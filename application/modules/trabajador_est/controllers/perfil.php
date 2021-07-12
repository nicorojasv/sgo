<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Perfil extends CI_Controller{
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
		$this->load->model('Usuarios_model');
		$this->load->model('Fotostrab_model');
		$this->load->model('Tipousuarios_model');
		$this->load->model('Estadocivil_model');
		$this->load->model('Afp_model');
		$this->load->model('Excajas_model');
		$this->load->model('Experiencia_model');
		$this->load->model('Salud_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Profesiones_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_model");
		$this->load->model('Provincia_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Region_model');
		
		$base['titulo'] = "Perfil de trabajador";
		$base['lugar'] = "Perfil";
		
		$pagina['menu'] = $this->load->view('layout2.0/menus/menu_trabajador',$this->noticias,TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		if( $this->Fotostrab_model->get_usuario($pagina['usuario']->id) )
			$img_grande = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		else{
			$img_grande->nombre_archivo = 'extras/img/perfil/avatar.jpg';
			$img_grande->thumb = 'extras/img/perfil/avatar.jpg';
		}
		$pagina['imagen_grande'] = $img_grande;
		$pagina['experiencia'] = $this->Experiencia_model->get_usuario($pagina['usuario']->id);
		$pagina['archivos'] = $this->Archivos_model->get_usuario($pagina['usuario']->id);
		
		$pagina['estado_civil'] = $this->Estadocivil_model->get($pagina['usuario']->id_estadocivil);
		$pagina['afp'] = $this->Afp_model->get($pagina['usuario']->id_afp);
		$pagina['salud'] = $this->Salud_model->get($pagina['usuario']->id_salud);
		$pagina['nivel_estudios'] = $this->Nivelestudios_model->get($pagina['usuario']->id_estudios);
		$pagina['profesion'] = $this->Profesiones_model->get($pagina['usuario']->id_profesiones);
		$pagina['especialidad1'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador);
		if( isset($this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_2)->desc_especialidad) )
			$pagina['especialidad2'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_2);
		if( isset($this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_3)->desc_especialidad) )
			$pagina['especialidad3'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_3);
		if( isset($pagina['usuario']->idiomas) ){
			$pagina['idioma'] = $pagina['usuario']->idiomas;
		}
		if( isset($pagina['usuario']->software) ){
			$pagina['software'] = $pagina['usuario']->software;
		}
		if( isset($pagina['usuario']->equipos) ){
			$pagina['equipos'] = $pagina['usuario']->equipos;
		}
		if( isset($pagina['usuario']->cursos) ){
			$pagina['cursos'] = $pagina['usuario']->cursos;
		}
		$base['cuerpo'] = $this->load->view('perfiles/trabajador',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function editar($msg = FALSE){
		$this->load->model('Usuarios_model');
		$this->load->model('Estadocivil_model');
		$this->load->model("Archivos_model");
		$this->load->model('Bancos_model');
		$this->load->model('Afp_model');
		$this->load->model('Excajas_model');
		$this->load->model('Region_model');
		$this->load->model('Provincia_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Salud_model');
		$this->load->model("Tipoarchivos_model");
		$this->load->model('Nivelestudios_model');
		$this->load->model('Profesiones_model');
		$this->load->model("Experiencia_model");
		$this->load->model('Especialidadtrabajador_model');

		$base = array(
			'head_titulo' => "Sistema EST - Trabajador",
			'titulo' => "Editar mi perfil",
			'subtitulo' => "Editar Perfil Trabajador",
		);
		
		/**** AVISOS Y MENSAJES ****/
		if($msg == "personal_vacio"){
			$aviso['titulo'] = "No olvide datos con asterisco son obligatorios";
			$pagina['aviso_personal'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "tecnico_vacio"){
			$aviso['titulo'] = "No olvide datos con asterisco son obligatorios";
			$pagina['aviso_tecnico'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "pass_vacio"){
			$aviso['titulo'] = "Uno o más campos estan vacios, todos son obligatorios";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "extra_vacio"){
			$aviso['titulo'] = "Uno o más campos estan vacios, todos son obligatorios";
			$pagina['aviso_extra'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "pass_error1"){
			$aviso['titulo'] = "La nueva contraseña no coincide al repetirla";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "pass_error2"){
			$aviso['titulo'] = "La contraseña original no es la misma";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "img_error"){
			$aviso['titulo'] = "Hubo un error al subir la imagen, intentelo nuevamente";
			$pagina['aviso_imagen'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "personal_exito"){
			$aviso['titulo'] = "Los datos han sido actualizados correctamente";
			$pagina['aviso_personal'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "pass_exito"){
			$aviso['titulo'] = "La contraseña ha sido cambiada exitosamente";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "img_exito"){
			$aviso['titulo'] = "La imagen ha sido cambiada exitosamente";
			$pagina['aviso_imagen'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "email_invalido"){
			$aviso['titulo'] = "El email ingresado es invalido";
			$pagina['aviso_personal'] = $this->load->view('avisos',$aviso,TRUE);
		}
		/***************************/
		$arch = $this->Archivos_model->get_usuario($this->session->userdata('id'));
		$listado = array();
		foreach ($arch as $a) {
			$aux = new stdClass();
			$aux->id = $a->id_archivo;
			$aux->nb_tipo = $a->desc_tipoarchivo;
			$aux->url = $a->url;
			$aux->fecha = $a->fecha;
			$aux->nb_archivo = $a->nombre;
			array_push($listado,$aux);
			unset($aux);
		}
		$pagina['listado_archivo'] = $listado;
		/***********************************/
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['civil'] = $this->Estadocivil_model->listar();
		$pagina['bancos'] = $this->Bancos_model->listar();
		$pagina['salud'] = $this->Salud_model->listar();
		$pagina['afp'] = $this->Afp_model->listar();
		$pagina['excajas'] = $this->Excajas_model->listar();
		$pagina['lvl_estudios'] = $this->Nivelestudios_model->listar();
		$pagina['profesiones'] = $this->Profesiones_model->listar();
		$pagina['esp_trab'] = $this->Especialidadtrabajador_model->listar();
		$pagina['regiones'] = $this->Region_model->listar();
		$pagina['ciudades'] = $this->Ciudad_model->listar();
		$pagina['provincias'] = $this->Provincia_model->listar();
		$pagina['experiencia'] = $this->Experiencia_model->get_usuario($this->session->userdata('id'));
		$pagina['listado_tipo'] = $this->Tipoarchivos_model->listar();
		$pagina['menu'] = $this->load->view('layout2.0/menus/menu_trabajador',$this->noticias,TRUE);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Novienbre","Diciembre");
		$base['cuerpo'] = $this->load->view('perfil/editar_perfil',$pagina,TRUE);
		$this->load->view('layout2.0/layout_horizontal_menu', $base);
	}




	function cambiar_contrasena($id){
		if( empty( $_POST['pass_original']) || empty($_POST['pass_nueva1']) || empty($_POST['pass_nueva2']) ){
			redirect('trabajador/perfil/editar/pass_vacio#datos-pass', 'refresh');
		}
		else{
			if(trim($_POST['pass_nueva1']) == trim($_POST['pass_nueva2'])){
				$this->load->model('Usuarios_model');
				$usr = $this->Usuarios_model->get($id);
				if( $usr->clave == hash("sha512",trim($_POST['pass_original'])) ){
					$data = array("clave" => hash("sha512", trim($_POST['pass_nueva1'])));
					$this->Usuarios_model->editar($id,$data);
					redirect('trabajador/perfil/editar/pass_exito#datos-pass', 'refresh');
				}
				else
					redirect('trabajador/perfil/editar/pass_error2#datos-pass', 'refresh');
			}
			else
				redirect('trabajador/perfil/editar/pass_error1#datos-pass', 'refresh');
		}
	}

	function guardar_archivos(){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("Tipoarchivos_model");
			$this->load->model("Archivos_model");
			$this->load->model("Usuarios_model");
			
			$tipo = $this->Tipoarchivos_model->get($_POST['select_archivo'])->desc_tipoarchivo;
			$tipo = str_replace(" ", "_", $tipo);
			$usuario = $this->Usuarios_model->get($this->session->userdata('id'));
			$aux = str_replace(" ", "_", $usuario->nombres);
			$ape = normaliza($aux)."_".normaliza($usuario->paterno).'_'.normaliza($usuario->materno);
			$nb_archivo = strtolower($this->session->userdata('id')."_".trim($tipo).'_'.trim($ape));
			$salida = subir($_FILES,"documento","extras/docs/",$nb_archivo);

			if($salida == 1)
				redirect('trabajador/perfil/editar#datos-archivos', 'refresh');
			elseif($salida==2)
				redirect('trabajador/perfil/editar#datos-archivos', 'refresh');
			else{
				$data = array(
					'id_usuarios' => $this->session->userdata('id'),
					'nombre' => $nb_archivo,
					'id_tipoarchivo' => $_POST['select_archivo'],
					'url' => $salida
 				);
				$this->Archivos_model->ingresar($data);
				system('cp /var/www/sgo/extras/docs/'.$nb_archivo.' /var/www/sgo2/extras/docs/');
				redirect('trabajador/perfil/editar#datos-archivos', 'refresh');
			}
		}
		else redirect('trabajador/perfil/editar#datos-archivos', 'refresh');
		
	}

	function eliminar_archivo($id){
		$this->load->model("Archivos_model");
		$arch = $this->Archivos_model->get($id);
		unlink(getcwd().'/'.$arch->url);
		$this->Archivos_model->eliminar($id);
		redirect('trabajador/perfil/editar#datos-archivos', 'refresh');
	}

	function agregar_exp() {
		if( empty( $_POST['select_mes_desde'] ) || empty( $_POST['select_ano_desde'] ) || 
		empty( $_POST['select_mes_hasta'] ) || empty( $_POST['select_ano_hasta'] ) ||
		empty( $_POST['cargo'] ) || empty( $_POST['area'] ) || empty( $_POST['contratista'] ) || empty( $_POST['funciones'] ) ){
			redirect('trabajador/perfil/editar#datos-exp', 'refresh');
		}
		else{
			$fecha1 = $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-01';
			$fecha2 = $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-01';
			
			if( (strtotime($fecha2) - strtotime($fecha1)) < 0 )
				redirect('trabajador/perfil/editar#datos-exp', 'refresh');
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
				redirect('trabajador/perfil/editar#datos-exp', 'refresh');
			}
		}
	}

	function eliminar_exp($id){
		$this->load->model("Experiencia_model");
		$this->Experiencia_model->borrar($id);
		redirect('trabajador/perfil/editar#datos-exp', 'refresh');
	}
	
	function editar_exp($id){
		$this->load->model("Experiencia_model");
		$exp = $this->Experiencia_model->get($id);
		$base['exp'] = $exp;
		$base['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Novienbre","Diciembre");
		$this->load->view('editar_exp',$base);
	}

	function edicion_exp($id){
		if( empty( $_POST['select_mes_desde'] ) || empty( $_POST['select_ano_desde'] ) || 
		empty( $_POST['select_mes_hasta'] ) || empty( $_POST['select_ano_hasta'] ) ||
		empty( $_POST['cargo'] ) || empty( $_POST['area'] ) || empty( $_POST['contratista'] ) || empty( $_POST['funciones'] ) ){
			redirect('trabajador/perfil/editar#datos-exp', 'refresh');
		}
		else{
			$fecha1 = $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-01';
			$fecha2 = $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-01';
			
			if( (strtotime($fecha2) - strtotime($fecha1)) < 0 )
				redirect('trabajador/perfil/editar#datos-exp', 'refresh');
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
				$this->Experiencia_model->editar($id,$data);
				redirect('trabajador/perfil/editar#datos-exp', 'refresh');
			}
		}
	}


	function guardar_personales($id){
		if(empty( $_POST['nombres'] ) || empty( $_POST['paterno'] ) || empty( $_POST['materno'] ) || empty( $_POST['select_nac_ano'] ) || 
		empty( $_POST['select_nac_mes'] ) || empty( $_POST['select_nac_dia'] ) ||  empty( $_POST['direccion']) || !isset( $_POST['select_sexo'] ) || 
		empty( $_POST['fono_1'] ) || empty( $_POST['fono_2']) || empty( $_POST['select_civil'] ) || empty( $_POST['select_nacionalidad'] )  || empty( $_POST['select_provincia']) ){
			redirect('trabajador/perfil/editar/personal_vacio#datos-personales', 'refresh');
		}
		else {
			if(!empty($_POST['email'])){
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					redirect('trabajador/perfil/editar/email_invalido#datos-personales', 'refresh');
				}
			}
			$this->load->model('Usuarios_model');
			date_default_timezone_set('America/Santiago');
			if(empty($_POST['select_provincia'])) $_POST['select_provincia'] = NULL;
			if(empty($_POST['email'])) $_POST['email'] = NULL;
			if(empty($_POST['fono_3']) || empty($_POST['fono_4'])) $fono2 = NULL;
			else $fono2 = trim($_POST['fono_3'])."-".trim($_POST['fono_4']);
			$data = array(
				'nombres' => trim($_POST['nombres']),
				'paterno' => trim($_POST['paterno']),
				'materno' => trim($_POST['materno']),
				'fecha_nac' => $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'],
				'direccion' => trim($_POST['direccion']),
				'sexo' => trim($_POST['select_sexo']),
				'fono' => trim($_POST['fono_1'])."-".trim($_POST['fono_2']),
				'telefono2' => $fono2,
				'email' => trim($_POST['email']),
				'id_estadocivil' => $_POST['select_civil'],
				'nacionalidad' => $_POST['select_nacionalidad'],
				'id_regiones' => $_POST['select_region'],
				'id_provincias' => $_POST['select_provincia'],
				'id_ciudades' => $_POST['select_ciudad'],
				'fecha_actualizacion' => date('Y-m-d')
			);
			$this->Usuarios_model->editar($id,$data);
			redirect('trabajador/perfil/editar#datos-personales', 'refresh');
		}
	}

	function guardar_tecnicos($id){
		if( empty($_POST['select_nivelestudios']) || empty($_POST['nb_institucion']) || empty( $_POST['ano_egreso']) || empty($_POST['select_profesion']) 
		 || empty($_POST['select_especialidad1']) || empty( $_POST['ano_experiencia']) ){
			redirect('trabajador/perfil/editar/tecnico_vacio#datos-tecnicos', 'refresh');
		}
		else{
			$this->load->model('Usuarios_model');
			date_default_timezone_set('America/Santiago');
			$data = array(
				'id_estudios' => $_POST['select_nivelestudios'],
				'institucion' => trim($_POST['nb_institucion']),
				'ano_egreso' => trim($_POST['ano_egreso']),
				'id_profesiones' => $_POST['select_profesion'],
				'id_especialidad_trabajador' => $_POST['select_especialidad1'],
				'id_especialidad_trabajador_2' => (empty($_POST['select_especialidad2']) ) ? "NULL" : $_POST['select_especialidad2'],
				'ano_experiencia' => trim($_POST['ano_experiencia']),
				'cursos' => trim($_POST['cursos']),
				'equipos' => trim($_POST['equipos']),
				'software' => trim($_POST['software']),
				'idiomas' => trim($_POST['idiomas']),
				'fecha_actualizacion' => date('Y-m-d')
			);
			$this->Usuarios_model->editar($id,$data);
			redirect('trabajador/perfil/editar#datos-tecnicos', 'refresh');
		}
	}

	function guardar_extras($id){
		if( empty($_POST['select_afp']) || empty($_POST['select_salud']) || empty($_POST['select_talla']) || empty( $_POST['zapato']) ){
			redirect('trabajador/perfil/editar/extra_vacio#datos-extras', 'refresh');
		}
		else{
			if( $_POST['select_afp'] == 7){
				if( empty($_POST['select_excaja']) ){
					redirect('trabajador/perfil/editar/extra_vacio#datos-extras', 'refresh');
				}
			}
			$this->load->model('Usuarios_model');
			date_default_timezone_set('America/Santiago');
			if(empty($_POST['zapato'])) $_POST['zapato'] = NULL;
			$data = array(
				'tipo_cuenta' => trim($_POST['tipo_cuenta']),
				'cuenta_banco' => trim($_POST['n_cuenta']),
				'id_afp' => $_POST['select_afp'],
				'id_salud' => $_POST['select_salud'],
				'licencia' => trim($_POST['licencia']),
				'num_zapato' => trim($_POST['zapato']),
				'talla_buzo' => $_POST['select_talla'],
				'fecha_actualizacion' => date('Y-m-d')
			);
			if(!empty($_POST['select_excaja']))
				$data = array_merge($data, array('id_excajas' => $_POST['select_excaja']));
			if(!empty($_POST['select_banco']))
				$data = array_merge($data,array('id_bancos' => $_POST['select_banco']));
			//print_r($data);			
			$this->Usuarios_model->editar($id,$data);
			redirect('trabajador/perfil/editar#datos-extras', 'refresh');
		}
	}
	
	function guardar_imagen($id){
		$this->load->model('Fotostrab_model');
		$this->load->model('Usuarios_model');
		$this->load->helper("imagen");
		date_default_timezone_set('America/Santiago');
		
		if($_FILES['imagen']['error'] == 0){
			$salida = subir($_FILES, 'imagen', 'extras/img/perfil/','440','440');
			$salida_thumb = subir($_FILES, 'imagen', 'extras/img/perfil/thumb/','72','72');
			$salida_media = subir($_FILES, 'imagen', 'extras/img/perfil/thumb/','104','104');
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
				'fecha' => strftime( "%Y-%m-%d %H-%M-%S", time())
			);
			$this->Fotostrab_model->ingresar($data);
			$this->session->set_userdata('imagen', $salida_thumb);
			$data2 = array('fecha_actualizacion' => date('Y-m-d'));
			$this->Usuarios_model->editar($id,$data2);
			
			redirect('trabajador/perfil/editar/img_exito#datos-imagen', 'refresh');
		}
		else{
			redirect('trabajador/perfil/editar/img_error#datos-imagen', 'refresh');
		}
	}
	function provincia($id_region){
		$this->load->model('Provincia_model');
		if(isset($id_region)){
			foreach ($this->Provincia_model->listar_region($id_region) as $prov ){
				echo "<option value=".$prov->id.">".$prov->desc_provincias."</option>";
			}
		}
	}
	
	function ciudad($id_region){
		$this->load->model('Ciudad_model');
		if(isset($id_region)){
			foreach ($this->Ciudad_model->listar_region($id_region) as $ciu ){
				echo "<option value=".$ciu->id.">".$ciu->desc_ciudades."</option>";
			}
		}
	}
}
?>