<?php
/**
 * Taxonomy
 *
 * @package bu-checkpoint
 */

namespace BU\Plugins\Checkpoint\Taxonomy;

function create_tax( $term, $tax_name, $tax_name_plural, $terms ) {
	$labels = array(
		'name'                       => $tax_name_plural,
		'singular_name'              => $tax_name,
		'search_items'               => __( 'Search ', 'bu-checkpoint' ) . $tax_name_plural,
		'popular_items'              => __( 'Popular ', 'bu-checkpoint' ) . $tax_name_plural,
		'all_items'                  => __( 'All ', 'bu-checkpoint' ) . $tax_name_plural,
		'edit_item'                  => __( 'Edit ', 'bu-checkpoint' ) . $tax_name,
		'update_item'                => __( 'Update ', 'bu-checkpoint' ) . $tax_name,
		'add_new_item'               => __( 'Add New ', 'bu-checkpoint' ) . $tax_name,
		'new_item_name'              => __( 'New ', 'bu-checkpoint' ) . $tax_name . ' Name',
		'separate_items_with_commas' => __( 'Separate ', 'bu-checkpoint' ) . strtolower( $tax_name_plural ) . __( ' with commas', 'bu-checkpoint' ),
		'add_or_remove_items'        => __( 'Add or remove ', 'bu-checkpoint' ) . strtolower( $tax_name_plural ),
		'choose_from_most_used'      => __( 'Choose from the most used ', 'bu-checkpoint' ) . strtolower( $tax_name_plural ),
		'not_found'                  => __( 'No ', 'bu-checkpoint' ) . strtolower( $tax_name ) . __( 's found.', 'bu-checkpoint' ),
		'view_item'                  => __( 'View ', 'bu-checkpoint' ) . $tax_name,
		'parent_item'                => __( 'Parent ', 'bu-checkpoint' ) . $tax_name,
	);

	$args = array(
		'public'            => true,
		'show_ui'           => false,
		'hierarchical'      => false,
		'show_admin_column' => true,
		'rewrite'           => array( 'hierarchical' => false ),
		'labels'            => $labels,
	);
	register_taxonomy( $term, BU_CHECKPOINT_CPT, $args );

	foreach ( $terms as $slug => $name ) {
		if ( ! term_exists( $slug, $term ) ) {
			wp_insert_term(
				$name,
				$term,
				array(
					'slug' => $slug,
				)
			);
		}
	}
}

function action_tax() {
	// Status
	$status             = BU_CHECKPOINT_STATUS;
	$status_name        = __( 'Status', 'bu-checkpoint' );
	$status_name_plural = __( 'Statuses', 'bu-checkpoint' );
	$status_tax         = array(
		'write'    => 'Ready to Write',
		'edit'     => 'Ready to Edit',
		'finalize' => 'Ready to Finalize',
	);

	create_tax( $status, $status_name, $status_name_plural, $status_tax );

	// Stages
	$stages             = BU_CHECKPOINT_STAGES;
	$stages_name        = __( 'Status', 'bu-checkpoint' );
	$stages_name_plural = __( 'Statuses', 'bu-checkpoint' );
	$stages_tax         = array(
		'development' => 'Development',
		'content'     => 'Content',
		'design'      => 'Design',
		'launch'      => 'Launch',
	);

	create_tax( $stages, $stages_name, $stages_name_plural, $stages_tax );
}
add_action( 'init', __NAMESPACE__ . '\\action_tax' );
