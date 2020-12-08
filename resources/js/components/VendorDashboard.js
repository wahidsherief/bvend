import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import url from 'url';

export default class VendorDashboard extends Component {
    constructor() {
        super();
        this.state = {
            ml_machines: [],
            total_sales_product: 0,
            total_sales_amount: 0,
            ml_8_machines: [],
            // ml_16_machines: [],
            ml_32_machines: [],
            // ml_64_machines: [],
            // ml_96_machines: [],
            // ml_128_machines: [],
            loading: true,
        };
    }

    componentDidMount() {
        let this_url = window.location.href;
        let parse_url = url.parse(this_url, true, true);
        let host = parse_url.protocol + '//' + parse_url.host;
        let api_url = host + '/vendor/dashboard/0';

        axios
            .get(api_url)
            .then((response) => {
                this.setState({
                    ml_machines: response.data.ml_machines,
                    total_sales_product: response.data.total_sales_product,
                    total_sales_amount: response.data.total_sales_amount,
                    ml_8_machines: response.data.ml_8_machines,
                    // ml_16_machines: response.data.ml_16_machines,
                    ml_32_machines: response.data.ml_32_machines,
                    // ml_64_machines: response.data.ml_64_machines,
                    // ml_96_machines: response.data.ml_96_machines,
                    // ml_128_machines: response.data.ml_128_machines,
                    loading: false,
                });
            })
            .catch((error) => {
                alert(error);
            });
    }

    selectDate(e) {
        let this_url = window.location.href;
        let parse_url = url.parse(this_url, true, true);
        let host = parse_url.protocol + '//' + parse_url.host;
        let date = e.target.value;

        let api_url = host + '/vendor/dashboard/' + date;

        this.setState({ value: date });
        axios
            .get(api_url)
            .then((response) => {
                console.log(response.data);
                this.setState({
                    ml_machines: response.data.ml_machines,
                    total_sales_product: response.data.total_sales_product,
                    total_sales_amount: response.data.total_sales_amount,
                    ml_8_machines: response.data.ml_8_machines,
                    // ml_16_machines: response.data.ml_16_machines,
                    ml_32_machines: response.data.ml_32_machines,
                    // ml_64_machines: response.data.ml_64_machines,
                    // ml_96_machines: response.data.ml_96_machines,
                    // ml_128_machines: response.data.ml_128_machines,
                });
            })
            .catch((error) => {
                alert(error);
            });
    }

    render() {
        return this.state.loading == false ? (
            <div>
                {this.state.ml_machines.length > 0 ? (
                    <div>
                        <div className="row">
                            <div className="col-lg-4 mb-4 ml-auto">
                                <select
                                    className="custom-select custom-select-sm"
                                    onChange={this.selectDate.bind(this)}
                                    value={this.state.value}
                                >
                                    <option value="0">Today</option>
                                    <option value="6">Last Week</option>
                                    <option value="30">Last Month</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div className="row">
                                <div className="col-lg col-md-6 col-sm-6 mb-4">
                                    <div className="stats-small stats-small--1 card card-small">
                                        <div className="card-body p-0 d-flex">
                                            <div className="d-flex flex-column m-auto">
                                                <div className="stats-small__data text-center">
                                                    <strong className="text-uppercase font-weight-bold">
                                                        Vendor Machines
                                                    </strong>
                                                    <h6 className="stats-small__value count my-3">
                                                        {this.state.ml_machines.length}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-lg col-md-6 col-sm-6 mb-4">
                                    <div className="stats-small stats-small--1 card card-small">
                                        <div className="card-body p-0 d-flex">
                                            <div className="d-flex flex-column m-auto">
                                                <div className="stats-small__data text-center">
                                                    <strong className="text-uppercase font-weight-bold">
                                                        Total Sales Amount
                                                    </strong>
                                                    <h6 className="stats-small__value count my-3">
                                                        {this.state.total_sales_amount} BDT
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-md-4 col-sm-6 mb-4">
                                    <div className="stats-small stats-small--1 card card-small">
                                        <div className="card-body p-0 d-flex">
                                            <div className="d-flex flex-column m-auto">
                                                <div className="stats-small__data text-center">
                                                    <strong className="text-uppercase font-weight-bold">
                                                        Total Sold
                                                    </strong>
                                                    <h6 className="stats-small__value count my-3">
                                                        {this.state.total_sales_product}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="row">
                                {/* <div className="col-md-4 col-sm-12 mb-4">
                                    <div>
                                        <div className="mb-3 row">
                                            <div className="col-xs-12 col-md-6 p-3">
                                                <div className="card card-small">
                                                    <div className="card-header border-bottom">
                                                        <strong className="highlight">
                                                            Top Product
                                                        </strong>
                                                    </div>
                                                    <div className="card-body p-0">
                                                        <div className="table-responsive">
                                                            <table className="table mb-0 text-center">
                                                                <thead className="bg-light">
                                                                    <tr>
                                                                        <th
                                                                            scope="col"
                                                                            className="border-0 text-left"
                                                                        >
                                                                            Product
                                                                        </th>
                                                                        <th
                                                                            scope="col"
                                                                            className="border-0"
                                                                        >
                                                                            Sold
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    {this.state.ml_machines.map(
                                                                        (ml_machine) =>
                                                                            ml_machine.products.map(
                                                                                (product) => (
                                                                                    <tr>
                                                                                        <td className="text-left">
                                                                                            {
                                                                                                product[
                                                                                                    'item'
                                                                                                ]
                                                                                                    .name
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                product.count
                                                                                            }
                                                                                        </td>
                                                                                    </tr>
                                                                                )
                                                                            )
                                                                    )}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> */}
                                <div className="col-md-12 col-sm-12 mb-4">
                                    {this.state.ml_8_machines.length > 0 ||
                                    // this.state.ml_16_machines.length > 0 ||
                                    this.state.ml_32_machines.length > 0 ? (
                                        // this.state.ml_64_machines.length > 0 ||
                                        // this.state.ml_128_machines.length > 0
                                        <div>
                                            {/* <h6>
                                                <strong class="font-weight-bold">
                                                    Locker Machines
                                                </strong>
                                            </h6> */}
                                            <div className="mb-3 row">
                                                {this.state.ml_8_machines.length > 0 ? (
                                                    <div className="col-xs-12 col-md-6 p-3">
                                                        <div className="card card-small">
                                                            <div className="card-header border-bottom">
                                                                <strong className="m-0 font-weight-bold">
                                                                    Model : 8
                                                                </strong>
                                                            </div>
                                                            <div className="card-body p-0">
                                                                <div className="table-responsive">
                                                                    <table className="table mb-0 text-center">
                                                                        <thead className="bg-light">
                                                                            <tr>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0 text-left"
                                                                                >
                                                                                    Machine
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Sold
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Amount
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            {this.state.ml_8_machines.map(
                                                                                (ml_8_machine) => (
                                                                                    <tr>
                                                                                        <td className="text-left">
                                                                                            <a
                                                                                                className="btn btn-xs btn-info"
                                                                                                href={`machine/8/${ml_8_machine.id}`}
                                                                                            >
                                                                                                {
                                                                                                    ml_8_machine.machine_code
                                                                                                }
                                                                                            </a>
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_8_machine.total_sales_product
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_8_machine.total_sales_amount
                                                                                            }{' '}
                                                                                            BDT
                                                                                        </td>
                                                                                    </tr>
                                                                                )
                                                                            )}
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ) : null}
                                                {/* {this.state.ml_16_machines.length > 0 ? (
                                                    <div className="col-xs-12 col-md-6 p-3">
                                                        <div className="card card-small">
                                                            <div className="card-header border-bottom">
                                                                <h6 className="m-0">Model : 16</h6>
                                                            </div>
                                                            <div className="card-body p-0">
                                                                <div className="table-responsive">
                                                                    <table className="table mb-0 text-center">
                                                                        <thead className="bg-light">
                                                                            <tr>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0 text-left"
                                                                                >
                                                                                    Machine
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Sold
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Amount
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            {this.state.ml_16_machines.map(
                                                                                (ml_16_machine) => (
                                                                                    <tr>
                                                                                        <td className="text-left">
                                                                                            <a
                                                                                                className="btn btn-xs btn-info"
                                                                                                href={`machine/16/${ml_16_machine.id}`}
                                                                                            >
                                                                                                {
                                                                                                    ml_16_machine.machine_code
                                                                                                }
                                                                                            </a>
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_16_machine.total_sales_product
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_16_machine.total_sales_amount
                                                                                            }{' '}
                                                                                            BDT
                                                                                        </td>
                                                                                    </tr>
                                                                                )
                                                                            )}
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ) : null} */}
                                                {this.state.ml_32_machines.length > 0 ? (
                                                    <div className="col-xs-12 col-md-6 p-3">
                                                        <div className="card card-small">
                                                            <div className="card-header border-bottom">
                                                                <strong className="m-0 font-weight-bold">
                                                                    Model : 32
                                                                </strong>
                                                            </div>
                                                            <div className="card-body p-0">
                                                                <div className="table-responsive">
                                                                    <table className="table mb-0 text-center">
                                                                        <thead className="bg-light">
                                                                            <tr>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0 text-left"
                                                                                >
                                                                                    Machine
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Sold
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Amount
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            {this.state.ml_32_machines.map(
                                                                                (ml_32_machine) => (
                                                                                    <tr>
                                                                                        <td className="text-left">
                                                                                            <a
                                                                                                className="btn btn-xs btn-info"
                                                                                                href={`machine/32/${ml_32_machine.id}`}
                                                                                            >
                                                                                                {
                                                                                                    ml_32_machine.machine_code
                                                                                                }
                                                                                            </a>
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_32_machine.total_sales_product
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_32_machine.total_sales_amount
                                                                                            }{' '}
                                                                                            BDT
                                                                                        </td>
                                                                                    </tr>
                                                                                )
                                                                            )}
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ) : null}
                                                {/* {this.state.ml_64_machines.length > 0 ? (
                                                    <div className="col-xs-12 col-md-6 p-3">
                                                        <div className="card card-small">
                                                            <div className="card-header border-bottom">
                                                                <h6 className="m-0">Model : 64</h6>
                                                            </div>
                                                            <div className="card-body p-0">
                                                                <div className="table-responsive">
                                                                    <table className="table mb-0 text-center">
                                                                        <thead className="bg-light">
                                                                            <tr>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0 text-left"
                                                                                >
                                                                                    Machine
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Sold
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Amount
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            {this.state.ml_64_machines.map(
                                                                                (ml_64_machine) => (
                                                                                    <tr>
                                                                                        <td className="text-left">
                                                                                            {
                                                                                                ml_64_machine.machine_code
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_64_machine.total_sales_product
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_64_machine.total_sales_amount
                                                                                            }{' '}
                                                                                            BDT
                                                                                        </td>
                                                                                    </tr>
                                                                                )
                                                                            )}
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ) : null} */}
                                                {/* {this.state.ml_96_machines.length > 0 ? (
                                                    <div className="col-xs-12 col-md-6 p-3">
                                                        <div className="card card-small">
                                                            <div className="card-header border-bottom">
                                                                <h6 className="m-0">Model : 96</h6>
                                                            </div>
                                                            <div className="card-body p-0">
                                                                <div className="table-responsive">
                                                                    <table className="table mb-0 text-center">
                                                                        <thead className="bg-light">
                                                                            <tr>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0 text-left"
                                                                                >
                                                                                    Machine
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Sold
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Amount
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            {this.state.ml_64_machines.map(
                                                                                (ml_96_machine) => (
                                                                                    <tr>
                                                                                        <td className="text-left">
                                                                                            {
                                                                                                ml_96_machine.machine_code
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_96_machine.total_sales_product
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_96_machine.total_sales_amount
                                                                                            }{' '}
                                                                                            BDT
                                                                                        </td>
                                                                                    </tr>
                                                                                )
                                                                            )}
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ) : null}
                                                {this.state.ml_128_machines.length > 0 ? (
                                                    <div className="col-xs-12 col-md-6 p-3">
                                                        <div className="card card-small">
                                                            <div className="card-header border-bottom">
                                                                <h6 className="m-0">Model : 128</h6>
                                                            </div>
                                                            <div className="card-body p-0">
                                                                <div className="table-responsive">
                                                                    <table className="table mb-0 text-center">
                                                                        <thead className="bg-light">
                                                                            <tr>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0 text-left"
                                                                                >
                                                                                    Machine
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Sold
                                                                                </th>
                                                                                <th
                                                                                    scope="col"
                                                                                    className="border-0"
                                                                                >
                                                                                    Amount
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            {this.state.ml_64_machines.map(
                                                                                (
                                                                                    ml_128_machine
                                                                                ) => (
                                                                                    <tr>
                                                                                        <td className="text-left">
                                                                                            {
                                                                                                ml_128_machine.machine_code
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_128_machine.total_sales_product
                                                                                            }
                                                                                        </td>
                                                                                        <td>
                                                                                            {
                                                                                                ml_128_machine.total_sales_amount
                                                                                            }{' '}
                                                                                            BDT
                                                                                        </td>
                                                                                    </tr>
                                                                                )
                                                                            )}
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ) : null} */}
                                            </div>
                                        </div>
                                    ) : null}
                                </div>
                            </div>
                        </div>
                    </div>
                ) : (
                    <center>
                        <h5 class="font-weight-light font-italic">Bvend Vendor Dashboard</h5>
                    </center>
                )}
            </div>
        ) : (
            <div className="font-weight-light">Loading...</div>
        );
    }
}

if (document.getElementById('vendor-dashboard')) {
    ReactDOM.render(<VendorDashboard />, document.getElementById('vendor-dashboard'));
}
