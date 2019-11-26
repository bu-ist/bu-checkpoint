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

define( 'BU_CHECKPOINT_VER', '1.0' );

// CPT & Taxonomies
define( 'BU_CHECKPOINT_CPT', 'bu-checkpoint' );
define( 'BU_CHECKPOINT_STATUS', 'bu-checkpoint-status' );
define( 'BU_CHECKPOINT_STAGES', 'bu-checkpoint-stages' );

// Required
require 'inc/taxonomy.php';
require 'inc/post-type.php';
require 'inc/rest-api.php';

/*
* Adds a submenu to the Settings menu.
* the page will contain the ID of html element that hosts our JSX components.
*/
function create_admin_menu() {
	add_menu_page( 'Checkpoint', 'Checkpoint', 'edit_others_pages', 'bu-checkpoint', __NAMESPACE__ . '\\display_admin_screen', 'dashicons-yes' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\create_admin_menu' );

function display_admin_screen() {
	echo '<div id="checkpoint-admin-wrapper"></div>';
}

/**
 * Enqueue React & scripts
 */
function enqueue_scripts() {
	if ( ! in_array( BU_ENVIRONMENT_TYPE, array( 'test', 'prod' ) ) ) {
		// Load Dev scripts in sandbox
		wp_enqueue_script( 'checkpoint-react', 'https://unpkg.com/react@16/umd/react.development.js', array(), BU_CHECKPOINT_VER, true );
		wp_enqueue_script( 'checkpoint-react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.development.js', array( 'checkpoint-react' ), BU_CHECKPOINT_VER, true );
	} else {
		// Load Prod scripts.
		wp_enqueue_script( 'checkpoint-react', 'https://unpkg.com/react@16/umd/react.production.min.js', array(), BU_CHECKPOINT_VER, true );
		wp_enqueue_script( 'checkpoint-react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array( 'checkpoint-react' ), BU_CHECKPOINT_VER, true );
	}

	wp_enqueue_script( 'bu-checkpoint', \plugin_dir_url( __FILE__ ) . 'js/app.js', array( 'checkpoint-react', 'checkpoint-react-dom' ), BU_CHECKPOINT_VER, true );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts' );
