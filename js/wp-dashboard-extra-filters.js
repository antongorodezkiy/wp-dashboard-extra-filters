(function($) {
	
	$(document).ready(function(){
		
		// select2
			if ($('.js-dashboard-extra-filters-dropdown, #posts-filter select[name="m"]').size()) {
				$('.js-dashboard-extra-filters-dropdown, #posts-filter select[name="m"]').select2({
					minimumResultsForSearch: 10,
					width: 'element'
				});
			}
			
			
		// tooltips
			if ($('.js-wp-dashboard-extra-filters-admin-settings .js-tip').size()) {
				$('.js-wp-dashboard-extra-filters-admin-settings .js-tip').tipsy({gravity: 's'});
				$('.js-wp-dashboard-extra-filters-admin-settings .js-tip').on("click", function(e){
					e.preventDefault();
				});
			}
			
		// datepair
			if ($('.js-dashboard-extra-filters-datepair').size()) {
				
				// pikaday
					$('.js-dashboard-extra-filters-datepair .date').pikaday({
						format: 'YYYY-MM-DD',
					});
					
				// timepicker
					$('.js-dashboard-extra-filters-datepair .time').timepicker({
						'showDuration': true,
						'timeFormat': 'g:ia'
					});
				
				// datepair
					$('.js-dashboard-extra-filters-datepair').datepair({
						parseDate: function(a) {
							return $.datepicker.parseDate('yy-mm-dd', $(a).val());
						}
					});
			}
			
		// predefined date filters
			if ($('.js-dashboard-extra-filters-datepair-predefined').size()) {
				$('.js-dashboard-extra-filters-datepair-predefined').on("change", function(){
					var option = $("option:selected",$(this));
					var start = option.attr("data-date-start");
					var end = option.attr("data-date-end");
					
					$(".js-dashboard-extra-filters-datepair .date.start").val(start);
					$(".js-dashboard-extra-filters-datepair .date.end").val(end);
				});
			}
			
	});
	
})(jQuery);
