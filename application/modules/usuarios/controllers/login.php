<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Login extends CI_Controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->library('session');
		$this->load->helper('browsers');
		if(getBrowser()){
			redirect('/home/cambiar_browser', 'refresh');
		}
	}
	
	function index(){
		if ($this->session->userdata('logged') == TRUE)
			redirect('/usuarios/home', 'refresh');

		$this->session->unset_userdata('reemplazo_final');
		$this->session->unset_userdata('usr_reemplazo');
		$this->session->unset_userdata('reemplazo');
		$this->load->view('login/login');
		//redirect('https://www.google.cl/', 'refresh');
	}

	function validar(){
		$this->load->model('Usuarios_general_model');
		$this->load->model('Auditoria_Login_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Fotostrab_model');
		$rut = strtoupper($_POST['rut']);
		$pass = $_POST['password'];
		
		if(empty($rut) || empty($pass)){
			redirect('/usuarios/login/index', 'refresh');
		}

		if ($_POST['ingreso'] == 1){
			$validar = $this->Usuarios_general_model->validar($rut,$pass);
			//var_dump($validar);
			if(count($validar) > 0 ){ //el usario esta validado, existe y la contraseña es correcta
				$this->load->helper('ip');
				if( $validar->activo == TRUE){
					date_default_timezone_set("America/Santiago");
					$datos_sesion = array(
						'usuario_id' => $validar->usuario_id,
						'tipo_usuario' => 1,
						'fecha_ingreso' => date("Y-m-d G:i:s"),
						//'fecha_egreso' => "0000-00-00 00:00:00",
					);
					//$this->Auditoria_Login_model->guardar($datos_sesion);
					//$ultimo_id = $this->db->insert_id();

					$foto_existe = $this->Fotostrab_model->get_usuario($validar->id);
					$foto = ( count($foto_existe) > 0 ) ? $foto_existe->thumb : 'extras/layout2.0/img_perfil/default_thumb.jpg' ;
					$foto_barra = ( count($foto_existe) > 0 ) ? $foto_existe->barra : 'extras/layout2.0/img_perfil/default_barra.jpg' ;
					$session = array(
						'rut' => $validar->rut_usuario,
						'nombres' => ucwords(mb_strtolower($validar->nombres,'UTF-8')),
						'id' => $validar->usuario_id,
						'centro_costo' => $validar->centro_costo_id,
						'cargo' => $validar->cargo_id,
						'departamento' => $validar->departamento_id,
						'sucursal' => $validar->sucursal_id,
						'sucursal_nb' => $validar->sucursal_nb,
						'empresa' => $validar->nombre_empresa,
						'tipo_usuario' => $validar->tipo_usuario_id,
						'imagen' => $foto,
						'imagen_barra' => $foto_barra,
						'navegador' => $_SERVER['HTTP_USER_AGENT'],
						'ip' => getRealIP(),
						'logged' => FALSE,
						'chat' => $validar->chat,
						'estado' => '1',
						'notificado'=>$validar->notificado,
						//'id_registro_login' => $ultimo_id
					);
					$this->session->set_userdata($session);

					$this->session->set_userdata('logged', TRUE);
					redirect('usuarios/home/', 'refresh');
				}
				else{
					redirect('/usuarios/login/index', 'refresh');
				}
			}
			else{
				redirect('/usuarios/login/index', 'refresh');
			}
		}
		elseif($_POST['ingreso'] == 2){
			$validar = $this->Usuarios_model->validar($rut,$pass);
			if(count($validar) > 0 ){
				$this->load->helper('ip');
				if( is_numeric($validar->tipo)){
					date_default_timezone_set("America/Santiago");
					$datos_sesion = array(
						'usuario_id' => $validar->id,
						'tipo_usuario' => 2,
						'fecha_ingreso' => date("Y-m-d G:i:s"),
					);
					$this->Auditoria_Login_model->guardar($datos_sesion);
					$ultimo_id = $this->db->insert_id();

					$foto_existe = $this->Fotostrab_model->get_usuario($validar->id);
					$foto = ( count($foto_existe) > 0 ) ? $foto_existe->thumb : 'extras/layout2.0/img_perfil/default_thumb.jpg';
					$foto_barra = ( count($foto_existe) > 0 ) ? $foto_existe->barra : 'extras/layout2.0/img_perfil/default_barra.jpg';
					$session = array(
						'rut' => $validar->rut,
						'nombres' => ucwords(mb_strtolower($validar->nombres,'UTF-8')),
						'id' => $validar->id,
						'tipo' => "trabajador",
						'subtipo' => "integra",
						'imagen' => $foto,
						'imagen_barra' => $foto_barra,
						'navegador' => $_SERVER['HTTP_USER_AGENT'],
						'ip' => getRealIP(),
						'logged' => FALSE,
						'chat' => $validar->chat,
						'estado' => '1',
						'id_registro_login' => $ultimo_id
					);
					$this->session->set_userdata($session);
					$this->session->set_userdata('logged', TRUE);
					redirect('trabajador', 'refresh');
				}
				else{
					redirect('/usuarios/login/index', 'refresh');
				}
			}
			else{
					redirect('/usuarios/login/index', 'refresh');
				}
		}
		else{
			redirect('/usuarios/login/index', 'refresh');
		}
	}

	function recordar(){
		$this->load->view('login_recordar');
	}
	function salir(){
		$this->load->library('session');
		$this->load->model('Auditoria_Login_model');
		date_default_timezone_set("America/Santiago");
		$datos_login = array(
			'fecha_egreso' => date("Y-m-d G:i:s"),
		);
		$id_registro = $this->session->userdata('id_registro_login');
		$this->Auditoria_Login_model->actualizar($id_registro, $datos_login);
		$this->session->destroy();
		redirect('/usuarios/login', 'refresh');
	}
	
	function validar_correo(){
		$rut = trim($_POST['rut']);
		if(empty($rut)){ die();}
		$this->load->model("Usuarios_model");
		$this->load->library('email');
		$this->load->library('encrypt');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'sgo@empresasintegra.cl';
		$config['smtp_pass'] = 'gestion2012';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);
		$u = $this->Usuarios_model->get_rut($rut);
		$key = "llave empresas integra";
		$correo = "enviado por correo";
		$pagina['key'] = "llave empresas integra";
		$pagina['correo'] = "enviado por correo"; 
		$pagina['u'] = $u;
		if(isset($u->id)){
			if(isset($u->email)){
				$this->email->from('sgo@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
				$this->email->to($u->email); 
				$this->email->subject('Recuperacion de contraseña');
				$this->email->message($this->load->view('email/usuario',$pagina,TRUE));
				$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
				if( !@$this->email->send()){
					//echo "error";
					//echo "debug --->" . $this->email->print_debugger();
					$salida = "Ocurrio un problema al enviar el correo de verificacion, favor intente nuevamente";
				}
				else{
					$salida = "Se ha enviado un correo electrónico con las indicaciones para la recuperación de la contraseña a su correo";
				}
			}
			else{
				$this->email->from('sgo@empresasintegra.cl', 'Grupo de Empresas Integra Ltda.');
				$this->email->to("gfigueroa@empresasintegra.cl"); 
				$this->email->cc('vsilva@empresasintegra.cl'); 
				$this->email->subject('Email desde SGO: Recuperacion de contraseña');
				$this->email->message($this->load->view('email/administrador',$pagina,TRUE));
				$this->email->set_alt_message('Para visualizar correctamente este correo, favor cambiar la vista a html');
				if( !@$this->email->send()){
					//echo "error";
					//echo $this->email->print_debugger();
					$salida = "Ocurrio un problema al enviar el correo de verificacion, favor intente nuevamente";
				}
				else{
					$salida = "Usted no posee un correo electrónico, se ha enviado una solicitud de recuperación de contraseña a la administracion, favor espere nuestro llamado, pronto nos comunicaremos con usted.";
				}
			}
		}
		else{
			$salida = "El Rut ingresado no existe, favor volver a ingresar";
		}
		$pagina['resultado'] = $salida;
		$this->load->view('login_resultado',$pagina);
	}
	function recuperar_pass($rut,$extra=FALSE,$id=FALSE){
		$this->load->library('encrypt');
		$this->load->model("Usuarios_model");
		
		$key = "llave empresas integra";
		$correo = "enviado por correo";
		
		$rut = $this->encrypt->decode( base64_decode(urldecode($rut)), $key);
		$extra = $this->encrypt->decode( base64_decode(urldecode($extra)), $key);
		$id = $this->encrypt->decode( base64_decode(urldecode($id)), $key);
		if($extra == $correo){
			$data['rut'] = $rut;
			$data['id'] = $id;
			$this->load->view('login_recuperar',$data);
		}
		else{
			echo "error de validacion, el link ya no esta activo";
		}
	}
	
	function renovar_pass(){
		$this->load->model("Usuarios_model");
		if($_POST['pass1'] == $_POST['pass2']){
			$data = array(
				'clave' => hash("sha512", $_POST['pass1'])
			);
			$this->Usuarios_model->editar($_POST['id'],$data);
		}
		redirect('/login', 'refresh');
	}
}
?>