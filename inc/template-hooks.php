<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @see add_defer_tag_script
 */
add_filter( 'script_loader_tag', 'add_defer_tag_script', 10, 3 );