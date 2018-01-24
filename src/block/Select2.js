import React from 'react';
import createClass from 'create-react-class';
import PropTypes from 'prop-types';
import Select from 'react-select';
import fetch from 'isomorphic-fetch';


const Select2 = createClass({
	displayName: 'Select2',
	propTypes: {
		label: PropTypes.string,
	},
	getInitialState () {
		return {
			backspaceRemoves: true,
			multi: false,
			creatable: false,
			value: this.props.initial_value
		};
	},
	onChange (value) {
		this.setState({
			value: value,
		});
		this.props.onChange(value);
	},
	
	getData (input) {
		if (!input) {
			return Promise.resolve({ options: [] });
		}
		var url = this.props.restUrl + input;
		return fetch(url)
		.then((response) => response.json())
		.then((json) => {
			return { options: json };
		});
	},
	toggleBackspaceRemoves () {
		this.setState({
			backspaceRemoves: !this.state.backspaceRemoves
		});
	},
	toggleCreatable () {
		this.setState({
			creatable: !this.state.creatable
		});
	},
	render () {
		const AsyncComponent = this.state.creatable
			? Select.AsyncCreatable
			: Select.Async;

		return (
			<div className="section">
				<AsyncComponent multi={this.state.multi} value={this.state.value} onChange={this.onChange} loadOptions={this.getData} backspaceRemoves={this.state.backspaceRemoves} />
            </div>
		);
	}
});

export default Select2;