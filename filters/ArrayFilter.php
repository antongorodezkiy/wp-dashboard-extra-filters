<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_ArrayFilter extends dashboardExtraFilters_Filter {
	
	public $values = array();
	public $apply_filters_callbacks = null;
	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
								
				// filtering 
					
					if (($this->hide_if_empty && !empty($this->values)) || !$this->hide_if_empty) {
						?>
							<select class="js-dashboard-extra-filters-dropdown dashboard-extra-filters-dropdown" name="<?php echo $this->meta_key; ?>">
								<option value="<?php echo $this->empty_value;?>"><?php echo $this->empty_label; ?></option>
								<?php
								
									foreach($this->values as $value) {
										$if_selected = '';
										if ($this->get_query_var($this->meta_key) == $value) {
											$if_selected = 'selected="selected"';
										}
								
										?>
											<option <?php echo $if_selected; ?> value="<?php echo $value;?>"><?php echo self::humanize_label($value);?></option>
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
					
					if ($this->get_query_var($this->meta_key) != $this->empty_value) {
						$qv = call_user_func($this->apply_filters_callbacks, $this, $qv);
					}
				}
			}
		}
	
	
}
