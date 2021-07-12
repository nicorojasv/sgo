

<script >
	$(document).ready(function(){
	var diaft = $("#datepicker2").val();
	var fechaTerminoContrato = diaft;

});
</script>



<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Adendum Requerimiento</h4>
  </div>
  <div id="modal_content">
		
    <form action="<?php echo base_url() ?>est/requerimiento/actualizar_adendum" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($listado != FALSE){
        foreach ($listado as $row){
      ?>


    <?php 

             
          	$f = explode('-', $row->f_inicio);
              $dia_fi = $f[2];
              $mes_fi = $f[1];
              $ano_fi = $f[0];

          


    ?>

    <input type="hidden" id="dia_fi" name="dia_fi" value="<?php echo $dia_fi ?>">
      <input type="hidden" id="mes_fi" name="mes_fi" value="<?php echo $mes_fi ?>">
      <input type="hidden" id="ano_fi" name="ano_fi" value="<?php echo $ano_fi ?>">

      <input type="hidden" name="causal" id="causal"  value="<?php echo $row->causal ?>">
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label"><b>Nombre</b></label>
                <input type='text' class="form-control" name="nombre" id="nombre" value="<?php echo $row->nombre ?>" disabled >
                <?php if ($ultimo){ ?>
                <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Fecha Inicio</b></label>
            <div class="controls">
               <input type="date" name="f_inicio" id="fecha_termino_contrato_anterior" class="form-control"  value="<?php echo $ultimo->fecha_termino ?>" readonly >
            </div>
          </div>

      <?php }else{ ?>
      	<div class="control-group">
            <label class="control-label" for="inputTipo"><b>Fecha Inicio</b></label>
            <div class="controls">
               <input readonly type="date" name="f_inicio2" id="fecha_termino_contrato_anterior" class="form-control" value="<?php echo $row->f_fin ?>"  >
            </div>
          </div>
      <?php } ?>
          </div>
           
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label"><b>Motivo</b></label>
                <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo $row->motivo ?>" disabled >
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Fecha Termino</b></label>
            <div class="controls">
               <input type="date" name="fechaTerminoAnexo" id="datepicker2" class="form-control" onchange="cambiarDefaul(this.value)">
            </div>
          </div>
            <div class="controls">
               <input type="hidden" name="id_req" id="id_req" class="form-control" value="<?php echo $row->id ?>" >
            </div>
        </div>
        <?php
          }
            }else{
        ?>
          <p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
        <?php
          }
        ?> 
        <br><br><br><br><br><br><br>
        <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="agregarAnexo" name="actualizar" class="btn btn-primary">Agregar</button>
      </div>
    </form>

    <?php if($adendum) {?>
        <table class="table">
  <thead>
    <tr>
      <th style="center" scope="col">#</th>
      <th style="center" scope="col">Fecha Inicio</th>
      <th style="center" scope="col">Fecha Término</th>
      <th style="center"scope="col">Documento</th>
    </tr>
  </thead>
  <tbody>
  	<?php
    $contar = $contar + 1;
    $i=0; ?>
  <?php  foreach ($adendum as $a ) {
      if($i < $contar) { ?>
    <tr>
      <th style="center" scope="row"> <?php echo  $a->id ?></th>
      <td style="center"><?php echo  $a->fecha_inicio ?></td>
      <td style="center"><?php echo  $a->fecha_termino ?></td>
      <td style="center"><a href="<?php echo base_url() ?>est/requerimiento/descargar_adendum_puesta_disposicion/<?php echo  $a->id_req ?>/<?php echo  $a->id ?>/<?php echo $i ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
   <?php $i= $i + 1; ?> 
    </tr>  
   <?php  }} ?> 
  </tbody>
</table>
<?php
          }
        ?> 
      
	</div>
</div>




<script type="text/javascript">

 function cambiarDefaulAll(){
  $('#agregarAnexo').removeAttr("disabled");
}
       
      function cambiarDefaulInico(){
        $('#agregarAnexo').attr('disabled',true);
      }

      function cambiarDefaul(fechaTermino = false){
           $('#agregarAnexo').attr('disabled',true);
            
            
           var causal = $("#causal").val();
           var dia = $("#dia_fi").val();
           var mes = $("#mes_fi").val();
           var ano = $("#ano_fi").val();

            var fechaInicio = moment(ano+'-'+mes+'-'+dia);
            var fechaTermino = moment(fechaTermino);

             console.log(fechaTermino)
             console.log(fechaInicio)
             console.log(causal)

            var fechaBisiesta = moment('2020-02-29')
            diferenciaDias = fechaTermino.diff(fechaInicio, 'days');
            if (new Date(fechaInicio).getTime() < new Date(fechaBisiesta).getTime() && new Date(fechaTermino).getTime() > new Date(fechaBisiesta).getTime()) {
              diferenciaDias++;
            }
            
            if (new Date(fechaInicio).getTime() > new Date(fechaTermino).getTime()) {
              alertify.alert('Imposible! ', "La fecha de Termino del Anexo no puede ser inferior a la fecha de Inicio del Contrato!");
              cambiarDefaulAll();
              return false;
            }

               if (causal == "A") {// causal A ilimitada
                cambiarDefaulAll();
                 return true;
               }

               if (causal == "B") {// causal B 90 dias maximo
                 if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal B, no puede superar los 90 días de contratación.<br>Tienes  un total de: "+diferenciaDias+" días entre Fecha de Inicio del contrato y termino del anexo<br> Intente reducir la fecha.");
                   
                    return false;
                 }
                 cambiarDefaulAll();
               }
               if (causal == "C") {// causal C 180 dias maximo
                 if (diferenciaDias >180) {
                    alertify.alert('Ups ', "De acuerdo a la causal C, no puede superar los 180 días de contratación.<br>Tienes  un total de: "+diferenciaDias+" días entre Fecha de Inicio del contrato y termino del anexo<br> Intente reducir la fecha.");
                   
                    return false;
                 }
                 cambiarDefaulAll();
               }
               if (causal == "D") {// causal D 90 dias maximo
                if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal D, no puede superar los 90 días de contratación.<br>Tienes  un total de: "+diferenciaDias+" días entre Fecha de Inicio del contrato y Termino del anexo <br> Intente reducir la fecha.");
                    
                    return false;
                 }
                 cambiarDefaulAll();
               }
               if (causal == "E") {// causal D 90 dias maximo
                if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal E, no puede superar los 90 días de contratación.<br>Tienes  un total de: "+diferenciaDias+" días entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    
                    return false;
                 }
                 cambiarDefaulAll();
               }
            
      }
      introJs().start();
</script>