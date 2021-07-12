<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Ofertas extends CI_Controller {
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

	public function index(){
		$this->load->helper('text');
		$this->load->helper('fechas');
		$base['titulo'] = "Ofertas Laborales - Empresas integra";
		$base['lugar'] = "Ofertas Laborales";
		$pagina['pag_lugar'] = "ofertas";

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
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$pagina['listado_noticias'] = $lista;
		$base['cuerpo'] = $this->load->view('noticias/listado_ofertas', $pagina, TRUE);
		$this->load->view('layout', $base);
	}

	function detalle($id = FALSE){
		if(empty($id)) redirect('/error/error_404', 'refresh');

		$this->load->model("Ofertas_model");

		$id = base64_decode(urldecode($id));
		$noticia = $this->Ofertas_model->get($id);
		$tipo_usuario = $this->Ofertas_model->get_tu($id);
		$adjuntos = $this->Ofertas_model->listar_adjuntos($id);
		

		$entra = FALSE;
		foreach($tipo_usuario as $tu){
			if($this->session->userdata('tipo') != 3){ //validacion de no ingreso a noticia autorizada
				if( $tu->id_tipo_usuarios == $this->session->userdata('tipo') || $tu->id_tipo_usuarios  == NULL )
					$entra = TRUE;
			}
		}

		//if (!$entra) redirect('/error/error_404', 'refresh');
		
		$base['titulo'] = "Ofertas Laborales - Empresas Integra";
		$base['lugar'] = "Ofertas Laborales";
		$pagina['noticia'] = $noticia;
		$pagina['adjuntos'] = $adjuntos;
		$pagina['pag_lugar'] = "Ofertas Laborales";

		/*if( count($this->Ofertas_model->noticias_noleidas_usr($id,$this->session->userdata('id'))) > 0 ){
			$revisar = $this->Ofertas_model->noticias_noleidas_id($id,$this->session->userdata('id'));
			$this->Ofertas_model->eliminar_revisar($revisar->id);
		}

		$s = $this->Ofertas_model->get_revisar($this->session->userdata('id'),$id);
		
		if($s < 1){
			$data = array(
				'id_oferta' => $id,
				'id_usuario' => $this->session->userdata('id'),
				'fecha' => date("Y-m-d H:i:s")
			);
			$this->Ofertas_model->ingresar_revisar($data);
		}
		*/
		$pagina['noticia_limite'] = $this->Ofertas_model->listar_limite(4,2);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$base['cuerpo'] = $this->load->view('noticias/detalle_oferta', $pagina, TRUE);
		$this->load->view('layout', $base);
	}
}
?>