<div>
	<h1 class="page-header">Bugs report</h1>
</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<table class="table table-striped table-bordered">
		<thead>
		
			
		<th>Type - e.g. UI or php error</th>
		<th>URL</th>
		<th>Description - e.g. procedures on reproducing the bug and your platform</th>
		<th>Status</th>
		<th>Created</th>
		<th>Modified</th>
		
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'bug_id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('bugs_report_true') : lang('bugs_report_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>