<?php
class Examenes_psicologicos_model extends CI_Model{

	function guardar($datos){
		$this->db->insert('examenes_psicologicos',$datos);
	}

	function eliminar_solicitud($id){
		$this->db->delete('examenes_psicologicos', array('id' => $id)); 
	}

	function actualizar($id_examen, $datos){
		$this->db->where('id', $id_examen);
		$this->db->update('examenes_psicologicos', $datos);
	}

	function actualizar_estado_ultimo_examen($id_usuario, $datos){
		$this->db->where('usuario_id', $id_usuario);
		$this->db->update('examenes_psicologicos', $datos); 
	}

	function listar_trabajadores_cc_planta($id_planta, $estado_examen = FALSE){
		$this->db->select('usuario_id');
		$this->db->from('examenes_psicologicos');

		if($id_planta != "todos")
			$this->db->where('lugar_trabajo_id', $id_planta);

		if($estado_examen == "no_cobrados")
			$this->db->where('estado_cobro', 0);
		elseif($estado_examen == "cobrados")
			$this->db->where('estado_cobro', 1);
		elseif($estado_examen == "no_informados")
			$this->db->where('estado_cobro', 2);

		$this->db->where('fecha_evaluacion >=', '2014-01-01');
		$this->db->group_by('usuario_id');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta_todos(){
		$this->db->select('usuario_id');
		$this->db->from('examenes_psicologicos');
		$this->db->group_by('usuario_id');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_result($id_examen){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('id', $id_examen);
		$query = $this->db->get();
		return $query->result();
	}

	function get_result_usu($id_usu, $id_lugar, $estado_examen = FALSE){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('usuario_id', $id_usu);

		if($id_lugar != "todos")
			$this->db->where('lugar_trabajo_id', $id_lugar);

		if($estado_examen == "no_cobrados")
			$this->db->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->db->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->db->where('estado_cobro', 2);

		$this->db->where('fecha_evaluacion >=', '2014-01-01');
		$query = $this->db->get();
		return $query->result();
	}

	function get_result_usu_todas_plantas($id_usu, $estado_examen = FALSE){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('usuario_id', $id_usu);

		if($estado_examen == "no_cobrados")
			$this->db->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->db->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->db->where('estado_cobro', 2);

		$query = $this->db->get();
		return $query->result();
	}

	function usuarios_pendiente_aprobacion(){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('liberacion', 0);
		$query = $this->db->get();
		return $query->result();
	}

	function usuarios_pendientes(){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('estado', 0);
		$this->db->where('liberacion', 1);
		$query = $this->db->get();
		return $query->result();
	}
	#yayo 25-10-2019
	function usuarios_pendientes2($id){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('estado', 0);
		$this->db->where('liberacion', 1);
		$this->db->where('usuario_id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function usuarios_aprobados2($id){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('(resultado = "A" or resultado = "B" or resultado = "C")');
		$this->db->where('estado', 1);
		$this->db->where('liberacion', 1);
		$this->db->where('usuario_id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function usuarios_desaprobados2($id){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('resultado', "NA");
		$this->db->where('estado', 1);
		$this->db->where('liberacion', 1);
		$this->db->where('usuario_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	function usuarios_aprobados(){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('resultado = "A" or resultado = "B" or resultado = "C"');
		$this->db->where('estado', 1);
		$this->db->where('liberacion', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function usuarios_desaprobados(){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('resultado', "NA");
		$this->db->where('estado', 1);
		$this->db->where('liberacion', 1);
		$query = $this->db->get();
		return $query->result();
	}

	

	function existe_usuario($usuario_id){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos');
		$this->db->where('usuario_id', $usuario_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NADA";
		}
	}

	function actualizar_examen_psicologico($actualizar_examen_psicologico, $id_examen_psicologico){
		$this->db->where('id', $id_examen_psicologico);
		$this->db->update('examenes_psicologicos', $actualizar_examen_psicologico);
	}

	function nuevo_examen_psicologico($nuevo_examen_psicologico){
		$this->db->insert('examenes_psicologicos', $nuevo_examen_psicologico);
	}

	function get_ultimo_examen($usu_id, $fecha_inicio_req = FALSE, $fecha_vigencia_req = FALSE){
		$this->db->select('*');
		$this->db->select('id as eval_psic_id');
		$this->db->select('DATEDIFF(fecha_vigencia,now()) as estado_psic');
		if($fecha_inicio_req != FALSE){
			$this->db->select('DATEDIFF(fecha_vigencia, ("'.$fecha_inicio_req.'")) as estado_inicio_psicol');
			$this->db->select('DATEDIFF(fecha_vigencia, ("'.$fecha_vigencia_req.'")) as estado_fin_psicol');
		}
		$this->db->from('examenes_psicologicos');
		$this->db->where('usuario_id',$usu_id);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get();
		return $query->row();
	}


}
?>