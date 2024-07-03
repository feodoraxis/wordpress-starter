<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'nav_menu_item', "Дополнительно" )
	->add_fields( [
		Field::make( 'checkbox', 'is_catalog', "Меню каталога" ),
	] );