<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Documentos extends CI_Controller {
	public $requerimiento;
	public function __construct()
   	{
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		/*elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		
		elseif( $this->session->userdata('departamento') == 1 or $this->session->userdata('departamento') == 6 or $this->session->userdata('departamento') == 7 or 
			$this->session->userdata('departamento') == 2 or $this->session->userdata('departamento') == 8 or $this->session->userdata('departamento') == 10 )
			$this->menu = $this->load->view('layout2.0/menus/menu_admin','',TRUE);*/
		else
			redirect('/usuarios/login/index', 'refresh');
		
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
		redirect('documentos/documentos/listado', 'refresh');
	}

	function mail_evaluacion(){ // cron con envío de email cuando una evaluacion esta a un mes de vencer
			$this->load->model("Evaluaciones_model");
			$this->load->model("Evaluacionesevaluacion_model");
			$this->load->model("Evaluacionestipo_model");
			$this->load->model("Usuarios_model");
			$this->load->library('email');

			$config['smtp_host'] = 'mail.empresasintegra.cl';
			$config['smtp_user'] = 'sgo@empresasintegra.cl';
			$config['smtp_pass'] = 'gestion2012';
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
					//echo $dias_diferencia."<br/>";
					if($dias_diferencia < 31 && $dias_diferencia > 29){
						$encontrados = TRUE;
						$aux = new stdClass();
						$usuario = $this->Usuarios_model->get($l->id_usuarios);
						$aux->nombre = $usuario->nombres;
						$aux->paterno = $usuario->paterno;
						$aux->materno = $usuario->materno;
						$aux->rut = $usuario->rut_usuario;
						$eval = $this->Evaluacionesevaluacion_model->get($l->id_evaluacion);
						$aux->nombre_eval = $eval->nombre;
						$aux->tipo_eval = $this->Evaluacionestipo_model->get($eval->id_tipo)->nombre;
						$aux->fecha_v = $dia."-".$mes."-".$anyo;
						array_push($listado,$aux);
						unset($aux);
					}
				}
			}
			if(@$encontrados){
			echo "enviando";
			$pagina['listado'] = $listado;
			//foreach($this->Usuarios_model->listar_tipo(3) as $u){
			//	if(!empty($u->email) && $u->email != "" ){
					//$correos[] = $u->email;
					$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
					$this->email->to('mcuevas@empresasintegra.cl');
					$this->email->subject('Proximos vencimientos de evaluaciones');
					$this->email->message($this->load->view('email/evaluacion',$pagina,TRUE));
					$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
					$this->email->send();
					echo $this->email->print_debugger();
					/*if( !@$this->email->send()){
						//echo "error";
						echo $this->email->print_debugger();
					}*/
				//}

				//$this->email->from('informaciones@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
				//$this->email->to('mcuevas@empresasintegra.cl');
				//$this->email->subject('Proximos vencimientos de evaluaciones');
				//$this->email->message($this->load->view('email/evaluacion',$pagina,TRUE));
				//$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
				//$this->email->send();
				//echo $this->email->print_debugger();
			//}

			echo "Proceso Realizado con Exito";
		}
	}


	function crear($msg = FALSE) {
		
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Documentos",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url'=>'administracion/archivos','txt' => 'Documentos'), array('url'=>'','txt'=>'Crear' )),
			'js' => array('js/archivos.js'),
			'menu' => $this->menu
		);


		$this->load->model("Usuarios_categoria_model");
		
		if($msg == "error_vacio"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "Algunos datos estan vacios, favor enviar nuevamente";
		}
		if($msg == "error_pass"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = 'error!! las contraseñas no coinciden';
		}
		if($msg == "error_rut"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "El rut existe en nuestros sistemas";
		}
		if($msg == "error_email_valid"){
			$base['alert_tipo'] = 'alert-danger';
			$base['alert_contenido'] = "El email ingresado es invalido";
		}
		if($msg == "exito"){
			$base['alert_tipo'] = 'alert-success';
			$base['alert_contenido'] = "El usuario a sido guardado exitosamente";
		}

		$pagina['lista_categoria'] = $this->Usuarios_categoria_model->listar();

		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->library('ftp');
			$this->load->model("Archivos_model");


			$config['hostname'] = 'respaldos.empresasintegra.cl';
			$config['username'] = 'sgo';
			$config['password'] = 'integra7109';
			$config['debug']	= TRUE;

			$this->ftp->connect($config);

			foreach ($_FILES['archivo']['name'] as $f => $name) {

				if($_FILES['archivo']['error'][$f] == 0){
				
					$destino = '/ISO 9001 - servicios industriales/'.$_FILES['archivo']['name'][$f];
					$this->ftp->upload($_FILES['archivo']['tmp_name'][$f], $destino, 'ascii', 0770);


					$data = array(
						'nombre' => $_FILES['archivo']['name'][$f],
						'usuarios_categoria_id' => $_POST['select_tipo'],
						'tipo_usuarios_id' => $_POST['select_categoria'],
						'url' => $destino
					);

					$this->Archivos_model->ingresar($data);
				}
				else{
					$this->ftp->close();
					redirect('documentos/documentos/crear/error', 'refresh');
				}
			}
			
			$this->ftp->close();
			redirect('documentos/documentos/listado', 'refresh');
			//$pagina['texto_anterior'] = $this->session->flashdata('data');

		}


		$base['cuerpo'] = $this->load->view('crear',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function listado(){
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Documentos",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url'=>'administracion/archivos','txt' => 'Documentos'), array('url'=>'','txt'=>'Listado' )),
			//'js' => array('plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js','js/form-wizard.js'),
			'menu' => $this->menu
		);

		$this->load->model("Archivos_model");
		$this->load->library('encrypt');

		$pagina['listado'] = $this->Archivos_model->listar();

		$base['cuerpo'] = $this->load->view('listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function ajax_categoria_usuario(){
		$id = $this->uri->segment(4);
		$this->load->model("Tipousuarios_model");
		echo json_encode( $this->Tipousuarios_model->get_categoria($id) );
	}

	function eliminar(){
		$this->load->library('encrypt');
		$this->load->library('ftp');
		$this->load->model("Archivos_model");
		//$id = urldecode($this->uri->segment(4));
		$id = $this->uri->segment(4);
		
		//$id = $this->encrypt->decode($id);

		$archivo = $this->Archivos_model->get($id);


		$config['hostname'] = 'respaldos.empresasintegra.cl';
		$config['username'] = 'sgo';
		$config['password'] = 'integra7109';
		$config['debug']	= TRUE;

		$this->ftp->connect($config);

		$this->ftp->delete_file($archivo->url);

		$this->Archivos_model->eliminar($id);
		$this->ftp->close();

		redirect('administracion/archivos/listado', 'refresh');
	}

	function descargar(){
		$this->load->library('ftp');
		$this->load->model("Archivos_model");

		$id = $this->uri->segment(4);
		$archivo = $this->Archivos_model->get($id);

		//echo getcwd() ;
		
		$config['hostname'] = 'respaldos.empresasintegra.cl';
		$config['username'] = 'sgo';
		$config['password'] = 'integra7109';
		$config['debug']	= TRUE;

		$this->ftp->connect($config);

		$file = getcwd().'/'.$archivo->nombre;

		$this->ftp->download($archivo->url, $file,  'ascii');

		$this->ftp->close();

		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    ob_clean();
		    flush();
		    readfile($file);
		    //exit;
		}

		unlink($file); 
	}

}
?>