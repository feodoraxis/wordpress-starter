<?php

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

//function load_widgets() {
//    register_widget( 'Blog_Categories' );
//}
//add_action( 'widgets_init', 'load_widgets' );

function widgets_init() {
	register_sidebar( array(
		'name'          => 'Сайдбар блога',
		'id'            => 'sidebar-blog',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}

add_action( 'widgets_init', 'widgets_init' );