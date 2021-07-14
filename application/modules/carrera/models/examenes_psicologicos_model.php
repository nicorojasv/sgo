<?php
class Examenes_psicologicos_model extends CI_Model{
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function guardar($datos){
		$this->carrera->insert('examenes_psicologicos',$datos);
	}

	function eliminar_solicitud($id){
		$this->carrera->delete('examenes_psicologicos', array('id' => $id)); 
	}

	function actualizar($id_examen, $datos){
		$this->carrera->where('id', $id_examen);
		$this->carrera->update('examenes_psicologicos', $datos);
	}

	function actualizar_estado_ultimo_examen($id_usuario, $datos){
		$this->carrera->where('usuario_id', $id_usuario);
		$this->carrera->update('examenes_psicologicos', $datos); 
	}

	function listar_trabajadores_cc_planta($id_planta, $estado_examen = FALSE){
		$this->carrera->select('usuario_id');
		$this->carrera->from('examenes_psicologicos');

		if($id_planta != "todos")
			$this->carrera->where('lugar_trabajo_id', $id_planta);

		if($estado_examen == "no_cobrados")
			$this->carrera->where('estado_cobro', 0);
		elseif($estado_examen == "cobrados")
			$this->carrera->where('estado_cobro', 1);
		elseif($estado_examen == "no_informados")
			$this->carrera->where('estado_cobro', 2);

		$this->carrera->where('fecha_evaluacion >=', '2014-01-01');
		$this->carrera->group_by('usuario_id');
		$query = $this->carrera->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta_todos(){
		$this->carrera->select('usuario_id');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->group_by('usuario_id');
		$query = $this->carrera->get();
		return $query->result();
	}
	
	function get_result($id_examen){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('id', $id_examen);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_result_usu($id_usu, $id_lugar, $estado_examen = FALSE){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('usuario_id', $id_usu);

		if($id_lugar != "todos")
			$this->carrera->where('lugar_trabajo_id', $id_lugar);

		if($estado_examen == "no_cobrados")
			$this->carrera->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->carrera->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->carrera->where('estado_cobro', 2);

		$this->carrera->where('fecha_evaluacion >=', '2014-01-01');
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_result_usu_todas_plantas($id_usu, $estado_examen = FALSE){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('usuario_id', $id_usu);

		if($estado_examen == "no_cobrados")
			$this->carrera->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->carrera->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->carrera->where('estado_cobro', 2);

		$query = $this->carrera->get();
		return $query->result();
	}

	function usuarios_pendiente_aprobacion(){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('liberacion', 0);
		$query = $this->carrera->get();
		return $query->result();
	}

	function usuarios_pendientes(){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('estado', 0);
		$this->carrera->where('liberacion', 1);
		$query = $this->carrera->get();
		return $query->result();
	}
	#yayo 03-10-2019
	function usuarios_pendientes2($id){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('estado', 0);
		$this->carrera->where('liberacion', 1);
		$this->carrera->where('usuario_id',$id);
		$query = $this->carrera->get();
		return $query->result();
	}

	function usuarios_aprobados2($id){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('(resultado = "A" or resultado = "B" or resultado = "C")');
		$this->carrera->where('estado', 1);
		$this->carrera->where('liberacion', 1);
		$this->carrera->where('usuario_id',$id);
		$query = $this->carrera->get();
		return $query->result();
	}
	function usuarios_aprobados(){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('resultado = "A" or resultado = "B" or resultado = "C"');
		$this->carrera->where('estado', 1);
		$this->carrera->where('liberacion', 1);
		$query = $this->carrera->get();
		return $query->result();
	}

	function usuarios_desaprobados(){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('resultado', "NA");
		$this->carrera->where('estado', 1);
		$this->carrera->where('liberacion', 1);
		$query = $this->carrera->get();
		return $query->result();
	}

	function existe_usuario($usuario_id){
		$this->carrera->select('*');
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('usuario_id', $usuario_id);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NADA";
		}
	}

	function actualizar_examen_psicologico($actualizar_examen_psicologico, $id_examen_psicologico){
		$this->carrera->where('id', $id_examen_psicologico);
		$this->carrera->update('examenes_psicologicos', $actualizar_examen_psicologico);
	}

	function nuevo_examen_psicologico($nuevo_examen_psicologico){
		$this->carrera->insert('examenes_psicologicos', $nuevo_examen_psicologico);
	}

	function get_ultimo_examen($usu_id, $fecha_inicio_req = FALSE, $fecha_vigencia_req = FALSE){
		$this->carrera->select('*');
		$this->carrera->select('id as eval_psic_id');
		$this->carrera->select('DATEDIFF(fecha_vigencia,now()) as estado_psic');
		if($fecha_inicio_req != FALSE){
			$this->carrera->select('DATEDIFF(fecha_vigencia, ("'.$fecha_inicio_req.'")) as estado_inicio_psicol');
			$this->carrera->select('DATEDIFF(fecha_vigencia, ("'.$fecha_vigencia_req.'")) as estado_fin_psicol');
		}
		$this->carrera->from('examenes_psicologicos');
		$this->carrera->where('usuario_id',$usu_id);
		$this->carrera->order_by("id", "desc"); 
		$query = $this->carrera->get();
		return $query->row();
	}


}
?>