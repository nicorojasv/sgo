<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Noticia extends CI_Controller {
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
		$base['titulo'] = "Perfil de administrador";
		$base['lugar'] = "Perfil";
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('perfil',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function publicar($msg = FALSE){
		$this->load->model("Tipousuarios_model");
		$this->load->model("administracion/Categoriasnoticias_model");
		$base['titulo'] = "Publicar noticia";
		$base['lugar'] = "Noticias";
		
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
		
		$pagina['tipos'] = $this->Tipousuarios_model->listar();
		$pagina['cat_noticias'] = $this->Categoriasnoticias_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('noticias/publicar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar_noticia(){
		if( empty($_POST['texto']) || empty($_POST['titulo']) || $_POST['select_cat'] == 0 ){
			redirect('administracion/noticia/publicar/vacio', 'refresh');
		}
		else{
			$this->load->model("Noticias_model");
			$this->load->model("Usuarios_model");
			$this->load->helper("archivo");
			
			if($_POST['select_usuarios'] == 0) $_POST['select_usuarios'] = NULL;
			$this->db->trans_begin();
			$data = array(
				'titulo' => $_POST['titulo'],
				'desc_noticia' => $_POST['texto'],
				'fecha' => date("Y-m-j"),
				'id_tipousuarios' => $_POST['select_usuarios'],
				'id_categoria' => $_POST['select_cat']
			);
			$id_noticia = $this->Noticias_model->ingresar($data);
			if($_POST['select_usuarios'] == NULL) $listado = $this->Usuarios_model->listar_no(3); //publica a todos menos al administrador
			else $listado = $this->Usuarios_model->listar_tipo($_POST['select_usuarios']);
			
			foreach($listado as $lu){
				$data2 = array(
					'id_noticia' => $id_noticia,
					'id_usuario' => $lu->id
				);
				$this->Noticias_model->ingresar_revisar($data2);
			}
			
			for($i=0;$i<count($_FILES['doc']['name']);$i++)
			{
				if($_FILES['doc']['error'][$i] == 0){
					$salida = subir($_FILES, 'doc', 'extras/adjuntos/',false,$i);
					if($salida == 1){
						$this->db->trans_rollback();
						redirect('administracion/noticia/publicar/error1', 'refresh');
					}
					elseif($salida == 2){
						$this->db->trans_rollback();
						redirect('administracion/noticia/publicar/error2', 'refresh');
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
			$this->db->trans_rollback();
			redirect('administracion/noticia/publicar/exito', 'refresh');
		}
	}
	function buscar($msg = FALSE){
		$this->load->model("Noticias_model");
		$this->load->model("Tipousuarios_model");
		$this->load->helper('text');
		$base['titulo'] = "Listado de noticias";
		$base['lugar'] = "Noticias";
		
		if($msg == "borrar_exito"){
			$aviso['titulo'] = "La noticia se a borrado exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		
		$lista = array();
		$noticias = $this->Noticias_model->listar();
		foreach($noticias as $n){
			$aux = new stdClass();
			$aux->titulo = $n->titulo;
			$aux->texto = $n->desc_noticia;
			$aux->tipo_usuario = (empty($n->id_tipousuarios))? 'Todos' : ucwords(strtolower($this->Tipousuarios_model->get($n->id_tipousuarios)->desc_tipo_usuarios));
			$aux->id = $n->id;
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['noticias'] = $lista;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('noticias/buscar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function eliminar($id){
		$this->load->model("Noticias_model");
		$this->Noticias_model->eliminar($id);
		redirect('administracion/noticia/buscar/borrar_exito', 'refresh');
	}
	function detalle($id){
		if(empty($id)) redirect('/error/error_404', 'refresh');
		$this->load->model("Noticias_model");
		$id = base64_decode(urldecode($id));
		$noticia = $this->Noticias_model->get($id);
		$adjuntos = $this->Noticias_model->listar_adjuntos($id);
		if($this->session->userdata('tipo') != 3){ //validacion de no ingreso a noticia autorizada
			 redirect('/error/error_404', 'refresh');
		}
		$base['titulo'] = "Noticias integra";
		$base['lugar'] = "Noticias";
		$pagina['noticia'] = $noticia;
		$pagina['adjuntos'] = $adjuntos;
		
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento, TRUE);
		$pagina['noticia_limite'] = $this->Noticias_model->listar_limite(4,2);
		$base['cuerpo'] = $this->load->view('noticias/detalle', $pagina, TRUE);
		$this->load->view('layout', $base);
	}
	
	function ingresar_categoria(){
		if(empty($_POST['cat']))
			redirect('/eadministracion/noticia/publicar', 'refresh');
		else{
			$this->load->model("administracion/Categoriasnoticias_model");
			$data = array( 'nombre' => mb_strtoupper($_POST['cat'], 'UTF-8') );
			$this->Categoriasnoticias_model->ingresar($data);
			redirect('/eadministracion/noticia/publicar', 'refresh');
		}
		
	}
}
?>