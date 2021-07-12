<?php
class Examenes_psicologicos_model extends CI_Model{
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function guardar($datos){
		$this->wood->insert('examenes_psicologicos',$datos);
	}

	function eliminar_solicitud($id){
		$this->wood->delete('examenes_psicologicos', array('id' => $id)); 
	}

	function actualizar($id_examen, $datos){
		$this->wood->where('id', $id_examen);
		$this->wood->update('examenes_psicologicos', $datos);
	}

	function actualizar_estado_ultimo_examen($id_usuario, $datos){
		$this->wood->where('usuario_id', $id_usuario);
		$this->wood->update('examenes_psicologicos', $datos); 
	}

	function listar_trabajadores_cc_planta($id_planta, $estado_examen = FALSE){
		$this->wood->select('usuario_id');
		$this->wood->from('examenes_psicologicos');

		if($id_planta != "todos")
			$this->wood->where('lugar_trabajo_id', $id_planta);

		if($estado_examen == "no_cobrados")
			$this->wood->where('estado_cobro', 0);
		elseif($estado_examen == "cobrados")
			$this->wood->where('estado_cobro', 1);
		elseif($estado_examen == "no_informados")
			$this->wood->where('estado_cobro', 2);

		$this->wood->where('fecha_evaluacion >=', '2014-01-01');
		$this->wood->group_by('usuario_id');
		$query = $this->wood->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta_todos(){
		$this->wood->select('usuario_id');
		$this->wood->from('examenes_psicologicos');
		$this->wood->group_by('usuario_id');
		$query = $this->wood->get();
		return $query->result();
	}
	
	function get_result($id_examen){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('id', $id_examen);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_result_usu($id_usu, $id_lugar, $estado_examen = FALSE){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('usuario_id', $id_usu);

		if($id_lugar != "todos")
			$this->wood->where('lugar_trabajo_id', $id_lugar);

		if($estado_examen == "no_cobrados")
			$this->wood->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->wood->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->wood->where('estado_cobro', 2);

		$this->wood->where('fecha_evaluacion >=', '2014-01-01');
		$query = $this->wood->get();
		return $query->result();
	}

	function get_result_usu_todas_plantas($id_usu, $estado_examen = FALSE){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('usuario_id', $id_usu);

		if($estado_examen == "no_cobrados")
			$this->wood->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->wood->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->wood->where('estado_cobro', 2);

		$query = $this->wood->get();
		return $query->result();
	}

	function usuarios_pendiente_aprobacion(){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('liberacion', 0);
		$query = $this->wood->get();
		return $query->result();
	}

	function usuarios_pendientes(){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('estado', 0);
		$this->wood->where('liberacion', 1);
		$query = $this->wood->get();
		return $query->result();
	}
	#yayo 03-10-2019
	function usuarios_pendientes2($id){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('estado', 0);
		$this->wood->where('liberacion', 1);
		$this->wood->where('usuario_id',$id);
		$query = $this->wood->get();
		return $query->result();
	}

	function usuarios_aprobados2($id){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('(resultado = "A" or resultado = "B" or resultado = "C")');
		$this->wood->where('estado', 1);
		$this->wood->where('liberacion', 1);
		$this->wood->where('usuario_id',$id);
		$query = $this->wood->get();
		return $query->result();
	}
	function usuarios_aprobados(){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('resultado = "A" or resultado = "B" or resultado = "C"');
		$this->wood->where('estado', 1);
		$this->wood->where('liberacion', 1);
		$query = $this->wood->get();
		return $query->result();
	}

	function usuarios_desaprobados(){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('resultado', "NA");
		$this->wood->where('estado', 1);
		$this->wood->where('liberacion', 1);
		$query = $this->wood->get();
		return $query->result();
	}

	function existe_usuario($usuario_id){
		$this->wood->select('*');
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('usuario_id', $usuario_id);
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NADA";
		}
	}

	function actualizar_examen_psicologico($actualizar_examen_psicologico, $id_examen_psicologico){
		$this->wood->where('id', $id_examen_psicologico);
		$this->wood->update('examenes_psicologicos', $actualizar_examen_psicologico);
	}

	function nuevo_examen_psicologico($nuevo_examen_psicologico){
		$this->wood->insert('examenes_psicologicos', $nuevo_examen_psicologico);
	}

	function get_ultimo_examen($usu_id, $fecha_inicio_req = FALSE, $fecha_vigencia_req = FALSE){
		$this->wood->select('*');
		$this->wood->select('id as eval_psic_id');
		$this->wood->select('DATEDIFF(fecha_vigencia,now()) as estado_psic');
		if($fecha_inicio_req != FALSE){
			$this->wood->select('DATEDIFF(fecha_vigencia, ("'.$fecha_inicio_req.'")) as estado_inicio_psicol');
			$this->wood->select('DATEDIFF(fecha_vigencia, ("'.$fecha_vigencia_req.'")) as estado_fin_psicol');
		}
		$this->wood->from('examenes_psicologicos');
		$this->wood->where('usuario_id',$usu_id);
		$this->wood->order_by("id", "desc"); 
		$query = $this->wood->get();
		return $query->row();
	}


}
?>