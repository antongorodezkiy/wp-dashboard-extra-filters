<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_MetaOfRelatedPostFilter extends dashboardExtraFilters_Filter {
	
	public $related_meta_key = null;
	public $related_post_type = null;
	public $empty_value = '-1';
	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
								
				// filtering 
					$meta_values = dashboardExtraFiltersModel::getDistinctMetaValuesWithPostKeys($this->related_post_type, $this->related_meta_key);
					
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
								
									foreach($meta_values as $meta_value => $post_ids) {
										$if_selected = '';
										if ($this->get_query_var($this->meta_key) == $post_ids) {
											$if_selected = 'selected="selected"';
										}
								
										?>
											<option <?php echo $if_selected; ?> value="<?php echo $post_ids;?>"><?php echo self::humanize_label($meta_value);?></option>
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
			
			if (!$typenow) {
				
			}
			
			$action = (isset($_GET['action']) ? $_GET['action'] : null);
			if ($query->is_admin && $query->is_main_query() && in_array($typenow,$this->post_types)) {
				$qv = &$query->query_vars;
		
				if ($pagenow == 'edit.php' && $this->get_query_var($this->meta_key)) {
					
					if (!isset($qv['meta_query'])) {
						$qv['meta_query'] = array();
					}
					
					if ($this->get_query_var($this->meta_key) != $this->empty_value) {
												
						$qv['meta_query'][] = array(
							'key' => $this->relation_meta_key,
							'value' => $this->get_query_var($this->meta_key),
							'compare' => 'IN'
						);
						
					}
				}
			}
		}
	
	
}
