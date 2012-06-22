<!-- View this university -->
<div class="">
	<?php $i = 0?>
	<?php if (isset($records) && is_array($records) && count($records)) : ?>
	<?php foreach ($records as $id => $rec) : ?>
		<?php $i++; ?>
		<h3>View University: <?php echo $rec->name; ?></h3>
		<?php if ($i > 0)
			break;
		?>
	<?php endforeach; ?>
	<?php else: ?>
	<h3>View University</h3>
	<?php endif; ?>
	<div class = "header">
	</div>
	<div class = "container">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>User ID</th>
					<th>First Name</th>
					<th>Middle Name</th>
					<th>Last Name</th>
				</tr>
			</thead>
			
			<tfoot>
				<tr>
					<td colspan = "4">
					<?php echo $this->pagination->create_links(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>

			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $id => $rec) : ?>
				<tr>
				
				<td><?php echo anchor(SITE_AREA .'/reports/kairosmemberinfo/detail/'. $rec->uid,  $rec->uid) ?></td>
				<td><?php echo $rec->kairosmemberinfo_firstname; ?></td>
				<td><?php echo $rec->kairosmemberinfo_middlename; ?></td>
				<td><?php echo $rec->kairosmemberinfo_lastname; ?></td>
				
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="4">No record is available.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
		
	</div>
</div>