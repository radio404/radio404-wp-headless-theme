<?php

// Register Custom Post Type
function custom_post_type_podcast() {

	$labels = array(
		'name'                  => _x( 'Podcasts', 'Post Type General Name', 'radio404' ),
		'singular_name'         => _x( 'Podcast', 'Post Type Singular Name', 'radio404' ),
		'menu_name'             => __( 'Podcasts', 'radio404' ),
		'name_admin_bar'        => __( 'Podcasts', 'radio404' ),
		'archives'              => __( 'Archives des podcasts', 'radio404' ),
		'attributes'            => __( 'Attributs', 'radio404' ),
		'parent_item_colon'     => __( 'Podcast parent', 'radio404' ),
		'all_items'             => __( 'Tous les podcasts', 'radio404' ),
		'add_new_item'          => __( 'Ajouter un podcast', 'radio404' ),
		'add_new'               => __( 'Ajouter un nouveau', 'radio404' ),
		'new_item'              => __( 'Nouveau podcast', 'radio404' ),
		'edit_item'             => __( 'Éditer le podcast', 'radio404' ),
		'update_item'           => __( 'Mettre à jour le podcast', 'radio404' ),
		'view_item'             => __( 'Voir le podcast', 'radio404' ),
		'view_items'            => __( 'Voir les podcasts', 'radio404' ),
		'search_items'          => __( 'Rechercher un podcast', 'radio404' ),
		'not_found'             => __( 'Non trouvé', 'radio404' ),
		'not_found_in_trash'    => __( 'Non trouvé dans la corbeille', 'radio404' ),
		'featured_image'        => __( 'Logo', 'radio404' ),
		'set_featured_image'    => __( 'Ajouter un logo', 'radio404' ),
		'remove_featured_image' => __( 'Supprimer le logo', 'radio404' ),
		'use_featured_image'    => __( 'Utiliser commer logo', 'radio404' ),
		'insert_into_item'      => __( 'Ajouter au podcast', 'radio404' ),
		'uploaded_to_this_item' => __( 'Uploadé au podcast', 'radio404' ),
		'items_list'            => __( 'Liste de podcasts', 'radio404' ),
		'items_list_navigation' => __( 'Navigation de liste des podcasts', 'radio404' ),
		'filter_items_list'     => __( 'Filtrer la liste de podcasts', 'radio404' ),
	);
	$args = array(
		'label'                 => __( 'Podcast', 'radio404' ),
		'description'           => __( 'Podcasts', 'radio404' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 8,
		'menu_icon'             => 'dashicons-rss',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'podcast', $args );

}
add_action( 'init', 'custom_post_type_podcast', 0 );