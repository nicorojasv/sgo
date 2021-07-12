<?php
class Requerimiento_model extends CI_Model {
	function listar(){
		$this->db->where('flag_vigente', 1);
		$query = $this->db->get('requerimiento');
		return $query->result();
	}
	
	function listar_planta_usr($id_usr,$id_planta,$limit=false){
		$this->db->where('id_planta', $id_planta);
		$this->db->where('id_usuarios', $id_usr);
		if($limit){
			$this->db->order_by("id", "desc");
			$this->db->limit($limit);
		}
		$query = $this->db->get('requerimiento');
		return $query->result();
	}

	function ultimo_requerimiento(){
		$this->db->select('id');
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('r_requerimiento');

     	if( is_null($query->row('id')) ) $folio = 1;
     	else $folio = (int)$query->row('id');

     	return $folio + 1;
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('requerimiento');
		return $query->row();
	}

	function r_get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('r_requerimiento');
		return $query->row();
	}

	function r_ingresar($data){
		$this->db->insert('r_requerimiento',$data); 
		return $this->db->insert_id();
	}
	
	function get_planta($id,$limit=false){
		$this->db->where('id_planta',$id);
		if($limit){
			$this->db->order_by("id", "desc");
			$this->db->limit($limit);
		}
		$query = $this->db->get('requerimiento');
		return $query->result();
	}
	
	function get_trab($id){
		$this->db->where('id_usuarios',$id);
		$query = $this->db->get('requerimiento');
		return $query->result();
	}
	
	function get_emp($id){
		$this->db->where('id_planta',$id);
		$query = $this->db->get('requerimiento');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('requerimiento', $data);
		return $this->db->insert_id();
	}
	
	function ingresar($data){
		$this->db->insert('requerimiento',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('requerimiento', array('id' => $id)); 
	}

	function r_eliminar($id){
		$this->db->delete('r_requerimiento', array('id' => $id)); 
	}
	
	function noleidas(){
		$this->db->where('flag_leido', 0);
		$this->db->where('flag_vigente', 1);
		$this->db->from('requerimiento');
		return $this->db->count_all_results();
	}
	
	function pet_eliminacion(){
		$this->db->where('eliminar', 1);
		$this->db->where('flag_vigente', 1);
		$this->db->from('requerimiento');
		return $this->db->count_all_results();
	}
	
	function get_pet_eliminacion(){
		$this->db->where('eliminar', 1);
		$this->db->where('flag_vigente', 1);
		$query = $this->db->get('requerimiento');
		return $query->result();
	}
	
	function nuevos(){
		$this->db->where('flag_leido', 0);
		$this->db->where('flag_vigente', 1);
		$query = $this->db->get('requerimiento');
		return $query->result();
	}
	function activos(){
		$query = $this->db->query('SELECT * FROM requerimiento AS r WHERE flag_leido = 1 AND flag_vigente = 1 AND CURDATE() <= ALL (SELECT MAX(fecha_termino) FROM requerimiento_trabajador AS t WHERE r.id = t.id_requerimiento)');
		//echo $this->db->last_query();
		return $query->result();
	}
	function activos2(){
		$this->db->select("*");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_areas as ra',"r.id = ra.id_requerimiento");
		$this->db->join('requerimiento_cargos as rc',"ra.id = rc.id_requerimiento_areas");
		//$this->db->join('requerimiento_trabajador as rt',"rc.id = rt.id_requerimiento_cargos");
		$this->db->where('r.flag_vigente', 1);
		$this->db->where('r.flag_leido', 1);
		//$this->db->where("MAX(rt.fecha_termino) <", date("Y-m-d"));
		$this->db->where("(SELECT MAX(fecha_termino) FROM requerimiento_trabajador AS rt WHERE rc.id = id_requerimiento) <", date("Y-m-d") );
		//$this->db->group_by("r.id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	
	function historial(){
		$query = $this->db->query('SELECT * FROM requerimiento AS r WHERE flag_leido = 1 AND flag_vigente = 1 AND CURDATE() > ALL (SELECT MAX(fecha_termino) FROM requerimiento_trabajador AS t WHERE r.id = t.id_requerimiento)');
		//echo $this->db->last_query();
		return $query->result();
	}
	function historial2(){
		$this->db->select("*,r.id as id");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_areas as ra',"r.id = ra.id_requerimiento");
		$this->db->join('requerimiento_cargos as rc',"ra.id = rc.id_requerimiento_areas");
		$this->db->join('requerimiento_trabajador as rt',"rc.id = rt.id_requerimiento_cargos");
		$this->db->where('r.flag_vigente', 1);
		//$this->db->where('r.flag_leido', 1);
		//$this->db->where("MAX(rt.fecha_termino) <", date("Y-m-d"));
		//$this->db->where("CURDATE() > ALL (SELECT MAX(fecha_termino) FROM requerimiento_trabajador AS rt WHERE rc.id = id_requerimiento) ");
		$this->db->where("rt.fecha_termino <", date("Y-m-d"));
		$this->db->group_by("r.id");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	
	function get_activas_mandante($id_mandante){
		$this->db->select("*,r.id as id_req");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_trabajador as rt',"r.id = rt.id_requerimiento");
		$this->db->where("r.id_usuarios",$id_mandante);
		$this->db->where('r.flag_vigente', 1);
		$this->db->where("rt.fecha_termino >", date("Y-m-d"));
		$this->db->group_by("rt.id_requerimiento");
		$query = $this->db->get();
		return $query->result();
	}

	function get_activas_mandante2($id_mandante){
		$this->db->select("*,r.id as id_req");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_areas as ra',"r.id = ra.id_requerimiento");
		$this->db->join('requerimiento_cargos as rc',"ra.id = rc.id_requerimiento_areas");
		$this->db->join('requerimiento_trabajador as rt',"rc.id = rt.id_requerimiento_cargos");
		$this->db->where("r.id_usuarios",$id_mandante);
		$this->db->where('r.flag_vigente', 1);
		$this->db->where("rt.fecha_termino >", date("Y-m-d"));
		$this->db->group_by("r.id");
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_inactivas_mandante($id_mandante){
		$this->db->select("*,r.id as id_req");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_trabajador as rt',"r.id = rt.id_requerimiento");
		$this->db->where("r.id_usuarios",$id_mandante);
		$this->db->where('r.flag_vigente', 1);
		$this->db->where("rt.fecha_termino <", date("Y-m-d"));
		$this->db->group_by("rt.id_requerimiento");
		$query = $this->db->get();
		return $query->result();
	}

	function get_inactivas_mandante2($id_mandante){
		$this->db->select("*,r.id as id_req");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_areas as ra',"r.id = ra.id_requerimiento");
		$this->db->join('requerimiento_cargos as rc',"ra.id = rc.id_requerimiento_areas");
		$this->db->join('requerimiento_trabajador as rt',"rc.id = rt.id_requerimiento_cargos");
		$this->db->where("r.id_usuarios",$id_mandante);
		$this->db->where('r.flag_vigente', 1);
		$this->db->where("rt.fecha_termino <", date("Y-m-d"));
		$this->db->group_by("r.id");
		$query = $this->db->get();
		return $query->result();
	}
	
	/********************************************************************/
	/*				MODELO DE LA TABLA REQUERIMIENTO_TRABAJADOR			*/
	
	function ingresar_req($data){
		$this->db->insert('requerimiento_trabajador',$data);
	}
	function actualizar_req($id,$data){
		$this->db->where('id', $id);
		$this->db->update('requerimiento_trabajador', $data);
	}
	
	function eliminar_req($id){
		$this->db->delete('requerimiento_trabajador', array('id' => $id)); 
	}
	
	function listar_req($id){
		$this->db->where('id_requerimiento',$id);
		$query = $this->db->get('requerimiento_trabajador');
		return $query->result();
	}
	
	function get_req($id){
		$this->db->where('id',$id);
		$query = $this->db->get('requerimiento_trabajador');
		return $query->row();
	}
	function get_prin_req($id){
		$this->db->where('id_requerimiento',$id);
		$query = $this->db->get('requerimiento_trabajador');
		return $query->result();
	}
	
	function get_prin_req2($id){
		$this->db->select("*,r.id as id_req");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_areas as ra',"r.id = ra.id_requerimiento");
		$this->db->join('requerimiento_cargos as rc',"ra.id = rc.id_requerimiento_areas");
		$this->db->join('requerimiento_trabajador as rt',"rc.id = rt.id_requerimiento_cargos");
		$this->db->where("r.id",$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_requerimiento_principal($id){
		$this->db->select("r.id");
		$this->db->from('requerimiento_trabajador as rt');
		$this->db->join('requerimiento_cargos as rc',"rc.id = rt.id_requerimiento_cargos");
		$this->db->join('requerimiento_areas as ra',"ra.id = rc.id_requerimiento_areas");
		$this->db->join('requerimiento as r',"r.id = ra.id_requerimiento");
		$this->db->where("rt.id",$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	/********************************************************************/
	/*				MODELO DE LA TABLA REQUERIMIENTO_ESTADO				*/
	
	function get_estado($id){
		$this->db->where('id',$id);
		$query = $this->db->get('requerimiento_estado');
		return $query->row();
	}

	/********************************************************************/
	/*				MODELO DE LA TABLA ASIGNAR REQUERIMIENTO			*/
	function ingresar_trabajador($data){
		$this->db->insert('asigna_requerimiento',$data);
		return $this->db->insert_id();
	}
	function get_asigna_req($id){
		$this->db->where("id",$id);
		$query = $this->db->get('asigna_requerimiento');
		return $query->row();
	}
	function get_trabajador($id){
		$this->db->where("id_requerimientotrabajador",$id);
		$query = $this->db->get('asigna_requerimiento');
		return $query->result();
	}
	function get_trabajador_req($id_usr,$id_req){
		$this->db->where("id_usuarios",$id_usr);
		$this->db->where("id_requerimientotrabajador",$id_req);
		$this->db->where("termino !=",1);
		$query = $this->db->get('asigna_requerimiento');
		return $query->result();
	}
	function get_trabajador_otroreq($id_usr,$id_req){
		$this->db->where("id_usuarios",$id_usr);
		$this->db->where("id_requerimientotrabajador !=",$id_req);
		$query = $this->db->get('asigna_requerimiento');
		return $query->row();
	}
	function eliminar_trabajador($id,$req){
		$data = array(
			'id_usuarios' => $id,
			'id_requerimientotrabajador' => $req
		);
		$this->db->delete('asigna_requerimiento',$data); 
	}
	function eliminar_trabajador_req($req){
		$data = array(
			'id_requerimientotrabajador' => $req
		);
		$this->db->delete('asigna_requerimiento',$data); 
	}
	function listar_trabajador_req($id_req){
		$this->db->where("id_requerimientotrabajador",$id_req);
		$query = $this->db->get('asigna_requerimiento');
		return $query->result();
	}
	function listarAdendum($id){
		$this->db->select('*');
		$this->db->from('adendum');
		$this->db->where('id_req',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function contaradendum($id){
		$this->db->select('*');
		$this->db->from('adendum');
		$this->db->where('id_req',$id);
		return $this->db->count_all_results();
	}

	function agregar_adendum($datos){
		$this->db->insert('adendum',$datos);

	}

	function ultimo_adendum($id){
		$this->db->select('*');
		$this->db->from('adendum');
		$this->db->where('id_req',$id);
		$this->db->order_by("id","desc");
    	$this->db->limit("1");
		$query = $this->db->get();
		return $query->row();
	}

}