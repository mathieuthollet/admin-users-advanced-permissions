<?php

/**
 * Filter posts lists depending on user permissions
 * @param WP_Query $query
 */
function auap_admin_pre_get_posts($query){
	if (is_admin() && !current_user_can("administrator")) {
		$post_type = $query->query["post_type"];
		$tax_query = array();
		foreach (auap_get_taxonomies() as $taxonomy) {
			if (in_array($post_type, get_taxonomy($taxonomy)->object_type)) {
				if (count(get_terms($taxonomy, array("hide_empty" => false))) > 0) {
					$access_tax = json_decode(get_user_meta(get_current_user_id(), "auap_".$taxonomy, true));
					if (!is_array($access_tax))
						$access_tax = array();
					if (is_array($access_tax)) {
						$tax_query[] = array(
											'taxonomy' => $taxonomy,
											'field'    => 'id',
											'terms'    => $access_tax
										 );
					}
				}
			}
		}
		$query->set('tax_query', $tax_query);
	}
	return $query;
}
add_filter('pre_get_posts', 'auap_admin_pre_get_posts');



/**
 * Exclude terms from lists depending on user permissions
 */
function auap_admin_list_terms_exclusions(){
	if (is_admin() && !current_user_can("administrator")) {
		$access_term_ids = array();
		foreach (auap_get_taxonomies() as $taxonomy) {
			$access_tax = json_decode(get_user_meta(get_current_user_id(), "auap_".$taxonomy, true));
			if (is_array($access_tax)) {
				$access_term_ids = array_merge($access_tax, $access_term_ids);
			}
		}
		$excluded = " AND (t.term_id IN (".implode(",", $access_term_ids).")) ";
		return $excluded;
	}
}
add_filter('list_terms_exclusions', 'auap_admin_list_terms_exclusions');