import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import url from 'url';

export default class Locker extends Component {
    constructor() {
        super();
        let this_url = window.location.href;
        let parse_url = url.parse(this_url, true, true);
        let url_val = parse_url.query;
        let host = parse_url.protocol + '//' + parse_url.host;
        console.log(host);

        this.state = {
            lockers: [],
            host: host,
            type: url_val.type,
            id: url_val.id,
            toast: '',
        };
    }

    componentDidMount() {
        this.fetchLockers();
    }

    fetchLockers() {
        let type = this.state.type;
        let id = this.state.id;
        let host = this.state.host;

        axios
            .get(host + '/admin/render_lockers/' + type + '/' + id)
            .then((response) => {
                if (response.status == 200) {
                    this.setState({
                        lockers: response.data,
                        toast: 'success',
                    });
                } else {
                    this.setState({
                        toast: 'fail',
                    });
                }
            })
            .catch((error) => {
                alert(error);
            });
    }

    updateLocker(update, id) {
        let type = this.state.type;
        if (type == 'a_machines' || type == 'b_machines' || type == 'c_machines') {
            if (type == 'a_machines') {
                this.saveUpdateLocker('a_machine_lockers', update, id);
            } else if (type == 'b_machines') {
                this.saveUpdateLocker('b_machine_lockers', update, id);
            } else {
                this.saveUpdateLocker('c_machine_lockers', update, id);
            }
        } else {
        }
    }

    saveUpdateLocker(type, update, id) {
        let host = this.state.host;
        console.log(host + '/admin/update_locker/' + type + '/' + id + '/' + update);
        axios
            .get(host + '/admin/update_locker/' + type + '/' + id + '/' + update)
            .then((response) => {
                const { toastManager } = this.props;
                if (response.data && response.status == 200) {
                    console.log(response.data);
                    this.fetchLockers();
                    setTimeout(() => this.showToast(), 800);
                } else if (response.data == 'update_fail') {
                    alert('Locker Update Failed !');
                } else {
                    alert('Something Went Wrong on Locker!');
                }
            })
            .catch((error) => {
                alert('Something Went Wrong!');
                console.log(error);
            });
    }

    showToast() {
        let toastType = this.state.toast;
        var x = document.getElementById('snackbar');
        if (toastType == 'success') {
            x.className = 'show bg-success';
            x.innerHTML =
                "<i class='fa fa-check mx-2'></i><span>Locker Updated Successfully !</span>";
        } else {
            x.className = 'show bg-danger';
            x.innerHTML = "<i class='fa fa-close mx-2'></i><span>Locker Update Failed !</span>";
        }
        setTimeout(function () {
            x.className = x.className.replace('show', '');
        }, 3000);
    }

    render() {
        return this.state.lockers.map((locker, key) => (
            <tr key={key}>
                <td>{locker.id}</td>
                <td>
                    {locker.product_id == 0 ? (
                        <span className="text-muted">No Product Available</span>
                    ) : (
                        locker.product_id
                    )}
                </td>
                <td>
                    {locker.status == 'off' ? (
                        <button
                            onClick={() => this.updateLocker('on', locker.id)}
                            className="mb-2 btn btn-sm btn-danger mr-1"
                        >
                            Closed
                        </button>
                    ) : (
                        <button
                            onClick={() => this.updateLocker('off', locker.id)}
                            className="mb-2 btn btn-sm btn-success mr-1"
                        >
                            Opened
                        </button>
                    )}
                </td>
            </tr>
        ));
    }
}

if (document.getElementById('bvend_app')) {
    ReactDOM.render(<Locker />, document.getElementById('bvend_app'));
}
