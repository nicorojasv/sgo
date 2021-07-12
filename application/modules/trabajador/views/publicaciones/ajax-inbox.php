<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<table class="table table-hover">
   <thead>
      <tr>
         <th colspan="4">
            <div class="checker" style="display: inline;"><span><input type="checkbox"></span></div>
               <a class="btn btn-light-grey" href="#" id="refresh"><i class="icon-refresh"></i></a>
			 <div class="btn-group" style="display: inline;">
				 <button class="btn btn-light-grey dropdown-toggle" data-toggle="dropdown"> Mas
					<i class="caret fa fa-caret-down"></i>
				 </button>
				 <ul class="dropdown-menu context" role="menu">
					<li><a href="#" id="leido"><i class="fa fa-pencil icon-pencil"></i> Marcar como leido</a></li>
					<li><a href="#" id="eliminar"><i class="fa fa-trash-o icon-trash"></i> Eliminar</a></li>
				 </ul>
			 </div>
         </th>
         <th colspan="3">
			<div class="btn-group pull-right">
				 <button class="btn btn-light-grey dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-cog fa-lg iconic-cog"></i> <i class="fa fa-caret-down caret"></i>
				 </button>
				 <ul class="dropdown-menu context" role="menu">
					<li><a href="#"><i class="fa fa-cogs iconic-wrench"></i> Settings</a></li>
					<li><a href="#"><i class="fa fa-desktop iconic-box"></i> Configure Inbox</a></li>
					<li><a href="#"><i class="fa fa-exclamation iconic-info"></i> Help</a></li>
				 </ul>
			 </div>
	      </th>
      </tr>
   </thead>
   <tbody>
      <?php if (isset($listado))  { ?>
      <?php foreach ($listado as $l) { ?>
      <tr <?php if(!$l->leido){ ?> class="new"<?php } ?> >
         <td class="width-10">
            <div class="checker"><span><input type="checkbox" data-id="<?php echo $l->id; ?>" data-tipo="<?php echo $l->tipo; ?>"
               <?php if(isset($l->especif)){ ?> data-especif="<?php echo $l->especif; ?>"  <?php } ?> ></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
      <td class="viewEmail  width-10" data-id="<?php echo $l->id; ?>" data-tipo="<?php echo $l->tipo; ?>"></td>
         <td class="viewEmail  hidden-xs" data-id="<?php echo $l->id; ?>" data-tipo="<?php echo $l->tipo; ?>"><?php echo $l->titulo; ?></td>
         <td class="viewEmail " data-id="<?php echo $l->id; ?>" data-tipo="<?php echo $l->tipo; ?>">
            <?php if(!$l->leido){ ?><span class="label label-inverse">Nuevo</span> <?php } ?>
            <?php if(!$l->activo){ ?><span class="label label-success">Vigente</span> <?php } ?>
            <?php echo $l->texto; ?>
         </td>
         <td class="viewEmail  text-right" data-id="<?php echo $l->id; ?>">
            <?php $fecha = explode("-", $l->fecha) ?>
            <?php echo $fecha[2].'/'.$fecha[1].'/'.$fecha[0]; ?>
         </td>
      </tr>
         <?php } ?>
      <?php } ?>
      <!--<tr class="new">
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail  width-10"></td>
         <td class="viewEmail hidden-xs">Steve Jobs</td>
         <td class="viewEmail"><span class="label label-success">New</span> Please buy our new iPhone</td>
         <td class="viewEmail text-right">Oct 18</td>
      </tr>
      <tr class="new">
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star starred"></i></td>
	   <td class="viewEmail width-10"><i class="fa fa-paperclip"></i></td>
         <td class="viewEmail hidden-xs">VMWare Billdesk</td>
         <td class="viewEmail">Billing information for the month of August</td>
         <td class="viewEmail text-right">Oct 03</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail width-10"><i class="fa fa-camera"></i></td>
         <td class="viewEmail hidden-xs">Facebook</td>
         <td class="viewEmail">John Doe, Liz have upcoming birthdays</td>              
         <td class="viewEmail text-right">Sep 14</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
         <td class="viewEmail width-10"></td>
         <td class="viewEmail hidden-xs">LinkedIn</td>
         <td class="viewEmail"><span class="label label-danger">Respond</span> Consetetur sadipscing elitry</td>
         <td class="viewEmail text-right">Sep 15</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star starred"></i></td>
	   <td class="viewEmail width-10"><i class="fa fa-paperclip"></i></td>
         <td class="viewEmail hidden-xs">Jane Doe</td>
         <td class="viewEmail">Dolor sit amet, consectetuer adipiscing</td>               
         <td class="viewEmail text-right">Aug 14</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star starred"></i></td>
	   <td class="viewEmail width-10"></td>
         <td class="viewEmail hidden-xs">John Doe</td>
         <td class="viewEmail"><span class="label label-warning">Read Later</span> Consetetur sadipscing elitry</td>               
         <td class="viewEmail text-right">Aug 15</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail width-10"></td>
         <td class="viewEmail hidden-xs">LinkedIn</td>
         <td class="viewEmail viewEmail">Sed diam nonumy eirmod tempor invidu</td>
         <td class="viewEmail text-right">Aug 14</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail width-10"></td>
         <td class="viewEmail hidden-xs">Jane Doe</td>
         <td class="viewEmail viewEmail">Consetetur sadipscing elitry</td>
         <td class="viewEmail text-right">July 15</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail width-10"></td>
         <td class="viewEmail hidden-xs">Facebook</td>
         <td class="viewEmail viewEmail"><span class="label label-warning">Read Later</span> Sed diam nonumy eirmod tempor invidu</td>
         <td class="viewEmail text-right">July 14</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star starred"></i></td>
	   <td class="viewEmail width-10"><i class="fa fa-camera"></i></td>
         <td class="viewEmail hidden-xs">John Doe</td>
         <td class="viewEmail">Consetetur sadipscing elitry</td>               
         <td class="viewEmail text-right">June 15</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star starred"></i></td>
	   <td class="viewEmail width-10"><i class="fa fa-paperclip"></i></td>
         <td class="hidden-xs">LinkedIn</td>
         <td class="viewEmail">Sed diam nonumy eirmod tempor invidu</td>
         <td class="viewEmail text-right">June 14</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star starred"></i></td>
	   <td class="viewEmail width-10"><i class="fa fa-paperclip"></i></td>
         <td class="viewEmail hidden-xs">Twitter</td>
         <td class="viewEmail">Consetetur sadipscing elitry</td>
         <td class="viewEmail text-right">April 15</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail width-10"></td>
         <td class="hidden-xs">Facebook</td>
         <td class="viewEmail viewEmail"><span class="label label-info">To Do</span> Sed diam nonumy eirmod tempor invidu</td>               
         <td class="viewEmail text-right">April 14</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail width-10"></td>
         <td class="viewEmail hidden-xs">Max Doe</td>
         <td class="viewEmail"><span class="label label-info">To Do</span> Consetetur sadipscing elitry</td>
         <td class="viewEmail text-right">April 15</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail width-10"></td>
         <td class="viewEmail hidden-xs">Dribbble</td>
         <td class="viewEmail">Sed diam nonumy eirmod tempor invidu</td>
         <td class="viewEmail text-right">April 14</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star starred"></i></td>
	   <td class="viewEmail width-10"><i class="fa fa-paperclip"></i></td>
         <td class="viewEmail hidden-xs">Barack Obama</td>
         <td class="viewEmail">Consetetur sadipscing elitry</td>               
         <td class="viewEmail text-right">March 15</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star starred"></i></td>
	   <td class="viewEmail width-10"><i class="fa fa-paperclip"></i></td>
         <td class="viewEmail hidden-xs">Facebook</td>
         <td class="viewEmail viewEmail"><span class="label label-info">To Do</span> Sed diam nonumy eirmod tempor invidu</td>
         <td class="viewEmail text-right">March 14</td>
      </tr>
      <tr>
         <td class="width-10">
            <div class="checker"><span><input type="checkbox"></span></div>
         </td>
         <td class="width-10"><i class="fa fa-star"></i></td>
	   <td class="viewEmail width-10"></td>
         <td class="viewEmail hidden-xs">John Doe</td>
         <td class="viewEmail">Consetetur sadipscing elitry</td>              
         <td class="viewEmail text-right">March 15</td>
      </tr> -->
   </tbody>
 <thead>
      <tr>
         <th colspan="4">
         </th>
         <th class="emailPager" colspan="3">
            <span class="emailPagerCount">1-30 de <?php echo count($listado); ?></span>
            <a id="btn_prev" class="btn btn-sm btn-light-grey" data-tipo="<?php echo $l->tipo; ?>" data-npagina="<?php echo $n_pagina_prev; ?>"><i class="fa fa-angle-left icon-chevron-left"></i></a>
            <a id="btn_next" class="btn btn-sm btn-light-grey" data-tipo="<?php echo $l->tipo; ?>" data-npagina="<?php echo $n_pagina_next; ?>"><i class="fa fa-angle-right icon-chevron-right"></i></a>
         </th>
      </tr>
   </thead>
</table>
   
