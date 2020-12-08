import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import url from 'url';

export default class AssignProductCategory extends Component {

	constructor() {
        super();
        this.state = {
        	ml_machines: []
        }
    }

	componentDidMount() {
    }

    selectDate(e) {
		let this_url = window.location.href
		let parse_url = url.parse(this_url, true, true)
        let url_val = parse_url.query
        let host = parse_url.protocol + '//' + parse_url.host
		let date = e.target.value

        let api_url =  host+'/'+'api/admin/dashboard/'+date

        this.setState({value: date})
        axios.get(api_url).then(response => {
        	console.log(response.data)
	        this.setState({
	        	ml_machines: response.data.ml_machines, 
	            total_sales_product : response.data.total_sales_product,
	            total_sales_amount : response.data.total_sales_amount,
	            ml_8_machines : response.data.ml_8_machines,
	            ml_16_machines : response.data.ml_16_machines,
	            ml_32_machines : response.data.ml_32_machines,
	            ml_64_machines : response.data.ml_64_machines,
	            ml_96_machines : response.data.ml_96_machines,
	            ml_128_machines : response.data.ml_128_machines
	        })
        }).catch(error => {
            alert(error)
        })
    }

    render() {
        return (
        	<div></div>
        );
    }
}

if (document.getElementById('assign-product-category')) {
    ReactDOM.render(<AssignProductCategory />, document.getElementById('assign-product-category'));
}
