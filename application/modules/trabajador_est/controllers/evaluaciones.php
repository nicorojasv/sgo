<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Evaluaciones extends CI_Controller {
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
		$this->load->model("Evaluaciones_model");
		$this->load->model("Tipousuarios_model");

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
		$id = $this->session->userdata('id');
		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		
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

		//print_r($arr);
		for($i = 0; $i < count($arr); $i++){
			$vuelta = 0;
			$sumatoria = 0;
			$si = 0;
			//print_r($arr[$i]).'<br/>';
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

		$base['cuerpo'] = $this->load->view('evaluaciones/informe',$pagina,TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

}
?>