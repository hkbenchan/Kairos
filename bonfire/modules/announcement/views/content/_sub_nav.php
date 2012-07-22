<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/announcement') ?>"><?php echo lang('announcement_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Announcement.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/announcement/create') ?>" id="create_new"><?php echo lang('announcement_new'); ?></a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('Announcement.Content.Edit') && $this->auth->has_permission('Announcement.Content.Delete')) : ?>
	<li <?php echo $this->uri->segment(4) == 'manage' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA . '/content/announcement/manage') ?>" id="manage"><?php echo lang('announcement_manage'); ?></a>
	</li>
	<?php endif; ?>
</ul>