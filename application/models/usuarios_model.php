<?php
class Usuarios_model extends CI_Model{

	function listar_usuarios_evaluaciones_preo(){
		$this->db->select('id_usuarios');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', 3);
		$this->db->group_by('id_usuarios');
		$query = $this->db->get();
		return $query->result();
	}

	function desactivar_trabajador($id_usuario){
		$this->db->set('estado', 0);
		$this->db->where('id', $id_usuario);
		$this->db->update('usuarios'); 
	}

	function contar_evaluaciones_preo($id_usuario){
		$this->db->select('count(id) as total');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', 3);
		$this->db->where('id_usuarios', $id_usuario);
		$query = $this->db->get();
		return $query->row();
	}

	function contar_evaluaciones_user($id_usuario, $id_tipo_eval){
		$this->db->select('count(id) as total');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', $id_tipo_eval);
		$this->db->where('id_usuarios', $id_usuario);
		$query = $this->db->get();
		return $query->row();
	}

	function id_maximo_examenes_preo($id_usuario){
		$this->db->select('max(id) as ultimo');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', 3);
		$this->db->where('id_usuarios', $id_usuario);
		$query = $this->db->get();
		return $query->row();
	}

	function id_maximo_examenes_user($id_usuario, $id_tipo_eval){
		$this->db->select('max(id) as ultimo');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', $id_tipo_eval);
		$this->db->where('id_usuarios', $id_usuario);
		$query = $this->db->get();
		return $query->row();
	}

	function actualizar_desactivo_estado_preo($id_usuario){
		$this->db->set('estado_ultima_evaluacion', 0);
		$this->db->where('id_usuarios', $id_usuario);
		$this->db->where('id_evaluacion', 3);
		$this->db->update('evaluaciones'); 
	}

	function actualizar_desactivo_estado_user($id_usuario, $id_tipo_eval){
		$this->db->set('estado_ultima_evaluacion', 0);
		$this->db->where('id_usuarios', $id_usuario);
		$this->db->where('id_evaluacion', $id_tipo_eval);
		$this->db->update('evaluaciones'); 
	}


	function actualizar_activo_estado_preo($id){
		$this->db->set('estado_ultima_evaluacion', 1);
		$this->db->where('id', $id);
		$this->db->update('evaluaciones'); 
	}



	//masso
	function listar_usuarios_evaluaciones_masso(){
		$this->db->select('id_usuarios');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', 4);
		$this->db->group_by('id_usuarios');
		$query = $this->db->get();
		return $query->result();
	}
	function contar_evaluaciones_masso($id_usuario){
		$this->db->select('count(id) as total');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', 4);
		$this->db->where('id_usuarios', $id_usuario);
		$query = $this->db->get();
		return $query->row();
	}
	function id_maximo_examenes_masso($id_usuario){
		$this->db->select('max(id) as ultimo');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', 4);
		$this->db->where('id_usuarios', $id_usuario);
		$query = $this->db->get();
		return $query->row();
	}
	function actualizar_desactivo_estado_masso($id_usuario){
		$this->db->set('estado_ultima_evaluacion', 0);
		$this->db->where('id_usuarios', $id_usuario);
		$this->db->where('id_evaluacion', 4);
		$this->db->update('evaluaciones'); 
	}
	function actualizar_activo_estado_masso($id){
		$this->db->set('estado_ultima_evaluacion', 1);
		$this->db->where('id', $id);
		$this->db->update('evaluaciones'); 
	}
	





	function listar(){
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function listar_psicologos(){
		$query = $this->db->get('psicologos');
		return $query->result();
	}

	function consultar_permiso_exam_psic($id_usuario){
		$this->db->select('*');
		$this->db->from('permiso_examen_psicologico');
		$this->db->where('usuario_id', $id_usuario);
		$query = $this->db->get();
		if($query->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	function ingresar_permiso_exam_psic($datos){
		$this->db->insert('permiso_examen_psicologico', $datos);
	}

	function eliminar_permiso_exam_psic($id){
		$this->db->delete('permiso_examen_psicologico', array('usuario_id' => $id)); 
	}

	function listar_psicologos_activos(){
		$this->db->select('*');
		$this->db->from('psicologos');
		$this->db->where('estado', 1);
		$this->db->order_by('nombres','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_usuarios_especialidad($id_espec){
		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('estado', 1);
		$this->db->where('id_especialidad_trabajador', $id_espec);
		$this->db->or_where('id_especialidad_trabajador_2', $id_espec);
		$this->db->or_where('id_especialidad_trabajador_3', $id_espec);
		$query = $this->db->get();
		return $query->result();
	}

	function ver_usuarios_especialidad(){
		$this->db->select('*');
		//$this->db->where('id', 5100);
		$query = $this->db->get('usuarios_especialidad');
		return $query->result();
	}

	function consulta_grande(){
		$query = $this->db->query("select usu.id as id, usu.rut_usuario, usu.nombres, usu.paterno, usu.materno, usu.estado, espec_t1.desc_especialidad as especialida1, espec_t2.desc_especialidad as especialidad2,  espec_t3.desc_especialidad as especialidad3,
(CASE WHEN DATEDIFF(e_masso.fecha_v,now()) >= 0 && DATEDIFF(e_masso.fecha_v,now()) <= 30 THEN '#FF8000' WHEN DATEDIFF(e_masso.fecha_v,now()) < 0 THEN 'red' WHEN DATEDIFF(e_masso.fecha_v,now()) > 30 THEN 'green' END) color_masso, e_masso.fecha_v as fecha_vigencia_masso,
(CASE WHEN DATEDIFF(e_examen_pre.fecha_v,now()) >= 0 && DATEDIFF(e_examen_pre.fecha_v,now()) <= 30 THEN '#FF8000' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) < 0 THEN 'red' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) > 30 THEN 'green' END) color_e_preo, e_examen_pre.fecha_v as fecha_vigencia_examen_preo
from usuarios usu
left join (select id_usuarios, max(fecha_v) fecha_v from evaluaciones where id_evaluacion = 4 group by id_usuarios order by evaluaciones.id desc) e_masso on e_masso.id_usuarios = usu.id
left join (select id_usuarios, max(fecha_v) fecha_v from evaluaciones where id_evaluacion = 3 group by id_usuarios order by evaluaciones.id desc) e_examen_pre on e_examen_pre.id_usuarios = usu.id
left join especialidad_trabajador espec_t1 on usu.id_especialidad_trabajador = espec_t1.id
left join especialidad_trabajador espec_t2 on usu.id_especialidad_trabajador_2 = espec_t1.id
left join especialidad_trabajador espec_t3 on usu.id_especialidad_trabajador_3 = espec_t1.id
where id_tipo_usuarios = 2
ORDER BY `usu`.`paterno`  ASC");

return $query->result();
}



	function ver_usuarios_masso($id_usuario){
		$this->db->where('id_usuario', $id_usuario);
		$query = $this->db->get('usuario_masso');
		return $query->row();
	}

	function ver_usuarios_examen_preocupacional($id_usuario){
		$this->db->where('id_usuario', $id_usuario);
		$query = $this->db->get('usuario_e_preocupacional');
		return $query->row();
	}

	function listar_trabajadores_con_id_especialidad(){
		$this->db->select('usu.id as id, usu.fecha_actualizacion, usu.rut_usuario, usu.nombres, usu.paterno, usu.materno, usu.estado, id_especialidad_trabajador, id_especialidad_trabajador_2, id_especialidad_trabajador_3');
		$this->db->from('usuarios usu');
		$this->db->where('usu.id_tipo_usuarios', 2);
		$this->db->where('usu.estado', 0);
		$this->db->order_by('usu.paterno', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_requerimiento($id_req){
		$this->db->select('*');
		$this->db->from('usuarios u');
		$this->db->join('r_requerimiento_asc_trabajadores rt', 'u.id = rt.usuario_id', 'inner');
		$this->db->join('r_requerimiento_area_cargo rac', 'rac.id = rt.requerimiento_area_cargo_id', 'inner');
		$this->db->where("rac.requerimiento_id" ,$id_req);
		$query = $this->db->get();
		return $query->result();
	}
	
	function listar_cantidad($mayor,$menor){
		$this->db->where("id >",$mayor);
		$this->db->where("id <",$menor);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_msj($nombre){
		$this->db->like("nombres",$nombre);
		$this->db->like("nombres",$nombre);
		$this->db->or_like("paterno",$nombre);
		$this->db->or_like("materno",$nombre);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_especialidad($id,$limite=false,$pagina=false){
		$this->db->where("id_especialidad_trabajador",$id);
		if( isset($pagina) && isset($limite) ){
			$query = $this->db->get('usuarios',$limite,$pagina);
		}
		else
			$query = $this->db->get('usuarios');
		return $query->result();
	}
	function listar_id(){
		$this->db->select('id');
		$this->db->where("id_tipo_usuarios",2);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	function listar_filtro($nombre=false,$rut=false,$id_profesion=false,$id_especialidad=false,$id_ciudad=false,$clave=false,$activo=false,$limite=false,$pagina=false){
		//$this->db->cache_on();
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');	
		if($nombre){
			$this->db->or_like("nombres",$nombre);
			$this->db->or_like("paterno",$nombre);
			$this->db->or_like("materno",$nombre);
		}
		if($rut)
			$this->db->or_like("rut_usuario",$rut);
		if($id_profesion)
			$this->db->where("id_profesiones",$id_profesion);
		if($id_especialidad)
			$this->db->where("id_especialidad_trabajador",$id_especialidad);
		if($id_ciudad)
			$this->db->or_like("id_ciudades",$id_ciudad);
		if($clave){
			$this->db->or_like("idiomas",$clave);
			$this->db->or_like("software",$clave);
			$this->db->or_like("equipos",$clave);
			$this->db->or_like("cursos",$clave);
			$this->db->or_like("institucion",$clave);
		}
		$this->db->from('usuarios');
		if($clave){
			$this->db->join('experiencia', 'usuarios.id = experiencia.id_usuarios','left');
			$this->db->or_like("experiencia.funciones",$clave);
			$this->db->or_like("experiencia.referencias",$clave);
		}
		if($activo){
			if($activo == 1){
				$this->db->where("id not in (SELECT id_usuarios FROM asigna_requerimiento)",NULL);
			}
			if($activo == 2)
				$this->db->join('asigna_requerimiento', 'usuarios.id = asigna_requerimiento.id_usuarios');
		}
		$this->db->where("id_tipo_usuarios" ,2);
		if( isset($pagina) && isset($limite) )
			$this->db->limit($limite, $pagina);

		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		//$this->db->join('evaluaciones', 'usuarios.id = evaluaciones.id_usuarios', 'left');
		//$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion', 'left');
		//$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo', 'left');
		//$this->db->where("evaluaciones_tipo.id" ,3); //examen preocupacional
		//$this->db->where("evaluaciones_tipo.id" ,4); //masso
		$this->db->group_by("usuarios.id"); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function total_filtro($nombre=false,$rut=false,$id_profesion=false,$id_especialidad=false,$id_ciudad=false,$clave=false,$activo=false){
		$this->db->select('*');	
		if($nombre){
			$this->db->or_like("nombres",$nombre);
			$this->db->or_like("paterno",$nombre);
			$this->db->or_like("materno",$nombre);
		}
		if($rut)
			$this->db->or_like("rut_usuario",$rut);
		if($id_profesion)
			$this->db->or_like("id_profesiones",$id_profesion);
		if($id_especialidad)
			$this->db->or_like("id_especialidad_trabajador",$id_especialidad);
		if($id_ciudad)
			$this->db->or_like("id_ciudades",$id_ciudad);
		if($clave){
			$this->db->or_like("idiomas",$clave);
			$this->db->or_like("software",$clave);
			$this->db->or_like("equipos",$clave);
			$this->db->or_like("cursos",$clave);
			$this->db->or_like("institucion",$clave);
		}
		$this->db->from('usuarios');
		if($clave){
			$this->db->join('experiencia', 'usuarios.id = experiencia.id_usuarios','left');
			$this->db->or_like("experiencia.funciones",$clave);
			$this->db->or_like("experiencia.referencias",$clave);
		}
		if($activo){
			if($activo == 1){
				$this->db->where("id not in (SELECT id_usuarios FROM asigna_requerimiento)",NULL);
			}
			if($activo == 2)
				$this->db->join('asigna_requerimiento', 'usuarios.id = asigna_requerimiento.id_usuarios');
		}
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->where("id_tipo_usuarios" ,2);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function listar_internos(){
		$this->db->where("id_tipo_usuarios !=",2);
		$this->db->where("id_tipo_usuarios !=",1);
		$this->db->where("id_tipo_usuarios !=",6);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_mandantes(){
		$this->db->where("id_tipo_usuarios",1);
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function listar_trabajadores(){
		$this->db->where("id_tipo_usuarios",2);
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function listar_trabajadores_orden_paterno(){
		$this->db->where("id_tipo_usuarios",2);
		$this->db->order_by('paterno','asc');
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->db->where("id_tipo_usuarios",2);
		$this->db->where("estado", 1);
		$this->db->order_by("paterno","asc");
		$query = $this->db->get("usuarios");
		return $query->result();
	}

	function getTrabajadorAjax($filtro){
		$this->db->like("rut_usuario",$filtro);
		$query = $this->db->get("usuarios");
		return $query->result();
	}

	function getTrabajadorAjaxNombre($filtro){
		$this->db->like("nombres",$filtro);
		$query = $this->db->get("usuarios");
		return $query->result();
	}

	function getTrabajadorAjaxApellido($filtro){
		$this->db->like("paterno",$filtro);
		$query = $this->db->get("usuarios");
		return $query->result();
	}

	function actualizar_desactivo_trabajadores($datos){
		$this->db->where("id_tipo_usuarios",2);
		$this->db->where("usuarios_categoria_id",3);
		$this->db->update('usuarios', $datos);
	}
	
	function actualizar_estado_activo_trabajador($id_usuario, $data){
		$this->db->where('id', $id_usuario);
		$this->db->update('usuarios', $data);
	}

	function actualizar_estado_activo_psicologos($id_usuario, $data){
		$this->db->where('id', $id_usuario);
		$this->db->update('psicologos', $data);
	}

	function listar_trabajadores_est(){
		$this->db->where("id_tipo_usuarios",2);
		$this->db->where("usuarios_categoria_id",3);
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function listar_trabajadores_est_activos(){
		$this->db->where("id_tipo_usuarios",2);
		$this->db->where("usuarios_categoria_id",3);
		$this->db->where("estado",1);
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function listar_trabajadores_paginado($l1=0,$l2=false){
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');
		$this->db->from('usuarios');
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->where("id_tipo_usuarios",2);
		if( !empty($l2) ) $this->db->limit($l2, $l1);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function listar_trabajadores_paginado_filtrado($filtro,$l1=0,$l2=false){
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');
		$this->db->from('usuarios');
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->join('experiencia ex','ex.id_usuarios = usuarios.id','left');
		$this->db->where("id_tipo_usuarios",2);
		if($filtro){
			$this->db->or_like("nombres",$filtro);
			$this->db->or_like("paterno",$filtro);
			$this->db->or_like("materno",$filtro);
			$this->db->or_like("rut_usuario",$filtro);
			$this->db->or_like("idiomas",$filtro);
			$this->db->or_like("software",$filtro);
			$this->db->or_like("equipos",$filtro);
			$this->db->or_like("cursos",$filtro);
			$this->db->or_like("institucion",$filtro);
			$this->db->or_like("ciudades.desc_ciudades",$filtro);
			$this->db->or_like("et.desc_especialidad",$filtro);
			$this->db->or_like("ex.cargo",$filtro);
			$this->db->or_like("ex.area",$filtro);
			$this->db->or_like("ex.funciones",$filtro);
		}
		if( !empty($l2) ) $this->db->limit($l2, $l1);
		$this->db->group_by("usuarios.id"); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function listar_trabajadores_totales(){
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');
		$this->db->from('usuarios');
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->where("id_tipo_usuarios",2);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	function listar_trabajadores_paginado_filtrado_totales($filtro){
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');
		$this->db->from('usuarios');
		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->join('experiencia ex','ex.id_usuarios = usuarios.id','left');
		$this->db->where("id_tipo_usuarios",2);
		if($filtro){
			$this->db->or_like("nombres",$filtro);
			$this->db->or_like("paterno",$filtro);
			$this->db->or_like("materno",$filtro);
			$this->db->or_like("rut_usuario",$filtro);
			$this->db->or_like("idiomas",$filtro);
			$this->db->or_like("software",$filtro);
			$this->db->or_like("equipos",$filtro);
			$this->db->or_like("cursos",$filtro);
			$this->db->or_like("institucion",$filtro);
			$this->db->or_like("ciudades.desc_ciudades",$filtro);
			$this->db->or_like("et.desc_especialidad",$filtro);
			$this->db->or_like("ex.cargo",$filtro);
			$this->db->or_like("ex.area",$filtro);
			$this->db->or_like("ex.funciones",$filtro);
		}
		$this->db->group_by("usuarios.id"); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}
	
	function listar_no($id){
		$this->db->where('usuarios_categoria_id !=', $id);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function listar_tipo($id){
		$this->db->where('id_tipo_usuarios', $id);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('usuarios');
		return $query->row();
	}

	function get_datos_trabajador($id){
		$this->db->where('id',$id);
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function get_datos_psicologo($id){
		$this->db->where('id',$id);
		$query = $this->db->get('psicologos');
		return $query->result();
	}

	function get_datos_psicologo_row($id){
		$this->db->where('id',$id);
		$query = $this->db->get('psicologos');
		return $query->row();
	}
	
	function get_planta($id){
		$this->db->where('id_planta',$id);
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function get_planta_subusr($id){
		$this->db->where('id_planta',$id);
		$this->db->where('id_tipo_usuarios',6); //6 id sub usuarios del un usuario mandante
		$query = $this->db->get('usuarios');
		return $query->result();
	}
	
	function get_rut($rut){
		$this->db->where('rut_usuario',$rut);
		$query = $this->db->get('usuarios');
		return $query->row();
	}

	function validar($rut,$pass){
		$this->db->select('usuarios_categoria.id AS tipo,tipo_usuarios.id AS subtipo,usuarios.rut_usuario AS rut,usuarios.id AS id, usuarios.chat, usuarios.nombres');
		$this->db->from('usuarios');
		$this->db->join('usuarios_categoria', 'usuarios_categoria.id = usuarios.usuarios_categoria_id');
		$this->db->join('tipo_usuarios', 'tipo_usuarios.id = usuarios.id_tipo_usuarios', 'left');
		$this->db->where("rut_usuario",$rut);
		$this->db->where("clave",hash("sha512", $pass));
		$this->db->where("activo",0);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->row();
	}
	
	function validar2($codigo,$pass){
		$this->db->select('usuarios_categoria.id AS tipo,tipo_usuarios.id AS subtipo,usuarios.rut_usuario AS rut,usuarios.id AS id, usuarios.chat, usuarios.nombres');
		$this->db->from('usuarios');
		$this->db->join('usuarios_categoria', 'usuarios_categoria.id = usuarios.usuarios_categoria_id');
		$this->db->join('tipo_usuarios', 'tipo_usuarios.id = usuarios.id_tipo_usuarios');
		$this->db->where("codigo_ingreso",$codigo);
		$this->db->where("clave",hash("sha512", $pass));
		$query = $this->db->get();
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('usuarios', $data); 
	}

	function editar_psicologo($id,$data){
		$this->db->where('id', $id);
		$this->db->update('psicologos', $data); 
	}

	function ingresar($data){
		$this->db->insert('usuarios',$data); 
		return $this->db->insert_id();
	}

	function ingresar_psicologo($data){
		$this->db->insert('psicologos',$data);
	}
	
	function eliminar($id){
		$this->db->delete('usuarios', array('id' => $id)); 
	}

	function eliminar_psicologo($id){
		$this->db->delete('psicologos', array('id' => $id)); 
	}

	function manual($str){
		$query = $this->db->query($str);
		$data['id'] = $this->db->insert_id();
		if($data['error'] = $this->db->_error_message());
		return $data;
	}
	
	function total_planta($id_planta){
		$this->db->where('id_planta',$id_planta);
		$this->db->where('id_tipo_usuarios', 1);
		$query = $this->db->get('usuarios');
		return $query->num_rows();
	}
	function total_planta_sub($id_planta){
		$this->db->where('id_planta',$id_planta);
		$this->db->where('id_tipo_usuarios', 6);
		$query = $this->db->get('usuarios');
		return $query->num_rows();
	}

	function listar_chat($yo){
		$this->db->where('chat',1);
		$this->db->where('id !=', $yo);
		$query = $this->db->get('usuarios');
		return $query->result();
	}

	function listar_datos_trabajador($usuario_id){
		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('id', $usuario_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	function getNombreBanco($id){
		$this->db->select('*');
		$this->db->from('bancos');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	function actualizarBancosCuentas($rut, $data){
		$this->db->where("rut_usuario",$rut);
		$this->db->update('usuarios', $data);
	}

	function agregarCodigoCiudad($id, $data){
		$this->db->where('id', $id);
		$this->db->update('ciudades', $data); 
	}


	#yayo 18-12-2019
	function verficarListaNegra($id){
		$this->db->select('*');
		$this->db->from('lista_negra');
		$this->db->where("id_usuario",$id);
		$this->db->where("estado",NULL);//-> Edit 21-01-2019
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	#yayo 21-01-2020

	function getAllListaNegra(){
		$this->db->select('*');
		$this->db->from('lista_negra');
		$this->db->where('estado',NULL);
		$query = $this->db->get();
		return $query->result();
	}
	function updateListaNegra($id,$data){
		$this->db->where('id', $id);
		$this->db->update('lista_negra', $data); 
		return $afftectedRows = $this->db->affected_rows();
	}
	
	function guardarRegistroObjecion($info){
		$this->db->insert('objeciones', $info);

	}

    function actualizarPorObjecion($id){
		$this->db->set('estado', 3);
		$this->db->where('id_req_usu_arch', $id);
		$this->db->update('r_requerimiento_usuario_archivo_solicitudes_contratos'); 
	}

}
