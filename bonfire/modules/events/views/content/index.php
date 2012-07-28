<div class="admin-box">
<h3>Event List</h3>
<div class="events_list">
<?php echo form_open(SITE_AREA.'/content/events/join'); ?>
	<table class="table table-striped">
	<tfoot>
		<tr>
			<td colspan="5"><?php echo lang('bf_with_selected') ?><input type="submit" name="join" class="btn btn-primary" value="Join" />
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
		</tr>
	</thead>
	<tbody>
		<?php foreach ($events_list as $id => $row): ?>
		<tr>
			<td><input type="checkbox" name="checked[]" value="<?php echo $row['event_id']; ?>"></td>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $row['location']; ?></td>
			<td><?php echo date('Y-m-d H:i',$row['start_time']).' to '.date('Y-m-d H:i',$row['end_time']); ?></td>
			<td style="width:40%;"><?php echo $row['content']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif;?>
	
	</table>
<?php echo form_close(); ?>
</div>
</div>