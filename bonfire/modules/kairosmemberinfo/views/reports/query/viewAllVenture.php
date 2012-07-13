<!-- View All Venture -->
<div class="">
	<h3>All Venture</h3>
	<div class = "header">
	</div>
	<div class = "container">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Venture Name</th>
					<th>Venture Owner</th>
				</tr>
			</thead>
			
			<tfoot>
				<tr>
					<td>
					<?php echo $this->pagination->create_links(); ?>
					</td>
					<td>
					<?php echo anchor_popup(SITE_AREA . '/reports/kairosmemberinfo/viewVentureOwner/0/1', 'Export to CSV'); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>

			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $id => $rec) : ?>
				<tr>
				<td><?php echo anchor(SITE_AREA .'/reports/kairosmemberinfo/detail/'. $rec->uid,  $rec->name) ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_firstname'}; ?>
					<?php if ($rec->{'kairosmemberinfo_middlename'} != "") 
					      {echo " " . $rec->{'kairosmemberinfo_middlename'};}; ?>
					<?php echo " " . $rec->{'kairosmemberinfo_lastname'}; ?></td>
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="2">No record is available.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
		
	</div>
</div>