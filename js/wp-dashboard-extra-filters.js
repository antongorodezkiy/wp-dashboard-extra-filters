(function($) {
	
	$(document).ready(function(){
		
		// chosen
			if ($('.js-dashboard-extra-filters').size()) {
				$('.js-dashboard-extra-filters').select2({
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
			
		// selects	
		/*	function selectricsInit($el) {
				$el.selectric({
					optionsItemBuilder: function(itemData, element, index){
						var icon_name = element.attr("data-icon");
						return element.val().length ? '<span class="linked-articles-preview-img '+icon_name+'"></span>' + itemData.text : itemData.text;
					}
				});
			}
			selectricsInit($('.js-select-with-previews'));*/
	});
	
})(jQuery);
