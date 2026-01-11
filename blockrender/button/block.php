<?php
/**
 * Shadcn Button Block - Server-side Rendering
 *
 * @package AltitudeBlocks
 */

namespace AltitudeBlocks\Blocks;

defined('ABSPATH') || exit;

class ButtonBlock
{
	/**
	 * Variant class mappings
	 */
	private static $variant_classes = array(
		'default' => 'shadcn-btn-default',
		'destructive' => 'shadcn-btn-destructive',
		'outline' => 'shadcn-btn-outline',
		'secondary' => 'shadcn-btn-secondary',
		'ghost' => 'shadcn-btn-ghost',
		'link' => 'shadcn-btn-link',
	);

	/**
	 * Size class mappings
	 */
	private static $size_classes = array(
		'default' => 'shadcn-btn-size-default',
		'sm' => 'shadcn-btn-sm',
		'lg' => 'shadcn-btn-lg',
		'icon' => 'shadcn-btn-icon',
	);

	public function __construct()
	{
		add_action('init', array($this, 'init_handler'));
	}

	public function init_handler()
	{
		register_block_type(__DIR__, array(
			'render_callback' => array($this, 'render_block'),
		));
	}

	public function render_block($settings, $inner_content, $block)
	{
		$block = (is_array($block)) ? $block : $block->parsed_block;
		$attrs = $block['attrs'];

		// Support for Hide on Frontend option
		if (!empty($attrs['styleAttributes']['hideOnFrontend_Extra'])) {
			if (!is_admin()) {
				return '';
			}
		}

		// Check if we have an icon - if so, use the saved content which has SVGViewer output
		$has_icon = !empty($attrs['icon']) && !empty($attrs['icon']['icon']);
		if ($has_icon && !empty($inner_content)) {
			// Use the save.js output which properly renders the SVG
			$output = $inner_content;

			// Handle dynamic placeholders in text
			if (strpos($output, '{{') !== false && function_exists('gl_dynamic_placeholders')) {
				$output = gl_dynamic_placeholders($output);
			}

			return $output;
		}

		// Get attributes with defaults
		$text = !empty($attrs['text']) ? $attrs['text'] : __('Button', 'altitude-blocks');
		$variant = !empty($attrs['variant']) ? $attrs['variant'] : 'default';
		$size = !empty($attrs['size']) ? $attrs['size'] : 'default';
		$href = !empty($attrs['href']) ? $attrs['href'] : '';
		$target = !empty($attrs['target']) ? $attrs['target'] : '_self';
		$rel = !empty($attrs['rel']) ? $attrs['rel'] : '';
		$disabled = !empty($attrs['disabled']) ? $attrs['disabled'] : false;
		$full_width = !empty($attrs['fullWidth']) ? $attrs['fullWidth'] : false;
		$anchor = !empty($attrs['anchor']) ? $attrs['anchor'] : '';
		$local_id = !empty($attrs['localId']) ? $attrs['localId'] : '';
		$class_name = !empty($attrs['className']) ? $attrs['className'] : '';

		// Color attributes
		$text_color = !empty($attrs['textColor']) ? $attrs['textColor'] : '';

		// Build classes array
		$classes = array('shadcn-btn');

		// Add variant class
		$classes[] = isset(self::$variant_classes[$variant])
			? self::$variant_classes[$variant]
			: self::$variant_classes['default'];

		// Add size class
		$classes[] = isset(self::$size_classes[$size])
			? self::$size_classes[$size]
			: self::$size_classes['default'];

		// Add full width class
		if ($full_width) {
			$classes[] = 'shadcn-btn-full';
		}

		// Add disabled class
		if ($disabled) {
			$classes[] = 'shadcn-btn-disabled';
		}

		// Add local ID for custom styling
		if ($local_id) {
			$classes[] = $local_id;
		}

		// Add custom className if set
		if ($class_name) {
			$classes[] = $class_name;
		}

		$class_string = implode(' ', array_filter($classes));

		// Build inline styles
		$styles = array();
		if ($text_color) {
			$styles[] = 'color:' . esc_attr($text_color);
		}

		$style_string = !empty($styles) ? ' style="' . implode(';', $styles) . '"' : '';

		// Handle dynamic placeholders in text
		if (strpos($text, '{{') !== false && function_exists('gl_dynamic_placeholders')) {
			$text = gl_dynamic_placeholders($text);
		}

		// Build content (no icon for server-side rendering - icons use save.js output)
		$content = '<span class="shadcn-btn-text">' . wp_kses_post($text) . '</span>';

		// Build output
		if ($href && !$disabled) {
			// Render as anchor tag
			$output = sprintf(
				'<a href="%s" class="%s"%s%s%s%s>%s</a>',
				esc_url($href),
				esc_attr($class_string),
				$target !== '_self' ? sprintf(' target="%s"', esc_attr($target)) : '',
				$rel ? sprintf(' rel="%s"', esc_attr($rel)) : '',
				$anchor ? sprintf(' id="%s"', esc_attr($anchor)) : '',
				$style_string,
				$content
			);
		} else {
			// Render as button tag
			$output = sprintf(
				'<button type="button" class="%s"%s%s%s>%s</button>',
				esc_attr($class_string),
				$disabled ? ' disabled aria-disabled="true"' : '',
				$anchor ? sprintf(' id="%s"', esc_attr($anchor)) : '',
				$style_string,
				$content
			);
		}

		return $output;
	}
}

new ButtonBlock();
