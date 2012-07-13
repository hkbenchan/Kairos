<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/bugs_report') ?>"><?php echo lang('bugs_report_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Bugs_report.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/bugs_report/create') ?>" id="create_new"><?php echo lang('bugs_report_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>