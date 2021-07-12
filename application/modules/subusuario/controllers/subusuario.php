<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Subusuario extends CI_Controller {
	
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 6){
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');
   	}
	
	function index() {
		$base['titulo'] = "Inicio Sub usuario";
		$base['lugar'] = "Escritorio";
		//echo $this->session->userdata('tipo');
		$aviso['titulo'] = "Bienvenido: <a href='#'>Revisar tal parte del sitio</a>";
		$aviso['comentario'] = "Tiene que cerrar este mensaje para que no se vuelva a ver."; 
		//$pagina['avisos'] = $this -> load -> view('avisos',$aviso,TRUE);
		$pagina['menu'] = $this->load->view('menus/menu_subusuario','',TRUE);
		$base['cuerpo'] = $this->load->view('home',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
}
?>