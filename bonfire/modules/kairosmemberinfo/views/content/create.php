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
	
		<!-- First name  -->
	
        <div class="control-group <?php echo form_error('kairosmemberinfo_firstname') ? 'error' : ''; ?>">
            <?php echo form_label('First Name'. lang('bf_form_label_required'), 'kairosmemberinfo_firstname', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_firstname" type="text" name="kairosmemberinfo_firstname" maxlength="32" value="<?php echo set_value('kairosmemberinfo_firstname', isset($kairosmemberinfo['kairosmemberinfo_firstname']) ? $kairosmemberinfo['kairosmemberinfo_firstname'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_firstname'); ?></span>
        </div>

		<!-- Middle Name  -->

        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_middlename') ? 'error' : ''; ?>">
            <?php echo form_label('Middle Name', 'kairosmemberinfo_middlename', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_middlename" type="text" name="kairosmemberinfo_middlename" maxlength="32" value="<?php echo set_value('kairosmemberinfo_middlename', isset($kairosmemberinfo['kairosmemberinfo_middlename']) ? $kairosmemberinfo['kairosmemberinfo_middlename'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_middlename'); ?></span>
        </div>

		<!-- Last Name  -->

        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_lastname') ? 'error' : ''; ?>">
            <?php echo form_label('Last name'. lang('bf_form_label_required'), 'kairosmemberinfo_lastname', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_lastname" type="text" name="kairosmemberinfo_lastname" maxlength="32" value="<?php echo set_value('kairosmemberinfo_lastname', isset($kairosmemberinfo['kairosmemberinfo_lastname']) ? $kairosmemberinfo['kairosmemberinfo_lastname'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_lastname'); ?></span>
        </div>

		<!-- Date of Birth  -->

        </div>
        <div class="control-group <?php echo form_error('kairosmemberinfo_dob') ? 'error' : ''; ?>">
            <?php echo form_label('Date Of Birth (DD/MM/YYYY)'. lang('bf_form_label_required'), 'kairosmemberinfo_dob', array('class' => "control-label") ); ?>
        <div class='controls'>
	
        <input id="kairosmemberinfo_dob_d" type="text" name="kairosmemberinfo_dob_d" maxlength="2" style="width:2%" value="<?php echo set_value('kairosmemberinfo_dob_d', isset($kairosmemberinfo['kairosmemberinfo_dob_d']) ? $kairosmemberinfo['kairosmemberinfo_dob_d'] : ''); ?>"  />
		<span>/</span>
		<input id="kairosmemberinfo_dob_m" type="text" name="kairosmemberinfo_dob_m" maxlength="2" style="width:2%" value="<?php echo set_value('kairosmemberinfo_dob_m', isset($kairosmemberinfo['kairosmemberinfo_dob_m']) ? $kairosmemberinfo['kairosmemberinfo_dob_m'] : ''); ?>"  />
		<span>/</span>
        <input id="kairosmemberinfo_dob_y" type="text" name="kairosmemberinfo_dob_y" maxlength="4" style="width:4%" value="<?php echo set_value('kairosmemberinfo_dob_y', isset($kairosmemberinfo['kairosmemberinfo_dob_y']) ? $kairosmemberinfo['kairosmemberinfo_dob_y'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_dob'); ?></span>
        </div>
        </div>


		<!-- Nationality  -->

        <?php // Change the values in this array to populate your dropdown as required ?>

<?php 
		foreach ($country_code as $row => $record)
		{
			//echo $row . '=>' . $record->nid . ' + ' . $record->name ;
			$options_nid[$record->nid] = $record->name;
		}
?>

        <?php echo form_dropdown('kairosmemberinfo_nationalityID', $options_nid, set_value('kairosmemberinfo_nationalityID', isset($kairosmemberinfo['kairosmemberinfo_nationalityID']) ? $kairosmemberinfo['kairosmemberinfo_nationalityID'] : ''), 'Nationality'. lang('bf_form_label_required'))?>        

		
		<!-- Gender  -->
		
		<div class="control-group <?php echo form_error('kairosmemberinfo_gender') ? 'error' : ''; ?>">
            <?php echo form_label('Gender'. lang('bf_form_label_required'), 'kairosmemberinfo_gender', array('class' => "control-label") ); ?>
       <div class='controls'>
			<?php
				$radio_gender = null;
				if (isset($kairosmemberinfo['kairosmemberinfo_gender'])) {
					if ($kairosmemberinfo['kairosmemberinfo_gender']=='M'){
						$radio_gender = 'M';
					}
					elseif ($kairosmemberinfo['kairosmemberinfo_gender']=='F'){
						$radio_gender = 'F';
					}
				}
			
			?>
            <input id="kairosmemberinfo_gender_M" name="kairosmemberinfo_gender" type="radio" value="M"
				<?php
				 	if ($radio_gender == 'M')
						echo set_radio('kairosmemberinfo_gender', 'M', TRUE);
					else
					 	echo set_radio('kairosmemberinfo_gender', 'M');
				?> />M<br>
            <input id="kairosmemberinfo_gender_F" name="kairosmemberinfo_gender" type="radio" value="F"
				<?php
				 	if ($radio_gender == 'F')
						echo set_radio('kairosmemberinfo_gender', 'F', TRUE);
					else
						echo set_radio('kairosmemberinfo_gender', 'F');
				?> />F
            <span class="help-inline"><?php echo form_error('kairosmemberinfo_gender'); ?></span>
        </div>
		</div>
		
		<!-- University  -->
		
		<?php // Change the values in this array to populate your dropdown as required ?>

		<?php 
				foreach ($university_code as $row => $record)
				{
					//echo $row . '=>' . $record->uid . ' + ' . $record->name ;
					$options_uid[$record->uid] = $record->name;
				}
		?>

		        <?php echo form_dropdown('kairosmemberinfo_UniversityID', $options_uid, set_value('kairosmemberinfo_UniversityID', isset($kairosmemberinfo['kairosmemberinfo_UniversityID']) ? $kairosmemberinfo['kairosmemberinfo_UniversityID'] : ''), 'University/Institution'. lang('bf_form_label_required'))?>
		
		
		<!-- Year Of Study  -->

		<?php // Change the values in this array to populate your dropdown as required ?>

		<?php $options_yos = array(
		                '0' => '0',
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'Others' => 'Others'
		); ?>

		        <?php echo form_dropdown('kairosmemberinfo_yearOfStudy', $options_yos, set_value('kairosmemberinfo_yearOfStudy', isset($kairosmemberinfo['kairosmemberinfo_yearOfStudy']) ? $kairosmemberinfo['kairosmemberinfo_yearOfStudy'] : ''), 'Year of Study'. lang('bf_form_label_required'))?>

		<!-- Phone number  -->
		
        <div class="control-group <?php echo form_error('kairosmemberinfo_phoneNo') ? 'error' : ''; ?>">
            <?php echo form_label('Contact Number'. lang('bf_form_label_required'), 'kairosmemberinfo_phoneNo', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_phoneNo" type="text" name="kairosmemberinfo_phoneNo" maxlength="14" value="<?php echo set_value('kairosmemberinfo_phoneNo', isset($kairosmemberinfo['kairosmemberinfo_phoneNo']) ? $kairosmemberinfo['kairosmemberinfo_phoneNo'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_phoneNo'); ?></span>
        </div>
		</div>
		
		<!-- Own venture  -->

		<div class="control-group <?php echo form_error('kairosmemberinfo_ownVenture') ? 'error' : ''; ?>">
            <?php echo form_label('Do you have your own venture?'. lang('bf_form_label_required'), 'kairosmemberinfo_ownVenture', array('class' => "control-label") ); ?>
       <div class='controls'>

		<?php $radio_venture = null;
			if (isset($kairosmemberinfo['kairosmemberinfo_ownVenture'])){
				if ($kairosmemberinfo['kairosmemberinfo_ownVenture'] == 'T'){
					$radio_venture = 'T';
				} elseif ($kairosmemberinfo['kairosmemberinfo_ownVenture'] == 'F'){
					$radio_venture = 'F';
				}
			}
		?>
		
            <input id="kairosmemberinfo_ownVentureT" name="kairosmemberinfo_ownVenture" type="radio" value="T"
			<?php
			 	if ($radio_venture == 'T')
					echo set_radio('kairosmemberinfo_ownVenture', 'T', TRUE);
				else
				 	echo set_radio('kairosmemberinfo_ownVenture', 'T');
			?> />
            T<br>
            <input id="kairosmemberinfo_ownVentureF" name="kairosmemberinfo_ownVenture" type="radio" value="F"
			<?php
			 	if ($radio_venture == 'F')
					echo set_radio('kairosmemberinfo_ownVenture', 'F', TRUE);
				else
				 	echo set_radio('kairosmemberinfo_ownVenture', 'F');
			?> />
            F
            <span class="help-inline"><?php echo form_error('kairosmemberinfo_ownVenture'); ?></span>
        </div>
		</div>
		
		<div id="kairosmemberinfo_ventureFollowUp" style="display:none">

		<!-- Industry ID -->

		<?php // Change the values in this array to populate your dropdown as required ?>

		<?php
				foreach ($industry_code as $row => $record)
				{
					//echo $row . '=>' . $record->uid . ' + ' . $record->name ;
					$options_iid[$record->iid] = $record->name;
				}
		?>

		<?php echo form_dropdown('kairosmemberinfo_IndustryID', $options_iid, set_value('kairosmemberinfo_IndustryID', isset($kairosmemberinfo['kairosmemberinfo_IndustryID']) ? $kairosmemberinfo['kairosmemberinfo_IndustryID'] : ''), 'Industry'. lang('bf_form_label_required'))?>
		
		<!-- Name of Venture -->

        <div class="control-group <?php echo form_error('kairosmemberinfo_ventureName') ? 'error' : ''; ?>">
            <?php echo form_label('Name of Venture'. lang('bf_form_label_required'), 'kairosmemberinfo_ventureName', array('class' => "control-label") ); ?>
            <div class='controls'>
        <input id="kairosmemberinfo_ventureName" type="text" name="kairosmemberinfo_ventureName" maxlength="100" value="<?php echo set_value('kairosmemberinfo_ventureName', isset($kairosmemberinfo['kairosmemberinfo_ventureName']) ? $kairosmemberinfo['kairosmemberinfo_ventureName'] : ''); ?>"  />
        <span class="help-inline"><?php echo form_error('kairosmemberinfo_ventureName'); ?></span>
        </div>
		</div>
		
		<!-- Description of Venture -->
		
		<?php
			$descrVenture = array(
				'name' => 'kairosmemberinfo_ventureDescr',
				'id' => 'kairosmemberinfo_ventureDescr',
				'rows' => '10',
				'cols' => '40',
				'value' => isset($kairosmemberinfo_ventureDescr) ? $kairosmemberinfo_ventureDescr : ''
			);
		?>
		<div class="control-group <?php echo form_error('kairosmemberinfo_ventureDescr') ? 'error' : ''; ?>">
            <?php echo form_label('Description of Venture'. lang('bf_form_label_required'), 'kairosmemberinfo_ventureDescr', array('class' => "control-label") ); ?>
            <div class='controls'>
			<?php echo form_textarea($descrVenture)?>
			<span class="help-inline"><?php echo form_error('kairosmemberinfo_ventureDescr'); ?></span>
		</div>
		</div>

		</div>
		
		
		<!-- Special Skills -->
		
		<?php
			$skills = array(
				'name' => 'kairosmemberinfo_skills',
				'id' => 'kairosmemberinfo_skills',
				'rows' => '10',
				'cols' => '40',
				'value' => isset($kairosmemberinfo_skills) ? $kairosmemberinfo_skills : ''
			);
		?>
		
		<div class="control-group <?php echo form_error('kairosmemberinfo_skills') ? 'error' : ''; ?>">
            <?php echo form_label('Special Skills', 'kairosmemberinfo_skills', array('class' => "control-label") ); ?>
            <div class='controls'>
			<?php echo form_textarea($skills)?>
			<span class="help-inline"><?php echo form_error('kairosmemberinfo_skills'); ?></span>
		</div>
		</div>
		
		<!-- Preference -->
		<?php
		
		
		?>
		<div class="control-group">
			<div class='controls'>
				<?php // preference code
					foreach ($preference_code as $id => $row): ?>
						<label class="checkbox" for="<?php echo "kairosmemberinfo_preference".$row['pid'];?>">
						<?php $data = array(
							'name' => 'kairosmemberinfo_preference',
							'id' => 'kairosmemberinfo_preference'.$row['pid'],
							'value' => $row['description'],
							'checked' => set_checkbox('kairosmemberinfo_preference',$row['description']),
						);
							echo form_checkbox($data);
						?>
						</label>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- Newsletter  -->
		
		
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
            <input type="submit" name="submit" class="btn btn-primary" value="Submit Application part 1" />
            or <?php echo anchor(SITE_AREA .'/content/kairosmemberinfo', lang('kairosmemberinfo_cancel'), 'class="btn btn-warning"'); ?>
            
        </div>
    </fieldset>
    <?php echo form_close(); ?>


</div>