<?php
class General_model extends CI_Model {
	
	function __construct(){
		$this->general = $this->load->database('general', TRUE);
	}

	function listar($cargo_id, $centro_costo_id, $departamento_id, $sucursales_id){
		$this->general->select('*');
		$this->general->from('usuarios usu');
		$this->general->join('usuarios_cargos usu_c','usu.id = usu_c.usuarios_id','left');
		$this->general->where('usu_c.cargos_id', $cargo_id);
		$this->general->where('usu_c.centro_costo_id', $centro_costo_id);
		$this->general->where('usu_c.departamento_id', $departamento_id);
		$this->general->where('usu_c.sucursales_id', $sucursales_id);
		$query = $this->general->get();
		return $query->result();
	}

	function eliminar($id){
		$this->general->delete('usuarios', array('id' => $id)); 
	}

	function get($id){
		$this->general->where('id', $id);
		$query = $this->general->get('usuarios');
		return $query->row();
	}

	function get_result($id){
		$this->general->where('id', $id);
		$query = $this->general->get('usuarios');
		return $query->result();
	}

	function listar_sucursales(){
		$this->general->select('*');
		$this->general->from('sucursales');
		$this->general->where('id != 14');
		$query = $this->general->get();
		return $query->result();
	}

	function listar_centros_costos(){
		$query = $this->general->get('centro_costo');
		return $query->result();
	}

	function get_centro_costo($id){
		$this->general->select('*');
		$this->general->from('centro_costo');
		$this->general->where('id', $id);
		$query = $this->general->get();
		return $query->row();
	}

	function get_sucursal($id){
		$this->general->select('*');
		$this->general->from('sucursales');
		$this->general->where('id', $id);
		$query = $this->general->get();
		return $query->row();
	}

	function editar_usuario($id,$data){
		$this->general->where('id', $id);
		$this->general->update('usuarios', $data); 
	}

	function get_rut($rut){
		$this->general->where('rut_usuario',$rut);
		$query = $this->general->get('usuarios');
		return $query->row();
	}

	function validar($rut,$pass){
		$this->general->select('*,usuarios.id as usuario_id, centro_costo.nombre as centro_costo_nombre, centro_costo.id as centro_costo_id, cargos.nombre as cargos_nombre, departamentos.id as departamento_id, cargos.id as cargo_id, sucursales.id as sucursal_id,sucursales.nombre as sucursal_nb, empresas.nombre as nombre_empresa');
		$this->general->from('usuarios');
		$this->general->join('usuarios_cargos', 'usuarios_cargos.usuarios_id = usuarios.id');
		$this->general->join('cargos', 'usuarios_cargos.cargos_id = cargos.id');
		$this->general->join('centro_costo', 'usuarios_cargos.centro_costo_id = centro_costo.id');
		$this->general->join('departamentos', 'usuarios_cargos.departamento_id = departamentos.id');
		$this->general->join('sucursales', 'usuarios_cargos.sucursales_id = sucursales.id');
		$this->general->join('empresas', 'centro_costo.empresas_id = empresas.id');
		$this->general->where('usuarios.rut_usuario', $rut);
		$this->general->where("usuarios.clave",hash("sha512", $pass));
		$query = $this->general->get();
		return $query->row();
	}

	function ingresar($data){
		$this->general->insert('usuarios',$data); 
		return $this->general->insert_id();
	}

	function ingresar_cargos($data){
		$this->general->insert('usuarios_cargos',$data);
	}

}