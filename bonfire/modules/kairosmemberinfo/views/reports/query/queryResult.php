<!-- General Query Result -->
<div class="">
	<h3></h3>
	<div class = "header">
	</div>
	<div class = "container">
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if (isset($display_data) && is_array($display_data) && count($display_data)) : ?>
					<?php $display_header = $display_data['header'] ?>
					<?php foreach ($display_header as $display_name => $name) : ?>
						<th><?php echo $display_name; ?></th>
					<?php endforeach; ?>
					<?php endif; ?>
				</tr>
			</thead>
			
			<tfoot>
				<tr>
					<td>
					<?php echo $this->pagination->create_links(); ?>
					</td>
					<td>
					<?php //echo anchor_popup(SITE_AREA . '/reports/kairosmemberinfo/viewGroupByUniversity/0/1', 'Export to CSV'); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>

			<?php if (isset($display_data) && is_array($display_data) && count($display_data)) : ?>
			<?php $display_header = $display_data['header']; ?>
			<?php $data = $display_data['data']; ?>
			<?php foreach ($data as $id => $rec) : ?>
				<tr>
				<?php foreach ($display_header as $display_name => $name) : ?>
					<td><?php echo $rec->{"$name"}; ?></td>
				<?php endforeach; ?>
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