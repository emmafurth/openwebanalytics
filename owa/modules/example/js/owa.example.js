/*function reloadNewUser(properties){
	// add new site_id to properties
	//alert("Test!");
	var current_user = jQuery("#owa_user_list option:selected").val(); 
	//OWA.debug(properties['action']);
	
	if (current_user != undefined) {
		properties['current_user'] = current_user;
	}
	// reload report	
	var url = OWA.util.makeUrl(OWA.config.link_template, OWA.config.main_url, properties);
	window.location.href = url;
}	*/