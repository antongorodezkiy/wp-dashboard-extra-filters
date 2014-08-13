<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_PostDateFilter extends dashboardExtraFilters_Filter {
	
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
		
		add_action('restrict_manage_posts', array(&$this,'show_filters'));
		add_action('parse_query', array(&$this,'apply_filters'));
	}

	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
				
				$date_start = $this->get_query_var($this->date_start_key);
				$date_end = $this->get_query_var($this->date_end_key);
				?>

					<div class="js-dashboard-extra-filters-datepair dashboard-extra-filters-range-input-pair dashboard-extra-filters-datepair">
						<input
							type="text"
							name="<?php echo $this->date_start_key;?>"
							value="<?php echo $date_start;?>"
							class="date start"
							placeholder="<?php echo $this->empty_label['date_start'];?>"
							/>
						<input
							type="text"
							name="<?php echo $this->time_start_key;?>"
							value="<?php echo $this->get_query_var($this->time_start_key);?>"
							class="time start <?php echo (!$this->time_start_key ? "hidden" : "");?>"
							placeholder="<?php echo $this->empty_label['time_start'];?>"
							/>
						<span class="separator">|</span>
						<input
							type="text"
							name="<?php echo $this->date_end_key;?>"
							value="<?php echo $date_end;?>"
							class="date end"
							placeholder="<?php echo $this->empty_label['date_end'];?>"
							/>
						<input
							type="text"
							name="<?php echo $this->time_end_key;?>"
							value="<?php echo $this->get_query_var($this->time_end_key);?>"
							class="time end <?php echo (!$this->time_end_key ? "hidden" : "");?>"
							placeholder="<?php echo $this->empty_label['time_end'];?>"
							/>
							
						<?php
							$predefined = array(
								__('Predefined', DASHBOARD_EXTRA_FILTERS_PLUGIN) => array(
									'value' => '',
									'date_start' => '',
									'date_end' => ''
								),
								__('Today', DASHBOARD_EXTRA_FILTERS_PLUGIN) => array(
									'value' => 'today',
									'date_start' => date('Y-m-d',strtotime('today midnight')),
									'date_end' => date('Y-m-d')
								),
								__('This week', DASHBOARD_EXTRA_FILTERS_PLUGIN) => array(
									'value' => 'this_week',
									'date_start' => date('Y-m-d',strtotime('this week midnight')),
									'date_end' => date('Y-m-d')
								),
								__('This month', DASHBOARD_EXTRA_FILTERS_PLUGIN) => array(
									'value' => 'this_month',
									'date_start' => date('Y-m-d',strtotime('midnight first day of this month')),
									'date_end' => date('Y-m-d')
								),
								__('This year', DASHBOARD_EXTRA_FILTERS_PLUGIN) => array(
									'value' => 'this_year',
									'date_start' => date('Y-m-d',strtotime('first day of January '.date('Y'))),
									'date_end' => date('Y-m-d')
								)
							);
						?>						
						<select class="js-dashboard-extra-filters-dropdown js-dashboard-extra-filters-datepair-predefined dashboard-extra-filters-datepair-predefined">
							<?php foreach($predefined as $label => $meta) { ?>
								<option
									value="<?php echo $meta['value'];?>"
									data-date-start="<?php echo $meta['date_start'];?>"
									data-date-end="<?php echo $meta['date_end'];?>"
									<?php echo ($meta['date_start'] == $date_start && $meta['date_end'] == $date_end ? 'selected="selected"' : '');?>>
										<?php echo $label;?></option>
							<?php } ?>
						</select>
					</div>
				<?php
			}
		}
	
	// apply filters
		public function apply_filters( $query ) {
			global $pagenow, $typenow;
			
			$action = (isset($_GET['action']) ? $_GET['action'] : null);
			if ( $query->is_admin && $query->is_main_query() || $action != '-1' ) {
				$qv = &$query->query_vars;
				
				$date_start = $this->get_query_var($this->date_start_key);
				$date_end = $this->get_query_var($this->date_end_key);
		
				if ('edit.php' == $pagenow
					&& $date_start
					&& $date_end
				) {
					
					$date_start_ts = strtotime($date_start);
					$date_end_ts = strtotime($date_end);
					
					if (!isset($qv['date_query'])) {
						$qv['date_query'] = array();
					}
					
					if ($date_start_ts) {
						$qv['date_query'][] = array(
							'after' => array(
								'year' => date('Y', strtotime('-1 day',$date_start_ts)),
								'month' => date('m', strtotime('-1 day',$date_start_ts)),
								'day' => date('d', strtotime('-1 day',$date_start_ts)),
							)
						);
					}
					
					if ($date_end_ts) {
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
	
	
}
