$(function () {

	setupQuery();


	var queryPos = $("#query").position();
	var queryWidth = $("#query").innerWidth();

	//	$("#engineInfo").css("left", $("#engine").position().left + 7);
	//	$("#engineInfo").width($("#engine").width() - 32);

	// pick a random search engine
	//setEngine(engines[Math.floor(Math.random() * engines.length)]);

	// hide all the radio buttons if JS is enabled
	$(".engine button").focus(function () {
		$(".engine").removeClass("focus")
		$(this).parents(".engine").addClass("focus");
	})

	$(".engine button").focusout(function () {
		$(".engine").removeClass("focus")
	})

	$(".engine").click(function () {
		setEngine($(this).find("button").first().attr("id"));
		doSearch();
	});


	// sniff browser and determine what information to display
	/*
	var browser = $.browser;
	if (browser.mozilla) {
		if (browser.version.substr(0,3) == "1.9") {
			$("#remove").show();
		} else {
			$("#add").show();
			$("#searchBar").show();
		}
	} else {
		$("#add").show();

		if (browser.msie && browser.version.substr(0,1) > 6) {
			$("#searchBar").show();
		} else {
			$("#addressBar").show();
		}
	}
	*/
	$('#addOpenSearch').click(function () {
		if ((typeof window.external == "object") && ((typeof window.external.AddSearchProvider == "unknown") || (typeof window.external.AddSearchProvider == "function"))) {
			window.external.AddSearchProvider("http://oldsearch.creativecommons.org/ccsearch.xml");
		} else {
			alert("Your browser does not support OpenSearch.");
		}

		return false;
	});

	$('#lang').change(function () {
		/* get value of the language */
		var lang_chosen = $("#lang").val();
		var new_loc = location.href.split('?')[0];
		new_loc = new_loc.split('#')[0]; /* Remove spurious "#" */
		new_loc = new_loc + '?lang=' + lang_chosen;
		window.location = new_loc;
	});
});


/*
 * Creative Commons Search Portal Interface
 * 1.0 - 2006-07
 * 
 */
var engines = ["google", "googleimg", "flickr", "jamendo", "openclipart", "wikimediacommons", "fotopedia", "europeana", "youtube", "ccmixter", "soundcloud"];
//defaults:
var engine = "";
var comm = 1;
var deriv = 1;
var rights = "";
var url = "";
var lang = "";

var default_query = "flowers";
var default_engine = "_random";
//var default_comm = 1;
//var default_deriv = 1;

/*
// DEBUG!!!!!
var d = new Date();
d.setFullYear(2020,0,1);
setCookie("ccsearch", "jamendo", d, '/') 
alert("cookie planted!  mwahahahaha");
// \DEBUG!!!!!
*/

// mmm, cookies...
function setCookie(name, value, expires, path, domain, secure) {
	document.cookie = name + "=" + escape(value) +
		((expires) ? "; expires=" + expires.toGMTString() : "") +
		((path) ? "; path=" + path : "") +
		((domain) ? "; domain=" + domain : "") +
		((secure) ? "; secure" : "");
}
function getCookie(name) {
	var dc = document.cookie;
	var prefix = name + "=";
	var begin = dc.indexOf("; " + prefix);
	if (begin == -1) {
		begin = dc.indexOf(prefix);
		if (begin != 0) return null;
	} else {
		begin += 2;
	}
	var end = document.cookie.indexOf(";", begin);
	if (end == -1) {
		end = dc.length;
	}
	return unescape(dc.substring(begin + prefix.length, end));
}
////

var cookie_name = '__ccsearch';
var cookie_break_text = "[-]";
var cookie_domain = 'oldsearch.creativecommons.org';
//var cookie_domain = '';

function saveSettings() {
	var cookieDate = new Date();
	cookieDate.setFullYear(2020, 0, 1);

	cookieText = engine + cookie_break_text + comm + cookie_break_text + deriv;
	setCookie(cookie_name, cookieText, cookieDate, '/', cookie_domain);
}

function getSettings() {
	cookieText = getCookie(cookie_name);

	if (cookieText && cookieText != '') {
		//break it into pieces
		cookieCrumbs = cookieText.split(cookie_break_text);

		engine = cookieCrumbs[0];
		if (1 in cookieCrumbs) {
			comm = cookieCrumbs[1];
		}
		if (2 in cookieCrumbs) {
			deriv = cookieCrumbs[2];
		}
	}
	else {
	}

	if (engine == null || !engine || engine == "") {
		//engine = default_engine;
		engine = "_random";

		//engine = engines[Math.floor(Math.random() * engines.length)];
	}

}

// function by Pete Freitag (pete@cfdev.com)
function getQueryStrVariable(variable) {
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i = 0; i < vars.length; i++) {
		var pair = vars[i].split("=");
		if (pair[0] == variable) {
			return pair[1];
		}
	}
	return '';
}

function show_ffx_msg() {
	$('#ffx-search-bar-info').style.display = "block";
}

// initialise app
function setupQuery() {
	var query = $("#query");
	var qs = getQueryStrVariable('q');
	qs = unescape(qs);
	var moz = getQueryStrVariable('sourceid');
	var e = getQueryStrVariable('engine');
	var docom = getQueryStrVariable('commercial');
	var doder = getQueryStrVariable('derivatives');

	// display firefox branding 
	if (moz == "Mozilla-search") {
		show_ffx_msg();
	}

	// grab cookie and setup default engine
	getSettings();
	if (e) {
		setEngine(e);
	}
	else {
		setEngine(engine);
	}

	// set commercial + derivative checkboxes
	updateCommDerivCheckboxes(docom, doder);

	//lang = getQueryStrVariable('lang');

	// Only insert query variable if nothing else is in the search entry
	// Should solve back button problems	
	if (query.val().length < 1 && qs) query.val(qs);

	// Since we don't have a submit button, be nice to users and
	// set focus in search box.
	query.focus();
}

// bell
function wakeQuery() {
	var query = $('#q');

	if (query.value == d) {
		query.val("");
		query.addClass("active");
		query.removeClass("inactive");
	}
}

// whistle
function resetQuery() {
	var query = $('#q');

	if (query.value == "") {
		query.val(d);
		query.addClass("inactive");
		query.removeClass("active");
	}
}

function setEngine(e) {
	var previous = engine;

	var query = $("#query");
	if (query.hasClass("inactive")) {
		query.val(default_query);
		query.addClass("active");
		query.removeClass("inactive");
	}

	if (typeof e == "string") {
		if (e == "_random") {
			engine = engines[Math.floor(Math.random() * engines.length)];
		} else {
			engine = e;
		}
	} else {
		engine = e.value;
	}

	$("#engineInfo ." + previous).hide();
	$("#engineInfo ." + engine).show();

	$("button[value=" + engine + "]").attr("checked", true);

	$(".engine").removeClass("selected");
	$("button[value=" + engine + "]").parents(".engine").addClass("selected");

	//if (e == "_random") engine = "_random";	
	saveSettings();

	//doSearch();

}

function setCommDeriv() {
	if ($('#comm').attr("checked"))
		comm = 1;
	else
		comm = 0;
	if ($('#deriv').attr("checked"))
		deriv = 1;
	else
		deriv = 0;

	saveSettings();
}

function updateCommDerivCheckboxes(comOverride, derivOverride) {
	if ((comm == 1))
		$('#comm').attr("checked", true);
	else
		$('#comm').attr("checked", false);
	if ((deriv == 1))
		$('#deriv').attr("checked", true);
	else
		$('#deriv').attr("checked", false);
}

// build advanced search query strings
// each engine has vastly different ways to do this. :/
function modRights() {

	var comm = $("#comm").attr("checked");
	var deriv = $("#deriv").attr("checked");
	rights = "";

	switch (engine) {

		case "google":
			// Google apparently doesn't like .-() appended to the
			// as_rights query string variable, so if neither the
			// commercial or deriv checkboxes are checked then rights
			// should just be empty.
			if ((comm == false) && (deriv == false)) {
				rights = "";
				break;
			}

			//.-(cc_noncommercial|cc_nonderived)
			rights = ".-(";

			if (comm) {
				rights += "cc_noncommercial";
			}
			if (deriv) {
				(comm) ? rights += "|" : null;
				rights += "cc_nonderived";
			}

			rights += ")";
			break;


		case "googleimg":
			//.-(cc_noncommercial|cc_nonderived)

			// Google apparently doesn't like .-() appended to the
			// as_rights query string variable, so if neither the
			// commercial or deriv checkboxes are checked then rights
			// should just be empty.
			if ((comm == false) && (deriv == false)) {
				rights = "";
				break;
			}

			rights = ".-(";

			if (comm) {
				rights += "cc_noncommercial";
			}
			if (deriv) {
				(comm) ? rights += "|" : null;
				rights += "cc_nonderived";
			}

			rights += ")";
			break;

		case "yahoo":
			rights = "&";
			if (comm) {
				rights += "ccs=c&";
			}
			if (deriv) {
				rights += "ccs=e";
			}
			break;

		case "flickr":
			rights = "l=";
			if (comm) {
				rights += "comm";
			}
			if (deriv) {
				rights += "deriv";
			}
			break;

		case "jamendo":
			if (comm && deriv) {
				rights = '-nc%20AND%20-nd';
			} else if (comm) {
				rights = '-nc';
			} else if (deriv) {
				rights = '-nd';
			}
			break;

		case "wikimediacommons":
			rights = "";
			if (rights.length < 5) rights = "";
			break;

		case "fotopedia":
			rights = "";
			if (comm && deriv) {
				rights = "reuse_commercial_modify";
			} else if (comm && !deriv) {
				rights = "reuse_commercial";
			} else if (!comm && deriv) {
				rights = "reuse_modify"
			} else {
				rights = "reuse";
			}
			break;
		case "europeana":
			rights = "";
			if (comm && deriv) {
				rights = "+AND+RIGHTS%3A*creative*+AND+NOT+RIGHTS%3A*nc*+AND+NOT+RIGHTS%3A*nd*";
			} else if (comm && !deriv) {
				rights = "+AND+RIGHTS%3A*creative*+AND+NOT+RIGHTS%3A*nc*";
			} else if (!comm && deriv) {
				rights = "+AND+RIGHTS%3A*creative*+AND+NOT+RIGHTS%3A*nd*"
			} else {
				rights = "+AND+RIGHTS%3A*creative*+";
			}

			break;
		case "ccmixter":
			rights = "";
			if (comm && deriv) {
				rights = "&lic=by,sa,s,splus,pd,zero";
			} else if (comm && !deriv) {
				rights = "&lic=open";
			} else if (!comm && deriv) {
				rights = "&lic=by,nc,sa,ncsa,s,splus,pd,zero"
			}
			break;
		case "soundcloud":
			rights = "";
			if (comm && deriv) {
				rights = "&filter.license=to_modify_commercially";
			} else if (comm && !deriv) {
				rights = "&filter.license=to_use_commercially";
			} else if ((!comm && deriv) || (!comm && !deriv)) {
				rights = "&filter.license=to_share";
			}
			break;

	}

}

// "main logic", no turning back.
function doSearch() {
	var query = $("#query");
	var comm = $("#comm").attr("checked");
	var deriv = $("#deriv").attr("checked");

	// We never want the search to execute with the default text
	if (query.val() == "Enter search query") {
		query.val(default_query);
	}

	url = "";

	// search only if there is something to search with
	if ((query.val().length > 0)/* && (query.className == "active")*/) {
		// set up rights string, works if user hits "go" or a tab. 
		modRights();

		// NOTE: if you make changes here, you should make a similar change in search.php 
		switch (engine) {
			case "openclipart":
				url = 'http://openclipart.org/search/?query=' + query.val();
				break;

			case "jamendo":
				if (rights) {
					url = 'http://www.jamendo.com/search?qs=fq=license_cc:(' + rights + ')&q=' + query.val();
				} else {
					url = 'http://www.jamendo.com/search?qs=q=' + query.val();
				}
				break;

			case "flickr":
				url = 'http://flickr.com/search/?' + ((rights.length > 2) ? rights : "l=cc") + '&q=' + query.val();
				break;

			case "owlmm":
				url = 'http://www.owlmm.com/?query_source=CC&' + ((rights.length > 13) ? rights : "license_type=cc") + '&q=' + query.val();
				break;

			case "yahoo":
				url = 'http://search.yahoo.com/search?cc=1&p=' + query.val() + rights;
				break;

			case "googleimg":
				url = 'https://www.google.com/search?site=imghp&tbm=isch&q=' + query.val() + '&tbs=sur:f' + ((deriv) ? "m" : "") + ((comm) ? "c" : "") + '%2Cil:cl';
				break;

			case "wikimediacommons":
				url = 'http://commons.wikimedia.org/w/index.php?title=Special%3ASearch&redirs=0&search=' + query.val() + '&fulltext=Search&ns0=1&ns6=1&ns14=1&title=Special%3ASearch&advanced=1&fulltext=Advanced+search';
				break;

			case "fotopedia":
				url = 'http://www.fotopedia.com/search?q=' + query.val() + '&human_license=' + rights;
				break;

			case "europeana":
				url = 'http://www.europeana.eu/portal/search.html?query=' + query.val() + rights;
				break;

			case "youtube":
				url = 'http://www.youtube.com/results?search_query=' + query.val() + ',creativecommons';
				break;

			case "ccmixter":
				url = 'http://ccmixter.org/api/query?datasource=uploads&search_type=all&sort=rank&search=' + query.val() + rights;
				break;

			case "soundcloud":
				url = 'http://soundcloud.com/search/sounds?q=' + query.val() + rights;
				break;

			case "google":
			default:
				url = 'http://google.com/search?as_rights=(cc_publicdomain|cc_attribute|cc_sharealike' +
					((comm) ? "" : "|cc_noncommercial") + ((deriv) ? "" : "|cc_nonderived") + ')' +
					rights + '&q=' + query.val();
				if (lang != null) url += '&hl=' + lang;
				break;

		}

		url = 'https://oldsearch.creativecommons.org/bouncer.php?q=' + query.val() + '&url=' + encodeURIComponent(url);

		window.open(
			url,
			'_blank',
			'noopener'
		);
		//	document.getElementBy$('#stat').setAttribute('src','transparent.gif?engine='+engine+'&comm='+comm+'&deriv='+deriv+'&q='+query.value);
	}
	return false;
}

// i18n
function grabOriginalLanguage() {
	return document.getElementsByTagName('html')[0].lang.replace('-', '_');
}


function grabChosenLanguage() {
	var select_box = document.getElementById('lang');
	for (var i = 0; i < select_box.childNodes.length; i++) {
		var select_child = select_box.childNodes[i];
		if (select_child.nodeType == 1) {
			if (select_child.selected) {
				return select_child.value;
			}
		}
	}
	return null;
}

