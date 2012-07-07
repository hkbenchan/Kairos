<!-- View All Users -->
<div class="">
	<h3>View All Users</h3>
	<div class = "header">
	</div>
	<div class = "container">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Date of Birth (YYYY-MM-DD)</th>
					<th>Gender</th>
					<th>Year of Study</th>
					<th>Phone Number</th>
					<th>Skills</th>
					<th>University</th>
					<th>Country</th>
					<th>Own Venture(T/F)</th>
					<th>Newsletter Update</th>
				</tr>
			</thead>
			
			<tfoot>
				<tr>
					<td>
					<?php echo $this->pagination->create_links(); ?>
					</td>
					<td>
					<?php echo anchor_popup(SITE_AREA . '/reports/kairosmemberinfo/viewAllUsers/0/1', 'Export to CSV'); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>

			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<?php foreach ($records as $id => $rec) : ?>
				<tr>
				<?php $name = ""; ?>
				<?php $name .= $rec->{'kairosmemberinfo_firstname'}; ?>
				<?php if ($rec->{'kairosmemberinfo_middlename'} != "") 
					{$name .= " " . $rec->{'kairosmemberinfo_middlename'};}; ?>
				<?php $name .= " " . $rec->{'kairosmemberinfo_lastname'}; ?>
				
				<td><?php echo anchor(SITE_AREA .'/reports/kairosmemberinfo/viewUniversity/'. $rec->uid, $name) ?></td>
			
				<td><?php echo $rec->{'kairosmemberinfo_dob'}; ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_gender'}; ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_yearOfStudy'}; ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_phoneNo'}; ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_skills'}; ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_University'}; ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_nationality'}; ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_ownVenture'}; ?></td>
				<td><?php echo $rec->{'kairosmemberinfo_newsletterUpdate'}; ?></td>
				
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="10">No record is available.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
		
	</div>
</div>