<ul class="nav nav-pills">
	<?php if ($this->uri->segment(4) == '' || $this->uri->segment(4) == 'index' || $this->uri->segment(4) == 'manage') : ?>
		<li class="active">
	<?php else: ?>
		<li>
	<?php endif;?>
		<a href="<?php echo site_url(SITE_AREA .'/reports/events/manage') ?>"><?php echo lang('events_list'); ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA . '/reports/events/create') ?>"><?php echo lang('events_create'); ?></a>
	</li>
	<li <?php echo $this->uri->segment(4) == 'approve' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA. '/reports/events/approve') ?>"><?php echo lang('events_approve'); ?></a>
	</li>
</ul>