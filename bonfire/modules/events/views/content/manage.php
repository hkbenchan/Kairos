<div class="admin-box">
<h3>Announcement List</h3>
<div class="announcement_list">
<?php echo form_open($this->uri->uri_string()); ?>
	<table class="table table-striped">
	<thead>
		<tr>
			<th class="column-check"><input class="check-all" type="checkbox" /></th>
			<th><b>Title</b></th>
			<th><b>Content</b></th>
			<th><b>Created At</b></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan = "3">
				<?php echo lang('bf_with_selected') ?>
				<input type="submit" name="delete" value="Delete" class="btn btn-danger" onclick="return confirm('<?php echo lang('announcement_delete_confirm'); ?>')">
			</td>
			<td><?php echo $this->pagination->create_links(); ?></td>
		</tr>
	</tfoot>
	
	<?php if (isset($announcement_list) && is_array($announcement_list) && count($announcement_list)): ?>
	<tbody>
		<?php foreach ($announcement_list as $id => $row): ?>
		<tr class="announcement_item">
			<td><input type="checkbox" name="checked[]" value="<?php echo $row['entry_id']; ?>"></td>
			<td><?php echo anchor(SITE_AREA .'/content/announcement/edit/'. $row['entry_id'], '<i class="icon-pencil">&nbsp;</i>' .  $row['title']) ?></td>
			<td><?php echo $row['content']; ?></td>
			<td><?php echo date('Y-m-d H:i',$row['created_at']); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif;?>
	
	</table>
<?php echo form_close(); ?>
</div>
</div>