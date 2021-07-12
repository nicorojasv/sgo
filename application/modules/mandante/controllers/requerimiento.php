<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Requerimiento extends CI_Controller {
	public $noticias;
	
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 1){
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

		$this->load->model("Noticias_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_admin($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->noticias['mensajes_noleidos'] = $suma;
   	}
	function index() {
		
	}
	
	function publicar($msg = FALSE){
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Centrocostos_model");
		$this->load->model('Usuarios_model');
		
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
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$id_planta = $this->Usuarios_model->get($this->session->userdata('id'))->id_planta; 
		$pagina['id_planta'] = $id_planta;
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		$pagina['listado_areas'] = $this->Areas_model->listar_planta($id_planta);
		$pagina['listado_cargos'] = $this->Cargos_model->listar_planta($id_planta);
		$pagina['listado_cc'] = $this->Centrocostos_model->listar_planta($id_planta);
		$base['cuerpo'] = $this->load->view('requerimientos/crear_requerimiento',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function editar($id = FALSE, $msg = FALSE){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		$this->load->model("Requerimiento_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Requerimiento_cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Centrocostos_model");
		$this->load->model("Usuarios_model");
		$this->load->library('encrypt');
		$id = base64_decode( urldecode($id) );
		$base['titulo'] = "Edición de requerimiento";
		$base['lugar'] = "Editar requerimiento";
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
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$pagina['datos'] = $this->Requerimiento_model->get($id);
		$pagina['editar'] = TRUE;
		$pagina['id_req'] = $id;
		//$pagina['subreq'] = $this->Requerimiento_model->listar_req($id);
		//$pagina['subreq'] = $this->Requerimiento_trabajador_model->get_requerimiento($id);
		$pagina['subreq'] = $this->Requerimiento_areas_model->get_requerimiento($id);
		
		//$id_planta = $this->Usuarios_model->get($this->session->userdata('id'))->id_planta;
		$id_planta = $pagina['datos']->id_planta; 
		$pagina['id_planta'] = $id_planta;
		$pagina['listado_areas'] = $this->Areas_model->listar_planta($id_planta);
		$pagina['listado_cargos'] = $this->Cargos_model->listar_planta($id_planta);
		$pagina['listado_cc'] = $this->Centrocostos_model->listar_planta($id_planta);
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		$base['cuerpo'] = $this->load->view('requerimientos/crear_requerimiento',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function eliminar_subreq($id){
		$this->load->model("Requerimiento_model");
		$this->Requerimiento_model->eliminar_req($id);
		
	}
	
	function guardar(){
		if( empty($_POST['select_area']) || empty($_POST['select_cargo']) || empty($_POST['cantidad']) || 
		empty($_POST['fdesde']) || $_POST['fdesde'] == "Desde" || empty($_POST['fhasta']) || 
		$_POST['fhasta'] == "Hasta" || empty($_POST['nombre']) || empty($_POST['lugar']) ){ 
			redirect('mandante/requerimiento/publicar/error_vacio', 'refresh');
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
				$data_base = array(
					'nombre' => mb_strtoupper($_POST['nombre'], 'UTF-8'),
					'id_usuarios' => $this -> session -> userdata('id'),
					'id_planta' => $this->Usuarios_model->get($this->session->userdata('id'))->id_planta,
					'lugar_trabajo' => mb_strtoupper($_POST['lugar'], 'UTF-8'),
					'comentario' => $_POST['texto']
				);
				//print_r($data_base);echo "<br/>";
				$id_requerimiento = $this->Requerimiento_model->ingresar($data_base);
				for($i = 0; $i < count($_POST['select_area']);$i++){
					$id_area = $_POST['select_area'][$i];
					$data_area = array(
						'id_areas' => $id_area,
						'id_requerimiento' => $id_requerimiento
					);
					//print_r($data_area);echo "<br/>";
					$id_requerimiento_area = $this->Requerimiento_areas_model->ingresar($data_area);
					if( count($_POST['select_cargo']) > 0 ){
						for( $x = 0; $x < count( $_POST['select_cargo'][$id_area]); $x++ ){
							$id_cargo = $_POST['select_cargo'][$id_area][$x];
							$especialidad = empty($_POST['select_especialidad'][$id_area][$x])? NULL : $_POST['select_especialidad'][$id_area][$x];
							$id_especialidad = empty($_POST['select_especialidad'][$id_area][$x])? 0 : $_POST['select_especialidad'][$id_area][$x];
							//echo "id_especialidad " .$id_especialidad ."<br />";
							$data_cargo = array(
								'id_requerimiento_areas' => $id_requerimiento_area,
								'id_cargos' => $id_cargo,
								'id_especialidad' => $especialidad
							);
							//print_r($data_cargo);echo "<br/>";
							$id_requerimiento_cargo = $this->Requerimiento_cargos_model->ingresar($data_cargo);
							$comparar = array(
								count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ),
								count( $_POST['fdesde'][$id_area][$id_cargo][$id_especialidad]),
								count( $_POST['fhasta'][$id_area][$id_cargo][$id_especialidad]),
							);
							if(count(array_unique($comparar)) == 1) {
								//echo "numero cantidades --> ".count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ). "<br />";
								for( $z = 0; $z < count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ); $z++ ){
									$cantidad = $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad][$z];
									$finicio = $_POST['fdesde'][$id_area][$id_cargo][$id_especialidad][$z];
									$ftermino = $_POST['fhasta'][$id_area][$id_cargo][$id_especialidad][$z];
									$centro_costo = empty( $_POST['select_cc'][$id_area][$id_cargo][$id_especialidad][$z] )? NULL : $_POST['select_cc'][$id_area][$id_cargo][$id_especialidad][$z];
									$fecha_inicio = explode(" ", $finicio);
									$fecha_termino = explode(" ", $ftermino);
									$data_trabajador = array(
										'id_requerimiento_cargos' => $id_requerimiento_cargo,
										'id_centrocosto' => $centro_costo,
										'fecha_inicio' => $fecha_inicio[2].'-'.mesXdia($fecha_inicio[1]).'-'.$fecha_inicio[0],
										'fecha_termino' => $fecha_termino[2].'-'.mesXdia($fecha_termino[1]).'-'.$fecha_termino[0],
										'cantidad' => $cantidad
									);
									//print_r($data_trabajador);echo "<br/>";
									$this->Requerimiento_trabajador_model->ingresar($data_trabajador);
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
			}
			else{
				$valido = FALSE;
			}
			
			if( $valido == FALSE){
				$this->db->trans_rollback();
				redirect('mandante/requerimiento/publicar/error_incompleto', 'refresh');
			}
			else{
				$this->db->trans_commit();
				redirect('mandante/requerimiento/publicar/exito', 'refresh');
			}
		}
	}
	
	function estado($msg = FALSE){
		$base['titulo'] = "Estado de requerimiento";
		$base['lugar'] = "Estado de requerimiento";
		$this->load->model("Requerimiento_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Requerimiento_cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		//$this->load->library('encrypt');
		
		if($msg == "eliminado"){
			$aviso['titulo'] = "Se eliminó el requerimiento correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$pagina['lista_req'] = $this->Requerimiento_model->get_activas_mandante2($this->session->userdata("id"));
		$base['cuerpo'] = $this->load->view('requerimientos/estado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function estado_subreq($id){
		$this->load->model("Requerimiento_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Requerimiento_cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		
		$base['listado'] = $this->Requerimiento_trabajador_model->get_requerimiento($id);
		$this->load->view('requerimientos/dialog_subreq',$base);
	}
	
	function ajax_eliminar($id){
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Especialidadtrabajador_model');
		//$this->load->library('encrypt');
		$id = base64_decode( urldecode($id));
		
		$lista = array();
		//foreach($this->Requerimiento_model->get_prin_req($id) as $l ){	
		foreach($this->Requerimiento_trabajador_model->get_requerimiento($id) as $l){
			if( $l->cantidad_ok > 0 ){
				$aux = new stdClass();
				if( !empty($l->id_especialidad) )
					$aux->especialidad = $this->Especialidadtrabajador_model->get($l->id_especialidad)->desc_especialidad;
				else $aux->especialidad = FALSE;
				$aux->cantidad = $l->cantidad_ok;
				array_push($lista,$aux);
				unset($aux);
			}
		}
		if( count($lista) > 0)
			echo json_encode($lista);
		else echo NULL;
	}
	
	function ajax_peticion_eliminacion($id){
		$this->load->model('Requerimiento_model');
		//$this->load->library('encrypt');
		$id = base64_decode( urldecode($id));
		$data = array('eliminar' => 1);
		$this->Requerimiento_model->editar($id,$data);
	}
	
	function ajax_validar_eliminacion($id){
		$this->load->model('Requerimiento_model');
		//$this->load->library('encrypt');
		$id = base64_decode( urldecode($id));
		$req = $this->Requermiento_model->get($id)->eliminar;
		echo $req;
	}
	
	function ajax_eliminar_sin_trab($id){
		$this->load->model('Requerimiento_model');
		//$this->load->library('encrypt');
		$id = base64_decode( urldecode($id));
		$this->Requerimiento_model->eliminar($id);
	}

	function asignados($id = FALSE){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		
		$base['titulo'] = "Trabajadores asignados el requerimiento";
		$base['lugar'] = "Trabajadores asignados";
		//$this->load->library('encrypt');
		$this->load->model('Asignarequerimiento_model');
		$this->load->model('Usuarios_model');
		$this->load->model("Fotostrab_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		
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
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$base['cuerpo'] = $this->load->view('requerimientos/trabajadores_asignados',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function editando($id = FALSE){
		//$this->load->library('encrypt');
		$id = base64_decode( urldecode($id) );
		
		if( empty($_POST['select_especialidad']) || empty($_POST['select_area']) || empty($_POST['select_cargo']) || empty($_POST['select_cc']) 
		|| empty($_POST['cantidad']) || empty($_POST['fdesde']) || $_POST['fdesde'] == "Desde" || empty($_POST['fhasta']) || $_POST['fhasta'] == "Hasta" ||
		empty($_POST['nombre']) || empty($_POST['lugar']) ){ 
			redirect('mandante/requerimiento/editar/'.urlencode( $this->encrypt->enconde($id) ).'/error_vacio', 'refresh');
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
			
			if( count($_POST['select_area']) > 0 ){
				//$this->Requerimiento_areas_model->eliminar_requerimiento($id);
				if(empty($_POST['nombre']) || empty($_POST['lugar']) ){
					$valido = FALSE;
					break;
				}
				$data_base = array(
					'nombre' => mb_strtoupper($_POST['nombre'], 'UTF-8'),
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
								if(count(array_unique($comparar)) == 1) {
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
			}
			else{
				$valido = FALSE;
			}
			if(@$contiene){
				redirect('administracion/requerimiento/editar/'.$id.'/contiene', 'refresh');
			}
			if( $valido == FALSE){
				$this->db->trans_rollback();
				redirect('mandante/requerimiento/editar/'.urlencode( $this->encrypt->encode($id)).'/error_incompleto', 'refresh');
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
				redirect('mandante/requerimiento/editar/'.urlencode( base64_encode($id)).'/exito', 'refresh');
			}
		}
	}

	function historial_requerimiento(){
		$base['titulo'] = "Estado de requerimiento";
		$base['lugar'] = "Requerimientos";
		$this->load->model("Requerimiento_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Requerimiento_cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->library('encrypt');
		
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$pagina['lista_req'] = $this->Requerimiento_model->get_inactivas_mandante2($this->session->userdata("id"));
		$base['cuerpo'] = $this->load->view('requerimientos/historial',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function tooltip($id){ //informacion dinamica de un usuario
		
		$this->load->model("Usuarios_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$this->load->library('encrypt');
		
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
				<div><a target='_blank' href='".base_url()."mandante/perfil/trabajador/".urlencode($this->encrypt->encode($usu->id))."'>Ver Perfil Completo</a></div>
			</div>
			<div class='clear'>&nbsp;</div>
		</div>";
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
	
	function ajax_revisar_codigo(){
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
	
	function ajax_peticion_edicion(){
		if($_POST['msg']){
			$this->load->library('email');
			$this->load->model('Requerimiento_model');
			$this->load->model('Usuarios_model');
			$this->load->model('Planta_model');
			
			$config['smtp_host'] = 'mail.empresasintegra.cl';
			$config['smtp_user'] = 'sgo@empresasintegra.cl';
			$config['smtp_pass'] = 'gestion2012';
			$config['mailtype'] = 'html';
			$config['smtp_port']    = '2552';

			$this->email->initialize($config);
			$id_evaluacion = base64_decode(urldecode($_POST['id']));
			$pagina['mensaje'] = $_POST['msg'];
			$pagina['datos'] = $this->Requerimiento_model->get($id_evaluacion);
			$pagina['usr'] = $this->Usuarios_model->get($this->session->userdata('id'));
			$this->email->from('sgo@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
			$this->email->to('vsilva@empresasintegra.cl','gfigueroa@empresasintegra.cl'); 
			$this->email->subject('Petición de edición de requerimiento');
			$this->email->message($this->load->view('email/edicion_requerimiento',$pagina,TRUE));
			$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
			if( !@$this->email->send()){
				//echo "error";
				echo $this->email->print_debugger();
			}
			else echo "si";
			
		}
	}

}
?>