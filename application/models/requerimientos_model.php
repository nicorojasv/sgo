<?php /* ESTE ES ULTIMO  MODELO DE LA BD MODIFICADA */
class Requerimientos_model extends CI_Model{

	function todos_los_contratos_y_anexos(){
		$this->db->select('tipo_archivo_requerimiento_id as tipo_archivo,rua.usuario_id, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, rua.fecha_termino, rua.jornada, rua.renta_imponible, rua.bono_responsabilidad, rua.sueldo_base_mas_bonos_fijos, rua.asignacion_colacion, rua.otros_no_imponibles, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo');
		$this->db->from('r_requerimiento_usuario_archivo rua');
		$this->db->join('usuarios usu','rua.usuario_id = usu.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores rasc','requerimiento_asc_trabajadores_id = rasc.id','inner');
		$this->db->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','inner');
		$this->db->join('r_requerimiento req','rac.requerimiento_id = req.id','inner');
		$this->db->join('r_areas ra','rac.areas_id = ra.id','inner');
		$this->db->join('r_cargos rc','rac.cargos_id = rc.id','inner');
		$this->db->join('empresa_planta ep','req.planta_id = ep.id','inner');
		$this->db->where('rua.tipo_archivo_requerimiento_id = 1');
		//$this->db->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->db->order_by('rua.usuario_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function todos_los_contratos(){
		$this->db->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible, rua.bono_responsabilidad, rua.sueldo_base_mas_bonos_fijos, rua.asignacion_colacion, rua.otros_no_imponibles, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno,usu.email , usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->db->from('r_requerimiento_usuario_archivo rua');
		$this->db->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->db->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->db->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->db->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->db->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->db->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->db->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->db->group_by('rua.usuario_id', 'ASC');
		$this->db->order_by('rua.usuario_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function todos_los_contratos_y_anexos_est(){
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

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->db->select(' *');
		$this->db->from('r_requerimiento_usuario_archivo rua');
		$this->db->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->db->where('rua.usuario_id',$id_usuario);
		$this->db->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->db->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->db->group_by('rua.usuario_id', 'ASC');
		$this->db->order_by('rua.usuario_id', 'ASC');
		$query = $this->db->get();
		return $query->row();
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

	function actualizar_desactivo_requerimiento($datos){
		$this->db->update('r_requerimiento', $datos);
	}
	
	function actualizar_estado_activo_requerimiento($id_req, $data){
		$this->db->where('id', $id_req);
		$this->db->update('r_requerimiento', $data);
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

	function r_listar_order_estado($tipo_estado = FALSE){
		$this->db->select("*"); 

		$this->db->from("r_requerimiento"); 

		if($tipo_estado == "activos")
			$this->db->where("estado", 1);

		if($tipo_estado == "inactivos")
			$this->db->where("estado", 0);
	
		$this->db->order_by("id", "desc"); 
		//$this->db->limit(10); 
		$query = $this->db->get('');
		return $query->result();
	}

	function r_listar_order_estado_usuarios($id_usuario, $id_planta = FALSE, $tipo_estado = FALSE){
		$this->db->select('*');
		$this->db->select('req.id as id_req');
		$this->db->from('r_requerimiento req');
		$this->db->join('relacion_usuario_planta rel_usu_p','req.planta_id = rel_usu_p.empresa_planta_id','left');
		$this->db->where('rel_usu_p.usuario_id', $id_usuario);
		
		if($id_planta != FALSE)
			$this->db->where('req.planta_id', $id_planta);

		if($tipo_estado == "activos")
			$this->db->where("req.estado", 1);

		if($tipo_estado == "inactivos")
			$this->db->where("req.estado", 0);

		$this->db->order_by("req.estado", "desc");
		$query = $this->db->get();
		return $query->result();
	}

	function listar_planta($id){
		$this->db->where("id_planta",$id);
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function listar_planta_id($id, $tipo_estado = FALSE){

		$this->db->select("*");
		$this->db->from("r_requerimiento");
		$this->db->where("planta_id",$id);

		if($tipo_estado == "activos")
			$this->db->where("estado", 1);

		if($tipo_estado == "inactivos")
			$this->db->where("estado", 0);

		$query = $this->db->get();
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
		$this->db->select("*");
		$this->db->from('r_requerimiento');
		$this->db->join('empresa_planta', 'empresa_planta.id = r_requerimiento.planta_id');
		$this->db->where("r_requerimiento.id",$id);
		$query = $this->db->get();
		return $query->row();
	}

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('r_requerimiento');
		return $query->row();
	}

	function get_result($id){
		$this->db->where("id",$id);
		$query = $this->db->get('r_requerimiento');
		return $query->result();
	}

	function buscar($palabra){
		$this->db->where("nombre",$palabra);
		$query = $this->db->get('r_requerimiento');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('r_requerimiento',$data); 
	}
	
	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('r_requerimiento', $data); 
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
	#18-06-2018

	function getFaenas(){
		$this->db->select('*');
		$this->db->from('empresa_planta');
		$query = $this->db->get();
		return $query->result();
	}
	#29-11-2018

	function getRequerimientoPuesto($id){
		$this->db->select('rr.id, 
						   rr.nombre as nombreRequerimiento, 
						   rr.f_solicitud as fechaSolicitudReq, 
						   rr.fecha_creacion as fechaCreacionReq, 
						   rr.f_inicio as fechaInicioReq, 
						   rr.f_fin as fechaFinReq, 
						   rr.causal as letraCausal, 
						   rr.motivo,
						   empresa.id as id_empresa,
						   empresa.razon_social as razonSocial, 
						   empresa.rut, 
						   empresa_planta.nombre as nombrePlanta, 
						   empresa_planta.direccion as direccionPlanta,
						   empresa_planta.id as idPlanta,
						   empresa_planta.nombreGerente as nombreGerente,
						   empresa_planta.rutGerente as rutGerente,
						   ciudades.desc_ciudades as nombreCiudad
						  ');
		$this->db->from('r_requerimiento rr');
		$this->db->join('empresa','empresa.id = rr.empresa_id','inner');
		$this->db->join('empresa_planta','empresa_planta.id = rr.planta_id','inner');
		$this->db->join('ciudades','ciudades.id = empresa_planta.id_ciudades','inner');
		$this->db->where('rr.id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	function buscar_adendum($id){
		$this->db->select('*');
		$this->db->from('adendum');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	function contarreq($id,$idPlanta){
		$this->db->select('*');
		$this->db->from('r_requerimiento');
		$this->db->where('id <=',$id);
		$this->db->where('f_inicio >=',"2021-01-01");
		$this->db->where('planta_id',$idPlanta);
		return $this->db->count_all_results();
	}
	
	function cambiarestado2($id,$data){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento', $data);
		
	}

}
?>