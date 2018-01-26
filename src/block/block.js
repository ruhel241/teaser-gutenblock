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
const { 
	InspectorControls,
	registerBlockType,
	blockEditRender 
	} = wp.blocks; // Import registerBlockType() from wp.blocks

const { ToggleControl } = InspectorControls;
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
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'ncfgears-reference-block — CGB Block' ),
		__( 'create-guten-block' ),
	],
	attributes: {
		getPost: {
			type: 'boolean',
			default: true,
		},
		hasPost: {
			type: 'boolean',
			default: false,
		},
		output: {
			type: 'string',
			default: '',
		},
		post_id: {
			type: 'int',
		},
		post_title: {
			type: 'string',
		},
	},

	// The "edit" property must be a valid function.
	edit( { attributes, setAttributes, focus, setFocus, className } ) {
		const { getPost, hasPost, output, post_id, post_title, some_bool } = attributes;
		function onSelectData( option ){
			if( option === null ){
				setAttributes({
					post_id: "",
					post_title: "",
					hasPost: false,
					getPost: false,
				});
			} else {
				setAttributes({
					post_id: option.value,
					post_title: option.label,
					hasPost: true,
					getPost: true,
				});
			}
		}

		function handleFetchErrors(response) {
			if (!response.ok) {
				console.log('fetch error, status: ' + response.statusText);
			}
			return response;
		}

		const getPostDisplay = ( post_id ) =>{
			var url = '/wp-json/gutenburg/v1/get-block/' + post_id;
			
			var vars = JSON.stringify( attributes );
			return fetch( url, { 
				credentials: 'same-origin',
				method: 'post', 
				headers: {
					Accept: 'application/json',
					'Content-Type': 'application/json',
					'X-WP-Nonce': ngfb.nonce
				},
				body: vars,
				})
				.then( handleFetchErrors )
				.then( ( response ) => response.json() )
				.then( ( json ) => {
					setAttributes({
						output: json.html,
						getPost: false
					});
				}).catch(function() {
					console.log("error");
				});
		}

		var value = { value: post_id, label: post_title }
		const selecta = (
			<Select2 
				onChange={ onSelectData } 
				restUrl="/wp-json/gutenburg/v1/search-query/" 
				initial_value={ value } 
				nonce={ ngfb.nonce } 
			/>
		)

		const controls = focus && (
			<InspectorControls key="inspector">
				<label class="blocks-base-control__label">Search for a Post</label>
				{ selecta }
			</InspectorControls>
		);

		if ( ! hasPost ) {
			return [
				controls,
				<div className={ className }>
					{ selecta }
				</div>
			]
		} else {
			if( getPost ){
				getPostDisplay( post_id );
			}
		}
		
		return [
			controls,
			<div className={ className } dangerouslySetInnerHTML={ { __html: output } } />
		];
	},

	// The "save" property must be specified and must be a valid function.
	save( { attributes, className } ) {
		const { getPost, hasPost, output, post_id, post_title, some_bool } = attributes;
		return [
			<div className={ className } dangerouslySetInnerHTML={ { __html: output } } />
		]
	},
});