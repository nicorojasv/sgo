<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Perfil extends CI_Controller {
	//public $noticias;
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 6){
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

		// $this -> load -> model("Noticias_model");
		// $this->noticias['noticias_noleidas'] = $this -> Noticias_model -> cont_noticias_noleidas($this -> session -> userdata('id'));
		// $this->load->model("Mensajes_model");
		// $this->load->model("Mensajesresp_model");
		// $suma = 0;
		// $suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		// $suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		// foreach($this->Mensajes_model->listar_admin($this->session->userdata("id")) as $lr){
			// $suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		// }
		// $this->noticias['mensajes_noleidos'] = $suma;
   	}

	function trabajador($id=false){
		$this->load->model('Usuarios_model');
		$this->load->library('encrypt');
		$id = $this->encrypt->decode(urldecode($id));
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Usuarios_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');
		
		$this->load->model('Fotostrab_model');
		$this->load->model('Tipousuarios_model');
		$this->load->model('Estadocivil_model');
		$this->load->model('Afp_model');
		$this->load->model('Excajas_model');
		$this->load->model('Experiencia_model');
		$this->load->model('Salud_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Profesiones_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_model");
		$this->load->model("Provincia_model");
		
		$base['titulo'] = "Perfil de trabajador";
		$base['lugar'] = "Perfil";
		
		$pagina['menu'] = $this->load->view('menus/menu_subusuario','',TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		$pagina['imagen_grande'] = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		$pagina['experiencia'] = $this->Experiencia_model->get_usuario($pagina['usuario']->id);
		$pagina['archivos'] = $this->Archivos_model->get_usuario($pagina['usuario']->id);
		
		$pagina['estado_civil'] = $this->Estadocivil_model->get($pagina['usuario']->id_estadocivil);
		$pagina['afp'] = $this->Afp_model->get($pagina['usuario']->id_afp);
		$pagina['salud'] = $this->Salud_model->get($pagina['usuario']->id_salud);
		$pagina['nivel_estudios'] = $this->Nivelestudios_model->get($pagina['usuario']->id_estudios);
		$pagina['profesion'] = $this->Profesiones_model->get($pagina['usuario']->id_profesiones);
		$pagina['especialidad1'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador);
		/** obetener especialidadades extras **/
		if( isset($this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_2)->desc_especialidad) )
			$pagina['especialidad2'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_2);
		if( isset($this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_3)->desc_especialidad) )
			$pagina['especialidad3'] = $this->Especialidadtrabajador_model->get($pagina['usuario']->id_especialidad_trabajador_3);
		/** limpiar idiomas **/
		if( isset($pagina['usuario']->idiomas) ){
			$idioma = explode(";", $pagina['usuario']->idiomas);
			$idiom = "";
			for($i=0;$i<(count($idioma)-1);$i++){
				$idiom .= ucwords(mb_strtolower($idioma[$i],'UTF-8'));
				if($i < (count($idioma)-2)) $idiom .= ", ";
			}
			$pagina['idioma'] = $idiom;
		}
		/** limpiar software **/
		if( isset($pagina['usuario']->software) ){
			$software = explode(";", $pagina['usuario']->software);
			$soft = "";
			for($i=0;$i<(count($software)-1);$i++){
				$soft .= ucwords(mb_strtolower($software[$i],'UTF-8'));
				if($i < (count($software)-2)) $soft .= ", ";
			}
			$pagina['software'] = $soft;
		}
		/** limpiar equipos **/
		if( isset($pagina['usuario']->equipos) ){
			$equipos = explode(";", $pagina['usuario']->equipos);
			$equi = "";
			for($i=0;$i<(count($equipos)-1);$i++){
				$equi .= ucwords(mb_strtolower($equipos[$i],'UTF-8'));
				if($i < (count($equipos)-2)) $equi .= ", ";
			}
			$pagina['equipos'] = $equi;
		}
		/** limpiar cursos **/
		if( isset($pagina['usuario']->cursos) ){
			$cursos = explode(";", $pagina['usuario']->cursos);
			$cur = "";
			for($i=0;$i<(count($cursos)-1);$i++){
				$cur .= ucwords(mb_strtolower($cursos[$i],'UTF-8'));
				if($i < (count($cursos)-2)) $cur .= ", ";
			}
			$pagina['cursos'] = $cur;
		}
		$base['cuerpo'] = $this->load->view('perfil/trabajador',$pagina,TRUE);
		$this->load->view('layout',$base);
		
	}
	
}
?>