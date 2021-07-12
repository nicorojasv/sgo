<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$archivo_numero_letras = "extras/contratos/numero_letras.php";
$autoloader = "extras/contratos/PHPWord-master/src/PhpWord/Autoloader.php";
require_once (BASE_URL2.$autoloader);
require_once (BASE_URL2.$archivo_numero_letras);
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;

class Firmatec extends CI_Controller{
	public function __construct(){
    	parent::__construct();
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
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('id') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}
   	function solicitudes_completas($get_id_planta = FALSE,$fecha = false){
   		/*Estado 1 Documentos fue emitido y trbabajador aun no firma
			Estado 2 en Proceso, es cuando el trabajadorr ya firmo
			Estado 3 firmado , cuando lo firma el representante
			Estado 4 Objetados, cuando el trabajador lo objeta
			Estado 5 No Vigente, 
			Estado 6 Anulado, por el representante
			Tipo doc en firmatec: 1 Contrato - 7 Anexo*/
		$this->load->model('Requerimiento_Usuario_Archivo_model');
  		$url = 'http://54.232.203.239/wsIntegra/getStatus';
		$ch = curl_init($url);
		$data = array(
				'idHolding'=>1,
                'idEstado'=>3,// id del estado en  SGO
                );

		$token = 'v6WU6haL&Qzq=*';
        $headers = [
            "Content-type: application/json;charset=utf-8",
            'Authorization: Bearer '.$token, 
            "Referer:prueba",
            "Connection: close"
        ];

		//var_dump($data);
		$data_json = json_encode($data,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		//var_dump($data_json);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        $array = json_decode($response, true);
	//	var_dump($array);
		if(json_last_error() == JSON_ERROR_NONE){
			/*foreach($array as $mydata){
				echo '<pre>';
				print_r($mydata['id_documentoSGO']);
				echo '</pre>';
		    }*/
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
			if ($fecha =='historico') {
				$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2();
				$pagina['mes'] = 'historico';
			}elseif($fecha){
				$fechaI = new DateTime($fecha);
					$fechaI->modify('first day of this month');
					$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
				$fechaT = new DateTime($fecha);
					$fechaT->modify('last day of this month');
					$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
				$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2($fechaInicio, $fechaTermino);
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
				$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2($fechaInicio, $fechaTermino);
				setlocale(LC_TIME, 'spanish');
				$monthNum  = date('m');
				$dateObj   = DateTime::createFromFormat('!m', $monthNum);
				$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
				$pagina['mes']= $nombreDelMes;
			}
			$listado = array();
			if($array != FALSE){
				foreach($array as $rm){
					if ($rm['id_tipo_documento']==1) {
						$aux = new stdClass();
						$id_solicitante = 106;//isset($rm->id_solicitante)?$rm->id_solicitante:'';
						$id_req_usu_arch = $rm['id_documentoSGO'];//isset($rm['id_documentoSGO'])?$rm['id_documentoSGO']:NULL;
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
						$aux->uf_pactada = isset($usr->uf_pactada)?$usr->uf_pactada:'';
						#Fin 12-11-2018 incorporacion banco, tipo  y numero de cuenta.
						$get_ciudad = $this->Ciudad_model->get($id_ciudad);
						$get_afp = $this->Afp_model->get($id_afp);
						$get_salud = $this->Salud_model->get($id_salud);
						$get_estado_civil = $this->Estadocivil_model->get($id_estado_civil);
						$get_nivel_estudios = $this->Nivelestudios_model->get($id_estudios);
						$get_area_cargo = $this->Requerimiento_area_cargo_model->get($id_req_area_cargo);
						$id_requerimiento = isset($get_area_cargo->requerimiento_id)?$get_area_cargo->requerimiento_id:'';
						//$aux->urlDocument = $rm['urlDocument'];
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
						$aux->urlDocument = $rm['urlDocument'];
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
			}
		}else{
			echo "no existen contratos";
			return false;
		}

		$pagina['listado'] = $listado;
		$pagina['planta_seleccionada'] = $get_id_planta;
		$pagina['listado_plantas'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('firmatec/listado_solicitudes_completas',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function solicitud_completa_arauco(){
		 $url = 'http://54.232.203.239/wsIntegra/getStatusByIdDocuments';

		$ch = curl_init($url);
		$data = array(
				'idHolding'=>1,
                'idDocumentoSGO'=>5309,// id del contrato en  SGO
                );

		$token = 'v6WU6haL&Qzq=*';
        $headers = [
            "Content-type: application/json;charset=utf-8",
            'Authorization: Bearer '.$token, 
            "Referer:prueba",
            "Connection: close"
        ];

		var_dump($data);
		$data_json = json_encode($data,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		//var_dump($data_json);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
       // var_dump($response);
        echo '<pre>';
		print_r($response);
		echo '</pre>';
	}

	function apiConsultaHoldingDocumento($id){//API CONSULTA POR DOCUMENTO
		/*Estado 1 Documentos fue emitido y trbabajador aun no firma
			Estado 2 en Proceso, es cuando el trabajadorr ya firmo
			Estado 3 firmado , cuando lo firma el representante
			Estado 4 Objetados, cuando el trabajador lo objeta
			Estado 5 No Vigente, 
			Estado 6 Anulado, por el representante
			Tipo doc en firmatec: 1 Contrato - 7 Anexo
		*///error en el 3, 5
		        //$url = 'http://sgo2.integraest.cl/api/updateTrabajador';
        $url = 'http://54.232.203.239/wsIntegra/getStatus';
		$ch = curl_init($url);
		$data = array(
				'idHolding'=>$id,
                'idEstado'=>1,// id del contrato en  SGO
                );

		$token = 'v6WU6haL&Qzq=*';
        $headers = [
            "Content-type: application/json;charset=utf-8",
            'Authorization: Bearer '.$token, 
            "Referer:prueba",
            "Connection: close"
        ];

		var_dump($data);
		$data_json = json_encode($data,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		//var_dump($data_json);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        echo '<pre>';
		print_r($response);
		echo '</pre>';
	$array = json_decode($response, true);
	var_dump($array);
		foreach($array as $mydata){
			
			echo '<pre>';
		print_r($mydata['id_documentoSGO']);
		echo '</pre>';
	    }
		//var_dump($response);
	//	json_decode($response);
 var_dump(json_last_error() == JSON_ERROR_NONE);
#
	}


}
?>