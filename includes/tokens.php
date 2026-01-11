<?php

/**
 * Shadcn Design Tokens Registration
 *
 * Registers Shadcn's design tokens (CSS custom properties) with Greenshift's
 * global variables system, making them available in the color picker and
 * variable selectors throughout the editor.
 *
 * @package AltitudeBlocks
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Register Shadcn color tokens with Greenshift
 */
add_filter('greenshift_global_variables', 'altitude_blocks_register_color_tokens');
function altitude_blocks_register_color_tokens($variables)
{
	// Ensure $variables is an array (filter may pass empty string or null)
	if (!is_array($variables)) {
		$variables = array();
	}

	// Note: variable_value uses HEX for color picker preview compatibility
	// The actual CSS output (below) uses OKLCH for better color accuracy
	$shadcn_colors = array(
		// Background & Foreground
		array(
			'label' => 'Background',
			'value' => 'var(--background)',
			'variable' => '--background',
			'variable_value' => '#ffffff',
			'group' => 'color'
		),
		array(
			'label' => 'Foreground',
			'value' => 'var(--foreground)',
			'variable' => '--foreground',
			'variable_value' => '#0a0a0a',
			'group' => 'color'
		),

		// Primary
		array(
			'label' => 'Primary',
			'value' => 'var(--primary)',
			'variable' => '--primary',
			'variable_value' => '#171717',
			'group' => 'color'
		),
		array(
			'label' => 'Primary Foreground',
			'value' => 'var(--primary-foreground)',
			'variable' => '--primary-foreground',
			'variable_value' => '#fafafa',
			'group' => 'color'
		),

		// Secondary
		array(
			'label' => 'Secondary',
			'value' => 'var(--secondary)',
			'variable' => '--secondary',
			'variable_value' => '#f5f5f5',
			'group' => 'color'
		),
		array(
			'label' => 'Secondary Foreground',
			'value' => 'var(--secondary-foreground)',
			'variable' => '--secondary-foreground',
			'variable_value' => '#171717',
			'group' => 'color'
		),

		// Destructive
		array(
			'label' => 'Destructive',
			'value' => 'var(--destructive)',
			'variable' => '--destructive',
			'variable_value' => '#dc2626',
			'group' => 'color'
		),
		array(
			'label' => 'Destructive Foreground',
			'value' => 'var(--destructive-foreground)',
			'variable' => '--destructive-foreground',
			'variable_value' => '#dc2626',
			'group' => 'color'
		),

		// Muted
		array(
			'label' => 'Muted',
			'value' => 'var(--muted)',
			'variable' => '--muted',
			'variable_value' => '#f5f5f5',
			'group' => 'color'
		),
		array(
			'label' => 'Muted Foreground',
			'value' => 'var(--muted-foreground)',
			'variable' => '--muted-foreground',
			'variable_value' => '#737373',
			'group' => 'color'
		),

		// Accent
		array(
			'label' => 'Accent',
			'value' => 'var(--accent)',
			'variable' => '--accent',
			'variable_value' => '#f5f5f5',
			'group' => 'color'
		),
		array(
			'label' => 'Accent Foreground',
			'value' => 'var(--accent-foreground)',
			'variable' => '--accent-foreground',
			'variable_value' => '#171717',
			'group' => 'color'
		),

		// Border & Ring
		array(
			'label' => 'Border',
			'value' => 'var(--border)',
			'variable' => '--border',
			'variable_value' => '#e5e5e5',
			'group' => 'color'
		),
		array(
			'label' => 'Ring',
			'value' => 'var(--ring)',
			'variable' => '--ring',
			'variable_value' => '#a3a3a3',
			'group' => 'color'
		),

		// Input & Card
		array(
			'label' => 'Input',
			'value' => 'var(--input)',
			'variable' => '--input',
			'variable_value' => '#e5e5e5',
			'group' => 'color'
		),
		array(
			'label' => 'Card',
			'value' => 'var(--card)',
			'variable' => '--card',
			'variable_value' => '#ffffff',
			'group' => 'color'
		),
		array(
			'label' => 'Card Foreground',
			'value' => 'var(--card-foreground)',
			'variable' => '--card-foreground',
			'variable_value' => '#0a0a0a',
			'group' => 'color'
		),

		// Popover
		array(
			'label' => 'Popover',
			'value' => 'var(--popover)',
			'variable' => '--popover',
			'variable_value' => '#ffffff',
			'group' => 'color'
		),
		array(
			'label' => 'Popover Foreground',
			'value' => 'var(--popover-foreground)',
			'variable' => '--popover-foreground',
			'variable_value' => '#0a0a0a',
			'group' => 'color'
		),
	);

	return array_merge($variables, $shadcn_colors);
}

/**
 * Register Shadcn size tokens with Greenshift
 */
add_filter('greenshift_global_variables', 'altitude_blocks_register_size_tokens');
function altitude_blocks_register_size_tokens($variables)
{
	// Ensure $variables is an array (filter may pass empty string or null)
	if (!is_array($variables)) {
		$variables = array();
	}

	$shadcn_sizes = array(
		array(
			'label' => 'Radius',
			'value' => 'var(--radius)',
			'variable' => '--radius',
			'variable_value' => '0.625rem',
			'group' => 'size'
		),
		array(
			'label' => 'Radius SM',
			'value' => 'calc(var(--radius) - 4px)',
			'variable' => '--radius-sm',
			'variable_value' => 'calc(var(--radius) - 4px)',
			'group' => 'size'
		),
		array(
			'label' => 'Radius MD',
			'value' => 'calc(var(--radius) - 2px)',
			'variable' => '--radius-md',
			'variable_value' => 'calc(var(--radius) - 2px)',
			'group' => 'size'
		),
		array(
			'label' => 'Radius LG',
			'value' => 'var(--radius)',
			'variable' => '--radius-lg',
			'variable_value' => 'var(--radius)',
			'group' => 'size'
		),
		array(
			'label' => 'Radius XL',
			'value' => 'calc(var(--radius) + 4px)',
			'variable' => '--radius-xl',
			'variable_value' => 'calc(var(--radius) + 4px)',
			'group' => 'size'
		),
	);

	return array_merge($variables, $shadcn_sizes);
}

/**
 * Output CSS custom properties in the frontend
 */
add_action('wp_head', 'altitude_blocks_output_css_variables', 1);
add_action('admin_head', 'altitude_blocks_output_css_variables', 1);
function altitude_blocks_output_css_variables()
{
?>
	<style id="altitude-blocks-tokens">
		:root {
			/* Background & Foreground */
			--background: oklch(1 0 0);
			--foreground: oklch(0.145 0 0);

			/* Primary */
			--primary: oklch(0.205 0 0);
			--primary-foreground: oklch(0.985 0 0);

			/* Secondary */
			--secondary: oklch(0.97 0 0);
			--secondary-foreground: oklch(0.205 0 0);

			/* Destructive */
			--destructive: oklch(0.577 0.245 27.325);
			--destructive-foreground: oklch(0.577 0.245 27.325);

			/* Muted */
			--muted: oklch(0.97 0 0);
			--muted-foreground: oklch(0.556 0 0);

			/* Accent */
			--accent: oklch(0.97 0 0);
			--accent-foreground: oklch(0.205 0 0);

			/* Border & Ring */
			--border: oklch(0.922 0 0);
			--ring: oklch(0.708 0 0);

			/* Input */
			--input: oklch(0.922 0 0);

			/* Card */
			--card: oklch(1 0 0);
			--card-foreground: oklch(0.145 0 0);

			/* Popover */
			--popover: oklch(1 0 0);
			--popover-foreground: oklch(0.145 0 0);

			/* Radius */
			--radius: 0.625rem;
		}
	</style>
<?php
}
