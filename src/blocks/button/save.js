/**
 * Shadcn Button Block - Save Component
 */

// WordPress dependencies
const { __ } = wp.i18n;
const { RichText } = wp.blockEditor;
import isEqual from 'lodash/isEqual';

// Import block dependencies
import attributes from './attributes';

// Greenlight dependencies
const { getDataAttributesfromDynamic } = gspblib.utilities;
const { AnimationRenderProps } = gspblib.collections;
const { SVGViewer } = gspblib.components;

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

export default function save(props) {
	const {
		anchor,
		localId,
		animation,
		interactionLayers,
		styleAttributes,
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
	} = props.attributes;

	let DynamicDataAttributes = getDataAttributesfromDynamic(props);
	let AnimationProps = AnimationRenderProps(animation, interactionLayers);

	// Check if we have an icon
	const hasIcon = icon && (icon.icon || icon.svg);

	// Build button classes
	const buttonClasses = [
		'shadcn-btn',
		VARIANT_CLASSES[variant] || VARIANT_CLASSES.default,
		SIZE_CLASSES[size] || SIZE_CLASSES.default,
		fullWidth ? 'shadcn-btn-full' : '',
		disabled ? 'shadcn-btn-disabled' : '',
		hasIcon ? 'shadcn-btn-has-icon' : '',
		props.attributes.className || '',
	].filter(Boolean).join(' ');

	// Determine element tag based on elementType attribute
	const ElementTag = elementType === 'link' ? 'a' : 'button';

	const blockProps = {
		...DynamicDataAttributes,
		...AnimationProps,
		className: buttonClasses,
	};

	// Add localId for styling - always add if exists since CSS targets this class
	if (localId) {
		blockProps.className = blockProps.className + ' ' + localId;
	}

	// Add anchor if set
	if (anchor) {
		blockProps.id = anchor;
	}

	// Add link attributes if elementType is link
	if (elementType === 'link') {
		if (href) {
			blockProps.href = href;
		}
		if (target && target !== '_self') {
			blockProps.target = target;
		}
		if (rel) {
			blockProps.rel = rel;
		}
	} else {
		// Add button type for button element
		blockProps.type = 'button';
	}

	// Add disabled state
	if (disabled) {
		if (elementType === 'link') {
			blockProps['aria-disabled'] = 'true';
		} else {
			blockProps.disabled = true;
		}
	}

	return (
		<ElementTag {...blockProps}>
			{hasIcon && iconPosition === 'left' && (
				<span className="shadcn-btn-icon-wrap">
					<SVGViewer attributeName="icon" {...props} />
				</span>
			)}
			<span className="shadcn-btn-text">
				<RichText.Content value={text} />
			</span>
			{hasIcon && iconPosition === 'right' && (
				<span className="shadcn-btn-icon-wrap">
					<SVGViewer attributeName="icon" {...props} />
				</span>
			)}
		</ElementTag>
	);
}
