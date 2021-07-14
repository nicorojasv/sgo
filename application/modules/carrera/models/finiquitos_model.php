<?php
class Finiquitos_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function guardar($data){
		$this->carrera->insert('finiquitos',$data); 
	}

	function get_archivo($id_usu_arch){
		$this->carrera->select('*');
		$this->carrera->from('finiquitos');
		$this->carrera->where('id_req_usu_archivo',$id_usu_arch);
		$query = $this->carrera->get();
		return $query->row();
	}

}
?>