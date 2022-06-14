<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function bkashWebhook()
    {
        
        //payload
        $payload = (array) json_decode(file_get_contents('php://input'), true);
    

        // headers
        // $messageType = $_SERVER['HTTP_X_AMZ_SNS_MESSAGE_TYPE'];
        $messageType = 'Notification';
    

        //logics

    
        //verify signature
        $signingCertURL = $payload['SigningCertURL'];
        $certUrlValidation = $this->validateUrl($signingCertURL);
        if ($certUrlValidation == '1') {
            $pubCert = $this->get_content($signingCertURL);
    
            $signature = $payload['Signature'];
            $signatureDecoded = base64_decode($signature);
        
            $content = $this->getStringToSign($payload);
            if ($content!='') {
                // $verified = openssl_verify($content, $signatureDecoded, $pubCert, OPENSSL_ALGO_SHA1);
                // if ($verified=='1') {
                if ($messageType=="SubscriptionConfirmation") {
                    $subscribeURL = $payload['SubscribeURL'];
                    $this->writeLog('Subscribe', $subscribeURL);
                    //subscribe
                    $url = curl_init($subscribeURL);
                    curl_exec($url);
                } elseif ($messageType=="Notification") {
                    $notificationData = $payload['Message'];
                    $this->writeLog('NotificationData-Message', $notificationData);
                }
                // }
            }
        }
    }

    
    private function writeLog($logName, $logData)
    {
        file_put_contents(storage_path('./bkash_logs/log-'.$logName.date("j.n.Y").'.log'), $logData, FILE_APPEND);
    }

    private function get_content($URL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $URL);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private function getStringToSign($message)
    {
        $signableKeys = [
            'Message',
            'MessageId',
            'Subject',
            'SubscribeURL',
            'Timestamp',
            'Token',
            'TopicArn',
            'Type'
        ];
    
        $stringToSign = '';
    
        if ($message['SignatureVersion'] !== '1') {
            $errorLog =  "The SignatureVersion \"{$message['SignatureVersion']}\" is not supported.";
            $this->writeLog('SignatureVersion-Error', $errorLog);
        } else {
            foreach ($signableKeys as $key) {
                if (isset($message[$key])) {
                    $stringToSign .= $key . "\n" . json_encode($message[$key]) . "\n";
                }
            }
            $this->writeLog('StringToSign', $stringToSign."\n");
        }
        return $stringToSign;
    }

    private function validateUrl($url)
    {
        $defaultHostPattern = '/^sns\.[a-zA-Z0-9\-]{3,}\.amazonaws\.com(\.cn)?$/';
        $parsed = parse_url($url);
    
        if (empty($parsed['scheme']) || empty($parsed['host']) || $parsed['scheme'] !== 'https' || substr($url, -4) !== '.pem' || !preg_match($defaultHostPattern, $parsed['host'])) {
            return false;
        } else {
            return true;
        }
    }
}
