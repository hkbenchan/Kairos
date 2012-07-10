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
							<?php /* get the static url */ $static = $url_config[$i]['url']; $var = $url_config[$i]['var']; $variable = $rec->{"$var"}; ?>
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
					<td colspan="2">No record is available.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
		
	</div>
</div>