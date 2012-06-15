<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/developer/kairosmemberinfo') ?>"><?php echo lang('kairosmemberinfo_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('KairosMemberInfo.Developer.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/developer/kairosmemberinfo/create') ?>" id="create_new"><?php echo lang('kairosmemberinfo_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>