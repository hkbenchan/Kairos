$('#kairosmemberinfo_dob').datepicker({ dateFormat: 'yy-mm-dd'});

/* Animation for the form */

$('#kairosmemberinfo_ownVentureT').click(function(){
	//console.log($(this).val());
	if ($(this).val() =="T") {
		$('#kairosmemberinfo_ventureFollowUp').show('slow');
		$('#kairosmemberinfo_ownVentureT').prop('checked',true);
		$('#kairosmemberinfo_ownVentureF').prop('checked',false);
	};
	return false;
});

$('#kairosmemberinfo_ownVentureF').click(function(){
	//console.log($(this).val());
	if ($(this).val() =="F") {
		$('#kairosmemberinfo_ventureFollowUp').hide('slow');
		$('#kairosmemberinfo_ownVentureF').prop('checked',true);
		$('#kairosmemberinfo_ownVentureT').prop('checked',false);
	};
	return false;
});
