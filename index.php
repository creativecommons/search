<?php
include('i18n.php');
?>

<!doctype html>
<html lang="<?= $queryLocale ?>">
	<head>
		<title>CC Search</title>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

		<link rel="search" type="application/opensearchdescription+xml" title="Creative Commons Search Beta" href="http://labs.creativecommons.org/demos/search/ccsearch.xml">
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
						<div id="beta"><!-- <a id="betaRevert" href="http://search.creativecommons.org/?noBeta=1">Switch to previous search interface</a>
							<br/> -->
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
							<div class="engineDesc"><label for="spin"><strong>SpinXpress</strong><br/><?php echo _('Media'); ?></label></div>
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
					<h1><?php echo _('What is this?'); ?></h1>
					<p><?php echo _('Please note that search.creativecommons.org is <em>not a search engine</em>, but rather offers convenient access to search services provided by other independent organizations. CC has no control over the results that are returned. <em>Do not assume that the results displayed in this search portal are under a CC license</em>. You should always verify that the work is actually under a CC license by following the link. Since there is no registration to use a CC license, CC has no way to determine what has and hasn\'t been placed under the terms of a CC license. If you are in doubt you should contact the copyright holder directly, or try to contact the site where you found the content.'); ?></p>
				</div>
			<div class="column">
				<div id="remove" class="wrong">	
					<h1><?php echo _('Remove this from my browser!'); ?></h1>
					<p><a href="http://wiki.creativecommons.org/Firefox_and_CC_Search"><?php echo _('<strong>Click here</strong></a> to find out how to change CC Search as your default search from browsers such as Firefox.'); ?></a></p>
				</div>
				<div id="add" class="wrong">
					<h1><?php echo _('Add this to my browser!'); ?></h1>
					<p><a href="#" id="addOpenSearch"><strong>Add the ability</strong></a> to use CC Search from your browser's <span id="addressBar">address</span><span id="searchBar">search</span> bar.</p>
					<p><b>Todo:</b> Add some more description here.</p>
				</div>

				<div id="translations" class="wrong">
					<h1>Translations
						<select name="lang" id="lang">
							<?php
							foreach ($languages as $key => $value) {
								$selected = "";
								if ($value . ".utf8" == $locale) $selected = "selected";

								$lang_name = grab_string($queryLocale, $key);
								print '<option value="'.$value.'"'.$selected.'>'.$lang_name.'</option>';
							}
							?>
						</select>
					</h1>
				</div>
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

