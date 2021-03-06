<?php

// Register Custom Post Type
function custom_post_type_schedule() {

	$labels = array(
		'name'                  => _x( 'Programmations', 'Post Type General Name', 'radio404' ),
		'singular_name'         => _x( 'Programmation', 'Post Type Singular Name', 'radio404' ),
		'menu_name'             => __( 'Programmations', 'radio404' ),
		'name_admin_bar'        => __( 'Programmations', 'radio404' ),
		'archives'              => __( 'Archives des programmations', 'radio404' ),
		'attributes'            => __( 'Attributs', 'radio404' ),
		'parent_item_colon'     => __( 'Programmation parente', 'radio404' ),
		'all_items'             => __( 'Toutes les programmations', 'radio404' ),
		'add_new_item'          => __( 'Ajouter une programmation', 'radio404' ),
		'add_new'               => __( 'Ajouter une nouvelle', 'radio404' ),
		'new_item'              => __( 'Nouvelle programmation', 'radio404' ),
		'edit_item'             => __( 'Éditer le programmation', 'radio404' ),
		'update_item'           => __( 'Mettre à jour la programmation', 'radio404' ),
		'view_item'             => __( 'Voir la programmation', 'radio404' ),
		'view_items'            => __( 'Voir les programmations', 'radio404' ),
		'search_items'          => __( 'Rechercher une programmation', 'radio404' ),
		'not_found'             => __( 'Non trouvée', 'radio404' ),
		'not_found_in_trash'    => __( 'Non trouvée dans la corbeille', 'radio404' ),
		'featured_image'        => __( 'Vignette', 'radio404' ),
		'set_featured_image'    => __( 'Ajouter une vignette', 'radio404' ),
		'remove_featured_image' => __( 'Supprimer la vignette', 'radio404' ),
		'use_featured_image'    => __( 'Utiliser comme vignette', 'radio404' ),
		'insert_into_item'      => __( 'Ajouter à la programmation', 'radio404' ),
		'uploaded_to_this_item' => __( 'Uploadé à la programmation', 'radio404' ),
		'items_list'            => __( 'Liste de programmations', 'radio404' ),
		'items_list_navigation' => __( 'Navigation de liste des programmations', 'radio404' ),
		'filter_items_list'     => __( 'Filtrer la liste de programmations', 'radio404' ),
	);
	$args = array(
		'label'                 => __( 'Label', 'radio404' ),
		'description'           => __( 'Labels', 'radio404' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'revisions', 'custom-fields' ),
		'taxonomies'            => [],
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		'rest_base'             => 'schedules',
	);
	register_post_type( 'schedule', $args );

}
add_action( 'init', 'custom_post_type_schedule', 0 );

function rest_schedule_collection_params($query_params){
	// list any schedule
	$query_params['status']['default']='any';
	return $query_params;
}

add_filter('rest_schedule_collection_params','rest_schedule_collection_params');