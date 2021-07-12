<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Areas extends CI_Controller {
	public $noticias;
	
	public function __construct(){
    	parent::__construct();
    	/*$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 1){
			redirect('usuarios/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

		$this->load->model("Noticias_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_admin($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->noticias['mensajes_noleidos'] = $suma;
   	}
	function index($msg = false) {
		$this->load->model('Areas_model');
		$this->load->model('Usuarios_model');
		$base['titulo'] = "Listado y publicacion de areas";
		$base['lugar'] = "Areas";
		
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nueva area</a>";
		$base['class_subheader'] = "toolbar";
		
		
		/*** mensajes ***/
		if($msg == "agregar_correcto"){	
			$aviso['titulo'] = "Se ha ingresado el area correctamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "eliminar_correcto"){	
			$aviso['titulo'] = "Se ha eliminado el area correctamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "eliminar_incorrecto"){	
			$aviso['titulo'] = "No se ha podido eliminar el area, intente nuevamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "editado_correcto"){	
			$aviso['titulo'] = "Se ha editado el area correctamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		/***************************************************************/
		
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$id_planta = $this->Usuarios_model->get($this->session->userdata('id'))->id_planta; 
		$pagina['listado_areas'] = $this->Areas_model->listar_planta($id_planta);
		$base['cuerpo'] = $this->load->view('areas',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function ingresar(){
		$this->load->model('Areas_model');
		$this->load->model('Usuarios_model');
		$data = array(
			'id_planta' => $this->Usuarios_model->get($this->session->userdata('id'))->id_planta,
			'desc_area' => mb_strtoupper($_POST['area'], 'UTF-8')
		);
		$this->Areas_model->ingresar($data);
		redirect('mandante/areas/index/agregar_correcto', 'refresh');
	}
	
	function eliminar($id){
		if( is_numeric($id)){
			$this->load->model('Areas_model');
			$this->Areas_model->eliminar($id);
			redirect('mandante/areas/index/eliminar_correcto', 'refresh');
		}
		else{
			redirect('mandante/areas/index/eliminar_incorrecto', 'refresh');
		}
	}
	
	function html_editar($tipo,$id){
		if($tipo == "areas"){
			$this->load->model('Areas_model');
			$pagina['titulo'] = "area";
			$pagina['url_form'] = "areas/editar";
			$pagina['subtitulo'] = "del area";
			$pagina['nombre'] = $this->Areas_model->get($id)->desc_area;
			$pagina['id'] = $id;
			$this->load->view('editar_actividades',$pagina);
		}
	}
	function editar(){
		$this->load->model('Areas_model');
		$id = $_POST['id'];
		$nb = $_POST['nuevo']; 
		$data = array('desc_area' => $nb);
		$this->Areas_model->editar($id,$data);
		redirect('mandante/areas/index/editado_correcto', 'refresh');
	}
	
}
?>