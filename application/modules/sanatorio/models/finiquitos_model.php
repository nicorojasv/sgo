<?php
class Finiquitos_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function guardar($data){
		$this->sanatorio->insert('finiquitos',$data); 
	}

	function get_archivo($id_usu_arch){
		$this->sanatorio->select('*');
		$this->sanatorio->from('finiquitos');
		$this->sanatorio->where('id_req_usu_archivo',$id_usu_arch);
		$query = $this->sanatorio->get();
		return $query->row();
	}

}
?>