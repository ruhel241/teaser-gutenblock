/**
 * BLOCK: ncfgears-reference-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';
//import Selecta from './selecta.js';

import Select2 from './Select2';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'ncfgears/reference-block', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: "News Reference Block", // Block title.
	icon: 'list-view', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'widgets', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	html: false,
	keywords: [
		__( 'ncfgears-reference-block — CGB Block' ),
		__( 'create-guten-block' ),
	],
	attributes: {
		post_id: {
			type: 'int',
		},
		post_title: {
			type: 'string',
		}
	},

	// The "edit" property must be a valid function.
	edit: function( props ) {
		function onSelectData( option ){
			if( option === null ){
				props.setAttributes({
					post_id: "",
					post_title: "",
				})
			} else {
				props.setAttributes({
					post_id: option.value,
					post_title: option.label,
				})
			}
		}

		var value = { value:props.attributes.post_id, label:props.attributes.post_title }

		return (
			<div className={ props.className }>
				<Select2 onChange={ onSelectData } restUrl="/wp-json/gutenburg/v1/search_query/" initial_value={ value } />
			</div>
		);
	},

	// The "save" property must be specified and must be a valid function.
	save: function( props ) {
		return null;
	},
});