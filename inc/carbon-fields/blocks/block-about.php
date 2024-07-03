<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( 'About' )
	->set_keywords( [ 'О компании' ] )
	->add_fields( [
		Field::make( 'text', 'title', 'Заголовок' ),
		Field::make( 'rich_text', 'text', 'Текст' ),
		Field::make( 'complex', 'list', 'Вопросы и ответы' )
			->setup_labels( [
				'plural_name' => 'элемент',
				'singular_name' => 'элемент',
			] )
			->set_collapsed( true )
			->add_fields( array(
				Field::make( 'text', 'item-question', 'Вопрос' ),
				Field::make( 'rich_text', 'item-answer', 'Ответ' )
			) ),
	) )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {

		get_template_part( 'template-blocks/block', 'about', $fields );

	} );