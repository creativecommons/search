<?php

define('PROJECT_NAME', 'ccsearch');
define('DEFAULT_LANG', 'en');
define('LOCALE_DIR', getcwd() . "/locale/po");

/**
 * An "active" locale is simply one with a compiled PO file.
 * Getting a language to show up in the select box should be
 * as simple as:
 * 
 * $ cd ./locale/po/<lang>/LC_MESSAGES/
 * $ msgfmt -o ccsearch.mo ccsearch.po
 *
 */
function get_active_locales() {

	$locales = array();

	// Just manually set up the default locale
	$locales['en'] = 'English';

	$h_dirs = opendir(LOCALE_DIR);
	while ( false !== ($dir = readdir($h_dirs)) ) {
		if ( is_dir(LOCALE_DIR . "/$dir") && preg_match("/^[a-z]{2,2}(_[A-Z]{2,4})?$/", $dir, $matches) ) {
			$mo_file = LOCALE_DIR . "/$dir/LC_MESSAGES/" . PROJECT_NAME . ".mo";
			if ( is_readable($mo_file) ) {
				$locales[$dir] = locale_get_display_language($dir, $dir);
			}
		}
	}

	asort($locales);

	return $locales;

}

$cookie_locale = isset($_COOKIE["__ccsearch_lang"]) ? $_COOKIE["__ccsearch_lang"] : DEFAULT_LANG;
$query_locale = isset($_GET['lang']) ? $_GET['lang'] : $cookie_locale; 

// Different systems store locales with different names.  So take advantage of
// setlocale()'s ability to take multiple fall-back locale names to maximize
// the chance that we get one right.  If $query_locale has an underscore, then
// also try everything before the underscore.  If it doesn't have an
// underscore, then try to add one and append $query_locale again, which will
// work in a lot of cases, since frequently the ISO code of the lang is the
// same as for the region.  If neither xx nor xx_XX turn out to be valid, then
// fetch a list of all the locales on the system and just grab the first one
// that matches '/^$query_locale/'.

// Don't bother with these any of these shenanigans if the lang is English.
if ( $query_locale != 'en' ) {
	$locales = array();
	$locales[] = "{$query_locale}.utf8";
	if ( $_pos = strpos($query_locale, '_') ) {
		$locales[] = substr($query_locale, 0, $_pos) . '.utf8';
	} else {
		$locales[] = "{$query_locale}_" . strtoupper($query_locale) . ".utf8";
	}

	// Try to set the locale as either xx or xx_XX.  This should work in
	// >75% of the cases.
	$locale = setlocale(LC_MESSAGES, $locales);

	// If we still don't have a valid locale then just pick the first one
	// that matches at all.  The user never sees this locale.
	if ( ! $locale ) {
		// Get a list of all the available UTF system locales.
		exec('locale -a | grep utf8', $sys_locales);
		foreach ( $sys_locales as $sys_locale ) {
			if ( preg_match("/^{$query_locale}/", $sys_locale, $loc_matches) ) {
				$locale = setlocale(LC_MESSAGES, $sys_locale);
				break;
			}
		}
	}
}

putenv("LANGUAGE=$locale");
putenv("LANG=$locale");
bindtextdomain(PROJECT_NAME, LOCALE_DIR);
bind_textdomain_codeset(PROJECT_NAME, 'UTF-8');
textdomain(PROJECT_NAME);

setcookie("__ccsearch_lang", $query_locale, time() + 86400*30, '/', 'labs.creativecommons.org');

?>
