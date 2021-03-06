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
require 'inc/meta.php';

/**
 * Admin menu.
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
	wp_enqueue_script( 'bu-checkpoint', plugin_dir_url( __FILE__ ) . 'js/app.js', array(), BU_CHECKPOINT_VER, true );
	$data = array(
		'restURL' => trailingslashit( get_site_url() ) . 'wp-json/wp/v2',
		'postID'  => get_queried_object_id(),
		'title'   => get_the_title( get_queried_object_id() ),
		'user'    => get_current_user_id(),
		'nonce'   => wp_create_nonce( 'wp_rest' ),
	);
	wp_localize_script(
		'bu-checkpoint',
		'checkpointData',
		$data
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );

/**
 * Admin specific styles
 */
function admin_enqueue_styles() {
	wp_enqueue_style( 'quill-core', plugin_dir_url( __FILE__ ) . 'css/quill.core.css', array(), BU_CHECKPOINT_VER );
	wp_enqueue_style( 'quill-snow', plugin_dir_url( __FILE__ ) . 'css/quill.snow.css', array(), BU_CHECKPOINT_VER );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\admin_enqueue_styles' );

