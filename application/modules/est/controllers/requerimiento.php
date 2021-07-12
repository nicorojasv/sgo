<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$archivo_numero_letras = "extras/contratos/numero_letras.php";
$autoloader = "extras/contratos/PHPWord-master/src/PhpWord/Autoloader.php";
require_once (BASE_URL2.$autoloader);
require_once (BASE_URL2.$archivo_numero_letras);
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;


class Requerimiento extends CI_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
    	$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 3)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 5)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 6)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_contabilidad','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function wenawena(){
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$data = json_decode(file_get_contents('php://input'), true);
		$this->Requerimiento_asc_trabajadores_model->guardarNew($data);

	}

	function agregar(){
		if( $this->session->userdata('tipo_usuario') == 4){
			$base = array(
				'head_titulo' => "Agregar Requerimiento - Sistema EST",
				'titulo' => "Publicacion de requerimiento",
				'subtitulo' => '',
				'side_bar' => true,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Crear Requerimiento' )),
				'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
					'js/form-wizard_est_externo.js','plugins/select2/select2.min.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/requerimiento.js'),
				'css' => array('plugins/datepicker/css/datepicker.css','plugins/select2/select2.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
				'menu' => $this->menu
			);
		}else{
			$base = array(
				'head_titulo' => "Agregar Requerimiento - Sistema EST",
				'titulo' => "Publicacion de requerimiento",
				'subtitulo' => '',
				'side_bar' => true,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/listado','txt' => 'Requerimiento'), array('url'=>'','txt'=>'Crear Requerimiento' )),
				'js' => array('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
					'js/form-wizard.js','plugins/select2/select2.min.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/requerimiento.js'),
				'css' => array('plugins/datepicker/css/datepicker.css','plugins/select2/select2.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
				'menu' => $this->menu
			);
		}
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model('Empresas_model');
		$this->load->model('Centrocostos_model');
		$this->load->model("Empresa_planta_model");
		$this->load->model("Relacion_usuario_planta_model");
		$this->load->model('Requerimientos_model');
		$pagina['listado_areas'] = $this->Areas_model->lista_orden_nombre();
		$pagina['listado_cargos'] = $this->Cargos_model->lista_orden_nombre();
		$pagina['listado_empresa'] = $this->Empresas_model->listar();
		$pagina['listado_centro_costo'] = $this->Centrocostos_model->listar();
		$pagina['ultimo_folio'] = $this->Requerimientos_model->ultimo_folio();

		if( $this->session->userdata('tipo_usuario') == 4){
			$id_usuario = $this->session->userdata('id');
			$pagina['unidad_negocio'] = $this->Relacion_usuario_planta_model->get_usuario_plantas_relacion($id_usuario);
		}else{
			$pagina['unidad_negocio'] = $this->Empresa_planta_model->listar();
		}
		$base['cuerpo'] = $this->load->view('requerimiento/crear_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function asignacion($id){
		if ($id==0) {
			redirect(base_url());
			return false;
		}
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model('Requerimientos_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');

		$datos_req = $this->Requerimientos_model->get_req_planta($id);
		$planta_id = (isset($datos_req->planta_id)?$datos_req->planta_id:"");


		if( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11){
			$base = array(
				'head_titulo' => "Agregar Area/Cargos al Requerimiento - Sistema EST",
				'titulo' => "Publicacion de requerimiento",
				'subtitulo' => '',
				'side_bar' => true,
				'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js','js/si_validaciones.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/listado/'.$planta_id.'','txt' => 'Listado Requerimientos'), array('url'=>'','txt'=>'Asignar Areas - Cargos Requerimiento' )),
				'menu' => $this->menu
			);
		}else{
			$base = array(
				'head_titulo' => "Agregar Area/Cargos al Requerimiento - Sistema EST",
				'titulo' => "Publicacion de requerimiento",
				'subtitulo' => '',
				'side_bar' => true,
				'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js','js/si_validaciones.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/listado','txt' => 'Listado Requerimientos'), array('url'=>'','txt'=>'Asignar Areas - Cargos Requerimiento' )),
				'menu' => $this->menu
			);
		}
			
		$lista = array();
		foreach ($this->Requerimientos_model->get_result($id) as $l){
			$aux = new stdClass();
			$get_empresa = $this->Empresa_planta_model->get($l->planta_id);
			$aux->id = $l->id;
			$aux->nombre = (isset($l->nombre))?$l->nombre:'';
			$aux->nombre_empresa = (isset($get_empresa->nombre))?$get_empresa->nombre:'';
			$aux->f_solicitud = (isset($l->f_solicitud))?$l->f_solicitud:'';
			$aux->regimen = (isset($l->regimen))?$l->regimen:'';
			$aux->f_inicio = (isset($l->f_inicio))?$l->f_inicio:'';
			$aux->f_fin = (isset($l->f_fin))?$l->f_fin:'';
			$aux->causal = (isset($l->causal))?$l->causal:'';
			$aux->motivo = (isset($l->motivo))?$l->motivo:'';
			array_push($lista,$aux);
			unset($aux);
		}

		$lista_aux = array();
		foreach ($this->Requerimiento_area_cargo_model->get_requerimiento($id) as $r){
			$aux1 = new stdClass();
			$aux1->id = $r->id;
			$get_area = $this->Areas_model->r_get($r->areas_id);
			$get_cargo = $this->Cargos_model->r_get($r->cargos_id);
			$aux1->nombre_area = (isset($get_area->nombre))?$get_area->nombre:'';
			$aux1->nombre_cargo = (isset($get_cargo->nombre))?$get_cargo->nombre:'';
			$aux1->cantidad = (isset($r->cantidad))?$r->cantidad:'';
			$aux1->valor_aprox = (isset($r->valor_aprox))?$r->valor_aprox:'';
			$p_asignadas = count($this->Requerimiento_asc_trabajadores_model->get_cargo_area($r->id));
			$aux1->asignadas = $p_asignadas;
			array_push($lista_aux,$aux1);
			unset($aux1);
		}
		$rutaDelAnexo = BASE_URL2 . "extras/anexos_masivos/".$id;
		$rutaDelContrato = BASE_URL2 . "extras/contratos_masivos/".$id;
		if (file_exists($rutaDelAnexo)) {
		    $noAnexos= true;
		}else{
			$noAnexos = false;
		}
		if (file_exists($rutaDelContrato)) {
		    $noContrato= true;
		}else{
			$noContrato = false;
		}
		$resultadoAnexos = $this->Requerimiento_asc_trabajadores_model->getTrabajadoresAnexo($id);
		$resultadoContratos = $this->Requerimiento_asc_trabajadores_model->getTrabajadoresContrato($id);
		$pagina['trabajadoresAnexo']=$resultadoAnexos;
		$pagina['trabajadoresContrato']=$resultadoContratos;
		$pagina['noAnexos']= $noAnexos;
		$pagina['noContrato']= $noContrato;
		$pagina['requerimiento'] = $lista;
		$pagina['area_cargos_requerimiento'] = $lista_aux;
		$pagina['id_req'] = $id;
		$pagina['areas'] = $this->Areas_model->lista_orden_nombre();
		$pagina['cargos'] = $this->Cargos_model->lista_orden_nombre();
		$base['cuerpo'] = $this->load->view('requerimiento/asignar_area_cargo_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function descargar_masiva($idRequerimiento){//descarga masiva de contratos del requerimiento
		$this->load->library('zip');
		$this->load->helper('download');
		$zip = new ZipArchive();
		// Ruta absoluta
		$nombreArchivoZip = BASE_URL2 . "/directorio.zip";
		$rutaDelDirectorio = BASE_URL2 . "/extras/contratos_masivos/".$idRequerimiento;
		if (!file_exists($rutaDelDirectorio)) {
		    $this->session->set_userdata('nodata',true);
		    redirect('est/requerimiento/asignacion/'.$idRequerimiento);
		}
		if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
		    exit("Error abriendo ZIP en $nombreArchivoZip");
		}
		// Si no hubo problemas, continuamos
		// Crear un iterador recursivo que tendrá un iterador recursivo del directorio
		$archivos = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rutaDelDirectorio),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);
		foreach ($archivos as $archivo) {
		    // No queremos agregar los directorios, pues los nombres
		    // de estos se agregarán cuando se agreguen los archivos
		    if ($archivo->isDir()) {
		        continue;
		    }
		    $rutaAbsoluta = $archivo->getRealPath();
		    $nombreArchivo = substr($rutaAbsoluta, strlen($rutaDelDirectorio) + 1);
		    $zip->addFile($rutaAbsoluta, $nombreArchivo);
		}
		// cierro el archivo
		$resultado = $zip->close();
		if ($resultado) {
		    echo "Archivo creado";
		} else {
		    echo "Error creando archivo";
		}
		$nombreAmigable = "ContratosMasivo.zip";
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=$nombreAmigable");
		// Leer el contenido binario del zip y enviarlo
		readfile($nombreArchivoZip);
	}

	function descargar_masiva_anexo($idRequerimiento){//Descarga masiva de los anexos del requerimiento
		$this->load->library('zip');
		$this->load->helper('download');
		$zip = new ZipArchive();
		// Ruta absoluta
		$nombreArchivoZip = BASE_URL2 . "/AnexosMasivo.zip";
		$rutaDelDirectorio = BASE_URL2 . "/extras/anexos_masivos/".$idRequerimiento;
		if (!file_exists($rutaDelDirectorio)) {
		    $this->session->set_userdata('nodata1',true);
		    redirect('est/requerimiento/asignacion/'.$idRequerimiento);
		}
		if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
		    exit("Error abriendo ZIP en $nombreArchivoZip");
		}
		// Si no hubo problemas, continuamos
		// Crear un iterador recursivo que tendrá un iterador recursivo del directorio
		$archivos = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rutaDelDirectorio),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);
		foreach ($archivos as $archivo) {
		    // No queremos agregar los directorios, pues los nombres
		    // de estos se agregarán cuando se agreguen los archivos
		    if ($archivo->isDir()) {
		        continue;
		    }
		    $rutaAbsoluta = $archivo->getRealPath();
		    $nombreArchivo = substr($rutaAbsoluta, strlen($rutaDelDirectorio) + 1);
		    $zip->addFile($rutaAbsoluta, $nombreArchivo);
		}
		$resultado = $zip->close();//Cierro el archivo
		if ($resultado) {
		    echo "Archivo creado";
		} else {
		    echo "Error creando archivo";
		}
		$nombreAmigable = "AnexosMasivo.zip";
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=$nombreAmigable");
		// Leer el contenido binario del zip y enviarlo
		readfile($nombreArchivoZip);
	}

	function descargar_seleccionado_anexo($id){
		$this->load->model('Requerimiento_asc_trabajadores_model');
		if(!empty($_POST['seleccionar_todos'])){
			$zip_name = tempnam("tmp", "zip");
			foreach($_POST['seleccionar_todos'] as $c=>$valores){			
				 $resultado = $this->Requerimiento_asc_trabajadores_model->getTrabajadoresAnexoforUsuario($valores);
				 $zip = new ZipArchive(); // Load zip library 
				 //$zip_name ="MiArchivo.zip"; // Nombre de Fichero ZIP
				 
				if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE){
				    // Agregamos ficheros al comprimido
					$new_filename = substr($resultado->url,strrpos($resultado->url,'/') + 1);
					 $zip->addFile($resultado->url,$new_filename);
					    // Cerramos la compresion
					$zip->close(); 	
						// Declaramos una variable para mostrar mensaje 
					$resultado="ok";
				}else{
					$resultado="no";	
				}
			}
		 $nombreAmigable = "AnexosMasivo.zip";
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary");
			header("Content-disposition: attachment; filename=$nombreAmigable");
			// Leer el contenido binario del zip y enviarlo
			readfile($zip_name);
		}else{
			$this->session->set_userdata('noselecciono',true);
			redirect('est/requerimiento/asignacion/'.$id);
		}
	}

	function descargar_seleccionado_contrato($id){
		$this->load->model('Requerimiento_asc_trabajadores_model');
		if(!empty($_POST['seleccionar_todosc'])){
			$zip_name = tempnam("tmp", "zip");
			foreach($_POST['seleccionar_todosc'] as $c=>$valores){			
				 $resultado = $this->Requerimiento_asc_trabajadores_model->getTrabajadoresContratoforUsuario($valores);
				 $zip = new ZipArchive(); // Load zip library 
				/// $zip_name ="Contratos.zip"; // Nombre de Fichero ZIP
				 
				if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE){
				    // Agregamos ficheros al comprimido
					$new_filename = substr($resultado->url,strrpos($resultado->url,'/') + 1);
					 $zip->addFile($resultado->url,$new_filename);
					    // Cerramos la compresion
					$zip->close(); 	
						// Declaramos una variable para mostrar mensaje 
					$resultado="ok";
				}else{
					$resultado="no";	
				}
			}
	 	$nombreAmigable = "ContratosMasivo.zip";
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=$nombreAmigable");
		// Leer el contenido binario del zip y enviarlo
		readfile($zip_name);

		}else{
			$this->session->set_userdata('noselecciono',true);
			redirect('est/requerimiento/asignacion/'.$id);
		}
	}

	function guardar_area_cargo_req(){
		$this->load->model("Requerimiento_area_cargo_model");
		$id_req = $_POST['id_req'];
		$buscar = $this->Requerimiento_area_cargo_model->estadoreq($id_req);
		$valor = str_replace ( ".", "", $_POST['valor']);
		if($buscar){
		$datos = array(
			"requerimiento_id" => $id_req,
			"areas_id" => $_POST['area'],
			"cargos_id" => $_POST['cargo'],
			"cantidad" => $_POST['cantidad'],
			"valor_aprox" => $valor,
			);
		$this->Requerimiento_area_cargo_model->ingresar($datos);
		$this->session->set_userdata('exito',2);
		//echo '<script>alert("Area - Cargo del Requerimiento Ingresado Exitosamente");</script>';
		redirect('est/requerimiento/asignacion/'.$id_req.'', 'refresh');
		}else{
		echo "<script>alert('No se puede agregar Cargo, Favor crear Adendum')</script>";
		redirect('est/requerimiento/asignacion/'.$id_req.'', 'refresh');
	}
	}

	function eliminar_area_cargo_req($id_area_cargo, $id_req){
		return falsE;
		$this->load->model("Requerimiento_area_cargo_model");
		$this->Requerimiento_area_cargo_model->eliminar($id_area_cargo);
		redirect('/est/requerimiento/asignacion/'.$id_req, 'refresh');
	}

	function listado($get_id_planta = FALSE, $get_estado = FALSE){
		$base = array(
			'head_titulo' => "Lista de Requerimientos - Sistema EST",
			'titulo' => "Listado de requerimientos",
			'subtitulo' => '',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Requerimientos' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->model('Empresas_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Planta_model');

		if(!$get_id_planta)
			$id_planta = "todas";
		else
			$id_planta = $get_id_planta;

		if(!$get_estado)
			$estado = "activos";
		else
			$estado = $get_estado;

		if($id_planta != "todas"){
			if($this->session->userdata('tipo_usuario') == 4){
				$requerimientos = $this->Requerimientos_model->r_listar_order_estado_usuarios($this->session->userdata('id'), $id_planta, $estado);
			}elseif($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2){
				
				//yo
				$requerimientos = $this->Requerimientos_model->listar_planta_id($id_planta, $estado);
			}else{
				$requerimientos = $this->Requerimientos_model->r_listar_order_estado($estado);
			}
			$get_planta = $this->Planta_model->get($id_planta);
			$pagina['planta'] = (isset($get_planta->nombre))?$get_planta->nombre:'';
		}else{
			if( $this->session->userdata('tipo_usuario') == 4){
				$requerimientos = array();
			}else{
				$requerimientos = $this->Requerimientos_model->r_listar_order_estado($estado);
			}
			$pagina['planta'] = "";
		}

		$lista = array();
		foreach ($requerimientos as $l){
			$dotacion = 0;

			if( $this->session->userdata('tipo_usuario') == 4){
				$id_requerimiento = (isset($l->id_req))?$l->id_req:'0';
			}else{
				$id_requerimiento = (isset($l->id))?$l->id:'0';
			}

			$e = $this->Empresas_model->get($l->empresa_id);
			$p = $this->Planta_model->get($l->planta_id);
			$ac = $this->Requerimiento_area_cargo_model->get_requerimiento($id_requerimiento);
			$aux = new stdClass();
			$aux->id = $id_requerimiento;
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
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['listado'] = $lista;
		$pagina['id_planta'] = $id_planta;
		$pagina['estado'] = $estado;
		$pagina['empresa_planta'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('requerimiento/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function cambiar_estados_requerimientos(){
		$this->load->model("Requerimientos_model");

		if (!empty($_POST['requerimientos'])?$_POST['requerimientos']:false){
			foreach($_POST['requerimientos'] as $c){
				$data = array(
						"estado" => '0',
					);
				$this->Requerimientos_model->actualizar_estado_activo_requerimiento($c, $data);
			}
		}

		if (!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c){
				$data = array(
						"estado" => '1',
					);
				$this->Requerimientos_model->actualizar_estado_activo_requerimiento($c, $data);
			}
		}
		echo "<script>alert('Requerimientos Actualizados Exitosamente')</script>";
		redirect('est/requerimiento/listado', 'refresh');
	}

	function editar_area_cargo_requerimiento($id_area_cargo, $id_req){
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$listado = array();
		foreach($this->Requerimiento_area_cargo_model->get_result($id_area_cargo) as $r){
			$get_area = $this->Areas_model->r_get($r->areas_id);
			$get_cargo = $this->Cargos_model->r_get($r->cargos_id);
			$aux = new stdClass();
			$aux->id = $r->id;
			$aux->requerimiento_id = $r->requerimiento_id;
			$aux->areas_id = $r->areas_id;
			$aux->nombre_area = (isset($get_area->nombre)?$get_area->nombre:"");
			$aux->cargos_id = $r->cargos_id;
			$aux->nombre_cargo = (isset($get_cargo->nombre)?$get_cargo->nombre:"");
			$aux->cantidad = $r->cantidad;
			$aux->valor = $r->valor_aprox;
			array_push($listado,$aux);
		}
		$pagina['datos_area_cargo_req'] = $listado;
		$pagina['areas'] = $this->Areas_model->lista_orden_nombre();
		$pagina['cargos'] = $this->Cargos_model->lista_orden_nombre();
		$this->load->view('requerimiento/modal_editar_datos_area_cargo_requerimiento', $pagina);
	}

	function editar_requerimiento($id){
		$this->load->model("Requerimientos_model");
		$this->load->model("Relacion_usuario_planta_model");
		$this->load->model("Empresa_planta_model");

		/*
		if($this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11){
			$id_usuario = $this->session->userdata('id');
			$pagina['unidad_negocio'] = $this->Relacion_usuario_planta_model->get_usuario_plantas_relacion($id_usuario);
		}else{
			$pagina['unidad_negocio'] = $this->Empresa_planta_model->listar();
		}
		*/
		$pagina['unidad_negocio'] = $this->Empresa_planta_model->listar();

		$listado = array();
		foreach($this->Requerimientos_model->get_result($id) as $r){
			$get_empresa = $this->Empresa_planta_model->get($r->planta_id);
			$aux = new stdClass();
			$aux->id = $r->id;
			$aux->codigo_requerimiento = $r->codigo_requerimiento;
			$aux->codigo_centro_costo = $r->codigo_centro_costo;
			$aux->nombre = $r->nombre;
			$aux->planta_id = $r->planta_id;
			$aux->nombre_planta = (isset($get_empresa->nombre)?$get_empresa->nombre:"");
			$aux->regimen = $r->regimen;
			$aux->causal = $r->causal;
			$aux->motivo = $r->motivo;
			$aux->f_solicitud = $r->f_solicitud;
			$aux->f_inicio = $r->f_inicio;
			$aux->f_fin = $r->f_fin;
			$aux->comentario = $r->comentario;
			array_push($listado,$aux);
		}
		$pagina['listado'] = $listado;
		$this->load->view('requerimiento/modal_editar_datos_requerimiento', $pagina);
	}

	function actualizar_requerimiento(){
		$this->load->model("Requerimientos_model");
		$id_req = $_POST['id_req'];

		$datos = array(
			"codigo_requerimiento" => $_POST['codigo'],
			"nombre" => $_POST['nombre'],
			"f_solicitud" => $_POST['f_solicitud'],
			"planta_id" => $_POST['select_planta'],
			"regimen" => $_POST['select_regimen'],
			"f_inicio" => $_POST['f_inicio'],
			"f_fin" => $_POST['f_fin'],
			"causal" => $_POST['causal'],
			"motivo" => $_POST['motivo'],
			"comentario" => $_POST['comentario'],
			"codigo_centro_costo"=> $_POST['codigo_centro_costo'],
			);


		$this->Requerimientos_model->actualizar($datos, $id_req);
		echo '<script>alert("Requerimiento Actualizado Exitosamente");</script>';
		redirect('est/requerimiento/listado', 'refresh');
	}

	function actualizar_area_cargo_requerimiento(){
		$this->load->model("Requerimiento_area_cargo_model");
		$id_req = $_POST['id_req'];
		$id_area_cargo = $_POST['id_area_cargo'];
		$valor = str_replace ( ".", "", $_POST['valor']);
		$datos = array(
			"areas_id" => $_POST['area'],
			"cargos_id" => $_POST['cargo'],
			"cantidad" => $_POST['cantidad'],
			"valor_aprox" => $valor,
			);

		$this->Requerimiento_area_cargo_model->actualizar($datos, $id_area_cargo);
		$this->session->set_userdata('exito',3);
		//echo '<script>alert("Areas/Cargos del Requerimiento Actualizado Exitosamente");</script>';
		redirect('est/requerimiento/asignacion/'.$id_req.'', 'refresh');
	}

	function j_areas(){ //ajax
		$this->load->model("Areas_model");
		$listado = array();
		foreach ($this->Areas_model->lista() as $a) {
			$aux = new stdClass();
			$aux->id = $a->id;
			$aux->text = $a->nombre;
			array_push($listado,$aux);
			unset($aux);
		}
		echo json_encode($listado);
	}

	function j_cargos(){ //ajax
		$this->load->model("Cargos_model");
		$listado = array();
		foreach ($this->Cargos_model->lista() as $a) {
			$aux = new stdClass();
			$aux->id = $a->id;
			$aux->text = $a->nombre;
			array_push($listado,$aux);
			unset($aux);
		}
		echo json_encode( $listado );
	}

	function guardar_vista_previa(){
		$this->load->library('session');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Requerimiento_model");

		$data = json_decode($_POST['json']);

		$listado = "";
		$areas = $data->areas;
		$cargos = $data->cargo;

		$base['id_requerimiento'] = $this->Requerimiento_model->ultimo_requerimiento();
		$base['nombre'] = $data->n_solicitud;
		$base['areas'] = $areas;
		$base['cant_areas'] = count($areas);
		$base['cargos'] = $cargos;
		$this->load->view('requerimiento/json_planilla',$base);

	}

	function guardar_vista_previa2(){
		$this->load->library('session');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");

		$data = json_decode($_POST['json']);

		$areas = $data->areas;
		$cargos = $data->cargo;

		$listado = array();
		//$areas = array();
		$areas_nb = array();
		//$cargos = array();
		$cargos_nb = array();
		$personas = array();
		$ids = array();
		$p_asignadas = array();


		array_push($areas_nb,"<div><b>Especialidad / Areas</b></div>");
		foreach ($data->areas as $a) {
			array_push($areas_nb,"<b>".$this->Areas_model->r_get($a)->nombre."</b>");
		}
		array_push($listado, $areas_nb);

		$z = 0;
		foreach ($data->cargo as $c) {
			array_push($cargos_nb,$this->Cargos_model->r_get($c)->nombre);
			$nb_cargo = $this->Cargos_model->r_get($c)->nombre;
			$resto = array();
			for($i=0;$i<count($data->areas);$i++){
				$resto[] = 0;
				$z++;
			}
			$salida = array();

			array_push($salida, "<b>".$nb_cargo."</b>");
			$res = array_merge($salida, $resto);
			//array_push($res, "renderer: 'html'");
			array_push($listado, $res);
		}
		header("Content-type: application/json");
		echo json_encode($listado);
	}

	function guardar_req(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->library('session');
			$this->load->model("Requerimiento_model");

			$data = json_decode($_POST['basico']);
			
			$f_s = explode('-',$data->f_solicitud);
			$f_solicitud = $f_s[2].'-'.$f_s[1].'-'.$f_s[0];

			$f_d = explode('-',$data->fdesde);
			$fdesde = $f_d[2].'-'.$f_d[1].'-'.$f_d[0];

			$f_h = explode('-',$data->fhasta);
			$fhasta = $f_h[2].'-'.$f_h[1].'-'.$f_h[0];

			$data = array(
				'codigo_requerimiento' => $data->codigo_requerimiento,
				'nombre' => strtoupper($data->n_solicitud),
				'f_solicitud' => $f_solicitud,
				'empresa_id' => 2,
				//'centro_costo_id' => $data->select_empresa,
				'planta_id' => $data->select_planta,
				'regimen' => $data->select_regimen,
				'f_inicio' => $fdesde,
				'f_fin' => $fhasta,
				'causal' => $data->causal,
				'motivo' => $data->motivo,
				'comentario' => $data->comentarios,
				'estado' => 1
			);
			$id_req = $this->Requerimiento_model->r_ingresar($data);
			//$ultimo_id = $this->db->insert_id();
			echo $id_req;
			return $id_req;
		}
	}


	function guardar_datos_requerimiento(){
		$this->load->model("Empresa_planta_model");
		$this->load->model("Requerimiento_model");

		$f_s = explode('-',$_POST['f_solicitud']);
		$f_solicitud = $f_s[2].'-'.$f_s[1].'-'.$f_s[0];

		$f_d = explode('-',$_POST['fdesde']);
		$fdesde = $f_d[2].'-'.$f_d[1].'-'.$f_d[0];

		$f_h = explode('-',$_POST['fhasta']);
		$fhasta = $f_h[2].'-'.$f_h[1].'-'.$f_h[0];
		$planta = $_POST['select_planta'];
		$get_datos_planta = $this->Empresa_planta_model->get($planta);
		$empresa_id = isset($get_datos_planta->id_centro_costo)?$get_datos_planta->id_centro_costo:'2';

		$data = array(
			'codigo_requerimiento' => $_POST['codigo_requerimiento'],
			'codigo_centro_costo' => $_POST['codigo_centro_costo'],
			'nombre' => strtoupper($_POST['n_solicitud']),
			'f_solicitud' => $f_solicitud,
			'empresa_id' => $empresa_id,
			'centro_costo_id' => NULL,
			'planta_id' => $_POST['select_planta'],
			'regimen' => $_POST['select_regimen'],
			'fecha_creacion' => date('Y-m-d'),
			'f_inicio' => $fdesde,
			'f_fin' => $fhasta,
			'causal' => $_POST['causal'],
			'motivo' => $_POST['motivo'],
			'comentario' => $_POST['comentarios'],
			'estado' => 1,
			'estado2' => 1
		);
		$id_req = $this->Requerimiento_model->r_ingresar($data);
		$this->session->set_userdata('exito',1);
		//echo "<script>alert('Requerimiento Guardado Exitosamente')</script>";
		redirect('est/requerimiento/asignacion/'.$id_req, 'refresh');
	}

	function guardar_area_cargo($salida){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model("Requerimiento_area_cargo_model");
			$this->load->library('session');

			//$data = json_decode($_POST['area_cargo']);

			//$salida2 = explode('-', $data->$salida);
			$salida2 = explode('-', $salida);
			$cantidad = $salida2[0];
			$cargo = $salida2[1];
			$area = $salida2[2];
			$id_req = $salida2[3];
			$arr = array(
				'requerimiento_id' => $id_req,
				'areas_id' => $area,
				'cargos_id' => $cargo,
				'cantidad' => $cantidad
			);
			$this->Requerimiento_area_cargo_model->ingresar($arr);
		}
	}

	function guardar_area_cargo_copia(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model("Requerimiento_area_cargo_model");
			$this->load->library('session');

			$data = json_decode($_POST['area_cargo']);

			$salida2 = explode('-', $data->salida);
			$cantidad = $salida2[0];
			$cargo = $salida2[1];
			$area = $salida2[2];
			//$id_req = $salida2[3];
			$arr = array(
				//'requerimiento_id' => $id_req,
				'areas_id' => $area,
				'cargos_id' => $cargo,
				'cantidad' => $cantidad
			);
			$this->Requerimiento_area_cargo_model->ingresar($arr);
		}
	}
	
	function planilla($id){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->model('Empresas_model');
		$this->load->model('Planta_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");

		if( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11){
			$base = array(
				'head_titulo' => "Sistema EST",
				'titulo' => "Planilla de requerimientos",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'home/index', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Planilla' )),
				'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/planilla.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
				'menu' => $this->menu
			);
		}else{
			$base = array(
				'head_titulo' => "Sistema EST",
				'titulo' => "Planilla de requerimientos",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'home/index', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/listado','txt' => 'Requerimientos'), array('url'=>'','txt'=>'Planilla' )),
				'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/planilla.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
				'menu' => $this->menu
			);
		}


		$pagina['requerimiento'] = $this->Requerimientos_model->get($id);
		$pagina['empresa'] = $this->Empresas_model->get($pagina['requerimiento']->empresa_id)->razon_social;
		$pagina['planta'] = $this->Planta_model->get($pagina['requerimiento']->planta_id)->nombre;
		$area_cargo =  $this->Requerimiento_area_cargo_model->get_requerimiento($id);

		$i = 0;
		$areas = array();
		$cargos = array();
		$personas = array();
		$ids = array();
		$p_asignadas = array();


		foreach($area_cargo as $r){
			if (!in_array($r->areas_id, $areas)) {
    			array_push($areas, $r->areas_id );
			}
			if (!in_array($r->cargos_id, $cargos)) {
    			array_push($cargos, $r->cargos_id );
			}
			
			array_push($personas, $r->cantidad );
			array_push($ids, $r->id );
			array_push($p_asignadas, count($this->Requerimiento_asc_trabajadores_model->get_cargo_area($r->id)) );

			/*$p_asignadas = count($this->Requerimiento_asc_trabajadores_model->get_cargo_area($r->id));

			$nb_area = $this->Areas_model->r_get($r->areas_id);
			$nb_cargo = $this->Cargos_model->r_get($r->cargos_id);

			$salida[$i] = array( 'areas' => $nb_area->nombre, 'cargo' => $nb_cargo->nombre, 'personas' => $r->cantidad, 'asignadas' => $p_asignadas, 'url' => $r->id );
			$i++;*/
		}
		//$pagina['lista'] = $salida;
		$pagina['areas'] = $areas;
		$pagina['cargos'] = $cargos;
		$pagina['personas'] = $personas;
		$pagina['ids'] = $ids;
		$pagina['asignadas'] = $p_asignadas;

		$base['cuerpo'] = $this->load->view('requerimiento/planilla',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function planilla2($id){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->model('Empresas_model');
		$this->load->model('Planta_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Planilla de requerimientos",
			'subtitulo' => '',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/listado','txt' => 'Requerimiento'), array('url'=>'','txt'=>'Planilla' )),
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/planilla.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'menu' => $this->menu
		);
		$pagina['requerimiento'] = $this->Requerimientos_model->get($id);
		$pagina['empresa'] = $this->Empresas_model->get($pagina['requerimiento']->empresa_id)->razon_social;
		$pagina['planta'] = $this->Planta_model->get($pagina['requerimiento']->planta_id)->nombre;
		$area_cargo =  $this->Requerimiento_area_cargo_model->get_requerimiento($id);
		$i = 0;
		$areas = array();
		$cargos = array();
		$personas = array();
		$ids = array();
		$p_asignadas = array();

		foreach($area_cargo as $r){
			if (!in_array($r->areas_id, $areas)) {
    			array_push($areas, $r->areas_id );
			}
			if (!in_array($r->cargos_id, $cargos)) {
    			array_push($cargos, $r->cargos_id );
			}
			array_push($personas, $r->cantidad );
			array_push($ids, $r->id );
			array_push($p_asignadas, count($this->Requerimiento_asc_trabajadores_model->get_cargo_area($r->id)) );
		}
		$pagina['id_requerimiento'] = $id;
		$pagina['areas'] = $areas;
		$pagina['cargos'] = $cargos;
		$pagina['personas'] = $personas;
		$pagina['ids'] = $ids;
		$pagina['asignadas'] = $p_asignadas;
		$base['cuerpo'] = $this->load->view('requerimiento/planilla',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function evaluacion_pgp($id){
		$base = array(
			'head_titulo' => "Evaluacion Requerimiento - Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/listado','txt' => 'Requerimientos'), array('url'=>'','txt'=>'Planilla' )),
			'side_bar' => false,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);

		$this->load->model('Noticias_model');
		$this->load->model("Usuarios_model");
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Archivos_trab_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('r_requerimiento_evaluacion_model');
		$this->load->helper("text");
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['noticias'] = "";
		$id_planta = "";
		$listado = array();

		foreach($this->Requerimiento_asc_trabajadores_model->get_requerimiento($id) as $r){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->usuario_id);
			$area = $this->Areas_model->r_get($r->areas_id);
			$cargo = $this->Cargos_model->r_get($r->cargos_id);
			$ar_contrato = $this->Archivos_trab_model->get_archivo($r->usuario_id,15);
			$ar_certificado = $this->Archivos_trab_model->get_archivo($r->usuario_id,9);
			$get_calif_requer = $this->r_requerimiento_evaluacion_model->get_evaluacion_row($r->usuario_id, $id);
			$aux->calificacion_final = (isset($get_calif_requer->calificacion_final)?$get_calif_requer->calificacion_final:'0');
			$aux->id = $r->id;
			$aux->usuario_id = $r->usuario_id;
			$aux->nombre = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
			$aux->fecha = $r->fecha;
			$aux->referido = $r->referido;
			$aux->contacto = $r->contacto;
			$aux->disponibilidad = $r->disponibilidad;
			$aux->contrato = $r->contrato;
			$aux->status = $r->status;
			$aux->area = $area->nombre;
			$aux->cargo = $cargo->nombre;
			$aux->contrato = $ar_contrato;
			$aux->certificado = $ar_certificado;
			$aux->comentario = $r->comentario;
			$aux->jefe_area = $r->jefe_area;
			$aux->asc_trabajadores = $r->id_asc_trabajadores;
			array_push($listado,$aux);
		}

		$pagina['listado'] = $listado;
		$pagina['area_cargo_id'] = $id;
		$base['cuerpo'] = $this->load->view('requerimiento/evaluacion_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_ingresar_evaluacion($usuario,$area_cargo){
		$this->load->model("usuarios_model");
		$this->load->model("r_requerimiento_evaluacion_model");
		$datos_requerimiento = $this->r_requerimiento_evaluacion_model->get_evaluacion($usuario, $area_cargo);
		$lista_aux = array();
		if (!empty($datos_requerimiento)){
			foreach ($datos_requerimiento as $rm){
				$aux = new stdClass();
				$aux->trabajo_equipo = (isset($rm->trabajo_equipo)?$rm->trabajo_equipo:'0');
				$aux->orientacion_calidad = (isset($rm->orientacion_calidad)?$rm->orientacion_calidad:'0');
				$aux->orientacion_logro = (isset($rm->orientacion_logro)?$rm->orientacion_logro:'0');
				$aux->iniciativa_productividad = (isset($rm->iniciativa_productividad)?$rm->iniciativa_productividad:'0');
				$aux->adaptabilidad_al_cambio = (isset($rm->adaptabilidad_al_cambio)?$rm->adaptabilidad_al_cambio:'0');
				$aux->capacidad_aprendizaje = (isset($rm->capacidad_aprendizaje)?$rm->capacidad_aprendizaje:'0');
				$aux->concientizacion_seguridad_ma = (isset($rm->concientizacion_seguridad_ma)?$rm->concientizacion_seguridad_ma:'0');
				$aux->tolerancia_trabajo_bajo_presion = (isset($rm->tolerancia_trabajo_bajo_presion)?$rm->tolerancia_trabajo_bajo_presion:'0');
				$aux->comunicacion_todo_nivel = (isset($rm->comunicacion_todo_nivel)?$rm->comunicacion_todo_nivel:'0');
				$aux->analisis_evaluacion_problemas = (isset($rm->analisis_evaluacion_problemas)?$rm->analisis_evaluacion_problemas:'0');
				$aux->disponibilidad_recibir_ordenes = (isset($rm->disponibilidad_recibir_ordenes)?$rm->disponibilidad_recibir_ordenes:'0');
				$aux->relaciones_interpersonales = (isset($rm->relaciones_interpersonales)?$rm->relaciones_interpersonales:'0');
				$aux->aplicacion_conocimientos = (isset($rm->aplicacion_conocimientos)?$rm->aplicacion_conocimientos:'0');
				$aux->capacidad_toma_decisiones = (isset($rm->capacidad_toma_decisiones)?$rm->capacidad_toma_decisiones:'0');
				$aux->liderazgo = (isset($rm->liderazgo)?$rm->liderazgo:'0');
				$aux->responsabilidad = (isset($rm->responsabilidad)?$rm->responsabilidad:'0');
				$aux->autocuidado = (isset($rm->autocuidado)?$rm->autocuidado:'0');
				$aux->presentacion_personal = (isset($rm->presentacion_personal)?$rm->presentacion_personal:'0');
				$aux->cumplimiento_normas = (isset($rm->cumplimiento_normas)?$rm->cumplimiento_normas:'0');
				$aux->motivacion = (isset($rm->motivacion)?$rm->motivacion:'0');
				$aux->respeto = (isset($rm->respeto)?$rm->respeto:'0');
				$aux->recomienda = (isset($rm->recomienda)?$rm->recomienda:'0');
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$pagina['usuario'] = $this->usuarios_model->get($usuario);
		$pagina['id_usuario'] = $usuario;
		$pagina['area_cargo'] = $area_cargo;
		$this->load->view('requerimiento/modal_detalles_evaluacion', $pagina);
	}

	/*
		*al momento de objetar poder generar contrato y enviarlo por SendDocument
		*estado de las vistas del estado del contrato 
		*update de trabajadores 
		*cookie variables documentacion del contrato pacto de horas extras
		*adonis js flutter
	*/

	function planilla_json($id){
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$listado = array();
		$areas = array();
		$areas_nb = array();
		$cargos = array();
		$cargos_nb = array();
		$personas = array();
		$ids = array();
		$p_asignadas = array();

		foreach($this->Requerimiento_area_cargo_model->get_requerimiento($id) as $r){

			if (!in_array($r->areas_id, $areas)) {
    			array_push($areas, $r->areas_id );
			}
			if (!in_array($r->cargos_id, $cargos)) {
    			array_push($cargos, $r->cargos_id );
			}
			
			array_push($personas, $r->cantidad );
			array_push($ids, $r->id );
			array_push($p_asignadas, count($this->Requerimiento_asc_trabajadores_model->get_cargo_area($r->id)) );
		}

		array_push($areas_nb,"<b>Especialidad / Areas</b>");
		foreach ($areas as $a) {
			array_push($areas_nb,"<b>".$this->Areas_model->r_get($a)->nombre."</b>");
		}
		array_push($listado, $areas_nb);

		$z = 0;
		foreach ($cargos as $c) {
			array_push($cargos_nb,$this->Cargos_model->r_get($c)->nombre);
			$nb_cargo = $this->Cargos_model->r_get($c)->nombre;
			$resto = array();
			for($i=0;$i<count($areas);$i++){
				$resto[] = "<a href='".base_url()."est/requerimiento/usuarios_requerimiento/".$ids[$z]."'>".$p_asignadas[$z].'/'.$personas[$z]."</a>";
				$z++;
			}
			$salida = array();

			array_push($salida, "<b>".$nb_cargo."</b>");
			$res = array_merge($salida, $resto);
			//array_push($res, "renderer: 'html'");
			array_push($listado, $res);
		}

		//echo json_encode($areas_nb);
		//echo json_encode($cargos_nb);
		//echo json_encode($personas);
		//echo json_encode($p_asignadas);
		echo json_encode($listado);

	}

	function agregar_session2($id,$add_remove = FALSE){
		//$usuario_req = array();

		if(!$this->session->set_userdata('usuario_req[]') ){
			//if($add_remove=='add'){
				//$data = array($id);
				$this->session->set_userdata('usuario_req[]', $id);
				$usuarios_req = $this->session->userdata('usuario_req[]');
				//print_r($this->session->flashdata('usuario_req'));
			//}
		}else{
			$usuarios_req = $this->session->userdata('usuario_req');
			if($add_remove=='add'){
				$datos = array_push($usuarios_req,$id);
				$this->session->set_userdata($usuario_req, $datos);
			}else{
				if(in_array($id,$usuarios_req)){
					$nuevo_usuarios_req = array_diff($usuarios_req, array($id));
					$this->session->set_userdata('usuario_req', $nuevo_usuarios_req);
				}
			}
			//print_r($this->session->flashdata('usuario_req'));
		}
		echo json_encode($this->session->userdata($usuarios_req));
	}




	function agregar_session($id,$add_remove = FALSE){
		if(!$this->session->flashdata('usuario_req')){
			if($add_remove=='add'){
				$data = array($id);
				$this->session->set_flashdata('usuario_req', $data);
			}
		}else{
			$usuarios_req = $this->session->flashdata('usuario_req');
			if($add_remove=='add'){
				array_push($usuarios_req,$id);
				//$this->session->set_flashdata('usuario_req', $datos);
			}else{
				if(in_array($id,$usuarios_req)){
					$nuevo_usuarios_req = array_diff($usuarios_req, array($id));
					$this->session->set_flashdata('usuario_req', $nuevo_usuarios_req);
				}
			}
		}
		echo json_encode($this->session->flashdata('usuario_req'));
	}

	function guardar_usuarios_requerimiento($id){
		if( $this->session->flashdata('usuario_req') ){
			$this->load->model("Requerimiento_model");
			$this->load->model("Requerimiento_area_cargo_model");

			$this->load->model("Requerimiento_asc_trabajadores_model");
			foreach ($this->session->flashdata('usuario_req') as $r) {
				$s = $this->Requerimiento_area_cargo_model->get($id);
				$c = $this->Requerimiento_model->r_get($s->requerimiento_id);
				
				$data = array('requerimiento_area_cargo_id' => $id, 'usuario_id' => $r, 'fecha' => $c->f_solicitud );

				$this->Requerimiento_asc_trabajadores_model->ingresar($data);
			}
		}
		else
			echo "error";
	}

	function usuarios_requerimiento($id_area_cargo = false, $id_usuario = FALSE){
		if (!$id_area_cargo) {
			redirect(base_url(),'refresh');
		}
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->model('Archivos_trab_model');
		$this->load->model('Empresas_model');
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model('Planta_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Listanegra_model");
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("Sre_evaluacion_req_model");
		$this->load->model('Examenes_psicologicos_model');

		$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		if(!$r_area_cargo){
		    	redirect(base_url(),'refresh');
		}

		if( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11){
			$base = array(
				'head_titulo' => "Sistema EST",
				'titulo' => "Usuarios asignados",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/asignacion/'.(isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0').'','txt' => 'Area-Cargo Requerimiento'), array('url'=>'','txt'=>'Lista de usuarios' )),
				'menu' => $this->menu,
				'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_req.js','js/si_validaciones.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);
		}else{
			$base = array(
				'head_titulo' => "Sistema EST",
				'titulo' => "Usuarios asignados",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/listado','txt' => 'Requerimientos'), array('url'=>'est/requerimiento/asignacion/'.(isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0').'','txt' => 'Area-Cargo Requerimiento'), array('url'=>'','txt'=>'Lista de usuarios' )),
				'menu' => $this->menu,
				'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','js/lista_usuarios_req.js','js/si_validaciones.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);
		}

		$listado = array();
		$pagina['id_requerimiento'] = (isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0');
		$reque = $this->Requerimientos_model->get($r_area_cargo->requerimiento_id);
		$pagina['nombre_req'] = isset($reque->nombre)?$reque->nombre:'';
		$pagina['empresa'] = $this->Empresas_model->get($reque->empresa_id)->razon_social;
		$pagina['centro_costo'] = $this->Empresa_planta_model->get_planta_centro_costo($reque->planta_id)->desc_centrocosto;
		$pagina['planta'] = $this->Planta_model->get($reque->planta_id)->nombre;
		$pagina['fecha'] = $reque->f_solicitud;
		$pagina['fecha_inicio'] = $reque->f_inicio;
		$pagina['fecha_termino'] = $reque->f_fin;
		$pagina['area_cargo'] = $id_area_cargo;
		$pagina['area'] = $this->Areas_model->r_get($r_area_cargo->areas_id)->nombre;
		$pagina['cargo'] = $this->Cargos_model->r_get($r_area_cargo->cargos_id)->nombre;
		$pagina['paso_usuario'] =  ($id_usuario)?$id_usuario:FALSE;
		$pagina['cantidad'] = $r_area_cargo->cantidad;
		$fecha_termino_req = $reque->f_fin;
		$fecha_inicio_req = $reque->f_inicio;

		$i = 0;
		foreach($this->Requerimiento_asc_trabajadores_model->get_cargo_area($id_area_cargo) as $r){
			$aux = new stdClass();
			
			$estado_envio = 0;

			$usr = $this->Usuarios_model->get($r->usuario_id);
			//$masso = $this->Evaluaciones_model->get_una_masso($r->usuario_id);
			$ar_contrato = $this->Archivos_trab_model->get_archivo($r->usuario_id,15);
			$ar_certificado = $this->Archivos_trab_model->get_archivo($r->usuario_id,9);
			$aux->id = $r->id;
			$aux->id_req = $id_area_cargo;
			$aux->usuario_id = $r->usuario_id;
			$aux->nombre = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
			$aux->fecha = $r->fecha;
			$aux->referido = $r->referido;
			$aux->contacto = $r->contacto;
			$aux->disponibilidad = $r->disponibilidad;
			$aux->contrato = $r->contrato;
			$aux->status = $r->status;

			$masso = $this->Evaluaciones_model->get_una_masso($r->usuario_id);
			$aux->masso = $masso;

			$preoc = $this->Evaluaciones_model->get_una_preocupacional($r->usuario_id);
			$aux->preocupacional = $preoc;

			$psicol = $this->Examenes_psicologicos_model->get_ultimo_examen($r->usuario_id);
			$aux->psicologico = $psicol;

			$id_asc_trabajador = isset($r->id)?$r->id:'';
			$id_requerimiento = (isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0');
			$get_solicitud = $this->Solicitud_revision_examenes_model->get_usu_req($r->usuario_id, $id_requerimiento, $id_asc_trabajador);
			$id_solicitud_revision = isset($get_solicitud->id)?$get_solicitud->id:'';
			$id_masso = isset($masso->id_masso)?$masso->id_masso:'';
			$id_preo = isset($preoc->preo_id)?$preoc->preo_id:'';
			$id_psicol = isset($psicol->eval_psic_id)?$psicol->eval_psic_id:'';

			$get_sre_req_masso = $this->Sre_evaluacion_req_model->get_row_por_tipo($id_solicitud_revision, $id_masso, 1);
			$get_sre_req_preo = $this->Sre_evaluacion_req_model->get_row_por_tipo($id_solicitud_revision, $id_preo, 2);
			$get_sre_req_psicol = $this->Sre_evaluacion_req_model->get_row_por_tipo($id_solicitud_revision, $id_psicol, 3);

			$estado_sre_masso = isset($get_sre_req_masso->estado)?$get_sre_req_masso->estado:NULL;
			$estado_sre_preo = isset($get_sre_req_preo->estado)?$get_sre_req_preo->estado:NULL;
			$estado_sre_psicol = isset($get_sre_req_psicol->estado)?$get_sre_req_psicol->estado:NULL;

			if($estado_sre_masso == NULL)
				$aux->badge_masso = "<span class='badge' style='background-color:#000000'>NG</span>";
			elseif($estado_sre_masso == 0)
				$aux->badge_masso = "<span class='badge' style='background-color:#D7DF01'>EP</span>";
			elseif($estado_sre_masso == 1)
				$aux->badge_masso = "<span class='badge' style='background-color:green'>A</span>";
			elseif($estado_sre_masso == 2)
				$aux->badge_masso = "<span class='badge' style='background-color:red'>R</span>";
			elseif($estado_sre_masso == 3)
				$aux->badge_masso = "<span class='badge' style='background-color:#886A08'>NA</span>";

			if($estado_sre_preo == NULL)
				$aux->badge_preo = "<span class='badge' style='background-color:#000000'>NG</span>";
			elseif($estado_sre_preo == 0)
				$aux->badge_preo = "<span class='badge' style='background-color:#D7DF01'>EP</span>";
			elseif($estado_sre_preo == 1)
				$aux->badge_preo = "<span class='badge' style='background-color:green'>A</span>";
			elseif($estado_sre_preo == 2)
				$aux->badge_preo = "<span class='badge' style='background-color:red'>R</span>";
			elseif($estado_sre_preo == 3)
				$aux->badge_preo = "<span class='badge' style='background-color:#886A08'>NA</span>";
			
			if($estado_sre_psicol == NULL)
				$aux->badge_psicol = "<span class='badge' style='background-color:#000000'>NG</span>";
			elseif($estado_sre_psicol == 0)
				$aux->badge_psicol = "<span class='badge' style='background-color:#D7DF01'>EP</span>";
			elseif($estado_sre_psicol == 1)
				$aux->badge_psicol = "<span class='badge' style='background-color:green'>A</span>";
			elseif($estado_sre_psicol == 2)
				$aux->badge_psicol = "<span class='badge' style='background-color:red'>R</span>";
			elseif($estado_sre_psicol == 3)
				$aux->badge_psicol = "<span class='badge' style='background-color:#886A08'>NA</span>";

			$masso_req = $this->Evaluaciones_model->get_una_masso_requerimiento($r->usuario_id, $fecha_inicio_req, $fecha_termino_req);
			$estado_inicio_masso = isset($masso_req->estado_inicio_masso)?$masso_req->estado_inicio_masso:NULL;
			$estado_termino_masso = isset($masso_req->estado_fin_masso)?$masso_req->estado_fin_masso:"";

			$examen_req = $this->Evaluaciones_model->get_una_preocupacional_requerimiento($r->usuario_id, $fecha_inicio_req, $fecha_termino_req);
			$get_estado_inicio_examen = isset($examen_req->estado_inicio_preo)?$examen_req->estado_inicio_preo:"";
			$estado_inicio_examen = $get_estado_inicio_examen + 365; 
			$get_estado_termino_examen = isset($examen_req->estado_fin_preo)?$examen_req->estado_fin_preo:"";
			$estado_termino_examen = $get_estado_termino_examen + 365;

			$psicol_req = $this->Examenes_psicologicos_model->get_ultimo_examen($r->usuario_id, $fecha_inicio_req, $fecha_termino_req);
			$estado_inicio_psicol = isset($psicol_req->estado_inicio_psicol)?$psicol_req->estado_inicio_psicol:NULL;
			$estado_termino_psicol = isset($psicol_req->estado_fin_psicol)?$psicol_req->estado_fin_psicol:"";

			if($estado_inicio_masso == NULL){
				$aux->color_masso = "";
				$aux->masso = "";
			}else{
				if($estado_inicio_masso >= 0 and $estado_termino_masso <= 0){
					$color_masso = "#FFBF00";
					$dedo_masso = "fa fa-thumbs-up";
				}elseif($estado_inicio_masso <= 0){
					$color_masso = "red";
					$dedo_masso = "fa fa-thumbs-down";
				}elseif($estado_termino_masso >= 0){
					$color_masso = "green";
					$dedo_masso = "fa fa-thumbs-up";
				}else{
					$color_masso = "red";
					$dedo_masso = "fa fa-thumbs-down";
				}

				$aux->color_masso = $color_masso;
				$aux->dedo_masso = $dedo_masso;
			}

			if(!$estado_inicio_examen){
				$aux->color_examen = "";
				$aux->preocupacional = "";
			}else{
				if($estado_inicio_examen >= 0 and $estado_termino_examen <= 0){
					$color_examen = "#FFBF00";
					$dedo_preo = "fa fa-thumbs-up";
				}elseif($estado_inicio_examen <= 0){
					$color_examen = "red";
					$dedo_preo = "fa fa-thumbs-down";
				}elseif($estado_termino_examen >= 0){
					$color_examen = "green";
					$dedo_preo = "fa fa-thumbs-up";
				}else{
					$color_examen = "red";
					$dedo_preo = "fa fa-thumbs-down";
				}

				$aux->color_examen = $color_examen;
				$aux->dedo_preo = $dedo_preo;
			}

			if(!$estado_inicio_psicol){
				$aux->color_psicol = "";
				$aux->psicologico = "";
			}else{
				if($estado_inicio_psicol >= 0 and $estado_termino_psicol <= 0){
					$color_psicol = "#FFBF00";
					$dedo_psicol = "fa fa-thumbs-up";
				}elseif($estado_inicio_psicol <= 0){
					$color_psicol = "red";
					$dedo_psicol = "fa fa-thumbs-down";
				}elseif($estado_termino_psicol >= 0){
					$color_psicol = "green";
					$dedo_psicol = "fa fa-thumbs-up";
				}else{
					$color_psicol = "red";
					$dedo_psicol = "fa fa-thumbs-down";
				}

				$aux->color_psicol = $color_psicol;
				$aux->dedo_psicol = $dedo_psicol;
			}

			$aux->contrato = $ar_contrato;
			$aux->certificado = $ar_certificado;
			$aux->comentario = $r->comentario;
			$aux->jefe_area = $r->jefe_area;
			$aux->valor_masso = (isset($masso->valor_examen)?$masso->valor_examen:"0");
			$aux->valor_examen = (isset($preoc->valor_examen)?$preoc->valor_examen:"0");

			$contratos_usu = $this->Requerimiento_Usuario_Archivo_model->get_result_tipo_archivo_usuario($r->usuario_id, $id_asc_trabajador, 1);
			/*$anexos_usu = $this->Requerimiento_Usuario_Archivo_model->get_result_tipo_archivo_usuario($r->usuario_id, $id_asc_trabajador, 2);*/
			$anexos_usu = $this->Requerimiento_Usuario_Archivo_model->get_anexos($r->usuario_id, $id_asc_trabajador);
			$cantidad_contratos_realizados = 0;
			$cantidad_contratos_realizados_generados = 0;
			if($contratos_usu != FALSE){
				foreach($contratos_usu as $row){
					$cantidad_contratos_realizados += 1;

					if($row->estado_generacion_contrato == 1)
						$cantidad_contratos_realizados_generados += 1;
				}
			}

			if($anexos_usu != FALSE){
				foreach($anexos_usu as $row2){
					$cantidad_contratos_realizados += 1;

					if($row2->estado_generacion_contrato == 1)
						$cantidad_contratos_realizados_generados += 1;
				}
			}

			$aux->cantidad_contratos_realizados = $cantidad_contratos_realizados;
			$aux->cantidad_contratos_realizados_generados = $cantidad_contratos_realizados_generados;

			$i++;
			array_push($listado,$aux);
		}
		$pagina['listado'] = $listado;
		$pagina['agregados'] = $i;
		$base['cuerpo'] = $this->load->view('requerimiento/usuarios_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function usuarios_general_requerimiento($id_req){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->model('Archivos_trab_model');
		$this->load->model('Empresas_model');
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model('Planta_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("ciudad_model");
		$this->load->model("Sre_evaluacion_req_model");
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("Examenes_psicologicos_model");

		if( $this->session->userdata('tipo_usuario') == 4){
			$base = array(
				'head_titulo' => "Sistema EST",
				'titulo' => "Usuarios asignados",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/asignacion/'.$id_req.'','txt' => 'Area-Cargo Requerimiento'), array('url'=>'','txt'=>'Lista de usuarios' )),
				'menu' => $this->menu,
				'js' => array('js/si_exportar_excel.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_req.js', 'js/si_validaciones.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);
		}else{
			$base = array(
				'head_titulo' => "Sistema EST",
				'titulo' => "Usuarios asignados",
				'subtitulo' => '',
				'side_bar' => false,
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/listado','txt' => 'Requerimientos'), array('url'=>'est/requerimiento/asignacion/'.$id_req.'','txt' => 'Area-Cargo Requerimiento'), array('url'=>'','txt'=>'Lista de usuarios' )),
				'menu' => $this->menu,
				'js' => array('js/si_exportar_excel.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_req.js', 'js/si_validaciones.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			);
		}

		$pagina['id_requerimiento'] = $id_req;
		$reque = $this->Requerimientos_model->get($id_req);
		//$get_centro_costo = $this->Empresa_planta_model->get_planta_centro_costo($reque->planta_id);
		$pagina['nombre_req'] = $reque->nombre;
		$pagina['codigo_requerimiento'] = $reque->codigo_requerimiento;
		$pagina['fecha'] = $reque->f_solicitud;
		$pagina['fecha_termino'] = $reque->f_fin;
		$pagina['empresa'] = $this->Empresas_model->get($reque->empresa_id)->razon_social;
		$pagina['centro_costo'] = $this->Empresa_planta_model->get_planta_centro_costo($reque->planta_id)->desc_centrocosto;
		$pagina['planta'] = $this->Planta_model->get($reque->planta_id)->nombre;
		$pagina['fecha_inicio'] = $reque->f_inicio;
		$fecha_termino_req = $reque->f_fin;
		$fecha_inicio_req = $reque->f_inicio;

		$listado = array();
		$i = 0;
		foreach($this->Requerimiento_asc_trabajadores_model->get_requerimiento($id_req) as $r){
			$aux = new stdClass();
			$get_areas_cargos_req_usu = $this->Requerimiento_area_cargo_model->r_get_area_cargo($r->requerimiento_area_cargo_id);
			$aux->nombre_area = (isset($get_areas_cargos_req_usu->nombre_area)?$get_areas_cargos_req_usu->nombre_area:"");
			$aux->nombre_cargo = (isset($get_areas_cargos_req_usu->nombre_cargo)?$get_areas_cargos_req_usu->nombre_cargo:"");
			$aux->requerimiento_area_cargo_id = isset($r->requerimiento_area_cargo_id)?$r->requerimiento_area_cargo_id:'';

			$existe_anexo = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($r->usuario_id, $r->id_asc_trabajadores, 2);
			$existe_contrato = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($r->usuario_id, $r->id_asc_trabajadores, 1);
		
			if($existe_anexo == 1){
				$get_datos_causal_motivo = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_datos($r->usuario_id, $r->id_asc_trabajadores, 2);
			}elseif($existe_contrato == 1){
				$get_datos_causal_motivo = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_datos($r->usuario_id, $r->id_asc_trabajadores, 1);
			}else{
				$get_datos_causal_motivo = "ERROR";
			}

			$causal = (isset($get_datos_causal_motivo->causal))?$get_datos_causal_motivo->causal:'';
			$aux->motivo = (isset($get_datos_causal_motivo->motivo))?$get_datos_causal_motivo->motivo:'';
			$aux->jornada = (isset($get_datos_causal_motivo->jornada))?$get_datos_causal_motivo->jornada:'';
			$aux->renta_imponible = (isset($get_datos_causal_motivo->renta_imponible))?$get_datos_causal_motivo->renta_imponible:'';
			$aux->bono_responsabilidad = (isset($get_datos_causal_motivo->bono_responsabilidad))?$get_datos_causal_motivo->bono_responsabilidad:'';
			$aux->sueldo_base_mas_bonos_fijos = (isset($get_datos_causal_motivo->sueldo_base_mas_bonos_fijos))?$get_datos_causal_motivo->sueldo_base_mas_bonos_fijos:'';
			$aux->asignacion_colacion = (isset($get_datos_causal_motivo->asignacion_colacion))?$get_datos_causal_motivo->asignacion_colacion:'';
			$aux->otros_no_imponibles = (isset($get_datos_causal_motivo->otros_no_imponibles))?$get_datos_causal_motivo->otros_no_imponibles:'';
			$aux->seguro_vida_arauco = (isset($get_datos_causal_motivo->seguro_vida_arauco))?$get_datos_causal_motivo->seguro_vida_arauco:'SI';
						
			if($causal == "A"){
				$aux->dias_causal = "N/D";
			}elseif($causal == "B"){
				$aux->dias_causal = "90";
			}elseif ($causal == "C") {
				$aux->dias_causal = "180";
			}elseif ($causal == "D") {
				$aux->dias_causal = "180";
			}elseif ($causal == "E") {
				$aux->dias_causal = "90";
			}else{
				$aux->dias_causal = "N/D";
			}

			$fecha_inicio = (isset($get_datos_causal_motivo->fecha_inicio))?$get_datos_causal_motivo->fecha_inicio:'';
			$fecha_termino = (isset($get_datos_causal_motivo->fecha_termino))?$get_datos_causal_motivo->fecha_termino:'';
			
			if($fecha_inicio == '' or $fecha_termino == '' or $fecha_inicio == '0000-00-00' or $fecha_termino == '0000-00-00' ){
				$aux->dias_contrato = "N/D";
			}else{
				$segundos=strtotime($fecha_termino) - strtotime($fecha_inicio);
				$diferencia_dias=intval($segundos/60/60/24) + 1;
				$aux->dias_contrato = $diferencia_dias;
			}

			$aux->causal = (isset($get_datos_causal_motivo->causal))?$get_datos_causal_motivo->causal:'';
			$aux->fecha_inicio = (isset($get_datos_causal_motivo->fecha_inicio))?$get_datos_causal_motivo->fecha_inicio:'';
			$aux->fecha_termino = (isset($get_datos_causal_motivo->fecha_termino))?$get_datos_causal_motivo->fecha_termino:'';

			$usr = $this->Usuarios_model->get($r->usuario_id);
			$ar_contrato = $this->Archivos_trab_model->get_archivo($r->usuario_id,15);
			$ar_certificado = $this->Archivos_trab_model->get_archivo($r->usuario_id,9);
			$aux->id = $r->id_asc_trabajadores;
			$aux->usuario_id = $r->usuario_id;
			$aux->nombre = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
			$aux->rut_usuario = $usr->rut_usuario;
			$aux->sexo = $usr->sexo;
			$get_nivel_estudios = $this->Nivelestudios_model->get($usr->id_estudios);
			$get_ciudad = $this->ciudad_model->get($usr->id_ciudades);
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'N/D';
			$aux->fecha = $r->fecha;
			$aux->referido = $r->referido;
			$aux->contacto = $r->contacto;
			$aux->disponibilidad = $r->disponibilidad;
			$aux->contrato = $r->contrato;
			$aux->status = $r->status;

			//Inicio codigo ultimo
			$masso = $this->Evaluaciones_model->get_una_masso($r->usuario_id);
			$aux->masso = $masso;

			$preoc = $this->Evaluaciones_model->get_una_preocupacional($r->usuario_id);
			$aux->preocupacional = $preoc;

			$psicol = $this->Examenes_psicologicos_model->get_ultimo_examen($r->usuario_id);
			$aux->psicologico = $psicol;

			$id_asc_trabajador = isset($r->id_asc_trabajadores)?$r->id_asc_trabajadores:'';
			$id_requerimiento = $id_req;
			$get_solicitud = $this->Solicitud_revision_examenes_model->get_usu_req($r->usuario_id, $id_requerimiento, $id_asc_trabajador);
			$id_solicitud_revision = isset($get_solicitud->id)?$get_solicitud->id:'';
			$id_masso = isset($masso->id_masso)?$masso->id_masso:'';
			$id_psicol = isset($psicol->eval_psic_id)?$psicol->eval_psic_id:'';

			$id_preo = isset($preoc->preo_id)?$preoc->preo_id:'';
			$get_sre_req_masso = $this->Sre_evaluacion_req_model->get_row_por_tipo($id_solicitud_revision, $id_masso, 1);
			$get_sre_req_preo = $this->Sre_evaluacion_req_model->get_row_por_tipo($id_solicitud_revision, $id_preo, 2);
			$get_sre_req_psicol = $this->Sre_evaluacion_req_model->get_row_por_tipo($id_solicitud_revision, $id_psicol, 3);

			$estado_sre_masso = isset($get_sre_req_masso->estado)?$get_sre_req_masso->estado:NULL;
			$estado_sre_preo = isset($get_sre_req_preo->estado)?$get_sre_req_preo->estado:NULL;
			$estado_sre_psicol = isset($get_sre_req_psicol->estado)?$get_sre_req_psicol->estado:NULL;

			if($estado_sre_masso == NULL)
				$aux->badge_masso = "<span class='badge' style='background-color:#000000'>NG</span>";
			elseif($estado_sre_masso == 0)
				$aux->badge_masso = "<span class='badge' style='background-color:#D7DF01'>EP</span>";
			elseif($estado_sre_masso == 1)
				$aux->badge_masso = "<span class='badge' style='background-color:green'>A</span>";
			elseif($estado_sre_masso == 2)
				$aux->badge_masso = "<span class='badge' style='background-color:red'>R</span>";
			elseif($estado_sre_masso == 3)
				$aux->badge_masso = "<span class='badge' style='background-color:#886A08'>NA</span>";

			if($estado_sre_preo == NULL)
				$aux->badge_preo = "<span class='badge' style='background-color:#000000'>NG</span>";
			elseif($estado_sre_preo == 0)
				$aux->badge_preo = "<span class='badge' style='background-color:#D7DF01'>EP</span>";
			elseif($estado_sre_preo == 1)
				$aux->badge_preo = "<span class='badge' style='background-color:green'>A</span>";
			elseif($estado_sre_preo == 2)
				$aux->badge_preo = "<span class='badge' style='background-color:red'>R</span>";
			elseif($estado_sre_preo == 3)
				$aux->badge_preo = "<span class='badge' style='background-color:#886A08'>NA</span>";

			if($estado_sre_psicol == NULL)
				$aux->badge_psicol = "<span class='badge' style='background-color:#000000'>NG</span>";
			elseif($estado_sre_psicol == 0)
				$aux->badge_psicol = "<span class='badge' style='background-color:#D7DF01'>EP</span>";
			elseif($estado_sre_psicol == 1)
				$aux->badge_psicol = "<span class='badge' style='background-color:green'>A</span>";
			elseif($estado_sre_psicol == 2)
				$aux->badge_psicol = "<span class='badge' style='background-color:red'>R</span>";
			elseif($estado_sre_psicol == 3)
				$aux->badge_psicol = "<span class='badge' style='background-color:#886A08'>NA</span>";

			$masso_req = $this->Evaluaciones_model->get_una_masso_requerimiento($r->usuario_id, $fecha_inicio_req, $fecha_termino_req);
			$estado_inicio_masso = isset($masso_req->estado_inicio_masso)?$masso_req->estado_inicio_masso:NULL;
			$estado_termino_masso = isset($masso_req->estado_fin_masso)?$masso_req->estado_fin_masso:"";

			$examen_req = $this->Evaluaciones_model->get_una_preocupacional_requerimiento($r->usuario_id, $fecha_inicio_req, $fecha_termino_req);
			$get_estado_inicio_examen = isset($examen_req->estado_inicio_preo)?$examen_req->estado_inicio_preo:"";
			$estado_inicio_examen = $get_estado_inicio_examen + 365; 
			$get_estado_termino_examen = isset($examen_req->estado_fin_preo)?$examen_req->estado_fin_preo:"";
			$estado_termino_examen = $get_estado_termino_examen + 365;

			$psicol_req = $this->Examenes_psicologicos_model->get_ultimo_examen($r->usuario_id, $fecha_inicio_req, $fecha_termino_req);
			$estado_inicio_psicol = isset($psicol_req->estado_inicio_psicol)?$psicol_req->estado_inicio_psicol:NULL;
			$estado_termino_psicol = isset($psicol_req->estado_fin_psicol)?$psicol_req->estado_fin_psicol:"";

			if($estado_inicio_masso == NULL){
				$aux->color_masso = "";
				$aux->masso = "";
				$aux->estado_masso = "N/D";
			}else{
				if($estado_inicio_masso >= 0 and $estado_termino_masso <= 0){
					$color_masso = "#FFBF00";
					$dedo_masso = "fa fa-thumbs-up";
					$estado_masso = "VENCE DENTRO DEL REQ";
				}elseif($estado_inicio_masso <= 0){
					$color_masso = "red";
					$dedo_masso = "fa fa-thumbs-down";
					$estado_masso = "VENCIDA";
				}elseif($estado_termino_masso >= 0){
					$color_masso = "green";
					$dedo_masso = "fa fa-thumbs-up";
					$estado_masso = "VIGENTE";
				}else{
					$color_masso = "red";
					$dedo_masso = "fa fa-thumbs-down";
					$estado_masso = "VENCIDA";
				}

				$aux->color_masso = $color_masso;
				$aux->dedo_masso = $dedo_masso;
				$aux->estado_masso = $estado_masso;
			}

			if(!$estado_inicio_examen){
				$aux->color_examen = "";
				$aux->preocupacional = "";
				$aux->estado_preo = "N/D";
			}else{
				if($estado_inicio_examen >= 0 and $estado_termino_examen <= 0){
					$color_examen = "#FFBF00";
					$dedo_preo = "fa fa-thumbs-up";
					$estado_preo = "VENCE DENTRO DEL REQ";
				}elseif($estado_inicio_examen <= 0){
					$color_examen = "red";
					$dedo_preo = "fa fa-thumbs-down";
					$estado_preo = "VENCIDA";
				}elseif($estado_termino_examen >= 0){
					$color_examen = "green";
					$dedo_preo = "fa fa-thumbs-up";
					$estado_preo = "VIGENTE";
				}else{
					$color_examen = "red";
					$dedo_preo = "fa fa-thumbs-down";
					$estado_preo = "VENCIDA";
				}

				$aux->color_examen = $color_examen;
				$aux->dedo_preo = $dedo_preo;
				$aux->estado_preo = $estado_preo;
			}
			//Fin codigo ultimo

			if(!$estado_inicio_psicol){
				$aux->color_psicol = "";
				$aux->psicologico = "";
			}else{
				if($estado_inicio_psicol >= 0 and $estado_termino_psicol <= 0){
					$color_psicol = "#FFBF00";
					$dedo_psicol = "fa fa-thumbs-up";
				}elseif($estado_inicio_psicol <= 0){
					$color_psicol = "red";
					$dedo_psicol = "fa fa-thumbs-down";
				}elseif($estado_termino_psicol >= 0){
					$color_psicol = "green";
					$dedo_psicol = "fa fa-thumbs-up";
				}else{
					$color_psicol = "red";
					$dedo_psicol = "fa fa-thumbs-down";
				}

				$aux->color_psicol = $color_psicol;
				$aux->dedo_psicol = $dedo_psicol;
			}

			$aux->contrato = $ar_contrato;
			$aux->certificado = $ar_certificado;
			$aux->comentario = $r->comentario;
			$aux->jefe_area = $r->jefe_area;
			$aux->valor_masso = (isset($masso->valor_examen)?$masso->valor_examen:"0");
			$aux->valor_examen = (isset($preoc->valor_examen)?$preoc->valor_examen:"0");
			//$aux->valor_masso = $r->valor_masso;
			//$aux->valor_examen = $r->valor_examen;

			$contratos_usu = $this->Requerimiento_Usuario_Archivo_model->get_result_tipo_archivo_usuario($r->usuario_id, $id_asc_trabajador, 1);
			$anexos_usu = $this->Requerimiento_Usuario_Archivo_model->get_result_tipo_archivo_usuario($r->usuario_id, $id_asc_trabajador, 2);

			$cantidad_contratos_realizados = 0;
			$cantidad_contratos_realizados_generados = 0;
			if($contratos_usu != FALSE){
				foreach($contratos_usu as $row){
					$cantidad_contratos_realizados += 1;

					if($row->estado_generacion_contrato == 1)
						$cantidad_contratos_realizados_generados += 1;
				}
			}

			if($anexos_usu != FALSE){
				foreach($anexos_usu as $row2){
					$cantidad_contratos_realizados += 1;

					if($row2->estado_generacion_contrato == 1)
						$cantidad_contratos_realizados_generados += 1;
				}
			}

			$aux->cantidad_contratos_realizados = $cantidad_contratos_realizados;
			$aux->cantidad_contratos_realizados_generados = $cantidad_contratos_realizados_generados;

			$i++;
			array_push($listado,$aux);
		}

		$pagina['listado'] = $listado;
		$pagina['agregados'] = $i;
		$base['cuerpo'] = $this->load->view('requerimiento/usuarios_general_requerimiento',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}



function usuarios_requerimientos_listado2($id_area_cargo){
		$this->load->model('Requerimiento_area_cargo_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Listanegra_model');

		$area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		$id_req = isset($area_cargo->requerimiento_id)?$area_cargo->requerimiento_id:0;

		$base = array(
			'head_titulo' => "Lista de Trabajadores - Sistema EST",
			'titulo' => "Listado de Trabajadores",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/usuarios_requerimiento/'.$id_area_cargo."", 'txt'=>'Volver a la Area - Cargo del Requerimiento'), array('url'=>'','txt'=>"Listado Trabajadores requerimiento ".$this->Requerimientos_model->get($id_req)->nombre."" )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','js/lista_req.js', 'js/usuarios_requerimientos.js', 'js/agregarTrabajadorAreaCargo.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css'),
		);

		$req = $this->Requerimientos_model->get($id_req);
		$planta = $this->Empresa_planta_model->get($req->planta_id);
		$area = $this->Areas_model->r_get($area_cargo->areas_id);
		$cargo = $this->Cargos_model->r_get($area_cargo->cargos_id);
		$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		$aux_req = new stdClass();
		$aux_req->nombre = $req->nombre;
		$aux_req->planta = $planta->nombre;
		$aux_req->version = $req->version;
		$aux_req->area = $area->nombre;
		$aux_req->cargo = $cargo->nombre;
		$aux_req->cantidad = $r_area_cargo->cantidad;
		$aux_req->agregados = $this->Requerimiento_asc_trabajadores_model->contador($id_area_cargo);
		$lista = array();
		$pagina['datos_req'] = $aux_req;
		$pagina['lista_aux'] = $lista;
		$pagina['desabilitar'] = true;
		$pagina['id_area_cargo'] = $id_area_cargo;
		$base['cuerpo'] = $this->load->view('requerimiento/listado_usuarios_req',$pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function busqueda($hola = false){
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Usuarios_model');
		$listado_usuarios = $this->Usuarios_model->listar_trabajadores_orden_paterno_activos();

		if (isset($_POST['valorBusqueda'])) {
			$qe = $_POST['valorBusqueda'];
			$resultado = $this->Usuarios_model->getTrabajadorAjax($qe);
		}elseif (isset($_POST['valorBusquedaNombre'])) {
			$qe = $_POST['valorBusquedaNombre'];
			$resultado = $this->Usuarios_model->getTrabajadorAjaxNombre($qe);
		}elseif (isset($_POST['valorBusquedaApellido'])) {
			$qe = $_POST['valorBusquedaApellido'];
			$resultado = $this->Usuarios_model->getTrabajadorAjaxApellido($qe);
		}	
		$nombre = false;
		foreach ($resultado as $key) {
			$especialidad = $this->Especialidadtrabajador_model->get($key->id_especialidad_trabajador);
				$especialidad2 = $this->Especialidadtrabajador_model->get($key->id_especialidad_trabajador_2);
				$e1= isset($especialidad->desc_especialidad)?$especialidad->desc_especialidad:"";
				$e2 = isset($especialidad2->desc_especialidad)?$especialidad2->desc_especialidad:"";
			$nombre .='<tr class="odd gradeX" id="'.$key->id.'tr">
						<td > <span style="cursor: pointer" class="agregarAlRequerimiento hvr-sweep-to-right hvr-pulse" data="'.$key->id.'"data-nombre="'.titleCase($key->nombres)." ".titleCase($key->paterno).'" data-rut="'.$key->rut_usuario.'">'. $key->rut_usuario .' <i style="color:blue;" class="fa fa-plus-circle hvr-pulse" aria-hidden="true"></i> </span></td>
						<td>'. $key->nombres .'</td>
						<td>'. $key->paterno .'</td>
						<td>'.$key->materno.' </td>
						<td>'.$e1." ".$e2.'</td>
						<td><img src="'.base_url().'extras/images/circle_green_16_ns.png"></td>
					   </tr>';
		}
		echo($nombre);
	}

	function agregar_usuarios_requerimiento_ajax(){
		$id_area_cargo =  $_POST['idAreaCargo'];
		$idTrabajador =  $_POST['idTrabajador'];
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$lista_negra = $this->Requerimiento_asc_trabajadores_model->verificarListaNegra($idTrabajador);
		$existe = $this->Requerimiento_asc_trabajadores_model->verificarSiExiste($id_area_cargo, $idTrabajador);
		if ($lista_negra) {
			$resultado = 3;
		}elseif ($existe == false) {
			$data = array(
				"requerimiento_area_cargo_id" => $id_area_cargo,
				"usuario_id" => $idTrabajador,
				"fecha" => date('Y-m-d'),
			);
			$this->Requerimiento_asc_trabajadores_model->ingresar($data);
			$resultado = 1;
		}else{
			$resultado = 0;
		}
		echo $resultado;
	}



	function usuarios_requerimientos_listado($id_area_cargo){
	  //  var_dump($id_area_cargo);
		$this->load->model('Requerimiento_area_cargo_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Listanegra_model');

		$area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		$id_req = isset($area_cargo->requerimiento_id)?$area_cargo->requerimiento_id:0;

		$base = array(
			'head_titulo' => "Lista de Trabajadores - Sistema EST",
			'titulo' => "Listado de Trabajadores",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/requerimiento/usuarios_requerimiento/'.$id_area_cargo."", 'txt'=>'Volver a la Area - Cargo del Requerimiento'), array('url'=>'','txt'=>"Listado Trabajadores requerimiento ".$this->Requerimientos_model->get($id_req)->nombre."" )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','js/lista_req.js', 'js/usuarios_requerimientos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css'),
		);

		$req = $this->Requerimientos_model->get($id_req);
		$planta = $this->Empresa_planta_model->get($req->planta_id);
		$area = $this->Areas_model->r_get($area_cargo->areas_id);
		$cargo = $this->Cargos_model->r_get($area_cargo->cargos_id);
		$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
		$aux_req = new stdClass();
		$aux_req->nombre = $req->nombre;
		$aux_req->planta = $planta->nombre;
		$aux_req->version = $req->version;
		$aux_req->area = $area->nombre;
		$aux_req->cargo = $cargo->nombre;
		$aux_req->cantidad = $r_area_cargo->cantidad;
		$aux_req->agregados = $this->Requerimiento_asc_trabajadores_model->contador($id_area_cargo);

		$listado_usuarios = $this->Usuarios_model->listar_trabajadores_orden_paterno_activos();
		$lista = array();
		if($listado_usuarios != FALSE){
			foreach ($listado_usuarios as $l){
				$aux = new stdClass();
				$especialidad = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador);
				$especialidad2 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_2);


				//$get_usu_asc = $this->Requerimiento_asc_trabajadores_model->get_usuarios_area_cargo_req_activos_row($l->id);
				//$get_anotaciones = $this->Listanegra_model->contar_anotaciones_trabajador($l->id);

				$aux->id_usuario = $l->id;
				$aux->rut_usuario = $l->rut_usuario;
				$aux->nombre = $l->nombres;
				$aux->ap_paterno = $l->paterno;
				$aux->ap_materno = $l->materno;
				$aux->especialidad = isset($especialidad->desc_especialidad)?$especialidad->desc_especialidad:"";
				$aux->especialidad2 = isset($especialidad2->desc_especialidad)?$especialidad2->desc_especialidad:"";

				/*
				$nombre_requerimiento = isset($get_usu_asc->nombre_req)?$get_usu_asc->nombre_req:"";
				$fi_req = isset($get_usu_asc->f_inicio)?$get_usu_asc->f_inicio:"";
				$ft_req = isset($get_usu_asc->f_fin)?$get_usu_asc->f_fin:"";
				$nombre_area = isset($get_usu_asc->nombre_area)?$get_usu_asc->nombre_area:"";
				$nombre_cargo = isset($get_usu_asc->nombre_cargo)?$get_usu_asc->nombre_cargo:"";
				$aux->nombre_requerimiento = "Requerimiento: ".$nombre_requerimiento." - Area: ".$nombre_area." - Cargo: ".$nombre_cargo." - Fecha Inicio: ".$fi_req." - Fecha Termino: ".$ft_req;
				*/

			/*	if($nombre_area != "")
					$aux->estado_usu_req = 1;
				else*/
				$aux->estado_usu_req = 0;

				$aux->anotaciones = (isset($get_anotaciones->total)?$get_anotaciones->total:"0");
				array_push($lista,$aux);
				unset($aux);
			}
		}

		$pagina['datos_req'] = $aux_req;
		$pagina['lista_aux'] = $lista;
	//	var_dump($pagina['lista_aux']);
		$pagina['id_area_cargo'] = $id_area_cargo;
	//	var_dump($pagina['id_area_cargo']);
		$base['cuerpo'] = $this->load->view('requerimiento/listado_usuarios_req',$pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


	function agregar_usuarios_requerimiento(){
		$id_area_cargo =  $_POST['id_area_cargo'];
		$this->load->model("Requerimiento_asc_trabajadores_model");

		if (!empty($_POST['check_usuario'])?$_POST['check_usuario']:false){
			foreach($_POST['check_usuario'] as $c){
				$data = array(
					"requerimiento_area_cargo_id" => $id_area_cargo,
					"usuario_id" => $c,
					"fecha" => date('Y-m-d'),
				);
				$this->Requerimiento_asc_trabajadores_model->ingresar($data);
			}
		}
		$this->session->set_userdata('exito',3);
		//echo "<script>alert('Usuarios Agregados Exitosamente')</script>";
		redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_cargo, 'refresh');
	}

	function contratos_req_trabajador($id_usuario,$id_asc_area_req,$id_area_cargo_req = FALSE,$agregandoAnexo= FALSE){
		$this->load->model("requerimiento_usuario_archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresas_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Region_model");
		$this->load->model("Tipo_gratificacion_model");
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("Descripcion_horarios_model");

		$base = array(
			'head_titulo' => "Lista de Contratos - Sistema EST",
			'titulo' => "Listado de Contratos y Anexos",
			'subtitulo' => '',
			'side_bar' => true,
			'menu' => $this->menu,
			'js' => array('js/confirm.js','js/lista_req.js', 'js/usuarios_requerimientos.js','js/valida_fecha_contrato.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css'),
			'lugar' => array(
							array('url' => 'usuarios/home', 'txt' => 'Inicio'), 
							array('url'=>'est/requerimiento/asignacion/'.(isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0').'','txt' => 'Area-Cargo Requerimiento'), 
							array('url'=>'est/requerimiento/usuarios_requerimiento/'.$id_area_cargo_req,'txt'=>'Lista de usuarios' ), 
							array('url'=>'','txt'=>'Contrato de Trabajo')),
		);

		$usr = $this->Usuarios_model->get($id_usuario);
		$pagina['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$contratos_usu = $this->requerimiento_usuario_archivo_model->get_result_tipo_archivo_usuario($id_usuario, $id_asc_area_req, 1);
		//var_dump($contratos_usu);return false;
		$anexos_usu = $this->requerimiento_usuario_archivo_model->get_anexos($id_usuario, $id_asc_area_req);

		$datos_generales = array();
		if($usr != FALSE){
			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
			$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
			$get_ciudad = $this->Ciudad_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->Estadocivil_model->get($id_estado_civil);
			$get_nivel_estudios = $this->Nivelestudios_model->get($id_estudios);
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_asc_area_req);
			$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo_req);
			$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
			$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
			$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
			$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
			$get_area = $this->Areas_model->r_get($id_area);
			$get_cargo = $this->Cargos_model->r_get($id_cargo);
			$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
			$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
			$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
			$get_planta = $this->Empresa_planta_model->get($id_planta);
			$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
			$id_ciudad_planta = isset($get_planta->id_ciudades)?$get_planta->id_ciudades:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->Region_model->get($id_region_planta);
			$get_ciudad_planta = $this->Ciudad_model->get($id_ciudad_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_empresa = isset($get_centro_costo->id)?$get_centro_costo->id:'';//Id de Empresa para validar examenes
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';

			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
			$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
			$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$aux->domicilo = isset($usr->direccion)?$usr->direccion:'';
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			$aux->telefono = isset($usr->fono)?$usr->fono:'';
			$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';

			$revisiones_al_dia = 0;
			$solicitudes_aprobadas = $this->Solicitud_revision_examenes_model->get_usu_req_aprobados_result($id_usuario, $id_requerimiento, $id_asc_area_req);
			if (!empty($solicitudes_aprobadas)){
				foreach ($solicitudes_aprobadas as $d) {
					$revisiones_al_dia += 1;
				}
			}
			array_push($datos_generales, $aux);
			unset($aux);
		}
		
		$fechaComparar ='1999-01-01';
		$lista_aux = array();
		if($contratos_usu != FALSE){
			foreach($contratos_usu as $row){
				$aux = new StdClass();
				$get_jornada = $this->Descripcion_horarios_model->get($row->jornada);
				$aux->id_req_usu_arch = $row->id;
				$aux->usuario_id = $id_usuario;
				$aux->nombre = $row->nombre;
				$aux->url = $row->url;
				$aux->causal = $row->causal;
				$aux->motivo = $row->motivo;
				$aux->fecha_inicio = $row->fecha_inicio;
				$aux->fecha_termino = $row->fecha_termino;
				$aux->fecha_termino2 = $row->fecha_termino2;

				$aux->idAreaCargo = $this->requerimiento_usuario_archivo_model->get_area_cargo($row->requerimiento_asc_trabajadores_id)->requerimiento_area_cargo_id;
				#yayo editado el 16-10-2019  al estar en true se valida que los contratos a crear sean con fecha igual o superior a la actual
				//if (date('Y-m-d') > $aux->fecha_termino) {
				//	$pagina['noCrear']=true;
				//}else{
					$pagina['noCrear']=false;
				//} Fin edicion
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->descripcion_jornada = isset($get_jornada->descripcion)?$get_jornada->descripcion:'';
				$aux->renta_imponible = $row->renta_imponible;
				$aux->estado_generacion_contrato = $row->estado_generacion_contrato;
				if (empty($row->nombre) || $row->estado_aprobacion_revision==1) {
					$aux->estadoContrato= $row->estado_aprobacion_revision;
				}
				$aux->cargarArchivo= $row->estado_aprobacion_revision;
				if ($row->estado_aprobacion_revision==1) {
					$ultimaFecha = $row->fecha_termino;
					if ($fechaComparar < $ultimaFecha) {
						$idParaCartaTermino[0] = $row->id;
						$idParaCartaTermino[1] = $row->fecha_termino;
						$idParaCartaTermino[2] = 1;
						$fechaComparar = $ultimaFecha;
					}
				}else{
						$idParaCartaTermino[0] = null;
						$idParaCartaTermino[1] = null;
						$idParaCartaTermino[2] = null;
				}
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$lista_aux2 = array();
		if($anexos_usu != FALSE){
			foreach($anexos_usu as $row2){
				$aux = new StdClass();
				$aux->id_req_usu_arch = $row2->id;
				$aux->usuario_id = $id_usuario;
				$aux->causal = $row2->causal;
				$aux->fecha_inicio = $row2->fecha_termino_contrato_anterior;
				$aux->fecha_termino = $row2->fecha_termino_nuevo_anexo;
				$aux->fecha_termino2 = $row2->fecha_termino2;
				$aux->nombre = $row2->nombre;
				$aux->url = $row2->url;
				#yayo editado el 16-10-2019  al estar en true se valida que los contratos a crear sean con fecha igual o superior a la actual
				//if (date('Y-m-d') > $aux->fecha_termino) {
				//	$pagina['noCrear']=true;
				//}else{
					$pagina['noCrear']=false;
				//}
				$aux->estado = $row2->estado;
				$aux->estado_generacion_contrato = $row2->estado_generacion_contrato;
				if ($aux->estado==2) {
					$ultimaFecha=$row2->fecha_termino_nuevo_anexo;
					if ($fechaComparar < $ultimaFecha) {
						$idParaCartaTermino[0] = $row2->id;
						$idParaCartaTermino[1] = $row2->fecha_termino_nuevo_anexo;
						$idParaCartaTermino[2] = 2;		
						$fechaComparar = $ultimaFecha;
					}
				}/*else{
					$idParaCartaTermino[0] = null;
					$idParaCartaTermino[1] = null;
					$idParaCartaTermino[2] = null;		
				}*/
				array_push($lista_aux2, $aux);
				unset($aux);
			}
		}
		$idParaCartaTermino = isset($idParaCartaTermino)?$idParaCartaTermino:'';
//18138050*/
		if ($agregandoAnexo) {
			$this->session->set_userdata('abrirModalAnexo',true);
		}
		/*if ($anexos_usu) {
			$pagina['limitAnexo']=true;
		}else{
			$pagina['limitAnexo']=false;	
		}*/
		$pagina['soloParaMarina']=true;
		$pagina['cartaTermino'] = $idParaCartaTermino;
		$pagina['soloParaMarina'] = true;
		$pagina['revisiones_al_dia'] = $revisiones_al_dia;
		$pagina['datos_generales'] = $datos_generales;
		$pagina['contratos'] = $lista_aux;
		$pagina['anexos'] = $lista_aux2;
		$pagina['id_usuario'] = $id_usuario;
		$pagina['id_asc_area_req'] = $id_asc_area_req;
		$pagina['id_area_cargo_req'] = $id_area_cargo_req;
		$base['cuerpo'] = $this->load->view('requerimiento/documentos_contractuales_contratos_req',$pagina, TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_agregar_contrato_anexo($usuario,$tipo,$asc_area, $id_req_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresas_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Region_model");
		$this->load->model("Tipo_gratificacion_model");
		$this->load->model("Descripcion_horarios_model");

		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		
		$get_datos_req = $this->Requerimiento_area_cargo_model->r_get_requerimiento($id_req_area_cargo);
		$pagina['motivo_defecto'] = (isset($get_datos_req->motivo)?$get_datos_req->motivo:'0');
		$pagina['causal_defecto'] = (isset($get_datos_req->causal)?$get_datos_req->causal:'0');

		$existe_anexo = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 2);
		$existe_contrato = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 1);

		if($existe_anexo == 1){
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, 2);
		}elseif($existe_contrato == 1){
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, 1);
		}else{
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, $tipo);
		}

		$datos_generales = array();
		if($usuario != FALSE){
			$usr = $this->Usuarios_model->get($usuario);
			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
			$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
			$get_ciudad = $this->Ciudad_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->Estadocivil_model->get($id_estado_civil);
			$get_nivel_estudios = $this->Nivelestudios_model->get($id_estudios);
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($asc_area);
			$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
			$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
			$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
			$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
			$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
			$get_area = $this->Areas_model->r_get($id_area);
			$get_cargo = $this->Cargos_model->r_get($id_cargo);
			$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
			$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
			$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
			$get_planta = $this->Empresa_planta_model->get($id_planta);
			$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->Region_model->get($id_region_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_empresa = isset($get_centro_costo->id)?$get_centro_costo->id:'';
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';

			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
			$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
			$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$aux->domicilo = isset($usr->direccion)?$usr->direccion:'';
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			$aux->telefono = isset($usr->fono)?$usr->fono:'';
			$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
			array_push($datos_generales, $aux);
			unset($aux);
		}

		$jornada = isset($datos_req->jornada)?$datos_req->jornada:'';
		$get_jornada = $this->Descripcion_horarios_model->get($jornada);
		$tipo_jornada = isset($get_jornada->id_tipo_horario)?$get_jornada->id_tipo_horario:'';
		$id_empresa_planta = isset($get_datos_req->planta_id)?$get_datos_req->planta_id:'';
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_empresa_planta);
		$pagina['datos_generales'] = $datos_generales;
		$pagina['datos_req'] = $datos_req;
		$pagina['tipo_jornada'] = $tipo_jornada;
		$this->load->view('est/requerimiento/modal_agregar_contrato_anexo_doc_contractuales', $pagina);
	}

/*
SELECT t1.*
FROM r_requerimiento_usuario_archivo t1
WHERE t1.fecha_termino = (SELECT MAX(t2.fecha_termino)
                 FROM  r_requerimiento_usuario_archivo t2
                 WHERE t2.usuario_id = t1.usuario_id AND usuario_id=8611)
*/
	#yayo 23-09-2019 funcion para controlar la fecha de inicio de los contratos
	function revisar_fecha($idPersona){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$fecha = $_POST['fechaInicio'];
		$contrato = $this->Requerimiento_Usuario_Archivo_model->buscarContrato($idPersona, $fecha);
		$anexo = $this->Requerimiento_Usuario_Archivo_model->buscarAnexo($idPersona, $fecha);
		$resultado=1;
		if ($anexo!= FALSE) {
			if (strtotime($anexo->fecha_termino2) >= strtotime($fecha) ) {
				$resultado = $anexo;
			}				
		}
		if ($contrato!= FALSE){
			$reqAreaCargo = $this->Requerimiento_Usuario_Archivo_model->get_area_cargo($contrato->requerimiento_asc_trabajadores_id);
			$contrato->id_requerimiento_area_cargo = $reqAreaCargo->requerimiento_area_cargo_id;
			if (strtotime($contrato->fecha_termino2) >= strtotime($fecha)) {
				$resultado = $contrato;
			}

		}
		if ($anexo!= FALSE && $contrato!= FALSE) {
			if (strtotime($contrato->fecha_termino2) >= strtotime($anexo->fecha_termino2)) {
				if (strtotime($contrato->fecha_termino2) >= strtotime($fecha)) {
					$resultado = $contrato;
				}
			}else{
				if (strtotime($anexo->fecha_termino2) >= strtotime($fecha) ) {
					$resultado = $anexo;
				}
			}
		}
		echo json_encode($resultado);
	}
	
	#yayo 25-09-2019
	function guardar_fecha_finiquito(){
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$mensaje='';
		if (empty($_POST['fecha_termino2']) || empty($_POST['comentario'])) {
			$mensaje = 0;
		}else{
			if ($_POST['tipo_archivo'] == 1) { //Si es Contrato
				$id = $_POST['id_archivo'];
				$data = array(
					'fecha_termino2'=> $_POST['fecha_termino2'],
				);
				$data2 = array(
					'id_usuario'=>$this->session->userdata('id'),
					'id_archivo'=>$id,
					'tipo_archivo'=>$_POST['tipo_archivo'],
					'comentario'=>$_POST['comentario'],
				);
				$contrato = $this->Requerimiento_Usuario_Archivo_model->finiquitarContrato($id, $data);
				$guardarAuditoria = $this->Requerimiento_Usuario_Archivo_model->guardarAuditoria($data2);
				$mensaje = 1;
				$get_solicitante = $this->Usuarios_general_model->get($this->session->userdata('id'));
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
				$nombreTrabajador = $this->Requerimiento_Usuario_Archivo_model->getNameTrabajador($_POST['id_trabajador']);
				$nombre_trabajador = isset($nombreTrabajador->nombres)?$nombreTrabajador->nombres:'';
				$paterno_trabajador = isset($nombreTrabajador->paterno)?$nombreTrabajador->paterno:'';
				$materno_trabajador = isset($nombreTrabajador->materno)?$nombreTrabajador->materno:'';
				$rut_trabajador= $nombreTrabajador->rut_usuario;
				$nombre_completo_trabajador = $nombre_trabajador.' '.$paterno_trabajador.' '.$materno_trabajador;
				$comentario = $_POST['comentario'];
				$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
			    $this->email->from('informaciones@empresasintegra.cl', 'Finiquito - ARAUCO');
			    $this->email->to('contratos@empresasintegra.cl');
			    $this->email->cc('jcruces@empresasintegra.cl');
			    $this->email->subject("Finiquito  informado ".$nombre_completo_trabajador." ");
			    $this->email->message('Estimados,<br> El administrador '.$nombre_completo_solicitante.' declara finiquitar a: <br> <b>trabajador:</b> '.$nombre_completo_trabajador.'<br><b>Rut:</b> '.$rut_trabajador.'<br><b>Fecha Finiquito:</b> '.$_POST['fecha_termino2'].'<br> <b>Comentario:</b> '.$comentario.'');
			    $this->email->send();
			}else if($_POST['tipo_archivo'] ==2){// Si es Anexo
				$id = $_POST['id_archivo'];
				$data = array(
					'fecha_termino2'=> $_POST['fecha_termino2'],
				);
				$data2 = array(
					'id_usuario'=>$this->session->userdata('id'),
					'id_archivo'=>$id,
					'tipo_archivo'=>$_POST['tipo_archivo'],
					'comentario'=>$_POST['comentario'],
				);
				$contrato = $this->Requerimiento_Usuario_Archivo_model->finiquitarAnexo($id, $data);
				$guardarAuditoria = $this->Requerimiento_Usuario_Archivo_model->guardarAuditoria($data2);
				$mensaje = 2;
				$get_solicitante = $this->Usuarios_general_model->get($this->session->userdata('id'));
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
				$nombreTrabajador = $this->Requerimiento_Usuario_Archivo_model->getNameTrabajador($_POST['id_trabajador']);
				$nombre_trabajador = isset($nombreTrabajador->nombres)?$nombreTrabajador->nombres:'';
				$paterno_trabajador = isset($nombreTrabajador->paterno)?$nombreTrabajador->paterno:'';
				$materno_trabajador = isset($nombreTrabajador->materno)?$nombreTrabajador->materno:'';
				$rut_trabajador= $nombreTrabajador->rut_usuario;
				$nombre_completo_trabajador = $nombre_trabajador.' '.$paterno_trabajador.' '.$materno_trabajador;
				$comentario = $_POST['comentario'];
				$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
			    $this->email->from('informaciones@empresasintegra.cl', 'Finiquito - ARAUCO');
			    $this->email->to('contratos@empresasintegra.cl');
			    $this->email->cc('jcruces@empresasintegra.cl');
			    $this->email->subject("Finiquito  informado ".$nombre_completo_trabajador." ");
			    $this->email->message('Estimados,<br> El administrador '.$nombre_completo_solicitante.' declara finiquitar a: <br> <b>trabajador:</b> '.$nombre_completo_trabajador.'<br><b>Rut:</b> '.$rut_trabajador.'<br><b>Fecha Finiquito:</b> '.$_POST['fecha_termino2'].'<br> <b>Comentario:</b> '.$comentario.'');
			    $this->email->send();
			}
		}
		echo json_encode($mensaje);
	}


	function guardar_nuevo_contrato_anexo_doc_contractual($usuario,$tipo,$asc_area){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Usuarios_model");
		$id_area_cargo = $this->Requerimiento_asc_trabajadores_model->get($asc_area)->requerimiento_area_cargo_id;

		if (empty($_POST['datos_extras']))
			$vienen_datos = "NO";
		else
			$vienen_datos = "SI";

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']) )
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		if($vienen_datos == "SI"){
			## 10-06-2019 Guardando Informacion personal del usuario relacionada con el contrato
			$usr = $this->Usuarios_model->get($usuario);
			$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
			$id_estudios = isset($usr->id_nivel_estudios)?$usr->id_nivel_estudios:'';
			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$domicilio = isset($usr->direccion)?$usr->direccion:'';
			$telefono = isset($usr->fono)?$usr->fono:'';
			$nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo,
				'causal' => $_POST['causal'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha_inicio,
				'fecha_termino' => $fecha_termino,
				'fecha_termino2' => $fecha_termino,
				'jornada' => $_POST['jornada'],
				'renta_imponible' => $_POST['renta_imponible'],
				'bono_responsabilidad' => $_POST['bono_responsabilidad'],
				'bono_gestion' => $_POST['bono_gestion'],
				'bono_confianza' => $_POST['bono_confianza'],
				'asignacion_movilizacion' => $_POST['asignacion_movilizacion'],
				'asignacion_colacion' => $_POST['asignacion_colacion'],
				'asignacion_zona' => $_POST['asignacion_zona'],
				'asignacion_herramientas' => $_POST['asignacion_herramientas'],
				'viatico' => $_POST['viatico'],
				'seguro_vida_arauco' => 'SI',
				'id_ciudad' => $id_ciudad,
				'id_afp' => $id_afp,
				'id_salud' => $id_salud,
				'id_estado_civil' => $id_estado_civil,
				'id_nivel_estudios' => $id_estudios,
				'nombres' => $nombres,
				'paterno' => $paterno,
				'materno' => $materno,
				'rut_usuario' => $rut,
				'fecha_nac' => $fecha_nac,
				'direccion' => $domicilio, 
				//'fono' => $telefono,
				'nacionalidad' => $nacionalidad,
			);
		}else{
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo
			);
		}
		$this->Requerimiento_Usuario_Archivo_model->ingresar($data);
		redirect('est/requerimiento/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
	}

	function modal_administrar_contrato_anexo_doc_general($id_usu_arch,$id_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresas_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Region_model");
		$this->load->model("Tipo_gratificacion_model");
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("Descripcion_horarios_model");
		$this->load->model("Sre_evaluacion_req_model");

		$revisiones_al_dia = 0;
		$evaluaciones_rechazados = 0;
		$datos_generales = array();
		if($id_usu_arch != FALSE){
			$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
			$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
			$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
			$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
			$usr = $this->Usuarios_model->get($id_usuario);

			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
			$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
			$get_ciudad = $this->Ciudad_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->Estadocivil_model->get($id_estado_civil);
			$get_nivel_estudios = $this->Nivelestudios_model->get($id_estudios);
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);

			$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
			$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
			$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
			$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
			$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
			$get_area = $this->Areas_model->r_get($id_area);
			$get_cargo = $this->Cargos_model->r_get($id_cargo);
			$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
			$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
			$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
			$get_planta = $this->Empresa_planta_model->get($id_planta);
			$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
			$id_ciudad_planta = isset($get_planta->id_ciudades)?$get_planta->id_ciudades:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->Region_model->get($id_region_planta);
			$get_ciudad_planta = $this->Ciudad_model->get($id_ciudad_planta);

			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->descripcion_tipo_gratificacion = isset($get_gratif->descripcion)?$get_gratif->descripcion:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_empresa = isset($get_centro_costo->id)?$get_centro_costo->id:'';
			$aux->id_centro_costo = isset($get_centro_costo->id)?$get_centro_costo->id:'';
			$aux->id_planta = $id_planta;
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';

			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
			$aux->nombre_sin_espacios = $paterno.'_'.$materno;
			$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
			$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			$aux->telefono = isset($usr->fono)?$usr->fono:'';
			$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
			$solicitudes_aprobadas = $this->Solicitud_revision_examenes_model->get_usu_req_aprobados_result($id_usuario, $id_requerimiento, $id_req_asc_trabajador);
			if (!empty($solicitudes_aprobadas)){
				foreach ($solicitudes_aprobadas as $d){
					$id_solicitud_revision = $d->id;
					$detalle_solicitud = $this->Sre_evaluacion_req_model->get_id_solicitud($id_solicitud_revision);
					foreach ($detalle_solicitud as $ds){
						if($ds->estado == 2)
							$evaluaciones_rechazados += 1;
					}
					$revisiones_al_dia += 1;
				}
			}
			array_push($datos_generales, $aux);
			unset($aux);
		}

		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
		$get_solicitudes_contratos = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);
		$solicitud_existente_contrato = isset($get_solicitudes_contratos->id)?$get_solicitudes_contratos->estado:"N/E";
		$estado_aprobacion_revision = isset($get_usu_archivo->estado_aprobacion_revision)?$get_usu_archivo->estado_aprobacion_revision:0;

		if($solicitud_existente_contrato == '0' or $solicitud_existente_contrato == '1'  or $estado_aprobacion_revision == '1')
			$estado_bloqueo = "si";
		else
			$estado_bloqueo = "no";

		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_planta);
		$pagina['estado_bloqueo'] = $estado_bloqueo;
		$pagina['solicitud_existente_contrato'] = $solicitud_existente_contrato;
		$pagina['comentarios_existente_contrato'] = isset($get_solicitudes_contratos->observaciones)?$get_solicitudes_contratos->observaciones:'';
		$pagina['datos_generales'] = $datos_generales;
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['revisiones_al_dia']= $revisiones_al_dia;
		$pagina['evaluaciones_rechazados']= $evaluaciones_rechazados;
		$pagina['id_area_cargo']= $id_area_cargo;
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$this->load->view('est/requerimiento/modal_administrar_contrato_anexo_doc_contractuales', $pagina);
	}

	function actualizar_contrato_anexo_doc_contractual($id_usu_arch,$id_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
	//	$this->load->model("Estado_civil_model");
		$this->load->model("Descripcion_causal_model");
		$this->load->model("Descripcion_horarios_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->library('zip');
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model("Usuarios_model");
		$this->load->helper('download');

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']) )
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];
		$idDelUsr = $this->Requerimiento_Usuario_Archivo_model->getIdUsuarioContrato($id_usu_arch);

		$causal = $_POST['causal'];
		$motivo = $_POST['motivo'];
		$jornada = $_POST['jornada'];
		$renta_imponible = $_POST['renta_imponible'];
		$bono_responsabilidad = $_POST['bono_responsabilidad'];
		$bono_gestion = $_POST['bono_gestion'];
		$bono_confianza = $_POST['bono_confianza'];
		$asignacion_movilizacion = $_POST['asignacion_movilizacion'];
		$asignacion_colacion = $_POST['asignacion_colacion'];
		$asignacion_zona = $_POST['asignacion_zona'];
		$asignacion_herramientas = $_POST['asignacion_herramientas'];
		$viatico = $_POST['viatico'];
		$seguro_vida_arauco = 'SI';

		/*
		$nombre_trabajador = $_POST['nombre'];
		$rut_trabajador = $_POST['rut_usuario'];
		$estado_civil = $_POST['estado_civil'];
		$fecha_nac = $_POST['fecha_nac'];
		$domicilio_trabajador = $_POST['domicilio'];
		$comuna_trabajador = $_POST['ciudad'];
		$prevision_trabajador = $_POST['prevision'];
		$salud_trabajador = $_POST['salud'];
		$nivel_estudios = $_POST['nivel_estudios'];
		$telefono = $_POST['telefono'];
		$nacionalidad = $_POST['nacionalidad'];*/
		if (!empty($idDelUsr->nombres)) {	
			$nombre_trabajador = $idDelUsr->nombres." ".$idDelUsr->paterno." ".$idDelUsr->materno;
		}else{
			$nombre_trabajador = $_POST['nombre'];
		}

		if (!empty($idDelUsr->rut_usuario)) {
			$rut_trabajador = $idDelUsr->rut_usuario;
		}else{
			$rut_trabajador = $_POST['rut_usuario'];
		}

		if (!empty($idDelUsr->id_estado_civil)) {
			//$get_estado_civil = $this->Estado_civil_model->get($idDelUsr->id_estado_civil);
			$estado_civil = $get_estado_civil->desc_estadocivil;
		}else{
			$estado_civil = $_POST['estado_civil'];
		}
		
		if (!empty($idDelUsr->fecha_nac	)) {
			$fecha_nac = $idDelUsr->fecha_nac;
		}else{
			$fecha_nac = $_POST['fecha_nac'];
		}

		if (!empty($idDelUsr->direccion	)) {
			$domicilio_trabajador = $idDelUsr->direccion;
		}else{
			$domicilio_trabajador = $_POST['domicilio'];
		}

		if (!empty($idDelUsr->id_ciudad	)) {
			$comuna_trabajador = $idDelUsr->id_ciudad;
		}else{
			$comuna_trabajador = $_POST['ciudad'];
		}

		if (!empty($idDelUsr->id_afp)) {
			$get_afp = $this->Afp_model->get($idDelUsr->id_afp);
			$prevision_trabajador = $get_afp->desc_afp;
		}else{	
			$prevision_trabajador = $_POST['prevision'];
		}

		if (!empty($idDelUsr->id_salud)){
			$get_salud = $this->Salud_model->get($idDelUsr->id_salud);
			$salud_trabajador = $get_salud->desc_salud;
		}else{
			$salud_trabajador = $_POST['salud'];
		}

		if (!empty($idDelUsr->id_estudios)){
			$get_nivel_estudios = $this->Nivel_estudios_model->get($idDelUsr->id_estudios);
			$nivel_estudios = $get_nivel_estudios->desc_nivelestudios;
		}else{
			$nivel_estudios = $_POST['nivel_estudios'];
		}

		if (!empty($idDelUsr->fono)) {
			$telefono = $idDelUsr->fono;
		}else{
			$telefono = $_POST['telefono'];
		}

		if (!empty($idDelUsr->nacionalidad)) {
			$nacionalidad = $idDelUsr->nacionalidad;
		}else{
			$nacionalidad = $_POST['nacionalidad'];
		}	

		$referido = $_POST['referido'];
		$cargo = $_POST['cargo'];
		$area = $_POST['area'];
		$nombre_centro_costo = $_POST['nombre_centro_costo'];
		$rut_centro_costo = $_POST['rut_centro_costo'];
		$id_planta = $_POST['id_planta'];
		$nombre_planta = $_POST['nombre_planta'];
		$direccion_planta = $_POST['direccion_planta'];
		$comuna_planta = $_POST['ciudad_planta'];
		$region_planta = $_POST['region_planta'];
		$gratificacion = $_POST['descripcion_tipo_gratificacion'];
		$nombre_sin_espacios = $_POST['nombre_sin_espacios'];
		$id_centro_costo = $_POST['id_centro_costo'];
		## 10-06-2019 se incorpora en la misma tabla mas campos con los datos del usuario en el momento en que se solicita
				$idDelUsr = $this->Requerimiento_Usuario_Archivo_model->getIdUsuarioContrato($id_usu_arch);
				$id_usuario = $idDelUsr->usuario_id;
				$usr = $this->Usuarios_model->get($id_usuario);
				$id_ciudad = isset($usr->id_ciudad)?$usr->id_ciudad:'';
				$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
				$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
				$id_estado_civil = isset($usr->id_estado_civil)?$usr->id_estado_civil:'';
				$id_estudios = isset($usr->id_nivel_estudios)?$usr->id_nivel_estudios:'';
				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
				$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$domicilio = isset($usr->direccion)?$usr->direccion:'';
				$telefono = isset($usr->fono)?$usr->fono:'';
				$nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
		$data = array(
			'causal' => $causal,
			'motivo' => $motivo,
			'fecha_inicio' => $fecha_inicio,
			'fecha_termino' => $fecha_termino,
			'fecha_termino2' => $fecha_termino,
			'jornada' => $jornada,
			'renta_imponible' => $renta_imponible,
			'bono_responsabilidad' => $bono_responsabilidad,
			'bono_gestion' => $bono_gestion,
			'bono_confianza' => $bono_confianza,
			'asignacion_movilizacion' => $asignacion_movilizacion,
			'asignacion_colacion' => $asignacion_colacion,
			'asignacion_zona' => $asignacion_zona,
			'asignacion_herramientas' => $asignacion_herramientas,
			'viatico' => $viatico,
			'seguro_vida_arauco' => 'SI',
				'id_ciudad' => $id_ciudad,
				'id_afp' => $id_afp,
				'id_salud' => $id_salud,
				'id_estado_civil' => $id_estado_civil,
				'id_nivel_estudios' => $id_estudios,
				'nombre' => $nombres,
				'paterno' => $paterno,
				'materno' => $materno,
				'rut_usuario' => $rut,
				'fecha_nac' => $fecha_nac,
				'direccion' => $domicilio,
				'fono' => $telefono,
				'nacionalidad' => $nacionalidad,
		);

		$datos_generacion_contrato = array(
			'estado_generacion_contrato' => 1,
			'gc_usuario_id' => $this->session->userdata('id'),
			'gc_fecha' => date('Y-m-d H:i:s'),
		);

		if(isset($_POST['actualizar'])){
			//inicio de boton actualizar
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_usu_arch, $data);
			echo '<script>alert("Contrato actualizado exitosamente");</script>';
			//fin de boton actualizar
		}elseif(isset($_POST['envio_solicitud_contrato'])){
			//inicio de boton envio aprobacion de contrato
			$datos_aprobacion = array(
				'id_req_usu_arch' => $id_usu_arch,
				'id_solicitante' => $this->session->userdata('id'),
				'fecha_solicitud' => date('Y-m-d'),
				'estado' => 0,
			);

			$datos_aprobacion_historial = array(
				'id_req_usu_arch' => $id_usu_arch,
				'id_usuario' => $this->session->userdata('id'),
				//'fecha_solicitud' => date('Y-m-d H:m:s'),
				'estado' => 0,
			);
			$data = array(
				'fecha_solicitud' =>date('Y-m-d H:i:s'),
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_usu_arch, $data);


			$get_existe = $this->Requerimiento_Usuario_Archivo_model->get_solicitud_contrato($id_usu_arch);
			$existe = isset($get_existe->id)?1:0;

			if($existe == 1)
				$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_usu_arch, $datos_aprobacion);
			else
				$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato($datos_aprobacion);
			
			$this->Requerimiento_Usuario_Archivo_model->ingresar_solicitud_contrato_historial($datos_aprobacion_historial);

			$id_solicitante = $this->session->userdata('id');
			$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
			$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;

			$this->load->library('email');
			$config['smtp_host'] = 'mail.empresasintegra.cl';
			$config['smtp_user'] = 'informaciones@empresasintegra.cl';
			$config['smtp_pass'] = '%SYkNLH1';
			$config['mailtype'] = 'html';
			$config['smtp_port']    = '2552';
			$this->email->initialize($config);
		    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - ARAUCO');
		    $this->email->to('contratos@empresasintegra.cl');
		    $this->email->cc('jcruces@empresasintegra.cl');
		    $this->email->subject("Solicitud Contrato Trabajador: ".$nombre_trabajador." - Fecha Inicio Contrato: ".$fecha_inicio);
		    $this->email->message('Estimados el administrador '.$nombre_completo_solicitante.' ha realizado una solicitud de contrato del trabajador: '.$nombre_trabajador.' con el siguiente Rut: '.$rut_trabajador.'.<br>Saludos');
		    $this->email->send();
		    #para las notificaciones14-05-2019
			/*$data2 = array(
				'id_usu_archivo'=>$id,
				'id_quien_solicita'=>$this->session->userdata('id'),
				'nombreSolicitante'=>$nombre_completo_solicitante,
				'nombreTrabajador'=>$nombre_trabajador,
				'tipoSolicitud'=> 2, //1.-Contrato 2.- Anexo
				'estado'=>0,
				);
			$this->Requerimiento_Usuario_Archivo_model->insertarNotificacion($data2);*/

			echo '<script>alert("Solicitud de aprobacion de contrato ha sido enviada exitosamente");</script>';
			//inicio de boton envio aprobacion de contrato
		}elseif(isset($_POST['generar_contrato'])){
			//inicio de boton generar contrato
			if(empty($_POST['gc_ano_fi']) || empty($_POST['gc_mes_fi']) || empty($_POST['gc_dia_fi']) )
				$fecha_inicio = '0000-00-00';
			else
				$fecha_inicio = $_POST['gc_ano_fi'].'-'.$_POST['gc_mes_fi'].'-'.$_POST['gc_dia_fi'];

			if(empty($_POST['gc_ano_ft']) || empty($_POST['gc_mes_ft']) || empty($_POST['gc_dia_ft']) )
				$fecha_termino = '0000-00-00';
			else
				$fecha_termino = $_POST['gc_ano_ft'].'-'.$_POST['gc_mes_ft'].'-'.$_POST['gc_dia_ft'];

			$causal = $_POST['gc_causal'];
			$motivo = $_POST['gc_motivo'];
			$fecha_inicio = $fecha_inicio;
			$fecha_termino = $fecha_termino;
			$jornada = $_POST['gc_jornada'];
			$renta_imponible = $_POST['gc_renta_imponible'];
			$bono_responsabilidad = $_POST['gc_bono_responsabilidad'];
			$bono_gestion = $_POST['gc_bono_gestion'];
			$bono_confianza = $_POST['gc_bono_confianza'];
			$asignacion_movilizacion = $_POST['gc_asignacion_movilizacion'];
			$asignacion_colacion = $_POST['gc_asignacion_colacion'];
			$asignacion_zona = $_POST['gc_asignacion_zona'];
			$asignacion_herramientas = $_POST['gc_asignacion_herramientas'];
			$viatico = $_POST['gc_viatico'];

			if($jornada == "1"){
				if ($id_centro_costo==2 || $id_centro_costo == 4 || $id_centro_costo==5 || $id_centro_costo == 13 ) {//2-
					$template_formato = base_url()."extras/contratos/formatos_contratos_est/2_contrato_sin_pacto_heNuevo.docx";
					#yayo add 10-01-2020
					$parrafoQuinto=', con excepcion del primer mes de contrato oportunidad en que se le pagara el día 5 del mes siguiente.';
				}elseif($id_centro_costo==13){
					$template_formato = base_url()."extras/contratos/formatos_contratos_andritz/contrato_andritz.docx";
					$parrafoQuinto='.';
				}else{
					$template_formato = base_url()."extras/contratos/formatos_contratos_est/2_contrato_sin_pacto_he.docx";
					$parrafoQuinto='.';
				}
			}else{
				if ($id_centro_costo==2 || $id_centro_costo == 4 || $id_centro_costo==5) {
					$template_formato = base_url()."extras/contratos/formatos_contratos_est/1_contrato_con_pacto_heNuevo.docx";
					$parrafoQuinto=', con excepcion del primer mes de contrato oportunidad en que se le pagara el día 5 del mes siguiente.';
				}elseif($id_centro_costo==13){
					$template_formato = base_url()."extras/contratos/formatos_contratos_andritz/contrato_andritz_pacto_horas.docx";
					$parrafoQuinto='.';
				}else{
					$template_formato = base_url()."extras/contratos/formatos_contratos_est/1_contrato_con_pacto_he.docx";
					$parrafoQuinto='.';
				}
			}

			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";

			$var1 = explode('.',$rut_trabajador); 
			$rut1 = $var1[0];

			if($rut1 < 10)
				$rut_trabajador = "0".$rut_trabajador;

			$get_fecha_inicio=date($fecha_inicio); 
			$var1 = explode('-',$get_fecha_inicio); 
			$get_dia_fi = $var1[2];
			$mes_fi = $var1[1];
			$ano_fi = $var1[0];

			if($get_dia_fi < '10')
				$dia_fi = $var1[2];
			else
				$dia_fi = $var1[2];

			if ($mes_fi=="01") $mes_letra_fi="Enero";
			if ($mes_fi=="02") $mes_letra_fi="Febrero";
			if ($mes_fi=="03") $mes_letra_fi="Marzo";
			if ($mes_fi=="04") $mes_letra_fi="Abril";
			if ($mes_fi=="05") $mes_letra_fi="Mayo";
			if ($mes_fi=="06") $mes_letra_fi="Junio";
			if ($mes_fi=="07") $mes_letra_fi="Julio";
			if ($mes_fi=="08") $mes_letra_fi="Agosto";
			if ($mes_fi=="09") $mes_letra_fi="Septiembre";
			if ($mes_fi=="10") $mes_letra_fi="Octubre";
			if ($mes_fi=="11") $mes_letra_fi="Noviembre";
			if ($mes_fi=="12") $mes_letra_fi="Diciembre";

			$get_fecha_termino=date($fecha_termino); 
			$var2 = explode('-',$get_fecha_termino); 
			$get_dia_ft = $var2[2];
			$mes_ft = $var2[1];
			$ano_ft = $var2[0];
			
			if($get_dia_ft < 10)
				$dia_ft = $var2[2];
			else
				$dia_ft = $var2[2];

			if ($mes_ft=="01") $mes_letra_ft="Enero";
			if ($mes_ft=="02") $mes_letra_ft="Febrero";
			if ($mes_ft=="03") $mes_letra_ft="Marzo";
			if ($mes_ft=="04") $mes_letra_ft="Abril";
			if ($mes_ft=="05") $mes_letra_ft="Mayo";
			if ($mes_ft=="06") $mes_letra_ft="Junio";
			if ($mes_ft=="07") $mes_letra_ft="Julio";
			if ($mes_ft=="08") $mes_letra_ft="Agosto";
			if ($mes_ft=="09") $mes_letra_ft="Septiembre";
			if ($mes_ft=="10") $mes_letra_ft="Octubre";
			if ($mes_ft=="11") $mes_letra_ft="Noviembre";
			if ($mes_ft=="12") $mes_letra_ft="Diciembre";

			$get_fecha_nacimiento=date($fecha_nac); 
			$var3 = explode('-',$get_fecha_nacimiento); 
			$dia_fecha_nac = $var3[2];
			$mes_fecha_nac = $var3[1];
			$ano_fecha_nac = $var3[0];
			if ($mes_fecha_nac=="01") $mes_letra_fecha_nac="Enero";
			if ($mes_fecha_nac=="02") $mes_letra_fecha_nac="Febrero";
			if ($mes_fecha_nac=="03") $mes_letra_fecha_nac="Marzo";
			if ($mes_fecha_nac=="04") $mes_letra_fecha_nac="Abril";
			if ($mes_fecha_nac=="05") $mes_letra_fecha_nac="Mayo";
			if ($mes_fecha_nac=="06") $mes_letra_fecha_nac="Junio";
			if ($mes_fecha_nac=="07") $mes_letra_fecha_nac="Julio";
			if ($mes_fecha_nac=="08") $mes_letra_fecha_nac="Agosto";
			if ($mes_fecha_nac=="09") $mes_letra_fecha_nac="Septiembre";
			if ($mes_fecha_nac=="10") $mes_letra_fecha_nac="Octubre";
			if ($mes_fecha_nac=="11") $mes_letra_fecha_nac="Noviembre";
			if ($mes_fecha_nac=="12") $mes_letra_fecha_nac="Diciembre";

			$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
			$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
			$fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

			if($causal == "A")
				$id_descrip_causal = 1;
			elseif($causal == "B")
				$id_descrip_causal = 2;
			elseif($causal == "C")
				$id_descrip_causal = 3;
			elseif($causal == "D")
				$id_descrip_causal = 4;
			elseif($causal == "E")
				$id_descrip_causal = 5;
			else
				$id_descrip_causal = 0;

			$get_descripcion_causal = $this->Descripcion_causal_model->get($id_descrip_causal);
			$descripcion_causal = isset($get_descripcion_causal->descripcion)?$get_descripcion_causal->descripcion:'';

			//parrafo cuando es distinto a "sin horario"
			if($jornada != "1")
				$adicional_cumplimiento_horario_undecimo = "Cumplir con el horario de ingreso y salida establecido en la Usuaria, y no registrar atrasos. ";
			else
				$adicional_cumplimiento_horario_undecimo = "";

			$get_descripcion_sin_horario = $this->Descripcion_horarios_model->get(1);
			$get_descripcion_adic_admin_e_turno_e = $this->Descripcion_horarios_model->get(2);
			$get_descripcion_horario_adicional_tiempo_extra = $this->Descripcion_horarios_model->get(3);
			$get_descripcion_horario = $this->Descripcion_horarios_model->get($jornada);

			if($jornada == "1"){
				$descripcion_jornada = isset($get_descripcion_sin_horario->descripcion)?$get_descripcion_sin_horario->descripcion:'';
			}else{
				$frase1 = isset($get_descripcion_horario->descripcion)?$get_descripcion_horario->descripcion:'';
				$frase2 = isset($get_descripcion_horario_adicional_tiempo_extra->descripcion)?$get_descripcion_horario_adicional_tiempo_extra->descripcion:'';
				$frase3 = isset($get_descripcion_adic_admin_e_turno_e->descripcion)?$get_descripcion_adic_admin_e_turno_e->descripcion:'';

				if($causal == "E")
					$descripcion_jornada = $frase1." ".$frase3.$salto_linea.$frase2;
				else
					$descripcion_jornada = $frase1.$salto_linea.$frase2;
			}

			$id_tipo_horario = isset($get_descripcion_horario->id_tipo_horario)?$get_descripcion_horario->id_tipo_horario:'';
			if($causal == "A"){
				if($id_tipo_horario == 2)
					$parrafo_decimo_tercero = "Las partes convienen que el presente Contrato de Servicios Transitorios tendrá como duración lo señalado en el Art. 183-O INCISO 1°, esto es la puesta disposición del trabajador podrá cubrir el tiempo de duración de la ausencia del trabajador reemplazado. Sus labores finalizarian el ".$fecha_termino_texto_largo.".";
				else
					$parrafo_decimo_tercero = "El presente contrato tendrá una vigencia hasta el ".$fecha_termino_texto_largo.", y podrá ponérsele término cuando concurran para ello causas justificadas que en conformidad a la ley puedan producir su caducidad, las partes fijan domicilio en la ciudad de Concepción y se someten a la jurisdicción de sus Tribunales.";
			}else{
				$parrafo_decimo_tercero = "El presente contrato tendrá una vigencia hasta el ".$fecha_termino_texto_largo.", y podrá ponérsele término cuando concurran para ello causas justificadas que en conformidad a la ley puedan producir su caducidad, las partes fijan domicilio en la ciudad de Concepción y se someten a la jurisdicción de sus Tribunales.";
			}

			$bono_responsabilidad_palabras = num2letras($bono_responsabilidad);
			$bono_gestion_palabras = num2letras($bono_gestion);
			$bono_confianza_palabras = num2letras($bono_confianza);
			$asignacion_zona_palabras = num2letras($asignacion_zona);
			$asignacion_movilizacion_palabras = num2letras($asignacion_movilizacion);
			$asignacion_herramientas_palabras =  num2letras($asignacion_herramientas);
			$asignacion_colacion_palabras = num2letras($asignacion_colacion);
			$viatico_palabras = num2letras($viatico);

			if($bono_responsabilidad > 0)
				$frase_bono_responsabilidad = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono de Responsabilidad por la suma de $ ".str_replace(',','.',number_format($bono_responsabilidad))." (".$bono_responsabilidad_palabras.").".$salto_linea."";
			else
				$frase_bono_responsabilidad = "";

			if($bono_gestion > 0)
				$frase_bono_gestion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono de Gestión por la suma de $ ".str_replace(',','.',number_format($bono_gestion))." (".$bono_gestion_palabras.").".$salto_linea."";
			else
				$frase_bono_gestion = "";

			if($bono_confianza > 0)
				$frase_bono_confianza = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Bono Confianza por la suma de $ ".str_replace(',','.',number_format($bono_confianza))." (".$bono_confianza_palabras.").".$salto_linea."";
			else
				$frase_bono_confianza = "";
			
			if($asignacion_herramientas > 0)
				$frase_bono_herramientas = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de herramientas $ ".str_replace(',','.',number_format($asignacion_herramientas))." (".$asignacion_herramientas_palabras.").".$salto_linea."";
			else
				$frase_bono_herramientas = "";

			if($asignacion_movilizacion > 0)
				$frase_asignacion_movilizacion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de locomoción de $ ".str_replace(',','.',number_format($asignacion_movilizacion))." (".$asignacion_movilizacion_palabras.").".$salto_linea."";
			else
				$frase_asignacion_movilizacion = "";

			if($asignacion_colacion > 0)
				$frase_asignacion_colacion = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación de colación de $ ".str_replace(',','.',number_format($asignacion_colacion))." (".$asignacion_colacion_palabras.").".$salto_linea."";
			else
				$frase_asignacion_colacion = "";

			if($asignacion_zona > 0)
				$frase_asignacion_zona = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, una asignación Zona por la suma de $ ".str_replace(',','.',number_format($asignacion_zona))." (".$asignacion_zona_palabras.").".$salto_linea."";
			else
				$frase_asignacion_zona = "";

			if($viatico > 0)
				$frase_viatico = "Además se pagará al trabajador mensualmente y, proporcional a los días efectivamente trabajados, un Viático de $ ".str_replace(',','.',number_format($viatico))." (".$viatico_palabras.").".$salto_linea."";
			else
				$frase_viatico = "";

			$detalle_bonos = $frase_bono_responsabilidad.$frase_bono_gestion.$frase_bono_confianza.$frase_bono_herramientas.$frase_asignacion_movilizacion.$frase_asignacion_colacion.$frase_asignacion_zona.$frase_viatico;
			$sueldo_base_palabras = num2letras($renta_imponible);

			// Insertamos variables en el word
			if($id_centro_costo == 13){

				$descripcion_cargo = $this->Descripcion_causal_model->traer_descripcion($cargo);
				$cargoo = $descripcion_cargo->descripcion;

			} 
			
			$templateWord->setValue('cargorealizar',$cargoo);
			$templateWord->setValue('fecha_ingreso_trabajador_palabras',$fecha_inicio_texto_largo);
			$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
			$templateWord->setValue('rut_trabajador',$rut_trabajador);
			$templateWord->setValue('nacionalidad',titleCase($nacionalidad));
			$templateWord->setValue('fecha_nacimiento',$fecha_nacimiento_texto_largo);
			$templateWord->setValue('estado_civil',titleCase($estado_civil));
			$templateWord->setValue('domicilio_trabajador',titleCase($domicilio_trabajador));
			$templateWord->setValue('comuna_trabajador',titleCase($comuna_trabajador));
			$templateWord->setValue('nombre_centro_costo',titleCase($nombre_centro_costo));
			$templateWord->setValue('rut_centro_costo',$rut_centro_costo);
			$templateWord->setValue('descripcion_causal',$descripcion_causal);
			$templateWord->setValue('motivo_req',htmlspecialchars(titleCase($motivo)));
			$templateWord->setValue('cargo_postulante',titleCase($cargo));
			$templateWord->setValue('centro_costo',$nombre_centro_costo);
			$templateWord->setValue('nombre_planta',titleCase($nombre_planta));
			$templateWord->setValue('direccion_planta',titleCase($direccion_planta));
			$templateWord->setValue('comuna_planta',titleCase($comuna_planta));
			$templateWord->setValue('region_planta',titleCase($region_planta));
			$templateWord->setValue('descripcion_jornada',$descripcion_jornada);
			$templateWord->setValue('sueldo_base_numeros', str_replace(',','.',number_format($renta_imponible)));
			$templateWord->setValue('sueldo_base_palabras',titleCase($sueldo_base_palabras));
			$templateWord->setValue('gratificacion',$gratificacion);
			$templateWord->setValue('detalle_bonos',$detalle_bonos);
			$templateWord->setValue('adicional_cumplimiento_horario_undecimo',$adicional_cumplimiento_horario_undecimo);
			$templateWord->setValue('prevision_trabajador',titleCase($prevision_trabajador));
			$templateWord->setValue('salud_trabajador',titleCase($salud_trabajador));
			$templateWord->setValue('fecha_ingreso_trabajador',$fecha_inicio_texto_largo);
			$templateWord->setValue('fecha_vigencia_contrato',$fecha_termino_texto_largo);
			$templateWord->setValue('parrafo_decimo_tercero',$parrafo_decimo_tercero);
			$templateWord->setValue('parrafoQuinto',$parrafoQuinto);

			// Guardamos el documento
			$nombre_documento = "contrato_trabajo_".$nombre_sin_espacios.".docx";
			$templateWord->saveAs("extras/contratos/archivos/".$nombre_documento);
			ob_clean();
			$get_url = "extras/contratos/archivos/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			//fin de boton generar contrato
		}elseif(isset($_POST['generar_doc_adicionales_contrato'])){
			//inicio de boton generar documentos adicionales contrato

			if(empty($_POST['gc_ano_fi']) || empty($_POST['gc_mes_fi']) || empty($_POST['gc_dia_fi']) )
				$fecha_inicio = '0000-00-00';
			else
				$fecha_inicio = $_POST['gc_ano_fi'].'-'.$_POST['gc_mes_fi'].'-'.$_POST['gc_dia_fi'];

			if(empty($_POST['gc_ano_ft']) || empty($_POST['gc_mes_ft']) || empty($_POST['gc_dia_ft']) )
				$fecha_termino = '0000-00-00';
			else
				$fecha_termino = $_POST['gc_ano_ft'].'-'.$_POST['gc_mes_ft'].'-'.$_POST['gc_dia_ft'];

			$causal = $_POST['gc_causal'];
			$motivo = $_POST['gc_motivo'];
			$fecha_inicio = $fecha_inicio;
			$fecha_termino = $fecha_termino;

			if($id_planta == 2)
				$template_formato = base_url()."extras/contratos/formatos_contratos_est/3_contrato_parte_2_con_4_documentos_celulosa_arauco.docx";
			elseif($id_planta == 3)
				$template_formato = base_url()."extras/contratos/formatos_contratos_est/3_contrato_parte_2_con_4_documentos_celulosa_nueva_aldea.docx";
			elseif($id_centro_costo == 13)
				$template_formato = base_url()."extras/contratos/formatos_contratos_andritz/documentos_adicionales.docx";
			elseif($id_planta == 5)
				$template_formato = base_url()."extras/contratos/formatos_contratos_est/3_contrato_parte_2_con_4_documentos_celulosa_valdivia.docx";
			elseif($id_planta == 30)
				$template_formato = base_url()."extras/contratos/formatos_contratos_est/3_contrato_parte_2_con_4_documentos_forestal_chillan.docx";
			elseif($id_planta == 20 or $id_planta == 21 or $id_planta == 34 or $id_planta == 35 or $id_planta == 36 or $id_planta == 37 or $id_planta == 38 or $id_planta == 39 or $id_planta == 40 )
				$template_formato = base_url()."extras/contratos/formatos_contratos_est/4_contrato_parte_2_con_2_documentos.docx";
			elseif($id_planta == 6 or $id_planta == 8 or $id_planta == 9 or $id_planta == 10 or $id_planta == 11 or $id_planta == 15 or $id_planta == 16 or $id_planta == 17 or $id_planta == 19 or $id_planta == 33)
				$template_formato = base_url()."extras/contratos/formatos_contratos_est/3_contrato_parte_2_con_4_documentos_maderas.docx";
			elseif($id_planta ==41)
				$template_formato = base_url()."extras/contratos/formatos_contratos_est/3_contrato_parte_2_con_4_documentos_celulosa_forestal.docx";
			else
				$template_formato = base_url()."extras/contratos/formatos_contratos_est/3_contrato_parte_2_con_4_documentos_celulosa_y_gic_y_transversal.docx";

			if($id_planta == 21 or $id_planta == 22)
				$nombre_planta = "";

			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";

			$var1 = explode('.',$rut_trabajador); 
			$rut1 = $var1[0];

			if($rut1 < 10)
				$rut_trabajador = "0".$rut_trabajador;

			$get_fecha_inicio=date($fecha_inicio); 
			$var1 = explode('-',$get_fecha_inicio); 
			$get_dia_fi = $var1[2];
			$mes_fi = $var1[1];
			$ano_fi = $var1[0];

			if($get_dia_fi < 10)
				$dia_fi = "0".$var1[2];
			else
				$dia_fi = $var1[2];

			if ($mes_fi=="01") $mes_letra_fi="Enero";
			if ($mes_fi=="02") $mes_letra_fi="Febrero";
			if ($mes_fi=="03") $mes_letra_fi="Marzo";
			if ($mes_fi=="04") $mes_letra_fi="Abril";
			if ($mes_fi=="05") $mes_letra_fi="Mayo";
			if ($mes_fi=="06") $mes_letra_fi="Junio";
			if ($mes_fi=="07") $mes_letra_fi="Julio";
			if ($mes_fi=="08") $mes_letra_fi="Agosto";
			if ($mes_fi=="09") $mes_letra_fi="Septiembre";
			if ($mes_fi=="10") $mes_letra_fi="Octubre";
			if ($mes_fi=="11") $mes_letra_fi="Noviembre";
			if ($mes_fi=="12") $mes_letra_fi="Diciembre";

			$get_fecha_termino=date($fecha_termino); 
			$var2 = explode('-',$get_fecha_termino); 
			$get_dia_ft = $var2[2];
			$mes_ft = $var2[1];
			$ano_ft = $var2[0];
			
			if($get_dia_ft < 10)
				$dia_ft = "0".$var2[2];
			else
				$dia_ft = $var2[2];

			if ($mes_ft=="01") $mes_letra_ft="Enero";
			if ($mes_ft=="02") $mes_letra_ft="Febrero";
			if ($mes_ft=="03") $mes_letra_ft="Marzo";
			if ($mes_ft=="04") $mes_letra_ft="Abril";
			if ($mes_ft=="05") $mes_letra_ft="Mayo";
			if ($mes_ft=="06") $mes_letra_ft="Junio";
			if ($mes_ft=="07") $mes_letra_ft="Julio";
			if ($mes_ft=="08") $mes_letra_ft="Agosto";
			if ($mes_ft=="09") $mes_letra_ft="Septiembre";
			if ($mes_ft=="10") $mes_letra_ft="Octubre";
			if ($mes_ft=="11") $mes_letra_ft="Noviembre";
			if ($mes_ft=="12") $mes_letra_ft="Diciembre";

			$get_fecha_nacimiento=date($fecha_nac); 
			$var3 = explode('-',$get_fecha_nacimiento); 
			$dia_fecha_nac = $var3[2];
			$mes_fecha_nac = $var3[1];
			$ano_fecha_nac = $var3[0];
			if ($mes_fecha_nac=="01") $mes_letra_fecha_nac="Enero";
			if ($mes_fecha_nac=="02") $mes_letra_fecha_nac="Febrero";
			if ($mes_fecha_nac=="03") $mes_letra_fecha_nac="Marzo";
			if ($mes_fecha_nac=="04") $mes_letra_fecha_nac="Abril";
			if ($mes_fecha_nac=="05") $mes_letra_fecha_nac="Mayo";
			if ($mes_fecha_nac=="06") $mes_letra_fecha_nac="Junio";
			if ($mes_fecha_nac=="07") $mes_letra_fecha_nac="Julio";
			if ($mes_fecha_nac=="08") $mes_letra_fecha_nac="Agosto";
			if ($mes_fecha_nac=="09") $mes_letra_fecha_nac="Septiembre";
			if ($mes_fecha_nac=="10") $mes_letra_fecha_nac="Octubre";
			if ($mes_fecha_nac=="11") $mes_letra_fecha_nac="Noviembre";
			if ($mes_fecha_nac=="12") $mes_letra_fecha_nac="Diciembre";
            
            $fechanacimientocorta = $var3[2]."-".$var3[1]."-".$var3[0];
			$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
			$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
			$fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

			// Insertamos variables en el word
			$templateWord->setValue('nombre_trabajador',titleCase($nombre_trabajador));
			$templateWord->setValue('f_nacimiento',titleCase($fechanacimientocorta));
			$templateWord->setValue('rut_trabajador',$rut_trabajador);
			$templateWord->setValue('cargo_postulante',titleCase($cargo));
			$templateWord->setValue('fecha_ingreso_trabajador_palabras',$fecha_inicio_texto_largo);
			$templateWord->setValue('nombre_planta',titleCase($nombre_planta));
			$templateWord->setValue('nombre_planta_may',strtoupper($nombre_planta));
			$templateWord->setValue('nombre_centro_costo',titleCase($nombre_centro_costo));
			$templateWord->setValue('nombre_centro_costo_may',strtoupper($nombre_centro_costo));
			$templateWord->setValue('comuna_planta',titleCase($comuna_planta));

			// Guardamos el documento
			$nombre_documento = "doc_adicional_contrato_trabajo_".$nombre_sin_espacios.".docx";
			$templateWord->saveAs("extras/contratos/archivos/".$nombre_documento);
			ob_clean();
			$get_url = "extras/contratos/archivos/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			//fin de boton generar documentos adicionales contrato
		}
		$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
		$usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
		$asc_area = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
		redirect('est/requerimiento/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
	}

	function callback_view_documentos($id_usuario,$id_asc_area_req,$id_req = FALSE){
		$this->load->model("tipoarchivos_requerimiento_model");
		$this->load->model("requerimiento_usuario_archivo_model");
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Pensiones_Requerimiento_model");
		$this->load->model("Pensiones_Valores_model");
		$this->load->model("Pensiones_model");
		$usr = $this->Usuarios_model->get($id_usuario);
		$base['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$archivos = $this->tipoarchivos_requerimiento_model->listar();
		$pensiones = $this->Pensiones_Requerimiento_model->get_pension_area_cargo($id_req, $id_usuario);
		//var_dump($archivos);return false;
		$salida = array();
		foreach ($archivos as $a){
			if ($a->id !=2) {			
				$dato = $this->requerimiento_usuario_archivo_model->get_usuario_requerimiento_archivo($id_usuario,$id_asc_area_req,$a->id);
				//var_dump($dato);
				$aux = new StdClass();
				$tipo_archivo = isset($a->id)?$a->id:'';
				//if($tipo_archivo != 1 and $tipo_archivo != 2){
					$aux->id = $a->id;
					$aux->usuario_id = $id_usuario;
					$aux->archivo = $a->nombre;
					$aux->id_requerimiento = $id_req;
			
					$aux->datos = array();
					if (!empty($dato)){
						foreach ($dato as $d){
							$archivo = new StdClass();
							$archivo->id = $d->id;
							$archivo->nombre = urldecode($d->nombre);
							$archivo->url = $d->url;
							$archivo->fecha_termino= $d->fecha_termino;
							$archivo->tipo= 1;
							array_push($aux->datos, $archivo);
						}
						unset($archivo);
					}
					array_push($salida, $aux);
					unset($aux);
			}
		}

		//var_dump($salida);
//return false;
			$anexos = $this->requerimiento_usuario_archivo_model->get_usuario_requerimiento_anexo($id_usuario,$id_asc_area_req);
			//Anexos
			//var_dump($anexos);
			$aux = new StdClass();
				if (!empty($anexos)){
					$aux->id = 2;//anexos
					$aux->usuario_id = $id_usuario;
					$aux->archivo = 'Anexo';
					$aux->id_requerimiento = $id_req;
					$aux->datos = array();
					foreach ($anexos as $anex){
						$archivo = new StdClass();
						$archivo->id = $anex->id;
						$archivo->nombre = urldecode($anex->nombre);
						$archivo->url = $anex->url;
						$archivo->fecha_termino= $anex->fecha_termino_nuevo_anexo;
						$archivo->tipo= 2;
						array_push($aux->datos, $archivo);
					}
					unset($archivo);
					array_push($salida, $aux);
				}

		/*echo '<pre>';
print_r($salida);
echo '</pre>';*/
		$salida2 = array();
		foreach ($pensiones as $p){
			$aux2 = new StdClass();
			$get_datos_pension_valores = $this->Pensiones_Valores_model->get_valores($p->id_pension_valores);
			$id_pension = isset($get_datos_pension_valores->id_pension)?$get_datos_pension_valores->id_pension:'0';
			$get_pension = $this->Pensiones_model->get_row($id_pension);
			$aux2->id_pension_req = $p->id;
			$aux2->nombre_pension = isset($get_pension->razon_social)?$get_pension->razon_social:'';
			array_push($salida2, $aux2);
			unset($aux2);
		}

		$archivos_trab = $this->Tipoarchivos_model->listar_2();
		$salida3 = array();
		foreach ($archivos_trab as $a){
			$aux3 = new StdClass();
			$aux3->id_usuario = $id_usuario;
			$aux3->nombre = $a->desc_tipoarchivo;
			$aux3->id_archivo_trabaj = $a->id;
			$aux3->id_requerimiento = $id_req;
			$get_archivo_trabaj = $this->Archivos_trab_model->get_archivo2($id_usuario, $a->id);
			$aux3->nombre_archivo_trabaj = (isset($get_archivo_trabaj->nombre))?$get_archivo_trabaj->nombre:'';
			$aux3->archivo_trabaj = (isset($get_archivo_trabaj->url))?$get_archivo_trabaj->url:'';	
			array_push($salida3, $aux3);
			unset($aux3);
		}

		$base['masso'] = $this->Evaluaciones_model->get_una_masso($id_usuario);
		$base['preocupacional'] = $this->Evaluaciones_model->get_una_preocupacional($id_usuario);
		$base['archivos'] = $salida;
		$base['datos_pension'] = $salida2;
		$base['archivos_trab'] = $salida3;
		$base['asc_area'] = $id_asc_area_req;
		$this->load->view('requerimiento/documentos_contractuales',$base);
	}

	function callback_view_documentos_general($id_usuario,$id_asc_area_req,$id_req = FALSE){
		$this->load->model("tipoarchivos_requerimiento_model");
		$this->load->model("requerimiento_usuario_archivo_model");
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$usr = $this->Usuarios_model->get($id_usuario);
		$base['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$archivos = $this->tipoarchivos_requerimiento_model->listar();

		$salida = array();
		foreach ($archivos as $a){
			$dato = $this->requerimiento_usuario_archivo_model->get_usuario_requerimiento_archivo($id_usuario,$id_asc_area_req,$a->id);
			$aux = new StdClass();

			$tipo_archivo = isset($a->id)?$a->id:'';
			//if($tipo_archivo != 1 and $tipo_archivo != 2){
				$aux->id = $a->id;
				$aux->usuario_id = $id_usuario;
				$aux->archivo = $a->nombre;
				$aux->id_requerimiento = $id_req;
			
				$aux->datos = array();
				if (!empty($dato)){
					foreach ($dato as $d) {
						$archivo = new StdClass();
						$archivo->id = $d->id;
						$archivo->nombre = urldecode($d->nombre);
						$archivo->url = $d->url;
						array_push($aux->datos, $archivo);
						unset($archivo);
					}
				}
				array_push($salida, $aux);
				unset($aux);
			//}
		}

		$base['archivos'] = $salida;
		$archivos_trab = $this->Tipoarchivos_model->listar_2();
		$salida2 = array();
		foreach ($archivos_trab as $a){
			$aux = new StdClass();
			$aux->id_usuario = $id_usuario;
			$aux->nombre = $a->desc_tipoarchivo;
			$aux->id_archivo_trabaj = $a->id;
			$aux->id_requerimiento = $id_req;
			$get_archivo_trabaj = $this->Archivos_trab_model->get_archivo2($id_usuario, $a->id);
			$aux->nombre_archivo_trabaj = (isset($get_archivo_trabaj->nombre))?$get_archivo_trabaj->nombre:'';
			$aux->archivo_trabaj = (isset($get_archivo_trabaj->url))?$get_archivo_trabaj->url:'';	
			array_push($salida2, $aux);
			unset($aux);
		}

		$base['masso'] = $this->Evaluaciones_model->get_una_masso($id_usuario);
		$base['preocupacional'] = $this->Evaluaciones_model->get_una_preocupacional($id_usuario);
		$base['archivos_trab'] = $salida2;
		$base['asc_area'] = $id_asc_area_req;
		$this->load->view('requerimiento/documentos_contractuales_general',$base);
	}

	function callback_view_documentos2($id_usuario,$id_asc_area_req,$id_req = FALSE){
		$this->load->model("tipoarchivos_requerimiento_model");
		$this->load->model("requerimiento_usuario_archivo_model");
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluaciones_model");
		$usr = $this->Usuarios_model->get($id_usuario);
		$base['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$archivos = $this->tipoarchivos_requerimiento_model->listar();

		$salida = array();

		foreach ($archivos as $a) {
			$dato = $this->requerimiento_usuario_archivo_model->get_usuario_requerimiento_archivo($id_usuario,$id_asc_area_req,$a->id);
			$aux = new StdClass();
			$aux->id = $a->id;
			$aux->usuario_id = $id_usuario;
			$aux->archivo = $a->nombre;
			$aux->datos = array();
			if (!empty($dato)){
				foreach ($dato as $d) {
					$archivo = new StdClass();
					$archivo->id = $d->id;
					$archivo->nombre = urldecode($d->nombre);
					$archivo->url = $d->url;
					array_push($aux->datos, $archivo);
				}
				unset($archivo);
			}
			array_push($salida, $aux);
			unset($aux);
		}

		$base['archivos'] = $salida;
		$archivos_trab = $this->Tipoarchivos_model->listar_2();
		$salida2 = array();
		foreach ($archivos_trab as $a){
			$aux = new StdClass();
			$aux->id_usuario = $id_usuario;
			$aux->nombre = $a->desc_tipoarchivo;
			$aux->id_archivo_trabaj = $a->id;
			$aux->id_requerimiento = $id_req;
			$get_archivo_trabaj = $this->Archivos_trab_model->get_archivo2($id_usuario, $a->id);
			$aux->nombre_archivo_trabaj = (isset($get_archivo_trabaj->nombre))?$get_archivo_trabaj->nombre:'';
			$aux->archivo_trabaj = (isset($get_archivo_trabaj->url))?$get_archivo_trabaj->url:'';	
			array_push($salida2, $aux);
			unset($aux);
		}

		$base['masso'] = $this->Evaluaciones_model->get_una_masso($id_usuario);
		$base['preocupacional'] = $this->Evaluaciones_model->get_una_preocupacional($id_usuario);
		$base['archivos_trab'] = $salida2;
		$base['asc_area'] = $id_asc_area_req;
		$this->load->view('requerimiento/documentos_contractuales2',$base);
	}

	function guardar_archivo_general(){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("Tipoarchivos_model");
			$this->load->model("Archivos_trab_model");
			$this->load->model("Usuarios_model");
			
			$id = $_POST['id_usuario'];
			$id_req = $_POST['id_requerimiento'];
			$tipo = $this->Tipoarchivos_model->get($_POST['id_archivo'])->desc_tipoarchivo;
			$tipo = str_replace(" ", "_", $tipo);
			

			$usuario = $this->Usuarios_model->get($id);
			$aux = str_replace(" ", "_", $usuario->nombres);
			$ape = normaliza($aux)."_".normaliza($usuario->paterno).'_'.normaliza($usuario->materno);
			$nb_archivo = strtolower(sanear_string($id."_".trim($ape)));
			$nb_archivo = urlencode(sanear_string($nb_archivo));
			$salida = subir($_FILES,"documento","extras/docs/",$nb_archivo);
			
			if($salida == 1)
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_req, 'refresh');
			elseif($salida==2)
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_req, 'refresh');
			else{
				$data = array(
					'id_usuarios' => $id,
					'nombre' => $nb_archivo,
					'id_tipoarchivo' => $_POST['id_archivo'],
					'url' => $salida
 				);
				$this->Archivos_trab_model->ingresar($data);
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_req, 'refresh');
			}
		}
		else redirect('est/requerimiento/usuarios_requerimiento/'.$id_req, 'refresh');
	}

	function guardar_archivo_usuarios_generales(){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("Tipoarchivos_model");
			$this->load->model("Archivos_trab_model");
			$this->load->model("Usuarios_model");
			
			$id = $_POST['id_usuario'];
			$id_req = $_POST['id_requerimiento'];
			$tipo = $this->Tipoarchivos_model->get($_POST['id_archivo'])->desc_tipoarchivo;
			$tipo = str_replace(" ", "_", $tipo);
			

			$usuario = $this->Usuarios_model->get($id);
			$aux = str_replace(" ", "_", $usuario->nombres);
			$ape = normaliza($aux)."_".normaliza($usuario->paterno).'_'.normaliza($usuario->materno);
			$nb_archivo = strtolower(sanear_string($id."_".trim($ape)));
			$nb_archivo = urlencode(sanear_string($nb_archivo));
			$salida = subir($_FILES,"documento","extras/docs/",$nb_archivo);
			
			if($salida == 1)
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
			elseif($salida==2)
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
			else{
				$data = array(
					'id_usuarios' => $id,
					'nombre' => $nb_archivo,
					'id_tipoarchivo' => $_POST['id_archivo'],
					'url' => $salida
 				);
				$this->Archivos_trab_model->ingresar($data);
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
			}
		}
		else redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
	}

	function eliminar_documento_contractual($id){
		$this->load->model("requerimiento_usuario_archivo_model");
		$data = array(
			'nombre'=>'',
			'url'=>'',
			);
		$req2 = $this->requerimiento_usuario_archivo_model->get_requerimiento($id);
	//	var_dump($req2);
		if ($req2->tipo_archivo_requerimiento_id != 1) {
			$this->requerimiento_usuario_archivo_model->eliminar($id);
		}else{
			$req = $this->requerimiento_usuario_archivo_model->quitarContrato($id, $data);
		}
		$this->requerimiento_usuario_archivo_model->eliminar_solicitudes_contratos($id);
		redirect('est/requerimiento/usuarios_requerimiento/'.$req2->requerimiento_area_cargo_id, 'refresh');
	}

	function eliminar_anexo_subido($id){
		$this->load->model("requerimiento_usuario_archivo_model");
		$data = array(
			'nombre'=>'',
			'url'=>'',
			);
		//$req2 = $this->requerimiento_usuario_archivo_model->get_anexos_id($id);
	//	var_dump($req2);

		$req = $this->requerimiento_usuario_archivo_model->quitarAnexo($id, $data);
		header('Location:' . getenv('HTTP_REFERER'));
		//redirect('est/requerimiento/usuarios_requerimiento/'.$req2->requerimiento_area_cargo_id, 'refresh');
	}

	function eliminar_documento_contractual_general($id, $id_req = FALSE){
		$this->load->model("requerimiento_usuario_archivo_model");
		$req = $this->requerimiento_usuario_archivo_model->get_requerimiento($id);
		$this->requerimiento_usuario_archivo_model->eliminar($id);
		$this->requerimiento_usuario_archivo_model->eliminar_solicitudes_contratos($id);
		redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
	}

	function modal_administrar_archivo_usu($id_req_usu_arch = FALSE, $id_area_req = FALSE){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_req_usu_arch);
		$pagina['id_req_usu_arch']= $id_req_usu_arch;
		$pagina['id_area_req']= $id_area_req;
		$this->load->view('est/requerimiento/modal_administrar_doc_contractuales', $pagina);
	}

	function modal_administrar_archivo_usu_renuncia_voluntaria($id_req_usu_arch = FALSE, $id_area_req = FALSE){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_req_usu_arch);
		$pagina['id_req_usu_arch']= $id_req_usu_arch;
		$pagina['id_area_req']= $id_area_req;
		$this->load->view('est/requerimiento/modal_administrar_doc_contractuales_renuncia_voluntaria', $pagina);
	}

	function modal_administrar_archivo_usu_renuncia_voluntaria_general($id_req_usu_arch = FALSE, $id_area_req = FALSE){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_req_usu_arch);
		$pagina['id_req_usu_arch']= $id_req_usu_arch;
		$pagina['id_area_req']= $id_area_req;
		$this->load->view('est/requerimiento/modal_administrar_doc_contractuales_renuncia_voluntaria_general', $pagina);
	}

	function modal_agregar_doc($usuario,$tipo,$asc_area, $id_req_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		
		$get_datos_req = $this->Requerimiento_area_cargo_model->r_get_requerimiento($id_req_area_cargo);
		$pagina['motivo_defecto'] = (isset($get_datos_req->motivo)?$get_datos_req->motivo:'0');
		$pagina['causal_defecto'] = (isset($get_datos_req->causal)?$get_datos_req->causal:'0');

		$existe_anexo = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 2);
		$existe_contrato = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 1);
		
		if($tipo == 2){
			if($existe_anexo == 1){
				$pagina['datos_req']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit($usuario, $asc_area, 2);
			}elseif($existe_contrato == 1){
				$pagina['datos_req']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit($usuario, $asc_area, 1);
			}else{
				$pagina['datos_req']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit($usuario, $asc_area, $tipo);
			}
		}else{
			$pagina['datos_req']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit($usuario, $asc_area, 1);
		}

		$this->load->view('est/requerimiento/modal_agregar_doc_contractuales', $pagina);
	}

	function modal_agregar_doc_renuncia_voluntaria($usuario,$tipo,$asc_area, $id_req_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		$this->load->view('est/requerimiento/modal_agregar_doc_contractuales_renuncia_voluntaria', $pagina);
	}

	function modal_agregar_doc_renuncia_voluntaria_general($usuario,$tipo,$asc_area, $id_req_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		$pagina['id_req_area_cargo']= $id_req_area_cargo;
		$this->load->view('est/requerimiento/modal_agregar_doc_contractuales_renuncia_voluntaria_general', $pagina);
	}

	function modal_agregar_doc_general($usuario,$tipo,$asc_area, $id_req){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		$pagina['id_req']= $id_req;
		
		$get_datos_req = $this->Requerimiento_area_cargo_model->r_get_requerimiento($id_req);
		$pagina['motivo_defecto'] = (isset($get_datos_req->motivo)?$get_datos_req->motivo:'0');
		$pagina['causal_defecto'] = (isset($get_datos_req->causal)?$get_datos_req->causal:'0');

		$existe_anexo = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 2);
		$existe_contrato = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 1);
		
		if($tipo == 2){
			if($existe_anexo == 1){
				$pagina['datos_req']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit($usuario, $asc_area, 2);
			}elseif($existe_contrato == 1){
				$pagina['datos_req']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit($usuario, $asc_area, 1);
			}else{
				$pagina['datos_req']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit($usuario, $asc_area, $tipo);
			}
		}else{
			$pagina['datos_req']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit($usuario, $asc_area, 1);
		}
		$this->load->view('est/requerimiento/modal_agregar_doc_contractuales_general', $pagina);
	}

	function modal_administrar_doc_general($id_usu_arch,$id_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$pagina['id_usu_arch']= $id_usu_arch;
		$pagina['id_area_cargo']= $id_area_cargo;
		$pagina['datos_usu_arch']= $this->Requerimiento_Usuario_Archivo_model->get_result($id_usu_arch);
		$this->load->view('est/requerimiento/modal_administrar_doc_contractuales_general', $pagina);
	}

	function modal_nueva_pension($usuario,$asc_area, $id_req_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Pensiones_model");
		
		$listado = array();
		$aux = new stdClass();
		$aux->id_req_area_cargo = $id_req_area_cargo;
		$aux->id_usuario = $usuario;
		$aux->id_pension1 = 0;
		$aux->n_dias_pension_completa1 = 0;
		$aux->n_dias_almuerzo1 = 0;
		$aux->n_dias_reserva1 = 0;
		$aux->n_dias_otros_valores1 = 0;
		$aux->fecha_inicio1 = '0000-00-00';
		$aux->fecha_termino1 = '0000-00-00';
		$aux->valor_pension_completa = 0;
		$aux->valor_almuerzo = 0;
		$aux->valor_reserva = 0;
		$aux->valor_otros_valores = 0;
		$aux->total_pension_completa = 0;
		$aux->total_almuerzo = 0;
		$aux->total_reserva = 0;
		$aux->total_otros_valores = 0;
		$aux->total_totales = 0;
		array_push($listado, $aux);
		unset($aux);

		$pagina['usuario']= $usuario;
		$pagina['asc_area']= $asc_area;
		$pagina['datos_pension']= $listado;
		$pagina['id_req_area_cargo']= $id_req_area_cargo;
		$pagina['datos_contrato']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo($usuario, $asc_area, 1);
		$pagina['datos_anexo']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo($usuario, $asc_area, 2);
		$pagina['pensiones'] = $this->Pensiones_model->listar();
		$this->load->view('est/requerimiento/modal_nueva_pension', $pagina);
	}

	function modal_admin_pension($id_pension_req, $asc_area){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Pensiones_Requerimiento_model");
		$this->load->model("Pensiones_Valores_model");
		$this->load->model("Pensiones_model");

		$datos_pension_req = $this->Pensiones_Requerimiento_model->get_pension_req($id_pension_req);

		$listado = array();
        if ($datos_pension_req != FALSE){
			foreach($datos_pension_req as $rm){
				$aux = new stdClass();
				$id_usuario = $rm->id_usuario;
				$get_valores_pension = $this->Pensiones_Valores_model->get_valores($rm->id_pension_valores);
				$valor_pension_completa = isset($get_valores_pension->pension_completa)?$get_valores_pension->pension_completa:"0";
				$valor_almuerzo = isset($get_valores_pension->almuerzo)?$get_valores_pension->almuerzo:"0";
				$valor_reserva = isset($get_valores_pension->reserva)?$get_valores_pension->reserva:"0";
				$valor_otros_valores = isset($get_valores_pension->otros_valores)?$get_valores_pension->otros_valores:"0";
				$total_pension_completa = ($valor_pension_completa * $rm->n_dias_pension_completa);
				$total_almuerzo = ($valor_almuerzo * $rm->n_dias_almuerzo);
				$total_reserva = ($valor_reserva * $rm->n_dias_reserva);
				$total_otros_valores = ($valor_otros_valores * $rm->n_dias_otros_valores);
				$total_totales = ($total_pension_completa + $total_almuerzo + $total_reserva + $total_otros_valores);
				$aux->id_req_area_cargo = $rm->id_requerimiento_area_cargo;
				$aux->id_usuario = $rm->id_usuario;
				$aux->id_pension_valores = $rm->id_pension_valores;
				$aux->id_pension = isset($get_valores_pension->id_pension)?$get_valores_pension->id_pension:'0';
				$aux->n_dias_pension_completa = $rm->n_dias_pension_completa;
				$aux->n_dias_almuerzo = $rm->n_dias_almuerzo;
				$aux->n_dias_reserva = $rm->n_dias_reserva;
				$aux->n_dias_otros_valores = $rm->n_dias_otros_valores;
				$aux->fecha_inicio = $rm->fecha_inicio;
				$aux->fecha_termino = $rm->fecha_termino;
				$aux->valor_pension_completa = $valor_pension_completa;
				$aux->valor_almuerzo = $valor_almuerzo;
				$aux->valor_reserva = $valor_reserva;
				$aux->valor_otros_valores = $valor_otros_valores;
				$aux->total_pension_completa = $total_pension_completa;
				$aux->total_almuerzo = $total_almuerzo;
				$aux->total_reserva = $total_reserva;
				$aux->total_otros_valores = $total_otros_valores;
				$aux->total_totales = $total_totales;
				array_push($listado, $aux);
				unset($aux);
			}
		}else{
			$aux = new stdClass();
			$id_usuario = 0;
			$aux->id_req_area_cargo = 0;
			$aux->id_usuario = 0;
			$aux->id_pension = 0;
			$aux->id_pension_valores = $rm->id_pension_valores;
			$aux->n_dias_pension_completa2 = 0;
			$aux->n_dias_almuerzo2 = 0;
			$aux->n_dias_reserva2 = 0;
			$aux->n_dias_otros_valores2 = 0;
			$aux->fecha_inicio2 = '0000-00-00';
			$aux->fecha_termino2 = '0000-00-00';
			$aux->valor_pension_completa = 0;
			$aux->valor_almuerzo = 0;
			$aux->valor_reserva = 0;
			$aux->valor_otros_valores = 0;
			$aux->total_pension_completa = 0;
			$aux->total_almuerzo = 0;
			$aux->total_reserva = 0;
			$aux->total_otros_valores = 0;
			$aux->total_totales = 0;
			array_push($listado, $aux);
			unset($aux);
        }

		$pagina['datos_pension']= $listado;
		$pagina['id_pension_req']= $id_pension_req;
		$pagina['datos_contrato']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo($id_usuario, $asc_area, 1);
		$pagina['datos_anexo']= $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo($id_usuario, $asc_area, 2);
		$pagina['pensiones'] = $this->Pensiones_model->listar();
		$this->load->view('est/requerimiento/modal_administrar_pension', $pagina);
	}

	function guardar_nueva_pension_requerimiento(){
		$this->load->model("Pensiones_Requerimiento_model");

		$usuario = $_POST['usuario'];
		$id_req_area_cargo = $_POST['id_req_area_cargo'];
		$id_registro_valores = $_POST['id_registro_valores'];

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']))
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']))
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		$datos = array(
			'id_requerimiento_area_cargo' => $id_req_area_cargo,
			'id_usuario' => $usuario,
			'id_pension_valores' => $id_registro_valores,
			'n_dias_pension_completa' => $_POST['dias_pension_c'],
			'n_dias_almuerzo' => $_POST['dias_almuerzo_c'],
			'n_dias_reserva' => $_POST['dias_reserva_c'],
			'n_dias_otros_valores' => $_POST['dias_otros_valores_c'],
			'fecha_inicio' => $fecha_inicio,
			'fecha_termino' => $fecha_termino,
		);

		/*$si_existe = $this->Pensiones_Requerimiento_model->existe_registro_pension($id_registro_valores, $id_req_area_cargo, $usuario);
		if($si_existe == 1){
			$this->Pensiones_Requerimiento_model->actualizar($datos, $id_registro_valores, $id_req_area_cargo, $usuario);
		}else{*/
		$this->Pensiones_Requerimiento_model->guardar($datos);
		//}

		echo '<script>alert("Pension Ingresada Exitosamente");</script>';
		redirect('est/requerimiento/usuarios_requerimiento/'.$id_req_area_cargo.'', 'refresh');
	}

	function actualizar_pension_requerimiento(){
		$this->load->model("Pensiones_Requerimiento_model");

		$id_pension_req = $_POST['id_pension_req'];
		$id_registro_valores = $_POST['id_registro_valores'];
		$id_req_area_cargo = $_POST['id_req_area_cargo'];

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']))
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']))
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		$datos = array(
			'id_pension_valores' => $id_registro_valores,
			'n_dias_pension_completa' => $_POST['dias_pension_c3'],
			'n_dias_almuerzo' => $_POST['dias_almuerzo_c3'],
			'n_dias_reserva' => $_POST['dias_reserva_c3'],
			'n_dias_otros_valores' => $_POST['dias_otros_valores_c3'],
			'fecha_inicio' => $fecha_inicio,
			'fecha_termino' => $fecha_termino,
		);

		$this->Pensiones_Requerimiento_model->actualizar_id($datos, $id_pension_req);
		
		echo '<script>alert("Pension Actualizada Exitosamente");</script>';
		redirect('est/requerimiento/usuarios_requerimiento/'.$id_req_area_cargo.'', 'refresh');
	}

	function buscar_detalles_pension($id_pension = FALSE){
		$this->load->model("Pensiones_model");
		$this->load->model("Pensiones_Valores_model");
		$consulta = $this->Pensiones_Valores_model->listar_valores($id_pension);
		echo json_encode($consulta);
	}

	function actualizar_doc_contractual($id_req_usu_arch, $id_area_req){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		if($_FILES['documento']['error'] == 0){
			$nombreTrabajador= $this->Requerimiento_Usuario_Archivo_model->getNombreTrabajador($id_req_usu_arch);
			//var_dump($nombreTrabajador);return false;
			$this->load->helper("archivo");
			$nb_archivo = urlencode(sanear_string($nombreTrabajador->name));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);
			$archivo = array(
				'nombre' => 'CT_'.$nombreTrabajador->nombreTrabajador,
				'url' => $salida,
			);
		}else{ 
			$archivo = array();
		}
		
		$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $archivo);
		header('Location:' . getenv('HTTP_REFERER'));
		//redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_req, 'refresh');
	}

	function actualizar_doc_contractual_renuncia_voluntaria($id_req_usu_arch, $id_area_req){
		$this->load->model("Requerimiento_Usuario_Archivo_model");

		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			
			$nb_archivo = urlencode(sanear_string($_FILES['documento']['name']));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);
			if($salida == 1)
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_req, 'refresh');
			elseif($salida==2)
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_req, 'refresh');
			else{

				if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
					$fecha_termino = '0000-00-00';
				else
					$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

				$data = array(
					'nombre' => $nb_archivo,
					'url' => $salida,
					'fecha_termino' => $fecha_termino,
				);

				$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $data);
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_req, 'refresh');
			}
		}else{
			if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
				$fecha_termino = '0000-00-00';
			else
				$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

			$data = array(
				'fecha_termino' => $fecha_termino,
			);

			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $data);
			redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_req, 'refresh');
		}
	}

	function actualizar_doc_contractual_renuncia_voluntaria_general($id_req_usu_arch, $id_area_req){
		$this->load->model("Requerimiento_Usuario_Archivo_model");

		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			
			$nb_archivo = urlencode(sanear_string($_FILES['documento']['name']));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);
			if($salida == 1)
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_area_req, 'refresh');
			elseif($salida==2)
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_area_req, 'refresh');
			else{

				if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
					$fecha_termino = '0000-00-00';
				else
					$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

				$data = array(
					'nombre' => $nb_archivo,
					'url' => $salida,
					'fecha_termino' => $fecha_termino,
				);

				$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $data);
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_area_req, 'refresh');
			}
		}else{
			if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
				$fecha_termino = '0000-00-00';
			else
				$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

			$data = array(
				'fecha_termino' => $fecha_termino,
			);

			$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_req_usu_arch, $data);
			redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_area_req, 'refresh');
		}
	}

	function guardar_doc_contractual($usuario,$tipo,$asc_area){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Usuarios_model");

		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$nb_archivo = urlencode(sanear_string($_FILES['documento']['name']));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);
			$archivo = array(
				'nombre' => $nb_archivo,
				'url' => $salida,
			);
		}else{
			$archivo = array();
		}

		$id_area_cargo = $this->Requerimiento_asc_trabajadores_model->get($asc_area)->requerimiento_area_cargo_id;
		//var_dump($id_area_cargo); return false;
		if (empty($_POST['datos_extras']))
			$vienen_datos = "NO";
		else
			$vienen_datos = "SI";

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']) )
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		if($vienen_datos == "SI"){
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo,
				'causal' => $_POST['causal'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha_inicio,
				'fecha_termino' => $fecha_termino,
				'jornada' => $_POST['jornada'],
				'renta_imponible' => $_POST['renta_imponible'],
				'bono_responsabilidad' => $_POST['bono_responsabilidad'],
				'bono_gestion' => $_POST['bono_gestion'],
				'bono_confianza' => $_POST['bono_confianza'],
				'asignacion_movilizacion' => $_POST['asignacion_movilizacion'],
				'asignacion_colacion' => $_POST['asignacion_colacion'],
				'asignacion_zona' => $_POST['asignacion_zona'],
				'viatico' => $_POST['viatico'],
				'seguro_vida_arauco' => 'SI'
			);
		}else{
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo
			);
		}

		$todos_los_datos = array_merge($archivo, $data);
		$this->Requerimiento_Usuario_Archivo_model->ingresar($todos_los_datos);
		redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_cargo, 'refresh');
	}

	function guardar_doc_contractual_renuncia_voluntaria($usuario,$tipo,$asc_area){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->model("Requerimiento_Usuario_Archivo_model");
			$this->load->model("Requerimiento_asc_trabajadores_model");
			$this->load->model("Usuarios_model");

			$id_area_cargo = $this->Requerimiento_asc_trabajadores_model->get($asc_area)->requerimiento_area_cargo_id;

			$nb_archivo = urlencode(sanear_string($_FILES['documento']['name']));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);
			if($salida == 1)
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_cargo, 'refresh');
			elseif($salida==2)
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_cargo, 'refresh');
			else{

				if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
					$fecha_termino = '0000-00-00';
				else
					$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

				$data = array(
					'usuario_id' => $usuario,
					'requerimiento_asc_trabajadores_id' => $asc_area,
					'tipo_archivo_requerimiento_id' => $tipo,
					'nombre' => $nb_archivo,
					'url' => $salida,
					'fecha_termino' => $fecha_termino,
 				);
				$this->Requerimiento_Usuario_Archivo_model->ingresar($data);
				redirect('est/requerimiento/usuarios_requerimiento/'.$id_area_cargo, 'refresh');
			}
		}
	}

	function guardar_doc_contractual_renuncia_voluntaria_general($usuario,$tipo,$asc_area, $id_req_area_cargo){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->model("Requerimiento_Usuario_Archivo_model");
			$this->load->model("Requerimiento_asc_trabajadores_model");
			$this->load->model("Usuarios_model");

			$id_area_cargo = $this->Requerimiento_asc_trabajadores_model->get($asc_area)->requerimiento_area_cargo_id;

			$nb_archivo = urlencode(sanear_string($_FILES['documento']['name']));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);
			if($salida == 1)
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req_area_cargo, 'refresh');
			elseif($salida==2)
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req_area_cargo, 'refresh');
			else{
				if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
					$fecha_termino = '0000-00-00';
				else
					$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

				$data = array(
					'usuario_id' => $usuario,
					'requerimiento_asc_trabajadores_id' => $asc_area,
					'tipo_archivo_requerimiento_id' => $tipo,
					'nombre' => $nb_archivo,
					'url' => $salida,
					'fecha_termino' => $fecha_termino,
 				);
				$this->Requerimiento_Usuario_Archivo_model->ingresar($data);
				redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req_area_cargo, 'refresh');
			}
		}
	}

	function actualizar_doc_contractual_general($id_usu_arch,$id_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");

		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$nb_archivo = urlencode(sanear_string($_FILES['documento']['name']));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);

			$archivo = array(
				'nombre' => $nb_archivo,
				'url' => $salida,
			);
		}else{
			$archivo = array();
		}

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']) )
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		$data = array(
			'causal' => $_POST['causal'],
			'motivo' => $_POST['motivo'],
			'fecha_inicio' => $fecha_inicio,
			'fecha_termino' => $fecha_termino,
			'jornada' => $_POST['jornada'],
			'renta_imponible' => $_POST['renta_imponible'],
			'bono_responsabilidad' => $_POST['bono_responsabilidad'],
			'bono_gestion' => $_POST['bono_gestion'],
			'bono_confianza' => $_POST['bono_confianza'],
			'asignacion_movilizacion' => $_POST['asignacion_movilizacion'],
			'asignacion_colacion' => $_POST['asignacion_colacion'],
			'asignacion_zona' => $_POST['asignacion_zona'],
			'viatico' => $_POST['viatico'],
			'seguro_vida_arauco' => 'SI'
		);
		$todos_los_datos = array_merge($archivo, $data);
		$this->Requerimiento_Usuario_Archivo_model->actualizar_usu_arch($id_usu_arch, $todos_los_datos);
		redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_area_cargo, 'refresh');
	}

	function guardar_doc_contractual_general($usuario,$tipo,$asc_area, $id_req = FALSE){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Usuarios_model");

		$id_area_cargo = $this->Requerimiento_asc_trabajadores_model->get($asc_area)->requerimiento_area_cargo_id;

		if (empty($_POST['datos_extras'])){
			$vienen_datos = "NO";
		}else{
			$vienen_datos = "SI";
		}

		if(empty($_POST['ano_fi']) || empty($_POST['mes_fi']) || empty($_POST['dia_fi']) )
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['ano_fi'].'-'.$_POST['mes_fi'].'-'.$_POST['dia_fi'];

		if(empty($_POST['ano_ft']) || empty($_POST['mes_ft']) || empty($_POST['dia_ft']) )
			$fecha_termino = '0000-00-00';
		else
			$fecha_termino = $_POST['ano_ft'].'-'.$_POST['mes_ft'].'-'.$_POST['dia_ft'];

		if($vienen_datos == "SI"){
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo,
				'causal' => $_POST['causal'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha_inicio,
				'fecha_termino' => $fecha_termino,
				'jornada' => $_POST['jornada'],
				'renta_imponible' => $_POST['renta_imponible'],
				'bono_responsabilidad' => $_POST['bono_responsabilidad'],
				'bono_gestion' => $_POST['bono_gestion'],
				'bono_confianza' => $_POST['bono_confianza'],
				'asignacion_movilizacion' => $_POST['asignacion_movilizacion'],
				'asignacion_colacion' => $_POST['asignacion_colacion'],
				'asignacion_zona' => $_POST['asignacion_zona'],
				'viatico' => $_POST['viatico'],
				'seguro_vida_arauco' => 'SI'
			);
		}else{
			$data = array(
				'usuario_id' => $usuario,
				'requerimiento_asc_trabajadores_id' => $asc_area,
				'tipo_archivo_requerimiento_id' => $tipo
			);
		}


		/*$si_existe = $this->Requerimiento_Usuario_Archivo_model->consultar_si_existe_req($usuario, $asc_area, $tipo);
		if($si_existe == 1){
			$this->Requerimiento_Usuario_Archivo_model->actualizar_req($usuario, $asc_area, $tipo, $data);
			redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
		}elseif($si_existe == 0){*/
			$this->Requerimiento_Usuario_Archivo_model->ingresar($data);
			redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
		/*}else{
			redirect('est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
		}*/
	}

	function guardar_fecha(){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->library('session');

		$arreglo = array(
			$_POST['name'] => $_POST['value'],
			'quien' => $this->session->userdata('id'),
			'actualizacion' => date("Y-m-d h:i:s")
		);
		$this->Requerimiento_asc_trabajadores_model->editar($_POST['pk'], $arreglo );
	}

	function revisar_cambios(){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		if( $this->Requerimiento_asc_trabajadores_model->consultar_actualizacion($this->session->userdata('id'),$this->fecha_actual) )
			print_r($this->Requerimiento_asc_trabajadores_model->consultar_actualizacion($this->session->userdata('id'),$this->fecha_actual));
	}
	
	function modal_comentario($id){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$base['id'] = $id;
		$base['comentario'] = ($this->Requerimiento_asc_trabajadores_model->get($id)->comentario)?$this->Requerimiento_asc_trabajadores_model->get($id)->comentario:'';
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model("Requerimiento_asc_trabajadores_model");

			$data = array('comentario' => $_POST['comentario']);
			$this->Requerimiento_asc_trabajadores_model->editar($id,$data);
		} 
		else
			$this ->load->view('requerimiento/modal_comentario',$base);
	}

	function editar_usuarios_req(){
		$this->load->model("Requerimiento_asc_trabajadores_model");

		$data = json_decode($_POST['json']);
		foreach ($data as $k => $v){
			if ($k == 'id') $id = $v;
			if( $k == 'referido') $referido = $v;
			if( $k == 'contacto' ) $contacto = $v;
			if( $k == 'disponibilidad' ) $disponibilidad = $v;
			if( $k == 'contrato' ) $contrato = $v;
			if( $k == 'status' ) $status = $v;
		}
		$salida = array( 
			'referido' => $referido,
			'contacto' => $contacto,
			'disponibilidad' => $disponibilidad,
			'contrato' => $contrato,
			'status' => $status
		);
		$this->Requerimiento_asc_trabajadores_model->editar($id,$salida);
	}

	function eliminar_usuarios_req($id,$area_cargo){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->Requerimiento_asc_trabajadores_model->eliminar($id);
		redirect('/est/requerimiento/usuarios_requerimiento/'.$area_cargo, 'refresh');
	}

	function eliminar_usuarios_general_req($id,$id_req){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->Requerimiento_asc_trabajadores_model->eliminar($id);
		redirect('/est/requerimiento/usuarios_general_requerimiento/'.$id_req, 'refresh');
	}

	function obtener_planta_ajax(){
		$id = $_POST['id'];
		$this->load->model("Planta_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Grupo_model");

		$listado_planta = $this->Planta_model->get_empresa($id);
		$listado_areas = $this->Areas_model->listar_empresa($id);
		$listado_cargos = $this->Cargos_model->listar_empresa($id);
		$listado_grupos = $this->Grupo_model->listar_empresa($id);

		$l['areas'] = array();
		$l['cargos'] = array();
		$l['plantas'] = array();
		$l['grupos'] = array();

		if (!empty($listado_planta)) {
			foreach ($listado_planta as $lp) {
				$aux_l = array( 
					"id" => $lp->id,
					"nombre" => $lp->nombre
				);
				$l['plantas'][] = $aux_l;
			}
		}
		if (!empty($listado_areas)) {
			foreach ($listado_areas as $la) {
				$aux_l = array( 
					"id" => $la->id,
					"nombre" => $la->desc_area
				);
				$l['areas'][] = $aux_l;
			}
		}
		if (!empty($listado_cargos)) {
			foreach ($listado_cargos as $lc) {
				$aux_l = array( 
					"id" => $lc->id,
					"nombre" => $lc->desc_cargo
				);
				$l['cargos'][] = $aux_l;
			}
		}

		if (!empty($listado_grupos)) {
			foreach ($listado_grupos as $lg) {
				$aux_l = array( 
					"id" => $lg->id,
					"nombre" => $lg->nombre
				);
				$l['grupos'][] = $aux_l;
			}
		}

		echo json_encode($l);
	}

	function resto_planta_ajax(){
		$id = $_POST['id'];
		$this->load->model("Grupo_model");
		$listado_grupo = $this->Grupo_model->listar_planta($id);
		$l['grupo'] = array();
		if (!empty($listado_grupo)) {
			foreach ($listado_grupo as $lg) {
				$aux_l = array(
					"id" => $lg->id,
					"nombre" => $lg->nombre
				);
				$l['grupo'][] = $aux_l;
			}
		}
		echo json_encode($l);
	}

	function guardar(){
		if( empty($_POST['select_empresa']) || empty($_POST['select_area']) || empty($_POST['select_cargo']) || empty($_POST['cantidad']) ){
			redirect('/administracion/requerimiento/agregar', 'refresh');
		}
		else{
			$this->load->model("Requerimientos_model");

			$f_sol = explode('-', $_POST['f_solicitud']);
			if ($_POST['fdesde']){
				$f_ini = explode('-', $_POST['fdesde']);
				$f_ini = $f_ini[2].'-'.$f_ini[1].'-'.$f_ini[0];
			}
			else
				$f_ini = false;
			if( $_POST['fhasta'] ){
				$f_fin = explode('-', $_POST['fhasta']);
				$f_fin = $f_fin[2].'-'.$f_fin[1].'-'.$f_fin[0];
			}
			else
				$f_fin = false;
			
			if ( $_POST['causal'])
				$causal = mb_strtoupper(trim($_POST['causal']), 'UTF-8');
			else
				$causal = false;

			if ( $_POST['motivo'])
				$motivo = mb_strtoupper(trim($_POST['motivo']), 'UTF-8');
			else
				$motivo = false;
			$data_base = array(
				'f_solicitud' => $f_sol[2].'-'.$f_sol[1].'-'.$f_sol[0],
				'empresa_id' => $_POST['select_empresa'],
				'cargo_id' => $_POST['select_cargo'],
				'area_id' => $_POST['select_area'],
				'cantidad' => trim($_POST['cantidad']),
				'f_inicio' => $f_ini,
				'f_fin' => $f_fin,
				'causal' => $causal,
				'motivo' => $motivo,
				'comentario' => trim($_POST['comentarios']),
			);
			$this->Requerimientos_model->ingresar($data_base);
			redirect('/administracion/requerimiento/nuevos', 'refresh');
		}
	}
	
	function nuevos(){
		$base['titulo'] = "Nuevos requerimientos";
		$base['lugar'] = "Requerimientos";
		$this->load->model("Usuarios_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Grupo_model");
		$this->load->model("Areas_model");
		$this->load->model("Asignarrequerimiento_model");
		$this->load->model("Requerimiento_representante_model");
		
		$this->session->unset_userdata('requerimiento');
		$this->session->unset_userdata('usuarios_finalizados');
		
		$listado = array();
		
		/*foreach($this->Requerimiento_model->nuevos() as $r ){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->id_usuarios);
			$aux->id = $r->id;
			$aux->empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->razon_social;
			$aux->id_empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->id;
			$aux->de = $usr->nombres." ".$usr->paterno." ".$usr->materno;
			$aux->id_de = $usr->id;
			$aux->nombre = $r->nombre;
			$aux->lugar = $r->lugar_trabajo;
			$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}*/

		foreach($this->Requerimientos_model->listar(@$_GET['planta'],@$_GET['grupo']) as $r ){
			$aux = new stdClass();
			$s = $this->Requerimiento_representante_model->get($r->id_solicitante);
			$aux->id = $r->id_req;
			$aux->planta = $this->Planta_model->get($this->Grupo_model->get($r->id_grupo)->id_planta)->nombre;
			$aux->f_solicitud = $r->f_solicitud;
			$aux->f_inicio = $r->f_inicio;
			$aux->f_termino = $r->f_fin;
			$aux->causal = $r->causal;
			$aux->motivo = $r->motivo;
			$aux->cargo = $this->Cargos_model->get_empresa($r->id_cargo)->desc_cargo;
			$aux->area = $this->Areas_model->get_empresa($r->id_area)->desc_area;
			$aux->grupo = $this->Grupo_model->get($r->id_grupo)->nombre;
			$aux->motivo = $r->motivo;
			$aux->cantidad = $r->cantidad;
			$aux->agregados = $this->Asignarrequerimiento_model->contar($r->id_req);
			$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
			$aux->solicitante = (empty($s)) ? ' - ' : $s->nombre;
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}
		$pagina['requerimientos'] = $listado;
		$pagina['l_grupos'] = $this->Grupo_model->listar();
		$pagina['l_plantas'] = $this->Planta_model->listar();
		$pagina['s_planta'] = @$_GET['planta'];
		$pagina['s_grupo'] = @$_GET['grupo'];
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function ajax_grupos_planta($id){
		$this->load->model("Grupo_model");
		$salida = $this->Grupo_model->listar_planta($id);
		echo  json_encode($salida);
	}

	function usr_asignados($id){
		$base['titulo'] = "Usuarios Asignados a Requerimiento";
		$base['lugar'] = "Usuarios Asignados";
		$this->load->model("Requerimiento_representante_model");
		$this->load->model("Asignarrequerimiento_model");
		$this->load->model("Requerimiento_origen_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Cargos_model");
		$this->load->model("Areas_model");
		$listado = array();
		foreach($this->Asignarrequerimiento_model->listar_req($id) as $r ){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->id_usuarios);
			$d_req = $this->Requerimientos_model->get($id);
			$cargo = $this->Cargos_model->get_empresa($d_req->id_cargo);
			$area = $this->Areas_model->get_empresa($d_req->id_area);
			$m = $this->Evaluaciones_model->get_una_masso($r->id_usuarios);
			$p = $this->Evaluaciones_model->get_una_preocupacional($r->id_usuarios);
			$aux->id = $r->id;
			$aux->id_usr = $usr->id;
			$aux->rut = $usr->rut_usuario;
			$aux->nombre = $usr->nombres;
			$aux->paterno = $usr->paterno;
			$aux->materno = $usr->materno;
			$aux->cargo = $cargo->desc_cargo;
			$aux->area = $area->desc_area;
			$aux->fono = $usr->fono;
			if($r->f_inicio){
				$fi = explode('-',$r->f_inicio);
				$fi = $fi[2].'-'.$fi[1].'-'.$fi[0];
			}
			else $fi = "00-00-0000";
			$aux->f_inicio = $fi;
			if($r->f_fin){
				$ff = explode('-',$r->f_fin);
				$ff = $ff[2].'-'.$ff[1].'-'.$ff[0];
			}
			else $ff = "00-00-0000";
			$aux->f_fin = $ff;
			$aux->origen = $this->Requerimiento_origen_model->get($r->id_requerimiento_origen)->name;
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

			array_push($listado,$aux);
			unset($aux,$usr);
		}
		$dt_planta = $this->Requerimientos_model->get_planta($id);
		$pagina['datos_req']['planta'] = ucfirst(strtolower($dt_planta->nombre_planta));
		$pagina['datos_req']['ca'] = ucfirst(strtolower($dt_planta->desc_cargo))." - ".ucfirst(strtolower($dt_planta->desc_area));
		$pagina['datos_req']['desde'] = $dt_planta->f_inicio;
		$pagina['datos_req']['hasta'] = $dt_planta->f_fin;
		$pagina['listado'] = $listado;
		$s = $this->Requerimiento_representante_model->get_id_req($id);
		$pagina['solicitante'] = (empty($s)) ? ' - ' : $s->nombre;
		$pagina['id_req'] = $id;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/usr_asignados',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function editar_fecha(){
		$this->load->model("Asignarrequerimiento_model");

		/*$fecha = explode("-",$_POST['value']);
		echo $_POST['value'];
		
		$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];*/
		$fecha = $_POST['value'];
		$id = $_POST['pk'];
		$campo = $_POST['name'];

		$data = array(
			$campo => $fecha
		);

		$this->Asignarrequerimiento_model->actualizar($data,$id);


	}

	function activos(){
		$base['titulo'] = "Requerimientos activos";
		$base['lugar'] = "Requerimientos Activos";
		$this->load->model("Usuarios_model");
		$this->load->model("Empresas_model");
		
		$this->session->unset_userdata('requerimiento');
		$this->session->unset_userdata('usuarios_finalizados');
		
		$listado = array();
		foreach($this->Requerimiento_model->activos2() as $r ){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->id_usuarios);
			$aux->id = $r->id;
			$aux->empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->razon_social;
			$aux->id_empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->id;
			$aux->de = $usr->nombres." ".$usr->paterno." ".$usr->materno;
			$aux->id_de = $usr->id;
			$aux->nombre = $r->nombre;
			$aux->lugar = $r->lugar_trabajo;
			$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}
		$pagina['requerimientos'] = $listado;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function historial(){
		$base['titulo'] = "Historial Requerimientos";
		$base['lugar'] = "Historial de Requerimientos";
		$this->load->model("Usuarios_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");

		$this->session->unset_userdata('requerimiento');
		$this->session->unset_userdata('usuarios_finalizados');
		

		$listado = array();
		foreach($this->Requerimiento_model->historial2() as $r ){
			$aux = new stdClass();
			$usr = $this->Usuarios_model->get($r->id_usuarios);
			$aux->id = $r->id;
			$aux->empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->razon_social;
			$aux->id_empresa = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->id;
			$aux->de = $usr->nombres." ".$usr->paterno." ".$usr->materno;
			$aux->id_de = $usr->id;
			$aux->nombre = $r->nombre;
			$aux->lugar = $r->lugar_trabajo;
			$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}
		$pagina['requerimientos'] = $listado;

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function editar($id = false,$msg = false){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		
		$this->load->model("Areas_model");
		$this->load->model("Centrocostos_model");
		$this->load->model("Cargos_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Requerimiento_cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->model("Usuarios_model");
		$base['titulo'] = "Edición de requerimiento";
		$base['lugar'] = "Editar requerimiento";
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		if($msg == "error_incompleto"){
			$aviso['titulo'] = "Ocurrio un error, uno o mas datos obligatorios se encontraron vacios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error"){
			$aviso['titulo'] = "Ocurrio un error, favor ingresar los datos nuevamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se editó el requerimiento correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "contiene"){
			$aviso['titulo'] = "Este requerimiento, ya contiene trabajadores asignados";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		//$retorno = modules::run('/mandante/requerimiento/editar', 'WzALPQ%3D%3D' ); //cambiar
		//echo $retorno;
		//$this -> load -> view($retorno);
		$pagina['editar'] = TRUE;
		$pagina['id_req'] = $id;
		$pagina['datos'] = $this->Requerimiento_model->get($id);
		//$pagina['subreq'] = $this->Requerimiento_model->listar_req($id);
		$pagina['subreq'] = $this->Requerimiento_areas_model->get_requerimiento($id); //obtiene el area
		
		//$id_planta = $this->Usuarios_model->get($pagina['subreq'][0]->id_usuarios)->id_planta; 
		$id_planta = $pagina['datos']->id_planta;
		$pagina['listado_areas'] = $this->Areas_model->listar_planta($id_planta);
		$pagina['listado_cargos'] = $this->Cargos_model->listar_planta($id_planta);
		$pagina['listado_cc'] = $this->Centrocostos_model->listar_planta($id_planta);
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		//echo Modules::run('/mandante/requerimientos/crear_requerimiento', $pagina,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/crear_requerimiento',$pagina,TRUE);
		$this->load->view('layout',$base);
		
	}

	function editando($id){
		if( empty($_POST['select_area']) || empty($_POST['select_cargo']) || empty($_POST['cantidad']) || 
		empty($_POST['fdesde']) || $_POST['fdesde'] == "Desde" || empty($_POST['fhasta']) || 
		$_POST['fhasta'] == "Hasta" || empty($_POST['nombre']) || empty($_POST['lugar']) ){ 
			redirect('est/requerimiento/editar/'.$id.'/error_vacio', 'refresh');
		}
		else{
			$valido = TRUE;
			$this->db->trans_begin();
			$this->load->model("Requerimiento_model");
			$this->load->model("Requerimiento_areas_model");
			$this->load->model("Requerimiento_cargos_model");
			$this->load->model("Requerimiento_trabajador_model");
			$this->load->model("Planta_model");
			$this->load->model("Usuarios_model");
			$this->load->model("Empresas_model");
			$this->load->helper("fechas");
			//print_r($_POST['select_area']);echo "<br/>";
			
			if( count($_POST['select_area']) > 0 ){
				//$this->Requerimiento_areas_model->eliminar_requerimiento($id);
				if(empty($_POST['nombre']) || empty($_POST['lugar']) ){
					$valido = FALSE;
					break;
				}
				$data_base = array(
					'nombre' => mb_strtoupper($_POST['nombre'], 'UTF-8'),
					//'id_usuarios' => $this -> session -> userdata('id'),
					//'id_planta' => $this->Usuarios_model->get($this->session->userdata('id'))->id_planta,
					'lugar_trabajo' => mb_strtoupper($_POST['lugar'], 'UTF-8'),
					'comentario' => $_POST['texto']
				);
				//print_r($data_base);echo "<br/>";
				$this->Requerimiento_model->editar($id,$data_base); //editar datos basicos del requerimiento
				
				for($i = 0; $i < count($_POST['select_area']);$i++){ //recorrer la cantidad de areas agregadas
					//$lista_id_ara = array();
					$id_area = $_POST['select_area'][$i];
					$area_antigua = empty($_POST['area_antigua'][$i])? NULL : $_POST['area_antigua'][$i];
					if(empty($id_area)){ //si hay un area agregada que no tenga un valor en ella, se sale del cilco y $valido cambia a false.
						$valido = FALSE;
						break;
					}
					// $area_contiene_trabajadores = $this->Requerimiento_areas_model->get_area($_POST['area_antigua'][$i],$id); //
					// if( count($area_contiene_trabajadores) > 0){
						// $contiene = TRUE;
						// break;
					// }
					//else{
					if($area_antigua){
						//echo "entra al update del area <br/>";
						$data_area = array(
							'id_areas' => $id_area
						);
						$id_requerimiento_area = $this->Requerimiento_areas_model->editar($area_antigua,$data_area);
					}
					else{
						//echo "entra al insert del area <br/>";
						$data_area = array(
								'id_areas' => $id_area,
								'id_requerimiento' => $id
							);
							$id_requerimiento_area = $this->Requerimiento_areas_model->ingresar($data_area);
					}
					$lista_id_area[] = $id_requerimiento_area;
					// echo $id_requerimiento_area;
						// $req_anterior = $this->Requerimiento_areas_model->get_validar($id_area,$id); 
						// if( count($req_anterior) > 0 ){
							// $data_area = array(
								// 'id_areas' => $id_area
							// );
							// $id_requerimiento_area = $this->Requerimiento_areas_model->editar($_POST['area_antigua'],$data_area);
						// }
						//else{
							// $data_area = array(
								// 'id_areas' => $id_area,
								// 'id_requerimiento' => $id
							// );
							// $id_requerimiento_area = $this->Requerimiento_areas_model->ingresar($data_area);
						//z}
						// $data_area = array(
							// 'id_areas' => $id_area,
							// 'id_requerimiento' => $id
						// );
						// //print_r($data_area);echo "<br/>";
						// $id_requerimiento_area = $this->Requerimiento_areas_model->ingresar($data_area);
						if( count($_POST['select_cargo']) > 0 ){
							//$lista_id_cargo = array();
							for( $x = 0; $x < count( $_POST['select_cargo'][$id_area]); $x++ ){
								$id_cargo = $_POST['select_cargo'][$id_area][$x];
								$especialidad = empty($_POST['select_especialidad'][$id_area][$x])? NULL : $_POST['select_especialidad'][$id_area][$x];
								$id_especialidad = (empty($_POST['select_especialidad'][$id_area][$x]))? '0' : $_POST['select_especialidad'][$id_area][$x];
								$pk_cargo = empty($_POST['cargo_antiguo'][$id_area][$x])? NULL : $_POST['cargo_antiguo'][$id_area][$x];
								//echo "id_especialidad " .$id_especialidad ."<br />";
								//echo $pk_cargo;
								if(empty($id_cargo)){
									$valido = FALSE;
									break;
								}
								if(count($pk_cargo) > 0){
									//echo "entra al update del cargo <br/>";
									$data_cargo = array(
										'id_requerimiento_areas' => $id_requerimiento_area,
										'id_cargos' => $id_cargo,
									);
									//print_r($data_cargo);echo "<br/>";
									$id_requerimiento_cargo = $this->Requerimiento_cargos_model->editar($pk_cargo,$data_cargo);
								}
								else{
									//echo "entra al insert del cargo <br/>";
									$data_cargo = array(
										'id_requerimiento_areas' => $id_requerimiento_area,
										'id_cargos' => $id_cargo,
										'id_especialidad' => $especialidad
									);
									//print_r($data_cargo);echo "<br/>";
									$id_requerimiento_cargo = $this->Requerimiento_cargos_model->ingresar($data_cargo);
								}
								$lista_id_cargo[] = $id_requerimiento_cargo;
								$comparar = array(
									count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ),
									count( $_POST['fdesde'][$id_area][$id_cargo][$id_especialidad]),
									count( $_POST['fhasta'][$id_area][$id_cargo][$id_especialidad]),
								);
								//print_r($comparar);echo "<br/>";
								if(count(array_unique($comparar)) == 1) {
									//$lista_id_rt = array();
									//echo "numero cantidades --> ".count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ). "<br />";
									//echo "<br/>".count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad])."<br />";
									for( $z = 0; $z < count( $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad] ); $z++ ){
										$cantidad = $_POST['cantidad'][$id_area][$id_cargo][$id_especialidad][$z];
										$finicio = $_POST['fdesde'][$id_area][$id_cargo][$id_especialidad][$z];
										$ftermino = $_POST['fhasta'][$id_area][$id_cargo][$id_especialidad][$z];
										$centro_costo = empty( $_POST['select_cc'][$id_area][$id_cargo][$id_especialidad][$z] )? NULL : $_POST['select_cc'][$id_area][$id_cargo][$id_especialidad][$z];
										$pk_rt = empty( $_POST['antiguo_rt'][$id_area][$id_cargo][$id_especialidad][$z] )? NULL : $_POST['antiguo_rt'][$id_area][$id_cargo][$id_especialidad][$z];
										//echo "valor rt antiguo--> ".$pk_rt."<br/>";
										if(empty($cantidad)){
											$valido = FALSE;
											break;
										}
										if(empty($finicio)){
											$valido = FALSE;
											break;
										}
										if(empty($ftermino)){
											$valido = FALSE;
											break;
										}
										
										$fecha_inicio = explode(" ", $finicio);
										$fecha_termino = explode(" ", $ftermino);
										if( count($pk_rt) > 0){
											//echo "<br /> entra al update del RT <br />";
											$data_trabajador = array(
												'id_centrocosto' => $centro_costo,
												'fecha_inicio' => $fecha_inicio[2].'-'.mesXdia($fecha_inicio[1]).'-'.$fecha_inicio[0],
												'fecha_termino' => $fecha_termino[2].'-'.mesXdia($fecha_termino[1]).'-'.$fecha_termino[0],
												'cantidad' => $cantidad
											);
											//print_r($data_trabajador);echo "<br/>";
											$id_rt = $this->Requerimiento_trabajador_model->editar($pk_rt,$data_trabajador);
										}
										else{
											//echo "<br /> entra al insert del RT <br />";
											$data_trabajador = array(
												'id_requerimiento_cargos' => $id_requerimiento_cargo,
												'id_centrocosto' => $centro_costo,
												'fecha_inicio' => $fecha_inicio[2].'-'.mesXdia($fecha_inicio[1]).'-'.$fecha_inicio[0],
												'fecha_termino' => $fecha_termino[2].'-'.mesXdia($fecha_termino[1]).'-'.$fecha_termino[0],
												'cantidad' => $cantidad
											);
											//print_r($data_trabajador);echo "<br/>";
											$id_rt = $this->Requerimiento_trabajador_model->ingresar($data_trabajador);
										}
										//$lista_id_rt[] = $id_rt; 
										//echo "rtid --> ".$id_rt."<br/>";
										$lista_id_rt[] = $id_rt ;
									}
								} else {
									$valido = FALSE;
									break;
								} 
							}
						}
						else{
							$valido = FALSE;
							break;
						}
					}
					
				//}
			}
			else{
				$valido = FALSE;
			}
			
			if(@$contiene){
				redirect('administracion/requerimiento/editar/'.$id.'/contiene', 'refresh');
			}
			if( $valido == FALSE){
				$this->db->trans_rollback();
				redirect('administracion/requerimiento/editar/'.$id.'/error_incompleto', 'refresh');
			}
			else{
				foreach($this->Requerimiento_trabajador_model->get_requerimiento($id) as $r){
					if (!in_array($r->trabajador_id, $lista_id_rt)) {
					    $this->Requerimiento_trabajador_model->eliminar($r->trabajador_id);
					}	
				}
				foreach($this->Requerimiento_cargos_model->get_requerimiento($id) as $c){
					if (!in_array($c->cargo_id, $lista_id_cargo)) {
					    $this->Requerimiento_cargos_model->eliminar($c->cargo_id);
					}
				}
				foreach($this->Requerimiento_areas_model->get_requerimiento($id) as $a){
					if (!in_array($a->id, $lista_id_area)) {
					    $this->Requerimiento_areas_model->eliminar($a->id);
					}
				}
				$this->db->trans_commit();
				redirect('administracion/requerimiento/editar/'.$id.'/exito', 'refresh');
			}
		}
	}

	function detalles($id = FALSE,$msg = FALSE){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Requerimiento_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');
		$this->session->unset_userdata('requerimiento');
		$this->session->unset_userdata('usuarios_finalizados');
		$this->session->unset_userdata('reemplazo');
		$this->session->unset_userdata('reemplazo_final');
		$this->session->unset_userdata('aux_reemplazo');
		
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		$this->load->model("Usuarios_model");
		$this->load->model("Areas_model");
		$this->load->model("Centrocostos_model");
		$this->load->model("Cargos_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");
		$this->load->model("Requerimiento_areas_model");
		$this->load->model("Requerimiento_cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		
		$base['titulo'] = "Detalle de requerimiento";
		$base['lugar'] = "Requerimientos";
		
		$arr_url = $this->uri->uri_to_assoc(5);
		//$this->Requerimiento_model->editar($id,array('flag_leido' => 1)); //marcar como leido
		$r = $this->Requerimiento_model->get($id);
		$de = $this->Usuarios_model->get($r->id_usuarios);
		$aux = new stdClass();
		$aux->nombre = $r->nombre;
		$aux->de = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->razon_social;
		$aux->id_de = $this->Empresas_model->get($this->Planta_model->get($r->id_planta)->id_empresa)->id;
		$aux->creador = $de->nombres." ".$de->paterno." ".$de->materno;
		$aux->id_creador = $de->id;
		$aux->lugar = $r->lugar_trabajo;
		$aux->id_req = $r->id;
		$aux->comentario = (empty($r->comentario)) ? 'Sin comentario' : $r->comentario;
		$listado = array();
		//foreach($this->Requerimiento_model->get_prin_req($r->id) as $dr){
		foreach($this->Requerimiento_trabajador_model->get_requerimiento($r->id) as $dr){
			$aux2 = new stdClass();
			if(isset($arr_url['req'])){
				if($arr_url['req'] == $dr->id){
					$activo = TRUE;
				}
				else $activo=FALSE;
			}
			else $activo=FALSE;
				
			$aux2->id = $dr->id;
			$aux2->activo = $activo;
			$aux2->areas = ucwords(mb_strtolower($this->Areas_model->get($dr->id_areas)->desc_area,'UTF-8'));
			$aux2->cargos = ucwords(mb_strtolower($this->Cargos_model->get($dr->id_cargos)->desc_cargo,'UTF-8'));
			$aux2->cc = (empty($dr->id_centrocosto))? '' : ucwords(mb_strtolower($this->Centrocostos_model->get($dr->id_centrocosto)->desc_centrocosto,'UTF-8'));
			if($dr->id_especialidad)
				$aux2->especialidad = ucwords(mb_strtolower($this->Especialidadtrabajador_model->get($dr->id_especialidad)->desc_especialidad,'UTF-8'));
			else
				$aux2->especialidad = '';
			$f_i = explode("-",$dr->fecha_inicio);
			$f_t = explode("-",$dr->fecha_termino);
			$aux2->f_inicio = $f_i[2].'-'.$f_i[1]."-".$f_i[0];
			$aux2->f_termino = $f_t[2].'-'.$f_t[1]."-".$f_t[0];
			$aux2->cantidad = $dr->cantidad;
			$aux2->cantidad_ok = $dr->cantidad_ok;
			$aux2->estado = $this->Requerimiento_model->get_estado($dr->id_estado)->nombre;
			array_push($listado,$aux2);
			unset($aux2,$f_i,$f_t);
		}
		$aux->detalle = $listado;
		
		if($msg == "exito"){
			$aviso['titulo'] = "Se a asignado los trabajadores exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		$pagina['requerimiento'] = $aux;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/detalle',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function asignar($id=false){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		$id = base64_decode(urldecode($id));
		$this->load->model("Requerimiento_trabajador_model");
		//$req = $this->Requerimiento_model->get_req($id);
		$req = $this->Requerimiento_trabajador_model->get_trabajador($id);
		
		if(count($req) < 1)
			redirect('/error/error404', 'refresh');
		
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Fotostrab_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Reemplazos_requerimiento_model");
		$this->load->library('pagination');
		
		$base['titulo'] = "Asignacion de requerimiento";
		$base['lugar'] = "Requerimientos";
		
		$lista = array();
		
		$url_pag = $this->uri->uri_to_assoc(5);
		if($this->uri->segment(5) === FALSE)
			$paginado = 1;
		else{
			$paginado = (empty($url_pag['pagina'])) ? 1 : $url_pag['pagina'];
			$url_encript = $this->uri->uri_to_assoc(5);
		}
		
		$config['per_page'] = 15;
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
		if(!empty($url_encript['filtro'])){ //si existe el filtro entonces........
			$filtro = base64_decode( urldecode($url_encript['filtro']));
			$fil = explode("/",$filtro);
			$asociacion = array();
			$aux = array(
				$fil[0] => $fil[1],
				$fil[2] => $fil[3],
				$fil[4] => $fil[5],
				$fil[6] => $fil[7],
				$fil[8] => $fil[9],
				$fil[10] => $fil[11]
			 );
			array_push($asociacion,$aux);
			unset($aux);
			
			if($asociacion[0]['nombre'] === 0) $asociacion[0]['nombre'] = FALSE;
			if($asociacion[0]['rut'] == 0) $asociacion[0]['rut'] = FALSE;
			if($asociacion[0]['profesion'] == 0) $asociacion[0]['profesion'] = FALSE;
			if($asociacion[0]['especialidad'] == 0) $asociacion[0]['especialidad'] = FALSE;
			if($asociacion[0]['ciudad'] == 0) $asociacion[0]['ciudad'] = FALSE;
			if($asociacion[0]['estado'] == 0) $asociacion[0]['estado'] = FALSE;
			$config['base_url'] = base_url().'/administracion/requerimiento/asignar/'.$this->uri->segment(4)."/filtro/".$url_encript['filtro']."/pagina/";
			$config['total_rows'] = $this->Usuarios_model->total_filtro($asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['profesion'],$asociacion[0]['especialidad'],$asociacion[0]['ciudad'],false,$asociacion[0]['estado']);
			$config['uri_segment'] = 8;
		}
		else{ // si no existe el filtro entoncess...........
			$config['base_url'] = base_url().'/administracion/requerimiento/asignar/'.$this->uri->segment(4)."/pagina/";
			$config['total_rows'] = $this->db->where('id_tipo_usuarios',2)->get('usuarios')->num_rows();
			$asociacion[0]['nombre'] = FALSE;
			$asociacion[0]['rut'] = FALSE;
			$asociacion[0]['profesion'] = FALSE;
			$asociacion[0]['especialidad'] = FALSE;
			$asociacion[0]['ciudad'] = FALSE;
			$asociacion[0]['estado'] = FALSE;
			$config['uri_segment'] = 6;
		}
		
		if($config['total_rows'] <= $config['per_page'] ){
			$config['total_rows'] = FALSE;
			$paginado = FALSE;
		}
		$this->pagination->initialize($config);
		//echo $config['total_rows'];
		//print_r($asociacion);
		
		//si la session de requerimiento no se a inicializado o esta vacia, se llana con los usuarios de bd del requerimiento
		if( (is_bool($this->session->userdata("requerimiento") )) || (count($this->session->userdata("requerimiento")) < 1 ) ){
			foreach($this->Usuarios_model->listar_id() as $u){
				if($asigna_req = $this->Requerimiento_model->get_trabajador_req($u->id,$id)){ //lleno la session de requerimiento, si existen asignados por BD
					$ses[] = $u->id;
					foreach($asigna_req as $ar){
						$id_asigna_req[] = $ar->id; 
					}
					$this->session->set_userdata("requerimiento",$ses);
					$this->session->set_userdata("aux_reemplazo",$id_asigna_req);
				}
			}
		}
		//si los reemplazantes estan vacios, se llena la session
		if( (is_bool($this->session->userdata("reemplazo_final") )) || (count($this->session->userdata("reemplazo_final")) < 1 ) ){
			$req_aux = array();
			foreach($this->Reemplazos_requerimiento_model->listar_asigna_requerimiento($id) as $r){
				$req_aux[] = array(
					'usuario' => $r->ar_usuarios,
					'sub_req' => $r->id_requerimientotrabajador,
					'reemplazo' => array(
						'usuario_r' => $r->rr_usuarios,
						'motivo' => $r->id_motivos_falta,
						'observacion' => $r->observacion
					)
				);
			}
			$this->session->set_userdata("reemplazo_final",$req_aux);
		}
		
		foreach($this->Usuarios_model->listar_filtro($asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['profesion'],$asociacion[0]['especialidad'],$asociacion[0]['ciudad'],false,$asociacion[0]['estado'],$config['per_page'],$paginado) as $t){
			$aux = new stdClass();
			$foto = $this->Fotostrab_model->get_usuario($t->id);
			$check = FALSE;
			$otro_req = FALSE;
			$id_otro_req = FALSE;
			$reemplazado = FALSE;
			if(!is_bool($this->session->userdata("requerimiento"))){
				foreach($this->session->userdata("requerimiento") as $r=>$k){
					if($t->id == $k){
						$check = TRUE;
					}
				}
			}
			//aux_reemplazo, contiene las id de la tabla asigna requerimiento, de los usuarios de la session "requerimiento"
			//se recorre la session con los que esten en la table reemplazos_requerimiento, si existen entonces el trabajador de
			//"requerimiento" fue reemplazado
			if(!is_bool($this->session->userdata("aux_reemplazo"))){ 
				foreach($this->session->userdata("aux_reemplazo") as $iar){
					if( count($s = $this->Reemplazos_requerimiento_model->listar_requerimiento($iar)) > 0){
						if($s->id_usuarios == $t->id){
							$check = TRUE;
						}
						if($this->Requerimiento_model->get_asigna_req($iar)->id == $s->id_asigna_requerimiento){
							if($this->Requerimiento_model->get_asigna_req($iar)->id_usuarios == $t->id){
								$reemplazado = TRUE;
								$check = FALSE;
							}
						}
					}
				}
			}
			/******/
			
			if(!is_bool($this->session->userdata("reemplazo_final"))){ //se agregan clases si se llenan usuarios de reemplazo
				$session_reemplazo = $this->session->userdata('reemplazo_final');
				for($z=0;$z < count($session_reemplazo); $z++){
					if($session_reemplazo[$z]['usuario'] == $t->id){
						$reemplazado = TRUE;
						$check = FALSE;
					} 
					if($session_reemplazo[$z]['reemplazo']['usuario_r'] == $t->id){
						$check = TRUE;
					}
				}
			}
			// if($this->Requerimiento_model->get_trabajador_otroreq($t->id,$id)){//verificar si existe en otro requerimiento
				// $otro_req = TRUE;
				// $id_otro_req = $this->Requerimiento_model->get_trabajador_otroreq($t->id,$id)->id_requerimientotrabajador;
			// }
			// echo $t->id."<br/>";
			// echo "id-->".$id."<br/>";
			//print_r($req);
			// echo "fecha_inicio-->".$req[0]->fecha_inicio."<br/>";
			if($this->Asignarequerimiento_model->get_actual($t->id,$id,$req->fecha_inicio)){//verificar si existe en otro requerimiento
				$otro_req = TRUE;
				$id_otro_req = $this->Asignarequerimiento_model->get_actual($t->id,$id,$req->fecha_inicio)->id_requerimientotrabajador;
				$id_otro_req_padre = $this->Requerimiento_model->get_req($id_otro_req);
			}
			
			
			$aux->id = $t->id;
			$aux->check = $check;
			$aux->otro_req = $otro_req;
			$aux->id_otro_req = $id_otro_req;//el id del otro requerimiento
			@$aux->id_otro_req_padre = $id_otro_req_padre->id_requerimiento; //id del requerimiento padre
			$aux->nombres =  $t->nombres;
			$aux->paterno = $t->paterno;
			$aux->materno = $t->materno;
			$aux->rut = $t->rut_usuario;
			$aux->reemplazado = $reemplazado;
			$aux->foto = (count($foto)< 1) ? 'extras/img/perfil/requerimiento/avatar.jpg' : $foto->media;
			array_push($lista,$aux);
			unset($aux);
		}
		//print_r($this->session->userdata("requerimiento"));
		if( is_bool( $this->session->userdata("requerimiento") ) )
			$asignados = '0';
		else
			$asignados = count($this->session->userdata("requerimiento"));
		
		$pagina['asignados'] = $asignados;
		
		//mantener el filtro en el html cuando recargue
		
		$pagina['paginado']	= $this->pagination->create_links();
		$pagina['input_nombre'] = $asociacion[0]['nombre'];
		$pagina['input_rut'] = $asociacion[0]['rut'];
		$pagina['input_profesion'] = $asociacion[0]['profesion'];
		$pagina['input_especialidad'] = $asociacion[0]['especialidad'];
		$pagina['input_ciudad'] = $asociacion[0]['ciudad'];
		$pagina['input_estado'] = $asociacion[0]['estado'];
		$pagina['cant_pedidos'] = $req->cantidad; 
		$pagina['listado_usuarios'] = $lista;
		$pagina['listado_ciudades'] = $this->Ciudad_model->listar();
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		$pagina['listado_profesiones'] = $this->Profesiones_model->listar();
		$pagina['id'] = $id;
		if(!empty($req->id_especialidad))
			$pagina['especialidad'] = $this->Especialidadtrabajador_model->get($req->id_especialidad)->desc_especialidad;
		else
			$pagina['especialidad'] = NULL;
		$pagina['id_req'] = $req->id_requerimiento;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/asignar',$pagina,TRUE);
		$this->load->view('layout',$base);
		
	}

	function filtrar($tipo = false){
		$id = urlencode(base64_encode($_POST['id']));
		if(empty($_POST['nombre']) ) $_POST['nombre'] = 0;
		if(empty($_POST['rut']) ) $_POST['rut'] = 0;
		if(empty($_POST['profesion']) ) $_POST['profesion'] = 0;
		if(empty($_POST['especialidad']) ) $_POST['especialidad'] = 0;
		if(empty($_POST['ciudad']) ) $_POST['ciudad'] = 0;
		if(empty($_POST['estado']) ) $_POST['estado'] = 0;
		$url = "nombre/".$_POST['nombre']."/rut/".$_POST['rut']."/profesion/".$_POST['profesion']."/especialidad/".$_POST['especialidad']."/ciudad/".$_POST['ciudad']."/estado/".$_POST['estado'];
		$enc = urlencode(base64_encode($url));
		if($tipo == false || $tipo == 1){
			redirect('/administracion/requerimiento/asignar/'.$id.'/filtro/'.$enc, 'refresh');
		}
		else{
			redirect('/administracion/requerimiento/ajax_reemplazo/'.$_POST['id'].'/filtro/'.$enc, 'refresh');
		}
	}
	
	function asignados($id = FALSE){
		$base['titulo'] = "Trabajadores asignados el requerimiento";
		$base['lugar'] = "Trabajadores asignados";
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		$this->load->model('Asignarequerimiento_model');
		$this->load->model('Usuarios_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->model("Fotostrab_model");
		$id = urldecode($id);
		$id = $this->encrypt->decode(url_to_encode($id));
		
		$listado_usuarios = $this->Asignarequerimiento_model->listado_requerimiento($id);
		
		$listado = array();
		foreach($listado_usuarios as $l){
			$aux = new stdClass();
			$u = $this->Usuarios_model->get($l->id_usuarios);
			$foto = $this->Fotostrab_model->get_usuario($u->id);
			$aux->id = $u->id;
			$aux->nombres = $u->nombres;
			$aux->paterno = $u->paterno;
			$aux->materno = $u->materno;
			$aux->rut = $u->rut_usuario;
			$aux->foto = (count($foto)< 1) ? 'extras/img/perfil/requerimiento/avatar.jpg' : $foto->media;
			array_push($listado,$aux);
			unset($aux,$u);
		}
		$pagina['listado_usuarios'] = $listado;
		$datos_req = $this->Requerimiento_trabajador_model->get_trabajador($id);
		$pagina['nb_req'] = $datos_req->nombre;
		$pagina['nb_area'] =  $this->Areas_model->get($datos_req->id_areas)->desc_area;
		$pagina['nb_cargo'] =  $this->Cargos_model->get($datos_req->id_cargos)->desc_cargo;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/trabajadores_asignados',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function tooltip($id){ //informacion dinamica de un usuario
		$this->load->model("Usuarios_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$usu = $this->Usuarios_model->get($id);
		$esp = $this->Especialidadtrabajador_model->get($usu->id_especialidad_trabajador);
		$prof = $this->Profesiones_model->get($usu->id_profesiones);
		echo "<div class='democontent'>
			<div class='info'>
				<p>Nombre: ".ucwords(mb_strtolower($usu->nombres." ".$usu->paterno." ".$usu->materno,"UTF-8"))."</p>
				<p>Rut: ".$usu->rut_usuario."</p>
				<p>Profesion: ".ucwords(mb_strtolower(@$prof->desc_profesiones,"UTF-8"))."</p>
				<p>Especialidad: ".ucwords(mb_strtolower(@$esp->desc_especialidad,"UTF-8"))."</p>
				<p>Experiencia: ";
		if(!empty($usu->ano_experiencia)){ echo $usu->ano_experiencia;} else{ echo '0';}
		echo " años</p>
				<div><a target='_blank' href='".base_url()."administracion/perfil/trabajador/".$usu->id."'>Ver Perfil Completo</a></div>
			</div>
			<div class='clear'>&nbsp;</div>
		</div>";
	}
	
	function agregar_usr($id){ //agregar dinamicamente a un usuario al requerimiento
		$req = array();
		$req = $this->session->userdata('requerimiento');
		if(is_bool($req)){
			$req[] = $id;
		}
		else 
			array_push($req,$id);
		print_r($req);
		$this->session->set_userdata('requerimiento', $req);
	}
	/*function eliminar_usr($id){ //eliminar de forma dinamica a un usuario del requerimiento
		$req = array();
		if($tipo == "sesion" || !$tipo){
		$req = $this->session->userdata('requerimiento');
		$key = array_search($id,$req,TRUE);
		unset($req[$key]);
		$req = array_values($req);
		$this->session->set_userdata('requerimiento', $req);
		}
	}*/
	function eliminar_usr($id_req,$id_usr){
		$this->load->model("Asignarrequerimiento_model");
		
		$this->Asignarrequerimiento_model->eliminar_usr($id_req,$id_usr);
		redirect(base_url().'administracion/requerimiento/usr_asignados/'.$id_req, 'refresh');
	}

	function agregar_reemplazo($reemp,$id_subreq){ //agregar dinamicamente a un usuario al requerimiento
		$ses_reemp = $this->session->userdata('reemplazo');
		if(is_bool($ses_reemp)){
			$this->session->unset_userdata('reemplazo');
		}
		$req = array(
			'remp' => $reemp,
			'sub_req' => $id_subreq
		);
		$this->session->set_userdata('reemplazo', $req);
		print_r($this->session->userdata('reemplazo'));
	}
	
	function session_guardar_usuario_reemplazar($id_usr){
		$ses_reemp = $this->session->userdata('usr_reemplazo');
		if(is_bool($ses_reemp)){
			$this->session->unset_userdata('usr_reemplazo');
		}
		
		$this->session->set_userdata('usr_reemplazo', $id_usr);
		print_r($this->session->userdata('usr_reemplazo'));
	}
	function session_obtener_usuario_reemplazar(){
		print_r($this->session->userdata('usr_reemplazo'));
	}
	
	function ajax_motivo(){
		$this->load->model("Motivosfalta_model");
		foreach($this->Motivosfalta_model->listar() as $l){
			echo "<option value=".$l->id.">".ucwords(mb_strtolower($l->nombre, 'UTF-8'))."</option>";
		}
		
	}
	
	function session_reemplazo_final($id_motivo,$observacion){
		//$this->session->userdata('reemplazo_final');
		//echo $id_motivo."<br/>";
		//echo $observacion."<br/>";
		$req = array();
		$req = $this->session->userdata('reemplazo_final');
		$datos_reemplazado = $this->session->userdata('reemplazo');
		if(is_bool($req)){
			$req[] = array(
				'usuario' => $this->session->userdata('usr_reemplazo'),
				'sub_req' => $datos_reemplazado['sub_req'],
				'reemplazo' => array(
					'usuario_r' => $datos_reemplazado['remp'],
					'motivo' => $id_motivo,
					'observacion' => $observacion
				)
			);
		}
		else{
			$valido = 0;
			$session_final = $this->session->userdata('reemplazo_final');
			$i=0;
			foreach ($session_final as $k => $v) {
				if(($session_final[$i]['usuario'] == $this->session->userdata('usr_reemplazo')) && ($session_final[$i]['sub_req'] == $datos_reemplazado['sub_req'] )){
					$valido = 1;
				}
				$i++;
			}
			if($valido == 0){
				$salida = array(
					'usuario' => $this->session->userdata('usr_reemplazo'),
					'sub_req' => $datos_reemplazado['sub_req'],
					'reemplazo' => array(
						'usuario_r' => $datos_reemplazado['remp'],
						'motivo' => $id_motivo,
						'observacion' => $observacion
					)
				);
				array_push($req,$salida);
			}
		}
		//print_r($req);
		$this->session->set_userdata('reemplazo_final', $req);
		print_r($this->session->userdata('reemplazo_final'));
	}

	function quitar_session_reemplazo_final($id_usr,$sub_req,$id_reemplazo,$motivo,$obs){
		$req = array();
		$req = $this->session->userdata('reemplazo_final');
		$key = array_search(array('usuario' => $id_usr,'sub_req'=> $sub_req,'reemplazo' => array('usuario_r' => $id_reemplazo,'motivo' => $motivo,'observacion' => $obs)),$req,TRUE);
		echo $key."\n";
		print_r($this->session->userdata('reemplazo_final'));
		unset($req[$key]);
		$req = array_values($req);
		$this->session->set_userdata('reemplazo_final', $req);
	}
	
	function session_asignados($id_req){ // obtener dinamicamente los usuarios en la session del requerimiento
		$this->load->model("Usuarios_model");
		$this->load->model("Reemplazos_requerimiento_model");
		$this->load->model("Origen_trabajador_requerimiento_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->helper("multidimencional_array");
		$listado_asignados = array();
		if( is_bool( $this->session->userdata("requerimiento") ) )
			$listado_asignados = array(); //ta demás
		else{
			foreach($this->session->userdata("requerimiento") as $sr=>$k){ 
				$aux2 = new stdClass();
				$aux2->id = $this->Usuarios_model->get($k)->id;
				$aux2->nombres = ucwords(mb_strtolower($this->Usuarios_model->get($k)->nombres,"UTF-8"));
				$aux2->paterno = ucwords(mb_strtolower($this->Usuarios_model->get($k)->paterno,"UTF-8"));
				$aux2->materno = ucwords(mb_strtolower($this->Usuarios_model->get($k)->materno,"UTF-8"));
				$aux2->rut = $this->Usuarios_model->get($k)->rut_usuario;
				$aux2->tipo = "sesion";
				if($dato_asignado = $this->Asignarequerimiento_model->ger_trabajador_subreq($aux2->id, $id_req)){
					$aux2->fecha_inicio = $dato_asignado->fecha_inicio;
					$aux2->fecha_termino = $dato_asignado->fecha_termino;
					$aux2->origen = $dato_asignado->id_origen_trabajador_requerimiento; 
				}
				array_push($listado_asignados,$aux2);
				unset($aux2);
			}
		}
		$pagina['listado_asignados'] = $listado_asignados;
		$pagina['id_req'] = $id_req;
		$pagina['lista_origen'] = $this->Origen_trabajador_requerimiento_model->listar();
		$pagina['reemplazos'] = $this->session->userdata('reemplazo_final');
		$this->load->view('requerimiento/asignados',$pagina);
	}
	
	function session_usuarios_finalizados(){
		$fin = array();
		$fin = $this->session->userdata('usuarios_finalizados');
		if(is_bool($fin)){
			$fecha1 = $_POST['f_inicio'];
			$fecha1 = explode('-',$fecha1);
			$fecha2 = $_POST['f_termino'];
			$fecha2 = explode('-',$fecha2);
			$fin[] = array(
				'id_usuario' => $_POST['usuario'],
				'id_req' => $_POST['id_req'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0],
				'fecha_termino' => $fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0],
				'id_origen_trabajador_requerimiento' => $_POST['origen']
			);
		}
		else{
			$fecha1 = $_POST['f_inicio'];
			$fecha1 = explode('-',$fecha1);
			$fecha2 = $_POST['f_termino'];
			$fecha2 = explode('-',$fecha2);
			$aux = array(
				'id_usuario' => $_POST['usuario'],
				'id_req' => $_POST['id_req'],
				'motivo' => $_POST['motivo'],
				'fecha_inicio' => $fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0],
				'fecha_termino' => $fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0],
				'id_origen_trabajador_requerimiento' => $_POST['origen']
			);
			array_push($fin,$aux);
		}
		print_r($fin);
		$this->session->set_userdata('usuarios_finalizados', $fin);
	}
	
	function guardar_requerimiento($id_req){
		if(!is_bool($this->session->userdata("requerimiento"))){
			$usr_req = $this->session->userdata("requerimiento");
			$total_usr = count($usr_req);
		}
		else{
			redirect('/administracion/requerimiento/detalles/'.$req->id_requerimiento.'/error', 'refresh');
		}
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_trabajador_model");
		//$req = $this->Requerimiento_model->get_req($id_req);
		$req = $this->Requerimiento_trabajador_model->get_trabajador($id_req);
		//$this->Requerimiento_model->eliminar_trabajador_req($id_req);
		$this->load->library('email');
		
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'sgo@empresasintegra.cl';
		$config['smtp_pass'] = 'gestion2012';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';

		$this->email->initialize($config);
		//ver si el trabajador ya se asigno al requerimiento
		if(is_array($usr_req)){
			$no_existen = array();
			foreach($usr_req as $u){
				if(!$this->Asignarequerimiento_model->existe_trab_requerimiento($u,$id_req))
				$no_existen[] = $u; //lista de trabajadores nuevos
			}
		}
		
		//finalizar trabajadores del requerimiento anterior
		 print_r($this->session->userdata('usuarios_finalizados'));
		 if(is_array($finalizados = $this->session->userdata('usuarios_finalizados'))){
		 	foreach($finalizados as $f){
		 		$data = array(
		 			'fecha_termino' => $f['fecha'],
		 			'termino' => 1,
		 			'motivo_termino' => $f['motivo']
				);
				$this->Asignarequerimiento_model->actualizar($f['id_req'],$f['id_usuario'],$data);
				unset($data);
		 	}
		 }
		
		
		//agregar trabajadores que no existan ya en el requerimiento
		if(is_array($no_existen)){
			foreach($no_existen as $n){
				$data = array(
					'id_requerimientotrabajador' => $id_req,
					'id_usuarios' => $n,
					'fecha_inicio' => $req->fecha_inicio,
					'fecha_termino' => $req->fecha_termino,
					'id_origen_trabajador_requerimiento' => $req->id_origen_trabajador_requerimiento
				);
				$id_asigna_requerimiento = $this->Requerimiento_model->ingresar_trabajador($data);
				// $id_ingreso[] = array(
					// 'usuario' => $n,
					// 'id_asigna_requerimiento' => $id_asigna_requerimiento
				// ); 
				$trabajador = $this->Usuarios_model->get($n);//verificar
				//envio de correo a los trabajadores nuevos
				$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
				$this->email->from('sgo@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
				$this->email->to($trabajador->email);
				$this->email->subject('Asignado a nuevo requerimiento');
				$this->email->message($this->load->view('email/asignado_requerimiento',$requerimiento_mail,TRUE));
				$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
				if( !@$this->email->send()){
					//echo "error";
					//echo $this->email->print_debugger();
				}
			}
		}
		
		//quitar trabajadores desclickeados
		if(is_array($usr_req)){
			foreach($this->Asignarequerimiento_model->listado_requerimiento($id_req) as $r){
				if (!in_array($r->id_usuarios, $usr_req)) {
				 	$this->Requerimiento_model->eliminar_trabajador($r->id_usuarios,$id_req);
				}
			}
		}
		
		if($total_usr == $req->cantidad ){
			$data2 = array(
				'id_estado' => 3,
				'cantidad_ok' => $total_usr
			);
		}
		if($total_usr < $req->cantidad ){
			$data2 = array(
				'id_estado' => 2,
				'cantidad_ok' => $total_usr
			);
		}
		if($total_usr == 0 ){
			$data2 = array(
				'id_estado' => 1,
				'cantidad_ok' => $total_usr
			);
		}
		
		$this->Requerimiento_model->actualizar_req($id_req,$data2); //actualizar el estado y la cantidad de trabajadors asignados
		$this->session->unset_userdata('requerimiento');
		
		//reemplazar trabajadores
		if( !is_bool($reemplazantes = $this->session->userdata('reemplazo_final') ) ){
			$this->load->model("Reemplazos_requerimiento_model");
			//listar todos los trabajadores del requerimiento
			foreach($this->Requerimiento_model->listar_trabajador_req($id_req) as $lr ){
				$Y=0;
				foreach($reemplazantes as $k => $v){
					if(($lr->id_usuarios == $reemplazantes[$Y]['usuario']) && ( $lr->id_requerimientotrabajador == $reemplazantes[$Y]['sub_req'])){
						$ingreso = array(
							'id_usuarios' => $reemplazantes[$Y]['reemplazo']['usuario_r'],
							'id_asigna_requerimiento' => $lr->id,
							'id_motivos_falta' => $reemplazantes[$Y]['reemplazo']['motivo'],
							'observacion' => $reemplazantes[$Y]['reemplazo']['observacion']
						);
						$this->Reemplazos_requerimiento_model->ingresar($ingreso);
					}
					$Y++;
				}
			}
		}
		
		$this->session->unset_userdata('usuarios_finalizados');
		$this->session->unset_userdata('reemplazo_final');
		//$tot_subreq = count($this->Requerimiento_model->listar_req($req->id_requerimiento)); //cantidad de subrequerimientos
		$tot_subreq = count($this->Requerimiento_trabajador_model->get_requerimiento($req->id_requerimiento));
		$listo = 0; //auxiliar contador de si estan todos los subrequerimientos listos
		//foreach($this->Requerimiento_model->listar_req($req->id_requerimiento) as $f){ // cuando esten todos en estado 3, marcar como leido
		foreach($this->Requerimiento_trabajador_model->get_requerimiento($req->id_requerimiento) as $f){ // cuando esten todos en estado 3, marcar como leido
			if($f->id_estado == 3)
				$listo++;
		}
		if($listo == $tot_subreq ){
			$salida = array('flag_leido' => 1);
			$this->Requerimiento_model->editar($req->id_requerimiento,$salida);
		}
		
		//redirect('/administracion/requerimiento/detalles/'.$req->id_requerimiento.'/exito', 'refresh');
	}

	function eliminar($id){
		$this->load->model('Requerimiento_model');
		$this->Requerimiento_model->r_eliminar($id);
		echo "<script>alert('Requerimiento Eliminado Exitosamente')</script>";
		redirect(base_url().'est/requerimiento/listado', 'refresh');
	}
	
	function peticion_eliminacion(){
		$this->load->model("Empresas_model");
		$base['titulo'] = "Petición de eliminación de requerimientos";
		$base['lugar'] = "Petición de eliminación";
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$pagina['lista_req'] = $this->Requerimiento_model->get_pet_eliminacion();
		$base['cuerpo'] = $this->load->view('requerimiento/peticion_eliminacion',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function estado_subreq($id){
		$this->load->model('Especialidadtrabajador_model');
		$base['listado'] = $this->Requerimiento_model->get_prin_req($id);
		$this->load->view('requerimiento/dialog_subreq',$base);
	}
	
	function eliminar_req_fin_trab($id){
		$this->load->model("Asignarequerimiento_model");
		foreach($this->Requerimiento_model->listar_req($id) as $r){
			foreach($this->Requerimiento_model->get_trabajador($r->id) as $t){
				$this->Asignarequerimiento_model->actualizar($r->id,$t->id_usuarios,array('fecha_termino'=>date('Y-m-d'),'termino'=>1));
			}
		}
		$this->Requerimiento_model->editar($id,array('flag_vigente' => 0));
	}
	
	function ajax_cargos($id_planta){
		$this->load->model("Cargos_model");
		$plantas = $this->Cargos_model->listar_planta($id_planta);
		echo "<option value='' >Cargos...</option>";
		foreach($plantas as $p){
			echo "<option value='" .$p->id. "'>". ucwords(mb_strtolower($p->desc_cargo)) ."</option>";
		}
	}

	function ajax_areas($id_planta){
		$this->load->model("Areas_model");
		$areas = $this->Areas_model->listar_planta($id_planta);
		echo "<option value='' >Areas...</option>";
		foreach($areas as $a){
			echo "<option value='" .$a->id. "'>". ucwords(mb_strtolower($a->desc_area)) ."</option>";
		}
	}
	
	function ajax_especialidades(){
		$this->load->model("Especialidadtrabajador_model");
		$espe = $this->Especialidadtrabajador_model->listar();
		echo "<option value='' >Especialidad...</option>";
		foreach($espe as $e){
			echo "<option value='" .$e->id. "'>". ucwords(mb_strtolower($e->desc_especialidad)) ."</option>";
		}
	}
	
	function ajax_centrocostos($id_planta){
		$this->load->model("Centrocostos_model");
		$cc = $this->Centrocostos_model->listar_planta($id_planta);
		echo "<option value='' >Centro de costo...</option>";
		foreach($cc as $c){
			echo "<option value='" .$c->id. "'>". ucwords(mb_strtolower($a->desc_centrocosto)) ."</option>";
		}
	}
	function ajax_reemplazo($id = false){
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		//$id = base64_decode(urldecode($id));
		$this->load->model("Requerimiento_trabajador_model");
		//$req = $this->Requerimiento_model->get_req($id);
		$req = $this->Requerimiento_trabajador_model->get_trabajador($id);
		if(count($req) < 1)
			redirect('/error/error404', 'refresh');
		$pagina['id_subreq'] = $id;
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Fotostrab_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->library('pagination');
		
		$base['titulo'] = "Asignacion de requerimiento";
		$base['lugar'] = "Requerimientos";
		
		$lista = array();
		
		$url_pag = $this->uri->uri_to_assoc(5);
		if($this->uri->segment(5) === FALSE)
			$paginado = 1;
		else{
			$paginado = (empty($url_pag['pagina'])) ? 1 : $url_pag['pagina'];
			$url_encript = $this->uri->uri_to_assoc(5);
		}
		
		$config['per_page'] = 15;
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
		if(!empty($url_encript['filtro'])){ //si existe el filtro entonces........
			$filtro = base64_decode( urldecode($url_encript['filtro']));
			$fil = explode("/",$filtro);
			$asociacion = array();
			$aux = array(
				$fil[0] => $fil[1],
				$fil[2] => $fil[3],
				$fil[4] => $fil[5],
				$fil[6] => $fil[7],
				$fil[8] => $fil[9],
				$fil[10] => $fil[11]
			 );
			array_push($asociacion,$aux);
			unset($aux);
			
			if($asociacion[0]['nombre'] === 0) $asociacion[0]['nombre'] = FALSE;
			if($asociacion[0]['rut'] == 0) $asociacion[0]['rut'] = FALSE;
			if($asociacion[0]['profesion'] == 0) $asociacion[0]['profesion'] = FALSE;
			if($asociacion[0]['especialidad'] == 0) $asociacion[0]['especialidad'] = FALSE;
			if($asociacion[0]['ciudad'] == 0) $asociacion[0]['ciudad'] = FALSE;
			if($asociacion[0]['estado'] == 0) $asociacion[0]['estado'] = FALSE;
			$config['base_url'] = base_url().'/administracion/requerimiento/ajax_reemplazo/'.$this->uri->segment(4)."/filtro/".$url_encript['filtro']."/pagina/";
			$config['total_rows'] = $this->Usuarios_model->total_filtro($asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['profesion'],$asociacion[0]['especialidad'],$asociacion[0]['ciudad'],false,$asociacion[0]['estado']);
			$config['uri_segment'] = 8;
		}
		else{ // si no existe el filtro entoncess...........
			$config['base_url'] = base_url().'/administracion/requerimiento/ajax_reemplazo/'.$this->uri->segment(4)."/pagina/";
			$config['total_rows'] = $this->db->where('id_tipo_usuarios',2)->get('usuarios')->num_rows();
			$asociacion[0]['nombre'] = FALSE;
			$asociacion[0]['rut'] = FALSE;
			$asociacion[0]['profesion'] = FALSE;
			$asociacion[0]['especialidad'] = FALSE;
			$asociacion[0]['ciudad'] = FALSE;
			$asociacion[0]['estado'] = FALSE;
			$config['uri_segment'] = 6;
		}
		
		if($config['total_rows'] <= $config['per_page'] ){
			$config['total_rows'] = FALSE;
			$paginado = FALSE;
		}
		$this->pagination->initialize($config);
		//echo $config['total_rows'];
		//print_r($asociacion);
		//si la session de requerimiento no se a inicializado o esta vacia, se llana con los usuarios de bd del requerimiento
		if( (is_bool($this->session->userdata("requerimiento") )) || (count($this->session->userdata("requerimiento")) < 1 ) ){
			foreach($this->Usuarios_model->listar_id() as $u){
				if($this->Requerimiento_model->get_trabajador_req($u->id,$id)){ //lleno la session de requerimiento, si existen asignados por BD
					$ses[] = $u->id;
					$this->session->set_userdata("requerimiento",$ses);
				}
			}
		}
		foreach($this->Usuarios_model->listar_filtro($asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['profesion'],$asociacion[0]['especialidad'],$asociacion[0]['ciudad'],false,$asociacion[0]['estado'],$config['per_page'],$paginado) as $t){
			$aux = new stdClass();
			$foto = $this->Fotostrab_model->get_usuario($t->id);
			$check = FALSE;
			$otro_req = FALSE;
			$id_otro_req = FALSE;
			if(!is_bool($this->session->userdata("requerimiento"))){
				foreach($this->session->userdata("requerimiento") as $r=>$k){
					if($t->id == $k){
						$check = TRUE;
					}
				}
			}
			// if($this->Requerimiento_model->get_trabajador_otroreq($t->id,$id)){//verificar si existe en otro requerimiento
				// $otro_req = TRUE;
				// $id_otro_req = $this->Requerimiento_model->get_trabajador_otroreq($t->id,$id)->id_requerimientotrabajador;
			// }
			// echo $t->id."<br/>";
			// echo "id-->".$id."<br/>";
			//print_r($req);
			// echo "fecha_inicio-->".$req[0]->fecha_inicio."<br/>";
			if($this->Asignarequerimiento_model->get_actual($t->id,$id,$req->fecha_inicio)){//verificar si existe en otro requerimiento
				$otro_req = TRUE;
				$id_otro_req = $this->Asignarequerimiento_model->get_actual($t->id,$id,$req->fecha_inicio)->id_requerimientotrabajador;
				$id_otro_req_padre = $this->Requerimiento_model->get_req($id_otro_req);
			}
			
			
			$aux->id = $t->id;
			$aux->check = $check;
			$aux->otro_req = $otro_req;
			$aux->id_otro_req = $id_otro_req;//el id del otro requerimiento
			@$aux->id_otro_req_padre = $id_otro_req_padre->id_requerimiento; //id del requerimiento padre
			$aux->nombres =  $t->nombres;
			$aux->paterno = $t->paterno;
			$aux->materno = $t->materno;
			$aux->rut = $t->rut_usuario;
			$aux->foto = (count($foto)< 1) ? 'extras/img/perfil/requerimiento/avatar.jpg' : $foto->media;
			array_push($lista,$aux);
			unset($aux);
		}
		//print_r($this->session->userdata("requerimiento"));
		if( is_bool( $this->session->userdata("requerimiento") ) )
			$asignados = '0';
		else
			$asignados = count($this->session->userdata("requerimiento"));
		
		$pagina['asignados'] = $asignados;
		
		//mantener el filtro en el html cuando recargue
		
		$pagina['paginado']	= $this->pagination->create_links();
		$pagina['input_nombre'] = $asociacion[0]['nombre'];
		$pagina['input_rut'] = $asociacion[0]['rut'];
		$pagina['input_profesion'] = $asociacion[0]['profesion'];
		$pagina['input_especialidad'] = $asociacion[0]['especialidad'];
		$pagina['input_ciudad'] = $asociacion[0]['ciudad'];
		$pagina['input_estado'] = $asociacion[0]['estado'];
		$pagina['cant_pedidos'] = $req->cantidad; 
		$pagina['listado_usuarios'] = $lista;
		$pagina['listado_ciudades'] = $this->Ciudad_model->listar();
		$pagina['listado_especialidad'] = $this->Especialidadtrabajador_model->listar();
		$pagina['listado_profesiones'] = $this->Profesiones_model->listar();
		$pagina['id'] = $id;
		if(!empty($req->id_especialidad))
			$pagina['especialidad'] = $this->Especialidadtrabajador_model->get($req->id_especialidad)->desc_especialidad;
		else
			$pagina['especialidad'] = NULL;
		$pagina['id_req'] = $req->id_requerimiento;
		//$pagina['menu'] = $this -> load -> view('menus/menu_admin',$this->requerimiento,TRUE);
		//$base['cuerpo'] = $this -> load -> view('requerimiento/ajax_asignar',$pagina,TRUE);
		$this->load->view('requerimiento/ajax_asignar',$pagina);
	}

	function form_requerimiento(){
		// print_r($_POST['trabajador_original']);
		// print_r($_POST['trabajador_reemplazo']);
		// print_r($_POST['f_inicio']);
		// print_r($_POST['f_termino']);
		// print_r($_POST['origen']);
		//echo $_POST['id_requerimiento'];
		
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_trabajador_model");
		$this->load->model("Reemplazos_requerimiento_model");
		$id_req = $_POST['id_requerimiento'];
		$id_principal = $this->Requerimiento_model->get_requerimiento_principal($_POST['id_requerimiento']);
		if(count($_POST['trabajador_original']) < 1 ){
			redirect('/administracion/requerimiento/detalles/'.$_POST['id_requerimiento'].'/error', 'refresh');
		}
		print_r($_POST['trabajador_original']);
		//si no existe el trabajador se ingresa y si existe se actualiza
		for($i=0;$i < count($_POST['trabajador_original']); $i++){
			$usr_req[] = $_POST['trabajador_original'][$i];
			$fecha_inicio =  explode('-', $_POST['f_inicio'][$i]);
			$fecha_termino =  explode('-', $_POST['f_termino'][$i]);
			$data = array(
				'id_requerimientotrabajador' => $_POST['id_requerimiento'],
				'id_usuarios' => $_POST['trabajador_original'][$i],
				'fecha_inicio' => $fecha_inicio[2].'-'.$fecha_inicio[1].'-'.$fecha_inicio[0],
				'fecha_termino' => $fecha_termino[2].'-'.$fecha_termino[1].'-'.$fecha_termino[0],
				'id_origen_trabajador_requerimiento' => $_POST['origen'][$i]
			);
			if(!$this->Asignarequerimiento_model->existe_trab_requerimiento($_POST['trabajador_original'][$i],$_POST['id_requerimiento'])){
				//echo "ingresa<br>";
				$id_asigna_requerimiento = $this->Requerimiento_model->ingresar_trabajador($data);
			}
			else{
				//echo "updatea<br>";
				$id_asigna_requerimiento = $this->Asignarequerimiento_model->existe_trab_requerimiento($_POST['trabajador_original'][$i],$_POST['id_requerimiento']);				
				$this->Asignarequerimiento_model->actualizar2($id_asigna_requerimiento->id,$data);
				$id_asigna_requerimiento = $id_asigna_requerimiento->id;
			}
			//echo $id_asigna_requerimiento;
			if(isset($_POST['trabajador_reemplazo'][$i])){ //verificar si existe reemplazo para el usuario
				$data_reemplazo = array(
					'id_usuarios' => $_POST['trabajador_reemplazo'][$i],
					'id_asigna_requerimiento' => $id_asigna_requerimiento,
					'id_motivos_falta' => 3
				);
				if( count( $this->Reemplazos_requerimiento_model->get_usuario($_POST['trabajador_original'][$i],$id_asigna_requerimiento) < 1)){
					$this->Reemplazos_requerimiento_model->ingresar($data_reemplazo);
				}
			}
		}
		
		foreach ($this->Asignarequerimiento_model->listado_requerimiento($_POST['id_requerimiento']) as $lr) {
			$aux_reemplazo = FALSE;
			if($lista_reemplazo = $this->Reemplazos_requerimiento_model->listar_requerimiento($lr->id)){
				print_r($lista_reemplazo);
				if(!empty($_POST['trabajador_reemplazo'])){
					for($a=0;$a < count($_POST['trabajador_reemplazo']); $a++){
						if($lista_reemplazo->id_usuarios == $_POST['trabajador_reemplazo'][$a] )
							$aux_reemplazo = TRUE;
					}
				}
				if($aux_reemplazo == FALSE){
					$this->Reemplazos_requerimiento_model->borrar($lista_reemplazo->id);
				}
			}
		}
		
		//$req = $this->Requerimiento_model->get_req($id_req);
		$req = $this->Requerimiento_trabajador_model->get_trabajador($_POST['id_requerimiento']);
		$total_usr = count($usr_req);
		//$this->Requerimiento_model->eliminar_trabajador_req($id_req);
		$this->load->library('email');
		
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'sgo@empresasintegra.cl';
		$config['smtp_pass'] = 'gestion2012';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';

		$this->email->initialize($config);
		//ver si el trabajador ya se asigno al requerimiento
		if(is_array($usr_req)){
			$no_existen = array();
			foreach($usr_req as $u){
				if(!$this->Asignarequerimiento_model->existe_trab_requerimiento($u,$id_req))
				$no_existen[] = $u; //lista de trabajadores nuevos
			}
		}
		
		//finalizar trabajadores del requerimiento anterior
		 print_r($this->session->userdata('usuarios_finalizados'));
		 if(is_array($finalizados = $this->session->userdata('usuarios_finalizados'))){
		 	foreach($finalizados as $f){
		 		$data = array(
		 			'fecha_termino' => $f['fecha'],
		 			'termino' => 1,
		 			'motivo_termino' => $f['motivo']
				);
				$this->Asignarequerimiento_model->actualizar($f['id_req'],$f['id_usuario'],$data);
				unset($data);
		 	}
		 }
		
		
		//agregar trabajadores que no existan ya en el requerimiento
		if(is_array($no_existen)){
			foreach($no_existen as $n){
				$data = array(
					'id_requerimientotrabajador' => $id_req,
					'id_usuarios' => $n,
					'fecha_inicio' => $req->fecha_inicio,
					'fecha_termino' => $req->fecha_termino
				);
				$id_asigna_requerimiento = $this->Requerimiento_model->ingresar_trabajador($data);
				// $id_ingreso[] = array(
					// 'usuario' => $n,
					// 'id_asigna_requerimiento' => $id_asigna_requerimiento
				// ); 
				$trabajador = $this->Usuarios_model->get($n);//verificar
				//envio de correo a los trabajadores nuevos
				$requerimiento_mail['nombre'] = ucwords(mb_strtolower( $trabajador->nombres.' '.$trabajador->paterno.' '. $trabajador->materno , 'UTF-8'));
				$this->email->from('sgo@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
				$this->email->to($trabajador->email);
				$this->email->subject('Asignado a nuevo requerimiento');
				$this->email->message($this->load->view('email/asignado_requerimiento',$requerimiento_mail,TRUE));
				$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
				if( !@$this->email->send()){
					//echo "error";
					//echo $this->email->print_debugger();
				}
			}
		}
		
		//quitar trabajadores desclickeados
		if(is_array($usr_req)){
			foreach($this->Asignarequerimiento_model->listado_requerimiento($id_req) as $r){
				if (!in_array($r->id_usuarios, $usr_req)) {
				 	$this->Requerimiento_model->eliminar_trabajador($r->id_usuarios,$id_req);
				}
			}
		}
		
		if($total_usr == $req->cantidad ){
			$data2 = array(
				'id_estado' => 3,
				'cantidad_ok' => $total_usr
			);
		}
		if($total_usr < $req->cantidad ){
			$data2 = array(
				'id_estado' => 2,
				'cantidad_ok' => $total_usr
			);
		}
		if($total_usr == 0 ){
			$data2 = array(
				'id_estado' => 1,
				'cantidad_ok' => $total_usr
			);
		}
		
		$this->Requerimiento_model->actualizar_req($id_req,$data2); //actualizar el estado y la cantidad de trabajadors asignados
		$this->session->unset_userdata('requerimiento');
		
		//reemplazar trabajadores
		
		
		$this->session->unset_userdata('usuarios_finalizados');
		$this->session->unset_userdata('reemplazo_final');
		//$tot_subreq = count($this->Requerimiento_model->listar_req($req->id_requerimiento)); //cantidad de subrequerimientos
		$tot_subreq = count($this->Requerimiento_trabajador_model->get_requerimiento($id_principal->id));
		$listo = 0; //auxiliar contador de si estan todos los subrequerimientos listos
		//foreach($this->Requerimiento_model->listar_req($req->id_requerimiento) as $f){ // cuando esten todos en estado 3, marcar como leido
		foreach($this->Requerimiento_trabajador_model->get_requerimiento($id_principal->id) as $f){ // cuando esten todos en estado 3, marcar como leido
			if($f->id_estado == 3)
				$listo++;
		}
		
		if($listo == $tot_subreq ){
			$salida = array('flag_leido' => 1);
			$this->Requerimiento_model->editar($id_principal->id,$salida);
		}
		//obtener el id principal
		//$id_principal = $this->Requerimiento_model->get_requerimiento_principal($_POST['id_requerimiento']);
		redirect('/administracion/requerimiento/detalles/'.$id_principal->id.'/exito', 'refresh');
	}




	function busqueda_grupos(){
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Busqueda de usuarios por grupos";
		$this->load->model("Planta_model");
		$pagina['listado_plantas'] = $this->Planta_model->listar();

		if (isset($_POST['planta'])){
			$this->load->model("Areas_model");
			$this->load->model("Grupo_model");
			$this->load->model("Cargos_model");
			$this->load->model("Usuarios_model");
			$this->load->model("Evaluaciones_model");
			$this->load->model("Requerimientos_model");
			$this->load->model("Asignarrequerimiento_model");

			$id_planta = $_POST['planta'];
			$id_grupo = $_POST['grupo'];
			$id_area = $_POST['area'];
			$id_cargo = $_POST['cargo'];

			if($id_planta == 0) $id_planta = FALSE;
			if($id_grupo == 0) $id_grupo = FALSE;
			if($id_area == 0) $id_area = FALSE;
			if($id_cargo == 0) $id_cargo = FALSE;

			$res = $this->Requerimientos_model->listar_usuarios($id_planta,$id_grupo,$id_area,$id_cargo);
			$lista = array();
			foreach ($res as $r) {
				foreach ($this->Asignarrequerimiento_model->listar_req($r->id) as $s ) {
					$aux = new stdClass();
					$u = $this->Usuarios_model->get($s->id_usuarios);
					$c = $this->Cargos_model->get_empresa($r->id_cargo);
					$a = $this->Areas_model->get_empresa($r->id_area);
					$g = $this->Grupo_model->get($r->id_grupo);
					$m = $this->Evaluaciones_model->get_una_masso($s->id_usuarios);
					$p = $this->Evaluaciones_model->get_una_preocupacional($s->id_usuarios);
					$aux->id_usr = $u->id;
					$aux->rut = $u->rut_usuario;
					$aux->nombre = $u->nombres;
					$aux->paterno = $u->paterno;
					$aux->materno = $u->materno;
					$aux->fono = $u->fono;
					$aux->grupo = $g->nombre;
					$aux->cargo = $c->desc_cargo;
					$aux->area = $a->desc_area;
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

					array_push($lista,$aux);
					unset($aux,$u,$c,$a,$g,$s,$m,$p);
				}
			}

			$pagina['listado'] = $lista;
		}


		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('requerimiento/busqueda',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function ajax_grupo($id_planta = FALSE){
		$this->load->model("Grupo_model");
		$res = $this->Grupo_model->listar_planta($id_planta);
		echo json_encode($res);
	}

	function ajax_areas2($id_grupo = FALSE){
		$this->load->model("Areas_model");
		$this->load->model("Requerimientos_model");
		$res = $this->Requerimientos_model->buscar_areas($id_grupo);
		$a = 0;
		$areas = array();
		foreach ($res as $r) {
			if ($r->id_area != $a){
				array_push($areas,$r->id_area);
				$a = $r->id_area;
			}
		}
		$lista = array();
		foreach ($areas as $a) {
			$aux = new stdClass();
			$ar = $this->Areas_model->get_empresa($a);
			$aux->id = $a;
			$aux->nombre = $ar->desc_area;

			array_push($lista,$aux);
			unset($aux,$ar);
		}

		echo json_encode($lista);
	}

	function ajax_cargos2($id_grupo = FALSE, $id_area = FALSE){
		$this->load->model("Requerimientos_model");
		$this->load->model("Cargos_model");
		$res = $this->Requerimientos_model->buscar_cargos($id_grupo,$id_area);
		$c = 0;
		$cargos = array();
		foreach ($res as $r) {
			if ($r->id_cargo != $c){
				array_push($cargos,$r->id_cargo);
				$c = $r->id_cargo;
			}
		}
		$lista = array();
		foreach ($cargos as $c) {
			$aux = new stdClass();
			$cr = $this->Cargos_model->get_empresa($c);
			$aux->id = $c;
			$aux->nombre = $cr->desc_cargo;

			array_push($lista,$aux);
			unset($aux,$cr);
		}

		echo json_encode($lista);
	}

	function verificarExamenPreocupacional($idUsuario){
		$this->load->model('Evaluaciones_model');
		$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($idUsuario);
		echo json_encode($examen_pre);
	}

	function verificarExamenPsicologico($idUsuario){
		$this->load->model('Examenes_psicologicos_model');
		$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($idUsuario);
		echo json_encode($examen_psic);
	}

	function verificarCharlaMasso($idUsuario){
		$this->load->model('Evaluaciones_model');
		$masso = $this->Evaluaciones_model->get_una_masso($idUsuario);
		echo json_encode($masso);
	}
	function no_mostrar_notificacion(){
		$this->load->model('Evaluaciones_model');
		$id= $this->session->userdata('id');
		$this->Evaluaciones_model->cancelarNotificacion($id);
		$hola = true;

		$this->session->set_userdata('notificado',1);
		echo json_encode($hola);
	}

	#29-11-2018 Contrato puesto a disposicion de trabajadores

	function descargar_puesta_disposicion($id){
		$this->load->library('zip');
		$this->load->helper('download');
		$this->load->model('Requerimientos_model');
		$this->load->model('Requerimiento_area_cargo_model');
		$requerimientos = $this->Requerimientos_model->getRequerimientoPuesto($id);
		
		$data = array('estado2' => 2 );
		$this->Requerimientos_model->cambiarestado2($id,$data);
		
		$ac = $this->Requerimiento_area_cargo_model->getReqContratoPuestoDisposicion($id);
		
		
		
		//$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fechaHoy = date('d')." de ".$meses[date('n')-1]. " de ".date('Y') ;
		
		#codigo Nicolas Rojas 19-05-2021
		$contador = $this->Requerimientos_model->contarreq($id,$requerimientos->idPlanta);
		if($requerimientos->idPlanta == "1")
		$codigo = "Celco ".$contador."/".date('Y');
		elseif ($requerimientos->idPlanta == "2") {
		$codigo = "CPA-".$contador."-".date('Y');
	   }elseif ($requerimientos->idPlanta == "3") {
		$codigo = "CNA-".$contador."-".date('Y');
	   }elseif ($requerimientos->idPlanta == "4") {
		$codigo = "Celic ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "5") {
		$codigo = "Celva ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "6") {
		$codigo = "Remvi ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "8") {
		$codigo = "Remva ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "9") {
		$codigo = "Asviñ ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "10") {
		$codigo = "AEC-".$contador."-".date('Y');
	   }elseif ($requerimientos->idPlanta == "11") {
		$codigo = "ANA-".$contador."-".date('Y');
	   }elseif ($requerimientos->idPlanta == "15") {
		$codigo = "Asval ".$contador."/".date('Y');
		}elseif ($requerimientos->idPlanta == "16") {
		$codigo = "Madte ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "17") {
		$codigo = "TNA-".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "19") {
		$codigo = "Bioen ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "20") {
		$codigo = "Caman ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "21") {
		$codigo = "Celgic ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "22") {
		$codigo = "Celtra ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "23") {
		$codigo = "SEI-".$contador."-".date('Y');
	   }elseif ($requerimientos->idPlanta == "24") {
		$codigo = "ADM-".$contador."-".date('Y');
	   }elseif ($requerimientos->idPlanta == "27") {
		$codigo = "EMI-".$contador."-".date('Y');
	   }elseif ($requerimientos->idPlanta == "28") {
		$codigo = "Forva ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "29") {
		$codigo = "Ewos ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "30") {
		$codigo = "Forchi ".$contador."/".date('Y');
	   }elseif ($requerimientos->idPlanta == "31") {
		$codigo = "Forco ".$contador."/".date('Y');
	   }else{
	   	$contador1= $contador + 103;
		$codigo = "AND-".$contador1."-".date('Y');
	   }

		#obteniendo la cantidad de dias que dura el requerimiento
		$fecha1 = new DateTime($requerimientos->fechaInicioReq);
	    $fecha2 = new DateTime($requerimientos->fechaFinReq);
	    $resultado = $fecha1->diff($fecha2);
	    $totalDiasRequerimiento = $resultado->format('%a')+1;

	    		$fecha_inicio = $requerimientos->fechaInicioReq;
	    		
				$get_fecha_inicio=date($fecha_inicio); 
				$var1 = explode('-',$get_fecha_inicio); 
				$get_dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

				if($get_dia_fi < 10)
					$dia_fi = $var1[2];
				else
					$dia_fi = $var1[2];

				if ($mes_fi=="01") $mes_letra_fi="Enero";
				if ($mes_fi=="02") $mes_letra_fi="Febrero";
				if ($mes_fi=="03") $mes_letra_fi="Marzo";
				if ($mes_fi=="04") $mes_letra_fi="Abril";
				if ($mes_fi=="05") $mes_letra_fi="Mayo";
				if ($mes_fi=="06") $mes_letra_fi="Junio";
				if ($mes_fi=="07") $mes_letra_fi="Julio";
				if ($mes_fi=="08") $mes_letra_fi="Agosto";
				if ($mes_fi=="09") $mes_letra_fi="Septiembre";
				if ($mes_fi=="10") $mes_letra_fi="Octubre";
				if ($mes_fi=="11") $mes_letra_fi="Noviembre";
				if ($mes_fi=="12") $mes_letra_fi="Diciembre";

				$fecha_termino = $requerimientos->fechaFinReq;
				
				$get_fecha_termino=date($fecha_termino); 
				$var2 = explode('-',$get_fecha_termino); 
				$get_dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];
				
				if($get_dia_ft < 10)
					$dia_ft = "0".$var2[2];
				else
					$dia_ft = $var2[2];

				if ($mes_ft=="01") $mes_letra_ft="Enero";
				if ($mes_ft=="02") $mes_letra_ft="Febrero";
				if ($mes_ft=="03") $mes_letra_ft="Marzo";
				if ($mes_ft=="04") $mes_letra_ft="Abril";
				if ($mes_ft=="05") $mes_letra_ft="Mayo";
				if ($mes_ft=="06") $mes_letra_ft="Junio";
				if ($mes_ft=="07") $mes_letra_ft="Julio";
				if ($mes_ft=="08") $mes_letra_ft="Agosto";
				if ($mes_ft=="09") $mes_letra_ft="Septiembre";
				if ($mes_ft=="10") $mes_letra_ft="Octubre";
				if ($mes_ft=="11") $mes_letra_ft="Noviembre";
				if ($mes_ft=="12") $mes_letra_ft="Diciembre";

			


				$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
					





		if ($requerimientos->letraCausal== 'A') {
			$descripcionCausal = 'Suspensión del contrato de trabajo o de la obligación de prestar servicios, según corresponda, de uno o más trabajadores por licencias médicas, descansos de maternidad o feriados';
			//articulo quinto
			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será de '.$totalDiasRequerimiento.' días, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 1°, podrá prorrogarse hasta cubrir el tiempo de duración de la ausencia del trabajador reemplazado.';

		}elseif($requerimientos->letraCausal == 'C'){
			$descripcionCausal = 'proyectos nuevos y específicos de la usuaria, tales como la construcción de nuevas instalaciones, la ampliación de las ya existentes o expansión a nuevos mercados';

			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será de '.$totalDiasRequerimiento.' días, considerando la totalidad de los trabajadores requeridos, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 3°, el contrato de trabajo junto a sus anexos para prestar servicios en una misma usuaria, por esta causal, no podrá exceder de 180 días a nivel individual de los trabajadores.';

		}elseif($requerimientos->letraCausal == 'E'){
			$descripcionCausal = 'Aumentos ocasionales, sean o no periódicos, o extraordinarios de la actividad de toda la Empresa Usuaria o en una determinada sección, sucursal, planta, faena o establecimiento de la misma';
			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será un total de '.$totalDiasRequerimiento.' días, considerando la totalidad de los trabajadores requeridos, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 3°, el contrato de trabajo para prestar servicios en una misma usuaria, por esta causal, no podrá exceder de 90 días a nivel individual de los trabajadores.';
		}

				if ($requerimientos->id_empresa == 7 ){
					$template_formato = base_url()."extras/contratos/formatos_contrato_disposicion/formatoContratoPuestaDisposicionewos.docx";
					}
				elseif ($requerimientos->id_empresa == 13 ){
					$template_formato = base_url()."extras/contratos/formatos_contrato_disposicion/formatoContratoPuestaDisposicionandritz.docx";
					}else{
			$template_formato = base_url()."extras/contratos/formatos_contrato_disposicion/formatoContratoPuestaDisposicionArauco.docx";
		}
			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";
			
			$templateWord->setValue('codigo', $codigo);
			$templateWord->setValue('fechaHoy', $fechaHoy);
			$templateWord->setValue('nombreCiudad',$requerimientos->nombreCiudad);
			$templateWord->setValue('domicilioGerente',$requerimientos->direccionPlanta);
			$templateWord->setValue('razonSocial',$requerimientos->razonSocial);
			$templateWord->setValue('razonSocialMayus',strtoupper($requerimientos->razonSocial));
			$templateWord->setValue('rut',$requerimientos->rut);
			$templateWord->setValue('nombrePlanta',$requerimientos->nombrePlanta);
			$templateWord->setValue('nombreGerente',$requerimientos->nombreGerente);
			$templateWord->setValue('rutGerente',$requerimientos->rutGerente);
			$templateWord->setValue('letraCausal',$requerimientos->letraCausal);
			$templateWord->setValue('descripcionCausal',$descripcionCausal);
			$templateWord->setValue('motivo',$requerimientos->motivo);
			$templateWord->setValue('articuloQuinto',$articuloQuinto);
			$templateWord->setValue('totalDiasRequerimiento',$totalDiasRequerimiento);
			$templateWord->setValue('fechainicioreq',$fecha_inicio_texto_largo);
			$templateWord->setValue('fechaterminoreq',$fecha_termino_texto_largo);
			$i = 0;
			$ValorReTotal = 0;

			foreach ($ac as $key) {
				$nombreArea[] = $key->nombreArea;
				$cantidadTrabajadores[] = $key->cantidadTrabajadores;
				$totalDiasReq = $totalDiasRequerimiento*$key->cantidadTrabajadores;
				$nombreCargo[] = $key->nombreCargo;
				$sueldoBase= $key->valor;
				$sueldoBasePorcentaje[$i] = $sueldoBase*0.25;
				if ($sueldoBasePorcentaje[$i] < 129240) {
					$sueldoBaseMasGratificacion[$i] =  $sueldoBase+$sueldoBasePorcentaje[$i];
				}else{
					$sueldoBaseMasGratificacion[$i] = $sueldoBase+129240;
				}
				$subtotal[$i] = ($sueldoBaseMasGratificacion[$i]/30)*$totalDiasReq;//$totalDiasRequerimiento Reemplazar por 1;
				$valorTotal[$i] = $subtotal[$i]+(($subtotal[$i]*0.935/100))+(($subtotal[$i]*2.3)/100)+($subtotal[$i]*0.03)+((2000/30)*$totalDiasReq);//$totalDiasRequerimiento Reemplazar por 1;
				$valorTotalRedondeado[$i] = round($valorTotal[$i]);
				$ValorReTotal = $ValorReTotal+ $valorTotalRedondeado[$i];
				$i++;
			}
			$ValorReTotalPalabras = num2letras($ValorReTotal);
			//$subtotal = ($sueldoBaseMasGratificacion[$i]/30)*$totalDiasRequerimiento;
			$templateWord->setValue('totalredondeado',$ValorReTotal);
			$templateWord->setValue('totalredondeadopalabras',$ValorReTotalPalabras);

			$templateWord->cloneRow('cargo', count($ac));
			for ($r = 1; $r <= count($ac); $r++) {
				$templateWord->setValue('cargo#'.$r,$nombreCargo[$r-1]);
				$templateWord->setValue('numero#'.$r,$cantidadTrabajadores[$r-1]);
				$templateWord->setValue('area#'.$r,$nombreArea[$r-1]);
				$templateWord->setValue('valor#'.$r,$valorTotalRedondeado[$r-1]);
			}
			// Guardamos el documento
			$nombre_documento = "contrato_anexo_disposicion.docx";
			$templateWord->saveAs("extras/contratos/contratosDisposicionGenerados/".$nombre_documento);
			ob_clean();
			$get_url = "extras/contratos/contratosDisposicionGenerados/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
	}

	#28-01-2019
	/*function qr_carga($id_area_cargo = false, $id_usuario = FALSE){
		if (!$id_area_cargo) {
			redirect(base_url(),'refresh');
		}
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->model('Archivos_trab_model');
		$this->load->model('Empresas_model');
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model('Planta_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Listanegra_model");
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("Sre_evaluacion_req_model");
		$this->load->model('Examenes_psicologicos_model');

		$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);

		$listado = array();
		$pagina['id_requerimiento'] = (isset($r_area_cargo->requerimiento_id)?$r_area_cargo->requerimiento_id:'0');
		$reque = $this->Requerimientos_model->get($r_area_cargo->requerimiento_id);
		$pagina['nombre_req'] = isset($reque->nombre)?$reque->nombre:'';

		$pagina['empresa'] = $this->Empresas_model->get($reque->empresa_id)->razon_social;
		$pagina['centro_costo'] = $this->Empresa_planta_model->get_planta_centro_costo($reque->planta_id)->desc_centrocosto;
		$pagina['planta'] = $this->Planta_model->get($reque->planta_id)->nombre;
		$pagina['fecha'] = $reque->f_solicitud;
		$pagina['fecha_inicio'] = $reque->f_inicio;
		$pagina['fecha_termino'] = $reque->f_fin;
		$pagina['area_cargo'] = $id_area_cargo;
		$pagina['area'] = $this->Areas_model->r_get($r_area_cargo->areas_id)->nombre;
		$pagina['cargo'] = $this->Cargos_model->r_get($r_area_cargo->cargos_id)->nombre;
		$pagina['paso_usuario'] =  ($id_usuario)?$id_usuario:FALSE;
		$pagina['cantidad'] = $r_area_cargo->cantidad;
		$fecha_termino_req = $reque->f_fin;
		$fecha_inicio_req = $reque->f_inicio;

		$i = 0;
		foreach($this->Requerimiento_asc_trabajadores_model->get_cargo_area($id_area_cargo) as $r){
			$aux = new stdClass();
			
			$estado_envio = 0;

			$usr = $this->Usuarios_model->get($r->usuario_id);
			//$masso = $this->Evaluaciones_model->get_una_masso($r->usuario_id);
			$ar_contrato = $this->Archivos_trab_model->get_archivo($r->usuario_id,15);
			$ar_certificado = $this->Archivos_trab_model->get_archivo($r->usuario_id,9);
			$aux->id = $r->id;
			$aux->id_req = $id_area_cargo;
			$aux->usuario_id = $r->usuario_id;
			$aux->nombre = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
			$aux->fecha = $r->fecha;
			$aux->referido = $r->referido;
			$aux->contacto = $r->contacto;
			$aux->disponibilidad = $r->disponibilidad;
			$aux->contrato = $r->contrato;
			$aux->status = $r->status;
			$i++;
			array_push($listado,$aux);
		}
		//function callback_view_documentos($id_usuario,$id_asc_area_req,$id_req = FALSE)
		$id_asc_area_req = $aux->id;
		$id_req = $id_area_cargo;

		$this->load->model("tipoarchivos_requerimiento_model");
		$this->load->model("requerimiento_usuario_archivo_model");
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Pensiones_Requerimiento_model");
		$this->load->model("Pensiones_Valores_model");
		$this->load->model("Pensiones_model");
		$usr = $this->Usuarios_model->get($id_usuario);
		$base['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$archivos = $this->tipoarchivos_requerimiento_model->listar();
		$pensiones = $this->Pensiones_Requerimiento_model->get_pension_area_cargo($id_req, $id_usuario);

		$salida = array();
		foreach ($archivos as $a){
			$dato = $this->requerimiento_usuario_archivo_model->get_usuario_requerimiento_archivo($id_usuario,$id_asc_area_req,$a->id);
			$aux = new StdClass();
			$tipo_archivo = isset($a->id)?$a->id:'';
			//if($tipo_archivo != 1 and $tipo_archivo != 2){
				$aux->id = $a->id;
				$aux->usuario_id = $id_usuario;
				$aux->archivo = $a->nombre;
				$aux->id_requerimiento = $id_req;
		
				$aux->datos = array();
				if (!empty($dato)){
					foreach ($dato as $d){
						$archivo = new StdClass();
						$archivo->id = $d->id;
						$archivo->nombre = urldecode($d->nombre);
						$archivo->url = $d->url;
						array_push($aux->datos, $archivo);
					}
					unset($archivo);
				}
				array_push($salida, $aux);
				unset($aux);
			//}
		}

		$salida2 = array();
		foreach ($pensiones as $p){
			$aux2 = new StdClass();
			$get_datos_pension_valores = $this->Pensiones_Valores_model->get_valores($p->id_pension_valores);
			$id_pension = isset($get_datos_pension_valores->id_pension)?$get_datos_pension_valores->id_pension:'0';
			$get_pension = $this->Pensiones_model->get_row($id_pension);
			$aux2->id_pension_req = $p->id;
			$aux2->nombre_pension = isset($get_pension->razon_social)?$get_pension->razon_social:'';
			array_push($salida2, $aux2);
			unset($aux2);
		}

		$archivos_trab = $this->Tipoarchivos_model->listar_2();
		$salida3 = array();
		foreach ($archivos_trab as $a){
			$aux3 = new StdClass();
			$aux3->id_usuario = $id_usuario;
			$aux3->nombre = $a->desc_tipoarchivo;
			$aux3->id_archivo_trabaj = $a->id;
			$aux3->id_requerimiento = $id_req;
			$get_archivo_trabaj = $this->Archivos_trab_model->get_archivo2($id_usuario, $a->id);
			$aux3->nombre_archivo_trabaj = (isset($get_archivo_trabaj->nombre))?$get_archivo_trabaj->nombre:'';
			$aux3->archivo_trabaj = (isset($get_archivo_trabaj->url))?$get_archivo_trabaj->url:'';	
			array_push($salida3, $aux3);
			unset($aux3);
		}

		$base['masso'] = $this->Evaluaciones_model->get_una_masso($id_usuario);
		$base['preocupacional'] = $this->Evaluaciones_model->get_una_preocupacional($id_usuario);
		$base['archivos'] = $salida;
		$base['datos_pension'] = $salida2;
		$base['archivos_trab'] = $salida3;
		$base['asc_area'] = $id_asc_area_req;
		$this->load->view('requerimiento/upload',$base);
	}*/

	function modal_agregar_anexo($usuario,$tipo,$asc_area, $id_req_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresas_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Region_model");
		$this->load->model("Tipo_gratificacion_model");
		$this->load->model("Descripcion_horarios_model");

		$pagina['usuario']= $usuario;
		$pagina['tipo']= $tipo;
		$pagina['asc_area']= $asc_area;
		
		$get_datos_req = $this->Requerimiento_area_cargo_model->r_get_requerimiento($id_req_area_cargo);
		//var_dump($get_datos_req);return false;
		$pagina['motivo_defecto'] = (isset($get_datos_req->motivo)?$get_datos_req->motivo:'0');
		$pagina['causal_defecto'] = (isset($get_datos_req->causal)?$get_datos_req->causal:'0');

		$existe_anexo = $this->Requerimiento_Usuario_Archivo_model->existe_registro_de_anexo($usuario, $asc_area, 2);
		$existe_contrato = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($usuario, $asc_area, 1);

		if($existe_anexo == 1){
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_ultimo_anexo($usuario, $asc_area, 2);
		}elseif($existe_contrato == 1){
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, 1);
		}else{
			$datos_req = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_archivo_limit_row($usuario, $asc_area, $tipo);
		}
		//var_dump($datos_req);

		$datos_generales = array();
		if($usuario != FALSE){
			$usr = $this->Usuarios_model->get($usuario);
			$aux = new StdClass();
			$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
			$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
			$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
			$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
			$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
			$id_banco = isset($usr->id_bancos)?$usr->id_bancos:1;
				$nombreB  = $this->Usuarios_model->getNombreBanco($id_banco);
				$aux->nombre_banco = $nombreB->desc_bancos;
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';
			$get_ciudad = $this->Ciudad_model->get($id_ciudad);
			$get_afp = $this->Afp_model->get($id_afp);
			$get_salud = $this->Salud_model->get($id_salud);
			$get_estado_civil = $this->Estadocivil_model->get($id_estado_civil);
			$get_nivel_estudios = $this->Nivelestudios_model->get($id_estudios);
			$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($asc_area);
			$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
			$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
			$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
			$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
			$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
			$get_area = $this->Areas_model->r_get($id_area);
			$get_cargo = $this->Cargos_model->r_get($id_cargo);
			$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
			$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
			$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
			$get_planta = $this->Empresa_planta_model->get($id_planta);
			$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
			$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
			$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
			$get_region_planta = $this->Region_model->get($id_region_planta);
			$aux->id_req_area_cargo = $id_req_area_cargo;
			$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
			$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
			$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
			$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
			$aux->id_empresa = isset($get_centro_costo->id)?$get_centro_costo->id:'';
			$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
			$aux->id_planta = $id_planta;
			$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
			$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
			$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
			$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
			$aux->area = isset($get_area->nombre)?$get_area->nombre:'';

			$nombres = isset($usr->nombres)?$usr->nombres:'';
			$paterno = isset($usr->paterno)?$usr->paterno:'';
			$materno = isset($usr->materno)?$usr->materno:'';
			$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
			$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
			$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
			$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
			$aux->domicilo = isset($usr->direccion)?$usr->direccion:'';
			$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
			$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
			$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
			$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
			$aux->telefono = isset($usr->fono)?$usr->fono:'';
			$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';
			array_push($datos_generales, $aux);
			unset($aux);
		}
		if ($datos_req->fecha_termino != $datos_req->fecha_termino2) {
			$pagina['finiquitado']= true;
		}else{
			$pagina['finiquitado']= false;
		}

		$jornada = isset($datos_req->jornada)?$datos_req->jornada:'';
		$get_jornada = $this->Descripcion_horarios_model->get($jornada);
		$tipo_jornada = isset($get_jornada->id_tipo_horario)?$get_jornada->id_tipo_horario:'';
		$id_empresa_planta = isset($get_datos_req->planta_id)?$get_datos_req->planta_id:'';
		$pagina['horarios_planta'] = $this->Descripcion_horarios_model->listar_planta($id_empresa_planta);
		$pagina['datos_generales'] = $datos_generales;
		$pagina['datos_req'] = $datos_req;
		$pagina['tipo_jornada'] = $tipo_jornada;
		$this->load->view('est/requerimiento/modal_crear_anexo', $pagina);
	}

	function modal_administrar_anexo($idAnexo, $id_area_cargo){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($idAnexo);
		//var_dump($datosAnexoContrato);
		$pagina['motivo'] =$this->Requerimiento_Usuario_Archivo_model->getMotivoAnexo($idAnexo);
		$pagina['datosAnexo']= $datosAnexoContrato;
		$pagina['id_planta'] = $this->Requerimiento_Usuario_Archivo_model->getIdEmpresa($datosAnexoContrato->id_planta);
		$pagina['id_area_cargo']= $id_area_cargo;
		$pagina['anexos']= $datosAnexoContrato;
		//var_dump($pagina['anexos']);
		$this->load->view('est/requerimiento/modal_administrar_anexo', $pagina);
	}

	function guardar_anexo($usuario,$tipo,$asc_area){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Ciudad_model");
		$id_area_cargo = $this->Requerimiento_asc_trabajadores_model->get($asc_area)->requerimiento_area_cargo_id;

		if (empty($_POST['fechaTerminoAnexo'])) {
			$this->session->set_userdata('error',1);
			redirect('est/requerimiento/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
		}
		if (empty($_POST['fecha_termino_contrato_anterior']) || empty($_POST['fechaTerminoAnexo']) || empty($_POST['nombre']) || empty($_POST['rut']) || empty($_POST['nacionalidad']) || empty($_POST['fecha_nacimiento']) || empty($_POST['estado_civil']) || empty($_POST['domicilo']) || empty($_POST['ciudad']) || empty($_POST['id_planta'])  ) {
			$this->session->set_userdata('error',3);
			redirect('est/requerimiento/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
		}

		if(empty($_POST['fecha_inicio_contrato']))
			$fecha_inicio = '0000-00-00';
		else
			$fecha_inicio = $_POST['fecha_inicio_contrato'];
		$get_planta = $this->Empresa_planta_model->get($_POST['id_planta']);
		$get_ciudad_planta = $this->Ciudad_model->get($get_planta->id_ciudades);
		$data = array(
			'usuario_id' => $usuario,
			'requerimiento_asc_trabajadores_id' => $asc_area,
			'id_requerimiento_area_cargo' => $_POST['id_area_cargo'],
			'tipo_archivo_requerimiento_id' => $tipo,
			'fecha_inicio_contrato' => $fecha_inicio,
			'fecha_termino_contrato_anterior' => $_POST['fecha_termino_contrato_anterior'],
			'fecha_termino_nuevo_anexo' => $_POST['fechaTerminoAnexo'],
			'fecha_termino2' => $_POST['fechaTerminoAnexo'],
			'nombres'=> $_POST['nombre'],
			'rut_usuario'=>$_POST['rut'],
			'nacionalidad' => $_POST['nacionalidad'],
			'fecha_nac' => $_POST['fecha_nacimiento'],
			'estado_civil' => $_POST['estado_civil'],
			'direccion'=>$_POST['domicilo'],
			'ciudad' => $_POST['ciudad'],
			'id_planta' => $_POST['id_planta'],
			'lugar_trabajo'=>$get_ciudad_planta->desc_ciudades,
			'afp' => $_POST['afp'],
			'salud' => $_POST['salud'],
			'nombre_centro_costo' => $_POST['nombre_centro_costo'],
			'telefono' => $_POST['telefono'],
			'nivel_estudios' => $_POST['nivel_estudios'],
			'nombre_banco' => $_POST['nombre_banco'],
			'tipo_cuenta' => $_POST['tipo_cuenta'],
			'cuenta_banco' => $_POST['cuenta_banco'],
			'nombre_planta' => $_POST['nombre_planta'],
			'causal' => $_POST['causal'],
			'id_quien_creo' => $this->session->userdata('id'),
			'estado' => 0, //0 creado , 1 en revision , 2 aprobado , 3 en proceso de baja , 4 bajado,5 eliminado
		);
		$this->session->set_userdata('error',2);
		$idAnexo = $this->Requerimiento_Usuario_Archivo_model->ingresarAnexo($data);
		if(isset($_POST['chkbxCambio'])){
			$data2 = array(
				'id_anexo'=>$idAnexo,
				'motivo'=>$_POST['nuevoMotivo'],
				);
			$this->Requerimiento_Usuario_Archivo_model->ingresarNuevoMotivoAnexo($data2);
			//var_dump($_POST['nuevoMotivo']);
		}
		redirect('est/requerimiento/contratos_req_trabajador/'.$usuario.'/'.$asc_area.'/'.$id_area_cargo.'', 'refresh');
	}

	function actualizar_anexo($id=false){
		if ($id == false) {
			redirect(base_url());
		}
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$data = array(
			'fecha_termino_nuevo_anexo' => $_POST['fechaTerminoAnexo'],
			'fecha_termino2' => $_POST['fechaTerminoAnexo'],
		);
		$this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($id, $data);
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		$this->session->set_userdata('error',4);
		redirect('est/requerimiento/contratos_req_trabajador/'.$datosAnexoContrato->usuario_id.'/'.$datosAnexoContrato->requerimiento_asc_trabajadores_id.'/'.$datosAnexoContrato->id_requerimiento_area_cargo.'', 'refresh');
	}

	function enviar_revision($id= false){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$data = array(
			'id_quien_solicita' => $this->session->userdata('id'),
			'estado' => 1,
			'fecha_solicitud' => date('Y-m-d H:i:s'),
		);
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		$get_solicitante = $this->Usuarios_general_model->get($this->session->userdata('id'));
			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
			$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
		$resultado = $this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($id, $data);
		if ($resultado == 1) {
			$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Anexo SGO - ARAUCO');
			    $this->email->to('contratos@empresasintegra.cl');
			    $this->email->cc('jcruces@empresasintegra.cl');
			    $this->email->subject("Solicitud Anexo de Contrato Trabajador: ".$datosAnexoContrato->nombres." - Fecha Inicio Contrato: ".$datosAnexoContrato->fecha_inicio_contrato);
			    $this->email->message('Estimados el administrador '.$nombre_completo_solicitante.' ha realizado una solicitud de contrato del trabajador: '.$datosAnexoContrato->nombres.' con el siguiente Rut: '.$datosAnexoContrato->rut_usuario.'.<br>Saludos');
			    $this->email->send();
			#para las notificaciones14-05-2019
			/*$data2 = array(
				'id_usu_archivo'=>$id,
				'id_quien_solicita'=>$this->session->userdata('id'),
				'nombreSolicitante'=>$nombre_completo_solicitante,
				'nombreTrabajador'=>$datosAnexoContrato->nombres,
				'tipoSolicitud'=> 2, //1.-Contrato 2.- Anexo
				'estado'=>0,
				);
			$this->Requerimiento_Usuario_Archivo_model->insertarNotificacion($data2);*/
		}

		echo json_encode($resultado);
	}

	function eliminar_anexo($id){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$data = array(
			'id_quien_elimino' => $this->session->userdata('id'),
			'estado' => 5, //0 creado , 1 en revision , 2 aprobado , 3 en proceso de baja , 4 bajado,5 eliminado
		);

		$realizado=$this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($id, $data);
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		//$this->session->set_userdata('error',6);
		/*redirect('est/requerimiento/contratos_req_trabajador/'.$datosAnexoContrato->usuario_id.'/'.$datosAnexoContrato->requerimiento_asc_trabajadores_id.'/'.$datosAnexoContrato->id_requerimiento_area_cargo.'', 'refresh');*/
		echo json_encode($realizado);
	}

		function descargar_anexo($id){
	//inicio de boton generar anexo
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$datos = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($id);
		//var_dump($datos); return false;
		if ($datos->estado == 2) {
				$template_formato = base_url()."extras/contratos/anexos/anexoArauco.docx";
				$templateWord = new TemplateProcessor($template_formato);
				$salto_linea = "<w:br/>";
				$var1 = explode('.',$datos->rut_usuario); 
				$rut1 = $var1[0];

				if($rut1 < 10){
					$datos->rut_usuario = "0".$datos->rut_usuario;
				}

				$getFechaTerminoAnterior=date($datos->fecha_termino_contrato_anterior); 
				$var1 = explode('-',$getFechaTerminoAnterior);
				$dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

				switch($mes_fi){
                   case 1: $mesTerminoAnterior="Enero"; break;
                   case 2: $mesTerminoAnterior="Febrero"; break;
                   case 3: $mesTerminoAnterior="Marzo"; break;
                   case 4: $mesTerminoAnterior="Abril"; break;
                   case 5: $mesTerminoAnterior="Mayo"; break;
                   case 6: $mesTerminoAnterior="Junio"; break;
                   case 7: $mesTerminoAnterior="Julio"; break;
                   case 8: $mesTerminoAnterior="Agosto"; break;
                   case 9: $mesTerminoAnterior="Septiembre"; break;
                   case 10: $mesTerminoAnterior="Octubre"; break;
                   case 11: $mesTerminoAnterior="Noviembre"; break;
                   case 12: $mesTerminoAnterior="Diciembre"; break;
                }

				$getFechaInicioContrato=date($datos->fecha_inicio_contrato); 
				$var2 = explode('-',$getFechaInicioContrato); 
				$dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];

				switch($mes_ft){
                   case 1: $mesInicioContrato="Enero"; break;
                   case 2: $mesInicioContrato="Febrero"; break;
                   case 3: $mesInicioContrato="Marzo"; break;
                   case 4: $mesInicioContrato="Abril"; break;
                   case 5: $mesInicioContrato="Mayo"; break;
                   case 6: $mesInicioContrato="Junio"; break;
                   case 7: $mesInicioContrato="Julio"; break;
                   case 8: $mesInicioContrato="Agosto"; break;
                   case 9: $mesInicioContrato="Septiembre"; break;
                   case 10: $mesInicioContrato="Octubre"; break;
                   case 11: $mesInicioContrato="Noviembre"; break;
                   case 12: $mesInicioContrato="Diciembre"; break;
                }

				$get_fecha_nacimiento=date($datos->fecha_nac); 
				$var3 = explode('-',$get_fecha_nacimiento); 
				$dia_fecha_nac = $var3[2];
				$mes_fecha_nac = $var3[1];
				$ano_fecha_nac = $var3[0];

				switch($mes_fecha_nac){
                   case 1: $mesFechaNacimiento="Enero"; break;
                   case 2: $mesFechaNacimiento="Febrero"; break;
                   case 3: $mesFechaNacimiento="Marzo"; break;
                   case 4: $mesFechaNacimiento="Abril"; break;
                   case 5: $mesFechaNacimiento="Mayo"; break;
                   case 6: $mesFechaNacimiento="Junio"; break;
                   case 7: $mesFechaNacimiento="Julio"; break;
                   case 8: $mesFechaNacimiento="Agosto"; break;
                   case 9: $mesFechaNacimiento="Septiembre"; break;
                   case 10: $mesFechaNacimiento="Octubre"; break;
                   case 11: $mesFechaNacimiento="Noviembre"; break;
                   case 12: $mesFechaNacimiento="Diciembre"; break;
                }


				$get_fecha_termino_nuevo=date($datos->fecha_termino_nuevo_anexo); 
				$var4 = explode('-',$get_fecha_termino_nuevo); 
				$dia_terminoAnexo = $var4[2];
				$mes_terminoAnexo = $var4[1];
				$ano_terminoAnexo = $var4[0];

				switch($mes_terminoAnexo){
                   case 1: $mesFechaTerminoAnexo="Enero"; break;
                   case 2: $mesFechaTerminoAnexo="Febrero"; break;
                   case 3: $mesFechaTerminoAnexo="Marzo"; break;
                   case 4: $mesFechaTerminoAnexo="Abril"; break;
                   case 5: $mesFechaTerminoAnexo="Mayo"; break;
                   case 6: $mesFechaTerminoAnexo="Junio"; break;
                   case 7: $mesFechaTerminoAnexo="Julio"; break;
                   case 8: $mesFechaTerminoAnexo="Agosto"; break;
                   case 9: $mesFechaTerminoAnexo="Septiembre"; break;
                   case 10: $mesFechaTerminoAnexo="Octubre"; break;
                   case 11: $mesFechaTerminoAnexo="Noviembre"; break;
                   case 12: $mesFechaTerminoAnexo="Diciembre"; break;
                }

				$fechaTerminoContratoAnterior = $dia_fi." de ".$mesTerminoAnterior." de ".$ano_fi;
				$fechaInicioContrato = $dia_ft." de ".$mesInicioContrato." de ".$ano_ft;
				$fechaNacimientoTrabajador = $dia_fecha_nac." de ".$mesFechaNacimiento." de ".$ano_fecha_nac;
				$fechaTerminoAnexo = $dia_terminoAnexo." de ".$mesFechaTerminoAnexo." de ".$ano_terminoAnexo;
				$motivoNuevoAnexo =$this->Requerimiento_Usuario_Archivo_model->getMotivoAnexo($id);
				$salto_linea = "<w:br/>";
				if ($motivoNuevoAnexo) {
					$nuevoParrafo='Primero: De común acuerdo, las partes han convenido en ampliar el Contrato de Trabajo suscrito con fecha '.$fechaInicioContrato.' quedando con fecha de término el '.$fechaTerminoAnexo.$salto_linea.'Segundo: Se establece que a partir de esta fecha el contrato del trabajador que esta por causal A, ahora será basado en el siguiente motivo: '.$motivoNuevoAnexo->motivo.'';
				}else{
					$nuevoParrafo='De común acuerdo, las partes han convenido en ampliar el Contrato de Trabajo suscrito con fecha '.$fechaInicioContrato.' quedando con fecha de término el '.$fechaTerminoAnexo.'.';
				}

				// Insertamos variables en el word
				$templateWord->setValue('lugarTrabajo',$datos->lugar_trabajo);
				$templateWord->setValue('fechaTerminoContratoAnterior',$fechaTerminoContratoAnterior);
				$templateWord->setValue('nombreTrabajador',$datos->nombres);
				$templateWord->setValue('rutTrabajador',$datos->rut_usuario);
				$templateWord->setValue('nacionalidadTrabajador',$datos->nacionalidad);
				$templateWord->setValue('nacimientoTrabajador',$fechaNacimientoTrabajador);
				$templateWord->setValue('civil',$datos->estado_civil);
				$templateWord->setValue('domicilioTrabajador',titleCase($datos->direccion));
				$templateWord->setValue('ciudad',titleCase($datos->ciudad));
				$templateWord->setValue('nuevoParrafo',$nuevoParrafo);
				//$templateWord->setValue('fechaTerminoAnexo',$fechaTerminoAnexo);


				// Guardamos el documento
				$nombre_documento = "contrato_trabajo_".$datos->nombres.".docx";
				$templateWord->saveAs("extras/contratos/anexosGenerados/".$nombre_documento);
				ob_clean();
				$get_url = "extras/contratos/anexosGenerados/".$nombre_documento;
				$url_ubicacion_archivo = (BASE_URL2.$get_url);
				header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
				echo file_get_contents($url_ubicacion_archivo);
		}else{
			header('Location:' . getenv('HTTP_REFERER'));
		}
	}
	#yayo
	function descargar_carta_termino($id_usuario, $idArchivo, $tipoArchivo){
		if (empty($id_usuario) || empty($idArchivo) || empty($tipoArchivo)  ) {
			header('Location:' . getenv('HTTP_REFERER'));
		}
		$this->load->model("Requerimiento_Usuario_Archivo_model");

		if ($tipoArchivo == 1) { // Contrato
			$datos = $this->Requerimiento_Usuario_Archivo_model->get_contrato($idArchivo);
				
		}elseif ($tipoArchivo == 2) { //Anexo de contrato
			$datos = $this->Requerimiento_Usuario_Archivo_model->get_anexo($idArchivo);
		}
		if ($datos->fecha_termino != $datos->fecha_termino2) {
			   echo "<script type='text/javascript'>";
    echo "window.history.back(-1)";
    echo "</script>";
			return false;
		}
		if ($datos) {
			$template_formato = base_url()."extras/contratos/anexos/terminoContratoArauco.docx";
			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";

			$date = $datos->fecha_termino;
			$date1 = str_replace('-', '/', $date);
			$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			$tomorrow2 = date('Y-m-d',strtotime($date1 . "+10 days"));
			#fecha de termino mas 1 dias
			$var1 = explode('-',$tomorrow); 
			$dia = $var1[2];
			$mes = $var1[1];
			$ano = $var1[0];
			switch($mes){
                   case 1: $mesTermino="Enero"; break;
                   case 2: $mesTermino="Febrero"; break;
                   case 3: $mesTermino="Marzo"; break;
                   case 4: $mesTermino="Abril"; break;
                   case 5: $mesTermino="Mayo"; break;
                   case 6: $mesTermino="Junio"; break;
                   case 7: $mesTermino="Julio"; break;
                   case 8: $mesTermino="Agosto"; break;
                   case 9: $mesTermino="Septiembre"; break;
                   case 10: $mesTermino="Octubre"; break;
                   case 11: $mesTermino="Noviembre"; break;
                   case 12: $mesTermino="Diciembre"; break;
                }
			$fechaUnoMasTermino= $dia." de ".$mesTermino." de ".$ano;
			#fecha termino real
			$var1 = explode('-',$datos->fecha_termino); 
			$dia = $var1[2];
			$mes = $var1[1];
			$ano = $var1[0];
			switch($mes){
                   case 1: $mesTermino="Enero"; break;
                   case 2: $mesTermino="Febrero"; break;
                   case 3: $mesTermino="Marzo"; break;
                   case 4: $mesTermino="Abril"; break;
                   case 5: $mesTermino="Mayo"; break;
                   case 6: $mesTermino="Junio"; break;
                   case 7: $mesTermino="Julio"; break;
                   case 8: $mesTermino="Agosto"; break;
                   case 9: $mesTermino="Septiembre"; break;
                   case 10: $mesTermino="Octubre"; break;
                   case 11: $mesTermino="Noviembre"; break;
                   case 12: $mesTermino="Diciembre"; break;
                }
			$fechaTermino= $dia." de ".$mesTermino." de ".$ano;

			$nombreTrabajador = $datos->nombres." ".$datos->paterno." ".$datos->materno;


			$festivosDelAno = array(
				    '01-01',  //  Año Nuevo (irrenunciable)
				    '19-04',  //  Viernes Santo (feriado religioso)
				    '20-04',  //  Sábado Santo (feriado religioso)
				    '01-05',  //  Día Nacional del Trabajo (irrenunciable)
				    '21-05',  //  Día de las Glorias Navales
				    '29-06',  //  San Pedro y San Pablo (feriado religioso)
				    '16-07',  //  Virgen del Carmen (feriado religioso)
				    '15-08',  //  Asunción de la Virgen (feriado religioso)
				    '18-09',  //  Día de la Independencia (irrenunciable)
				    '19-09',  //  Día de las Glorias del Ejército
				    '12-10',  //  Aniversario del Descubrimiento de América
				    '31-10',  //  Día Nacional de las Iglesias Evangélicas y Protestantes (feriado religioso)
				    '01-11',  //  Día de Todos los Santos (feriado religioso)
				    '08-12',  //  Inmaculada Concepción de la Virgen (feriado religioso)
				    '25-12',  //  Natividad del Señor (feriado religioso) (irrenunciable)
				);
				 
				$startDate = (new DateTime($datos->fecha_termino));    //inicia
				$endDate = (new DateTime($datos->fecha_termino))->modify('+30 day');    //termina
				// var_dump($endDate);
				$interval = new DateInterval('P1D'); // intervalo de un día
				/** @var \DateTime[] $date_range */
				$date_range = new DatePeriod($startDate, $interval ,$endDate); //creamos rango de fechas
				//var_dump($date_range);
				 
				$workdays = 0;
				foreach($date_range as $date){
				    //Se considera el Domingo y los feriados como no hábiles
				    if($date->format("N") <7 AND !in_array($date->format("d-m"),$festivosDelAno)){
				        ++$workdays; // se cuentan los días habiles
				        if ($workdays==10) {
				        	$diaqlo =$date;
				        }
				    }
				}

				$wenats =  $diaqlo->format('Y-m-d');
				$diaqlo2 =explode('-', $wenats);
				$dia = $diaqlo2[2] + 1;
				$mes = $diaqlo2[1];
				$ano = $diaqlo2[0];

				switch($mes){
                   case 1: $mesTermino="Enero"; break;
                   case 2: $mesTermino="Febrero"; break;
                   case 3: $mesTermino="Marzo"; break;
                   case 4: $mesTermino="Abril"; break;
                   case 5: $mesTermino="Mayo"; break;
                   case 6: $mesTermino="Junio"; break;
                   case 7: $mesTermino="Julio"; break;
                   case 8: $mesTermino="Agosto"; break;
                   case 9: $mesTermino="Septiembre"; break;
                   case 10: $mesTermino="Octubre"; break;
                   case 11: $mesTermino="Noviembre"; break;
                   case 12: $mesTermino="Diciembre"; break;
                }
                $fechaPago = $dia." de ".$mesTermino." de ".$ano;

		            $idPersona = $this->session->userdata('id');
		            $nombreSupervisor = $this->session->userdata('nombres');
					$consulta = $this->Requerimiento_Usuario_Archivo_model->consultaRD($idPersona,$id_usuario,$idArchivo);
					if ($consulta != false) {
						$totalDescargado = $consulta->total_descargado+1;
						$insertandoRDescarga = $this->Requerimiento_Usuario_Archivo_model->updateRD($consulta->id, $totalDescargado);
					}else{
						$cartaTermino= array(
							'usuario_descargo'=>$idPersona,
							'id_trabajador'=>$id_usuario,
							'id_archivo'=>$idArchivo,
							'tipo_archivo'=>$tipoArchivo,
							'total_descargado'=>1,
							);
						$insertandoRDescarga = $this->Requerimiento_Usuario_Archivo_model->insertarRD($cartaTermino);
						
						$this->load->library('email');
						$config['smtp_host'] = 'mail.empresasintegra.cl';
						$config['smtp_user'] = 'informaciones@empresasintegra.cl';
						$config['smtp_pass'] = '%SYkNLH1';
						$config['mailtype'] = 'html';
						$config['smtp_port']    = '2552';
						$this->email->initialize($config);
					    $this->email->from('informaciones@empresasintegra.cl', 'Carta de Termino Generada');
					    $this->email->to('contratos@empresasintegra.cl');
					    $this->email->subject("Carta de Termino Generada");
					    $this->email->message(' Se ha generado carta de termino por '.$nombreSupervisor.' <br> <b>Trabajador:</b> '.$nombreTrabajador.'<br><b>Planta:</b> '.$datos->nombrePlanta.'<br> <b>Fecha Termino:</b> '.$fechaTermino.' ');
					    $this->email->send();

					}   
			// Insertamos variables en el word
			$templateWord->setValue('fechaUnoMasTermino',$fechaUnoMasTermino);
			$templateWord->setValue('nombreTrabajador',$nombreTrabajador);
			$templateWord->setValue('fechaTermino',$fechaTermino);
			$templateWord->setValue('rutTrabajador',$datos->rut_usuario);
			$templateWord->setValue('diaDePago',$fechaPago);
			$templateWord->setValue('nombrePlanta',$datos->nombrePlanta);
			// Guardamos el documento
			$nombre_documento = "carta_termino_".$datos->nombres.".docx";
			$templateWord->saveAs("extras/contratos/termiContratosGenerados/".$nombre_documento);
			ob_clean();
			$get_url = "extras/contratos/termiContratosGenerados/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);
			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
			
		}else{
			header('Location:' . getenv('HTTP_REFERER'));
		}
	}

    function diashabiles(){
				$festivosDelAno = array(
				    '01-01',  //  Año Nuevo (irrenunciable)
				    '19-04',  //  Viernes Santo (feriado religioso)
				    '20-04',  //  Sábado Santo (feriado religioso)
				    '01-05',  //  Día Nacional del Trabajo (irrenunciable)
				    '21-05',  //  Día de las Glorias Navales
				    '29-06',  //  San Pedro y San Pablo (feriado religioso)
				    '16-07',  //  Virgen del Carmen (feriado religioso)
				    '15-08',  //  Asunción de la Virgen (feriado religioso)
				    '18-09',  //  Día de la Independencia (irrenunciable)
				    '19-09',  //  Día de las Glorias del Ejército
				    '12-10',  //  Aniversario del Descubrimiento de América
				    '31-10',  //  Día Nacional de las Iglesias Evangélicas y Protestantes (feriado religioso)
				    '01-11',  //  Día de Todos los Santos (feriado religioso)
				    '08-12',  //  Inmaculada Concepción de la Virgen (feriado religioso)
				    '25-12',  //  Natividad del Señor (feriado religioso) (irrenunciable)
				);
				 
				$startDate = (new DateTime('2019-03-11'));    //inicia
				$endDate = (new DateTime('2019-04-26'))->modify('+30 day');    //termina
				// var_dump($endDate);
				$interval = new DateInterval('P1D'); // intervalo de un día
				/** @var \DateTime[] $date_range */
				$date_range = new DatePeriod($startDate, $interval ,$endDate); //creamos rango de fechas
				//var_dump($date_range);
				 
				$workdays = 0;
				foreach($date_range as $date){
				    //Se considera el Domingo y los feriados como no hábiles
				    if($date->format("N") <7 AND !in_array($date->format("d-m"),$festivosDelAno)){
				        ++$workdays; // se cuentan los días habiles
				        if ($workdays==10) {
				        	$diaqlo =$date;
				        }
				    }
				}

				echo $diaqlo->format('Y-m-d');
				 var_dump($startDate);
				 var_dump($endDate);
				var_dump($workdays);
    }

    #yayo 09-04-2019

	function modal_cargar_anexo($idAnexo, $id_area_cargo= false){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$datosAnexoContrato = $this->Requerimiento_Usuario_Archivo_model->get_anexos_id($idAnexo);
		//var_dump($datosAnexoContrato);
		$pagina['datosAnexo']= $datosAnexoContrato;
		$pagina['id_planta'] = $this->Requerimiento_Usuario_Archivo_model->getIdEmpresa($datosAnexoContrato->id_planta);


		$this->load->view('est/requerimiento/modal_subir_anexo', $pagina);
	}

	function subir_anexo($idAnexo, $idAreaCargo= false){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$nb_archivo = urlencode(sanear_string($_FILES['documento']['name']));
			$salida = subir($_FILES,"documento","extras/doc_contractuales/",$nb_archivo);
			$archivo = array(
				'nombre' => $nb_archivo,
				'url' => $salida,
			);
		}else{
			$archivo = array();
		}
		
		$this->Requerimiento_Usuario_Archivo_model->actualizarAnexo($idAnexo, $archivo);
		header('Location:' . getenv('HTTP_REFERER'));
		//redirect('est/requerimiento/usuarios_requerimiento/'.$idAreaCargo, 'refresh');
	}

function solicitudes_completas($fecha = false){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresas_model");
		$this->load->model("Tipo_gratificacion_model");
		$this->load->model("Region_model");
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Usuarios_model');
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model("Descripcion_horarios_model");
		$this->load->model("Descripcion_causal_model");
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de contratos completas",
			'titulo' => "Listado solicitudes completas",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado solicitudes completas' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/exportarExcelArauco.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);
		$idUsuario= $this->session->userdata('id');
		if ($fecha =='historico') {
			$fi= false;
			$fn = false;
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->mis_solicitudes_completas($fi,$fn,$idUsuario);
			$pagina['mes'] = 'historico';
		}elseif($fecha){
			$fechaI = new DateTime($fecha);
				$fechaI->modify('first day of this month');
				$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
			$fechaT = new DateTime($fecha);
				$fechaT->modify('last day of this month');
				$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->mis_solicitudes_completas($fechaInicio, $fechaTermino,$idUsuario);
			$f= explode("-", $fecha);
				$mes =$f[1];
			setlocale(LC_TIME, 'spanish');// para que los meses sean escritos en español
			$monthNum  = $mes;
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
			$pagina['mes']= $nombreDelMes;
		}else{
			$fecha = date('Y-m-d');
			$fechaI = new DateTime($fecha);
				$fechaI->modify('first day of this month');
				$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
			$fechaT = new DateTime($fecha);
				$fechaT->modify('last day of this month');
				$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
			$trabajadores = $this->Requerimiento_Usuario_Archivo_model->mis_solicitudes_completas($fechaInicio, $fechaTermino,$idUsuario);
			setlocale(LC_TIME, 'spanish');
			$monthNum  = date('m');
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
			$pagina['mes']= $nombreDelMes;
		}
		//$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas($get_id_planta);
		$listado = array();
		if($trabajadores != FALSE){
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$id_solicitante = isset($rm->id_solicitante)?$rm->id_solicitante:'';
				$id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:NULL;
				$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_req_usu_arch);
				$id_usuario = isset($get_usu_archivo->usuario_id)?$get_usu_archivo->usuario_id:'';
				$id_req_asc_trabajador = isset($get_usu_archivo->requerimiento_asc_trabajadores_id)?$get_usu_archivo->requerimiento_asc_trabajadores_id:'';
				$get_asc_trab = $this->Requerimiento_asc_trabajadores_model->get($id_req_asc_trabajador);
				$id_req_area_cargo = isset($get_asc_trab->requerimiento_area_cargo_id)?$get_asc_trab->requerimiento_area_cargo_id:'';
				$usr = $this->Usuarios_model->get($id_usuario);
				$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$id_jornada = isset($get_usu_archivo->jornada)?$get_usu_archivo->jornada:'';
				$get_jornada = $this->Descripcion_horarios_model->get($id_jornada);

				$aux = new StdClass();
				$id_ciudad = isset($usr->id_ciudades)?$usr->id_ciudades:'';
				$id_afp = isset($usr->id_afp)?$usr->id_afp:'';
				$id_salud = isset($usr->id_salud)?$usr->id_salud:'';
				$id_estado_civil = isset($usr->id_estadocivil)?$usr->id_estadocivil:'';
				$id_estudios = isset($usr->id_estudios)?$usr->id_estudios:'';
				#12-11-2018 incorporacion banco, tipo  y numero de cuenta.
				$id_banco = isset($usr->id_bancos)?$usr->id_bancos:1;
				$nombreB  = $this->Usuarios_model->getNombreBanco($id_banco);
				$aux->nombre_banco = $nombreB->desc_bancos;
				$aux->tipo_cuenta = isset($usr->tipo_cuenta)?$usr->tipo_cuenta:'';
				$aux->cuenta_banco = isset($usr->cuenta_banco)?$usr->cuenta_banco:'';
				#Fin 12-11-2018 incorporacion banco, tipo  y numero de cuenta.
				$get_ciudad = $this->Ciudad_model->get($id_ciudad);
				$get_afp = $this->Afp_model->get($id_afp);
				$get_salud = $this->Salud_model->get($id_salud);
				$get_estado_civil = $this->Estadocivil_model->get($id_estado_civil);
				$get_nivel_estudios = $this->Nivelestudios_model->get($id_estudios);
				$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
				$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
				$id_area = isset($get_area_cargo->areas_id)?$get_area_cargo->areas_id:'';
				$id_cargo = isset($get_area_cargo->cargos_id)?$get_area_cargo->cargos_id:'';
				$get_requerimiento = $this->Requerimientos_model->get($id_requerimiento);
				$get_area = $this->Areas_model->r_get($id_area);
				$get_cargo = $this->Cargos_model->r_get($id_cargo);
				$id_centro_costo = isset($get_requerimiento->empresa_id)?$get_requerimiento->empresa_id:'';
				$id_planta = isset($get_requerimiento->planta_id)?$get_requerimiento->planta_id:'';
				$get_centro_costo = $this->Empresas_model->get($id_centro_costo);
				$get_planta = $this->Empresa_planta_model->get($id_planta);
				$id_region_planta = isset($get_planta->id_regiones)?$get_planta->id_regiones:'';
				$id_ciudad_planta = isset($get_planta->id_ciudades)?$get_planta->id_ciudades:'';
				$id_gratif_planta = isset($get_planta->id_gratificacion)?$get_planta->id_gratificacion:'';
				$get_gratif = $this->Tipo_gratificacion_model->get($id_gratif_planta);
				$get_region_planta = $this->Region_model->get($id_region_planta);
				$get_ciudad_planta = $this->Ciudad_model->get($id_ciudad_planta);

				$aux->codigo_centro_costo = isset($get_requerimiento->codigo_centro_costo)?$get_requerimiento->codigo_centro_costo:'';
				$aux->id_req_usu_arch = isset($rm->id_req_usu_arch)?$rm->id_req_usu_arch:'';
				$aux->tipo_gratificacion = isset($get_gratif->titulo)?$get_gratif->titulo:'';
				$aux->descripcion_tipo_gratificacion = isset($get_gratif->descripcion)?$get_gratif->descripcion:'';
				$aux->region_planta = isset($get_region_planta->desc_regiones)?$get_region_planta->desc_regiones:'';
				$aux->ciudad_planta = isset($get_ciudad_planta->desc_ciudades)?$get_ciudad_planta->desc_ciudades:'';
				$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:'';
				$aux->rut_centro_costo = isset($get_centro_costo->rut)?$get_centro_costo->rut:'';
				$aux->id_planta = $id_planta;
				$aux->nombre_planta = isset($get_planta->nombre)?$get_planta->nombre:'';
				$aux->direccion_planta = isset($get_planta->direccion)?$get_planta->direccion:'';
				$aux->nombre_req = isset($get_requerimiento->nombre)?$get_requerimiento->nombre:'';
				$aux->referido = isset($get_asc_trab->referido)?$get_asc_trab->referido:'';
				$aux->cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
				$aux->area = isset($get_area->nombre)?$get_area->nombre:'';
				$aux->nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;

				$nombres = isset($usr->nombres)?$usr->nombres:'';
				$paterno = isset($usr->paterno)?$usr->paterno:'';
				$materno = isset($usr->materno)?$usr->materno:'';
				$aux->nombres_apellidos = $nombres.' '.$paterno.' '.$materno;
				$aux->nombre_sin_espacios = $paterno.'_'.$materno;
				$aux->rut = isset($usr->rut_usuario)?$usr->rut_usuario:'';
				$aux->estado_civil = isset($get_estado_civil->desc_estadocivil)?$get_estado_civil->desc_estadocivil:'';
				$aux->fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$aux->domicilio = isset($usr->direccion)?$usr->direccion:'';
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:'';
				$aux->prevision = isset($get_afp->desc_afp)?$get_afp->desc_afp:'';
				$aux->salud = isset($get_salud->desc_salud)?$get_salud->desc_salud:'';
				$aux->nivel_estudios = isset($get_nivel_estudios->desc_nivelestudios)?$get_nivel_estudios->desc_nivelestudios:'';
				$aux->telefono = isset($usr->fono)?$usr->fono:'';
				$aux->nacionalidad = isset($usr->nacionalidad)?$usr->nacionalidad:'';

				$id_tipo_archivo = isset($get_usu_archivo->tipo_archivo_requerimiento_id)?$get_usu_archivo->tipo_archivo_requerimiento_id:NULL;

				if($id_tipo_archivo == 1)
					$aux->tipo_archivo = "Contrato de Trabajo";
				elseif($id_tipo_archivo == 2)
					$aux->tipo_archivo = "Anexo de Contrato";
				else
					$aux->tipo_archivo = "";

				$aux->nombre = isset($get_usu_archivo->nombre)?$get_usu_archivo->nombre:'';
				$aux->url = isset($get_usu_archivo->url)?$get_usu_archivo->url:'';
				$aux->causal = isset($get_usu_archivo->causal)?$get_usu_archivo->causal:'';
				$aux->motivo = isset($get_usu_archivo->motivo)?$get_usu_archivo->motivo:'';
				$aux->jornada = isset($get_jornada->nombre_horario)?$get_jornada->nombre_horario:'';
				$aux->renta_imponible = isset($get_usu_archivo->renta_imponible)?$get_usu_archivo->renta_imponible:'';
				$aux->bono_responsabilidad = isset($get_usu_archivo->bono_responsabilidad)?$get_usu_archivo->bono_responsabilidad:'';
				$aux->bono_gestion = isset($get_usu_archivo->bono_gestion)?$get_usu_archivo->bono_gestion:'';
				$aux->bono_confianza = isset($get_usu_archivo->bono_confianza)?$get_usu_archivo->bono_confianza:'';
				$aux->asignacion_movilizacion = isset($get_usu_archivo->asignacion_movilizacion)?$get_usu_archivo->asignacion_movilizacion:'';
				$aux->asignacion_colacion = isset($get_usu_archivo->asignacion_colacion)?$get_usu_archivo->asignacion_colacion:'';
				$aux->asignacion_zona = isset($get_usu_archivo->asignacion_zona)?$get_usu_archivo->asignacion_zona:'';
				$aux->asignacion_herramientas = isset($get_usu_archivo->asignacion_herramientas)?$get_usu_archivo->asignacion_herramientas:'';
				$aux->viatico = isset($get_usu_archivo->viatico)?$get_usu_archivo->viatico:'';
				$aux->fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'';
				$aux->fecha_termino = isset($get_usu_archivo->fecha_termino)?$get_usu_archivo->fecha_termino:'';

				$fecha_inicio = isset($get_usu_archivo->fecha_inicio)?$get_usu_archivo->fecha_inicio:'0000-00-00';
				$get_fecha_inicio=date($fecha_inicio); 
				$var1 = explode('-',$get_fecha_inicio); 
				$get_dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

				if($get_dia_fi < 10)
					$dia_fi = "0".$var1[2];
				else
					$dia_fi = $var1[2];

				if ($mes_fi=="01") $mes_letra_fi="Enero";
				if ($mes_fi=="02") $mes_letra_fi="Febrero";
				if ($mes_fi=="03") $mes_letra_fi="Marzo";
				if ($mes_fi=="04") $mes_letra_fi="Abril";
				if ($mes_fi=="05") $mes_letra_fi="Mayo";
				if ($mes_fi=="06") $mes_letra_fi="Junio";
				if ($mes_fi=="07") $mes_letra_fi="Julio";
				if ($mes_fi=="08") $mes_letra_fi="Agosto";
				if ($mes_fi=="09") $mes_letra_fi="Septiembre";
				if ($mes_fi=="10") $mes_letra_fi="Octubre";
				if ($mes_fi=="11") $mes_letra_fi="Noviembre";
				if ($mes_fi=="12") $mes_letra_fi="Diciembre";

				$fecha_termino = $get_usu_archivo->fecha_termino;
				$get_fecha_termino=date($fecha_termino); 
				$var2 = explode('-',$get_fecha_termino); 
				$get_dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];
				
				if($get_dia_ft < 10)
					$dia_ft = "0".$var2[2];
				else
					$dia_ft = $var2[2];

				if ($mes_ft=="01") $mes_letra_ft="Enero";
				if ($mes_ft=="02") $mes_letra_ft="Febrero";
				if ($mes_ft=="03") $mes_letra_ft="Marzo";
				if ($mes_ft=="04") $mes_letra_ft="Abril";
				if ($mes_ft=="05") $mes_letra_ft="Mayo";
				if ($mes_ft=="06") $mes_letra_ft="Junio";
				if ($mes_ft=="07") $mes_letra_ft="Julio";
				if ($mes_ft=="08") $mes_letra_ft="Agosto";
				if ($mes_ft=="09") $mes_letra_ft="Septiembre";
				if ($mes_ft=="10") $mes_letra_ft="Octubre";
				if ($mes_ft=="11") $mes_letra_ft="Noviembre";
				if ($mes_ft=="12") $mes_letra_ft="Diciembre";

				$fecha_nac = isset($usr->fecha_nac)?$usr->fecha_nac:'';
				$get_fecha_nacimiento=date($fecha_nac); 
				$var3 = explode('-',$get_fecha_nacimiento); 
				$dia_fecha_nac = $var3[2];
				$mes_fecha_nac = $var3[1];
				$ano_fecha_nac = $var3[0];
				if ($mes_fecha_nac=="01") $mes_letra_fecha_nac="Enero";
				if ($mes_fecha_nac=="02") $mes_letra_fecha_nac="Febrero";
				if ($mes_fecha_nac=="03") $mes_letra_fecha_nac="Marzo";
				if ($mes_fecha_nac=="04") $mes_letra_fecha_nac="Abril";
				if ($mes_fecha_nac=="05") $mes_letra_fecha_nac="Mayo";
				if ($mes_fecha_nac=="06") $mes_letra_fecha_nac="Junio";
				if ($mes_fecha_nac=="07") $mes_letra_fecha_nac="Julio";
				if ($mes_fecha_nac=="08") $mes_letra_fecha_nac="Agosto";
				if ($mes_fecha_nac=="09") $mes_letra_fecha_nac="Septiembre";
				if ($mes_fecha_nac=="10") $mes_letra_fecha_nac="Octubre";
				if ($mes_fecha_nac=="11") $mes_letra_fecha_nac="Noviembre";
				if ($mes_fecha_nac=="12") $mes_letra_fecha_nac="Diciembre";

				$aux->fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$aux->fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
				$aux->fecha_nacimiento_texto_largo = $dia_fecha_nac." de ".$mes_letra_fecha_nac." de ".$ano_fecha_nac;

				array_push($listado, $aux);
				unset($aux);
			}
		}
		$get_id_planta = '';
		$pagina['listado'] = $listado;
		$pagina['planta_seleccionada'] = $get_id_planta;
		$pagina['listado_plantas'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('contratos/listado_completas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	/*function solicitud_bajar_contrato($id_usu_arch){
		if($id_usu_arch != FALSE ){
			$motivoDeSolicitud = $_POST['value'];
			$verificandoExisteMotivo = $this->Requerimiento_Usuario_Archivo_model->getMotivoSolicitud($id_usu_arch);
			if ($verificandoExisteMotivo == false) {
				$array = array(
					'id_solicitante'=>$this->session->userdata('id'),
					'id_r_requerimiento_usuario_archivo'=>$id_usu_arch,
					'motivoSolicitud'=>$motivoDeSolicitud,
					);
				$this->Requerimiento_Usuario_Archivo_model->guardarMotivoSolicitud($array);
			}else{
				$array = array(
					'id_solicitante'=>$this->session->userdata('id'),
					'motivoSolicitud'=>$motivoDeSolicitud,
					);
				$this->Requerimiento_Usuario_Archivo_model->actualizarMotivoSolicitud($verificandoExisteMotivo->id, $array);
			}

			$data = array(
				'estado' => 4,// en proceso de baja
				);
			$this->Requerimiento_Usuario_Archivo_model->actualizar_solicitud_contrato($id_usu_arch, $data);
			$get_usu_archivo = $this->Requerimiento_Usuario_Archivo_model->get($id_usu_arch);
			$nombre = isset($get_usu_archivo->nombres)?$get_usu_archivo->nombres:'';
			$aP = isset($get_usu_archivo->paterno)?$get_usu_archivo->paterno:'';
			$aM =isset($get_usu_archivo->materno)?$get_usu_archivo->materno:'';
			$nombre_trabajador = $nombre." ".$aP." ".$aM;
			$hoy = date('Y-m-d');
				$this->load->library('email');
				$config['smtp_host'] = 'mail.empresasintegra.cl';
				$config['smtp_user'] = 'informaciones@empresasintegra.cl';
				$config['smtp_pass'] = '%SYkNLH1';
				$config['mailtype'] = 'html';
				$config['smtp_port']    = '2552';
				$this->email->initialize($config);
				//$destinatarios_cc = array('contratos@empresasintegra.cl','jsilva@empresasintegra.cl');
			    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - ENJOY');
			    $this->email->to('contratos@empresasintegra.cl');
				//$this->email->cc('jsilva@empresasintegra.cl');
			    $this->email->subject("Baja de Contrato ARAUCO Trabajador: ".$nombre_trabajador." fecha: ".$hoy." PENDIENTE ");
			    $this->email->message('Estimado(a) Hay una nueva solicitud de baja de contrato.<br> Motivo: '.$motivoDeSolicitud.'<br> Saludos');
			    $this->email->send();
			$variable=1;
		}else{
			$variable=0;//error al enviar id del requerimiento
		}
		echo json_encode($variable);
	}*/

	function solicitudes_completas_anexo($get_id_planta = false){
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de Anexos Completos",
			'titulo' => "Anexos de Contratos",
			'subtitulo' => 'Unidad de Negocio: Casa Matriz',
			'side_bar' => true,
			'lugar' => array(
							array('url' => 'usuarios/home', 'txt' => 'Inicio'), 
							array('url'=>'','txt'=>'Listado de Anexos Aprobados' )
						),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);
		$idUsuario= $this->session->userdata('id');
		$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas_anexo($get_id_planta, $idUsuario);
		$pagina['trabajadores']=$trabajadores;
		$base['cuerpo'] = $this->load->view('contratos/anexos_completos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	/*
	universidad de santiago
	direccion san pablo bajo estacion ecuador
	clinica bicentenario
	*/
	function historico_carta_termino(){
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de Anexos Completos",
			'titulo' => "Cartas de Termino generadas",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(
							array('url' => 'usuarios/home', 'txt' => 'Inicio'), 
							array('url'=>'','txt'=>'Carta de Terminos Generadas' )
						),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);
		$idUsuario= $this->session->userdata('id');
		$historico = $this->Requerimiento_Usuario_Archivo_model->getCartasTermino($idUsuario);
		$pagina['historico']=$historico;

		//var_dump(($historico));
		//return false;
		$base['cuerpo'] = $this->load->view('contratos/historico_carta_termino',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function generar_dt($fecha = null){
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		$base = array(
			'head_titulo' => "Sistema EST - Listado de solicitudes de Anexos Completos",
			'titulo' => "Generar DT",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(
							array('url' => 'usuarios/home', 'txt' => 'Inicio'), 
							array('url'=>'','txt'=>'Carta de Terminos Generadas' )
						),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','js/si_validaciones.js','js/datepickerDT.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);
		$idUsuario= $this->session->userdata('id');
		$fechaDeTermino = $fecha;
		$historico = $this->Requerimiento_Usuario_Archivo_model->getCartasTerminosAll();
		$lista = array();
		foreach ($historico as $key) {
			$generandoDT = $this->Requerimiento_Usuario_Archivo_model->getInformacionDT($key->id_trabajador);//para obtener los datos del trabajador
			if ($key->tipo_archivo ==1) { // 1 es contrato  
				$documento = $this->Requerimiento_Usuario_Archivo_model->getInformacionContrato($key->id_archivo);
			}else{// 2 es Anexo
				$documento = $this->Requerimiento_Usuario_Archivo_model->getInformacionAnexo($key->id_archivo);
			}
			if ($fechaDeTermino == $documento->fecha_termino) {
				$fechaNotificacion = date('d-m-Y',strtotime($documento->fecha_termino . "+1 days"));
				$fechaAformatear = explode('-', $documento->fecha_termino);
				$get_dia_fi = $fechaAformatear[2];
				$mes_fi = $fechaAformatear[1];
				$ano_fi = $fechaAformatear[0];

				if($get_dia_fi < 10)
					$dia_fi = "0".$fechaAformatear[2];
				else
					$dia_fi = $fechaAformatear[2];

				if ($mes_fi=="01") $mes_letra_fi="Enero";
				if ($mes_fi=="02") $mes_letra_fi="Febrero";
				if ($mes_fi=="03") $mes_letra_fi="Marzo";
				if ($mes_fi=="04") $mes_letra_fi="Abril";
				if ($mes_fi=="05") $mes_letra_fi="Mayo";
				if ($mes_fi=="06") $mes_letra_fi="Junio";
				if ($mes_fi=="07") $mes_letra_fi="Julio";
				if ($mes_fi=="08") $mes_letra_fi="Agosto";
				if ($mes_fi=="09") $mes_letra_fi="Septiembre";
				if ($mes_fi=="10") $mes_letra_fi="Octubre";
				if ($mes_fi=="11") $mes_letra_fi="Noviembre";
				if ($mes_fi=="12") $mes_letra_fi="Diciembre";
				foreach ($generandoDT as $dt) {
					$aux = new stdClass();
					//var_dump($dt);
					$rut = $dt->rut_usuario;
					$str = str_replace(".", "", $rut);
					$aa = explode('-',$str);
					$rut_tr= $aa[0];
					$dv_tr= $aa[1];
					$nombres_tr = $dt->nombres;
					$ap_paterno_tr = $dt->paterno;
					$ap_materno_tr = $dt->materno;
					if ($dt->sexo == 0) {
						$sexo = 'M';
					}elseif($dt->sexo==1){
						$sexo = 'F';
					}else
					 	$sexo='1';
					$medio_comunicacion = "P";//personal
					$oficina_correo = "www";
					$aux->rut_tr = $rut_tr;
					$aux->dv_tr = $dv_tr;
					$aux->nombres_tr = $nombres_tr;
					$aux->ap_paterno_tr = $ap_paterno_tr;
					$aux->ap_materno_tr = $ap_materno_tr;
					$aux->comuna_tr = $key->codigo;
					$aux->fechaNotificacion = $fechaNotificacion;
					$aux->sexo = $sexo;
					$aux->medio_comunicacion = $medio_comunicacion;
					$aux->oficina_correo = $oficina_correo;
					$aux->fecha_inicio = $documento->fecha_inicio;
					$aux->fecha_termino = $documento->fecha_termino;
					$aux->fecha_termino_letra = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
					array_push($lista,$aux);
					unset($aux);
				}
			}
		}
		$pagina['fechaParaDatePickerDT']= $fechaDeTermino;
		$pagina['soloParaMarina']=true;
		$pagina['dt']=$lista;
		$pagina['historico']=$historico;
		$base['cuerpo'] = $this->load->view('contratos/generar_dt',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	public function exportar_excel_dt(){
		header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo utf8_encode($_POST['datos_a_enviar2']);
	}

	function anulacionCartaTermino($id){
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		if (!empty($_POST['value']) || $_POST['value']!='') {
			$nombreSupervisor = $this->session->userdata('nombres');
			$this->load->library('email');
			$config['smtp_host'] = 'mail.empresasintegra.cl';
			$config['smtp_user'] = 'informaciones@empresasintegra.cl';
			$config['smtp_pass'] = '%SYkNLH1';
			$config['mailtype'] = 'html';
			$config['smtp_port']    = '2552';
			$this->email->initialize($config);
		    $this->email->from('informaciones@empresasintegra.cl', 'Anulacion Carta Termino SGO - ARAUCO');
		    $this->email->to('contratos@empresasintegra.cl');
		    $this->email->subject("Anular Carta Termino");
		    $this->email->message($nombreSupervisor.' ha solicitado anulacion de carta de termino<br>
		    	  <b>Trabajador:</b> '.$_POST['nombre'].'<br><b>Planta:</b> '.$_POST['planta'].'<br><b>Motivo:</b> '.$_POST['value'].' ');
		    $this->email->send();
		    $motivo= $_POST['value'];
			$this->Requerimiento_Usuario_Archivo_model->anularCT($id,$motivo);
			$resultado = 1;
		}else{
			$resultado = 2;
		}
		echo json_encode($resultado);
	}

	#yayo 14-10-2019 se crea funcion para descar masivo seleccionable de anexos y contratos

	function get_masivo_anexo($id){
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$resultado = $this->Requerimiento_asc_trabajadores_model->getTrabajadoresAnexo($id);
		$waa= ["id"=>"3","nombre"=>"gera"];
		return json_encode($waa);
	}
	function adendum($id){
		$this->load->model("Requerimientos_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("Relacion_usuario_planta_model");
		$this->load->model("Empresa_planta_model");

		$pagina['unidad_negocio'] = $this->Empresa_planta_model->listar();

		$listado = array();
		foreach($this->Requerimientos_model->get_result($id) as $r){
			$get_empresa = $this->Empresa_planta_model->get($r->planta_id);
			$aux = new stdClass();
			$aux->id = $r->id;
			$aux->codigo_requerimiento = $r->codigo_requerimiento;
			$aux->codigo_centro_costo = $r->codigo_centro_costo;
			$aux->nombre = $r->nombre;
			$aux->planta_id = $r->planta_id;
			$aux->nombre_planta = (isset($get_empresa->nombre)?$get_empresa->nombre:"");
			$aux->regimen = $r->regimen;
			$aux->causal = $r->causal;
			$aux->motivo = $r->motivo;
			$aux->f_solicitud = $r->f_solicitud;
			$aux->f_inicio = $r->f_inicio;
			$aux->f_fin = $r->f_fin;
			$aux->comentario = $r->comentario;
			array_push($listado,$aux);
		}

		$pagina['listado'] = $listado;
		$pagina['adendum'] = $this->Requerimiento_model->listarAdendum($id);
		$pagina['contar'] = $this->Requerimiento_model->contaradendum($id);
		$pagina['ultimo'] = $this->Requerimiento_model->ultimo_adendum($id);
	
		$this->load->view('requerimiento/modal_adeundum', $pagina);
	}

	function actualizar_adendum(){
		$this->load->model("Requerimiento_model");
        $this->load->model("Requerimientos_model");
        
        $fechainicio = $_POST['f_inicio'];
		if ($fechainicio){
			$datos = array('id_req' => $_POST['id_req'],
					   		'fecha_inicio' => $_POST['f_inicio'],
					   		'fecha_termino' => $_POST['fechaTerminoAnexo'] );
		}else{
			$datos = array('id_req' => $_POST['id_req'],
					   		'fecha_inicio' => $_POST['f_inicio2'],
					   		'fecha_termino' => $_POST['fechaTerminoAnexo'] );
		}
		$this->Requerimiento_model->agregar_adendum($datos);
		
		$id = $_POST['id_req'];
		$data = array('estado2' => 1 );
		$this->Requerimientos_model->cambiarestado2($id,$data);

		redirect('/est/requerimiento/listado/', 'refresh');

	}

	function descargar_adendum_puesta_disposicion($id_req,$id,$i){
		$this->load->library('zip');
		$this->load->helper('download');
		$this->load->model('Requerimientos_model');
		$this->load->model('Requerimiento_area_cargo_model');
		$requerimientos = $this->Requerimientos_model->getRequerimientoPuesto($id_req);
		$ac = $this->Requerimiento_area_cargo_model->getReqContratoPuestoDisposicion($id_req);
		$adendum = $this->Requerimientos_model->buscar_adendum($id);
		$contador = $this->Requerimientos_model->contarreq($id_req,$requerimientos->idPlanta);
		$i = $i + 1;
		$data = array('estado2' => 2 );
		$this->Requerimientos_model->cambiarestado2($id_req,$data);
		
		//$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fechaHoy = date('d')." de ".$meses[date('n')-1]. " de ".date('Y') ;

		#obteniendo la cantidad de dias que dura el requerimiento
		$fecha1 = new DateTime($adendum->fecha_inicio);
	    $fecha2 = new DateTime($adendum->fecha_termino);
	    $resultado = $fecha1->diff($fecha2);
	    $totalDiasRequerimiento = $resultado->format('%a') +1;
	    if($requerimientos->idPlanta == "1")
		$codigo = "Celco ".$contador."-".date('Y')."/AD".$i;
		elseif ($requerimientos->idPlanta == "2") {
		$codigo = "CPA-".$contador."-".$i."-".date('Y');
	   }elseif ($requerimientos->idPlanta == "3") {
		$codigo = "CNA-".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "4") {
		$codigo = "Celic ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "5") {
		$codigo = "Celva ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "6") {
		$codigo = "Remvi ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "8") {
		$codigo = "Remva ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "9") {
		$codigo = "Asviñ ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "10") {
		$codigo = "AEC-".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "11") {
		$codigo = "ANA-".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "15") {
		$codigo = "Asval ".$contador."-".date('Y')."/AD".$i;
		}elseif ($requerimientos->idPlanta == "16") {
		$codigo = "Madte".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "17") {
		$codigo = "TNA-".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "19") {
		$codigo = "Bioen ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "20") {
		$codigo = "Caman ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "21") {
		$codigo = "Celgic ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "22") {
		$codigo = "Celtra ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "23") {
		$codigo = "SEI-".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "24") {
		$codigo = "ADM-".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "27") {
		$codigo = "EMI ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "28") {
		$codigo = "Forva ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "29") {
		$codigo = "Ewos ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "30") {
		$codigo = "Forchi ".$contador."-".date('Y')."/AD".$i;
	   }elseif ($requerimientos->idPlanta == "31") {
		$codigo = "Forco ".$contador."-".date('Y')."/AD".$i;
	   }else{
	   	$contador1= $contador + 103;
		$codigo = "AND ".$contador1."-".date('Y')."/AD".$i;
	   }

	    		$fecha_inicio = $adendum->fecha_inicio;
	    		
				$get_fecha_inicio=date($fecha_inicio); 
				$var1 = explode('-',$get_fecha_inicio); 
				$get_dia_fi = $var1[2];
				$mes_fi = $var1[1];
				$ano_fi = $var1[0];

				if($get_dia_fi < 10)
					$dia_fi = $var1[2];
				else
					$dia_fi = $var1[2];

				if ($mes_fi=="01") $mes_letra_fi="Enero";
				if ($mes_fi=="02") $mes_letra_fi="Febrero";
				if ($mes_fi=="03") $mes_letra_fi="Marzo";
				if ($mes_fi=="04") $mes_letra_fi="Abril";
				if ($mes_fi=="05") $mes_letra_fi="Mayo";
				if ($mes_fi=="06") $mes_letra_fi="Junio";
				if ($mes_fi=="07") $mes_letra_fi="Julio";
				if ($mes_fi=="08") $mes_letra_fi="Agosto";
				if ($mes_fi=="09") $mes_letra_fi="Septiembre";
				if ($mes_fi=="10") $mes_letra_fi="Octubre";
				if ($mes_fi=="11") $mes_letra_fi="Noviembre";
				if ($mes_fi=="12") $mes_letra_fi="Diciembre";

				$fecha_termino = $adendum->fecha_termino;
				
				$get_fecha_termino=date($fecha_termino); 
				$var2 = explode('-',$get_fecha_termino); 
				$get_dia_ft = $var2[2];
				$mes_ft = $var2[1];
				$ano_ft = $var2[0];
				
				if($get_dia_ft < 10)
					$dia_ft = $var2[2];
				else
					$dia_ft = $var2[2];

				if ($mes_ft=="01") $mes_letra_ft="Enero";
				if ($mes_ft=="02") $mes_letra_ft="Febrero";
				if ($mes_ft=="03") $mes_letra_ft="Marzo";
				if ($mes_ft=="04") $mes_letra_ft="Abril";
				if ($mes_ft=="05") $mes_letra_ft="Mayo";
				if ($mes_ft=="06") $mes_letra_ft="Junio";
				if ($mes_ft=="07") $mes_letra_ft="Julio";
				if ($mes_ft=="08") $mes_letra_ft="Agosto";
				if ($mes_ft=="09") $mes_letra_ft="Septiembre";
				if ($mes_ft=="10") $mes_letra_ft="Octubre";
				if ($mes_ft=="11") $mes_letra_ft="Noviembre";
				if ($mes_ft=="12") $mes_letra_ft="Diciembre";

			


				$fecha_inicio_texto_largo = $dia_fi." de ".$mes_letra_fi." de ".$ano_fi;
				$fecha_termino_texto_largo = $dia_ft." de ".$mes_letra_ft." de ".$ano_ft;
					





		if ($requerimientos->letraCausal== 'A') {
			$descripcionCausal = 'Suspensión del contrato de trabajo o de la obligación de prestar servicios, según corresponda, de uno o más trabajadores por licencias médicas, descansos de maternidad o feriados';
			//articulo quinto
			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será de '.$totalDiasRequerimiento.' días, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 1°, podrá prorrogarse hasta cubrir el tiempo de duración de la ausencia del trabajador reemplazado.';

		}elseif($requerimientos->letraCausal == 'C'){
			$descripcionCausal = 'proyectos nuevos y específicos de la usuaria, tales como la construcción de nuevas instalaciones, la ampliación de las ya existentes o expansión a nuevos mercados';

			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será de '.$totalDiasRequerimiento.' días, considerando la totalidad de los trabajadores requeridos, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 3°, el contrato de trabajo junto a sus anexos para prestar servicios en una misma usuaria, por esta causal, no podrá exceder de 180 días a nivel individual de los trabajadores.';

		}elseif($requerimientos->letraCausal == 'E'){
			$descripcionCausal = 'Aumentos ocasionales, sean o no periódicos, o extraordinarios de la actividad de toda la Empresa Usuaria o en una determinada sección, sucursal, planta, faena o establecimiento de la misma';
			$articuloQuinto = 'La duración de los servicios prestados bajo la causal dispuesta en el artículo 183 Ñ del Código del Trabajo contratados será un total de '.$totalDiasRequerimiento.' días, considerando la totalidad de los trabajadores requeridos, no obstante, de acuerdo a lo señalado en el Art. 183-O inciso 3°, el contrato de trabajo para prestar servicios en una misma usuaria, por esta causal, no podrá exceder de 90 días a nivel individual de los trabajadores.';
		}

				if ($requerimientos->id_empresa == 7 ){
					$template_formato = base_url()."extras/contratos/formatos_contrato_disposicion/formatoContratoPuestaDisposicionewosadendum.docx";
				}
				if ($requerimientos->id_empresa == 13 ){
					$template_formato = base_url()."extras/contratos/formatos_contrato_disposicion/formatoContratoPuestaDisposicionandritzAdendum.docx";
				}else{
			$template_formato = base_url()."extras/contratos/formatos_contrato_disposicion/formatoContratoPuestaDisposicionAraucoadendum.docx";
		}
			$templateWord = new TemplateProcessor($template_formato);
			$salto_linea = "<w:br/>";
			
			$templateWord->setValue('codigo', $codigo);
			$templateWord->setValue('fechaHoy', $fechaHoy);
			$templateWord->setValue('nombreCiudad',$requerimientos->nombreCiudad);
			$templateWord->setValue('domicilioGerente',$requerimientos->direccionPlanta);
			$templateWord->setValue('razonSocial',$requerimientos->razonSocial);
			$templateWord->setValue('razonSocialMayus',strtoupper($requerimientos->razonSocial));
			$templateWord->setValue('rut',$requerimientos->rut);
			$templateWord->setValue('nombrePlanta',$requerimientos->nombrePlanta);
			$templateWord->setValue('nombreGerente',$requerimientos->nombreGerente);
			$templateWord->setValue('rutGerente',$requerimientos->rutGerente);
			$templateWord->setValue('letraCausal',$requerimientos->letraCausal);
			$templateWord->setValue('descripcionCausal',$descripcionCausal);
			$templateWord->setValue('motivo',$requerimientos->motivo);
			$templateWord->setValue('articuloQuinto',$articuloQuinto);
			$templateWord->setValue('totalDiasRequerimiento',$totalDiasRequerimiento);
			$templateWord->setValue('fechainicioreq',$fecha_inicio_texto_largo);
			$templateWord->setValue('fechaterminoreq',$fecha_termino_texto_largo);
			$i = 0;
			$ValorReTotal = 0;

			foreach ($ac as $key) {
				$nombreArea[] = $key->nombreArea;
				$cantidadTrabajadores[] = $key->cantidadTrabajadores;
				$totalDiasReq = $totalDiasRequerimiento*$key->cantidadTrabajadores;
				$nombreCargo[] = $key->nombreCargo;
				$sueldoBase= $key->valor;
				$sueldoBasePorcentaje[$i] = $sueldoBase*0.25;
				if ($sueldoBasePorcentaje[$i] < 129240) {
					$sueldoBaseMasGratificacion[$i] =  $sueldoBase+$sueldoBasePorcentaje[$i];
				}else{
				$sueldoBaseMasGratificacion[$i] = $sueldoBase+129240;
				}
				$subtotal[$i] = ($sueldoBaseMasGratificacion[$i]/30)*$totalDiasReq;//$totalDiasRequerimiento Reemplazar por 1;
				$valorTotal[$i] = $subtotal[$i]+(($subtotal[$i]*0.935/100))+(($subtotal[$i]*2.3)/100)+($subtotal[$i]*0.03)+((2000/30)*$totalDiasReq);//$totalDiasRequerimiento Reemplazar por 1;
				$valorTotalRedondeado[$i] = round($valorTotal[$i]);
				$ValorReTotal = $ValorReTotal+ $valorTotalRedondeado[$i];
				$i++;
			}
			$ValorReTotalPalabras = num2letras($ValorReTotal);
			//$subtotal = ($sueldoBaseMasGratificacion[$i]/30)*$totalDiasRequerimiento;
			$templateWord->setValue('totalredondeado',$ValorReTotal);
			$templateWord->setValue('totalredondeadopalabras',$ValorReTotalPalabras);

			$templateWord->cloneRow('cargo', count($ac));
			for ($r = 1; $r <= count($ac); $r++) {
				$templateWord->setValue('cargo#'.$r,$nombreCargo[$r-1]);
				$templateWord->setValue('numero#'.$r,$cantidadTrabajadores[$r-1]);
				$templateWord->setValue('area#'.$r,$nombreArea[$r-1]);
				$templateWord->setValue('valor#'.$r,$valorTotalRedondeado[$r-1]);
			}
			// Guardamos el documento
			$nombre_documento = "contrato_trabajo_.docx";
			$templateWord->saveAs("extras/contratos/contratosDisposicionGenerados/".$nombre_documento);
			ob_clean();
			$get_url = "extras/contratos/contratosDisposicionGenerados/".$nombre_documento;
			$url_ubicacion_archivo = (BASE_URL2.$get_url);

			header("Content-Disposition: attachment; filename=".$nombre_documento."; charset=iso-8859-1");
			echo file_get_contents($url_ubicacion_archivo);
	
	}

}
?>