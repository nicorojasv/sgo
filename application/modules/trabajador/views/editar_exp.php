<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Editar Experiencia</h4>
  </div>
  <div id="modal_content"><br>
    <form action="<?php echo base_url() ?>trabajador/perfil/edicion_exp/<?php echo $exp->id ?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Desde</label>
                <div class="controls">
                	<?php $f_d = explode('-',$exp->desde); ?>
                	<select name="select_dia_desde" style="width:48px" required>
						<option value="">Dia</option>
						<?php for ($i=1; $i < 32 ; $i++) { ?>
						<option <?php if($i == $f_d[2]){ echo 'SELECTED'; } ?> value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
					</select>
					<select name="select_mes_desde" style="width:60px" required>
						<option value="">Mes</option>
						<?php for ($i=1; $i < 13 ; $i++) { ?> 
						<option <?php if($i == $f_d[1]){ echo 'SELECTED'; } ?> value="<?php echo $i ?>"><?php echo $meses[$i-1] ?></option>
						<?php } ?>
					</select>
					<?php
					$ano_inicio = date('Y') - 40;
					$ano_fin = date('Y') + 1;
					?>
					<select name="select_ano_desde" style="width:64px" required>
						<option value="">Año</option>
						<?php for ($ano_inicio; $i < $ano_fin ; $i++) { ?> 
						<option <?php if( $i == $f_d[0] ){ echo 'SELECTED'; } ?> value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
					</select>
                </div>
            </div>
            <div class="control-group">
              	<label class="control-label" for="inputTipo">Hasta</label>
              	<div class="controls">
	                <?php $f_h = explode('-',$exp->hasta); ?>
	                <select name="select_dia_hasta" style="width:48px" required>
						<option value="">Dia</option>
						<?php for ($i=1; $i < 32 ; $i++) { ?> 
						<option <?php if($i == $f_h[2]){ echo 'SELECTED'; } ?> value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
					</select>
					<select name="select_mes_hasta" style="width:60px" required>
						<option value="">Mes</option>
						<?php for ($i=1; $i < 13 ; $i++) { ?>
						<option <?php if($i == $f_h[1]){ echo 'SELECTED'; } ?> value="<?php echo $i ?>"><?php echo $meses[$i-1] ?></option>
						<?php } ?>
					</select>
					<?php
					$ano_inicio = date('Y') - 40;
					$ano_fin = date('Y') + 1;
					?>
					<select name="select_ano_hasta" style="width:64px" required>
						<option value="">Año</option>
						<?php for ($ano_inicio; $i < $ano_fin ; $i++) { ?> 
						<option <?php if( $i == $f_h[0] ){ echo 'SELECTED'; } ?> value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
					</select>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Cargo</label>
                <div class="controls">
					<input type="text" name="cargo" value="<?php echo $exp->cargo; ?>" required/>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Area</label>
                <div class="controls">
					<input type="text" name="area" value="<?php echo $exp->area ?>" required/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Empresa Contratista</label>
                <div class="controls">
					<input type="text" name="contratista" value="<?php echo $exp->empresa_c ?>" required/>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Empresa mandante/planta</label>
                <div class="controls">
					<input type="text" name="mandante" value="<?php echo $exp->empresa_m ?>" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Principales Funciones</label>
              <div class="controls">
				<textarea name="funciones" required><?php echo $exp->funciones ?></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Referencias</label>
                <div class="controls">
					<textarea name="referencias"><?php echo $exp->referencias ?></textarea>
              </div>
            </div>
          </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>