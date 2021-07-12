<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Noticias extends CI_Controller {
	public $noticias;

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('usuarios/login/index', 'refresh');
		/*elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');*/
		elseif ($this->session->userdata('tipo') != 7) {
			redirect('usuarios/login/index', 'refresh');
		}else{
			redirect('usuarios/login/index', 'refresh');
		}
	}

	function index() {
		$this->load->helper('text');
		$this->load->helper('fechas');
		$base['titulo'] = "Noticias integra";
		$base['lugar'] = "Noticias";
		$pagina['pag_lugar'] = "noticias";
		$this->load->model("Noticias_model");
		
		$lista = array();
		foreach($this->Noticias_model->mostrar_listado(2,$this->session->userdata('id')) as $n){//solo mostrara usuarios tipo 2, que son trabajadores.
			$aux = new stdClass();
			$leido = $this->Noticias_model->noticias_noleidas_usr($n->id_noticia,$this->session->userdata('id'));
			$aux->id = urlencode(base64_encode($n->id_noticia));
			$aux->titulo = $n->titulo;
			$aux->texto = word_limiter(strip_tags($n->desc_noticia), 30);
			$aux->fecha = $n->fecha;
			$aux->leido = true;
			array_push($lista,$aux);
			unset($aux,$leido);
		}
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$pagina['listado_noticias'] = $lista;
		$base['cuerpo'] = $this->load->view('noticias/listado', $pagina, TRUE);
		$this->load->view('layout', $base);
	}
	
	function detalle($id = FALSE){
		if(empty($id)) redirect('/error/error_404', 'refresh');
		$id = base64_decode(urldecode($id));
		$this->load->model("Noticias_model");
		$noticia = $this->Noticias_model->get($id);
		$tipo_usuario = $this->Noticias_model->get_tu($id);
		$adjuntos = $this->Noticias_model->listar_adjuntos($id);
		

		$entra = FALSE;
		foreach($tipo_usuario as $tu){
			if($this->session->userdata('tipo') != 3){ //validacion de no ingreso a noticia autorizada
				if( $tu->id_tipo_usuarios == $this->session->userdata('tipo') || $tu->id_tipo_usuarios  == NULL )
					$entra = TRUE;
			}
		}

		//if (!$entra) redirect('/error/error_404', 'refresh');
		
		$base['titulo'] = "Noticias integra";
		$base['lugar'] = "Noticias";
		$pagina['noticia'] = $noticia;
		$pagina['adjuntos'] = $adjuntos;
		$pagina['pag_lugar'] = "Noticias";

		/*if( count($this->Noticias_model->noticias_noleidas_usr($id,$this->session->userdata('id'))) > 0 ){
			$revisar = $this->Noticias_model->noticias_noleidas_id($id,$this->session->userdata('id'));
			$this->Noticias_model->eliminar_revisar($revisar->id);
		}
		$s = $this->Noticias_model->get_revisar($this->session->userdata('id'),$id);
		
		if($s < 1){
			$data = array(
				'id_noticia' => $id,
				'id_usuario' => $this->session->userdata('id'),
				'fecha' => date("Y-m-d H:i:s")
			);
			$this->Noticias_model->ingresar_revisar($data);
		}*/
		$pagina['noticia_limite'] = $this->Noticias_model->listar_limite(4,2);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$base['cuerpo'] = $this->load->view('noticias/detalle', $pagina, TRUE);
		$this->load->view('layout', $base);
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

		redirect('/consulta/noticias/', 'refresh');
	}

}
?>