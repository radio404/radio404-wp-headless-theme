<?php

// Register Custom Post Type
function custom_post_type_track() {

	$labels = array(
		'name'                  => _x( 'Morceaux', 'Post Type General Name', 'radio404' ),
		'singular_name'         => _x( 'Morceau', 'Post Type Singular Name', 'radio404' ),
		'menu_name'             => __( 'Morceaux', 'radio404' ),
		'name_admin_bar'        => __( 'Morceaux', 'radio404' ),
		'archives'              => __( 'Archives des morceaux', 'radio404' ),
		'attributes'            => __( 'Attributs', 'radio404' ),
		'parent_item_colon'     => __( 'Morceau parent', 'radio404' ),
		'all_items'             => __( 'Tous les morceaux', 'radio404' ),
		'add_new_item'          => __( 'Ajouter un morceau', 'radio404' ),
		'add_new'               => __( 'Ajouter un nouveau', 'radio404' ),
		'new_item'              => __( 'Nouveau morceau', 'radio404' ),
		'edit_item'             => __( 'Éditer le morceau', 'radio404' ),
		'update_item'           => __( 'Mettre à jour le morceau', 'radio404' ),
		'view_item'             => __( 'Voir le morceau', 'radio404' ),
		'view_items'            => __( 'Voir les morceaux', 'radio404' ),
		'search_items'          => __( 'Rechercher un morceau', 'radio404' ),
		'not_found'             => __( 'Non trouvé', 'radio404' ),
		'not_found_in_trash'    => __( 'Non trouvé dans la corbeille', 'radio404' ),
		'featured_image'        => __( 'Pochette d\'album', 'radio404' ),
		'set_featured_image'    => __( 'Ajouter une pochette d\'album', 'radio404' ),
		'remove_featured_image' => __( 'Supprimer la pochette d\'album', 'radio404' ),
		'use_featured_image'    => __( 'Utiliser comme pochette d\'album', 'radio404' ),
		'insert_into_item'      => __( 'Ajouter au morceau', 'radio404' ),
		'uploaded_to_this_item' => __( 'Uploadé au morceau', 'radio404' ),
		'items_list'            => __( 'Liste de morceaux', 'radio404' ),
		'items_list_navigation' => __( 'Navigation de liste des morceaux', 'radio404' ),
		'filter_items_list'     => __( 'Filtrer la liste de morceaux', 'radio404' ),
	);
	$args = array(
		'label'                 => __( 'Label', 'radio404' ),
		'description'           => __( 'Labels', 'radio404' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'genre' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-format-audio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'track', $args );

}
add_action( 'init', 'custom_post_type_track', 0 );


// Add the custom columns to the book post type:
add_filter( 'manage_track_posts_columns', 'set_custom_edit_track_columns' );
function set_custom_edit_track_columns($columns) {
	//unset( $columns['taxonomy-genre'] );
	//unset( $columns['date'] );
	$columns['author'] = __('Géré par','radio404');
	$columns['album'] = __( 'Album', 'radio404' );
	$columns['artist'] = __( 'Artiste', 'radio404' );

	return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_track_posts_custom_column' , 'custom_track_column', 10, 2 );
function custom_track_column( $column, $post_id ) {
	switch ( $column ) {
		case 'cover':
			break;
		case 'artist' :
			$column_post_id = get_post_meta( $post_id , $column , true );
			echo $column_post_id ? get_the_title($column_post_id) : '-';
			break;
		case 'album' :
			the_post_thumbnail('thumbnail',['class'=>'admin-list-cover']);
			$column_post_id = get_post_meta( $post_id , $column , true );
			echo ' ';
			echo $column_post_id ? get_the_title($column_post_id) : '-';
			break;
	}
}

/*
add authors menu filter to admin post list for custom post type
*/
function restrict_manage_authors() {
	if (isset($_GET['post_type']) && post_type_exists($_GET['post_type']) && in_array(strtolower($_GET['post_type']), array('track', 'track_2'))) {
		wp_dropdown_users(array(
			'show_option_all'   => __('Afficher tous'),
			'show_option_none'  => false,
			'name'          => 'author',
			'selected'      => !empty($_GET['author']) ? $_GET['author'] : 0,
			'include_selected'  => false
		));
	}
}
add_action('restrict_manage_posts', 'restrict_manage_authors');

/*
function custom_columns_author($columns) {
	$columns['author'] = 'Author';
	return $columns;
}
add_filter('manage_edit-track_columns', 'custom_columns_author');
*/