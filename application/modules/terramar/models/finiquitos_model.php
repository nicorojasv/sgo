<?php
class Finiquitos_model extends CI_Model {

	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function guardar($data){
		$this->terramar->insert('finiquitos',$data); 
	}

	function get_archivo($id_usu_arch){
		$this->terramar->select('*');
		$this->terramar->from('finiquitos');
		$this->terramar->where('id_req_usu_archivo',$id_usu_arch);
		$query = $this->terramar->get();
		return $query->row();
	}

}
?>