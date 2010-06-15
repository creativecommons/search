$(function() {
	
	setupQuery();
	
	
	var queryPos = $("#query").position();
	var queryWidth = $("#query").innerWidth();
	
	$("#engineInfo").css("left", $("#engine").position().left + 7);
//	$("#engineInfo").width($("#engine").width() - 32);
	
})


/*
 * Creative Commons Search Interface
 * 1.0 - 2006-07
 * 
 */

var engines = ["google", "googleimg", "yahoo", "flickr", "blip", "jamendo", "spin", "openclipart", "wikimediacommons", "fotopedia"];
//defaults:
var engine = "";
var comm = 1;
var deriv = 1;
var rights = "";
var url = "";
var lang = "";

var default_query = "flowers";
var default_engine = "google";
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

var cookie_name = 'ccsearch';
var cookie_break_text = "[-]";
var cookie_domain = '.creativecommons.org';
//var cookie_domain = '';

function saveSettings(){
	var cookieDate = new Date();
	cookieDate.setFullYear(2020,0,1);
	
	cookieText = engine + cookie_break_text + comm + cookie_break_text + deriv;
	
	setCookie(cookie_name, cookieText, cookieDate, '/', cookie_domain);
}

function getSettings(){
   cookieText = getCookie(cookie_name);
   
   if(cookieText && cookieText != ''){
      //break it into pieces
      cookieCrumbs = cookieText.split(cookie_break_text);
         
	   engine = cookieCrumbs[0];
	   if(1 in cookieCrumbs){
	         comm = cookieCrumbs[1];
	   }
	   if(2 in cookieCrumbs){
	         deriv = cookieCrumbs[2];
	   }
   }
   else{
   }
   
	if (engine == null || !engine || engine == ""){
	   engine = default_engine;
	}
   
}

// function by Pete Freitag (pete@cfdev.com)
function getQueryStrVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  }
	return null;
}

// don't need an entire framework just for this
function id(i) { return document.getElementById(i); }

function show_ffx_msg(){
	id('ffx-search-bar-info').style.display = "block";
}

// initialise app
function setupQuery() {
	var query = id("query");
	var qs = getQueryStrVariable('q');
	var moz = getQueryStrVariable('sourceid');
	var e = getQueryStrVariable('engine');
	var docom = getQueryStrVariable('commercial');
	var doder = getQueryStrVariable('derivatives');

	// display firefox branding 
	if (moz == "Mozilla-search") {
		show_ffx_msg();
	}
	
	// grab cookie and setup default engine
//	getSettings();
	if (e){
	   setEngine(e);
	}
	else{
	   setEngine(engine);
	}
	
	updateCommDerivCheckboxes();

	lang = getQueryStrVariable('lang');
	
	// set commercial + derivative checkboxes
	if (docom != 'false') {
		id('comm').checked = true;
	} else {
		id('comm').checked = false;
	}
	if (doder != 'false') {
		id('deriv').checked = true;
	} else {
		id('deriv').checked = false;
	}
	
	query.value = qs;
	
	// if ((query.value == "") || (query.value == "null") || !(query.value)) {
	// 	query.value = d;
	// 	window.results.location.href = 'intro.php';
	// } else if (query.value != d){
	// 	query.className = "active";
	// 	
	// 	// since there's query data...
	// 	doSearch();
	// }
}

// bell
function wakeQuery() {
	var query = id('q');
	
	if (query.value == d) {
		query.value = "";
		query.className = "active";
	}
}

// whistle
function resetQuery() {
	var query = id('q');
	
	if (query.value == "") {
		query.className = "inactive";
		query.value = d;
	}
}

function setEngine(e) {
	var previous = engine;

    var query = id("query");
    if ( query.className == "inactive" ) {
        query.value = default_query;
        query.className = "active";
    }
	
	if (typeof e == "string") {
		engine = e;
	} else {
		engine = e.value;
	}
	try { id(previous).className="inactive"; } catch(err) {}
	//id(engine).className="active";
	
	$("#engineInfo ." + previous).hide();
	$("#engineInfo ." + engine).show();
	
	$("option[value=" + engine + "]").attr("selected", true);
	
	saveSettings();
	
//	doSearch();
}

function setCommDeriv() {
   if(id('comm').checked)
      comm = 1;
   else
      comm = 0;
   if(id('deriv').checked)
      deriv = 1;
   else
      deriv = 0;
      
   saveSettings();
}

function updateCommDerivCheckboxes(){
   if(comm == 1)
      id('comm').checked = "checked";
   else
      id('comm').checked = "";
   if(deriv == 1)
      id('deriv').checked = "checked";
   else
      id('deriv').checked = "";
}

// build advanced search query strings
// each engine has vastly different ways to do this. :/
function modRights() {
	
	switch (engine) {

		case "google":
			// Google apparently doesn't like .-() appended to the
			// as_rights query string variable, so if neither the
			// commercial or deriv checkboxes are checked then rights
			// should just be empty.
			if ( id('comm').checked == false && id('deriv').checked == false ) {
				rights = "";
				break;
			}

			//.-(cc_noncommercial|cc_nonderived)
			rights = ".-(";

			if (id('comm').checked) {
				rights += "cc_noncommercial";
			}
			if (id('deriv').checked) {
				(id('comm').checked) ? rights += "|" : null;
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
			if ( id('comm').checked == false && id('deriv').checked == false ) {
				rights = "";
				break;
			}

			rights = ".-(";

			if (id('comm').checked) {
				rights += "cc_noncommercial";
			}
			if (id('deriv').checked) {
				(id('comm').checked) ? rights += "|" : null;
				rights += "cc_nonderived";
			}

			rights += ")";
			break;


		case "yahoo":
			rights = "&";
			if (id('comm').checked) {
				rights += "ccs=c&";
			}
			if (id('deriv').checked) {
				rights += "ccs=e";
			}
			break;

		case "flickr":
			rights = "l=";
			if (id('comm').checked) {
				rights += "comm";
			}
			if (id('deriv').checked) {
				rights += "deriv";
			}
			break;

		case "blip":
			rights = "license=1,6,7"; // by,by-sa,pd
			if (!id('comm').checked && !id('deriv').checked) {
				rights += ",2,3,4,5"; // by-nd,by-nc-nd,by-nc-,by-nc-sa
			} else if (id('comm').checked && !id('deriv').checked) {
				rights += ",2"; // by-nd
			} else if(!id('comm').checked && id('deriv').checked){ // deriv must be checked
				rights += ",4,5"; // by-nc,by-nc-sa
			}
			//else: case: both true
			//we just leave it at by, by-sa, pd
			break;
			
		case "jamendo":
			rights = "";
			//note: apparently they don't check the values of these vars, they just check to see if they're defined
			//so uncommenting the else's will cause jamendo to think you always want derivs and commercial
			if (id('deriv').checked) {
				rights += "license_minrights_d=on&";
			}
			/*else{
			rights += "license_minrights_d=off&";
			}*/
			if (id('comm').checked) {
				rights += "license_minrights_c=on";
			}
			/*else{
			rights += "license_minrights_c=off";
			}*/
			break;
			
		case "ccmixter":
			rights = "";
			// everything on ccmixter permits derivs
			if (id('comm').checked) {
				rights += "+attribution";
			}
			break;
		
		case "spin":
			rights = "_license=";
			if (!id('comm').checked && !id('deriv').checked) {
				rights += "11"; // by-nd,by-nc-nd,by-nc-,by-nc-sa
			} else if (id('comm').checked && !id('deriv').checked) {
				rights += "8"; // by-nd
			} else if (!id('comm').checked && id('deriv').checked) {
				rights += "9";
			} else { 
				rights += "10"; // by-nc,by-nc-sa
			}
			break;

		case "openclipart":
			rights = "+publicdomain";
			break;

		case "wikimediacommons":
			rights = "";
			if (rights.length < 5) rights = "";
			break;

		case "fotopedia":
			rights = "";
			if (id('comm').checked && id('deriv').checked) {
				rights = "reuse_commercial_modify";
			} else if (id('comm').checked && !id('deriv').checked) {
				rights = "reuse_commercial";
			} else if (!id('comm').checked && id('deriv').checked) {
				rights = "reuse_modify"
			} else {
				rights = "reuse";
			}
			break;

	}

}

// "main logic", no turning back.
function doSearch() {
	var query = id("query");

    // We never want the search to execute with the default text
    if ( query.value == "Enter search query" ) {
        query.value = default_query;
    }

	url = "";
	
	// search only if there is something to search with
	if ((query.value.length > 0)/* && (query.className == "active")*/) {
		// set up rights string, works if user hits "go" or a tab. 
		modRights();

		switch (engine) {
			case "openclipart":
		    url = 'http://openclipart.org/cchost/media/tags/' + query.value + rights;
		    break;
                
			case "spin":
				url = 'http://www.spinxpress.com/getmedia' + rights + '_searchwords=' + query.value
				break;
				
			case "ccmixter":
				url = 'http://ccmixter.org/media/tags/' + query.value + rights;
				break;
				
			case "jamendo":
			  url ='http://www.jamendo.com/tag/' + query.value + '?' + rights + '&location_country=all&order=rating_desc';
				break;
				
			case "blip":
				url = 'http://blip.tv/posts/view/?q=' + query.value + '&section=/posts/view&sort=popularity&' + rights;
				break;
				
			case "flickr":
				url = 'http://flickr.com/search/?' + ((rights.length > 2) ? rights : "l=cc") + '&q=' + query.value;
				break;
				
			case "owlmm":
				url = 'http://www.owlmm.com/?query_source=CC&' + ((rights.length > 13) ? rights : "license_type=cc") + '&q=' + query.value;
				break;
				
			case "yahoo":
				url = 'http://search.yahoo.com/search?cc=1&p=' + query.value + rights;
				break;
		   
			case "googleimg":
			   url = 'http://images.google.com/images?as_q=' + query.value + '&as_rights=(cc_publicdomain|cc_attribute|cc_sharealike' + ((id('comm').checked) ? "" : "|cc_noncommercial") + ((id('deriv').checked) ? "" : "|cc_nonderived") + ')' + rights;
			   break;
			
			case "wikimediacommons":
				url ='http://commons.wikimedia.org/w/index.php?title=Special%3ASearch&redirs=0&search=' + query.value + '&fulltext=Search&ns0=1&ns6=1&ns14=1&title=Special%3ASearch&advanced=1&fulltext=Advanced+search';
				break;

			case "fotopedia":
				url = 'http://www.fotopedia.com/search?q=' + query.value + '&human_license=' + rights;
				break;

			case "google":
			default:
				url = 'http://google.com/search?as_rights=(cc_publicdomain|cc_attribute|cc_sharealike' + 
						((id('comm').checked) ? "" : "|cc_noncommercial") + ((id('deriv').checked) ? "" : "|cc_nonderived") + ')' + 
							rights + '&q=' + query.value; 
				if (lang != null) url += '&hl=' + lang;
				break;
		}
		window.location.href = url;
//		document.getElementById('stat').setAttribute('src','transparent.gif?engine='+engine+'&comm='+id('comm').checked+'&deriv='+id('deriv').checked+'&q='+query.value);
	}
	return false;
}
