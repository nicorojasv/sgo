<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Trabajador extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		
		elseif ($this->session->userdata('tipo') != 7) {
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');
	}

	function index() {
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Informes y Perfiles";
		
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$this->load->model('Usuarios_model');
		$this->load->model("Listanegra_model");

		$trab = $this->Usuarios_model->listar_trabajadores();
		if (!empty($_POST['rut'])) {

			$usr = $this->Usuarios_model->get_rut($_POST['rut']);
			if (isset($usr->id)){
				$n = $this->Listanegra_model->listar_trabajador($usr->id);
				$id = $usr->id;
				$pagina['id'] = $id;
				$u = $this->Usuarios_model->get($id);
				$pagina['nombre'] = $u->nombres.' '.$u->paterno .' '. $u->materno;
				$pagina['rut'] = $u->rut_usuario;
				if(empty($n)){
					$pagina['ln'] = 0;
				}
				else{
					$cont_g = 0;
					$cont_ln = 0;
					$cont_lnp = 0;
					foreach ($n as $n) {
						if($n->tipo == "-"){
							$cont_g += 1;
						}
						if($n->tipo == "LNP"){
							$cont_lnp += 1;
						}
						if($n->tipo == "LN"){
							$cont_ln += 1;
						}
					}

					if ( $cont_g <=3 ) $pagina['ln'] = 1;
					if ( $cont_g >= 4 || $cont_ln >= 1) $pagina['ln'] = 2;
					if ( ($cont_g <= 3 && $cont_ln >= 1) || $cont_lnp >= 1) $pagina['ln'] = 3;
				}
			}
			$pagina['value'] = $_POST['rut'];
		}
		if( !empty($_POST['nombre'])){
			
			/*$res = $this->Usuarios_model->listar_filtro($_POST['nombre']);
		    $pagina['listado_usr'] = $res;
			$pagina['val_nb'] = $_POST['nombre'];*/
			$u = $this->Usuarios_model->get($_POST['nombre']);
			if (isset($u->id)){
				$id = $u->id;
				$n = $this->Listanegra_model->listar_trabajador($u->id);
				$pagina['id'] = $id;
				$pagina['nombre'] = $u->nombres.' '.$u->paterno .' '. $u->materno;
				$pagina['rut'] = $u->rut_usuario;
				if(empty($n)){
					$pagina['ln'] = 0;
				}
				else{
					$cont_g = 0;
					$cont_ln = 0;
					$cont_lnp = 0;
					foreach ($n as $n) {
						if($n->tipo == "-"){
							$cont_g += 1;
						}
						if($n->tipo == "LNP"){
							$cont_lnp += 1;
						}
						if($n->tipo == "LN"){
							$cont_ln += 1;
						}
					}

					if ( $cont_g <=3 ) $pagina['ln'] = 1;
					if ( $cont_g >= 4 || $cont_ln >= 1) $pagina['ln'] = 2;
					if ( ($cont_g <= 3 && $cont_ln >= 1) || $cont_lnp >= 1) $pagina['ln'] = 3;
				}
			}
			$pagina['val_nb'] = $_POST['nombre'];
		}

		$pagina['trab'] = $trab;

		$base['cuerpo'] = $this->load->view('trabajador/busqueda',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function perfil($id = FALSE) {
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$this->load->model('Usuarios_model');

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
		$this->load->model("Ciudad_model");
		
		$base['titulo'] = "Perfil de trabajador";
		$base['lugar'] = "Perfil";
		
		//$pagina['menu'] = $this -> load -> view('menus/menu_admin', $this -> requerimiento, TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		if( $this->Fotostrab_model->get_usuario($pagina['usuario']->id) )
			$img_grande = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		else{
			$img_grande->nombre_archivo = 'extras/img/perfil/avatar.jpg';
			$img_grande->thumb = 'extras/img/perfil/avatar.jpg';
		}
		$pagina['imagen_grande'] = $img_grande;
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
		$base['cuerpo'] = $this -> load -> view('perfiles/trabajador',$pagina,TRUE);
		$this -> load -> view('layout',$base);
	}

	function informe_eval($id = FALSE) {
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$this->load->model('Usuarios_model');
		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Usuarios_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');

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

		$base['cuerpo'] = $this->load->view('trabajador/informe',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function trabajos($id = FALSE) {
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$this->load->model("Asignarrequerimiento_model");
		$this->load->model('Usuarios_model');
		$this->load->model("Tipousuarios_model");
		$this->load->model("Fotostrab_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Grupo_model");

		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Usuarios_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');

		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Historial de Trabajos";
		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		if( $this->Fotostrab_model->get_usuario($pagina['usuario']->id) )
			$img_grande = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		else{
			$img_grande->nombre_archivo = 'extras/img/perfil/avatar.jpg';
			$img_grande->thumb = 'extras/img/perfil/avatar.jpg';
		}
		$pagina['imagen_grande'] = $img_grande;

		$lista = array();
		foreach ($this->Asignarrequerimiento_model->historial($id) as $h) {
			$aux = new stdClass();
			$a = $this->Areas_model->get_empresa($h->id_area);
			$c = $this->Cargos_model->get_empresa($h->id_cargo);
			$g = $this->Grupo_model->get($h->id_grupo);
			$aux->solicitud = $h->f_solicitud;
			$aux->inicio = $h->f_inicio;
			$aux->fin = $h->f_fin;
			$aux->motivo = $h->motivo;
			$aux->area = $a->desc_area;
			$aux->cargo = $c->desc_cargo;
			$aux->grupo = $g->nombre;

			array_push($lista,$aux);
			unset($aux,$a,$c,$g);
		}
		
		$pagina['trabajos'] = $lista;
		$base['cuerpo'] = $this->load->view('trabajador/historial',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
}

?>