<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_BetweenMetaFilter extends dashboardExtraFilters_Filter {
	
	public $empty_label = array(
		'value_start' => null,
		'value_end' => null
	);
	public $meta_start_key = 'value_start';
	public $meta_end_key = 'value_end';
	public $meta_key = '';
	
	public function __construct() {
		
		if (empty($this->empty_label)) {
			$this->empty_label = array(
				'value_start' => null,
				'value_end' => null
			);
		}
		
		if (!$this->empty_label['value_start']) {
			$this->empty_label['value_start'] = __('From',DASHBOARD_EXTRA_FILTERS_PLUGIN);
		}
		
		if (!$this->empty_label['value_end']) {
			$this->empty_label['value_end'] = __('To',DASHBOARD_EXTRA_FILTERS_PLUGIN);
		}

		add_action('restrict_manage_posts', array(&$this,'show_filters'));
		add_action('parse_query', array(&$this,'apply_filters'));
	}
	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
								
				$value_start = $this->get_query_var($this->meta_start_key);
				$value_end = $this->get_query_var($this->meta_end_key);
				
				?><div class="dashboard-extra-filters-range-input-pair dashboard-extra-filters-valuepair">
						<input
							type="text"
							name="<?php echo $this->meta_start_key;?>"
							value="<?php echo $value_start;?>"
							class="value start"
							placeholder="<?php echo $this->empty_label['value_start'];?>"
							/><!--
						--><span class="separator">|</span><!--
						--><input
							type="text"
							name="<?php echo $this->meta_end_key;?>"
							value="<?php echo $value_end;?>"
							class="value end"
							placeholder="<?php echo $this->empty_label['value_end'];?>"
							/>
					</div><?php
				
			}
		}
	
	// apply filters
		public function apply_filters( $query ) {
			global $pagenow, $typenow;
			
			$action = (isset($_GET['action']) ? $_GET['action'] : null);
			if ( $query->is_admin && $query->is_main_query() ) {
				$qv = &$query->query_vars;
		
				if ($pagenow == 'edit.php') {

					if (!isset($qv['meta_query'])) {
						$qv['meta_query'] = array();
					}
					
					if ($this->get_query_var($this->meta_start_key) != $this->empty_value) {
						$qv['meta_query'][] = array(
							'key' => $this->meta_key,
							'value' => $this->get_query_var($this->meta_start_key),
							'compare' => '>=',
							'type' => 'NUMERIC'
						);
					}
					
					if ($this->get_query_var($this->meta_end_key) != $this->empty_value) {
						$qv['meta_query'][] = array(
							'key' => $this->meta_key,
							'value' => $this->get_query_var($this->meta_end_key),
							'compare' => '<=',
							'type' => 'NUMERIC'
						);
					}
					
				}
			}
		}
	
	
}

