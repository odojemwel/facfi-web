<?php

if ( ! function_exists( 'tt4_child_enqueue_styles' ) ) :
  function tt4_child_enqueue_styles() {
    wp_enqueue_style( 'tt4-child-style', get_stylesheet_uri() );
  }
endif;
add_action( 'wp_enqueue_scripts', 'tt4_child_enqueue_styles' );


if ( ! function_exists( 'tt4_child_setup') ) :
function tt4_child_setup() {
  add_editor_style( get_stylesheet_uri() );
}
endif;
add_action( 'after_setup_theme', 'tt4_child_setup' );


if ( ! function_exists( 'meta_block_post_permalink' )) :
function meta_block_post_permalink( $block_content, $attributes, $block, $post_id, $object_type ) {
  $field_name = $attributes['fieldName'] ?? '';

  if ( '' === $field_name){
    return $block_content;
  }

  if ( 'post_link' === $field_name ) {
    $post_url = esc_url(get_the_permalink($post_id));
    $block_content = "<a href=\"{$post_url}\" class=\"post-card\">";
  }

  return $block_content;
}
endif;
add_filter( 'meta_field_block_get_block_content', 'meta_block_post_permalink' , 10, 5);

if ( ! function_exists( 'custom_button_url_shortcode' )) :
  function custom_button_url_shortcode($attributes) {
    $attributes = shortcode_atts(
      array(
        'page' => ''
      ),
      $attributes
    );

    $base_url = rtrim(home_url(), '/');

    if ( ! in_array($attributes['page'], array( "board-of-directors", "fr-aloysius-philip-schwartz" ) ) ) {
      return '';
    }

    $full_url = esc_url("$base_url/about-us/{$attributes['page']}");
    $content = "<a href=\"$full_url\" style=\"text-decoration: none;\">";
    return $content;

  }
endif;
add_shortcode( 'custom_button_url', 'custom_button_url_shortcode' );