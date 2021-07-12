<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Noticias extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		$this->load->model("Noticias_model");

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: ".$this->session->userdata('empresa'),
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'),array('url' => '', 'txt' => 'Noticias')),
			'menu' => $this->menu
		);

		$pagina['listado'] = $this->Noticias_model->listar();
		$pagina['meses_noticias'] = $this->Noticias_model->listar_meses();
		$pagina['meses'] = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$pagina['dias'] = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado","domingo");
		$base['cuerpo'] = $this->load->view('listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function crear(){
		$this->load->model("Noticias_model");
		$this->load->model("Noticias_tipo_model");
		$this->load->model("Noticias_categoria_model");

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: ".$this->session->userdata('empresa'),
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'js' => array('js/noticias.js'),
			'css' => array(),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'noticias/index', 'txt' => 'Noticias'),array('url' => '', 'txt' => 'Crear')),
			'menu' => $this->menu
		);

		$pagina['lista_tipo'] = $this->Noticias_tipo_model->listar();
		$pagina['lista_categoria'] = $this->Noticias_categoria_model->listar();

		$base['cuerpo'] = $this->load->view('crear',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar(){
		if($_POST['select_publicaciones'] == 1 || $_POST['select_publicaciones'] == 2){
			if( empty($_POST['texto']) ){
				redirect('noticias/crear/vacio', 'refresh');
			}else{
				$this->load->model("Noticias_model");
				$this->load->model("Usuarios_model");
				$this->load->helper("archivo");
				
				//if($_POST['select_usuarios'] == 0) $_POST['select_usuarios'] = NULL;
				//$this->db->trans_begin();
				$data = array(
					'titulo' => $_POST['titulo'],
					'desc_noticia' => $_POST['texto'],
					'fecha' => date("Y-m-j"),
					'id_categoria' => $_POST['select_cat'],
					'id_noticia_tipo' => $_POST['select_publicaciones'],
					'estado_envio' => 0
				);

				$this->Noticias_model->ingresar($data);
				$id_noticia = $this->db->insert_id();

				if($_FILES['doc']['name']){
					//for($i=0;$i<count($_FILES['doc']['name']);$i++){
						if($_FILES['doc']['error'] == 0){
							$salida = subir($_FILES, 'doc', 'extras/adjuntos/',$id_noticia);
							if($salida == 1){
								redirect('noticias/crear/error1', 'refresh');
							}elseif($salida == 2){
								redirect('noticias/crear/error2', 'refresh');
							}else{
								$data3 = array(
									'id_noticias' => $id_noticia,
									'url' => $salida,
									'nombre' => $_FILES['doc']['name']
								);
								$this->Noticias_model->ingresar_adjuntos($data3);
								//$this->db->trans_commit();
							}
						}
				   	//}
				}
			}
		}
		redirect('noticias/index', 'refresh');
	}

	function eliminar_noticia($id){
		$this->load->model('Noticias_model');
		$this->Noticias_model->eliminar($id);
		redirect('noticias/index', 'refresh');
	}

	function envio_noticias($id_noticia = FALSE, $get_tipo_usuario = FALSE){
		if($id_noticia == FALSE){
			redirect('noticias/index', 'refresh');
		}else{
			$this->load->model('Noticias_est_model');
			$this->load->model('Usuarios_model');
			$this->load->model('Especialidadtrabajador_model');
			$this->load->model('Requerimientos_model');
			$this->load->model('Empresas_model');
			$this->load->model('Planta_model');
			$this->load->model('Requerimiento_area_cargo_model');
			$base = array(
				'head_titulo' => "Sistema EST - Publicaciones",
				'titulo' => "Empresa: ".$this->session->userdata('empresa'),
				'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
				'side_bar' => true,
				'js' => array('js/envio_noticias.js','js/si_validaciones.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/listado_envio_noticia.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'noticias/index', 'txt' => 'Noticias'), array('url' => '', 'txt' => 'Envio de Publicaciones a Usuarios') ),
				'menu' => $this->menu
			);

			$tipo_usuario_defecto = "requerimiento";
			if (empty($get_tipo_usuario)){
				$tipo_usuario = $tipo_usuario_defecto;
			}else{
				$tipo_usuario = $get_tipo_usuario;
			}

			$lista = array();
			foreach ($this->Usuarios_model->listar_trabajadores_est_activos() as $l){
				$aux = new stdClass();
				$aux->id_usuario = $l->id;
				$aux->rut_usuario = $l->rut_usuario;
				$aux->nombre = $l->nombres;
				$aux->ap_paterno = $l->paterno;
				$aux->ap_materno = $l->materno;
				$aux->fecha_actualizacion = isset($l->fecha_actualizacion)?$l->fecha_actualizacion:"";
				
				$get_espec1 = isset($l->id_especialidad_trabajador)?$l->id_especialidad_trabajador:"";
				$get_espec2 = isset($l->id_especialidad_trabajador_2)?$l->id_especialidad_trabajador_2:"";
				$get_espec3 = isset($l->id_especialidad_trabajador_3)?$l->id_especialidad_trabajador_3:"";

				if(!$get_espec1){
					$aux->especialidad = "";
				}else{
					$get_especialidad_1 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador);
					$aux->especialidad = isset($get_especialidad_1->desc_especialidad)?$get_especialidad_1->desc_especialidad:"";;
				}

				if(!$get_espec2){
					$aux->especialidad2 = "";
				}else{
					$get_especialidad_2 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_2);
					$aux->especialidad2 = isset($get_especialidad_2->desc_especialidad)?$get_especialidad_2->desc_especialidad:"";;
				}

				if(!$get_espec3){
					$aux->especialidad3 = "";
				}else{
					$get_especialidad_3 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_3);
					$aux->especialidad3 = isset($get_especialidad_3->desc_especialidad)?$get_especialidad_3->desc_especialidad:"";;
				}
				array_push($lista,$aux);
				unset($aux);
			}

			$requerimientos = $this->Requerimientos_model->r_listar_activos();
			$listado2 = array();
			foreach ($requerimientos as $l){
				$dotacion = 0;
				$e = $this->Empresas_model->get($l->empresa_id);
				$p = $this->Planta_model->get($l->planta_id);
				$ac = $this->Requerimiento_area_cargo_model->get_requerimiento($l->id);
				$aux = new stdClass();
				$aux->id = (isset($l->id))?$l->id:'';
				$aux->nombre = (isset($l->nombre))?$l->nombre:'';
				$aux->empresa = (isset($e->razon_social))?$e->razon_social:'';
				$aux->planta = (isset($p->nombre))?$p->nombre:'';
				$aux->regimen = (isset($l->regimen))?$l->regimen:'';
				$aux->f_solicitud = (isset($l->f_solicitud))?$l->f_solicitud:'';
				$aux->f_inicio = (isset($l->f_inicio))?$l->f_inicio:'';
				$aux->f_fin = (isset($l->f_fin))?$l->f_fin:'';
				$aux->causal = (isset($l->causal))?$l->causal:'';
				$aux->motivo = (isset($l->motivo))?$l->motivo:'';
				$aux->comentario = (isset($l->comentario))?$l->comentario:'';
				$aux->version = (isset($l->version))?$l->version:'';
				$aux->estado = (isset($l->estado))?$l->estado:'';
				foreach ($ac as $ac) {
					$dotacion += $ac->cantidad;
				}
				$aux->dotacion = $dotacion;
				array_push($listado2,$aux);
				unset($aux);
			}
			$pagina['especialidades'] = $this->Especialidadtrabajador_model->listar();
			$pagina['requerimientos'] = $listado2;
			$pagina['trabajadores'] = $lista;
			$pagina['tipo_usuario'] = $tipo_usuario;
			$pagina['id_noticia'] = $id_noticia;
			$pagina['adjuntos_noticia'] = $this->Noticias_est_model->listar_adjuntos($id_noticia);
			$pagina['noticia'] = $this->Noticias_est_model->get_result($id_noticia);
			$base['cuerpo'] = $this->load->view('envio_noticias',$pagina,TRUE);
			$this->load->view('layout2.0/layout',$base);
		}
	}

	function enviar_publicacion_trabajador(){
		//todos los trabajadores seleccionados
		$this->load->model('Usuarios_model');
		$this->load->model('Noticias_est_model');
		$id_noticia = $_POST['id_noticia'];
		$get_noticia = $this->Noticias_est_model->get($id_noticia);
		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

		$correos_erroneos = array();
		$correos_vacios = array();

		if (!empty($_POST['seleccionar_usuario'])?$_POST['seleccionar_usuario']:false){
			foreach($_POST['seleccionar_usuario'] as $c){
				$trabajador = $this->Usuarios_model->get($c);

				if (!filter_var($trabajador->email, FILTER_VALIDATE_EMAIL) === false) {
				    $estado_email = 1;
				}else{
				    $estado_email = 0;
				}

				//if(!empty($trabajador->email) && filter_var($trabajador->email, FILTER_VALIDATE_EMAIL)){
				if(!empty($trabajador->email) && $estado_email == 1){
					$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
					$requerimiento_mail['titulo'] = $get_noticia->titulo;
					$requerimiento_mail['cuerpo'] = $get_noticia->desc_noticia;
					$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
					$this->email->to($trabajador->email);
					$this->email->subject('Publicacion - Empresas Integra!!!');
					$this->email->message($this->load->view('email/noticia',$requerimiento_mail,TRUE));
					$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
					if( !@$this->email->send()){
						$this->load->model("Errores_model");
						$salida = array(
							'tipo' => 'email',
							'texto' => $this->email->print_debugger(),
							'fecha' => date('Y-m-d')
						);
						$this->Errores_model->ingresar($salida);
					}
				}

				if(!empty($trabajador->email) and $estado_email == 0){
					$aux1 = new stdClass();
					$aux1->rut_usuario = $trabajador->rut_usuario;
					$aux1->email = $trabajador->email;
					array_push($correos_erroneos,$aux1);
					unset($aux1);
				}

				if(!empty($trabajador->email)){
					array_push($correos_vacios, $trabajador->rut_usuario);
				}
			}
		}

		$cantidad_correos_erroneos = count($correos_erroneos);
		$cantidad_correos_vacios = count($correos_vacios);

		if($cantidad_correos_erroneos > 0 or $cantidad_correos_vacios > 0){
			$requerimiento_mail2['mensaje'] = ucwords(mb_strtolower('Correos erroneos encontrados en la publicacion de una noticia', 'UTF-8'));
			$requerimiento_mail2['titulo'] = $get_noticia->titulo;
			$requerimiento_mail2['correos_erroneos'] = $correos_erroneos;
			$requerimiento_mail2['correos_vacios'] = $correos_vacios;
			$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
			$this->email->to('jcruces@empresasintegra.cl');
			//$this->email->cc('pcanales@empresasintegra.cl');
			//$this->email->cco('mcuevas@empresasintegra.cl');
			$this->email->subject('Errores Publicacion - Empresas Integra!!!');
			$this->email->message($this->load->view('email/correos_erroneos',$requerimiento_mail2,TRUE));
			$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
			$this->email->send();
		}

		$estado_noticia = array(
			'estado_envio' => 1
		);
		$this->Noticias_est_model->editar($id_noticia, $estado_noticia);
		echo "<script>alert('Noticia Enviada Exitosamente')</script>";
		redirect('/noticias/index', 'refresh');
	}

	function enviar_publicacion_requerimientos(){
		$this->load->model('Requerimiento_area_cargo_model');
		$this->load->model('Noticias_est_model');
		$this->load->model('Usuarios_model');
		$this->load->helper('email');
		$id_noticia = $_POST['id_noticia'];
		$get_noticia = $this->Noticias_est_model->get($id_noticia);

		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

		$correos_erroneos = array();
		$correos_vacios = array();
		//todos los requerimientos seleccionados
		$i = 0;
		if (!empty($_POST['seleccionar_req'])?$_POST['seleccionar_req']:false){
			foreach($_POST['seleccionar_req'] as $c){
				$i += 1;
				$usuarios_req[$i] = $this->Requerimiento_area_cargo_model->listar_usuarios_requerimiento($c);
				foreach($usuarios_req[$i] as $z){
					$trabajador = $z;

					if (!filter_var($trabajador->email, FILTER_VALIDATE_EMAIL) === false) {
					    $estado_email = 1;
					} else {
					    $estado_email = 0;
					}
					//$trabajador = $this->Usuarios_model->get($z);
					//if(!empty($trabajador->email) && filter_var($trabajador->email, FILTER_VALIDATE_EMAIL)){
					if(!empty($trabajador->email) && $estado_email == 1){
						$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
						$requerimiento_mail['titulo'] = $get_noticia->titulo;
						$requerimiento_mail['cuerpo'] = $get_noticia->desc_noticia;
						$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
						$this->email->to($trabajador->email);
						$this->email->subject('Publicacion - Empresas Integra!!!');
						$this->email->message($this->load->view('email/noticia',$requerimiento_mail,TRUE));
						$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
						if( !@$this->email->send()){
							$this->load->model("Errores_model");
							$salida = array(
								'tipo' => 'email',
								'texto' => $this->email->print_debugger(),
								'fecha' => date('Y-m-d')
							);
							$this->Errores_model->ingresar($salida);
						}
					}

					if(!empty($trabajador->email) and $estado_email == 0){
						$aux1 = new stdClass();
						$aux1->rut_usuario = $trabajador->rut_usuario;
						$aux1->email = $trabajador->email;
						array_push($correos_erroneos,$aux1);
						unset($aux1);
					}

					if(!empty($trabajador->email)){
						array_push($correos_vacios, $trabajador->rut_usuario);
					}
					//fin codigo
				}
			}
		}

		$cantidad_correos_erroneos = count($correos_erroneos);
		$cantidad_correos_vacios = count($correos_vacios);

		if($cantidad_correos_erroneos > 0 or $cantidad_correos_vacios > 0){
			$requerimiento_mail2['mensaje'] = ucwords(mb_strtolower('Correos erroneos encontrados en la publicacion de una noticia', 'UTF-8'));
			$requerimiento_mail2['titulo'] = $get_noticia->titulo;
			$requerimiento_mail2['correos_erroneos'] = $correos_erroneos;
			$requerimiento_mail2['correos_vacios'] = $correos_vacios;
			$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
			$this->email->to('jcruces@empresasintegra.cl');
			//$this->email->cc('pcanales@empresasintegra.cl');
			//$this->email->cco('mcuevas@empresasintegra.cl');
			$this->email->subject('Errores Publicacion - Empresas Integra!!!');
			$this->email->message($this->load->view('email/correos_erroneos',$requerimiento_mail2,TRUE));
			$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
			$this->email->send();
		}

		$estado_noticia = array(
			'estado_envio' => 1
		);
		$this->Noticias_est_model->editar($id_noticia, $estado_noticia);
		echo "<script>alert('Noticia Enviada Exitosamente')</script>";
		redirect('/noticias/index', 'refresh');
	}

	function enviar_publicacion_especialidad(){
		$this->load->model('Usuarios_model');
		$this->load->model('Noticias_est_model');
		$id_noticia = $_POST['id_noticia'];
		$get_noticia = $this->Noticias_est_model->get($id_noticia);

		$this->load->library('email'); // load email library
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

		$correos_erroneos = array();
		$correos_vacios = array();
		//$this->load->model('');
		//todas las especialidades seleccionadas
		if (!empty($_POST['seleccionar_espec'])?$_POST['seleccionar_espec']:false){
			foreach($_POST['seleccionar_espec'] as $c){
				$usuarios_especialidad = $this->Usuarios_model->listar_usuarios_especialidad($c);
				foreach($usuarios_especialidad as $z){
					//inicio codigo
					$trabajador = $z;

					if (!filter_var($trabajador->email, FILTER_VALIDATE_EMAIL) === false) {
					    $estado_email = 1;
					} else {
					    $estado_email = 0;
					}
					//$trabajador = $this->Usuarios_model->get($z);
					//if(!empty($trabajador->email) && filter_var($trabajador->email, FILTER_VALIDATE_EMAIL)){
					if(!empty($trabajador->email) && $estado_email == 1){
						$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
						$requerimiento_mail['titulo'] = $get_noticia->titulo;
						//$requerimiento_mail['cuerpo'] = word_limiter($get_noticia->desc_noticia,80);
						$requerimiento_mail['cuerpo'] = $get_noticia->desc_noticia;
						$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
						$this->email->to($trabajador->email);
						$this->email->subject('Publicacion - Empresas Integra!!!');
						$this->email->message($this->load->view('email/noticia',$requerimiento_mail,TRUE));
						$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
						if( !@$this->email->send()){
							$this->load->model("Errores_model");
							$salida = array(
								'tipo' => 'email',
								'texto' => $this->email->print_debugger(),
								'fecha' => date('Y-m-d')
							);
							$this->Errores_model->ingresar($salida);
						}
					}

					if(!empty($trabajador->email) and $estado_email == 0){
						$aux1 = new stdClass();
						$aux1->rut_usuario = $trabajador->rut_usuario;
						$aux1->email = $trabajador->email;
						array_push($correos_erroneos,$aux1);
						unset($aux1);
					}

					if(!empty($trabajador->email)){
						array_push($correos_vacios, $trabajador->rut_usuario);
					}
					//fin codigo
				}
			}
		}

		$cantidad_correos_erroneos = count($correos_erroneos);
		$cantidad_correos_vacios = count($correos_vacios);

		if($cantidad_correos_erroneos > 0 or $cantidad_correos_vacios > 0){
			$requerimiento_mail2['mensaje'] = ucwords(mb_strtolower('Correos erroneos encontrados en la publicacion de una noticia', 'UTF-8'));
			$requerimiento_mail2['titulo'] = $get_noticia->titulo;
			$requerimiento_mail2['correos_erroneos'] = $correos_erroneos;
			$requerimiento_mail2['correos_vacios'] = $correos_vacios;
			$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
			$this->email->to('jcruces@empresasintegra.cl');
			//$this->email->cc('pcanales@empresasintegra.cl');
			//$this->email->cco('mcuevas@empresasintegra.cl');
			$this->email->subject('Errores Publicacion - Empresas Integra!!!');
			$this->email->message($this->load->view('email/correos_erroneos',$requerimiento_mail2,TRUE));
			$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
			$this->email->send();
		}

		$estado_noticia = array(
			'estado_envio' => 1
		);
		$this->Noticias_est_model->editar($id_noticia, $estado_noticia);
		echo "<script>alert('Noticia Enviada Exitosamente')</script>";
		redirect('/noticias/index', 'refresh');
	}

}
?>