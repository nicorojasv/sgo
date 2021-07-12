<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Error extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
	//	if($this->session->userdata('logged') == FALSE)
		//	 redirect('usuarios/login/index', 'refresh');
	}

	function index(){

	}

	function error_404(){
		$base['titulo'] = "Pagina no encontrada";
		$base['lugar'] = "¡Houston, tenemos un problema!";
		$this->load->view('error/404',$base);
	}

}
?>