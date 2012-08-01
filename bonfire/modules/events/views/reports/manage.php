<div class="admin-box">
<h3>Event List</h3>
<div class="events_list">
<?php echo form_open($this->uri->uri_string()); ?>
	<table class="table table-striped">
	<tfoot>
		<tr>
			<td colspan="6"><?php echo lang('bf_with_selected') ?><input type="submit" name="delete" class="btn btn-danger" value="Delete" />
			<?php echo $this->pagination->create_links(); ?>
			</td>
		</tr>
	</tfoot>
	
	<?php if (isset($events_list) && is_array($events_list) && count($events_list)): ?>
	<thead>
		<tr>
			<th class="column-check"><input class="check-all" type="checkbox" /></th>
			<th>Event Name</th>
			<th>Location</th>
			<th>Time</th>
			<th>Content</th>
			<th>No. of Participates<br>(Click to download CSV)</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($events_list as $id => $row): ?>
		<tr>
			<td><input type="checkbox" name="checked[]" value="<?php echo $row['event_id']; ?>"></td>
			<td><?php echo anchor(SITE_AREA .'/reports/events/edit/'. $row['event_id'], '<i class="icon-pencil">&nbsp;</i>' .  $row['title']) ?></td>
			<td><?php echo $row['location']; ?></td>
			<td><span class="start_time"><?php echo date('Y-m-d H:i',$row['start_time']); ?></span>
			 to <span class="end_time"><?php echo date('Y-m-d H:i',$row['end_time']); ?></span></td>
			<td style="width:30%;"><?php echo $row['content']; ?></td>
			<td><?php echo anchor_popup(SITE_AREA.'/reports/events/records/'.$row['event_id'], $users_list[$row['event_id']]->num_rows()); ?><br>
			<?php echo anchor(SITE_AREA.'/reports/events/approve/'.$row['event_id'], 'Approve members'); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif;?>
	
	</table>
<?php echo form_close(); ?>
</div>
</div>