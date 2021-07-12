<?php
class Finiquitos_model extends CI_Model {

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function guardar($data){
		$this->wood->insert('finiquitos',$data); 
	}

	function get_archivo($id_usu_arch){
		$this->wood->select('*');
		$this->wood->from('finiquitos');
		$this->wood->where('id_req_usu_archivo',$id_usu_arch);
		$query = $this->wood->get();
		return $query->row();
	}

}
?>