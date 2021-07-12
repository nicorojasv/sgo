<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Requerimiento extends CI_Controller {
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

	function estado($msg = FALSE){
		$base['titulo'] = "Estado de requerimiento";
		$base['lugar'] = "Requerimiento";
		$this->load->model("Requerimiento_model");
		$this->load->model("Subusuarios_model");
		$this->load->library('encrypt');
		
		$listado = array();
		
		foreach($this->Subusuarios_model->get_usuario( $this->session->userdata("id") ) as $g){
			$req = $this->Requerimiento_model->get($g->id_requerimiento);
			$aux1 = new stdClass();
			$aux1->nombre = $req->nombre;
			$aux1->id = urlencode($this->encrypt->encode($req->id));
			$aux1->data = array();
			foreach($this->Requerimiento_model->listar_req($g->id_requerimiento) as $r){
				$aux2 = new stdClass();
				$aux2->id_subreq = urlencode($this->encrypt->encode($r->id));
				$aux2->lugar_trabajo = $req->lugar_trabajo;
				$aux2->cantidad = $r->cantidad;
				$aux2->cantidad_ok = $r->cantidad_ok;
				$aux2->estado = $this->Requerimiento_model->get_estado($r->id_estado)->nombre;
				$fecha = explode('-',$r->fecha_inicio);
				$aux2->f_inicio = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
				array_push($aux1->data,$aux2);
				unset($aux2);
			}
			array_push($listado,$aux1);
			unset($aux);
		}
		
		$pagina['menu'] = $this->load->view('menus/menu_subusuario','',TRUE);
		$pagina['lista_req'] = $listado;
		$base['cuerpo'] = $this->load->view('requerimientos/estado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function detalle_requerimiento($id_req = FALSE, $id_subreq = FALSE){
		$this->load->model("Requerimiento_model");
		$this->load->library('encrypt');
		$id_req = $this->encrypt->decode(urldecode($id_req));
		$id_subreq = $this->encrypt->decode(urldecode($id_subreq));
		
		if($id_req == FALSE || $id_subreq == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Requerimiento_model->get($id_req)) < 1)
			redirect('/error/error404', 'refresh');
		
		$this->load->model("Usuarios_model");
		$this->load->model("Areas_model");
		$this->load->model("Centrocostos_model");
		$this->load->model("Cargos_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Empresas_model");
		$this->load->model("Planta_model");
		
		$base['titulo'] = "Detalle de requerimiento";
		$base['lugar'] = "Requerimientos";
		
		$arr_url = $this->uri->uri_to_assoc(5);
		//$this->Requerimiento_model->editar($id,array('flag_leido' => 1)); //marcar como leido
		$r = $this->Requerimiento_model->get($id_req);
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
		
		$sub_req = $this->Requerimiento_model->get_req($id_subreq);
		
		$aux->id = $sub_req->id;
		$aux->areas = $this->Areas_model->get($sub_req->id_areas)->desc_area;
		$aux->cargos = $this->Cargos_model->get($sub_req->id_cargos)->desc_cargo;
		$aux->cc = (empty($sub_req->id_centrocosto))? '' : $this->Centrocostos_model->get($sub_req->id_centrocosto)->desc_centrocosto;
		$aux->especialidad = $this->Especialidadtrabajador_model->get($sub_req->id_especialidad_trabajador)->desc_especialidad;
		$f_i = explode("-",$sub_req->fecha_inicio);
		$f_t = explode("-",$sub_req->fecha_termino);
		$aux->f_inicio = $f_i[2].'-'.$f_i[1]."-".$f_i[0];
		$aux->f_termino = $f_t[2].'-'.$f_t[1]."-".$f_t[0];
		$aux->cantidad = $sub_req->cantidad;
		$aux->cantidad_ok = $sub_req->cantidad_ok;
		$aux->estado = $this->Requerimiento_model->get_estado($sub_req->id_estado)->nombre;
		
		$pagina['requerimiento'] = $aux;
		$pagina['menu'] = $this->load->view('menus/menu_subusuario','',TRUE);
		$base['cuerpo'] = $this->load->view('requerimientos/detalles',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function trabajadores($id_req = FALSE, $id_subreq = FALSE){
		$this->load->model("Requerimiento_model");
		$this->load->library('encrypt');
		$id_req = $this->encrypt->decode(urldecode($id_req));
		$id_subreq = $this->encrypt->decode(urldecode($id_subreq));
		
		if($id_req == FALSE || $id_subreq == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Requerimiento_model->get($id_req)) < 1)
			redirect('/error/error404', 'refresh');
		
		$this->load->model("Usuarios_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Fotostrab_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->library('pagination');
		
		$base['titulo'] = "Trabajadores asignados al requerimiento";
		$base['lugar'] = "Requerimientos";
		
		
		$listado_usuarios = array();
		$req = $this->Requerimiento_model->get_req($id_subreq);
		
		foreach($this->Asignarequerimiento_model->listado_requerimiento($id_subreq) as $sr){
			$aux = new stdClass();
			$usu = $this->Usuarios_model->get($sr->id_usuarios);
			$foto = $this->Fotostrab_model->get_usuario($usu->id);
			$aux->nombres = $usu->nombres;
			$aux->paterno = $usu->paterno;
			$aux->materno = $usu->materno;
			$aux->rut = $usu->rut_usuario;
			$aux->id = $usu->id;
			$aux->foto = (count($foto)< 1) ? 'extras/img/perfil/requerimiento/avatar.jpg' : $foto->media;
			array_push($listado_usuarios,$aux);
			unset($aux);
		}
		$pagina['especialidad'] = $this->Especialidadtrabajador_model->get($req->id_especialidad_trabajador)->desc_especialidad;
		$pagina['listado_usuarios'] = $listado_usuarios;
		$pagina['menu'] = $this->load->view('menus/menu_subusuario','',TRUE);
		$base['cuerpo'] = $this->load->view('requerimientos/trabajadores',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function tooltip($id){ //informacion dinamica de un usuario
		
		$this->load->model("Usuarios_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Profesiones_model");
		$this->load->library('encrypt');
		
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
				<div><a target='_blank' href='".base_url()."subusuario/perfil/trabajador/".urlencode($this->encrypt->encode($usu->id))."'>Ver Perfil Completo</a></div>
			</div>
			<div class='clear'>&nbsp;</div>
		</div>";
	}
}
?>