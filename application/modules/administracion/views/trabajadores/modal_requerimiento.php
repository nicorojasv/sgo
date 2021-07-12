<form class="form-horizontal">
<div class="control-group">
  <label class="control-label" for="inputCategoria">Grupo:</label>
  <div class="controls">
    <select name="modal_grupo" id="modal_grupo">
      <option>Seleccione...</option>
      <?php foreach ($grupo as $g) { ?>
        <option value="<?php echo $g->id ?>"><?php echo $g->nombre ?></option>
      <?php } ?>
    </select>
  </div>
</div>
<div class="control-group">
  <div class="contenedor" style="margin-left: 114px;">
    <select style="width: 285px;" name="modal_planta" id="modal_planta">
      <option>Seleccione...</option>
    </select>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="inputCategoria">Asignados:</label>
  <div class="controls asign">
    
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="inputCategoria">Seleccionados:</label>
  <div class="controls select">
    
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="inputCategoria">Origen:</label>
  <div class="controls">
    <select style="width: 285px;" name="origen" id="modal_origen">
      <option value='0'>Seleccione...</option>
      <?php foreach($origen as $o){ ?>
      <option value="<?php echo $o->id ?>"><?php echo $o->name; ?></option>
      <?php } ?>
    </select>
  </div>
</div>
</form>