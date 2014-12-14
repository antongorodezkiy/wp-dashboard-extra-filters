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
	
	public static function getDistinctMetaValuesWithPostKeys($post_type, $meta_key){
		global $wpdb;

		$query = "
			SELECT DISTINCT(".$wpdb->postmeta.".meta_value), ".$wpdb->postmeta.".post_id
			FROM ".$wpdb->posts."
			LEFT JOIN ".$wpdb->postmeta."
				ON ".$wpdb->posts.".ID = ".$wpdb->postmeta.".post_id
			WHERE
				".$wpdb->posts.".post_type IN ('".implode("','",$post_type)."')
				AND ".$wpdb->postmeta.".meta_key = '".$meta_key."'
				AND ".$wpdb->postmeta.".meta_value != ''
			ORDER BY ".$wpdb->postmeta.".meta_value
		";
		
		$results = $wpdb->get_results($query);
		$meta_values = array();
		foreach($results as $result) {
			
			if (!isset($meta_values[$result->meta_value])) {
				$meta_values[$result->meta_value] = array();
			}
			
			$meta_values[$result->meta_value][] = $result->post_id;
		}
		
		foreach($meta_values as $i => $meta_value) {
			$meta_values[$i] = implode(',',$meta_value);
		}
		
		return $meta_values;
	}
	
	public static function getRelatedPosts($post_type, $ids){
		global $wpdb;

		$query = "
			SELECT ID, post_title
			FROM ".$wpdb->posts."
			WHERE
				".$wpdb->posts.".post_type IN ('".implode("','",$post_type)."')
				AND ".$wpdb->posts.".ID IN ('".implode("','",$ids)."')
			ORDER BY ".$wpdb->posts.".post_title
		";
		
		$values = $wpdb->get_results($query);
		
		return $values;
	}
	
	
	
	public static function getDistinctP2PRelatedPostsForPostType($post_type, $connection_name) {
		global $wpdb;

		$query = "
			SELECT DISTINCT(".$wpdb->p2p.".p2p_to) 
			FROM ".$wpdb->p2p."
			LEFT JOIN ".$wpdb->posts."
				ON ".$wpdb->posts.".ID = ".$wpdb->p2p.".p2p_from
			WHERE
				".$wpdb->posts.".post_type IN ('".implode("','",$post_type)."')
				AND ".$wpdb->p2p.".p2p_type = '".$connection_name."'
		";
		$meta_values = $wpdb->get_col($query);
		
		$query = "
			SELECT DISTINCT(".$wpdb->p2p.".p2p_from) 
			FROM ".$wpdb->p2p."
			LEFT JOIN ".$wpdb->posts."
				ON ".$wpdb->posts.".ID = ".$wpdb->p2p.".p2p_to
			WHERE
				".$wpdb->posts.".post_type IN ('".implode("','",$post_type)."')
				AND ".$wpdb->p2p.".p2p_type = '".$connection_name."'
		";
		$meta_values = array_merge($meta_values, $wpdb->get_col($query));
		
		return $meta_values;
	}
	
	
	public static function getDistinctP2PIdsByRelatedPosts($connection_name, $to_ids) {
		global $wpdb;

		$query = "
			SELECT DISTINCT(".$wpdb->p2p.".p2p_from) 
			FROM ".$wpdb->p2p."
			LEFT JOIN ".$wpdb->posts."
				ON ".$wpdb->posts.".ID = ".$wpdb->p2p.".p2p_to
			WHERE
				".$wpdb->p2p.".p2p_to IN ('".implode("','",(array)$to_ids)."')
				AND ".$wpdb->p2p.".p2p_type = '".$connection_name."'
		";
		$meta_values = $wpdb->get_col($query);
		
		$query = "
			SELECT DISTINCT(".$wpdb->p2p.".p2p_to) 
			FROM ".$wpdb->p2p."
			LEFT JOIN ".$wpdb->posts."
				ON ".$wpdb->posts.".ID = ".$wpdb->p2p.".p2p_from
			WHERE
				".$wpdb->p2p.".p2p_from IN ('".implode("','",(array)$to_ids)."')
				AND ".$wpdb->p2p.".p2p_type = '".$connection_name."'
		";
		$meta_values = array_merge($meta_values, $wpdb->get_col($query));
		
		return $meta_values;
	}
	
}
