<?php if (!defined('WPINC')) die();

class dashboardExtraFiltersAdminController {
		
	// settings
		public static function registerMenuPage() {
			//add_options_page('Dashboard Extra Filters', 'Dashboard Extra Filters', 'manage_options', DASHBOARD_EXTRA_FILTERS_PLUGIN, array('dashboardExtraFiltersAdminController','showSettings'));
			
			/*function admin_footer_debug_query() {
				global $wp_query;
				
				echo '
				<!-- $wp_query '.print_r($wp_query,true).' -->
				';
			}
			add_action("admin_footer", "admin_footer_debug_query");*/
		}
	
		public static function showSettings() {
			include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/views/settings.php');
		}
		
		
		public static function settingsInit() {
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-add-to-post-content');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-turn-on-for-post-types');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-search-in-articles-content');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-search-meta-fields');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-allow-cross-post-types-linked-articles');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-ordering');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-limit');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-disable-frontend-styles');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-layout');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-layout-columns');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-label');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-appear-animation');
			register_setting(DASHBOARD_EXTRA_FILTERS_PLUGIN, DASHBOARD_EXTRA_FILTERS_PLUGIN.'-time-span');
		}
	
		public static function get_allowed_post_types() {
			$default_post_types = get_post_types(array(
				'public' => true
			));
			
			$allowed_post_types = get_option(DASHBOARD_EXTRA_FILTERS_PLUGIN.'-turn-on-for-post-types');
			
			return (!empty($allowed_post_types) ? $allowed_post_types : $default_post_types);
		}
		
		public static function is_post_type_allowed($post_type) {
			return in_array($post_type,self::get_allowed_post_types());
		}
		
		
		
		
	

}
