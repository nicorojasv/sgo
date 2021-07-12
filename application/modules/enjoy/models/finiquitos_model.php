<?php
class Finiquitos_model extends CI_Model {

	function __construct(){
		$this->enjoy = $this->load->database('enjoy', TRUE);
	}

	function guardar($data){
		$this->enjoy->insert('finiquitos',$data); 
	}

	function get_archivo($id_usu_arch){
		$this->enjoy->select('*');
		$this->enjoy->from('finiquitos');
		$this->enjoy->where('id_req_usu_archivo',$id_usu_arch);
		$query = $this->enjoy->get();
		return $query->row();
	}

}
?>