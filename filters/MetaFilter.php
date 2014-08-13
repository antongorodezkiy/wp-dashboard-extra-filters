<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_MetaFilter extends dashboardExtraFilters_Filter {
	
	public $null_label = null;
	public $null_value = null;
	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
								
				// filtering 
					$meta_values = dashboardExtraFiltersModel::getDistinctMetaValues($this->post_types, $this->meta_key);
					
					if (($this->hide_if_empty && !empty($meta_values)) || !$this->hide_if_empty) {
						?>
							<select class="js-dashboard-extra-filters-dropdown dashboard-extra-filters-dropdown" name="<?php echo $this->meta_key; ?>">
								<option value="<?php echo $this->empty_value;?>"><?php echo $this->empty_label; ?></option>
								
								<?php if ($this->null_value && $this->null_label) {
									
									$if_selected = '';
									if ($this->get_query_var($this->meta_key) == $this->null_label) {
										$if_selected = 'selected="selected"';
									}
									?>
									<option <?php echo $if_selected; ?> value="<?php echo $this->null_value;?>"><?php echo $this->null_label; ?></option>
								<?php } ?>
								
								<?php
								
									foreach($meta_values as $meta_value) {
										$if_selected = '';
										if ($this->get_query_var($this->meta_key) == $meta_value) {
											$if_selected = 'selected="selected"';
										}
								
										?>
											<option <?php echo $if_selected; ?> value="<?php echo $meta_value;?>"><?php echo self::humanize_label($meta_value);?></option>
										<?php
									}
								?>
							</select>
						<?php
					}
			}
		}
	
	// apply filters
		public function apply_filters( $query ) {
			global $pagenow, $typenow;
			
			$action = (isset($_GET['action']) ? $_GET['action'] : null);
			if ( $query->is_admin && $query->is_main_query() || $action != '-1' ) {
				$qv = &$query->query_vars;
		
				if ($pagenow == 'edit.php' && $this->get_query_var($this->meta_key)) {

					if (!isset($qv['meta_query'])) {
						$qv['meta_query'] = array();
					}
					
					if ($this->get_query_var($this->meta_key) == $this->null_value) {
						$qv['meta_query'][] = array(
							'key' => $this->meta_key,
							'value' => '',
							'compare' => 'NOT EXISTS'
						);
						
					}
					else if ($this->get_query_var($this->meta_key) != $this->empty_value) {
						$qv['meta_query'][] = array(
							'key' => $this->meta_key,
							'value' => $this->get_query_var($this->meta_key),
							'compare' => '=',
							'type' => ''
						);
					}
				}
			}
		}
	
	
}

