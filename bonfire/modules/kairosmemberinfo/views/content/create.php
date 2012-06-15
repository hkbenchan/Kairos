
<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php // Change the css classes to suit your needs
if( isset($kairosmemberinfo) ) {
    $kairosmemberinfo = (array)$kairosmemberinfo;
}
$id = isset($kairosmemberinfo['id']) ? $kairosmemberinfo['id'] : '';
?>
<div class="admin-box">
    <h3>KairosMemberInfo</h3>
<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
    <fieldset>
        <div class="control-group <?php echo form_error('kairosmemberinfo_surname') ? 'error' : ''; ?>">
            <?php echo form_label('Surname'. lang('bf_form_label_required'), 'kairosmemberinfo_surname', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_surname" type="text" name="kairosmemberinfo_surname" maxlength="32" value="<?php echo set_value('kairosmemberinfo_surname', isset($kairosmemberinfo['kairosmemberinfo_surname']) ? $kairosmemberinfo['kairosmemberinfo_surname'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_surname'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_middlename') ? 'error' : ''; ?>">
            <?php echo form_label('Middle Name', 'kairosmemberinfo_middlename', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_middlename" type="text" name="kairosmemberinfo_middlename" maxlength="32" value="<?php echo set_value('kairosmemberinfo_middlename', isset($kairosmemberinfo['kairosmemberinfo_middlename']) ? $kairosmemberinfo['kairosmemberinfo_middlename'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_middlename'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_lastname') ? 'error' : ''; ?>">
            <?php echo form_label('Last name'. lang('bf_form_label_required'), 'kairosmemberinfo_lastname', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_lastname" type="text" name="kairosmemberinfo_lastname" maxlength="32" value="<?php echo set_value('kairosmemberinfo_lastname', isset($kairosmemberinfo['kairosmemberinfo_lastname']) ? $kairosmemberinfo['kairosmemberinfo_lastname'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_lastname'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_dob') ? 'error' : ''; ?>">
            <?php echo form_label('Date Of Birth'. lang('bf_form_label_required'), 'kairosmemberinfo_dob', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_dob" type="text" name="kairosmemberinfo_dob" maxlength="8" value="<?php echo set_value('kairosmemberinfo_dob', isset($kairosmemberinfo['kairosmemberinfo_dob']) ? $kairosmemberinfo['kairosmemberinfo_dob'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_dob'); ?></span>
        </div>


        </div>


        <?php // Change the values in this array to populate your dropdown as required ?>

<?php $options = array(
                10 => 10,
); ?>

        <?php echo form_dropdown('kairosmemberinfo_nationality_id', $options, set_value('kairosmemberinfo_nationality_id', isset($kairosmemberinfo['kairosmemberinfo_nationality_id']) ? $kairosmemberinfo['kairosmemberinfo_nationality_id'] : ''), 'Nationality'. lang('bf_form_label_required'))?>        <div class="control-group <?php echo form_error('kairosmemberinfo_gender') ? 'error' : ''; ?>">
            <?php echo form_label('Gender'. lang('bf_form_label_required'), 'kairosmemberinfo_gender', array('class' => "control-label") ); ?>
            <div class='controls'>
        <label class="radio">
            <input id="kairosmemberinfo_gender" name="kairosmemberinfo_gender" type="radio" class="" value="option1" <?php echo set_radio('kairosmemberinfo_gender', 'option1', TRUE); ?> />
            <label for="kairosmemberinfo_gender">Radio option 1</label>
            <input id="kairosmemberinfo_gender" name="kairosmemberinfo_gender" type="radio" class="" value="option2" <?php echo set_radio('kairosmemberinfo_gender', 'option2'); ?> />
            <label for="kairosmemberinfo_gender">Radio option 2</label>
            <span class="help-inline"><?php echo form_error('kairosmemberinfo_gender'); ?></span>
            </label>
        </div>



        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_University') ? 'error' : ''; ?>">
            <?php echo form_label('University'. lang('bf_form_label_required'), 'kairosmemberinfo_University', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_University" type="text" name="kairosmemberinfo_University" maxlength="255" value="<?php echo set_value('kairosmemberinfo_University', isset($kairosmemberinfo['kairosmemberinfo_University']) ? $kairosmemberinfo['kairosmemberinfo_University'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_University'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_yearOfStudy') ? 'error' : ''; ?>">
            <?php echo form_label('Year of Study'. lang('bf_form_label_required'), 'kairosmemberinfo_yearOfStudy', array('class' => "control-label") ); ?>
            <div class='controls'>
        <label class="radio">
            <input id="kairosmemberinfo_yearOfStudy" name="kairosmemberinfo_yearOfStudy" type="radio" class="" value="option1" <?php echo set_radio('kairosmemberinfo_yearOfStudy', 'option1', TRUE); ?> />
            <label for="kairosmemberinfo_yearOfStudy">Radio option 1</label>
            <input id="kairosmemberinfo_yearOfStudy" name="kairosmemberinfo_yearOfStudy" type="radio" class="" value="option2" <?php echo set_radio('kairosmemberinfo_yearOfStudy', 'option2'); ?> />
            <label for="kairosmemberinfo_yearOfStudy">Radio option 2</label>
            <span class="help-inline"><?php echo form_error('kairosmemberinfo_yearOfStudy'); ?></span>
            </label>
        </div>



        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_phoneNo') ? 'error' : ''; ?>">
            <?php echo form_label('Contact Number'. lang('bf_form_label_required'), 'kairosmemberinfo_phoneNo', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_phoneNo" type="text" name="kairosmemberinfo_phoneNo" maxlength="14" value="<?php echo set_value('kairosmemberinfo_phoneNo', isset($kairosmemberinfo['kairosmemberinfo_phoneNo']) ? $kairosmemberinfo['kairosmemberinfo_phoneNo'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_phoneNo'); ?></span>
        </div>


        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_newsletterUpdate') ? 'error' : ''; ?>">
            <?php echo form_label('Receive Future Updates and Newsletter'. lang('bf_form_label_required'), 'kairosmemberinfo_newsletterUpdate', array('class' => "control-label") ); ?>
            <div class='controls'>
            <label class="checkbox" for="kairosmemberinfo_newsletterUpdate">
            <input type="checkbox" id="kairosmemberinfo_newsletterUpdate" name="kairosmemberinfo_newsletterUpdate" value="1" <?php echo (isset($kairosmemberinfo['kairosmemberinfo_newsletterUpdate']) && $kairosmemberinfo['kairosmemberinfo_newsletterUpdate'] == 1) ? 'checked="checked"' : set_checkbox('kairosmemberinfo_newsletterUpdate', 1); ?>>
            <span class="help-inline"><?php echo form_error('kairosmemberinfo_newsletterUpdate'); ?></span>
            </label>

        </div>

        </div>



        <div class="form-actions">
            <br/>
            <input type="submit" name="submit" class="btn btn-primary" value="Create KairosMemberInfo" />
            or <?php echo anchor(SITE_AREA .'/content/kairosmemberinfo', lang('kairosmemberinfo_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>
