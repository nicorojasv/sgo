<?php
class Examenes_psicologicos_model extends CI_Model{
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function guardar($datos){
		$this->terramar->insert('examenes_psicologicos',$datos);
	}

	function eliminar_solicitud($id){
		$this->terramar->delete('examenes_psicologicos', array('id' => $id)); 
	}

	function actualizar($id_examen, $datos){
		$this->terramar->where('id', $id_examen);
		$this->terramar->update('examenes_psicologicos', $datos);
	}

	function actualizar_estado_ultimo_examen($id_usuario, $datos){
		$this->terramar->where('usuario_id', $id_usuario);
		$this->terramar->update('examenes_psicologicos', $datos); 
	}

	function listar_trabajadores_cc_planta($id_planta, $estado_examen = FALSE){
		$this->terramar->select('usuario_id');
		$this->terramar->from('examenes_psicologicos');

		if($id_planta != "todos")
			$this->terramar->where('lugar_trabajo_id', $id_planta);

		if($estado_examen == "no_cobrados")
			$this->terramar->where('estado_cobro', 0);
		elseif($estado_examen == "cobrados")
			$this->terramar->where('estado_cobro', 1);
		elseif($estado_examen == "no_informados")
			$this->terramar->where('estado_cobro', 2);

		$this->terramar->where('fecha_evaluacion >=', '2014-01-01');
		$this->terramar->group_by('usuario_id');
		$query = $this->terramar->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta_todos(){
		$this->terramar->select('usuario_id');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->group_by('usuario_id');
		$query = $this->terramar->get();
		return $query->result();
	}
	
	function get_result($id_examen){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('id', $id_examen);
		$query = $this->terramar->get();
		return $query->result();
	}

	function get_result_usu($id_usu, $id_lugar, $estado_examen = FALSE){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('usuario_id', $id_usu);

		if($id_lugar != "todos")
			$this->terramar->where('lugar_trabajo_id', $id_lugar);

		if($estado_examen == "no_cobrados")
			$this->terramar->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->terramar->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->terramar->where('estado_cobro', 2);

		$this->terramar->where('fecha_evaluacion >=', '2014-01-01');
		$query = $this->terramar->get();
		return $query->result();
	}

	function get_result_usu_todas_plantas($id_usu, $estado_examen = FALSE){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('usuario_id', $id_usu);

		if($estado_examen == "no_cobrados")
			$this->terramar->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->terramar->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->terramar->where('estado_cobro', 2);

		$query = $this->terramar->get();
		return $query->result();
	}

	function usuarios_pendiente_aprobacion(){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('liberacion', 0);
		$query = $this->terramar->get();
		return $query->result();
	}

	function usuarios_pendientes(){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('estado', 0);
		$this->terramar->where('liberacion', 1);
		$query = $this->terramar->get();
		return $query->result();
	}
	#yayo 03-10-2019
	function usuarios_pendientes2($id){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('estado', 0);
		$this->terramar->where('liberacion', 1);
		$this->terramar->where('usuario_id',$id);
		$query = $this->terramar->get();
		return $query->result();
	}

	function usuarios_aprobados2($id){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('(resultado = "A" or resultado = "B" or resultado = "C")');
		$this->terramar->where('estado', 1);
		$this->terramar->where('liberacion', 1);
		$this->terramar->where('usuario_id',$id);
		$query = $this->terramar->get();
		return $query->result();
	}
	function usuarios_aprobados(){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('resultado = "A" or resultado = "B" or resultado = "C"');
		$this->terramar->where('estado', 1);
		$this->terramar->where('liberacion', 1);
		$query = $this->terramar->get();
		return $query->result();
	}

	function usuarios_desaprobados(){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('resultado', "NA");
		$this->terramar->where('estado', 1);
		$this->terramar->where('liberacion', 1);
		$query = $this->terramar->get();
		return $query->result();
	}

	function existe_usuario($usuario_id){
		$this->terramar->select('*');
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('usuario_id', $usuario_id);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NADA";
		}
	}

	function actualizar_examen_psicologico($actualizar_examen_psicologico, $id_examen_psicologico){
		$this->terramar->where('id', $id_examen_psicologico);
		$this->terramar->update('examenes_psicologicos', $actualizar_examen_psicologico);
	}

	function nuevo_examen_psicologico($nuevo_examen_psicologico){
		$this->terramar->insert('examenes_psicologicos', $nuevo_examen_psicologico);
	}

	function get_ultimo_examen($usu_id, $fecha_inicio_req = FALSE, $fecha_vigencia_req = FALSE){
		$this->terramar->select('*');
		$this->terramar->select('id as eval_psic_id');
		$this->terramar->select('DATEDIFF(fecha_vigencia,now()) as estado_psic');
		if($fecha_inicio_req != FALSE){
			$this->terramar->select('DATEDIFF(fecha_vigencia, ("'.$fecha_inicio_req.'")) as estado_inicio_psicol');
			$this->terramar->select('DATEDIFF(fecha_vigencia, ("'.$fecha_vigencia_req.'")) as estado_fin_psicol');
		}
		$this->terramar->from('examenes_psicologicos');
		$this->terramar->where('usuario_id',$usu_id);
		$this->terramar->order_by("id", "desc"); 
		$query = $this->terramar->get();
		return $query->row();
	}


}
?>