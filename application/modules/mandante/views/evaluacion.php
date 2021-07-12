<?php 
	echo @$avisos;
?>

<div class="row-fluid">
	<div class="span10 offset1" >
		<div style='float:left;'>
			<select>
				<option>Todas las Especialidades</option>
                <option>Especialidad 1</option>
                <option>Especialidad 2</option>
                <option>Especialidad 3</option>
				<option>Especialidad 4</option>
			</select>
            <select>
                <option>Todas las Areas</option>
                <option>area 1</option>
                <option>area 2</option>
                <option>area 3</option>
                <option>area 4</option>
            </select>
		</div>
        <div style='float:right;text-align:right;'>
            <span><a href="<?php echo base_url() ?>extras/Registro_Evaluaciones_al_Trabajador_2.0.xls">Descargar Evaluaci&oacute;n excel <i class="icon-file"></i></a></span><br/>
            <span><a href="">Subir Evaluaci&oacute;n excel <i class="icon-file"></i></a></span>
        </div>
        <div class='clear'></div>
		<table class="table table-hover">
    		<thead style="background-color:#D7D7D7;color:black;">
                <th style="text-align:center;">Nombre</th>
    			<th style="text-align:center;">Referido</th>
    			<th style="text-align:center;">Especialidad</th>
    			<th style="text-align:center;">Area</th>
    			<th style="text-align:center;">Certificaci&oacute;n</th>
    			<th style="text-align:center;">Examen Preocupacional</th>
    			<th style="text-align:center;">MASSO</th>
    			<th style="text-align:center;">Contrato</th>
    			<th style="text-align:center;">Status General</th>
                <th style="text-align:center;">Evaluar</th>
    			<th style="text-align:center;">Calificaci&oacute;n</th>
    		</thead>
    		<tbody>
    			<tr>
                    <td><b><a href='#'>Benjamin Button</a><b/></td>
    				<td><b>Si<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Pulpa</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><b>En Servicio</b></td>
                    <td style="text-align:center;"><a href="#myModal" role="button" class="" data-toggle="modal">Evaluar</a></td>
                    <td style="text-align:center;"><input style='height: 10px;width: 30px;' type='text' value='0' disabled ></td>
    			</tr>
    			<tr>
    				<td><b><a href='#'>Benjamin Button</a><b/></td>
                    <td><b>No<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Secado</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;"><b>No Disponible</b></td>
                    <td style="text-align:center;"><a href='#'>Evaluar</a></td>
                    <td style="text-align:center;"><input style='height: 10px;width: 30px;' type='text' value='0' disabled ></td>
    			</tr>
    			<tr>
    				<td><b><a href='#'>Benjamin Button</a><b/></td>
                    <td><b>No<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Secado</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;"><b>En Proceso</b></td>
                    <td style="text-align:center;"><a href='#'>Evaluar</a></td>
                    <td style="text-align:center;"><input style='height: 10px;width: 30px;' type='text' value='0' disabled ></td>
    			</tr>
    			<tr>
    				<td><b><a href='#'>Benjamin Button</a><b/></td>
                    <td><b>Si<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Papeleria</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><b>En Servicio</b></td>
                    <td style="text-align:center;"><a href='#'>Evaluar</a></td>
                    <td style="text-align:center;"><input style='height: 10px;width: 30px;' type='text' value='0' disabled ></td>
    			</tr>
    			<tr style="border-bottom:1px solid #DDD">
    				<td><b><a href='#'>Benjamin Button</a><b/></td>
                    <td><b>No<b/></td>
    				<td style="text-align:center;">Especialidad</td>
    				<td style="text-align:center;">Pulpa</td>
    				<td style="text-align:center;">No</td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><a href='#'>Si</a></td>
    				<td style="text-align:center;"><b>No Disponible</b></td>
                    <td style="text-align:center;"><a href='#'>Evaluar</a></td>
                    <td style="text-align:center;"><input style='height: 10px;width: 30px;' type='text' value='0' disabled ></td>
    			</tr>
    		</tbody>
    	</table>
	</div>
</div>
<!--<script src="<?php echo base_url() ?>extras/js/jquery-fallr-1.3.pack.js"></script>-->
<!--<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>-->
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

<!-- OVERLAY CON LA EDICION 
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


<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Encuesta trabajador xxxxxxxxxxx</h3>
  </div>
    <div class="modal-body">
        <div>
            <h5>Instrucciones</h5>
            <p>Complete los siguientes campos: &aacute;rea de trabajo, Nombre de trabajador, rut, quien eval&uacute;a.</p>
            <p>Ponga nota del 1 al 7 y trdponfs 'si/no' frente a la pregunta si recomendar&iacute;a al trabajador.</p>
        </div>
        <form class="form-horizontal">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Trabaja en equipo</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Orientaci&oacute;n a la calidad</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Orientaci&oacute;n al logro y cumplimiento de metas</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Iniciativa / Productividad</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Adaptabilidad al cambio</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Capacidad de aprendizaje</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Concientizaci&oacute;n sobre seguridad y MA</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Tolerancia al trabajo bajo presi&oacute;n</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Comunicaci&oacute;n a todo nivel</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">An&aacute;lisis y evaluaci&oacute;n de problemas</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
          <label class="control-label" for="inputTipo">Disposici&oacute;n a recibir ordenes</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Relaciones interpersonales</label>
            <div class="controls">
                <input type='text' class="input-mini"  />
            </div>
          </div>
        <div class="control-group">
            <label class="control-label" for="inputTipo">Aplicaci&oacute;n de conocimientos de la especialidad</label>
            <div class="controls">
                <input type='text' class="input-mini" />
            </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Capacidad de toma de decisiones (solo nivel superior)</label>
        <div class="controls">
            <input type='text' class="input-mini"  />
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Liderazgo (solo nivel superior)</label>
        <div class="controls">
            <input type='text' class="input-mini"  />
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Responsabilidad</label>
        <div class="controls">
            <input type='text' class="input-mini"  />
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Autocuidado</label>
        <div class="controls">
            <input type='text' class="input-mini"  />
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Presentaci&oacute;n personal</label>
        <div class="controls">
            <input type='text' class="input-mini"  />
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Cumplimiento de normas y procedimientos</label>
        <div class="controls">
            <input type='text' class="input-mini"  />
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Motivaci&oacute;n</label>
        <div class="controls">
            <input type='text' class="input-mini"  />
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Respeto</label>
        <div class="controls">
            <input type='text' class="input-mini"  />
        </div>
        </div>
        <div class="control-group">
        <label class="control-label" for="inputTipo">Recomendar&iacute; al trabajador?</label>
        <div class="controls">
            si <input type='radio' name='recomienda'>
            no <input type='radio' name='recomienda'>
        </div>
        </div>
        </form>
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
      </div>
</div> -->