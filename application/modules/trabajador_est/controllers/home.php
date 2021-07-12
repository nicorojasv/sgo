<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Home extends CI_Controller {
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

		$this->load->model("Noticias_Est_model");
		$this->load->model("Ofertas_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Evaluacionestipo_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_Est_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->noticias['capacitaciones_noleidas'] = $this->Noticias_Est_model->cont_capacitacion_noleidas($this->session->userdata('id'));
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
		$base = array(
			'head_titulo' => "Sistema EST - Trabajador",
			'titulo' => "Escritorio",
			'subtitulo' => "Resumen Perfil Trabajador",
		);
		$this->load->model("Usuarios_model");
		$this->load->model('Profesiones_model');
		$this->load->model('Noticias_Est_model');
		$this->load->model('Ofertas_model');
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		$this->load->helper('text');
		$aviso['titulo'] = "Aviso: <a href='#'>Se le ha asignado un nuevo trabajo</a>";
		$aviso['comentario'] = "Tiene que cerrar este mensaje para que no se vuelva a ver.";
		//$pagina['avisos'] = $this -> load -> view('avisos', $aviso, TRUE);
		$pagina['menu'] = $this->load->view('layout2.0/menus/menu_trabajador', $this->noticias, TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['noticias'] = $this->Noticias_Est_model->listar_limite(3,2);
		$pagina['capacitacion'] = $this->Noticias_Est_model->listar_limite_cap(3,2);
		$pagina['ofertas'] = $this->Ofertas_model->listar_limite(3,2);
		
		$listado_evaluaciones = array();
		$i = 0;
		foreach($this->Evaluaciones_model->listar_usuario($this->session->userdata('id')) as $l){
			$aux = new stdClass();
			$eval = $this->Evaluacionesevaluacion_model->get($l->id_evaluacion);
			$eval_tipo = $this->Evaluacionestipo_model->get($eval->id_tipo);
			$aux->nombre = $eval->nombre;
			if($l->fecha_v != '0000-00-00'){
				$fv = explode('-',$l->fecha_v);
				$aux->vigencia = $fv[2].'-'.$fv[1].'-'.$fv[0];
			}
			else
				$aux->vigencia = FALSE;
			
			if($eval->tipo_resultado == 1 )
				$aux->resultado = $l->resultado;
			else{
				if($eval_tipo->nombre == "MEDICA" ){
					if($l->resultado == 0) $aux->resultado = "Sin Contraindicaciones";
					if($l->resultado == 1) $aux->resultado = "Con Contraindicaciones";
				}
				if($eval_tipo->nombre == "CONOCIMIENTO" || $eval_tipo->nombre == "SEGURIDAD" ){
					if($l->resultado == 0) $aux->resultado = "Aprobado";
					if($l->resultado == 1) $aux->resultado = "Rechazado";
				}
			}
			array_push($listado_evaluaciones,$aux);
			unset($aux);
			$i++;
			//if($i > 3) break;
		}
		
		//$pagina['evaluaciones'] = $listado_evaluaciones;
		$pagina['evaluaciones'] = $this->Evaluaciones_model->not_all($this->session->userdata('id')); 
		
		//listado noticias requerimiento
		$this->load->model('Publicaciones_requerimientos_model');
		$listado_requerimientos = array();
		$z = 0;
		foreach($this->Publicaciones_requerimientos_model->listar_usuario($this->session->userdata('id')) as $r){
			$aux = new stdClass();
			$aux->nombre_requerimiento = $r->nombre_requerimiento;
			$aux->titulo = $r->titulo;
			$aux->texto = $r->desc_publicacion;
			$aux->id = $r->idpr;
			$aux->id_area = $r->id_area;
			array_push($listado_requerimientos,$aux);
			unset($aux);
			$z++;
			if($z > 5) break;
		}
		$pagina['requerimientos'] = $listado_requerimientos;
		$base['cuerpo'] = $this->load->view('trabajador_est/home/home', $pagina, TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu', $base);
	}

}
?>