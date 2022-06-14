<?php

namespace App\Http\Controllers;

use App\Services\MachineService;
use App\Repositories\UserRepository;
use App\Services\RefillService;
use App\Services\TransactionService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\ResetLockers;

class BkashController extends Controller
{
    protected $machine_service;
    protected $transaction_service;
    protected $refill_service;
    protected $user;

    public function __construct(
        MachineService $machine_service,
        RefillService $refill_service,
        UserRepository $user,
        TransactionService $transaction_service
    ) {
        $this->machine_service = $machine_service;
        $this->transaction_service = $transaction_service;
        $this->refill_service = $refill_service;
        $this->user = $user;
    }

    public function processInput(Request $request)
    {
        $token = $request->machine_type == 'ML' ? $this->processPaymentInputForLocker($request) : $this->processPaymentInputForStore($request);

        return $token;
    }

    public function index(Request $request)
    {
        $session_token = $request->token;

        if (!isset($session_token)) {
            $message = $this->error('default');
            $url = config('global.api_url_bkash') . 'error/' . $message;

            return redirect()->away($url);
        }

        $this->grantToken($session_token);

        $user_id = $this->getSession($session_token, 'user_id');

        $user = $this->user->find($user_id);

        $bkash_url = '';

        if ($user->bkash_agreement_id == null) {
            $bkash_url = $this->createAgreement($session_token);
        } else {
            $this->updateSession($session_token, 'agreement_id', $user->bkash_agreement_id);
            $bkash_url = $this->createPayment($session_token);
        }

        return redirect()->away($bkash_url);
    }

    private function createAgreement($session_token)
    {
        $url = config('global.bkash_url') . 'create';
        $token = $this->getSession($session_token, 'token');
        $payer_reference = $this->getSession($session_token, 'user_mobile');
        $callback_url = config('global.api_url_bkash') . 'agreement/' . $session_token;

        $headers = [
            'content-type' => 'application/json',
            'authorization' => $token,
            'x-app-key' => config('global.bkash_app_key'),
        ];

        $body = [
            'mode' => '0000',
            'callbackURL' => $callback_url,
            'payerReference' => $payer_reference
        ];

        try {
            $response = Http::timeout(30)->withHeaders($headers)->post($url, $body)->json();

            if ($response['statusCode'] != '0000') {
                return $this->redirectError($response['statusCode'], $session_token);
            }

            return $response['bkashURL'];
        } catch (\Throwable $th) {
            return $this->redirectError($response['statusCode'], $session_token);
        }
    }

    public function executeAgreement(Request $request)
    {
        $session_token = $request->token;
        $url = config('global.bkash_url') . 'execute';
        $token = $this->getSession($session_token, 'token');

        $this->updateSession($session_token, 'payment_id', $request->paymentID);

        $headers = [
            'content-type' => 'application/json',
            'authorization' => $token,
            'x-app-key' => config('global.bkash_app_key'),
        ];

        $body = [
            'paymentID' => $request->paymentID
        ];

        try {
            $response = Http::timeout(30)->withHeaders($headers)->post($url, $body)->json();

            if ($response['statusCode'] != '0000') {
                // auto redirect to client and alert him/her agreement canceled or failed
                // based upon callback url state.
                if ($response['statusCode'] == '2054') {
                    if ($session_token != null) {
                        session()->forget($session_token);
                    }
                    return null;
                }

                return $this->redirectError($response['statusCode'], $session_token);
            }

            $attributes = ['bkash_agreement_id' => $response['agreementID']];
            $user_id = $this->getSession($session_token, 'user_id');
            $updated = $this->user->update($user_id, $attributes);

            if (!$updated) {
                return $this->redirectError('default', $session_token);
            }

            $this->updateSession($session_token, 'agreement_id', $response['agreementID']);
            $bkash_url = $this->createPayment($session_token);
            return redirect()->away($bkash_url);
        } catch (\Throwable $th) {
            return $this->redirectError($response['statusCode'], $session_token);
        }
    }

    private function createPayment($session_token)
    {
        $token = $this->getSession($session_token, 'token');
        $agreement_id = $this->getSession($session_token, 'agreement_id');
        $total_amount = $this->getSession($session_token, 'total_amount');
        $payer_reference = $this->getSession($session_token, 'user_mobile');
        $url = config('global.bkash_url') . 'create';
        $date = \Carbon\Carbon::now()->format('Y-m-dH:i:s');
        $invoice_no = 'bvend-' . str_replace(['20', '-', ':'], ['', '', ''], $date);

        $headers = [
            'content-type' => 'application/json',
            'authorization' => $token,
            'x-app-key' => config('global.bkash_app_key'),
        ];

        $callback_url = config('global.api_url_bkash') . 'payment/' . $session_token;

        $body = [
            'mode' => '0001',
            'agreementID' => $agreement_id,
            'amount' => $total_amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $invoice_no,
            'callbackURL' => $callback_url,
            'payerReference' => $payer_reference
        ];

        try {
            $response = Http::timeout(30)->withHeaders($headers)->post($url, $body)->json();

            if ($response['statusCode'] != '0000') {
                return $this->redirectError($response['statusCode'], $session_token);
            }

            return $response['bkashURL'];
        } catch (\Throwable $th) {
            return $this->redirectError($response['statusCode'], $session_token);
        }
    }

    public function executePayment(Request $request)
    {
        $session_token = $request->token;
        $token = $this->getSession($session_token, 'token');

        $url = config('global.bkash_url') . 'execute';

        $headers = [
            'content-type' => 'application/json',
            'authorization' => $token,
            'x-app-key' => config('global.bkash_app_key'),
        ];

        $body = [
            'paymentID' => $request->paymentID
        ];

        try {
            $response = Http::timeout(30)->withHeaders($headers)->post($url, $body)->json();

            if ($response['statusCode'] != '0000') {
                // auto redirect to client and alert payment cancel or failed
                // based upon callback url state.
                if ($response['statusCode'] == '2056') {
                    if ($session_token != null) {
                        session()->forget($session_token);
                    }
                    return null;
                }

                return $this->redirectError($response['statusCode'], $session_token);
            } else {
                return $this->storeTransaction($session_token, $response);
            }
        } catch (Exception $e) {
            if (class_basename($e) != 'ConnectionException') {
                return $this->redirectError('default', $session_token);
            }
            return $this->queryPayment($session_token, $request->paymentID);
        }
    }

    private function queryPayment($session_token, $payment_id)
    {
        $url = config('global.bkash_url') . 'payment/status';
        $token = $this->getSession($session_token, 'token');

        $headers = [
            'content-type' => 'application/json',
            'authorization' => $token,
            'x-app-key' => config('global.bkash_app_key'),
        ];

        $body = [
            'paymentID' => $payment_id
        ];

        $response = Http::timeout(30)->withHeaders($headers)->post($url, $body)->json();

        if ($response['transactionStatus'] == 'Initiated') {
            $bkash_url = $this->createPayment($session_token);
            return redirect()->away($bkash_url);
        } elseif ($response['transactionStatus'] == 'Completed') {
            return $this->storeTransaction($session_token, $response);
        } else {
            return $this->redirectError('default', $session_token);
        }
    }

    public function searchTransaction($trx_id)
    {
        $url = config('global.bkash_url') . 'general/searchTransaction';

        $token = $this->grantToken();

        $headers = [
            'content-type' => 'application/json',
            'authorization' => $token,
            'x-app-key' => config('global.bkash_app_key'),
        ];

        $body = [
            'trxID' => $trx_id
        ];

        $response = Http::timeout(30)->withHeaders($headers)->post($url, $body)->json();
        if ($response['statusCode'] != '0000') {
            return  $this->error($response['statusCode']);
        }

        return $response;
    }

    public function cancelAgreement($user_id)
    {
        $user = $this->user->find($user_id);
        $token = $this->grantToken();

        if (!$user) {
            return $this->error('default');
        }

        if ($user->bkash_agreement_id != null) {
            return $this->executeCancelAgreement($user, $token);
        } else {
            return 'bKash account not found.';
        }
    }

    public function checkAgreement($user_id)
    {
        $checked = $this->user->find($user_id)->bkash_agreement_id;

        if ($checked == null) {
            return response()->json(false);
        }

        return response()->json(true);
    }

    public function exit($session_token)
    {
        session()->forget($session_token);

        return response()->json(true);
    }

    private function executeCancelAgreement($user, $token)
    {
        $url = config('global.bkash_url') . 'agreement/cancel';

        $headers = [
            'content-type' => 'application/json',
            'authorization' => $token,
            'x-app-key' => config('global.bkash_app_key')
        ];

        $body = [
            'agreementID' => $user->bkash_agreement_id
        ];

        try {
            $response = Http::timeout(30)->withHeaders($headers)->post($url, $body)->json();

            if ($response['statusCode'] != '0000') {
                return $this->error($response['statusCode']);
            }
            return $this->updateUserByRemovingAgreementID($user);
        } catch (\Throwable $th) {
            return $this->error('default');
        }
    }

    private function updateUserByRemovingAgreementID($user)
    {
        $attributes = ['bkash_agreement_id' => null];

        $updated = $this->user->update($user->id, $attributes);

        if (!$updated) {
            return $this->error('default');
        }

        return response()->json(true);
    }

    private function grantToken($session_token = null)
    {
        $grant_token = $this->getGrantToken();
        if ($session_token != null) {
            return $this->updateSession($session_token, 'token', $grant_token);
        } else {
            return $grant_token;
        }
    }

    private function getGrantToken()
    {
        $url = config('global.bkash_url') . 'token/grant';

        $headers = [
            'content-type' => 'application/json',
            'username' => config('global.bkash_username'),
            'password' => config('global.bkash_password')
        ];

        $body = [
            'app_key' => config('global.bkash_app_key'),
            'app_secret' => config('global.bkash_app_secret'),
        ];

        try {
            $response = Http::timeout(30)->withHeaders($headers)->post($url, $body)->json();

            if ($response['statusCode'] != '0000') {
                return $this->redirectError('default');
            }
            return $response['id_token'];
        } catch (\Throwable $th) {
            return $this->redirectError('default');
        }
    }

    private function  , ($request)
    {
        $attributes = [
            'machine_id' => $request->machine_id,
            'vendor_id' => $request->vendor_id,
            'machine_model' => $request->machine_model,
            'user_id' => $request->user_id,
            'total_amount' => $request->total_amount,
            'discount' => $request->discount,
            'user_mobile' => $request->user_mobile,
            'items' => $request->items
        ];

        $token = $this->generateSessionToken();

        session()->put($token, $attributes);

        return $token;
    }

    private function storeTransaction($session_token, $response)
    {
        $attributes = $this->processTransactionData($session_token, $response);

        $transaction = $this->transaction_service->storeAndReturn($attributes);

        if (!$transaction) {
            $this->redirectError('default', $session_token);
        }

        $stored = $this->storeTransactionLocker($session_token, $transaction);

        if (!$stored) {
            return $this->redirectError('default', $session_token);
        }

        return $this->redirectSuccess($session_token);
    }

    private function processTransactionData($session_token, $data)
    {
        $session_data = session($session_token);

        $attributes = [
            'machine_id' => $session_data['machine_id'],
            'machine_model' => $session_data['machine_model'],
            'user_id' => $session_data['user_id'],
            'vendor_id' => $session_data['vendor_id'],
            'payment_method_id' => 1, // in future needs to be get from client
            'discount' => $session_data['discount'],
            'total_amount' => $data['amount'],
            'bkash_trx_id' => $data['trxID'],
            'payment_id' => $data['paymentID'],
            'invoice_no' => $data['merchantInvoiceNumber'],
            'status' => 'success'
        ];

        return $attributes;
    }

    private function storeTransactionLocker($session_token, $transaction)
    {
        $items = $this->getSession($session_token, 'items');

        $values = [];

        foreach ($items as $item) {
            $conditions = [
                'machine_id' => $transaction->machine_id,
                'machine_model' => $transaction->machine_model,
                'locker_id' => $item['id']
            ];

            $refill = $this->refill_service->findByCondition($conditions);

            $value = [
                'transaction_id' => $transaction->id,
                'refill_id' => $refill->id
            ];

            array_push($values, $value);

            $locker_table = $this->machine_service->getLockersTable($refill->machine_model);
            \DB::table($locker_table)->where('id', $refill->locker_id)->update(['empty' => 1, 'refilled' => 0, 'status' => 'on']);

            $reset = (new ResetLockers($refill->machine_model, $transaction->machine_id, $refill->locker_id))->delay(now()->addMinutes(2));
            dispatch($reset);
        }

        return $this->transaction_service->storeLocker($values);
    }

    private function getSession($session_token, $key)
    {
        $data = session($session_token);

        return $data[$key];
    }

    private function updateSession($session_token, $key, $value)
    {
        $data = session()->pull($session_token);

        $data[$key] = $value;

        session()->put($session_token, $data);
    }

    private function redirectError($code, $session_token = null)
    {
        if ($session_token != null) {
            session()->forget($session_token);
        }

        $message = $this->error($code);

        $url = config('global.api_url_bkash') . 'error/' . $message;

        return redirect()->away($url);
    }

    private function redirectSuccess($session_token)
    {
        session()->forget($session_token);

        $url = config('global.api_url_bkash') . 'success/done';

        return redirect()->away($url);
    }

    private function generateSessionToken()
    {
        $date = str_replace(['20', '-', ':'], ['', '', ''], \Carbon\Carbon::now()->format('Y-m-dH:i:s'));

        return  Str::random(20) . $date;
    }

    private function error($code)
    {
        switch ($code) {
            case '2001':
                return 'Invalid App Key';
                break;

            case '2002':
                return 'Invalid Payment ID';
                break;

            case '2003':
                return 'Process failed';
                break;

            case '2004':
                return 'Invalid firstPaymentDate';
                break;

            case '2005':
                return 'Invalid frequency';
                break;

            case '2006':
                return 'Invalid amount';
                break;

            case '2007':
                return 'Invalid currency';
                break;

            case '2008':
                return 'Invalid intent';
                break;

            case '2009':
                return 'Invalid Wallet';
                break;

            case '2010':
                return 'Invalid OTP';
                break;

            case '2011':
                return 'Invalid PIN';
                break;

            case '2012':
                return 'Invalid Receiver MSISDN';
                break;

            case '2013':
                return 'Resend Limit Exceeded';
                break;

            case '2014':
                return 'Wrong PIN';
                break;

            case '2015':
                return 'Wrong PIN count exceeded';
                break;

            case '2016':
                return 'Wrong verification code';
                break;

            case '2017':
                return 'Wrong verification limit exceeded';
                break;

            case '2018':
                return 'OTP verification time expired';
                break;

            case '2019':
                return 'PIN verification time expired';
                break;

            case '2020':
                return 'Exception Occurred';
                break;

            case '2021':
                return 'Invalid Mandate ID';
                break;

            case '2022':
                return 'The mandate does not exist';
                break;

            case '2023':
                return 'Insufficient Balance';
                break;

            case '2024':
                return 'Exception occurred';
                break;

            case '2025':
                return 'Invalid request body';
                break;

            case '2026':
                return 'The reversal amount cannot be greater than the original transaction amount';
                break;

            case '2027':
                return 'The mandate corresponding to the payer reference number already exists and cannot be created again';
                break;

            case '2028':
                return 'Reverse failed because the transaction serial number does not exist';
                break;

            case '2029':
                return 'Duplicate for all transactions';
                break;

            case '2030':
                return 'Invalid mandate request type';
                break;

            case '2031':
                return 'Invalid merchant invoice number';
                break;

            case '2032':
                return 'Invalid transfer type';
                break;

            case '2033':
                return 'Transaction not found';
                break;

            case '2034':
                return 'The transaction cannot be reversed because the original transaction has been reversed';
                break;

            case '2035':
                return 'Reverse failed because the initiator has no permission to reverse the transaction';
                break;

            case '2036':
                return 'The direct debit mandate is not in Active state';
                break;

            case '2037':
                return 'The account of the debit party is in a state which prohibits execution of this transaction';
                break;

            case '2038':
                return 'Debit party identity tag prohibits execution of this transaction';
                break;

            case '2039':
                return 'The account of the credit party is in a state which prohibits execution of this transaction';
                break;

            case '2040':
                return 'Credit party identity tag prohibits execution of this transaction';
                break;

            case '2041':
                return 'Credit party identity is in a state which does not support the current service';
                break;

            case '2042':
                return 'Reverse failed because the initiator has no permission to reverse the transaction';
                break;

            case '2043':
                return 'The security credential of the subscriber is incorrect';
                break;

            case '2044':
                return 'Identity has not subscribed to a product that contains the expected service or the identity is not in Active status';
                break;

            case '2045':
                return 'The MSISDN of the customer does not exist';
                break;

            case '2046':
                return 'Identity has not subscribed to a product that contains requested service';
                break;

            case '2047':
                return 'TLV Data Format Error';
                break;

            case '2048':
                return 'Invalid Payer Reference';
                break;

            case '2049':
                return 'Invalid Merchant Callback URL';
                break;

            case '2050':
                return 'Agreement already exists between payer and merchant';
                break;

            case '2051':
                return 'Invalid Agreement ID';
                break;

            case '2052':
                return 'Agreement is in incomplete state';
                break;

            case '2053':
                return 'Agreement has already been cancelled';
                break;

            case '2054':
                return "Agreement execution pre-requisite hasn't been met";
                break;

            case '2055':
                return 'Invalid Agreement State';
                break;

            case '2056':
                return 'Invalid Payment State';
                break;

            case '2057':
                return 'Not a bKash Account';
                break;

            case '2058':
                return 'Not a Customer Wallet';
                break;

            case '2059':
                return 'Multiple OTP request for a single session denied';
                break;

            case '2060':
                return "Payment execution pre-requisite hasn't been met";
                break;

            case '2061':
                return 'This action can only be performed by the agreement or payment initiator party';
                break;

            case '2062':
                return 'The payment has already been completed';
                break;

            case '2063':
                return 'Mode is not valid as per request data';
                break;

            case '2064':
                return 'This product mode currently unavailable';
                break;

            case '2065':
                return 'Mendatory field missing';
                break;

            case '2066':
                return 'Agreement is not shared with other merchant';
                break;

            case '2067':
                return 'Invalid permission';
                break;

            case '2068':
                return 'Transaction has already been completed';
                break;

            case '2069':
                return 'Transaction has already been cancelled';
                break;

            case '503':
                return 'System is undergoing maintenance. Please try again later';
                break;

            default:
                return 'Something went wrong';
        }
    }
}
