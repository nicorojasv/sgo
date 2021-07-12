<div class="sidebar-content">
	<a class="sidebar-back" id="chat-volver" href="#"><i class="fa fa-chevron-circle-left"></i> Volver</a>
	<a class="sidebar-back" href="#"><i class="fa fa-video-camera"></i> Video Chat</a>
</div>
<div class="user-chat-form sidebar-content">
	<div class="input-group">
		<input type="text" id="texto_chat" placeholder="Escriba un mensaje aqu&iacute;..." class="form-control">
		<input type="hidden" id="to_id" value="<?php echo $to_id ?>" />
		<div class="input-group-btn">
			<button class="btn btn-blue no-radius" id="envio-chat" type="button">
				<i class="fa fa-chevron-right"></i>
			</button>
		</div>
	</div>
</div>
<ol class="discussion sidebar-content">
	<?php foreach ($conversa as $c) { ?>
		<li class="<?php echo ($c->from_id==$this->session->userdata('id'))?'self':'other'; ?>">
			<div class="avatar">
				<img src="<?php echo base_url() ?>extras/layout2.0/img_perfil/default_barra.jpg" alt="">
			</div>
			<div class="messages">
				<p>
					<?php echo $c->message ?>
				</p>
				<span class="time"> 51 min </span>
			</div>
		</li>
	<?php } ?>
	<!--
	<li class="other">
		<div class="avatar">
			<img src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-4.jpg" alt="">
		</div>
		<div class="messages">
			<p>
				Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
			</p>
			<span class="time"> 51 min </span>
		</div>
	</li>
	<li class="self">
		<div class="avatar">
			<img src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-1.jpg" alt="">
		</div>
		<div class="messages">
			<p>
				Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
			</p>
			<span class="time"> 37 mins </span>
		</div>
	</li>
	<li class="other">
		<div class="avatar">
			<img src="<?php echo base_url() ?>extras/layout2.0/assets/images/avatar-4.jpg" alt="">
		</div>
		<div class="messages">
			<p>
				Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
			</p>
		</div>
	</li>
	-->
</ol>