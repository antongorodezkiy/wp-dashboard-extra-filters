<?php if (!defined('WPINC')) die();

abstract class dashboardExtraFilters_Filter {
	
	public $post_types = array();
	public $meta_key = null;
	public $empty_label = null;
	public $empty_value = '';
	public $hide_if_empty = false;
	
	public function __construct() {
		if (!$this->empty_label) {
			$this->empty_label = __('Show All',DASHBOARD_EXTRA_FILTERS_PLUGIN);
		}
		
		add_action('restrict_manage_posts', array(&$this,'show_filters'));
		add_action('parse_query', array(&$this,'apply_filters'));
	}
	
	// get query var
		public function get_query_var($name) {
			$var = null;
			
			if (isset($_GET[$name])) {
				$var = sanitize_text_field($_GET[$name]);
			}
			
			return $var;
		}
		
	public static function humanize_label($string) {
		return ucfirst(str_replace('_',' ',$string));
	}
}
