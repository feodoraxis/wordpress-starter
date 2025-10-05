<?php

/**
 * В этом файле создаём функции-экшены, которые добавляются в хуки/фильтры из файла template-hooks.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Включает отображение ошибок на сайте, когда константа WP_DEBUG_DISPLAY_ALL === true, а пользователь -- авторизован
 *
 * Hook: init - 10
 *
 * @return void
 */
function show_errors():void {
	if ( ! is_user_logged_in() || ! defined( "WP_DEBUG_DISPLAY_ALL" ) || ( defined( "WP_DEBUG_DISPLAY_ALL" ) && WP_DEBUG_DISPLAY_ALL === false ) ) {
		return;
	}

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}