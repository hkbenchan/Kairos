<!-- Report -->

<div class="admin-box">
	<h3>KairosMemberInfo</h3>
	<?php //echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Report Type</th>
					<th>Description</th>
				</tr>
			</thead>
			
			<tfoot>
				<tr>
					<td colspan="2">
					<?php if (isset($records) && is_array($records) && count($records)) : ?>
						Select one to view the report.
					<?php else: ?>
						Please ask admin to construct more report.
					<?php endif; ?>
					</td>
				</tr>
			</tfoot>
			<tbody>

			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $id => $report) : ?>
				<?php if ($report['display']) : ?>
				<tr>
				
				<td><?php echo anchor(SITE_AREA .'/reports/kairosmemberinfo/view/'. $report['reportID'], '<i class="icon-pencil">&nbsp;</i>' .  $report['reportName']) ?></td>
			
				<td><?php echo $report['reportDescription']; ?></td>
				</tr>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="2">No reports are available.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	<?php //echo form_close(); ?>
</div>