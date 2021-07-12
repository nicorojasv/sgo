<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Examen_Psicologico extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 5)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	/*function index($get_estado = FALSE){
		$this->load->model('Examenes_psicologicos_model');
		$this->load->model('Examenes_psicologicos_archivos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('usuarios/Usuarios_general_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Cargos_model');

		$base = array(
			'head_titulo' => "Listado de Examenes Psicologicos - Sistema EST",
			'titulo' => "Listado de trabajadores",
			'subtitulo' => '',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Examenes Psicologicos' )),
			'menu' => $this->menu,
			'js' => array('js/examenes_psicologicos.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$estado_defecto = "pendientes";
		if (empty($get_estado)){
			$estado = $estado_defecto;
		}else{
			$estado = $get_estado;
		}

		if($estado == "pendientes"){
			$usuarios = $this->Examenes_psicologicos_model->usuarios_pendientes();
			$letra_estado = "P";
			$color_estado = "#DAAA08";
		}elseif($estado == "aprobados"){
			$usuarios = $this->Examenes_psicologicos_model->usuarios_aprobados();
			$letra_estado = "A";
			$color_estado = "#3E9610";
		}elseif($estado == "desaprobados"){
			$usuarios = $this->Examenes_psicologicos_model->usuarios_desaprobados();
			$letra_estado = "D";
			$color_estado = "red";
		}else{
			$usuarios = array();
			$letra_estado = "";
			$color_estado = "";
		}

		$listado = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usuario = $this->Usuarios_model->get($l->usuario_id);
			$id_ciudad = isset($get_usuario->id_ciudades)?$get_usuario->id_ciudades:'';
			$get_ciudad = $this->Ciudad_model->get($id_ciudad);
			$get_cargo_postulacion = $this->Cargos_model->r_get($l->cargo_postulacion_id);
			$get_lugar_trabajo = $this->Empresa_planta_model->get($l->lugar_trabajo_id);
			$get_solicitante = $this->Usuarios_general_model->get($l->solicitante_id);
			$get_psicologo_evaluador = $this->Usuarios_model->get_datos_psicologo_row($l->psicologo_evaluador);
			$get_archivo_examen = $this->Examenes_psicologicos_archivos_model->get($l->id);

			$nombres_usu = isset($get_usuario->nombres)?$get_usuario->nombres:'';
			$paterno_usu = isset($get_usuario->paterno)?$get_usuario->paterno:'';
			$materno_usu = isset($get_usuario->materno)?$get_usuario->materno:'';

			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:"";
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:"";
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:"";
			$nombre_psicologo = isset($get_psicologo_evaluador->nombres)?$get_psicologo_evaluador->nombres:"";
			$ap_psicologo = isset($get_psicologo_evaluador->paterno)?$get_psicologo_evaluador->paterno:"";
			$am_psicologo = isset($get_psicologo_evaluador->materno)?$get_psicologo_evaluador->materno:"";
			$aux->id_examen = $l->id;
			$aux->rut_usuario = isset($get_usuario->rut_usuario)?$get_usuario->rut_usuario:"";
			$aux->nombres_usuario = $nombres_usu." ".$paterno_usu." ".$materno_usu;
			$aux->fono = isset($get_usuario->fono)?$get_usuario->fono:'';
			$aux->residencia = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:"";
			$aux->lugar_trabajo = isset($get_lugar_trabajo->nombre)?$get_lugar_trabajo->nombre:"";
			$aux->solicitante = $nombre_solicitante." ".$paterno_solicitante." ".$materno_solicitante;
			$aux->psicologo = $nombre_psicologo." ".$ap_psicologo." ".$am_psicologo;
			$aux->especialidad_post = isset($get_cargo_postulacion->nombre)?$get_cargo_postulacion->nombre:"";

			if($l->tecnico_supervisor == 1){
				$aux->tecnico_supervisor = "Tecnico";
			}elseif($l->tecnico_supervisor == 2){
				$aux->tecnico_supervisor = "Supervisor";
			}else{
				$aux->tecnico_supervisor = "";
			}

			$aux->color_examen = isset($get_archivo_examen->id)?"green":"red";
			$aux->letra_estado = $letra_estado;
			$aux->color_estado = $color_estado;
			$aux->sueldo_definido = isset($l->sueldo_definido)?$l->sueldo_definido:"0";
			$aux->resultado = isset($l->resultado)?$l->resultado:"";
			$aux->referido = isset($l->referido)?$l->referido:"";
			$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
			$aux->fecha_evaluacion = isset($l->fecha_evaluacion)?$l->fecha_evaluacion:"";
			$aux->fecha_vigencia = isset($l->fecha_vigencia)?$l->fecha_vigencia:"";
			$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";

			$id_espec = isset($get_usuario->id_especialidad_trabajador)?$get_usuario->id_especialidad_trabajador:NULL;
			if($id_espec != NULL){
				$e1 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			$id_espec2 = isset($get_usuario->id_especialidad_trabajador_2)?$get_usuario->id_especialidad_trabajador_2:NULL;
			if($id_espec2 != NULL){
				$e2 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;

			$id_espec3 = isset($get_usuario->id_especialidad_trabajador_3)?$get_usuario->id_especialidad_trabajador_3:NULL;
			if($id_espec3 != NULL){
				$e3 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_3);
				$aux->especialidad3 = (!empty($e3->desc_especialidad))?$e3->desc_especialidad:FALSE;
			}else
				$aux->especialidad3 = false;

			array_push($listado,$aux);
			unset($aux);
		}
		$pagina['lista_aux'] = $listado;
		$pagina['estado'] = $estado;
		$base['cuerpo'] = $this->load->view('examen_psicologico/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}*/

	function index($get_estado = FALSE){
		$this->load->model('Examenes_psicologicos_model');
		$this->load->model('Examenes_psicologicos_archivos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('usuarios/Usuarios_general_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Cargos_model');

		$base = array(
			'head_titulo' => "Listado de Examenes Psicologicos - Sistema EST",
			'titulo' => "Listado de trabajadores",
			'subtitulo' => '',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Examenes Psicologicos' )),
			'menu' => $this->menu,
			'js' => array('js/examenes_psicologicos.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$estado_defecto = "aprobados";
		if (empty($get_estado)){
			$estado = $estado_defecto;
		}else{
			$estado = $get_estado;
		}

		if($estado == "pendientes"){
			//$usuarios = $this->Examenes_psicologicos_model->usuarios_pendientes();
			$letra_estado = "P";
			$color_estado = "#DAAA08";
		}elseif($estado == "aprobados"){
			//$usuarios = $this->Examenes_psicologicos_model->usuarios_aprobados();
			$letra_estado = "A";
			$color_estado = "#3E9610";
		}elseif($estado == "desaprobados"){
			//$usuarios = $this->Examenes_psicologicos_model->usuarios_desaprobados();
			$letra_estado = "D";
			$color_estado = "red";
		}else{
			$usuarios = array();
			$letra_estado = "";
			$color_estado = "";
		}

		$listado = array();
		/*foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usuario = $this->Usuarios_model->get($l->usuario_id);
			$id_ciudad = isset($get_usuario->id_ciudades)?$get_usuario->id_ciudades:'';
			$get_ciudad = $this->Ciudad_model->get($id_ciudad);
			$get_cargo_postulacion = $this->Cargos_model->r_get($l->cargo_postulacion_id);
			$get_lugar_trabajo = $this->Empresa_planta_model->get($l->lugar_trabajo_id);
			$get_solicitante = $this->Usuarios_general_model->get($l->solicitante_id);
			$get_psicologo_evaluador = $this->Usuarios_model->get_datos_psicologo_row($l->psicologo_evaluador);
			$get_archivo_examen = $this->Examenes_psicologicos_archivos_model->get($l->id);

			$nombres_usu = isset($get_usuario->nombres)?$get_usuario->nombres:'';
			$paterno_usu = isset($get_usuario->paterno)?$get_usuario->paterno:'';
			$materno_usu = isset($get_usuario->materno)?$get_usuario->materno:'';

			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:"";
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:"";
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:"";
			$nombre_psicologo = isset($get_psicologo_evaluador->nombres)?$get_psicologo_evaluador->nombres:"";
			$ap_psicologo = isset($get_psicologo_evaluador->paterno)?$get_psicologo_evaluador->paterno:"";
			$am_psicologo = isset($get_psicologo_evaluador->materno)?$get_psicologo_evaluador->materno:"";
			$aux->id_examen = $l->id;
			$aux->rut_usuario = isset($get_usuario->rut_usuario)?$get_usuario->rut_usuario:"";
			$aux->nombres_usuario = $nombres_usu." ".$paterno_usu." ".$materno_usu;
			$aux->fono = isset($get_usuario->fono)?$get_usuario->fono:'';
			$aux->residencia = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:"";
			$aux->lugar_trabajo = isset($get_lugar_trabajo->nombre)?$get_lugar_trabajo->nombre:"";
			$aux->solicitante = $nombre_solicitante." ".$paterno_solicitante." ".$materno_solicitante;
			$aux->psicologo = $nombre_psicologo." ".$ap_psicologo." ".$am_psicologo;
			$aux->especialidad_post = isset($get_cargo_postulacion->nombre)?$get_cargo_postulacion->nombre:"";

			if($l->tecnico_supervisor == 1){
				$aux->tecnico_supervisor = "Tecnico";
			}elseif($l->tecnico_supervisor == 2){
				$aux->tecnico_supervisor = "Supervisor";
			}else{
				$aux->tecnico_supervisor = "";
			}

			$aux->color_examen = isset($get_archivo_examen->id)?"green":"red";
			$aux->letra_estado = $letra_estado;
			$aux->color_estado = $color_estado;
			$aux->sueldo_definido = isset($l->sueldo_definido)?$l->sueldo_definido:"0";
			$aux->resultado = isset($l->resultado)?$l->resultado:"";
			$aux->referido = isset($l->referido)?$l->referido:"";
			$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
			$aux->fecha_evaluacion = isset($l->fecha_evaluacion)?$l->fecha_evaluacion:"";
			$aux->fecha_vigencia = isset($l->fecha_vigencia)?$l->fecha_vigencia:"";
			$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";

			$id_espec = isset($get_usuario->id_especialidad_trabajador)?$get_usuario->id_especialidad_trabajador:NULL;
			if($id_espec != NULL){
				$e1 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			$id_espec2 = isset($get_usuario->id_especialidad_trabajador_2)?$get_usuario->id_especialidad_trabajador_2:NULL;
			if($id_espec2 != NULL){
				$e2 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;

			$id_espec3 = isset($get_usuario->id_especialidad_trabajador_3)?$get_usuario->id_especialidad_trabajador_3:NULL;
			if($id_espec3 != NULL){
				$e3 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_3);
				$aux->especialidad3 = (!empty($e3->desc_especialidad))?$e3->desc_especialidad:FALSE;
			}else
				$aux->especialidad3 = false;

			array_push($listado,$aux);
			unset($aux);
		}*/
		$pagina['lista_aux'] = $listado;
		$pagina['estado'] = $estado;
		$base['cuerpo'] = $this->load->view('examen_psicologico/listado2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
#yayo 04-10-2019 busqueda con ajax de examen psicologicos
function busqueda(){//validr el  estado seleccionado
		$this->load->model('Usuarios_model');
		$this->load->model('Examenes_psicologicos_model');
		$this->load->model('Cargos_model');
		$this->load->model('usuarios/Usuarios_general_model');
		$this->load->model('Examenes_psicologicos_archivos_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Especialidadtrabajador_model');
		if (isset($_POST['valorBusqueda'])) {//Rut
			$qe = $_POST['valorBusqueda'];
			$resultado = $this->Usuarios_model->getTrabajadorAjax($qe);
		}elseif(isset($_POST['valorBusquedaNombre'])){
			$qe = $_POST['valorBusquedaNombre'];
			$resultado = $this->Usuarios_model->getTrabajadorAjaxNombre($qe);
		}elseif (isset($_POST['valorBusquedaApellido'])) {
			$qe = $_POST['valorBusquedaApellido'];
			$resultado = $this->Usuarios_model->getTrabajadorAjaxApellido($qe);
		}
		$estado= $_POST['tipo']; 
		//$qe = '18.215.263';
		//var_dump($resultado);




		$usuarios= array();
		foreach ($resultado as $key) {
			if($estado == "pendientes"){
				$examen = $this->Examenes_psicologicos_model->usuarios_pendientes2($key->id);
			}elseif($estado == "aprobados"){
				//$usuarios = $this->Examenes_psicologicos_model->usuarios_aprobados();
				$examen = $this->Examenes_psicologicos_model->usuarios_aprobados2($key->id);
			}elseif($estado == "desaprobados"){
				$examen = $this->Examenes_psicologicos_model->usuarios_desaprobados2($key->id);
			}else{
				$examen = array();
			}
			
			foreach ($examen as $exx) {
				$get_cargo_postulacion = $this->Cargos_model->r_get($exx->cargo_postulacion_id);
				$get_lugar_trabajo = $this->Empresa_planta_model->get($exx->lugar_trabajo_id);

				$get_solicitante = $this->Usuarios_general_model->get($exx->solicitante_id);
				$nombre_s = isset($get_solicitante->nombres)?$get_solicitante->nombres:"";
				$paterno_s = isset($get_solicitante->paterno)?$get_solicitante->paterno:"";
				$materno_s = isset($get_solicitante->materno)?$get_solicitante->materno:"";

				$psicologo = $this->Usuarios_model->get_datos_psicologo_row($exx->psicologo_evaluador);
				$nombre_psi = isset($psicologo->nombres)?$psicologo->nombres:"";
				$ap_psi = isset($psicologo->paterno)?$psicologo->paterno:"";
				$am_psi = isset($psicologo->materno)?$psicologo->materno:"";
				$exx->nombrePsicologo = $nombre_psi." ".$ap_psi." ".$am_psi;

				if($exx->tecnico_supervisor == 1){
					$exx->tecnico_supervisor = "Tecnico";
				}elseif($exx->tecnico_supervisor == 2){
					$exx->tecnico_supervisor = "Supervisor";
				}else{
					$exx->tecnico_supervisor = "";
				}
				/*Especialidad*/
				$id_espec = isset($key->id_especialidad_trabajador)?$key->id_especialidad_trabajador:NULL;
				if($id_espec != NULL){
					$e1 = $this->Especialidadtrabajador_model->get($key->id_especialidad_trabajador);
					$especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
				}else
					$especialidad1 = false;

				$id_espec2 = isset($key->id_especialidad_trabajador_2)?$key->id_especialidad_trabajador_2:NULL;
				if($id_espec2 != NULL){
					$e2 = $this->Especialidadtrabajador_model->get($key->id_especialidad_trabajador_2);
					$especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower('/ '.$e2->desc_especialidad,'UTF-8')):FALSE;
				}else
					$especialidad2 = false;

				$id_espec3 = isset($key->id_especialidad_trabajador_3)?$key->id_especialidad_trabajador_3:NULL;
				if($id_espec3 != NULL){
					$e3 = $this->Especialidadtrabajador_model->get($key->id_especialidad_trabajador_3);
					$especialidad3 = (!empty($e3->desc_especialidad))?'/ '.$e3->desc_especialidad:FALSE;
				}else
					$especialidad3 = false;
				/*Fin Especialidad*/
				if($exx->referido == 1)
					$exx->referido = 'SI'; 
				elseif($exx->referido == 2)
					$exx->referido = 'NO'; 
				$id_ciudad = isset($key->id_ciudades)?$key->id_ciudades:'';
				$get_ciudad = $this->Ciudad_model->get($id_ciudad);
				$exx->residencia = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:"";

				$exx->nombreSolicitante = $nombre_s." ".$paterno_s." ".$materno_s;
				$exx->nombreCargo = isset($get_cargo_postulacion->nombre)?$get_cargo_postulacion->nombre:'';
				$exx->rutTrabajador= $key->rut_usuario;
				$exx->nombreTrabajador =$key->nombres." ".$key->paterno." ".$key->materno;
				$exx->fono = $key->fono;
				$exx->lugar_trabajo = $get_lugar_trabajo->nombre;
				$exx->nombrePsicologo = $nombre_psi." ".$ap_psi." ".$am_psi;
				$exx->especialidad = $especialidad1." ".$especialidad2." ".$especialidad3;
			}
			if ($examen) {
				array_push($usuarios, $examen);
			}
		}
		//var_dump($usuarios); 
		$enviar= false;
		foreach ($usuarios as $uu) {
			$enviar.='<tr><td>'.$uu[0]->rutTrabajador.'</td><td>'.$uu[0]->nombreTrabajador.'</td><td>'.$uu[0]->fono.'</td><td>'.$uu[0]->residencia.'</td><td>'.$uu[0]->referido.'</td><td>'.$uu[0]->lugar_trabajo.'</td><td>'.$uu[0]->nombreSolicitante.'</td><td>'.$uu[0]->nombrePsicologo.'</td><td>'.$uu[0]->especialidad.'</td><td>'.$uu[0]->nombreCargo.'</td><td>'.$uu[0]->tecnico_supervisor.'</td><td>'.$uu[0]->sueldo_definido.'</td><td>'.$uu[0]->resultado.'</td><td>'.$uu[0]->fecha_solicitud.'</td><td>'.$uu[0]->fecha_evaluacion.'</td><td>'.$uu[0]->fecha_vigencia.'</td><td>'.$uu[0]->observaciones.'</td><td><a href="'.base_url().'est/examen_psicologico/detalle/'.$uu[0]->id.'" target="_blank"><i style="color:green" class="fa fa-book" aria-hidden="true"></i></a></td></tr>';
		}
		echo ($enviar);
	}

	function detalle($id_examen){
		if(empty($id_examen)){
			redirect('est/examen_psicologico/index');
		}else{
			$this->load->model('Examenes_psicologicos_model');
			$this->load->model('Examenes_psicologicos_archivos_model');
			$this->load->model('Usuarios_model');
			$this->load->model('usuarios/Usuarios_general_model');
			$this->load->model('Ciudad_model');
			$this->load->model('Empresa_planta_model');
			$this->load->model('Cargos_model');
			$this->load->model('Especialidadtrabajador_model');

			$base = array(
				'head_titulo' => "Listado de Examen Psicologico - Sistema EST",
				'titulo' => "Examen Psicologicos",
				'subtitulo' => '',
				'side_bar' => true,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/examen_psicologico','txt'=>'Listado Examenes Psicologicos' ), array('url'=>'','txt'=>'Listado Examenes Psicologicos' )),
				'menu' => $this->menu,
				'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);

			$get_id_examen = $this->Examenes_psicologicos_model->get_result($id_examen);
			$listado = array();
			foreach ($get_id_examen as $l){
				$aux = new stdClass();
				$get_usuario = $this->Usuarios_model->get($l->usuario_id);
				$get_cargo_postulacion = $this->Cargos_model->r_get($l->cargo_postulacion_id);
				$get_lugar_trabajo = $this->Empresa_planta_model->get($l->lugar_trabajo_id);
				$get_solicitante = $this->Usuarios_general_model->get($l->solicitante_id);
				$get_psicologo_evaluador = $this->Usuarios_model->get_datos_psicologo_row($l->psicologo_evaluador);

				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:"";
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:"";
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:"";

				$nombre_usu = isset($get_usuario->nombres)?$get_usuario->nombres:"";
				$paterno_usu = isset($get_usuario->paterno)?$get_usuario->paterno:"";
				$materno_usu = isset($get_usuario->materno)?$get_usuario->materno:"";

				$nombre_psicologo = isset($get_psicologo_evaluador->nombres)?$get_psicologo_evaluador->nombres:"";
				$ap_psicologo = isset($get_psicologo_evaluador->paterno)?$get_psicologo_evaluador->paterno:"";
				$am_psicologo = isset($get_psicologo_evaluador->materno)?$get_psicologo_evaluador->materno:"";
				$aux->usuario_id = $l->usuario_id;
				$aux->nombres_usuario = $nombre_usu." ".$paterno_usu." ".$materno_usu;
				$aux->lugar_trabajo = isset($get_lugar_trabajo->nombre)?$get_lugar_trabajo->nombre:"";
				$aux->solicitante = $nombre_solicitante." ".$paterno_solicitante." ".$materno_solicitante;
				$aux->psicologo = $nombre_psicologo." ".$ap_psicologo." ".$am_psicologo;
				$aux->psicologo_id = isset($get_psicologo_evaluador->id)?$get_psicologo_evaluador->id:"";
				$aux->especialidad_post = isset($get_cargo_postulacion->nombre)?$get_cargo_postulacion->nombre:"";

				if($l->tecnico_supervisor == 1){
					$aux->tecnico_supervisor = "Tecnico";
				}elseif($l->tecnico_supervisor == 2){
					$aux->tecnico_supervisor = "Supervisor";
				}else{
					$aux->tecnico_supervisor = "";
				}

				$aux->sueldo_definido = isset($l->sueldo_definido)?$l->sueldo_definido:"0";
				$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
				$aux->fecha_evaluacion = isset($l->fecha_evaluacion)?$l->fecha_evaluacion:"";
				$aux->fecha_vigencia = isset($l->fecha_vigencia)?$l->fecha_vigencia:"0000-00-00";
				$aux->resultado = isset($l->resultado)?$l->resultado:"";
				$aux->referido = isset($l->referido)?$l->referido:"";
				$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";

				$get_archivo_informe = $this->Examenes_psicologicos_archivos_model->get_archivo_informe($id_examen);
				$aux->url_informe = isset($get_archivo_informe->id)?$get_archivo_informe->url:"NE";
				$aux->id_archivo_examen = isset($get_archivo_informe->id)?$get_archivo_informe->id:"0";

				$id_espec = isset($get_usuario->id_especialidad_trabajador)?$get_usuario->id_especialidad_trabajador:NULL;
				if($id_espec != NULL){
					$e1 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador);
					$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
				}else
					$aux->especialidad1 = false;

				$id_espec2 = isset($get_usuario->id_especialidad_trabajador_2)?$get_usuario->id_especialidad_trabajador_2:NULL;
				if($id_espec2 != NULL){
					$e2 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_2);
					$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
				}else
					$aux->especialidad2 = false;

				$id_espec3 = isset($get_usuario->id_especialidad_trabajador_3)?$get_usuario->id_especialidad_trabajador_3:NULL;
				if($id_espec3 != NULL){
					$e3 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_3);
					$aux->especialidad3 = (!empty($e3->desc_especialidad))?$e3->desc_especialidad:FALSE;
				}else
					$aux->especialidad3 = false;

				array_push($listado,$aux);
				unset($aux);
			}

			$pagina['soloParaMarina'] = true;
			$pagina['id_examen'] = $id_examen;
			$pagina['datos_examen'] = $listado;
			$pagina['psicologos'] = $this->Usuarios_model->listar_psicologos_activos();
			$pagina['existe_zulliger'] = $this->Examenes_psicologicos_archivos_model->get_existe_registro_examen_psicologico($id_examen, 2);
			$pagina['datos_zulliger'] = $this->Examenes_psicologicos_archivos_model->get_archivo_examen($id_examen, 2);
			//$pagina['existe_complemento'] = $this->Examenes_psicologicos_archivos_model->get_existe_registro_examen_psicologico_complemento($id_examen);
			$pagina['datos_complemento_kostick'] = $this->Examenes_psicologicos_archivos_model->get_archivo_examen_complemento_kostick($id_examen);
			$pagina['datos_complemento_western'] = $this->Examenes_psicologicos_archivos_model->get_archivo_examen_complemento_western($id_examen);
			$base['cuerpo'] = $this->load->view('examen_psicologico/listado_usuario',$pagina,TRUE);
			$this->load->view('layout2.0/layout',$base);
		}
	}

	function subir_informe_psicologico(){
		$this->load->model('Examenes_psicologicos_model');
		$this->load->model('Examenes_psicologicos_archivos_model');
		$this->load->helper("archivo");
		$id_examen = $_POST['id_examen'];
		$usuario_id = $_POST['usuario_id'];

		if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])){
			$fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];
		}else{
			$fecha_v = '0000-00-00';
		}

		if(isset($_POST['ano_e']) && isset($_POST['mes_e']) && isset($_POST['dia_e'])){
			$fecha_e = $_POST['ano_e'].'-'.$_POST['mes_e'].'-'.$_POST['dia_e'];
		}else{
			$fecha_e = '0000-00-00';
		}

		$datos_examen = array(
			'psicologo_evaluador' => $_POST['psicologo'],
			'fecha_evaluacion' => $fecha_e,
			'fecha_vigencia' => $fecha_v,
			'resultado' => $_POST['resultado'],
			'observaciones' => $_POST['observaciones'],
			'estado' => 1,
			'estado_ultimo_examen' => 1
		);

		$estado_cero = array('estado_ultimo_examen' => '0');
		$this->Examenes_psicologicos_model->actualizar_estado_ultimo_examen($usuario_id, $estado_cero);
		$this->Examenes_psicologicos_model->actualizar($id_examen, $datos_examen);

		if($_FILES['documento']['error'] == 0){
			$salida = subir($_FILES,"documento","extras/evaluaciones/");
			if($salida == 1)
				redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
			elseif($salida==2)
				redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
			else{

				$data = array(
					'examen_psicologico_id' => $id_examen,
					'tipo_examen_id' => 1,
					'url' => $salida
				);
				$existe_archivo_informe = $this->Examenes_psicologicos_archivos_model->get_existe_registro_examen_psicologico($id_examen, 1);
				if($existe_archivo_informe == 1){
					//actualizar
					$get_archivo_informe = $this->Examenes_psicologicos_archivos_model->get_archivo_informe($id_examen);
					$id_archivo_examen = isset($get_archivo_informe->id)?$get_archivo_informe->id:"0";
					$this->Examenes_psicologicos_archivos_model->actualizar($id_archivo_examen, $data);
				}else{
					//guardar
					$this->Examenes_psicologicos_archivos_model->guardar($data);
				}
			}
		}
		echo "<script>alert('Informe Examen Psicologico Ingresado Exitosamente')</script>";
		redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
	}

	function subir_prueba_zulling(){
		$this->load->model('Examenes_psicologicos_archivos_model');
		$this->load->helper("archivo");
		$id_examen = $_POST['id_examen'];

		if($_FILES['documento']['error'] == 0){
			$salida = subir($_FILES,"documento","extras/evaluaciones/");
			if($salida == 1)
				redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
			elseif($salida==2)
				redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
			else{
				$data = array(
					'examen_psicologico_id' => $id_examen,
					'tipo_examen_id' => 2,
					'url' => $salida
				);
				$this->Examenes_psicologicos_archivos_model->guardar($data);
			}
			echo "<script>alert('Examen Psicologico (Zulliger) Ingresado Exitosamente')</script>";
		}
		redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
	}

	function subir_prueba_complemento(){
		$this->load->model('Examenes_psicologicos_archivos_model');
		$this->load->helper("archivo");
		$id_examen = $_POST['id_examen'];

		if($_FILES['documento']['error'] == 0){
			$salida = subir($_FILES,"documento","extras/evaluaciones/");
			if($salida == 1)
				redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
			elseif($salida==2)
				redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
			else{
				$data = array(
					'examen_psicologico_id' => $id_examen,
					'tipo_examen_id' => $_POST['tipo_examen'],
					'url' => $salida
				);
				$this->Examenes_psicologicos_archivos_model->guardar($data);
			}
			echo "<script>alert('Examen Psicologico (Complemento) Ingresado Exitosamente')</script>";
		}
		redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
	}

	function actualizar_prueba_complemento(){
		$this->load->model('Examenes_psicologicos_archivos_model');
		$this->load->helper("archivo");
		$id_examen = $_POST['id_examen'];
		$id_registro_archivo = $_POST['id_registro_archivo'];

		if($_FILES['documento']['error'] == 0){
			$salida = subir($_FILES,"documento","extras/evaluaciones/");
			if($salida == 1)
				redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
			elseif($salida==2)
				redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
			else{
				$data = array(
					'examen_psicologico_id' => $id_examen,
					'tipo_examen_id' => $_POST['tipo_examen'],
					'url' => $salida
				);
				$this->Examenes_psicologicos_archivos_model->actualizar($id_registro_archivo, $data);
			}
		}else{
			$data2 = array(
				'examen_psicologico_id' => $id_examen,
				'tipo_examen_id' => $_POST['tipo_examen']
			);
			$this->Examenes_psicologicos_archivos_model->actualizar($id_registro_archivo, $data2);
		}
		echo "<script>alert('Examen Psicologico (Complemento) Ingresado Exitosamente')</script>";
		redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
	}

	function eliminar_archivo_examen($id_archivo_examen, $id_examen){
		$this->load->model('Examenes_psicologicos_archivos_model');
		$this->Examenes_psicologicos_archivos_model->eliminar($id_archivo_examen);
		echo "<script>alert('Archivo Examen Psicologico Eliminado Correctamente')</script>";
		redirect('/est/examen_psicologico/detalle/'.$id_examen.'', 'refresh');
	}

	function eliminar_examen($id_examen){
		$this->load->model('Examenes_psicologicos_model');
		$this->Examenes_psicologicos_model->eliminar_solicitud($id_examen);
		echo "<script>alert('Solicitud de Examen Psicologico Eliminado Exitosamente')</script>";
		redirect('/est/examen_psicologico/index', 'refresh');
	}

}
?>