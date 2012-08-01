<div class="admin-box">
<h3>Confirm List</h3>
<div class="events_list">
<?php echo form_open(SITE_AREA.'/content/events/join'); ?>
	<table class="table table-striped">
	<tfoot>
		<tr>
			<td colspan="5"><input type="submit" name="confirm" class="btn btn-primary" value="Confirm" />
			or <?php echo anchor(SITE_AREA .'/content/events/', lang('events_cancel'), 'class="btn btn-warning"'); ?>
			<p style="color:#DD2266; font-size:16px; font-weight: bold;">Please dobule-check the time to make sure they are not overlapped. We are not responsible for any time conflict incurred.</p>
			</td>
		</tr>
	</tfoot>
	
	<?php if (isset($events) && is_array($events) && count($events)): ?>
	<thead>
		<tr>
			<th>No.</th>
			<th>Event Name</th>
			<th>Location</th>
			<th>Time</th>
			<th>Content</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0; ?>
		<?php foreach ($events as $id => $row): ?>
		<tr>
			<input type="hidden" name="ids[]" value="<?php echo $row['event_id']; ?>">
			<td><?php echo $i+1; ?></td>
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $row['location']; ?></td>
			<td><span class="start_time"><?php echo date('Y-m-d H:i',$row['start_time']); ?></span>
			 to <span class="end_time"><?php echo date('Y-m-d H:i',$row['end_time']); ?></span></td>
			<td style="width:40%;"><?php echo $row['content']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif;?>
	
	</table>
<?php echo form_close(); ?>
</div>
</div>