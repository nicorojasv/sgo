<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Noticias extends CI_Controller {
	public $requerimiento;
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('logged') == TRUE)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');

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
		$this->load->model("Noticias_model");

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: ".$this->session->userdata('empresa'),
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'js' => array(),
			'css' => array(),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'),array('url' => '', 'txt' => 'Noticias')),
			'menu' => $this->menu
		);

		$pagina['listado'] = $this->Noticias_model->listar();
		$pagina['meses_noticias'] = $this->Noticias_model->listar_meses();
		$pagina['meses'] = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$pagina['dias'] = array("domingo","lunes","martes","mi&eacute;rcoles","jueves","viernes","s&aacute;bado");
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
		if($_POST['select_publicaciones'] == 1 || $_POST['select_publicaciones'] == 2){ //noticias y capacitaciones
			if( empty($_POST['texto']) ){
				redirect('noticias/crear/vacio', 'refresh');
			}
			else{
				$this->load->model("Noticias_model");
				$this->load->model("Usuarios_model");
				$this->load->helper("archivo");
				
				if($_POST['select_usuarios'] == 0) $_POST['select_usuarios'] = NULL;
				$this->db->trans_begin();
				if ($_POST['select_publicaciones'] ==1){ 
					$tip = 1;
					if($_POST['select_cat'] == 0) redirect('noticias/crear/vacio', 'refresh');
				}
				if ($_POST['select_publicaciones'] ==4) $tip = 2;

				if (isset($_POST['select_cat'])) $select_cat = $_POST['select_cat'];
				if ($_POST['select_cat'] == 0) $select_cat = NULL;

				$data = array(
					'titulo' => $_POST['titulo'],
					'desc_noticia' => $_POST['texto'],
					'fecha' => date("Y-m-j"),
					//'id_tipousuarios' => $_POST['select_usuarios'],
					'id_categoria' => $select_cat,
					'id_noticia_tipo' => $tip
				);
				$id_noticia = $this->Noticias_model->ingresar($data);
				/*
				foreach ($_POST['select_usuarios'] as $su) {
					$d = array(
						'id_noticias' => $id_noticia,
						'usuarios_categoria_id' => 3
					);
					$this->Noticias_model->ingresar_usuario($d);
				}
				
				if(empty($_POST['select_usuarios'])){
					$listado = $this->Usuarios_model->listar_no(1); //publica a todos menos al administrador
					foreach($listado as $lu){
							$data2 = array(
								'id_noticia' => $id_noticia,
								'id_usuario' => $lu->id
							);
							$this->Noticias_model->ingresar_revisar($data2);
							$list_usr[] = $lu->id;
						}
				} 
				else{
					foreach ($_POST['select_usuarios'] as $su) {
						$listado = $this->Usuarios_model->listar_tipo($su);
						foreach($listado as $lu){
							$data2 = array(
								'id_noticia' => $id_noticia,
								'id_usuario' => $lu->id
							);
							$this->Noticias_model->ingresar_revisar($data2);
							$list_usr[] = $lu->id;
						}
					}
				}*/
				if($_FILES['doc']['name']){
					for($i=0;$i<count($_FILES['doc']['name']);$i++)
					{
						if($_FILES['doc']['error'][$i] == 0){
							$salida = subir($_FILES, 'doc', 'extras/adjuntos/',false,$i);
							if($salida == 1){
								$this->db->trans_rollback();
								redirect('noticias/crear/error1', 'refresh');
							}
							elseif($salida == 2){
								$this->db->trans_rollback();
								redirect('noticias/crear/error2', 'refresh');
							}
							else{
								$data3 = array(
									'id_noticias' => $id_noticia,
									'url' => $salida,
									'nombre' => $_FILES['doc']['name'][$i]
								); 
								$this->Noticias_model->ingresar_adjuntos($data3);
								$this->db->trans_commit();
							}
						}
				   	}
				}
				if( isset($id_noticia) ){
					$this->db->trans_commit();
					if(!empty($_POST['env_email']))
					{
						$this->load->library('email'); // load email library
						$this->load->helper('text');
						#$config['smtp_host'] = 'mail.empresasintegra.cl';
						#$config['smtp_user'] = 'sgo@empresasintegra.cl';
						#$config['smtp_pass'] = 'gestion2012';
						#$config['mailtype'] = 'html';

						#$this->email->initialize($config);

						/*if($_POST['select_usuarios']==0){
							$list_usr = $this->Usuarios_model->listar_no(1);
						}else{
							$list_usr = $this->Usuarios_model->listar_tipo($_POST['select_usuarios']);
						}
						foreach ($list_usr as $l){
							$trabajador = $l;
							if(!empty($trabajador->email) && filter_var($trabajador->email, FILTER_VALIDATE_EMAIL)){
								$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
								$requerimiento_mail['titulo'] = $_POST['titulo'];
								$requerimiento_mail['cuerpo'] = word_limiter($_POST['texto'],80);
								//$this->email->from('no-responder@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
								$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
								$this->email->to($trabajador->email);
								$this->email->subject('Publicacion - Empresas Integra');
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
						}*/
					}
				}
				else{
					$this->db->trans_rollback();
				}
				//redirect('noticias/crear/exito', 'refresh');
			}
		}
		if($_POST['select_publicaciones'] == 2){ //avisos
			if( empty($_POST['texto']) ){
				redirect('noticias/crear/vacio', 'refresh');
			}
			else{
				
			}
		}
		/*
		if($_POST['select_publicaciones'] == 3){ //requerimientos
			if( empty($_POST['texto']) || empty($_POST['select_req']) || empty($_POST['select_area']) || empty($_POST['titulo']) ){
				redirect('noticias/crear/vacio', 'refresh');
			}
			else{
				$this->load->model("Publicaciones_requerimientos_model");
				$this->load->model("Publicaciones_requerimientos_adjuntos_model");
				$this->load->model("Usuarios_model");
				$this->load->helper("archivo");
				
				$this->db->trans_begin();
				if($_POST['select_area'] == 0) $_POST['select_area'] = NULL;
				$data = array(
					'titulo' => $_POST['titulo'],
					'desc_publicacion' => $_POST['texto'],
					'fecha' => date("Y-m-j"),
					'id_requerimiento' => $_POST['select_req'],
					'id_area' => $_POST['select_area']
				);
				$id_pur = $this->Publicaciones_requerimientos_model->ingresar($data);
				if( count($_FILES['doc']['name']) > 0){
					for($i=0;$i<count($_FILES['doc']['name']);$i++)
					{
						if($_FILES['doc']['error'][$i] == 0){
							$salida = subir($_FILES, 'doc', 'extras/adjuntos/',false,$i);
							if($salida == 1){
								$this->db->trans_rollback();
								redirect('administracion/publicaciones/publicar/error1', 'refresh');
							}
							elseif($salida == 2){
								$this->db->trans_rollback();
								redirect('administracion/publicaciones/publicar/error2', 'refresh');
							}
							else{
								$data3 = array(
									'id_publicaciones_requerimientos' => $id_pur,
									'url' => $salida,
									'nombre' => $_FILES['doc']['name'][$i]
								); 
								$this->Publicaciones_requerimientos_adjuntos_model->ingresar($data3);
								$this->db->trans_commit();
							}
						}
				   	}
				}
				if( isset($id_pur) ){
					$this->db->trans_commit();
				}
				redirect('administracion/publicaciones/publicar/exito', 'refresh');
			}
		}*/
		if($_POST['select_publicaciones'] == 4){ //capacitaciones

			$data = array(
				'titulo' => $_POST['titulo'],
				'desc_noticia' => $_POST['texto'],
				'fecha' => date("Y-m-j"),
				'id_tipousuarios' => $_POST['select_usuarios'],
				'id_categoria' => $_POST['select_cat'],
				'id_noticia_tipo' => 2
			);
		}
	}


}
?>