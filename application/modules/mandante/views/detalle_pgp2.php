<?php 
	echo @$avisos;
?>

<div class="row-fluid">
	<div class="span10 offset1" >
		<div>
			<select>
				<option>Todos</option>
				<option>No Contactado</option>
				<option>No Disponible</option>
				<option>En Proceso</option>
				<option>En Planta</option>
			</select>
		</div>
		<table class="table table-hover">
    		<thead style="background-color:#D7D7D7;color:black;">
                <th style="text-align:center;">Nombre</th>
    			<th style="text-align:center;">Referido</th>
    			<th style="text-align:center;">Especialidad</th>
    			<th style="text-align:center;">Contacto</th>
    			<th style="text-align:center;">Disponiblidad</th>
    			<th style="text-align:center;">Certificaci&oacute;n</th>
    			<th style="text-align:center;">Examen Preocupacional</th>
    			<th style="text-align:center;">MASSO</th>
    			<th style="text-align:center;">Contrato</th>
    			<th style="text-align:center;">Status General</th>
                <th style="text-align:center;">Gominota</th>
                <th style="text-align:center;">Recomienda?</th>
    			<th style="text-align:center;">Comentarios</th>
    		</thead>
    		<tbody>
    			<tr>
                    <td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Benjamin Button</a><b/></td>
    				<td><b>Si<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><b>En Servicio</b></td>
                    <td style="text-align:center;">Comentario</td>
    				<td style="text-align:center;">si<input type='radio' name='r' checked /> no<input type='radio' name='r' /></td>
                    <th style="text-align:center;"><a href="#myModal" role="button" class="" data-toggle="modal">Comentar</a></th>
    			</tr>
    			<tr>
    				<td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Benjamin Button</a><b/></td>
                    <td><b>No<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;"><b>No Disponible</b></td>
    				<td style="text-align:center;">Comentario</td>
                    <td style="text-align:center;">si<input type='radio' name='s' checked /> no<input type='radio' name='s' /></td>
                    <th style="text-align:center;"><a href='#'>Comentar</a></th>
    			</tr>
    			<tr>
    				<td><b><a href='#'>Benjamin Button</a><b/></td>
                    <td><b>No<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;"><b>En Proceso</b></td>
    				<td style="text-align:center;">Comentario</td>
                    <td style="text-align:center;">si<input type='radio' name='d' checked /> no<input type='radio' name='d' /></td>
                    <th style="text-align:center;"><a href='#'>Comentar</a></th>
    			</tr>
    			<tr>
    				<td><b><a href='#'>Benjamin Button</a><b/></td>
                    <td><b>Si<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><b>En Servicio</b></td>
    				<td style="text-align:center;">Comentario</td>
                    <td style="text-align:center;">si<input type='radio' name='f' checked /> no<input type='radio' name='f' /></td>
                    <th style="text-align:center;"><a href='#'>Comentar</a></th>
    			</tr>
    			<tr style="border-bottom:1px solid #DDD">
    				<td><b><a href='#'>Benjamin Button</a><b/></td>
                    <td><b>No<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Si</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><b>No Disponible</b></td>
    				<td style="text-align:center;">Comentario</td>
                    <td style="text-align:center;">si<input type='radio' name='g' checked /> no<input type='radio' name='g' /></td>
                    <th style="text-align:center;"><a href='#'>Comentar</a></th>
    			</tr>
    		</tbody>
    	</table>
	</div>
</div>
<!--<script src="<?php echo base_url() ?>extras/js/jquery-fallr-1.3.pack.js"></script>-->
<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
   // $(".open, .impatient").pageslide();

   $('.waa').click(function(e){
        //var id = $(this).attr('href').substring(7);
        //methods[id].apply(this,[this]);
        e.preventDefault(); 
        /*$.extend($.modal.defaults, {
            closeClass: "closeClass",
            closeHTML: "<a href='#'>x</a>"
        });*/
        $("#modal").modal();
        //return false;
        /*
        var gap     = 20;
        var boxH    = $(window).height() - gap;     // bottom gap
        var boxW    = $(window).width() - gap * 2;  // left + right gap

        $.fallr('show', {
            content     : '<p>Yay, no overlay!</p>',
            icon        : 'quote',
            useOverlay  : false
        });
        */
       
    }); 
                
}); 
</script>

<!-- OVERLAY CON LA EDICION  -->
<div id="modal"style="display: none;">
    <div class="closeClass"></div>
    <div id="modal_header">
        <h3>Creación de nueva experiencia</h3>
    </div>
    <div id="modal_content">
        <div style="width: 420px;">
            
        </div>
    </div>
</div>
<!-- -->

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2 id="myModalLabel">Comentario</h2>
  </div>
    <div class="modal-body">
        <form class="">
         <textarea rows="5" style="width: 515px;"></textarea>
        </form>
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
      </div>
</div>