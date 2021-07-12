<?php
class Finiquitos_model extends CI_Model {

	function __construct(){
		$this->marina_chillan = $this->load->database('marina_chillan', TRUE);
	}

	function guardar($data){
		$this->marina_chillan->insert('finiquitos',$data); 
	}

	function get_archivo($id_usu_arch){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('finiquitos');
		$this->marina_chillan->where('id_req_usu_archivo',$id_usu_arch);
		$query = $this->marina_chillan->get();
		return $query->row();
	}

}
?>