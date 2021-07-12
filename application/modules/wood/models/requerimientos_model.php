<?php /* ESTE ES ULTIMO  MODELO DE LA BD MODIFICADA */
class Requerimientos_model extends CI_Model{

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function ingresar($data){
		$this->wood->insert('r_requerimiento',$data);
		return $this->wood->insert_id();
	}

	function r_listar_order_estado(){
		$this->wood->order_by("estado", "desc"); 
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}

	function actualizar_desactivo_requerimiento($datos){
		$this->wood->update('r_requerimiento', $datos);
	}
	
	function actualizar($id_req, $data){
		$this->wood->where('id', $id_req);
		$this->wood->update('r_requerimiento', $data);
	}

	function eliminar($id){
		$this->wood->delete('r_requerimiento', array('id' => $id)); 
	}

	function get_result($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}
	
	function r_listar_order_estado_fecha($fecha_inicio, $fecha_termino){
		$this->wood->select("*"); 
		$this->wood->from("r_requerimiento"); 	
		$this->wood->order_by("id", "desc"); 
		//$this->wood->limit(10); 
		$this->wood->where('f_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$query = $this->wood->get('');
		return $query->result();
	}











	function todos_los_contratos_y_anexos(){
		$this->wood->select('tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, rua.fecha_termino, rua.jornada, rua.renta_imponible, rua.bono_responsabilidad, rua.sueldo_base_mas_bonos_fijos, rua.asignacion_colacion, rua.otros_no_imponibles, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo');
		$this->wood->from('r_requerimiento_usuario_archivo rua');
		$this->wood->join('usuarios usu','rua.usuario_id = usu.id','inner');
		$this->wood->join('r_requerimiento_asc_trabajadores rasc','requerimiento_asc_trabajadores_id = rasc.id','inner');
		$this->wood->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','inner');
		$this->wood->join('r_requerimiento req','rac.requerimiento_id = req.id','inner');
		$this->wood->join('r_areas ra','rac.areas_id = ra.id','inner');
		$this->wood->join('r_cargos rc','rac.cargos_id = rc.id','inner');
		$this->wood->join('empresa_planta ep','req.planta_id = ep.id','inner');
		$this->wood->where('rua.tipo_archivo_requerimiento_id = 1');
		$this->wood->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$query = $this->wood->get();
		return $query->result();
	}

	function contratos_vigentes_planta($id_planta, $fecha_inicio = false, $fecha_termino = false){
		$this->wood->select('*, req.id as req_id, req.nombre as nombre_req, rua.causal as causal_contrato');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->where('req.f_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->wood->where('rua.tipo_archivo_requerimiento_id', 1);
		$query = $this->wood->get();
		return $query->result();
	}

	function contratos_vigentes_planta_mandante($id_planta){
		$this->wood->select('*, req.id as req_id, req.nombre as nombre_req, rua.causal as causal_contrato');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->wood->where('req.planta_id', $id_planta);
		//$this->wood->where('req.f_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->wood->where('rua.tipo_archivo_requerimiento_id', 1);
		$query = $this->wood->get();
		return $query->result();
	}

	function contratos_vigentes_planta_por_usuario($id_planta, $fecha_inicio = false, $fecha_termino = false){
		$this->wood->select('*, rua.causal as causal_contrato');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->where('req.f_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->wood->where('rua.tipo_archivo_requerimiento_id', 1);
		$this->wood->group_by('rua.usuario_id');
		$query = $this->wood->get();
		return $query->result();
	}

	function cantidad_contratos_vigentes_mes($id_planta, $fecha_inicio, $fecha_termino){
		$this->wood->select('count(req.id) as cantidad_contratos');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		//$this->wood->where('rua.fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->wood->where('rua.fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'" or rua.fecha_termino BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->where('rua.tipo_archivo_requerimiento_id', 1);
		$query = $this->wood->get();
		return $query->row();
	}

	/*function cantidad_contratos_vigentes_causales($id_planta, $fecha_inicio, $fecha_termino, $causal){
		$this->wood->select('count(req.id) as cantidad_contratos');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->wood->where('rua.fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->where('rua.causal', $causal);
		$this->wood->where('rua.tipo_archivo_requerimiento_id', 1);
		$query = $this->wood->get();
		return $query->row();
	}*/

	function cantidad_contratos_vigentes_causales_trabajador($id_planta, $fecha_inicio, $fecha_termino, $causal){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rasct','rac.id = rasct.requerimiento_area_cargo_id','left');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rasct.id = rua.requerimiento_asc_trabajadores_id','left');
		$this->wood->where('rua.fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->where('rua.causal', $causal);
		$this->wood->where('rua.tipo_archivo_requerimiento_id', 1);
		$this->wood->group_by('rua.usuario_id');
		$query = $this->wood->get();
		return $query->num_rows();
	}

	function listar($planta=false,$grupo=false){
		$this->wood->select('*,req.id as id_req');
		if( $planta ){
			$this->wood->join('planta_grupo', 'planta_grupo.id = req.id_grupo');
			$this->wood->join('empresa_planta', 'empresa_planta.id = planta_grupo.id_planta');
			$this->wood->where("empresa_planta.id",$planta);
		}
		if( $grupo ){
			$this->wood->where("id_grupo",$grupo);
		}
		$query = $this->wood->get('r_requerimiento req');
		//echo $this->wood->last_query();
		return $query->result();
	}

	function listar_trabajadores_asc_planta($id_planta){
		$this->wood->select('rat.usuario_id');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','inner');
		$this->wood->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','inner');
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->group_by('rat.usuario_id');
		$query = $this->wood->get();
		return $query->result();
	}

	function obtener_fecha_primer_contrato($usuario_id, $id_planta){
		$this->wood->select('rua.fecha_inicio');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','inner');
		$this->wood->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','inner');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rat.id = rua.requerimiento_asc_trabajadores_id','inner');
		$this->wood->where('rat.usuario_id', $usuario_id);
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->where('tipo_archivo_requerimiento_id', 1);
		$this->wood->order_by('rua.fecha_inicio', 'ASC');
		$this->wood->limit('1');
		$query = $this->wood->get();
		return $query->row();
			//select rua.fecha_inicio from r_requerimiento req inner join r_requerimiento_area_cargo rac on req.id = rac.requerimiento_id inner join r_requerimiento_asc_trabajadores rat on rac.id = rat.requerimiento_area_cargo_id inner join r_requerimiento_usuario_archivo rua on rat.id = rua.requerimiento_asc_trabajadores_id where rat.usuario_id = '7780' and req.planta_id = '1' and tipo_archivo_requerimiento_id = '1' ORDER BY `rua`.`fecha_inicio` ASC limit 1
	}

	function requerimientos_planta_usuario($usuario_id, $id_planta){
		$this->wood->select('req.id as id_req, req.nombre, req.planta_id, rac.id as rac_id, rat.requerimiento_area_cargo_id, rat.usuario_id, rat.referido');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','left');
			
		if($id_planta != "todos")
			$this->wood->where('req.planta_id', $id_planta);

		$this->wood->where('rat.usuario_id', $usuario_id);
		$query = $this->wood->get();
		return $query->result();
		//SELECT req.id as id_req, req.nombre, req.planta_id, rac.id as rac_id, rat.requerimiento_area_cargo_id, rat.usuario_id, rat.referido FROM r_requerimiento req left join r_requerimiento_area_cargo rac on req.id = rac.requerimiento_id left join r_requerimiento_asc_trabajadores rat on rac.id = rat.requerimiento_area_cargo_id where req.planta_id = '1' and rat.usuario_id = '6696'
	}

	function requerimientos_todas_planta_usuario($usuario_id){
		$this->wood->select('req.id as id_req, req.nombre, req.planta_id, rac.id as rac_id, rat.requerimiento_area_cargo_id, rat.usuario_id, rat.referido');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','left');
		$this->wood->where('rat.usuario_id', $usuario_id);
		$query = $this->wood->get();
		return $query->result();
	}

	function obtener_ultimo_area_cargo($usuario_id, $id_planta){
		$this->wood->select('areas_id, cargos_id');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','inner');
		$this->wood->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','inner');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rat.id = rua.requerimiento_asc_trabajadores_id','inner');
		$this->wood->where('rat.usuario_id', $usuario_id);
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->where('tipo_archivo_requerimiento_id', 1);
		$this->wood->order_by('rua.fecha_inicio', 'desc');
		$this->wood->limit('1');
		$query = $this->wood->get();
		return $query->row();
		//select areas_id, cargos_id from r_requerimiento req inner join r_requerimiento_area_cargo rac on req.id = rac.requerimiento_id inner join r_requerimiento_asc_trabajadores rat on rac.id = rat.requerimiento_area_cargo_id inner join r_requerimiento_usuario_archivo rua on rat.id = rua.requerimiento_asc_trabajadores_id where rat.usuario_id = '6696' and req.planta_id = '1' and tipo_archivo_requerimiento_id = '1' ORDER BY `rua`.`fecha_inicio` DESC limit 1
	}

	function obtener_fechas_contratos($usuario_id, $id_planta){
		$this->wood->select('rua.fecha_inicio, rua.fecha_termino');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('r_requerimiento_area_cargo rac','req.id = rac.requerimiento_id','inner');
		$this->wood->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','inner');
		$this->wood->join('r_requerimiento_usuario_archivo rua','rat.id = rua.requerimiento_asc_trabajadores_id','inner');
		$this->wood->where('rat.usuario_id', $usuario_id);
		$this->wood->where('req.planta_id', $id_planta);
		$this->wood->where('tipo_archivo_requerimiento_id', 1);
		$query = $this->wood->get();
		return $query->result();
		//select rua.fecha_inicio from r_requerimiento req inner join r_requerimiento_area_cargo rac on req.id = rac.requerimiento_id inner join r_requerimiento_asc_trabajadores rat on rac.id = rat.requerimiento_area_cargo_id inner join r_requerimiento_usuario_archivo rua on rat.id = rua.requerimiento_asc_trabajadores_id where rat.usuario_id = '7780' and req.planta_id = '1' and tipo_archivo_requerimiento_id = '1' ORDER BY `rua`.`fecha_inicio` ASC limit 1
	}

	function r_listar_req_vencidos(){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento');
		$this->wood->where('f_fin <', date('Y-m-d'));
		$query = $this->wood->get();
		return $query->result();
	}

	function r_listar(){
		$this->wood->order_by("id", "desc"); 
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}


	function r_listar_activos(){
		$this->wood->where('estado', 1);
		$this->wood->order_by("id", "desc"); 
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}

	function r_listar_order_fecha(){
		$this->wood->order_by("f_solicitud", "desc"); 
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}

	function r_listar_order_fecha_planta($id_planta){
		$this->wood->where('planta_id', $id_planta);
		$this->wood->order_by("f_solicitud", "desc"); 
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}

	function r_listar_order_fecha_planta_activos($id_planta){
		$this->wood->from('r_requerimiento');
		$this->wood->where('planta_id', $id_planta);
		$this->wood->where('estado', 1);
		$this->wood->order_by("f_solicitud", "desc"); 
		$query = $this->wood->get();
		return $query->result();
	}

	function r_listar_order_estado_usuarios($id_usuario, $id_planta = false){
		$this->wood->select('*');
		$this->wood->select('req.id as id_req');
		$this->wood->from('r_requerimiento req');
		$this->wood->join('relacion_usuario_planta rel_usu_p','req.planta_id = rel_usu_p.empresa_planta_id','left');
		$this->wood->where('rel_usu_p.usuario_id', $id_usuario);
		if($id_planta){
			$this->wood->where('req.planta_id', $id_planta);
		}
		$this->wood->order_by("req.estado", "desc");
		$query = $this->wood->get();
		return $query->result();
	}

	function listar_planta($id){
		$this->wood->where("id_planta",$id);
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}

	function listar_planta_id($id){
		$this->wood->where("planta_id",$id);
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}

	function listar_datos_req($id){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento');
		$this->wood->where('planta_id', $id);
		//$this->wood->where('estado', 1);
		$query = $this->wood->get();
		return $query->result();
	}

	function listar_datos_req_todos($id){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento');
		$this->wood->where('planta_id', $id);
		$query = $this->wood->get();
		return $query->result();
	}

	function usuario_requerimiento($id_usuario){
		$this->wood->select("*, r.id as id_requerimiento,ra.id as id_area_cargo");
		$this->wood->from('r_requerimiento r');
		$this->wood->join('r_requerimiento_area_cargo ra', 'r.id = ra.requerimiento_id');
		$this->wood->join('r_requerimiento_asc_trabajadores rt', 'ra.id = rt.requerimiento_area_cargo_id');
		$this->wood->where("rt.usuario_id",$id_usuario);
		$this->wood->where("rt.estado",1);
		$query = $this->wood->get();
		return $query->row();
	}

	function listar_grupo($id){
		$this->wood->select("r_requerimiento.id,r_areas.desc_area,r_cargos.desc_cargo,planta_grupo.nombre");
		$this->wood->from('r_requerimiento');
		$this->wood->join('r_areas', 'r_areas.id = r_requerimiento.id_area');
		$this->wood->join('planta_grupo', 'planta_grupo.id = r_requerimiento.id_grupo');
		$this->wood->join('r_cargos', 'r_cargos.id = r_requerimiento.id_cargo');
		$this->wood->where("id_grupo",$id);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_planta($id){
		$this->wood->select("*,planta_grupo.nombre as nombre_planta");
		$this->wood->from('r_requerimiento');
		$this->wood->join('planta_grupo', 'planta_grupo.id = r_requerimiento.id_grupo');
		$this->wood->join('empresa_planta', 'empresa_planta.id = planta_grupo.id_planta');
		$this->wood->join('r_areas', 'r_areas.id = r_requerimiento.id_area');
		$this->wood->join('r_cargos', 'r_cargos.id = r_requerimiento.id_cargo');
		$this->wood->where("r_requerimiento.id",$id);
		$query = $this->wood->get();
		return $query->row();
	}





	function get_req_planta($id){
		$this->wood->select("*");
		$this->wood->from('r_requerimiento');
		$this->wood->join('empresa_planta', 'empresa_planta.id = r_requerimiento.planta_id');
		$this->wood->where("r_requerimiento.id",$id);
		$query = $this->wood->get();
		return $query->row();
	}

	function get($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('r_requerimiento');
		return $query->row();
	}
	




	function buscar($palabra){
		$this->wood->where("nombre",$palabra);
		$query = $this->wood->get('r_requerimiento');
		return $query->row();
	}

	function buscar_areas($id_grupo){
		$this->wood->where("id_grupo",$id_grupo);
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}

	function buscar_cargos($id_grupo,$id_area){
		$this->wood->where("id_grupo",$id_grupo);
		$this->wood->where("id_area",$id_area);
		$query = $this->wood->get('r_requerimiento');
		return $query->result();
	}

	function listar_usuarios($planta=false,$grupo=false,$area=false,$cargo=false){
		if( $planta ){
			$this->wood->select("r_requerimiento.id, r_requerimiento.f_solicitud,r_requerimiento.f_solicitud, r_requerimiento.id_grupo,r_requerimiento.id_cargo,r_requerimiento.id_area,r_requerimiento.cantidad,r_requerimiento.f_inicio,r_requerimiento.f_fin,r_requerimiento.causal,r_requerimiento.motivo,r_requerimiento.comentario");
			$this->wood->join('planta_grupo','planta_grupo.id = r_requerimiento.id_grupo');
			$this->wood->where("planta_grupo.id_planta",$planta);
		}
		if( $grupo ){
			$this->wood->where("id_grupo",$grupo);
		}
		if( $area ){
			$this->wood->where("id_area",$area);
		}
		if( $cargo ){
			$this->wood->where("id_cargo",$cargo);
		}
		$query = $this->wood->get('r_requerimiento');
		//echo $this->wood->last_query();
		return $query->result();
	}

	function ultimo_folio(){
		$this->wood->select('id');
		$this->wood->order_by('id','desc');
		$this->wood->limit(1);
		$query = $this->wood->get('r_requerimiento');

     	if( is_null($query->row('id')) ) $folio = 0;
     	else $folio = (int)$query->row('id');

     	return $folio + 1;
	}
	
	function getRequerimientoPuesto($id){
		$this->wood->select('rr.id, 
						   rr.nombre as nombreRequerimiento, 
						   rr.f_solicitud as fechaSolicitudReq, 
						   rr.fecha_creacion as fechaCreacionReq, 
						   rr.f_inicio as fechaInicioReq, 
						   rr.f_fin as fechaFinReq, 
						   rr.causal as letraCausal, 
						   rr.motivo, 
						   empresa.id as idEmpresa,
						   empresa.razon_social as razonSocial, 
						   empresa.rut, 
						   empresa_planta.nombre as nombrePlanta, 
						   empresa_planta.direccion as direccionPlanta,
						   empresa_planta.id as idPlanta,
						   empresa_planta.nombreGerente as nombreGerente,
						   empresa_planta.rutGerente as rutGerente,
						   ciudades.desc_ciudades as nombreCiudad
						  ');
		$this->wood->from('r_requerimiento rr');
		$this->wood->join('empresa','empresa.id = rr.empresa_id','inner');
		$this->wood->join('empresa_planta','empresa_planta.id = rr.planta_id','inner');
		$this->wood->join('ciudades','ciudades.id = empresa_planta.id_ciudades','inner');
		$this->wood->where('rr.id',$id);
		$query = $this->wood->get();
		return $query->row();
	}

}
?>