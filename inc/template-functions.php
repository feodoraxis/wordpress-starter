<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param $arr
 * @param  bool  $is_hide
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
 * Подключение стилей и скриптов из приложения на React.js на базе его manifest.json
 * Необходим именно такой способ, т.к. при каждой сборке react.js создает новые файлы css и js с новыми названиями,
 * которые фиксируются в manifest.json
 *
 * @param  string  $manifest_directory  use get_template_directory()
 * @param  string  $manifest_file_name
 * @param  string  $enqueue_name
 */
function enqueue_from_reactjs_manifest(
	string $manifest_directory,
	string $manifest_file_name,
	string $enqueue_name = 'tournament-table'
):void {
	$manifest_link = $manifest_directory . $manifest_file_name;

	$manifest = file_get_contents( $manifest_link );
	if ( $manifest === false ) {
		return;
	}

	$manifest = json_decode( $manifest, true );
	if ( ! isset( $manifest['entrypoints'] ) || empty( $manifest['entrypoints'] ) || ! is_array( $manifest['entrypoints'] ) ) {
		return;
	}

	foreach ( $manifest['entrypoints'] as $entrypoint ) {
		if ( strripos( $entrypoint, '.css' ) ) {
			wp_enqueue_style( $enqueue_name,
				$manifest_directory . $entrypoint,
				array(),
				'1.0',
				false );
		} elseif ( strripos( $entrypoint, '.js' ) ) {
			wp_enqueue_script( $enqueue_name,
				$manifest_directory . $entrypoint,
				array(),
				'1.0',
				false );
		}
	}
}

/**
 * @param  mixed  $arr
 */
function debug( mixed $arr ):void {
	$f = fopen( $_SERVER["DOCUMENT_ROOT"] . "/debug.txt", "a+" );
	fwrite( $f, print_r( [ $arr ], true ) );
	fclose( $f );
}

function feodoraxis_log( string $name, string $request, $data ):void {
	if ( isset( $_SERVER['HTTP_HOST'] ) && strripos( $_SERVER['HTTP_HOST'], 'rugby.loc' ) ) {
		return;
	}

	$db_logs = new wpdb( 'user_rugby_logs', '-1hHc|BYe-E:WzT{', 'user_rugby_logs', 'localhost' );

	$db_logs->insert( 'rugby_ru', [
			'name'    => $name,
			'request' => $request,
			'file'    => __FILE__,
			'data'    => $data,
		], [
			'%s',
			'%s',
			'%s',
			'%s',
		] );
	//	$content = $name . "\n\r";
	//	$content .= "Запрос: " . $request . "\n\r";
	//	$content .= "Date: " . date( "Y-m-d H:i:s" ) . "\n\r";
	//	$content .= "File: " . __FILE__ . "\n\r";
	//	$content .= $data . "\n\r\n\r---------------------------------------";
	//
	//	$file_name = "mtg_log_" . date( "Y-m-d H:i:s" ) . '.txt';
	//	$file_dir = '/home/user/web/new.rugby.ru/mtg_logs';//$_SERVER["DOCUMENT_ROOT"] . "/../mtg_logs";
	//	if ( ! is_dir( $file_dir ) ) {
	//		return;
	//	}
	//
	//	file_put_contents( $file_dir . "/" . $file_name, print_r( $content, true ) );
	//	$f = fopen( $_SERVER["DOCUMENT_ROOT"] . "/../mtg_logs/{$file_name}", "a+" );
	//	fwrite( $f, print_r( $content, true ) );
	//	fclose( $f );
}

/**
 * @param $number
 * @param $after
 *
 * @return string
 */
function plural_format_word( $number, $after ):string {
	$cases = [ 2, 0, 1, 1, 1, 2 ];

	return $number . ' ' . $after[ ( $number % 100 > 4 && $number % 100 < 20 ) ? 2 : $cases[ min( $number % 10, 5 ) ] ];
}

/**
 * @param  string  $date  - use international format
 * @param  string  $date_format  - use needle format. You can use it like in function date()
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

function calculate_age( $date_birthday ) {
	$date     = new DateTime( $date_birthday );
	$now      = new DateTime();
	$interval = $now->diff( $date );

	return $interval->y;
}

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

	if ( $add_year === true || date( "Y" ) > date( "Y", $date_unix ) ) {
		$output .= ' ' . date( "Y", $date_unix );
	}

	return $output;
}

function translit( $s ):string {
	$s = (string) $s;
	$s = strip_tags( $s );
	$s = str_replace( array( "\n", "\r" ), " ", $s );
	$s = preg_replace( "/\s+/", ' ', $s );
	$s = trim( $s );
	$s = function_exists( 'mb_strtolower' ) ? mb_strtolower( $s ) : strtolower( $s );
	$s = strtr( $s, array(
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
	) );
	$s = preg_replace( "/[^0-9a-z-_ ]/i", "", $s );
	$s = str_replace( " ", "-", $s );

	return $s;
}

/**
 * @param $title
 * @param $data
 *
 * @return string
 */
function create_message( $title, $data ):string {
	$time = date( 'd.m.Y в H:i' );

	$message = "
            <!doctype html>
                <html>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                        <title>{$title}</title>
                        <style>
                            div, p, span, strong, b, em, i, a, li, td, th {
                                -webkit-text-size-adjust: none;
                            }
                            td, th{
                            	vertical-align:middle
                            }
                        </style>
                    </head>
                    
                    <body>
                        
                        <table width='500' cellspacing='0' cellpadding='5' border='1' bordercolor='1' style='border:solid 1px #000;border-collapse:collapse;'>
                            <caption align='center' bgcolor='#fafafa' border='1' bordercolor='1' style='border:solid 1px #000;border-collapse:collapse;background:#dededd;padding:10px 0'><b>{$title}</b></caption>";

	foreach ( $data as $key => $val ) {
		if ( $val != '' ) {
			$message .= '<tr><td bgcolor="#fbfbfb" style="background:#efeeee">' . $key . ':</td><td>' . $val . '</td>';
		}
	}

	$ip      = $_SERVER['REMOTE_ADDR'];
	$message .= "<tr><td bgcolor='#fbfbfb' style='background:#fbfbfb'>Дата:</td><td>{$time}</td></tr><tr><td bgcolor='#fbfbfb' style='background:#fbfbfb'>IP:</td><td>{$ip}</td></tr>";

	$message .= "</table></body></html>";

	return $message;
}

/**
 * @param  array  $items  = array(
 *                              array(
 *                                  'name' => 'Front page',
 *                                  'link' => '/',
 *                              ),
 *                              array(
 *                                  'name' => 'News',
 *                              ),
 *                          )
 * @param  bool  $to_return
 *
 * @return string|void
 */
function breadcrumbs_render( array $items, bool $to_return = false, array $classes = array() ) {
	if ( empty( $items ) ) {
		return;
	}

	$classes = implode( ' ',
		array_merge( array( 'breadcrumps' ),
			$classes ) );

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

function wp_corenavi() {
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

function link2hyperlink( string $link ):string {
	$link = str_replace( array(
		'//',
		'http:',
		'https:',
	), '', $link );

	return 'https://' . $link;
}

/**
 * @param  string  $dir_name
 * @param  string  $file_prefix
 */
function feodoraxis_autoloader( string $dir_name, string $file_prefix ):void {
	$files = scandir( get_template_directory() . $dir_name );

	foreach ( $files as $file ) {
		if ( strripos( $file, $file_prefix . '-' ) > - 1 && strripos( $file,
				'.php' ) && file_exists( get_template_directory() . $dir_name . $file )
		) {
			require_once get_template_directory() . $dir_name . $file;
		}
	}
}