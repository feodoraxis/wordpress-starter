<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hook: script_loader_tag
 */
function add_defer_tag_script( $tag, $handle, $source ) {
	$path = parse_url( $_SERVER['REQUEST_URI'] );
	if ( strripos( $path['path'], 'wp-admin/' ) ) {
		return $tag;
	}

	return str_replace( "'>", "' defer>", $tag );
}