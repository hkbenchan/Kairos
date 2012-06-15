<div class="admin-box">
	<h3>KairosMemberInfo</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($this->auth->has_permission('KairosMemberInfo.Reports.Delete') && isset($records) && is_array($records) && count($records)) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Surname</th>
					<th>Middle Name</th>
					<th>Last name</th>
					<th>Date Of Birth</th>
					<th>Nationality</th>
					<th>Gender</th>
					<th>University</th>
					<th>Year of Study</th>
					<th>Contact Number</th>
					<th>Receive Future Updates and Newsletter</th>
				</tr>
			</thead>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<tfoot>
				<?php if ($this->auth->has_permission('KairosMemberInfo.Reports.Delete')) : ?>
				<tr>
					<td colspan="11">
						<?php echo lang('bf_with_selected') ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('kairosmemberinfo_delete_confirm'); ?>')">
					</td>
				</tr>
				<?php endif;?>
			</tfoot>
			<?php endif; ?>
			<tbody>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $record) : ?>
				<tr>
					<?php if ($this->auth->has_permission('KairosMemberInfo.Reports.Delete')) : ?>
					<td><input type="checkbox" name="checked[]" value="<?php echo $record->entry_id ?>" /></td>
					<?php endif;?>
					
				<?php if ($this->auth->has_permission('KairosMemberInfo.Reports.Edit')) : ?>
				<td><?php echo anchor(SITE_AREA .'/reports/kairosmemberinfo/edit/'. $record->entry_id, '<i class="icon-pencil">&nbsp;</i>' .  $record->kairosmemberinfo_surname) ?></td>
				<?php else: ?>
				<td><?php echo $record->kairosmemberinfo_surname ?></td>
				<?php endif; ?>
			
				<td><?php echo $record->kairosmemberinfo_middlename?></td>
				<td><?php echo $record->kairosmemberinfo_lastname?></td>
				<td><?php echo $record->kairosmemberinfo_dob?></td>
				<td><?php echo $record->kairosmemberinfo_nationality_id?></td>
				<td><?php echo $record->kairosmemberinfo_gender?></td>
				<td><?php echo $record->kairosmemberinfo_University?></td>
				<td><?php echo $record->kairosmemberinfo_yearOfStudy?></td>
				<td><?php echo $record->kairosmemberinfo_phoneNo?></td>
				<td><?php echo $record->kairosmemberinfo_newsletterUpdate?></td>
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="11">No records found that match your selection.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
</div>