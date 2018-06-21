/**
 * Managing "Check all"
 */
jQuery(document).ready(function() {
	jQuery('.check-all').click(function() {
		var rel = jQuery(this).attr("rel");
		var cases = jQuery("input[type='checkbox'][rel='" + rel + "']");
		if (jQuery(this).html() == auap_check_all_label) {
			cases.attr('checked', true);
			jQuery(this).html(auap_uncheck_all_label); 
		} else { 
			cases.attr('checked', false);
			jQuery(this).html(auap_check_all_label);
		}
		return false;
	});
	jQuery('.check-all').each(function() {
		var rel = jQuery(this).attr("rel");
		if (jQuery("input[type='checkbox'][rel='" + rel + "']").length == jQuery("input[type='checkbox'][rel='" + rel + "']:checked").length)
			jQuery(this).trigger("click");
	});
});		



/**
 * Display block or not, depending on choosen role
 */
jQuery(document).ready(function() {
	jQuery("select#role").change(function() { manageRoleSelect(false) });
	manageRoleSelect(true);
});
function manageRoleSelect(first) {
	var role = jQuery("select#role option:selected").val();
	if (role == "administrator")
		jQuery("#auap_permissions").hide();
	else
		jQuery("#auap_permissions").show();
	
}