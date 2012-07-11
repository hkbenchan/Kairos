
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
    <h3>KairosMemberInfo</h3>
<?php echo form_open_multipart($this->uri->uri_string() . '_upload', 'class="form-horizontal"'); ?>
    <fieldset>
	
		<input type="file" name="userfile" size="20" />

        <div class="form-actions">
            <br/>
            <input type="submit" name="submit" class="btn btn-primary" value="Upload CV" />
            or <?php echo anchor(SITE_AREA .'/content/kairosmemberinfo', lang('kairosmemberinfo_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
