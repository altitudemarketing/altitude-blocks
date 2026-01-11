/**
 * Button Block Attributes
 * @type {Object}
 */
const { collectionsObjects } = gspblib.helpers;

export default {
	// Standard Greenshift attributes
	id: {
		type: 'string',
		default: null,
	},
	localId: {
		type: 'string',
	},
	staticLocalId: {
		type: 'boolean',
	},
	anchor: {
		type: 'string',
	},
	inlineCssStyles: {
		type: 'string',
	},
	dynamicGClasses: {
		type: 'array',
	},
	interactionLayers: {
		type: 'array',
	},
	animation: {
		type: 'object',
		default: collectionsObjects.animation,
	},
	className: {
		type: 'string',
	},
	styleAttributes: {
		type: 'object',
	},
	enableSpecificity: {
		type: 'boolean',
	},

	// Button specific attributes
	text: {
		type: 'string',
		default: 'Button',
		role: 'content',
	},
	variant: {
		type: 'string',
		default: 'default',
	},
	size: {
		type: 'string',
		default: 'default',
	},
	href: {
		type: 'string',
		default: '',
	},
	target: {
		type: 'string',
		default: '_self',
	},
	rel: {
		type: 'string',
		default: '',
	},
	disabled: {
		type: 'boolean',
		default: false,
	},
	fullWidth: {
		type: 'boolean',
		default: false,
	},

	// Icon attributes
	icon: {
		type: 'object',
	},
	iconPosition: {
		type: 'string',
		default: 'left',
	},
	iconSize: {
		type: 'string',
		default: '1em',
	},
	iconSvg: {
		type: 'string',
		default: '',
	},

	// Color attributes
	textColor: {
		type: 'string',
	},
	iconColor: {
		type: 'string',
	},
};
