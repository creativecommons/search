<?php

define('PROJECT_NAME', 'ccsearch');
define('DEFAULT_LANG', 'en');
define('LOCALE_DIR', getcwd() . "/locale.npk/po");

function get_active_locales() {

	$locales = array();

	// Just manually set up the default locale
	$locales['en'] = 'English';

	$h_dirs = opendir(LOCALE_DIR);
	while ( false !== ($dir = readdir($h_dirs)) ) {
		if ( is_dir(LOCALE_DIR . "/$dir") && preg_match("/^[a-z]{2,2}(_[A-Z]{2,4})?$/", $dir, $matches) ) {
			$mo_file = LOCALE_DIR . "/$dir/LC_MESSAGES/" . PROJECT_NAME . ".mo";
			if ( is_readable($mo_file) ) {
				$code = $matches[1] ? $dir : "{$dir}_" . strtoupper($dir);
				$locales[$code] = locale_get_display_language($code, $code);
			}
		}
	}

	return $locales;

}

$cookie_locale = isset($_COOKIE["__ccsearch_lang"]) ? $_COOKIE["__ccsearch_lang"] : DEFAULT_LANG;
$query_locale = isset($_GET['lang']) ? $_GET['lang'] : $cookie_locale; 

$locale = "$query_locale.UTF-8";
setlocale(LC_MESSAGES, $locale);
putenv("LANGUAGE=$locale");
putenv("LANG=$locale");
bindtextdomain(PROJECT_NAME, LOCALE_DIR);
bind_textdomain_codeset(PROJECT_NAME, 'UTF-8');
textdomain(PROJECT_NAME);

setcookie("__ccsearch_lang", $query_locale, time() + 86400*30, '/', 'labs.creativecommons.org');

?>
