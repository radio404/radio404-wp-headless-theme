<?php

// Register Custom Post Type
function custom_post_type_album() {

	$labels = array(
		'name'                  => _x( 'Albums', 'Post Type General Name', 'radio404' ),
		'singular_name'         => _x( 'Album', 'Post Type Singular Name', 'radio404' ),
		'menu_name'             => __( 'Albums', 'radio404' ),
		'name_admin_bar'        => __( 'Albums', 'radio404' ),
		'archives'              => __( 'Archives des albums', 'radio404' ),
		'attributes'            => __( 'Attributs', 'radio404' ),
		'parent_item_colon'     => __( 'Album parent', 'radio404' ),
		'all_items'             => __( 'Tous les albums', 'radio404' ),
		'add_new_item'          => __( 'Ajouter un nouvel album', 'radio404' ),
		'add_new'               => __( 'Ajouter', 'radio404' ),
		'new_item'              => __( 'Nouvel album', 'radio404' ),
		'edit_item'             => __( 'Éditer', 'radio404' ),
		'update_item'           => __( 'Mettre à jour', 'radio404' ),
		'view_item'             => __( 'Voir', 'radio404' ),
		'view_items'            => __( 'Voir les albums', 'radio404' ),
		'search_items'          => __( 'Rechercher un album', 'radio404' ),
		'not_found'             => __( 'Non trouvé', 'radio404' ),
		'not_found_in_trash'    => __( 'Non trouvé dans la corbeille', 'radio404' ),
		'featured_image'        => __( 'Pochette d’album', 'radio404' ),
		'set_featured_image'    => __( 'Ajouter une pochette d’album', 'radio404' ),
		'remove_featured_image' => __( 'Supprimer la pochette d’album', 'radio404' ),
		'use_featured_image'    => __( 'Utiliser comme pochette d’album', 'radio404' ),
		'insert_into_item'      => __( 'Ajouter à l\'album', 'radio404' ),
		'uploaded_to_this_item' => __( 'Téléchargé', 'radio404' ),
		'items_list'            => __( 'Liste d\'albums', 'radio404' ),
		'items_list_navigation' => __( 'Navigation de liste d\'albums', 'radio404' ),
		'filter_items_list'     => __( 'Filtrer les albums', 'radio404' ),
	);
	$args = array(
		'label'                 => __( 'Album', 'radio404' ),
		'description'           => __( 'Albums, groupes, musiciens', 'radio404' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'genre' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-album',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'album', $args );

}
add_action( 'init', 'custom_post_type_album', 0 );