<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Archivos extends CI_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 2){
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

		$this->load->model("Noticias_model");
		$this->load->model("Ofertas_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Evaluacionestipo_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->noticias['capacitaciones_noleidas'] = $this->Noticias_model->cont_capacitacion_noleidas($this->session->userdata('id'));
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
	function index() {
		
	}
	
	function subir($msg = FALSE){
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_model");
		
		$base['titulo'] = "Subir archivos al sistema";
		$base['lugar'] = "Subir Archivo";
		
		/**
		 * mensajes
		 */ 
		if($msg == "exito"){
			$aviso['titulo'] = "Archivo guardado exitosamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "vacio"){
			$aviso['titulo'] = "El archivo que quiere subir esta vacio, intente nuevamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error0"){
			$aviso['titulo'] = "El archivo tiene una extención no soportada";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error1"){
			$aviso['titulo'] = "No se pudo guardar el archivo, intente nuevamente";
			$pagina['avisos'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$pagina['menu'] = $this->load->view('menus/menu_trabajador',$this->noticias,TRUE);
		$pagina['listado_tipo'] = $this->Tipoarchivos_model->listar();
		
		$base['cuerpo'] = $this->load->view('archivos',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function guardar(){
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
				redirect('trabajador/archivos/subir/error0', 'refresh');
			elseif($salida==2)
				redirect('trabajador/archivos/subir/error1', 'refresh');
			else{
				$data = array(
					'id_usuarios' => $this->session->userdata('id'),
					'nombre' => $nb_archivo,
					'id_tipoarchivo' => $_POST['select_archivo'],
					'url' => $salida
 				);
				$this->Archivos_model->ingresar($data);
				redirect('trabajador/archivos/subir/exito', 'refresh');
			}
		}
		else redirect('trabajador/archivos/subir/vacio', 'refresh');
		
	}
	
	function buscar(){
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_model");
		$base['titulo'] = "Listado de archivos del sistema";
		$base['lugar'] = "Buscar Archivo";
		$listado_archivos = $this->Tipoarchivos_model->listar();
		
		$listado = array();
		foreach($listado_archivos as $la){
			$aux = new stdClass();
			$aux->nb_tipo = ucwords(strtolower($la->desc_tipoarchivo));
			if($archivo = $this->Archivos_model->get_archivo($this->session->userdata('id'),$la->id) ){
				$aux->existe = 'si';
				$aux->cant = count($archivo);
				foreach($archivo as $a){
					$aux->nb_archivo[] = $a->nombre;
					$aux->fecha[] = $a->fecha;
					$aux->url[] = $a->url;
					$aux->id_archivo[] = $a->id;
				}
			}
			else $aux->existe = 'no';
			array_push($listado,$aux);
			unset($aux);
		}
		// echo "<pre>";
		// print_r($listado);
		// echo "</pre>";
		$pagina['listado'] = $listado;
		$pagina['menu'] = $this->load->view('menus/menu_trabajador',$this->noticias,TRUE);
		$base['cuerpo'] = $this->load->view('busqueda_archivos',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function eliminar_archivo($id){
		$this->load->model("Archivos_model");
		$archivo = $this->Archivos_model->get($id);
		
		$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
		$ruta_prin = $ruta_prin[0];
		unlink($ruta_prin.$archivo->url);
		$this->Archivos_model->eliminar($id);
		redirect('trabajador/archivos/buscar', 'refresh');
	}

}
?>