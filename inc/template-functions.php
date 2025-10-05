<?php

/**
 * Все функции, которые нужны в теме
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Отображение содержимого переменных в удобном виде
 *
 * @param  $arr
 */
function d( ...$arr ) {
	echo '<pre style="color: red;background: yellow;">';

	if ( count( $arr ) === 1 ) {
		$arr = $arr['0'];
		var_dump( $arr );
	} else {
		foreach ( $arr as $item ) {
			var_dump( $item );
			echo '<hr >';
		}
	}

	echo "</pre>";
}

/**
 * Запись данных переменной $arr в файл debug.txt в корне сайта.
 * Бывает удобно, когда нужно увидеть результат фонового исполнения скрипта
 *
 * @param  mixed  $arr
 */
function debug( mixed $arr ):void {
	$f = fopen( $_SERVER["DOCUMENT_ROOT"] . "/debug.txt", "a+" );
	fwrite( $f, print_r( [ $arr ], true ) );
	fclose( $f );
}

/**
 * Вывод слова во множественном числе, в зависимости от переданной цифры
 *
 * @param  int    $number
 * @param  array  $after
 *
 * @return string
 */
function plural_format_word( int $number, array $after ):string {
	$cases = [ 2, 0, 1, 1, 1, 2 ];

	return $number . ' ' . $after[ ( $number % 100 > 4 && $number % 100 < 20 ) ? 2 : $cases[ min( $number % 10, 5 ) ] ];
}

/**
 * Изменить формат даты
 *
 * @param  string  $date         - указываем международный формат
 * @param  string  $date_format  - указываем формат, который хотим получить. Принимает тоже самое, что функция date()
 *
 * @return string
 */
function change_date_format( string $date, string $date_format ):string {
	if ( empty( $date ) || empty( $date_format ) ) {
		return '';
	}

	$_date = strtotime( $date );

	return date( $date_format, $_date );
}

/**
 * Подсчёт количества лет с даты рождения до текущей, либо указанной даты
 *
 * @param  string  $date_birthday - день рождения
 * @param  string  $now - дата, на момент которой нужно получить количество лет
 *
 * @return null|int
 */
function calculate_age( string $date_birthday, string $now = '' ):?int {
	try {
		if ( $now === '' ) {
			$now = new DateTime();
		} else {
			$now = new DateTime( $now );
		}

		$date     = new DateTime( $date_birthday );
		$interval = $now->diff( $date );

		return $interval->y;
	} catch ( \Exception $e ) {
		return null;
	}
}

/**
 * Получить дату в российском формате
 *
 * @param  string  $date - дата в международном формате
 * @param  bool    $add_year - указать год в конце или нет
 *
 * @return string
 */
function get_russian_date_format( string $date, bool $add_year = false ):string {
	if ( empty( $date ) ) {
		return '';
	}

	$date_unix = strtotime( $date );

	$output = date( "d", $date_unix ) . ' ';
	$output .= match ( intval( date( "m", $date_unix ) ) ) {
		1 => 'января',
		2 => 'февраля',
		3 => 'марта',
		4 => 'апреля',
		5 => 'мая',
		6 => 'июня',
		7 => 'июля',
		8 => 'августа',
		9 => 'сентября',
		10 => 'октября',
		11 => 'ноября',
		12 => 'декабря',
	};

	if ( $add_year === true ) {
		$output .= ' ' . date( "Y", $date_unix );
	}

	return $output;
}

/**
 * Транслитерация строки из кириллицы в латиницу
 *
 * @param  string  $s
 *
 * @return string
 */
function translit( string $s ):string {
	$s = (string) $s;
	$s = strip_tags( $s );
	$s = str_replace( [ "\n", "\r" ], " ", $s );
	$s = preg_replace( "/\s+/", ' ', $s );
	$s = trim( $s );
	$s = function_exists( 'mb_strtolower' ) ? mb_strtolower( $s )
		: strtolower( $s );
	$s = strtr( $s, [
		'а' => 'a',
		'б' => 'b',
		'в' => 'v',
		'г' => 'g',
		'д' => 'd',
		'е' => 'e',
		'ё' => 'e',
		'ж' => 'j',
		'з' => 'z',
		'и' => 'i',
		'й' => 'y',
		'к' => 'k',
		'л' => 'l',
		'м' => 'm',
		'н' => 'n',
		'о' => 'o',
		'п' => 'p',
		'р' => 'r',
		'с' => 's',
		'т' => 't',
		'у' => 'u',
		'ф' => 'f',
		'х' => 'h',
		'ц' => 'c',
		'ч' => 'ch',
		'ш' => 'sh',
		'щ' => 'shch',
		'ы' => 'y',
		'э' => 'e',
		'ю' => 'yu',
		'я' => 'ya',
		'ъ' => '',
		'ь' => '',
	] );
	$s = preg_replace( "/[^0-9a-z-_ ]/i", "", $s );
	$s = str_replace( " ", "-", $s );

	return $s;
}

/**
 * Функция для рендеринга хлебных крошек
 *
 * @param  array{
 *     name:string,
 *     link:string
 * }[]            $items
 * @param  bool   $to_return
 * @param  array  $classes
 *
 * @return string|void
 */
function breadcrumbs_render( array $items, bool $to_return = false, array $classes = [] ) {
	if ( empty( $items ) ) {
		return;
	}

	$classes = implode( ' ', array_merge( [ 'breadcrumps' ], $classes ) );

	$output   = '<ol class="' . $classes . '" itemscope itemtype="http://schema.org/BreadcrumbList">';
	$position = 1;
	foreach ( $items as $key => $item ) {
		$output .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';

		if ( isset( $items[ $key + 1 ] ) && isset( $item['link'] ) && ! empty( $item['link'] ) ) {
			$output .= "<a itemprop=\"item\" href=\"{$item['link']}\">";
			$output .= "<span itemprop=\"name\">{$item['name']}</span>";
			$output .= '</a>';
			$output .= "<meta itemprop=\"position\" content=\"" . $position . "\" />";
		} else {
			$output .= "<span itemprop=\"name\">{$item['name']}</span>";
			$output .= "<meta itemprop=\"position\" content=\"" . $position . "\" />";
		}

		$position ++;
		$output .= '</li>';
	}

	$output .= '</ol>';

	if ( $to_return === true ) {
		return $output;
	}

	echo $output;
}

/**
 * Отображение пагинации на странице записей или архива
 *
 * @return void
 */
function wp_corenavi():void {
	global $wp_query, $wp_rewrite;

	$pages = '';
	$max   = $wp_query->max_num_pages;

	if ( ! $current = get_query_var( 'paged' ) ) {
		$current = 1;
	}

	$a['base']     = str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) );
	$a['total']    = $max;
	$a['current']  = $current;
	$a['show_all'] = false;

	$total          = 0;
	$a['mid_size']  = 2;
	$a['end_size']  = 2;
	$a['prev_text'] = false;
	$a['next_text'] = false;

	if ( $max > 1 ) {
		echo '<div class="pagination"><ul>';
	}

	echo $pages . paginate_links( $a );

	if ( $max > 1 ) {
		echo '</ul>
            </div>';
	}
}

/**
 * Конвертация ссылки в единый формат
 *
 * @param  string  $link
 * @param  string  $format
 *
 * @return string
 */
function link2hyperlink( string $link, string $format = 'https' ):string {
	$link = str_replace( [
		'//',
		'http:',
		'https:',
	], '', $link );

	return ( $format === 'https' ? 'https' : 'http' ) . '://' . $link;
}

/**
 * Функция автозагрузки файлов из определенной директории
 *
 * @param  string  $dir_name
 * @param  string  $file_prefix
 */
function feodoraxis_autoloader( string $dir_name, string $file_prefix ):void {
	$files = scandir( get_template_directory() . $dir_name );

	foreach ( $files as $file ) {
		if ( strripos( $file, $file_prefix . '-' ) > - 1 && strripos( $file, '.php' ) && file_exists( get_template_directory() . $dir_name . $file ) ) {
			require_once get_template_directory() . $dir_name . $file;
		}
	}
}