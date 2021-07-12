<?php
class Examenes_psicologicos_model extends CI_Model{
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function guardar($datos){
		$this->sanatorio->insert('examenes_psicologicos',$datos);
	}

	function eliminar_solicitud($id){
		$this->sanatorio->delete('examenes_psicologicos', array('id' => $id)); 
	}

	function actualizar($id_examen, $datos){
		$this->sanatorio->where('id', $id_examen);
		$this->sanatorio->update('examenes_psicologicos', $datos);
	}

	function actualizar_estado_ultimo_examen($id_usuario, $datos){
		$this->sanatorio->where('usuario_id', $id_usuario);
		$this->sanatorio->update('examenes_psicologicos', $datos); 
	}

	function listar_trabajadores_cc_planta($id_planta, $estado_examen = FALSE){
		$this->sanatorio->select('usuario_id');
		$this->sanatorio->from('examenes_psicologicos');

		if($id_planta != "todos")
			$this->sanatorio->where('lugar_trabajo_id', $id_planta);

		if($estado_examen == "no_cobrados")
			$this->sanatorio->where('estado_cobro', 0);
		elseif($estado_examen == "cobrados")
			$this->sanatorio->where('estado_cobro', 1);
		elseif($estado_examen == "no_informados")
			$this->sanatorio->where('estado_cobro', 2);

		$this->sanatorio->where('fecha_evaluacion >=', '2014-01-01');
		$this->sanatorio->group_by('usuario_id');
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta_todos(){
		$this->sanatorio->select('usuario_id');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->group_by('usuario_id');
		$query = $this->sanatorio->get();
		return $query->result();
	}
	
	function get_result($id_examen){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('id', $id_examen);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get_result_usu($id_usu, $id_lugar, $estado_examen = FALSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('usuario_id', $id_usu);

		if($id_lugar != "todos")
			$this->sanatorio->where('lugar_trabajo_id', $id_lugar);

		if($estado_examen == "no_cobrados")
			$this->sanatorio->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->sanatorio->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->sanatorio->where('estado_cobro', 2);

		$this->sanatorio->where('fecha_evaluacion >=', '2014-01-01');
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get_result_usu_todas_plantas($id_usu, $estado_examen = FALSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('usuario_id', $id_usu);

		if($estado_examen == "no_cobrados")
			$this->sanatorio->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->sanatorio->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->sanatorio->where('estado_cobro', 2);

		$query = $this->sanatorio->get();
		return $query->result();
	}

	function usuarios_pendiente_aprobacion(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('liberacion', 0);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function usuarios_pendientes(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('estado', 0);
		$this->sanatorio->where('liberacion', 1);
		$query = $this->sanatorio->get();
		return $query->result();
	}
	#yayo 03-10-2019
	function usuarios_pendientes2($id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('estado', 0);
		$this->sanatorio->where('liberacion', 1);
		$this->sanatorio->where('usuario_id',$id);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function usuarios_aprobados2($id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('(resultado = "A" or resultado = "B" or resultado = "C")');
		$this->sanatorio->where('estado', 1);
		$this->sanatorio->where('liberacion', 1);
		$this->sanatorio->where('usuario_id',$id);
		$query = $this->sanatorio->get();
		return $query->result();
	}
	function usuarios_aprobados(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('resultado = "A" or resultado = "B" or resultado = "C"');
		$this->sanatorio->where('estado', 1);
		$this->sanatorio->where('liberacion', 1);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function usuarios_desaprobados(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('resultado', "NA");
		$this->sanatorio->where('estado', 1);
		$this->sanatorio->where('liberacion', 1);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function existe_usuario($usuario_id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('usuario_id', $usuario_id);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NADA";
		}
	}

	function actualizar_examen_psicologico($actualizar_examen_psicologico, $id_examen_psicologico){
		$this->sanatorio->where('id', $id_examen_psicologico);
		$this->sanatorio->update('examenes_psicologicos', $actualizar_examen_psicologico);
	}

	function nuevo_examen_psicologico($nuevo_examen_psicologico){
		$this->sanatorio->insert('examenes_psicologicos', $nuevo_examen_psicologico);
	}

	function get_ultimo_examen($usu_id, $fecha_inicio_req = FALSE, $fecha_vigencia_req = FALSE){
		$this->sanatorio->select('*');
		$this->sanatorio->select('id as eval_psic_id');
		$this->sanatorio->select('DATEDIFF(fecha_vigencia,now()) as estado_psic');
		if($fecha_inicio_req != FALSE){
			$this->sanatorio->select('DATEDIFF(fecha_vigencia, ("'.$fecha_inicio_req.'")) as estado_inicio_psicol');
			$this->sanatorio->select('DATEDIFF(fecha_vigencia, ("'.$fecha_vigencia_req.'")) as estado_fin_psicol');
		}
		$this->sanatorio->from('examenes_psicologicos');
		$this->sanatorio->where('usuario_id',$usu_id);
		$this->sanatorio->order_by("id", "desc"); 
		$query = $this->sanatorio->get();
		return $query->row();
	}


}
?>