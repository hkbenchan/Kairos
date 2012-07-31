<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<div class="admin-box">
<h3>New Event</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
<fieldset>
	<div class="control-group <?php echo form_error('event_name') ? 'error' : ''; ?>">
		<?php echo form_label('Event Name'. lang('bf_form_label_required'), 'event_name', array('class' => "control-label") ); ?>
		<div class='controls'>
		<?php 
	 		if (isset($form_data['event_name'])) {
				$name_value = $form_data['event_name'];
			} else {
				$name_value = 'Name';
			} ?>
		<input type="text" name="event_name" id="event_name" value="<?php echo $name_value; ?>" maxlength="100" size="50" style="width:50%; font-size:24px; height:24px;">
		<span class="help-inline"><?php echo form_error('event_name'); ?></span>
		</div>
	</div>
	
	<!-- Start Time -->
	<div class="control-group">
		<?php echo form_label('Start Time (YYYY-MM-DD HH:mm (24 hours format))'.lang('bf_form_label_required'), 'event_start',array('class'=>"control-label")); ?>
		<div class='controls'>
			<div style="float:left;">
				<input type="text" name="event_start_y" maxlength="4" size="4" style="width:50%;" value="<?php if (isset($form_data['event_start_y'])) echo $form_data['event_start_y']; ?>">
				<span class="help-inline"><?php echo form_error('event_start_y'); ?></span>
			</div><span style="float:left;">/</span>
			<div style="float:left;">
				<input type="text" name="event_start_m" maxlength="2" size="2" style="width:50%;" value="<?php if (isset($form_data['event_start_m'])) echo $form_data['event_start_m']; ?>">
				<span class="help-inline"><?php echo form_error('event_start_m'); ?></span>
			</div><span style="float:left;">/</span>
			<div style="float:left;">
				<input type="text" name="event_start_d" maxlength="2" size="2" style="width:50%;" value="<?php if (isset($form_data['event_start_d'])) echo $form_data['event_start_d']; ?>">
				<span class="help-inline"><?php echo form_error('event_start_d'); ?></span>
			</div><span style="float:left;"> </span>
			<div style="float:left;">
				<input type="text" name="event_start_h" maxlength="2" size="2" style="width:50%;" value="<?php if (isset($form_data['event_start_h'])) echo $form_data['event_start_h']; ?>">
				<span class="help-inline"><?php echo form_error('event_start_h'); ?></span>
			</div><span style="float:left;">:</span>
			<div style="float:left;">
				<input type="text" name="event_start_i" maxlength="2" size="2" style="width:50%;" value="<?php if (isset($form_data['event_start_i'])) echo $form_data['event_start_i']; ?>">
				<span class="help-inline"><?php echo form_error('event_start_i'); ?></span>
			</div>
		</div>
	</div>
	
	<!-- End Time -->
	
	<div class="control-group">
		<?php echo form_label('End Time (YYYY-MM-DD HH:mm (24 hours format))'.lang('bf_form_label_required'), 'event_end',array('class'=>"control-label")); ?>
		<div class='controls'>
			<div style="float:left;">
				<input type="text" name="event_end_y" maxlength="4" size="4" style="width:50%;" value="<?php if (isset($form_data['event_end_y'])) echo $form_data['event_end_y']; ?>">
				<span class="help-inline"><?php echo form_error('event_end_y'); ?></span>
			</div><span style="float:left;">/</span>
			<div style="float:left;">
				<input type="text" name="event_end_m" maxlength="2" size="2" style="width:50%;" value="<?php if (isset($form_data['event_end_m'])) echo $form_data['event_end_m']; ?>">
				<span class="help-inline"><?php echo form_error('event_end_m'); ?></span>
			</div><span style="float:left;">/</span>
			<div style="float:left;">
				<input type="text" name="event_end_d" maxlength="2" size="2" style="width:50%;" value="<?php if (isset($form_data['event_end_d'])) echo $form_data['event_end_d']; ?>">
				<span class="help-inline"><?php echo form_error('event_end_d'); ?></span>
			</div><span style="float:left;"> </span>
			<div style="float:left;">
				<input type="text" name="event_end_h" maxlength="2" size="2" style="width:50%;" value="<?php if (isset($form_data['event_end_h'])) echo $form_data['event_end_h']; ?>">
				<span class="help-inline"><?php echo form_error('event_end_h'); ?></span>
			</div><span style="float:left;">:</span>
			<div style="float:left;">
				<input type="text" name="event_end_i" maxlength="2" size="2" style="width:50%;" value="<?php if (isset($form_data['event_end_i'])) echo $form_data['event_end_i']; ?>">
				<span class="help-inline"><?php echo form_error('event_end_i'); ?></span>
			</div>
		</div>
	</div>
	
	<!-- Location -->
	
	<div class="control-group <?php echo form_error('event_location') ? 'error' : ''; ?>">
		<?php echo form_label('Event Location'. lang('bf_form_label_required'), 'event_location', array('class' => "control-label") ); ?>
		<div class='controls'>
		<?php 
	 		if (isset($form_data['event_location'])) {
				$location_value = $form_data['event_location'];
			} else {
				$location_value = 'Name';
			} ?>
		<input type="text" name="event_location" id="event_location" value="<?php echo $location_value; ?>" maxlength="255" size="50" style="width:50%; font-size:24px; height:24px;">
		<span class="help-inline"><?php echo form_error('event_location'); ?></span>
		</div>
	</div>
	
	<div class="control-group <?php echo form_error('ck_content') ? 'error' : ''; ?>">
		<?php echo form_label('Content'.lang('bf_form_label_required'), 'ck_content',array('class'=>"control-label")); ?>
		<div class='controls'>
		<textarea name="ck_content" id="ck_content" ><?php
			if (isset($form_data['ck_content'])){
				echo $form_data['ck_content'];
			} else {
				echo lang('event_edit_text');
			};
		?></textarea>
		<?php echo display_ckeditor($ckeditor_data['ckeditor']); ?>
		
		<span class="help-inline"><?php echo form_error('ck_content'); ?></span>
		</div>
	</div>
	
	<div class="form-actions">
        <br/>
        <input type="submit" name="submit" class="btn btn-primary" value="Create" />
        or <?php echo anchor(SITE_AREA .'/reports/event/manage', lang('events_cancel'), 'class="btn btn-warning"'); ?>
    </div>
	
</fieldset>
<?php echo form_close(); ?>
</div>