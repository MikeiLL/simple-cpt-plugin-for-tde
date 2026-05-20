<?php
/**
 * Plugin Name: Dickinson Ensemble
 * Version: 1.0.0
 * Plugin URI: https://brownsvilledigital.com
 * Description: Tools and stuff for The Dickinson Ensemble
 * Author: mzoo.org
 * Author URI: https://brownsvilledigital.com
 * Requires at least: 6.0
 * Tested up to: 6.0
 *
 * Text Domain: tdeplugin
 * Domain Path: /lang/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_theme_support( 'post-thumbnails' );

function tde_compile_post_type_labels($singular = 'Post', $plural = 'Posts') {
  $p_lower = strtolower($plural);
  $s_lower = strtolower($singular);

  return [
      'name' => $plural,
      'singular_name' => $singular,
      'add_new_item' => "New $singular",
      'edit_item' => "Edit $singular",
      'view_item' => "View $singular",
      'view_items' => "View $plural",
      'search_items' => "Search $plural",
      'not_found' => "No $p_lower found",
      'not_found_in_trash' => "No $p_lower found in trash",
      'parent_item_colon' => "Parent $singular",
      'all_items' => "All $plural",
      'archives' => "$singular Archives",
      'attributes' => "$singular Attributes",
      'insert_into_item' => "Insert into $s_lower",
      'uploaded_to_this_item' => "Uploaded to this $s_lower",
  ];
}

function cptui_register_tde_cpts() {

	/**
	 * Post Type: Board Members.
	 */

  $labels = tde_compile_post_type_labels('Board Member', 'Board Members');

	$args = [
		"label" => esc_html__( "Board Members", "tdeplugin" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "board-member", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-lightbulb",
		"supports" => [ "title", "editor", "thumbnail", "custom-fields", ],
		"show_in_graphql" => false,
	];

	register_post_type( "board-member", $args );


	/**
	 * Post Type: Artists.
	 */

   $labels = tde_compile_post_type_labels('Artist', 'Artists');

   $args = [
     "label" => esc_html__( "Artists", "tdeplugin" ),
     "labels" => $labels,
     "description" => "",
     "public" => true,
     "publicly_queryable" => true,
     "show_ui" => true,
     "show_in_rest" => true,
     "rest_base" => "",
     "rest_controller_class" => "WP_REST_Posts_Controller",
     "rest_namespace" => "wp/v2",
     "has_archive" => false,
     "show_in_menu" => true,
     "show_in_nav_menus" => true,
     "delete_with_user" => false,
     "exclude_from_search" => false,
     "capability_type" => "post",
     "map_meta_cap" => true,
     "hierarchical" => false,
     "can_export" => false,
     "rewrite" => [ "slug" => "artist", "with_front" => true ],
     "query_var" => true,
     "menu_icon" => "dashicons-megaphone",
     "supports" => [ "title", "editor", "thumbnail", "custom-fields"],
     "show_in_graphql" => false,
   ];

   register_post_type( "artist", $args );
}

add_action( 'init', 'cptui_register_tde_cpts' );

add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_6a0df490c10c3',
	'title' => 'Personnel',
	'fields' => array(
		array(
			'key' => 'field_6a0df4912cd1e',
			'label' => 'Roles',
			'name' => 'roles',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'board-member',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'artist',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	'display_title' => '',
	'allow_ai_access' => false,
	'ai_description' => '',
) );
} );



add_shortcode('board', function($atts) {
  $posts = get_posts([
        'post_type' => 'board-member',
        'numberposts' => 50,
        'post_status' => 'publish',
    ]);
    $result = "<style>img.biopic {max-width: 200px; height: auto; margin: 1em;} img.biopic-left {float: left;} img.biopic-right {float:right}</style>";
    $result .= "<div>";
    foreach ($posts as $i => $p) {
      $result .= '<h2>'.$p->post_title.'</h2>';
      //$result .= '<img src='.get_the_post_thumbnail_url($posts[0]->ID).' title="board member photo" alt="board member photo">';
      $styles = $i % 2 == 0 ? 'biopic biopic-left' : 'biopic biopic-right';
      $result .= get_the_post_thumbnail($posts[$i]->ID, ' ', ['class' => $styles]);
      $result .= $p->post_content;// post_content
      //get_the_post_thumbnail_url($posts[0]->ID);
    }
    $result .= '</div>';
    return $result;
});


add_shortcode('artists', function($atts) {
  $posts = get_posts([
        'post_type' => 'artist',
        'numberposts' => 50,
        'post_status' => 'publish',
    ]);
    $customField = get_post_meta($posts[0]->ID, "roles");
    echo "<pre>";
    print_r($customField);
    echo "</pre>";
    $result = "<style>img.biopic {max-width: 200px; height: auto; margin: 1em;} img.biopic-left {float: left;} img.biopic-right {float:right}</style>";
    $result .= "<div>";
    foreach ($posts as $i => $p) {
      $result .= '<h2>'.$p->post_title.'</h2>';
      //$result .= '<img src='.get_the_post_thumbnail_url($posts[0]->ID).' title="board member photo" alt="board member photo">';
      $styles = $i % 2 == 0 ? 'biopic biopic-left' : 'biopic biopic-right';
      $result .= get_the_post_thumbnail($posts[$i]->ID, ' ', ['class' => $styles]);
      $result .= $p->post_content;// post_content
      //get_the_post_thumbnail_url($posts[0]->ID);
    }
    $result .= '</div>';
    return $result;
});
