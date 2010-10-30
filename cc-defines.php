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

