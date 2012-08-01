<div class="admin-box">
<h3>Announcement List</h3>
<div class="announcement_list">
	<table class="table table-striped">
	<thead></thead>
	<tfoot>
		<tr>
			<td><?php echo $this->pagination->create_links(); ?></td>
			<td><p></p></td>
		</tr>
	</tfoot>
	
	<?php if (isset($announcement_list) && is_array($announcement_list) && count($announcement_list)): ?>
	<tbody>
		<?php foreach ($announcement_list as $id => $row): ?>
		<tr>
			<td style="width:20%"><b>Title:</b></td>
			<td><?php echo $row['title']; ?></td>
		</tr>
		<tr>
			<td style="width:20%">
				<p><b>Content:</b></p>
				<p><b>Created At: </b><?php echo date('Y-m-d H:i',$row['created_at']); ?></p>
			</td>
			<td class="announcement_content">
				<?php echo $row['content']; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif;?>
	
	</table>
</div>
</div>