<div class="announcement_list">
	<?php if (isset($announcement_list) && is_array($announcement_list) && count($announcement_list)): ?>
		<?php foreach ($announcement_list as $id => $row): ?>
			<div class="announcement_item">
				<h3><?php echo $row['title']; ?></h3>
				<div class="announcement_content">
					<?php echo $row['content']; ?>
				</div>
				<div class="announcement_time">
					<?php echo date('Y-m-d H:i:s',$row['created_at']); ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php echo $this->pagination->create_links(); ?>
	<?php endif;?>

</div>