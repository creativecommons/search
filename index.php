<?php

include('i18n.php');
$languages = get_active_locales();

/**
 * If $engine is set in the request, then the user must have javascript turned
 * off, else they would have gone directly to the search site, and not back to
 * index.php.  This block handles those who don't uses javascript for whatever
 * reason.
 */
if ( isset($_REQUEST['engine']) && $_REQUEST['query'] != "" ) {

	$engine = $_REQUEST['engine'];
	$query = $_REQUEST['query'];
	$comm = isset($_REQUEST['comm']) ? TRUE : FALSE;
	$deriv = isset($_REQUEST['deriv']) ? TRUE : FALSE;
        
	// We never want the search to execute with the default text
	if ( $query == "Enter search query" ) {
		$query = "flowers";
	}

	$rights = modRights($engine, $comm, $deriv);

	$url = "";
        
	switch ( $engine ) {

		case "openclipart":
			$url = 'http://openclipart.org/search/?query=' . $query;
			break;

		case "spin":
			$url = 'http://www.spinxpress.com/getmedia' . $rights . '_searchwords=' . $query;
			break;

		case "jamendo":
			$url = 'http://www.jamendo.com/tag/' . $query . '?' . $rights . '&location_country=all&order=rating_desc';
			break;

		case "flickr":
			$url = 'http://flickr.com/search/?' . $rights . '&q=' . $query;
			break;

		case "wikimediacommons":
			$url = 'http://commons.wikimedia.org/w/index.php?title=Special%3ASearch&redirs=0&search=' . $query . '&fulltext=Search&ns0=1&ns6=1&ns14=1&title=Special%3ASearch&advanced=1&fulltext=Advanced+search';
			break;

		case "fotopedia":
			$url = 'http://www.fotopedia.com/search?q=' . $query . '&human_license=' . $rights;
			break;

		case "europeana":
			$url = 'http://www.europeana.eu/portal/brief-doc.html?start=1&view=table&query=' . $query . $rights;
			break;

		case "youtube":
			$url = 'http://www.youtube.com/results?search_query=' . $query . ',creativecommons';
			break;

		case "googleimg":
			$url = 'http://images.google.com/images?q=';

		case "google":
		default:
			$url = $url ? $url : 'http://google.com/search?q=';
			$url .= $query . '&as_rights=' . $rights;
			break;

	}

	header('Location: ' . $url);
	exit;

}

/**
 * Sets up the right query string for the various content providers.
 */
function modRights($engine, $comm, $deriv) {
        
	$rights = "";

	switch ( $engine ) {

		case "google":
		case "googleimg":

			$rights = "(cc_publicdomain|cc_attribute|cc_sharealike";
			$extra_rights = ".-(";

			if ( $comm ) {
				$extra_rights .= "cc_noncommercial";
			} else {
				$rights .= "|cc_noncommercial";
			}

			if ( $deriv ) {
				$extra_rights .= $comm ? "|cc_nonderived" : "cc_nonderived";
			} else {
				$rights .= "|cc_nonderived";
			}

			$rights .= ")";

			if ( $extra_rights != ".-(" ) {
				$extra_rights .= ")";
				$rights .= $extra_rights;
			}
			
			break;

		case "flickr":
			$rights = "l=";
			$rights .= $comm ? "comm" : "";
			$rights .= $deriv ? "deriv" : "";
			$rights = ($rights == "l=") ? "l=cc" : $rights;
			break;

		case "jamendo":
			$rights .= $comm ? "license_minrights_c=on&" : "";
			$rights .= $deriv ? "license_minrights_d=on" : "";
			break;

		case "spin":
			$rights = "_license=";
			if ( ! $comm && ! $deriv ) {
				$rights .= "11"; // by-nd,by-nc-nd,by-nc-,by-nc-sa
			} else if ( $comm && ! $deriv ) {
				$rights .= "8"; // by-nd
			} else if ( ! $comm && $deriv ) {
				$rights .= "9";
			} else { 
				$rights .= "10"; // by-nc,by-nc-sa
			}
			break;

		case "fotopedia":
			if ( $comm && $deriv ) {
				$rights = "reuse_commercial_modify";
			} else if ( $comm && ! $deriv ) {
				$rights = "reuse_commercial";
			} else if ( ! $comm && $deriv ) {
				$rights = "reuse_modify";
			} else {
				$rights = "reuse";
			}
			break;

		case "europeana":
			if ( $comm && $deriv ) {
				$rights = "+AND+europeana_rights%3A*creative*+AND+NOT+europeana_rights%3A*nc*+AND+NOT+europeana_rights%3A*nd*";
			} else if ( $comm && ! $deriv ) {
				$rights = "+AND+europeana_rights%3A*creative*+AND+NOT+europeana_rights%3A*nc*";
			} else if ( ! $comm && $deriv ) {
				$rights = "+AND+europeana_rights%3A*creative*+AND+NOT+europeana_rights%3A*nd*";
			} else {
				$rights = "+AND+europeana_rights%3A*creative*+";
			}
			break;

	}

	return $rights;

}
    // adaptor code for cc-wp theme
    if ( ! function_exists('bloginfo') ) {
        function bloginfo ($param) {
            if ( $param == 'home' )
                print 'http://creativecommons.org';
            if ( $param == 'stylesheet_directory' ) {
                // print $theme_path . '/cc-wp';
                print '/cc-wp';
            }
        }
    }
    if ( ! function_exists('get_http_security') ) {
        function get_http_security () {
            echo 'https';
        }
    }
    include 'cc-wp/meta.php';
    include 'cc-wp/header-doctype.php'; ?>
<html lang="<?php echo $query_locale ?>">
	<head>
		<title>CC Search</title>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <?php include 'cc-wp/header-common.php'; ?>

		<link rel="search" type="application/opensearchdescription+xml" title="Creative Commons Search" href="http://search.creativecommons.org/ccsearch.xml" />
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	
		<!--[if lte IE 7]>
		<link rel="stylesheet" href="style-ie.css" type="text/css" media="screen" charset="utf-8" />
		<![endif]-->

		<script src="jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="search.js" type="text/javascript" charset="utf-8"></script>

		<script src="elog/elog.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
	<div id="container">
        <?php include 'cc-wp/page-nav.php'; ?>
        <div id="main" role="main">
            <div class="container">
                <div class="sixteen columns">

		<div class="first row">
			<div id="search">
				<form id="search_form" method="get" onsubmit="return doSearch()">
            <div class="sixteen columns">
            <div class="five columns alpha">
			<div id="header_logo">
				<img src="cc-search.png" alt="CC Search" />
				<div id="header_text"><span style="color: white;"><?php echo _('Find content you can share, use and remix'); ?></span></div>
			</div>
            </div>
            <div class="eleven columns omega">
					<input type="text" id="query" name="query" placeholder="<?php echo _('Enter your search query'); ?> "/>
					<div id="secondaryOptions">
						<fieldset id="permissions"> 
							<small>
                                <div class="eleven columns">
                                <div class="four columns alpha">
								<strong><?php echo _('I want something that I can...'); ?></strong>
                                </div>

                                <div class="seven columns omega">
								<input type="checkbox" name="comm" value="" id="comm" checked="checked" onclick="setCommDeriv()" /> 
								<label for="comm"  onclick="setCommDeriv()"><?php echo _('use for <em>commercial purposes</em>'); ?>;</label>
								<input type="checkbox" name="deriv" value="" id="deriv" checked="checked"  onclick="setCommDeriv()" /> 
								<label for="deriv" onclick="setCommDeriv()"><?php echo _('<em>modify</em>, <em>adapt</em>, or <em>build upon</em>'); ?>.</label><br/> 
                                </div>
                                </div>
							</small>
						</fieldset>
					</div>
                    </div>
                    </div>

                    <div class="engineer">
					<fieldset id="engines">
						<p style="text-align:left;"><strong><?php echo _('Search using'); ?>:</strong></p>
                        <div class="sixteen columns">
                        <div class="first row">
                        <div class="four columns alpha">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="europeana" id="europeana">
							</div>
							<div class="engineDesc"><label for="europeana"><strong>Europeana</strong><br/><?php echo _('Media'); ?></label></div>
						</div>
                        </div>
                        <div class="four columns">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="flickr" id="flickr">
							</div>
							<div class="engineDesc"><label for="flickr"><strong>Flickr</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
                        </div>
                        <div class="four columns">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="fotopedia" id="fotopedia">
							</div>
							<div class="engineDesc"><label for="fotopedia"><strong>Fotopedia</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
                        </div>
                        <div class="four columns omega">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="google" id="google">
							</div>
							<div class="engineDesc"><label for="google"><strong>Google</strong><br/><?php echo _('Web'); ?></label></div>
						</div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="four columns alpha">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="googleimg" id="googleimg">
							</div>
							<div class="engineDesc"><label for="googleimg"><strong>Google Images</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
                        </div>
                        <div class="four columns">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="jamendo" id="jamendo">
							</div>
							<div class="engineDesc"><label for="jamendo"><strong>Jamendo</strong><br/><?php echo _('Music'); ?></label></div>
						</div>
                        </div>
                        <div class="four columns">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="openclipart" id="openclipart">
							</div>
							<div class="engineDesc"><label for="openclipart"><strong>Open Clip Art Library</strong><br/><?php echo _('Image'); ?></label></div>
						</div>
                        </div>
                        <div class="four columns omega">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="spin" id="spin">
							</div>
							<div class="engineDesc"><label for="spin"><strong>SpinXpress</strong><br/><?php echo _('Media'); ?></label></div>
						</div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="four columns alpha">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="wikimediacommons" id="wikimediacommons">
							</div>
							<div class="engineDesc"><label for="wikimediacommons"><strong>Wikimedia Commons</strong><br/><?php echo _('Media'); ?></label></div>
						</div>
                        </div>
                        <div class="four columns">
						<div class="engine">
							<div class="engineRadio">
								<input type="radio" onclick="setEngine(this)" name="engine" value="youtube" id="youtube">
							</div>
							<div class="engineDesc"><label for="youtube"><strong>YouTube</strong><br/><?php echo _('Video'); ?></label></div>
						</div>
                        </div>
                        </div>
                        </div>
					</fieldset>
                    </div>
				</form>
                </div>
			</div>
		</div>
		<div class="row">
			<div id="help">
                <div class="eight columns alpha">
					<p><?php echo _('Please note that search.creativecommons.org is <em>not a search engine</em>, but rather offers convenient access to search services provided by other independent organizations. CC has no control over the results that are returned. <em>Do not assume that the results displayed in this search portal are under a CC license</em>. You should always verify that the work is actually under a CC license by following the link. Since there is no registration to use a CC license, CC has no way to determine what has and hasn\'t been placed under the terms of a CC license. If you are in doubt you should contact the copyright holder directly, or try to contact the site where you found the content.'); ?></p>
				</div>
            <div class="eight columns omega">
				<div id="remove" class="wrong">
					<p><?php echo _('<a href="#" id="addOpenSearch"><strong>Add CC Search</strong></a> to your browser.'); ?></strong></p>
					<p><?php echo _('<a href="http://wiki.creativecommons.org/Firefox_and_CC_Search"><strong>Learn how</strong></a> to switch to or from CC Search in your Firefox search bar.'); ?></a></>
				</div>

				<div id="translate">
						<select name="lang" id="lang">
							<?php
							foreach ( $languages as $code => $name ) {
								$selected = ($code == $query_locale) ? 'selected="selected"' : '';
								echo "<option value='$code' $selected>$name</option>\n";
							}
							?>
						</select>
						<a href="http://www.transifex.net/projects/p/CC/"><?php echo _('Help Translate'); ?></a> 
				</div>
			</div>
		</div>


                </div>
            </div><!--! end of .container -->
		</div><!--! end of #main -->

<?php include 'cc-wp/page-footer.php'; ?>
    </div> <!--! end of #container -->
<?php include 'cc-wp/footer-codes.php'; ?>
<script type="text/javascript"> 
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-2010376-2']);
	_gaq.push(['_trackPageview']);
 
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
</body>
</html>

