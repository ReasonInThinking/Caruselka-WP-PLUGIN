<?php

/**
 * Plugin Name: Мой Первый Текстовый Плагин
 * Description: Автоматически добавляет важный блок в конец каждого поста.
 * Version: 1.0
 * Author: IVAN
 * License: GPL2
 */

if(!defined('ABSPATH')) {
  exit;
}

function caruselka_enqueue_styles() {
  wp_enqueue_style('caruselka-style', plugin_dir_url( __FILE__ ) . 'style.css');
} add_action('wp_enqueue_scripts', 'caruselka_enqueue_styles' );


function my_first_plugin_thanks( $content ) {
    $custom_text = '<p class="caruselka-css-text">⚡ Thank You</p>';
    return $content . $custom_text;
}
add_filter( 'the_content', 'my_first_plugin_thanks' );
