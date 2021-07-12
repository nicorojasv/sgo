<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	class Cron extends CI_Controller {
	
	function dos_vez_al_dia(){
		//inicio examen_preo();
		$this->load->model("Usuarios_model");
		foreach ($this->Usuarios_model->listar_usuarios_evaluaciones_preo() as $rm){
			$get_cantidad = $this->Usuarios_model->contar_evaluaciones_preo($rm->id_usuarios);
			$total_examenes = isset($get_cantidad->total)?$get_cantidad->total:0;
			if($total_examenes >= 1){
				$get_ultimo = $this->Usuarios_model->id_maximo_examenes_preo($rm->id_usuarios);
				$this->Usuarios_model->actualizar_desactivo_estado_preo($rm->id_usuarios);
				$this->Usuarios_model->actualizar_activo_estado_preo($get_ultimo->ultimo);
			}
		}
		//fin examen_preo();

		//inicio masso();
		$this->load->model("Usuarios_model");
		foreach ($this->Usuarios_model->listar_usuarios_evaluaciones_masso() as $rm){
			$get_cantidad = $this->Usuarios_model->contar_evaluaciones_masso($rm->id_usuarios);
			$total_examenes = isset($get_cantidad->total)?$get_cantidad->total:0;
			if($total_examenes >= 1){
				$get_ultimo = $this->Usuarios_model->id_maximo_examenes_masso($rm->id_usuarios);
				$this->Usuarios_model->actualizar_desactivo_estado_masso($rm->id_usuarios);
				$this->Usuarios_model->actualizar_activo_estado_masso($get_ultimo->ultimo);
			}
		}
		//fin masso();

		//inicio limpiar_mongo();
		$this->load->model("Usuarios2_model");
   		$this->Usuarios2_model->llenar_mongo_otro();
		//fin limpiar_mongo();

   		echo "Finalizado Correctamente";
	}

	function una_vez_al_dia(){
		//inicio mail_evaluacion();
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Usuarios/usuarios_general_model");
		$this->load->model("Requerimiento_Asc_Trabajadores_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->library('email');
		$config['protocol']     = 'mail';
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

		$dia_actual = date("d");
		$mes_actual = date("m");
		$anyo_actual = date("Y");
		$timestamp_actual = mktime(0,0,0,$mes_actual,$dia_actual,$anyo_actual);
		$listado = array();

		foreach($this->Evaluaciones_model->listar() as $l){
			if(!empty($l->fecha_v) && $l->fecha_v != '0000-00-00'){
				$fecha_v = explode("-", $l->fecha_v);
				$dia = $fecha_v[2];
				$mes = $fecha_v[1];
				$anyo = $fecha_v[0];
				$timestamp_eval = mktime(0,0,0,$mes,$dia,$anyo);
				$segundos_diferencia = $timestamp_eval - $timestamp_actual;
				$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
				$dias_diferencia = floor($dias_diferencia);
				if($dias_diferencia < 31 && $dias_diferencia > 29){
					$encontrados = TRUE;
					$aux = new stdClass();
					$usuario = $this->Usuarios_model->get($l->id_usuarios);
					$aux->nombre = $usuario->nombres;
					$aux->paterno = $usuario->paterno;
					$aux->materno = $usuario->materno;
					$aux->usuario_id = $usuario->id;
					$aux->rut = $usuario->rut_usuario;
					$eval = $this->Evaluacionesevaluacion_model->get($l->id_evaluacion);
					$aux->nombre_eval = $eval->nombre;
					$aux->tipo_eval = $this->Evaluacionestipo_model->get($eval->id_tipo)->nombre;
					$aux->fecha_v = $dia."-".$mes."-".$anyo;

					$get_req = $this->Requerimiento_Asc_Trabajadores_model->get_usuarios_area_cargo_req_activos_row($usuario->id);
					$status_contrato = isset($get_req->status)?$get_req->status:"";
					$id_asc_trab = isset($get_req->id_asc_trab)?$get_req->id_asc_trab:"";

					$get_contrato = $this->Requerimiento_Usuario_Archivo_model->get_archivos_req($id_asc_trab);

					if($status_contrato != 6 and $status_contrato != ""){
						$aux->nombre_req = isset($get_req->nombre_req)?$get_req->nombre_req:"";
						$aux->nombre_area = isset($get_req->nombre_area)?$get_req->nombre_area:"";
						$aux->nombre_cargo = isset($get_req->nombre_cargo)?$get_req->nombre_cargo:"";

						$planta_id = isset($get_req->planta_id)?$get_req->planta_id:"";

						$get_planta = $this->Empresa_planta_model->get($planta_id); 
						$aux->empresa_id = isset($get_planta->nombre)?$get_planta->nombre:"";
						$aux->fecha_termino_contrato = isset($get_contrato->fecha_termino)?$get_contrato->fecha_termino:"";
					}
					array_push($listado,$aux);
					unset($aux);
				}
			}
		}
		if(@$encontrados){
			echo "enviando";
			$pagina['listado'] = $listado;
			$this->load->view('email/evaluacion',$pagina);

			$usuarios_internos = $this->usuarios_general_model->listar_tipo_usuario(2);
			foreach ($usuarios_internos as $ui){
				if(!empty($ui->email) && $ui->email != "" ){
					$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
					$this->email->to($ui->email, 'Grupo de Empresas Integra Ltda.');
					$this->email->subject('Proximos vencimientos de evaluaciones');
					$this->email->message($this->load->view('email/evaluacion',$pagina,TRUE));
					$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
					$this->email->send();
					//echo $this->email->print_debugger();
				}
			}

			$usuarios_externos = $this->usuarios_general_model->listar_tipo_usuario(4);
			foreach ($usuarios_externos as $ue){
				if(!empty($ue->email) && $ue->email != "" ){
					$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
					$this->email->to($ue->email, 'Grupo de Empresas Integra Ltda.');
					$this->email->subject('Proximos vencimientos de evaluaciones');
					$this->email->message($this->load->view('email/evaluacion',$pagina,TRUE));
					$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
					$this->email->send();
					//echo $this->email->print_debugger();
				}
			}

			$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
			$this->email->to('jcruces@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
			$this->email->subject('Proximos vencimientos de evaluaciones');
			$this->email->message($this->load->view('email/evaluacion',$pagina,TRUE));
			$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
			$this->email->send();
			echo $this->email->print_debugger();
		}
		//fin mail_evaluacion();

	
		//inicio contratos_finalizados();
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		$this->load->model('Requerimiento_Asc_Trabajadores_model');
		$fecha_hoy = date('Y-m-d');
		$total=0;
		$monal = 0 ;
		$listado_usuarios = $this->Requerimiento_Usuario_Archivo_model->listar_contratos_y_anexos();
		if(!empty($listado_usuarios)){
			foreach ($listado_usuarios as $key ) {
				if ($key->tipo_archivo_requerimiento_id == 1 || $key->tipo_archivo_requerimiento_id == 2) {
					if ($key->fecha_termino>= $fecha_hoy) {	
						$id_asc_req = $key->requerimiento_asc_trabajadores_id;
						$datos = array(
							'status' => 3,
						);
						$this->Requerimiento_Asc_Trabajadores_model->editar($id_asc_req, $datos);
					}else{
						$id_asc_req = $key->requerimiento_asc_trabajadores_id;
						$datos = array(
							'status' => 6,
						);
						$this->Requerimiento_Asc_Trabajadores_model->editar($id_asc_req, $datos);
					}

				}
			}
		}
		//fin contratos_finalizados();


		//inicio requerimientos_finalizados();
		$this->load->model('Requerimientos_model');
		$listado_req = $this->Requerimientos_model->r_listar();
		if(!empty($listado_req)){
			foreach ($listado_req as $row){
				$id_req = $row->id;
				$desactivar = array(
					'estado' => 0,
				);

				$activar = array(
					'estado' => 1,
				);

				$fecha_v = isset($row->f_fin)?$row->f_fin:'0000-00-00';

				if($fecha_v < date('Y-m-d') and $fecha_v != '0000-00-00')
					$this->Requerimientos_model->actualizar_estado_activo_requerimiento($id_req, $desactivar);

				if($fecha_v > date('Y-m-d') and $fecha_v != '0000-00-00')
					$this->Requerimientos_model->actualizar_estado_activo_requerimiento($id_req, $activar);
			}
		}
		//fin requerimientos_finalizados();
   		echo "Finalizado Correctamente";
	}


	function avisoTerminoContrato(){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Usuarios_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->library('email');
		$config['protocol']     = 'mail';
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$hoy = date('Y-m-d');
		$gg = $this->Requerimiento_Usuario_Archivo_model->getAllContratos();
		$i=-1;
		$varql = -999;
		$j =0;
		$datos = false;
		$variable='';
		foreach ($gg as $key) {
			if ($key->id_solicitante != $varql) {
				if ($datos == true) {
					$l=1;
					$get_solicitante = $this->Usuarios_general_model->get($idSolicitante[$i][$j-1]);
					$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
					$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
					$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
					$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
					$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';
					$variable='Estimado '.$nombre_completo_solicitante.', Los siguientes trabajadores cuentan con su Contrato de trabajo pronto a finalizar:<br><br>';
					for ($k=0; $k < $j; $k++) { 
						$date1 = new DateTime($fTermino[$i][$k]);
						$date2 = new DateTime($hoy);
						$diff = $date1->diff($date2);                        
						$totalDias = $diff->days;//Aqui me entrega la cantidad de dias entre la fecha de hoy con la de termino
						if ($totalDias>1) {
							$finalizaEn = 'El contrato de trabajo finaliza en '.$totalDias.' días.';
						}elseif($totalDias==0){
							$finalizaEn = 'El contrato de trabajo finaliza el día de Hoy.';
						}else{
							$finalizaEn = 'El contrato de trabajo finaliza en '.$totalDias.' día.';
						}

						$variable.= $l.'. '.$nombreTrabajador[$i][$k].'<br>&nbsp;&nbsp;&nbsp; Motivo: '.$motivo[$i][$k].'<br>&nbsp;&nbsp;&nbsp; '.$finalizaEn.' ('.$fTermino[$i][$k].')<br>&nbsp;&nbsp;&nbsp; <a href="'.base_url().'correo/'.$idTrabajador[$i][$k].'/'.$idReqAsc[$i][$k].'/'.$reqAreaCargo[$i][$k].'/2">Crear Anexo</a> | <a href="'.base_url().'carta/'.$idTrabajador[$i][$k].'/'.$idArchivo[$i][$k].'/1">Descargar Carta Término</a><br><hr/>';
						$l++;
					}
					$pagina['variable'] = $variable;
					$pagina['titulo'] = 'Trabajadores con contrato de trabajo pronto a finalizar';
					$this->email->initialize($config);
				    $this->email->from('informaciones@empresasintegra.cl', 'Contratos por finalizar - ARAUCO');
				    $this->email->to($email_solicitante);
				    $this->email->cc('jcruces@empresasintegra.cl');
				    $this->email->subject("Contratos por finalizar");
				    $this->email->message($this->load->view('email/avisoDeTerminoContrato',$pagina,TRUE));
				    $this->email->send();
				    print_r($variable);
					$variable = '';
					$datos = false;
				}
				$i++;
				$j=0;
				$idSolicitante[$i][$j] = $key->id_solicitante;
				$idArchivo[$i][$j] = $key->idArchivo;
				$nombreTrabajador[$i][$j] = titleCase($key->nombreTrabajador);
				$idTrabajador[$i][$j] = $key->idUsuario;
				$idReqAsc[$i][$j] = $key->reqAscTrabajador;
				$motivo[$i][$j] = titleCase($key->motivo);
				$reqAreaCargo[$i][$j] = $key->reqAreaCargo;
				$fTermino[$i][$j] = $key->fTermino;
				$varql= $key->id_solicitante;
			}else{
				$idSolicitante[$i][$j] = $key->id_solicitante;
				$idArchivo[$i][$j] = $key->idArchivo;
				$nombreTrabajador[$i][$j] = titleCase($key->nombreTrabajador);
				$idTrabajador[$i][$j] = $key->idUsuario;
				$idReqAsc[$i][$j] = $key->reqAscTrabajador;
				$motivo[$i][$j] = titleCase($key->motivo);
				$reqAreaCargo[$i][$j] = $key->reqAreaCargo;
				$fTermino[$i][$j] = $key->fTermino;
				$varql= $key->id_solicitante;
				$datos =true;
			}
			$j++;
		}//End Foreach 

		if ($i==1) {// en caso de que solo vengan dos arrays
					$get_solicitante = $this->Usuarios_general_model->get($idSolicitante[$i][$j-1]);
					$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
					$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
					$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
					$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
					$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';
					$variable='Estimado '.$nombre_completo_solicitante.' Los siguientes trabajadores cuenta con su contrato pronto a vencer:<br><br>';
			for ($k=0; $k <= $i; $k++) { 
				$l=1;
				for ($m=0; $m < count($nombreTrabajador[$k]); $m++) {
						$date1 = new DateTime($fTermino[$k][$m]);
						$date2 = new DateTime($hoy);
						$diff = $date1->diff($date2);                        
						$totalDias = $diff->days;//Aqui me entrega la cantidad de dias entre la fecha de hoy con la de termino
						if ($totalDias>1) {
							$finalizaEn = 'El contrato de trabajo finaliza en '.$totalDias.' días.';
						}elseif($totalDias==0){
							$finalizaEn = 'El contrato de trabajo finaliza el día de Hoy.';
						}else{
							$finalizaEn = 'El contrato de trabajo finaliza en '.$totalDias.' día.';
						}
					$variable.= $l.'. '.$nombreTrabajador[$k][$m].'<br>&nbsp;&nbsp;&nbsp; Motivo: '.$motivo[$k][$m].'<br>&nbsp;&nbsp;&nbsp; '.$finalizaEn.' ('.$fTermino[$k][$m].')<br>&nbsp;&nbsp;&nbsp; <a href="'.base_url().'correo/'.$idTrabajador[$k][$m].'/'.$idReqAsc[$k][$m].'/'.$reqAreaCargo[$k][$m].'/2">Crear Anexo</a> | <a href="'.base_url().'carta/'.$idTrabajador[$k][$m].'/'.$idArchivo[$k][$m].'/1">Carta Termino</a><br><hr/>';
					$l++;
				}
				$pagina['variable'] = $variable;
				$pagina['titulo'] = 'Trabajadores con contrato de trabajo pronto a finalizar';
					$this->email->initialize($config);
				    $this->email->from('informaciones@empresasintegra.cl', 'Contratos por finalizar - ARAUCO');
				    $this->email->to($email_solicitante);
				    $this->email->cc('jcruces@empresasintegra.cl');
				    $this->email->subject("Contratos por finalizar");
				    $this->email->message($this->load->view('email/avisoDeTerminoContrato',$pagina,TRUE));
				    $this->email->send();
				print_r($variable);
				$variable='';
			}
		}else{//Cuando termina el foreach queda un ultimo valor en el array qe no es enviado por correo para ello lo hago desde aqui.
			$l=1;
			$get_solicitante = $this->Usuarios_general_model->get($idSolicitante[$i][$j-1]);
			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
			$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
			$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';
			$variable='Estimado '.$nombre_completo_solicitante.' Los siguientes trabajadores cuenta con su contrato pronto a vencer:<br><br>';
			for ($k=0; $k < $j; $k++) { 
				$date1 = new DateTime($fTermino[$i][$k]);
						$date2 = new DateTime($hoy);
						$diff = $date1->diff($date2);                        
						$totalDias = $diff->days;//Aqui me entrega la cantidad de dias entre la fecha de hoy con la de termino
						if ($totalDias>1) {
							$finalizaEn = 'El contrato de trabajo finaliza en '.$totalDias.' días.';
						}elseif($totalDias==0){
							$finalizaEn = 'El contrato de trabajo finaliza el día de Hoy.';
						}else{
							$finalizaEn = 'El contrato de trabajo finaliza en '.$totalDias.' día.';
						}
				$variable.= $l.'. '.$nombreTrabajador[$i][$k].'<br>&nbsp;&nbsp;&nbsp; Motivo: '.$motivo[$i][$k].'<br>&nbsp;&nbsp;&nbsp; '.$finalizaEn.' ('.$fTermino[$i][$k].')<br>&nbsp;&nbsp;&nbsp; <a href="'.base_url().'correo/'.$idTrabajador[$i][$k].'/'.$idReqAsc[$i][$k].'/'.$reqAreaCargo[$i][$k].'/2">Crear Anexo</a> | <a href="'.base_url().'carta/'.$idTrabajador[$i][$k].'/'.$idArchivo[$i][$k].'/1">Carta Termino</a><br><hr/>';
				$l++;
			}
			$pagina['variable'] = $variable;
			$pagina['titulo'] = 'Trabajadores con contrato de trabajo pronto a finalizar';
			$this->email->initialize($config);
		    $this->email->from('informaciones@empresasintegra.cl', 'Contratos por finalizar - ARAUCO');
		    $this->email->to($email_solicitante);
		    $this->email->cc('jcruces@empresasintegra.cl');
		    $this->email->subject("Contratos por finalizar");
		    $this->email->message($this->load->view('email/avisoDeTerminoContrato',$pagina,TRUE));
		    $this->email->send();
			echo $variable;
		}
	}

	function avisoTerminoAnexo(){
		$this->load->model("Requerimiento_Usuario_Archivo_model");
		$this->load->model("Usuarios_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->library('email');
		$config['protocol']     = 'mail';
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$hoy = date('Y-m-d');
		$gg = $this->Requerimiento_Usuario_Archivo_model->getAllAnexos();
		//echo count($gg);
		//var_dump($gg); return false;
		$i=-1;
		$varql = -999;
		$j =0;
		$datos = false;
		$variable='';
		if ($gg) {
			foreach ($gg as $key) {
				if ($key->id_solicitante != $varql) {
					if ($datos == true) {
						$l=1;
						$get_solicitante = $this->Usuarios_general_model->get($idSolicitante[$i][$j-1]);
						$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
						$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
						$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
						$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
						$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';
						$variable='Estimado '.$nombre_completo_solicitante.', Los siguientes trabajadores cuentan con su Anexo de Contrato pronto a finalizar:<br><br>';
						for ($k=0; $k < $j; $k++) { 
							$date1 = new DateTime($fTermino[$i][$k]);
							$date2 = new DateTime($hoy);
							$diff = $date1->diff($date2);                        
							$totalDias = $diff->days;//Aqui me entrega la cantidad de dias entre la fecha de hoy con la de termino
							if ($totalDias>1) {
								$finalizaEn = 'El Anexo de contrato finaliza en '.$totalDias.' días.';
							}elseif($totalDias==0){
								$finalizaEn = 'El Anexo de contrato finaliza el día de Hoy.';
							}else{
								$finalizaEn = 'El Anexo de contrato finaliza en '.$totalDias.' día.';
							}
							$variable.= $l.'. '.$nombreTrabajador[$i][$k].'<br>'.$finalizaEn.' ('.$fTermino[$i][$k].')<br>&nbsp;&nbsp;&nbsp; <a href="'.base_url().'correo/'.$idTrabajador[$i][$k].'/'.$idReqAsc[$i][$k].'/'.$reqAreaCargo[$i][$k].'/2">Crear Anexo</a> | <a href="'.base_url().'carta/'.$idTrabajador[$i][$k].'/'.$idArchivo[$i][$k].'/2">Carta Termino</a><br><hr/>';
							$l++;
						}
						$pagina['variable'] = $variable;
						$pagina['titulo'] = 'Trabajadores con Anexos de Contrato pronto a finalizar';
						$this->email->initialize($config);
					    $this->email->from('informaciones@empresasintegra.cl', 'Anexos de Contratos por finalizar - ARAUCO');
					    $this->email->to($email_solicitante);
					    $this->email->cc('jcruces@empresasintegra.cl');
					    $this->email->subject("Anexos de Contratos por finalizar");
					    $this->email->message($this->load->view('email/avisoDeTerminoContrato',$pagina,TRUE));
					    $this->email->send();
						print_r($variable);
						$variable ='';
						$datos = false;
					}
					$i++;
					$j=0;
					$idSolicitante[$i][$j] = $key->id_solicitante;
					$idArchivo[$i][$j] = $key->idArchivo;
					$nombreTrabajador[$i][$j] = titleCase($key->nombreTrabajador);
					$idTrabajador[$i][$j] = $key->idUsuario;
					$idReqAsc[$i][$j] = $key->reqAscTrabajador;
					//$motivo[$i][$j] = titleCase($key->motivo);
					$reqAreaCargo[$i][$j] = $key->reqAreaCargo;
					$fTermino[$i][$j] = $key->fTermino;
					$varql= $key->id_solicitante;
				}else{
					$idSolicitante[$i][$j] = $key->id_solicitante;
					$idArchivo[$i][$j] = $key->idArchivo;
					$nombreTrabajador[$i][$j] = titleCase($key->nombreTrabajador);
					$idTrabajador[$i][$j] = $key->idUsuario;
					$idReqAsc[$i][$j] = $key->reqAscTrabajador;
					//$motivo[$i][$j] = titleCase($key->motivo);
					$reqAreaCargo[$i][$j] = $key->reqAreaCargo;
					$fTermino[$i][$j] = $key->fTermino;
					$varql= $key->id_solicitante;
					$datos =true;
				}
				$j++;
			}//End Foreach 

			if ($i==1) {// en caso de que solo vengan dos arrays
						$get_solicitante = $this->Usuarios_general_model->get($idSolicitante[$i][$j-1]);
						$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
						$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
						$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
						$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
						$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';
						$variable='Estimado '.$nombre_completo_solicitante.' Los siguientes trabajadores cuentan con su Anexo de Contrato pronto a finalizar:<br><br>';
				for ($k=0; $k <= $i; $k++) { 
					$l=1;
					for ($m=0; $m < count($nombreTrabajador[$k]); $m++) { 
						$date1 = new DateTime($fTermino[$k][$m]);
						$date2 = new DateTime($hoy);
						$diff = $date1->diff($date2);                        
						$totalDias = $diff->days;//Aqui me entrega la cantidad de dias entre la fecha de hoy con la de termino
						if ($totalDias>1) {
							$finalizaEn = 'El Anexo de contrato finaliza en '.$totalDias.' días.';
						}elseif($totalDias==0){
							$finalizaEn = 'El Anexo de contrato finaliza el día de Hoy.';
						}else{
							$finalizaEn = 'El Anexo de contrato finaliza en '.$totalDias.' día.';
						}
						$variable.= $l.'. '.$nombreTrabajador[$k][$m].'<br>'.$finalizaEn.' ('.$fTermino[$k][$m].')<br>&nbsp;&nbsp;&nbsp; <a href="'.base_url().'correo/'.$idTrabajador[$k][$m].'/'.$idReqAsc[$k][$m].'/'.$reqAreaCargo[$k][$m].'/2">Crear Anexo</a> | <a href="'.base_url().'carta/'.$idTrabajador[$k][$m].'/'.$idArchivo[$k][$m].'/2">Carta Termino</a><br><hr/>';
						$l++;
					}
					$pagina['variable'] = $variable;
					$pagina['titulo'] = 'Trabajadores con Anexos de Contrato pronto a finalizar';
						$this->email->initialize($config);
					    $this->email->from('informaciones@empresasintegra.cl', 'Anexos de Contratos por finalizar - ARAUCO');
					    $this->email->to($email_solicitante);
					    $this->email->cc('jcruces@empresasintegra.cl');
					    $this->email->subject("Anexos de Contratos por finalizar");
					    $this->email->message($this->load->view('email/avisoDeTerminoContrato',$pagina,TRUE));
					    $this->email->send();
					print_r($variable);
					$variable='';
				}
			}else{
				$l=1;
				$get_solicitante = $this->Usuarios_general_model->get($idSolicitante[$i][$j-1]);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
				$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';
				$variable='Estimado '.$nombre_completo_solicitante.' Los siguientes trabajadores cuentan con su Anexo de Contrato pronto a finalizar:<br><br>';
				for ($k=0; $k < $j; $k++) {
					$date1 = new DateTime($fTermino[$i][$k]);
					$date2 = new DateTime($hoy);
					$diff = $date1->diff($date2);                        
					$totalDias = $diff->days;//Aqui me entrega la cantidad de dias entre la fecha de hoy con la de termino
					if ($totalDias>1) {
						$finalizaEn = 'El Anexo de contrato finaliza en '.$totalDias.' días.';
					}elseif($totalDias==0){
						$finalizaEn = 'El Anexo de contrato finaliza el día de Hoy.';
					}else{
						$finalizaEn = 'El Anexo de contrato finaliza en '.$totalDias.' día.';
					} 
					$variable.= $l.'. '.$nombreTrabajador[$i][$k].'<br>'.$finalizaEn.' ('.$fTermino[$i][$k].')<br>&nbsp;&nbsp;&nbsp; <a href="'.base_url().'correo/'.$idTrabajador[$i][$k].'/'.$idReqAsc[$i][$k].'/'.$reqAreaCargo[$i][$k].'/2">Crear Anexo</a> | <a href="'.base_url().'carta/'.$idTrabajador[$i][$k].'/'.$idArchivo[$i][$k].'/2">Carta Termino</a><br><hr/>';
					$l++;
				}
				$pagina['variable'] = $variable;
				$pagina['titulo'] = 'Trabajadores con Anexos de Contrato pronto a finalizar';
				$this->email->initialize($config);
			    $this->email->from('informaciones@empresasintegra.cl', 'Anexos de Contratos por finalizar - ARAUCO');
			    $this->email->to($email_solicitante);
			    $this->email->cc('jcruces@empresasintegra.cl');
			    $this->email->subject("Anexos de Contratos por finalizar");
			    $this->email->message($this->load->view('email/avisoDeTerminoContrato',$pagina,TRUE));
			    $this->email->send();
				echo $variable;
			}
		}
	}


}
?>