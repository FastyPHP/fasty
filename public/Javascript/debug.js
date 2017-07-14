'use strict';

function main() {

	var
		toggleButton = $("#toggleButton"),
		toggleIcon = $("#toggleIcon"),
		debugbar = $("#debugbar"),
		debugExpanded = false,
		debug_query = $(".debug_query"),
		debug_tempalte = $(".debug_template"),
		column = $(".column"),
		debug_tab = $(".debug_tab")

	column.click(function() {
		var opens = $(this).data('opens');

		if(opens !== undefined) {
			debug_tab.hide();
			$("#" + opens).show();
		}
	});

	debug_tempalte.click(function() {

		var id = $(this).data('id');

		$("#paramsForTemplate_" + id).toggle();
	});

	debug_query.click(function() {

		var id = $(this).data('id');

		$("#paramsForQuery_" + id).toggle();
	});

	toggleButton.click(function() {
		if(!debugExpanded) {
			debugbar.addClass("expanded");
			debugExpanded = true;
			toggleIcon.removeClass("fa-toggle-off");
			toggleIcon.addClass("fa-toggle-on");
		} else {
			debugbar.removeClass("expanded");
			debugExpanded = false;
			toggleIcon.removeClass("fa-toggle-on");
			toggleIcon.addClass("fa-toggle-off");
		}
	});
}

function debugInit () {
	/**
	 * Font awesome
	 */

    var ss = document.styleSheets;
    for (var i = 0, max = ss.length; i < max; i++) {
        if (ss[i].href == "Fontawesome/css/font-awesome.min.css")
            return;
    }
    var link = document.createElement("link");
    link.rel = "stylesheet";
    link.href = "Fontawesome/css/font-awesome.min.css";

    document.getElementsByTagName("head")[0].appendChild(link);

	/**
	 * jQuery
	 */

	if ('undefined' == typeof window.jQuery) {
		var script = document.createElement("SCRIPT");
	    script.src = 'Debug/jquery.js';
	    script.type = 'text/javascript';
	    script.onload = function() {
	        var $ = window.jQuery;
	        main();
	    };
	    document.getElementsByTagName("head")[0].appendChild(script);
	} else {
		$(document).ready(main);
	}
}

debugInit();
