<div class="admin-box">
<?php if (isset($event) && is_array($event) && count($event)) : ?>
<div class="event_list">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Location</th>
				<th>Time</th>
				<th>Content</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $event['title']; ?></td>
				<td><?php echo $event['location']; ?></td>
				<td><span class="start_time"><?php echo date('Y-m-d H:i',$event['start_time']); ?></span>
				 to <span class="end_time"><?php echo date('Y-m-d H:i',$event['end_time']); ?></span></td>
				<td style="width:40%;"><?php echo $event['content']; ?></td>
			</tr>
		</tbody>
	</table>
</div>
<?php endif; ?>


<h3>User List</h3>
<div class="users_list">
<?php echo form_open($this->uri->uri_string()); ?>
	<table class="table table-striped">
	<tfoot>
		<tr>
			<td colspan="4"><?php echo lang('bf_with_selected') ?><input type="submit" name="process" class="btn btn-primary" value="Process" />
			or <?php echo anchor(SITE_AREA .'/reports/events/manage', lang('events_cancel'), 'class="btn btn-warning"'); ?></td>
			<td><?php //echo $this->pagination->create_links(); ?>
			</td>
		</tr>
	</tfoot>
	
	<?php if (isset($user_list) && is_array($user_list) && count($user_list)): ?>
	<thead>
		<tr>
			<th>Username</th>
			<th>Email</th>
			<th>Display Name</th>
			<th>Status</th>
			<th>Check</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($user_list as $id => $row): ?>
		<tr>
			<td><?php echo anchor_popup(SITE_AREA.'/reports/kairosmemberinfo/detail/'.$row['uid'], $row['username']); ?></td>
			<td><?php echo $row['email']; ?></td>
			<td><?php echo $row['display_name'];?></td>
			<td><?php echo $row['status']; ?></td>
			<td><input type="hidden" name="id[]" value="<?php echo $row['uid'];?>">
				<input type="radio" name="approve[]" <?php echo set_radio('approve[]','Approve',$row['status']=='Approved'); ?> value="Approve">Approve
				<input type="radio" name="approve[]" <?php echo set_radio('approve[]','Reject',$row['status']=='Rejected'); ?> value="Reject">Reject
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif;?>
	
	</table>
<?php echo form_close(); ?>
</div>
</div>