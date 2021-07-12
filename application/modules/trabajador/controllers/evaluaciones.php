<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Evaluaciones extends CI_Controller {
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

	function index( $nb = FALSE) {
		if($nb == FALSE)
			redirect('/error/error404', 'refresh');
		$existe_eval = $this->Evaluacionestipo_model->get_nombre( mb_strtoupper(urldecode($nb),"UTF-8"));
		if(!$existe_eval)
			redirect('/error/error404', 'refresh');

		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Cargos_model");
		$this->load->model("Areas_model");

		$nb = ucwords(mb_strtolower(urldecode($nb),'UTF-8'));

		$base = array(
			'head_titulo' => "Informe de Evaluaciones",

			'titulo' => "Evaluaciones de ".$nb,
			'subtitulo' => 'Evaluaciones',
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'menu' => $this->menu
		);

		$listado = array();
		
		foreach($this->Evaluacionesevaluacion_model->get_tipo($existe_eval->id) as $e){
			foreach($this->Evaluaciones_model->get_ue($this->session->userdata('id'),$e->id) as $u){
				$aux = new stdClass();
				$aux->nb_evaluacion = $e->nombre;
				$aux->id_planta = $u->id_planta;
				$aux->fecha_e = $u->fecha_e;
				$aux->fecha_v = $u->fecha_v;
				$aux->faena = $u->faena;
				if($u->id_area != NULL)
					$aux->area = $this->Areas_model->get($u->id_area)->desc_area;
				if($u->id_cargo != NULL)
					$aux->cargo = $this->Cargos_model->get($u->id_cargo)->desc_cargo;
				$aux->faena = $u->faena;
				$aux->resultado = $u->resultado;
				$aux->tipo_resultado = $e->tipo_resultado;
				$aux->recomienda = $u->recomienda;
				$aux->obs = $u->observaciones;
				array_push($listado,$aux);
				unset($aux);
			}
		}
		$pagina['res'] = $listado;
		$pagina['nb_eval'] = $nb;
		$base['cuerpo'] = $this->load->view('evaluacion/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

	function informe(){
		$id = $this->session->userdata('id');
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Tipousuarios_model");
		$this->load->model("Fotostrab_model");
		
		$base = array(
			'head_titulo' => "Informe de Evaluaciones",
			'titulo' => "Informe de Evaluaciones",
			'subtitulo' => 'Bienvenido al Sistema EST de Empresas Integra!!!',
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => 'trabajador', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Informe Evaluaciones')  ),
			'menu' => $this->menu
		);


		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($this->Usuarios_model->get($id)->id_tipo_usuarios);
		$evaluaciones = $this->Evaluaciones_model->get_all($id);
		$et = $this->Evaluaciones_model->get_desepeno($id);
		$pagina['evaluaciones'] = $evaluaciones;

		$user = $id;
		$arr = array();
		$aux = array();
		$id = 0;
		$i = 0;

		foreach ($et as $e) {
			$aux['nombre'] = $e->nombre_eval;
			$aux['promedio'] = "";
			$aux['porcentaje'] = "";
			$et_aux = $this->Evaluaciones_model->get_eval_user($e->id_eval,$user);
			foreach ($et_aux as $ea) {
				$s = str_replace(',', '.',$ea->resultado);
				$fecha_des = explode("-",$ea->fecha_e);
				$fecha_des = $fecha_des[2]."-".$fecha_des[1]."-".$fecha_des[0];
				$aux['sub'][] = array(
					'nombre' => $fecha_des." ".$ea->faena, 
					'nota' => $s,
					'recomienda' => $ea->recomienda,
					'comentario' => $ea->observaciones,
				);
			}
			$arr[$i] = $aux;
			$i += 1;
		}

		for($i = 0; $i < count($arr); $i++){
			$vuelta = 0;
			$sumatoria = 0;
			$si = 0;
			foreach ($arr[$i]['sub'] as $m) {
				$sumatoria += $m['nota'];
				$vuelta += 1;
				if($m['recomienda'] == 1){
					$si += 1;
				}
			}
			$prom = $sumatoria / $vuelta;
			$arr[$i]['promedio'] = round($prom,1);
			$prom = ($si * 100) / $vuelta;
			$arr[$i]['porcentaje'] = round($prom,2)."%";
			$i += 1;
		}

		$pagina['le'] = $arr;
		$base['cuerpo'] = $this->load->view('evaluacion/informe',$pagina,TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

}
?>