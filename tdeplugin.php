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
function cptui_register_my_cpts_board_member() {

	/**
	 * Post Type: Board Members.
	 */

	$labels = [
		"name" => esc_html__( "Board Members", "custom-post-type-ui" ),
		"singular_name" => esc_html__( "Board Member", "custom-post-type-ui" ),
	];

	$args = [
		"label" => esc_html__( "Board Members", "custom-post-type-ui" ),
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
		"supports" => [ "title", "editor", "thumbnail", ],
		"show_in_graphql" => false,
	];

	register_post_type( "board-member", $args );
}

add_action( 'init', 'cptui_register_my_cpts_board_member' );

add_shortcode('board', function($atts) {
  $posts = get_posts([
        'post_type' => 'board-member',
        'numberposts' => 20,
        'post_status' => 'publish',
    ]);
/*
(
    [0] => WP_Post Object
        (
            [ID] => 473
            [post_author] => 1
            [post_date] => 2026-05-19 22:32:51
            [post_date_gmt] => 2026-05-19 22:32:51
            [post_content] =>
Mike iLL Kilmer the bugout bla bla  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus non fringilla nisl. Curabitur ex turpis, pellentesque at viverra non, tempor ut turpis. Etiam id vehicula metus, eu porttitor magna. Vivamus non malesuada felis. Quisque sodales ligula neque, nec aliquet tortor malesuada venenatis. Suspendisse potenti. Nunc sit amet sodales ex. Aenean ut ultrices purus. Suspendisse sit amet nibh ex. Curabitur nibh nisl, suscipit condimentum dolor a, accumsan luctus enim.





Also bla  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus non fringilla nisl. Curabitur ex turpis, pellentesque at viverra non, tempor ut turpis. Etiam id vehicula metus, eu porttitor magna. Vivamus non malesuada felis. Quisque sodales ligula neque, nec aliquet tortor malesuada venenatis. Suspendisse potenti. Nunc sit amet sodales ex. Aenean ut ultrices purus. Suspendisse sit amet nibh ex. Curabitur nibh nisl, suscipit condimentum dolor a, accumsan luctus enim.



            [post_title] => Mike iLL Kilmer
            [post_excerpt] =>
            [post_status] => publish
            [comment_status] => closed
            [ping_status] => closed
            [post_password] =>
            [post_name] => mike-ill-kilmer
            [to_ping] =>
            [pinged] =>
            [post_modified] => 2026-05-19 22:32:51
            [post_modified_gmt] => 2026-05-19 22:32:51
            [post_content_filtered] =>
            [post_parent] => 0
            [guid] => http://the-dickinson-ensemble.local/?post_type=board-member&p=473
            [menu_order] => 0
            [post_type] => board-member
            [post_mime_type] =>
            [comment_count] => 0
            [filter] => raw
        )

)
*/
    $result = "<style>img.biopic {max-width: 200px; height: auto; float: left;}</style>";
    $result .= "<div>";
    foreach ($posts as $p) {
      $result .= '<h2>'.$p->post_title.'</h2>';
      //$result .= '<img src='.get_the_post_thumbnail_url($posts[0]->ID).' title="board member photo" alt="board member photo">';
      $result .= get_the_post_thumbnail($posts[0]->ID, ' ', ['class' => 'biopic']);
      $result .= $p->post_content;// post_content
      //get_the_post_thumbnail_url($posts[0]->ID);
    }
    $result .= '</div>';
    return $result;
});
