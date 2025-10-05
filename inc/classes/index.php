<?php

/**
 * Автозагрузка всех классов.
 *
 * Если есть абстрактный или другой класс,
 * который должен быть загружен первым
 * - укажите его явно, как в примере с class-ajax.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-ajax.php';

feodoraxis_autoloader( "/inc/classes/", "class" );