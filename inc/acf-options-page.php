<?php

if( function_exists('acf_add_options_page') ) {

	$page_title = 'Radio';
	$page_slug = 'options_radio';
	$options_page_radio = acf_add_options_page([
		'page_title'	=> $page_title,
		'menu_title'	=> $page_title,
		'menu_slug'     => $page_slug,
		'slug'          => $page_slug,
		'post_id'       => $page_slug,
		'icon_url' => 'dashicons-radio',
	]);

}