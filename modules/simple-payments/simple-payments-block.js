'use strict';

var registerBlockType = wp.blocks.registerBlockType;

var blockStyle = { backgroundColor: '#900', color: '#fff', padding: '20px' };

registerBlockType('jetpack/simple-payments-button', {
	title: 'Simple payment title',

	icon: 'universal-access-alt',

	category: 'layout',

	edit: function edit() {
		return wp.element.createElement(
			'p',
			{ style: blockStyle },
			'Edit simple payments button.'
		);
	},
	save: function save() {
		return wp.element.createElement(
			'p',
			{ style: blockStyle },
			'Simple payment button saved content.'
		);
	}
});