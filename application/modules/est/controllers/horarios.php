<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Horarios extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		$this->load->model("Empresa_planta_model");
		$this->load->model("Descripcion_horarios_model");

		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		$base = array(
			'head_titulo' => "Sistema EST - Listado de Horarios EST",
			'titulo' => "Horarios EST",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Horarios EST')),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);
		$pagina['listado_empresas_planta'] = $this->Empresa_planta_model->listar();
		$pagina['listado'] = $this->Descripcion_horarios_model->listar_menos_transversales();
		$base['cuerpo'] = $this->load->view('horarios/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_editar($id){
		$pagina['listado_empresas_planta'] = $this->Empresa_planta_model->listar();
		$pagina['datos_horario'] = $this->Descripcion_horarios_model->get_result($id);
		$this->load->view('est/horarios/modal_editar_horario', $pagina);
	}

	function guardar_nuevo_horario(){
		$texto = $_POST['descripcion'];
		$texto = rawurlencode($texto);
		$descripcion = rawurldecode(str_replace("%0D%0A","<w:br/>",$texto));
		$data = array(
			"id_empresa_planta" => $_POST['empresa_planta'],
			"id_tipo_horario" => $_POST['tipo_horario'],
			"nombre_horario" => $_POST['titulo'],
			"descripcion" => $descripcion,
		);
		$this->Descripcion_horarios_model->ingresar($data);
		echo '<script>alert("Horario Ingresado Exitosamente");</script>';
		redirect('est/horarios', 'refresh');
	}

	function actualizar_horario(){
		$id_horario = $_POST['id_horario'];
		$texto = $_POST['descripcion'];
		$texto = rawurlencode($texto);
		$descripcion = rawurldecode(str_replace("%0D%0A","<w:br/>",$texto));
		$data = array(
			"id_empresa_planta" => $_POST['empresa_planta'],
			"id_tipo_horario" => $_POST['tipo_horario'],
			"nombre_horario" => $_POST['titulo'],
			"descripcion" => $descripcion,
		);
		$this->Descripcion_horarios_model->editar($id_horario, $data);
		echo '<script>alert("Horario Actualizado Exitosamente");</script>';
		redirect('est/horarios', 'refresh');
	}

	function eliminar($id){
		$this->Descripcion_horarios_model->eliminar($id);
		redirect('est/horarios', 'refresh');
	}

}

?>