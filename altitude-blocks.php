<?php

/**
 * Plugin Name: Altitude Blocks
 * Description: Shadcn design system components for Greenshift/GreenLight
 * Author: Altitude Blocks
 * Author URI: https://github.com/scottfoster/altitude-blocks
 * Version: 0.1
 * Text Domain: altitude-blocks
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

// Define Dir URL
define('ALTITUDE_BLOCKS_DIR_URL', plugin_dir_url(__FILE__));
define('ALTITUDE_BLOCKS_DIR_PATH', plugin_dir_path(__FILE__));

/**
 * Check if parent plugin (Greenshift or GreenLight) is active
 */
function altitude_blocks_is_parent_active()
{
	$active_plugins = get_option('active_plugins', array());

	if (is_multisite()) {
		$network_active_plugins = get_site_option('active_sitewide_plugins', array());
		$active_plugins = array_merge($active_plugins, array_keys($network_active_plugins));
	}

	foreach ($active_plugins as $basename) {
		if (
			0 === strpos($basename, 'gl-page-builder/') ||
			0 === strpos($basename, 'greenshift-animation-and-page-builder-blocks/')
		) {
			return true;
		}
	}

	return false;
}

if (altitude_blocks_is_parent_active()) {
	add_action('enqueue_block_editor_assets', 'altitude_blocks_editor_assets');
} else {
	add_action('admin_notices', 'altitude_blocks_admin_notice_warning');
}

/**
 * Show warning if parent plugin is not active
 */
function altitude_blocks_admin_notice_warning()
{
?>
	<div class="notice notice-warning">
		<p><?php printf(
			__('Please activate %s or %s plugin to use Altitude Blocks', 'altitude-blocks'),
			'<a href="https://greenlightbuilder.pro" target="_blank">GreenLight Builder</a>',
			'<a href="https://greenshiftwp.com" target="_blank">Greenshift</a>'
		); ?></p>
	</div>
<?php
}

/**
 * Register Altitude Blocks Category
 */
if (!function_exists('altitude_blocks_category')) {
	function altitude_blocks_category($categories, $post)
	{
		return array_merge(
			array(
				array(
					'slug'  => 'altitude-blocks',
					'title' => __('Altitude Blocks', 'altitude-blocks'),
				),
			),
			$categories
		);
	}
}
add_filter('block_categories_all', 'altitude_blocks_category', 1, 2);

/**
 * Enqueue Gutenberg block assets for backend editor
 */
if (!function_exists('altitude_blocks_editor_assets')) {
	function altitude_blocks_editor_assets()
	{
		$index_asset_file = include(ALTITUDE_BLOCKS_DIR_PATH . 'build/index.asset.php');

		// Blocks Assets Scripts
		wp_enqueue_script(
			'altitude-blocks-editor-js',
			ALTITUDE_BLOCKS_DIR_URL . 'build/index.js',
			array(
				'greenShift-editor-js',
				'greenShift-library-script',
				'wp-block-editor',
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-editor',
				'wp-data'
			),
			$index_asset_file['version'],
			true
		);

		// Styles
		wp_enqueue_style(
			'altitude-blocks-editor-css',
			ALTITUDE_BLOCKS_DIR_URL . 'build/index.css',
			array('greenShift-library-editor', 'wp-edit-blocks'),
			$index_asset_file['version']
		);
	}
}

/**
 * Include design tokens and preset classes
 */
require_once ALTITUDE_BLOCKS_DIR_PATH . 'includes/tokens.php';
require_once ALTITUDE_BLOCKS_DIR_PATH . 'includes/presets/button.php';

/**
 * Register server side block rendering
 */
require_once ALTITUDE_BLOCKS_DIR_PATH . 'blockrender/example/block.php';
require_once ALTITUDE_BLOCKS_DIR_PATH . 'blockrender/button/block.php';

/**
 * Register frontend styles
 */
add_action('wp_enqueue_scripts', 'altitude_blocks_register_frontend_styles');
function altitude_blocks_register_frontend_styles()
{
	// Register button styles (will be enqueued when block is used)
	wp_register_style(
		'altitude-blocks-button',
		ALTITUDE_BLOCKS_DIR_URL . 'assets/css/button.css',
		array(),
		'0.1'
	);
}

/**
 * Enqueue button styles in editor
 */
add_action('enqueue_block_editor_assets', 'altitude_blocks_editor_button_styles');
function altitude_blocks_editor_button_styles()
{
	wp_enqueue_style(
		'altitude-blocks-button-editor',
		ALTITUDE_BLOCKS_DIR_URL . 'assets/css/button.css',
		array(),
		'0.1'
	);
}

/**
 * Conditional scripts and frontend render
 */
add_filter('render_block', 'altitude_blocks_render_block', 10, 2);
if (!function_exists('altitude_blocks_render_block')) {
	function altitude_blocks_render_block($html, $block)
	{
		if (!is_admin()) {
			// Enqueue button styles when button block is used
			if ($block['blockName'] === 'altitude-blocks/button') {
				wp_enqueue_style('altitude-blocks-button');
			}
		}

		return $html;
	}
}
