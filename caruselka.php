<?php

/**
 * Plugin Name: My Dev Plugin
 * Description: Auto adds text to the end of the article.
 * Version: Alfa-Test 1.0
 * Author: IVAN
 * License: GPL2
 */

if(!defined('ABSPATH')) {
  exit;
}


function my_plugin_shortcode_caruselka() {
  return '<p style="color: red;">This Simple ShortCode Text</p>';
} add_shortcode('my_special_box', 'my_plugin_shortcode_caruselka');



function caruselka_enqueue_styles() {
  wp_enqueue_style('caruselka-style', plugin_dir_url( __FILE__ ) . 'style.css');
} add_action('wp_enqueue_scripts', 'caruselka_enqueue_styles' );


function my_first_plugin_thanks( $content ) {
    $custom_text_one = '<p class="caruselka-css-text">⚡ Hello! </p>';
    $custom_text_two = '<p class="caruselka-css-text">⚡ Thank You</p>';

    return $custom_text_one . $content . $custom_text_two;
}
add_filter( 'the_content', 'my_first_plugin_thanks' );
