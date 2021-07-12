<tr class="odd gradeX">
<td>'.$uu->id.'</td>
<td>'.$uu->rutTrabajador.'</td>
<td>'.$uu->.nombres' '.$uu->paterno.' '.$uu->materno.'</td>
<td>'.$uu->fono.'</td>
<td>'.$uu->residencia.'</td>
<td>'.$uu->referido.'</td>
<td>'.$uu->lugar_trabajo.'</td>
<td>'.$uu->nombreSolicitante.'</td>
<td>'.$uu->nombrePsicologo.'</td>
<td>'.$uu->especialidad.'</td>
<td>'.$uu->nombreCargo.'</td>
<td><?php echo $uu->tecnico_supervisor ?></td>
<td><?php echo $uu->sueldo_definido ?></td>
<td><?php echo $uu->resultado ?></td>
<td><?php echo $uu->fecha_solicitud ?></td>
<td><?php echo $uu->fecha_evaluacion ?></td>
<td><?php echo $uu->fecha_vigencia ?></td>
<td><?php echo $uu->observaciones ?></td>
<td class="center">
<a href="<?php echo base_url() ?>est/examen_psicologico/detalle/<?php echo $uu->id_examen ?>"><i style="color:<?php echo $uu->color_examen ?>" class="fa fa-book" aria-hidden="true"></i></a>
<?php if($uu->letra_estado == 'P' and $this->session->userdata('tipo_usuario') == 5){ ?>
<a class="eliminar" href="<?php echo base_url() ?>est/examen_psicologico/eliminar_examen/<?php echo $uu->id_examen ?>"><i class="fa fa-times fa fa-white" aria-hidden="true"></i></a>
<?php } ?>
</td>
<td class="center"><span class='badge' style='background-color:<?php echo $uu->color_estado ?>'><?php echo $uu->letra_estado ?></span></td>
</tr>