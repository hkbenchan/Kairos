<?php if (validation_errors()) : ?>
<div class="alert alert-block alert-error fade in ">
  <a class="close" data-dismiss="alert">&times;</a>
  <h4 class="alert-heading">Please fix the following errors :</h4>
 <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<div class="admin-box">
	<?php echo form_open(); ?>
	<fieldset>
		<input type="hidden" name="total" value="<?php echo $total; ?>">
		<?php if (isset($users_data) && is_array($users_data) && count($users_data)) : ?>
		<?php $i = 0; ?>
		<?php foreach ($users_data as $user): ?>
			<?php if (isset($form_data) && is_array($form_data) && count($form_data)) $current_data = $form_data[$i]; ?>
			<h3>User - <?php echo $i+1; ?></h3>
			<table class="table table-striped">
				<tbody>
					
					<?php if (isset($user['info']) && is_array($user['info']) && count($user['info'])) : ?>
						<?php if (isset($user['info']['uid'])) : ?>
						<input type="hidden" name="uid_<?php echo $i; ?>" value="<?php echo $user['info']['uid'];?>">
						<?php endif; ?>
						<?php if (isset($user['info']['kairosmemberinfo_firstname'])) : ?>
						<tr>
							<td>First Name</td>
							<td><?php echo $user['info']['kairosmemberinfo_firstname']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_middlename'])) : ?>
						<tr>
							<td>Middle Name</td>
							<td><?php echo $user['info']['kairosmemberinfo_middlename']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_lastname'])) : ?>
						<tr>
							<td>Last Name</td>
							<td><?php echo $user['info']['kairosmemberinfo_lastname']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_dob'])) : ?>
						<tr>
							<td>Date of Birth (YYYY-MM-DD)</td>
							<td><?php echo $user['info']['kairosmemberinfo_dob']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_gender'])) : ?>
						<tr>
							<td>Gender</td>
							<td><?php echo $user['info']['kairosmemberinfo_gender']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_nationality'])) : ?>
						<tr>
							<td>Country</td>
							<td><?php echo $user['info']['kairosmemberinfo_nationality']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_University'])) : ?>
						<tr>
							<td>University</td>
							<td><?php echo $user['info']['kairosmemberinfo_University']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_yearOfStudy'])) : ?>
						<tr>
							<td>Year of Study</td>
							<td><?php echo $user['info']['kairosmemberinfo_yearOfStudy']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_phoneNo'])) : ?>
						<tr>
							<td>Phone Number</td>
							<td><?php echo $user['info']['kairosmemberinfo_phoneNo']; ?></td>
						</tr>
						<?php endif; ?>
						
						<?php if (isset($user['info']['kairosmemberinfo_ownVenture'])) : ?>
						<tr>
							<td>Venture (T/F)</td>
							<td><?php echo $user['info']['kairosmemberinfo_ownVenture']; ?></td>
						</tr>
						<?php endif; ?>
					<?php endif; ?>
					
					<tr>
						<td>Membership Type</td>
						<td><input type="text" name="m_type_<?php echo $i;?>" size="30" maxlength="100" 
						value="<?php if (isset($current_data)) {
							echo $current_data['m_type'];
						} elseif (isset($user['ship']['m_type'])) {
							echo $user['ship']['m_type'];
						} ?>"></td>
					</tr>
					<tr>
						<td>Valid From (DD-MM-YYYY)</td>
						<td><input type="text" name="valid_from_d_<?php echo $i;?>" style="width:2%" maxlength="2" 
						value="<?php if (isset($current_data)) {
							echo $current_data['valid_from_d'];
						} elseif (isset($user['ship']['valid_from_d'])) {
							echo $user['ship']['valid_from_d'];
						} ?>">
						/<input type="text" name="valid_from_m_<?php echo $i;?>" style="width:2%" maxlength="2" 
						value="<?php if (isset($current_data)) {
							echo $current_data['valid_from_m'];
						} elseif (isset($user['ship']['valid_from_m'])) {
							echo $user['ship']['valid_from_m'];
						} ?>">
						/<input type="text" name="valid_from_y_<?php echo $i;?>" style="width:3%" maxlength="4" 
						value="<?php if (isset($current_data)) {
							echo $current_data['valid_from_y'];
						} elseif (isset($user['ship']['valid_from_y'])) {
							echo $user['ship']['valid_from_y'];
						} ?>"></td>
					</tr>
					<tr>
						<td>Valid To (DD-MM-YYYY)</td>
						<td><input type="text" name="valid_to_d_<?php echo $i;?>" style="width:2%" maxlength="2" 
						value="<?php if (isset($current_data)) {
							echo $current_data['valid_to_d'];
						} elseif (isset($user['ship']['valid_to_d'])) {
							echo $user['ship']['valid_to_d'];
						} ?>">
						/<input type="text" name="valid_to_m_<?php echo $i;?>" style="width:2%" maxlength="2" 
						value="<?php if (isset($current_data)) {
							echo $current_data['valid_to_m'];
						} elseif (isset($user['ship']['valid_to_m'])) {
							echo $user['ship']['valid_to_m'];
						} ?>">
						/<input type="text" name="valid_to_y_<?php echo $i;?>" style="width:3%" maxlength="4" 
						value="<?php if (isset($current_data)) {
							echo $current_data['valid_to_y'];
						} elseif (isset($user['ship']['valid_to_y'])) {
							echo $user['ship']['valid_to_y'];
						} ?>"></td>
					</tr>
					<tr>
						<td>Paid?</td>
						<td><input type="radio" name="paid_<?php echo $i;?>" value="T" 
						<?php if (isset($current_data) && $current_data['paid'] == 'T') {
							echo 'checked="checked"';
						} elseif (isset($user['ship']['paid']) && $user['ship']['paid'] == 'T') {
							echo 'checked="checked"';
						}?>>T<br>
							<input type="radio" name="paid_<?php echo $i;?>" value="F"
						<?php if (isset($current_data) && $current_data['paid'] == 'F') {
							echo 'checked="checked"';
						} elseif (isset($user['ship']['paid']) && $user['ship']['paid'] == 'F') {
							echo 'checked="checked"';
						}?>>F</td>
					</tr>
					<tr>
						<td>Ignore this entry</td>
						<td><input type="checkbox" name="ignore[]" value="<?php echo $i; ?>"
						<?php if (isset($ignore) && array_search($i, $ignore)!==FALSE) echo 'checked="checked"'; ?>"></td>
					</tr>
				</tbody>
			</table>
			<br>
			<?php $i++; ?>
			<?php if (isset($current_data)) unset($current_data); ?>
		<?php endforeach; ?>
		<table class="table table-striped">
			<tfoot>
				<tr>
					<td>
						<input type="submit" class="btn btn-primary" value="Submit">
						or <?php echo anchor(SITE_AREA .'/reports/kairosmemberinfo/manage', lang('kairosmemberinfo_cancel'), 'class="btn btn-warning"'); ?>
					</td>
				</tr>
			</tfoot>
		</table>
		<?php endif; ?>
	</fieldset>
	<?php echo form_close(); ?>
</div>