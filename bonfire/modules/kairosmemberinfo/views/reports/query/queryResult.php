<!-- General Query Result -->
<div class="">
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
					<input class="btn btn-primary" type="submit" value="Back" onclick="javascript:history.go(-1);return false;" />
					</td>
					<td>
					<input class="btn btn-info" type="submit" value="Export to CSV" onclick="javascript:csv_call('<?php
					if (isset($url_csv))
					echo $url_csv;
					?>');"/>
					</td>
					<?php if (count($display_header)-2>0) : ?>
						<td colspan="<?php echo (count($display_header)-2); ?>"></td>
					<?php endif; ?>
				</tr>
				<tr>
					<td colspan= "<?php echo (count($display_header)); ?>">
					<?php echo $this->pagination->create_links(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>

			<?php if (isset($display_data) && is_array($display_data) && count($display_data) 
				&& isset($display_data['data']) && is_array($display_data['data']) && count($display_data['data'])): ?>
			<?php $display_header = $display_data['header']; ?>
			<?php $display_url = $display_data['url']; ?>
			<?php if (isset($display_url) && is_array($display_url) && count($display_url)) : ?>
				<?php $url_config = $display_url; ?>
			<?php else: ?>
				<?php $url_config = array(); ?>
			<?php endif; ?>
			<?php $data = $display_data['data']; ?>
			<?php foreach ($data as $id => $rec) : ?>
				<tr>
				<?php $i=0; ?>
				<?php foreach ($display_header as $display_name => $name) : ?>
					<td>
						<?php if (array_key_exists($i, $url_config)): ?>
							<?php /* get the static url */ 
								$static = $url_config[$i]['url']; $var = $url_config[$i]['var']; $variable = $rec->{"$var"}; 
							?>
							<?php echo anchor($static . $variable, $rec->{"$name"}); ?>
						<?php else: ?>
							<?php echo $rec->{"$name"}; ?>
						<?php endif; ?>
						<?php $i++; ?>
					</td>
				<?php endforeach; ?>
				
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="<?php echo count($display_header); ?>">No record is available.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
		
	</div>
</div>