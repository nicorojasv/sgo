<h5 class="sidebar-title">On-line</h5>
<ul class="media-list" id="usr_chat">
	<?php foreach ($listado as $l) { ?>
		<li class="media">
			<a href="#" data-id="<?php echo $l->id ?>">
				<i class="fa fa-circle status-online"></i>
				<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/img_perfil/default_barra.jpg" class="media-object">
				<div class="media-body">
					<h4 class="media-heading"><?php echo $l->nombres.' '.$l->paterno ?></h4>
					<span> ... </span>
				</div>
			</a>
		</li>
	<?php } ?>
	<!--
	<li class="media">
		<a href="#" data-id="3">
			<i class="fa fa-circle status-online"></i>
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-2.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Nicole Bell</h4>
				<span> Content Designer </span>
			</div>
		</a>
	</li>
	<li class="media">
		<a href="#" data-id="3">
			<div class="user-label">
				<span class="label label-default">3</span>
			</div>
			<i class="fa fa-circle status-online"></i>
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-3.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Steven Thompson</h4>
				<span> Visual Designer </span>
			</div>
		</a>
	</li>
	<li class="media">
		<a href="#" data-id="3">
			<i class="fa fa-circle status-online"></i>
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-4.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Ella Patterson</h4>
				<span> Web Editor </span>
			</div>
		</a>
	</li>
	<li class="media">
		<a href="#" data-id="3">
			<i class="fa fa-circle status-online"></i>
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-5.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Kenneth Ross</h4>
				<span> Senior Designer </span>
			</div>
		</a>
	</li>
</ul>
<h5 class="sidebar-title">Off-line</h5>
<ul class="media-list">
	<li class="media">
		<a href="#">
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-6.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Nicole Bell</h4>
				<span> Content Designer </span>
			</div>
		</a>
	</li>
	<li class="media">
		<a href="#">
			<div class="user-label">
				<span class="label label-default">3</span>
			</div>
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-7.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Steven Thompson</h4>
				<span> Visual Designer </span>
			</div>
		</a>
	</li>
	<li class="media">
		<a href="#">
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-8.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Ella Patterson</h4>
				<span> Web Editor </span>
			</div>
		</a>
	</li>
	<li class="media">
		<a href="#">
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-9.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Kenneth Ross</h4>
				<span> Senior Designer </span>
			</div>
		</a>
	</li>
	<li class="media">
		<a href="#">
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-10.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Ella Patterson</h4>
				<span> Web Editor </span>
			</div>
		</a>
	</li>
	<li class="media">
		<a href="#">
			<img alt="..." src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-5.jpg" class="media-object">
			<div class="media-body">
				<h4 class="media-heading">Kenneth Ross</h4>
				<span> Senior Designer </span>
			</div>
		</a>
	</li>
-->
</ul>