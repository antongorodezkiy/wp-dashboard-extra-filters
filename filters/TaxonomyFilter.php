<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_TaxonomyFilter extends dashboardExtraFilters_Filter {

	public $empty_value = '-1';
	public $taxonomy = null;
	
	// get query var
		public function get_query_var($name) {
			$var = null;
			
			if (isset($_GET[$name])) {
				$var = sanitize_text_field($_GET[$name]);
			}
			
			return $var;
		}
	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
					
					$terms = get_terms($this->taxonomy, array('hide_empty' => true));
					
					if (($this->hide_if_empty && !empty($terms)) || !$this->hide_if_empty) {
						?>
							<select class="js-dashboard-extra-filters-dropdown dashboard-extra-filters-dropdown" name="<?php echo $this->taxonomy; ?>">
								<option value="<?php echo $this->empty_value;?>"><?php echo $this->empty_label; ?></option>
								<?php
								
									foreach($terms as $term) {
										$if_selected = '';
										if ($this->get_query_var($this->taxonomy) == $term->slug) {
											$if_selected = 'selected="selected"';
										}
								
										?>
											<option <?php echo $if_selected; ?> value="<?php echo $term->slug;?>"><?php echo $term->name;?></option>
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
		
				if ('edit.php' == $pagenow && $this->get_query_var($this->taxonomy)) {
					
					if (!isset($qv['tax_query'])) {
						$qv['tax_query'] = array();
					}
					
					if ($this->get_query_var($this->meta_key) != $this->empty_value) {
						$qv['tax_query'][] = array(
							'taxonomy' => $this->taxonomy,
							'field' => 'slug',
							'terms' => $this->get_query_var($this->taxonomy),
							'operator' => 'IN',
						);
					}
				}
			}
		}
	
	
}
