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
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "board-member", $args );
}

add_action( 'init', 'cptui_register_my_cpts_board_member' );

add_shortcode('board', function($atts) {
  $query = new WP_Query( array(
      'post_type' => 'board-member',
  ) );

  while ( $query->have_posts() ) :
      $query->the_post();
      the_title();
        the_content();
  endwhile;

  /* Restore original Post Data
  * NB: Because we are using new WP_Query we aren't stomping on the
  * original $wp_query and it does not need to be reset.
  */
  wp_reset_postdata();
  return "hello, world.";
});
?>
