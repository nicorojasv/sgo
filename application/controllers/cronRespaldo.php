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

}
?>