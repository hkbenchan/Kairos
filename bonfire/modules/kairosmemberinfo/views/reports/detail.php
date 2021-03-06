<!-- Content -->

<div class="admin-box">
	<h3>Detail</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<tbody>
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
				<tr>
					<?php if ($this->auth->has_permission('KairosMemberInfo.Content.Delete')) : ?>
					<div style="display:none">
						<input type="checkbox" name="checked[]" checked="checked" value="<?php echo $records["entry_id"] ?>" />
					</div>
					<?php endif;?>
					<td>First Name</td>
					<td><?php echo $records['kairosmemberinfo_firstname']; ?></td>
				</tr>
				<?php if (isset($records['kairosmemberinfo_middlename'])) : ?>
				<tr>
					<td>Middle Name</td>
					<td><?php echo $records['kairosmemberinfo_middlename']; ?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td>Last Name</td>
					<td><?php echo $records['kairosmemberinfo_lastname']; ?></td>
				</tr>
				<tr>
					<td>Date of Birth (YYYY-MM-DD)</td>
					<td><?php echo $records['kairosmemberinfo_dob']; ?></td>
				</tr>
				<tr>
					<td>Gender</td>
					<td><?php echo $records['kairosmemberinfo_gender']; ?></td>
				</tr>
				<tr>
					<td>Country</td>
					<td><?php echo $records['kairosmemberinfo_nationality']; ?></td>
				</tr>
				<tr>
					<td>University</td>
					<td><?php echo $records['kairosmemberinfo_University']; ?></td>
				</tr>
				<tr>
					<td>Year of Study</td>
					<td><?php echo $records['kairosmemberinfo_yearOfStudy']; ?></td>
				</tr>
				<tr>
					<td>Phone Number</td>
					<td><?php echo $records['kairosmemberinfo_phoneNo']; ?></td>
				</tr>
				<tr>
					<td>Venture (T/F)</td>
					<td><?php echo $records['kairosmemberinfo_ownVenture']; ?></td>
				</tr>
				<?php if (($records['kairosmemberinfo_ownVenture'])=='T') :?>
					<tr>
						<td>Venture Name</td>
						<td><?php echo $records['kairosmemberinfo_ventureName']; ?></td>
					</tr>
					<tr>
						<td>Venture Nature</td>
						<td><?php echo $records['kairosmemberinfo_ventureIndustry']; ?></td>
					</tr>
					<tr>
						<td>Venture Description</td>
						<td><?php echo $records['kairosmemberinfo_ventureDescr']; ?></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td>Special Skills</td>
					<td><?php echo $records['kairosmemberinfo_skills']; ?></td>
				</tr>
				<tr>
					<td>Receive future Newsletter (T/F)</td>
					<td><?php echo $records['kairosmemberinfo_newsletterUpdate']==1 ? 'T':'F'; ?></td>
				</tr>
				<?php if (isset($preference_records)): ?>
				<tr>
					<td>Preference:</td>
					<td>
						<?php if (count($preference_records)) :?>
							<?php foreach ($preference_records as $r_id => $rows){
								echo $rows['description'] . '<br>';}
							?>
						<?php else: ?>
							No preference is selected.
						<?php endif; ?>
					</td>
				</tr>
				<?php endif; ?>				
				<?php if (isset($records['kairosmemberinfo_CV'])): ?>
				<tr>
					<td>CV download:</td>
					<td><?php echo anchor_popup(SITE_AREA. '/reports/kairosmemberinfo/CV_download/' . $records['uid'], 'Download via here');?></td>
				</tr>
				<?php endif; ?>
			<?php else: ?>
				<tr>
					<td colspan="2">You have entered an invalid user id. Please try again.</td>
				</tr>
			<?php endif; ?>
			</tbody>
			
			<?php if (isset($records) && is_array($records) && count($records)) : ?>
			<tfoot>
				<tr>
					<td>
					<?php echo anchor(SITE_AREA .'/content/kairosmemberinfo/edit/'. $records['uid'], 
					'<i class="icon-pencil">&nbsp;</i>EDIT',array('class'=>'btn btn-inverse')); ?>
					<input class="btn btn-primary" type="submit" value="Back" onclick="javascript:history.go(-1);return false;" />
					</td>
					<td>
					<?php if (isset($url_csv)) : ?>
					<input class="btn btn-info" type="submit" value="Export to CSV" onclick="javascript:csv_call('<?php echo $url_csv; ?>');"/>
					<?php endif; ?>
					</td>
				</tr>
			</tfoot>
			<?php endif; ?>
			
			
		</table>
	<?php echo form_close(); ?>
</div>