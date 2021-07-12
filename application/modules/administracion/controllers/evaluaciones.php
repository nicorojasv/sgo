<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Evaluaciones extends CI_Controller {
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
		
	}
	
	function crear(){

		$base = array(
			'head_titulo' => "Sistema EST - Crear evaluaciones",
			'titulo' => "Crear evaluaciones",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url' => 'administracion/evaluaciones/index', 'txt' => 'Evaluaciones'), array('url' => '', 'txt' => 'Crear')),
			'menu' => $this->load->view('layout2.0/menus/menu_admin',$this->requerimiento,TRUE)
		);
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->helper('urlencrypt');
		
		$pagina['listado_tipos'] = $this->Evaluacionestipo_model->listar();
		$pagina['listado_eval'] = $this->Evaluacionesevaluacion_model->listar();

		$base['cuerpo'] = $this->load->view('evaluaciones/crear',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	
	function modal_editar_evaluacion($id){
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Evaluacionesevaluacion_model");
		
		$base['listado_tipos'] = $this->Evaluacionestipo_model->listar();
		$base['eval'] = $this->Evaluacionesevaluacion_model->get($id);
		$base['id'] = $id;
		$this->load->view('evaluaciones/modal_editar_eval',$base);
	}
	
	function editar_evaluacion($id){
		$this->load->model("Evaluacionesevaluacion_model");
		$tipo = trim($_POST['tipo_eval']);
		$nb = trim($_POST['eval']);
		$abr = trim($_POST['abre']);
		$res = $_POST['resultado'];
		
		if(!empty($tipo) && !empty($nb)){
			$data = array(
				'id_tipo' => $tipo,
				'nombre' => mb_strtoupper($nb, 'UTF-8'),
				'abreviacion' => mb_strtoupper($abr, 'UTF-8'),
				'tipo_resultado' => $res
			);
			$this->Evaluacionesevaluacion_model->editar($id,$data);
		}
		redirect('/administracion/evaluaciones/crear', 'refresh');
	}
	
	function eliminar_evaluacion($id){
		$this->load->model("Evaluacionesevaluacion_model");
		$this->Evaluacionesevaluacion_model->eliminar($id);
	}
	
	function archivo(){
		$base['titulo'] = "Crear evaluaciones";
		$base['lugar'] = "Evaluar con archivo";
		
		$this->load->model("Evaluacionestipo_model");
		
		$pagina['listado_tipos'] = $this->Evaluacionestipo_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('evaluaciones/archivo',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar_tipo(){
		$this->load->model("Evaluacionestipo_model");
		$nb = trim($_POST['cat']);
		if(!empty($nb)){
			$data = array(
				'nombre' => mb_strtoupper($nb, 'UTF-8')
			);
			$this->Evaluacionestipo_model->ingresar($data);
		}
		redirect('/administracion/evaluaciones/crear', 'refresh');
	}
	
	function guardar_categoria(){
		$this->load->model("Evaluacionesevaluacion_model");
		$tipo = trim($_POST['tipo_eval']);
		$nb = trim($_POST['eval']);
		$abr = trim($_POST['abre']);
		$res = $_POST['resultado'];
		
		if(!empty($tipo) && !empty($nb)){
			$data = array(
				'id_tipo' => $tipo,
				'nombre' => mb_strtoupper($nb, 'UTF-8'),
				'abreviacion' => mb_strtoupper($abr, 'UTF-8'),
				'tipo_resultado' => $res
			);
			$this->Evaluacionesevaluacion_model->ingresar($data);
		}
		redirect('/administracion/evaluaciones/crear', 'refresh');
	}
	
	function subir(){ //subir excel con evaluaciones
		$this->load->model("Evaluaciones_model");
		$this->load->helper("archivo");
		$this->load->helper("excel");
		$base['titulo'] = "Log de Subida de evaluaciones";
		$base['lugar'] = "Log evaluaciones";
		
		if($_FILES['archivo']['error'] == 0){
			$salida = trabajadores($_FILES, 'archivo', 'extras/docs_temp/','evaluaciones');
			if($salida == 1)
				redirect('administracion/trabajadores/subir_archivo/error_formato', 'refresh');
			elseif($salida == 2)
				redirect('administracion/trabajadores/subir_archivo/error_copiar', 'refresh');
			else{
				
				$this->load->library('PHPExcel');
				$this->load->library('PHPExcel/IOFactory');
				$errores = array();
				if (file_exists(BASE_URL2.$salida)) {
				    //echo "El fichero existe<br/>";
				} else {
				   	//echo "El fichero no existe<br/>";
				}
				$objPHPExcel = new PHPExcel();
				$objReader = IOFactory::load(BASE_URL2.$salida);
				$lista_texto1 = array('PLANTA','RUT','TIPO EVALUACION','EVALUACION','CARGO','FECHA EVALUACION','FAENA','AREA','RESULTADO','RECOMIENDA','OBSERVACIONES');
				$lista_texto2 = array('RUT','TIPO EVALUACION','EVALUACION','FECHA EVALUACION','FECHA VIGENCIA','RESULTADO','OBSERVACIONES');
				$lista_asoc1 = array('id_planta','id_usuarios','id_evaluacion','id_cargo','fecha_e','faena','id_area','resultado','recomienda','observaciones');
				$lista_asoc2 = array('id_usuarios','id_evaluacion','fecha_e','fecha_v','resultado','observaciones');
				$lista_arr = array();
				//validar si la table contiene datos llenos y/o sin los nombres correctos
				foreach ($objReader->getWorksheetIterator() as $worksheet) {
				    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
				    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					$highestColumnIndex = (int)$highestColumnIndex;
					for ($row = 1; $row <= 1; $row++){
				        for($col = 0; $col < $highestColumnIndex; $col++) {
				            $cell = $worksheet->getCellByColumnAndRow($col, $row);
				            $val = trim($cell->getValue());
							if($val != ""){
								$lista_arr[] = $val;
							}
				        }
				    }
				    
				}
				
				//print_r($lista_arr);echo "<br />";
				
				if(count(array_diff($lista_arr, $lista_texto1)) === 0){
					//echo "es texto 1";
					$salida = importar_eval_largo($salida,$lista_texto1,$lista_asoc1);
				}
				elseif(count(array_diff($lista_arr, $lista_texto2)) === 0){
					//echo "es texto 2<br />";
					$salida = importar_eval_corto($salida,$lista_texto2,$lista_asoc2);
				}
				else{
					//echo "es nada";
					$salida = false;
				}
			}
		}
		else{
			redirect('administracion/trabajadores/subir_archivo/error', 'refresh');
		}
		$total_correcto = count($salida['correcto']);
		if( $total_correcto > 0){
			$consulta = $salida['consulta']; 
			$z = 0;
			foreach($salida['correcto'] as $c){
				$z++;
				$consulta.= $c;
				if($z < $total_correcto)
					$consulta.= ',';
			}
			$consulta.=";";
			$this->Evaluaciones_model->manual($consulta);
		}
		
		$pagina['resultados'] = $salida;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('evaluaciones/subir_errores',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function listado($id_tipo){
		
		if(empty($id_tipo))
			redirect('/error/error404', 'refresh');

		$base = array(
			'head_titulo' => "Sistema EST - Listado de evaluaciones",
			'titulo' => "Listado de evaluaciones añadidas",
			'subtitulo' => '',
			'side_bar' => false,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url' => 'administracion/evaluaciones/index', 'txt' => 'Evaluaciones'), array('url' => '', 'txt' => 'Listado')),
			'menu' => $this->load->view('layout2.0/menus/menu_admin','',TRUE),
			'css' => array('plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'js' => array('plugins/bootstrap-modal/js/bootstrap-modal.js','plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/ui-modals.js','js/listado_evaluaciones2.js')
		);

		$this->load->library('pagination');
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Planta_model");
		//echo $this->uri->total_segments();
		
		if( !$this->Evaluacionestipo_model->get($id_tipo) )
			redirect('/error/error404', 'refresh');
		
		if($this->uri->total_segments() == 4 || $this->uri->total_segments() == 5){
			$pag_actual = 0;
			$config['uri_segment'] = 5;
			$config['base_url'] = base_url().'/administracion/evaluaciones/listado/'.$id_tipo.'/pagina/';
			$asociacion[0]['nombre'] = FALSE;
			$asociacion[0]['rut'] = FALSE;
			$asociacion[0]['evaluacion'] = FALSE;
			$asociacion[0]['planta'] = FALSE;
			$asociacion[0]['tipo'] = FALSE;
			$asociacion[0]['rango_1'] = FALSE;
			$asociacion[0]['rango_2'] = FALSE;
			$asociacion[0]['radio'] = 4;
		}
		else{
			$asc = $this->uri->uri_to_assoc(5);
			if($this->uri->total_segments() == 6 && empty($asc['filtro'])){
				if(empty($asc['pagina'])) $pag_actual = 0;
				else $pag_actual = $asc['pagina'];
				$config['uri_segment'] = 6;
				$config['base_url'] = base_url().'/administracion/evaluaciones/listado/'.$id_tipo.'/pagina/';
				$asociacion[0]['radio'] = 4;
				$asociacion[0]['nombre'] = FALSE;
				$asociacion[0]['rut'] = FALSE;
				$asociacion[0]['evaluacion'] = FALSE;
				$asociacion[0]['planta'] = FALSE;
				$asociacion[0]['tipo'] = FALSE;
				$asociacion[0]['rango_1'] = FALSE;
				$asociacion[0]['rango_2'] = FALSE;
			}
			else{
				if(empty($asc['pagina'])) $pag_actual = 0;
				else $pag_actual = $asc['pagina'];
				$config['uri_segment'] = 8;
				$config['base_url'] = base_url().'/administracion/evaluaciones/listado/'.$id_tipo.'/filtro/'.$asc['filtro'].'/pagina/';
				if(!empty($asc['filtro'])){ //si existe el filtro entonces........
					$filtro = urldecode($asc['filtro']);
					
					$filtro = $this->encrypt->decode( url_to_encode($filtro) );
					$fil = explode("/",$filtro);
					$asociacion = array();
					$aux = array(
						$fil[0] => $fil[1],
						$fil[2] => $fil[3],
						$fil[4] => $fil[5],
						$fil[6] => $fil[7],
						$fil[8] => $fil[9],
						$fil[10] => $fil[11],
						$fil[12] => $fil[13],
						$fil[14] => $fil[15]
					 );
					array_push($asociacion,$aux);
					unset($aux);
				}
			}
		}
		
		if(!empty($asociacion[0]['rango_1']) && !empty($asociacion[0]['rango_2'])){
			$this->load->helper("fechas");
			$fecha1 = explode(" ",$asociacion[0]['rango_1']);
			$fecha2 = explode(" ",$asociacion[0]['rango_2']);
			$mes1 = mesXdia($fecha1[1]);
			$mes2 = mesXdia($fecha2[1]);
			$fecha_rango1 = $fecha1[2]. '-'. $mes1. '-'. $fecha1[0]; 
			$fecha_rango2 = $fecha2[2]. '-'. $mes2. '-'. $fecha2[0];
		}
		else{
			$fecha_rango1 = $asociacion[0]['rango_1']; 
			$fecha_rango2 = $asociacion[0]['rango_2'];
		}
		
		$config['per_page'] = 15;
		//echo "valor radio => ".$asociacion[0]['radio'];
		if($asociacion[0]['radio'] == 1){
			$config['total_rows'] = $this->Evaluaciones_model->total_filtro_test_vigente($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2);
		}
		elseif($asociacion[0]['radio'] == 2){
			$config['total_rows'] = $this->Evaluaciones_model->total_filtro_test_novigente($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2);
		}
		elseif($asociacion[0]['radio'] == 3){
			$config['total_rows'] = $this->Evaluaciones_model->total_filtro_test_sinevaluacion($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2);
		}
		elseif($asociacion[0]['radio'] == 4){
			$config['total_rows'] = $this->Evaluaciones_model->total_filtro_test_todo($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2);
		}
		else{
			$config['total_rows'] = $this->Evaluaciones_model->total_filtro_test($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2);
		}
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

		
		//echo $config['uri_segment'] = 4;
		//$pag_actual = ($this->uri->segment(5) === FALSE)? 0 : $this->uri->segment(5);
		
		$pagina['paginado']	= $this->pagination->create_links();
		
		$pagina['totales'] = $config['total_rows'];
		if($asociacion[0]['radio'] == 1){
			$totales = $this->Evaluaciones_model->filtro_test_vigente($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2,$config['per_page'],$pag_actual);
		}
		elseif($asociacion[0]['radio'] == 2){
			$totales = $this->Evaluaciones_model->filtro_test_novigente($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2,$config['per_page'],$pag_actual);
		}
		elseif($asociacion[0]['radio'] == 3){
			$totales = $this->Evaluaciones_model->filtro_test_sinevaluacion($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2,$config['per_page'],$pag_actual);
		}
		elseif($asociacion[0]['radio'] == 4){
			$totales = $this->Evaluaciones_model->filtro_test_todo($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2,$config['per_page'],$pag_actual);
		}
		else{
			$totales = $this->Evaluaciones_model->filtro_test($id_tipo,$asociacion[0]['nombre'],$asociacion[0]['rut'],$asociacion[0]['planta'],$asociacion[0]['tipo'],$fecha_rango1,$fecha_rango2,$config['per_page'],$pag_actual);
		} 
		$pagina['listado'] = $totales;
		
		$pagina['input_nombre'] = $asociacion[0]['nombre'];
		$pagina['input_rut'] = $asociacion[0]['rut'];
		$pagina['input_eval'] = $asociacion[0]['evaluacion'];
		$pagina['input_planta'] = $asociacion[0]['planta'];
		$pagina['input_tipo'] = $asociacion[0]['tipo'];
		$pagina['input_rango1'] = $asociacion[0]['rango_1'];
		$pagina['input_rango2'] = $asociacion[0]['rango_2'];
		$pagina['input_radio'] = $asociacion[0]['radio'];
		$pagina['sin_planta'] = ($id_tipo == 2 || $id_tipo == 3) ? TRUE : FALSE;
		$pagina['con_vigencia'] = ($id_tipo != 1) ? TRUE : FALSE;
		$pagina['id_tipo'] = $id_tipo;
		$pagina['tipo'] = $this->Evaluacionestipo_model->get($id_tipo)->nombre;
		$pagina['listado_planta'] = $this->Planta_model->listar();
		$pagina['listar_tipo'] = $this->Evaluacionesevaluacion_model->get_tipo($id_tipo);
		$pagina['listado_eval'] = $this->Evaluacionestipo_model->listar();
		$pagina['url'] = urlencode($this->encrypt->encode(current_url()));
		//$base['cuerpo'] = $this -> load -> view('evaluaciones/listado',$pagina,TRUE);
		$base['cuerpo'] = $this->load->view('evaluaciones/listado_nuevo',$pagina,TRUE);

		$this->load->view('layout2.0/layout',$base);
	}
	function filtrar($id_tipo){
		if(empty($id_tipo))
			redirect('/error/error404', 'refresh');
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		if(empty($_POST['radio_eval'])) $_POST['radio_eval'] = FALSE;
		if(empty($_POST['nombre']) ) $_POST['nombre'] = FALSE;
		if(empty($_POST['rut']) ) $_POST['rut'] = FALSE;
		if(empty($_POST['evaluacion']) ) $_POST['evaluacion'] = FALSE;
		if(empty($_POST['planta']) ) $_POST['planta'] = FALSE;
		if(empty($_POST['tipo']) ) $_POST['tipo'] = FALSE;
		if(empty($_POST['rango_1']) ) $_POST['rango_1'] = FALSE;
		if(empty($_POST['rango_2']) ) $_POST['rango_2'] = FALSE;
		$url = "radio/".$_POST['radio_eval']."/nombre/".$_POST['nombre']."/rut/".$_POST['rut']."/evaluacion/".$_POST['evaluacion']."/planta/".$_POST['planta']."/tipo/".$_POST['tipo']."/rango_1/".$_POST['rango_1']."/rango_2/".$_POST['rango_2'];
		$enc = $this->encrypt->encode($url);
		$enc = encode_to_url($enc);
		$enc = urlencode($enc);
		redirect('/administracion/evaluaciones/listado/'.$id_tipo.'/filtro/'.$enc, 'refresh');
	}

	function ajax_fechaPrimeraEval(){
		$this->load->model("Evaluaciones_model");
		echo $this->Evaluaciones_model->primera_evaluacion()->fecha_e;
	}
	function ajax_SubmitBusqueda($arreglo){
		
	}
	
	function ajax_subirDocumento(){
		$id_eval = $_POST['id'];
		$url = $_POST['url'];
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesarchivo_model");
		$this->load->library('encrypt');
		
		if($this->Evaluacionesarchivo_model->get($id_eval))
			$base['eval'] = $id_eval;
		else
			$base['eval'] = false;
		$base['id_eval'] = $id_eval;
		$base['redirect'] = $url;
		$this->load->view('evaluaciones/modal_subir_archivo',$base);
	}
	
	function ajax_urlEncriptada(){
		$this->load->library('encrypt');
		echo urlencode($this->encrypt->encode($_POST['url']));
	}
	
	function subir_archivo(){
		$this->load->library('encrypt');
		$this->load->helper("archivo");
		$this->load->model("Evaluacionesarchivo_model");
		
		$url = $this->encrypt->decode(urldecode($_POST['redirect']));
		
			//redirect($url.'#error0', 'refresh');
			
		$salida = @subir($_FILES,"documento","extras/evaluaciones/");
		
		if($salida == 1)
			redirect($url, 'refresh');
		elseif($salida==2)
			redirect($url, 'refresh');
		else{
			if($archivo = $this->Evaluacionesarchivo_model->get($_POST['id_eval'])){
				$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
				$ruta_prin = $ruta_prin[0];
				unlink($ruta_prin.$archivo->url);
				$this->Evaluacionesarchivo_model->eliminar($archivo->id);
			}
			$data = array(
				'id_evaluacion' => $_POST['id_eval'],
				'url' => $salida
			);
			$this->Evaluacionesarchivo_model->ingresar($data);
			redirect($url, 'refresh');
		}
	}
	
	function ajax_eliminarArchivo($id){
		$this->load->helper("archivo");
		$this->load->model("Evaluacionesarchivo_model");
		
		$archivo = $this->Evaluacionesarchivo_model->get($id);
		$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
		$ruta_prin = $ruta_prin[0];
		unlink($ruta_prin.$archivo->url);
		$this->Evaluacionesarchivo_model->eliminar($archivo->id);
	}
	
	function editar($id = FALSE,$id_usr = FALSE){
		if(!$id || !$id_usr){
			redirect('/administracion/evaluaciones/listado', 'refresh');
		}
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Evaluacionesarchivo_model");
		$this->load->helper("fechas");
		
		//$base['eval'] = $this->Evaluaciones_model->get($id); 
		//$base['archivo'] = $this->Evaluacionesarchivo_model->get($id);
		$base['id_eval'] = $id;
		$base['salida'] = $this->Evaluaciones_model->ob_usuario($id_usr,$id);

		$this->load->view('evaluaciones/modal_editar',$base);
	}
	
	
	function ajax_eliminar($id = FALSE){
		if(!$id){
			redirect('/administracion/evaluaciones/listado', 'refresh');
		}
		
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Evaluacionesarchivo_model");
		
		$archivo = $this->Evaluacionesarchivo_model->get($id);
		$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
		$ruta_prin = $ruta_prin[0];
		unlink($ruta_prin.$archivo->url);
		$this->Evaluacionesarchivo_model->eliminar($archivo->id);
		$this->Evaluaciones_model->eliminar($id);
	}
	
	function edicion_evaluacion(){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesarchivo_model");
		$this->load->helper("archivo");
		foreach( array_keys($_POST['ano_e']) as $v => $s){
			$fecha_e = $_POST['ano_e'][$s].'-'.$_POST['mes_e'][$s].'-'.$_POST['dia_e'][$s];
			if(isset($_POST['ano_v'][$s]) && isset($_POST['mes_v'][$s]) && isset($_POST['dia_v'][$s])){
			$fecha_v = $_POST['ano_v'][$s].'-'.$_POST['mes_v'][$s].'-'.$_POST['dia_v'][$s];}
			else {$fecha_v = '0000-00-00';}
			$edit = array(
				'observaciones' => trim( mb_strtoupper($_POST['obs'][$s], 'UTF-8')),
				'resultado' => $_POST['resultado'][$s],
				'faena' => trim( mb_strtoupper(@$_POST['faena'], 'UTF-8')),
				'recomienda' => @$_POST['recomienda'],
				'fecha_e' => $fecha_e,
				'fecha_v' => $fecha_v
			);
			$this->Evaluaciones_model->editar($s,$edit);
			
			//archivo
			if(@$_FILES['docu']['name'][$s] != ''){
				if($_FILES['docu']['error'][$s] == 0){
					$salida = subir($_FILES,"docu","extras/evaluaciones/",false,$s);
					if($salida == 1)
						redirect('/administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
					elseif($salida==2)
						redirect('/administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
					else{
						if($archivo = $this->Evaluacionesarchivo_model->get($s)){
							$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
							$ruta_prin = $ruta_prin[0];
							unlink($ruta_prin.$archivo->url);
							$this->Evaluacionesarchivo_model->eliminar($archivo->id);
						}
						$data = array(
							'id_evaluacion' => $s,
							'url' => $salida
						);
						$this->Evaluacionesarchivo_model->ingresar($data);
						//redirect(base_url().'administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
					}
				}
			}
		}
		redirect(base_url().'administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
		// if($_POST['id_eval']){
			// $fecha_e = $_POST['ano_e'].'-'.$_POST['mes_e'].'-'.$_POST['dia_e'];
			// if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])){
			// $fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];}
			// else {$fecha_v = '0000-00-00';}
			// $edit = array(
				// 'observaciones' => trim( mb_strtoupper($_POST['obs'], 'UTF-8')),
				// 'resultado' => $_POST['resultado'],
				// 'fecha_e' => $fecha_e,
				// 'fecha_v' => $fecha_v
			// );
			// $this->Evaluaciones_model->editar($_POST['id_eval'],$edit);
			// //archivo
			// if(isset($_FILES['documento'])){
				// $salida = @subir($_FILES,"documento","extras/evaluaciones/");
				// if($salida == 1)
					// redirect('/administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
				// elseif($salida==2)
					// redirect('//administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
				// else{
					// if($archivo = $this->Evaluacionesarchivo_model->get($_POST['id_eval'])){
						// $ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
						// $ruta_prin = $ruta_prin[0];
						// unlink($ruta_prin.$archivo->url);
						// $this->Evaluacionesarchivo_model->eliminar($archivo->id);
					// }
					// $data = array(
						// 'id_evaluacion' => $_POST['id_eval'],
						// 'url' => $salida
					// );
					// $this->Evaluacionesarchivo_model->ingresar($data);
				// }
			// }
			// redirect(base_url().'administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
		// }
	}
	
	function agregar($id,$id_usr){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Evaluacionesarchivo_model");
		$this->load->model("Usuarios_model");
		$this->load->helper("fechas");
		$base['tipo'] = $id;
		$base['id_usr'] = $id_usr;
		$base['usr'] = $this->Usuarios_model->get($id_usr);
		$base['examenes'] = $this->Evaluacionestipo_model->get_eval($id);
		$this->load->view('evaluaciones/modal_crear', $base);
	}
	
	function ajax_return_examenes($id,$id_usr){
		$this->load->model("Evaluaciones_model");
		echo json_encode($this->Evaluaciones_model->ob_usuario($id_usr,$id));
	}

	function ajax_tipo_resultado($id){
		$this->load->model("Evaluacionestipo_model");
		$salida = $this->Evaluacionestipo_model->get_examen($id);
		echo json_encode($salida);
	}
	
	function guardar_creacion_eval($id_usr){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesarchivo_model");
		$this->load->helper("archivo");
		
		if( empty($id_usr) || empty($_POST['id_ee']) || empty($_POST['ano_e']) || empty($_POST['mes_e']) || empty($_POST['dia_e']) ){
			redirect(base_url().'administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
		}
		
		$fecha_e = $_POST['ano_e'].'-'.$_POST['mes_e'].'-'.$_POST['dia_e'];
		if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])){
		$fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];}
		else {$fecha_v = '0000-00-00';}
		
		if(isset($_POST['resultado_cualitativo'])) $resultado = $_POST['resultado_cualitativo'];
		else $resultado = $_POST['resultado_cuantitativo'];

		$arr = array(
			'id_usuarios' => $id_usr,
			'id_evaluacion' => $_POST['id_ee'],
			'observaciones' => trim( mb_strtoupper($_POST['obs'], 'UTF-8')),
			'resultado' => $resultado,
			'faena' => trim( mb_strtoupper($_POST['faena'], 'UTF-8')),
			'recomienda' => $_POST['recomienda'],
			'fecha_e' => $fecha_e,
			'fecha_v' => $fecha_v
		);
		$id_eval = $this->Evaluaciones_model->ingresar($arr);
		
		if($_FILES['docu']['error'] == 0){
				$salida = subir($_FILES,"docu","extras/evaluaciones/");
				if($salida == 1)
					redirect('/administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
				elseif($salida==2)
					redirect('/administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
				else{
					$data = array(
						'id_evaluacion' => $id_eval,
						'url' => $salida
					);
					$this->Evaluacionesarchivo_model->ingresar($data);
				}
			}
		redirect(base_url().'administracion/evaluaciones/listado/'.$_POST['tipo'], 'refresh');
	}
	
	function tooltip($id_evaluacion){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesarchivo_model");
		
		$dato = $this->Evaluaciones_model->get_evaluacion($id_evaluacion);
		$res = "";
		echo "<div class='democontent'>
			<div class='info'>";
			echo "<p>Evaluacion: <b>".ucwords(mb_strtolower($dato->nombre_examen,"UTF-8"))."</b></p>";
			if(isset ($dato->nombre_planta) ){
				echo "<p>Planta: ".ucwords(mb_strtolower($dato->nombre_planta,"UTF-8"))."</p>";
			}
			echo "<p>Fecha evaluacion: ".$dato->fecha_e."</p>";
			if($dato->fecha_v != 0 ){
				echo "<p>Fecha vigencia: ".@$dato->fecha_v."</p>";
			}
			if($dato->tipo_resultado == 1){
				$res = $dato->resultado;
			}
			elseif($dato->tipo_resultado == 2){
				if($dato->id_tipo == 1 || $dato->id_tipo == 3 || $dato->id_tipo == 4 ){
					if($dato->resultado == 0) $res = "Aprobado";
					if($dato->resultado == 1) $res = "Rechazado";
				}
				if($dato->id_tipo == 2 ){
					if($dato->resultado == 0) $res = "Sin Contraindicaciones";
					if($dato->resultado == 1) $res = "Con Contraindicaciones";
				}
			}
			echo "<p>Resultado: ".$res."</p>";
			if(!empty($dato->observaciones)){	
				echo "<p>Observaciones:".nl2br(ucwords(mb_strtolower($dato->observaciones,"UTF-8")))."</p>";
			}
		if(!empty($dato->url)){ 
			echo "<div><a target='_blank' href='".base_url().$dato->url."'>Descargar archivo</a></div>";
		}
		echo "</div>
			<div class='clear'>&nbsp;</div>
		</div>";
	}
	function ajax_verificar_evaluacion_asignada($id){
		$this->load->model("Evaluaciones_model");
		
	}
	
	function ajax_archivos($id_tipo,$id_usr){
		$this->load->model("Evaluaciones_model");
		$data = $this->Evaluaciones_model->ob_usuario($id_usr,$id_tipo);
		echo json_encode($data);
	}


	function informe($id){
		$base['titulo'] = "Informe de Evaluaciones";
		$base['lugar'] = "Informe de Evaluaciones";

		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Tipousuarios_model");
		$this->load->model("Fotostrab_model");

		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		if( $this->Fotostrab_model->get_usuario($pagina['usuario']->id) )
			$img_grande = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		else{
			$img_grande->nombre_archivo = 'extras/img/perfil/avatar.jpg';
			$img_grande->thumb = 'extras/img/perfil/avatar.jpg';
		}
		$pagina['imagen_grande'] = $img_grande;

		$evaluaciones = $this->Evaluaciones_model->get_all($id);
		$et = $this->Evaluaciones_model->get_desepeno($id);
		$pagina['evaluaciones'] = $evaluaciones;

		$user = $id;
		$arr = array();
		$aux = array();
		$id = 0;
		$i = 0;

		foreach ($et as $e) {
			$aux['nombre'] = $e->nombre_eval;
			$aux['promedio'] = "";
			$aux['porcentaje'] = "";
			$et_aux = $this->Evaluaciones_model->get_eval_user($e->id_eval,$user);
			foreach ($et_aux as $ea) {
				$s = str_replace(',', '.',$ea->resultado);
				$fecha_des = explode("-",$ea->fecha_e);
				$fecha_des = $fecha_des[2]."-".$fecha_des[1]."-".$fecha_des[0];
				$aux['sub'][] = array(
					'nombre' => $fecha_des." ".$ea->faena, 
					'nota' => $s,
					'recomienda' => $ea->recomienda,
					'comentario' => $ea->observaciones,
				);
			}
			$arr[$i] = $aux;
			$i += 1;
		}

		//print_r($arr);
		for($i = 0; $i < count($arr); $i++){
			$vuelta = 0;
			$sumatoria = 0;
			$si = 0;
			//print_r($arr[$i]).'<br/>';
			foreach ($arr[$i]['sub'] as $m) {
				$sumatoria += $m['nota'];
				$vuelta += 1;
				if($m['recomienda'] == 1){
					$si += 1;
				}
			}
			$prom = $sumatoria / $vuelta;
			$arr[$i]['promedio'] = round($prom,1);
			$prom = ($si * 100) / $vuelta;
			$arr[$i]['porcentaje'] = round($prom,2)."%";
			$i += 1;
		}

		$pagina['le'] = $arr;

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('evaluaciones/informe',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function informe_grupal(){
		//$this->output->enable_profiler(TRUE);
		$base['titulo'] = "Informe Grupal de Evaluaciones";
		$base['lugar'] = "Informe Grupal de Evaluaciones";

		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Tipousuarios_model");
		$this->load->model("Especialidadtrabajador_model");

		$listado = array();
		foreach($this->Usuarios_model->listar_trabajadores() as $t ){
			$aux = new stdClass();
			$aux->id = $t->id;
			$aux->rut = $t->rut_usuario;
			$aux->nombre = $t->nombres." ".$t->paterno." ".$t->materno;
			$aux->especialidad = @$this->Especialidadtrabajador_model->get($t->id_especialidad_trabajador)->desc_especialidad;
			$m = $this->Evaluaciones_model->get_una_masso($t->id);
			$p = $this->Evaluaciones_model->get_una_preocupacional($t->id);
			$d = $this->Evaluaciones_model->get_all_desepeno($t->id);
			$c = $this->Evaluaciones_model->get_all_conocimiento($t->id);
			$aux->masso =  (isset($m->fecha_e) ) ? $m->fecha_e : "No Tiene";
			$aux->examen_pre =  (isset($p->fecha_e) ) ? $p->fecha_e : "No Tiene";
			$suma = 0;
			$recomienda = 0;
			foreach ($d as $vd) {
				$suma =+ $vd->resultado;
				if ($vd->recomienda == 1){
					$recomienda += 1;
				}
			}
			$aux->desempeno = @round($suma / count($d),2);
			@$prom = ($recomienda * 100) / count($d);
			$aux->recomienda = @round($prom,2)."%";
			$res = "";
			$tot = count($c);
			$z=1;
			foreach ($c as $co) {
				$res.= ($z < $tot) ? $co->resultado. " - ": $co->resultado ; 
				$z +=1;
			}
			if (empty($res)) $res = "-";
			$aux->resultado = $res;

			array_push($listado,$aux);
			unset($aux);
		}


		$pagina['listado'] = $listado;

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('evaluaciones/informe_grupal',$pagina,TRUE);
		$this->load->view('layout',$base);

	}

	function listado_usuario($id){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");

		$usr = $this->Usuarios_model->get($id);
		$eval = $this->Evaluaciones_model->get_all($id);
		$base['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$base['listado'] = $eval;
		$base['id'] = $id;
		$this->load->view('evaluaciones/listado_usuario',$base);
	}

	function crear_nuevo($id){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Evaluacionesevaluacion_model");

		$usr = $this->Usuarios_model->get($id);
		$base['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		$base['id'] = $id;
		$base['tipo'] = $this->Evaluacionestipo_model->listar();
		$base['evaluaciones'] = $this->Evaluacionesevaluacion_model->listar();

		$this->load->view('evaluaciones/crear_nuevo',$base);
	}
	
}
?>