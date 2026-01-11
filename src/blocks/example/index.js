import { __ } from '@wordpress/i18n';
import edit from './edit';
import save from './save';
import {registerBlockType} from '@wordpress/blocks';
import blockIcon from './icon';
import './styles.editor.scss';
import attributes from './attributes';

registerBlockType( 'altitude-blocks/example', {
    category: 'altitude-blocks',
    icon: blockIcon,
    example: {},
    title: __('Example Block', 'altitude-blocks'),
    description: __('Example block', 'altitude-blocks'),
    keywords: [],
    attributes,
    edit,
    save
});