/* Animation for the form */

$('input[name=kairosmemberinfo_ownVenture]').click(function(){
	var a = $('#kairosmemberinfo_ventureFollowUp');
	if ($(this).val() == 'T'){
		a.show('slow');
	} else {
		a.hide('slow');
	}
});

var preference_filler = function(){
	var target = $('#kairosmemberinfo_preference_combine');
	var t_val = "";
	var tmp = $('input[name=kairosmemberinfo_preference]');
	jQuery.each(tmp, function() {
		if ($(this).prop('checked'))
			t_val += $(this).val() + ";";
	});
	target.val(t_val);
};

/* */
$('input[name=kairosmemberinfo_preference]').click(preference_filler);

/* for form filling */
$(document).ready(function(){
	if ($('#kairosmemberinfo_ownVentureT').prop('checked')) {
		$('#kairosmemberinfo_ventureFollowUp').css('display','block');
	}
	preference_filler();
});