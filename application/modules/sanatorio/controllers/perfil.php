<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Perfil extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 3)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 5)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 6)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_contabilidad','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 7)
			$this->menu = $this->load->view('layout2.0/menus/menu_mandante','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 9)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_solo_abastecimiento','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 12)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 13)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios_supervisor','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 14)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 15)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin_supervisor','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}
	
	function index($id = false){
		if (empty($id)) $id = $this->session->userdata('id');

		$this->load->model("Usuarios_general_model");
		$this->load->model("Usuarios_model");
		$this->load->model('Fotostrab_model');
		$this->load->model('Estadocivil_model');
		$this->load->model('Region_model');
		$this->load->model('Provincia_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Experiencia_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Profesiones_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Bancos_model');
		$this->load->model('Afp_model');
		$this->load->model('Salud_model');

		if ($this->session->userdata('subtipo') == 2)
			$usuario = $this->Usuarios_model->get($id);
		else
			$usuario = $this->Usuarios_general_model->get($id);
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Arauco S.A.',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Perfil' )),
			'menu' => $this->menu
		);

		$pagina['nombre'] = ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno.' '.$usuario->materno,'UTF-8'));
		$pagina['imagen'] = ($this->Fotostrab_model->get_usuario($id))? $this->Fotostrab_model->get_usuario($id)->media :'extras/layout2.0/img_perfil/default.jpg';
		$pagina['estadocivil'] = $this->Estadocivil_model->listar();
		$pagina['regiones'] = $this->Region_model->listar();
		$pagina['provincias'] = $this->Provincia_model->listar();
		$pagina['ciudades'] = $this->Ciudad_model->listar();
		$pagina['datos'] = $usuario;
		$pagina['meses'] = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$pagina['experiencia'] = $this->Experiencia_model->get_usuario($id);
		$pagina['nivel_estudios'] = $this->Nivelestudios_model->listar();
		$pagina['profesion'] = $this->Profesiones_model->listar();
		$pagina['especialidad1'] = $this->Especialidadtrabajador_model->listar();
		$pagina['bancos'] = $this->Bancos_model->listar();
		$pagina['afp'] = $this->Afp_model->listar();
		$pagina['salud'] = $this->Salud_model->listar();

		$base['cuerpo'] = $this->load->view('perfil/perfil',$pagina,TRUE);
		if ($this->session->userdata('subtipo') == 2)
			$this->load->view('layout2.0/layout_horizontal_menu',$base);
		else
			$this->load->view('layout2.0/layout',$base);
	}

	function contacto(){
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Empresa de Servicios Transitorios',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Contacto' )),
			'menu' => $this->menu
		);
		$pagina[''] = "";
		$base['cuerpo'] = $this->load->view('perfil/contacto',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function documentos(){
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Empresa de Servicios Transitorios',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Documentos' )),
			'menu' => $this->menu
		);
		$pagina[''] = "";
		$base['cuerpo'] = $this->load->view('perfil/documentos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function crear($msg = FALSE){
		$this->load->model("Usu_parentesco_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt' => 'Trabajadores'), array('url'=>'','txt'=>'Crear' )),
			//'js' => array('js/jquery.Rut.min.js'),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js'),
			'menu' => $this->menu
		);

		$this->load->model("Usuarios_categoria_model");
		
		if($msg == "error_vacio"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "Algunos datos estan vacios, favor enviar nuevamente";
		}
		if($msg == "error_pass"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = 'error!! las contraseñas no coinciden';
		}
		if($msg == "error_rut"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "El rut existe en nuestros sistemas";
		}
		if($msg == "error_email_valid"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "El email ingresado es invalido";
		}
		if($msg == "exito"){
			$base['alert_tipo'] = 'alert-success';
			$base['alert_contenido'] = "El usuario a sido guardado exitosamente";
		}

		$pagina['tipo'] = false;
		$pagina['cargo'] = false;
		if( $this->session->userdata('departamento') == 2 ){
			$this->load->model('Tipousuarios_model');

			$pagina['cargo'] = $this->Tipousuarios_model->get_categoria(3);
			$pagina['tipo'] = 3;
		}

		$pagina['lista_tipo'] = $this->Usuarios_categoria_model->listar();
		$pagina['lista_parentesco'] = $this->Usu_parentesco_model->listar();

		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->model("Usuarios_model");

			$data = array(
				'nombres' => trim($_POST['nombres']),
				'paterno' => trim($_POST['paterno']),
				'materno' => trim($_POST['materno']),
				'rut_usuario' => trim($_POST['rut']),
				'fono' => trim($_POST['fono1']).'-'.trim($_POST['fono2']),
				'email' => trim($_POST['email']),
				'clave' => hash("sha512", trim($_POST['password'])),
				'sexo' => $_POST['genero'],
				'fecha_creacion' => date('Y-m-d'),
				'chat' => $_POST['chat'],
				'estado' => 1,
				'aviso_cumple' => $_POST['cumple'],
				'id_tipo_usuarios' => $_POST['cargo'],
				'usuarios_categoria_id' => $_POST['tipo_usuario'],
				'emerg_nombre' => $_POST['emerg_nombre'],
				'emerg_telefono' => $_POST['emerg_telefono'],
				'emerg_parentesco_id' => $_POST['emerg_parentesco']
			);

			$pagina['texto_anterior'] = $this->session->flashdata('data');

			if(empty($_POST['nombres']) || empty($_POST['paterno']) || empty($_POST['rut'])
				|| empty($_POST['password']) || empty($_POST['password_again'])  ){
		 		redirect('est/usuarios/crear/error_vacio', 'refresh');
		 	}

			if($this->Usuarios_model->get_rut(mb_strtoupper($_POST['rut'], 'UTF-8')))
					redirect('usuarios/perfil/crear/error_rut', 'refresh');

			if($_POST['password'] != $_POST['password_again']){
				redirect('usuarios/perfil/crear/error_pass', 'refresh');
			}

			if(!empty($_POST['email'])){
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					redirect('usuarios/perfil/crear/error_email_valid', 'refresh');
				}
			}

			if(empty($_POST['select_nac_ano']) || empty($_POST['select_nac_mes']) || empty($_POST['select_nac_dia']) )
				$nacimiento = NULL;
			else $nacimiento = $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'];

			$data['fecha_nac'] = $nacimiento;

			$id_usr = $this->Usuarios_model->ingresar($data);

			if ( ($_POST['tipo_usuario'] == 3) && ( $_POST['cargo'] == 2) ){
				$this->load->model("Usuarios2_model");
		   		$this->Usuarios2_model->llenar_mongo_otro();
				redirect('usuarios/perfil/trabajador_est/'.$id_usr, 'refresh');
			}
		}

		$base['cuerpo'] = $this->load->view('perfil/crear',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function crear_mandante($msg = FALSE) {
		$this->load->model("Usu_parentesco_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/gestion_usuarios/mandantes','txt' => 'Usuarios Mandantes'), array('url'=>'','txt'=>'Crear' )),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js'),
			'menu' => $this->menu
		);
		$this->load->model("Usuarios_categoria_model");
		
		if($msg == "error_vacio"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "Algunos datos estan vacios, favor enviar nuevamente";
		}
		if($msg == "error_pass"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = 'error!! las contraseñas no coinciden';
		}
		if($msg == "error_rut"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "El rut existe en nuestros sistemas";
		}
		if($msg == "error_email_valid"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "El email ingresado es invalido";
		}
		if($msg == "exito"){
			$base['alert_tipo'] = 'alert-success';
			$base['alert_contenido'] = "El usuario a sido guardado exitosamente";
		}

		$pagina['tipo'] = false;
		$pagina['cargo'] = false;
		//$pagina['mensaje'] = "Usuario Registrado Exitosamente!!!";
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->model("Usuarios_general_model");

			$data = array(
				'nombres' => trim($_POST['nombres']),
				'paterno' => trim($_POST['paterno']),
				'materno' => trim($_POST['materno']),
				'rut_usuario' => trim($_POST['rut']),
				'fono' => trim($_POST['fono1']).'-'.trim($_POST['fono2']),
				'email' => trim($_POST['email']),
				'clave' => hash("sha512", trim($_POST['password'])),
				'sexo' => $_POST['genero'],
				'activo' => '1',
				'chat' => '0',
				'aviso_cumple' => '0',
			);

			$pagina['texto_anterior'] = $this->session->flashdata('data');

			if(empty($_POST['nombres']) || empty($_POST['paterno']) || empty($_POST['rut']) || empty($_POST['password']) || empty($_POST['password_again'])  ){
		 		redirect('est/usuarios/crear_mandante/error_vacio', 'refresh');
		 	}

			if($this->Usuarios_general_model->get_rut(mb_strtoupper($_POST['rut'], 'UTF-8')))
					redirect('usuarios/perfil/crear_mandante/error_rut', 'refresh');

			if($_POST['password'] != $_POST['password_again']){
				redirect('usuarios/perfil/crear_mandante/error_pass', 'refresh');
			}

			if(!empty($_POST['email'])){
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					redirect('usuarios/perfil/crear_mandante/error_email_valid', 'refresh');
				}
			}

			if(empty($_POST['select_nac_ano']) || empty($_POST['select_nac_mes']) || empty($_POST['select_nac_dia']) )
				$nacimiento = NULL;
			else $nacimiento = $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'];
			$data['fecha_nac'] = $nacimiento;
			$id_usr = $this->Usuarios_general_model->ingresar($data);

			$datos_cargo = array(
				'usuarios_id' => $id_usr,
				'cargos_id' => '2',
				'centro_costo_id' => '7',
				'departamento_id' => '9',
				'sucursales_id' => '11',
				'tipo_usuario_id' => '7'
			);
			$this->Usuarios_general_model->ingresar_cargos($datos_cargo);
			redirect('usuarios/perfil/crear_mandante/exito', 'refresh');
		}
		$base['cuerpo'] = $this->load->view('perfil/crear_mandante',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function eliminar($id){
		$this->Requerimiento_model->r_eliminar($id);
		redirect(base_url().'est/requerimiento/listado', 'refresh');
	}

	function crear_est_externo($msg = FALSE) {
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/gestion_usuarios/est_externo','txt' => 'Usuarios EST EXTERNOS'), array('url'=>'','txt'=>'Crear' )),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js'),
			'menu' => $this->menu
		);
		$this->load->model("Usuarios_categoria_model");
		
		if($msg == "error_vacio"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "Algunos datos estan vacios, favor enviar nuevamente";
		}
		if($msg == "error_pass"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = 'error!! las contraseñas no coinciden';
		}
		if($msg == "error_rut"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "El rut existe en nuestros sistemas";
		}
		if($msg == "error_email_valid"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "El email ingresado es invalido";
		}
		if($msg == "exito"){
			$base['alert_tipo'] = 'alert-success';
			$base['alert_contenido'] = "El usuario a sido guardado exitosamente";
		}

		$pagina['tipo'] = false;
		$pagina['cargo'] = false;
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->model("Usuarios_general_model");

			$data = array(
				'nombres' => trim($_POST['nombres']),
				'paterno' => trim($_POST['paterno']),
				'materno' => trim($_POST['materno']),
				'rut_usuario' => trim($_POST['rut']),
				'fono' => trim($_POST['fono1']).'-'.trim($_POST['fono2']),
				'email' => trim($_POST['email']),
				'clave' => hash("sha512", trim($_POST['password'])),
				'sexo' => $_POST['genero'],
				'activo' => '1',
				'chat' => '0',
				'aviso_cumple' => '0',
			);

			$pagina['texto_anterior'] = $this->session->flashdata('data');

			if(empty($_POST['nombres']) || empty($_POST['paterno']) || empty($_POST['rut']) || empty($_POST['password']) || empty($_POST['password_again'])  ){
		 		redirect('est/usuarios/crear_est_externo/error_vacio', 'refresh');
		 	}

			if($this->Usuarios_general_model->get_rut(mb_strtoupper($_POST['rut'], 'UTF-8')))
					redirect('usuarios/perfil/crear_est_externo/error_rut', 'refresh');

			if($_POST['password'] != $_POST['password_again']){
				redirect('usuarios/perfil/crear_est_externo/error_pass', 'refresh');
			}

			if(!empty($_POST['email'])){
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					redirect('usuarios/perfil/crear_est_externo/error_email_valid', 'refresh');
				}
			}

			if(empty($_POST['select_nac_ano']) || empty($_POST['select_nac_mes']) || empty($_POST['select_nac_dia']) )
				$nacimiento = NULL;
			else $nacimiento = $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'];
			$data['fecha_nac'] = $nacimiento;
			$id_usr = $this->Usuarios_general_model->ingresar($data);

			$datos_cargo = array(
				'usuarios_id' => $id_usr,
				'cargos_id' => '9',
				'centro_costo_id' => '7',
				'departamento_id' => '2',
				'sucursales_id' => '11',
				'tipo_usuario_id' => '4',
			);
			$this->Usuarios_general_model->ingresar_cargos($datos_cargo);
			redirect('usuarios/perfil/crear_est_externo/exito', 'refresh');
		}

		$base['cuerpo'] = $this->load->view('perfil/crear_est_externo',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function rut_existe(){
		$this->load->model("Usuarios2_model");
		if ( $_POST['rut'] ){
			if($this->Usuarios2_model->get_rut($_POST['rut'])){
				$salida = "si";
			}
			else $salida = "no";
		}
		else $salida = "vacio";

		echo $salida;
	}

	function tipo_usuario(){
		$this->load->model('Tipousuarios_model');
		if($_POST['id']){
			echo json_encode($this->Tipousuarios_model->get_categoria($_POST['id']));
		}
	}

	function trabajador_est($id, $id_evaluacion = FALSE){
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Bancos_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("Usu_parentesco_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Experiencia_model");
		$this->load->model("Evaluaciones_model");
		//Masso
		$this->load->model('Evaluacionestipo_model');
		$this->load->model('Evaluacionesbaterias_model');
		$this->load->model('Evaluacionesevaluacion_model');

		$base = array(
			'head_titulo' => "Sistema EST - Datos Trabajador",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt'=>'Trabajadores EST' ), array('url'=>'','txt'=>'Datos Trabajadores' )),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

		$pagina['datos_usuario'] = $this->Usuarios_model->get($id);
		$pagina['lista_archivos'] = $this->Tipoarchivos_model->listar();
		$pagina['lista_archivos_subidos'] = $this->Archivos_trab_model->get_usuario($id);
		$pagina['lista_civil'] = $this->Estadocivil_model->listar();
		$pagina['lista_region'] = $this->Region_model->listar();
		$pagina['lista_provincia'] = $this->Provincia_model->listar_region($pagina['datos_usuario']->id_regiones);
		$pagina['lista_ciudad'] = $this->Ciudad_model->listar_region($pagina['datos_usuario']->id_regiones);
		$pagina['lista_bancos'] = $this->Bancos_model->listar();
		$pagina['lista_afp'] = $this->Afp_model->listar();
		$pagina['lista_salud'] = $this->Salud_model->listar();
		$pagina['lista_estudios'] = $this->Nivelestudios_model->listar();
		$pagina['lista_parentesco'] = $this->Usu_parentesco_model->listar();
		$pagina['lista_profesiones'] = $this->Profesiones_model->listar();
		$pagina['lista_especialidades'] = $this->Especialidadtrabajador_model->listar();
		$pagina['lista_experiencia'] = $this->Experiencia_model->get_usuario($id);
		$pagina['id_usuario'] = $id;
		$pagina['id'] = $id;
		$usr = $this->Usuarios_model->get($id);
		$eval = $this->Evaluaciones_model->get_all($id);
		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$pagina['listado'] = $eval;
		$pagina['exam_conocimientos'] = $this->Evaluaciones_model->get_all_tipo(3);
		$pagina['exam_desempeno'] = $this->Evaluaciones_model->get_all_tipo(1);
		$base['cuerpo'] = $this->load->view('perfil/trabajador_est',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_editar_desempeno($id_examen, $id_usu){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesarchivo_model");
		$lista = array();
		foreach ($this->Evaluaciones_model->get_eval_id($id_examen) as $l){
			$aux = new stdClass();

			$f = explode("-", $l->fecha_e);
			$fecha_eval_a = $f[0];
			$fecha_eval_m = $f[1];
			$fecha_eval_d = $f[2];

			$f2 = explode("-", $l->fecha_v);
			$fecha_vig_a = $f2[0];
			$fecha_vig_m = $f2[1];
			$fecha_vig_d = $f2[2];

			$aux->id_eval = $id_examen;
			$aux->id_tipo_eval = $l->id_evaluacion;
			$get_archivo = $this->Evaluacionesarchivo_model->get($id_examen);
			$aux->url_archivo = (isset($get_archivo->url)?$get_archivo->url:"");
			$aux->fecha_eval_d = $fecha_eval_d;
			$aux->fecha_eval_m = $fecha_eval_m;
			$aux->fecha_eval_a = $fecha_eval_a;
			$aux->fecha_vig_d = $fecha_vig_d;
			$aux->fecha_vig_m = $fecha_vig_m;
			$aux->fecha_vig_a = $fecha_vig_a;
			$aux->resultado = (isset($l->resultado)?$l->resultado:"");
			$aux->observaciones = (isset($l->observaciones)?$l->observaciones:"");
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['lista_aux'] = $lista;
		$pagina['id_usu'] = $id_usu;
		$pagina['exam_desempeno'] = $this->Evaluaciones_model->get_all_tipo(1);
		$this->load->view('usuarios/perfil/modal_editar_desempenos', $pagina);
	}

	function modal_editar_conocimiento($id_examen, $id_usu){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesarchivo_model");
		$lista = array();
		foreach ($this->Evaluaciones_model->get_eval_id($id_examen) as $l){
			$aux = new stdClass();

			$f = explode("-", $l->fecha_e);
			$fecha_eval_a = $f[0];
			$fecha_eval_m = $f[1];
			$fecha_eval_d = $f[2];

			$f2 = explode("-", $l->fecha_v);
			$fecha_vig_a = $f2[0];
			$fecha_vig_m = $f2[1];
			$fecha_vig_d = $f2[2];

			$aux->id_eval = $id_examen;
			$aux->id_tipo_eval = $l->id_evaluacion;
			$get_archivo = $this->Evaluacionesarchivo_model->get($id_examen);
			$aux->url_archivo = (isset($get_archivo->url)?$get_archivo->url:"");
			$aux->fecha_eval_d = $fecha_eval_d;
			$aux->fecha_eval_m = $fecha_eval_m;
			$aux->fecha_eval_a = $fecha_eval_a;
			$aux->fecha_vig_d = $fecha_vig_d;
			$aux->fecha_vig_m = $fecha_vig_m;
			$aux->fecha_vig_a = $fecha_vig_a;
			$aux->resultado = (isset($l->resultado)?$l->resultado:"");
			$aux->observaciones = (isset($l->observaciones)?$l->observaciones:"");
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['lista_aux'] = $lista;
		$pagina['id_usu'] = $id_usu;
		$pagina['exam_conocimientos'] = $this->Evaluaciones_model->get_all_tipo(3);
		$this->load->view('usuarios/perfil/modal_editar_conocimientos', $pagina);
	}

	function modificar_exam_conocimientos_desempeno(){
		$this->load->model('Evaluaciones_model');
		$this->load->model('Evaluacionesarchivo_model');
		$this->load->helper("archivo");
		$id_eval = $_POST['id_eval'];
		$id_usu = $_POST['id_usu'];
		$fecha_e = $_POST['fecha_eval_a']."-".$_POST['fecha_eval_m']."-".$_POST['fecha_eval_d'];
		$fecha_v = $_POST['fecha_vig_a']."-".$_POST['fecha_vig_m']."-".$_POST['fecha_vig_d'];

		if($_FILES['documento']['error'] == 0){
			$salida = subir($_FILES,"documento","extras/evaluaciones/");

			$datos = array(
				'id_evaluacion' => $_POST['id_tipo_eval'],
				'fecha_e' => $fecha_e,
				'fecha_v' => $fecha_v,
				'resultado' => $_POST['resultado'],
				'observaciones' => $_POST['observacion'],
			);
			$this->Evaluaciones_model->editar($id_eval, $datos);

			$archivo_eval = array(
				'url' => $salida,
			);
			$this->Evaluacionesarchivo_model->editar($id_eval, $archivo_eval);
		}else{
			$datos = array(
				//'id' => $ultimo_id,
				'id_evaluacion' => $_POST['id_tipo_eval'],
				'fecha_e' => $fecha_e,
				'fecha_v' => $fecha_v,
				'resultado' => $_POST['resultado'],
				'observaciones' => $_POST['observacion'],
			);
			$this->Evaluaciones_model->editar($id_eval, $datos);
		}

		echo "<script>alert('Examen Modificado Exitosamente')</script>";
		redirect('usuarios/perfil/trabajador_est/'.$id_usu.'', 'refresh');
	}

	function guardar_exam_conocimientos(){
		$this->load->model('Evaluaciones_model');
		$this->load->model('Evaluacionesarchivo_model');
		$this->load->helper("archivo");
		$id_usu = $_POST['id_usuario'];
		$fecha_e = $_POST['fecha_eval_a']."-".$_POST['fecha_eval_m']."-".$_POST['fecha_eval_d'];
		$fecha_v = $_POST['fecha_vig_a']."-".$_POST['fecha_vig_m']."-".$_POST['fecha_vig_d'];
		$ultimo_id =$this->Evaluaciones_model->ultimo_id_eval();

		$datos = array(
			'id' => $ultimo_id,
			'id_usuarios' => $id_usu,
			'id_evaluacion' => $_POST['id_tipo_eval'],
			'fecha_e' => $fecha_e,
			'fecha_v' => $fecha_v,
			'resultado' => $_POST['resultado'],
			'observaciones' => $_POST['observacion'],
			'estado_ultima_evaluacion' => 1,
		);

		$this->Evaluaciones_model->actualizar_estado_ultimo_ex_conocimiento($id_usu);
		$this->Evaluaciones_model->ingresar($datos);
		//$ultimo_id = $this->db->insert_id();

		if($_FILES['documento']['error'] == 0){
			$salida = subir($_FILES,"documento","extras/evaluaciones/");
		}else{
			$salida = "";
		}

		$datos_archivo = array(
			'id_evaluacion' => $ultimo_id,
			'url' => $salida
		);
		$this->Evaluacionesarchivo_model->ingresar($datos_archivo);
		echo "<script>alert('Examen Ingresado Exitosamente')</script>";
		redirect('usuarios/perfil/trabajador_est/'.$id_usu.'', 'refresh');
	}

	function guardar_exam_desempeno(){
		$this->load->model('Evaluaciones_model');
		$this->load->model('Evaluacionesarchivo_model');
		$this->load->helper("archivo");
		$id_usu = $_POST['id_usuario'];
		$fecha_e = $_POST['fecha_eval_a']."-".$_POST['fecha_eval_m']."-".$_POST['fecha_eval_d'];
		$fecha_v = $_POST['fecha_vig_a']."-".$_POST['fecha_vig_m']."-".$_POST['fecha_vig_d'];

		$datos = array(
			'id_usuarios' => $id_usu,
			'id_evaluacion' => $_POST['id_tipo_eval'],
			'fecha_e' => $fecha_e,
			'fecha_v' => $fecha_v,
			'resultado' => $_POST['resultado'],
			'observaciones' => $_POST['observacion'],
		);
		$this->Evaluaciones_model->ingresar($datos);
		$ultimo_id = $this->db->insert_id();

		if($_FILES['documento']['error'] == 0){
			$salida = subir($_FILES,"documento","extras/evaluaciones/");
		}else{
			$salida = "";
		}

		$datos_archivo = array(
			'id_evaluacion' => $ultimo_id,
			'url' => $salida
		);
		$this->Evaluacionesarchivo_model->ingresar($datos_archivo);
		echo "<script>alert('Examen Ingresado Exitosamente')</script>";
		redirect('usuarios/perfil/trabajador_est/'.$id_usu.'', 'refresh');
	}

	function crear_examen($id,$id_evaluacion=FALSE){
		$this->load->model("Cargos_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Evaluacionesbaterias_model");
		$this->load->model("Evaluacionescargos_model");
		$usr = $this->Usuarios_model->get($id);
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'usuarios/perfil/trabajador_est/'.$id.'','txt'=>'Datos Trabajador '.$usr->nombres.'' ), array('url'=>'','txt'=>'Agregar Examen Preocupacional' )),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js', 'js/examen_preo_masso.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

		if( $usr->fecha_nac ){
			$fecha_cumple = time() - strtotime($usr->fecha_nac);
			$edad = floor((($fecha_cumple / 3600) / 24) / 360);
			$pagina['edad'] = $edad.' Años';
		}
		else
			$pagina['edad'] = "No esta ingresada la fecha de nacimiento";

		$cargos_aptos = $this->Cargos_model->r_listar();
		$lista_aux = array();
		if (!empty($cargos_aptos)){
			foreach ($cargos_aptos as $cga){
				$aux = new stdClass();
				$aux->id_r_cargo = $cga->id;
				$aux->nombre_r_cargo = $cga->nombre;

				$get_estado = $this->Evaluacionescargos_model->get($cga->id, $id_evaluacion);
				$aux->estado = isset($get_estado->id)?'1':'0';
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$pagina['id'] = $id;
		$pagina['rut'] = $usr->rut_usuario;
		$pagina['tipo'] = $this->Evaluacionestipo_model->listar();
		$pagina['eval'] = ( $id_evaluacion )? $this->Evaluaciones_model->get($id_evaluacion) : false;
		$pagina['bat'] = ( $id_evaluacion )? $this->Evaluacionesbaterias_model->get_eval($id_evaluacion) : false;
		$pagina['empresa_planta'] = $this->Empresa_planta_model->listar();
		$pagina['evaluaciones'] = $this->Evaluacionesevaluacion_model->get_tipo(2);
		$pagina['r_cargos'] = $lista_aux;
		$base['cuerpo'] = $this->load->view('usuarios/perfil/crear_examen',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function crear_masso($id,$id_evaluacion=FALSE){
		$this->load->model("Empresa_planta_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Evaluacionesevaluacion_model");

		$usr = $this->Usuarios_model->get($id);
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'usuarios/perfil/trabajador_est/'.$id.'','txt'=>'Datos Trabajador '.$usr->nombres.'' ), array('url'=>'','txt'=>'Agregar Masso' )),
			'js' => array('js/jquery.Rut.min.js','js/usuarios.js', 'js/examen_preo_masso.js', 'js/confirm.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			'menu' => $this->menu
		);

		if( $usr->fecha_nac ){
			$fecha_cumple = time() - strtotime($usr->fecha_nac);
			$edad = floor((($fecha_cumple / 3600) / 24) / 360);
			$pagina['edad'] = $edad;
		}
		else
			$pagina['edad'] = "No esta ingresada la fecha de nacimiento";
		

		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$pagina['id'] = $id;
		$pagina['rut'] = $usr->rut_usuario;
		$pagina['tipo'] = $this->Evaluacionestipo_model->listar();
		$pagina['evaluaciones'] = $this->Evaluacionesevaluacion_model->get_tipo(4);
		$pagina['empresa_planta'] = $this->Empresa_planta_model->listar();
		$pagina['eval'] = ($id_evaluacion)?$this->Evaluaciones_model->get($id_evaluacion):false;
		$base['cuerpo'] = $this->load->view('usuarios/perfil/crear_masso',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function eliminar_examen($id_usr, $id_evalua=FALSE){
		$this->load->model('Evaluaciones_model');
		$this->Evaluaciones_model->eliminar($id_evalua);
		redirect('usuarios/perfil/trabajador_est/'.$id_usr.'#datos-personales', 'refresh');	
	}

	function guardar_creacion_eval($id_usr, $id_evalua=FALSE){
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesarchivo_model");
		$this->load->model("Evaluacionesbaterias_model");
		$this->load->model("Evaluacionescargos_model");
		$this->load->helper("archivo");

		if(empty($id_usr)){
			redirect('usuarios/perfil/trabajador_est/'.$id_usr.'#datos-examenes', 'refresh');
		}

		$id_evaluacion = $_POST['id_ee'];
		$fecha_e = $_POST['ano_e'].'-'.$_POST['mes_e'].'-'.$_POST['dia_e'];
		if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])){
		$fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];}
		else {$fecha_v = '0000-00-00';}

		$ultimo_id =$this->Evaluaciones_model->ultimo_id_eval();

		if(isset($_POST['resultado_cualitativo'])){
			$get_resultado = $_POST['resultado_cualitativo'];
			if($get_resultado == 0 or $get_resultado == 1){
				$resultado = $_POST['resultado_cualitativo'];
			}else{
				$resultado = 2;
			}

			if($get_resultado == 2){
				$asiste_examen = 0;
			}elseif($get_resultado == 0 or $get_resultado == 1){
				$asiste_examen = 1;
			}else{
				$asiste_examen = NULL;
			}
		}else{
			$resultado = 2;
			$asiste_examen = 0;
		}

		if($_POST['id_ee'] == 4){
			$arr = array(
				'id_usuarios' => $id_usr,
				'id_evaluacion' => $_POST['id_ee'],
				'observaciones' => trim( mb_strtoupper($_POST['obs'], 'UTF-8')),
				'resultado' => $resultado,
				'recomienda' => ( !empty($_POST['recomienda']))?$_POST['recomienda']:'NULL',
				'fecha_e' => $fecha_e,
				'fecha_v' => $fecha_v,
				'pago' => $_POST['pago'],
				'valor_examen' => (!empty($_POST['valor_examen']))?$_POST['valor_examen']:'0',
				'indice_ganancia' => (!empty($_POST['indice_ganancia']))?$_POST['indice_ganancia']:'0',
				'oc' => (!empty($_POST['oc']))?$_POST['oc']:'NULL',
				'ccosto' => (!empty($_POST['ccosto']))?$_POST['ccosto']:'NULL',
				'ciudadch' =>  (!empty($_POST['ciudadch']))?$_POST['ciudadch']:'NULL',
				'examen_referido' =>  (!empty($_POST['referido']))?$_POST['referido']:'0',
				'asistencia_examen' =>  $asiste_examen
			);
		}else{
			$arr = array(
				'id_usuarios' => $id_usr,
				'id_evaluacion' => $_POST['id_ee'],
				'observaciones' => trim( mb_strtoupper($_POST['obs'], 'UTF-8')),
				'resultado' => $resultado,
				'recomienda' => ( !empty($_POST['recomienda']))?$_POST['recomienda']:'NULL',
				'valor_examen' => (!empty($_POST['valor_examen']))?$_POST['valor_examen']:'0',
				'indice_ganancia' => (!empty($_POST['indice_ganancia']))?$_POST['indice_ganancia']:'0',
				'ccosto' => (!empty($_POST['ccosto']))?$_POST['ccosto']:'NULL',
				'fecha_e' => $fecha_e,
				'fecha_v' => $fecha_v,
				'pago' => $_POST['pago'],
				'examen_referido' =>  (!empty($_POST['referido']))?$_POST['referido']:'0',
				'asistencia_examen' =>  $asiste_examen
			);
		}

		if($id_evalua){
			$id_eval = $id_evalua;
			$this->Evaluaciones_model->editar($id_evalua,$arr);
		}else{
			$get_ultimo_id = array('id' => $ultimo_id);
			$get_arr = array_merge($arr, $get_ultimo_id);
			$this->Evaluaciones_model->ingresar($get_arr);
			$id_eval = $ultimo_id;
		}

		if($_FILES['docu']['error'] == 0){
			$salida = subir($_FILES,"docu","extras/evaluaciones/");
			if($salida == 1)
				redirect('usuarios/perfil/trabajador_est/'.$id_usr.'#datos-examenes', 'refresh');
				//redirect('/est/trabajadores/buscar_js', 'refresh');
			elseif($salida==2)
				redirect('usuarios/perfil/trabajador_est/'.$id_usr.'#datos-examenes', 'refresh');
				//redirect('est/trabajadores/buscar_js', 'refresh');
			else{
				$data = array(
					'id_evaluacion' => $id_eval,
					'url' => $salida
				);
				$this->Evaluacionesarchivo_model->ingresar($data);
			}
		}

		if($_POST['id_ee'] == 3){
			if( $id_evalua )
				$this->Evaluacionesbaterias_model->eliminar_eval($id_evalua);

			$baterias = (isset($_POST['baterias'])?"1":"0");

			if($baterias == 1){
				foreach ($_POST['baterias'] as $b) {
					$dat = array(
						'evaluaciones_id' => $id_eval,
						'nombre' => $b
					);

					$this->Evaluacionesbaterias_model->ingresar($dat);
				}
			}

			if( $id_evalua )
				$this->Evaluacionescargos_model->eliminar_eval($id_evalua);

			$cargos_aptos = (isset($_POST['cargos_aptos'])?"1":"0");

			if($cargos_aptos == 1){
				foreach ($_POST['cargos_aptos'] as $cg){
					$cargos = array(
						'id_evaluacion' => $id_eval,
						'id_r_cargo' => $cg
					);

					$this->Evaluacionescargos_model->ingresar($cargos);
				}
			}
		}

		$get_cantidad = $this->Usuarios_model->contar_evaluaciones_user($id_usr, $_POST['id_ee']);
		$total_examenes = isset($get_cantidad->total)?$get_cantidad->total:0;
		if($total_examenes >= 1){
			$get_ultimo = $this->Usuarios_model->id_maximo_examenes_user($id_usr, $_POST['id_ee']);
			$this->Usuarios_model->actualizar_desactivo_estado_preo($id_usr, $_POST['id_ee']);
			$this->Usuarios_model->actualizar_activo_estado_preo($get_ultimo->ultimo);
		}
		redirect('usuarios/perfil/trabajador_est/'.$id_usr.'#datos-examenes', 'refresh');
	}

	function guardar_datos_perfil_general(){
		$this->load->model("Usuarios_general_model");
		$id_usuario = $_POST['id'];

		if(empty($_POST['nac_ano']) || empty($_POST['nac_mes']) || empty($_POST['nac_dia']) )
			$nacimiento = NULL;
		else $nacimiento = $_POST['nac_ano'].'-'.$_POST['nac_mes'].'-'.$_POST['nac_dia'];

		if( !empty($_POST['fono1']) && !empty($_POST['fono2']) ) 
			$fono1 = $_POST['fono1'].'-'.$_POST['fono2'];
		else $fono1 = NULL;

		$data = array(
			"nombres" => $_POST['nombres'],
			"paterno" => $_POST['paterno'],
			'materno' => $_POST['materno'],
			'email' => $_POST['email'],
			'fono' => $fono1,
			'fecha_nac' => $nacimiento,
			'sexo' => $_POST['select_sexo'],
			'estadocivil_id' => $_POST['select_civil'],
			'nacionalidad' => $_POST['select_nacionalidad']
		);

		$this->Usuarios_general_model->editar_general($id_usuario,$data);
		redirect('usuarios/perfil/index', 'refresh');
	}

	function guardar_personales(){
		$this->load->model("Usuarios_model");

		$id_usuario = $_POST['id'];

		if( empty($_POST['select_region']) || empty($_POST['select_provincia']) || empty($_POST['select_ciudad']) || empty($_POST['select_civil']) || 
			empty($_POST['select_nacionalidad']) || empty($_POST['nombres']) || empty($_POST['paterno']))
			redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#datos-personales', 'refresh');

		if(empty($_POST['nac_ano']) || empty($_POST['nac_mes']) || empty($_POST['nac_dia']) )
			$nacimiento = NULL;
		else $nacimiento = $_POST['nac_ano'].'-'.$_POST['nac_mes'].'-'.$_POST['nac_dia'];

		if( !empty($_POST['fono1']) && !empty($_POST['fono2']) ) 
			$fono1 = $_POST['fono1'].'-'.$_POST['fono2'];
		else $fono1 = NULL;

		if( !empty($_POST['fono3']) && !empty($_POST['fono4']) ) 
			$fono2 = $_POST['fono3'].'-'.$_POST['fono4'];
		else $fono2 = NULL;

		if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('id') == 14){
			$data = array(
				"rut_usuario" => $_POST['rut'],
				"nombres" => $_POST['nombres'],
				"paterno" => $_POST['paterno'],
				'materno' => $_POST['materno'],
				'fecha_nac' => $nacimiento,
				'id_regiones' => $_POST['select_region'],
				'id_provincias' => $_POST['select_provincia'],
				'id_ciudades' => $_POST['select_ciudad'],
				'direccion' => $_POST['direccion'],
				'sexo' => $_POST['select_sexo'],
				'email' => $_POST['email'],
				'fono' => $fono1,
				'telefono2' => $fono2,
				'id_estadocivil' => $_POST['select_civil'],
				'nacionalidad' => $_POST['select_nacionalidad']
			);
		}else{
			$data = array(
				"nombres" => $_POST['nombres'],
				"paterno" => $_POST['paterno'],
				'materno' => $_POST['materno'],
				'fecha_nac' => $nacimiento,
				'id_regiones' => $_POST['select_region'],
				'id_provincias' => $_POST['select_provincia'],
				'id_ciudades' => $_POST['select_ciudad'],
				'direccion' => $_POST['direccion'],
				'sexo' => $_POST['select_sexo'],
				'email' => $_POST['email'],
				'fono' => $fono1,
				'telefono2' => $fono2,
				'id_estadocivil' => $_POST['select_civil'],
				'nacionalidad' => $_POST['select_nacionalidad']
			);
		}
		$this->Usuarios_model->editar($id_usuario,$data);
		//if ( $_FILES['imagen'] )
		//$this->guardar_imagen($id_usuario, $_FILES['imagen']  );
		
		if ($this->session->userdata('subtipo') == 2){
			redirect('usuarios/perfil/index', 'refresh');
		}else{
			redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#datos-personales', 'refresh');
		}
	}

	function guardar_datos_de_emergencia(){
		$this->load->model("Usuarios_model");

		$id_usuario = $_POST['id'];
		$data = array(
			'emerg_nombre' => ($_POST['nombres_emergencia'])?$_POST['nombres_emergencia']:NULL,
			'emerg_telefono' => ($_POST['fono_emergencia'])?$_POST['fono_emergencia']:NULL,
			'emerg_parentesco_id' => ($_POST['emerg_parentesco'])?$_POST['emerg_parentesco']:NULL,
		);

		$this->Usuarios_model->editar($id_usuario,$data);
		if ($this->session->userdata('subtipo') == 2)
			redirect('usuarios/perfil/index', 'refresh');
		else
			redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#contacto-emergencia', 'refresh');

	}

	function guardar_experiencia(){
		$this->load->model("Experiencia_model");
		$id_usuario = $_POST['id_usuario'];
		$datos = array(
			'id_usuarios' => $id_usuario,
			'desde' => ($_POST['desde'])?$_POST['desde']:NULL,
			'hasta' => ($_POST['hasta'])?$_POST['hasta']:NULL,
			'cargo' => ($_POST['cargo'])?$_POST['cargo']:NULL,
			'area' => ($_POST['area'])?$_POST['area']:NULL,
			'empresa_c' => ($_POST['empresa_c'])?$_POST['empresa_c']:NULL,
			'empresa_m' => ($_POST['empresa_m'])?$_POST['empresa_m']:NULL,
			'funciones' => ($_POST['funciones'])?$_POST['funciones']:NULL,
			'referencias' => ($_POST['referencias'])?$_POST['referencias']:NULL,
		);

		$this->Experiencia_model->ingresar($datos);
		echo "<script>alert('Experiencia Ingresada Exitosamente')</script>";
		redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#datos-experiencia', 'refresh');
	}

	function guardar_tecnicos(){
		$this->load->model("Usuarios_model");
		$id_usuario = $_POST['id'];
		$data = array(
			'id_estudios' => ($_POST['select_estudios'])?$_POST['select_estudios']:NULL,
			'institucion' => ($_POST['institucion'])?$_POST['institucion']:NULL,
			'ano_egreso' => ($_POST['ano_egreso'])?$_POST['ano_egreso']:NULL,
			'id_profesiones' => ($_POST['select_profesiones'])?$_POST['select_profesiones']:NULL,
			'id_especialidad_trabajador' => ($_POST['select_especialidad1'])?$_POST['select_especialidad1']:NULL,
			'id_especialidad_trabajador_2' => ($_POST['select_especialidad2'])?$_POST['select_especialidad2']:NULL,
			'ano_experiencia' => ($_POST['anos_experiencia'])?$_POST['anos_experiencia']:NULL,
			'cursos' => ($_POST['cursos'])?$_POST['cursos']:NULL,
			'equipos' => ($_POST['equipos'])?$_POST['equipos']:NULL,
			'software' => ($_POST['software']) ?$_POST['software']:NULL,
			'idiomas' => ($_POST['idiomas'])?$_POST['idiomas']:NULL,
			//'id_bancos' => ($_POST['select_bancos'])?$_POST['select_bancos']:NULL,
			//'tipo_cuenta' => ($_POST['tipo_cuenta'])?$_POST['tipo_cuenta']:NULL,
			//'cuenta_banco' => ($_POST['n_cuenta'])?$_POST['n_cuenta']:NULL,
			//'id_afp' => ($_POST['select_afp'])?$_POST['select_afp']:NULL,
			//'id_salud' => ($_POST['select_salud'])?$_POST['select_salud']:NULL,
			//'licencia' => ($_POST['licencia'])?$_POST['licencia']:NULL,
			//'num_zapato' => ($_POST['n_zapato'])?$_POST['n_zapato']:NULL,
			//'talla_buzo' => ($_POST['talla_buzo'])?$_POST['talla_buzo']:NULL
		);

		$this->Usuarios_model->editar($id_usuario,$data);
		if ($this->session->userdata('subtipo') == 2)
			redirect('usuarios/perfil/index', 'refresh');
		else
			redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#datos-tecnicos', 'refresh');
	}

	function guardar_extra(){
		$this->load->model("Usuarios_model");

		$id_usuario = $_POST['id'];
		$data = array(
			"id_bancos" => $_POST['select_bancos'],
			"tipo_cuenta" => $_POST['tipo_cuenta'],
			'cuenta_banco' => $_POST['n_cuenta'],
			'id_afp' => $_POST['select_afp'],
			'id_salud' => $_POST['select_salud'],
			'licencia' => $_POST['licencia'],
			'num_zapato' => $_POST['n_zapato'],
			'talla_buzo' => $_POST['talla_buzo']
		);

		$this->Usuarios_model->editar($id_usuario,$data);
		if ($this->session->userdata('subtipo') == 2)
			redirect('usuarios/perfil/index', 'refresh');
		else
			redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#datos-extras', 'refresh');
	}

	function guardar_contrasena(){
		$this->load->model("Usuarios_model");

		$id_usuario = $_POST['id'];

		if( $_POST['pass_nueva1'] == $_POST['pass_nueva2'] ){

			$data = array(
				'clave' => hash("sha512", trim($_POST['pass_nueva1']))
				);

			$this->Usuarios_model->editar($id_usuario,$data);
			if ($this->session->userdata('subtipo') == 2)
				redirect('usuarios/perfil/index', 'refresh');
			else
				redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#datos-pass', 'refresh');	
		}
	}

	function cambiar_contrasena_general(){
		$id = $this->session->userdata('id');
		if( empty( $_POST['pass_original']) || empty($_POST['pass_nueva1']) || empty($_POST['pass_nueva2']) ){
			redirect('usuarios/perfil/index', 'refresh');
		}else{
			if(trim($_POST['pass_nueva1']) == trim($_POST['pass_nueva2'])){
				$this->load->model('Usuarios_general_model');
				$usr = $this->Usuarios_general_model->get($id);
				if( $usr->clave == hash("sha512",trim($_POST['pass_original'])) ){
					$data = array(
						"clave" => hash("sha512", trim($_POST['pass_nueva1']))
					);
					$this->Usuarios_general_model->editar_general($id,$data);
					echo "<script>alert('Password Modificada Exitosamente')</script>";
					redirect('usuarios/perfil/index', 'refresh');
				}else{
					echo "<script>alert('Password ingresada no es valida')</script>";
				}
					redirect('usuarios/perfil/index', 'refresh');
			}else{
				echo "<script>alert('Password ingresadas no coinciden')</script>";
			}
				redirect('usuarios/perfil/index', 'refresh');
		}
	}

	function guardar_imagen($id, $FILE = FALSE){
		$this->load->model('Fotostrab_model');
		$this->load->model('Usuarios_model');
		$this->load->helper("imagen");
		date_default_timezone_set('America/Santiago');

		if ($FILE)
			$_FILES['imagen'] = $FILE;

		if($_FILES['imagen']['error'] == 0){
			$salida = subir($_FILES, 'imagen', 'extras/layout2.0/img_perfil/','440','440');
			$salida_thumb = subir($_FILES, 'imagen', 'extras/layout2.0/img_perfil/thumb/','50','50');
			$salida_barra = subir($_FILES, 'imagen', 'extras/layout2.0/img_perfil/thumb/','30','30');
			$salida_media = subir($_FILES, 'imagen', 'extras/layout2.0/img_perfil/thumb/','150','150');
			$foto_existe = $this->Fotostrab_model->get_usuario($id);
			if( count($foto_existe) > 0 ){
				$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
				$ruta_prin = $ruta_prin[0];
				$imagen = $foto_existe->nombre_archivo;
				$thumb = $foto_existe->thumb;
				$media = $foto_existe->media;
				unlink($ruta_prin.$imagen);
				unlink($ruta_prin.$thumb);
				unlink($ruta_prin.$media);
				$this->Fotostrab_model->borrar($id);
			}
			
			$data = array(
				'id_usuarios' => $id,
				'nombre_archivo' => $salida,
				'thumb' => $salida_thumb,
				'media' => $salida_media,
				'barra' => $salida_barra,
				'fecha' => strftime( "%Y-%m-%d %H-%M-%S", time())
			);
			$this->Fotostrab_model->ingresar($data);
			//$this->session->set_userdata('imagen', $salida_thumb);
			$data2 = array('fecha_actualizacion' => date('Y-m-d'));
			$this->Usuarios_model->editar($id,$data2);
			if ($this->session->userdata('subtipo') == 2)
				redirect('usuarios/perfil/index', 'refresh');
			else
				redirect('usuarios/perfil/trabajador_est/'.$id.'/img_exito#datos-imagen', 'refresh');
		}
		else{
			if ($this->session->userdata('subtipo') == 2)
				redirect('usuarios/perfil/index', 'refresh');
			else
				redirect('usuarios/perfil/trabajador_est/'.$id.'/img_error#datos-imagen', 'refresh');
		}
	}

	function guardar_archivo($id){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("Tipoarchivos_model");
			$this->load->model("Archivos_trab_model");
			$this->load->model("Usuarios_model");

			if($_POST['select_archivo'] == 13){
				$la = $this->Archivos_trab_model->get_usuario($id);
				foreach ($la as $l) {
				 	if( $l->id_tipoarchivo == 13)
				 		redirect('usuarios/perfil/trabajador_est/'.$id.'/archivo_repetido#datos-extras', 'refresh');
				}
			}
			
			$tipo = $this->Tipoarchivos_model->get($_POST['select_archivo'])->desc_tipoarchivo;
			$tipo = str_replace(" ", "_", $tipo);
			$usuario = $this->Usuarios_model->get($id);
			$aux = str_replace(" ", "_", $usuario->nombres);
			$ape = normaliza($aux)."_".normaliza($usuario->paterno).'_'.normaliza($usuario->materno);
			$nb_archivo = strtolower($id."_".trim($ape));
			$nb_archivo = urlencode($nb_archivo);
			$salida = subir($_FILES,"documento","extras/docs/",$nb_archivo);
			
			if($salida == 1)
				redirect('usuarios/perfil/trabajador_est/'.$id.'/archivo_error0#datos-extras', 'refresh');
			elseif($salida==2)
				redirect('usuarios/perfil/trabajador_est/'.$id.'/archivo_error1#datos-extras', 'refresh');
			else{
				$data = array(
					'id_usuarios' => $id,
					'nombre' => $nb_archivo,
					'id_tipoarchivo' => $_POST['select_archivo'],
					'url' => $salida
 				);
				$this->Archivos_trab_model->ingresar($data);
				redirect('usuarios/perfil/trabajador_est/'.$id.'/archivo_exito#datos-extras', 'refresh');
			}
		}
		else redirect('usuarios/perfil/trabajador_est/'.$id.'/archivo_vacio#datos-extras', 'refresh');
	}

	function agregar_exp(){
		if( empty( $_POST['select_mes_desde'] ) || empty( $_POST['select_ano_desde'] ) || 
		empty( $_POST['select_mes_hasta'] ) || empty( $_POST['select_ano_hasta'] ) ||
		empty( $_POST['cargo'] ) || empty( $_POST['area'] ) || empty( $_POST['contratista'] ) || empty( $_POST['funciones'] ) ){
			redirect('usuarios/perfil/index', 'refresh');
		}
		else{
			$fecha1 = $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-01';
			$fecha2 = $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-01';
			
			if( (strtotime($fecha2) - strtotime($fecha1)) < 0 )
				redirect('usuarios/perfil/index', 'refresh');
			else{
				$this->load->model("Experiencia_model");
				$data = array(
					'id_usuarios' => $this->session->userdata('id'),
					'desde' => $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-01',
					'hasta' => $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-01',
					'cargo' => $_POST['cargo'],
					'area' => $_POST['area'],
					'empresa_c' => $_POST['contratista'],
					'empresa_m' => $_POST['mandante'],
					'funciones' => $_POST['funciones'],
					'referencias' => $_POST['referencias']
				);
				$this->Experiencia_model->ingresar($data);
				redirect('usuarios/perfil/index', 'refresh');
			}
		}
	}

	function eliminar_archivo($id_archivo,$id_usuario){
		//echo $id_archivo .'-'.$id_usuario; 
		if ($id_archivo && $id_usuario){
			$this->load->model("Archivos_trab_model");
			$this->Archivos_trab_model->eliminar($id_archivo);
		}
		redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#datos-extras', 'refresh');
	}

	function listar_trabajador($id){
		$this->load->model('Fotostrab_model');
		$this->load->model("Usuarios_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Experiencia_model");
		$this->load->model("Usu_parentesco_model");
		$this->load->model("Requerimiento_usuario_archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt' => 'Usuarios'), array('url'=>'','txt'=>'Perfil EST' )),
			'menu' => $this->menu
		);
		$usuario = $this->Usuarios_model->get($id);
		$data_usr = new stdClass();

		$data_usr->nombre = ucwords(mb_strtolower( $usuario->nombres.' '.$usuario->paterno.' '.$usuario->materno, 'UTF-8'));
		if($usuario->fecha_actualizacion == "0000-00-00") $actualizacion = "No se ha actualizado el perfil";
		else{
			 $act = explode("-",$usuario->fecha_actualizacion);
			$actualizacion = $act[2]."-".$act[1].'-'.$act[0];
		}
		$data_usr->actualizacion = $actualizacion;
		$data_usr->rut = $usuario->rut_usuario;
		$data_usr->telefono = $usuario->fono;
		$data_usr->email = $usuario->email;
		$data_usr->sexo = ($usuario->sexo == 0) ? 'Masculino':'Femenino';
		if ( $usuario->fecha_nac ){
			$f_nac = explode('-', $usuario->fecha_nac );
			$data_usr->nacimiento = $f_nac[2].'-'.$f_nac[1].'-'.$f_nac[0];
		}
		else 
			$data_usr->nacimiento = '';
		$data_usr->direccion = ($usuario->direccion)?$usuario->direccion:'';
		$data_usr->region = ($usuario->id_regiones)?$this->Region_model->get( $usuario->id_regiones )->desc_regiones:'';
		$data_usr->provincia = ($usuario->id_provincias)?$this->Provincia_model->get( $usuario->id_provincias )->desc_provincias:'';
		$data_usr->ciudad = ($usuario->id_ciudades)?$this->Ciudad_model->get( $usuario->id_ciudades )->desc_ciudades:'';
		$data_usr->nacionalidad = ($usuario->nacionalidad)?$usuario->nacionalidad:'';
		$data_usr->civil = $this->Estadocivil_model->get($usuario->id_estadocivil)->desc_estadocivil;
		$data_usr->afp = (isset($this->Afp_model->get($usuario->id_afp)->desc_afp)?$this->Afp_model->get($usuario->id_afp)->desc_afp:"");
		$data_usr->salud = (isset($this->Salud_model->get($usuario->id_salud)->desc_salud)?$this->Salud_model->get($usuario->id_salud)->desc_salud:"");
		$data_usr->masso = ($this->Evaluaciones_model->get_una_masso($id))?$this->Evaluaciones_model->get_una_masso($id):'';
		$data_usr->examen = ($this->Evaluaciones_model->get_una_preocupacional($id))?$this->Evaluaciones_model->get_una_preocupacional($id):'';
		$data_usr->experiencia = ($this->Experiencia_model->get_usuario($id))?$this->Experiencia_model->get_usuario($id):'';
		$data_usr->nombre_emerg = isset($usuario->emerg_nombre)?$usuario->emerg_nombre:"";
		$data_usr->telefono_emerg = isset($usuario->emerg_telefono)?$usuario->emerg_telefono:"";
		$get_parentesco_emerg = $this->Usu_parentesco_model->get($usuario->emerg_parentesco_id);
		$data_usr->parentesco_emerg = isset($get_parentesco_emerg->nombre)?$get_parentesco_emerg->nombre:"";
		$data_usr->requerimientos = ($this->Requerimiento_asc_trabajadores_model->get_requerimiento_usu($id))?$this->Requerimiento_asc_trabajadores_model->get_requerimiento_usu($id):'';

		$imagen_thumb = $this->Fotostrab_model->get_usuario($id);
		$data_usr->thumb_usu = isset($imagen_thumb->thumb)?$imagen_thumb->thumb:'extras/layout2.0/img_perfil/default_thumb.jpg';

		$tecnicos_usr = new stdClass();
		$tecnicos_usr->estudios = ($usuario->id_estudios)?$this->Nivelestudios_model->get($usuario->id_estudios)->desc_nivelestudios:'';
		$tecnicos_usr->institucion = $usuario->institucion;
		$tecnicos_usr->egreso = $usuario->ano_egreso;
		$tecnicos_usr->profesion = ($usuario->id_profesiones)?$this->Profesiones_model->get($usuario->id_profesiones)->desc_profesiones:'';
		$get_especialidad = $this->Especialidadtrabajador_model->get($usuario->id_especialidad_trabajador);
		$get_especialidad2 = $this->Especialidadtrabajador_model->get($usuario->id_especialidad_trabajador_2);
		$get_especialidad3 = $this->Especialidadtrabajador_model->get($usuario->id_especialidad_trabajador_3);
		$tecnicos_usr->especialidad = (isset($get_especialidad->desc_especialidad)?$get_especialidad->desc_especialidad:"");
		$tecnicos_usr->especialidad2 = (isset($get_especialidad2->desc_especialidad)?$get_especialidad2->desc_especialidad:"");
		$tecnicos_usr->especialidad3 = (isset($get_especialidad3->desc_especialidad)?$get_especialidad3->desc_especialidad:"");
		$tecnicos_usr->experiencia = $usuario->ano_experiencia;
		$tecnicos_usr->cursos = $usuario->cursos;
		$tecnicos_usr->equipos = $usuario->equipos;
		$tecnicos_usr->software = $usuario->software;
		$tecnicos_usr->idiomas = $usuario->idiomas;
		$pagina['usuario'] = $data_usr;
		$pagina['tecnicos'] = $tecnicos_usr;
		$pagina['masso'] = $this->Evaluaciones_model->get_all_masso2($id);
		$pagina['examen_preo'] = $this->Evaluaciones_model->get_all_preo2($id);
		$pagina['finiquitos'] = $this->Requerimiento_usuario_archivo_model->get_usuario_archivos($id, 4);
		$pagina['contratos'] = $this->Requerimiento_usuario_archivo_model->get_usuario_archivos($id, 1);
		$pagina['anexos'] = $this->Requerimiento_usuario_archivo_model->get_usuario_archivos($id, 2);
		$base['cuerpo'] = $this->load->view('perfil/data_trabajador_est',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function renovar_pass(){
		$this->load->model("Usuarios_model");
		$id_usuario = $_POST['id'];
		if($_POST['pass_nueva1'] == $_POST['pass_nueva2']){
			$data = array(
				'clave' => hash("sha512", $_POST['pass_nueva1'])
			);
			$this->Usuarios_model->editar($id_usuario,$data);
			echo "<script>alert('Clave Modificada Exitosamente')</script>";
		}else{
			echo "<script>alert('Claves Ingresadas no Coinciden')</script>";
		}
		redirect('usuarios/perfil/trabajador_est/'.$id_usuario.'#datos-pass', 'refresh');
	}

	function ajax_provincias($id_region){
		$this->load->model("Provincia_model");
		echo json_encode($this->Provincia_model->listar_region($id_region));
	}
	function ajax_ciudades($id_region){
		$this->load->model("Ciudad_model");
		echo json_encode($this->Ciudad_model->listar_region($id_region));
	}
}
?>