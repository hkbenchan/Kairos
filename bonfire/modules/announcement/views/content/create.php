<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<div class="admin-box">
<h3>New Announcement</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
<fieldset>
	<div class="control-group <?php echo form_error('announcement_title') ? 'error' : ''; ?>">
		<?php echo form_label('Title'. lang('bf_form_label_required'), 'announcement_title', array('class' => "control-label") ); ?>
		<div class='controls'>
		<?php 
	 		if (isset($form_data['announcement_title'])) {
				$title_value = $form_data['announcement_title'];
			} else {
				$title_value = 'Title';
			} ?>
		<input type="text" name="announcement_title" id="announcement_title" value="<?php echo $title_value; ?>" maxlength="100" size="50" style="width:50%; font-size:24px; height:24px;">
		<span class="help-inline"><?php echo form_error('announcement_title'); ?></span>
		</div>
	</div>
	<div class="control-group <?php echo form_error('ck_content') ? 'error' : ''; ?>">
		<?php echo form_label('Content'.lang('bf_form_label_required'), 'ck_content',array('class'=>"control-label")); ?>
		<div class='controls'>
		<textarea name="ck_content" id="ck_content" ><?php
			if (isset($form_data['ck_content'])){
				echo $form_data['ck_content'];
			} else {
				echo lang('announcement_edit_text');
			};
		?></textarea>
		<?php echo display_ckeditor($ckeditor_data['ckeditor']); ?>
		
		<span class="help-inline"><?php echo form_error('ck_content'); ?></span>
		</div>
	</div>
	
	<div class="form-actions">
        <br/>
        <input type="submit" name="submit" class="btn btn-primary" value="Create" />
        or <?php echo anchor(SITE_AREA .'/content/announcement', lang('announcement_cancel'), 'class="btn btn-warning"'); ?>
    </div>
	
</fieldset>
<?php echo form_close(); ?>
</div>