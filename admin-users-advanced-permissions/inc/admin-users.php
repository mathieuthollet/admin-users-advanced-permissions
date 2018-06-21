<?php


/** 
 * Add new fields to user admin form
 * @param WP_User $user
 */
function auap_edit_user_profile($user) {
	wp_enqueue_script("admin-users", AUAP_WEB_PATH."js/admin-users.js");
	$user_access = array();
	?>
	<div id="auap_permissions">
		<h3><?php _e("Taxonomies permissions", AUAP_I18N_DOMAIN); ?></h3>
		<table class="form-table">
			<tbody>
				<?php foreach (auap_get_taxonomies(array(), "objects") as $taxonomy => $taxonomy_obj) {
						if (is_object($user))
							$user_access[$taxonomy] = json_decode(get_user_meta($user->ID, "auap_".$taxonomy, true));
						if (!isset($user_access[$taxonomy]) || $user_access[$taxonomy] == null) 
							$user_access[$taxonomy] = array();	?>
						<tr>
							<th>
								<label><?php echo $taxonomy_obj->labels->name;?></label>
							</th>
							<td>
								<?php auap_hierarchical_taxonomy_tree("0", $taxonomy, $user_access[$taxonomy], "auap_".$taxonomy); ?>
							</td>
						</tr>
				<?php } ?>
			</tbody>
		</table>
		<script type="text/javascript">
			auap_check_all_label = '<?php _e("Check all", AUAP_I18N_DOMAIN);?>';
			auap_uncheck_all_label = '<?php _e("Uncheck all", AUAP_I18N_DOMAIN);?>';
		</script>
	</div>
	<?php 
}
add_action('edit_user_profile', 'auap_edit_user_profile');
add_action('user_new_form', 'auap_edit_user_profile');



/** 
 * Recursive function to display taxonomy tree
 * @param object $term_id
 * @param string $taxonomy
 * @param array $access_tax
 * @param string $input_name
 */
function auap_hierarchical_taxonomy_tree($term_id, $taxonomy, $access_tax, $input_name) {
  	$next = get_terms($taxonomy, array("parent" => $term_id
  								, "hide_empty" => 0)
  							);
  	if ($next) {?>
  		<?php if ($term_id!="0") {?><div style="margin-left:20px;"><?php }
    	foreach($next as $next_term) { ?>
   			<label>
    			<input type="checkbox" rel="<?php echo $input_name;?>" name="<?php echo $input_name;?>[]" value="<?php echo $next_term->term_id?>" <?php echo in_array($next_term->term_id, $access_tax)?"checked":""; ?> /><?php echo $next_term->name;?>
   			</label><br/>
   			<?php auap_hierarchical_taxonomy_tree($next_term->term_id, $taxonomy, $access_tax, $input_name);
    	}?>
    	<?php if ($term_id=="0") {?>
			<p>
				<a class="check-all" rel="<?php echo $input_name;?>" href="#"><?php _e("Check all", AUAP_I18N_DOMAIN);?></a>
			</p>
		<?php } ?>
	    <?php if ($term_id!="0") {?>
	    	</div>
	    <?php }
	}
}



/**
 * Saves data in user profile
 * @param int $user_id 
 */
function auap_edit_user_profile_update($user_id) {
	foreach (auap_get_taxonomies() as $taxonomy) {
		update_user_meta($user_id, "auap_".$taxonomy, json_encode($_POST["auap_".$taxonomy]));		
	}
}
add_action('edit_user_profile_update', 'auap_edit_user_profile_update');
add_action('user_register', 'auap_edit_user_profile_update');

