<?php if (!defined('WPINC')) die();

class dashboardExtraFiltersModel {

	public static function getDistinctMetaValues($post_type, $meta_key){
		global $wpdb;

		$query = "
			SELECT DISTINCT(".$wpdb->postmeta.".meta_value) 
			FROM ".$wpdb->posts."
			LEFT JOIN ".$wpdb->postmeta."
				ON ".$wpdb->posts.".ID = ".$wpdb->postmeta.".post_id
			WHERE
				".$wpdb->posts.".post_type IN ('".implode("','",$post_type)."')
				AND ".$wpdb->postmeta.".meta_key = '".$meta_key."'
				AND ".$wpdb->postmeta.".meta_value != ''
			ORDER BY ".$wpdb->postmeta.".meta_value
		";
		
		$meta_values = $wpdb->get_col($query);
		
		return $meta_values;
	}
	
}
