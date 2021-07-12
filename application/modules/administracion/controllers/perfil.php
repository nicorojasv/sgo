<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Perfil extends CI_Controller {
	public $requerimiento;
	
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		
		elseif ($this->session->userdata('tipo') != 3) {
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

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

	function index() {
		$base['titulo'] = "Perfil de administrador";
		$base['lugar'] = "Perfil";

		$pagina['menu'] = $this->load->view('menus/menu_admin', $this->requerimiento, TRUE);
		$base['cuerpo'] = $this->load->view('perfiles/administrador', $pagina, TRUE);
		$this->load->view('layout', $base);
	}

	function editar($msg = FALSE) {
		$this->load->model('Usuarios_model');
		$base['titulo'] = "Editar perfil de administrador";
		$base['lugar'] = "Editar Perfil";

		/**** MENSAJES DE ERROR O EXITO ****/
		if ($msg == "error_pass1") {
			$aviso['titulo'] = "La contraseña original no conicide";
			$pagina['avisos'] = $this->load->view('avisos', $aviso, TRUE);
		}
		if ($msg == "error_pass2") {
			$aviso['titulo'] = "La nueva contraseña no conicide al repetirla";
			$pagina['avisos'] = $this->load->view('avisos', $aviso, TRUE);
		}
		if ($msg == "error_img") {
			$aviso['titulo'] = "Favor verifique extención y peso en la imagen";
			$pagina['avisos'] = $this->load->view('avisos', $aviso, TRUE);
		}
		if ($msg == "exito") {
			$aviso['titulo'] = "Los datos se han actualizado exitosamente";
			$pagina['avisos'] = $this->load->view('avisos', $aviso, TRUE);
		}

		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['menu'] = $this->load->view('menus/menu_admin', $this->requerimiento, TRUE);
		$base['cuerpo'] = $this->load->view('editar_perfil', $pagina, TRUE);
		$this->load->view('layout', $base);
	}

	function guardar() {
		$this->load->model('Usuarios_model');
		$this->load->model('Fotostrab_model');
		$this->load->helper("imagen");

		$usr = $this->Usuarios_model->get($this->session->userdata('id'));

		$nueva_clave = false;

		//verificar contraseña
		if (!empty($_POST['pass_actual']) && !empty($_POST['pass_nuevo1'])) {//si los input de las contraseñas tien datos, quiere modificarlos!!
			if ($usr->clave == hash("sha512", trim($_POST['pass_actual']))) {
				if (trim($_POST['pass_nuevo1']) == trim($_POST['pass_nuevo2'])) {
					$nueva_clave = array('clave' => hash("sha512", trim($_POST['pass_nuevo1'])));
				} else {
					redirect('administracion/perfil/editar/error_pass2', 'refresh');
				}
			} else {
				redirect('administracion/perfil/editar/error_pass1', 'refresh');
			}
		}
		//guardar datos
		$data = array('nombres' => trim($_POST['nombres']), 'paterno' => trim($_POST['paterno']), 'materno' => trim($_POST['materno']), 'fono' => trim($_POST['fono1']) . "-" . trim($_POST['fono2']), 'telefono2' => trim($_POST['fono3']) . "-" . trim($_POST['fono4']), 'email' => trim($_POST['correo']));
		if ($nueva_clave)
			$data = array_merge($data, $nueva_clave);
		$this->Usuarios_model->editar($this->session->userdata('id'), $data);
		//guardar imagen
		if ($_FILES['imagen']['error'] == 0) {//si el input de la imagen tiene un archivo entonces quiere cambiar la imagen!
			$salida = subir($_FILES, 'imagen', 'extras/img/perfil/','440','440');
			$salida_thumb = subir($_FILES, 'imagen', 'extras/img/perfil/thumb/','72','72');
			$salida_media = subir($_FILES, 'imagen', 'extras/img/perfil/requerimiento/','104','104');
			if (!$salida)
				redirect('administracion/perfil/editar/error_img', 'refresh');
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
				'fecha' => strftime("%Y-%m-%d %H-%M-%S", time())
			);
			$this->Fotostrab_model->ingresar($data);
			$this->session->set_userdata('imagen', $salida_thumb);
		}
		redirect('administracion/perfil/editar/exito', 'refresh');
	}

	function trabajador($id=false){
		$this->load->model('Usuarios_model');
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
		$this->load->model("Ciudad_model");
		
		$base['titulo'] = "Perfil de trabajador";
		$base['lugar'] = "Perfil";
		
		$pagina['menu'] = $this->load->view('menus/menu_admin', $this->requerimiento, TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($id);
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
		/** obetener especialidadades extras **/
		if( isset($this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_2)->desc_especialidad) )
			$pagina['especialidad2'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_2);
		/** limpiar idiomas **/
		if( isset($pagina['usuario']->idiomas) ){
			$pagina['idioma'] = $pagina['usuario']->idiomas;
			/*$idioma = explode(";", $pagina['usuario']->idiomas);
			$idiom = "";
			for($i=0;$i<(count($idioma)-1);$i++){
				$idiom .= ucwords(mb_strtolower($idioma[$i],'UTF-8'));
				if($i < (count($idioma)-2)) $idiom .= ", ";
			}
			$pagina['idioma'] = $idiom;*/
		}
		/** limpiar software **/
		if( isset($pagina['usuario']->software) ){
			$pagina['software'] = $pagina['usuario']->software;
			/*$software = explode(";", $pagina['usuario']->software);
			$soft = "";
			for($i=0;$i<(count($software)-1);$i++){
				$soft .= ucwords(mb_strtolower($software[$i],'UTF-8'));
				if($i < (count($software)-2)) $soft .= ", ";
			}
			$pagina['software'] = $soft;*/
		}
		/** limpiar equipos **/
		if( isset($pagina['usuario']->equipos) ){
			$pagina['equipos'] = $pagina['usuario']->equipos;
			/*$equipos = explode(";", $pagina['usuario']->equipos);
			$equi = "";
			for($i=0;$i<(count($equipos)-1);$i++){
				$equi .= ucwords(mb_strtolower($equipos[$i],'UTF-8'));
				if($i < (count($equipos)-2)) $equi .= ", ";
			}
			$pagina['equipos'] = $equi;*/
		}
		/** limpiar cursos **/
		if( isset($pagina['usuario']->cursos) ){
			$pagina['cursos'] = $pagina['usuario']->cursos;
			/*$cursos = explode(";", $pagina['usuario']->cursos);
			$cur = "";
			for($i=0;$i<(count($cursos)-1);$i++){
				$cur .= ucwords(mb_strtolower($cursos[$i],'UTF-8'));
				if($i < (count($cursos)-2)) $cur .= ", ";
			}
			$pagina['cursos'] = $cur;*/
		}
		$base['cuerpo'] = $this->load->view('perfiles/trabajador',$pagina,TRUE);
		$this->load->view('layout',$base);
		
	}
	
	function mandante($id=false){
		$this->load->model('Usuarios_model');
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Usuarios_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');
		
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
		
		$pagina['menu'] = $this->load->view('menus/menu_admin', $this->requerimiento, TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($id);
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
					$aux2->cc = $this->Centrocostos_model->get($g->id_centrocosto)->desc_centrocosto;
					$aux2->especialidad = $this->Especialidadtrabajador_model->get($g->id_especialidad_trabajador)->desc_especialidad;
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
	function empresa($id=false){
		$this->load->model('Usuarios_model');
		$this->load->model('Fotosemp_model');
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
		
		$base['titulo'] = "Perfil de Empresa";
		$base['lugar'] = "Perfil";
		
		$pagina['menu'] = $this->load->view('menus/menu_admin', $this->requerimiento, TRUE);
		$pagina['empresa'] = $this->Empresas_model->get($id);
		$lista_planta = array();
		foreach($this->Planta_model->get_empresa($id) as $p){
			$aux = new stdClass();
			$aux->nombre = $p->nombre;
			$aux->fono = $p->fono;
			$aux->fax = $p->fax;
			$aux->email = $p->email;
			$lista_aux = array();
			foreach($this->Usuarios_model->get_planta($p->id) as $u){
				$aux2 = new stdClass();
				$aux2->rut = $u->rut_usuario;
				$aux2->nombres = $u->nombres;
				$aux2->paterno = $u->paterno;
				$aux2->materno = $u->materno;
				$aux2->fono = $u->fono;
				$aux2->email = $u->email;
				array_push($lista_aux,$aux2);
				unset($aux2);
			}
			$aux->usuarios = $lista_aux;
			array_push($lista_planta,$aux);
			unset($aux);
		}
		$pagina['planta'] = $lista_planta;
		$listar_req = array();
		foreach($this->Requerimiento_model->get_emp($id) as $req){
			$aux = new stdClass();
			$aux->nombre = $req->nombre;
			$aux->lugar = $req->lugar_trabajo;
			$lista_aux = array();
			foreach($this->Requerimientotrabajador_model->get_req($req->id) as $rt){
				$aux2 = new stdClass();
				$aux2->area = $this->Areas_model->get($rt->id_areas)->desc_area;
				$aux2->cargo = $this->Cargos_model->get($rt->id_cargos)->desc_cargo;
				$aux2->cc = $this->Centrocostos_model->get($rt->id_centrocosto)->desc_centrocosto;
				$aux2->especialidad = $this->Especialidadtrabajador_model->get($rt->id_especialidad_trabajador)->desc_especialidad;
				$aux2->f_inicio = $rt->fecha_inicio;
				$aux2->f_termino = $rt->fecha_termino;
				$aux2->estado = $this->Requerimiento_model->get_estado($rt->id_estado)->nombre;
				$aux2->cantidad = $rt->cantidad."/".$rt->cantidad_ok; 
				array_push($lista_aux,$aux2);
				unset($aux2);
			}
			$aux->req = $lista_aux;
			array_push($listar_req,$aux);
			unset($aux);
		}
		$pagina['requerimiento'] = $listar_req;
		$pagina['imagen_grande'] = $this->Fotosemp_model->get_empresa($pagina['empresa']->id);
		
		$base['cuerpo'] = $this->load->view('perfiles/empresa',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

}
?>