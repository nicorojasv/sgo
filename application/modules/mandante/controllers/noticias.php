<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Noticias extends CI_Controller {
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
		
		elseif ($this->session->userdata('tipo') != 1) {
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

	function index() {
		$this->load->helper('text');
		$this->load->helper('fechas');
		$base['titulo'] = "Noticias integra";
		$base['lugar'] = "Noticias";
		
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$lista = array();
		foreach($this->Noticias_model->mostrar_listado(1) as $n){//solo mostrara usuarios tipo 1, que son mandantes.
			$aux = new stdClass();
			$leido = $this->Noticias_model->noticias_noleidas_usr($n->id,$this->session->userdata('id'));
			$aux->id = urlencode(base64_encode($n->id));
			$aux->titulo = $n->titulo;
			$aux->texto = word_limiter($n->desc_noticia, 30);
			$aux->fecha = $n->fecha;
			$aux->leido = ($leido <1 )? true : false;
			array_push($lista,$aux);
			unset($aux,$leido);
		}
		$pagina['menu'] = $this->load->view('menus/menu_mandante', $this->noticias, TRUE);
		$pagina['listado_noticias'] = $lista;
		$base['cuerpo'] = $this->load->view('noticias/listado', $pagina, TRUE);
		$this->load->view('layout', $base);
	}
	
	function detalle($id){
		if(empty($id)) redirect('/error/error_404', 'refresh');
		$id = base64_decode(urldecode($id));
		$noticia = $this->Noticias_model->get($id);
		$adjuntos = $this->Noticias_model->listar_adjuntos($id);
		
		if($this->session->userdata('tipo') != 3){ //validacion de no ingreso a noticia autorizada
			if( $noticia->id_tipousuarios == $this->session->userdata('tipo') || $noticia->id_tipousuarios == NULL)
				TRUE;
			else
			 redirect('/error/error_404', 'refresh');
		}
		$base['titulo'] = "Noticias integra";
		$base['lugar'] = "Noticias";
		$pagina['noticia'] = $noticia;
		$pagina['adjuntos'] = $adjuntos;
		
		if($this->Noticias_model->noticias_noleidas_usr($noticia->id,$this->session->userdata('id')) > 0 ){
			$revisar = $this->Noticias_model->noticias_noleidas_id($noticia->id,$this->session->userdata('id'));
			$this->Noticias_model->eliminar_revisar($revisar->id);
		}
		$pagina['noticia_limite'] = $this->Noticias_model->listar_limite(4,2);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['menu'] = $this->load->view('menus/menu_mandante', $this->noticias, TRUE);
		$base['cuerpo'] = $this->load->view('noticias/detalle', $pagina, TRUE);
		$this->load->view('layout', $base);
	}

}
?>