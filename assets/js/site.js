$(document).ready(function(){
  //alert('Hello World!');
});

$( "#poll_edit_add_option" ).click(function() {
	// Very strangely any dynamically added form elements need to have an extra
	// 4 px left margin to appear on the same level horisontally as the statical
	// elements. This was reproducible in both Chrome and Firefox.
	$time = new Date().getTime();
	$("<label for='poll_option_name_new_" + $time + "'>Vaihtoehdon nimi</label>")
		.insertBefore("#poll_edit_add_option");
	$("<input type='text' value='' />")
		.attr("id", "poll_option_name_new_" + $time)
		.attr("name", "option_name_new_" + $time)
		.attr("maxlength", "20")
		.attr("style", "margin-left: 4px;")
		.insertBefore("#poll_edit_add_option");
	$("<br/>")
		.insertBefore("#poll_edit_add_option");
	$("<label for='poll_option_description_new_" + $time + "'>Vaihtoehdon kuvaus</label>")
		.insertBefore("#poll_edit_add_option");
	$("<textarea></textarea>")
		.attr("id", "poll_option_description_new_" + $time)
		.attr("name", "option_description_new_" + $time)
		.attr("cols", "30")
		.attr("maxlength", "100")
		.attr("style", "margin-left: 4px;")
		.insertBefore("#poll_edit_add_option");
	$("<br/>")
		.insertBefore("#poll_edit_add_option");
});