<?php

/**
 * Shadcn Button Preset Classes
 *
 * Registers Shadcn button component styles as Greenshift preset classes,
 * making them available in the class picker and automatically including
 * the CSS when used.
 *
 * @package AltitudeBlocks
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Register Shadcn button preset classes with Greenshift
 */
add_filter('greenshift_preset_classes', 'altitude_blocks_register_button_presets');
function altitude_blocks_register_button_presets($classes)
{
	$button_presets = array(
		// Base button class
		array(
			'value' => 'shadcn-btn',
			'label' => 'Shadcn Button Base',
			'type' => 'preset',
			'css' => '.shadcn-btn{display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;white-space:nowrap;border-radius:var(--radius);font-size:0.875rem;font-weight:500;line-height:1.25rem;transition-property:color,background-color,border-color,box-shadow;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;outline:none;}.shadcn-btn:focus-visible{outline:2px solid var(--ring);outline-offset:2px;}.shadcn-btn:disabled{pointer-events:none;opacity:0.5;}.shadcn-btn svg{pointer-events:none;flex-shrink:0;}'
		),

		// Variant: Default
		array(
			'value' => 'shadcn-btn-default',
			'label' => 'Button Default',
			'type' => 'preset',
			'css' => '.shadcn-btn-default{background-color:var(--primary);color:var(--primary-foreground);box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);}.shadcn-btn-default:hover{background-color:color-mix(in oklch,var(--primary) 90%,black);}'
		),

		// Variant: Destructive
		array(
			'value' => 'shadcn-btn-destructive',
			'label' => 'Button Destructive',
			'type' => 'preset',
			'css' => '.shadcn-btn-destructive{background-color:var(--destructive);color:#fff;box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);}.shadcn-btn-destructive:hover{background-color:color-mix(in oklch,var(--destructive) 90%,black);}.shadcn-btn-destructive:focus-visible{outline-color:var(--destructive);}'
		),

		// Variant: Outline
		array(
			'value' => 'shadcn-btn-outline',
			'label' => 'Button Outline',
			'type' => 'preset',
			'css' => '.shadcn-btn-outline{border:1px solid var(--input);background-color:var(--background);box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);}.shadcn-btn-outline:hover{background-color:var(--accent);color:var(--accent-foreground);}'
		),

		// Variant: Secondary
		array(
			'value' => 'shadcn-btn-secondary',
			'label' => 'Button Secondary',
			'type' => 'preset',
			'css' => '.shadcn-btn-secondary{background-color:var(--secondary);color:var(--secondary-foreground);box-shadow:0 1px 2px 0 rgba(0,0,0,0.05);}.shadcn-btn-secondary:hover{background-color:color-mix(in oklch,var(--secondary) 80%,black);}'
		),

		// Variant: Ghost
		array(
			'value' => 'shadcn-btn-ghost',
			'label' => 'Button Ghost',
			'type' => 'preset',
			'css' => '.shadcn-btn-ghost{background-color:transparent;}.shadcn-btn-ghost:hover{background-color:var(--accent);color:var(--accent-foreground);}'
		),

		// Variant: Link
		array(
			'value' => 'shadcn-btn-link',
			'label' => 'Button Link',
			'type' => 'preset',
			'css' => '.shadcn-btn-link{color:var(--primary);text-underline-offset:4px;background-color:transparent;}.shadcn-btn-link:hover{text-decoration:underline;}'
		),

		// Size: Default
		array(
			'value' => 'shadcn-btn-size-default',
			'label' => 'Button Size Default',
			'type' => 'preset',
			'css' => '.shadcn-btn-size-default{height:2.25rem;padding-left:1rem;padding-right:1rem;padding-top:0.5rem;padding-bottom:0.5rem;}'
		),

		// Size: Small
		array(
			'value' => 'shadcn-btn-sm',
			'label' => 'Button Size Small',
			'type' => 'preset',
			'css' => '.shadcn-btn-sm{height:2rem;padding-left:0.75rem;padding-right:0.75rem;border-radius:var(--radius);gap:0.375rem;font-size:0.75rem;}'
		),

		// Size: Large
		array(
			'value' => 'shadcn-btn-lg',
			'label' => 'Button Size Large',
			'type' => 'preset',
			'css' => '.shadcn-btn-lg{height:2.5rem;padding-left:1.5rem;padding-right:1.5rem;border-radius:var(--radius);}'
		),

		// Size: Icon
		array(
			'value' => 'shadcn-btn-icon',
			'label' => 'Button Size Icon',
			'type' => 'preset',
			'css' => '.shadcn-btn-icon{height:2.25rem;width:2.25rem;padding:0;}'
		),

		// Full Width modifier
		array(
			'value' => 'shadcn-btn-full',
			'label' => 'Button Full Width',
			'type' => 'preset',
			'css' => '.shadcn-btn-full{width:100%;}'
		),
	);

	return array_merge($classes, $button_presets);
}
