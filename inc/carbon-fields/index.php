<?php

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

add_action( 'after_setup_theme', 'crb_load', 1 );
function crb_load() {
	if ( ! file_exists( __DIR__ . '/../../vendor/autoload.php' ) ) {
		return;
	}

	require_once( __DIR__ . '/../../vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}

require_once __DIR__ . "/theme-options.php";

if ( file_exists( __DIR__ . "/fields/index.php" ) ) {
	require_once __DIR__ . "/fields/index.php";
}

if ( file_exists( __DIR__ . "/blocks/index.php" ) ) {
	require_once __DIR__ . "/blocks/index.php";
}

if ( file_exists( __DIR__ . "/widgets/index.php" ) ) {
    require_once __DIR__ . "/widgets/index.php";
}