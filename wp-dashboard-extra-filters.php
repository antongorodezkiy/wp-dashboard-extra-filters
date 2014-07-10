<?php
/*
	Plugin Name: Wordpress Dashboard Extra Filters
	Plugin URI: http://demo.teamlead.pw/
	Description: Plugin for adding extra filters to Dashboard
	Version: 1.0.0
	Author: E. Kozachek
	Author URI: http://teamlead.pw/
	License: GPLv2
	Text Domain: wp-dashboard-extra-filters
*/

if (!defined('WPINC')) die();

define('DASHBOARD_EXTRA_FILTERS_PLUGIN','wp-dashboard-extra-filters');
define('DASHBOARD_EXTRA_FILTERS_APPPATH',dirname(__FILE__));
define('DASHBOARD_EXTRA_FILTERS_FILE',__FILE__);

if (!class_exists('dashboardExtraFiltersPlugin')) {
	include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/controllers/Plugin.php');
}

// initialization
	register_activation_hook(__FILE__, array('dashboardExtraFiltersPlugin','activation'));
	
// plugin actions
	add_filter('plugin_action_links', array('dashboardExtraFiltersPlugin','registerPluginActions'), 10, 2);

// Create Text Domain For Translations
	add_action('wp_loaded', array('dashboardExtraFiltersPlugin','localization'));
	
function wp_dashboard_extra_filters_init() {
	
	if (!class_exists('dashboardExtraFiltersModel')) {
		include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/models/Model.php');
	}

	if (!class_exists('dashboardExtraFiltersAssetsController')) {
		include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/controllers/AssetsController.php');
	}
	
	if (!class_exists('dashboardExtraFiltersAdminController')) {
		include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/controllers/AdminController.php');
	}
	
	if (!class_exists('dashboardExtraFilters_MetaFilter')) {
		include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/filters/MetaFilter.php');
	}

	if (!class_exists('dashboardExtraFilters_RelatedPostMetaFilter')) {
		include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/filters/RelatedPostMetaFilter.php');
	}
	
	if (!class_exists('dashboardExtraFilters_PostDateFilter')) {
		include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/filters/PostDateFilter.php');
	}
	
	if (!class_exists('dashboardExtraFilters_TaxonomyFilter')) {
		include_once(DASHBOARD_EXTRA_FILTERS_APPPATH.'/filters/TaxonomyFilter.php');
	}
	
	// assets
		if (is_admin()) {
			add_action('admin_head', array('dashboardExtraFiltersAssetsController', 'admin_head'));
		}

	//ADMIN
	if (is_admin() && (current_user_can('edit_posts') || current_user_can('edit_pages'))) {
		
		// settings init
			add_action('admin_init', array('dashboardExtraFiltersAdminController','settingsInit'));
			
		// admin page
			add_action( 'admin_menu', array('dashboardExtraFiltersAdminController','registerMenuPage'));
	}


}
add_action('after_setup_theme','wp_dashboard_extra_filters_init');
