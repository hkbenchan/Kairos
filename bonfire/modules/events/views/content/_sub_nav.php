<ul class="nav nav-pills">
	<?php if ($this->uri->segment(4) == '' || $this->uri->segment(4) == 'index') : ?>
		<li class="active">
	<?php else: ?>
		<li>
	<?php endif;?>
		<a href="<?php echo site_url(SITE_AREA .'/content/events') ?>"><?php echo lang('events_list'); ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'join' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA . '/content/events/join') ?>" id="manage"><?php echo lang('events_join'); ?></a>
	</li>
</ul>