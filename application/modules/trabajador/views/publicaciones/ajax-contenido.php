<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<div class="panel panel-white">
	<div class="panel-body">
<div class="row">
  <div class="col-md-12 toolbar">
		<span class="btn-group">
		  <button class="btn btn-light-grey replyBtn" data-pagina="<?php echo $pagina; ?>">
			<i class="fa fa-reply icon-arrow-left"></i>
		  </button>
		  <button class="btn btn-light-grey dropdown-toggle" data-toggle="dropdown">
		  <i class="fa fa-angle-down caret"></i>
		  </button>
		  <ul class="dropdown-menu context pull-right text-left">
			 <li><a href="#"><i class="fa fa-reply reply-btn"></i> Reply All</a></li>
			 <li><a href="#"><i class="fa fa-arrow-right reply-btn"></i> Forward</a></li>
			 <li><a href="#"><i class="fa fa-print icon-print"></i> Print</a></li>
			 <li><a href="#"><i class="fa fa-ban icon-ban-circle"></i> Spam</a></li>
			 <li><a href="#"><i class="fa fa-trash-o icon-trash"></i> Delete</a></li>
			 <li></li>
		  </ul>
		</span>
		<span class="btn-group">
			<button class="btn btn-light-grey">
				<i class="fa fa-cloud-download icon-download"></i>
			</button>
			<button class="btn btn-light-grey">
				<i class="fa fa-share icon-share-alt"></i>
			</button>
			<button class="btn btn-light-grey">
				<i class="fa fa-trash-o icon-trash"></i>
			</button>
		</span>
  </div>
</div>
</div>
</div>
<div class="divide-20"></div>
<div class="emailTitle emailViewHeader"><br />
 <h1><?php echo ucwords(strtolower($noticia->titulo)); ?> 
 	<?php if( isset($noticia->activo) && $noticia->activo == 0){ ?><span class="label label-success">Vigente</span><?php } ?>&nbsp;<span class="label label-default">Inbox</span>
 </h1> 
</div>
<hr>
<div class="emailViewContent">
 <form class="form-horizontal" role="form">
	<div class="form-group">
		<label class="col-sm-1 control-label span1">Fecha:</label>
		<label class="col-sm-11 control-label span11">
			<?php $fecha = explode("-", $noticia->fecha) ?>
			<?php echo $fecha[2].'&nbsp;'.$meses[$fecha[1]-1].'&nbsp;'.$fecha[0] ?>
		</label>
	</div>
 </form>
</div>
<hr>
<br />
<div class="emailView">
<?php if( isset($noticia->desc_noticia)) echo $noticia->desc_noticia;  ?>
<?php if( isset($noticia->desc_oferta)) echo $noticia->desc_oferta;  ?>
</div>
<hr>
   
