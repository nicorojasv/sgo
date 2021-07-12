<?php
class Finiquitos_model extends CI_Model {

	function __construct(){
		$this->marina = $this->load->database('marina', TRUE);
	}

	function guardar($data){
		$this->marina->insert('finiquitos',$data); 
	}

	function get_archivo($id_usu_arch){
		$this->marina->select('*');
		$this->marina->from('finiquitos');
		$this->marina->where('id_req_usu_archivo',$id_usu_arch);
		$query = $this->marina->get();
		return $query->row();
	}

}
?>