<?php

/** 
 * Returns all AUAP configurable taxonomies
 * @return array $taxonomies 
 * */
function auap_get_taxonomies($args = array(), $output = 'names', $operator = 'and') {
	$taxonomies = get_taxonomies($args, $output, $operator);
	foreach ($taxonomies as $taxonomy_key => $taxonomy_val) {
		if (in_array($taxonomy_key, array("nav_menu", "link_category", "post_format")))
			unset($taxonomies[$taxonomy_key]);
	}
	return $taxonomies;
}