<ul class="nav nav-pills">
	<?php if ($this->uri->segment(4) == '' || $this->uri->segment(4) == 'index') : ?>
		<li class="active">
	<?php else: ?>
		<li>
	<?php endif;?>
		<a href="<?php echo site_url(SITE_AREA .'/content/kairosmemberinfo') ?>"><?php echo lang('kairosmemberinfo_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('KairosMemberInfo.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/kairosmemberinfo/create') ?>" id="create_new"><?php echo lang('kairosmemberinfo_new_part1'); ?></a>
	</li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('KairosMemberInfo.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create_cv' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/kairosmemberinfo/create_cv') ?>" id="create_new"><?php echo lang('kairosmemberinfo_new_cv'); ?></a>
	</li>
	<?php endif; ?>
</ul>