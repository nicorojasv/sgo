<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Ofertas extends CI_Controller{
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
		$pagina['pag_lugar'] = "ofertas";

		$base = array(
			'head_titulo' => "Ofertas Laborales - Empresas integra",
			'titulo' => "Ofertas Laborales",
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => 'trabajador', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Listado de Ofertas') ),
			'menu' => $this->menu
		);

		$this->load->model("Ofertas_model");
		
		$lista = array();
		foreach($this->Ofertas_model->mostrar_listado(2) as $n){//solo mostrara usuarios tipo 2, que son trabajadores.
			$aux = new stdClass();
			$leido = $this->Ofertas_model->noticias_noleidas_usr($n->oferta_id,$this->session->userdata('id'));
			$aux->id = urlencode(base64_encode($n->oferta_id));
			$aux->titulo = $n->titulo;
			$aux->texto = word_limiter(strip_tags($n->desc_oferta), 30);
			$aux->fecha = $n->fecha;
			$aux->leido = (!empty($leido))? true : false;
			$aux->activo = $n->activo;
			array_push($lista,$aux);
			unset($aux,$leido);
		}
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['listado_noticias'] = $lista;
		$base['cuerpo'] = $this->load->view('noticias/listado_ofertas', $pagina, TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

	function detalle($id = FALSE){
		if(empty($id)) redirect('/error/error_404', 'refresh');
		$this->load->model("Ofertas_model");

		$base = array(
			'head_titulo' => "Ofertas Laborales - Empresas Integra",
			'titulo' => "Ofertas Laborales",
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => 'trabajador', 'txt' => 'Inicio'), array('url' => 'trabajador/ofertas', 'txt' => 'Listado de Ofertas'), array('url' => '', 'txt' => 'Detalle de Ofertas') ),
			'menu' => $this->menu
		);

		$id = base64_decode(urldecode($id));
		$noticia = $this->Ofertas_model->get($id);
		$tipo_usuario = $this->Ofertas_model->get_tu($id);
		$adjuntos = $this->Ofertas_model->listar_adjuntos($id);
		
		$entra = FALSE;
		foreach($tipo_usuario as $tu){
			if($this->session->userdata('tipo') != 3){
				if( $tu->id_tipo_usuarios == $this->session->userdata('tipo') || $tu->id_tipo_usuarios  == NULL )
					$entra = TRUE;
			}
		}

		//if (!$entra) redirect('/error/error_404', 'refresh');
		$pagina['noticia'] = $noticia;
		$pagina['adjuntos'] = $adjuntos;
		$pagina['pag_lugar'] = "Ofertas Laborales";
		$s = $this->Ofertas_model->get_revisar($this->session->userdata('id'),$id);
		
		if($s < 1){
			$data = array(
				'id_oferta' => $id,
				'id_usuario' => $this->session->userdata('id'),
				'fecha' => date("Y-m-d H:i:s")
			);
			$this->Ofertas_model->ingresar_revisar($data);
		}

		$pagina['noticia_limite'] = $this->Ofertas_model->listar_limite(4,2);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$base['cuerpo'] = $this->load->view('noticias/detalle_oferta', $pagina, TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
		//$this->load->view('layout', $base);
	}
}
?>