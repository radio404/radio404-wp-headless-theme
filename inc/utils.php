<?php

function get_track_by_id( $idtrack )
{

	// grab page - polylang will take take or language selection ##
	$args = array(
		'post_status'       => 'any',
		'meta_query'        => array(
			array(
				'key'       => 'idtrack',
				'value'     => "$idtrack"
			)
		),
		'post_type'         => 'track',
		'posts_per_page'    => '1'
	);

	// run query ##
	$posts = get_posts( $args );

	// check results ##
	if ( ! $posts || is_wp_error( $posts ) ) return false;

	// test it ##
	#pr( $posts[0] );

	// kick back results ##
	return $posts[0];

}

function get_cover_by_id( $idtrack )
{

	// grab page - polylang will take take or language selection ##
	$args = array(
		'post_status'       => 'any',
		'meta_query'        => array(
			array(
				'key'       => 'idtrack',
				'value'     => "$idtrack"
			)
		),
		'post_type'         => 'attachment',
		'posts_per_page'    => '1'
	);

	// run query ##
	$query = new WP_Query($args);
	$posts = $query->posts;

	// check results ##
	if ( ! $posts || is_wp_error( $posts ) ) return false;

	// test it ##
	#pr( $posts[0] );

	// kick back results ##
	return $posts[0];

}
function get_schedule_by_id( $idschedule )
{

	// grab page - polylang will take take or language selection ##
	$args = array(
		'post_status'       => 'any',
		'meta_query'        => array(
			array(
				'key'       => 'idschedule',
				'value'     => "$idschedule"
			)
		),
		'post_type'         => 'schedule',
		'posts_per_page'    => '1'
	);

	// run query ##
	$query = new WP_Query($args);
	$posts = $query->posts;

	// check results ##
	if ( ! $posts || is_wp_error( $posts ) ) return false;

	// test it ##
	#pr( $posts[0] );

	// kick back results ##
	return $posts[0];

}

function get_cover_by_album( $album = '', $artist = '', $cover = '' )
{

	if(!$album) return false;
	// grab page - polylang will take take or language selection ##
	$args = array(
		'post_status'       => 'any',
		'meta_query'        => array(
			'relation'      => 'OR',
			[
				'key'       => 'cover',
				'value'     => "$cover",
				'compare' => 'LIKE',
			],
			'relation'      => 'OR',
			[
				[
					'key'       => 'album',
					'value'     => "$album",
					'compare' => 'LIKE',
				],
				'relation'      => 'AND',
				[
					'key'       => 'artist',
					'value'     => "$artist",
					'compare' => 'LIKE',
				],
			]
		),
		'post_type'         => 'attachment',
		'posts_per_page'    => '1'
	);

	// run query ##
	$query = new WP_Query($args);
	$posts = $query->posts;

	// check results ##
	if ( ! $posts || is_wp_error( $posts ) ) return false;

	// test it ##
	#pr( $posts[0] );

	// kick back results ##
	return $posts[0];

}

function get_album_by_title_and_artist( $title, $artist)
{

	// grab page - polylang will take take or language selection ##
	$args = array(
		'post_status'       => 'any',
		'title'        => $title,
		'meta_query'        => array(
			array(
				'key'       => 'artist_literal',
				'value'     => "$artist"
			)
		),
		'post_type'         => 'album',
		'posts_per_page'    => '1'
	);

	// run query ##
	$query = new WP_Query($args);
	$posts = $query->posts;

	// check results ##
	if ( ! $posts || is_wp_error( $posts ) ) return false;

	// test it ##
	#pr( $posts[0] );

	// kick back results ##
	return $posts[0];

}
function get_podcast_by_title( $title)
{

	// grab page - polylang will take take or language selection ##
	$args = array(
		'post_status'       => 'any',
		'title'        => $title,
		'post_type'         => 'podcast',
		'posts_per_page'    => '1'
	);

	// run query ##
	$query = new WP_Query($args);
	$posts = $query->posts;

	// check results ##
	if ( ! $posts || is_wp_error( $posts ) ) return false;

	// test it ##
	#pr( $posts[0] );

	// kick back results ##
	return $posts[0];

}
function get_artist_by_name( $name )
{

	// grab page - polylang will take take or language selection ##
	$args = array(
		'post_status'       => 'any',
		'title'        => $name,
		'post_type'         => 'artist',
		'posts_per_page'    => '1'
	);

	// run query ##
	$query = new WP_Query($args);
	$posts = $query->posts;

	// check results ##
	if ( ! $posts || is_wp_error( $posts ) ) return false;

	// test it ##
	#pr( $posts[0] );

	// kick back results ##
	return $posts[0];

}

/**
 * Insert an attachment from an URL address.
 *
 * @param  String $url
 * @param  Int    $parent_post_id
 * @param  String $title
 * @param  Array  $meta
 * @return Int    Attachment ID
 */
function insert_attachment_from_url($url, $parent_post_id = null, $title = null, $meta = []) {
	if( !class_exists( 'WP_Http' ) )
		include_once( ABSPATH . WPINC . '/class-http.php' );
	$http = new WP_Http();
	$response = $http->request( $url );
	if( $response['response']['code'] != 200 ) {
		return false;
	}
	$upload = wp_upload_bits( basename($url), null, $response['body'] );
	if( !empty( $upload['error'] ) ) {
		return false;
	}
	$file_path = $upload['file'];
	$file_name = basename( $file_path );
	$file_type = wp_check_filetype( $file_name, null );
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir = wp_upload_dir();
	$target_title = !!$title ? $title : $attachment_title;
	$post_info = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
		'post_mime_type' => $file_type['type'],
		'post_title'     => $target_title,
		'post_content'   => '',
		'post_status'    => 'inherit',
		'meta_input'     => $meta
	);
	// Create the attachment
	$attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );
	// Include image.php
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id,  $attach_data );
	return $attach_id;
}