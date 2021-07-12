<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Centros_de_costo extends CI_Controller {
	public $noticias;
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		
		elseif($this->session->userdata('tipo') != 1){
			redirect('/login/index', 'refresh');
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
	function index($msg = FALSE) {
		$this->load->model('Centrocostos_model');
		$this->load->model('Usuarios_model');
		
		$base['titulo'] = "Listado y publicacion de centros de costo";
		$base['lugar'] = "Centros de costo";
		
		$base['lugar_aux'] = "<a href='#modal' class='tab dialog'>Nuevo centro de costo</a>";
		$base['class_subheader'] = "toolbar";
		
		/*** mensajes ***/
		if($msg == "agregar_correcto"){	
			$aviso['titulo'] = "Se ha ingresado el centro de costo correctamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "eliminar_correcto"){	
			$aviso['titulo'] = "Se ha eliminado el centro de costo correctamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "eliminar_incorrecto"){	
			$aviso['titulo'] = "No se ha podido eliminar el centro de costo, intente nuevamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "editado_correcto"){	
			$aviso['titulo'] = "Se ha editado el centro de costos correctamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		/***************************************************************/
		
		
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$id_planta = $this->Usuarios_model->get($this->session->userdata('id'))->id_planta; 
		$pagina['listado_cc'] = $this->Centrocostos_model->listar_planta($id_planta);
		$base['cuerpo'] = $this->load->view('centro_costo',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function ingresar(){
		$this->load->model('Centrocostos_model');
		$this->load->model('Usuarios_model');
		$data = array(
			'id_planta' => $this->Usuarios_model->get($this->session->userdata('id'))->id_planta,
			'desc_centrocosto' => mb_strtoupper($_POST['cc'],'UTF-8')
		);
		$this->Centrocostos_model->ingresar($data);
		redirect('mandante/centros_de_costo/index/agregar_correcto', 'refresh');
	}
	
	function eliminar($id){
		if( is_numeric($id)){
			$this->load->model('Centrocostos_model');
			$this->Centrocostos_model->eliminar($id);
			redirect('mandante/centros_de_costo/index/eliminar_correcto', 'refresh');
		}
		else{
			redirect('mandante/centros_de_costo/index/eliminar_incorrecto', 'refresh');
		}
	}
	
	function html_editar($tipo,$id){
		if($tipo == "centro_costo"){
			$this->load->model('Centrocostos_model');
			$pagina['titulo'] = "centros de costo";
			$pagina['url_form'] = "centros_de_costo/editar";
			$pagina['subtitulo'] = "el centro de costo";
			$pagina['nombre'] = $this->Centrocostos_model->get($id)->desc_centrocosto;
			$pagina['id'] = $id;
			$this->load->view('editar_actividades',$pagina);
		}
	}
	function editar(){
		$this->load->model('Centrocostos_model');
		$id = $_POST['id'];
		$nb = $_POST['nuevo']; 
		$data = array('desc_centrocosto' => $nb);
		$this->Centrocostos_model->editar($id,$data);
		redirect('mandante/centros_de_costo/index/editado_correcto', 'refresh');
	}

}
?>