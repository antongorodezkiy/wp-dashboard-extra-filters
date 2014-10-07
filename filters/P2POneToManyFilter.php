<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_P2POneToManyFilter extends dashboardExtraFilters_Filter {
	
	public $p2p_connection = null;
	
	// show filters
		public function show_filters() {
			global $typenow;
			
			if (in_array($typenow, $this->post_types)) {
								
				// filtering 
					$meta_values = dashboardExtraFiltersModel::getDistinctP2PRelatedPostsForPostType($this->post_types, $this->p2p_connection);
					
					if ($meta_values) {
						$posts_query = new WP_Query(array(
							'post_type' => get_post_types(),
							'post__in' => $meta_values,
							'posts_per_page' => -1
						));
					
						$found_posts = $posts_query->get_posts();
					}
					else {
						$found_posts = array();
					}
					
					if (($this->hide_if_empty && !empty($found_posts)) || !$this->hide_if_empty) {
						?>
							<select class="js-dashboard-extra-filters-dropdown dashboard-extra-filters-dropdown" name="<?php echo $this->meta_key; ?>">
								<option value="<?php echo $this->empty_value;?>"><?php echo $this->empty_label; ?></option>
								<?php
									
									foreach($found_posts as $found_post) {
										$if_selected = '';
										if ($this->get_query_var($this->meta_key) == $found_post->ID) {
											$if_selected = 'selected="selected"';
										}
								
										?>
											<option <?php echo $if_selected; ?> value="<?php echo $found_post->ID;?>"><?php echo $found_post->post_title;?></option>
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
			if (
				in_array($typenow, $this->post_types)
				&& $query->is_admin && $query->is_main_query() /* this is needed to show filters always - && $query->query['post_type'] == $typenow*/
			) {
				
				$qv = &$query->query_vars;
		
				if ($pagenow == 'edit.php' && $this->get_query_var($this->meta_key)) {
					
					if ($this->get_query_var($this->meta_key) != $this->empty_value) {
						
						if (empty($qv['post__in'])) {
							$qv['post__in'] = dashboardExtraFiltersModel::getDistinctP2PIdsByRelatedPosts(
								$this->p2p_connection,
								$this->get_query_var($this->meta_key)
							);
						}
						else {
							$qv['post__in'] = array_intersect(
								$qv['post__in'],
								dashboardExtraFiltersModel::getDistinctP2PIdsByRelatedPosts(
									$this->p2p_connection,
									$this->get_query_var($this->meta_key)
								)
							);
							
							if (empty($qv['post__in'])) {
								$qv['post__in'] = array(-1);
							}
						}
					}
				}
			}
		}
	
	
}
