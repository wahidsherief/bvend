import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

const axiosInstance = axios.create();
axiosInstance.defaults.timeout = 30000;

const API_URL = 'https://bvend.xyz/';
const BKASH_API = 'https://tokenized.pay.bka.sh/v1.2.0-beta/';
const APP_KEY = '2p21bbatr8uv07cr0gn9gs73ki';
const APP_SECRET = 'dr6aki0vl0ir48pn8h24n7rl67jk274q8cm6at1ac13pooe2ml';
const BKASH_USERNAME = 'BVENDTECHNOLOGIESLTD';
const BKASH_PASSWORD = 'bV7@En9DtE3c';
const userID = 1;
const MARCHENT_MOBILE_NUMBER = '01301794373';

export default class Bkash extends Component {
    constructor(props) {
        super(props);
        this.state = {
            token: '',
            bkashURL: '',
            mobile: '123',
            invoice_no: '12345',
            amount: '50',
            agreementExecuted: false, // to make sure the executeAgreement function run once.
            paymentExecuted: false, // to make sure the executePayment function run once.
        };
    }

    componentDidMount() {
        console.log('api url is');
        console.log('api url is', API_URL);
        const api = BKASH_API + 'tokenized/checkout/token/grant';
        const body = JSON.stringify({
            app_key: APP_KEY,
            app_secret: APP_SECRET,
        });
        const headers = {
            'Content-Type': 'application/json',
            username: BKASH_USERNAME,
            password: BKASH_PASSWORD,
        };
        axiosInstance
            .post(api, body, { headers: headers })
            .then((response) => {
                console.log('grant token response', response.data);
                if (response.data.statusCode == '0000') {
                    this.setState({
                        token: response.data.id_token,
                    });
                } else {
                    const message = this.errorMessage(response.data.statusCode);
                    this.displayAlert('Error', message);
                }
            })
            .then((resp) => {
                // const userID = this.props.navigation.state.params.userID;
                const getAgreementIDAPI = API_URL + 'api/get_agreement_id/' + userID;
                axiosInstance
                    .get(getAgreementIDAPI)
                    .then((id) => {
                        if (Object.keys(id.data).length === 0) {
                            this.createAgreement(this.state.token);
                        } else {
                            this.createPayment(id.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        this.displayAlert('Error', 'Something went wrong', error);
                    });
            })
            .catch((error) => {
                console.log(error);
                this.displayAlert('Error', 'Something went wrong', error);
            });
    }

    async updateAsyncStatus() {
        const value = await AsyncStorage.getItem('user');
        let user = JSON.parse(value);
        user['bkash_agreement_id'] = true;
        AsyncStorage.setItem('user', JSON.stringify(user));
    }

    async createAgreement(token) {
        const create_agreement_api = BKASH_API + 'tokenized/checkout/create';
        const body = JSON.stringify({
            mode: '0000',
            callbackURL: 'https://bvend.xyz/loading?method=agreement',
            payerReference: this.state.mobile,
        });
        const headers = {
            'Content-Type': 'application/json',
            authorization: token,
            'x-app-key': APP_KEY,
        };
        const response = await axiosInstance
            .post(create_agreement_api, body, { headers: headers })
            .catch((error) => {
                console.log(error);
                this.displayAlert('Error', 'Something went wrong', error);
            });
        console.log('response in create agreement: ', response.data);
        if (response.data.statusCode == '0000') {
            this.setState({
                bkashURL: response.data.bkashURL,
            });
        } else {
            const message = this.errorMessage(response.data.statusCode);
            this.displayAlert('Error', message);
        }
    }

    async executeAgreement(paymentID) {
        this.setState({
            agreementExecuted: true,
        });
        console.log('payment id', paymentID);
        console.log('token', this.state.token);
        const execute_agreement_api = BKASH_API + 'tokenized/checkout/execute';
        const body = JSON.stringify({
            paymentID: paymentID,
        });
        const headers = {
            'Content-Type': 'application/json',
            authorization: this.state.token,
            'x-app-key': APP_KEY,
        };
        const response = await axiosInstance
            .post(execute_agreement_api, body, { headers: headers })
            .catch((error) => {
                console.log('executeAgreement method error');
                this.displayAlert('Error', 'Something went wrong', error);
            });
        console.log('response in execute agreement: ', response.data);
        if (response.data.statusCode == '0000') {
            const agreementID = response.data.agreementID;
            const agreementID_saved = this.saveAgreementID(agreementID);
            if (agreementID_saved) {
                this.updateAsyncStatus().then(() => {
                    console.log('dasda');
                    this.createPayment(agreementID);
                });
            } else {
                console.log(
                    'agreement ID save fail, check executeAgreement method in BkashScreen file.'
                );
                this.displayAlert('Error', 'Something went wrong', error);
            }
        } else {
            const message = this.errorMessage(response.data.statusCode);
            this.displayAlert('Error', message);
        }
    }

    async createPayment(agreementID) {
        const amount = this.state.amount.toString();
        const merchantInvoiceNumber = this.state.invoice_no;
        if (amount && merchantInvoiceNumber) {
            const create_payment_api = BKASH_API + 'tokenized/checkout/create';
            const body = JSON.stringify({
                mode: '0001',
                agreementID: agreementID,
                amount: amount,
                currency: 'BDT',
                intent: 'sale',
                merchantInvoiceNumber: merchantInvoiceNumber,
                callbackURL: 'https://bvend.xyz/loading?method=payment',
            });

            const headers = {
                'Content-Type': 'application/json',
                authorization: this.state.token,
                'x-app-key': APP_KEY,
            };
            const response = await axiosInstance
                .post(create_payment_api, body, { headers: headers })
                .catch((error) => {
                    console.log(error);
                    this.displayAlert('Error', 'Something went wrong', error);
                });
            console.log('response in create payment: ', response.data);
            if (response.data.statusCode == '0000') {
                this.setState({
                    bkashURL: response.data.bkashURL,
                });

                this.savePaymentID(response.data.paymentID);
            } else {
                const message = this.errorMessage(response.data.statusCode);
                this.displayAlert('Error', message);
            }
        }
    }

    executePayment(paymentID) {
        this.setState({
            paymentExecuted: true,
        });
        const execute_payment_api = BKASH_API + 'tokenized/checkout/execute';
        const body = JSON.stringify({
            paymentID: paymentID,
        });
        const headers = {
            'Content-Type': 'application/json',
            authorization: this.state.token,
            'x-app-key': APP_KEY,
        };
        axiosInstance
            .post(execute_payment_api, body, { headers: headers })
            .then((response) => {
                console.log('response in execute payment: ', response.data);
                if (response.data.paymentID == paymentID && response.data.statusCode == '0000') {
                    console.log('payment completed');
                    this.saveTransaction(response.data);
                    // this.executePaymentStatus(paymentID)
                } else {
                    const message = this.errorMessage(response.data.statusCode);
                    this.displayAlert('Error', message);
                }
            })
            .catch((error) => {
                console.log('error inside execute payment', error);
                if (error.code == 'ECONNABORTED') {
                    this.executePaymentStatus(paymentID);
                } else {
                    this.displayAlert('Error', 'Something went wrong', error);
                }
            });
    }

    executePaymentStatus(paymentID) {
        const execute_payment_status_api = BKASH_API + 'tokenized/checkout/payment/status';
        const body = JSON.stringify({
            paymentID: paymentID,
        });
        const headers = {
            'Content-Type': 'application/json',
            authorization: this.state.token,
            'x-app-key': APP_KEY,
        };
        axiosInstance
            .post(execute_payment_status_api, body, { headers: headers })
            .then((response) => {
                console.log('response in execute payment status : ', response.data);
                if (response.data.transactionStatus == 'Initiated') {
                    console.log('payment initiated');
                    this.createPayment(response.data.agreementID);
                } else if (response.data == 'Completed') {
                    console.log('payment initiated');
                    this.saveTransaction(response.data);
                } else {
                    const message = this.errorMessage(response.data.statusCode);
                    this.displayAlert(error, 'Error', message);
                }
            })
            .catch((error) => {
                console.log(error);
                this.displayAlert('Error', 'Something went wrong', error);
            });
    }

    async saveAgreementID(agreementID) {
        const save_agreement_id_api = API_URL + 'api/save_agreement_id';
        body = {
            // user_id: this.props.navigation.state.params.userID,
            user_id: userID,
            agreement_id: agreementID,
        };
        console.log(this.state.userID);
        axiosInstance
            .post(save_agreement_id_api, body)
            .then((response) => {
                console.log('saveAgreementID: ', response.data);
                return true;
            })
            .catch((error) => {
                console.log(error);
                this.displayAlert('Error', 'Something went wrong', error);
            });
    }

    savePaymentID(paymentID) {
        const save_payment_id_api = API_URL + 'api/save_payment_id';
        body = {
            paymentID: paymentID,
            invoice_no: this.state.invoice_no,
        };
        axiosInstance
            .post(save_payment_id_api, body)
            .then((response) => {
                console.log('savePaymentID: ', response.data);
            })
            .catch((error) => {
                console.log(error);
                this.displayAlert('Error', 'Something went wrong', error);
            });
    }

    saveTransaction(body) {
        const save_trx_id_api = API_URL + 'api/save_trx_id';
        axiosInstance
            .post(save_trx_id_api, body)
            .then((response) => {
                if (response.data == true) {
                    // this.navigateToCompleteScreen(type, model, body.amount);
                } else {
                    console.log(
                        'error: save transaction failed, check saveTransaction method in BkashScreen file'
                    );
                    this.displayAlert('Error', 'Something went wrong', error);
                }
            })
            .catch((error) => {
                console.log(error);
                this.displayAlert('Error', 'Something went wrong', error);
            });
    }

    _onLoad(state) {
        const url_string = state.url;
        console.log('state', url_string);
        const url_params = url.parse(url_string, 'status');
        const method = url_params.query.method;
        console.log(method);
        const status = url_params.query.status;
        console.log(status);
        const paymentID = url_params.query.paymentID;
        if (status == 'success' && method == 'agreement' && this.state.agreementExecuted == false) {
            this.executeAgreement(paymentID);
        } else if (
            status == 'success' &&
            method == 'payment' &&
            this.state.paymentExecuted == false
        ) {
            this.executePayment(paymentID);
        } else if (status == 'failure' && method == 'agreement') {
            console.log('Agreement Creation Failed');
            this.displayAlert('Alert', 'Agreement Creation Failed');
        } else if (status == 'failure' && method == 'payment') {
            console.log('Payment Failed');
            this.displayAlert('Alert', 'Payment Failed');
        } else if (status == 'cancel' && method == 'agreement') {
            console.log('Agreement Creation Cancelled');
            this.displayAlert('Alert', 'Agreement Creation Cancelled');
        } else if (status == 'cancel' && method == 'payment') {
            console.log('Payment Cancelled');
            this.displayAlert('Alert', 'Payment Cancelled');
        } else {
            console.log('Payment Execution Processing...');
        }
    }

    displayAlert(title, message, error = null) {
        if (error != null) {
            if (error.code == 'ECONNABORTED') {
                message = 'Time exceeded';
            }
        }

        console.log(title, message);
    }

    errorMessage(message) {
        console.log(message);
    }

    // render() {
    //     if (this.state.bkashURL) {
    //         console.log('BKash URL in render method : ', this.state.bkashURL);
    //         return this._onLoad.bind(this);
    //     }
    // }

    render() {
        console.log(this.state.bkashURL);
        return (
            <div>
                <iframe
                    src="https://payment.bkash.com/redirect/tokenized/?paymentID=TR00017M1594401861796&hash=PCmLX_E4VyfRiQ5)ITT(7wVRMTIWiLX4CYayTbDATItvYe562eo52CBcCB2B(UxvkTUy!nIvbz-vLF6wRmvIFo0Wntvtnm7YJAHx1594401861835&mode=0001&apiVersion=v1.2.0-beta"
                    frameborder="0"
                    width="100%"
                    height="100%"
                ></iframe>
            </div>
        );
    }
}

if (document.getElementById('bkash')) {
    ReactDOM.render(<Bkash />, document.getElementById('bkash'));
}
