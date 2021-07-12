<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Requerimiento extends CI_Controller {
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

	function asignado() {
		$base['titulo'] = "Trabajos asignados";
		$base['lugar'] = "Trabajo";
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("Empresas_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Planta_model");
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		
		$listado = array();
		foreach($this->Asignarequerimiento_model->get_despues2($this->session->userdata('id')) as $a ){
			$aux = new stdClass();
			$this->Asignarequerimiento_model->actualizar_leido($a->id_ar);
			$empresa = $this->Planta_model->get($a->id_planta)->id_empresa;
			$aux->id_req = encode_to_url($this->encrypt->encode($a->id_requerimiento));
			$aux->id_area = encode_to_url($this->encrypt->encode($a->id_areas));
			$aux->nombre =  $a->nombre;
			$aux->empresa = $this->Empresas_model->get($empresa)->razon_social;
			$aux->f_inicio = $a->fecha_inicio;
			$aux->f_termino = $a->termino_real;
			$aux->lugar = $a->lugar_trabajo;
			$aux->area =  $this->Areas_model->get($a->id_areas)->desc_area;
			$aux->cargo = $this->Cargos_model->get($a->id_cargos)->desc_cargo;
			array_push($listado,$aux);
			unset($aux);
		}
		
		$pagina['listado_trabajos'] = $listado;
		$pagina['menu'] = $this->load->view('menus/menu_trabajador', $this->noticias, TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$base['cuerpo'] = $this->load->view('requerimientos/asignado', $pagina, TRUE);
		$this->load->view('layout', $base);
	}
	
	function anteriores() {
		$base['titulo'] = "Trabajos anteriores";
		$base['lugar'] = "Trabajo";
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("Empresas_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Planta_model");
		
		$listado = array();
		foreach($this->Asignarequerimiento_model->get_anteriores2($this->session->userdata('id')) as $a ){
			$aux = new stdClass();
			$empresa = $this->Planta_model->get($a->id_planta)->id_empresa;
			$aux->nombre =  $a->nombre;
			$aux->empresa = $this->Empresas_model->get($empresa)->razon_social;
			$aux->f_inicio = $a->fecha_inicio;
			$aux->f_termino = $a->termino_real;
			$aux->lugar = $a->lugar_trabajo;
			$aux->area =  $this->Areas_model->get($a->id_areas)->desc_area;
			$aux->cargo = $this->Cargos_model->get($a->id_cargos)->desc_cargo;
			array_push($listado,$aux);
			unset($aux);
		}
		
		$pagina['listado_trabajos'] = $listado;
		$pagina['menu'] = $this->load->view('menus/menu_trabajador', $this->noticias, TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$base['cuerpo'] = $this->load->view('requerimientos/anteriores', $pagina, TRUE);
		$this->load->view('layout', $base);
	}
	
	function historial(){
		$id = $this->session->userdata('id');
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_usuario_archivo_model");
		$this->load->model('Usuarios_model');
		$this->load->model("Tipousuarios_model");

		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Usuarios_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');

		$base = array(
			'head_titulo' => "Sistema EST - Trabajador",
			'titulo' => "Historial de Trabajos",
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => 'trabajador', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Historial de Trabajos') ),
			'menu' => $this->menu
		);

		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);

		$lista = array();
		foreach ($this->Requerimiento_asc_trabajadores_model->get_historial_requerimientos($id) as $h){
			$aux = new stdClass();
			$get_archivo = $this->Requerimiento_usuario_archivo_model->get_archivos_req($h->rat_id);
			$aux->inicio = (isset($get_archivo->fecha_inicio)?$get_archivo->fecha_inicio:FALSE);
			$aux->fin = (isset($get_archivo->fecha_termino)?$get_archivo->fecha_termino:FALSE);
			$aux->motivo = (isset($get_archivo->motivo)?$get_archivo->motivo:"");
			$aux->area = $h->nombre_area;
			$aux->cargo = $h->nombre_cargo;
			array_push($lista,$aux);
			unset($aux);
		}
		
		$pagina['trabajos'] = $lista;
		$base['cuerpo'] = $this->load->view('historial_trabajos',$pagina,TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

}
?>