<?php

include('i18n.php');
$languages = get_active_locales();

?>

<!doctype html>
<html lang="<?= $query_locale ?>">
	<head>
		<title>CC Search</title>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

		<link rel="search" type="application/opensearchdescription+xml" title="Creative Commons Search Beta" href="http://labs.creativecommons.org/demos/search/ccsearch.xml">
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	
		<!--[if lte IE 7]>
		<link rel="stylesheet" href="style-ie.css" type="text/css" media="screen" charset="utf-8" />
		<![endif]-->

		<script src="jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="search.js" type="text/javascript" charset="utf-8"></script>

		<script src="elog/elog.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div id="header">
			<div id="header_logo">
				<img src="cc-search.png" alt="CC Search" />
				<div id="header_text"><span style="color: white;"><?php echo _('Find content you can share, use and remix'); ?></span></div>
			</div>
<div style="position:absolute; left: 10px; top: 0px; padding: 1px 10px 0 10px; margin:4px 0 0 0; background-color: #223212; color:#fbff00; -webkit-box-shadow: 0 1px 0 rgba(120, 178, 62, 0.5), inset 0 2px 3px rgba(0, 0, 0, 0.45); text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.5); -webkit-border-radius: 10px; -moz-border-radius:10px; height:20px; -moz-box-shadow: 0 1px 0 rgba(120, 178, 62, 0.5), inset 0 2px 3px rgba(0, 0, 0, 0.45);" id="switcher"><a id="betaSwitch" href="http://search.creativecommons.org/?noBeta=1" style="color:#fbff00;">Switch to tabbed search interface</a></div>
		</div>
		<div class="mainContent">
			<div id="search">
				<form id="search_form" onsubmit="return doSearch()">
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
					</div>
					<fieldset id="engines">
						<p style="text-align:left;"><strong><?php echo _('Search using'); ?>:</strong></p>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="blip" id="blip">
							</div>
							<div class="engineDesc"><label for="blip"><strong>Blip.tv</strong><br/><?php echo _('Video'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="flickr" id="flickr">
							</div>
							<div class="engineDesc"><label for="flickr"><strong>Flickr</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="fotopedia" id="fotopedia">
							</div>
							<div class="engineDesc"><label for="fotopedia"><strong>Fotopedia</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="google" id="google">
							</div>
							<div class="engineDesc"><label for="google"><strong>Google</strong><br/><?php echo _('Web'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="googleimg" id="googleimg">
							</div>
							<div class="engineDesc"><label for="googleimg"><strong>Google Images</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="jamendo" id="jamendo">
							</div>
							<div class="engineDesc"><label for="jamendo"><strong>Jamendo</strong><br/><?php echo _('Music'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="openclipart" id="openclipart">
							</div>
							<div class="engineDesc"><label for="openclipart"><strong>Open Clip Art Library</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="spin" id="spin">
							</div>
							<div class="engineDesc"><label for="spin"><strong>SpinXpress</strong><br/><?php echo _('Media'); ?></label></div>
						</div>
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="wikimediacommons" id="wikimediacommons">
							</div>
							<div class="engineDesc"><label for="wikimediacommons"><strong>Wikimedia Commons</strong><br/><?php echo _('Media'); ?></label></div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="mainContent" style="margin-top:30px">
			<div id="help">
				<div class="column">
					<p><?php echo _('Please note that search.creativecommons.org is <em>not a search engine</em>, but rather offers convenient access to search services provided by other independent organizations. CC has no control over the results that are returned. <em>Do not assume that the results displayed in this search portal are under a CC license</em>. You should always verify that the work is actually under a CC license by following the link. Since there is no registration to use a CC license, CC has no way to determine what has and hasn\'t been placed under the terms of a CC license. If you are in doubt you should contact the copyright holder directly, or try to contact the site where you found the content.'); ?></p>
				</div>
			<div class="column">
				<div id="remove" class="wrong">
					<p><?php echo _('<a href="#" id="addOpenSearch"><strong>Add CC Search</strong></a> to your browser.'); ?></strong></p>
					<p><?php echo _('<a href="http://wiki.creativecommons.org/Firefox_and_CC_Search"><strong>Learn how</strong></a> to switch to or from CC Search in your Firefox search bar.'); ?></a></>
				</div>

				<div>
						<select name="lang" id="lang">
							<?php
							foreach ( $languages as $code => $name ) {
								$selected = ("{$code}.UTF-8" == $locale) ? 'selected="selected"' : '';
								echo "<option value='$code' $selected>$name</option>\n";
							}
							?>
						</select>
				</div>
			</div>
		</div>
		<div id="footer">
			<span id="contact-support"> 
				<a href="http://www.transifex.net/projects/p/CC/"><?php echo _('Help Translate'); ?></a> 
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
				|
				<a href="http://wiki.creativecommons.org/CC_Search#Developers"> <?php echo _('Developers'); ?>               </a> 
			</span>
		</div>
	</div>
</body>
</html>

