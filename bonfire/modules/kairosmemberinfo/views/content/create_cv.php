
<?php if (isset($errors)) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo $errors; ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($kairosmembercv) ) {
    $kairosmembercv = (array)$kairosmembercv;
}
$id = isset($kairosmemberinfo['id']) ? $kairosmemberinfo['id'] : '';
?>
<div class="admin-box">
    <h3>Your CV (support: doc/docx/pdf)</h3>
<?php echo form_open_multipart($this->uri->uri_string() . '_upload', 'class="form-horizontal"'); ?>
    <fieldset>
			<div class="control-group">
	            <label class="control-label">
					<p>CV:</p>
				</label>
	            <div class='controls'>
					<input type="file" name="userfile" size="50" />
				</div>
			</div>
			
        <div class="form-actions">
            <br/>
            <input type="submit" name="submit" class="btn btn-primary" value="Upload CV" />
            or <?php echo anchor(SITE_AREA .'/content/kairosmemberinfo', lang('kairosmemberinfo_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
<?php echo form_close(); ?>
	<div class="">
		<p>* Your file will be encrypted and secured in our database.</p>
	</div>
</div>
