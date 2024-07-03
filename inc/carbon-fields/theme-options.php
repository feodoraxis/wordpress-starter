<?php

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'feodoraxis_theme_options_fields', 10 );
function feodoraxis_theme_options_fields() {
	Container::make( 'theme_options', __( 'Theme Options', 'theme_options' ) )
         ->add_tab( 'Общие настройки для всех языковых версий', array(
	         Field::make( 'image', 'option-logo', 'Логотип' ),
	         Field::make( 'text', 'option-email-recall', 'E-mail для форм' ),
	         Field::make( 'text', 'option-phone', 'Телефон' ),
	         Field::make( 'text', 'option-email', 'Email' ),
	         Field::make( 'text', 'option-instagram', 'Instagram' ),
	         Field::make( 'text', 'option-youtube', 'YouTube' ),

         ) );
}