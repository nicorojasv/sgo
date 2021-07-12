<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Ofertas extends CI_Controller {
	public $noticias;

	public function __construct() {
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
		//$this -> load -> model("Requerimientos_model");
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
		$base['titulo'] = "Publicar ofertas de trabajo";
		$base['lugar'] = "Ofertas de Trabajo";
		
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
		$base['cuerpo'] = $this->load->view('ofertas/publicar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function guardar_publicacion(){
		if(empty($_POST['select_usuarios'])){
			redirect('administracion/ofertas/publicar/vacio', 'refresh');
		}
		
		$this->load->model("Ofertas_model");
		$this->load->model("Usuarios_model");
		$this->load->helper("archivo");
		
		if($_POST['select_usuarios'] == 0) $_POST['select_usuarios'] = NULL;
		$this->db->trans_begin();

		$data = array(
			'titulo' => $_POST['titulo'],
			'desc_oferta' => $_POST['texto'],
			'fecha' => date("Y-m-j"),
			'activo' => 0
		);
		$id_oferta = $this->Ofertas_model->ingresar($data);
		foreach ($_POST['select_usuarios'] as $su) {
			$d = array(
				'id_ofertas_trabajo' => $id_oferta,
				'id_tipo_usuarios' => $su
			);
			$this->Ofertas_model->ingresar_usuario($d);
		}
		
		if($_POST['select_usuarios'] == NULL){
			$listado = $this->Ofertas_model->listar_no(3); //publica a todos menos al administrador
			foreach($listado as $lu){
					$data2 = array(
						'id_oferta' => $id_oferta,
						'id_usuario' => $lu->id,
						'fecha' => date("Y-m-j")
					);
					$this->Ofertas_model->ingresar_revisar($data2);
					$list_usr[] = $lu->id;
				}
		} 
		else{
			foreach ($_POST['select_usuarios'] as $su) {
				$listado = $this->Usuarios_model->listar_tipo($su);
				foreach($listado as $lu){
					$data2 = array(
						'id_oferta' => $id_oferta,
						'id_usuario' => $lu->id,
						'fecha' => date("Y-m-j")
					);
					$this->Ofertas_model->ingresar_revisar($data2);
					$list_usr[] = $lu->id;
				}
			}
		}
		
		for($i=0;$i<count($_FILES['doc']['name']);$i++)
		{
			if($_FILES['doc']['error'][$i] == 0){
				$salida = subir($_FILES, 'doc', 'extras/ofertas/',false,$i);
				if($salida == 1){
					$this->db->trans_rollback();
					redirect('administracion/ofertas/publicar/error1', 'refresh');
				}
				elseif($salida == 2){
					$this->db->trans_rollback();
					redirect('administracion/ofertas/publicar/error2', 'refresh');
				}
				else{
					$data3 = array(
						'id_ofertas' => $id_oferta,
						'url' => $salida,
						'nombre' => $_FILES['doc']['name'][$i]
					); 
					$this->Ofertas_model->ingresar_adjuntos($data3);
					$this->db->trans_commit();
				}
			}
	   	}
		if( isset($id_oferta) ){
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
					if(!empty($trabajador->email)){
						$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
						$requerimiento_mail['titulo'] = $_POST['titulo'];
						$requerimiento_mail['cuerpo'] = word_limiter($_POST['texto'],80);
						$this->email->from('sgo@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
						$this->email->to($trabajador->email);
						$this->email->subject('Oferta Laboral - Empresas Integra');
						$this->email->message($this->load->view('email/ofertas',$requerimiento_mail,TRUE));
						$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
						if( !@$this->email->send()){
							//echo "error";
							//echo $this->email->print_debugger();
						}
					}
				}
			}
		}
		else{
			$this->db->trans_rollback();
		}
		redirect('administracion/ofertas/publicar/exito', 'refresh');

	}

	function buscar($tipo = FALSE,$msg = FALSE){
		$this->load->model("Ofertas_model");
		$this->load->model("Tipousuarios_model");
		$this->load->helper('text');
		$this->load->helper('urlencrypt');
		$base['titulo'] = "Listado de ofertas laborales";
		$base['lugar'] = "Ofertas Laborales";
		
		if($msg == "borrar_exito"){
			$aviso['titulo'] = "La oferta se a borrado exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$pagina['tipo'] = empty($tipo)? '0' : $tipo;
		
		$lista_noticia = array();
		

		$noticias = $this->Ofertas_model->listar();
		foreach($noticias as $n){
			$aux = new stdClass();
			$aux->titulo = $n->titulo;
			$aux->texto = $n->desc_oferta;
			$aux->tipo_usuario = (empty($n->id_tipousuarios))? 'Todos' : ucwords(strtolower($this->Tipousuarios_model->get($n->id_tipousuarios)->desc_tipo_usuarios));
			$aux->id = $n->id;
			$aux->activo = $n->activo;
			array_push($lista_noticia,$aux);
			unset($aux);
		}
		$pagina['listado'] = $lista_noticia;


		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('ofertas/buscar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function detalle($id){
		if(empty($id)) redirect('/error/error_404', 'refresh');
		
		$this->load->helper('urlencrypt');
		$id = desencrypt($id);
		$base['titulo'] = "Publicaciones integra";
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		$salida = new stdClass();
		
		
		$this->load->model("Ofertas_model");
		$noticia = $this->Ofertas_model->get($id);
		$adjuntos = $this->Ofertas_model->listar_adjuntos($id);
		if($this->session->userdata('tipo') != 3){ //validacion de no ingreso a noticia autorizada
			redirect('/error/error_404', 'refresh');
		}

		$base['lugar'] = "Ofertas Laborales";
		$pagina['noticia_limite'] = $this->Ofertas_model->listar_limite(4,2);

		$pagina['adjuntos'] = $adjuntos;
		$salida->titulo = $noticia->titulo;
		$salida->texto = $noticia->desc_oferta;
		$salida->fecha = $noticia->fecha;
		$pagina['noticia'] = $salida;
		
		$pagina['salida'] = $salida; 
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento, TRUE);
		$base['cuerpo'] = $this->load->view('publicaciones/detalle', $pagina, TRUE);
		$this->load->view('layout', $base);
	}

	function des_activar($id,$tipo = 0){
		if(empty($id)) redirect('/error/error_404', 'refresh');
		if(empty($tipo)) redirect('/error/error_404', 'refresh');

		$this->load->model("Ofertas_model");
		$this->load->helper('urlencrypt');
		$id = desencrypt($id);
		if ( $tipo < 2 ){
			$data = array(
				'activo' => $tipo
			);
			$this->Ofertas_model->editar($id,$data);
		}
		redirect('administracion/ofertas/buscar', 'refresh');
	}

	function editar($id,$msg = FALSE){
		$this->load->model("Tipousuarios_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("administracion/Categoriasnoticias_model");
		$this->load->model("Publicaciones_requerimientos_model");
		$this->load->model("Ofertas_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Areas_model");
		
		$this->load->helper('urlencrypt');
		$base['titulo'] = "Edicion de ofertas laborales";
		$base['lugar'] = "Ofertas Laborales";
		$id = desencrypt($id);
		$salida = new stdClass();
		//$pagina['tipo'] = $tipo;

		$dato = $this->Ofertas_model->get($id);
		$salida->titulo = $dato->titulo;
		$salida->texto = $dato->desc_oferta;
		$salida->id = $dato->id;
		foreach ($this->Ofertas_model->get_tu($id) as $tu) {
			$salida->usuarios[] = $tu->id_tipo_usuarios;
		}

		$pagina['datos'] = $salida;
		$pagina['tipos'] = $this->Tipousuarios_model->listar();
		$pagina['lista_req'] = $this->Requerimiento_model->listar();
		$pagina['cat_noticias'] = $this->Categoriasnoticias_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('ofertas/editar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function editar_publicacion(){
		$this->load->helper('urlencrypt');
		if( empty($_POST['texto']) || empty($_POST['titulo']) ){
		redirect('administracion/ofertas/editar/'.encrypt($_POST['id']).'/vacio', 'refresh');
		}
		else{
			$this->load->model("Ofertas_model");
			$this->load->model("Usuarios_model");
			$this->load->helper("archivo");
			
			if($_POST['select_usuarios'] == 0) $_POST['select_usuarios'] = NULL;
			if(@$_POST['vigente'] == 1) $vig = 1;
			else $vig = 0;
			$data = array(
				'titulo' => $_POST['titulo'],
				'desc_oferta' => $_POST['texto'],
				'activo' => $vig
			);
			$this->Ofertas_model->editar($_POST['id'],$data);

			$this->Ofertas_model->eliminar_tu($_POST['id']);
			foreach ($_POST['select_usuarios'] as $tu) {
				$d = array(
					'id_tipo_usuarios' => $tu,
					'id_ofertas_trabajo' => $_POST['id']
				);
				$this->Ofertas_model->ingresar_usuario($d);
			}
			
			for($i=0;$i<count($_FILES['doc']['name']);$i++)
			{
				if($_FILES['doc']['error'][$i] == 0){
					$salida = subir($_FILES, 'doc', 'extras/ofertas/',false,$i);
					if($salida == 1){
						redirect('administracion/ofertas/editar/'.encrypt($_POST['id']).'/error1', 'refresh');
					}
					elseif($salida == 2){
						redirect('administracion/ofertas/editar/'.encrypt($_POST['id']).'/error2', 'refresh');
					}
					else{
						$data3 = array(
							'id_ofertas' => $_POST['id'],
							'url' => $salida,
							'nombre' => $_FILES['doc']['name'][$i]
						); 
						$this->Ofertas_model->ingresar_adjuntos($data3);
					}
				}
		   	}
			redirect('administracion/ofertas/editar/'.encrypt($_POST['id']).'/exito', 'refresh');
		}
	}

	function eliminar_publicacion($id){
		$this->load->helper('urlencrypt');
		$id = desencrypt($id);
		$this->load->model("Ofertas_model");
		$this->Ofertas_model->eliminar($id);
		redirect('administracion/ofertas/buscar/borrar_exito', 'refresh');
	}
}
?>