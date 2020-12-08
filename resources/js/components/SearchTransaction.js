import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import url from 'url';
import axios from 'axios';

const axiosInstance = axios.create();
axiosInstance.defaults.timeout = 30000;

export default class SearchTransaction extends Component {
    constructor(props) {
        super(props);
        this.state = {
            token: '',
            trxID: '',
            result: '',
        };
    }

    handleChange(event) {
        this.setState({
            trxID: event.target.value,
        });
    }

    componentDidMount() {
        this.setToken();
    }

    setToken() {
        const api = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout/token/grant';
        const body = JSON.stringify({
            app_key: '4f6o0cjiki2rfm34kfdadl1eqq',
            app_secret: '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b',
        });

        const headers = {
            'Content-Type': 'application/json',
            username: 'sandboxTokenizedUser02',
            password: 'sandboxTokenizedUser02@12345',
        };
        axiosInstance
            .post(api, body, { headers: headers })
            .then((response) => {
                this.setState({
                    token: response.data.id_token,
                });
            })
            .catch((error) => {
                console.log(error);
            });
    }

    search(event) {
        event.preventDefault();
        if (this.state.trxID) {
            const api =
                'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout/general/searchTransaction';
            const body = JSON.stringify({
                trxID: this.state.trxID,
            });
            const headers = {
                'Content-Type': 'application/json',
                authorization: this.state.token,
                'X-APP-Key': '4f6o0cjiki2rfm34kfdadl1eqq',
            };
            axiosInstance
                .post(api, body, { headers: headers })
                .then((response) => {
                    console.log('search api response', response.data);
                    if (response.data) {
                        this.setState({
                            result: response.data,
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        } else {
            console.log('blank');
        }
    }

    result() {
        const result = this.state.result;
        if (result.statusCode == '0000') {
            return (
                <div className="mt-4">
                    <ul className="list-group list-group-small list-group-flush">
                        <li className="list-group-item d-flex px-3">
                            <span className="font-weight-bold text-fiord-blue">Trx ID</span>
                            <span className="ml-auto text-right font-weight-bold text-reagent-gray">
                                {result.trxID}
                            </span>
                        </li>
                        <li className="list-group-item d-flex px-3">
                            <span className="font-weight-bold text-fiord-blue">
                                Customer Number
                            </span>
                            <span className="ml-auto text-right font-weight-bold text-reagent-gray">
                                {result.customerMsisdn}
                            </span>
                        </li>
                        <li className="list-group-item d-flex px-3">
                            <span className="font-weight-bold text-fiord-blue">Amount</span>
                            <span className="ml-auto text-right font-weight-bold text-reagent-gray">
                                {result.amount} BDT
                            </span>
                        </li>
                        <li className="list-group-item d-flex px-3">
                            <span className="font-weight-bold text-fiord-blue">Status</span>
                            <span className="ml-auto text-right font-weight-bold text-reagent-gray">
                                {result.transactionStatus}
                            </span>
                        </li>
                        <li className="list-group-item d-flex px-3">
                            <span className="font-weight-bold text-fiord-blue">Time</span>
                            <span className="ml-auto text-right font-weight-bold text-reagent-gray">
                                {result.completedTime}
                            </span>
                        </li>
                    </ul>
                </div>
            );
        } else if (result.statusCode == '2033') {
            return (
                <center>
                    <p className="text-muted font-italic font-weight-light p-5">
                        {result.statusMessage}
                    </p>
                </center>
            );
        } else {
            return null;
        }
    }

    render() {
        return (
            <div>
                <div className="row">
                    <div className="col">
                        <div className="card card-small mb-4">
                            <div className="card-header border-bottom">
                                <h6>Search Transaction</h6>
                            </div>
                            <div className="card-body">
                                <div className="col-md-6 mt-4 offset-2">
                                    <form onSubmit={this.search.bind(this)}>
                                        <div className="input-group mb-3">
                                            <input
                                                type="text"
                                                className="form-control"
                                                placeholder="Transaction ID (Trx ID)"
                                                onChange={this.handleChange.bind(this)}
                                                value={this.state.trxID}
                                            />
                                            <div className="input-group-append">
                                                <button className="btn btn-success" type="submit">
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    {this.result()}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById('search-transaction')) {
    ReactDOM.render(<SearchTransaction />, document.getElementById('search-transaction'));
}
