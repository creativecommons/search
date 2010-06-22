// Search UI Event Logger
// Tracks events, but no data is recorded
//
// Alex Roberts @ Creative Commons, 2010
//
// Some data may be used for processing, differentials and time tracking
// All logs are stored privately and for internal use only
//
// Requirements: jQuery

// Quick and dirty user id for a single page load session s
var id = 'xxxxxGxx'.replace(/[xy]/g, function(c) {var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);return v.toString(16);}).toUpperCase();
var baseUrl = '/sites/default/themes/cc/heatmap/elog.php?';

$(function() {
	// page has loaded! 
	log ("page_load");
	
	// now set up event handlers
	$("#query").blur (function() { log("query_changed"); });
	$("#engineSelect").change (function() { log("engine_changed"); });
	$("input[name=engine]").click(function() { log("engine_changed"); });
	$("#submit").click (function() { log("submit_clicked"); });
	$("#comm").click (function() { log("commercial_clicked"); });
	$("#deriv").click (function() { log("deriv_clicked"); });
})

function log(value) {
	//console.log (baseUrl + "id=" + id + "&event=" + value);
	$.get(baseUrl + "id=" + id + "&event=" + value);
}
