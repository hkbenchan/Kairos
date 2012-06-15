<div>
	<h1 class="page-header">KairosMemberInfo</h1>
</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<table class="table table-striped table-bordered">
		<thead>
		
			
		<th>Surname</th>
		<th>Middle Name</th>
		<th>Last name</th>
		<th>Date Of Birth</th>
		<th>Nationality</th>
		<th>Gender</th>
		<th>University</th>
		<th>Year of Study</th>
		<th>Contact Number</th>
		<th>Receive Future Updates and Newsletter</th>
		
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td><?php echo ($field == 'deleted') ? (($value > 0) ? lang('kairosmemberinfo_true') : lang('kairosmemberinfo_false')) : $value; ?></td>
				<?php endif; ?>
				
			<?php endforeach; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>