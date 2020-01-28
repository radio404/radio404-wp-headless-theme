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
		'rest_base'             => 'tracks',
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
	$columns['album_post_type'] = __( 'Type', 'radio404' );
	$columns['album'] = __( 'Album', 'radio404' );
	$columns['artist'] = __( 'Artiste', 'radio404' );

	return array_merge(array_slice($columns,0,1),[
		'cover' => __('Pochette', 'radio404')
	],array_slice($columns,1));}

// Add the data to the custom columns for the book post type:
add_action( 'manage_track_posts_custom_column' , 'custom_track_column', 10, 2 );
function custom_track_column( $column, $post_id ) {
	switch ( $column ) {
		case 'album_post_type':
			$column_value = get_post_meta( $post_id , $column , true );
			echo ucfirst($column_value);
			break;
		case 'cover':
			the_post_thumbnail('thumbnail',['class'=>'admin-list-cover']);
			break;
		case 'artist' :
			$artists = [];
			foreach(get_post_meta( $post_id , $column, true ) as $artist_id){
				$artist_edit_link = get_edit_post_link($artist_id);
				$artist_name = get_the_title($artist_id);
				$artists[] = "<a href='$artist_edit_link'>$artist_name</a>";
			}
			echo implode(', ',$artists);
			break;
		case 'album' :
			$column_post_id = get_post_meta( $post_id , $column , true );
			$album_title = get_the_title($column_post_id);
			$edit_link = get_edit_post_link($column_post_id);
			echo $column_post_id ? "<a href='$edit_link'>$album_title</a>" : "—";
			break;
	}
}

/*
add authors menu filter to admin post list for custom post type
*/
function restrict_manage_authors() {
	if (isset($_GET['post_type']) && post_type_exists($_GET['post_type']) && in_array(strtolower($_GET['post_type']), array('track'))) {
		wp_dropdown_users(array(
			'show_option_all'   => __('Tous les utilisateurs'),
			'show_option_none'  => false,
			'name'          => 'author',
			'selected'      => !empty($_GET['author']) ? $_GET['author'] : 0,
			'include_selected'  => false
		));
	}
}
add_action('restrict_manage_posts', 'restrict_manage_authors');

/**
 * Add extra dropdowns to the List Tables
 *
 * @param required string $post_type    The Post Type that is being displayed
 */
add_action('restrict_manage_posts', 'add_tracks_extra_tablenav');
function add_tracks_extra_tablenav($post_type){

	global $wpdb;

	/** Ensure this is the correct Post Type*/
	if($post_type !== 'track')
		return;

	/** Grab the results from the DB */
	$query = $wpdb->prepare('
        SELECT DISTINCT pm.meta_value FROM %1$s pm
        LEFT JOIN %2$s p ON p.ID = pm.post_id
        WHERE pm.meta_key = "%3$s" 
        AND p.post_status = "%4$s" 
        AND p.post_type = "%5$s"
        ORDER BY "%3$s"',
		$wpdb->postmeta,
		$wpdb->posts,
		'album_post_type', // Your meta key - change as required
		'publish',             // Post status - change as required
		$post_type
	);
	$results = $wpdb->get_col($query);

	/** Ensure there are options to show */
	if(empty($results))
		return;

	// get selected option if there is one selected
	if (isset( $_GET['album_post_type'] ) && $_GET['album_post_type'] != '') {
		$selectedAlbumPostType = $_GET['album_post_type'];
	} else {
		$selectedAlbumPostType = '';
	}

	/** Grab all of the options that should be shown */
	$options[] = sprintf('<option value="">%1$s</option>', __('Tous les types', 'radio404'));
	foreach($results as $result) :
		if ($result == $selectedAlbumPostType) {
			$selected = " selected";
		}else{
			$selected = '';
		}
		$options[] = sprintf('<option value="%1$s"'.$selected.'>%2$s</option>', esc_attr($result), $result);
	endforeach;

	/** Output the dropdown menu */
	echo '<select class="" id="album_post_type" name="album_post_type">';
	echo join("\n", $options);
	echo '</select>';

}

add_filter( 'parse_query', 'admin_tracks_filter' );
function admin_tracks_filter( $query )
{
	global $pagenow;

	if($query->query['post_type'] !== 'track') return;

	if ( is_admin() && $pagenow=='edit.php' && isset($_GET['album_post_type']) && $_GET['album_post_type'] != '') {
		$query->query_vars['meta_key'] = 'album_post_type';
		if (isset($_GET['album_post_type']) && $_GET['album_post_type'] != ''){
			$query->query_vars['meta_value'] = $_GET['album_post_type'];
		}
		//var_dump($query->query_vars);die();
	}
}

/*
function custom_columns_author($columns) {
	$columns['author'] = 'Author';
	return $columns;
}
add_filter('manage_edit-track_columns', 'custom_columns_author');
*/