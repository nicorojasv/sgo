<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Noticias extends CI_Controller {
	public $noticias;

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo') == "trabajador" and $this->session->userdata('subtipo') == "integra")
			$this->menu = $this->load->view('layout2.0/menus/menu_trabajador','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');

		$this->load->model("Noticias_est_model");
		$this->load->model("Noticias_model");
		$this->load->model("Ofertas_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Evaluacionestipo_model");
		$this->noticias['noticias_noleidas'] = $this ->Noticias_est_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->noticias['capacitaciones_noleidas'] = $this->Noticias_est_model->cont_capacitacion_noleidas($this->session->userdata('id'));
		$this->noticias['ofertas_noleidas'] = $this->Ofertas_model->cont_ofertas_noleidas($this->session->userdata('id'));
		$this->noticias['requerimiento_nuevo'] = $this->Asignarequerimiento_model->cant_asignados($this->session->userdata('id'));
		$this->noticias['listado_tipoeval'] = $this->Evaluacionestipo_model->listar();
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_trabajador($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->noticias['mensajes_noleidos'] = $suma;
	}

	function index(){
		redirect('trabajador', 'refresh');
		/*
		$this->load->helper('text');
		$this->load->helper('fechas');
		$base['titulo'] = "Noticias integra";
		$base['lugar'] = "Noticias";
		$pagina['pag_lugar'] = "noticias";
		
		$lista = array();
		foreach($this->Noticias_est_model->mostrar_listado(2,$this->session->userdata('id')) as $n){//solo mostrara usuarios tipo 2, que son trabajadores.
			$aux = new stdClass();
			$leido = $this->Noticias_model->noticias_noleidas_usr($n->id_noticia,$this->session->userdata('id'));
			$aux->id = urlencode(base64_encode($n->id_noticia));
			$aux->titulo = $n->titulo;
			$aux->texto = word_limiter(strip_tags($n->desc_noticia), 30);
			$aux->fecha = $n->fecha;
			$aux->leido = (!empty($leido))? true : false;
			array_push($lista,$aux);
			unset($aux,$leido);
		}
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['menu'] = $this->load->view('menus/menu_trabajador', $this->noticias, TRUE);
		$pagina['listado_noticias'] = $lista;
		$base['cuerpo'] = $this->load->view('noticias/listado', $pagina, TRUE);
		$this->load->view('layout', $base);*/
	}
	
	function detalle($id = FALSE){
		if(empty($id)) redirect('/error/error_404', 'refresh');
		$id = base64_decode(urldecode($id));
		$noticia = $this->Noticias_model->get($id);
		$tipo_usuario = $this->Noticias_model->get_tu($id);
		$adjuntos = $this->Noticias_model->listar_adjuntos($id);

		$base = array(
			'head_titulo' => "Noticias Integra",
			'titulo' => "Noticias",
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => 'trabajador', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Detalle Noticias')  ),
			'menu' => $this->menu
		);
		$pagina['noticia'] = $noticia;
		$pagina['adjuntos'] = $adjuntos;
		$pagina['pag_lugar'] = "Noticias";

		$s = $this->Noticias_model->get_revisar($this->session->userdata('id'),$id);
		
		if($s < 1){
			$data = array(
				'id_noticia' => $id,
				'id_usuario' => $this->session->userdata('id'),
				'fecha' => date("Y-m-d H:i:s")
			);
			$this->Noticias_model->ingresar_revisar($data);
		}
		$pagina['noticia_limite'] = $this->Noticias_est_model->listar_limite(4,2);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$base['cuerpo'] = $this->load->view('noticias/detalle', $pagina, TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

	function eliminar_noticia(){
		$this->load->model("Noticias_model");

		$news_list = $_POST['editar'];
		foreach ($news_list as $l) {
			$id = base64_decode(urldecode($l));
			$data = array(
				'id_noticia' => $id,
				'id_usuario' => $this->session->userdata('id'),
				'fecha' => date("Y-m-j")
			);
			$this->Noticias_model->eliminar_noticia($data);
		}

		redirect('/trabajador/noticias/', 'refresh');
	}

}
?>