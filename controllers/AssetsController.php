<?php if (!defined('WPINC')) die();
		
class dashboardExtraFiltersAssetsController {	
	
	public static function admin_head() {
		
		// styles
			wp_enqueue_style('purecss.grids', plugins_url('css/pure.grids.css',  DASHBOARD_EXTRA_FILTERS_FILE ));
			wp_enqueue_style('purecss.forms', plugins_url('css/pure.forms.css',  DASHBOARD_EXTRA_FILTERS_FILE ));
			wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.css',  DASHBOARD_EXTRA_FILTERS_FILE ));
			wp_enqueue_style('tipsy', plugins_url('css/tipsy.css',  DASHBOARD_EXTRA_FILTERS_FILE ));
			wp_enqueue_style('jquery.select2', plugins_url('css/jquery.select2.css',  DASHBOARD_EXTRA_FILTERS_FILE ));
			wp_enqueue_style('jquery.pikaday', plugins_url('css/pikaday.css',  DASHBOARD_EXTRA_FILTERS_FILE ));
			wp_enqueue_style('jquery.timepicker', plugins_url('css/jquery.timepicker.css',  DASHBOARD_EXTRA_FILTERS_FILE ));
			wp_enqueue_style('admin.'.DASHBOARD_EXTRA_FILTERS_PLUGIN, plugins_url('css/wp-dashboard-extra-filters.css',  DASHBOARD_EXTRA_FILTERS_FILE ), array('purecss.grids'));
		
		// scripts
			wp_enqueue_script(
				'jquery.tipsy',
				plugins_url('js/jquery.tipsy.js', DASHBOARD_EXTRA_FILTERS_FILE),
				array('jquery')
			);
			wp_enqueue_script(
				'moment',
				plugins_url('js/moment.js', DASHBOARD_EXTRA_FILTERS_FILE),
				array('jquery')
			);
			wp_enqueue_script(
				'jquery.select2',
				plugins_url('js/jquery.select2.js', DASHBOARD_EXTRA_FILTERS_FILE),
				array('jquery')
			);
			wp_enqueue_script(
				'jquery.pikaday',
				plugins_url('js/pikaday.js', DASHBOARD_EXTRA_FILTERS_FILE),
				array('jquery')
			);
			wp_enqueue_script(
				'jquery.timepicker',
				plugins_url('js/jquery.timepicker.js', DASHBOARD_EXTRA_FILTERS_FILE),
				array('jquery')
			);
			wp_enqueue_script(
				'datepair',
				plugins_url('js/datepair.js', DASHBOARD_EXTRA_FILTERS_FILE),
				array('jquery')
			);
			wp_enqueue_script(
				'jquery.datepair',
				plugins_url('js/jquery.datepair.js', DASHBOARD_EXTRA_FILTERS_FILE),
				array('jquery', 'datepair')
			);
			wp_enqueue_script(
				'wp-dashboard-extra-filters',
				plugins_url('js/wp-dashboard-extra-filters.js', DASHBOARD_EXTRA_FILTERS_FILE),
				array(
					'jquery',
					'moment',
					'jquery.select2',
					'jquery.pikaday',
					'jquery.timepicker',
					'datepair',
					'jquery.datepair'
				)
			);
			
			// javascript settings
				wp_localize_script('wp-dashboard-extra-filters', 'DashboardExtraFilters', array(
					'url' => array(
						'ajaxurl' => admin_url('admin-ajax.php')
					),
					'lang' => array(
					)
				));
			
	}
	
	
	
}
