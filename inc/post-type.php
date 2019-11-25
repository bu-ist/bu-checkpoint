<?php
/**
 * Custom Post Type
 *
 * @package bu-checkpoint
 */

namespace BU\Plugins\Checkpoint\CPT;

/**
 * Custom Post Type
 *
 * @return void
 */
function action_cpt() {
	$cpt      = BU_CHECKPOINT_CPT;
	$cpt_name = __( 'Checkpoint', 'bu-checkpoint' );

	$labels = array(
		'name'                  => $cpt_name . 's',
		'singular_name'         => $cpt_name,
		'menu_name'             => $cpt_name . 's',
		'name_admin_bar'        => $cpt_name,
		'archives'              => $cpt_name . __( ' Archives', 'bu-checkpoint' ),
		'attributes'            => $cpt_name . __( ' Attributes', 'bu-checkpoint' ),
		'parent_item_colon'     => __( 'Parent', 'bu-checkpoint' ) . $cpt_name . ':',
		'all_items'             => __( 'All ', 'bu-checkpoint' ) . $cpt_name . 's',
		'add_new_item'          => __( 'Add New ', 'bu-checkpoint' ) . $cpt_name,
		'add_new'               => __( 'Add New', 'bu-checkpoint' ),
		'new_item'              => __( 'New ', 'bu-checkpoint' ) . $cpt_name,
		'edit_item'             => __( 'Edit ', 'bu-checkpoint' ) . $cpt_name,
		'update_item'           => __( 'Update ', 'bu-checkpoint' ) . $cpt_name,
		'view_item'             => __( 'View ', 'bu-checkpoint' ) . $cpt_name,
		'view_items'            => __( 'View ', 'bu-checkpoint' ) . $cpt_name . 's',
		'search_items'          => __( 'Search ', 'bu-checkpoint' ) . $cpt_name . 's',
		'not_found'             => __( 'Not found', 'bu-checkpoint' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'bu-checkpoint' ),
		'insert_into_item'      => __( 'Insert into item', 'bu-checkpoint' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'bu-checkpoint' ),
		'items_list'            => $cpt_name . __( ' list', 'bu-checkpoint' ),
		'items_list_navigation' => $cpt_name . __( ' list navigation', 'bu-checkpoint' ),
		'filter_items_list'     => __( 'Filter items list', 'bu-checkpoint' ),
	);

	$args = array(
		'label'               => $cpt_name . 's',
		'description'         => __( 'Posts for ', 'bu-checkpoint' ) . $cpt_name . 's',
		'labels'              => $labels,
		'supports'            => array( 'title', 'author' ),
		'taxonomies'          => array( BU_CHECKPOINT_STATUS, BU_CHECKPOINT_STAGES ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => false,
		'show_in_menu'        => false,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-yes',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
		'rewrite'             => true,
	);

	register_post_type( $cpt, $args );
}
add_action( 'init', __NAMESPACE__ . '\\action_cpt' );
