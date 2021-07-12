<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Perfil extends CI_Controller {
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
	function index(){
		$this->load->model('Usuarios_model');
		$this->load->model('Fotostrab_model');
		$this->load->model('Tipousuarios_model');
		$this->load->model("Requerimiento_model");
		$this->load->model('administracion/Requerimientotrabajador_model');
		$this->load->model("Archivos_model");
		$this->load->model('Empresas_model');
		$this->load->model('Planta_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('Centrocostos_model');
		$this->load->model('Especialidadtrabajador_model');
		
		$base['titulo'] = "Perfil de Mandante";
		$base['lugar'] = "Perfil";
		
		$pagina['menu'] = $this->load->view('menus/menu_mandante', $this->noticias, TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		$pagina['imagen_grande'] = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		$pagina['archivos'] = $this->Archivos_model->get_usuario($pagina['usuario']->id);
		
		$pagina['planta'] = $this->Planta_model->get($pagina['usuario']->id_planta);
		$pagina['empresa'] = $this->Empresas_model->get($pagina['planta']->id_empresa);
		$requerimientos = $this->Requerimiento_model->get_trab($pagina['usuario']->id);
		if(count($requerimientos) > 0){
			$lista_req = array();
			foreach($requerimientos as $r){
				$aux = new stdClass();
				
				$aux->nombre = $r->nombre;
				$aux->lugar = $r->lugar_trabajo;
				$lista_req2 = array();
				foreach($this->Requerimientotrabajador_model->get_req($r->id) as $g){
					$aux2 = new stdClass();
					$aux2->area = $this->Areas_model->get($g->id_areas)->desc_area;
					$aux2->cargo = $this->Cargos_model->get($g->id_cargos)->desc_cargo;
					$aux2->cc = @$this->Centrocostos_model->get($g->id_centrocosto)->desc_centrocosto;
					$aux2->especialidad = @$this->Especialidadtrabajador_model->get($g->id_especialidad_trabajador)->desc_especialidad;
					$aux2->f_inicio = $g->fecha_inicio;
					$aux2->f_termino = $g->fecha_termino;
					$aux2->cantidad = $g->cantidad;
					$aux2->estado = $this->Requerimiento_model->get_estado($g->id_estado)->nombre;
					array_push($lista_req2,$aux2);
					unset($aux2);
				}
				$aux->req = $lista_req2;
				
				array_push($lista_req,$aux);
				unset($aux);
			}
			//print_r($lista_req);
			$pagina['requerimientos'] = $lista_req;
		}
		else
			$pagina['requerimintos'] = FALSE;
		$base['cuerpo'] = $this->load->view('perfiles/mandante',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function editar($msg = false){
		$this->load->model('Usuarios_model');
		$this->load->model('Region_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Provincia_model');
		$this->load->model('Empresas_model');
		$this->load->model('Planta_model');
		
		$base['titulo'] = "Editar mi perfil";
		$base['lugar'] = "Editar Perfil";
		
		if($msg == "error_pass1"){
			$aviso['titulo'] = "La contraseña original no conicide";
			$aviso['comentario'] = "favor verificar sus datos";
			$pagina['avisos_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_pass2"){
			$aviso['titulo'] = "La nueva contraseña no conicide al repetirla";
			$pagina['avisos_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "msg_pass"){
			$aviso['titulo'] = "La contraseña ha sido cambiada exitosamente";
			$pagina['avisos_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		if($msg == "exito_rep"){
			$aviso['titulo'] = "Las datos han sido cambiados exitosamente";
			$pagina['avisos_representante'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito_emp"){
			$aviso['titulo'] = "Las datos han sido cambiados exitosamente";
			$pagina['avisos_empresa'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_img"){
			$aviso['titulo'] = "Ha ocurrido un error al intentar subir la imagen";
			$pagina['avisos_img'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito_img"){
			$aviso['titulo'] = "La imagen se ha guardado correctamente";
			$pagina['avisos_img'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$pagina['listado_regiones'] = $this->Region_model->listar();
		$pagina['datos_usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['datos_planta'] = $this->Planta_model->get($pagina['datos_usuario']->id_planta);
		$pagina['datos_empresa'] = $this->Empresas_model->get($pagina['datos_planta']->id_empresa);
		$base['cuerpo'] = $this->load->view('editar_perfil',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function editar_contrasena(){
		$this->load->model('Usuarios_model');
		$usr = $this->Usuarios_model->get($this->session->userdata('id'));
		if($usr->clave == hash("sha512", trim($_POST['pass_actual']))){
			if(trim($_POST['pass_nuevo1']) == trim($_POST['pass_nuevo2'])){
				$data = array('clave' => hash("sha512", trim($_POST['pass_nuevo1'])));
				$this->Usuarios_model->editar($this->session->userdata('id'),$data);
				redirect('mandante/perfil/editar/msg_pass#datos-pass', 'refresh');
			}else{
				redirect('mandante/perfil/editar/error_pass2#datos-pass', 'refresh');
			}
		}
		else{
			redirect('mandante/perfil/editar/error_pass1#datos-pass', 'refresh');
		}
	}

	function guardar_representante(){
		$this->load->model('Usuarios_model');
		date_default_timezone_set('America/Santiago');
		
		$data = array(
			'nombres' => trim($_POST['nombres']),
			'paterno' => trim($_POST['paterno']),
			'materno' => trim($_POST['materno']),
			'rut_usuario' => trim($_POST['rut_usuario']),
			'sexo' => trim($_POST['select_sexo']),
			'fono' => trim($_POST['fono3'])."-".trim($_POST['fono4']),
			'email' => trim($_POST['correo']),
			'cargo_mandante' => trim($_POST['cargo']),
			'fecha_actualizacion' => date('Y-m-d')
		);
		$this->Usuarios_model->editar($this->session->userdata('id'),$data);
		
		redirect('mandante/perfil/editar/exito_rep#datos-representante', 'refresh');
	}
	
	function guardar_imagen(){
		$this->load->model('Fotostrab_model');
		$this->load->model('Usuarios_model');
		$this->load->helper("imagen");
		date_default_timezone_set('America/Santiago');
		
		if($_FILES['imagen']['error'] == 0){
			$salida = subir($_FILES, 'imagen', 'extras/img/perfil/','440','440');
			$salida_thumb = subir($_FILES, 'imagen', 'extras/img/perfil/thumb/','72','72');
			$salida_media = subir($_FILES, 'imagen', 'extras/img/perfil/requerimiento/','104','104');
			$foto_existe = $this->Fotostrab_model->get_usuario($this->session->userdata('id'));
			if( count($foto_existe) > 0 ){
				$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
				$ruta_prin = $ruta_prin[0];
				$imagen = $foto_existe->nombre_archivo;
				$thumb = $foto_existe->thumb;
				$media = $foto_existe->media;
				unlink($ruta_prin.$imagen);
				unlink($ruta_prin.$thumb);
				unlink($ruta_prin.$media);
				$this->Fotostrab_model->borrar($this->session->userdata('id'));
			}
			
			$data = array(
				'id_usuarios' => $this->session->userdata('id'),
				'nombre_archivo' => $salida,
				'thumb' => $salida_thumb,
				'media' => $salida_media,
				'fecha' => strftime( "%Y-%m-%d %H-%M-%S", time())
			);
			$this->Fotostrab_model->ingresar($data);
			$this->session->set_userdata('imagen', $salida_thumb);
			$data2 = array('fecha_actualizacion' => date('Y-m-d'));
			$this->Usuarios_model->editar($this->session->userdata('id'),$data2);
			redirect('mandante/perfil/editar/exito_img#datos-imagen', 'refresh');
		}
		else{
			redirect('mandante/perfil/editar/error_img#datos-imagen', 'refresh');
		}
	}
	
	function trabajador($id=false){
		$this->load->model('Usuarios_model');
		$this->load->library('encrypt');
		$id = $this->encrypt->decode(urldecode($id));
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Usuarios_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');
		
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
		$this->load->model("Provincia_model");
		
		$base['titulo'] = "Perfil de trabajador";
		$base['lugar'] = "Perfil";
		
		$pagina['menu'] = $this->load->view('menus/menu_mandante',$this->noticias,TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		$pagina['imagen_grande'] = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		$pagina['experiencia'] = $this->Experiencia_model->get_usuario($pagina['usuario']->id);
		$pagina['archivos'] = $this->Archivos_model->get_usuario($pagina['usuario']->id);
		
		$pagina['estado_civil'] = $this->Estadocivil_model->get($pagina['usuario']->id_estadocivil);
		$pagina['afp'] = $this->Afp_model->get($pagina['usuario']->id_afp);
		$pagina['salud'] = $this->Salud_model->get($pagina['usuario']->id_salud);
		$pagina['nivel_estudios'] = $this->Nivelestudios_model->get($pagina['usuario']->id_estudios);
		$pagina['profesion'] = $this->Profesiones_model->get($pagina['usuario']->id_profesiones);
		$pagina['especialidad1'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador);
		/** obetener especialidadades extras **/
		if( isset($this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_2)->desc_especialidad) )
			$pagina['especialidad2'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_2);
		if( isset($this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_3)->desc_especialidad) )
			$pagina['especialidad3'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_3);
		/** limpiar idiomas **/
		if( isset($pagina['usuario']->idiomas) ){
			$idioma = explode(";", $pagina['usuario']->idiomas);
			$idiom = "";
			for($i=0;$i<(count($idioma)-1);$i++){
				$idiom .= ucwords(mb_strtolower($idioma[$i],'UTF-8'));
				if($i < (count($idioma)-2)) $idiom .= ", ";
			}
			$pagina['idioma'] = $idiom;
		}
		/** limpiar software **/
		if( isset($pagina['usuario']->software) ){
			$software = explode(";", $pagina['usuario']->software);
			$soft = "";
			for($i=0;$i<(count($software)-1);$i++){
				$soft .= ucwords(mb_strtolower($software[$i],'UTF-8'));
				if($i < (count($software)-2)) $soft .= ", ";
			}
			$pagina['software'] = $soft;
		}
		/** limpiar equipos **/
		if( isset($pagina['usuario']->equipos) ){
			$equipos = explode(";", $pagina['usuario']->equipos);
			$equi = "";
			for($i=0;$i<(count($equipos)-1);$i++){
				$equi .= ucwords(mb_strtolower($equipos[$i],'UTF-8'));
				if($i < (count($equipos)-2)) $equi .= ", ";
			}
			$pagina['equipos'] = $equi;
		}
		/** limpiar cursos **/
		if( isset($pagina['usuario']->cursos) ){
			$cursos = explode(";", $pagina['usuario']->cursos);
			$cur = "";
			for($i=0;$i<(count($cursos)-1);$i++){
				$cur .= ucwords(mb_strtolower($cursos[$i],'UTF-8'));
				if($i < (count($cursos)-2)) $cur .= ", ";
			}
			$pagina['cursos'] = $cur;
		}
		$base['cuerpo'] = $this->load->view('perfil/trabajador',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
}
?>