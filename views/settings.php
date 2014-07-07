<?php if (!defined('WPINC')) die(); ?>
<div class="wrap wp-dashboard-extra-filters js-wp-dashboard-extra-filters-admin-settings pure-g-r">
	
		<div class="pure-u-2-3">
			
			<div class="wp-dashboard-extra-filters-bl row">
				<div class="row hdr">
					<h3>
						<span class="fa fa-info"></span>
						<?php _e('About', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
					</h3>
				</div>
				<div class="row container">
					<p class="center">
						<a class="logo" href="http://demo.teamlead.pw/" target="_blank">
							Wordpress Dashboard Extra Filters Plugin 
						</a>
					</p>

					<div class="in">
						<blockquote>
							Wordpress Dashboard Extra Filters Plugin &copy; <a href="http://teamlead.pw" target="_blank">Teamlead Power&nbsp;<span class="fa fa-external-link-square"></span></a>
						</blockquote>
						<blockquote>
							<p>
								CSS Framework &copy; <a href="http://purecss.io/" target="_blank">Pure.css&nbsp;<span class="fa fa-external-link-square"></span></a>
							</p>
							<p>
								Tooltips &copy; <a href="http://onehackoranother.com/projects/jquery/tipsy/" target="_blank">tipsy&nbsp;<span class="fa fa-external-link-square"></span></a>
							</p>
							<p>
								Selectboxes &copy; <a href="https://github.com/harvesthq/chosen" target="_blank">jQuery Chosen&nbsp;<span class="fa fa-external-link-square"></span></a>
							</p>
						</blockquote>
					</div>

				</div>
			</div>

			<form class="wp-dashboard-extra-filters-content wp-dashboard-extra-filters-bl settings-pure-form pure-form-aligned pure-form" method="post" action="options.php">
				
				<?php settings_fields(DASHBOARD_EXTRA_FILTERS_PLUGIN); ?>
				
				<div class="row hdr">
					<h3>
						<span class="fa fa-sliders"></span>
						<?php _e('Settings', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
					</h3>
				</div>

				<div class="row in">

					<div class="row">
						<legend>
							<span class="fa fa-code"></span>
							<?php _e('Manual mode', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
						</legend>
						<p>
							<?php echo sprintf(__('In manual mode for adding linked articles you could use shortcode %s or php code %s', DASHBOARD_EXTRA_FILTERS_PLUGIN),
									'<code>[wp-dashboard-extra-filters]</code>',
									'<code>linkedArticlesFrontController::disaply_linked_articles($atts = array())</code>'
								)?>
						</p>
						<blockquote>
							<?php echo sprintf(__('More information about shortcode and php code (including parameters) you could find below in %s "Documentation" section, "Are you developer?" subsection.',DASHBOARD_EXTRA_FILTERS_PLUGIN),'<span class="fa fa-file-code-o"></span>')?>
						</blockquote>
					</div>
					
					<div class="row">
						<legend>
							<span class="fa fa-cogs"></span>
							<?php _e('Plugin settings', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
						</legend>
						<div class="pure-control-group">
							<label>
								<span class="fa fa-file-o"></span>
								<?php _e('Allow linked articles for following post types', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>:
							</label>
							<ul>
								<?php
									$post_types = get_post_types(array(
										'public' => true
									));
									$selected_post_types = dashboardExtraFiltersAdminController::get_allowed_post_types();
									foreach($post_types as $post_type) {
										?>
											<li>
												<label>
													<input
														type="checkbox"
														name="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-turn-on-for-post-types[]"
														value="<?php echo $post_type; ?>"
														<?php echo (in_array($post_type,$selected_post_types) ? 'checked="checked"' : '' )?>
														/>
													<?php _e('for',DASHBOARD_EXTRA_FILTERS_PLUGIN); ?> <?php echo $post_type;?>
												</label>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
		
						<p class="pure-control-group">
							<label for="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-allow-cross-post-types-linked-articles">
								<span class="fa fa-random"></span>
								<?php _e('Allow cross post types linking', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
								<a href="#" class="js-tip tip" title="<?php _e('By default linked articles widget search is restricted to post type of the current post. This option will give you an ability to search and link articles with different post types. Posts, which were already linked, will stay linked.', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>"><span class="fa fa-question-circle"></span></a>
							</label>
							<input
								type="checkbox"
								id="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-allow-cross-post-types-linked-articles"
								name="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-allow-cross-post-types-linked-articles"
								value="1"
								<?php echo ( get_option(DASHBOARD_EXTRA_FILTERS_PLUGIN.'-allow-cross-post-types-linked-articles') ? 'checked="checked"' : '' )?>
								/>
						</p>
					</div>
					
					<div>
						<legend>
							<span class="fa fa-link"></span>
							<?php _e('Posts linking widget settings', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
						</legend>
						<p class="pure-control-group">
							<label for="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-search-in-articles-content">
								<span class="fa fa-file-text-o"></span>
								<?php _e('Search in articles content', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
								<a href="#" class="js-tip tip" title="<?php _e('This option will allow widget to search in articles content.', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>"><span class="fa fa-question-circle"></span></a>
							</label>
							<input
								type="checkbox"
								id="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-search-in-articles-content"
								name="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-search-in-articles-content"
								value="1"
								<?php echo ( get_option(DASHBOARD_EXTRA_FILTERS_PLUGIN.'-search-in-articles-content') ? 'checked="checked"' : '' )?>
								/>
						</p>
						
						<p class="pure-control-group">
							<label for="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-search-meta-fields">
								<span class="fa fa-database"></span>
								<?php _e('Search in meta fields', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
								<a href="#" class="js-tip tip" title="<?php _e('This option will allow widget to search in meta fields. Add meta fields names, separate them by commas.', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>"><span class="fa fa-question-circle"></span></a>
							</label>
							<input
								type="text"
								id="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-search-meta-fields"
								name="<?php echo DASHBOARD_EXTRA_FILTERS_PLUGIN?>-search-meta-fields"
								value="<?php echo get_option(DASHBOARD_EXTRA_FILTERS_PLUGIN.'-search-meta-fields'); ?>"
								/>
						</p>
					</div>
					
					<p>
						<blockquote>
							<?php echo sprintf(__('More information about settings you could find below in %s "Documentation" section, "Where to start?" subsection.',DASHBOARD_EXTRA_FILTERS_PLUGIN),'<span class="fa fa-file-code-o"></span>')?>
						</blockquote>
					</p>

					<hr />
					
					<div class="row">
						<button class="button-primary" type="submit">
							<span class="fa fa-save"></span>
							<?php _e('Save', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
						</button>
					</div>
				</div>
				
			</form>

		</div>
		
		<div class="pure-u-1-3">

			<div class="wp-dashboard-extra-filters-bl row">
				<div class="row hdr">
					<h3>
						<span class="fa fa-envelope-o"></span>
						<?php _e('Personal Support', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
					</h3>
				</div>
				<div class="row in container">

					<div class="row">
						<blockquote>
							<p>
								<?php

								$subject = sprintf(__('Support request, plugin: %s (time: %s)', DASHBOARD_EXTRA_FILTERS_PLUGIN),
									DASHBOARD_EXTRA_FILTERS_PLUGIN,
									date('d.m.Y H:i:s')
								);
								
								echo sprintf(__('To get support please contact us on address <a target="_blank" href="%s">%s</a>. Please also attach information below to let us know more about your server and site environment - this could be helpful to solve the issue.', DASHBOARD_EXTRA_FILTERS_PLUGIN),
									'mailto:support@teamlead.pw?subject='.$subject,
									'support@teamlead.pw&nbsp;<span class="fa fa-external-link-square"></span>'
								);?>
							</p>
						</blockquote>
						<p>
							Email: <a target="_blank" href="mailto:support@teamlead.pw?subject=<?php echo $subject;?>">support@teamlead.pw&nbsp;<span class="fa fa-external-link-square"></span></a>
						</p>
						<p>
							<?php _e('Subject', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>: <?php echo $subject;?>
						</p>
					</div>
		
					<div class="row">
						<h5 class="row">
							<?php _e('Server Info', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
						</h5>
						<ul>
							<?php
								foreach(dashboardExtraFiltersPlugin::serverInfo() as $option => $val) {
									$info = $option.' -> '.$val;
									?>
										<li>
											<?php echo $info; ?>
										</li>
									<?php
								}
							?>
						</ul>
					</div>
					
					<hr />
					
					<div class="row">
						<h5 class="row">
							<?php _e('Theme', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
						</h5>
						<?php $current_theme = wp_get_theme(); ?>
						<p>
							<?php echo $current_theme->get('Name');?>,
							<?php echo $current_theme->get('Version');?>,
							<?php echo $current_theme->get('ThemeURI');?>
						</p>
						<p>
							<?php _e('from', DASHBOARD_EXTRA_FILTERS_PLUGIN)?> <?php echo $current_theme->get('Author');?>,
							<?php echo $current_theme->get('AuthorURI');?>
						</p>
						
					</div>
					
					<hr />
					
					<div class="row">
						<h5 class="row">
							<?php _e('Plugins', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
						</h5>
						<ul>
							<?php
								foreach(dashboardExtraFiltersPlugin::getActivePlugins() as $pl) {
									$plugin = $pl['Name'].', '.$pl['Version'].', '.$pl['PluginURI'];
									?>
										<li>
											<?php echo $plugin; ?>
										</li>
									<?php
								}
							?>
						</ul>
					</div>
			
				</div>
			</div>
			
			
		</div>
		
	
	<div class="pure-u-1">
		<?php
		if (file_exists(DASHBOARD_EXTRA_FILTERS_APPPATH.'/documentation/index_'.WPLANG.'.html')) {
			$documentation_url = 'documentation/index'.WPLANG.'.html';
		}
		else {
			$documentation_url = 'documentation/index.html';
		}
		$documentation_url = plugins_url($documentation_url, DASHBOARD_EXTRA_FILTERS_FILE)
		?>
		<div class="wp-dashboard-extra-filters-bl">
			<div class="row hdr">
				<h3>
					<span class="fa fa-file-code-o"></span>
					<?php _e('Documentation', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>
					<a class="right" target="_blank" href="<?php echo $documentation_url?>" title="<?php _e('open in the separate tab', DASHBOARD_EXTRA_FILTERS_PLUGIN)?>"><span class="fa fa-external-link"></span></a>
				</h3>
			</div>
			<div class="row in container">
				<iframe class="wp-dashboard-extra-filters-iframe" src="<?php echo $documentation_url?>" frameborder="0"></iframe>
			</div>
		</div>
	</div>

</div>
