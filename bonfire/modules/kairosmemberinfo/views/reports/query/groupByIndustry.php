<!-- Group By Industry -->
<div class="">
	<h3>Group by Industry</h3>
	<div class = "header">
	</div>
	<div class = "container">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Industry Name</th>
					<th>Number of Members</th>
				</tr>
			</thead>
			
			<tfoot>
				<tr>
					<td colspan = "2">
					<?php echo $this->pagination->create_links(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>

			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $id => $rec) : ?>
				<tr>
				
				<td><?php echo anchor(SITE_AREA .'/reports/kairosmemberinfo/viewIndustry/'. $rec->IndustryID,  $rec->IndustryName) ?></td>
			
				<td><?php echo $rec->{'Number of members'}; ?></td>
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