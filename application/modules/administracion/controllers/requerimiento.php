<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Requerimiento extends CI_Controller {
	public $requerimiento;
	
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 3){
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

		$this->load->model("Requerimiento_model");
		//$this -> load -> model("Requerimientos_model");
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
		
	}

	function agregar($msg = FALSE){
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Centrocostos_model");
		$this->load->model('Usuarios_model');
		$this->load->model('Empresas_model');
		$this->load->model("Requerimiento_representante_model");
		
		$base['titulo'] = "Publicacion de requerimiento";
		$base['lugar'] = "Publicar requerimiento";
		
		if($msg == "error_vacio"){
			$aviso['titulo'] = "Ocurrio un error, todos los datos son obligatorios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_incompleto"){
			$aviso['titulo'] = "Ocurrio un error, uno o mas datos obligatorios se encontraron vacios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error"){
			$aviso['titulo'] = "Ocurrio un error, favor ingresar los datos nuevamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se ingreso el requerimiento correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		$pagina['editar'] = FALSE;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$id_planta = $this->Usuarios_model->get($this->session->userdata('id'))->id_planta; 
		$pagina['id_planta'] = $id_planta;
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		$pagina['listado_areas'] = $this->Areas_model->listar();
		$pagina['listado_cargos'] = $this->Cargos_model->listar();
		//$pagina['listado_cc'] = $this->Centrocostos_model->listar();
		$pagina['listado_empresa'] = $this->Empresas_model->listar();
		$pagina['representante'] = $this->Requerimiento_representante_model->listar();
		$base['cuerpo'] = $this->load->view('requerimiento/crear_requerimiento',$pagina,TRUE);
		$this->load->view('layout',$base);

	}

	function obtener_planta_ajax(){
		$id = $_POST['id'];
		$this->load->model("Planta_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Grupo_model");

		$listado_planta = $this->Planta_model->get_empresa($id);
		$listado_areas = $this->Areas_model->listar_empresa($id);
		$listado_cargos = $this->Cargos_model->listar_empresa($id);
		$listado_grupos = $this->Grupo_model->listar_empresa($id);

		$l['areas'] = array();
		$l['cargos'] = array();
		$l['plantas'] = array();
		$l['grupos'] = array();

		if (!empty($listado_planta)) {
			foreach ($listado_planta as $lp) {
				$aux_l = array( 
					"id" => $lp->id,
					"nombre" => $lp->nombre
				);
				$l['plantas'][] = $aux_l;
			}
		}
		if (!empty($listado_areas)) {
			foreach ($listado_areas as $la) {
				$aux_l = array( 
					"id" => $la->id,
					"nombre" => $la->desc_area
				);
				$l['areas'][] = $aux_l;
			}
		}
		if (!empty($listado_cargos)) {
			foreach ($listado_cargos as $lc) {
				$aux_l = array( 
					"id" => $lc->id,
					"nombre" => $lc->desc_cargo
				);
				$l['cargos'][] = $aux_l;
			}
		}

		if (!empty($listado_grupos)) {
			foreach ($listado_grupos as $lg) {
				$aux_l = array( 
					"id" => $lg->id,
					"nombre" => $lg->nombre
				);
				$l['grupos'][] = $aux_l;
			}
		}

		echo json_encode($l);
	}

	function resto_planta_ajax(){
		$id = $_POST['id'];
		$this->load->model("Grupo_model");
		$listado_grupo = $this->Grupo_model->listar_planta($id);
		$l['grupo'] = array();
		if (!empty($listado_grupo)) {
			foreach ($listado_grupo as $lg) {
				$aux_l = array(
					"id" => $lg->id,
					"nombre" => $lg->nombre
				);
				$l['grupo'][] = $aux_l;
			}
		}
		echo json_encode($l);
	}

	function guardar(){
		if( empty($_POST['select_empresa']) || empty($_POST['select_area']) || empty($_POST['select_cargo']) || empty($_POST['cantidad']) ){
			redirect('/administracion/requerimiento/agregar', 'refresh');
		}
		else{
			$this->load->model("Requerimientos_model");

			$f_sol = explode('-', $_POST['f_solicitud']);
			if ($_POST['fdesde']){
				$f_ini = explode('-', $_POST['fdesde']);
				$f_ini = $f_ini[2].'-'.$f_ini[1].'-'.$f_ini[0];
			}
			else
				$f_ini = false;
			if( $_POST['fhasta'] ){
				$f_fin = explode('-', $_POST['fhasta']);
				$f_fin = $f_fin[2].'-'.$f_fin[1].'-'.$f_fin[0];
			}
			else
				$f_fin = false;
			
			if ( $_POST['causal'])
				$causal = mb_strtoupper(trim($_POST['causal']), 'UTF-8');
			else
				$causal = false;
			$data_base = array(
				'f_solicitud' => $f_sol[2].'-'.$f_sol[1].'-'.$f_sol[0],
				'empresa_id' => $_POST['select_empresa'],
				'cargo_id' => $_POST['select_cargo'],
				'area_id' => $_POST['select_area'],
				'cantidad' => trim($_POST['cantidad']),
				'f_inicio' => $f_ini,
				'f_fin' => $f_fin,
				'causal' => $causal,
				'comentario' => trim($_POST['comentarios']),
			);
			$this->Requerimientos_model->ingresar($data_base);
			redirect('/administracion/requerimiento/nuevos', 'refresh');
		}
	}
	
	function nuevos(){
		$base['titulo'] = "Nuevos requerimientos";
		$base['lugar'] = "Requerimientos";
		$this->load->model("Usuarios_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Grupo_model");
		$this->load->model("Areas_model");
		$this->load->model("Asignarrequerimiento_model");
		$this->load->model("Requerimiento_representante_model");
		
		$this->session->unset_userdata('requerimiento');
		$this->session->unset_userdata('usuarios_finalizados');
		
		$listado = array();
		
		/*foreach($this->Requerimiento_model->nuevos() as $r ){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->id_usuarios);
			$aux->id = $r->id;
			$aux->empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->razon_social;
			$aux->id_empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->id;
			$aux->de = $usr->nombres." ".$usr->paterno." ".$usr->materno;
			$aux->id_de = $usr->id;
			$aux->nombre = $r->nombre;
			$aux->lugar = $r->lugar_trabajo;
			$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}*/

		foreach($this->Requerimientos_model->listar(@$_GET['planta'],@$_GET['grupo']) as $r ){
			$aux = new stdClass();
			$s = $this->Requerimiento_representante_model->get($r->id_solicitante);
			$aux->id = $r->id_req;
			$aux->planta = $this->Planta_model->get($this->Grupo_model->get($r->id_grupo)->id_planta)->nombre;
			$aux->f_solicitud = $r->f_solicitud;
			$aux->f_inicio = $r->f_inicio;
			$aux->f_termino = $r->f_fin;
			$aux->causal = $r->causal;
			$aux->cargo = $this->Cargos_model->get_empresa($r->id_cargo)->desc_cargo;
			$aux->area = $this->Areas_model->get_empresa($r->id_area)->desc_area;
			$aux->grupo = $this->Grupo_model->get($r->id_grupo)->nombre;
			$aux->motivo = $r->motivo;
			$aux->cantidad = $r->cantidad;
			$aux->agregados = $this->Asignarrequerimiento_model->contar($r->id_req);
			$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
			$aux->solicitante = (empty($s)) ? ' - ' : $s->nombre;
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}
		$pagina['requerimientos'] = $listado;
		$pagina['l_grupos'] = $this->Grupo_model->listar();
		$pagina['l_plantas'] = $this->Planta_model->listar();
		$pagina['s_planta'] = @$_GET['planta'];
		$pagina['s_grupo'] = @$_GET['grupo'];
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function ajax_grupos_planta($id){
		$this->load->model("Grupo_model");
		$salida = $this->Grupo_model->listar_planta($id);
		echo  json_encode($salida);
	}

	function usr_asignados($id){
		$base['titulo'] = "Usuarios Asignados a Requerimiento";
		$base['lugar'] = "Usuarios Asignados";
		$this->load->model("Requerimiento_representante_model");
		$this->load->model("Asignarrequerimiento_model");
		$this->load->model("Requerimiento_origen_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Cargos_model");
		$this->load->model("Areas_model");
		$listado = array();
		foreach($this->Asignarrequerimiento_model->listar_req($id) as $r ){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->id_usuarios);
			$d_req = $this->Requerimientos_model->get($id);
			$cargo = $this->Cargos_model->get_empresa($d_req->id_cargo);
			$area = $this->Areas_model->get_empresa($d_req->id_area);
			$m = $this->Evaluaciones_model->get_una_masso($r->id_usuarios);
			$p = $this->Evaluaciones_model->get_una_preocupacional($r->id_usuarios);
			$aux->id = $r->id;
			$aux->id_usr = $usr->id;
			$aux->rut = $usr->rut_usuario;
			$aux->nombre = $usr->nombres;
			$aux->paterno = $usr->paterno;
			$aux->materno = $usr->materno;
			$aux->cargo = $cargo->desc_cargo;
			$aux->area = $area->desc_area;
			$aux->fono = $usr->fono;
			if($r->f_inicio){
				$fi = explode('-',$r->f_inicio);
				$fi = $fi[2].'-'.$fi[1].'-'.$fi[0];
			}
			else $fi = "00-00-0000";
			$aux->f_inicio = $fi;
			if($r->f_fin){
				$ff = explode('-',$r->f_fin);
				$ff = $ff[2].'-'.$ff[1].'-'.$ff[0];
			}
			else $ff = "00-00-0000";
			$aux->f_fin = $ff;
			$aux->origen = $this->Requerimiento_origen_model->get($r->id_requerimiento_origen)->name;
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

			array_push($listado,$aux);
			unset($aux,$usr);
		}
		$dt_planta = $this->Requerimientos_model->get_planta($id);
		$pagina['datos_req']['planta'] = ucfirst(strtolower($dt_planta->nombre_planta));
		$pagina['datos_req']['ca'] = ucfirst(strtolower($dt_planta->desc_cargo))." - ".ucfirst(strtolower($dt_planta->desc_area));
		$pagina['datos_req']['desde'] = $dt_planta->f_inicio;
		$pagina['datos_req']['hasta'] = $dt_planta->f_fin;
		$pagina['listado'] = $listado;
		$s = $this->Requerimiento_representante_model->get_id_req($id);
		$pagina['solicitante'] = (empty($s)) ? ' - ' : $s->nombre;
		$pagina['id_req'] = $id;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/usr_asignados',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function editar_fecha(){
		$this->load->model("Asignarrequerimiento_model");

		/*$fecha = explode("-",$_POST['value']);
		echo $_POST['value'];
		
		$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];*/
		$fecha = $_POST['value'];
		$id = $_POST['pk'];
		$campo = $_POST['name'];

		$data = array(
			$campo => $fecha
		);
		$this->Asignarrequerimiento_model->actualizar($data,$id);
	}

	function activos(){
		$base['titulo'] = "Requerimientos activos";
		$base['lugar'] = "Requerimientos Activos";
		$this->load->model("Usuarios_model");
		$this->load->model("Empresas_model");
		
		$this->session->unset_userdata('requerimiento');
		$this->session->unset_userdata('usuarios_finalizados');
		
		$listado = array();
		foreach($this->Requerimiento_model->activos2() as $r ){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->id_usuarios);
			$aux->id = $r->id;
			$aux->empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->razon_social;
			$aux->id_empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->id;
			$aux->de = $usr->nombres." ".$usr->paterno." ".$usr->materno;
			$aux->id_de = $usr->id;
			$aux->nombre = $r->nombre;
			$aux->lugar = $r->lugar_trabajo;
			$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}
		$pagina['requerimientos'] = $listado;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function historial(){
		$base['titulo'] = "Historial Requerimientos";
		$base['lugar'] = "Historial de Requerimientos";
		$this->load->model("Usuarios_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");
		$this->session->unset_userdata('requerimiento');
		$this->session->unset_userdata('usuarios_finalizados');

		$listado = array();
		foreach($this->Requerimiento_model->historial2() as $r ){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->id_usuarios);
			$aux->id = $r->id;
			$aux->empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->razon_social;
			$aux->id_empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->id;
			$aux->de = $usr->nombres." ".$usr->paterno." ".$usr->materno;
			$aux->id_de = $usr->id;
			$aux->nombre = $r->nombre;
			$aux->lugar = $r->lugar_trabajo;
			$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}
		$pagina['requerimientos'] = $listado;

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function editar($id = false,$msg = false){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		
		$this->load->model("Areas_model");
		$this->load->model("Centrocostos_model");
		$this->load->model("Cargos_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Requerimiento_cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->model("Usuarios_model");
		$base['titulo'] = "Edición de requerimiento";
		$base['lugar'] = "Editar requerimiento";
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		if($msg == "error_incompleto"){
			$aviso['titulo'] = "Ocurrio un error, uno o mas datos obligatorios se encontraron vacios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error"){
			$aviso['titulo'] = "Ocurrio un error, favor ingresar los datos nuevamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se editó el requerimiento correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "contiene"){
			$aviso['titulo'] = "Este requerimiento, ya contiene trabajadores asignados";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		//$retorno = modules::run('/mandante/requerimiento/editar', 'WzALPQ%3D%3D' ); //cambiar
		//echo $retorno;
		//$this -> load -> view($retorno);
		$pagina['editar'] = TRUE;
		$pagina['id_req'] = $id;
		$pagina['datos'] = $this->Requerimiento_model->get($id);
		//$pagina['subreq'] = $this->Requerimiento_model->listar_req($id);
		$pagina['subreq'] = $this->Requerimiento_areas_model->get_requerimiento($id); //obtiene el area
		
		//$id_planta = $this->Usuarios_model->get($pagina['subreq'][0]->id_usuarios)->id_planta; 
		$id_planta = $pagina['datos']->id_planta;
		$pagina['listado_areas'] = $this->Areas_model->listar_planta($id_planta);
		$pagina['listado_cargos'] = $this->Cargos_model->listar_planta($id_planta);
		$pagina['listado_cc'] = $this->Centrocostos_model->listar_planta($id_planta);
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		//echo Modules::run('/mandante/requerimientos/crear_requerimiento', $pagina,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/crear_requerimiento',$pagina,TRUE);
		$this->load->view('layout',$base);
		
	}

	function editando($id){
		if( empty($_POST['select_area']) || empty($_POST['select_cargo']) || empty($_POST['cantidad']) || 
		empty($_POST['fdesde']) || $_POST['fdesde'] == "Desde" || empty($_POST['fhasta']) || 
		$_POST['fhasta'] == "Hasta" || empty($_POST['nombre']) || empty($_POST['lugar']) ){ 
			redirect('administracion/requerimiento/editar/'.$id.'/error_vacio', 'refresh');
		}
		else{
			$valido = TRUE;
			$this->db->trans_begin();
			$this->load->model("Requerimiento_model");
			$this->load->model("Requerimiento_areas_model");
			$this->load->model("Requerimiento_cargos_model");
			$this->load->model("Requerimiento_trabajador_model");
			$this->load->model("Planta_model");
			$this->load->model("Usuarios_model");
			$this->load->model("Empresas_model");
			$this->load->helper("fechas");
			//print_r($_POST['select_area']);echo "<br/>";
			
			if( count($_POST['select_area']) > 0 ){
				//$this->Requerimiento_areas_model->eliminar_requerimiento($id);
				if(empty($_POST['nombre']) || empty($_POST['lugar']) ){
					$valido = FALSE;
					break;
				}
				$data_base = array(
					'nombre' => mb_strtoupper($_POST['nombre'], 'UTF-8'),
					//'id_usuarios' => $this -> session -> userdata('id'),
					//'id_planta' => $this->Usuarios_model->get($this->session->userdata('id'))->id_planta,
					'lugar_trabajo' => mb_strtoupper($_POST['lugar'], 'UTF-8'),
					'comentario' => $_POST['texto']
				);
				//print_r($data_base);echo "<br/>";
				$this->Requerimiento_model->editar($id,$data_base); //editar datos basicos del requerimiento
				
				for($i = 0; $i < count($_POST['select_area']);$i++){ //recorrer la cantidad de areas agregadas
					//$lista_id_ara = array();
					$id_area = $_POST['select_area'][$i];
					$area_antigua = empty($_POST['area_antigua'][$i])? NULL : $_POST['area_antigua'][$i];
					if(empty($id_area)){ //si hay un area agregada que no tenga un valor en ella, se sale del cilco y $valido cambia a false.
						$valido = FALSE;
						break;
					}
					// $area_contiene_trabajadores = $this->Requerimiento_areas_model->get_area($_POST['area_antigua'][$i],$id); //
					// if( count($area_contiene_trabajadores) > 0){
						// $contiene = TRUE;
						// break;
					// }
					//else{
					if($area_antigua){
						//echo "entra al update del area <br/>";
						$data_area = array(
							'id_areas' => $id_area
						);
						$id_requerimiento_area = $this->Requerimiento_areas_model->editar($area_antigua,$data_area);
					}
					else{
						//echo "entra al insert del area <br/>";
						$data_area = array(
								'id_areas' => $id_area,
								'id_requerimiento' => $id
							);
							$id_requerimiento_area = $this->Requerimiento_areas_model->ingresar($data_area);
					}
					$lista_id_area[] = $id_requerimiento_area;
					// echo $id_requerimiento_area;
						// $req_anterior = $this->Requerimiento_areas_model->get_validar($id_area,$id); 
						// if( count($req_anterior) > 0 ){
							// $data_area = array(
								// 'id_areas' => $id_area
							// );
							// $id_requerimiento_area = $this->Requerimiento_areas_model->editar($_POST['area_antigua'],$data_area);
						// }
						//else{
							// $data_area = array(
								// 'id_areas' => $id_area,
								// 'id_requerimiento' => $id
							// );
							// $id_requerimiento_area = $this->Requerimiento_areas_model->ingresar($data_area);
						//z}
						// $data_area = array(
							// 'id_areas' => $id_area,
							// 'id_requerimiento' => $id
						// );
						// //print_r($data_area);echo "<br/>";
						// $id_requerimiento_area = $this->Requerimiento_areas_model->ingresar($data_area);
						if( count($_POST['select_cargo']) > 0 ){
							//$lista_id_cargo = array();
							for( $x = 0; $x < count( $_POST['select_cargo'][$id_area]); $x++ ){
								$id_cargo = $_POST['select_cargo'][$id_area][$x];
								$especialidad = empty($_POST['select_especialidad'][$id_area][$x])? NULL : $_POST['select_especialidad'][$id_area][$x];
								$id_especialidad = (empty($_POST['select_especialidad'][$id_area][$x]))? '0' : $_POST['select_especialidad'][$id_area][$x];
								$pk_cargo = empty($_POST['cargo_antiguo'][$id_area][$x])? NULL : $_POST['cargo_antiguo'][$id_area][$x];
								//echo "id_especialidad " .$id_especialidad ."<br />";
								//echo $pk_cargo;
								if(empty($id_cargo)){
									$valido = FALSE;
									break;
								}
								if(count($pk_cargo) > 0){
									//echo "entra al update del cargo <br/>";
									$data_cargo = array(
										'id_requerimiento_areas' => $id_requerimiento_area,
										'id_cargos' => $id_cargo,
									);
									//print_r($data_cargo);echo "<br/>";
									$id_requerimiento_cargo = $this->Requerimiento_cargos_model->editar($pk_cargo,$data_cargo);
								}
								else{
									//echo "entra al insert del cargo <br/>";
									$data_cargo = array(
										'id_requerimiento_areas' => $id_requerimiento_area,
										'id_cargos' => $id_cargo,
										'id_especialidad' => $especialidad
									);
									//print_r($data_cargo);echo "<br/>";
									$id_requerimiento_cargo = $this->Requerimiento_cargos_model->ingresar($data_cargo);
								}
								$lista_id_cargo[] = $id_requerimiento_cargo;
								$comparar = array(
									count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ),
									count( $_POST['fdesde'][$id_area][$id_cargo][$id_especialidad]),
									count( $_POST['fhasta'][$id_area][$id_cargo][$id_especialidad]),
								);
								//print_r($comparar);echo "<br/>";
								if(count(array_unique($comparar)) == 1) {
									//$lista_id_rt = array();
									//echo "numero cantidades --> ".count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ). "<br />";
									//echo "<br/>".count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad])."<br />";
									for( $z = 0; $z < count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ); $z++ ){
										$cantidad = $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad][$z];
										$finicio = $_POST['fdesde'][$id_area][$id_cargo][$id_especialidad][$z];
										$ftermino = $_POST['fhasta'][$id_area][$id_cargo][$id_especialidad][$z];
										$centro_costo = empty( $_POST['select_cc'][$id_area][$id_cargo][$id_especialidad][$z] )? NULL : $_POST['select_cc'][$id_area][$id_cargo][$id_especialidad][$z];
										$pk_rt = empty( $_POST['antiguo_rt'][$id_area][$id_cargo][$id_especialidad][$z] )? NULL : $_POST['antiguo_rt'][$id_area][$id_cargo][$id_especialidad][$z];
										//echo "valor rt antiguo--> ".$pk_rt."<br/>";
										if(empty($cantidad)){
											$valido = FALSE;
											break;
										}
										if(empty($finicio)){
											$valido = FALSE;
											break;
										}
										if(empty($ftermino)){
											$valido = FALSE;
											break;
										}
										
										$fecha_inicio = explode(" ", $finicio);
										$fecha_termino = explode(" ", $ftermino);
										if( count($pk_rt) > 0){
											//echo "<br /> entra al update del RT <br />";
											$data_trabajador = array(
												'id_centrocosto' => $centro_costo,
												'fecha_inicio' => $fecha_inicio[2].'-'.mesXdia($fecha_inicio[1]).'-'.$fecha_inicio[0],
												'fecha_termino' => $fecha_termino[2].'-'.mesXdia($fecha_termino[1]).'-'.$fecha_termino[0],
												'cantidad' => $cantidad
											);
											//print_r($data_trabajador);echo "<br/>";
											$id_rt = $this->Requerimiento_trabajador_model->editar($pk_rt,$data_trabajador);
										}
										else{
											//echo "<br /> entra al insert del RT <br />";
											$data_trabajador = array(
												'id_requerimiento_cargos' => $id_requerimiento_cargo,
												'id_centrocosto' => $centro_costo,
												'fecha_inicio' => $fecha_inicio[2].'-'.mesXdia($fecha_inicio[1]).'-'.$fecha_inicio[0],
												'fecha_termino' => $fecha_termino[2].'-'.mesXdia($fecha_termino[1]).'-'.$fecha_termino[0],
												'cantidad' => $cantidad
											);
											//print_r($data_trabajador);echo "<br/>";
											$id_rt = $this->Requerimiento_trabajador_model->ingresar($data_trabajador);
										}
										//$lista_id_rt[] = $id_rt; 
										//echo "rtid --> ".$id_rt."<br/>";
										$lista_id_rt[] = $id_rt ;
									}
								} else {
									$valido = FALSE;
									break;
								} 
							}
						}
						else{
							$valido = FALSE;
							break;
						}
					}
					
				//}
			}
			else{
				$valido = FALSE;
			}
			
			if(@$contiene){
				redirect('administracion/requerimiento/editar/'.$id.'/contiene', 'refresh');
			}
			if( $valido == FALSE){
				$this->db->trans_rollback();
				redirect('administracion/requerimiento/editar/'.$id.'/error_incompleto', 'refresh');
			}
			else{
				foreach($this->Requerimiento_trabajador_model->get_requerimiento($id) as $r){
					if (!in_array($r->trabajador_id, $lista_id_rt)) {
					    $this->Requerimiento_trabajador_model->eliminar($r->trabajador_id);
					}	
				}
				foreach($this->Requerimiento_cargos_model->get_requerimiento($id) as $c){
					if (!in_array($c->cargo_id, $lista_id_cargo)) {
					    $this->Requerimiento_cargos_model->eliminar($c->cargo_id);
					}
				}
				foreach($this->Requerimiento_areas_model->get_requerimiento($id) as $a){
					if (!in_array($a->id, $lista_id_area)) {
					    $this->Requerimiento_areas_model->eliminar($a->id);
					}
				}
				$this->db->trans_commit();
				redirect('administracion/requerimiento/editar/'.$id.'/exito', 'refresh');
			}
		}
	}

	function detalles($id = FALSE,$msg = FALSE){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Requerimiento_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');
		$this->session->unset_userdata('requerimiento');
		$this->session->unset_userdata('usuarios_finalizados');
		$this->session->unset_userdata('reemplazo');
		$this->session->unset_userdata('reemplazo_final');
		$this->session->unset_userdata('aux_reemplazo');
		
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		$this->load->model("Usuarios_model");
		$this->load->model("Areas_model");
		$this->load->model("Centrocostos_model");
		$this->load->model("Cargos_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Requerimiento_cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		
		$base['titulo'] = "Detalle de requerimiento";
		$base['lugar'] = "Requerimientos";
		
		$arr_url = $this->uri->uri_to_assoc(5);
		//$this->Requerimiento_model->editar($id,array('flag_leido' => 1)); //marcar como leido
		$r = $this->Requerimiento_model->get($id);
		$de = $this->Usuarios_model->get($r->id_usuarios);
		$aux = new stdClass();
		$aux->nombre = $r->nombre;
		$aux->de = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->razon_social;
		$aux->id_de = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->id;
		$aux->creador = $de->nombres." ".$de->paterno." ".$de->materno;
		$aux->id_creador = $de->id;
		$aux->lugar = $r->lugar_trabajo;
		$aux->id_req = $r->id;
		$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
		$listado = array();
		//foreach($this->Requerimiento_model->get_prin_req($r->id) as $dr){
		foreach($this->Requerimiento_trabajador_model->get_requerimiento($r->id) as $dr){
			$aux2 = new stdClass();
			if(isset($arr_url['req'])){
				if($arr_url['req'] == $dr->id){
					$activo = TRUE;
				}
				else $activo=FALSE;
			}
			else $activo=FALSE;
				
			$aux2->id = $dr->id;
			$aux2->activo = $activo;
			$aux2->areas = ucwords(mb_strtolower($this->Areas_model->get($dr->id_areas)->desc_area,'UTF-8'));
			$aux2->cargos = ucwords(mb_strtolower($this->Cargos_model->get($dr->id_cargos)->desc_cargo,'UTF-8'));
			$aux2->cc = (empty($dr->id_centrocosto))? '' : ucwords(mb_strtolower($this->Centrocostos_model->get($dr->id_centrocosto)->desc_centrocosto,'UTF-8'));
			if($dr->id_especialidad)
				$aux2->especialidad = ucwords(mb_strtolower($this->Especialidadtrabajador_model->get($dr->id_especialidad)->desc_especialidad,'UTF-8'));
			else
				$aux2->especialidad = '';
			$f_i = explode("-",$dr->fecha_inicio);
			$f_t = explode("-",$dr->fecha_termino);
			$aux2->f_inicio = $f_i[2].'-'.$f_i[1]."-".$f_i[0];
			$aux2->f_termino = $f_t[2].'-'.$f_t[1]."-".$f_t[0];
			$aux2->cantidad = $dr->cantidad;
			$aux2->cantidad_ok = $dr->cantidad_ok;
			$aux2->estado = $this->Requerimiento_model->get_estado($dr->id_estado)->nombre;
			array_push($listado,$aux2);
			unset($aux2,$f_i,$f_t);
		}
		$aux->detalle = $listado;
		
		if($msg == "exito"){
			$aviso['titulo'] = "Se a asignado los trabajadores exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$pagina['requerimiento'] = $aux;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/detalle',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function asignar($id=false){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		$id = base64_decode(urldecode($id));
		$this->load->model("Requerimiento_trabajador_model");
		//$req = $this->Requerimiento_model->get_req($id);
		$req = $this->Requerimiento_trabajador_model->get_trabajador($id);
		
		if(count($req) < 1)
			redirect('/error/error404', 'refresh');
		
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Fotostrab_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Reemplazos_requerimiento_model");
		$this->load->library('pagination');
		
		$base['titulo'] = "Asignacion de requerimiento";
		$base['lugar'] = "Requerimientos";
		
		$lista = array();
		
		$url_pag = $this->uri->uri_to_assoc(5);
		if($this->uri->segment(5) === FALSE)
			$paginado = 1;
		else{
			$paginado = (empty($url_pag['pagina'])) ? 1 : $url_pag['pagina'];
			$url_encript = $this->uri->uri_to_assoc(5);
		}
		
		$config['per_page'] = 15;
		$config['full_tag_open'] = "<div class='dataTables_paginate paging_full_numbers'>";
		$config['full_tag_close'] = '</div>';
		$config['next_link'] = 'Siguiente';
		$config['next_tag_open'] = '<span class="next paginate_button">';
		$config['next_tag_close'] = '</span>';
		$config['num_tag_open'] = '<span class="paginate_button">';
		$config['num_tag_close'] = '</span>';
		$config['cur_tag_open'] = '<span class="paginate_active">';
		$config['cur_tag_close'] = '</span>';
		$config['last_link'] = 'Ultimo';
		$config['last_tag_open'] = '<span class="next paginate_button">';
		$config['last_tag_close'] = '</span>';
		$config['first_link'] = 'Primero';
		$config['first_tag_open'] = '<span class="previous paginate_button">';
		$config['first_tag_close'] = '</span>';
		$config['prev_link'] = 'Anterior';
		$config['prev_tag_open'] = '<span class="previous paginate_button">';
		$config['prev_tag_close'] = '</span>';
		if(!empty($url_encript['filtro'])){ //si existe el filtro entonces........
			$filtro = base64_decode( urldecode($url_encript['filtro']));
			$fil = explode("/",$filtro);
			$asociacion = array();
			$aux = array(
				$fil[0] => $fil[1],
				$fil[2] => $fil[3],
				$fil[4] => $fil[5],
				$fil[6] => $fil[7],
				$fil[8] => $fil[9],
				$fil[10] => $fil[11]
			 );
			array_push($asociacion,$aux);
			unset($aux);
			
			if($asociacion[0]['nombre'] === 0) $asociacion[0]['nombre'] = FALSE;
			if($asociacion[0]['rut'] == 0) $asociacion[0]['rut'] = FALSE;
			if($asociacion[0]['profesion'] == 0) $asociacion[0]['profesion'] = FALSE;
			if($asociacion[0]['especialidad'] == 0) $asociacion[0]['especialidad'] = FALSE;
			if($asociacion[0]['ciudad'] == 0) $asociacion[0]['ciudad'] = FALSE;
			if($asociacion[0]['estado'] == 0) $asociacion[0]['estado'] = FALSE;
			$config['base_url'] = base_url().'/administracion/requerimiento/asignar/'.$this->uri->segment(4)."/filtro/".$url_encript['filtro']."/pagina/";
			$config['total_rows'] = $this->Usuarios_model->total_filtro($asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['profesion'],$asociacion[0]['especialidad'],$asociacion[0]['ciudad'],false,$asociacion[0]['estado']);
			$config['uri_segment'] = 8;
		}
		else{ // si no existe el filtro entoncess...........
			$config['base_url'] = base_url().'/administracion/requerimiento/asignar/'.$this->uri->segment(4)."/pagina/";
			$config['total_rows'] = $this->db->where('id_tipo_usuarios',2)->get('usuarios')->num_rows();
			$asociacion[0]['nombre'] = FALSE;
			$asociacion[0]['rut'] = FALSE;
			$asociacion[0]['profesion'] = FALSE;
			$asociacion[0]['especialidad'] = FALSE;
			$asociacion[0]['ciudad'] = FALSE;
			$asociacion[0]['estado'] = FALSE;
			$config['uri_segment'] = 6;
		}
		
		if($config['total_rows'] <= $config['per_page'] ){
			$config['total_rows'] = FALSE;
			$paginado = FALSE;
		}
		$this->pagination->initialize($config);
		//echo $config['total_rows'];
		//print_r($asociacion);
		
		//si la session de requerimiento no se a inicializado o esta vacia, se llana con los usuarios de bd del requerimiento
		if( (is_bool($this->session->userdata("requerimiento") )) || (count($this->session->userdata("requerimiento")) < 1 ) ){
			foreach($this->Usuarios_model->listar_id() as $u){
				if($asigna_req = $this->Requerimiento_model->get_trabajador_req($u->id,$id)){ //lleno la session de requerimiento, si existen asignados por BD
					$ses[] = $u->id;
					foreach($asigna_req as $ar){
						$id_asigna_req[] = $ar->id; 
					}
					$this->session->set_userdata("requerimiento",$ses);
					$this->session->set_userdata("aux_reemplazo",$id_asigna_req);
				}
			}
		}
		//si los reemplazantes estan vacios, se llena la session
		if( (is_bool($this->session->userdata("reemplazo_final") )) || (count($this->session->userdata("reemplazo_final")) < 1 ) ){
			$req_aux = array();
			foreach($this->Reemplazos_requerimiento_model->listar_asigna_requerimiento($id) as $r){
				$req_aux[] = array(
					'usuario' => $r->ar_usuarios,
					'sub_req' => $r->id_requerimientotrabajador,
					'reemplazo' => array(
						'usuario_r' => $r->rr_usuarios,
						'motivo' => $r->id_motivos_falta,
						'observacion' => $r->observacion
					)
				);
			}
			$this->session->set_userdata("reemplazo_final",$req_aux);
		}
		
		foreach($this->Usuarios_model->listar_filtro($asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['profesion'],$asociacion[0]['especialidad'],$asociacion[0]['ciudad'],false,$asociacion[0]['estado'],$config['per_page'],$paginado) as $t){
			$aux = new stdClass();
			$foto = $this->Fotostrab_model->get_usuario($t->id);
			$check = FALSE;
			$otro_req = FALSE;
			$id_otro_req = FALSE;
			$reemplazado = FALSE;
			if(!is_bool($this->session->userdata("requerimiento"))){
				foreach($this->session->userdata("requerimiento") as $r=>$k){
					if($t->id == $k){
						$check = TRUE;
					}
				}
			}
			//aux_reemplazo, contiene las id de la tabla asigna requerimiento, de los usuarios de la session "requerimiento"
			//se recorre la session con los que esten en la table reemplazos_requerimiento, si existen entonces el trabajador de
			//"requerimiento" fue reemplazado
			if(!is_bool($this->session->userdata("aux_reemplazo"))){ 
				foreach($this->session->userdata("aux_reemplazo") as $iar){
					if( count($s = $this->Reemplazos_requerimiento_model->listar_requerimiento($iar)) > 0){
						if($s->id_usuarios == $t->id){
							$check = TRUE;
						}
						if($this->Requerimiento_model->get_asigna_req($iar)->id == $s->id_asigna_requerimiento){
							if($this->Requerimiento_model->get_asigna_req($iar)->id_usuarios == $t->id){
								$reemplazado = TRUE;
								$check = FALSE;
							}
						}
					}
				}
			}
			/******/
			
			if(!is_bool($this->session->userdata("reemplazo_final"))){ //se agregan clases si se llenan usuarios de reemplazo
				$session_reemplazo = $this->session->userdata('reemplazo_final');
				for($z=0;$z < count($session_reemplazo); $z++){
					if($session_reemplazo[$z]['usuario'] == $t->id){
						$reemplazado = TRUE;
						$check = FALSE;
					} 
					if($session_reemplazo[$z]['reemplazo']['usuario_r'] == $t->id){
						$check = TRUE;
					}
				}
			}
			// if($this->Requerimiento_model->get_trabajador_otroreq($t->id,$id)){//verificar si existe en otro requerimiento
				// $otro_req = TRUE;
				// $id_otro_req = $this->Requerimiento_model->get_trabajador_otroreq($t->id,$id)->id_requerimientotrabajador;
			// }
			// echo $t->id."<br/>";
			// echo "id-->".$id."<br/>";
			//print_r($req);
			// echo "fecha_inicio-->".$req[0]->fecha_inicio."<br/>";
			if($this->Asignarequerimiento_model->get_actual($t->id,$id,$req->fecha_inicio)){//verificar si existe en otro requerimiento
				$otro_req = TRUE;
				$id_otro_req = $this->Asignarequerimiento_model->get_actual($t->id,$id,$req->fecha_inicio)->id_requerimientotrabajador;
				$id_otro_req_padre = $this->Requerimiento_model->get_req($id_otro_req);
			}
			
			
			$aux->id = $t->id;
			$aux->check = $check;
			$aux->otro_req = $otro_req;
			$aux->id_otro_req = $id_otro_req;//el id del otro requerimiento
			@$aux->id_otro_req_padre = $id_otro_req_padre->id_requerimiento; //id del requerimiento padre
			$aux->nombres =  $t->nombres;
			$aux->paterno = $t->paterno;
			$aux->materno = $t->materno;
			$aux->rut = $t->rut_usuario;
			$aux->reemplazado = $reemplazado;
			$aux->foto = (count($foto)< 1) ? 'extras/img/perfil/requerimiento/avatar.jpg' : $foto->media;
			array_push($lista,$aux);
			unset($aux);
		}
		//print_r($this->session->userdata("requerimiento"));
		if( is_bool( $this->session->userdata("requerimiento") ) )
			$asignados = '0';
		else
			$asignados = count($this->session->userdata("requerimiento"));
		
		$pagina['asignados'] = $asignados;
		
		//mantener el filtro en el html cuando recargue
		
		$pagina['paginado']	= $this->pagination->create_links();
		$pagina['input_nombre'] = $asociacion[0]['nombre'];
		$pagina['input_rut'] = $asociacion[0]['rut'];
		$pagina['input_profesion'] = $asociacion[0]['profesion'];
		$pagina['input_especialidad'] = $asociacion[0]['especialidad'];
		$pagina['input_ciudad'] = $asociacion[0]['ciudad'];
		$pagina['input_estado'] = $asociacion[0]['estado'];
		$pagina['cant_pedidos'] = $req->cantidad; 
		$pagina['listado_usuarios'] = $lista;
		$pagina['listado_ciudades'] = $this->Ciudad_model->listar();
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		$pagina['listado_profesiones'] = $this->Profesiones_model->listar();
		$pagina['id'] = $id;
		if(!empty($req->id_especialidad))
			$pagina['especialidad'] = $this->Especialidadtrabajador_model->get($req->id_especialidad)->desc_especialidad;
		else
			$pagina['especialidad'] = NULL;
		$pagina['id_req'] = $req->id_requerimiento;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/asignar',$pagina,TRUE);
		$this->load->view('layout',$base);
		
	}

	function filtrar($tipo = false){
		$id = urlencode(base64_encode($_POST['id']));
		if(empty($_POST['nombre']) ) $_POST['nombre'] = 0;
		if(empty($_POST['rut']) ) $_POST['rut'] = 0;
		if(empty($_POST['profesion']) ) $_POST['profesion'] = 0;
		if(empty($_POST['especialidad']) ) $_POST['especialidad'] = 0;
		if(empty($_POST['ciudad']) ) $_POST['ciudad'] = 0;
		if(empty($_POST['estado']) ) $_POST['estado'] = 0;
		$url = "nombre/".$_POST['nombre']."/rut/".$_POST['rut']."/profesion/".$_POST['profesion']."/especialidad/".$_POST['especialidad']."/ciudad/".$_POST['ciudad']."/estado/".$_POST['estado'];
		$enc = urlencode(base64_encode($url));
		if($tipo == false || $tipo == 1){
			redirect('/administracion/requerimiento/asignar/'.$id.'/filtro/'.$enc, 'refresh');
		}
		else{
			redirect('/administracion/requerimiento/ajax_reemplazo/'.$_POST['id'].'/filtro/'.$enc, 'refresh');
		}
	}
	
	function asignados($id = FALSE){
		$base['titulo'] = "Trabajadores asignados el requerimiento";
		$base['lugar'] = "Trabajadores asignados";
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		$this->load->model('Asignarequerimiento_model');
		$this->load->model('Usuarios_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->model("Fotostrab_model");
		$id = urldecode($id);
		$id = $this->encrypt->decode(url_to_encode($id));
		
		$listado_usuarios = $this->Asignarequerimiento_model->listado_requerimiento($id);
		
		$listado = array();
		foreach($listado_usuarios as $l){
			$aux = new stdClass();
			$u = $this->Usuarios_model->get($l->id_usuarios);
			$foto = $this->Fotostrab_model->get_usuario($u->id);
			$aux->id = $u->id;
			$aux->nombres = $u->nombres;
			$aux->paterno = $u->paterno;
			$aux->materno = $u->materno;
			$aux->rut = $u->rut_usuario;
			$aux->foto = (count($foto)< 1) ? 'extras/img/perfil/requerimiento/avatar.jpg' : $foto->media;
			array_push($listado,$aux);
			unset($aux,$u);
		}
		$pagina['listado_usuarios'] = $listado;
		$datos_req = $this->Requerimiento_trabajador_model->get_trabajador($id);
		$pagina['nb_req'] = $datos_req->nombre;
		$pagina['nb_area'] =  $this->Areas_model->get($datos_req->id_areas)->desc_area;
		$pagina['nb_cargo'] =  $this->Cargos_model->get($datos_req->id_cargos)->desc_cargo;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/trabajadores_asignados',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function tooltip($id){ //informacion dinamica de un usuario
		$this->load->model("Usuarios_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$usu = $this->Usuarios_model->get($id);
		$esp = $this->Especialidadtrabajador_model->get($usu->id_especialidad_trabajador);
		$prof = $this->Profesiones_model->get($usu->id_profesiones);
		echo "<div class='democontent'>
			<div class='info'>
				<p>Nombre: ".ucwords(mb_strtolower($usu->nombres." ".$usu->paterno." ".$usu->materno,"UTF-8"))."</p>
				<p>Rut: ".$usu->rut_usuario."</p>
				<p>Profesion: ".ucwords(mb_strtolower(@$prof->desc_profesiones,"UTF-8"))."</p>
				<p>Especialidad: ".ucwords(mb_strtolower(@$esp->desc_especialidad,"UTF-8"))."</p>
				<p>Experiencia: ";
		if(!empty($usu->ano_experiencia)){ echo $usu->ano_experiencia;} else{ echo '0';}
		echo " años</p>
				<div><a target='_blank' href='".base_url()."administracion/perfil/trabajador/".$usu->id."'>Ver Perfil Completo</a></div>
			</div>
			<div class='clear'>&nbsp;</div>
		</div>";
	}
	
	function agregar_usr($id){ //agregar dinamicamente a un usuario al requerimiento
		$req = array();
		$req = $this->session->userdata('requerimiento');
		if(is_bool($req)){
			$req[] = $id;
		}
		else 
			array_push($req,$id);
		print_r($req);
		$this->session->set_userdata('requerimiento', $req);
	}
	/*function eliminar_usr($id){ //eliminar de forma dinamica a un usuario del requerimiento
		$req = array();
		if($tipo == "sesion" || !$tipo){
		$req = $this->session->userdata('requerimiento');
		$key = array_search($id,$req,TRUE);
		unset($req[$key]);
		$req = array_values($req);
		$this->session->set_userdata('requerimiento', $req);
		}
	}*/
	function eliminar_usr($id_req,$id_usr){
		$this->load->model("Asignarrequerimiento_model");
		
		$this->Asignarrequerimiento_model->eliminar_usr($id_req,$id_usr);
		redirect(base_url().'administracion/requerimiento/usr_asignados/'.$id_req, 'refresh');
	}

	function agregar_reemplazo($reemp,$id_subreq){ //agregar dinamicamente a un usuario al requerimiento
		$ses_reemp = $this->session->userdata('reemplazo');
		if(is_bool($ses_reemp)){
			$this->session->unset_userdata('reemplazo');
		}
		$req = array(
			'remp' => $reemp,
			'sub_req' => $id_subreq
		);
		$this->session->set_userdata('reemplazo', $req);
		print_r($this->session->userdata('reemplazo'));
	}
	
	function session_guardar_usuario_reemplazar($id_usr){
		$ses_reemp = $this->session->userdata('usr_reemplazo');
		if(is_bool($ses_reemp)){
			$this->session->unset_userdata('usr_reemplazo');
		}
		
		$this->session->set_userdata('usr_reemplazo', $id_usr);
		print_r($this->session->userdata('usr_reemplazo'));
	}
	function session_obtener_usuario_reemplazar(){
		print_r($this->session->userdata('usr_reemplazo'));
	}
	
	function ajax_motivo(){
		$this->load->model("Motivosfalta_model");
		foreach($this->Motivosfalta_model->listar() as $l){
			echo "<option value=".$l->id.">".ucwords(mb_strtolower($l->nombre, 'UTF-8'))."</option>";
		}
		
	}
	
	function session_reemplazo_final($id_motivo,$observacion){
		//$this->session->userdata('reemplazo_final');
		//echo $id_motivo."<br/>";
		//echo $observacion."<br/>";
		$req = array();
		$req = $this->session->userdata('reemplazo_final');
		$datos_reemplazado = $this->session->userdata('reemplazo');
		if(is_bool($req)){
			$req[] = array(
				'usuario' => $this->session->userdata('usr_reemplazo'),
				'sub_req' => $datos_reemplazado['sub_req'],
				'reemplazo' => array(
					'usuario_r' => $datos_reemplazado['remp'],
					'motivo' => $id_motivo,
					'observacion' => $observacion
				)
			);
		}
		else{
			$valido = 0;
			$session_final = $this->session->userdata('reemplazo_final');
			$i=0;
			foreach ($session_final as $k => $v) {
				if(($session_final[$i]['usuario'] == $this->session->userdata('usr_reemplazo')) && ($session_final[$i]['sub_req'] == $datos_reemplazado['sub_req'] )){
					$valido = 1;
				}
				$i++;
			}
			if($valido == 0){
				$salida = array(
					'usuario' => $this->session->userdata('usr_reemplazo'),
					'sub_req' => $datos_reemplazado['sub_req'],
					'reemplazo' => array(
						'usuario_r' => $datos_reemplazado['remp'],
						'motivo' => $id_motivo,
						'observacion' => $observacion
					)
				);
				array_push($req,$salida);
			}
		}
		//print_r($req);
		$this->session->set_userdata('reemplazo_final', $req);
		print_r($this->session->userdata('reemplazo_final'));
	}

	function quitar_session_reemplazo_final($id_usr,$sub_req,$id_reemplazo,$motivo,$obs){
		$req = array();
		$req = $this->session->userdata('reemplazo_final');
		$key = array_search(array('usuario' => $id_usr,'sub_req'=> $sub_req,'reemplazo' => array('usuario_r' => $id_reemplazo,'motivo' => $motivo,'observacion' => $obs)),$req,TRUE);
		echo $key."\n";
		print_r($this->session->userdata('reemplazo_final'));
		unset($req[$key]);
		$req = array_values($req);
		$this->session->set_userdata('reemplazo_final', $req);
	}
	
	function session_asignados($id_req){ // obtener dinamicamente los usuarios en la session del requerimiento
		$this->load->model("Usuarios_model");
		$this->load->model("Reemplazos_requerimiento_model");
		$this->load->model("Origen_trabajador_requerimiento_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->helper("multidimencional_array");
		$listado_asignados = array();
		if( is_bool( $this->session->userdata("requerimiento") ) )
			$listado_asignados = array(); //ta demás
		else{
			foreach($this->session->userdata("requerimiento") as $sr=>$k){ 
				$aux2 = new stdClass();
				$aux2->id = $this->Usuarios_model->get($k)->id;
				$aux2->nombres = ucwords(mb_strtolower($this->Usuarios_model->get($k)->nombres,"UTF-8"));
				$aux2->paterno = ucwords(mb_strtolower($this->Usuarios_model->get($k)->paterno,"UTF-8"));
				$aux2->materno = ucwords(mb_strtolower($this->Usuarios_model->get($k)->materno,"UTF-8"));
				$aux2->rut = $this->Usuarios_model->get($k)->rut_usuario;
				$aux2->tipo = "sesion";
				if($dato_asignado = $this->Asignarequerimiento_model->ger_trabajador_subreq($aux2->id, $id_req)){
					$aux2->fecha_inicio = $dato_asignado->fecha_inicio;
					$aux2->fecha_termino = $dato_asignado->fecha_termino;
					$aux2->origen = $dato_asignado->id_origen_trabajador_requerimiento; 
				}
				array_push($listado_asignados,$aux2);
				unset($aux2);
			}
		}
		$pagina['listado_asignados'] = $listado_asignados;
		$pagina['id_req'] = $id_req;
		$pagina['lista_origen'] = $this->Origen_trabajador_requerimiento_model->listar();
		$pagina['reemplazos'] = $this->session->userdata('reemplazo_final');
		$this->load->view('requerimiento/asignados',$pagina);
	}
	
	function session_usuarios_finalizados(){
		$fin = array();
		$fin = $this->session->userdata('usuarios_finalizados');
		if(is_bool($fin)){
			$fecha1 = $_POST['f_inicio'];
			$fecha1 = explode('-',$fecha1);
			$fecha2 = $_POST['f_termino'];
			$fecha2 = explode('-',$fecha2);
			$fin[] = array(
				'id_usuario' => $_POST['usuario'],
				'id_req' => $_POST['id_req'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0],
				'fecha_termino' => $fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0],
				'id_origen_trabajador_requerimiento' => $_POST['origen']
			);
		}
		else{
			$fecha1 = $_POST['f_inicio'];
			$fecha1 = explode('-',$fecha1);
			$fecha2 = $_POST['f_termino'];
			$fecha2 = explode('-',$fecha2);
			$aux = array(
				'id_usuario' => $_POST['usuario'],
				'id_req' => $_POST['id_req'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0],
				'fecha_termino' => $fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0],
				'id_origen_trabajador_requerimiento' => $_POST['origen']
			);
			array_push($fin,$aux);
		}
		print_r($fin);
		$this->session->set_userdata('usuarios_finalizados', $fin);
	}
	
	function guardar_requerimiento($id_req){
		if(!is_bool($this->session->userdata("requerimiento"))){
			$usr_req = $this->session->userdata("requerimiento");
			$total_usr = count($usr_req);
		}
		else{
			redirect('/administracion/requerimiento/detalles/'.$req->id_requerimiento.'/error', 'refresh');
		}
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_trabajador_model");
		//$req = $this->Requerimiento_model->get_req($id_req);
		$req = $this->Requerimiento_trabajador_model->get_trabajador($id_req);
		//$this->Requerimiento_model->eliminar_trabajador_req($id_req);
		$this->load->library('email');
		
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'sgo@empresasintegra.cl';
		$config['smtp_pass'] = 'gestion2012';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';

		$this->email->initialize($config);
		//ver si el trabajador ya se asigno al requerimiento
		if(is_array($usr_req)){
			$no_existen = array();
			foreach($usr_req as $u){
				if(!$this->Asignarequerimiento_model->existe_trab_requerimiento($u,$id_req))
				$no_existen[] = $u; //lista de trabajadores nuevos
			}
		}
		
		//finalizar trabajadores del requerimiento anterior
		 print_r($this->session->userdata('usuarios_finalizados'));
		 if(is_array($finalizados = $this->session->userdata('usuarios_finalizados'))){
		 	foreach($finalizados as $f){
		 		$data = array(
		 			'fecha_termino' => $f['fecha'],
		 			'termino' => 1,
		 			'motivo_termino' => $f['motivo']
				);
				$this->Asignarequerimiento_model->actualizar($f['id_req'],$f['id_usuario'],$data);
				unset($data);
		 	}
		 }
		
		
		//agregar trabajadores que no existan ya en el requerimiento
		if(is_array($no_existen)){
			foreach($no_existen as $n){
				$data = array(
					'id_requerimientotrabajador' => $id_req,
					'id_usuarios' => $n,
					'fecha_inicio' => $req->fecha_inicio,
					'fecha_termino' => $req->fecha_termino,
					'id_origen_trabajador_requerimiento' => $req->id_origen_trabajador_requerimiento
				);
				$id_asigna_requerimiento = $this->Requerimiento_model->ingresar_trabajador($data);
				// $id_ingreso[] = array(
					// 'usuario' => $n,
					// 'id_asigna_requerimiento' => $id_asigna_requerimiento
				// ); 
				$trabajador = $this->Usuarios_model->get($n);//verificar
				//envio de correo a los trabajadores nuevos
				$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
				$this->email->from('sgo@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
				$this->email->to($trabajador->email);
				$this->email->subject('Asignado a nuevo requerimiento');
				$this->email->message($this->load->view('email/asignado_requerimiento',$requerimiento_mail,TRUE));
				$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
				if( !@$this->email->send()){
					//echo "error";
					//echo $this->email->print_debugger();
				}
			}
		}
		
		//quitar trabajadores desclickeados
		if(is_array($usr_req)){
			foreach($this->Asignarequerimiento_model->listado_requerimiento($id_req) as $r){
				if (!in_array($r->id_usuarios, $usr_req)) {
				 	$this->Requerimiento_model->eliminar_trabajador($r->id_usuarios,$id_req);
				}
			}
		}
		
		if($total_usr == $req->cantidad ){
			$data2 = array(
				'id_estado' => 3,
				'cantidad_ok' => $total_usr
			);
		}
		if($total_usr < $req->cantidad ){
			$data2 = array(
				'id_estado' => 2,
				'cantidad_ok' => $total_usr
			);
		}
		if($total_usr == 0 ){
			$data2 = array(
				'id_estado' => 1,
				'cantidad_ok' => $total_usr
			);
		}
		
		$this->Requerimiento_model->actualizar_req($id_req,$data2); //actualizar el estado y la cantidad de trabajadors asignados
		$this->session->unset_userdata('requerimiento');
		
		//reemplazar trabajadores
		if( !is_bool($reemplazantes = $this->session->userdata('reemplazo_final') ) ){
			$this->load->model("Reemplazos_requerimiento_model");
			//listar todos los trabajadores del requerimiento
			foreach($this->Requerimiento_model->listar_trabajador_req($id_req) as $lr ){
				$Y=0;
				foreach($reemplazantes as $k => $v){
					if(($lr->id_usuarios == $reemplazantes[$Y]['usuario']) && ( $lr->id_requerimientotrabajador == $reemplazantes[$Y]['sub_req'])){
						$ingreso = array(
							'id_usuarios' => $reemplazantes[$Y]['reemplazo']['usuario_r'],
							'id_asigna_requerimiento' => $lr->id,
							'id_motivos_falta' => $reemplazantes[$Y]['reemplazo']['motivo'],
							'observacion' => $reemplazantes[$Y]['reemplazo']['observacion']
						);
						$this->Reemplazos_requerimiento_model->ingresar($ingreso);
					}
					$Y++;
				}
			}
		}
		
		$this->session->unset_userdata('usuarios_finalizados');
		$this->session->unset_userdata('reemplazo_final');
		//$tot_subreq = count($this->Requerimiento_model->listar_req($req->id_requerimiento)); //cantidad de subrequerimientos
		$tot_subreq = count($this->Requerimiento_trabajador_model->get_requerimiento($req->id_requerimiento));
		$listo = 0; //auxiliar contador de si estan todos los subrequerimientos listos
		//foreach($this->Requerimiento_model->listar_req($req->id_requerimiento) as $f){ // cuando esten todos en estado 3, marcar como leido
		foreach($this->Requerimiento_trabajador_model->get_requerimiento($req->id_requerimiento) as $f){ // cuando esten todos en estado 3, marcar como leido
			if($f->id_estado == 3)
				$listo++;
		}
		if($listo == $tot_subreq ){
			$salida = array('flag_leido' => 1);
			$this->Requerimiento_model->editar($req->id_requerimiento,$salida);
		}
		
		//redirect('/administracion/requerimiento/detalles/'.$req->id_requerimiento.'/exito', 'refresh');
	}

	function eliminar($id){
		$this->Requerimiento_model->eliminar($id);
		redirect(base_url().'administracion/requerimiento/nuevos', 'refresh');
	}
	
	function peticion_eliminacion(){
		$this->load->model("Empresas_model");
		$base['titulo'] = "Petición de eliminación de requerimientos";
		$base['lugar'] = "Petición de eliminación";
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$pagina['lista_req'] = $this->Requerimiento_model->get_pet_eliminacion();
		$base['cuerpo'] = $this->load->view('requerimiento/peticion_eliminacion',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function estado_subreq($id){
		$this->load->model('Especialidadtrabajador_model');
		$base['listado'] = $this->Requerimiento_model->get_prin_req($id);
		$this->load->view('requerimiento/dialog_subreq',$base);
	}
	
	function eliminar_req_fin_trab($id){
		$this->load->model("Asignarequerimiento_model");
		foreach($this->Requerimiento_model->listar_req($id) as $r){
			foreach($this->Requerimiento_model->get_trabajador($r->id) as $t){
				$this->Asignarequerimiento_model->actualizar($r->id,$t->id_usuarios,array('fecha_termino'=>date('Y-m-d'),'termino'=>1));
			}
		}
		$this->Requerimiento_model->editar($id,array('flag_vigente' => 0));
	}
	
	function ajax_cargos($id_planta){
		$this->load->model("Cargos_model");
		$plantas = $this->Cargos_model->listar_planta($id_planta);
		echo "<option value='' >Cargos...</option>";
		foreach($plantas as $p){
			echo "<option value='" .$p->id. "'>". ucwords(mb_strtolower($p->desc_cargo)) ."</option>";
		}
	}

	function ajax_areas($id_planta){
		$this->load->model("Areas_model");
		$areas = $this->Areas_model->listar_planta($id_planta);
		echo "<option value='' >Areas...</option>";
		foreach($areas as $a){
			echo "<option value='" .$a->id. "'>". ucwords(mb_strtolower($a->desc_area)) ."</option>";
		}
	}
	
	function ajax_especialidades(){
		$this->load->model("Especialidadtrabajador_model");
		$espe = $this->Especialidadtrabajador_model->listar();
		echo "<option value='' >Especialidad...</option>";
		foreach($espe as $e){
			echo "<option value='" .$e->id. "'>". ucwords(mb_strtolower($e->desc_especialidad)) ."</option>";
		}
	}
	
	function ajax_centrocostos($id_planta){
		$this->load->model("Centrocostos_model");
		$cc = $this->Centrocostos_model->listar_planta($id_planta);
		echo "<option value='' >Centro de costo...</option>";
		foreach($cc as $c){
			echo "<option value='" .$c->id. "'>". ucwords(mb_strtolower($a->desc_centrocosto)) ."</option>";
		}
	}
	function ajax_reemplazo($id = false){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		//$id = base64_decode(urldecode($id));
		$this->load->model("Requerimiento_trabajador_model");
		//$req = $this->Requerimiento_model->get_req($id);
		$req = $this->Requerimiento_trabajador_model->get_trabajador($id);
		if(count($req) < 1)
			redirect('/error/error404', 'refresh');
		$pagina['id_subreq'] = $id;
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Fotostrab_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->library('pagination');
		
		$base['titulo'] = "Asignacion de requerimiento";
		$base['lugar'] = "Requerimientos";
		
		$lista = array();
		
		$url_pag = $this->uri->uri_to_assoc(5);
		if($this->uri->segment(5) === FALSE)
			$paginado = 1;
		else{
			$paginado = (empty($url_pag['pagina'])) ? 1 : $url_pag['pagina'];
			$url_encript = $this->uri->uri_to_assoc(5);
		}
		
		$config['per_page'] = 15;
		$config['full_tag_open'] = "<div class='dataTables_paginate paging_full_numbers'>";
		$config['full_tag_close'] = '</div>';
		$config['next_link'] = 'Siguiente';
		$config['next_tag_open'] = '<span class="next paginate_button">';
		$config['next_tag_close'] = '</span>';
		$config['num_tag_open'] = '<span class="paginate_button">';
		$config['num_tag_close'] = '</span>';
		$config['cur_tag_open'] = '<span class="paginate_active">';
		$config['cur_tag_close'] = '</span>';
		$config['last_link'] = 'Ultimo';
		$config['last_tag_open'] = '<span class="next paginate_button">';
		$config['last_tag_close'] = '</span>';
		$config['first_link'] = 'Primero';
		$config['first_tag_open'] = '<span class="previous paginate_button">';
		$config['first_tag_close'] = '</span>';
		$config['prev_link'] = 'Anterior';
		$config['prev_tag_open'] = '<span class="previous paginate_button">';
		$config['prev_tag_close'] = '</span>';
		if(!empty($url_encript['filtro'])){ //si existe el filtro entonces........
			$filtro = base64_decode( urldecode($url_encript['filtro']));
			$fil = explode("/",$filtro);
			$asociacion = array();
			$aux = array(
				$fil[0] => $fil[1],
				$fil[2] => $fil[3],
				$fil[4] => $fil[5],
				$fil[6] => $fil[7],
				$fil[8] => $fil[9],
				$fil[10] => $fil[11]
			 );
			array_push($asociacion,$aux);
			unset($aux);
			
			if($asociacion[0]['nombre'] === 0) $asociacion[0]['nombre'] = FALSE;
			if($asociacion[0]['rut'] == 0) $asociacion[0]['rut'] = FALSE;
			if($asociacion[0]['profesion'] == 0) $asociacion[0]['profesion'] = FALSE;
			if($asociacion[0]['especialidad'] == 0) $asociacion[0]['especialidad'] = FALSE;
			if($asociacion[0]['ciudad'] == 0) $asociacion[0]['ciudad'] = FALSE;
			if($asociacion[0]['estado'] == 0) $asociacion[0]['estado'] = FALSE;
			$config['base_url'] = base_url().'/administracion/requerimiento/ajax_reemplazo/'.$this->uri->segment(4)."/filtro/".$url_encript['filtro']."/pagina/";
			$config['total_rows'] = $this->Usuarios_model->total_filtro($asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['profesion'],$asociacion[0]['especialidad'],$asociacion[0]['ciudad'],false,$asociacion[0]['estado']);
			$config['uri_segment'] = 8;
		}
		else{ // si no existe el filtro entoncess...........
			$config['base_url'] = base_url().'/administracion/requerimiento/ajax_reemplazo/'.$this->uri->segment(4)."/pagina/";
			$config['total_rows'] = $this->db->where('id_tipo_usuarios',2)->get('usuarios')->num_rows();
			$asociacion[0]['nombre'] = FALSE;
			$asociacion[0]['rut'] = FALSE;
			$asociacion[0]['profesion'] = FALSE;
			$asociacion[0]['especialidad'] = FALSE;
			$asociacion[0]['ciudad'] = FALSE;
			$asociacion[0]['estado'] = FALSE;
			$config['uri_segment'] = 6;
		}
		
		if($config['total_rows'] <= $config['per_page'] ){
			$config['total_rows'] = FALSE;
			$paginado = FALSE;
		}
		$this->pagination->initialize($config);
		//echo $config['total_rows'];
		//print_r($asociacion);
		//si la session de requerimiento no se a inicializado o esta vacia, se llana con los usuarios de bd del requerimiento
		if( (is_bool($this->session->userdata("requerimiento") )) || (count($this->session->userdata("requerimiento")) < 1 ) ){
			foreach($this->Usuarios_model->listar_id() as $u){
				if($this->Requerimiento_model->get_trabajador_req($u->id,$id)){ //lleno la session de requerimiento, si existen asignados por BD
					$ses[] = $u->id;
					$this->session->set_userdata("requerimiento",$ses);
				}
			}
		}
		foreach($this->Usuarios_model->listar_filtro($asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['profesion'],$asociacion[0]['especialidad'],$asociacion[0]['ciudad'],false,$asociacion[0]['estado'],$config['per_page'],$paginado) as $t){
			$aux = new stdClass();
			$foto = $this->Fotostrab_model->get_usuario($t->id);
			$check = FALSE;
			$otro_req = FALSE;
			$id_otro_req = FALSE;
			if(!is_bool($this->session->userdata("requerimiento"))){
				foreach($this->session->userdata("requerimiento") as $r=>$k){
					if($t->id == $k){
						$check = TRUE;
					}
				}
			}
			// if($this->Requerimiento_model->get_trabajador_otroreq($t->id,$id)){//verificar si existe en otro requerimiento
				// $otro_req = TRUE;
				// $id_otro_req = $this->Requerimiento_model->get_trabajador_otroreq($t->id,$id)->id_requerimientotrabajador;
			// }
			// echo $t->id."<br/>";
			// echo "id-->".$id."<br/>";
			//print_r($req);
			// echo "fecha_inicio-->".$req[0]->fecha_inicio."<br/>";
			if($this->Asignarequerimiento_model->get_actual($t->id,$id,$req->fecha_inicio)){//verificar si existe en otro requerimiento
				$otro_req = TRUE;
				$id_otro_req = $this->Asignarequerimiento_model->get_actual($t->id,$id,$req->fecha_inicio)->id_requerimientotrabajador;
				$id_otro_req_padre = $this->Requerimiento_model->get_req($id_otro_req);
			}
			
			
			$aux->id = $t->id;
			$aux->check = $check;
			$aux->otro_req = $otro_req;
			$aux->id_otro_req = $id_otro_req;//el id del otro requerimiento
			@$aux->id_otro_req_padre = $id_otro_req_padre->id_requerimiento; //id del requerimiento padre
			$aux->nombres =  $t->nombres;
			$aux->paterno = $t->paterno;
			$aux->materno = $t->materno;
			$aux->rut = $t->rut_usuario;
			$aux->foto = (count($foto)< 1) ? 'extras/img/perfil/requerimiento/avatar.jpg' : $foto->media;
			array_push($lista,$aux);
			unset($aux);
		}
		//print_r($this->session->userdata("requerimiento"));
		if( is_bool( $this->session->userdata("requerimiento") ) )
			$asignados = '0';
		else
			$asignados = count($this->session->userdata("requerimiento"));
		
		$pagina['asignados'] = $asignados;
		
		//mantener el filtro en el html cuando recargue
		
		$pagina['paginado']	= $this->pagination->create_links();
		$pagina['input_nombre'] = $asociacion[0]['nombre'];
		$pagina['input_rut'] = $asociacion[0]['rut'];
		$pagina['input_profesion'] = $asociacion[0]['profesion'];
		$pagina['input_especialidad'] = $asociacion[0]['especialidad'];
		$pagina['input_ciudad'] = $asociacion[0]['ciudad'];
		$pagina['input_estado'] = $asociacion[0]['estado'];
		$pagina['cant_pedidos'] = $req->cantidad; 
		$pagina['listado_usuarios'] = $lista;
		$pagina['listado_ciudades'] = $this->Ciudad_model->listar();
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		$pagina['listado_profesiones'] = $this->Profesiones_model->listar();
		$pagina['id'] = $id;
		if(!empty($req->id_especialidad))
			$pagina['especialidad'] = $this->Especialidadtrabajador_model->get($req->id_especialidad)->desc_especialidad;
		else
			$pagina['especialidad'] = NULL;
		$pagina['id_req'] = $req->id_requerimiento;
		//$pagina['menu'] = $this -> load -> view('menus/menu_admin',$this->requerimiento,TRUE);
		//$base['cuerpo'] = $this -> load -> view('requerimiento/ajax_asignar',$pagina,TRUE);
		$this->load->view('requerimiento/ajax_asignar',$pagina);
	}

	function form_requerimiento(){
		// print_r($_POST['trabajador_original']);
		// print_r($_POST['trabajador_reemplazo']);
		// print_r($_POST['f_inicio']);
		// print_r($_POST['f_termino']);
		// print_r($_POST['origen']);
		//echo $_POST['id_requerimiento'];
		
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->model("Reemplazos_requerimiento_model");
		$id_req = $_POST['id_requerimiento'];
		$id_principal = $this->Requerimiento_model->get_requerimiento_principal($_POST['id_requerimiento']);
		if(count($_POST['trabajador_original']) < 1 ){
			redirect('/administracion/requerimiento/detalles/'.$_POST['id_requerimiento'].'/error', 'refresh');
		}
		print_r($_POST['trabajador_original']);
		//si no existe el trabajador se ingresa y si existe se actualiza
		for($i=0;$i < count($_POST['trabajador_original']); $i++){
			$usr_req[] = $_POST['trabajador_original'][$i];
			$fecha_inicio =  explode('-', $_POST['f_inicio'][$i]);
			$fecha_termino =  explode('-', $_POST['f_termino'][$i]);
			$data = array(
				'id_requerimientotrabajador' => $_POST['id_requerimiento'],
				'id_usuarios' => $_POST['trabajador_original'][$i],
				'fecha_inicio' => $fecha_inicio[2].'-'.$fecha_inicio[1].'-'.$fecha_inicio[0],
				'fecha_termino' => $fecha_termino[2].'-'.$fecha_termino[1].'-'.$fecha_termino[0],
				'id_origen_trabajador_requerimiento' => $_POST['origen'][$i]
			);
			if(!$this->Asignarequerimiento_model->existe_trab_requerimiento($_POST['trabajador_original'][$i],$_POST['id_requerimiento'])){
				//echo "ingresa<br>";
				$id_asigna_requerimiento = $this->Requerimiento_model->ingresar_trabajador($data);
			}
			else{
				//echo "updatea<br>";
				$id_asigna_requerimiento = $this->Asignarequerimiento_model->existe_trab_requerimiento($_POST['trabajador_original'][$i],$_POST['id_requerimiento']);				
				$this->Asignarequerimiento_model->actualizar2($id_asigna_requerimiento->id,$data);
				$id_asigna_requerimiento = $id_asigna_requerimiento->id;
			}
			//echo $id_asigna_requerimiento;
			if(isset($_POST['trabajador_reemplazo'][$i])){ //verificar si existe reemplazo para el usuario
				$data_reemplazo = array(
					'id_usuarios' => $_POST['trabajador_reemplazo'][$i],
					'id_asigna_requerimiento' => $id_asigna_requerimiento,
					'id_motivos_falta' => 3
				);
				if( count( $this->Reemplazos_requerimiento_model->get_usuario($_POST['trabajador_original'][$i],$id_asigna_requerimiento) < 1)){
					$this->Reemplazos_requerimiento_model->ingresar($data_reemplazo);
				}
			}
		}
		
		foreach ($this->Asignarequerimiento_model->listado_requerimiento($_POST['id_requerimiento']) as $lr) {
			$aux_reemplazo = FALSE;
			if($lista_reemplazo = $this->Reemplazos_requerimiento_model->listar_requerimiento($lr->id)){
				print_r($lista_reemplazo);
				if(!empty($_POST['trabajador_reemplazo'])){
					for($a=0;$a < count($_POST['trabajador_reemplazo']); $a++){
						if($lista_reemplazo->id_usuarios == $_POST['trabajador_reemplazo'][$a] )
							$aux_reemplazo = TRUE;
					}
				}
				if($aux_reemplazo == FALSE){
					$this->Reemplazos_requerimiento_model->borrar($lista_reemplazo->id);
				}
			}
		}
		
		//$req = $this->Requerimiento_model->get_req($id_req);
		$req = $this->Requerimiento_trabajador_model->get_trabajador($_POST['id_requerimiento']);
		$total_usr = count($usr_req);
		//$this->Requerimiento_model->eliminar_trabajador_req($id_req);
		$this->load->library('email');
		
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'sgo@empresasintegra.cl';
		$config['smtp_pass'] = 'gestion2012';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';

		$this->email->initialize($config);
		//ver si el trabajador ya se asigno al requerimiento
		if(is_array($usr_req)){
			$no_existen = array();
			foreach($usr_req as $u){
				if(!$this->Asignarequerimiento_model->existe_trab_requerimiento($u,$id_req))
				$no_existen[] = $u; //lista de trabajadores nuevos
			}
		}
		
		//finalizar trabajadores del requerimiento anterior
		 print_r($this->session->userdata('usuarios_finalizados'));
		 if(is_array($finalizados = $this->session->userdata('usuarios_finalizados'))){
		 	foreach($finalizados as $f){
		 		$data = array(
		 			'fecha_termino' => $f['fecha'],
		 			'termino' => 1,
		 			'motivo_termino' => $f['motivo']
				);
				$this->Asignarequerimiento_model->actualizar($f['id_req'],$f['id_usuario'],$data);
				unset($data);
		 	}
		 }
		
		
		//agregar trabajadores que no existan ya en el requerimiento
		if(is_array($no_existen)){
			foreach($no_existen as $n){
				$data = array(
					'id_requerimientotrabajador' => $id_req,
					'id_usuarios' => $n,
					'fecha_inicio' => $req->fecha_inicio,
					'fecha_termino' => $req->fecha_termino
				);
				$id_asigna_requerimiento = $this->Requerimiento_model->ingresar_trabajador($data);
				// $id_ingreso[] = array(
					// 'usuario' => $n,
					// 'id_asigna_requerimiento' => $id_asigna_requerimiento
				// ); 
				$trabajador = $this->Usuarios_model->get($n);//verificar
				//envio de correo a los trabajadores nuevos
				$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
				$this->email->from('sgo@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
				$this->email->to($trabajador->email);
				$this->email->subject('Asignado a nuevo requerimiento');
				$this->email->message($this->load->view('email/asignado_requerimiento',$requerimiento_mail,TRUE));
				$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
				if( !@$this->email->send()){
					//echo "error";
					//echo $this->email->print_debugger();
				}
			}
		}
		
		//quitar trabajadores desclickeados
		if(is_array($usr_req)){
			foreach($this->Asignarequerimiento_model->listado_requerimiento($id_req) as $r){
				if (!in_array($r->id_usuarios, $usr_req)) {
				 	$this->Requerimiento_model->eliminar_trabajador($r->id_usuarios,$id_req);
				}
			}
		}
		
		if($total_usr == $req->cantidad ){
			$data2 = array(
				'id_estado' => 3,
				'cantidad_ok' => $total_usr
			);
		}
		if($total_usr < $req->cantidad ){
			$data2 = array(
				'id_estado' => 2,
				'cantidad_ok' => $total_usr
			);
		}
		if($total_usr == 0 ){
			$data2 = array(
				'id_estado' => 1,
				'cantidad_ok' => $total_usr
			);
		}
		
		$this->Requerimiento_model->actualizar_req($id_req,$data2); //actualizar el estado y la cantidad de trabajadors asignados
		$this->session->unset_userdata('requerimiento');
		
		//reemplazar trabajadores
		
		
		$this->session->unset_userdata('usuarios_finalizados');
		$this->session->unset_userdata('reemplazo_final');
		//$tot_subreq = count($this->Requerimiento_model->listar_req($req->id_requerimiento)); //cantidad de subrequerimientos
		$tot_subreq = count($this->Requerimiento_trabajador_model->get_requerimiento($id_principal->id));
		$listo = 0; //auxiliar contador de si estan todos los subrequerimientos listos
		//foreach($this->Requerimiento_model->listar_req($req->id_requerimiento) as $f){ // cuando esten todos en estado 3, marcar como leido
		foreach($this->Requerimiento_trabajador_model->get_requerimiento($id_principal->id) as $f){ // cuando esten todos en estado 3, marcar como leido
			if($f->id_estado == 3)
				$listo++;
		}
		
		if($listo == $tot_subreq ){
			$salida = array('flag_leido' => 1);
			$this->Requerimiento_model->editar($id_principal->id,$salida);
		}
		//obtener el id principal
		//$id_principal = $this->Requerimiento_model->get_requerimiento_principal($_POST['id_requerimiento']);
		redirect('/administracion/requerimiento/detalles/'.$id_principal->id.'/exito', 'refresh');
	}




	function busqueda_grupos(){
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Busqueda de usuarios por grupos";
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


		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/busqueda',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function ajax_grupo($id_planta = FALSE){
		$this->load->model("Grupo_model");
		$res = $this->Grupo_model->listar_planta($id_planta);
		echo json_encode($res);
	}

	function ajax_areas2($id_grupo = FALSE){
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

	function ajax_cargos2($id_grupo = FALSE, $id_area = FALSE){
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


}
?>