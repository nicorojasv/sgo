<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Publicaciones extends CI_Controller {
	public $noticias;

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('usuarios/login/index', 'refresh');
		/*elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');*/
		
		elseif ($this->session->userdata('tipo') != 7) {
			redirect('usuarios/login/index', 'refresh');
		}
		$this->load->model("Noticias_model");
		$this->load->model("Ofertas_model");
		$this->noticias['noticias_noleidas'] = $this->Noticias_model->cont_noticias_noleidas($this->session->userdata('id'));
		$this->noticias['capacitaciones_noleidas'] = $this ->Noticias_model->cont_capacitacion_noleidas($this->session->userdata('id'));
		$this->noticias['ofertas_noleidas'] = $this->Ofertas_model->cont_ofertas_noleidas($this->session->userdata('id'));
	}

	function index() {
		$base['titulo'] = "Publicaciones integra";
		$base['lugar'] = "Publicaciones";
		$pagina['publicaciones'] = $this->noticias;

		$pagina['menu'] = $this->load->view('menus/menu_consulta', $this->noticias, TRUE);
		$base['cuerpo'] = $this->load->view('publicaciones/index', $pagina, TRUE);
		$this->load->view('layout', $base);
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

}
?>