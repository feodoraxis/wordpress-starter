<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="tagline" content="https://feodoraxis.ru/">
    <meta name="author" content="Andrei Smorodin @feodoraxis">
    <meta name="theme-color" content="#FFF">
	<?php wp_head(); ?>
</head>
<body>

<?php

wp_nav_menu( [
	'theme_location' => 'menu_main',
	'menu_class'     => '',
	'container'      => false,
] );

?>