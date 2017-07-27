<?php if (!defined('WPINC')) die();

class dashboardExtraFilters_MetaDateFilter extends dashboardExtraFilters_PostDateFilter {

    public $parse_format = 'Ymd';

	// apply filters
		public function apply_filters( $query ) {
			global $pagenow, $typenow;

			$action = (isset($_GET['action']) ? $_GET['action'] : null);
			if ( $query->is_admin && $query->is_main_query() ) {
				$qv = &$query->query_vars;

				$date_start = $this->get_query_var($this->date_start_key);
				$date_end = $this->get_query_var($this->date_end_key);

				if ('edit.php' == $pagenow
					&& $date_start
					&& $date_end
				) {

                    $date_start_ts = \DateTime::createFromFormat('Y-m-d', $date_start)->format($this->parse_format);
                    $date_end_ts = \DateTime::createFromFormat('Y-m-d', $date_end)->format($this->parse_format);

					if (!isset($qv['date_query'])) {
						$qv['date_query'] = array();
					}

					if ($date_start_ts != $this->empty_value) {
						$qv['meta_query'][] = array(
							'key' => $this->meta_key,
							'value' => $date_start_ts,
							'compare' => '>=',
							'type' => 'NUMERIC'
						);
					}

					if ($date_end_ts != $this->empty_value) {
						$qv['meta_query'][] = array(
							'key' => $this->meta_key,
							'value' => $date_end_ts,
							'compare' => '<=',
							'type' => 'NUMERIC'
						);
					}

				}
			}
		}
}
