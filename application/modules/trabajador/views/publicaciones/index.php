<link href="<?php echo base_url() ?>extras/css/inbox.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/inbox.js" type="text/javascript"></script>

<div id="loading" style="position: fixed;height: 100%;width: 100%;background-color: white;display: block;top: 0;z-index: 9999;opacity: 0.7; display:none;">
	<img src="<?php echo base_url() ?>extras/img/3.GIF" style="position: absolute;top: 45%;left: 49%;" />
</div>

<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<div class="span11">
					<div class="box-body">
						<!-- TOP ROW -->
						<div class="emailHeader row">
							<div class="emailTitle">
							  <div class="span2">
							  </div>
							  <div class="span10">
								  <form class="form-inline" action="#">
									 <div class="input-append span10">
										<input type="text" class="input-block-level" placeholder="Buscar Publicación">
										<span class="input-group-btn">                   
										<button type="submit" class="btn btn-primary"><i class="icon-search icon-white"></i></button>
										</span>
									 </div>
								  </form>
							  </div>
						   </div>
						</div>
						<!-- /TOP ROW -->
						<hr>
						<!-- INBOX -->
						<div class="row email">
							<div id="list-toggle" class="span2">
							   <ul class="emailNav nav nav-pills nav-stacked margin-bottom-10">									
								  <li class="inbox active">
									 <a href="javascript:;" data-title="Inbox" class="inbox-click" data-pagina="ajax-all">
										<i class="icon-inbox"></i> Todos (<?php echo $publicaciones['capacitaciones_noleidas'] + $publicaciones['noticias_noleidas'] + $publicaciones['ofertas_noleidas'] ; ?>)
									 </a>
								  </li>
								  <li class="inbox">
									 <a href="javascript:;" data-title="Inbox" class="inbox-click" data-pagina="ajax-noticias">
										<i class="icon-inbox"></i> Noticias (<?php echo $publicaciones['noticias_noleidas']; ?>)
									 </a>
								  </li>
								  <li class="inbox">
									 <a href="javascript:;" data-title="Inbox" class="inbox-click" data-pagina="ajax-ofertas">
										<i class="icon-inbox"></i> Ofertas (<?php echo $publicaciones['ofertas_noleidas']; ?>)
									 </a>
								  </li>
								  <li class="inbox">
									 <a href="javascript:;" data-title="Inbox" class="inbox-click" data-pagina="ajax-capacitacion">
										<i class="icon-inbox"></i> Capacitación (<?php echo $publicaciones['capacitaciones_noleidas']; ?>)
									 </a>
								  </li>
								  <li class="inbox">
									<a href="javascript:;" data-title="Trash" class="inbox-click" data-pagina="ajax-trash">
										<i class="icon-trash"></i> Eliminados
									</a>
								  </li>
							   </ul>
							</div>
							<div class="span10">
							   <div class="emailContent"></div>
							</div>
						</div>
						<!-- /INBOX -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>