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
		array(
			'key' => 'field_6a0e1a21e96ed',
			'label' => 'Sequence',
			'name' => 'sequence',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => 'This can be used to set the sequence the item has in the display. Default of -1 will display in default order. Higher numbers will display first.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => -1,
			'min' => -1,
			'max' => 50,
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'step' => 1,
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

add_filter( 'tde_plugin_posts_columns', function( $columns ) {
  $columns['price'] = __( 'Price', 'textdomain' );
  return $columns;
});

add_action( 'tde_plugin_posts_custom_column', function( $column, $post_id ) {
  if ( $column === 'price' ) {
      $price = get_post_meta( $post_id, 'price', true );
      echo esc_html( $price );
  }
}, 10, 2 );

add_action( 'quick_edit_custom_box', function( $column, $post_type ) {
  if ( $post_type !== 'board-member' || $column !== 'sequence' ) return;
  ?>
  <fieldset class="inline-edit-col-right">
      <div class="inline-edit-col">
          <label>
              <span class="title"><?php _e( 'Sequence', 'tdeplugin' ); ?></span>
              <span class="input-text-wrap">
                  <input type="text" name="sequence" value="">
              </span>
          </label>
      </div>
  </fieldset>
  <?php
}, 10, 2 );

add_action( 'save_post_board-member', function( $post_id ) {
  if ( isset( $_POST['sequence'] ) ) {
      update_post_meta( $post_id, 'sequence', sanitize_text_field( $_POST['sequence'] ) );
  }
});

add_action( 'admin_footer-edit.php', function() {
  global $typenow;
  if ( $typenow !== 'board-member' ) return;
  ?>
  <script>
  jQuery(function($){
      if (typeof inlineEditPost === 'undefined') return;

      var $wp_inline_edit = inlineEditPost.edit;
      inlineEditPost.edit = function( id ) {
          $wp_inline_edit.apply( this, arguments );
          var postId = 0;
          if ( typeof(id) == 'object' ) {
              postId = parseInt(this.getId(id));
          }
          if ( postId > 0 ) {
              var $editRow = $('#edit-' + postId);
              var sequence = $('#post-' + postId).find('td.column-sequence').text();
              $editRow.find('input[name="sequence"]').val(sequence.trim());
          }
      };
  });
  </script>
  <?php
});



add_shortcode('board', function($atts) {
/*     $the_query = new WP_Query(array(
      'post_type'         => 'board-member',
      'posts_per_page'    => -1,
      'meta_key'          => 'roles',
      'orderby'           => 'meta_value',
      'order'             => 'DESC'
    ));


    if( $the_query->have_posts() ):
      while( $the_query->have_posts() ) : $the_query->the_post();
          $result .= get_the_title();
      endwhile;
    endif;

    wp_reset_query();   // Restore global post data stomped by the_post(). */
  $posts = get_posts([
        'post_type' => 'board-member',
        'posts_per_page'    => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'sequence',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => 'sequence',
                'compare' => 'NOT EXISTS'
            )
        ),
        'order' => 'ASC',
        'orderby'           => ['meta_value_num' => 'DESC', 'title' => 'ASC'],
        'post_status' => 'publish',
    ]);
    $result = "<style>img.biopic {max-width: 200px; height: auto; margin: 1em;} img.biopic-left {float: left;} img.biopic-right {float:right}</style>";
    $result .= '<div class="presonnel boardofdirectors">';
    foreach ($posts as $i => $p) {
      $roles = implode(',',get_post_meta($posts[$i]->ID, "roles"));
      $result .= '<h2 style="margin-bottom:0.1em;">'.$p->post_title.'</h2>';
      if (isset($roles)):
        $result .= '<h3 style="font-size:1.5em;margin-top:0.1em;font-variant:smallcaps;">' . $roles . '</h3>';
      endif;
      $styles = $i % 2 == 0 ? 'biopic biopic-left' : 'biopic biopic-right';
      $result .= get_the_post_thumbnail($posts[$i]->ID, ' ', ['class' => $styles]);
      $result .= $p->post_content;
    }
    $result .= '</div>';
    return $result;
});


add_shortcode('artists', function($atts) {
  $posts = get_posts([
        'post_type' => 'artist',
        'numberposts' => 50,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'sequence',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => 'sequence',
                'compare' => 'NOT EXISTS'
            )
        ),
        'order' => 'ASC',
        'orderby'           => ['meta_value_num' => 'DESC', 'title' => 'ASC'],
        'post_status' => 'publish',
    ]);
    $result = "<style>img.biopic {max-width: 200px; height: auto; margin: 1em;} img.biopic-left {float: left;} img.biopic-right {float:right}</style>";
    $result .= '<div class="presonnel artists">';
    foreach ($posts as $i => $p) {
      $result .= '<h2>'.$p->post_title.'</h2>';
      $styles = $i % 2 == 0 ? 'biopic biopic-left' : 'biopic biopic-right';
      $result .= get_the_post_thumbnail($posts[$i]->ID, ' ', ['class' => $styles]);
      $result .= $p->post_content;// post_content
      //get_the_post_thumbnail_url($posts[0]->ID);
    }
    $result .= '</div>';
    return $result;
});
