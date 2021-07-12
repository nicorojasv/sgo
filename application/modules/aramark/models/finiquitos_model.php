<?php
class Finiquitos_model extends CI_Model {

	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}

	function guardar($data){
		$this->aramark->insert('finiquitos',$data); 
	}

	function get_archivo($id_usu_arch){
		$this->aramark->select('*');
		$this->aramark->from('finiquitos');
		$this->aramark->where('id_req_usu_archivo',$id_usu_arch);
		$query = $this->aramark->get();
		return $query->row();
	}

}
?>