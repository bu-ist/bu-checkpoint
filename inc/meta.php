<?php
/**
 * Custom Meta
 *
 * @package bu-checkpoint
 */

namespace BU\Plugins\Checkpoint\Meta;

/**
 * Utility function to get the meta keys.
 *
 * @return array Meta keys.
 */
function get_meta_keys() {
	return array(
		'bu_checkpoint_post_id',
		'bu_checkpoint_comments',
		'bu_checkpoint_stage',
		'bu_checkpoint_status',
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
				'show_in_rest'  => true,
				'type'          => 'string',
				'single'        => true,
				'auth_callback' => function() {
					return current_user_can( 'edit_other_pages' );
				},
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\\init_register_meta' );

function register_meta_fields() {
	$meta = get_meta_keys();
	foreach ( $meta as $key ) {
		register_rest_field(
			BU_CHECKPOINT_CPT,
			$key,
			array(
				'get_callback'    => __NAMESPACE__ . 'get_meta' . $key,
				'update_callback' => __NAMESPACE__ . 'update_meta' . $key,
				'schema'          => array(),
			)
		);
	}
}
add_action( 'rest_api_init', __NAMESPACE__ . '\\register_meta_fields' );

function get_meta_bu_checkpoint_post_id( $_post ) {

	return post_meta( $_post->ID, 'bu_checkpoint_post_id', true );
}

function update_meta_bu_checkpoint_post_id( $value, $post, $key ) {
	$update = update_post_meta( $post->id, $key, $value );

	if ( false === $update ) {
		return new \WP_Error(
			'checkpoint_post_id-update-failed',
			__( 'Checkpoint Post ID meta update faled' ),
			array( 'status' => 500 )
		);
	}

	return true;
}
