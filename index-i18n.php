<?php

#$locale = isset($_GET['lang']) ? $_GET['lang'] : "en_US";

#$locale = "$locale.utf8";
#setlocale(LC_MESSAGES, $locale);
#putenv("LANG=$locale");
#$btd = bindtextdomain("ccsearch", "./locale");
#textdomain("ccsearch");

$use_i18n = true;

require_once('cc-defines.php');                                                                             
require_once('cc-language.php');                                                                            
require_once('cc-language-ui.php');             

//language stuff--------------                                                                              
if ($use_i18n) {
  session_start();                                                                                          
  
  // This nastiness handles session storage                                                                 
  $cc_lang = &$_SESSION['lang'];
  if (DEBUG) {
    echo "<pre>";                                                                                           
    print_r($_SESSION);                                                                                     
    echo "</pre>";
  } 
  
  if ( ! isset($cc_lang) || isset($_REQUEST['update'] ) ) {                                                 
    $cc_lang = new CCLanguage($_REQUEST['lang']);
      if (DEBUG) echo "<p>created new object</p>";                                                          
  }   
  else                                                                                                      
  {
      if (DEBUG) echo "<p>Using session language</p>";                                                      
      
      if ( isset($_REQUEST['localepref']) ) {
          $cc_lang->SetLocalePref($_REQUEST['localepref']);
          if (DEBUG) echo "<p>set new locale pref</p>";
      }

      if ( isset($_REQUEST['lang']) ) {
          $cc_lang->SetLanguage($_REQUEST['lang']);
          if (DEBUG) echo "<p>set new language</p>";
      }
  }

  $cc_lang->Init();
  $cc_lang_selector =
      new CCLanguageUISelector(&$cc_lang,
                               "<div id=\"language_selector\">",
                               "</div>", true, false);

}



?>

<!doctype html>
<? if ($use_i18n) { ?>
<html lang="<?php echo $cc_lang->get('_language_xml') ?>" xml:lang="<?php echo $cc_lang->get('_language_xml') ?>">
<? } else { ?>
<html>
<? } ?>
	<head>
		<title>CC Search</title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8" />
		<script src="jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="search.js" type="text/javascript" charset="utf-8"></script>

		<script src="elog/elog.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div id="header">
			<img src="cc-search.png" alt="CC Search" />
		</div>
		<div class="mainContent">
			<div id="search">
				<form onsubmit="return doSearch()">
					<input type="text" id="query" placeholder="<?php echo _('Enter your search query'); ?> "/>
					<div id="secondaryOptions">
						<fieldset id="permissions"> 
							<small>
								<strong><?php echo _('I want something that I can...'); ?></strong>
								<input type="checkbox" name="comm" value="" id="comm" checked="checked" onclick="setCommDeriv()" /> 
								<label for="comm"  onclick="setCommDeriv()"><?php echo _('use for <em>commercial purposes</em>'); ?>;</label>
								<input type="checkbox" name="deriv" value="" id="deriv" checked="checked"  onclick="setCommDeriv()" /> 
								<label for="deriv" onclick="setCommDeriv()"><?php echo _('<em>modify</em>, <em>adapt</em>, or <em>build upon</em>'); ?>.</label><br/> 
							</small>
						</fieldset>
						<div id="beta"><a id="betaRevert" href="http://search.creativecommons.org/?noBeta=1">Switch to previous search interface</a>
							<?php if ($use_i18n) $cc_lang_selector->output(); ?>

						</div>
					</div>
					<fieldset id="engines">
						<p style="text-align:left;"><strong><?php echo _('Search Provider:'); ?></strong></p>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="blip" id="blip"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="blip"><strong>Blip.tv</strong><br/><?php echo _('Video'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="flickr" id="flickr"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="flickr"><strong>Flickr</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="fotopedia" id="fotopedia"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="fotopedia"><strong>Fotopedia</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="google" id="google"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="google"><strong>Google</strong><br/><?php echo _('Web'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="googleimg" id="googleimg"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="googleimg"><strong>Google Images</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="jamendo" id="jamendo"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="jamendo"><strong>Jamendo</strong><br/><?php echo _('Music'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="openclipart" id="openclipart"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="openclipart"><strong>Open Clip Art Library</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="spin" id="spin"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="spin"><strong>SpinXpress</strong><br/><?php echo _('Music'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="wikimediacommons" id="wikimediacommons"><br/>&nbsp;
							</div>
							<div class="engineDesc"><label for="wikimediacommons"><strong>Wikimedia Commons</strong><br/><?php echo _('Media'); ?></label></div>
						</div>
						<p><br/><input type="submit" id="submit" value="<?php echo _('Search'); ?>" /></p>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="mainContent" style="margin-top:30px">
			<div id="help">
				<div class="column">
					<h1><br/><?php echo _('What is this?'); ?></h1>
					<p><?php echo _('Please note that search.creativecommons.org is <em>not a search engine</em>, but rather offers convenient access to search services provided by other independent organizations. CC has no control over the results that are returned. <em>Do not assume that the results displayed in this search portal are under a CC license</em>. You should always verify that the work is actually under a CC license by following the link. Since there is no registration to use a CC license, CC has no way to determine what has and hasn\'t been placed under the terms of a CC license. If you are in doubt you should contact the copyright holder directly, or try to contact the site where you found the content.'); ?></p>
				</div>
			<div class="column wrong">
				<h1><?php echo _('Remove this from my browser!'); ?></h1>
				<p><a href="http://wiki.creativecommons.org/Firefox_and_CC_Search"><?php echo _('<strong>Click here</strong></a> to find out how to change CC Search as your default search from browsers such as Firefox.'); ?></a></p>
			</div>
		</div>
		<div id="footer">
			<span id="contact-support"> 
				<a href="http://translate.creativecommons.org/projects/ccsearch"><?php echo _('Help Translate'); ?></a> 
				| 
				<a href="http://creativecommons.org/contact"> <?php echo _('Contact'); ?>               </a> 
				|
				<a href="https://creativecommons.net/donate"> <?php echo _('Donate to CC'); ?>               </a> 
				|
				<a href="http://creativecommons.org/policies"> <?php echo _('Policies'); ?>            </a> 
				|
				<a href="http://creativecommons.org/privacy"> <?php echo _('Privacy'); ?>               </a> 
				|
				<a href="http://creativecommons.org/terms"> <?php echo _('Terms of Use'); ?>               </a> 
			</span>
		</div>
	</div>
</body>
</html>

