
	
	// sticky
	var wind = $(window);
	var sticky = $('#sticky-header');
	wind.on('scroll', function () {
		var scroll = wind.scrollTop();
		if (scroll < 100) {
			sticky.removeClass('sticky');
		} else {
			sticky.addClass('sticky');
		}
	});

	// datatables
	$(document).ready( function () {
		$('#frontendmix').DataTable({
		})
	});	

	



	