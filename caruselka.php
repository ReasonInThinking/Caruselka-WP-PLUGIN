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

    // Проверяем, есть ли в URL параметр успеха из обработчика
    if ( isset( $_GET['form_success'] ) ) {
        echo '<p style="color: green;">Данные успешно отправлены!</p>';
    }

    // Получаем значение, которое вводили (если нужно оставить его в поле при ошибке)
    $user_name = isset( $_POST['user_name'] ) ? sanitize_text_field( $_POST['user_name'] ) : '';
    ?>
    <form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">

        <!-- Защита Nonce: создает скрытое поле для проверки безопасности -->
        <?php wp_nonce_field( 'my_form_action', 'my_form_nonce' ); ?>

        <!-- Передаем реферер, чтобы обработчик знал, куда вернуть пользователя -->
        <?php wp_referer_field( true ); ?>

        <input type="text" name="user_name" placeholder="Your Name" value="<?php echo esc_attr( $user_name ); ?>">
        <input type="submit" value="Отправить" name="my_btn">
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('html_box', 'my_html_box_shortcode');


function my_form_listener() {
    // 1. Проверяем, была ли нажата кнопка
    if ( ! isset( $_POST['my_btn'] ) ) {
        return;
    }

    // 2. Проверяем Nonce-защиту (если проверка провалена — выполнение остановится)
    if ( ! isset( $_POST['my_form_nonce'] ) || ! wp_verify_nonce( $_POST['my_form_nonce'], 'my_form_action' ) ) {
        wp_die( 'Ошибка безопасности: запрос отклонен.' );
    }

    // 3. Обрабатываем данные
    $save_name = sanitize_text_field( $_POST['user_name'] );

    // Здесь ваша логика сохранения (например, в базу данных)

    // 4. Получаем URL из скрытого поля реферера (безопасно)
    $redirect_url = wp_get_referer() ? wp_get_referer() : home_url();

    // 5. Добавляем флаг успеха и делаем БЕЗОПАСНЫЙ редирект
    $redirect_url = add_query_arg( 'form_success', '1', $redirect_url );

    wp_safe_redirect( $redirect_url );
    exit;
}
add_action('init', 'my_form_listener');






function my_plagin_name($atts) {
  $chosen_size = $atts['font-size'] ?? '20px';
  $chosen_color = $atts['color'] ?? 'green';
  $chosen_text = $atts['text'] ?? "USER TEXT";
  return '<p style="font-size: ' . $chosen_size . '; color: ' . $chosen_color . ';">' .  $chosen_text . '</p>';
}
add_shortcode('my_plagin_name', 'my_plagin_name');






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
