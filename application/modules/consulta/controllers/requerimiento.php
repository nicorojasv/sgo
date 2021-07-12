<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Requerimiento extends CI_Controller {

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
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Busqueda de usuarios";
		$this->load->model("Planta_model");
		$pagina['listado_plantas'] = $this->Planta_model->listar();

		if (isset($_POST['planta'])){
			$this->load->model("Areas_model");
			$this->load->model("Grupo_model");
			$this->load->model("Cargos_model");
			$this->load->model("Usuarios_model");
			$this->load->model("Evaluaciones_model");
			$this->load->model("Requerimientos_model");
			$this->load->model("Asignarrequerimiento_model");

			$id_planta = $_POST['planta'];
			$id_grupo = $_POST['grupo'];
			$id_area = $_POST['area'];
			$id_cargo = $_POST['cargo'];

			if($id_planta == 0) $id_planta = FALSE;
			if($id_grupo == 0) $id_grupo = FALSE;
			if($id_area == 0) $id_area = FALSE;
			if($id_cargo == 0) $id_cargo = FALSE;

			$res = $this->Requerimientos_model->listar_usuarios($id_planta,$id_grupo,$id_area,$id_cargo);
			$lista = array();
			foreach ($res as $r) {
				foreach ($this->Asignarrequerimiento_model->listar_req($r->id) as $s ) {
					$aux = new stdClass();
					$u = $this->Usuarios_model->get($s->id_usuarios);
					$c = $this->Cargos_model->get_empresa($r->id_cargo);
					$a = $this->Areas_model->get_empresa($r->id_area);
					$g = $this->Grupo_model->get($r->id_grupo);
					$m = $this->Evaluaciones_model->get_una_masso($s->id_usuarios);
					$p = $this->Evaluaciones_model->get_una_preocupacional($s->id_usuarios);
					$aux->id_usr = $u->id;
					$aux->rut = $u->rut_usuario;
					$aux->nombre = $u->nombres;
					$aux->paterno = $u->paterno;
					$aux->materno = $u->materno;
					$aux->fono = $u->fono;
					$aux->grupo = $g->nombre;
					$aux->cargo = $c->desc_cargo;
					$aux->area = $a->desc_area;
					if (isset($m->fecha_v)){
						$m_fecha = explode('-',$m->fecha_v);
						$m_fecha = $m_fecha[2].'-'.$m_fecha[1].'-'.$m_fecha[0]; 
					}
					else
						$m_fecha = "No Tiene";

					if (isset($p->fecha_v)){
						$p_fecha = explode('-',$p->fecha_v);
						$p_fecha = $p_fecha[2].'-'.$p_fecha[1].'-'.$p_fecha[0];
					}
					else
						$p_fecha = "No Tiene";

					$aux->masso =  $m_fecha;
					$aux->examen_pre =  $p_fecha;

					array_push($lista,$aux);
					unset($aux,$u,$c,$a,$g,$s,$m,$p);
				}
			}

			$pagina['listado'] = $lista;
		}


		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/busqueda',$pagina,TRUE);
		$this->load->view('layout',$base);
	}


	function ajax_grupo($id_planta = FALSE){
		$this->load->model("Grupo_model");
		$res = $this->Grupo_model->listar_planta($id_planta);
		echo json_encode($res);
	}

	function ajax_areas($id_grupo = FALSE){
		$this->load->model("Areas_model");
		$this->load->model("Requerimientos_model");
		$res = $this->Requerimientos_model->buscar_areas($id_grupo);
		$a = 0;
		$areas = array();
		foreach ($res as $r) {
			if ($r->id_area != $a){
				array_push($areas,$r->id_area);
				$a = $r->id_area;
			}
		}
		$lista = array();
		foreach ($areas as $a) {
			$aux = new stdClass();
			$ar = $this->Areas_model->get_empresa($a);
			$aux->id = $a;
			$aux->nombre = $ar->desc_area;

			array_push($lista,$aux);
			unset($aux,$ar);
		}

		echo json_encode($lista);
	}

	function ajax_cargos($id_grupo = FALSE, $id_area = FALSE){
		$this->load->model("Requerimientos_model");
		$this->load->model("Cargos_model");
		$res = $this->Requerimientos_model->buscar_cargos($id_grupo,$id_area);
		$c = 0;
		$cargos = array();
		foreach ($res as $r) {
			if ($r->id_cargo != $c){
				array_push($cargos,$r->id_cargo);
				$c = $r->id_cargo;
			}
		}
		$lista = array();
		foreach ($cargos as $c) {
			$aux = new stdClass();
			$cr = $this->Cargos_model->get_empresa($c);
			$aux->id = $c;
			$aux->nombre = $cr->desc_cargo;

			array_push($lista,$aux);
			unset($aux,$cr);
		}

		echo json_encode($lista);
	}

	function lista_usuarios() {
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Grupos";

		$this->load->model("Areas_model");
		$this->load->model("Grupo_model");
		$this->load->model("Cargos_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Asignarrequerimiento_model");

		$id_planta = $_POST['planta'];
		$id_grupo = $_POST['grupo'];
		$id_area = $_POST['area'];
		$id_cargo = $_POST['cargo'];

		if($id_planta == 0) $id_planta = FALSE;
		if($id_grupo == 0) $id_grupo = FALSE;
		if($id_area == 0) $id_area = FALSE;
		if($id_cargo == 0) $id_cargo = FALSE;

		$res = $this->Requerimientos_model->listar_usuarios($id_planta,$id_grupo,$id_area,$id_cargo);
		$lista = array();
		foreach ($res as $r) {
			foreach ($this->Asignarrequerimiento_model->listar_req($r->id) as $s ) {
				$aux = new stdClass();
				$u = $this->Usuarios_model->get($s->id_usuarios);
				$c = $this->Cargos_model->get_empresa($r->id_cargo);
				$a = $this->Areas_model->get_empresa($r->id_area);
				$g = $this->Grupo_model->get($r->id_grupo);
				$m = $this->Evaluaciones_model->get_una_masso($s->id_usuarios);
				$p = $this->Evaluaciones_model->get_una_preocupacional($s->id_usuarios);
				$aux->id_usr = $u->id;
				$aux->rut = $u->rut_usuario;
				$aux->nombre = $u->nombres;
				$aux->paterno = $u->paterno;
				$aux->materno = $u->materno;
				$aux->fono = $u->fono;
				$aux->grupo = $g->nombre;
				$aux->cargo = $c->desc_cargo;
				$aux->area = $a->desc_area;
				if (isset($m->fecha_v)){
					$m_fecha = explode('-',$m->fecha_v);
					$m_fecha = $m_fecha[2].'-'.$m_fecha[1].'-'.$m_fecha[0]; 
				}
				else
					$m_fecha = "No Tiene";

				if (isset($p->fecha_v)){
					$p_fecha = explode('-',$p->fecha_v);
					$p_fecha = $p_fecha[2].'-'.$p_fecha[1].'-'.$p_fecha[0];
				}
				else
					$p_fecha = "No Tiene";

				$aux->masso =  $m_fecha;
				$aux->examen_pre =  $p_fecha;

				array_push($lista,$aux);
				unset($aux,$u,$c,$a,$g,$s,$m,$p);
			}
		}

		$pagina['listado'] = $lista;
		
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/lista_usuarios',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
}

?>