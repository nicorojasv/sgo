<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Noticias_Laborales extends CI_Controller{
	public $noticias;
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo') == "trabajador" and $this->session->userdata('subtipo') == "integra")
			$this->menu = $this->load->view('layout2.0/menus/menu_trabajador', $this->noticias, TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');

		$this->load->model("Noticias_est_model");
		$this->load->model("Noticias_model");
		$this->load->model("Ofertas_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Evaluacionestipo_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_est_model->cont_noticias_noleidas($this->session->userdata('id'));
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

	public function index(){
		$this->load->helper('text');
		$this->load->helper('fechas');
		$pagina['pag_lugar'] = "noticias_laborales";

		$base = array(
			'head_titulo' => "Noticias Laborales - Empresas integra",
			'titulo' => "Noticias Laborales",
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => 'trabajador', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Listado de Noticias Laborales') ),
			'menu' => $this->menu
		);
		
		$lista = array();
		foreach($this->Noticias_model->listar_categoria_des(1) as $n){//solo mostrara usuarios tipo 2, que son trabajadores.
			$aux = new stdClass();
			$leido = $this->Noticias_model->get_revisar($this->session->userdata('id'), $n->id);
			$aux->id = urlencode(base64_encode($n->id));
			$aux->titulo = $n->titulo;
			$aux->texto = word_limiter(strip_tags($n->desc_noticia), 30);
			$aux->fecha = $n->fecha;
			$aux->leido = (!empty($leido))?true:false;
			array_push($lista,$aux);
			unset($aux,$leido);
		}
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['listado_noticias'] = $lista;
		$base['cuerpo'] = $this->load->view('noticias/listado_noticias', $pagina, TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

	function detalle($id = FALSE){
		if(empty($id)) redirect('/error/error_404', 'refresh');
		
		$base = array(
			'head_titulo' => "Noticias Laborales - Empresas Integra",
			'titulo' => "Noticias Laborales",
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => 'trabajador', 'txt' => 'Inicio'), array('url' => 'trabajador/noticias_laborales', 'txt' => 'Listado de Noticias Laborales'), array('url' => '', 'txt' => 'Detalle de la Noticia') ),
			'menu' => $this->menu
		);

		$id = base64_decode(urldecode($id));
		$noticia = $this->Noticias_model->get($id);
		$adjuntos = $this->Noticias_model->listar_adjuntos($id);

		$pagina['noticia'] = $noticia;
		$pagina['adjuntos'] = $adjuntos;
		$pagina['pag_lugar'] = "Noticias Laborales";
		$s = $this->Noticias_model->get_revisar($this->session->userdata('id'),$id);
		
		if($s < 1){
			$data = array(
				'id_noticia' => $id,
				'id_usuario' => $this->session->userdata('id'),
				'fecha' => date("Y-m-d H:i:s")
			);
			$this->Noticias_model->ingresar_revisar($data);
		}

		$pagina['noticia_limite'] = $this->Noticias_model->listar_limite(4);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$base['cuerpo'] = $this->load->view('noticias/detalle_noticias', $pagina, TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}
}
?>