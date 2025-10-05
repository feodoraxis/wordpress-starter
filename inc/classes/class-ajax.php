<?php

/**
 * Абстрактный класс для Ajax-запросов.
 *
 * Создайте дочерний от этого класс в этой папке с постфиксом Ajax,
 * укажите в нём константу ACTION_NAME с названием экшена ajax-запроса
 * и опишите функцию action - которая и будет исполнена при обращении по ajax
 */

namespace Feodoraxis;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Ajax {

	public function __construct( array $actions = [ 'wp_ajax', 'wp_ajax_nopriv' ] ) {
		if ( in_array( 'wp_ajax', $actions ) ) {
			add_action( 'wp_ajax_' . static::ACTION_NAME, [ $this, 'action' ] );
		}

		if ( in_array( 'wp_ajax_nopriv', $actions ) ) {
			add_action( 'wp_ajax_nopriv_' . static::ACTION_NAME, [ $this, 'action' ] );
		}
	}

	abstract public function action():void;

	public function is_ajax():bool {
		return $_SERVER['REQUEST_METHOD'] === 'POST' && wp_doing_ajax();
	}
}