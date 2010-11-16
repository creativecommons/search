<?php
/* 
 * Featureful class for dealing with i18n localization in PHP in a standard
 * open source fashion.
 *
 * This file is used here in accordance with the GNU GPL which is copied in the 
 * COPYING file accompanying this file.
 *
 * Copyright 2006, Creative Commons.
 * Copyright 2006, Jon Phillips.
 *
 */


/**
 * This is for this local code only and is more than likely supplanted by
 * a software's own codebase.
 */
define('DEBUG', false);

/**
 * This constant is for a generic PROJECT_NAME for the project. This is 
 * primarily for testing this code out and for setting the default locale
 * preference directory. Please replace this with your project specific
 * project name constant.
 * @see CCLanguage
 * @see CCLanguage::LoadLanguages()
 * @see CCLanguage::SetLocalePref()
 * @see CCLanguage::GetLocalePref()
 */
define('CC_PROJECT_NAME', 'ccsearch');

define('CC_PROJECT_SHORT_NAME', 'ccsearch');


/* LANGUAGE DEFINES */

/** 
 * Default language is nothing so that the default strings in the code are the 
 * default. In general however, language is general english and not en_US.
 * @see CCLanguage
 */
define('CC_LANG', 'en_US');

/**
 * This constant is the default locale folder to find i18n translations.
 * @see CCLanguage
 * @see CCLanguage::LoadLanguages()
 * @see CCLanguage::CCLanguage()
 */
define('CC_LANG_LOCALE', 'locale');

/**
 * This constant is the default locale preference folder to find different
 * locale sets for possible different translations depending on installation
 * and user preference that are larger than just per-language differences of
 * i18n translations.
 * @see CCLanguage
 * @see CCLanguage::CCLanguage()
 * @see CCLanguage::LoadLanguages()
 * @see CCLanguage::SetLocalePref()
 * @see CCLanguage::GetLocalePref()
 */
define('CC_LANG_LOCALE_PREF', 'default');

/**
 * This constant is the default full path relative to an installation / web
 * root for the locale preference directory.
 * @see CCLanguage
 * @see CCLanguage::CCLanguage()
 * @see CCLanguage::LoadLanguages()
 * @see CCLanguage::SetLocalePref()
 * @see CCLanguage::GetLocalePref()
 */
define('CC_LANG_LOCALE_PREF_DIR', CC_LANG_LOCALE . '/' . CC_LANG_LOCALE_PREF);

/**
 * This constant is the domain for messages and is usually the same short
 * name for the project or package to be installed.
 * @see CCLanguage
 * @see CCLanguage::CCLanguage()
 * @see CCLanguage::LoadLanguages()
 * @see CCLanguage::SetDomain()
 * @see CCLanguage::GetDomain()
 */
define('CC_LANG_LOCALE_DOMAIN', CC_PROJECT_SHORT_NAME);

/**
 * This constant is the default full po filename.
 * @see CCLanguage
 * @see CCLanguage::SetDomain()
 * @see CCLanguage::GetDomain()
 */
define('CC_LANG_PO_FN', CC_LANG_LOCALE_DOMAIN . '.mo');


// Lame hack to bind cc_org text domain to the directory it lives in
// Is there a better place in this code for this?
bindtextdomain("cc_org", "./cc_org");

function grab_string($old_lang, $temp_lang) {
  // Totally lame non-thread-safe hack:
  // That is to say, a threading Apache MPM with PHP will enjoy race conditions with this code!
  // But hey - that's true with any use of gettext, generally speaking.

  $domain = "cc_org";
  $string_id = "lang.$temp_lang";

  putenv("LANGUAGE=$temp_lang");
  setlocale(LC_MESSAGES, "$temp_lang.utf8");
  $result = dgettext($domain, $string_id);
  putenv("LANGUAGE=$old_lang");
	setlocale(LC_MESSAGES, "$old_lang.utf8");

	if (strcmp($result, $string_id) == 0) { 
		putenv("LANGUAGE=$temp_lang");
		$result = dgettext("ccsearch", $string_id);
		putenv("LANGUAGE=$old_lang");
	}
  
  return $result;
}

/**
 * Loads all locale preference folders and languages into the 
 * $_all_languages array for use during runtime.
 *
 * @param string $locale_dir The master locale directory.
 * @param string $po_fn The master name of catalogs.
 * @return bool <code>true</code> if loads, <code>false</code> otherwise
 */
function load_languages ($locale_dir = CC_LANG_LOCALE, $po_fn = CC_LANG_PO_FN) {
  // try to head off any type of malicious search
  if ( empty($locale_dir) || $locale_dir == '/' )
    return false;

  // read in each locale preference folder
  $locale_dirs = glob( $locale_dir . '/*', GLOB_ONLYDIR ); 

  if ( count($locale_dirs) == 0 )
    return false;

  $languages = array();
  
  foreach ( $locale_dirs as $dir ) {
    // Read in each folder (language) for consideration
    $lang_dirs = glob( "$dir/*", GLOB_ONLYDIR );
    // if the locale pref. folder has no languages, then don't load it
    if ( count($lang_dirs) == 0 )
      continue;
    $locale_pref = basename($dir);
    $languages['locale'][$locale_pref] = array('path' => $dir);


    foreach ( $lang_dirs as $lang_dir ) {
      $lang_name = basename($lang_dir);
      $lower_lang_name = strtolower($lang_name); // HTTP spec says
      // this is case-insensitive

      // if there is no readable mo file, then get the hell out
      if ( is_readable( "$lang_dir/$po_fn" ) ) {
        $languages['locale'][$locale_pref]['language'][$lang_name] = array('path' => $lang_dir);
      }
    }
  }
  // TODO: Need one more check here of the array and if there is nothing
  // usable, then should return a false here and remove that bad shit from
  // the global array.

  return $languages;
}

function get_possible_languages($languages) {
  $lang_list = array_keys($languages['locale']);
  $possible_langs = array();

  foreach ( $lang_list as $item ) {
    if ($languages['locale'][$item]['language']) {
      if (strlen($item) > 2) {
        $possible_langs[$item] = $item;
      } else {
        $possible_langs[$item] = $item . "_" . strtoupper($item);
      }
      //$possible_langs[$item] = $this->_all_languages['locale'][$item]['language'];
    }
  }

  // This is dumb in that if it is selected for user preferences, it
  // inherits the master default for an installation.
  // If default is selected for the master setting, then this is 
  // set to the constant, CC_LANG, and if that setting is not available
  // or set to nothing, then the default is to use the strings in the
  // code
  // $possible_langs['default'] = _('default');
  $possible_langs[CC_LANG] = CC_LANG;
  // $possible_langs['autodetect'] = _('autodetect');

  return $possible_langs;
}

$cookieLocale = isset($_COOKIE["__ccsearch_lang"]) ? $_COOKIE["__ccsearch_lang"] : "en_US";
$queryLocale = isset($_GET['lang']) ? $_GET['lang'] : $cookieLocale; 

$locale = "$queryLocale.utf8";
setlocale(LC_MESSAGES, $locale);
putenv("LANG=$locale");
$btd = bindtextdomain("ccsearch", "./locale");
textdomain("ccsearch");


#$cc_lang = new CCLanguage($locale);
$languages = get_possible_languages(load_languages());

setcookie("__ccsearch_lang", $queryLocale, time() + 86400*30, '/', 'labs.creativecommons.org');

?>