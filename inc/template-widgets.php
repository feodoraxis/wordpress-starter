<?php

/**
 * Регистрация виджетов
 */

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

function widgets_init() {
	register_sidebar( [
		'name'          => 'Сайдбар блога',
		'id'            => 'sidebar-blog',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	] );
}

add_action( 'widgets_init', 'widgets_init' );