/* Animation for the form */

$('input[name=kairosmemberinfo_ownVenture]').click(function(){
	var a = $('#kairosmemberinfo_ventureFollowUp');
	if ($(this).val() == 'T'){
		a.show('slow');
	} else {
		a.hide('slow');
	}
})

/* for form filling */
$(document).ready(function(){
	if ($('#kairosmemberinfo_ownVentureT').prop('checked')) {
		$('#kairosmemberinfo_ventureFollowUp').css('display','block');
	}
});