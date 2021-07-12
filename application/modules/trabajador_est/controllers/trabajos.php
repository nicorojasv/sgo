<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Trabajos extends CI_Controller {
	public $requerimiento;
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
		
		$this->load->model("Requerimiento_model");
		$this->requerimiento['requerimiento_noleidos'] = $this->Requerimiento_model->noleidas();
		$this->requerimiento['requerimiento_eliminacion'] = $this->Requerimiento_model->pet_eliminacion();
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$this->load->model("Evaluacionestipo_model");
		$this->requerimiento['listado_evaluaciones'] = $this->Evaluacionestipo_model->listar(); 
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_admin($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->requerimiento['mensajes_noleidos'] = $suma;
   	}
	function index(){
		$this->load->model("Usuarios_model");
		$this->load->model("Tipousuarios_model");
		$this->load->model("Asignarrequerimiento_model");
		$id = $this->session->userdata('id');

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: ".$this->session->userdata('empresa'),
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'menu' => $this->menu
		);

		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);

		$lista = array();
		foreach ($this->Asignarrequerimiento_model->historial($id) as $h) {
			$aux = new stdClass();
			$a = $this->Areas_model->get_empresa($h->id_area);
			$c = $this->Cargos_model->get_empresa($h->id_cargo);
			$g = $this->Grupo_model->get($h->id_grupo);
			$aux->solicitud = $h->f_solicitud;
			$aux->inicio = $h->f_inicio;
			$aux->fin = $h->f_fin;
			$aux->motivo = $h->motivo;
			$aux->area = $a->desc_area;
			$aux->cargo = $c->desc_cargo;
			$aux->grupo = $g->nombre;

			array_push($lista,$aux);
			unset($aux,$a,$c,$g);
		}
		
		$pagina['trabajos'] = $lista;

		$base['cuerpo'] = $this->load->view('trabajos/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

}
?>