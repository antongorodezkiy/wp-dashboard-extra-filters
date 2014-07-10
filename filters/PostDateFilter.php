<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_PostDateFilter {
	
	public $post_types = array();
	public $empty_label = array(
		'date_start' => null,
		'time_start' => null,
		'date_end' => null,
		'time_end' => null
	);
	public $date_start_key = 'date_start';
	public $time_start_key = 'time_start';
	public $date_end_key = 'date_end';
	public $time_end_key = 'time_end';
	
	public function __construct() {
		
		if (empty($this->empty_label)) {
			$this->empty_label = array(
				'date_start' => null,
				'time_start' => null,
				'date_end' => null,
				'time_end' => null
			);
		}
		
		if (!$this->empty_label['date_start']) {
			$this->empty_label['date_start'] = __('Date Start',DASHBOARD_EXTRA_FILTERS_PLUGIN);
		}
		
		if (!$this->empty_label['time_start']) {
			$this->empty_label['time_start'] = __('Time Start',DASHBOARD_EXTRA_FILTERS_PLUGIN);
		}
		
		if (!$this->empty_label['date_end']) {
			$this->empty_label['date_end'] = __('Date End',DASHBOARD_EXTRA_FILTERS_PLUGIN);
		}
		
		if (!$this->empty_label['time_end']) {
			$this->empty_label['time_end'] = __('Time End',DASHBOARD_EXTRA_FILTERS_PLUGIN);
		}
		
		add_filter('query_vars', array(&$this,'add_query_vars_filter'));
		add_action('restrict_manage_posts', array(&$this,'show_filters'));
		add_action('parse_query', array(&$this,'apply_filters'));
		
		
	}
	
	// add query var
		public function add_query_vars_filter($vars) {
			$vars[] = $this->date_start_key;
			$vars[] = $this->time_start_key;
			$vars[] = $this->date_end_key;
			$vars[] = $this->time_end_key;
			return $vars;
		}
	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
								
				// filtering 
					$meta_values = dashboardExtraFiltersModel::getDistinctMetaValues($this->post_types, $this->meta_key);
					
				?>
				<br />
					
					<div class="js-dashboard-extra-filters-datepair dashboard-extra-filters-datepair">
						<input
							type="text"
							name="<?php echo $this->date_start_key;?>"
							value="<?php echo get_query_var($this->date_start_key);?>"
							class="date start"
							placeholder="<?php echo $this->empty_label['date_start'];?>"
							/>
						<input
							type="text"
							name="<?php echo $this->time_start_key;?>"
							value="<?php echo get_query_var($this->time_start_key);?>"
							class="time start <?php echo (!$this->time_start_key ? "hidden" : "");?>"
							placeholder="<?php echo $this->empty_label['time_start'];?>"
							/>
						<span class="separator">&mdash;</span>
						<input
							type="text"
							name="<?php echo $this->date_end_key;?>"
							value="<?php echo get_query_var($this->date_end_key);?>"
							class="date end"
							placeholder="<?php echo $this->empty_label['date_end'];?>"
							/>
						<input
							type="text"
							name="<?php echo $this->time_end_key;?>"
							value="<?php echo get_query_var($this->time_end_key);?>"
							class="time end <?php echo (!$this->time_end_key ? "hidden" : "");?>"
							placeholder="<?php echo $this->empty_label['time_end'];?>"
							/>
					</div>
				<?php
			}
		}
	
	// apply filters
		public function apply_filters( $query ) {
			global $pagenow, $typenow;
			
			if ( $query->is_main_query() ) {
				$qv = &$query->query_vars;
				
				$date_start = get_query_var($this->date_start_key);
				$date_end = get_query_var($this->date_end_key);
		
				if ('edit.php' == $pagenow
					&& $date_start
					&& $date_end
				) {
					
					$date_start_ts = strtotime($date_start);
					$date_end_ts = strtotime($date_end);
					
					if (!isset($qv['date_query'])) {
						$qv['date_query'] = array();
					}
					
					$qv['date_query'][] = array(
						'after' => array(
							'year' => date('Y', strtotime('-1 day',$date_start_ts)),
							'month' => date('m', strtotime('-1 day',$date_start_ts)),
							'day' => date('d', strtotime('-1 day',$date_start_ts)),
						)
					);
					
					$qv['date_query'][] = array(
						'before' => array(
							'year' => date('Y', strtotime('+1 day',$date_end_ts)),
							'month' => date('m', strtotime('+1 day',$date_end_ts)),
							'day' => date('d', strtotime('+1 day',$date_end_ts)),
						)
					);
				}
			}
		}
	
	
}
