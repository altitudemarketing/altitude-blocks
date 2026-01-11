/**
 * Shadcn Button Block - Edit Component
 */

// WordPress dependencies
const { __ } = wp.i18n;
const { useRef, useEffect } = wp.element;
const { RichText, useBlockProps } = wp.blockEditor;

// Greenlight dependencies
const { gspb_setBlockId, getDataAttributesfromDynamic } = gspblib.utilities;
const {
	aos_animation_cssGen,
	gspb_Css_Final,
	getFinalCssFromDynamicLocalClasses,
	getCssFromStyleAttributes,
} = gspblib.utilities;
const { gspb_cssGen, gspb_convert_styles_for_editor } = gspblib.helpers;
const { BlockToolBar, SVGViewer } = gspblib.components;
const { AnimationRenderProps, AnimationWrapper } = gspblib.collections;

// Inspector
import Inspector from './inspector';

// Button variant and size class mappings
const VARIANT_CLASSES = {
	default: 'shadcn-btn-default',
	destructive: 'shadcn-btn-destructive',
	outline: 'shadcn-btn-outline',
	secondary: 'shadcn-btn-secondary',
	ghost: 'shadcn-btn-ghost',
	link: 'shadcn-btn-link',
};

const SIZE_CLASSES = {
	default: 'shadcn-btn-size-default',
	sm: 'shadcn-btn-sm',
	lg: 'shadcn-btn-lg',
	icon: 'shadcn-btn-icon',
};

export default function edit(props) {
	const {
		id,
		localId,
		animation,
		styleAttributes,
		enableSpecificity,
		interactionLayers,
		anchor,
		// Button specific
		text,
		variant,
		size,
		href,
		disabled,
		fullWidth,
		icon,
		iconPosition,
		iconSize,
		textColor,
		iconColor,
		fontSize,
	} = props.attributes;

	// Generate Unique ID for The Block
	useEffect(() => {
		gspb_setBlockId(props, 2);
	}, []);

	// Set Root class for the block
	useEffect(() => {
		if (id != null) {
			if (props.attributes.localId && props.attributes.localId == id) {
				// do nothing
			} else {
				if (props.attributes.staticLocalId && props.attributes.localId) {
					// do nothing
				} else {
					props.setAttributes({ localId: id });
				}
			}
		}
	}, [id]);

	// Extract SVG from icon object and store for frontend
	useEffect(() => {
		if (icon && icon.icon) {
			// The icon.icon might be an object with svg property or a string
			let svgString = '';
			if (typeof icon.icon === 'string') {
				svgString = icon.icon;
			} else if (icon.icon && typeof icon.icon === 'object' && icon.icon.svg) {
				svgString = icon.icon.svg;
			} else if (icon.svg) {
				svgString = icon.svg;
			}
			props.setAttributes({ iconSvg: svgString });
		} else if (!icon) {
			props.setAttributes({ iconSvg: '' });
		}
	}, [icon]);

	// Check if icon has content - icon object from IconPicker
	const hasIcon = icon && (icon.icon || icon.svg);

	// Render Animation Properties
	const animationRef = useRef();
	let AnimationProps = AnimationRenderProps(animation, interactionLayers);

	// Get Dynamic Data Attributes
	let DynamicDataAttributes = getDataAttributesfromDynamic(props);

	// Build button classes
	const buttonClasses = [
		'shadcn-btn',
		VARIANT_CLASSES[variant] || VARIANT_CLASSES.default,
		SIZE_CLASSES[size] || SIZE_CLASSES.default,
		fullWidth ? 'shadcn-btn-full' : '',
		hasIcon ? 'shadcn-btn-has-icon' : '',
		localId || '',
	].filter(Boolean).join(' ');

	// Set Block Props
	let blockProps = useBlockProps({
		'data-gspb-block-id': props.attributes.id,
		className: `gspb-selector-element ${buttonClasses}`,
		ref: animationRef,
		...DynamicDataAttributes,
		...AnimationProps,
	});

	// CSS Generation
	let css_selector_by_user = '.' + localId;
	let final_css = '';

	// Get Final CSS from Dynamic Local Classes
	final_css = getFinalCssFromDynamicLocalClasses(props, final_css);

	// Get CSS from Style Attributes
	let local_css = '';
	if (styleAttributes) {
		local_css = getCssFromStyleAttributes(styleAttributes, css_selector_by_user, local_css, enableSpecificity);
	}
	if (local_css != '') {
		final_css += local_css;
	}

	// Animation CSS Generation
	final_css = aos_animation_cssGen(animation, css_selector_by_user, final_css, props);

	// Use more specific selector for button overrides
	const btn_selector = '.shadcn-btn' + css_selector_by_user;

	// Add custom color CSS
	if (textColor) {
		final_css = gspb_cssGen(btn_selector, ['color'], [textColor], final_css);
	}

	// Add font size CSS
	if (fontSize) {
		final_css = gspb_cssGen(btn_selector, ['font-size'], [fontSize], final_css);
	}

	// Icon color and size CSS
	if (hasIcon) {
		const iconSelector = btn_selector + ' .shadcn-btn-icon-wrap svg';
		if (iconColor) {
			final_css = gspb_cssGen(iconSelector, ['fill'], [iconColor], final_css);
		}
		if (iconSize) {
			final_css = gspb_cssGen(iconSelector, ['width', 'height'], [iconSize, iconSize], final_css);
		}
	}

	// Determine element tag - use span in editor for proper block behavior
	let ElementTag = 'span';

	if (anchor) {
		blockProps.id = anchor;
	}

	if (disabled) {
		blockProps['aria-disabled'] = 'true';
		blockProps.className += ' shadcn-btn-disabled';
	}

	// Get Final CSS for Editor
	let editor_css = final_css;
	editor_css = gspb_convert_styles_for_editor(editor_css);

	// Set Stored CSS
	gspb_Css_Final(id, final_css, props);

	// Render icon using SVGViewer component
	const renderIcon = () => {
		if (!hasIcon) return null;
		// Don't pass blockProps to SVGViewer - it would apply button classes to the SVG
		return (
			<span className="shadcn-btn-icon-wrap">
				<SVGViewer attributeName="icon" {...props} />
			</span>
		);
	};

	return (
		<>
			<AnimationWrapper attributes={props.attributes} props={props} animationExtRef={animationRef}>
				{props.isSelected && (
					<>
						<Inspector {...props} />
						<BlockToolBar {...props} />
					</>
				)}
				<ElementTag {...blockProps}>
					{hasIcon && iconPosition === 'left' && renderIcon()}
					<RichText
						tagName="span"
						className="shadcn-btn-text"
						placeholder={__('Button text...', 'altitude-blocks')}
						value={text}
						onChange={(value) => {
							props.setAttributes({ text: value });
						}}
						allowedFormats={['core/bold', 'core/italic']}
					/>
					{hasIcon && iconPosition === 'right' && renderIcon()}
					{editor_css && (
						<style
							dangerouslySetInnerHTML={{
								__html: editor_css,
							}}
						/>
					)}
				</ElementTag>
			</AnimationWrapper>
		</>
	);
}
