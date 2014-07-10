<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_TaxonomyFilter {
	
	public $post_types = array();
	public $empty_label = null;
	public $taxonomy = null;
	
	public function __construct() {
		if (!$this->empty_label) {
			$this->empty_label = __('Show All',DASHBOARD_EXTRA_FILTERS_PLUGIN);
		}
		
		add_filter('query_vars', array(&$this,'add_query_vars_filter'));
		add_action('restrict_manage_posts', array(&$this,'show_filters'));
		add_action('parse_query', array(&$this,'apply_filters'));
	}
	
	// add query var
		public function add_query_vars_filter($vars) {
			$vars[] = $this->taxonomy;
			return $vars;
		}
	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
					
					$terms = get_terms($this->taxonomy, array('hide_empty' => true));
				?>
					<select class="js-dashboard-extra-filters-dropdown dashboard-extra-filters-dropdown" name="<?php echo $this->taxonomy; ?>">
						<option value="0"><?php echo $this->empty_label; ?></option>
						<?php
						
							foreach($terms as $term) {
								$if_selected = '';
								if (get_query_var($this->taxonomy) == $term->slug) {
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
	
	// apply filters
		public function apply_filters( $query ) {
			global $pagenow, $typenow;
			
			if ( $query->is_main_query() ) {
				$qv = &$query->query_vars;
		
				if ('edit.php' == $pagenow && get_query_var($this->taxonomy)) {
					
					if (!isset($qv['tax_query'])) {
						$qv['tax_query'] = array();
					}
					
					$qv['tax_query'][] = array(
						'taxonomy' => $this->taxonomy,
						'field' => 'slug',
						'terms' => get_query_var($this->taxonomy),
						'operator' => 'IN',
					);
				}
			}
		}
	
	
}
