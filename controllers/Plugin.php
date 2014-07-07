<?php if (!defined('WPINC')) die();

class dashboardExtraFiltersPlugin {
	
	public static function activation() {
		return true;
	}
	
	public static function localization() {
		//load_plugin_textdomain(DASHBOARD_EXTRA_FILTERS_PLUGIN, false, dirname( plugin_basename(DASHBOARD_EXTRA_FILTERS_FILE) ) . '/languages/'.get_locale().'/' );
	}
	
	public static function getActivePlugins() {
		$apl = get_option('active_plugins');
		$plugins = get_plugins();
		$activated_plugins = array();
		foreach($apl as $p) {           
			if(isset($plugins[$p])) {
				array_push($activated_plugins, $plugins[$p]);
			}           
		}
		
		return $activated_plugins;
	}
	
	public static function serverInfo() {
		global $wp_version, $wpdb;
		
		$mysql = $wpdb->get_row("SHOW VARIABLES LIKE 'version'");
		
		$info = array(
			'os' => php_uname(),
			'php' => phpversion(),
			'mysql' => $mysql->Value,
			'wordpress' => $wp_version
		);
		
		return $info;
	}
		
	// plugin actions
		public static function registerPluginActions($links, $file) {
			if (stristr($file, DASHBOARD_EXTRA_FILTERS_PLUGIN)) {
				$settings_link = '<a href="options-general.php?page='.DASHBOARD_EXTRA_FILTERS_PLUGIN.'">' . __('Settings', DASHBOARD_EXTRA_FILTERS_PLUGIN) . '</a>';
				$links = array_merge(array($settings_link), $links);
			}
			return $links;
		}
		
	
	private static $cached_meta = array();
	static public function get_post_meta($post_id, $key = '', $single = false) {
		if (!isset(self::$cached_meta[$post_id])) {
			self::$cached_meta[$post_id] = array();
			$meta_data = get_post_meta($post_id);
			if (!empty($meta_data)) {
				foreach($meta_data as $meta_key => $meta) {
					if (is_serialized($meta[0])) {
						$meta[0] = unserialize($meta[0]);
					}
					self::$cached_meta[$post_id][$meta_key] = $meta[0];
				}
			}
		}
		
		if (!$key) {
			return isset(self::$cached_meta[$post_id]) ? self::$cached_meta[$post_id] : null;
		}
		else {
			return isset(self::$cached_meta[$post_id][$key]) ? self::$cached_meta[$post_id][$key] : null;
		}
	}
		
}
