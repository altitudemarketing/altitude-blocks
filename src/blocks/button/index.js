/**
 * Shadcn Button Block
 *
 * A button component following Shadcn's design system with
 * 6 variants and 4 sizes.
 */
import { __ } from '@wordpress/i18n';
import edit from './edit';
import save from './save';
import { registerBlockType } from '@wordpress/blocks';
import blockIcon from './icon';
import attributes from './attributes';

registerBlockType('altitude-blocks/button', {
	category: 'altitude-blocks',
	icon: blockIcon,
	example: {
		attributes: {
			text: 'Click me',
			variant: 'default',
			size: 'default',
		},
	},
	title: __('Shadcn Button', 'altitude-blocks'),
	description: __('A button component with multiple variants and sizes following Shadcn design system.', 'altitude-blocks'),
	keywords: [
		__('button', 'altitude-blocks'),
		__('shadcn', 'altitude-blocks'),
		__('link', 'altitude-blocks'),
		__('cta', 'altitude-blocks'),
	],
	attributes,
	edit,
	save,
});
