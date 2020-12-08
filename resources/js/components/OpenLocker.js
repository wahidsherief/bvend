import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import url from 'url';
import { bind } from 'lodash';

export default class OpenLocker extends Component {
    constructor(props) {
        super(props);
    }

    openBox() {
        // this.showLoading();

        const data = {
            model: this.props.model,
            machine_id: this.props.machine_id,
            locker_id: this.props.locker_id,
        };

        const { model, machine_id, locker_id } = data;

        const this_url = window.location.href;
        const parse_url = url.parse(this_url, true, true);
        const host = parse_url.protocol + '//' + parse_url.host;
        const api_url = `${host}/vendor/locker/open/${model}/${machine_id}/${locker_id}`;

        // let timer = 20000;

        // if (model == '8') {
        //     timer = 20000;
        // } else {
        //     timer = 60000;
        // }

        axios
            .get(api_url)
            .then((response) => {
                if (!response.data) {
                    alert('Box open failed!');
                }
            })
            .catch((error) => {
                alert(error);
            });
    }

    // closeBox(data, host) {
    //     const { model, machine_id, locker_id } = data;
    //     const api_url = `${host}/vendor/locker/close/${model}/${machine_id}/${locker_id}`;

    //     axios
    //         .get(api_url)
    //         .then((response) => {
    //             if (!response.data) {
    //                 alert('Box close failed!');
    //             } else {
    //                 this.setState({
    //                     disable: false,
    //                 });

    //                 this.hideLoading();

    //                 alert('Box opened successfully');
    //             }
    //         })
    //         .catch((error) => {
    //             alert(error);
    //         });
    // }

    // showLoading() {
    //     document.getElementsByClassName('full-page-loader')[0].classList.remove('d-none');
    // }

    // hideLoading() {
    //     document.getElementsByClassName('full-page-loader')[0].classList.add('d-none');
    // }

    // showMessage() {
    //     document.getElementsByClassName('full-page-loader')[0].classList.add('d-none');
    // }

    render() {
        return (
            <div>
                <button
                    id="open-box"
                    type="button"
                    className="btn btn-secondary btn-block text-white"
                    onClick={this.openBox.bind(this)}
                >
                    Open Box
                </button>
            </div>
        );
    }
}

if (document.getElementById('open-locker')) {
    const propsContainer = document.getElementById('open-locker');
    const props = Object.assign({}, propsContainer.dataset);
    ReactDOM.render(<OpenLocker {...props} />, document.getElementById('open-locker'));
}
