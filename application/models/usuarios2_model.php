<?php
class Usuarios2_model extends CI_Model{
	function listar(){
		$query = $this->db->get('usuarios');
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
	function listar_filtro($filtro=false,$activo=false,$limite=false,$pagina=false){
		$this->db->cache_on();
		$this->db->select('*,usuarios.id as id_user,et.desc_especialidad as desc_especialidad1,et2.desc_especialidad as desc_especialidad2,et3.desc_especialidad as desc_especialidad3');	
		$this->db->or_like("nombres",$filtro);
		$this->db->or_like("paterno",$filtro);
		$this->db->or_like("materno",$filtro);
		$this->db->or_like("rut_usuario",$filtro);
			
		/*$this->db->or_like("idiomas",$filtro);
		$this->db->or_like("software",$filtro);
		$this->db->or_like("equipos",$filtro);
		$this->db->or_like("cursos",$filtro);
		$this->db->or_like("institucion",$filtro);*/
		$this->db->from('usuarios');

		$this->db->join('experiencia', 'usuarios.id = experiencia.id_usuarios','left');
		$this->db->or_like("experiencia.funciones",$filtro);
		$this->db->or_like("experiencia.referencias",$filtro);
		/*
		if($activo){
			if($activo == 1){
				$this->db->where("id not in (SELECT id_usuarios FROM asigna_requerimiento)",NULL);
			}
			if($activo == 2)
				$this->db->join('asigna_requerimiento', 'usuarios.id = asigna_requerimiento.id_usuarios');
		}
		
		if( isset($pagina) && isset($limite) )
			$this->db->limit($limite, $pagina); */

		$this->db->join('ciudades', 'usuarios.id_ciudades = ciudades.id', 'left');
		$this->db->or_like("ciudades.desc_ciudades",$filtro);
		//$this->db->join('profesiones', 'usuarios.id_profesiones = profesiones.id', 'left');
		//$this->db->or_like("profesiones.desc_profesiones",$filtro);
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->or_like("et.desc_especialidad",$filtro);
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->or_like("et2.desc_especialidad",$filtro);
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->or_like("et3.desc_especialidad",$filtro);
		$this->db->join('evaluaciones', 'usuarios.id = evaluaciones.id_usuarios', 'left');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion', 'left');
		$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo', 'left');
		$this->db->where("evaluaciones_tipo.id" ,3); //examen preocupacional
		$this->db->where("evaluaciones_tipo.id" ,4); //masso
		$this->db->where("usuarios.id_tipo_usuarios", 2);
		$this->db->group_by("usuarios.id"); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function listar_filtro2($limit_start=FALSE,$limit_lenght=FALSE,$busqueda=FALSE){
	 	$data = array();

		$this->db->select("u.id id_user, u.estado, u.id_tipo_usuarios, u.nombres, u.paterno, u.materno, u.rut_usuario, u.fono, IFNULL(DATE_FORMAT(u.fecha_nac, '%d/%m/%Y'),'00/00/0000' ) fecha_nacimiento, IFNULL(c.desc_ciudades,'No Ingresada') desc_ciudades, a_afp.url afp, a_salud.url salud,a_estudios.url estudios,a_cv.url cv, et1.desc_especialidad especialidad1, et2.desc_especialidad especialidad2, et3.desc_especialidad especialidad3, e_masso.fecha_v masso, e_examen_pre.fecha_v examen_pre, rec.id requerimiento, IF(DATEDIFF(e_masso.fecha_v,now()) > 0,'vigente','vencida') estado_masso, IF(DATEDIFF(e_examen_pre.fecha_v,now()) > 0,'vigente','vencida') estado_examen,IF(ln_guion.guion <= 3, 1,IF(ln_guion.guion > 4 or ln_ln.ln >=1,2,IF((ln_guion.guion <= 3 and ln_ln.ln >=1)or ln_lnp.lnp >=1,3,0))) ln ", FALSE);
		$this->db->from('usuarios u');
		$this->db->join('(select id_usuarios, url, MAX( fecha )  from archivos_trab where id_tipoarchivo = 11 group by id_usuarios) a_afp','u.id = a_afp.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX( fecha )  from archivos_trab where id_tipoarchivo = 12 group by id_usuarios) a_salud','u.id = a_salud.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX( fecha )  from archivos_trab where id_tipoarchivo = 9 group by id_usuarios) a_estudios','u.id = a_estudios.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX( fecha )  from archivos_trab where id_tipoarchivo = 13 group by id_usuarios) a_cv','u.id = a_cv.id_usuarios','left');
		$this->db->join('ciudades c','c.id = u.id_ciudades','left');
		$this->db->join('especialidad_trabajador et1','et1.id = u.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = u.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = u.id_especialidad_trabajador_3','left');
		$this->db->join('(select id_usuarios, max(fecha_v) fecha_v from evaluaciones where id_evaluacion = 4 group by id_usuarios) e_masso','e_masso.id_usuarios = u.id','left');
		$this->db->join('(select id_usuarios, max(fecha_v) fecha_v from evaluaciones where id_evaluacion = 3 group by id_usuarios) e_examen_pre','e_examen_pre.id_usuarios = u.id','left');
		$this->db->join('(SELECT r.id, rat.usuario_id usuario_id FROM r_requerimiento r INNER JOIN r_requerimiento_area_cargo rac ON r.id = rac.requerimiento_id INNER JOIN r_requerimiento_asc_trabajadores rat ON rac.id = rat.requerimiento_area_cargo_id WHERE DATE( r.f_fin ) > NOW( ) group by rat.usuario_id) rec','rec.usuario_id = u.id','left');
		$this->db->join("(SELECT id_usuario, if(tipo='-',count(tipo),NULL) guion FROM lista_negra group by id_usuario) ln_guion",'ln_guion.id_usuario = u.id','left');
		$this->db->join("(SELECT id_usuario, if(tipo='LNP',count(tipo),NULL) lnp FROM lista_negra group by id_usuario) ln_lnp",'ln_lnp.id_usuario = u.id','left');
		$this->db->join("(SELECT id_usuario, if(tipo='LN',count(tipo),NULL) ln FROM lista_negra group by id_usuario) ln_ln",'ln_ln.id_usuario = u.id','left');
		if(!empty($busqueda)){
			$this->db->like('u.rut_usuario', $busqueda, 'after');
			$this->db->or_like('u.nombres', $busqueda, 'after'); 
			$this->db->or_like('u.paterno', $busqueda, 'after'); 
			$this->db->or_like('u.materno', $busqueda, 'after'); 
			$this->db->or_like('et1.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('et2.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('et3.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('u.fono', $busqueda); 
			$this->db->or_like('desc_ciudades', $busqueda); 
		}
		if(!empty($limit_start))
			$this->db->limit($limit_lenght,$limit_start);

		$this->db->where('u.estado', 1);
		$this->db->where('u.id_tipo_usuarios', 2);


		$query = $this->db->get();
		foreach ($query->result_array() as $row){
			$nestedData=array(); 
	        //<td><input type="checkbox" name="seleccionar[]" style="width:12px;" value="<?php echo $row->usuario_id "/></td>
		   	$nestedData[] = "<input type='checkbox' name='edicion' value='".$row["id_user"]."' class='check_edit' />";
		   	$nestedData[] = $row["rut_usuario"];
			$nestedData[] = "<a target='_blank' href='".base_url()."usuarios/perfil/listar_trabajador/".$row["id_user"]."'>".$row["nombres"].' '.$row["paterno"].' '.$row["materno"]."</a>";
			$nestedData[] = $row["fono"];
			$nestedData[] = $row["desc_ciudades"];
			$nestedData[] = $row["especialidad1"].' '.$row["especialidad2"];
			if($row["estado_masso"] == 'vigente')
				$color_masso = 'color:green';
			elseif ($row["estado_masso"] == 'vencida')
				$color_masso = 'color:red';
			elseif ($row["estado_masso"] == 'falta')
				$color_masso = 'color:#FF8000';

			$nestedData[] = "<a id='masso_".$row["id_user"]."' target='_blank' href='".base_url()."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_masso."'>".$row["masso"]."</a>";
			if($row["estado_examen"] == 'vigente')
				$color_eval = 'color:green';
			elseif ($row["estado_examen"] == 'vencida')
				$color_eval = 'color:red';
			elseif ($row["estado_examen"] == 'falta')
				$color_eval = 'color:#FF8000';
			$nestedData[] = "<a id='examen_".$row["id_user"]."' target='_blank' href='".base_url()."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_eval."'>".$row["examen_pre"]."</a>";
			$nestedData[] = $row["fecha_nacimiento"];
			$color_cv = ($row['cv'])?'color:green':'color:red';
			$url_cv = ($row['cv'])?base_url().$row['cv']:'#';
			$docs = "<a target=_'blank' style='".$color_cv."' href='".$url_cv."' >CV</a> - ";
			$color_afp = ($row['afp'])?'color:green':'color:red';
			$url_afp = ($row['afp'])?base_url().$row['afp']:'#';
			$docs .= "<a target=_'blank' style='".$color_afp."' href='".$url_afp."' >AFP</a> - ";
			$color_salud = ($row['salud'])?'color:green':'color:red';
			$url_salud = ($row['salud'])?base_url().$row['salud']:'#';
			$docs .= "<a target=_'blank' style='".$color_salud."' href='".$url_salud."' >SALUD</a> - ";
			$color_estu = ($row['estudios'])?'color:green':'color:red';
			$url_estu = ($row['estudios'])?base_url().$row['estudios']:'#';
			$docs .= "<a target=_'blank' style='".$color_estu."' href='".$url_estu."' >ESTU</a>";
			$nestedData[] = $docs;

			if($row['ln'] == 0) $anotacion = base_url().'extras/images/circle_green_16_ns.png';
			elseif($row['ln'] == 1) $anotacion = base_url().'extras/images/circle_yellow_16_ns.png';
			elseif($row['ln'] == 2) $anotacion = base_url().'extras/images/circle_red_16_ns.png';
			elseif($row['ln'] == 3) $anotacion = base_url().'extras/images/circle_red-yellow_16.png';
			
			$anot = "<a href='".base_url()."est/trabajadores/anotaciones/".$row["id_user"]."' target='_blank'><img src='".$anotacion."'></a>";
			if($row['requerimiento']) $anot .= "<a style='color:red;' target='_blank' title='' href='".base_url()."est/requerimiento/usuarios_requerimiento/".$row["requerimiento"]."/".$row["id_user"]."'><i class='fa fa-flag'></i></a>";
			else $anot .= "<i style='color:green;'' class='fa fa-flag'></i>";
			$anot .= "<a href='".base_url()."est/evaluaciones/informe/".$row["id_user"]."' target='_blank'><i class='fa fa-eye'></i></a>";
			$anot .= "<a href='".base_url()."usuarios/perfil/trabajador_est/".$row["id_user"]."#datos-personales' target='_blank'><i class='fa fa-edit'></i></a>";
			//$anot .= "<a href='".base_url()."est/trabajadores/desactivar/".$row["id_user"]."' class='desactivar_trabajador'><i class='fa fa-ban'></i></a>";
			//$anot .= "<a href='".base_url()."est/trabajadores/eliminar_trabajador/".$row["id_user"]."' class='eliminar_trabajador2'><i class='fa fa-trash-o'></i></a>";
			$nestedData[] = $anot;
			$nestedData[] = "<a data-usuario='".$row["id_user"]."' href='".base_url()."est/evaluaciones/listado_usuario/".$row["id_user"]."' class='sv-callback-list'><i class='fa fa-book'></i></a>";
			
			$data[] = $nestedData;
		}
		return $data;
	}

	function llenar_mongo_otro(){
		$base_url = "https://sgo2.integraest.cl/";
	 	$this->load->library('cimongo');
	 	$this->cimongo->delete('est');
	 	$data = array();
		$this->db->select("u.id id_user, e_examen_pre.id_preo, e_examen_pre.indice_ganancia, u.estado, u.id_tipo_usuarios, u.nombres, u.paterno, u.materno, u.rut_usuario, u.fono, IFNULL(DATE_FORMAT(u.fecha_nac, '%d/%m/%Y'),'00/00/0000' ) fecha_nacimiento, IFNULL(c.desc_ciudades,'No Ingresada') desc_ciudades, a_afp.url afp, a_salud.url salud, a_estudios.url estudios, a_cv.url cv, et1.desc_especialidad especialidad1, et2.desc_especialidad especialidad2, et3.desc_especialidad especialidad3, DATE_FORMAT(e_masso.fecha_v, '%d/%m/%Y') masso, DATE_FORMAT(m_masso.fecha_v, '%d/%m/%Y') masso_madera, DATE_FORMAT(e_examen_pre.fecha_v, '%d/%m/%Y') examen_pre, rec.id requerimiento, rec.status, rec.requerimiento_area_cargo requerimiento_area_cargo, rec.nombre_req nombre_req,(CASE WHEN DATEDIFF(e_masso.fecha_v,now()) >= 0 && DATEDIFF(e_masso.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(e_masso.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(e_masso.fecha_v,now()) > 30 THEN 'vigente' END) estado_masso,(CASE WHEN DATEDIFF(m_masso.fecha_v,now()) >= 0 && DATEDIFF(m_masso.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(m_masso.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(m_masso.fecha_v,now()) > 30 THEN 'vigente' END) madera_masso, (CASE WHEN DATEDIFF(e_examen_pre.fecha_v,now()) >= 0 && DATEDIFF(e_examen_pre.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) > 30 THEN 'vigente' END) estado_examen,IF(ln_guion.guion <= 3, 1,IF(ln_guion.guion > 4 or ln_ln.ln >=1,2,IF((ln_guion.guion <= 3 and ln_ln.ln >=1)or ln_lnp.lnp >=1,3,0))) ln, DATE_FORMAT(psicologico.fecha_vigencia, '%d/%m/%Y') vigencia_psicologico, psicologico.resultado resultado_pisocologico, psicologico.tecnico_supervisor, conocimiento.resultado as nota_conocimiento", FALSE);
		$this->db->from('usuarios u');
		/*
		$this->db->join('(select id_usuarios, url, MAX(fecha) from archivos_trab where id_tipoarchivo = 11 group by id_usuarios) a_afp','u.id = a_afp.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX(fecha) from archivos_trab where id_tipoarchivo = 12 group by id_usuarios) a_salud','u.id = a_salud.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX(fecha) from archivos_trab where id_tipoarchivo = 9 group by id_usuarios) a_estudios','u.id = a_estudios.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX(fecha) from archivos_trab where id_tipoarchivo = 13 group by id_usuarios) a_cv','u.id = a_cv.id_usuarios','left');
		*/
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 11 GROUP BY id_usuarios) ORDER BY id DESC) a_afp','u.id = a_afp.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 12 GROUP BY id_usuarios) ORDER BY id DESC) a_salud','u.id = a_salud.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 9 GROUP BY id_usuarios) ORDER BY id DESC) a_estudios','u.id = a_estudios.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 13 GROUP BY id_usuarios) ORDER BY id DESC) a_cv','u.id = a_cv.id_usuarios','left');
		$this->db->join('ciudades c','c.id = u.id_ciudades','left');
		$this->db->join('especialidad_trabajador et1','et1.id = u.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = u.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = u.id_especialidad_trabajador_3','left');
		$this->db->join('(select id_usuarios, fecha_v from evaluaciones where id_evaluacion = 4 and estado_ultima_evaluacion = 1 group by id_usuarios) e_masso','e_masso.id_usuarios = u.id','left');
		
		$this->db->join('(select id as id_preo, id_usuarios, fecha_v, indice_ganancia from evaluaciones where id_evaluacion = 3 and estado_ultima_evaluacion = 1 group by id_usuarios) e_examen_pre','e_examen_pre.id_usuarios = u.id','left');
		$this->db->join('(select id_usuarios, fecha_v from evaluaciones where id_evaluacion = 20 and estado_ultima_evaluacion = 1 group by id_usuarios) m_masso','m_masso.id_usuarios = u.id','left');
		$this->db->join('(select usuario_id, fecha_vigencia, resultado, tecnico_supervisor from examenes_psicologicos where estado_ultimo_examen = 1 group by usuario_id) psicologico','psicologico.usuario_id = u.id','left');
		$this->db->join('(select ev.id_usuarios, ev.resultado from evaluaciones ev left join evaluaciones_evaluacion ev_eval on ev.id_evaluacion = ev_eval.id where ev_eval.id_tipo = 3 and estado_ultima_evaluacion = 1 group by id_usuarios) conocimiento','conocimiento.id_usuarios = u.id','left');
		//$this->db->join('(select r.id, rat.usuario_id usuario_id, rac.id requerimiento_area_cargo, r.nombre nombre_req FROM r_requerimiento r INNER JOIN r_requerimiento_area_cargo rac ON r.id = rac.requerimiento_id INNER JOIN r_requerimiento_asc_trabajadores rat ON rac.id = rat.requerimiento_area_cargo_id WHERE DATE( r.f_fin ) > NOW( ) group by rat.usuario_id) rec','rec.usuario_id = u.id','left');
		$this->db->join('(select req.id, r_asc.status, r_asc.usuario_id, r_area_cargo.id requerimiento_area_cargo, req.nombre as nombre_req from r_requerimiento_asc_trabajadores r_asc left join r_requerimiento_area_cargo r_area_cargo on r_asc.requerimiento_area_cargo_id = r_area_cargo.id left join r_requerimiento req on r_area_cargo.requerimiento_id = req.id where req.estado = 1 and r_asc.status != 6) rec','rec.usuario_id = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='-',count(tipo),NULL) guion FROM lista_negra group by id_usuario) ln_guion",'ln_guion.id_usuario = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='LNP',count(tipo),NULL) lnp FROM lista_negra group by id_usuario) ln_lnp",'ln_lnp.id_usuario = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='LN',count(tipo),NULL) ln FROM lista_negra group by id_usuario) ln_ln",'ln_ln.id_usuario = u.id','left');
		$this->db->where('u.estado', 1);
		$this->db->where('u.id_tipo_usuarios', 2);

		$query = $this->db->get();
		foreach ($query->result_array() as $row){
			$nestedData=array();

			if($row['ln'] == 0) $anotacion = $base_url.'extras/images/circle_green_16_ns.png';
			elseif($row['ln'] == 1) $anotacion = $base_url.'extras/images/circle_yellow_16_ns.png';
			elseif($row['ln'] == 2) $anotacion = $base_url.'extras/images/circle_red_16_ns.png';
			elseif($row['ln'] == 3) $anotacion = $base_url.'extras/images/circle_red-yellow_16.png';

			$nestedData[] = "<input type='checkbox' name='edicion' value='".$row["id_user"]."' class='check_edit' />";
		   	$nestedData[] = $row["rut_usuario"];
		   	$nestedData[] = "<a target='_blank' href='".$base_url."usuarios/perfil/listar_trabajador/".$row["id_user"]."'>".$row["nombres"].' '.$row["paterno"].' '.$row["materno"]."</a>";
			$nestedData[] = $row["fono"];
			$nestedData[] = $row["desc_ciudades"];
			$nestedData[] = $row["especialidad1"].' '.$row["especialidad2"];

			if($row["estado_masso"] == 'vigente')
				$color_masso = 'color:green';
			elseif ($row["estado_masso"] == 'vencida')
				$color_masso = 'color:red';
			elseif ($row["estado_masso"] == 'falta')
				$color_masso = 'color:#FF8000';

			if($row["madera_masso"] == 'vigente')
				$masso_madera = 'color:#523000';
			elseif ($row["madera_masso"] == 'vencida')
				$masso_madera = 'color:#59351f';
			elseif ($row["madera_masso"] == 'falta')
				$masso_madera = 'color:#c6a664';
			else $masso_madera = '';

			if($row["estado_examen"] == 'vigente')
				$color_eval = 'color:green';
			elseif ($row["estado_examen"] == 'vencida')
				$color_eval = 'color:red';
			elseif ($row["estado_examen"] == 'falta')
				$color_eval = 'color:#FF8000';
			else $color_eval ='';

			if ($row["resultado_pisocologico"] == 'NA')
				$color_tecnico_sup = 'color:red';
			elseif($row["tecnico_supervisor"] == '1')
				$color_tecnico_sup = 'color:green';
			elseif ($row["tecnico_supervisor"] == '2')
				$color_tecnico_sup = 'color:blue';
			else
				$color_tecnico_sup = 'color:#00000';

			$nestedData[] = $row["nota_conocimiento"];
			$nestedData[] = "<a id='masso_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_masso."'>".$row["masso"]."</a><br><a id='masso_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$masso_madera."'>".$row["masso_madera"]."";

			if($row['id_preo'] != NULL and $row['id_preo'] != 0 and $row['indice_ganancia'] != NULL and $row['indice_ganancia'] != 0 and $row['indice_ganancia'] != "")
				$nestedData[] = "<a id='examen_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_eval."'>".$row["examen_pre"]."</a> <a title='Visualizar Bateria del Examen' data-target='#ModalBaterias' data-toggle='modal'  href='".$base_url."est/trabajadores/modal_baterias/".$row["id_user"]."/".$row["id_preo"]."'><i class='fa fa-search' ></i></a><br><font color='red'>IA=".$row['indice_ganancia']."%</font>";
			elseif($row['id_preo'] != NULL and $row['id_preo'] != 0)
				$nestedData[] = "<a id='examen_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_eval."'>".$row["examen_pre"]."</a> <a title='Visualizar Bateria del Examen' data-target='#ModalBaterias' data-toggle='modal'  href='".$base_url."est/trabajadores/modal_baterias/".$row["id_user"]."/".$row["id_preo"]."'><i class='fa fa-search' ></i></a>";
			else
				$nestedData[] = "<a id='examen_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_eval."'>".$row["examen_pre"]."</a>";

			//$nestedData[] = "<a style='".$color_tecnico_sup."'>".$row["vigencia_psicologico"]."<br>".$row["resultado_pisocologico"]."</a>";
			$nestedData[] = "<a style='".$color_tecnico_sup."'>".$row["vigencia_psicologico"]."</a>";
			$nestedData[] = $row["fecha_nacimiento"];
			$color_cv = ($row['cv'])?'color:green':'color:red';
			$url_cv = ($row['cv'])?$base_url.$row['cv']:'#';
			$docs = "<a target=_'blank' style='".$color_cv."' href='".$url_cv."' >CV</a> - ";
			$color_afp = ($row['afp'])?'color:green':'color:red';
			$url_afp = ($row['afp'])?$base_url.$row['afp']:'#';
			$docs .= "<a target=_'blank' style='".$color_afp."' href='".$url_afp."' >AFP</a> - ";
			$color_salud = ($row['salud'])?'color:green':'color:red';
			$url_salud = ($row['salud'])?$base_url.$row['salud']:'#';
			$docs .= "<a target=_'blank' style='".$color_salud."' href='".$url_salud."' >SALUD</a> - ";
			$color_estu = ($row['estudios'])?'color:green':'color:red';
			$url_estu = ($row['estudios'])?$base_url.$row['estudios']:'#';
			$docs .= "<a target=_'blank' style='".$color_estu."' href='".$url_estu."' >ESTU</a> -";
			#.- 25-01-2019 Se agrega campo  QR ?
			/*if($row['status'] != 6 and $row['status'] != 7 and $row['status'] != 0 and $row['status'] != NULL){
			$docs .= "<input type='button' value='Generar' data='".$base_url."qr/".$row["requerimiento_area_cargo"]."/".$row["id_user"]."' onclick='update_qrcode(this)' >";}*/

			$nestedData[] = $docs;

			$anot = "<a href='".$base_url."est/trabajadores/anotaciones/".$row["id_user"]."' target='_blank'><img src='".$anotacion."'></a>";
			if($row['status'] != 6 and $row['status'] != 7 and $row['status'] != 0 and $row['status'] != NULL)
				$anot .= "<a style='color:red;' target='_blank' title='".$row["nombre_req"]."' href='".$base_url."est/requerimiento/usuarios_requerimiento/".$row["requerimiento_area_cargo"]."/".$row["id_user"]."'><i class='fa fa-flag'></i></a>";
			elseif($row['status'] == 7)
				$anot .= "<a style='color:orange;' target='_blank' title='".$row["nombre_req"]."' href='".$base_url."est/requerimiento/usuarios_requerimiento/".$row["requerimiento_area_cargo"]."/".$row["id_user"]."'><i class='fa fa-flag'></i></a>";
			else
				$anot .= "<i style='color:green;' class='fa fa-flag'></i>";
			$anot .= "<a href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' target='_blank'><i class='fa fa-eye'></i></a>";
			$anot .= "<a href='".$base_url."usuarios/perfil/trabajador_est/".$row["id_user"]."#datos-personales' target='_blank'><i class='fa fa-edit'></i></a>";
			$anot .= "<a data-usuario='".$row["id_user"]."' href='".$base_url."est/evaluaciones/listado_usuario/".$row["id_user"]."' class='sv-callback-list'><i class='fa fa-book'></i></a>";
			//$anot .= "<a href='".$base_url."est/trabajadores/desactivar_trabajadores/".$row["id_user"]."' ><i class='fa fa-ban'></i></a>";
			$nestedData[] = $anot;
			$data[] = $nestedData;
		}
		$this->cimongo->insert("est",array('data' => $data) );
		echo "LLeno...";
	}

	function llenar_mongo($limit_start=FALSE,$limit_lenght=FALSE,$busqueda=FALSE){
		$base_url = "http://localhost/sgo2/";
	 	$this->load->library('cimongo');
	 	$this->cimongo->delete('est');
	 	$data = array();
		$this->db->select("u.id id_user, e_examen_pre.id_preo, e_examen_pre.indice_ganancia, u.estado, u.id_tipo_usuarios, u.nombres, u.paterno, u.materno, u.rut_usuario, u.fono, IFNULL(DATE_FORMAT(u.fecha_nac, '%d/%m/%Y'),'00/00/0000' ) fecha_nacimiento, IFNULL(c.desc_ciudades,'No Ingresada') desc_ciudades, a_afp.url afp, a_salud.url salud, a_estudios.url estudios, a_cv.url cv, et1.desc_especialidad especialidad1, et2.desc_especialidad especialidad2, et3.desc_especialidad especialidad3, DATE_FORMAT(e_masso.fecha_v, '%d/%m/%Y') masso, DATE_FORMAT(e_examen_pre.fecha_v, '%d/%m/%Y') examen_pre, rec.id requerimiento, rec.status, rec.requerimiento_area_cargo requerimiento_area_cargo, rec.nombre_req nombre_req,(CASE WHEN DATEDIFF(e_masso.fecha_v,now()) >= 0 && DATEDIFF(e_masso.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(e_masso.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(e_masso.fecha_v,now()) > 30 THEN 'vigente' END) estado_masso, (CASE WHEN DATEDIFF(e_examen_pre.fecha_v,now()) >= 0 && DATEDIFF(e_examen_pre.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) > 30 THEN 'vigente' END) estado_examen,IF(ln_guion.guion <= 3, 1,IF(ln_guion.guion > 4 or ln_ln.ln >=1,2,IF((ln_guion.guion <= 3 and ln_ln.ln >=1)or ln_lnp.lnp >=1,3,0))) ln, DATE_FORMAT(psicologico.fecha_vigencia, '%d/%m/%Y') vigencia_psicologico, psicologico.resultado resultado_pisocologico, psicologico.tecnico_supervisor, conocimiento.resultado as nota_conocimiento", FALSE);
		$this->db->from('usuarios u');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 11 GROUP BY id_usuarios) ORDER BY id DESC) a_afp','u.id = a_afp.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 12 GROUP BY id_usuarios) ORDER BY id DESC) a_salud','u.id = a_salud.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 9 GROUP BY id_usuarios) ORDER BY id DESC) a_estudios','u.id = a_estudios.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 13 GROUP BY id_usuarios) ORDER BY id DESC) a_cv','u.id = a_cv.id_usuarios','left');
		$this->db->join('ciudades c','c.id = u.id_ciudades','left');
		$this->db->join('especialidad_trabajador et1','et1.id = u.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = u.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = u.id_especialidad_trabajador_3','left');
		$this->db->join('(select id_usuarios, fecha_v from evaluaciones where id_evaluacion = 4 and estado_ultima_evaluacion = 1 group by id_usuarios) e_masso','e_masso.id_usuarios = u.id','left');
		$this->db->join('(select id as id_preo, id_usuarios, fecha_v, indice_ganancia from evaluaciones where id_evaluacion = 3 and estado_ultima_evaluacion = 1 group by id_usuarios) e_examen_pre','e_examen_pre.id_usuarios = u.id','left');
		$this->db->join('(select usuario_id, fecha_vigencia, resultado, tecnico_supervisor from examenes_psicologicos where estado_ultimo_examen = 1 group by usuario_id) psicologico','psicologico.usuario_id = u.id','left');
		$this->db->join('(select ev.id_usuarios, ev.resultado from evaluaciones ev left join evaluaciones_evaluacion ev_eval on ev.id_evaluacion = ev_eval.id where ev_eval.id_tipo = 3 and estado_ultima_evaluacion = 1 group by id_usuarios) conocimiento','conocimiento.id_usuarios = u.id','left');
		//$this->db->join('(select r.id, rat.usuario_id usuario_id, rac.id requerimiento_area_cargo, r.nombre nombre_req FROM r_requerimiento r INNER JOIN r_requerimiento_area_cargo rac ON r.id = rac.requerimiento_id INNER JOIN r_requerimiento_asc_trabajadores rat ON rac.id = rat.requerimiento_area_cargo_id WHERE DATE( r.f_fin ) > NOW( ) group by rat.usuario_id) rec','rec.usuario_id = u.id','left');
		$this->db->join('(select req.id, r_asc.status, r_asc.usuario_id, r_area_cargo.id requerimiento_area_cargo, req.nombre as nombre_req from r_requerimiento_asc_trabajadores r_asc left join r_requerimiento_area_cargo r_area_cargo on r_asc.requerimiento_area_cargo_id = r_area_cargo.id left join r_requerimiento req on r_area_cargo.requerimiento_id = req.id where req.estado = 1 and r_asc.status != 6) rec','rec.usuario_id = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='-',count(tipo),NULL) guion FROM lista_negra group by id_usuario) ln_guion",'ln_guion.id_usuario = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='LNP',count(tipo),NULL) lnp FROM lista_negra group by id_usuario) ln_lnp",'ln_lnp.id_usuario = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='LN',count(tipo),NULL) ln FROM lista_negra group by id_usuario) ln_ln",'ln_ln.id_usuario = u.id','left');
		$this->db->where('u.estado', 1);
		$this->db->where('u.id_tipo_usuarios', 2);

		if(!empty($busqueda)){
			$this->db->like('u.rut_usuario', $busqueda, 'after');
			$this->db->or_like('u.nombres', $busqueda, 'after'); 
			$this->db->or_like('u.paterno', $busqueda, 'after'); 
			$this->db->or_like('u.materno', $busqueda, 'after'); 
			$this->db->or_like('et1.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('et2.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('et3.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('u.fono', $busqueda); 
			$this->db->or_like('desc_ciudades', $busqueda); 
		}
		if(!empty($limit_start))
			$this->db->limit($limit_lenght,$limit_start);

		$query = $this->db->get();
		foreach ($query->result_array() as $row){
			$nestedData=array();

			if($row['ln'] == 0) $anotacion = $base_url.'extras/images/circle_green_16_ns.png';
			elseif($row['ln'] == 1) $anotacion = $base_url.'extras/images/circle_yellow_16_ns.png';
			elseif($row['ln'] == 2) $anotacion = $base_url.'extras/images/circle_red_16_ns.png';
			elseif($row['ln'] == 3) $anotacion = $base_url.'extras/images/circle_red-yellow_16.png';

		   	$nestedData[] = "<input type='checkbox' name='edicion' value='".$row["id_user"]."' class='check_edit' />";
			$nestedData[] = $row["rut_usuario"];
		   	$nestedData[] = "<a target='_blank' href='".$base_url."usuarios/perfil/listar_trabajador/".$row["id_user"]."'>".$row["nombres"].' '.$row["paterno"].' '.$row["materno"]."</a>";
			$nestedData[] = $row["fono"];
			$nestedData[] = $row["desc_ciudades"];
			$nestedData[] = $row["especialidad1"].' '.$row["especialidad2"];

			if($row["estado_masso"] == 'vigente')
				$color_masso = 'color:green';
			elseif ($row["estado_masso"] == 'vencida')
				$color_masso = 'color:red';
			elseif ($row["estado_masso"] == 'falta')
				$color_masso = 'color:#FF8000';

			if($row["estado_examen"] == 'vigente')
				$color_eval = 'color:green';
			elseif ($row["estado_examen"] == 'vencida')
				$color_eval = 'color:red';
			elseif ($row["estado_examen"] == 'falta')
				$color_eval = 'color:#FF8000';

			if ($row["resultado_pisocologico"] == 'NA')
				$color_tecnico_sup = 'color:red';
			elseif($row["tecnico_supervisor"] == '1')
				$color_tecnico_sup = 'color:green';
			elseif ($row["tecnico_supervisor"] == '2')
				$color_tecnico_sup = 'color:blue';

			$nestedData[] = $row["nota_conocimiento"];
			$nestedData[] = "<a id='masso_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_masso."'>".$row["masso"]."</a>";

			if($row['id_preo'] != NULL and $row['id_preo'] != 0 and $row['indice_ganancia'] != NULL and $row['indice_ganancia'] != 0 and $row['indice_ganancia'] != "")
				$nestedData[] = "<a id='examen_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_eval."'>".$row["examen_pre"]."</a> <a title='Visualizar Bateria del Examen' data-target='#ModalBaterias' data-toggle='modal'  href='".$base_url."est/trabajadores/modal_baterias/".$row["id_user"]."/".$row["id_preo"]."'><i class='fa fa-search' ></i></a><br><font color='red'>IA=".$row['indice_ganancia']."%</font>";
			elseif($row['id_preo'] != NULL and $row['id_preo'] != 0)
				$nestedData[] = "<a id='examen_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_eval."'>".$row["examen_pre"]."</a> <a title='Visualizar Bateria del Examen' data-target='#ModalBaterias' data-toggle='modal'  href='".$base_url."est/trabajadores/modal_baterias/".$row["id_user"]."/".$row["id_preo"]."'><i class='fa fa-search' ></i></a>";
			else
				$nestedData[] = "<a id='examen_".$row["id_user"]."' target='_blank' href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' style='".$color_eval."'>".$row["examen_pre"]."</a>";

			//$nestedData[] = "<a style='".$color_tecnico_sup."'>".$row["vigencia_psicologico"]."<br>".$row["resultado_pisocologico"]."</a>";
			$nestedData[] = "<a style='".$color_tecnico_sup."'>".$row["vigencia_psicologico"]."</a>";
			$nestedData[] = $row["fecha_nacimiento"];
			$color_cv = ($row['cv'])?'color:green':'color:red';
			$url_cv = ($row['cv'])?$base_url.$row['cv']:'#';
			$docs = "<a target=_'blank' style='".$color_cv."' href='".$url_cv."' >CV</a> - ";
			$color_afp = ($row['afp'])?'color:green':'color:red';
			$url_afp = ($row['afp'])?$base_url.$row['afp']:'#';
			$docs .= "<a target=_'blank' style='".$color_afp."' href='".$url_afp."' >AFP</a> - ";
			$color_salud = ($row['salud'])?'color:green':'color:red';
			$url_salud = ($row['salud'])?$base_url.$row['salud']:'#';
			$docs .= "<a target=_'blank' style='".$color_salud."' href='".$url_salud."' >SALUD</a> - ";
			$color_estu = ($row['estudios'])?'color:green':'color:red';
			$url_estu = ($row['estudios'])?$base_url.$row['estudios']:'#';
			$docs .= "<a target=_'blank' style='".$color_estu."' href='".$url_estu."' >ESTU</a>";
			$nestedData[] = $docs;

			$anot = "<a href='".$base_url."est/trabajadores/anotaciones/".$row["id_user"]."' target='_blank'><img src='".$anotacion."'></a>";
			if($row['status'] != 6 and $row['status'] != 7 and $row['status'] != 0 and $row['status'] != NULL)
				$anot .= "<a style='color:red;' target='_blank' title='".$row["nombre_req"]."' href='".$base_url."est/requerimiento/usuarios_requerimiento/".$row["requerimiento_area_cargo"]."/".$row["id_user"]."'><i class='fa fa-flag'></i></a>";
			elseif($row['status'] == 7)
				$anot .= "<a style='color:orange;' target='_blank' title='".$row["nombre_req"]."' href='".$base_url."est/requerimiento/usuarios_requerimiento/".$row["requerimiento_area_cargo"]."/".$row["id_user"]."'><i class='fa fa-flag'></i></a>";
			else
				$anot .= "<i style='color:green;' class='fa fa-flag'></i>";
			$anot .= "<a href='".$base_url."est/evaluaciones/informe/".$row["id_user"]."' target='_blank'><i class='fa fa-eye'></i></a>";
			$anot .= "<a href='".$base_url."usuarios/perfil/trabajador_est/".$row["id_user"]."#datos-personales' target='_blank'><i class='fa fa-edit'></i></a>";
			$anot .= "<a data-usuario='".$row["id_user"]."' href='".$base_url."est/evaluaciones/listado_usuario/".$row["id_user"]."' class='sv-callback-list'><i class='fa fa-book'></i></a>";
			//$anot .= "<a href='".$base_url."est/trabajadores/desactivar_trabajadores/".$row["id_user"]."' ><i class='fa fa-ban'></i></a>";
			$nestedData[] = $anot;

			$data[] = $nestedData;			
		}
		$this->cimongo->insert("est",array('data' => $data) );
		echo "LLeno...";
	}

	function todos_los_trabajadores_est(){
		$this->db->select("u.id id_user, u.estado, u.id_tipo_usuarios, u.nombres, u.paterno, u.materno, u.rut_usuario, u.fono, IFNULL(DATE_FORMAT(u.fecha_nac, '%d/%m/%Y'),'00/00/0000' ) fecha_nacimiento, IFNULL(c.desc_ciudades,'No Ingresada') desc_ciudades, a_afp.url afp, a_salud.url salud, a_estudios.url estudios, a_cv.url cv, et1.desc_especialidad especialidad1, et2.desc_especialidad especialidad2, et3.desc_especialidad especialidad3, DATE_FORMAT(e_masso.fecha_v, '%d/%m/%Y') masso, DATE_FORMAT(e_examen_pre.fecha_v, '%d/%m/%Y') examen_pre, rec.id requerimiento, rec.requerimiento_area_cargo requerimiento_area_cargo, rec.nombre_req nombre_req,(CASE WHEN DATEDIFF(e_masso.fecha_v,now()) >= 0 && DATEDIFF(e_masso.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(e_masso.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(e_masso.fecha_v,now()) > 30 THEN 'vigente' END) estado_masso, (CASE WHEN DATEDIFF(e_examen_pre.fecha_v,now()) >= 0 && DATEDIFF(e_examen_pre.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) > 30 THEN 'vigente' END) estado_examen,IF(ln_guion.guion <= 3, 1,IF(ln_guion.guion > 4 or ln_ln.ln >=1,2,IF((ln_guion.guion <= 3 and ln_ln.ln >=1)or ln_lnp.lnp >=1,3,0))) ln, DATE_FORMAT(psicologico.fecha_vigencia, '%d/%m/%Y') vigencia_psicologico, psicologico.resultado resultado_pisocologico, psicologico.tecnico_supervisor, conocimiento.resultado as nota_conocimiento", FALSE);
		$this->db->from('usuarios u');
		$this->db->join('(select id_usuarios, url, MAX(fecha) from archivos_trab where id_tipoarchivo = 11 group by id_usuarios) a_afp','u.id = a_afp.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX(fecha) from archivos_trab where id_tipoarchivo = 12 group by id_usuarios) a_salud','u.id = a_salud.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX(fecha) from archivos_trab where id_tipoarchivo = 9 group by id_usuarios) a_estudios','u.id = a_estudios.id_usuarios','left');
		$this->db->join('(select id_usuarios, url, MAX(fecha) from archivos_trab where id_tipoarchivo = 13 group by id_usuarios) a_cv','u.id = a_cv.id_usuarios','left');
		$this->db->join('ciudades c','c.id = u.id_ciudades','left');
		$this->db->join('especialidad_trabajador et1','et1.id = u.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = u.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = u.id_especialidad_trabajador_3','left');
		$this->db->join('(select id_usuarios, fecha_v from evaluaciones where id_evaluacion = 4 and estado_ultima_evaluacion = 1) e_masso','e_masso.id_usuarios = u.id','left');
		$this->db->join('(select id_usuarios, fecha_v from evaluaciones where id_evaluacion = 3 and estado_ultima_evaluacion = 1) e_examen_pre','e_examen_pre.id_usuarios = u.id','left');
		$this->db->join('(select usuario_id, fecha_vigencia, resultado, tecnico_supervisor from examenes_psicologicos where estado_ultimo_examen = 1) psicologico','psicologico.usuario_id = u.id','left');
		$this->db->join('(select ev.id_usuarios, ev.resultado from evaluaciones ev left join evaluaciones_evaluacion ev_eval on ev.id_evaluacion = ev_eval.id where ev_eval.id_tipo = 3 and estado_ultima_evaluacion = 1) conocimiento','conocimiento.id_usuarios = u.id','left');
		$this->db->join('(select r.id, rat.usuario_id usuario_id, rac.id requerimiento_area_cargo, r.nombre nombre_req FROM r_requerimiento r INNER JOIN r_requerimiento_area_cargo rac ON r.id = rac.requerimiento_id INNER JOIN r_requerimiento_asc_trabajadores rat ON rac.id = rat.requerimiento_area_cargo_id WHERE DATE( r.f_fin ) > NOW( ) group by rat.usuario_id) rec','rec.usuario_id = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='-',count(tipo),NULL) guion FROM lista_negra group by id_usuario) ln_guion",'ln_guion.id_usuario = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='LNP',count(tipo),NULL) lnp FROM lista_negra group by id_usuario) ln_lnp",'ln_lnp.id_usuario = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='LN',count(tipo),NULL) ln FROM lista_negra group by id_usuario) ln_ln",'ln_ln.id_usuario = u.id','left');
		$this->db->where('u.estado', 1);
		$this->db->where('u.id_tipo_usuarios', 2);
		$query = $this->db->get();
		return $query->result();
	}



	function total_usuarios(){
		$query = $this->db->get('usuarios');
		return $query->num_rows();
	}

	function seleccionar_campos($arreglo,$id){
		$lista = array();
		foreach ($arreglo as $a) {
			$this->db->select($a);
			$this->db->from('usuarios');
			$this->db->where("id" ,$id);
			$query = $this->db->get();
			if($a == "id_ciudades"){
				if (!empty($query->row()->$a)){
					$this->db->select("desc_ciudades");
					$this->db->from('ciudades');
					$this->db->where("id" ,$query->row()->$a);
					$query_aux = $this->db->get();
					$lista[] = $query_aux->row()->desc_ciudades;
				}
				else
					$lista[] = "";
				
			}
			elseif($a == "id_estadocivil"){
				if (!empty($query->row()->$a)){
					$this->db->select("desc_estadocivil");
					$this->db->from('estado_civil');
					$this->db->where("id" ,$query->row()->$a);
					$query_aux = $this->db->get();
					$lista[] = $query_aux->row()->desc_estadocivil;
				}
				else
					$lista[] = "";
			}
			elseif($a == "id_afp"){
				if (!empty($query->row()->$a)){
					$this->db->select("desc_afp");
					$this->db->from('afp');
					$this->db->where("id" ,$query->row()->$a);
					$query_aux = $this->db->get();
					$lista[] = $query_aux->row()->desc_afp;
				}
				else
					$lista[] = "";
			}
			elseif($a == "id_salud"){
				if (!empty($query->row()->$a)){
					$this->db->select("desc_salud");
					$this->db->from('salud');
					$this->db->where("id" ,$query->row()->$a);
					$query_aux = $this->db->get();
					$lista[] = $query_aux->row()->desc_salud;
				}
				else
					$lista[] = "";
			}
			elseif($a == "id_especialidad_trabajador"){
				if (!empty($query->row()->$a)){
					$this->db->select("desc_especialidad");
					$this->db->from('especialidad_trabajador');
					$this->db->where("id" ,$query->row()->$a);
					$query_aux = $this->db->get();
					$lista[] = $query_aux->row()->desc_especialidad;
				}
				else
					$lista[] = "";
			}
			elseif ($a == "fecha_nac"){
				if($query->row()->$a == '0000-00-00' or $query->row()->$a == NULL){
					$lista[] = "";
				}else{
					$f_nac_aux = explode('-', $query->row()->$a);
					$meses = array('Enero','Febrero','Marzo','Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre','');
					$f_nac = $f_nac_aux[2].' de '. $meses[$f_nac_aux[1] - 1 ] .' de '.$f_nac_aux[0];
					$lista[] = $f_nac;
				}
			}
			else
				$lista[] = $query->row()->$a;
			
		}
		return $lista;
	}


	function total_filtro($filtro=false,$activo=false){
		$this->db->select('*');	
		$this->db->or_like("nombres",$filtro);
		$this->db->or_like("paterno",$filtro);
		$this->db->or_like("materno",$filtro);
		$this->db->or_like("rut_usuario",$filtro);
			
		//$this->db->or_like("idiomas",$filtro);
		$this->db->or_like("software",$filtro);
		$this->db->or_like("equipos",$filtro);
		$this->db->or_like("cursos",$filtro);
		$this->db->or_like("institucion",$filtro);
		$this->db->from('usuarios');

		$this->db->join('experiencia', 'usuarios.id = experiencia.id_usuarios','left');
		$this->db->or_like("experiencia.funciones",$filtro);
		$this->db->or_like("experiencia.referencias",$filtro);

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
		$this->db->or_like("ciudades.desc_ciudades",$filtro);
		$this->db->join('profesiones', 'usuarios.id_profesiones = profesiones.id', 'left');
		$this->db->or_like("profesiones.desc_profesiones",$filtro);
		$this->db->join('especialidad_trabajador et','et.id = usuarios.id_especialidad_trabajador','left');
		$this->db->or_like("et.desc_especialidad",$filtro);
		$this->db->join('especialidad_trabajador et2','et2.id = usuarios.id_especialidad_trabajador_2','left');
		$this->db->or_like("et2.desc_especialidad",$filtro);
		$this->db->join('especialidad_trabajador et3','et3.id = usuarios.id_especialidad_trabajador_3','left');
		$this->db->or_like("et3.desc_especialidad",$filtro);
		$this->db->where("usuarios.id_tipo_usuarios" ,'2');
		$this->db->group_by("usuarios.id"); 
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
			//$this->db->or_like("idiomas",$filtro);
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
		//$this->db->where("estado",1);
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
			//$this->db->or_like("idiomas",$filtro);
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
		$this->db->where('id_tipo_usuarios !=', $id);
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
		$this->db->select('usuarios_categoria.id AS tipo,tipo_usuarios.id AS subtipo,usuarios.rut_usuario AS rut,usuarios.id AS id, usuarios.chat');
		$this->db->from('usuarios');
		$this->db->join('tipo_usuarios', 'tipo_usuarios.id = usuarios.id_tipo_usuarios');
		$this->db->where("rut_usuario",$rut);
		$this->db->where("clave",hash("sha512", $pass));
		$this->db->where("activo",0);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->row();
	}
	
	function validar2($codigo,$pass){
		$this->db->select('tipo_usuarios.id AS tipo,usuarios.codigo_ingreso AS codigo_ingreso,usuarios.id AS id');
		$this->db->from('usuarios');
		$this->db->join('tipo_usuarios', 'tipo_usuarios.id = usuarios.id_tipo_usuarios');
		$this->db->where("codigo_ingreso",$codigo);
		$this->db->where("clave",hash("sha512", $pass));
		$query = $this->db->get();
		return $query->row();
	}
	
	function editar($id,$data){
		//$this->db->cache_delete_all();
		$this->db->where('id', $id);
		$this->db->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->db->cache_delete_all();
		$this->db->insert('usuarios',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		//$this->db->cache_delete_all();
		$this->db->delete('usuarios', array('id' => $id)); 
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

}