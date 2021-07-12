<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Mandante extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 7)
			$this->menu = $this->load->view('layout2.0/menus/menu_mandante','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function trazabilidad($id_planta){
		$this->load->model('Empresa_planta_model');
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->helper("text");
		$base = array(
			'css' => array("css/avance_pgp.css"),
			'head_titulo' => "Avance de Contrataciones Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Avance de Contrataciones por Planta')),
			'side_bar' => true,
			'js' => array('js/avance_pgp.js'),
			'menu' => $this->menu
		);
			
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$no_contactado = 0;
		$dotacion_total_total = 0;
		$en_servicio = 0;
		$contratos_en_proceso = 0;
		$contratos_firmados = 0;
		$contratos_finalizados = 0;
		$renuncias_voluntarias = 0;
		$referidos = 0;
		$requerimientos_planta = $this->Requerimientos_model->listar_datos_req($id_planta);
		if (!empty($requerimientos_planta)){
			foreach ($requerimientos_planta as $rm){
				foreach ($this->Requerimiento_area_cargo_model->get_requerimiento($rm->id) as $r){
					$dotacion_total_total += $r->cantidad;
				}
				foreach ($this->Requerimiento_asc_trabajadores_model->get_requerimiento($rm->id) as $g){
					if ($g->status == 0)
						$no_contactado += 1;
					elseif ($g->status == 3)
						$en_servicio += 1;
					elseif($g->status == 2)
						$contratos_en_proceso += 1;
					elseif($g->status == 5)
						$contratos_firmados += 1;
					elseif($g->status == 6)
						$contratos_finalizados += 1;
					elseif($g->status == 7)
						$renuncias_voluntarias += 1;

					if($g->referido == 1)
						$referidos += 1;
				}
			}
		}else{
			$no_contactado += 0;
			$dotacion_total_total += 0;
			$en_servicio += 0;
			$contratos_en_proceso += 0;
			$contratos_firmados += 0;
			$contratos_finalizados += 0;
			$renuncias_voluntarias += 0;
			$referidos += 0;
		}

		$dotacion_total = ($no_contactado + $en_servicio + $contratos_en_proceso + $contratos_firmados);

		//$no_contactado = $dotacion_total - $en_servicio;
		$pagina['id_planta'] = $id_planta;
		$pagina['dotacion_total'] = $dotacion_total;
		$pagina['dotacion_total_total'] = $dotacion_total_total;
		$pagina['servicio'] = $en_servicio;
		$pagina['requerimientos_planta'] = $requerimientos_planta;
		$pagina['no_contactado'] = $no_contactado;
		$pagina['contratos_en_proceso'] = $contratos_en_proceso;
		$pagina['contratos_firmados'] = $contratos_firmados;
		$pagina['contratos_finalizados'] = $contratos_finalizados;
		$pagina['renuncias_voluntarias'] = $renuncias_voluntarias;
		$pagina['referidos'] = $referidos;
		if($dotacion_total == 0){
			$pagina['porcentaje'] = 0;
			$pagina['porcentaje_no_contactado'] = 0;
			$pagina['porcentaje_contratos_en_proceso'] = 0;
			$pagina['porcentaje_contratos_firmados'] = 0;
			$pagina['porcentaje_contratos_finalizados'] = 0;
			$pagina['porcentaje_renuncias_voluntarias'] = 0;
			$pagina['porcentaje_referidos'] = 0;
		}else{
			$pagina['porcentaje'] = number_format( ($en_servicio * 100) / $dotacion_total, 2);
			$pagina['porcentaje_no_contactado'] = number_format( ($no_contactado * 100) / $dotacion_total, 2);
			$pagina['porcentaje_contratos_en_proceso'] = number_format( ($contratos_en_proceso * 100) / $dotacion_total, 2);
			$pagina['porcentaje_contratos_firmados'] = number_format( ($contratos_firmados * 100) / $dotacion_total, 2);
			$pagina['porcentaje_contratos_finalizados'] = number_format( ($contratos_finalizados * 100) / $dotacion_total_total, 2);
			$pagina['porcentaje_renuncias_voluntarias'] = number_format( ($renuncias_voluntarias * 100) / $dotacion_total_total, 2);
			$pagina['porcentaje_referidos'] = number_format( ($referidos * 100) / $dotacion_total_total, 2);
		}
		$base['cuerpo'] = $this->load->view('informes/trazabilidad',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
 	function exportar_excel($value=''){
		header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo utf8_decode($_POST['datos_a_enviar']);
	}

	function base_datos_contratos($id_planta){
		$this->load->model('Empresa_planta_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('ciudad_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('Archivos_trab_model');
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Requerimiento_Usuario_Archivo_model');

		$base = array(
			'head_titulo' => "Reportabilidad Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Reportabilidad Base de Datos Excel')),
			'side_bar' => true,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel2.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js','js/exportarExcelArauco.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);

		$contratos_planta = $this->Requerimientos_model->contratos_vigentes_planta_mandante($id_planta);
		$listado = array();
		foreach($contratos_planta as $r){
			$aux = new stdClass();
			$existe_anexo = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($r->usuario_id, $r->requerimiento_asc_trabajadores_id, 2);
			$existe_contrato = $this->Requerimiento_Usuario_Archivo_model->existe_registro_tipo_archivo_usuario($r->usuario_id, $r->requerimiento_asc_trabajadores_id, 1);
		
			if($existe_anexo == 1){
				$get_datos_causal_motivo = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_datos($r->usuario_id, $r->requerimiento_asc_trabajadores_id, 2);
			}elseif($existe_contrato == 1){
				$get_datos_causal_motivo = $this->Requerimiento_Usuario_Archivo_model->get_usuario_requerimiento_datos($r->usuario_id, $r->requerimiento_asc_trabajadores_id, 1);
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

			$fecha_inicio = (isset($get_datos_causal_motivo->fecha_inicio))?$get_datos_causal_motivo->fecha_inicio:'0000-00-00';
			$fecha_termino = (isset($get_datos_causal_motivo->fecha_termino))?$get_datos_causal_motivo->fecha_termino:'0000-00-00';
			
			if($fecha_inicio == '0000-00-00' or $fecha_termino == '0000-00-00' ){
				$aux->dias_contrato = "N/D";
			}else{
				$segundos=strtotime($fecha_termino) - strtotime($fecha_inicio);
				$diferencia_dias=intval($segundos/60/60/24) + 1;
				$aux->dias_contrato = $diferencia_dias;
			}

			$aux->causal = (isset($get_datos_causal_motivo->causal))?$get_datos_causal_motivo->causal:'';
			$aux->fecha_inicio = (isset($get_datos_causal_motivo->fecha_inicio))?$get_datos_causal_motivo->fecha_inicio:'0000-00-00';
			$aux->fecha_termino = (isset($get_datos_causal_motivo->fecha_termino))?$get_datos_causal_motivo->fecha_termino:'0000-00-00';
			$usr = $this->Usuarios_model->get($r->usuario_id);
			$area = $this->Areas_model->r_get($r->areas_id);
			$cargo = $this->Cargos_model->r_get($r->cargos_id);
			$ar_contrato = $this->Archivos_trab_model->get_archivo($r->usuario_id,15);
			$ar_certificado = $this->Archivos_trab_model->get_archivo($r->usuario_id,9);
			$aux->id = $r->id;
			$aux->id_requerimiento = $r->req_id;
			$aux->nombre_req = (isset($r->nombre_req))?$r->nombre_req:'N/D';
			$aux->codigo_requerimiento = (isset($r->codigo_requerimiento))?$r->codigo_requerimiento:'N/D';
			$get_datos_planta = $this->Empresa_planta_model->get($id_planta);
			$aux->nombre_planta = (isset($get_datos_planta->nombre))?$get_datos_planta->nombre:'0';
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
			$aux->area = $area->nombre;
			$aux->cargo = $cargo->nombre;
			$aux->contrato = $ar_contrato;
			$aux->certificado = $ar_certificado;
			$aux->comentario = $r->comentario;
			$aux->jefe_area = $r->jefe_area;
			$aux->asc_trabajadores = $r->requerimiento_asc_trabajadores_id;
			
			if($fecha_termino < date('Y-m-d')){
				$aux->estado_req = 0;
			}else{
				$aux->estado_req = 1;
			}
			array_push($listado, $aux);
			unset($aux);
		}
		$pagina['id_planta'] = $id_planta;
		$pagina['listado'] = $listado;
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$base['cuerpo'] = $this->load->view('informes/base_datos_contratos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function reportabilidad($id_planta, $get_fecha = FALSE){
		$this->load->model('Empresa_planta_model');
		$this->load->model('Requerimientos_model');
		
		$base = array(
			'css' => array("css/avance_pgp.css"),
			'head_titulo' => "Reportabilidad de Dotacion",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Reportabilidad de Dotacion')),
			'side_bar' => true,
			'js' => array('js/si_datepicker_reportabilidad_mandante.js','js/avance_pgp.js', 'js/si_graficos_reportabilidad.js', 'js/si_canvasjs.min.js'),
			'menu' => $this->menu
		);

		$fecha_defecto = "2016";
		if (empty($get_fecha)){
			$fecha = $fecha_defecto;
		}else{
			$fecha = $get_fecha;
		}

		$fecha_inicio = $fecha."-01-01";
		$fecha_termino = $fecha."-12-31";

		$listar_contratos_planta = $this->Requerimientos_model->contratos_vigentes_planta($id_planta, $fecha_inicio, $fecha_termino);
		$listar_contratos_planta_usuario = $this->Requerimientos_model->contratos_vigentes_planta_por_usuario($id_planta, $fecha_inicio, $fecha_termino);
		$contratosmes1 = 0;
		$contratosmes2 = 0;
		$contratosmes3 = 0;
		$contratosmes4 = 0;
		$contratosmes5 = 0;
		$contratosmes6 = 0;
		$contratosmes7 = 0;
		$contratosmes8 = 0;
		$contratosmes9 = 0;
		$contratosmes10 = 0;
		$contratosmes11 = 0;
		$contratosmes12 = 0;
		$contratosmesusuario1 = 0;
		$contratosmesusuario2 = 0;
		$contratosmesusuario3 = 0;
		$contratosmesusuario4 = 0;
		$contratosmesusuario5 = 0;
		$contratosmesusuario6 = 0;
		$contratosmesusuario7 = 0;
		$contratosmesusuario8 = 0;
		$contratosmesusuario9 = 0;
		$contratosmesusuario10 = 0;
		$contratosmesusuario11 = 0;
		$contratosmesusuario12 = 0;
		$diascontratosmes1 = 0;
		$diascontratosmes2 = 0;
		$diascontratosmes3 = 0;
		$diascontratosmes4 = 0;
		$diascontratosmes5 = 0;
		$diascontratosmes6 = 0;
		$diascontratosmes7 = 0;
		$diascontratosmes8 = 0;
		$diascontratosmes9 = 0;
		$diascontratosmes10 = 0;
		$diascontratosmes11 = 0;
		$diascontratosmes12 = 0;

		$listado = array();
		foreach($listar_contratos_planta as $rm){
			$aux = new stdClass();
			$fecha_inicio = $rm->fecha_inicio;
			$fecha_termino = $rm->fecha_termino;

			if($fecha_inicio == '0000-00-00' or $fecha_termino == '0000-00-00'){
			}else{
				$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
				foreach($meses as $mes){
					if($mes == 1){
						$ultimo_dia = "31";
					}elseif ($mes == 2){
						$ultimo_dia = '28';
					}elseif ($mes == 3){
						$ultimo_dia = '31';
					}elseif ($mes == 4){
						$ultimo_dia = '30';
					}elseif ($mes == 5){
						$ultimo_dia = '31';
					}elseif ($mes == 6){
						$ultimo_dia = '30';
					}elseif ($mes == 7){
						$ultimo_dia = '31';
					}elseif ($mes == 8){
						$ultimo_dia = '31';
					}elseif ($mes == 9){
						$ultimo_dia = '30';
					}elseif ($mes == 10){
						$ultimo_dia = '31';
					}elseif ($mes == 11){
						$ultimo_dia = '30';
					}elseif ($mes == 12){
						$ultimo_dia = '31';
					}else{
						$ultimo_dia = '30';
					}

					$time = strtotime($fecha.'-'.$mes.'-01');
					$time2 = strtotime($fecha.'-'.$mes.'-'.$ultimo_dia);
					$inicio_mes = date('Y-m-d',$time);
					$fin_mes = date('Y-m-d',$time2);

					if($inicio_mes <= $fecha_inicio and $fin_mes >= $fecha_inicio and $inicio_mes <= $fecha_termino and $fin_mes >= $fecha_termino){
						$datetime1 = new DateTime($fecha_inicio);
						$datetime2 = new DateTime($fecha_termino);
						$interval = $datetime1->diff($datetime2);
						$dias_mes = $interval->format('%R%a días');

						$dias[$mes] = $dias_mes + 1;
						
						if($mes == 1){
							$contratosmes1 += 1;
							$diascontratosmes1 = $diascontratosmes1 + $dias[1];
						}elseif($mes == 2){
							$contratosmes2 += 1;
							$diascontratosmes2 = $diascontratosmes2 + $dias[2];
						}elseif($mes == 3){
							$contratosmes3 += 1;
							$diascontratosmes3 = $diascontratosmes3 + $dias[3];
						}elseif($mes == 4){
							$contratosmes4 += 1;
							$diascontratosmes4 = $diascontratosmes4 + $dias[4];
						}elseif($mes == 5){
							$contratosmes5 += 1;
							$diascontratosmes5 = $diascontratosmes5 + $dias[5];
						}elseif($mes == 6){
							$contratosmes6 += 1;
							$diascontratosmes6 = $diascontratosmes6 + $dias[6];
						}elseif($mes == 7){
							$contratosmes7 += 1;
							$diascontratosmes7 = $diascontratosmes7 + $dias[7];
						}elseif($mes == 8){
							$contratosmes8 += 1;
							$diascontratosmes8 = $diascontratosmes8 + $dias[8];
						}elseif($mes == 9){
							$contratosmes9 += 1;
							$diascontratosmes9 = $diascontratosmes9 + $dias[9];
						}elseif($mes == 10){
							$contratosmes10 += 1;
							$diascontratosmes10 = $diascontratosmes10 + $dias[10];
						}elseif($mes == 11){
							$contratosmes11 += 1;
							$diascontratosmes11 = $diascontratosmes11 + $dias[11];
						}elseif($mes == 12){
							$contratosmes12 += 1;
							$diascontratosmes12 = $diascontratosmes12 + $dias[12];
						}


					}elseif($fecha_inicio < $inicio_mes and $fin_mes < $fecha_termino){
						
						$datetime1 = new DateTime($inicio_mes);
						$datetime2 = new DateTime($fin_mes);
						$interval = $datetime1->diff($datetime2);
						$dias_mes = $interval->format('%R%a días');

						$dias[$mes] = $dias_mes + 1;
						
						if($mes == 1){
							$contratosmes1 += 1;
							$diascontratosmes1 = $diascontratosmes1 + $dias[1];
						}elseif($mes == 2){
							$contratosmes2 += 1;
							$diascontratosmes2 = $diascontratosmes2 + $dias[2];
						}elseif($mes == 3){
							$contratosmes3 += 1;
							$diascontratosmes3 = $diascontratosmes3 + $dias[3];
						}elseif($mes == 4){
							$contratosmes4 += 1;
							$diascontratosmes4 = $diascontratosmes4 + $dias[4];
						}elseif($mes == 5){
							$contratosmes5 += 1;
							$diascontratosmes5 = $diascontratosmes5 + $dias[5];
						}elseif($mes == 6){
							$contratosmes6 += 1;
							$diascontratosmes6 = $diascontratosmes6 + $dias[6];
						}elseif($mes == 7){
							$contratosmes7 += 1;
							$diascontratosmes7 = $diascontratosmes7 + $dias[7];
						}elseif($mes == 8){
							$contratosmes8 += 1;
							$diascontratosmes8 = $diascontratosmes8 + $dias[8];
						}elseif($mes == 9){
							$contratosmes9 += 1;
							$diascontratosmes9 = $diascontratosmes9 + $dias[9];
						}elseif($mes == 10){
							$contratosmes10 += 1;
							$diascontratosmes10 = $diascontratosmes10 + $dias[10];
						}elseif($mes == 11){
							$contratosmes11 += 1;
							$diascontratosmes11 = $diascontratosmes11 + $dias[11];
						}elseif($mes == 12){
							$contratosmes12 += 1;
							$diascontratosmes12 = $diascontratosmes12 + $dias[12];
						}

					}elseif($fecha_inicio < $inicio_mes and $inicio_mes <= $fecha_termino and $fin_mes >= $fecha_termino){
						
						$datetime1 = new DateTime($inicio_mes);
						$datetime2 = new DateTime($fecha_termino);
						$interval = $datetime1->diff($datetime2);
						$dias_mes = $interval->format('%R%a días');

						$dias[$mes] = $dias_mes + 1;
						
						if($mes == 1){
							$contratosmes1 += 1;
							$diascontratosmes1 = $diascontratosmes1 + $dias[1];
						}elseif($mes == 2){
							$contratosmes2 += 1;
							$diascontratosmes2 = $diascontratosmes2 + $dias[2];
						}elseif($mes == 3){
							$contratosmes3 += 1;
							$diascontratosmes3 = $diascontratosmes3 + $dias[3];
						}elseif($mes == 4){
							$contratosmes4 += 1;
							$diascontratosmes4 = $diascontratosmes4 + $dias[4];
						}elseif($mes == 5){
							$contratosmes5 += 1;
							$diascontratosmes5 = $diascontratosmes5 + $dias[5];
						}elseif($mes == 6){
							$contratosmes6 += 1;
							$diascontratosmes6 = $diascontratosmes6 + $dias[6];
						}elseif($mes == 7){
							$contratosmes7 += 1;
							$diascontratosmes7 = $diascontratosmes7 + $dias[7];
						}elseif($mes == 8){
							$contratosmes8 += 1;
							$diascontratosmes8 = $diascontratosmes8 + $dias[8];
						}elseif($mes == 9){
							$contratosmes9 += 1;
							$diascontratosmes9 = $diascontratosmes9 + $dias[9];
						}elseif($mes == 10){
							$contratosmes10 += 1;
							$diascontratosmes10 = $diascontratosmes10 + $dias[10];
						}elseif($mes == 11){
							$contratosmes11 += 1;
							$diascontratosmes11 = $diascontratosmes11 + $dias[11];
						}elseif($mes == 12){
							$contratosmes12 += 1;
							$diascontratosmes12 = $diascontratosmes12 + $dias[12];
						}

					}elseif($inicio_mes <= $fecha_inicio and $fin_mes >= $fecha_inicio and $fecha_termino > $fin_mes){
						
						$datetime1 = new DateTime($fecha_inicio);
						$datetime2 = new DateTime($fin_mes);
						$interval = $datetime1->diff($datetime2);
						$dias_mes = $interval->format('%R%a días');

						$dias[$mes] = $dias_mes + 1;

						if($mes == 1){
							$contratosmes1 += 1;
							$diascontratosmes1 = $diascontratosmes1 + $dias[1];
						}elseif($mes == 2){
							$contratosmes2 += 1;
							$diascontratosmes2 = $diascontratosmes2 + $dias[2];
						}elseif($mes == 3){
							$contratosmes3 += 1;
							$diascontratosmes3 = $diascontratosmes3 + $dias[3];
						}elseif($mes == 4){
							$contratosmes4 += 1;
							$diascontratosmes4 = $diascontratosmes4 + $dias[4];
						}elseif($mes == 5){
							$contratosmes5 += 1;
							$diascontratosmes5 = $diascontratosmes5 + $dias[5];
						}elseif($mes == 6){
							$contratosmes6 += 1;
							$diascontratosmes6 = $diascontratosmes6 + $dias[6];
						}elseif($mes == 7){
							$contratosmes7 += 1;
							$diascontratosmes7 = $diascontratosmes7 + $dias[7];
						}elseif($mes == 8){
							$contratosmes8 += 1;
							$diascontratosmes8 = $diascontratosmes8 + $dias[8];
						}elseif($mes == 9){
							$contratosmes9 += 1;
							$diascontratosmes9 = $diascontratosmes9 + $dias[9];
						}elseif($mes == 10){
							$contratosmes10 += 1;
							$diascontratosmes10 = $diascontratosmes10 + $dias[10];
						}elseif($mes == 11){
							$contratosmes11 += 1;
							$diascontratosmes11 = $diascontratosmes11 + $dias[11];
						}elseif($mes == 12){
							$contratosmes12 += 1;
							$diascontratosmes12 = $diascontratosmes12 + $dias[12];
						}
					}
				}
			}
			array_push($listado, $aux);
			unset($aux);
		}

		//inicio tercer grafico
		$listado2 = array();
		foreach($listar_contratos_planta_usuario as $rm){
			$aux = new stdClass();
			$fecha_inicio = $rm->fecha_inicio;
			$fecha_termino = $rm->fecha_termino;

			if($fecha_inicio == '0000-00-00' or $fecha_termino == '0000-00-00'){
			}else{
				$meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
				foreach($meses as $mes){
					if($mes == 1){
						$ultimo_dia = "31";
					}elseif ($mes == 2){
						$ultimo_dia = '28';
					}elseif ($mes == 3){
						$ultimo_dia = '31';
					}elseif ($mes == 4){
						$ultimo_dia = '30';
					}elseif ($mes == 5){
						$ultimo_dia = '31';
					}elseif ($mes == 6){
						$ultimo_dia = '30';
					}elseif ($mes == 7){
						$ultimo_dia = '31';
					}elseif ($mes == 8){
						$ultimo_dia = '31';
					}elseif ($mes == 9){
						$ultimo_dia = '30';
					}elseif ($mes == 10){
						$ultimo_dia = '31';
					}elseif ($mes == 11){
						$ultimo_dia = '30';
					}elseif ($mes == 12){
						$ultimo_dia = '31';
					}else{
						$ultimo_dia = '30';
					}

					$time = strtotime($fecha.'-'.$mes.'-01');
					$time2 = strtotime($fecha.'-'.$mes.'-'.$ultimo_dia);
					$inicio_mes = date('Y-m-d',$time);
					$fin_mes = date('Y-m-d',$time2);

					if($inicio_mes <= $fecha_inicio and $fin_mes >= $fecha_inicio and $inicio_mes <= $fecha_termino and $fin_mes >= $fecha_termino){
						if($mes == 1){
							$contratosmesusuario1 += 1;
						}elseif($mes == 2){
							$contratosmesusuario2 += 1;
						}elseif($mes == 3){
							$contratosmesusuario3 += 1;
						}elseif($mes == 4){
							$contratosmesusuario4 += 1;
						}elseif($mes == 5){
							$contratosmesusuario5 += 1;
						}elseif($mes == 6){
							$contratosmesusuario6 += 1;
						}elseif($mes == 7){
							$contratosmesusuario7 += 1;
						}elseif($mes == 8){
							$contratosmesusuario8 += 1;
						}elseif($mes == 9){
							$contratosmesusuario9 += 1;
						}elseif($mes == 10){
							$contratosmesusuario10 += 1;
						}elseif($mes == 11){
							$contratosmesusuario11 += 1;
						}elseif($mes == 12){
							$contratosmesusuario12 += 1;
						}
					}elseif($fecha_inicio < $inicio_mes and $fin_mes < $fecha_termino){
						if($mes == 1){
							$contratosmesusuario1 += 1;
						}elseif($mes == 2){
							$contratosmesusuario2 += 1;
						}elseif($mes == 3){
							$contratosmesusuario3 += 1;
						}elseif($mes == 4){
							$contratosmesusuario4 += 1;
						}elseif($mes == 5){
							$contratosmesusuario5 += 1;
						}elseif($mes == 6){
							$contratosmesusuario6 += 1;
						}elseif($mes == 7){
							$contratosmesusuario7 += 1;
						}elseif($mes == 8){
							$contratosmesusuario8 += 1;
						}elseif($mes == 9){
							$contratosmesusuario9 += 1;
						}elseif($mes == 10){
							$contratosmesusuario10 += 1;
						}elseif($mes == 11){
							$contratosmesusuario11 += 1;
						}elseif($mes == 12){
							$contratosmesusuario12 += 1;
						}
					}elseif($fecha_inicio < $inicio_mes and $inicio_mes <= $fecha_termino and $fin_mes >= $fecha_termino){
						if($mes == 1){
							$contratosmesusuario1 += 1;
						}elseif($mes == 2){
							$contratosmesusuario2 += 1;
						}elseif($mes == 3){
							$contratosmesusuario3 += 1;
						}elseif($mes == 4){
							$contratosmesusuario4 += 1;
						}elseif($mes == 5){
							$contratosmesusuario5 += 1;
						}elseif($mes == 6){
							$contratosmesusuario6 += 1;
						}elseif($mes == 7){
							$contratosmesusuario7 += 1;
						}elseif($mes == 8){
							$contratosmesusuario8 += 1;
						}elseif($mes == 9){
							$contratosmesusuario9 += 1;
						}elseif($mes == 10){
							$contratosmesusuario10 += 1;
						}elseif($mes == 11){
							$contratosmesusuario11 += 1;
						}elseif($mes == 12){
							$contratosmesusuario12 += 1;
						}
					}elseif($inicio_mes <= $fecha_inicio and $fin_mes >= $fecha_inicio and $fecha_termino > $fin_mes){
						if($mes == 1){
							$contratosmesusuario1 += 1;
						}elseif($mes == 2){
							$contratosmesusuario2 += 1;
						}elseif($mes == 3){
							$contratosmesusuario3 += 1;
						}elseif($mes == 4){
							$contratosmesusuario4 += 1;
						}elseif($mes == 5){
							$contratosmesusuario5 += 1;
						}elseif($mes == 6){
							$contratosmesusuario6 += 1;
						}elseif($mes == 7){
							$contratosmesusuario7 += 1;
						}elseif($mes == 8){
							$contratosmesusuario8 += 1;
						}elseif($mes == 9){
							$contratosmesusuario9 += 1;
						}elseif($mes == 10){
							$contratosmesusuario10 += 1;
						}elseif($mes == 11){
							$contratosmesusuario11 += 1;
						}elseif($mes == 12){
							$contratosmesusuario12 += 1;
						}
					}
				}
			}
			array_push($listado2, $aux);
			unset($aux);
		}
		//fin tercer grafico

		if($diascontratosmes1 > 0){
			$total_dias_mes1 = round(($diascontratosmes1 / 30), 2);
		}else{
			$total_dias_mes1 = 0;
		}

		if($diascontratosmes2 > 0){
			$total_dias_mes2 = round(($diascontratosmes2 / 30), 2);
		}else{
			$total_dias_mes2 = 0;
		}

		if($diascontratosmes3 > 0){
			$total_dias_mes3 = round(($diascontratosmes3 / 30), 2);
		}else{
			$total_dias_mes3 = 0;
		}

		if($diascontratosmes4 > 0){
			$total_dias_mes4 = round(($diascontratosmes4 / 30), 2);
		}else{
			$total_dias_mes4 = 0;
		}

		if($diascontratosmes5 > 0){
			$total_dias_mes5 = round(($diascontratosmes5 / 30), 2);
		}else{
			$total_dias_mes5 = 0;
		}

		if($diascontratosmes6 > 0){
			$total_dias_mes6 = round(($diascontratosmes6 / 30), 2);
		}else{
			$total_dias_mes6 = 0;
		}

		if($diascontratosmes7 > 0){
			$total_dias_mes7 = round(($diascontratosmes7 / 30), 2);
		}else{
			$total_dias_mes7 = 0;
		}

		if($diascontratosmes8 > 0){
			$total_dias_mes8 = round(($diascontratosmes8 / 30), 2);
		}else{
			$total_dias_mes8 = 0;
		}

		if($diascontratosmes9 > 0){
			$total_dias_mes9 = round(($diascontratosmes9 / 30), 2);
		}else{
			$total_dias_mes9 = 0;
		}

		if($diascontratosmes10 > 0){
			$total_dias_mes10 = round(($diascontratosmes10 / 30), 2);
		}else{
			$total_dias_mes10 = 0;
		}

		if($diascontratosmes11 > 0){
			$total_dias_mes11 = round(($diascontratosmes11 / 30), 2);
		}else{
			$total_dias_mes11 = 0;
		}

		if($diascontratosmes12 > 0){
			$total_dias_mes12 = round(($diascontratosmes12 / 30), 2);
		}else{
			$total_dias_mes12 = 0;
		}

		$pagina['d_equiv1'] = $total_dias_mes1;
		$pagina['d_equiv2'] = $total_dias_mes2;
		$pagina['d_equiv3'] = $total_dias_mes3;
		$pagina['d_equiv4'] = $total_dias_mes4;
		$pagina['d_equiv5'] = $total_dias_mes5;
		$pagina['d_equiv6'] = $total_dias_mes6;
		$pagina['d_equiv7'] = $total_dias_mes7;
		$pagina['d_equiv8'] = $total_dias_mes8;
		$pagina['d_equiv9'] = $total_dias_mes9;
		$pagina['d_equiv10'] = $total_dias_mes10;
		$pagina['d_equiv11'] = $total_dias_mes11;
		$pagina['d_equiv12'] = $total_dias_mes12;
		$pagina['c_contratos1'] = $contratosmes1;
		$pagina['c_contratos2'] = $contratosmes2;
		$pagina['c_contratos3'] = $contratosmes3;
		$pagina['c_contratos4'] = $contratosmes4;
		$pagina['c_contratos5'] = $contratosmes5;
		$pagina['c_contratos6'] = $contratosmes6;
		$pagina['c_contratos7'] = $contratosmes7;
		$pagina['c_contratos8'] = $contratosmes8;
		$pagina['c_contratos9'] = $contratosmes9;
		$pagina['c_contratos10'] = $contratosmes10;
		$pagina['c_contratos11'] = $contratosmes11;
		$pagina['c_contratos12'] = $contratosmes12;
		$pagina['por_trabajador1'] = $contratosmesusuario1;
		$pagina['por_trabajador2'] = $contratosmesusuario2;
		$pagina['por_trabajador3'] = $contratosmesusuario3;
		$pagina['por_trabajador4'] = $contratosmesusuario4;
		$pagina['por_trabajador5'] = $contratosmesusuario5;
		$pagina['por_trabajador6'] = $contratosmesusuario6;
		$pagina['por_trabajador7'] = $contratosmesusuario7;
		$pagina['por_trabajador8'] = $contratosmesusuario8;
		$pagina['por_trabajador9'] = $contratosmesusuario9;
		$pagina['por_trabajador10'] = $contratosmesusuario10;
		$pagina['por_trabajador11'] = $contratosmesusuario11;
		$pagina['por_trabajador12'] = $contratosmesusuario12;
		$pagina['id_planta'] = $id_planta;
		$pagina['fecha'] = $fecha;
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$base['cuerpo'] = $this->load->view('informes/reportabilidad',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function reporte_causales($id_planta, $get_fecha = FALSE){
		$this->load->model('Empresa_planta_model');
		$this->load->model('Requerimientos_model');

		$nombre_planta = isset($this->Empresa_planta_model->get($id_planta)->nombre)?$this->Empresa_planta_model->get($id_planta)->nombre:"";

		$base = array(
			'css' => array("css/avance_pgp.css"),
			'head_titulo' => "Reportabilidad Causales",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$nombre_planta,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Reportabilidad Causales')),
			'js' => array('js/si_datepicker_reportabilidad_mandante.js'),
			'side_bar' => true,
			'menu' => $this->menu
		);

		$fecha_defecto = "2016";
		if (empty($get_fecha)){
			$fecha = $fecha_defecto;
		}else{
			$fecha = $get_fecha;
		}

		$fecha_inicio = $fecha."-01-01";
		$fecha_termino = $fecha."-12-31";

		$listar_contratos_planta = $this->Requerimientos_model->contratos_vigentes_planta($id_planta, $fecha_inicio, $fecha_termino);
		$listar_contratos_planta_usuario = $this->Requerimientos_model->contratos_vigentes_planta_por_usuario($id_planta, $fecha_inicio, $fecha_termino);
		$causal_a = 0;
		$causal_b = 0;
		$causal_c = 0;
		$causal_d = 0;
		$causal_e = 0;
		$causal_usuario_a = 0;
		$causal_usuario_b = 0;
		$causal_usuario_c = 0;
		$causal_usuario_d = 0;
		$causal_usuario_e = 0;

		foreach($listar_contratos_planta as $rm){
			$causal = $rm->causal_contrato;

			if($causal == 'A'){
				$causal_a += 1;
			}elseif($causal == 'B'){
				$causal_b += 1;
			}elseif($causal == 'C'){
				$causal_c += 1;
			}elseif($causal == 'D'){
				$causal_d += 1;
			}elseif($causal == 'E'){
				$causal_e += 1;
			}
		}

		foreach($listar_contratos_planta_usuario as $rm){
			$causal = $rm->causal_contrato;

			if($causal == 'A'){
				$causal_usuario_a += 1;
			}elseif($causal == 'B'){
				$causal_usuario_b += 1;
			}elseif($causal == 'C'){
				$causal_usuario_c += 1;
			}elseif($causal == 'D'){
				$causal_usuario_d += 1;
			}elseif($causal == 'E'){
				$causal_usuario_e += 1;
			}
		}

		$pagina['c_contratosA'] = $causal_a;
		$pagina['c_contratosB'] = $causal_b;
		$pagina['c_contratosC'] =  $causal_c;
		$pagina['c_contratosD'] =  $causal_d;
		$pagina['c_contratosE'] = $causal_e;
		$pagina['por_trabajadorA'] = $causal_usuario_a;
		$pagina['por_trabajadorB'] = $causal_usuario_b;
		$pagina['por_trabajadorC'] = $causal_usuario_c;
		$pagina['por_trabajadorD'] = $causal_usuario_d;
		$pagina['por_trabajadorE'] = $causal_usuario_e;
		$this->load->model('Empresa_planta_model');
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$pagina['id_planta'] = $id_planta;
		$pagina['fecha'] = $fecha;
		$base['cuerpo'] = $this->load->view('informes/reporte_causales',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function indicador_permanencia($id_planta){
		$this->load->model('Empresa_planta_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		
		$base = array(
			'css' => array("css/avance_pgp.css"),
			'head_titulo' => "Indicador de Permanencia - Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Indicador de Permanencia')),
			'side_bar' => true,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);

		$trabajadores = $this->Requerimientos_model->listar_trabajadores_asc_planta($id_planta);
		$listado = array();
		foreach($trabajadores as $rm){
			$aux = new stdClass();
			$aux->id_usuario = $rm->usuario_id;
			$get_usu = $this->Usuarios_model->get($rm->usuario_id);
			$aux->rut_usuario = (isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"");
			$aux->nombres = (isset($get_usu->nombres)?$get_usu->nombres:"");
			$aux->paterno = (isset($get_usu->paterno)?$get_usu->paterno:"");
			$aux->materno = (isset($get_usu->materno)?$get_usu->materno:"");

			$get_fecha_primer_contrato = $this->Requerimientos_model->obtener_fecha_primer_contrato($rm->usuario_id, $id_planta);
			$fecha_primer_contrato = (isset($get_fecha_primer_contrato->fecha_inicio)?$get_fecha_primer_contrato->fecha_inicio:'');

			$get_ultimo_area_cargo = $this->Requerimientos_model->obtener_ultimo_area_cargo($rm->usuario_id, $id_planta);
			$id_area = (isset($get_ultimo_area_cargo->areas_id)?$get_ultimo_area_cargo->areas_id:"");
			$id_cargo = (isset($get_ultimo_area_cargo->cargos_id)?$get_ultimo_area_cargo->cargos_id:"");
			$aux->nombre_area = (isset($this->Areas_model->r_get($id_area)->nombre)?$this->Areas_model->r_get($id_area)->nombre:""); 
			$aux->nombre_cargo = (isset($this->Cargos_model->r_get($id_cargo)->nombre)?$this->Cargos_model->r_get($id_cargo)->nombre:""); 

			$get_dias_trabajados = 0;
			foreach ($this->Requerimientos_model->obtener_fechas_contratos($rm->usuario_id, $id_planta) as $key){
				if($key->fecha_termino > date('Y-m-d')){
					$segundos = strtotime(date('Y-m-d')) - strtotime($key->fecha_inicio);
					$total_dias = intval($segundos/60/60/24) + 1;
				}else{
					$segundos = strtotime($key->fecha_termino) - strtotime($key->fecha_inicio);
					$total_dias = intval($segundos/60/60/24) + 1;
				}
				$get_dias_trabajados += $total_dias;
			}

			if($get_dias_trabajados < 0)
				$dias_trabajados = 0;
			else
				$dias_trabajados = $get_dias_trabajados;

			if($fecha_primer_contrato == ""){
				$aux->fecha_primer_contrato = "";
				$aux->dias_trabajados = "";
				$aux->dias_corridos_trabajados = "";
				$aux->permanencia = "0";
				$aux->color_permanencia = "";
			}else{
				$segundos = strtotime('now') - strtotime($fecha_primer_contrato);
				
				$get_dias_corridos_trabajados=intval($segundos/60/60/24) + 1;
				if($get_dias_corridos_trabajados < 0)
					$dias_corridos_trabajados = 0;
				else
					$dias_corridos_trabajados=intval($segundos/60/60/24) + 1;

				$aux->fecha_primer_contrato = $fecha_primer_contrato;
				$aux->dias_trabajados = $dias_trabajados;
				$aux->dias_corridos_trabajados = $dias_corridos_trabajados;

				$get_permanencia = round(( ($dias_trabajados * 100) / $dias_corridos_trabajados ), 0);

				if($get_permanencia < 0){
					$permanencia = 0;
				}elseif($get_permanencia > 100){
					$permanencia = 100;
				}else{
					$permanencia = $get_permanencia;
				}

				$aux->permanencia = $permanencia;
				
				if($permanencia >= 0 and $permanencia <= 39){
					$aux->color_permanencia = "green";
				}elseif($permanencia >= 40 and $permanencia <= 69){
					$aux->color_permanencia = "#DAAA08";
				}elseif($permanencia >= 70){
					if($dias_trabajados >= 100){
						$aux->color_permanencia = "#DF0101";
					}elseif($dias_trabajados <= 99){
						$aux->color_permanencia = "#DAAA08";
					}
				}else{
					$aux->color_permanencia = "#DF0101";
				}
			}
			array_push($listado, $aux);
			unset($aux);
		}

		$pagina['listado'] = $listado;
		$pagina['id_planta'] = $id_planta;
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$base['cuerpo'] = $this->load->view('informes/indicador_permanencia',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function detalle_requerimientos($id_planta){
		$this->load->model('Noticias_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model("Usuarios_model");
		$this->load->model('Requerimientos_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_area_cargo_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->helper("text");

		$base = array(
			'head_titulo' => "Detalle Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => 'Empresas Arauco S.A. - Unidad de Negocio (Nueva Aldea, Licancel)',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Requerimientos por Planta')),
			'menu' => $this->menu,
			'js' => array('plugins/tooltipster/jquery.tooltipster.min.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/mandante_index.js'),
			'css' => array('plugins/tooltipster/tooltipster.css','plugins/tooltipster/themes/tooltipster-light.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','css/avance_pgp.css'),
		);
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['noticias'] = "";

		$lista = array();
		foreach ($this->Requerimientos_model->r_listar_order_fecha_planta_activos($id_planta) as $l){
			$aux = new StdClass();
			$personas = 0;
			$servicio = 0;
			$proceso = 0;
			foreach ($this->Requerimiento_area_cargo_model->get_requerimiento($l->id) as $r){
				$personas += $r->cantidad;
			}
			foreach ($this->Requerimiento_asc_trabajadores_model->get_requerimiento($l->id) as $g){
				if ($g->status == 3)
					$servicio += 1;
				elseif($g->status == 2)
					$proceso += 1;
			}
			$aux->id = $l->id;
			$aux->nombre = $l->nombre;
			$aux->dot = $personas;
			$aux->regimen = $l->regimen;
			$f_inicio = explode('-', $l->f_inicio);
			$f_inicio = $f_inicio[2].'-'.$f_inicio[1].'-'.$f_inicio[0];
			$aux->f_inicio = $f_inicio;
			$f_fin = explode('-', $l->f_fin);
			$f_fin = $f_fin[2].'-'.$f_fin[1].'-'.$f_fin[0];
			$aux->f_fin = $f_fin;
			$aux->servicio = $servicio;
			$aux->proceso = $proceso;
			if ($personas != 0) {
				$aux->porcentaje = number_format( ($servicio * 100) / $personas, 2);
			}else{
				$aux->porcentaje=0;
			}
			array_push($lista, $aux);
			unset($aux);
		}
		$pagina['id_planta'] = $id_planta;
		$pagina['requerimientos'] = $lista;
		//$aviso['titulo'] = "Bienvenido: <a href='#'>Revisar tal parte del sitio</a>";
		//$aviso['comentario'] = "Tiene que cerrar este mensaje para que no se vuelva a ver."; 
		$base['cuerpo'] = $this->load->view('informes/home',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function trazabilidad2($id_planta) {
		$base = array(
			'head_titulo' => "Informes Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => 'Empresas Arauco S.A. - Unidad de Negocio (Nueva Aldea, Licancel)',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio')),
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE),
			'menu' => $this->menu,
			'js' => array('plugins/tooltipster/jquery.tooltipster.min.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/mandante_index.js'),
			'css' => array('plugins/tooltipster/tooltipster.css','plugins/tooltipster/themes/tooltipster-light.css','plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','css/avance_pgp.css'),
		);
		$pagina['id_planta'] = $id_planta;
		$base['cuerpo'] = $this->load->view('layout2.0/home',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function planilla_pgp($id = FALSE, $id_planta = FALSE) {
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->model('Empresas_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Planta_model');
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");

		$base = array(
			'head_titulo' => "Inicio Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Planilla de suministro de personal' )),
			'side_bar' => true,
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','plugins/tooltipster/jquery.tooltipster.min.js','js/planilla_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/tooltipster/tooltipster.css','plugins/tooltipster/themes/tooltipster-light.css','css/avance_pgp.css'),
		);

		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$pagina['requerimiento'] = $this->Requerimientos_model->get($id);

		$lista_aux = array();
		foreach ($this->Requerimiento_area_cargo_model->get_requerimiento($id) as $r){
			$aux1 = new stdClass();
			$aux1->id = $r->id;
			$get_area = $this->Areas_model->r_get($r->areas_id);
			$get_cargo = $this->Cargos_model->r_get($r->cargos_id);
			$aux1->nombre_area = (isset($get_area->nombre))?$get_area->nombre:'';
			$aux1->nombre_cargo = (isset($get_cargo->nombre))?$get_cargo->nombre:'';
			$aux1->cantidad = (isset($r->cantidad))?$r->cantidad:'';
			$p_asignadas = count($this->Requerimiento_asc_trabajadores_model->get_cargo_area($r->id));
			$aux1->asignadas = $p_asignadas;
			array_push($lista_aux,$aux1);
			unset($aux1);
		}

		$pagina['area_cargos_requerimiento'] = $lista_aux;
		$pagina['id'] = $id;
		$pagina['id_planta'] = $id_planta;
		$pagina['asignadas'] = $p_asignadas;
		$base['cuerpo'] = $this->load->view('layout2.0/planilla',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

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

	function planilla_pgp2() {
		$base = array(
			'head_titulo' => "Inicio Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'mandante/index', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Planilla de suministro de personal' )),
			'side_bar' => true,
			'js' => array('plugins/tooltipster/jquery.tooltipster.min.js','js/planilla_pgp.js','js/avance_pgp.js'),
			'css' => array('plugins/tooltipster/tooltipster.css','plugins/tooltipster/themes/tooltipster-light.css','css/avance_pgp.css'),
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
			'menu' => $this->menu
		);

		$this->load->model('Noticias_model');
		$this->load->model("Usuarios_model");
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->helper("text");
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['noticias'] = $this->Noticias_model->listar_limite(3,1);
		$id_planta = $pagina['usuario']->id_planta;
		$base['cuerpo'] = $this->load->view('layout2.0/planilla2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function avance_pgp($id = FALSE) {
		$base = array(
			'css' => array("css/avance_pgp.css"),
			'head_titulo' => "Inicio Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'mandante/planilla_pgp/'.$id, 'txt' => 'Planilla de suministro de personal' ), array('url' => '', 'txt' => 'Avance')),
			'side_bar' => true,
			'js' => array('js/avance_pgp.js'),
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);

		$this->load->model('Noticias_model');
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->helper("text");
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['noticias'] = "";
		$personas = 0;
		$servicio = 0;
		$proceso = 0;
		$no_disponible = 0;
		$no_contactado = 0;
		$referido = 0;
		foreach ($this->Requerimiento_area_cargo_model->get_requerimiento($id) as $r) {
			$personas += $r->cantidad;
		}
		foreach ($this->Requerimiento_asc_trabajadores_model->get_requerimiento($id) as $g) {
			if ($g->status == 3)
				$servicio += 1;
			elseif($g->status == 2)
				$proceso += 1;
			elseif($g->status == 1)
				$no_disponible += 1;
			elseif($g->status == 0)
				$no_contactado += 1;

			if($g->referido == 1)
				$referido += 1;
		}
		$id_planta = 5;
		$pagina['id_requerimiento'] = $id;
		$pagina['personas'] = $personas;
		$pagina['servicio'] = $servicio;
		$pagina['proceso'] = $proceso;
		$pagina['referido'] = $referido;
		$pagina['no_disponible'] = $no_disponible;
		$pagina['no_contactado'] = $no_contactado;
		$pagina['porcentaje'] = number_format( ($servicio * 100) / $personas, 2);
		$pagina['porcentaje_proceso'] = number_format( ($proceso * 100) / $personas, 2);
		$pagina['porcentaje_no_disponible'] = number_format( ($no_disponible * 100) / $personas, 2);
		$pagina['porcentaje_no_contactado'] = number_format( ($no_contactado * 100) / $personas, 2);
		$pagina['porcentaje_referido'] = number_format( ($referido * 100) / $personas, 2);
		$pagina['requerimiento'] = $this->Requerimientos_model->get($id);
		$area_cargo =  $this->Requerimiento_area_cargo_model->get_requerimiento($id);
		$base['cuerpo'] = $this->load->view('layout2.0/avance',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function causales_contratacion($id = FALSE) {
		$base = array(
			'css' => array("css/avance_pgp.css"),
			'head_titulo' => "Inicio Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'mandante/index', 'txt' => 'Inicio'), array('url' => 'mandante/planilla_pgp/'.$id, 'txt' => 'Planilla de suministro de personal' ), array('url' => '', 'txt' => 'Causales Contratacion')),
			'side_bar' => true,
			'js' => array('js/avance_pgp.js'),
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);

		$this->load->model('Noticias_model');
		$this->load->model("Usuarios_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimientos_model");
		$this->load->helper("text");
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['noticias'] = "";
		$personas = 0;
		$servicio = 0;
		$proceso = 0;
		$no_disponible = 0;
		$referido = 0;
		foreach ($this->Requerimiento_area_cargo_model->get_requerimiento($id) as $r){
			$personas += $r->cantidad;
		}
		foreach ($this->Requerimiento_asc_trabajadores_model->get_requerimiento($id) as $g) {
			if ($g->status == 3)
				$servicio += 1;
			elseif($g->status == 2)
				$proceso += 1;
			elseif($g->status == 1)
				$no_disponible += 1;

			if($g->referido == 1)
				$referido += 1;
		}

		$pagina['causalA'] = 20;
		$pagina['causalB'] = 25;
		$pagina['causalC'] = 22;
		$pagina['causalD'] = 15;
		$pagina['causalE'] = 19;
		$pagina['id_requerimiento'] = $id;
		$pagina['requerimiento'] = $this->Requerimientos_model->get($id);
		$base['cuerpo'] = $this->load->view('layout2.0/grafico_causales_contratacion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function avance_pgp2() {
		$base = array(
			'css' => array("css/avance_pgp.css"),
			'head_titulo' => "Inicio Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'mandante/index', 'txt' => 'Inicio'), array('url' => 'mandante/planilla_pgp2', 'txt' => 'Planilla de suministro de personal' ), array('url' => '', 'txt' => 'Avance')),
			'side_bar' => true,
			'js' => array('js/avance_pgp.js'),
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);

		$this->load->model('Noticias_model');
		$this->load->model("Usuarios_model");
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->helper("text");
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['noticias'] = "";
		$id_planta = 5;
		$base['cuerpo'] = $this->load->view('layout2.0/avance2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function detalle_pgp($id = FALSE, $id_req = FALSE, $id_planta = FALSE){
		$this->load->model('Noticias_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model("Usuarios_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->model('Requerimiento_area_cargo_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Evaluacionesarchivo_model');
		$this->load->model('Archivos_trab_model');
		$this->load->helper("text");
		$base = array(
			'head_titulo' => "Detalle PGP Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('txt' => 'Planilla de suministro de personal' )),
			'side_bar' => false,
			'menu' => $this->menu,
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE),
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','plugins/tooltipster/jquery.tooltipster.min.js','js/detalle_pgp.js','plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
		);
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$pagina['noticias'] = "";
		//$id_planta = 5;
		$lista = array();
		$pagina['detalle'] = $id;
		$pagina['id_requerimiento'] = $id_req;
		$pagina['id_planta'] = $id_planta;
		$req = 0;
		$area_cargo = $this->Requerimiento_area_cargo_model->get($id);
		$pagina['area'] = $this->Areas_model->r_get($area_cargo->areas_id)->nombre;
		$pagina['cargo'] = $this->Cargos_model->r_get($area_cargo->cargos_id);
		
		foreach ($this->Requerimiento_asc_trabajadores_model->get_cargo_area($id) as $p) {
			$aux = new StdClass();
			$u = $this->Usuarios_model->get($p->usuario_id);
			$e = $this->Especialidadtrabajador_model->get_usuario($p->usuario_id);
			$mas = $this->Evaluaciones_model->get_una_masso($p->usuario_id);
			$pre = $this->Evaluaciones_model->get_una_preocupacional($p->usuario_id);
			$ar_contrato = $this->Archivos_trab_model->get_archivo($p->usuario_id,15);
			$ar_certificado = $this->Archivos_trab_model->get_archivo($p->usuario_id,9);
			if (!$ar_certificado)
				$ar_certificado = $this->Archivos_trab_model->get_archivo($p->usuario_id,10);
			$aux->req = $this->Requerimiento_area_cargo_model->get($p->requerimiento_area_cargo_id)->requerimiento_id;
			$aux->id = $p->id;
			$aux->id_usuario = $u->id;
			$aux->nombre = ucwords(mb_strtolower($u->nombres.' '.$u->paterno.' '.$u->materno,'UTF-8'));
			$aux->referido = ($p->referido)?'Si':'No';
			$aux->especialidad = ($e) ? ucwords(mb_strtolower($e->desc_especialidad,'UTF-8')) : '';
			$aux->contacto = ($p->contacto)?'Si':'No';
			$aux->disponibilidad = ($p->disponibilidad)?'Si':'No';
			$aux->certificacion = ($ar_certificado)?'Si':'No';
			$aux->certificacion_url = (!empty($ar_certificado->url))?$ar_certificado->url:'';
			$aux->masso = ($mas)?'Si':'No';
			$aux->masso_url = ($mas)? $mas->url :'';
			$aux->preocupacional = ($pre)?'Si':'No';
			$aux->preocupacional_url = ($pre)? $pre->url :'';
			$aux->contrato = ($p->contrato)?'Si':'No';
			$aux->jefe_area = $p->jefe_area;
			$aux->comentario = ($p->comentario)?true:false;
			$aux->comentario_text = $p->comentario;
			$aux->id_requerimiento = $id;
			if($p->status == 0) $aux->status = 'No Contactado';
			if($p->status == 1) $aux->status = 'No Disponible';
			if($p->status == 2) $aux->status = 'En Proceso';
			if($p->status == 3) $aux->status = 'En Servicio';
			if($p->status == 4) $aux->status = 'Renuncia';
			if($p->status == 5) $aux->status = 'Contrato Firmado';
			if($p->status == 6) $aux->status = 'Contrato Finalizado';
			array_push($lista, $aux);
			unset($aux);
		}
		
		$pagina['personas'] = $lista;
		$base['cuerpo'] = $this->load->view('layout2.0/detalle_pgp',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function callback_view_documentos($id_usuario,$id_asc_area_req){
		$this->load->model("tipoarchivos_requerimiento_model");
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("requerimiento_usuario_archivo_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Evaluaciones_model");

		$usr = $this->Usuarios_model->get($id_usuario);
		$base['nombre'] = $usr->nombres.' '.$usr->paterno.' '.$usr->materno;
		
		$archivos = $this->tipoarchivos_requerimiento_model->listar();
		$salida = array();
		foreach ($archivos as $a) {
			$dato = $this->requerimiento_usuario_archivo_model->get_usuario_requerimiento_archivo($id_usuario,$id_asc_area_req,$a->id);
			$aux = new StdClass();
			$aux->archivo = $a->nombre;
			$aux->datos = array();
			if (!empty($dato)){
				foreach ($dato as $d) {
					$archivo = new StdClass();
					$archivo->nombre = urldecode($d->nombre);
					$archivo->url = $d->url;
					array_push($aux->datos, $archivo);
				}
				unset($archivo);
			}
			array_push($salida, $aux);
			unset($aux);
		}

		$base['archivos'] = $salida;//Fin Archivos Requerimientos

		$archivos_trab = $this->Tipoarchivos_model->listar_2();
		$salida2 = array();
		foreach ($archivos_trab as $a){
			$aux = new StdClass();
			$aux->nombre = $a->desc_tipoarchivo;

			$get_archivo_trabaj = $this->Archivos_trab_model->get_archivo2($id_usuario, $a->id);
			$aux->nombre_archivo_trabaj = (isset($get_archivo_trabaj->nombre))?$get_archivo_trabaj->nombre:'';
			$aux->archivo_trabaj = (isset($get_archivo_trabaj->url))?$get_archivo_trabaj->url:'';
			array_push($salida2, $aux);
			unset($aux);
		}

		$base['archivos_trab'] = $salida2;
		$base['masso'] = $this->Evaluaciones_model->get_una_masso($id_usuario);
		$base['preocupacional'] = $this->Evaluaciones_model->get_una_preocupacional($id_usuario);
		$this->load->view('layout2.0/documentos_contractuales',$base);
	}









	function modal_comentario($id){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$base['id'] = $id;
		$base['comentario'] = ($this->Requerimiento_asc_trabajadores_model->get($id)->comentario_mandante)?$this->Requerimiento_asc_trabajadores_model->get($id)->comentario_mandante:'';
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->load->model("Requerimiento_asc_trabajadores_model");

			$data = array('comentario_mandante' => $_POST['comentario']);
			$this->Requerimiento_asc_trabajadores_model->editar($id,$data);
		} 
		else
			$this ->load->view('est/requerimiento/modal_comentario',$base);
	}

	function modal_comentario_integra($id){
		$this->load->model("Requerimiento_asc_trabajadores_model");
		echo ($this->Requerimiento_asc_trabajadores_model->get($id)->comentario)?$this->Requerimiento_asc_trabajadores_model->get($id)->comentario:'';
	}

	function detalle_pgp2() {

		$base = array(
			'head_titulo' => "Inicio Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'mandante/index', 'txt' => 'Inicio'), array('url' => 'mandante/planilla_pgp2', 'txt' => 'Planilla de suministro de personal' ), array('url' => '', 'txt' => 'Detalle')),
			'side_bar' => false,
			'js' => array('plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js'),
			'css' => array('plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);

		$this->load->model('Noticias_model');
		$this->load->model("Usuarios_model");
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->helper("text");
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		//$pagina['noticias'] = $this->Noticias_model->listar_limite(3,1);
		$pagina['noticias'] = "";
		//$id_planta = $pagina['usuario']->id_planta;
		$id_planta = "";
		

		//$pagina['avisos'] = $this -> load -> view('avisos',$aviso,TRUE);
		$base['cuerpo'] = $this->load->view('layout2.0/detalle_pgp2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function perfil2($id_trabajador){
		$base = array(
			'head_titulo' => "Datos Trabajador - Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'side_bar' => false,
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante')
		);

		$this->load->model('Noticias_model');
		$this->load->model("Usuarios_model");
		$this->load->model("Usu_Parentesco_model");
		$this->load->model("Nivelestudios_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Experiencia_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->helper("text");
		
		$pagina['usuario'] = $this->Usuarios_model->get($id_trabajador);
		$pagina['experiencias'] = $this->Experiencia_model->get_usuario($id_trabajador);
		$listado = array();
		foreach($this->Usuarios_model->get_datos_trabajador($id_trabajador) as $r){
			$aux = new stdClass();
			$aux->nombre_trab = (isset($r->nombres))?$r->nombres:'';
			$aux->a_paterno = (isset($r->paterno))?$r->paterno:'';
			$aux->a_materno = (isset($r->materno))?$r->materno:'';
			$aux->rut = (isset($r->rut_usuario))?$r->rut_usuario:'';
			$aux->sexo = (isset($r->sexo))?$r->sexo:'';
			$aux->fecha_nac = (isset($r->fecha_nac))?$r->fecha_nac:'';
			$get_datos_estado = $this->Estadocivil_model->get($r->id_estadocivil);
			$aux->estado_civil = (isset($get_datos_estado->desc_estadocivil))?$get_datos_estado->desc_estadocivil:'';
			$aux->nacionalidad = (isset($r->nacionalidad))?$r->nacionalidad:'';
			$get_datos_afp = $this->Afp_model->get($r->id_afp);
			$aux->afp = (isset($get_datos_afp->desc_afp))?$get_datos_afp->desc_afp:'';
			$get_datos_sistema_salud = $this->Salud_model->get($r->id_salud);
			$aux->sistema_salud = (isset($get_datos_sistema_salud->desc_salud))?$get_datos_sistema_salud->desc_salud:'';
			$aux->emerg_nombre = $r->emerg_nombre;
			$aux->emerg_telefono = $r->emerg_telefono;
			$get_parentesco = $this->Usu_Parentesco_model->get($r->emerg_parentesco_id);
			$aux->emerg_parentesco = (isset($get_parentesco->nombre))?$get_parentesco->nombre:'';
			$get_nivel_estudios = $this->Nivelestudios_model->get($r->id_estudios);
			$aux->nivel_estudios = (isset($get_nivel_estudios->desc_nivelestudios))?$get_nivel_estudios->desc_nivelestudios:'';
			$get_profesiones = $this->Profesiones_model->get($r->id_profesiones);
			$aux->profesiones = (isset($get_profesiones->desc_profesiones))?$get_profesiones->desc_profesiones:'';
			$get_especialidad_1 = $this->Especialidadtrabajador_model->get($r->id_especialidad_trabajador);
			$get_especialidad_2 = $this->Especialidadtrabajador_model->get($r->id_especialidad_trabajador_2);
			$get_especialidad_3 = $this->Especialidadtrabajador_model->get($r->id_especialidad_trabajador_3);
			$aux->especialidad_1 = (isset($get_especialidad_1->desc_especialidad))?$get_especialidad_1->desc_especialidad:'0';
			$aux->especialidad_2 = (isset($get_especialidad_2->desc_especialidad))?$get_especialidad_2->desc_especialidad:'0';
			$aux->especialidad_3 = (isset($get_especialidad_3->desc_especialidad))?$get_especialidad_3->desc_especialidad:'0';
			$get_charla_masso = $this->Evaluaciones_model->get_una_masso($id_trabajador);
			$get_examen_preocup = $this->Evaluaciones_model->get_una_preocupacional($id_trabajador);
			$aux->fecha_eval_masso = (isset($get_charla_masso->fecha_e))?$get_charla_masso->fecha_e:'';
			$aux->fecha_vigencia_masso = (isset($get_charla_masso->fecha_v))?$get_charla_masso->fecha_v:'';
			$aux->archivo_masso = (isset($get_charla_masso->url))?$get_charla_masso->url:'0';
			$aux->fecha_eval_preocup = (isset($get_examen_preocup->fecha_e))?$get_examen_preocup->fecha_e:'';
			$aux->fecha_vigencia_preocup = (isset($get_examen_preocup->fecha_v))?$get_examen_preocup->fecha_v:'';
			$aux->archivo_preocup = (isset($get_examen_preocup->url))?$get_examen_preocup->url:'0';
			array_push($listado,$aux);
		}

		$pagina['listado'] = $listado;
		$pagina['noticias'] = "";
		$id_planta = "";
		$base['cuerpo'] = $this->load->view('layout2.0/perfil',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function evaluar_pgp($id, $id_planta = FALSE){
		$this->load->model('Noticias_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model("Usuarios_model");
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Archivos_trab_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('r_requerimiento_evaluacion_model');
		$this->load->helper("text");
		$base = array(
			'head_titulo' => "Evaluacion Requerimiento - Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Evaluar Trabajadores')),
			'side_bar' => false,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$pagina['id_planta'] = $id_planta;
		$pagina['id'] = $id;
		$pagina['noticias'] = "";
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
		$pagina['requerimiento'] = $this->Requerimientos_model->get($id);
		$base['cuerpo'] = $this->load->view('layout2.0/evaluacion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_ingresar_evaluacion($usuario,$area_cargo, $id_planta){
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
		$pagina['id_planta'] = $id_planta;
		$pagina['id_usuario'] = $usuario;
		$pagina['area_cargo'] = $area_cargo;
		$this->load->view('layout2.0/modal_evaluar', $pagina);
	}

	function guardar_evaluacion(){
		$this->load->model("r_requerimiento_evaluacion_model");
		$fecha_hoy = date('Y-m-d');
		$id_area_cargo = $_POST['area_cargo'];
		$id_usuario = $_POST['id_usuario'];
		$id_planta = $_POST['id_planta'];
		$suma_uno = ($_POST['trabajo_equipo'] + $_POST['orientacion_calidad'] + $_POST['orientacion_logro'] + $_POST['iniciativa_productividad'] + $_POST['adaptabilidad_al_cambio'] + $_POST['capacidad_aprendizaje'] + $_POST['concientizacion_seguridad_ma']);
		$suma_dos = ($_POST['tolerancia_trabajo_bajo_presion'] + $_POST['comunicacion_todo_nivel'] + $_POST['analisis_evaluacion_problemas'] + $_POST['disponibilidad_recibir_ordenes'] + $_POST['relaciones_interpersonales']);
		$suma_tres = ($_POST['aplicacion_conocimientos'] + $_POST['capacidad_toma_decisiones'] + $_POST['liderazgo'] + $_POST['responsabilidad'] + $_POST['autocuidado'] + $_POST['presentacion_personal'] + $_POST['cumplimiento_normas'] + $_POST['motivacion'] + $_POST['respeto']);
		$promedio_calif_final = (($suma_uno + $suma_dos + $suma_tres) / 21);

		$datos = array(
			"usuario_id" => $id_usuario,
			"requerimiento_id" => $id_area_cargo,
			"trabajo_equipo" => $_POST['trabajo_equipo'],
			"orientacion_calidad" => $_POST['orientacion_calidad'],
			"orientacion_logro" => $_POST['orientacion_logro'],
			"iniciativa_productividad" => $_POST['iniciativa_productividad'],
			"adaptabilidad_al_cambio" => $_POST['adaptabilidad_al_cambio'],
			"capacidad_aprendizaje" => $_POST['capacidad_aprendizaje'],
			"concientizacion_seguridad_ma" => $_POST['concientizacion_seguridad_ma'],
			"tolerancia_trabajo_bajo_presion" => $_POST['tolerancia_trabajo_bajo_presion'],
			"comunicacion_todo_nivel" => $_POST['comunicacion_todo_nivel'],
			"analisis_evaluacion_problemas" => $_POST['analisis_evaluacion_problemas'],
			"disponibilidad_recibir_ordenes" => $_POST['disponibilidad_recibir_ordenes'],
			"relaciones_interpersonales" => $_POST['relaciones_interpersonales'],
			"aplicacion_conocimientos" => $_POST['aplicacion_conocimientos'],
			"capacidad_toma_decisiones" => $_POST['capacidad_toma_decisiones'],
			"liderazgo" => $_POST['liderazgo'],
			"responsabilidad" => $_POST['responsabilidad'],
			"autocuidado" => $_POST['autocuidado'],
			"presentacion_personal" => $_POST['presentacion_personal'],
			"cumplimiento_normas" => $_POST['cumplimiento_normas'],
			"motivacion" => $_POST['motivacion'],
			"respeto" => $_POST['respeto'],
			"recomienda" => $_POST['recomienda'],
			"calificacion_final" => $promedio_calif_final,
			"fecha" => $fecha_hoy,
		);

		$existen_registros = $this->r_requerimiento_evaluacion_model->get_si_existe_requerimiento($id_usuario, $id_area_cargo);

		if ($existen_registros == 1){
			$this->r_requerimiento_evaluacion_model->actualizar_r_requerimiento($id_usuario, $id_area_cargo, $datos);
		}elseif ($existen_registros == 0){
			$this->r_requerimiento_evaluacion_model->guardar_evaluacion($datos);
		}else{
			echo "<script>alert('Ocurrio un error con el Usuario ID: $id_usuario')</script>";
		}
		echo '<script>alert("Evaluacion Ingresada Correctamente");</script>';
		redirect('mandante/evaluar_pgp/'.$id_area_cargo.'/'.$id_planta, 'refresh');
	}

	function evaluar_pgp2() {
		$base = array(
			'head_titulo' => "Inicio Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'mandante/index', 'txt' => 'Inicio'), array('url' => 'mandante/planilla_pgp2', 'txt' => 'Planilla de suministro de personal' ), array('url' => '', 'txt' => 'Evaluar Trabajadores')),
			'side_bar' => true,
			'js' => array('plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js'),
			'css' => array('plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);

		$this->load->model('Noticias_model');
		$this->load->model("Usuarios_model");
		$this->load->model('Requerimiento_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->helper("text");
		
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		//$pagina['noticias'] = $this->Noticias_model->listar_limite(3,1);
		$pagina['noticias'] = "";
		//$id_planta = $pagina['usuario']->id_planta;
		$id_planta = "";
		$base['cuerpo'] = $this->load->view('layout2.0/evaluacion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function perfil_cargo($id) {
		$base = array(
			'head_titulo' => "Perfil de Cargo - Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Perfil de Cargo')),
			'side_bar' => true,
			'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);

		$this->load->model("Usuarios_model");
		$this->load->model("Perfil_cargo_model");
		$this->load->model("Cargos_model");

		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['cargo'] = $this->Perfil_cargo_model->get_cargo($id);
		$pagina['nombre_cargo'] = $this->Cargos_model->r_get($id);
		$base['cuerpo'] = $this->load->view('layout2.0/perfil_cargo',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function perfil_trabajador($id_usuario,$detalle,$req) {
		$base = array(
			'head_titulo' => "Inicio Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'mandante/index', 'txt' => 'Inicio'), array('url' => 'mandante/planilla_pgp/'.$req, 'txt' => 'Planilla de suministro de personal' ), array('url' => 'mandante/detalle_pgp/'.$detalle, 'txt' => 'Detalle'), array('url' => '', 'txt' => 'Perfil Cargo Trabajador')),
			'side_bar' => true,
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);

		$this->load->model("Usuarios_model");

		$pagina['usuario'] = $this->Usuarios_model->get($id_usuario);
		$base['cuerpo'] = $this->load->view('layout2.0/perfil_trabajador',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function reportabilidad2($id){
		$this->load->model('Usuarios_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('ciudad_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Areas_model');
		$this->load->model('Cargos_model');
		$this->load->model('Archivos_trab_model');
		$this->load->model('Requerimiento_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Requerimiento_trabajador_model');
		$this->load->model('Requerimiento_areas_model');
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Requerimiento_Usuario_Archivo_model');

		$base = array(
			'head_titulo' => "Reportabilidad Mandante",
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->session->userdata('sucursal_nb'),
			'lugar' => array(array('url' => 'mandante/index', 'txt' => 'Inicio'), array('url' => 'mandante/planilla_pgp/'.$id, 'txt' => 'Planilla de suministro de personal' ), array('url' => '', 'txt' => 'Reportabilidad')),
			'side_bar' => false,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
			//'menu' => $this->load->view('layout2.0/menus/menu_mandante',$this->noticias,TRUE)
		);

		$listado = array();

		foreach($this->Requerimiento_asc_trabajadores_model->get_requerimiento($id) as $r){
			$aux = new stdClass();

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
			$area = $this->Areas_model->r_get($r->areas_id);
			$cargo = $this->Cargos_model->r_get($r->cargos_id);
			$ar_contrato = $this->Archivos_trab_model->get_archivo($r->usuario_id,15);
			$ar_certificado = $this->Archivos_trab_model->get_archivo($r->usuario_id,9);
			$aux->id = $r->id;
			$aux->id_requerimiento = $id;
			$get_datos_requerimiento = $this->Requerimiento_model->r_get($id);
			$planta_id_req = (isset($get_datos_requerimiento->planta_id))?$get_datos_requerimiento->planta_id:'0';
			$aux->codigo_requerimiento = (isset($get_datos_requerimiento->codigo_requerimiento))?$get_datos_requerimiento->codigo_requerimiento:'N/D';
			$get_datos_planta = $this->Empresa_planta_model->get($planta_id_req);
			$aux->nombre_planta = (isset($get_datos_planta->nombre))?$get_datos_planta->nombre:'0';

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
			$aux->area = $area->nombre;
			$aux->cargo = $cargo->nombre;
			$aux->contrato = $ar_contrato;
			$aux->certificado = $ar_certificado;
			$aux->comentario = $r->comentario;
			$aux->jefe_area = $r->jefe_area;
			$aux->asc_trabajadores = $r->id_asc_trabajadores;
			array_push($listado,$aux);
		}
		$pagina['requerimiento'] = $this->Requerimientos_model->get($id);
		$pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('layout2.0/reportabilidad',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}


}
?>