/**
 * Shadcn Button Block - Inspector Controls
 */

// WordPress dependencies
const { __ } = wp.i18n;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl, TextControl, ToggleControl, TextareaControl } = wp.components;
const { useState } = wp.element;
import isEqual from 'lodash/isEqual';
import attributesDefault from './attributes';

// Greenlight dependencies
const {
	Animation,
	InteractionsPanel,
	IconPicker,
	AttributeTabs,
} = gspblib.collections;
const { GlobalClasses, BlpgeColorPicker } = gspblib.components;
const { collectionsObjects } = gspblib.helpers;

// Variant options
const VARIANT_OPTIONS = [
	{ label: __('Default', 'altitude-blocks'), value: 'default' },
	{ label: __('Destructive', 'altitude-blocks'), value: 'destructive' },
	{ label: __('Outline', 'altitude-blocks'), value: 'outline' },
	{ label: __('Secondary', 'altitude-blocks'), value: 'secondary' },
	{ label: __('Ghost', 'altitude-blocks'), value: 'ghost' },
	{ label: __('Link', 'altitude-blocks'), value: 'link' },
];

// Size options
const SIZE_OPTIONS = [
	{ label: __('Default', 'altitude-blocks'), value: 'default' },
	{ label: __('Small', 'altitude-blocks'), value: 'sm' },
	{ label: __('Large', 'altitude-blocks'), value: 'lg' },
	{ label: __('Icon', 'altitude-blocks'), value: 'icon' },
];

// Icon position options
const ICON_POSITION_OPTIONS = [
	{ label: __('Left', 'altitude-blocks'), value: 'left' },
	{ label: __('Right', 'altitude-blocks'), value: 'right' },
];

// Element type options
const ELEMENT_TYPE_OPTIONS = [
	{ label: __('Button', 'altitude-blocks'), value: 'button' },
	{ label: __('Link', 'altitude-blocks'), value: 'link' },
];

const Inspector = (props) => {
	const {
		attributes: {
			anchor,
			styleAttributes,
			enableSpecificity,
			staticLocalId,
			// Button specific
			text,
			variant,
			size,
			href,
			target,
			rel,
			disabled,
			fullWidth,
			elementType,
			icon,
			iconPosition,
			textColor,
			iconColor,
			iconSize,
			fontSize,
		},
		setAttributes,
	} = props;

	const iconBox = icon ? JSON.parse(JSON.stringify(icon)) : JSON.parse(JSON.stringify(collectionsObjects.iconPicker));

	let animationchange = isEqual(attributesDefault.animation.default, props.attributes.animation) ? false : true;
	let interactionchange = (typeof props.attributes.interactionLayers != 'undefined' && props.attributes.interactionLayers.length > 0) ? true : false;

	return (
		<>
			<InspectorControls>
				<div className="gspb_inspector gst-elements-inspector glfw-inspector">
					<GlobalClasses flexChild={true} {...props} />

					{/* Button Settings Panel */}
					<PanelBody title={__('Button Settings', 'altitude-blocks')} initialOpen={true}>
						<TextControl
							label={__('Button Text', 'altitude-blocks')}
							value={text}
							onChange={(value) => setAttributes({ text: value })}
							placeholder={__('Enter button text...', 'altitude-blocks')}
						/>
						<SelectControl
							label={__('Variant', 'altitude-blocks')}
							value={variant}
							options={VARIANT_OPTIONS}
							onChange={(value) => setAttributes({ variant: value })}
							help={__('Choose the button style variant.', 'altitude-blocks')}
						/>
						<SelectControl
							label={__('Size', 'altitude-blocks')}
							value={size}
							options={SIZE_OPTIONS}
							onChange={(value) => setAttributes({ size: value })}
						/>
						<SelectControl
							label={__('Element Type', 'altitude-blocks')}
							value={elementType || 'button'}
							options={ELEMENT_TYPE_OPTIONS}
							onChange={(value) => setAttributes({ elementType: value })}
							help={__('Button for actions, Link for navigation.', 'altitude-blocks')}
						/>
						<ToggleControl
							label={__('Full Width', 'altitude-blocks')}
							checked={fullWidth}
							onChange={(value) => setAttributes({ fullWidth: value })}
						/>
						<ToggleControl
							label={__('Disabled', 'altitude-blocks')}
							checked={disabled}
							onChange={(value) => setAttributes({ disabled: value })}
						/>
					</PanelBody>

					{/* Typography Panel */}
					<PanelBody title={__('Typography', 'altitude-blocks')} initialOpen={false}>
						<TextControl
							label={__('Font Size', 'altitude-blocks')}
							value={fontSize || ''}
							onChange={(value) => setAttributes({ fontSize: value })}
							placeholder="e.g., 16px, 1rem, 1.25em"
							help={__('Enter a CSS font size value.', 'altitude-blocks')}
						/>
					</PanelBody>

					{/* Colors Panel */}
					<PanelBody title={__('Colors', 'altitude-blocks')} initialOpen={false}>
						<div className="gspb-inspector-flex-row gs-flex-space-between gs-gutter-10 gs-child-width-9/3 gs-inspector-margin-bottom-10 gs-flex-align-center">
							<div>{__('Text Color', 'altitude-blocks')}</div>
							<div className="gspb_text_align_right">
								<BlpgeColorPicker
									color={textColor}
									onChange={(value) => setAttributes({ textColor: value })}
								/>
							</div>
						</div>
						<div className="gspb-inspector-flex-row gs-flex-space-between gs-gutter-10 gs-child-width-9/3 gs-inspector-margin-bottom-10 gs-flex-align-center">
							<div>{__('Icon Color', 'altitude-blocks')}</div>
							<div className="gspb_text_align_right">
								<BlpgeColorPicker
									color={iconColor}
									onChange={(value) => setAttributes({ iconColor: value })}
								/>
							</div>
						</div>
					</PanelBody>

					{/* Link Settings Panel */}
					<PanelBody title={__('Link Settings', 'altitude-blocks')} initialOpen={false}>
						<TextControl
							label={__('URL', 'altitude-blocks')}
							value={href}
							onChange={(value) => setAttributes({ href: value })}
							placeholder="https://"
						/>
						<ToggleControl
							label={__('Open in new tab', 'altitude-blocks')}
							checked={target === '_blank'}
							onChange={(value) => {
								setAttributes({
									target: value ? '_blank' : '_self',
									rel: value ? 'noopener noreferrer' : '',
								});
							}}
						/>
						{target === '_blank' && (
							<TextControl
								label={__('Rel attribute', 'altitude-blocks')}
								value={rel}
								onChange={(value) => setAttributes({ rel: value })}
								help={__('Default: noopener noreferrer', 'altitude-blocks')}
							/>
						)}
					</PanelBody>

					{/* Icon Settings Panel */}
					<PanelBody title={__('Icon', 'altitude-blocks')} initialOpen={false}>
						<IconPicker
							icon={iconBox}
							options={false}
							{...props}
							onChange={(icon) => {
								setAttributes({ icon: icon });
							}}
						/>
						{icon && (
							<>
								<SelectControl
									label={__('Icon Position', 'altitude-blocks')}
									value={iconPosition}
									options={ICON_POSITION_OPTIONS}
									onChange={(value) => setAttributes({ iconPosition: value })}
								/>
								<TextControl
									label={__('Icon Size', 'altitude-blocks')}
									value={iconSize || '1em'}
									onChange={(value) => setAttributes({ iconSize: value })}
									help={__('e.g., 1em, 16px, 1.5rem', 'altitude-blocks')}
								/>
							</>
						)}
					</PanelBody>

					{/* Local Styles Panel */}
					<PanelBody
						title={__('Local Styles', 'altitude-blocks')}
						initialOpen={false}
						className="gst-inspector-tab gst-elements-styles"
					>
						<AttributeTabs
							attributeName="styleAttributes"
							{...props}
							defaultTab=""
							includes={['color', 'spacing', 'border', 'shadow', 'effects', 'responsive']}
							svgcolors={true}
							selfAlign="both"
						/>
					</PanelBody>

					{/* Animation Panel */}
					<PanelBody
						title={__('Animation', 'altitude-blocks')}
						initialOpen={false}
						className={`${!animationchange ? '' : 'gspb_panel_changed'}`}
					>
						<Animation attributeName="animation" {...props} />
					</PanelBody>

					{/* Interaction Layers Panel */}
					<PanelBody
						title={__('Interaction Layers', 'altitude-blocks')}
						initialOpen={false}
						className={`${interactionchange ? 'gspb_panel_changed' : ''}`}
					>
						<InteractionsPanel {...props} />
					</PanelBody>

					{/* Anchor & Root Class Panel */}
					<PanelBody
						title={__('Anchor & Root Class', 'altitude-blocks')}
						initialOpen={false}
						className={`${anchor || staticLocalId ? 'gspb_panel_changed' : ''}`}
					>
						<TextareaControl
							label={__('Anchor', 'altitude-blocks')}
							help={__('Set an anchor (ID) for this element.', 'altitude-blocks')}
							value={anchor}
							onChange={(value) => {
								let newvalue = value.trim();
								setAttributes({ anchor: newvalue });
							}}
						/>
					</PanelBody>
				</div>
			</InspectorControls>
		</>
	);
};

export default Inspector;
