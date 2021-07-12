<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Publicaciones extends CI_Controller {
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

   	function publicar($msg = FALSE){
		$this->load->model("Tipousuarios_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("administracion/Categoriasnoticias_model");
		$this->load->helper('urlencrypt');
		$base['titulo'] = "Publicar noticias o avisos";
		$base['lugar'] = "Publicaciones";
		
		if($msg == "vacio"){
			$aviso['titulo'] = "Algunos datos estan vacios, favor enviar nuevamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "La noticia se a publicado exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error1"){
			$aviso['titulo'] = "El tipo de archivo no esta soportado, favor adjuntar doc,docx,o pdf.";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error2"){
			$aviso['titulo'] = "Error al copiar el archivo, favor intentar nuevamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito_del_cat"){
			$aviso['titulo'] = "La categoria fue eliminada correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_del_cat"){
			$aviso['titulo'] = "La categoria no puede ser eliminada, contiene noticias asociadas.";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$pagina['tipos'] = $this->Tipousuarios_model->listar();
		$pagina['lista_req'] = $this->Requerimiento_model->listar();
		$pagina['cat_noticias'] = $this->Categoriasnoticias_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('publicaciones/publicar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function editar($tipo,$id,$msg = FALSE){
		$this->load->model("Tipousuarios_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("administracion/Categoriasnoticias_model");
		$this->load->model("Publicaciones_requerimientos_model");
		$this->load->model("Noticias_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Areas_model");
		
		$this->load->helper('urlencrypt');
		$base['titulo'] = "Publicar noticias o avisos";
		$base['lugar'] = "Publicaciones";
		$id = desencrypt($id);
		$salida = new stdClass();
		$pagina['tipo'] = $tipo;
		if( ($tipo == 0) || ($tipo == 1)){ //noticias por default
			$dato = $this->Noticias_model->get($id);
			$salida->titulo = $dato->titulo;
			$salida->texto = $dato->desc_noticia;
			$salida->categoria = $dato->id_categoria;
			$salida->usuarios = $dato->id_tipousuarios;
			$salida->id = $dato->id;
		}
		elseif($tipo == 3){
			$dato = $this->Publicaciones_requerimientos_model->get($id);
			$salida->titulo = $dato->titulo;
			$salida->texto = $dato->desc_publicacion;
			$salida->requerimiento = $dato->id_requerimiento;
			$salida->area = $dato->id_area;
			$salida->foreach_req = $this->Requerimiento_areas_model->get_requerimiento($dato->id_requerimiento);
			$salida->id = $dato->id;
		}
		$pagina['datos'] = $salida;
		$pagina['tipos'] = $this->Tipousuarios_model->listar();
		$pagina['lista_req'] = $this->Requerimiento_model->listar();
		$pagina['cat_noticias'] = $this->Categoriasnoticias_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('publicaciones/editar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar_publicacion(){
		if(empty($_POST['select_publicaciones'])){
			redirect('administracion/publicaciones/publicar/vacio', 'refresh');
		}
		if($_POST['select_publicaciones'] == 1 || $_POST['select_publicaciones'] == 4){ //noticias y capacitaciones
			if( empty($_POST['texto']) || empty($_POST['titulo']) ){
			redirect('administracion/publicaciones/publicar/vacio', 'refresh');
			}
			else{
				$this->load->model("Noticias_model");
				$this->load->model("Usuarios_model");
				$this->load->helper("archivo");
				
				if($_POST['select_usuarios'] == 0) $_POST['select_usuarios'] = NULL;
				$this->db->trans_begin();
				if ($_POST['select_publicaciones'] ==1){ 
					$tip = 1;
					if($_POST['select_cat'] == 0) redirect('administracion/publicaciones/publicar/vacio', 'refresh');
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
				foreach ($_POST['select_usuarios'] as $su) {
					$d = array(
						'id_noticias' => $id_noticia,
						'id_tipo_usuarios' => $su
					);
					$this->Noticias_model->ingresar_usuario($d);
				}
				if($_POST['select_usuarios'] == NULL){
					$listado = $this->Usuarios_model->listar_no(3); //publica a todos menos al administrador
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
				}
				
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
								'id_noticias' => $id_noticia,
								'url' => $salida,
								'nombre' => $_FILES['doc']['name'][$i]
							); 
							$this->Noticias_model->ingresar_adjuntos($data3);
							$this->db->trans_commit();
						}
					}
			   	}
				if( isset($id_noticia) ){
					$this->db->trans_commit();
					if($_POST['env_email'])
					{
						$this->load->library('email');
						$this->load->helper('text');
						$config['smtp_host'] = 'mail.empresasintegra.cl';
						$config['smtp_user'] = 'sgo@empresasintegra.cl';
						$config['smtp_pass'] = 'gestion2012';
						$config['mailtype'] = 'html';
						$config['smtp_port']    = '2552';

						$this->email->initialize($config);
						foreach ($list_usr as $l) {
							$trabajador = $this->Usuarios_model->get($l);
							if(!empty($trabajador->email) && filter_var($trabajador->email, FILTER_VALIDATE_EMAIL)){
								$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
								$requerimiento_mail['titulo'] = $_POST['titulo'];
								$requerimiento_mail['cuerpo'] = word_limiter($_POST['texto'],80);
								$this->email->from('no-responder@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
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
						}
					}
				}
				else{
					$this->db->trans_rollback();
				}
				redirect('administracion/publicaciones/publicar/exito', 'refresh');
			}
		}
		if($_POST['select_publicaciones'] == 2){ //avisos
			if( empty($_POST['texto']) ){
				redirect('administracion/publicaciones/publicar/vacio', 'refresh');
			}
			else{
				
			}
		}
		if($_POST['select_publicaciones'] == 3){ //requerimientos
			if( empty($_POST['texto']) || empty($_POST['select_req']) || empty($_POST['select_area']) || empty($_POST['titulo']) ){
				redirect('administracion/publicaciones/publicar/vacio', 'refresh');
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
		}
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

	function ver_correo(){
		$this -> load -> view('email/noticia');
	}
	
	function editar_publicacion(){
		$this->load->helper('urlencrypt');
		if($_POST['select_publicaciones'] == 1 || $_POST['select_publicaciones'] == 0){ //noticias
			if( empty($_POST['texto']) || empty($_POST['titulo']) || $_POST['select_cat'] == 0 ){
			redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/vacio', 'refresh');
			}
			else{
				$this->load->model("Noticias_model");
				$this->load->model("Usuarios_model");
				$this->load->helper("archivo");
				
				if($_POST['select_usuarios'] == 0) $_POST['select_usuarios'] = NULL;
				$data = array(
					'titulo' => $_POST['titulo'],
					'desc_noticia' => $_POST['texto'],
					'fecha' => date("Y-m-j"),
					'id_tipousuarios' => $_POST['select_usuarios'],
					'id_categoria' => $_POST['select_cat']
				);
				$this->Noticias_model->editar($_POST['id'],$data);
				
				for($i=0;$i<count($_FILES['doc']['name']);$i++)
				{
					if($_FILES['doc']['error'][$i] == 0){
						$salida = subir($_FILES, 'doc', 'extras/adjuntos/',false,$i);
						if($salida == 1){
							redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/error1', 'refresh');
						}
						elseif($salida == 2){
							redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/error2', 'refresh');
						}
						else{
							$data3 = array(
								'id_noticias' => $id_noticia,
								'url' => $salida,
								'nombre' => $_FILES['doc']['name'][$i]
							); 
							$this->Noticias_model->ingresar_adjuntos($data3);
						}
					}
			   	}
				redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/exito', 'refresh');
			}
		}
		if($_POST['select_publicaciones'] == 2){ //avisos
			if( empty($_POST['texto']) ){
				redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/vacio', 'refresh');
			}
			else{
				
			}
		}
		if($_POST['select_publicaciones'] == 3){ //requerimientos
			if( empty($_POST['texto']) || empty($_POST['select_req']) || empty($_POST['select_area']) || empty($_POST['titulo']) ){
				redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/vacio', 'refresh');
			}
			else{
				$this->load->model("Publicaciones_requerimientos_model");
				$this->load->model("Publicaciones_requerimientos_adjuntos_model");
				$this->load->model("Usuarios_model");
				$this->load->helper("archivo");
				
				
				if($_POST['select_area'] == 0) $_POST['select_area'] = NULL;
				$data = array(
					'titulo' => $_POST['titulo'],
					'desc_publicacion' => $_POST['texto'],
					'fecha' => date("Y-m-j"),
					'id_requerimiento' => $_POST['select_req'],
					'id_area' => $_POST['select_area']
				);
				$this->Publicaciones_requerimientos_model->editar($_POST['id'],$data);
				if( count($_FILES['doc']['name']) > 0){
					for($i=0;$i<count($_FILES['doc']['name']);$i++)
					{
						if($_FILES['doc']['error'][$i] == 0){
							$salida = subir($_FILES, 'doc', 'extras/adjuntos/',false,$i);
							if($salida == 1){
								redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/error1', 'refresh');
							}
							elseif($salida == 2){
								redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/error2', 'refresh');
							}
							else{
								$data3 = array(
									'id_publicaciones_requerimientos' => $id_pur,
									'url' => $salida,
									'nombre' => $_FILES['doc']['name'][$i]
								); 
								$this->Publicaciones_requerimientos_adjuntos_model->editar($data3);
								
							}
						}
				   	}
				}
				
				redirect('administracion/publicaciones/editar/'.$_POST['select_publicaciones'].'/'.encrypt($_POST['id']).'/exito', 'refresh');
			}
		}
		
	}
	
	function ajax_area(){
		$id = $_POST['area'];
		if( !empty($id) ){
			$this->load->model("Requerimiento_areas_model");
			$this->load->model("Areas_model");
			echo "<option value='0'>Todas</option>";
			foreach($this->Requerimiento_areas_model->get_requerimiento($id) as $a){
				$area = $this->Areas_model->get($a->id_areas);
				echo "<option value='".$a->id."'>". ucwords( mb_strtolower( $area->desc_area, 'UTF-8'))."</option>";
			}
		}
	}

	function eliminar_categorias_noticias($id){
		if( empty( $id) )
			 redirect('/error/error_404', 'refresh');
		
		$this->load->helper('urlencrypt');
		$this->load->model('Categoriasnoticias_model');
		$this->load->model('Noticias_model');
		$id = desencrypt($id);
		
		if( count($this->Noticias_model->listar_categoria($id)) > 0 ){
			redirect('administracion/publicaciones/publicar/error_del_cat', 'refresh');
		}
		else{
			$this->Categoriasnoticias_model->borrar($id);
			redirect('administracion/publicaciones/publicar/exito_del_cat', 'refresh');
		}
		
	}
	
	function buscar($tipo = FALSE,$msg = FALSE){
		$this->load->model("Noticias_model");
		$this->load->model("Tipousuarios_model");
		$this->load->model("Publicaciones_requerimientos_model");
		$this->load->helper('text');
		$this->load->helper('urlencrypt');
		$base['titulo'] = "Listado de publicaciones";
		$base['lugar'] = "Publicaciones";
		
		if($msg == "borrar_exito"){
			$aviso['titulo'] = "La noticia se a borrado exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$pagina['tipo'] = empty($tipo)? '0' : $tipo;
		
		$lista_noticia = array();
		$lista_aviso = array();
		$lista_requerimiento = array();
		
		if( ($tipo == FALSE) || ($tipo == 1)){ //noticias por default
			$noticias = $this->Noticias_model->listar();
			foreach($noticias as $n){
				$aux = new stdClass();
				$aux->titulo = $n->titulo;
				$aux->texto = $n->desc_noticia;
				$aux->tipo_usuario = (empty($n->id_tipousuarios))? 'Todos' : ucwords(strtolower($this->Tipousuarios_model->get($n->id_tipousuarios)->desc_tipo_usuarios));
				$aux->id = $n->id;
				array_push($lista_noticia,$aux);
				unset($aux);
			}
			$pagina['listado'] = $lista_noticia;
		}
		if( $tipo == 2) { //avisos
			
			$pagina['listado'] = "";
		}
		
		if ( $tipo == 3 ){ // publicaciones en requerimientos
			
				$this->load->model("Usuarios_model");
				$this->load->helper("archivo");
				
				$publicacion = $this->Publicaciones_requerimientos_model->listar();
				
				foreach($publicacion as $n){
				$aux = new stdClass(); 
				$aux->titulo = $n->titulo;
				$aux->texto = $n->desc_publicacion;
				$aux->tipo_usuario = (empty($n->id_tipousuarios))? 'Todos' : ucwords(strtolower($this->Tipousuarios_model->get($n->id_tipousuarios)->desc_tipo_usuarios));
				$aux->id = $n->id;
				array_push($lista_requerimiento,$aux);
				unset($aux);
			}
			$pagina['listado'] = $lista_requerimiento;
		}

		if($tipo == 4){ //capacitaciones
			$noticias = $this->Noticias_model->listar_cap();
			foreach($noticias as $n){
				$aux = new stdClass();
				$aux->titulo = $n->titulo;
				$aux->texto = $n->desc_noticia;
				$aux->tipo_usuario = (empty($n->id_tipousuarios))? 'Todos' : ucwords(strtolower($this->Tipousuarios_model->get($n->id_tipousuarios)->desc_tipo_usuarios));
				$aux->id = $n->id;
				array_push($lista_noticia,$aux);
				unset($aux);
			}
			$pagina['listado'] = $lista_noticia;
		}
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('publicaciones/buscar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function detalle($tipo,$id){
		if(empty($id) || !isset($tipo)) redirect('/error/error_404', 'refresh');
		
		$this->load->helper('urlencrypt');
		$id = desencrypt($id);
		$base['titulo'] = "Publicaciones integra";
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		$salida = new stdClass();
		
		if($tipo == 0 || $tipo == 1 || $tipo == 4){
			$this->load->model("Noticias_model");
			$noticia = $this->Noticias_model->get($id);
			$adjuntos = $this->Noticias_model->listar_adjuntos($id);
			if($this->session->userdata('tipo') != 3){ //validacion de no ingreso a noticia autorizada
				 redirect('/error/error_404', 'refresh');
			}
			if ($tipo == 4){
				$base['lugar'] = "Capacitación";
				$pagina['noticia_limite'] = $this->Noticias_model->listar_limite_cap(4,2);
			}
			else{
				$base['lugar'] = "Noticias";
				$pagina['noticia_limite'] = $this->Noticias_model->listar_limite(4,2);
			} 
			$pagina['adjuntos'] = $adjuntos;
			$salida->titulo = $noticia->titulo;
			$salida->texto = $noticia->desc_noticia;
			$salida->fecha = $noticia->fecha;
			$pagina['noticia'] = $salida;
		}
		
		if($tipo == 3){
			$this->load->model('Publicaciones_requerimientos_model');
			$this->load->model('Publicaciones_requerimientos_adjuntos_model');
			$base['lugar'] = "Requerimientos";
			$publicacion = $this->Publicaciones_requerimientos_model->get($id);
			$adjuntos = $this->Publicaciones_requerimientos_adjuntos_model->listar_adjuntos($id);
			$pagina['adjuntos'] = $adjuntos;
			$pagina['noticia_limite'] = $this->Publicaciones_requerimientos_model->get_publicacion($id,FALSE, FALSE,2);
			$salida->titulo = $publicacion->titulo;
			$salida->texto = $publicacion->desc_publicacion;
			$salida->fecha = $publicacion->fecha;
			$pagina['noticia'] = $salida;
		}
		
		
		$pagina['salida'] = $salida; 
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento, TRUE);
		$base['cuerpo'] = $this->load->view('publicaciones/detalle', $pagina, TRUE);
		$this->load->view('layout', $base);
	}

	function eliminar_publicacion($tipo,$id){
		$this->load->helper('urlencrypt');
		$id = desencrypt($id);
		
		if($tipo == 0 || $tipo == 1){
			$this->load->model("Noticias_model");
			$this->Noticias_model->eliminar($id);
			redirect('administracion/publicaciones/buscar/1', 'refresh');
		}
		if($tipo == 3){
			$this->load->model('Publicaciones_requerimientos_model');
			$this->Publicaciones_requerimientos_model->eliminar($id);
			redirect('administracion/publicaciones/buscar/3', 'refresh');
		}

	}

}
?>
