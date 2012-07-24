<ul class="nav nav-pills">
	<?php if (($this->uri->segment(4) == '') || ($this->uri->segment(4) == 'view') || ($this->uri->segment(4) == 'index')) : ?>
	<li class="active">
	<?php else: ?>
	<li>
	<?php endif; ?>
		<a href="<?php echo site_url(SITE_AREA .'/reports/kairosmemberinfo') ?>"><?php echo lang('kairosmemberinfo_list'); ?></a>
	</li>
	
	<?php if ($this->uri->segment(4) == 'manage') : ?>
	<li class="active">
	<?php else: ?>
	<li>
	<?php endif; ?>
		<a href="<?php echo site_url(SITE_AREA.'/reports/kairosmemberinfo/manage') ?>"><?php echo lang('kairosmemberinfo_manage'); ?></a>
	</li>
</ul>