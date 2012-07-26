<div class= "admin-box">
	<h3>All Users</h3>
	<?php echo form_open(SITE_AREA.'/reports/kairosmemberinfo/manage_status');?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
				<th style="width: 3em"><?php echo lang('bf_id'); ?></th>
				<th><?php echo lang('bf_username'); ?></th>
				<th><?php echo lang('bf_display_name'); ?></th>
				<th><?php echo lang('bf_email'); ?></th>
				<th style="width: 10em">Info filled</th>
				<th style="width: 11em">CV uploaded</th>
				<th style="width: 10em">Member Valid</th>
			</tr>
		</thead>
		<tbody>
			<?php if (isset($users) && is_array($users) && count($users)): ?>
				<?php foreach($users as $id => $user): ?>
				<tr>
					<td><input type="checkbox" name="checked[]" value="<?php echo $user->id ?>" /></td>
					<td><?php echo $user->id; ?></td>
					<td><?php echo $user->username; ?></td>
					<td><?php echo $user->display_name; ?></td>
					<td><?php echo $user->email; ?></td>
					<td><span <?php echo $user->filled_info == 'T'?'class="label label-success"':'class="label label-warning"'; ?>><?php echo $user->filled_info; ?></span></td>
					<td><span <?php echo $user->filled_cv == 'T'?'class="label label-success"':'class="label label-warning"'; ?>><?php echo $user->filled_cv; ?></span></td>
					<td><span <?php echo $user->filled_ship == 'T'?'class="label label-success"':'class="label label-warning"'; ?>><?php echo $user->filled_ship; ?></span></td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="8">Something went wrong......</td>
				</tr>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo lang('bf_with_selected') ?>
					<input type="submit" name="submit" class="btn btn-primary" value="Change membership status">
				</td>
			</tr>
		</tfoot>
		<?php echo form_close(); ?>
	</table>
</div>