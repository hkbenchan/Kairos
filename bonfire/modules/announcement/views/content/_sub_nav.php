<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/announcement') ?>"><?php echo lang('announcement_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Announcement.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/announcement/create') ?>" id="create_new"><?php echo lang('announcement_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>