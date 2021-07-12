<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Abastecimiento extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 3)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 9)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_solo_abastecimiento','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index($guardar = FALSE){
		$this->load->model("Abastecimiento_model");
		$this->load->model("relacion_usuario_centro_costo_abastecimiento_model");
		$this->load->model("relacion_usuario_sucursal_abastecimiento_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model("Empresa_Planta_model");
		$this->load->model("Empresas_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: ".$this->session->userdata('empresa'),
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'js' => array('js/abastecimiento.js?guardar='.$guardar),
			'css' => array(),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'),array('url' => '', 'txt' => 'Abastecimiento')),
			'menu' => $this->menu
		);

		$listado_centro_costo = $this->relacion_usuario_centro_costo_abastecimiento_model->get_usuario_centro_costo_result($this->session->userdata('id'));
		$listado_sucursales = $this->relacion_usuario_sucursal_abastecimiento_model->get_usuario_sucursal_result($this->session->userdata('id'));
		$lista_aux = array();
		if (!empty($listado_centro_costo)){
			foreach ($listado_centro_costo as $rm){
				$aux = new stdClass();
				$get_centro_costo =  $this->Empresas_model->get($rm->id_centro_costo);
				$aux->id_centro_costo = $rm->id;
				$aux->nombre_centro_costo = isset($get_centro_costo->razon_social)?$get_centro_costo->razon_social:"";
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$lista_aux2 = array();
		if (!empty($listado_sucursales)){
			foreach ($listado_sucursales as $rm2){
				$aux2 = new stdClass();
				$get_sucursal =  $this->Empresa_Planta_model->get($rm2->id_sucursal);
				$aux2->id_sucursal = $rm2->id_sucursal;
				$aux2->nombre_sucursal = isset($get_sucursal->nombre)?$get_sucursal->nombre:"";
				array_push($lista_aux2, $aux2);
				unset($aux2);
			}
		}
		$pagina['centro_costo'] = $lista_aux;
		$pagina['sucursales'] = $lista_aux2;
		$pagina['usuario'] = $this->Usuarios_general_model->get($this->session->userdata('id'));
		$pagina['fecha'] = date("d-m-Y");
		$pagina['folio'] =$this->Abastecimiento_model->ultimo_folio();
		$base['cuerpo'] = $this->load->view('crear',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function asignar($tipo_usuario = FALSE){
		$this->load->model("Usuarios/usuarios_general_model");
		$base = array(
			'head_titulo' => "Sistema EST - Listado Usuarios",
			'titulo' => "Listado Usuarios",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Usuarios' )),
			'menu' => $this->menu,
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css')
		);

		/*if($tipo_usuario == 'est'){
			$listado = $this->usuarios_general_model->listar_usuarios_est();
		}else{
			$listado = $this->usuarios_general_model->listar();
		}*/

		$listado = $this->usuarios_general_model->listar();
		$lista_aux = array();
		if (!empty($listado)){
			foreach ($listado as $rm){
				$aux = new stdClass();
				/*if($tipo_usuario == 'est'){
					$aux->id_usuario = $rm->usuarios_id;
				}else{
					$aux->id_usuario = $rm->id;
				}*/
				$aux->id_usuario = $rm->id;
				$aux->rut_usuario = $rm->rut_usuario;
				$aux->paterno = $rm->paterno;
				$aux->materno = $rm->materno;
				$aux->nombres = $rm->nombres;
				$aux->fono = $rm->fono;
				$aux->email = $rm->email;
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$base['cuerpo'] = $this->load->view('listado_gestion_usuarios',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_permiso_planta_usuarios($id_usuario){
		$this->load->model("est/general_model");
		$this->load->model("relacion_usuario_centro_costo_abastecimiento_model");
		$this->load->model("relacion_usuario_sucursal_abastecimiento_model");
		$listado = $this->general_model->get_result($id_usuario);
		$lista_aux = array();
		if (!empty($listado)){
			foreach ($listado as $rm){
				$listado_sucursales = $this->general_model->listar_sucursales();
				$listado_centros_costos = $this->general_model->listar_centros_costos();
				$aux = new stdClass();
				$aux->id_usuario = $rm->id;
				$aux->paterno = $rm->paterno;
				$aux->materno = $rm->materno;
				$aux->nombres = $rm->nombres;
				$aux->sucursales = array();
				if (!empty($listado_sucursales)){
					foreach ($listado_sucursales as $z){
						$archivo2 = new StdClass();
						$get_usu_sucursal = $this->relacion_usuario_sucursal_abastecimiento_model->get_usuario_sucursal($rm->id, $z->id);
						$archivo2->si_existe = isset($get_usu_sucursal->id)?1:0;
						$archivo2->id_sucursal = $z->id;
						$archivo2->nombre = urldecode($z->nombre);
						array_push($aux->sucursales, $archivo2);
					}
					unset($archivo2);
				}

				$aux->centros_costos = array();
				if (!empty($listado_centros_costos)){
					foreach ($listado_centros_costos as $d) {
						$archivo = new StdClass();
						$get_usu_centro_costo = $this->relacion_usuario_centro_costo_abastecimiento_model->get_usuario_centro_costo($rm->id, $d->id);
						$archivo->si_existe = isset($get_usu_centro_costo->id)?1:0;
						$archivo->id_centro_costo = $d->id;
						$archivo->nombre = urldecode($d->nombre);
						array_push($aux->centros_costos, $archivo);
					}
					unset($archivo);
				}

				array_push($lista_aux, $aux);
				unset($aux);
			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$this->load->view('modal_asignar_permisos_planta', $pagina);
	}

	function guardar_relacion_planta_usuario(){
		$this->load->model("relacion_usuario_centro_costo_abastecimiento_model");
		$this->load->model("relacion_usuario_sucursal_abastecimiento_model");
		$id_usuario = $_POST['id_usuario'];
        $this->relacion_usuario_centro_costo_abastecimiento_model->eliminar_relacion_centro_costo_usuario($id_usuario);
        $this->relacion_usuario_sucursal_abastecimiento_model->eliminar_relacion_sucursal_usuario($id_usuario);

		foreach($_POST['rut_ingresar1'] as $c=>$valores){
			if(!empty($_POST['sucursales_usuario'][$c]) ){
				$data = array(
					'id_usuario' => $id_usuario,
					'id_sucursal' => (!empty($_POST['sucursales_usuario'][$c]))?$_POST['sucursales_usuario'][$c]:false,
				);
				$asistencia = $this->relacion_usuario_sucursal_abastecimiento_model->ver_relacion_sucursal_usuario($id_usuario, $_POST['sucursales_usuario'][$c]);
				if ($asistencia == 1){
					$this->relacion_usuario_sucursal_abastecimiento_model->actualizar_relacion($id_usuario, $data);
				}elseif ($asistencia == 0){
					$this->relacion_usuario_sucursal_abastecimiento_model->guardar_relacion($data);
				}
			}else{
				echo "";
			}
		}

		foreach($_POST['rut_ingresar2'] as $c=>$valores){
			if(!empty($_POST['centro_costo_usuario'][$c]) ){
				$data = array(
					'id_usuario' => $id_usuario,
					'id_centro_costo' => (!empty($_POST['centro_costo_usuario'][$c]))?$_POST['centro_costo_usuario'][$c]:false,
				);
				$asistencia2 = $this->relacion_usuario_centro_costo_abastecimiento_model->ver_relacion_centro_costo_usuario($id_usuario, $_POST['centro_costo_usuario'][$c]);
				if ($asistencia2 == 1){
					$this->relacion_usuario_centro_costo_abastecimiento_model->actualizar_relacion($id_usuario, $data);
				}elseif ($asistencia2 == 0){
					$this->relacion_usuario_centro_costo_abastecimiento_model->guardar_relacion($data);
				}
			}else{
				echo "";
			}
		}
		echo "<script>alert('Permisos Registrados Exitosamente')</script>";
		redirect('abastecimiento/asignar', 'refresh');
	}

	function enviar(){
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model("Centro_costo_model");
		$this->load->model("Abastecimiento_model");
		$this->load->model("Sucursales_model");
		$this->load->model("Empresa_Planta_model");
		$this->load->model("Empresas_model");
		$usuario = $this->Usuarios_general_model->get($this->session->userdata('id'));
		$fecha = $_POST['fecha'];
		$get_cc = $this->Empresas_model->get($_POST['centro_costo']);
		$centro_costo = isset($get_cc->razon_social)?$get_cc->razon_social:'';
		$sucursal = $this->Empresa_Planta_model->get($_POST['sucursal'])->nombre;
		$folio = $_POST['folio'];

		if ($_POST['centro_costo'] == 1)
			$empresa = "SI";
		elseif ($_POST['centro_costo'] == 2)
			$empresa = "ST";
		elseif ($_POST['centro_costo'] == 3)
			$empresa = "TR";
		elseif ($_POST['centro_costo'] == 4)
			$empresa = "CP";
		elseif ($_POST['centro_costo'] == 5)
			$empresa = "WT";
		elseif ($_POST['centro_costo'] == 7)
			$empresa = "CE";
		elseif ($_POST['centro_costo'] == 8)
			$empresa = "OV";
		else
			$empresa = "ND";

		if( $_POST['t_solicitud'] == "H")
			$t_solicitud = "Habitual";
		elseif( $_POST['t_solicitud'] == "NH")
			$t_solicitud = "No Habitual";

		if( $_POST['regimen'] == "RN")
			$regimen = "Regimen Normal";
		elseif( $_POST['regimen'] == "RPGP")
			$regimen = "Regimen PGP";

		if( $_POST['insumos'] == "EPP")
			$insumos = "EPP";
		elseif( $_POST['insumos'] == "CE")
			$insumos = "Caja de Herramientas";

		$fecha_aux = explode('-', $fecha);
		$fecha2 = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];

		$guardar = array(
			'usuario_id' => $this->session->userdata('id'),
			'tipo_solicitud' => $_POST['t_solicitud'],
			'centro_costo_id' => $_POST['centro_costo'],
			'sucursal_id' => $_POST['sucursal'],
			'regimen' => $_POST['regimen'],
			'insumos' => $_POST['insumos'],
			'fecha' => $fecha2,
		);

		$folio = $this->Abastecimiento_model->ingresar($guardar);
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$_archivo = "extras/excel/SOLICITUD DE PEDIDO.XLSX";
		$objPHPExcel = $objReader->load(BASE_URL2.$_archivo);
		$objPHPExcel->setActiveSheetIndex(0);

		//CREAR VALORES
		$objPHPExcel->getActiveSheet()->SetCellValue('C31', 'Autorizado por:');
		$objPHPExcel->getActiveSheet()->SetCellValue('E4', $usuario->nombres.' '.$usuario->paterno);
		$objPHPExcel->getActiveSheet()->SetCellValue('G4', $folio);
		$objPHPExcel->getActiveSheet()->SetCellValue('E5', $centro_costo);
		$objPHPExcel->getActiveSheet()->SetCellValue('E6', $sucursal);
		$objPHPExcel->getActiveSheet()->SetCellValue('E7', $fecha);
		$objPHPExcel->getActiveSheet()->SetCellValue('G5', $t_solicitud);
		$objPHPExcel->getActiveSheet()->SetCellValue('G6', $regimen);
		$objPHPExcel->getActiveSheet()->SetCellValue('G7', $insumos);

		$i = 0;
		$z = 10;
		foreach ($_POST['descripcion'] as $d) {
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$z, $_POST['descripcion'][$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$z, $_POST['cantidad'][$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$z, $_POST['talla'][$i]);
			$i++;
			$z++;
		}
		//GUARDAR Y CREAR EXCEL NUEVO
		//header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//$objWriter->save('php://output');
		$objWriter->save(BASE_URL2."extras/excel/".$folio."_".$_POST['t_solicitud']."_".$fecha."_".$empresa."_".$sucursal.".xlsx");

		$this->load->library('email'); // load email library
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);
		$destinatarios_cc = array('controldebodega@empresasintegra.cl','msoto@empresasintegra.cl','bodegacentral@empresasintegra.cl');
	    $this->email->from('informaciones@empresasintegra.cl', 'Informaciones Integra');
	    $this->email->to($usuario->email);
	    $this->email->cc($destinatarios_cc);
	    $this->email->subject("[ABASTECIMIENTO SP] ".$folio." ".$fecha." ".$empresa." ".$sucursal);
	    $this->email->message('Se adjunta archivo generado por sistema');
	    $this->email->attach(BASE_URL2."extras/excel/".$folio."_".$_POST["t_solicitud"]."_".$fecha."_".$empresa."_".$sucursal.".xlsx"); // attach file
    	if ($this->email->send()){
    		unlink(BASE_URL2."extras/excel/".$folio."_".$_POST["t_solicitud"]."_".$fecha."_".$empresa."_".$sucursal.".xlsx");
    		redirect('/abastecimiento/abastecimiento/index/correcto', 'refresh');
    	}
		else
			redirect('/abastecimiento/abastecimiento/index/error', 'refresh');

		//$objWriter->save("Archivo_salida.xlsx");
		/*
		$this->load->library('email');

		$this->email->from('your@example.com', 'Your Name');
		$this->email->to($usuario->email); 

		$this->email->attach('php://output');
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');	

		$this->email->send();
		*/
	}

}
?>