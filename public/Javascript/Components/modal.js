var
	zIndex = 1000,
	modalCallbekovi = []

$.fn.modalController = function (action, callback){
	var
		modalId = this.attr("id");

	if(action) {
		$("#modalShadow_" + modalId).fadeIn("fast");
		$("#modalShadow_" + modalId).css('z-index', zIndex);
		$('body').css('overflow', 'hidden');
		$("#" + modalId).addClass('bounceIn animated');
		
		setTimeout(function(){
			$("#" + modalId).removeClass('bounceIn animated');
		}, 750);

		modalCallbekovi[modalId] = callback;

		zIndex ++;
	} else {
		$("#modalShadow_" + modalId).fadeOut("fast");
		$('body').css('overflow', 'auto');
	}
};

function closeModals() {
	$(".modalShadow").fadeOut("fast");
	$('body').css('overflow', 'auto');
}


$(document).mouseup(function(e){
	if(!$(".modalino").is(e.target) && $(".modalino").has(e.target).length === 0){
		closeModals();
		modalCallbekovi[$(this).attr('id')];
	}
});

$(document).delegate('.modalClose', 'click', function(){
	$("#" + $(this).data('id')).modalController(false);
});