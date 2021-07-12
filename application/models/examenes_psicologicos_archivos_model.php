<?php
class Examenes_psicologicos_archivos_model extends CI_Model{

	function guardar($datos){
		$this->db->insert('examenes_psicologicos_archivos',$datos);
	}

	function eliminar($id){
		$this->db->delete('examenes_psicologicos_archivos', array('id' => $id));
	}

	function actualizar($id_archivo, $datos){
		$this->db->where('id', $id_archivo);
		$this->db->update('examenes_psicologicos_archivos', $datos);
	}
	
	function get($id_examen){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos_archivos');
		$this->db->where('examen_psicologico_id', $id_examen);
		$query = $this->db->get();
		return $query->row();
	}

	function get_archivo_informe($id_examen){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos_archivos');
		$this->db->where('examen_psicologico_id', $id_examen);
		$this->db->where('tipo_examen_id', 1);
		$query = $this->db->get();
		return $query->row();
	}

	function get_archivo_examen($id_examen, $id_tipo_archivo){
		$this->db->SELECT('*');
		$this->db->from('examenes_psicologicos_archivos');
		$this->db->where('examen_psicologico_id', $id_examen);
		$this->db->where('tipo_examen_id', $id_tipo_archivo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return FALSE;
		}
	}

	function get_existe_registro_examen_psicologico($id_examen, $id_tipo_archivo){
		$this->db->SELECT('*');
		$this->db->from('examenes_psicologicos_archivos');
		$this->db->where('examen_psicologico_id', $id_examen);
		$this->db->where('tipo_examen_id', $id_tipo_archivo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_existe_registro_examen_psicologico_complemento($id_examen){
		$this->db->SELECT('*');
		$this->db->from('examenes_psicologicos_archivos');
		$this->db->where('examen_psicologico_id', $id_examen);
		$this->db->where('tipo_examen_id = 3 or tipo_examen_id = 4');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_archivo_examen_complemento_kostick($id_examen){
		$this->db->SELECT('*, epa.id as id_registro_archivo');
		$this->db->from('examenes_psicologicos_archivos epa');
		$this->db->join('examenes_psicologicos_tipo ept','epa.tipo_examen_id = ept.id','left');
		$this->db->where('epa.examen_psicologico_id', $id_examen);
		$this->db->where('epa.tipo_examen_id = 3');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return FALSE;
		}
	}

	function get_archivo_examen_complemento_western($id_examen){
		$this->db->SELECT('*, epa.id as id_registro_archivo');
		$this->db->from('examenes_psicologicos_archivos epa');
		$this->db->join('examenes_psicologicos_tipo ept','epa.tipo_examen_id = ept.id','left');
		$this->db->where('epa.examen_psicologico_id', $id_examen);
		$this->db->where('epa.tipo_examen_id = 4');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return FALSE;
		}
	}

	

}