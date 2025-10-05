<?php

/**
 * Тут указываем все настройки и регистрации темы
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'search-form' );
add_theme_support( 'gallery' );
add_theme_support( 'caption' );
add_theme_support( 'widgets' );

register_nav_menus( [
	'main-menu' => __( "Main menu" )
] );

/*
 * WordPress-Starter - is dir-name of this starter. If you change dir name - you need change name here to.
 */
load_theme_textdomain( 'WordPress-Starter', get_template_directory() . '/langs' );

add_image_size( 'post-preview', 150, 150, true );