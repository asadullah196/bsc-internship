<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

//register Eventin  block category
function etn_block_category($categories, $post)
{
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'eventin-blocks',
				'title' => __('Eventin ', 'eventin'),
			),
		)
	);
}
add_filter('block_categories', 'etn_block_category', 10, 2);

//register block assets
function etn_block_assets()
{
	// Register block styles for both frontend + backend.
	wp_register_style(
		'eventin-block-style-css',
		plugins_url('dist/blocks.style.build.css', dirname(__FILE__)),
		is_admin() ? array('wp-editor') : null,
		null
	);

	// Register block editor styles for backend.
	wp_register_style(
		'eventin-block-editor-style-css',
		plugins_url('dist/blocks.editor.build.css', dirname(__FILE__)),
		array('wp-edit-blocks'),
		null
	);

	// Register block editor script for backend.
	wp_register_script(
		'eventin-block-js',
		plugins_url('/dist/blocks.build.js', dirname(__FILE__)), // Block.build.js: We register the block here. Built with Webpack.
		array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-compose', 'wp-server-side-render'),
		null,
		true
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'eventin-block-js',
		'tsGlobal',
		[
			'pluginDirPath' => plugin_dir_path(__DIR__),
			'pluginDirUrl'  => plugin_dir_url(__DIR__),

		]
	);
}

// Hook: Block assets.
add_action('init', 'etn_block_assets');

//include event block
if (file_exists(ETN_DIR . '/core/guten-block/inc/blocks/event-list.php')) {
	include_once ETN_DIR . '/core/guten-block/inc/blocks/event-list.php';
}
//include speaker block
if (file_exists(ETN_DIR . '/core/guten-block/inc/blocks/speaker-list.php')) {
	include_once ETN_DIR . '/core/guten-block/inc/blocks/speaker-list.php';
}
//include zoom meeting
if (file_exists(ETN_DIR . '/core/guten-block/inc/blocks/zoom-meeting.php')) {
	include_once ETN_DIR . '/core/guten-block/inc/blocks/zoom-meeting.php';
}
//include zoom meeting
if (file_exists(ETN_DIR . '/core/guten-block/inc/blocks/schedule-tab.php')) {
	include_once ETN_DIR . '/core/guten-block/inc/blocks/schedule-tab.php';
}
