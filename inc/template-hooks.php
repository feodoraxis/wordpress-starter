<?php

/**
 * В этом файле добавляем хуки к экшенам, указанным в файле template-actions.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Включает отображение ошибок на сайте, когда константа WP_DEBUG_DISPLAY_ALL === true, а пользователь -- авторизован
 *
 * @see show_errors - 10
 */
add_action( 'init', 'show_errors', 10 );