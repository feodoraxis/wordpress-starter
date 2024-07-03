<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
function enqueue_scripts() {
    wp_enqueue_style( 'app', get_template_directory_uri() . '/assets/css/app.min.css', [], '1.0', false );

    wp_deregister_script( 'jquery' );
    wp_enqueue_script( 'ymaps', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU', [], '1.0', true );
    wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/js/app.min.js', [ 'ymaps' ], '1.0', true );
}