
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($bugs_report) ) {
    $bugs_report = (array)$bugs_report;
}
$id = isset($bugs_report['bug_id']) ? $bugs_report['bug_id'] : '';
?>
<div class="admin-box">
    <h3>Bugs report</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('bugs_report_bug_type') ? 'error' : ''; ?>">
            <?php echo form_label('Type - e.g. UI or php error'. lang('bf_form_label_required'), 'bugs_report_bug_type', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="bugs_report_bug_type" type="text" name="bugs_report_bug_type" maxlength="30" value="<?php echo set_value('bugs_report_bug_type', isset($bugs_report['bugs_report_bug_type']) ? $bugs_report['bugs_report_bug_type'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('bugs_report_bug_type'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('bugs_report_URL') ? 'error' : ''; ?>">
            <?php echo form_label('URL', 'bugs_report_URL', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="bugs_report_URL" type="text" name="bugs_report_URL" maxlength="255" value="<?php echo set_value('bugs_report_URL', isset($bugs_report['bugs_report_URL']) ? $bugs_report['bugs_report_URL'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('bugs_report_URL'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('bugs_report_descr') ? 'error' : ''; ?>">
            <?php echo form_label('Description - e.g. procedures on reproducing the bug and your platform'. lang('bf_form_label_required'), 'bugs_report_descr', array('class' => "control-label") ); ?>
            <div class='controls'>
            <?php echo form_textarea( array( 'name' => 'bugs_report_descr', 'id' => 'bugs_report_descr', 'rows' => '5', 'cols' => '80', 'value' => set_value('bugs_report_descr', isset($bugs_report['bugs_report_descr']) ? $bugs_report['bugs_report_descr'] : '') ) )?>
            <span class="help-inline"><?php echo form_error('bugs_report_descr'); ?></span>
        </div>

        </div>
        <div class="control-group <?php echo form_error('bugs_report_Status') ? 'error' : ''; ?>">
            <?php echo form_label('Status', 'bugs_report_Status', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="bugs_report_Status" type="text" name="bugs_report_Status" maxlength="1" value="<?php echo set_value('bugs_report_Status', isset($bugs_report['bugs_report_Status']) ? $bugs_report['bugs_report_Status'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('bugs_report_Status'); ?></span>
        </div>


        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="submit" class="btn btn-primary" value="Create Bugs report" />
            or <?php echo anchor(SITE_AREA .'/reports/bugs_report', lang('bugs_report_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
