<?
/*
* Creative Commons has made the contents of this file
* available under a CC-GNU-GPL license:
*
* http://creativecommons.org/licenses/GPL/2.0/
*
* A copy of the full license can be found as part of this
* distribution in the file LICENSE.TXT.
* 
* You may use the ccHost software in accordance with the
* terms of that license. You agree that you are solely 
* responsible for your use of the ccHost software and you
* represent and warrant to Creative Commons that your use
* of the ccHost software will comply with the CC-GNU-GPL.
*
* $Id: cc-language.php 4284 2006-09-20 19:12:03Z fourstones $
*
*/

/**
* @package cchost
* @subpackage lang
*/

if ( file_exists('cc-defines.php') && !defined(DEBUG) )
    require_once('cc-defines.php');

/**
 * This is a class for dealing with standard gettext-based localization
 * (i18n) in php. It should be studied and used for sites that
 * want this type of support for their sites.
 *
 * LINUX/OTHER NIXES: locale setting is very sensitive based on your system,
 * installed locales, and how your .po and .mo files are formatted.
 * If your locale doesn't work on a *nix (linux, etc) system, try to do
 * a 'locale -a' from the commandline to see what locale's are installed
 * on your system. Your installed locales are usually in /usr/lib/locale and
 * are often generated from /etc/locale.gen with the locale-gen command.
 * Please consult your system to see what type of locale system is installed 
 * on your system. 
 *
 * WINDOWS: On windows machines, the 
 * locale codes are not used and the full english name of languages is used.
 * This has not been fully tested on windows systems and possibly might 
 * break. There should be a workaround in an upcoming system
 *
 */
class CCLanguage
{
    /**
     * @access private
     * @var array
     * This holds an array that points to all locale prefs (folders) and the
     * languages within these folders for access later.
     */
    var $_all_languages;
   
    /**
     * @access private
     * @var string
     * This is the currently selected language.
     */
    var $_language;

    /**
     * This is formatted string of how XML requires lang codes.
     * @var		string
     * @access	private
     */
    var $_language_xml;
    
    /**
     * @access private
     * @var string
     * The current locale preference folder selected (default is default)
     */
    var $_locale_pref;
    
    /**
     * @access private
     * @var string
     * The current domain to access strings in inside the locale .po files.
     */
    var $_domain;
    
    /**
     * @access private
     * @var string
     * The current web browsers' default autodetected language.
     */
    var $_browser_default_language;

    
    /**
     * Constructor
     * 
     * This method sets up the default language, preferences, etc for dealing
     * with languages for the entire app.
     *
     * TODO: Note that the defaults are in the file cc-defines.php at present
     * and will be moved to defaults that can be set where applicable in a 
     * user's interface.
     * 
     * @param string $language The default language
     * @param string $locale_dir The default locale master folder
     * @param string $locale The default locale preference folder
     * @param string $domain The domain to access strings with from .po files
     */
    function CCLanguage ( $override_lang = null,
			  $language   = CC_LANG,
                          $locale_dir = CC_LANG_LOCALE, 
                          $locale     = CC_LANG_LOCALE_PREF,
                          $domain     = CC_LANG_LOCALE_DOMAIN)
    {
        // CCHOST: global $CC_GLOBALS;
        // CCDebug::StackTrace();
        // CCDebug::PrintVar($CC_GLOBALS);
    
        $this->_all_languages = array();
        $this->_domain = $domain;
        $this->LoadBrowserDefaultLanguage($override_lang);
        $this->LoadLanguages( $locale_dir );
        $this->_locale_dir = $locale_dir;
  
        $this->SetLocalePref( $locale );
        
	if (empty($this->_browser_default_language)) {
	  $this->SetLanguage($language);
	} else {
	  $this->SetLanguage( $this->_browser_default_language );
	}
    }
    

    /**
     * Static function that returns boolean true if the
     * PHP get_text module is compiled into this installation
     *
     * @return bool true if installation is get_text enabled
     */
    function IsEnabled()
    {
        static $_enabled;
        if( !isset($_enabled) )
            $_enabled = function_exists('gettext');
        return $_enabled;
    }

    /**
     * Loads all locale preference folders and languages into the 
     * $_all_languages array for use during runtime.
     *
     * @param string $locale_dir The master locale directory.
     * @param string $po_fn The master name of catalogs.
     * @return bool <code>true</code> if loads, <code>false</code> otherwise
     */
    function LoadLanguages ($locale_dir = CC_LANG_LOCALE, 
                            $po_fn = CC_LANG_PO_FN) 
    {
        // try to head off any type of malicious search
        if ( empty($locale_dir) || $locale_dir == '/' )
            return false;

        // read in each locale preference folder
        $locale_dirs = glob( $locale_dir . '/*', GLOB_ONLYDIR ); 
    
        if ( count($locale_dirs) == 0 )
            return false;
    
        foreach ( $locale_dirs as $dir ) {
            // Read in each folder (language) for consideration
            $lang_dirs = glob( "$dir/*", GLOB_ONLYDIR );
            // if the locale pref. folder has no languages, then don't load it
            if ( count($lang_dirs) == 0 )
                continue;
            $locale_pref = basename($dir);
            $this->_all_languages['locale'][$locale_pref] = 
            array('path' => $dir);
	    
	    
            foreach ( $lang_dirs as $lang_dir ) {
	      $lang_name = basename($lang_dir);
	      $lower_lang_name = strtolower($lang_name); // HTTP spec says
	                                           // this is case-insensitive

	      // if there is no readable mo file, then get the hell out
		  if ( is_readable( "$lang_dir/$po_fn" ) ) {
		$this->
		  _all_languages['locale'][$locale_pref]['language'][$lang_name] =
		  array('path' => $lang_dir);
                }
            }
        }
        // TODO: Need one more check here of the array and if there is nothing
        // usable, then should return a false here and remove that bad shit from
        // the global array.
    
        return true;
    }
    
    /* MUTATORS */
    
    /**
     * This is where the default locale is set upon startup
     * of the app and where one can set the locale pref at anytime.
     * 
     * @param string $locale_pref The default locale preference directory
     * @return bool <code>true</code> if sets, <code>false</code> otherwise
     */
    function SetLocalePref ($locale_pref = CC_LANG_LOCALE_PREF)
    {
        // conditions for not attempting anything
        if ( $locale_pref == $this->_locale_pref )
            return true;
    
        // these are the various possible settings ranked in order for
        // setting this directory.
        $locale_tests = array(&$locale_pref, 
                              &$_SERVER['HTTP_HOST'], 
                              CC_PROJECT_NAME);
    
        // test to see if we can set to some default in order of the array
        foreach ( $locale_tests as $test )
        {
            if ( isset($this->_all_languages['locale'][$test]) ) {
                $this->_locale_pref = $test;
                return true;
            }
        }
    
        // NOTE: I have gone back and forth on whether or not to set this
        // I think it is wisest to set as last precaution to the default
        // and ideally also make some note in the error log stating what is up
        $this->_locale_pref = CC_LANG_LOCALE_PREF;
        return false;
    }
   
    /**
     * This method sets the current language and also the default if no
     * parameter is provided.
     *
     * @param string $lang_pref This is the language pref as 2 or 4 length code.
     * @return bool <code>true</code> if sets, <code>false</code> otherwise
     */
    function SetLanguage ($lang_pref = CC_LANG)
    {
    if ( $this->_language == $lang_pref )
        return true;
    
        $lang_possible = 
            &$this->_all_languages['locale'][$this->_locale_pref]['language'];

	// First try for a case-insensitive exact match
	
	foreach ($lang_possible as $key => $value) {
	  $lowerkey = strtolower($key);
	  $lang_pref = strtolower($lang_pref);
	  if ($lowerkey == $lang_pref) {
	    $this->_language = $key;
	    $this->_language_xml = str_replace('_', '-', $this->_language);
	    return true;
	  }
	}

	// failing that, try for a leading substring match
	
	foreach ($lang_possible as $key => $value) {
	  $lowerkey = strtolower($key);
	  $first_part_lowerkey = explode('-', $lowerkey); // PHP can't
	  // do array indexing from function return values.
	  // complaining of a syntax error.  Geez.
	  $first_part_lowerkey = $first_part_lowerkey[0];
	  $first_part_lowerkey = explode('_', $first_part_lowerkey);
	  $first_part_lowerkey = $first_part_lowerkey[0];

	  $first_part_lang_pref = explode('-', $lang_pref);
	  $first_part_lang_pref = $first_part_lang_pref[0];
	  $first_part_lang_pref = explode('_', $first_part_lang_pref);
	  $first_part_lang_pref = $first_part_lang_pref[0];

	  if ($first_part_lowerkey == $first_part_lang_pref) {
	    $this->_language = $key;
	    $this->_language_xml = str_replace('_', '-', $this->_language);
	    return true;
	  }
	}
	

        // if all else fails set it to the default
	if (DEBUG) {
	  echo "you suck, going to default<p>";
	}
        $this->_language = CC_LANG;
        $this->_language_xml = str_replace('_', '-', $this->_language);
        return false;
    }
   
    /**
     * Sets the domain for the .po files.
     * @param string $domain The domain for strings in .po files.
     */
    function SetDomain ($domain = DEFAULT_DOMAIN)
    {
        $this->_domain = $domain;
    }

    /* ACCESSORS */

    /** 
     * Gets all languages and locale prefs as an array.
     * @return array An array that looks like the one constructed by 
     * LoadLanguages()
     */
    function GetAllLanguages ()
    {
        return $this->_all_languages;
    }

    /**
     * Get the current locale preference (directory).
     * @return string The current locale preference directory
     */
    function GetLocalePref ()
    {
        return $this->_locale_pref;
    }

    /**
     * Get the current language.
     * @return string The current language
     */
    function GetLanguage()
    {
        return $this->_language;
    }

    /**
     * Get possible language as an array.
     * @param bool $inherits_parent <code>true</code> or <code>false</code>
     * @return array This is an array of possible language within the current
     * locale preference directory.
     */
    function GetPossibleLanguages()
    {
        $lang_list = array_keys($this->_all_languages['locale']);
        $possible_langs = array();

		foreach ( $lang_list as $item ) {
			if ($this->_all_languages['locale'][$item]['language']) {
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

    /**
     * Get possible locale prefs as an array.
     * @return array possible locale preferences
     */
    function GetPossibleLocalePrefs()
    {
        $locale_prefs_list = array_keys($this->_all_languages['locale']);
    // had to add this hack because array_combine() is only in php5
    $locale_prefs_list_combined = array();
    foreach ( $locale_prefs_list as $pref )
        $locale_prefs_list_combined[$pref] = $pref;
        return $locale_prefs_list_combined;
    
    }

    /**
     * Get the current domain for strings.
     * @return string The current domain
     */
    function GetDomain()
    {
        return $this->_domain;
    }

    /**
     * Loads Browser Default Language into local variable and returns if
     * already set.
     *
     * @return bool <code>true</code> if loads, <code>false</code> otherwise
     */
    function LoadBrowserDefaultLanguage($override_lang)
    {
      // return true if this is set
      if ( !empty($this->_browser_default_language) ) {
	return true;
      }
      
      if( !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) )
	{
	  // First, convert the incoming language to underscores
	  // rather than hyphens
	  $given_lang = strtr($_SERVER['HTTP_ACCEPT_LANGUAGE'], '-', '_');
	  $given_lang = strtolower($given_lang);
	  list($this->_browser_default_language) =  
	    explode(',', $given_lang, 2);
        } 
      else if ( !empty($_SERVER['HTTP_USER_AGENT']) )
        {
	  // get language from browser's user-agent
	  $browser = preg_replace("/^.*\((.*)\).*/", "\\1", 
				  $_SERVER['HTTP_USER_AGENT']);
	  list(,,,$browser_language) = explode(';', $browser);
	  $this->_browser_default_language = 
	    strtr($browser_language, '-', '_');
        }
      if ($override_lang != null) { 
	$this->_browser_default_language = strtolower($override_lang);
      }
      return !empty($this->_browser_default_language);
    }
    
    /**
     * This is where the main guts of this code takes place. I'm actually
     * splitting this out from the constructor because I think that it is
     * a better option to call this after any objects are pulled from a 
     * session variable and/or after doing some checking on the current
     * run-time setup.
     * 
     * NOTE: Setting of the locale is dependent on what locales are installed
     * on one's system: http://us2.php.net/manual/en/function.setlocale.php
     * http://www.gentoo.org/doc/en/guide-localization.xml
     */
    function Init ()
    {
        if( !CCLanguage::IsEnabled() )
        {
            //CCDebug::Log('Language is disabled, no init');
            return;
        }

        if (!isset($this->_locale_dir)) {
            $this->_locale_dir = CC_LANG_LOCALE;
        }
        $this->LoadLanguages( $this->_locale_dir );

        // set the LANGUAGE environmental variable
        // This one for some reason makes a difference FU@#$%^&*!CK
        // and when combined with bind_textdomain_codeset allows one
        // to set locale independent of server locale setup!!!
        if ( false == putenv("LANGUAGE=" . $this->_language ) )
            if (DEBUG) 
                echo (sprintf("Could not set the ENV variable LANGUAGE = %s",
                             $this->_language));

        // set the LANG environmental variable
        if ( false == putenv("LANG=" . $this->_language ) )
            if (DEBUG) 
                echo (sprintf("Could not set the ENV variable LANG = %s", 
                             $this->_language));

        // if locales are not installed in locale folder, they will not
        // get set! This is usually in /usr/lib/locale
        // Also, the backup language should always be the default language
        // because of this...see the NOTE in the class description

        // Try first what we want but with the .utf8, which is what the locale
        // setting on most systems want (and is most compatible
        // Then just try the standard lang encoding asked for, and then if 
        // all else fails, just try the default language
        // LC_ALL is said to be used, but it has nasty usage in some languages
        // in swapping commas and periods! Thus try LC_MESSAGE if on one of
        // those systems.
        // It is supposedly not defined on WINDOWS, so am including it here
        // for possible uncommenting if a problem is shown
        //
        // if (!defined('LC_MESSAGES')) define('LC_MESSAGES', 6);
        // yes, setlocale is case-sensitive...arg
        $locale_set = setlocale(LC_ALL, $this->_language . ".utf8", 
                        $this->_language . ".UTF8",
                        $this->_language . ".utf-8",
                        $this->_language . ".UTF-8",
                        $this->_language, 
                        CC_LANG);
        // if we don't get the setting we want, make sure to complain!
        if ( ( $locale_set != $this->_language && CC_LANG == $locale_set) || 
             empty($locale_set) )
        {
            if (DEBUG)
                echo (
                sprintf("Tried: setlocale to '%s', but could only set to '%s'.",                        $this->_language, $locale_set) );
        }
        
        $bindtextdomain_set = bindtextdomain($this->_domain, 
                                  CC_LANG_LOCALE . "/" . $this->_locale_pref );
        if ( empty($bindtextdomain_set) )
            if (DEBUG) 
                echo (
                sprintf("Tried: bindtextdomain, '%s', to directory, '%s', " . 
                        "but received '%s'",
                        $this->_domain, CC_LANG_LOCALE . "/" . $this->_locale_pref,
                        $bindtextdomain_set) );

        // This is the magic key to not being bound by a system locale
        if ( "UTF-8" != bind_textdomain_codeset($this->_domain, "UTF-8") )
        {
            if (DEBUG)
                echo (
                sprintf("Tried: bind_textdomain_codeset '%s' to 'UTF-8'",
                        $this->_domain));
        }

        $textdomain_set = textdomain($this->_domain);
        if ( empty($textdomain_set) )
        {
            if (DEBUG) 
                echo(sprintf("Tried: set textdomain to '%s', but got '%s'",
                                 $this->_domain, $textdomain_set));
        }

        // Basically need to init all the language stuff here...
        // need the following for lang. encoding standards...arg
        
        // CCHOST: $CC_GLOBALS['lang_locale_pref'] = &$this->_locale_pref;
        // TODO: should replace this with a singleton...
        // CCHOST: $CC_GLOBALS['language'] = &$this;
        
        // $this->DebugLanguages();
    
    } // end of method Init ()

    /**
     * Gets NIX system locales 
     * @returns array array of possible locales on a system
     */
    function GetSystemLocales()
    {
        exec('locale -a', $system_locales); /* if need -> $retval); */
        return $system_locales;
    }

    
    /**
     * This method is for generically testing what is happening inside
     * of this object.
     */
    function DebugLanguages ()
    {
        // CCHOST: global $CC_GLOBALS;
        echo "<pre>";
        // print_r( $this->_all_languages );
        print_r( $this );
        // print_r( $CC_GLOBALS );
        echo ( $this->_language );
        // get system locals and print them out
        // print_r($this->GetSystemLocales());
        echo "</pre>";
    }

    /**
     * Basic accessor.
     */
    function set ($var_name, $value)
    {
        $this->$var_name = $value;
    }

    function get ($var_name)
    {
        return $this->$var_name;
    } 
    // got rid of OnInitApp()

} // end of CCLanguage class

?>
