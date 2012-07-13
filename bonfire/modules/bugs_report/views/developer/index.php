<div class="admin-box">
	<h3>Bugs report</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($this->auth->has_permission('Bugs_report.Developer.Delete') && isset($records) && is_array($records) && count($records)) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Type - e.g. UI or php error</th>
					<th>URL</th>
					<th>Description - e.g. procedures on reproducing the bug and your platform</th>
					<th>Status</th>
					<th>Created</th>
					<th>Modified</th>
				</tr>
			</thead>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<tfoot>
				<?php if ($this->auth->has_permission('Bugs_report.Developer.Delete')) : ?>
				<tr>
					<td colspan="7">
						<?php echo lang('bf_with_selected') ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('bugs_report_delete_confirm'); ?>')">
					</td>
				</tr>
				<?php endif;?>
			</tfoot>
			<?php endif; ?>
			<tbody>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $record) : ?>
				<tr>
					<?php if ($this->auth->has_permission('Bugs_report.Developer.Delete')) : ?>
					<td><input type="checkbox" name="checked[]" value="<?php echo $record->bug_id ?>" /></td>
					<?php endif;?>
					
				<?php if ($this->auth->has_permission('Bugs_report.Developer.Edit')) : ?>
				<td><?php echo anchor(SITE_AREA .'/developer/bugs_report/edit/'. $record->bug_id, '<i class="icon-pencil">&nbsp;</i>' .  $record->bugs_report_bug_type) ?></td>
				<?php else: ?>
				<td><?php echo $record->bugs_report_bug_type ?></td>
				<?php endif; ?>
			
				<td><?php echo $record->bugs_report_URL?></td>
				<td><?php echo $record->bugs_report_descr?></td>
				<td><?php echo $record->bugs_report_Status?></td>
				<td><?php echo $record->created_on?></td>
				<td><?php echo $record->modified_on?></td>
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="7">No records found that match your selection.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
</div>