
<div id="modal">
  <form action="<?php echo base_url() ?>carrera/requerimientos/actualizar_doc_contractual/<?php echo $id_req_usu_arch?>/<?php echo $id_area_req ?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <div id="modal_content">
    <div class="row">
        <div class="col-md-6  col-sd-6">

          <div class="control-form">
            <label class="control-label" for="documento">Documento</label>
            <div class="controls">
              <br>
              <input type="file" name="documento" id="documento" class="form-control">
            </div>
          </div>
        <br>
      <div class="modal_content">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Agregar</button>
      </div>
    </form>
</div>