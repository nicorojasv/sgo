<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Trabajadores extends CI_Controller {
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
		redirect('administracion/trabajadores/agregar', 'refresh');
	}

	function agregar($msg = FALSE) {
		$this->load->model('Region_model');
		$this->load->model('Estadocivil_model');
		$this->load->model('Afp_model');
		$this->load->model('Bancos_model');
		$this->load->model('Salud_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Profesiones_model');
		$this->load->model('Especialidadtrabajador_model');	

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url'=>'administracion/trabajadores','txt' => 'Trabajadores'), array('url'=>'','txt'=>'Agregar' )),
			'js' => array('plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js','js/form-wizard.js'),
			'menu' => $this->load->view('layout2.0/menus/menu_admin','',TRUE)
		);
		
		if($msg == "error_vacio"){
			$aviso['titulo'] = "Algunos datos estan vacios, favor enviar nuevamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_pass"){
			$aviso['titulo'] = "Las contraseñas no coinciden,favor corregir";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_rut"){
			$aviso['titulo'] = "El rut existe en nuestros sistemas";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_email_valid"){
			$aviso['titulo'] = "El email ingresado es invalido";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "El usuario a sido guardado exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}

		$pagina['listado_regiones'] = $this->Region_model->listar();
		$pagina['listado_civil'] = $this->Estadocivil_model->listar();
		$pagina['listado_afp'] = $this->Afp_model->listar();
		$pagina['listado_bancos'] = $this->Bancos_model->listar();
		$pagina['listado_salud'] = $this->Salud_model->listar();
		$pagina['listado_estudios'] = $this->Nivelestudios_model->listar();
		$pagina['listado_profesiones'] = $this->Profesiones_model->listar();
		$pagina['listado_especialidades'] = $this->Especialidadtrabajador_model->listar();
		$pagina['texto_anterior'] = $this->session->flashdata('ingreso');
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		//$this->output->enable_profiler(TRUE); 
		$base['cuerpo'] = $this->load->view('trabajadores/agregar2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
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
	
	function subir_archivo() {
		$base['titulo'] = "Subir archivo de trabajadores";
		$base['lugar'] = "Agregar Trabajador";
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/subir',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function buscar() {
		$this->load->library('encrypt');
		$this->load->library('pagination');

		if(isset($_POST['head_buscar']))
			redirect('/administracion/trabajadores/buscar/filtro/'.$_POST['head_buscar'].'/pagina/', 'refresh');

		$filtro = FALSE;

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Listado trabajadores",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => false,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url'=>'administracion/trabajadores','txt' => 'Trabajadores'), array('url'=>'','txt'=>'Listado' )),
			'menu' => $this->load->view('layout2.0/menus/menu_admin','',TRUE),
			'js' => array('js/table-data.js','js/ui-subview.js','js/listado_trabajadores.js'),
			'head_buscar' => array('method' => 'post', 'url' => base_url().'administracion/trabajadores/buscar')
		);
		
		$this->load->model("Usuarios2_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Listanegra_model");
		$this->load->model("Archivos_model");



		if($this->uri->segment(4) === FALSE){
			$pag_actual = 0;
			$config['uri_segment'] = 4;
			$config['base_url'] = base_url().'/administracion/trabajadores/buscar/pagina/';
			$asociacion[0]['nombre'] = FALSE;
			$asociacion[0]['rut'] = FALSE;
			$asociacion[0]['profesion'] = FALSE;
			$asociacion[0]['especialidad'] = FALSE;
			$asociacion[0]['ciudad'] = FALSE;
			$asociacion[0]['clave'] = FALSE;
		}
		else{
			$asc = $this->uri->uri_to_assoc(4);

			if($this->uri->uri_to_assoc(4) == 'pagina'){
				$config['uri_segment'] = 5;
				$config['base_url'] = base_url().'/administracion/trabajadores/buscar/pagina/';
				$filtro = FALSE;
				$pag_actual = $this->uri->segment(5);
			}
			else{//si existe el filtro entonces........
				$config['uri_segment'] = 7;
				$config['base_url'] = base_url().'/administracion/trabajadores/buscar/filtro/'.$this->uri->segment(5).'/pagina/';
				$filtro = $this->uri->segment(5);
				$pag_actual = $this->uri->segment(7);
			}
		}
		
		$config['per_page'] = 100;
		$config['total_rows'] = $this->Usuarios2_model->total_filtro($filtro,FALSE );
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
		$this->pagination->initialize($config);
		
		$pagina['paginado']	= $this->pagination->create_links();

		
		$listado = array();
		//foreach($this->Usuarios_model->listar_trabajadores() as $l ){
		foreach($this->Usuarios2_model->listar_filtro($filtro,FALSE,$config['per_page'],$pag_actual) as $l ){
			$aux = new stdClass();
			$l->id = $l->id_user;
			$m = $this->Evaluaciones_model->get_una_masso($l->id);
			$p = $this->Evaluaciones_model->get_una_preocupacional($l->id);
			$n = $this->Listanegra_model->listar_trabajador($l->id);
			$c = $this->Ciudad_model->get($l->id_ciudades);
			if ($l->id_especialidad_trabajador){
				$e1 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador);
				$aux->especilidad1 = ($e1->desc_especialidad)? ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')) : FALSE;	
			}
			else
				$aux->especilidad1 = false;

			if ($l->id_especialidad_trabajador_2){
				$e2 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_2);
				$aux->especilidad2 = (!empty($e2->desc_especialidad))? ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')) : FALSE;
			}
			else
				$aux->especilidad2 = false;

			if ($l->id_especialidad_trabajador_3){
				$e3 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_3);
				$aux->especilidad3 =  (!empty($e3->desc_especialidad))? $e3->desc_especialidad : FALSE;
			}
			else
				$aux->especilidad3 = false;

			$aux->id_user = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->fono = $l->fono;
			if (isset($l->fecha_nac)){
				$fa = explode('-',$l->fecha_nac);
				$aux->fecha_nacimiento = $fa[2].'/'.$fa[1].'/'.$fa[0];
			}
			else $aux->fecha_nacimiento = '00/00/0000';

			$aux->afp = $this->Archivos_model->get_archivo($l->id,11);
			$aux->salud = $this->Archivos_model->get_archivo($l->id,12);
			$aux->estudios = $this->Archivos_model->get_archivo($l->id,9);
			$aux->cv = $this->Archivos_model->get_archivo($l->id,13);

			$aux->desc_ciudades = (!empty($c->desc_ciudades))? ucfirst(strtolower($c->desc_ciudades)):'No Ingresada';
			$aux->nombres = ucwords(mb_strtolower($l->nombres.' '.$l->paterno.' '.$l->materno,'UTF-8'));
			if (isset($m->fecha_v)){
				$m_fecha = explode('-',$m->fecha_v);
				$m_fecha = $m_fecha[2].'/'.$m_fecha[1].'/'.$m_fecha[0];
			}
			else
				$m_fecha = "no tiene";

			if (isset($p->fecha_v)){
				$p_fecha = explode('-',$p->fecha_v);
				$p_fecha = $p_fecha[2].'/'.$p_fecha[1].'/'.$p_fecha[0];
			}
			else
				$p_fecha = "no tiene";

			$aux->masso =  $m_fecha;
			$aux->examen_pre =  $p_fecha;

			$fecha_actual = date("m-d-Y");
			$fecha_actual = explode('-', $fecha_actual);
			$fecha_actual = mktime(0,0,0,$fecha_actual[0],$fecha_actual[1],$fecha_actual[2]); 
			$aux->estado_masso = "";
			$aux->estado_examen = "";
			if ($aux->masso != "no tiene"){
				$fecha_entrada = explode('-', $m->fecha_v);
				$fecha_entrada = mktime(0,0,0,$fecha_entrada[1],$fecha_entrada[2],$fecha_entrada[0]); 
				$segundos_diferencia = $fecha_entrada - $fecha_actual;
				$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
				$dias_diferencia = floor($dias_diferencia);
				
				if($dias_diferencia <= 30 && $dias_diferencia > 0 ){
					$aux->estado_masso = "falta";
				}
				else if($dias_diferencia <= 0){
					$aux->estado_masso = "vencida";
				}
				else if($dias_diferencia > 30){
					$aux->estado_masso = "vigente";
				}
				//$aux->estado_masso = $dias_diferencia;
			}

			if ($aux->examen_pre != "no tiene"){
				$fecha_entrada = explode('-', $p->fecha_v);
				$fecha_entrada = mktime(0,0,0,$fecha_entrada[1],$fecha_entrada[2],$fecha_entrada[0]); 
				$segundos_diferencia = $fecha_entrada - $fecha_actual;
				$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
				$dias_diferencia = floor($dias_diferencia);
				
				if($dias_diferencia <= 30 && $dias_diferencia > 0){
					$aux->estado_examen = "falta";
				}
				else if($dias_diferencia <= 0){
					$aux->estado_examen = "vencida";
				}
				else if($dias_diferencia > 30){
					$aux->estado_examen = "vigente";
				}
			}

			if(empty($n)){
				$aux->ln = 0;
			}
			else{
				$cont_g = 0;
				$cont_ln = 0;
				$cont_lnp = 0;
				foreach ($n as $n) {
					if($n->tipo == "-"){
						$cont_g += 1;
					}
					if($n->tipo == "LNP"){
						$cont_lnp += 1;
					}
					if($n->tipo == "LN"){
						$cont_ln += 1;
					}
				}

				if ( $cont_g <=3 ) $aux->ln = 1;
				if ( $cont_g >= 4 || $cont_ln >= 1) $aux->ln = 2;
				if ( ($cont_g <= 3 && $cont_ln >= 1) || $cont_lnp >= 1) $aux->ln = 3;
			}
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}

		$pagina['listado'] = $listado;

		$base['cuerpo'] = $this->load->view('trabajadores/listado2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_requerimiento(){
		$this->load->model("Grupo_model");
		$this->load->model("Requerimiento_origen_model");
		$id = 2;
		$listado_grupo['grupo'] = $this->Grupo_model->listar();
		$listado_grupo['origen'] = $this->Requerimiento_origen_model->listar();
		$this->load->view('trabajadores/modal_requerimiento',$listado_grupo);
	}

	function req_ajax(){
		$id = $_POST['id'];
		$this->load->model("Requerimientos_model");
		$salida = $this->Requerimientos_model->listar_grupo($id);
		echo json_encode($salida);
	}
	function asign_ajax(){
		$id = $_POST['id'];
		$this->load->model("Requerimientos_model");
		$salida = $this->Requerimientos_model->get($id);
		echo json_encode($salida);
	}
	function trabajadores_ajax(){
		$id = $_REQUEST['id'];
		$this->load->model("Usuarios_model");
		foreach ($id as $v) {
			$salida[] = $this->Usuarios_model->get($v);
		}
		
		echo json_encode($salida);
	}

	function origen_ajax(){
		$this->load->model("Requerimiento_origen_model");
		$salida = $this->Requerimiento_origen_model->listar();
		
		echo json_encode($salida);
	}

	function sesion_usuarios_req(){
		$this->load->library('session');
		$tipo = $_GET['tipo']; //agrega o quita usuario
		$usr = $_GET['usuario']; //ID usuario
		$listado = array();
		$data = array(
			'tipo' => $tipo,
			'id' => $usr
		);
		if( is_array($this->session->flashdata('usr_req')) ){
			$this->session->keep_flashdata('usr_req');
			array_push($listado,$this->session->flashdata('usr_req') );
			array_push($listado,$data);
			//$data = array_merge( $data , $this->session->flashdata('usr_req'));
			$this->session->set_flashdata('usr_req', $listado);
		}
		else{
			$this->session->set_flashdata('usr_req', $data);
		}

		print_r($this->session->flashdata('usr_req'));

	}

	function rut_existe(){
		$this->load->model("Usuarios_model");
		$rut = $_GET['rut'];

		$salida = $this->Usuarios_model->get_rut($rut);

		if(is_array($salida))
			echo false;
		else
			echo true;

	}

	function requerimiento_ajax(){
		$trab = $_POST['trabajadores'];
		$idre = $_POST['id'];
		$origen = $_POST['origen'];
		$this->load->model("Asignarrequerimiento_model");
		$this->load->model("Requerimientos_model");

		$r = $this->Requerimientos_model->get($idre);

		foreach ($trab as $v) {
			$data = array(
				'id_r_requerimiento' => $idre, 
				'id_usuarios' => $v,
				'id_requerimiento_origen' => $origen,
				'f_inicio' => $r->f_inicio,
				'f_fin' => $r->f_fin
			);
			$this->Asignarrequerimiento_model->ingresar($data);
		}
		//$this->session->set_flashdata('req_guardado', 'true');
		echo "guardado";
	}
	function filtrar(){
		$this->load->library('encrypt');
		
		if(empty($_POST['nombre']) ) $_POST['nombre'] = FALSE;
		if(empty($_POST['rut']) ) $_POST['rut'] = FALSE;
		if(empty($_POST['profesion']) ) $_POST['profesion'] = FALSE;
		if(empty($_POST['especialidad']) ) $_POST['especialidad'] = FALSE;
		if(empty($_POST['ciudad']) ) $_POST['ciudad'] = FALSE;
		if(empty($_POST['clave']) ) $_POST['clave'] = FALSE;
		$url = "nombre/".$_POST['nombre']."/rut/".$_POST['rut']."/profesion/".$_POST['profesion']."/especialidad/".$_POST['especialidad']."/ciudad/".$_POST['ciudad']."/clave/".$_POST['clave'];
		$enc = urlencode($this->encrypt->encode($url));
		redirect('/administracion/trabajadores/buscar/filtro/'.$enc, 'refresh');
	}
	function evaluar() {
		$base['titulo'] = "Evaluar trabajador";
		$base['lugar'] = "Evaluaciones";
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function editar($id,$msg = FALSE){
		$this->load->model('Usuarios_model');
		$this->load->model('Estadocivil_model');
		$this->load->model('Bancos_model');
		$this->load->model('Afp_model');
		$this->load->model('Excajas_model');
		$this->load->model('Region_model');
		$this->load->model('Provincia_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Salud_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Profesiones_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_model");
		$this->load->model("Experiencia_model");
		
		$base['titulo'] = "Editar mi perfil";
		$base['lugar'] = "Editar Perfil";
		
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
			$aviso['titulo'] = "La contraseña ah sido cambiada exitosamente";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "img_exito"){
			$aviso['titulo'] = "La imagen ah sido cambiada exitosamente";
			$pagina['aviso_imagen'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_exito"){
			$aviso['titulo'] = "El archivo fue guardado exitosamente";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_vacio"){
			$aviso['titulo'] = "Tiene que adjuntar un archivo, esta vacio";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_error0"){
			$aviso['titulo'] = "El archivo tiene una extención no soportada";;
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_error1"){
			$aviso['titulo'] = "No se pudo guardar el archivo, intente nuevamente";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_borrar_exito"){
			$aviso['titulo'] = "El archivo fue borrardo exitosamente";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_repetido"){
			$aviso['titulo'] = "El curriculum no puede ser ingresado 2 veces, favor borrar el archivo anterior";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "email_invalido"){
			$aviso['titulo'] = "El email ingresado es invalido";
			$pagina['aviso_personal'] = $this->load->view('avisos',$aviso,TRUE);
		}
		/***************************/

		$arch = $this->Archivos_model->get_usuario($id);
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
		
		
		$pagina['usuario'] = $this->Usuarios_model->get($id);
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
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$pagina['listado_tipo'] = $this->Tipoarchivos_model->listar();
		$pagina['listado_archivos'] = $this->Archivos_model->get_usuario($id);
		$pagina['experiencia'] = $this->Experiencia_model->get_usuario($id);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Novienbre","Diciembre");
		$base['cuerpo'] = $this->load->view('trabajadores/editar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}


	public function ajax_modal_experiencia($id_usr, $id_exp = false){
		$this->load->model("Experiencia_model");
		$base['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$base['form_url'] = 'administracion/trabajadores/guardar_experiencia/'.$id_usr;
		if( $id_exp ) {
			$base['exp'] = $this->Experiencia_model->get($id_exp);
			$base['form_url'] = 'administracion/trabajadores/editar_experiencia/'.$id_usr;
		}
		$this->load->view('trabajadores/modal_experiencia',$base);
	}
	
	function eliminar_experiencia($id_usr,$id_exp){
		$this->load->model("Experiencia_model");
		$this->Experiencia_model->borrar($id_exp);
		redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
	}
	
	function guardar_experiencia($id_usr) {
		if( empty( $_POST['select_dia_desde'] ) || empty( $_POST['select_mes_desde'] ) || empty( $_POST['select_ano_desde'] ) || 
		empty( $_POST['select_dia_hasta'] ) || empty( $_POST['select_mes_hasta'] ) || empty( $_POST['select_ano_hasta'] ) ||
		empty( $_POST['cargo'] ) || empty( $_POST['area'] ) || empty( $_POST['contratista'] ) || empty( $_POST['funciones'] ) ){
			redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
		}
		else{
			$fecha1 = $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'];
			$fecha2 = $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'];
			
			if( (strtotime($fecha2) - strtotime($fecha1)) < 0 )
				redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
			else{
				$this->load->model("Experiencia_model");
				$data = array(
					'id_usuarios' => $id_usr,
					'desde' => $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'],
					'hasta' => $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'],
					'cargo' => $_POST['cargo'],
					'area' => $_POST['area'],
					'empresa_c' => $_POST['contratista'],
					'empresa_m' => $_POST['mandante'],
					'funciones' => $_POST['funciones'],
					'referencias' => $_POST['referencias']
				);
				$this->Experiencia_model->ingresar($data);
				redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
			}
		}
	}

	function editar_experiencia($id_usr, $id_exp){
		if( empty( $_POST['select_dia_desde'] ) || empty( $_POST['select_mes_desde'] ) || empty( $_POST['select_ano_desde'] ) || 
		empty( $_POST['select_dia_hasta'] ) || empty( $_POST['select_mes_hasta'] ) || empty( $_POST['select_ano_hasta'] ) ||
		empty( $_POST['cargo'] ) || empty( $_POST['area'] ) || empty( $_POST['contratista'] ) || empty( $_POST['funciones'] ) ){
			redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
		}
		else{
			$fecha1 = $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'];
			$fecha2 = $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'];
			
			if( (strtotime($fecha2) - strtotime($fecha1)) < 0 )
				redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
			else{
				$this->load->model("Experiencia_model");
				$data = array(
					'desde' => $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'],
					'hasta' => $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'],
					'cargo' => $_POST['cargo'],
					'area' => $_POST['area'],
					'empresa_c' => $_POST['contratista'],
					'empresa_m' => $_POST['mandante'],
					'funciones' => $_POST['funciones'],
					'referencias' => $_POST['referencias']
				);
				$this->Experiencia_model->editar($id_exp,$data);
				redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
			}
		}
	}

	function guardar(){
		$data = array(
			'nombres' => trim($_POST['nombres']),
			'paterno' => trim($_POST['paterno']),
			'materno' => trim($_POST['materno']),
			'rut_usuario' => trim($_POST['rut']),
			'fono1' => trim($_POST['fono1']),
			'fono2' => trim($_POST['fono2']),
			'fono3' => trim($_POST['fono3']),
			'fono4' => trim($_POST['fono4']),
			'direccion' => trim($_POST['direccion']),
			'email' => trim($_POST['email']),
			'id_regiones' => $_POST['select_region'],
			'id_provincias' => $_POST['select_provincia'],
			'id_ciudades' => $_POST['select_ciudad'],
			'nacionalidad' => trim($_POST['nacionalidad']),
			'nac_dia' => $_POST['select_nac_dia'],
			'nac_mes' => $_POST['select_nac_mes'],
			'nac_ano' => $_POST['select_nac_ano'],
			'id_afp' => $_POST['select_afp'],
			'id_salud' => $_POST['select_salud'],
			'sexo' => $_POST['select_sexo'],
			'id_estadocivil' => $_POST['select_civil'],
			'id_profesiones' => $_POST['select_profesion'],
			'id_bancos' => $_POST['select_banco'],
			'id_especialidad_trabajador' => $_POST['select_especialidad'],
			'id_especialidad_trabajador_2' => $_POST['select_especialidad2'],
			'tipo_cuenta' => trim($_POST['t_cuenta']),
			'cuenta_banco' => trim($_POST['n_cuenta']),
			'talla_buzo' => trim($_POST['select_talla']),
			'num_zapato' => trim($_POST['n_zapato']),
			'licencia' => trim($_POST['licencia']),
			'id_estudios' => $_POST['select_estudios'],
			'institucion' => trim($_POST['institucion']),
			'ano_egreso' => trim($_POST['a_egreso']),
			'ano_experiencia' => trim($_POST['a_experiencia']),
			'cursos' => trim($_POST['cursos']),
			'equipos' => trim($_POST['equipos']),
			'software' => trim($_POST['software']),
			'idiomas' => trim($_POST['idiomas'])
		);
		$this->session->set_flashdata('ingreso', $data);
		
		if(empty($_POST['nombres']) || empty($_POST['paterno']) || empty($_POST['materno']) || empty($_POST['rut']) || empty($_POST['fono1'])  || empty($_POST['fono2'])
		|| empty($_POST['direccion']) || empty($_POST['pass1']) || empty($_POST['pass2']) || empty($_POST['select_region']) || empty($_POST['select_provincia']) || 
		 empty($_POST['select_ciudad']) ){
		 	redirect('administracion/trabajadores/agregar/error_vacio', 'refresh');
		 }
		else{
			if($_POST['pass1'] != $_POST['pass2']){
				redirect('administracion/trabajadores/agregar/error_pass', 'refresh');
			}
			else{
				if(!empty($_POST['email'])){
					if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
						redirect('administracion/trabajadores/agregar/error_email_valid', 'refresh');
					}
				}
				$this->load->model("Usuarios_model");
				if($this->Usuarios_model->get_rut(mb_strtoupper($_POST['rut'], 'UTF-8')))
					redirect('administracion/trabajadores/agregar/error_rut', 'refresh');
				else{
					if(empty($_POST['select_banco'])) $_POST['select_banco'] = NULL;
					if(empty($_POST['fono1'])|| empty($_POST['fono2'])) $fono1 = NULL;
					else $fono1 = trim($_POST['fono1']).'-'.trim($_POST['fono2']);
					if(empty($_POST['fono3'])|| empty($_POST['fono4'])) $fono2 = NULL;
					else $fono2 = trim($_POST['fono3']).'-'.trim($_POST['fono4']);
					if(empty($_POST['select_nac_ano']) || empty($_POST['select_nac_mes']) || empty($_POST['select_nac_dia']) )
						$nacimiento = NULL;
					else $nacimiento = $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'];
					$_POST['t_cuenta'] = trim($_POST['t_cuenta']);
					if(empty($_POST['email'])) $_POST['email'] = NULL;
					if(empty($_POST['nacionalidad'])) $_POST['nacionalidad'] = NULL;
					if(empty($_POST['select_afp'])) $_POST['select_afp'] = NULL;
					if(empty($_POST['select_salud'])) $_POST['select_salud'] = NULL;
					if(empty($_POST['select_civil'])) $_POST['select_civil'] = NULL;
					if(empty($_POST['select_profesion'])) $_POST['select_profesion'] = NULL;
					if(empty($_POST['select_especialidad'])) $_POST['select_especialidad'] = NULL;
					if(empty($_POST['select_especialidad2'])) $_POST['select_especialidad2'] = NULL;
					if(empty($_POST['t_cuenta'])) $_POST['t_cuenta'] = NULL;
					if(empty($_POST['n_cuenta'])) $_POST['n_cuenta'] = NULL;
					if(empty($_POST['select_talla'])) $_POST['select_talla'] = NULL;
					if(empty($_POST['n_zapato'])) $_POST['n_zapato'] = NULL;
					if(empty($_POST['licencia'])) $_POST['licencia'] = NULL;
					if(empty($_POST['select_estudios'])) $_POST['select_estudios'] = NULL;
					if(empty($_POST['institucion'])) $_POST['institucion'] = NULL;
					if(empty($_POST['a_egreso'])) $_POST['a_egreso'] = NULL;
					if(empty($_POST['a_experiencia'])) $_POST['a_experiencia'] = NULL;
					if(empty($_POST['cursos'])) $_POST['cursos'] = NULL;
					if(empty($_POST['equipos'])) $_POST['equipos'] = NULL;
					if(empty($_POST['software'])) $_POST['software'] = NULL;
					if(empty($_POST['idiomas'])) $_POST['idiomas'] = NULL;
					
					$data2 = array(
					'id_tipo_usuarios' => 2,
					'nombres' => mb_strtoupper(trim($_POST['nombres']), 'UTF-8'),
					'paterno' => mb_strtoupper(trim($_POST['paterno']), 'UTF-8'),
					'materno' => mb_strtoupper(trim($_POST['materno']), 'UTF-8'),
					'rut_usuario' => mb_strtoupper(trim($_POST['rut']), 'UTF-8'),
					'fono' => $fono1,
					'telefono2' => $fono2,
					'direccion' => mb_strtoupper(trim($_POST['direccion']), 'UTF-8'),
					'email' => mb_strtoupper(trim($_POST['email']), 'UTF-8'),
					'clave' => hash("sha512", trim($_POST['pass1'])),
					'id_regiones' => $_POST['select_region'],
					'id_provincias' => $_POST['select_provincia'],
					'id_ciudades' => $_POST['select_ciudad'],
					'nacionalidad' => trim($_POST['nacionalidad']),
					'fecha_nac' => $nacimiento,
					'id_afp' => $_POST['select_afp'],
					'id_salud' => $_POST['select_salud'],
					'sexo' => $_POST['select_sexo'],
					'id_estadocivil' => $_POST['select_civil'],
					'id_profesiones' => $_POST['select_profesion'],
					'id_bancos' => $_POST['select_banco'],
					'id_especialidad_trabajador' => $_POST['select_especialidad'],
					'id_especialidad_trabajador_2' => $_POST['select_especialidad2'],
					'tipo_cuenta' => mb_strtoupper(trim($_POST['t_cuenta']), 'UTF-8'),
					'cuenta_banco' => trim($_POST['n_cuenta']),
					'talla_buzo' => $_POST['select_talla'],
					'num_zapato' => trim($_POST['n_zapato']),
					'licencia' => mb_strtoupper(trim($_POST['licencia']), 'UTF-8'),
					'id_estudios' => $_POST['select_estudios'],
					'institucion' => trim($_POST['institucion']),
					'ano_egreso' => trim($_POST['a_egreso']),
					'ano_experiencia' => trim($_POST['a_experiencia']),
					'cursos' => trim($_POST['cursos']),
					'equipos' => trim($_POST['equipos']),
					'software' => trim($_POST['software']),
					'idiomas' => trim($_POST['idiomas'])
					);
					$id_salida = $this->Usuarios_model->ingresar($data2);
					redirect('administracion/trabajadores/editar/'.$id_salida.'#datos-personales', 'refresh');
				}
			}
		}
	}

	function guardar_personales($id){
		$this->load->model('Usuarios_model');
		date_default_timezone_set('America/Santiago');
		
		if(empty($_POST['nombres'])) $_POST['nombres'] = NULL;
		if(empty($_POST['paterno'])) $_POST['paterno'] = NULL;
		if(empty($_POST['direccion'])) $_POST['direccion'] = NULL;
		if(empty($_POST['select_sexo'])) $_POST['select_sexo'] = NULL;
		if(empty($_POST['email'])) $_POST['email'] = NULL;
		if(empty($_POST['select_civil'])) $_POST['select_civil'] = NULL;
		if(empty($_POST['select_nacionalidad'])) $_POST['select_nacionalidad'] = NULL;
		if(empty($_POST['select_nac_ano']) || empty($_POST['select_nac_mes']) || empty($_POST['select_nac_dia']) ) $nacimiento = FALSE;
		else $nacimiento = $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'];
		if( empty($_POST['fono_1']) || empty($_POST['fono_2']) ) $fono1 = NULL;
		else $fono1 = trim($_POST['fono_1'])."-".trim($_POST['fono_2']);
		if( empty($_POST['fono_3']) || empty($_POST['fono_3']) ) $fono2 = NULL;
		else $fono2 = trim($_POST['fono_3'])."-".trim($_POST['fono_4']);

		if(!empty($_POST['email'])){
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				redirect('administracion/trabajadores/editar/'.$id.'/email_invalido#datos-personales', 'refresh');
			}
		}
		
		$data = array(
			'nombres' => trim($_POST['nombres']),
			'paterno' => trim($_POST['paterno']),
			'materno' => trim($_POST['materno']),
			'fecha_nac' => $nacimiento,
			'direccion' => trim($_POST['direccion']),
			'sexo' => $_POST['select_sexo'],
			'fono' => $fono1,
			'telefono2' => $fono2,
			'email' => trim($_POST['email']),
			'id_estadocivil' => $_POST['select_civil'],
			'id_ciudades' => $_POST['select_ciudad'],
			'nacionalidad' => $_POST['select_nacionalidad'],
			'fecha_actualizacion' => date('Y-m-d')
		);
		$this->Usuarios_model->editar($id,$data);
		redirect('administracion/trabajadores/editar/'.$id.'#datos-personales', 'refresh');
	}

	function guardar_tecnicos($id){
		$this->load->model('Usuarios_model');
		date_default_timezone_set('America/Santiago');
		
		if( empty($_POST['select_nivelestudios']) ) $_POST['select_nivelestudios'] = NULL;
		if( empty($_POST['nb_institucion']) ) $_POST['nb_institucion'] = NULL;
		if( empty($_POST['ano_egreso']) ) $_POST['ano_egreso'] = NULL;
		if( empty($_POST['select_profesion']) ) $_POST['select_profesion'] = NULL;
		if( empty($_POST['select_especialidad1']) ) $_POST['select_especialidad1'] = NULL;
		if( empty($_POST['select_especialidad2']) ) $_POST['select_especialidad2'] = NULL;
		if( empty($_POST['ano_experiencia']) ) $_POST['ano_experiencia'] = NULL;
		if( empty($_POST['cursos']) ) $_POST['cursos'] = NULL;
		if( empty($_POST['equipos']) ) $_POST['equipos'] = NULL;
		if( empty($_POST['software']) ) $_POST['software'] = NULL;
		if( empty($_POST['idiomas']) ) $_POST['idiomas'] = NULL;
		
		$data = array(
			'id_estudios' => $_POST['select_nivelestudios'],
			'institucion' => trim($_POST['nb_institucion']),
			'ano_egreso' => trim($_POST['ano_egreso']),
			'id_profesiones' => $_POST['select_profesion'],
			'id_especialidad_trabajador' => $_POST['select_especialidad1'],
			'id_especialidad_trabajador_2' => $_POST['select_especialidad2'],
			'ano_experiencia' => trim($_POST['ano_experiencia']),
			'cursos' => trim($_POST['cursos']),
			'equipos' => trim($_POST['equipos']),
			'software' => trim($_POST['software']),
			'idiomas' => trim($_POST['idiomas']),
			'fecha_actualizacion' => date('Y-m-d')
		);
		$this->Usuarios_model->editar($id,$data);
		redirect('administracion/trabajadores/editar/'.$id.'#datos-tecnicos', 'refresh');
	}

	function guardar_extras($id){
		$this->load->model('Usuarios_model');
		date_default_timezone_set('America/Santiago');
		
		if(empty($_POST['tipo_cuenta'])) $_POST['tipo_cuenta'] = NULL;
		if(empty($_POST['n_cuenta'])) $_POST['n_cuenta'] = NULL;
		if(empty($_POST['select_afp'])) $_POST['select_afp'] = NULL;
		if(empty($_POST['select_salud'])) $_POST['select_salud'] = NULL;
		if(empty($_POST['licencia'])) $_POST['licencia'] = NULL;
		if(empty($_POST['zapato'])) $_POST['zapato'] = NULL;
		if(empty($_POST['select_talla'])) $_POST['select_talla'] = NULL;
		
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
		redirect('administracion/trabajadores/editar/'.$id.'#datos-extras', 'refresh');
	}

	function guardar_archivo($id){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("Tipoarchivos_model");
			$this->load->model("Archivos_model");
			$this->load->model("Usuarios_model");

			if($_POST['select_archivo'] == 13){
				$la = $this->Archivos_model->get_usuario($id);
				foreach ($la as $l) {
				 	if( $l->id_tipoarchivo == 13)
				 		redirect('administracion/trabajadores/editar/'.$id.'/archivo_repetido#datos-archivo', 'refresh');
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
				redirect('administracion/trabajadores/editar/'.$id.'/archivo_error0#datos-archivo', 'refresh');
			elseif($salida==2)
				redirect('administracion/trabajadores/editar/'.$id.'/archivo_error1#datos-archivo', 'refresh');
			else{
				$data = array(
					'id_usuarios' => $id,
					'nombre' => $nb_archivo,
					'id_tipoarchivo' => $_POST['select_archivo'],
					'url' => $salida
 				);
				$this->Archivos_model->ingresar($data);
				redirect('administracion/trabajadores/editar/'.$id.'/archivo_exito#datos-archivo', 'refresh');
			}
		}
		else redirect('administracion/trabajadores/editar/'.$id.'/archivo_vacio#datos-archivo', 'refresh');
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
			redirect('administracion/trabajadores/editar/'.$id.'/img_exito#datos-imagen', 'refresh');
		}
		else{
			redirect('administracion/trabajadores/editar/'.$id.'/img_error#datos-imagen', 'refresh');
		}
	}

	function cambiar_contrasena($id){
		if( empty($_POST['pass_nueva1']) || empty($_POST['pass_nueva2']) ){
			redirect('administracion/trabajadores/editar/'.$id.'/pass_vacio#datos-pass', 'refresh');
		}
		else{
			if(trim($_POST['pass_nueva1']) == trim($_POST['pass_nueva2'])){
				$this->load->model('Usuarios_model');
				$data = array("clave" => hash("sha512", $_POST['pass_nueva1']));
				$this->Usuarios_model->editar($id,$data);
				redirect('administracion/trabajadores/editar/'.$id.'/pass_exito#datos-pass', 'refresh');
			}
			else
				redirect('administracion/trabajadores/editar/'.$id.'/pass_error1#datos-pass', 'refresh');
		}
	}
	
	function eliminar_trabajador($id){
		$this->load->model('Usuarios_model');
		$this->Usuarios_model->eliminar($id);
	}
	
	function desactivar($id){
		$this->load->model('Usuarios_model');
		$u = $this->Usuarios_model->get($id);
		if ($u->activo == 0){
			$data = array(
				'activo' => 1,
			);
			$s = 1;
		}
		else{
			$data = array(
				'activo' => 0,
			);
			$s = 0;
		}
		
		$this->Usuarios_model->editar($id,$data);
		return $s;
	}

	function eliminar_archivo($id_usuario,$id_archivo){
		$this->load->model("Archivos_model");
		$arch = $this->Archivos_model->get($id_archivo);
		unlink(getcwd().'/'.$arch->url);
		$this->Archivos_model->eliminar($id_archivo);
		redirect('administracion/trabajadores/editar/'.$id_usuario.'/archivo_borrar_exito#datos-archivo', 'refresh');
	}
	
	function subir(){
		$this->load->model("Usuarios_model");
		$this->load->model("Bancos_model");
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Afp_model");
		$this->load->model("Excajas_model");
		$this->load->model("Salud_model");
		$this->load->model("Nivelestudios_model");
		
		$this->load->helper("archivo");
		$this->load->helper("excel");
		$base['titulo'] = "Log de Subida de Trabajador";
		$base['lugar'] = "Log Trabajador";
		
		if($_FILES['archivo']['error'] == 0){
			$salida = trabajadores($_FILES, 'archivo', 'extras/docs_temp/','trabajadores');
			if($salida == 1)
				redirect('administracion/trabajadores/subir_archivo/error_formato', 'refresh');
			elseif($salida == 2)
				redirect('administracion/trabajadores/subir_archivo/error_copiar', 'refresh');
			else{
				
				$lista_texto = array('RUT','NOMBRES','APELLIDO PATERNO','APELLIDO MATERNO','DIRECCIÓN','CORREO ELECTRÓNICO','TELÉFONO','TELÉFONO 2','REGIÓN','PROVINCIA','CIUDAD','FECHA NACIMIENTO','NACIONALIDAD','SEXO','ESTADO CIVIL','PROFESION','BANCO','TIPO DE CUENTA','NUMERO DE CUENTA','ESPECIALIDAD 1','ESPECIALIDAD 2','ESPECIALIDAD 3','AFP','EXCAJA','SALUD','NUMERO DE ZAPATO','TALLA DE BUZO','LICENCIA','ESTUDIOS','INSTIUCIÓN','AÑO DE EGRESO','AÑOS DE EXPERIENCIA','CURSOS','EQUIPOS','SOFTWARE','IDIOMAS');
				$lista_asoc = array('rut_usuario','nombres','paterno','materno','direccion','email','fono','telefono2','id_regiones','id_provincias','id_ciudades','fecha_nac','nacionalidad','sexo','id_estadocivil','id_profesiones','id_bancos','tipo_cuenta','cuenta_banco','id_especialidad_trabajador','id_especialidad_trabajador_2','id_especialidad_trabajador_3','id_afp','id_excajas','id_salud','num_zapato','talla_buzo','licencia','id_estudios','institucion','ano_egreso','ano_experiencia','cursos','equipos','software','idiomas');
				//$loadPHPExcel->load($ruta_prin.$salida);
				//echo $salida;
				$salida = importar_trabajadores($salida, $lista_texto, $lista_asoc);
				
				//validar si la table contiene datos llenos y/o sin los nombres correctos
				
				
			}
		}
		else{
			redirect('administracion/trabajadores/subir_archivo/error', 'refresh');
		}
		if(count($salida['correcto']) > 0){
			$consulta = $salida['consulta'];
			$totales = count($salida['correcto']);
			$i = 0;
			foreach($salida['correcto'] as $c){
				$i++;
				$consulta.= $c;
				if( $totales > $i ) $consulta.=',';
			}
			$consulta.=";";
			$this->Usuarios_model->manual($consulta);
		}
		
		$pagina['resultados'] = $salida;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/subir_errores',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function generar_excel(){
		$this->load->model("Usuarios_model");
		$this->load->model("Bancos_model");
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Afp_model");
		$this->load->model("Excajas_model");
		$this->load->model("Salud_model");
		$this->load->model("Nivelestudios_model");
		
		
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		
		$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
		$ruta_prin = $ruta_prin[0];
		
		$objPHPExcel = new PHPExcel();
		$sheet = $objPHPExcel->getActiveSheet();
		$styleArray = array(
			'font' => array('bold' => true)
		);
		$lista_celdas = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1','T1','U1','V1','W1','X1','Y1','Z1','AA1','AB1','AC1','AD1','AE1','AF1','AG1','AH1','AI1','AJ1');
		$lista_texto = array('RUT','NOMBRES','APELLIDO PATERNO','APELLIDO MATERNO','DIRECCIÓN','CORREO ELECTRÓNICO','TELÉFONO','TELÉFONO 2','REGIÓN','PROVINCIA','CIUDAD','FECHA NACIMIENTO','NACIONALIDAD','SEXO','ESTADO CIVIL','PROFESION','BANCO','TIPO DE CUENTA','NUMERO DE CUENTA','ESPECIALIDAD 1','ESPECIALIDAD 2','ESPECIALIDAD 3','AFP','EXCAJA','SALUD','NUMERO DE ZAPATO','TALLA DE BUZO','LICENCIA','ESTUDIOS','INSTIUCIÓN','AÑO DE EGRESO','AÑOS DE EXPERIENCIA','CURSOS','EQUIPOS','SOFTWARE','IDIOMAS');
		for($i=0;$i<count($lista_celdas);$i++){ //llenar los titulos del excel, la primera fila
			$sheet->setCellValue($lista_celdas[$i], $lista_texto[$i]);
			$sheet->getStyle($lista_celdas[$i])->applyFromArray($styleArray);
		}
		$l = 2;
		foreach($this->Bancos_model->listar() as $b){ //llenar el listado de bancos en una celda
			$sheet->setCellValue('Q'.$l, $b->desc_bancos);
			$l++;
		}
		$sheet->setCellValue('G2', '041-123456'); //ejemplo de telefono
		$sheet->setCellValue('H2', '09-87654321'); //ejemplo de celular
		$r = 2;
		foreach($this->Region_model->listar() as $b){ //llenar el listado de regiones en una celda
			$sheet->setCellValue('I'.$r, $b->desc_regiones);
			$r++;
		}
		$p = 2;
		foreach($this->Provincia_model->listar() as $b){ //llenar el listado de provincias en una celda
			$sheet->setCellValue('J'.$p, $b->desc_provincias);
			$p++;
		}
		$c = 2;
		foreach($this->Ciudad_model->listar() as $b){ //llenar el listado de ciudades en una celda
			$sheet->setCellValue('K'.$c, $b->desc_ciudades);
			$c++;
		}
		$sheet->setCellValue('L2', '30-01-1970'); //ejemplo de fecha de nacimiento
		$sheet->setCellValue('M2', 'CHILENA'); //ejemplo de nacionalidad
		$sheet->setCellValue('M3', 'EXTRANJERA'); //ejemplo de nacionalidad
		$sheet->setCellValue('N2', 'MASCULINO'); //ejemplo de sexo
		$sheet->setCellValue('N3', 'FEMENINO'); //ejemplo de sexo
		$e = 2;
		foreach($this->Estadocivil_model->listar() as $b){ //llenar el listado de estados civiles en una celda
			$sheet->setCellValue('O'.$e, $b->desc_estadocivil);
			$e++;
		}
		$p = 2;
		foreach($this->Profesiones_model->listar() as $b){ //llenar el listado de profesiones en una celda
			$sheet->setCellValue('P'.$p, $b->desc_profesiones);
			$p++;
		}
		$e = 2;
		foreach($this->Especialidadtrabajador_model->listar() as $b){ //llenar el listado de especialidades en una celda
			$sheet->setCellValue('T'.$e, $b->desc_especialidad);
			$e++;
		}
		$a = 2;
		foreach($this->Afp_model->listar() as $b){ //llenar el listado de afp's en una celda
			$sheet->setCellValue('W'.$a, $b->desc_afp);
			$a++;
		}
		$e = 2;
		foreach($this->Excajas_model->listar() as $b){ //llenar el listado de afp's en una celda
			$sheet->setCellValue('X'.$e, $b->desc_excaja);
			$e++;
		}
		$s = 2;
		foreach($this->Salud_model->listar() as $b){ //llenar el listado de sistemas de salud en una celda
			$sheet->setCellValue('Y'.$s, $b->desc_salud);
			$s++;
		}
		$s = 2;
		foreach($this->Nivelestudios_model->listar() as $b){ //llenar el listado de niveles de estudios en una celda
			$sheet->setCellValue('AC'.$s, $b->desc_nivelestudios);
			$s++;
		}
		
		$objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save($ruta_prin.'extras/docs_temp/excel_trabajador_tmp.xls');
		header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=excel_trabajador_tmp.xls');
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($ruta_prin.'extras/docs_temp/excel_trabajador_tmp.xls'));
	    ob_clean();
	    flush();
		readfile($ruta_prin.'extras/docs_temp/excel_trabajador_tmp.xls');
	}

	function anotaciones($id){
		$base['titulo'] = "Anotaciones de Trabajador";
		$base['lugar'] = "Anotaciones";

		$this->load->model('Usuarios_model');
		$this->load->model('Fotostrab_model');
		$this->load->model('Tipousuarios_model');
		$this->load->model("Listanegra_model");

		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Usuarios_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');

		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		if( $this->Fotostrab_model->get_usuario($pagina['usuario']->id) )
			$img_grande = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		else{
			$img_grande->nombre_archivo = 'extras/img/perfil/avatar.jpg';
			$img_grande->thumb = 'extras/img/perfil/avatar.jpg';
		}
		$pagina['imagen_grande'] = $img_grande;
		$pagina['listado'] = $this->Listanegra_model->listar_trabajador($id);
		$pagina['id'] = $id;


		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/anotaciones',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function guardar_anotacion($id){
		$tipo = $_POST['tipo'];
		$fecha = $_POST['fecha'];
		$fecha = explode('-', $fecha);
		$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
		$texto = $_POST['texto'];
		$quien = $_POST['quien'];
		$archivo = $_FILES['attach'];

		if($_FILES['attach']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("Listanegra_model");
			$this->load->model("Usuarios_model");
			
			$usuario = $this->Usuarios_model->get($id);
			$aux = str_replace(" ", "_", $usuario->nombres);
			$ape = $aux."_".$usuario->paterno.'_'.$usuario->materno;
			$nb_archivo = strtolower($ape);
			$nb_archivo = normaliza($nb_archivo);
			$salida = subir($_FILES,"attach","extras/lista/",$nb_archivo);

			if($salida == 1)
				redirect('administracion/trabajadores/anotaciones/'.$id, 'refresh');
			elseif($salida==2)
				redirect('administracion/trabajadores/anotaciones/'.$id, 'refresh');
			else{
				$data = array(
					'id_usuario' => $id,
					'archivo' => $salida,
					'tipo' => $tipo,
					'fecha' => $fecha,
					'anotacion' => $texto,
					'quien' => $quien,
 				);
				$this->Listanegra_model->ingresar($data);
				redirect('administracion/trabajadores/anotaciones/'.$id, 'refresh');
			}
		}
		else redirect('administracion/trabajadores/anotaciones/'.$id, 'refresh');
	}

	function editar_anotaciones(){
		$this->load->model("Listanegra_model");

		print_r($_POST);

		if ($_POST['name'] == "tipo"){
			$id = $_POST['pk'];

			$data = array(
				'tipo' => $_POST['value'],
			);

			$this->Listanegra_model->editar($id,$data);
		}

		if ($_POST['name'] == "fecha"){
			$id = $_POST['pk'];

			$data = array(
				'fecha' => $_POST['value'],
			);

			$this->Listanegra_model->editar($id,$data);
		}

		if ($_POST['name'] == "anotacion"){
			$id = $_POST['pk'];

			$data = array(
				'anotacion' => $_POST['value'],
			);

			$this->Listanegra_model->editar($id,$data);
		}


		if ($_POST['name'] == "quien"){
			$id = $_POST['pk'];

			$data = array(
				'quien' => $_POST['value'],
			);

			$this->Listanegra_model->editar($id,$data);
		}
	}

	function buscar_nuevo(){
		$this->load->library('encrypt');
		$this->load->helper('url');
		
		$base['titulo'] = "Listado trabajadores";
		$base['lugar'] = "Listado trabajadores";
		
		$this->load->model("Usuarios_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Listanegra_model");
		
		$por_pag = 15;
		$num_pagina = $this->uri->segment(5, 0);
		
		if ($num_pagina == 0 || empty($num_pagina)){
			$comienzo = 0;
			$num_pagina = 1;
		}
		else{
			$comienzo = ($num_pagina - 1) * $por_pag;
		}

		if( isset($_GET['filtro']) ){
			$pagina['filtro'] = $_GET['filtro'];
			$listado_trabajadores = $this->Usuarios_model->listar_trabajadores_paginado_filtrado($_GET['filtro'],$comienzo,$por_pag);
			$total_registros = $this->Usuarios_model->listar_trabajadores_paginado_filtrado_totales($_GET['filtro']);

			$total_paginas = ceil($total_registros / $por_pag);

			if(($num_pagina - 1) > 0) $num_ant = $num_pagina - 1;
			else $num_ant = 1;
			if(($num_pagina + 1) <= $total_paginas) $num_sig = $num_pagina + 1;
			else $num_sig = $total_paginas;

			$num_ant = $num_ant.'?filtro='.$_GET['filtro'];
			$num_sig = $num_sig.'?filtro='.$_GET['filtro'];
		}
		else{
			$pagina['filtro'] = "";
			$listado_trabajadores = $this->Usuarios_model->listar_trabajadores_paginado($comienzo,$por_pag);	
			$total_registros = $this->Usuarios_model->listar_trabajadores_totales();

			$total_paginas = ceil($total_registros / $por_pag);

			if(($num_pagina - 1) > 0) $num_ant = $num_pagina - 1;
			else $num_ant = 1;
			if(($num_pagina + 1) <= $total_paginas) $num_sig = $num_pagina + 1;
			else $num_sig = $total_paginas;
		}

		$pagina['ant'] = $num_ant;
		$pagina['sig'] = $num_sig;

		$lista2 = array();
		if (isset($listado_trabajadores )){
			foreach($listado_trabajadores as $l ){
				$aux = new stdClass();
				//$usr = $this->Usuarios_model->get($r->id_usuarios);
				$m = $this->Evaluaciones_model->get_una_masso($l->id_user);
				$p = $this->Evaluaciones_model->get_una_preocupacional($l->id_user);
				$n = $this->Listanegra_model->listar_trabajador($l->id_user);
				$aux->id_user = $l->id_user;
				$aux->rut_usuario = $l->rut_usuario;
				$aux->fono = $l->fono;
				$aux->fecha_actualizacion = $l->fecha_actualizacion;
				$aux->desc_ciudades = ($l->desc_ciudades)? ucfirst(strtolower($l->desc_ciudades)):'No Ingresada';
				$aux->nombres = ucwords(mb_strtolower($l->nombres.' '.$l->paterno.' '.$l->materno,'UTF-8'));
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

				if(empty($n)){
					$aux->ln = 0;
				}
				else{
					$cont_g = 0;
					$cont_ln = 0;
					$cont_lnp = 0;
					foreach ($n as $n) {
						if($n->tipo == "-"){
							$cont_g += 1;
						}
						if($n->tipo == "LNP"){
							$cont_lnp += 1;
						}
						if($n->tipo == "LN"){
							$cont_ln += 1;
						}
					}

					if ( $cont_g <=3 ) $aux->ln = 1;
					if ( $cont_g >= 4 || $cont_ln >= 1) $aux->ln = 2;
					if ( ($cont_g <= 3 && $cont_ln >= 1) || $cont_lnp >= 1) $aux->ln = 3;
				}
				$aux->especilidad1 = $l->desc_especialidad1;
				$aux->especilidad2 = $l->desc_especialidad2;
				$aux->especilidad3 = $l->desc_especialidad3;
				array_push($lista2,$aux);
				unset($aux,$usr);
			}
		}

		//print_r($lista);

		$pagina['listado'] = $lista2;

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/listado3',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function listado_grupo(){
		$base['titulo'] = "Listado grupos";
		$base['lugar'] = "Listado grupos";

		$this->load->model("Grupo_trabajadores_model");
		$this->load->model("Grupo_trabajadores_asc_usuarios_model");


		if(isset($_POST['ngrupo'])){
			$data = array(
				'name' => $_POST['ngrupo'],
				);
			$this->Grupo_trabajadores_model->ingresar($data);
		}
		if(isset($_GET['id'])){
			$this->Grupo_trabajadores_model->eliminar($_GET['id']);
		}
		$pagina['listado'] = $this->Grupo_trabajadores_model->listar();

		$listado = array();

		foreach ( $this->Grupo_trabajadores_model->listar() as $g) {
			$aux = new stdClass();
			$gt = $this->Grupo_trabajadores_asc_usuarios_model->cantidad_usuarios($g->id);
			$aux->grupo_id = $g->id;
			$aux->grupo_name = $g->name;
			$aux->cantidad = $gt;
			array_push($listado,$aux);
			unset($aux);
		}
		$pagina['listado'] = $listado;


		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/grupo_trabajadores',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function listado_grupo_asignados($id){
		$base['titulo'] = "Listado trabajadores asignados a grupo";
		

		$this->load->model("Grupo_trabajadores_model");
		$this->load->model("Grupo_trabajadores_asc_usuarios_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Archivos_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");

		$grupo = $this->Grupo_trabajadores_model->get($id);
		$base['lugar'] = $grupo->name;

		$listado = array();

		foreach ( $this->Grupo_trabajadores_asc_usuarios_model->usuarios_grupo($id) as $g) {
			$u = $this->Usuarios_model->get( $g->usuarios_id );
			
			$aux = new stdClass();
			$aux->id = $g->id;
			$aux->grupo_id = $g->grupo_trabajadores_id;
			$aux->usuario_id = $g->usuarios_id;
			$aux->usuario_nb = $u->nombres;
			$aux->usuario_app = $u->paterno;
			$aux->usuario_apm = $u->materno;
			$aux->usuario_rut = $u->rut_usuario;
			$aux->usuario_dire = $u->direccion;
			$aux->usuario_afp = $this->Afp_model->get($u->id_afp)->desc_afp;
			$aux->usuario_salud = $this->Salud_model->get($u->id_salud)->desc_salud;
			$aux->civil = $this->Estadocivil_model->get($u->id_estadocivil)->desc_estadocivil;
			$aux->nacionalidad = $u->nacionalidad;

			$aux->afp = $this->Archivos_model->get_archivo($g->usuarios_id,11);
			$aux->salud = $this->Archivos_model->get_archivo($g->usuarios_id,12);
			$aux->estudios = $this->Archivos_model->get_archivo($g->usuarios_id,9);
			$aux->cv = $this->Archivos_model->get_archivo($g->usuarios_id,13);

			array_push($listado,$aux);
			unset($aux);
		}
		$pagina['listado'] = $listado;

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/grupo_trabajadores_asignados',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function eliminar_usuario_listado_grupo_asignados($id,$id_grupo){
		$this->load->model("Grupo_trabajadores_asc_usuarios_model");

		$this->Grupo_trabajadores_asc_usuarios_model->eliminar($id);

		redirect('administracion/trabajadores/listado_grupo_asignados/'.$id_grupo, 'refresh');
	}

	function usuarios_listado_session(){
		@$id = $_POST['id'];
		@$id_rem = $_POST['id_rem'];
		$sesion = array($id);
		if( isset($id) ){
			if( $this->session->flashdata('listado_trabajadores_grupo') ){
				$sesion2 = array_merge( $this->session->flashdata('listado_trabajadores_grupo'), $sesion );
				$this->session->set_flashdata('listado_trabajadores_grupo', $sesion2);
			}
			else{
				$this->session->set_flashdata('listado_trabajadores_grupo', $sesion);
			}
		}
		if( isset($id_rem) ){
			$arreglo = $this->session->flashdata('listado_trabajadores_grupo');
			$clave = array_search($id_rem, $arreglo);
			unset($arreglo[$clave]);
			$arr = array_values($arreglo);
			$this->session->set_flashdata('listado_trabajadores_grupo', $arr);
		}
		if( !isset($id) && !isset($id_rem) )
			echo json_encode( $this->session->flashdata('listado_trabajadores_grupo') );
	}

	function guardar_usuarios_listado_session(){
		$id_grupo = $_POST['id_grupo'];
		$usuarios = json_decode($_POST['usuarios']);
		$this->load->model("Grupo_trabajadores_asc_usuarios_model");

		
		foreach ($usuarios as $u) {
			
			$arr_guardar = array(
				'grupo_trabajadores_id' => $id_grupo,
				'usuarios_id'  => $u,
			);
			$this->Grupo_trabajadores_asc_usuarios_model->ingresar($arr_guardar);
		}

		echo $usuarios;
		//var_dump($usuarios);
		
	}
}
?>