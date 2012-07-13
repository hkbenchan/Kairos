<!-- Content -->

<div class="admin-box">
	<h3>Your Information</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<tbody>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
				<tr>
					<?php if ($this->auth->has_permission('KairosMemberInfo.Content.Delete')) : ?>
					<div style="display:none">
						<input type="checkbox" name="checked[]" checked="checked" value="<?php echo $records["entry_id"] ?>" />
					</div>
					<?php endif;?>
					<td>First Name</td>
					<td><?php echo $records['kairosmemberinfo_firstname']; ?></td>
				</tr>
				<?php if (isset($records['kairosmemberinfo_middlename'])) : ?>
				<tr>
					<td>Middle Name</td>
					<td><?php echo $records['kairosmemberinfo_middlename']; ?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td>Last Name</td>
					<td><?php echo $records['kairosmemberinfo_lastname']; ?></td>
				</tr>
				<tr>
					<td>Date of Birth (YYYY-MM-DD)</td>
					<td><?php echo $records['kairosmemberinfo_dob']; ?></td>
				</tr>
				<tr>
					<td>Gender</td>
					<td><?php echo $records['kairosmemberinfo_gender']; ?></td>
				</tr>
				<tr>
					<td>Country</td>
					<td><?php echo $records['kairosmemberinfo_nationality']; ?></td>
				</tr>
				<tr>
					<td>University</td>
					<td><?php echo $records['kairosmemberinfo_University']; ?></td>
				</tr>
				<tr>
					<td>Year of Study</td>
					<td><?php echo $records['kairosmemberinfo_yearOfStudy']; ?></td>
				</tr>
				<tr>
					<td>Phone Number</td>
					<td><?php echo $records['kairosmemberinfo_phoneNo']; ?></td>
				</tr>
				<tr>
					<td>Venture (T/F)</td>
					<td><?php echo $records['kairosmemberinfo_ownVenture']; ?></td>
				</tr>
				<?php if (($records['kairosmemberinfo_ownVenture'])=='T') :?>
					<tr>
						<td>Venture Name</td>
						<td><?php echo $records['kairosmemberinfo_ventureName']; ?></td>
					</tr>
					<tr>
						<td>Venture Nature</td>
						<td><?php echo $records['kairosmemberinfo_ventureIndustry']; ?></td>
					</tr>
					<tr>
						<td>Venture Description</td>
						<td><?php echo $records['kairosmemberinfo_ventureDescr']; ?></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td>Special Skills</td>
					<td><?php echo $records['kairosmemberinfo_skills']; ?></td>
				</tr>
				<tr>
					<td>Receive future Newsletter (T/F)</td>
					<td><?php echo $records['kairosmemberinfo_newsletterUpdate']==1 ? 'T':'F'; ?></td>
				</tr>
			<?php else: ?>
				<tr>
					<td colspan="11">You have not entered your information. <?php anchor(SITE_AREA . 'content/kairosmemberinfo/create','Click here to create',''); ?></td>
				</tr>
			<?php endif; ?>
			</tbody>
			
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<tfoot>
				<?php if ($this->auth->has_permission('KairosMemberInfo.Content.Delete')) : ?>
				<tr>
					<td>
					<?php echo anchor(SITE_AREA .'/content/kairosmemberinfo/edit/'. $records['uid'], '<i class="icon-pencil">&nbsp;</i> EDIT') ?>
					</td>
					<td>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('kairosmemberinfo_delete_confirm'); ?>')">
					</td>
				</tr>
				<?php else: ?>
				<tr>
					<td colspan="2">
					<?php echo anchor(SITE_AREA .'/content/kairosmemberinfo/edit/'. $records['uid'], '<i class="icon-pencil">&nbsp;</i>' .  $records['kairosmemberinfo_firstname']) ?>
					</td>
				</tr>
				<?php endif;?>
			</tfoot>
			<?php endif; ?>
			
			
		</table>
	<?php echo form_close(); ?>
</div>