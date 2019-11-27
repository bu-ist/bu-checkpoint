<?php
/**
 * Plugin Name:     BU Checkpoint
 * Plugin URI:      https://github.com/bu-ist/bu-checkpoint
 * Description:     Editorial workflow for posts and pages.
 * Author:          Boston University, Jim Reevior
 * Text Domain:     bu-checkpoint
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         bu-checkpoint
 */

namespace BU\Plugins\Checkpoint;

use function plugin_dir_url;

define( 'BU_CHECKPOINT_VER', '1.0' );

// CPT & Taxonomies.
define( 'BU_CHECKPOINT_CPT', 'bu-checkpoint' );
define( 'BU_CHECKPOINT_STATUS', 'bu-checkpoint-status' );
define( 'BU_CHECKPOINT_STAGES', 'bu-checkpoint-stages' );

// Required.
require 'inc/taxonomy.php';
require 'inc/post-type.php';

/**
 * Utility function to get the meta keys.
 *
 * @return array Meta keys.
 */
function get_meta_keys() {
	return array(
		'bu-checkpoint-comments',
		'bu-checkpoint-stage',
		'bu-checkpoint-status',
	);
}

/**
 * Register the meta fields.
 */
function init_register_meta() {
	$meta = get_meta_keys();
	foreach ( $meta as $key ) {
		register_meta(
			BU_CHECKPOINT_CPT,
			$key,
			array(
				'show_in_rest' => true,
				'type'         => 'string',
				'single'       => true,
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\\init_register_meta' );

/*
* Adds a submenu to the Settings menu.
* the page will contain the ID of html element that hosts our JSX components.
*/
function create_admin_menu() {
	add_menu_page( 'Checkpoint', 'Checkpoint', 'edit_others_pages', 'bu-checkpoint', __NAMESPACE__ . '\\display_admin_screen', 'dashicons-yes' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\create_admin_menu' );

/**
 * Callback for displaying the admin screen div wrapper.
 */
function display_admin_screen() {
	echo '<div id="checkpoint-admin-wrapper"></div>';
}

/**
 * Add meta box.
 */
function action_add_meta_box() {
	add_meta_box(
		'bu-checkpoint',
		__( 'Checkpoint', 'bu-checkpoint' ),
		__NAMESPACE__ . '\\display_meta_box',
		'page',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\\action_add_meta_box' );

/**
 * Callback to display the metabox wrapper.
 */
function display_meta_box() {
	echo '<div id="checkpoint-metabox-wrapper"></div>';
}

/**
 * Enqueue React & scripts
 */
function enqueue_scripts() {
	if ( ! in_array( BU_ENVIRONMENT_TYPE, array( 'test', 'prod' ) ) ) {
		// Load Dev scripts in sandbox.
		wp_enqueue_script( 'checkpoint-react', 'https://unpkg.com/react@16/umd/react.development.js', array(), BU_CHECKPOINT_VER, true );
		wp_enqueue_script( 'checkpoint-react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.development.js', array( 'checkpoint-react' ), BU_CHECKPOINT_VER, true );
	} else {
		// Load Prod scripts.
		wp_enqueue_script( 'checkpoint-react', 'https://unpkg.com/react@16/umd/react.production.min.js', array(), BU_CHECKPOINT_VER, true );
		wp_enqueue_script( 'checkpoint-react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array( 'checkpoint-react' ), BU_CHECKPOINT_VER, true );
	}

	wp_enqueue_script( 'bu-checkpoint', plugin_dir_url( __FILE__ ) . 'js/app.js', array( 'checkpoint-react', 'checkpoint-react-dom' ), BU_CHECKPOINT_VER, true );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
