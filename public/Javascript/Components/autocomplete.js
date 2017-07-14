'use strict';

$(document).ready(function() {

	var
		autocompleteForLocation = $("#autocompleteForLocation"),
		trenutniACFokus

	$(document).delegate('.tutor_autocomplete', 'keyup', function(){

		var
			url = ''

		trenutniACFokus = $(this);

		switch(trenutniACFokus.data('sta')){
			case 'lokacija': url = '/autocomplete/lokacija'; break;
		}

		$.ajax({
			url: url,
			type: 'POST',
			data: 'q=' + trenutniACFokus.val(),
			success: function(data) {
				if(data == '') {
					autocompleteForLocation.hide();
				} else {
					var offset = trenutniACFokus.offset();

					autocompleteForLocation.html(data);

					autocompleteForLocation.css({
						'top' : offset.top + 50 + 'px',
						'left' : offset.left + 'px',
						'width' : trenutniACFokus.width() + 'px'
					});

					autocompleteForLocation.show();
				}
			}
		});
	}).delegate('.tutor_autocompleteAdd', 'click', function() {

		autocompleteForLocation.hide();

		trenutniACFokus.val($(this).data('val'));
	}).mouseup(function(e){
		if(!autocompleteForLocation.is(e.target) && autocompleteForLocation.has(e.target).length === 0)
			autocompleteForLocation.hide();
	});
});