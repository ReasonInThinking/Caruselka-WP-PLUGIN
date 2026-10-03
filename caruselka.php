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

function my_html_box_shortcode($atts, $content = null) {
  ob_start();
  ?>
<form method="post" action="">
<input type="text" name="user_name" placeholder="your Name">
<input type="submit" value="Send" name="my_btn">
</form>
<?php
return ob_get_clean();
} add_shortcode('html_box', 'my_html_box_shortcode');

function my_form_listener() {
  if(isset($_POST['my_btn'])) {
    $save_name = sanitize_text_field( $_POST['user_name']);

    $redirect_url = add_query_arg( 'p', '9', $referer_url );
    wp_redirect( $redirect_url );
    exit;

  }
} add_action('init', 'my_form_listener');



function my_plugin_shortcode_caruselka() {
  return '<p style="color: red;">This Simple ShortCode Text</p>';
} add_shortcode('my_special_box', 'my_plugin_shortcode_caruselka');

function my_two_shortcode_caruselka($attr, $content = null) {
  return '<mark>' . $content . '</mark>';
} add_shortcode('two_shortcode', 'my_two_shortcode_caruselka');

function caruselka_enqueue_styles() {
  wp_enqueue_style('test-style', plugin_dir_url( __FILE__ ) . 'style.css');
} add_action('wp_enqueue_scripts', 'caruselka_enqueue_styles' );


function my_first_plugin_thanks( $content ) {
    $custom_text_one = '<div class="wp-block-image"><img src="' . plugin_dir_url( __FILE__ ) . 'elephant.jpeg" alt="Elephant"></div>';
    $custom_text_two = '<p class="caruselka-css-text">⚡ Thank You</p>';

    return $custom_text_one . $content . $custom_text_two;
}
add_filter( 'the_content', 'my_first_plugin_thanks' );
