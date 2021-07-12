<?php /* ESTE ES ULTIMO  MODELO DE LA BD MODIFICADA */
class Requerimientos_model extends CI_Model{

	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}

	function ingresar($data){
		$this->aramark->insert('r_requerimiento',$data);
		return $this->aramark->insert_id();
	}

	function r_listar_order_estado(){
		$this->aramark->order_by("estado", "desc"); 
		$query = $this->aramark->get('r_requerimiento');
		return $query->result();
	}

	function actualizar_desactivo_requerimiento($datos){
		$this->aramark->update('r_requerimiento', $datos);
	}
	
	function actualizar($id_req, $data){
		$this->aramark->where('id', $id_req);
		$this->aramark->update('r_requerimiento', $data);
	}

	function eliminar($id){
		$this->aramark->delete('r_requerimiento', array('id' => $id)); 
	}

	function get_result($id){
		$this->aramark->where("id",$id);
		$query = $this->aramark->get('r_requerimiento');
		return $query->result();
	}











	function todos_los_contratos_y_anexos(){
		$this->db->select('tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, rua.fecha_termino, rua.jornada, rua.renta_imponible, rua.bono_responsabilidad, rua.sueldo_base_mas_bonos_fijos, rua.asignacion_colacion, rua.otros_no_imponibles, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo');
		$this->db->from('r_requerimiento_usuario_archivo rua');
		$this->db->join('usuarios usu','rua.usuario_id = usu.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores rasc','requerimiento_asc_trabajadores_id = rasc.id','inner');
		$this->db->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','inner');
		$this->db->join('r_requerimiento req','rac.requerimiento_id = req.id','inner');
		$this->db->join('r_areas ra','rac.areas_id = ra.id','inner');
		$this->db->join('r_cargos rc','rac.cargos_id = rc.id','inner');
		$this->db->join('empresa_planta ep','req.planta_id = ep.id','inner');
		$this->db->where('rua.tipo_archivo_requerimiento_id = 1');
		$this->db->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$query = $this->db->get();
		return $query->result();
	}

	function contratos_vigentes_planta($id_planta, $fecha_inicio = false, $fecha_termino = false){
		$this->db->select('*, req.id as req_id, req.nombre as nombre_req, rua.causal as causal_contrato');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->db->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->db->where('req.planta_id', $id_planta);
		$this->db->where('req.f_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->db->where('rua.tipo_archivo_requerimiento_id', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function contratos_vigentes_planta_mandante($id_planta){
		$this->db->select('*, req.id as req_id, req.nombre as nombre_req, rua.causal as causal_contrato');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->db->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->db->where('req.planta_id', $id_planta);
		//$this->db->where('req.f_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->db->where('rua.tipo_archivo_requerimiento_id', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function contratos_vigentes_planta_por_usuario($id_planta, $fecha_inicio = false, $fecha_termino = false){
		$this->db->select('*, rua.causal as causal_contrato');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->db->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->db->where('req.planta_id', $id_planta);
		$this->db->where('req.f_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->db->where('rua.tipo_archivo_requerimiento_id', 1);
		$this->db->group_by('rua.usuario_id');
		$query = $this->db->get();
		return $query->result();
	}

	function cantidad_contratos_vigentes_mes($id_planta, $fecha_inicio, $fecha_termino){
		$this->db->select('count(req.id) as cantidad_contratos');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->db->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		//$this->db->where('rua.fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->db->where('rua.fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'" or rua.fecha_termino BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->db->where('req.planta_id', $id_planta);
		$this->db->where('rua.tipo_archivo_requerimiento_id', 1);
		$query = $this->db->get();
		return $query->row();
	}

	/*function cantidad_contratos_vigentes_causales($id_planta, $fecha_inicio, $fecha_termino, $causal){
		$this->db->select('count(req.id) as cantidad_contratos');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->db->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->db->where('rua.fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->db->where('req.planta_id', $id_planta);
		$this->db->where('rua.causal', $causal);
		$this->db->where('rua.tipo_archivo_requerimiento_id', 1);
		$query = $this->db->get();
		return $query->row();
	}*/

	function cantidad_contratos_vigentes_causales_trabajador($id_planta, $fecha_inicio, $fecha_termino, $causal){
		$this->db->select('*');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->db->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->db->where('rua.fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->db->where('req.planta_id', $id_planta);
		$this->db->where('rua.causal', $causal);
		$this->db->where('rua.tipo_archivo_requerimiento_id', 1);
		$this->db->group_by('rua.usuario_id');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function listar($planta=false,$grupo=false){
		$this->db->select('*,req.id as id_req');
		if( $planta ){
			$this->db->join('planta_grupo', 'planta_grupo.id = req.id_grupo');
			$this->db->join('empresa_planta', 'empresa_planta.id = planta_grupo.id_planta');
			$this->db->where("empresa_planta.id",$planta);
		}
		if( $grupo ){
			$this->db->where("id_grupo",$grupo);
		}
		$query = $this->db->get('r_requerimiento req');
		//echo $this->db->last_query();
		return $query->result();
	}

	function listar_trabajadores_asc_planta($id_planta){
		$this->db->select('rat.usuario_id');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','inner');
		$this->db->where('req.planta_id', $id_planta);
		$this->db->group_by('rat.usuario_id');
		$query = $this->db->get();
		return $query->result();
	}

	function obtener_fecha_primer_contrato($usuario_id, $id_planta){
		$this->db->select('rua.fecha_inicio');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','inner');
		$this->db->join('r_requerimiento_usuario_archivo rua','rat.id = rua.requerimiento_asc_trabajadores_id','inner');
		$this->db->where('rat.usuario_id', $usuario_id);
		$this->db->where('req.planta_id', $id_planta);
		$this->db->where('tipo_archivo_requerimiento_id', 1);
		$this->db->order_by('rua.fecha_inicio', 'ASC');
		$this->db->limit('1');
		$query = $this->db->get();
		return $query->row();
			//select rua.fecha_inicio from r_requerimiento req inner join r_requerimiento_area_cargo rac on req.id = rac.requerimiento_id inner join r_requerimiento_asc_trabajadores rat on rac.id = rat.requerimiento_area_cargo_id inner join r_requerimiento_usuario_archivo rua on rat.id = rua.requerimiento_asc_trabajadores_id where rat.usuario_id = '7780' and req.planta_id = '1' and tipo_archivo_requerimiento_id = '1' ORDER BY `rua`.`fecha_inicio` ASC limit 1
	}

	function requerimientos_planta_usuario($usuario_id, $id_planta){
		$this->db->select('req.id as id_req, req.nombre, req.planta_id, rac.id as rac_id, rat.requerimiento_area_cargo_id, rat.usuario_id, rat.referido');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','left');
			
		if($id_planta != "todos")
			$this->db->where('req.planta_id', $id_planta);

		$this->db->where('rat.usuario_id', $usuario_id);
		$query = $this->db->get();
		return $query->result();
		//SELECT req.id as id_req, req.nombre, req.planta_id, rac.id as rac_id, rat.requerimiento_area_cargo_id, rat.usuario_id, rat.referido FROM r_requerimiento req left join r_requerimiento_area_cargo rac on req.id = rac.requerimiento_id left join r_requerimiento_asc_trabajadores rat on rac.id = rat.requerimiento_area_cargo_id where req.planta_id = '1' and rat.usuario_id = '6696'
	}

	function requerimientos_todas_planta_usuario($usuario_id){
		$this->db->select('req.id as id_req, req.nombre, req.planta_id, rac.id as rac_id, rat.requerimiento_area_cargo_id, rat.usuario_id, rat.referido');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','left');
		$this->db->where('rat.usuario_id', $usuario_id);
		$query = $this->db->get();
		return $query->result();
	}

	function obtener_ultimo_area_cargo($usuario_id, $id_planta){
		$this->db->select('areas_id, cargos_id');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','inner');
		$this->db->join('r_requerimiento_usuario_archivo rua','rat.id = rua.requerimiento_asc_trabajadores_id','inner');
		$this->db->where('rat.usuario_id', $usuario_id);
		$this->db->where('req.planta_id', $id_planta);
		$this->db->where('tipo_archivo_requerimiento_id', 1);
		$this->db->order_by('rua.fecha_inicio', 'desc');
		$this->db->limit('1');
		$query = $this->db->get();
		return $query->row();
		//select areas_id, cargos_id from r_requerimiento req inner join r_requerimiento_area_cargo rac on req.id = rac.requerimiento_id inner join r_requerimiento_asc_trabajadores rat on rac.id = rat.requerimiento_area_cargo_id inner join r_requerimiento_usuario_archivo rua on rat.id = rua.requerimiento_asc_trabajadores_id where rat.usuario_id = '6696' and req.planta_id = '1' and tipo_archivo_requerimiento_id = '1' ORDER BY `rua`.`fecha_inicio` DESC limit 1
	}

	function obtener_fechas_contratos($usuario_id, $id_planta){
		$this->db->select('rua.fecha_inicio, rua.fecha_termino');
		$this->db->from('r_requerimiento req');
		$this->db->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','inner');
		$this->db->join('r_requerimiento_usuario_archivo rua','rat.id = rua.requerimiento_asc_trabajadores_id','inner');
		$this->db->where('rat.usuario_id', $usuario_id);
		$this->db->where('req.planta_id', $id_planta);
		$this->db->where('tipo_archivo_requerimiento_id', 1);
		$query = $this->db->get();
		return $query->result();
		//select rua.fecha_inicio from r_requerimiento req inner join r_requerimiento_area_cargo rac on req.id = rac.requerimiento_id inner join r_requerimiento_asc_trabajadores rat on rac.id = rat.requerimiento_area_cargo_id inner join r_requerimiento_usuario_archivo rua on rat.id = rua.requerimiento_asc_trabajadores_id where rat.usuario_id = '7780' and req.planta_id = '1' and tipo_archivo_requerimiento_id = '1' ORDER BY `rua`.`fecha_inicio` ASC limit 1
	}

	function r_listar_req_vencidos(){
		$this->db->select('*');
		$this->db->from('r_requerimiento');
		$this->db->where('f_fin <', date('Y-m-d'));
		$query = $this->db->get();
		return $query->result();
	}

	function r_listar(){
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}


	function r_listar_activos(){
		$this->db->where('estado', 1);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function r_listar_order_fecha(){
		$this->db->order_by("f_solicitud", "desc"); 
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function r_listar_order_fecha_planta($id_planta){
		$this->db->where('planta_id', $id_planta);
		$this->db->order_by("f_solicitud", "desc"); 
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function r_listar_order_fecha_planta_activos($id_planta){
		$this->db->from('r_requerimiento');
		$this->db->where('planta_id', $id_planta);
		$this->db->where('estado', 1);
		$this->db->order_by("f_solicitud", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function r_listar_order_estado_usuarios($id_usuario, $id_planta = false){
		$this->db->select('*');
		$this->db->select('req.id as id_req');
		$this->db->from('r_requerimiento req');
		$this->db->join('relacion_usuario_planta rel_usu_p','req.planta_id = rel_usu_p.empresa_planta_id','left');
		$this->db->where('rel_usu_p.usuario_id', $id_usuario);
		if($id_planta){
			$this->db->where('req.planta_id', $id_planta);
		}
		$this->db->order_by("req.estado", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	function listar_planta($id){
		$this->db->where("id_planta",$id);
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function listar_planta_id($id){
		$this->db->where("planta_id",$id);
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function listar_datos_req($id){
		$this->db->select('*');
		$this->db->from('r_requerimiento');
		$this->db->where('planta_id', $id);
		//$this->db->where('estado', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function listar_datos_req_todos($id){
		$this->db->select('*');
		$this->db->from('r_requerimiento');
		$this->db->where('planta_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	function usuario_requerimiento($id_usuario){
		$this->db->select("*, r.id as id_requerimiento,ra.id as id_area_cargo");
		$this->db->from('r_requerimiento r');
		$this->db->join('r_requerimiento_area_cargo ra', 'r.id = ra.requerimiento_id');
		$this->db->join('r_requerimiento_asc_trabajadores rt', 'ra.id = rt.requerimiento_area_cargo_id');
		$this->db->where("rt.usuario_id",$id_usuario);
		$this->db->where("rt.estado",1);
		$query = $this->db->get();
		return $query->row();
	}

	function listar_grupo($id){
		$this->db->select("r_requerimiento.id,r_areas.desc_area,r_cargos.desc_cargo,planta_grupo.nombre");
		$this->db->from('r_requerimiento');
		$this->db->join('r_areas', 'r_areas.id = r_requerimiento.id_area');
		$this->db->join('planta_grupo', 'planta_grupo.id = r_requerimiento.id_grupo');
		$this->db->join('r_cargos', 'r_cargos.id = r_requerimiento.id_cargo');
		$this->db->where("id_grupo",$id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_planta($id){
		$this->db->select("*,planta_grupo.nombre as nombre_planta");
		$this->db->from('r_requerimiento');
		$this->db->join('planta_grupo', 'planta_grupo.id = r_requerimiento.id_grupo');
		$this->db->join('empresa_planta', 'empresa_planta.id = planta_grupo.id_planta');
		$this->db->join('r_areas', 'r_areas.id = r_requerimiento.id_area');
		$this->db->join('r_cargos', 'r_cargos.id = r_requerimiento.id_cargo');
		$this->db->where("r_requerimiento.id",$id);
		$query = $this->db->get();
		return $query->row();
	}





	function get_req_planta($id){
		$this->aramark->select("*");
		$this->aramark->from('r_requerimiento');
		$this->aramark->join('empresa_planta', 'empresa_planta.id = r_requerimiento.planta_id');
		$this->aramark->where("r_requerimiento.id",$id);
		$query = $this->aramark->get();
		return $query->row();
	}

	function get($id){
		$this->aramark->where("id",$id);
		$query = $this->aramark->get('r_requerimiento');
		return $query->row();
	}
	




	function buscar($palabra){
		$this->db->where("nombre",$palabra);
		$query = $this->db->get('r_requerimiento');
		return $query->row();
	}

	function buscar_areas($id_grupo){
		$this->db->where("id_grupo",$id_grupo);
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function buscar_cargos($id_grupo,$id_area){
		$this->db->where("id_grupo",$id_grupo);
		$this->db->where("id_area",$id_area);
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function listar_usuarios($planta=false,$grupo=false,$area=false,$cargo=false){
		if( $planta ){
			$this->db->select("r_requerimiento.id, r_requerimiento.f_solicitud,r_requerimiento.f_solicitud, r_requerimiento.id_grupo,r_requerimiento.id_cargo,r_requerimiento.id_area,r_requerimiento.cantidad,r_requerimiento.f_inicio,r_requerimiento.f_fin,r_requerimiento.causal,r_requerimiento.motivo,r_requerimiento.comentario");
			$this->db->join('planta_grupo','planta_grupo.id = r_requerimiento.id_grupo');
			$this->db->where("planta_grupo.id_planta",$planta);
		}
		if( $grupo ){
			$this->db->where("id_grupo",$grupo);
		}
		if( $area ){
			$this->db->where("id_area",$area);
		}
		if( $cargo ){
			$this->db->where("id_cargo",$cargo);
		}
		$query = $this->db->get('r_requerimiento');
		//echo $this->db->last_query();
		return $query->result();
	}

	function ultimo_folio(){
		$this->db->select('id');
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('r_requerimiento');

     	if( is_null($query->row('id')) ) $folio = 0;
     	else $folio = (int)$query->row('id');

     	return $folio + 1;
	}

}
?>