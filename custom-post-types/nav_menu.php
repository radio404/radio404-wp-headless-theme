<?php


function rest_get_nav_menus(WP_REST_Request $request) {
	$menus = wp_get_nav_menus();
	foreach ($menus as &$menu){
		$menu_items = wp_get_nav_menu_items($menu->slug);
		$menu->items = $menu_items;
	}
	return $menus;
}

add_action( 'rest_api_init', function () {
	/**/
	register_post_type('nav_menu', array('show_in_rest' => true));
	register_rest_route( 'wp/v2', '/nav_menu', array(
		'methods' => 'GET',
		'callback' => 'rest_get_nav_menus',
	), true );
} );