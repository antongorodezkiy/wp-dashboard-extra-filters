(function($) {
	
	$(document).ready(function(){
		
		// select2
			if ($('.js-dashboard-extra-filters-dropdown').size()) {
				$('.js-dashboard-extra-filters-dropdown').select2({
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
						
					});
			}
	});
	
})(jQuery);
