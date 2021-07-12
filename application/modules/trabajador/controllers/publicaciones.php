<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Publicaciones extends CI_Controller {
	public $noticias;

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo') == "trabajador" and $this->session->userdata('subtipo') == "integra")
			$this->menu = $this->load->view('layout2.0/menus/menu_trabajador','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');

		$this->load->model("Noticias_est_model");
		$this->load->model("Noticias_model");
		$this->load->model("Ofertas_model");
		$this->load->model("Asignarequerimiento_model");
		$this->load->model("Evaluacionestipo_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_est_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->noticias['capacitaciones_noleidas'] = $this ->Noticias_est_model->cont_capacitacion_noleidas($this->session->userdata('id'));
		$this->noticias['ofertas_noleidas'] = $this->Ofertas_model->cont_ofertas_noleidas($this->session->userdata('id'));
		$this->noticias['requerimiento_nuevo'] = $this->Asignarequerimiento_model->cant_asignados($this->session->userdata('id'));
		$this->noticias['listado_tipoeval'] = $this->Evaluacionestipo_model->listar();
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_trabajador($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->noticias['mensajes_noleidos'] = $suma;
	}

	function index() {
		$base = array(
			'head_titulo' => "Publicaciones integra",
			'titulo' => "Publicaciones",
			'side_bar' => true,
			'js' => array('plugins/holder/holder.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => 'trabajador', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Publicaciones') ),
			'menu' => $this->menu
		);

		$pagina['publicaciones'] = $this->noticias;
		$base['cuerpo'] = $this->load->view('publicaciones/index', $pagina, TRUE);
		//$this->load->view('layout', $base);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

	function inbox_ajax(){
		$this->load->helper('text');
		$this->load->helper('fechas');

		$tamano_pagina = 30;
		if (isset($_POST["n_pagina"]))
			$n_pagina = $_POST["n_pagina"];

		if (!isset($n_pagina)) {
		    $inicio = 0;
		    $n_pagina=1;
		}
		else {
		    $inicio = ($n_pagina - 1) * $tamano_pagina;
		}

		if($_POST['pagina']){
			$tipo_pag = $_POST['pagina'];
			$lista = array();
			if ($tipo_pag == "ajax-all"){
				$num_total_registros = count($this->Noticias_model->union_tablas(2,$this->session->userdata('id')));
				//calculo el total de páginas
				$total_paginas = ceil($num_total_registros / $tamano_pagina); 
				
				foreach($this->Noticias_model->union_tablas(2,$this->session->userdata('id'),$inicio,$tamano_pagina) as $n){//solo mostrara usuarios tipo 2, que son trabajadores.
					$aux = new stdClass();
					if ($n->tabla =="ofertas")
						$leido = $this->Ofertas_model->noticias_noleidas_usr($n->id_noticia,$this->session->userdata('id'));
					else
						$leido = $this->Noticias_model->noticias_noleidas_usr($n->id_noticia,$this->session->userdata('id'));
					$aux->id = urlencode(base64_encode($n->id_noticia));
					$aux->titulo = $n->titulo;
					$aux->texto = word_limiter(strip_tags($n->desc_noticia), 10);
					$aux->fecha = $n->fecha;
					$aux->leido = (!empty($leido))? true : false;
					$aux->activo = $n->activo;
					$aux->tipo = $tipo_pag;
					$aux->especif = $n->tabla;
					array_push($lista,$aux);
					unset($aux,$leido);
				}
			}
			elseif ($tipo_pag == "ajax-noticias"){
				$num_total_registros = count($this->Noticias_model->mostrar_listado(2,$this->session->userdata('id')));
				//calculo el total de páginas
				$total_paginas = ceil($num_total_registros / $tamano_pagina); 
				foreach($this->Noticias_model->mostrar_listado(2,$this->session->userdata('id'),$inicio,$tamano_pagina) as $n){//solo mostrara usuarios tipo 2, que son trabajadores.
					$aux = new stdClass();
					$leido = $this->Noticias_model->noticias_noleidas_usr($n->id_noticia,$this->session->userdata('id'));
					$aux->id = urlencode(base64_encode($n->id_noticia));
					$aux->titulo = $n->titulo;
					$aux->texto = word_limiter(strip_tags($n->desc_noticia), 10);
					$aux->fecha = $n->fecha;
					$aux->leido = (!empty($leido))? true : false;
					$aux->activo = true;
					$aux->tipo = $tipo_pag;
					array_push($lista,$aux);
					unset($aux,$leido);
				}
			}
			elseif($tipo_pag == "ajax-ofertas"){
				$num_total_registros = count($this->Ofertas_model->mostrar_listado(2,$this->session->userdata('id')));
				//calculo el total de páginas
				$total_paginas = ceil($num_total_registros / $tamano_pagina); 
				foreach($this->Ofertas_model->mostrar_listado(2,$this->session->userdata('id'),$inicio,$tamano_pagina) as $n){//solo mostrara usuarios tipo 2, que son trabajadores.
					$aux = new stdClass();
					$leido = $this->Ofertas_model->noticias_noleidas_usr($n->oferta_id,$this->session->userdata('id'));
					$aux->id = urlencode(base64_encode($n->oferta_id));
					$aux->titulo = $n->titulo;
					$aux->texto = word_limiter(strip_tags($n->desc_oferta), 10);
					$aux->fecha = $n->fecha;
					$aux->leido = (!empty($leido))? true : false;
					$aux->activo = $n->activo;
					$aux->tipo = $tipo_pag;
					array_push($lista,$aux);
					unset($aux,$leido);
				}
			}
			elseif($tipo_pag == "ajax-capacitacion"){
				$num_total_registros = count($this->Noticias_model->mostrar_listado_cap(2));
				//calculo el total de páginas
				$total_paginas = ceil($num_total_registros / $tamano_pagina); 
				foreach($this->Noticias_model->mostrar_listado_cap(2,$inicio,$tamano_pagina) as $n){//solo mostrara usuarios tipo 2, que son trabajadores.
					$aux = new stdClass();
					$leido = $this->Noticias_model->noticias_noleidas_usr($n->id_noticia,$this->session->userdata('id'));
					$aux->id = urlencode(base64_encode($n->id_noticia));
					$aux->titulo = $n->titulo;
					$aux->texto = word_limiter(strip_tags($n->desc_noticia), 30);
					$aux->fecha = $n->fecha;
					$aux->leido = (!empty($leido))? true : false;
					$aux->activo = true;
					$aux->tipo = $tipo_pag;
					array_push($lista,$aux);
					unset($aux,$leido);
				}
			}
			elseif($tipo_pag == "ajax-trash"){
				$num_total_registros = count($this->Noticias_model->eliminadas_union($this->session->userdata('id')));
				//calculo el total de páginas
				$total_paginas = ceil($num_total_registros / $tamano_pagina); 
				foreach($this->Noticias_model->eliminadas_union($this->session->userdata('id'),$inicio,$tamano_pagina) as $n){
					$aux = new stdClass();
					$aux->id = urlencode(base64_encode($n->id_noticia));
					$aux->titulo = $n->titulo;
					$aux->texto = word_limiter(strip_tags($n->desc_noticia), 30);
					$aux->fecha = $n->fecha;
					$aux->leido = true;
					$aux->activo = true;
					$aux->tipo = $tipo_pag;
					array_push($lista,$aux);
					unset($aux,$leido);
				}
			}

			if ( $n_pagina <= $total_paginas )
				$n_paginas_next = $n_pagina + 1;
			else
				$n_paginas_next = $total_paginas;

			if ( $n_pagina <= 2 )
				$n_paginas_prev = 1;
			else
				$n_paginas_prev = $n_pagina - 1;

			$pagina['n_pagina_next'] = $n_paginas_next;
			$pagina['n_pagina_prev'] = $n_paginas_prev;
			$pagina['listado'] = $lista;
			$this->load->view('publicaciones/ajax-inbox',$pagina);
		}
	}

	function contenido_ajax(){
		if( $_POST['id'] && $_POST['pagina']){
			//$id = base64_decode(urldecode($_POST['id']));
			$id = base64_decode(urldecode($_POST['id']));
			$tipo_pag = $_POST['pagina'];
			if ($tipo_pag == "ajax-noticias"){
				$salida = $this->Noticias_model->get($id);

				//actualizar noticia leida
				$this->marcar_leido($id,$tipo_pag);
			}
			elseif($tipo_pag == "ajax-ofertas"){
				$this->Ofertas_model->get($id);
				$salida = $this->Ofertas_model->get($id);

				//actualizar a oferta vista
				$this->marcar_leido($id,$tipo_pag);

			}
			elseif($tipo_pag == "ajax-capacitacion"){
				$salida = $this->Noticias_model->get($id);
				//capacitacion leida
				$this->marcar_leido($id,$tipo_pag);
			}
			
			$pagina['noticia'] = $salida;
			$pagina['pagina'] = $tipo_pag;
			$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$this->load->view('publicaciones/ajax-contenido',$pagina);
		}
	}

	private function marcar_leido($id,$tipo_pag){
		if ($tipo_pag == "ajax-noticias"){
			$s = $this->Noticias_model->get_revisar($this->session->userdata('id'),$id);
			if($s < 1){
				$data = array(
					'id_noticia' => $id,
					'id_usuario' => $this->session->userdata('id'),
					'fecha' => date("Y-m-d H:i:s")
				);
				$this->Noticias_model->ingresar_revisar($data);
				return true;
			}
			else return false;
		}
		elseif($tipo_pag == "ajax-ofertas"){
			$s = $this->Ofertas_model->get_revisar($this->session->userdata('id'),$id);
			if($s < 1){
				$data = array(
					'id_oferta' => $id,
					'id_usuario' => $this->session->userdata('id'),
					'fecha' => date("Y-m-d H:i:s")
				);
				$this->Ofertas_model->ingresar_revisar($data);
				return true;
			}
			else return false;

		}
		elseif($tipo_pag == "ajax-capacitacion"){
			$s = $this->Noticias_model->get_revisar($this->session->userdata('id'),$id);
			if($s < 1){
				$data = array(
					'id_noticia' => $id,
					'id_usuario' => $this->session->userdata('id'),
					'fecha' => date("Y-m-d H:i:s")
				);
				$this->Noticias_model->ingresar_revisar($data);
				return true;
			}
			else return false;
		}
	}

	function leido(){
		$id = base64_decode(urldecode($_POST['id']));
		$tipo_pag = $_POST['pagina'];
		$this->marcar_leido($id,$tipo_pag);
	}

	function borrar(){
		$id = base64_decode(urldecode($_POST['id']));
		$tipo_pag = $_POST['pagina'];
		$this->eliminar($id,$tipo_pag);
	}














	private function eliminar($id,$tipo_pag){
		if ($tipo_pag == "ajax-noticias"){
			$data = array(
				'id_noticia' => $id,
				'id_usuario' => $this->session->userdata('id'),
				'fecha' => date("Y-m-j")
			);
			$this->Noticias_model->eliminar_noticia($data);
		}
		elseif($tipo_pag == "ajax-ofertas"){
			$data = array(
				'id_ofertas' => $id,
				'id_usuarios' => $this->session->userdata('id'),
				'fecha' => date("Y-m-j")
			);
			$this->Ofertas_model->eliminar_oferta($data);
		}
		elseif($tipo_pag == "ajax-capacitacion"){

		}
	}


	function detalle($id = FALSE,$id_area){
		if(empty($id) || empty($id_area)) redirect('/error/error_404', 'refresh');
		$this->load->helper('urlencrypt');
		$this->load->helper('fechas');
		$this->load->model("Publicaciones_requerimientos_model");
		$this->load->model("Publicaciones_requerimientos_adjuntos_model");
		
		$id = desencrypt($id);
		$id_area = desencrypt($id_area);
		
		$publicacion = $this->Publicaciones_requerimientos_model->get($id);
		$adjuntos = $this->Publicaciones_requerimientos_adjuntos_model->listar_adjuntos($id);
		
		// if($this->session->userdata('tipo') != 3){ //validacion de no ingreso a noticia autorizada
			// if( $noticia->id_tipousuarios == $this->session->userdata('tipo') || $noticia->id_tipousuarios == NULL )
				// TRUE;
			// else
			 // redirect('/error/error_404', 'refresh');
		// }
		
		$base['titulo'] = "Publicaciones integra";
		$base['lugar'] = "Publicaciones";
		$pagina['publicacion'] = $publicacion;
		$pagina['adjuntos'] = $adjuntos;
		
		// if($this->Noticias_model->noticias_noleidas_usr($noticia->id,$this->session->userdata('id')) > 0 ){
			// $revisar = $this->Noticias_model->noticias_noleidas_id($noticia->id,$this->session->userdata('id'));
			// $this->Noticias_model->eliminar_revisar($revisar->id);
		// }
		$pagina['publicaciones_limite'] = $this->Publicaciones_requerimientos_model->get_publicacion_limite($id,$id_area,$this->session->userdata("id"),3);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['menu'] = $this->load->view('menus/menu_trabajador', $this->noticias, TRUE);
		$base['cuerpo'] = $this->load->view('requerimientos/detalle_publicaciones', $pagina, TRUE);
		//$this->load->view('layout', $base);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

	function requerimiento($id,$id_area){
		if( empty( $id) || empty($id_area) )
			 redirect('/error/error_404', 'refresh');
		
		$this->load->helper('urlencrypt');
		$this->load->helper('text');
		$this->load->helper('fechas');
		$this->load->model("Publicaciones_requerimientos_model");
		
		
		$id = desencrypt($id);
		$pagina['id_area'] = $id_area;
		$id_area = desencrypt($id_area);
		$base['titulo'] = "Publicaciones integra";
		$base['lugar'] = "Publicacion";
		
		$lista = array();
		foreach($this->Publicaciones_requerimientos_model->get_publicacion($id,$id_area,$this->session->userdata('id')) as $p ){
			$aux = new stdClass();
			$aux->idpr = encrypt($p->idpr);
			$aux->titulo = $p->titulo;
			$aux->texto = word_limiter($p->desc_publicacion, 30);
			$aux->fecha = $p->fecha;
			array_push($lista,$aux);
			unset($aux,$leido);
		}
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$pagina['menu'] = $this->load->view('menus/menu_trabajador', $this->noticias, TRUE);
		$pagina['listado_noticias'] = $lista;
		$base['cuerpo'] = $this->load->view('requerimientos/listado_publicaciones', $pagina, TRUE);
		//$this->load->view('layout', $base);
		$this->load->view('layout2.0/layout_horizontal_menu',$base);
	}

}
?>