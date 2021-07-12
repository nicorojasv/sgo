<?php
class Evaluaciones_model extends CI_Model {
	function __construct(){
		$this->general = $this->load->database('general', TRUE);
	}
	function ultimo_id_eval(){
		$this->db->select('id');
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('evaluaciones');

     	if( is_null($query->row('id')) ) $folio = 0;
     	else $folio = (int)$query->row('id');

     	return $folio + 1;
	}

	function listar($por_pagina = FALSE,$segment = FALSE){
		if($por_pagina){
			$this->db->limit($por_pagina,$segment);
		}
		$this->db->order_by('id ASC');
		$query = $this->db->get('evaluaciones');
		return $query->result();
	}
	
	function listar_usuario($id_usr){
		$this->db->where("id_usuarios",$id_usr);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get('evaluaciones');
		return $query->result();
	}

	function listar_trabajadores_cc_planta_segun_eval($id_planta, $id_tipo_eval, $estado_examen = FALSE){
		$this->db->select('id_usuarios as usuario_id');
		$this->db->from('evaluaciones');

		if($id_planta == "terceros"){
			$this->db->where('pago', 1);
		}elseif ($id_planta == "sin_cc"){
			$this->db->where('pago', 0);
			$this->db->where('ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->db->where('ccosto', $id_planta);
		}

		if($estado_examen == "no_cobrados")
			$this->db->where('estado_cobro', 0);
		elseif($estado_examen == "cobrados")
			$this->db->where('estado_cobro', 1);
		elseif($estado_examen == "no_informados")
			$this->db->where('estado_cobro', 2);

		$this->db->where('id_evaluacion', $id_tipo_eval);
		$this->db->where('fecha_e >=', '2014-01-01');
		$this->db->group_by('id_usuarios');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta($id_planta){
		$this->db->select('id_usuarios as usuario_id');
		$this->db->from('evaluaciones');
		$this->db->where('ccosto', $id_planta);
		$this->db->group_by('id_usuarios');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta_todos(){
		$this->db->select('id_usuarios as usuario_id');
		$this->db->from('evaluaciones');
		$this->db->where('id_evaluacion', 3);
		$this->db->or_where('id_evaluacion', 4);
		$this->db->group_by('id_usuarios');
		$query = $this->db->get();
		return $query->result();
	}

	function filtro($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$tipo);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->db->limit($por_pagina,$segment);
		}
		$this->db->where("u.id_tipo_usuarios",2);
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function filtro_vigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->db->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->db->limit($por_pagina,$segment);
		}
		
		$this->db->where("et.id",$tipo);
		$this->db->where("u.id_tipo_usuarios",2);
		
		$this->db->where("e.fecha_v >", date("Y-m-d") );
		$this->db->or_where("e.fecha_v", '0000-00-00' );
		
		
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function filtro_novigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->db->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->db->limit($por_pagina,$segment);
		}
		
		$this->db->where("et.id",$tipo);
		$this->db->where("u.id_tipo_usuarios",2);
		
		$this->db->where("e.fecha_v <", date("Y-m-d") );
		$this->db->where("e.fecha_v >", '0000-00-00' );
		
		
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function total_filtro($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$tipo);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->db->where("u.id_tipo_usuarios",2);
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function total_filtro_vigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->db->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
			
		$this->db->where("et.id",$tipo);
		$this->db->where("u.id_tipo_usuarios",2);
		
		$this->db->where("e.fecha_v >", date("Y-m-d") );
		
		$this->db->or_where("e.fecha_v", '0000-00-00' );
		
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	function total_filtro_novigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->db->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->db->where("et.id",$tipo);
		$this->db->where("u.id_tipo_usuarios",2);
		
		$this->db->where("e.fecha_v <", date("Y-m-d") );
		$this->db->where("e.fecha_v >", '0000-00-00' );
		
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	function actualizar_estado_ultima_evaluacion($id_usuario, $id_evaluacion, $datos){
		$this->db->where('id_usuarios', $id_usuario);
		$this->db->where('id_evaluacion', $id_evaluacion);
		$this->db->update('evaluaciones', $datos); 
	}

	function actualizar_estado_ultimo_ex_conocimiento($id_usuario){
		$this->db->set('ev.estado_ultima_evaluacion', 0);
		$this->db->where('ev.id_usuarios', $id_usuario);
		$this->db->where('ev_eval.id_tipo', 3);
		$this->db->where('ev.id_evaluacion = ev_eval.id');
		$this->db->update('evaluaciones ev, evaluaciones_evaluacion ev_eval');
	}

	//SIN EVALUACION
	function filtro_sinevaluacion($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "u.rut_usuario as rut,u.nombres,u.paterno,u.materno";
		$sql = "SELECT ".$select." FROM usuarios u WHERE u.id NOT IN( SELECT e.id_usuarios FROM evaluaciones e JOIN evaluaciones_evaluacion ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo et ON et.id = ee.id_tipo WHERE et.id = $tipo ) ";
		$sql.= "AND u.id_tipo_usuarios = 2 ";
		if($nombre){
			$sql.= "AND u.nombres LIKE '%$nombre%' ";
			$sql.= "OR u.paterno LIKE '%$nombre%' ";
			$sql.= "OR u.materno LIKE '%$nombre%' ";
		}
		
		if($rut){
			$sql.= "AND u.rut_usuario LIKE '%$rut%' ";
		}
		
		if($planta){
			$sql.= "AND ep.id = $planta ";
		}
		
		if($n_tipo){
			$sql.= "AND ee.id = $n_tipo ";
		}
		
		if($fecha_e1 && $fecha_e2){
			$sql.= "AND e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2' ";
		}
		
		$sql .= 'ORDER BY u.id ASC ';
		
		if($por_pagina || $segment){
			$sql.= "LIMIT $segment, $por_pagina ";
		}
		
		//$this->db->from('usuarios AS u');
		//$this->db->where('NOT EXISTS( SELECT * FROM evaluaciones AS e JOIN evaluaciones_evaluacion AS ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo AS et ON ee.id_tipo = et.id )');
		// $this->db->join('evaluaciones AS e','e.id_usuarios = u.id');
		// $this->db->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		// $this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		// $this->db->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		// $this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		// if($nombre){
			// $this->db->like("u.nombres",$nombre);
			// $this->db->or_like("u.paterno",$nombre);
			// $this->db->or_like("u.materno",$nombre);
		// }
		// if($rut){
			// $this->db->like("u.rut_usuario",$rut);
		// }
		
		// if($planta){
			// $this->db->where("ep.id",$planta);
		// }
		
		// if($n_tipo){
			// $this->db->where("ee.id",$n_tipo);
		// }
		
		// if($fecha_e1 && $fecha_e2){
			// $this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			// //$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		// }
// 		
		// if($por_pagina || $segment){
			// $this->db->limit($por_pagina,$segment);
		// }
		
		//$this->db->where("et.id",$tipo);
		//$this->db->where("u.id_tipo_usuarios",2);
		
		//$this->db->order_by('u.id ASC');
		//$this->db->select($select);
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $query->result();
	}

	function total_filtro_sinevaluacion($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		// $select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		// $this->db->from('usuarios AS u');
		// $this->db->where(' NOT EXISTS( SELECT * FROM evaluaciones AS e JOIN evaluaciones_evaluacion AS ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo AS et ON ee.id_tipo = et.id )');
		// $this->db->join('evaluaciones AS e','e.id_usuarios = u.id');
		// $this->db->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		// $this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		// $this->db->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		// $this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$select = "u.rut_usuario as rut,u.nombres,u.paterno,u.materno";
		$sql = "SELECT ".$select." FROM usuarios u WHERE u.id NOT IN( SELECT e.id_usuarios FROM evaluaciones e JOIN evaluaciones_evaluacion ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo et ON et.id = ee.id_tipo WHERE et.id = $tipo ) ";
		$sql.= "AND u.id_tipo_usuarios = 2 ";
		
		if($nombre){
			$sql.= "AND u.nombres LIKE '%$nombre%' ";
			$sql.= "OR u.paterno LIKE '%$nombre%' ";
			$sql.= "OR u.materno LIKE '%$nombre%' ";
		}
		
		if($rut){
			$sql.= "AND u.rut_usuario LIKE '%$rut%' ";
		}
		
		if($planta){
			$sql.= "AND ep.id = $planta ";
		}
		
		if($n_tipo){
			$sql.= "AND ee.id = $n_tipo ";
		}
		
		if($fecha_e1 && $fecha_e2){
			$sql.= "AND e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2' ";
		}
		
		// if($nombre){
			// $this->db->like("u.nombres",$nombre);
			// $this->db->or_like("u.paterno",$nombre);
			// $this->db->or_like("u.materno",$nombre);
		// }
		// if($rut){
			// $this->db->like("u.rut_usuario",$rut);
		// }
// 		
		// if($planta){
			// $this->db->where("ep.id",$planta);
		// }
// 		
		// if($n_tipo){
			// $this->db->where("ee.id",$n_tipo);
		// }
// 		
		// if($fecha_e1 && $fecha_e2){
			// $this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			// //$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		// }
		
		// $this->db->where("et.id",$tipo);
		// $this->db->where("u.id_tipo_usuarios",2);
// 		
		// $this->db->order_by('u.id ASC');
		// $this->db->select($select);
		// $query = $this->db->get();
		$sql .= 'ORDER BY u.id ASC';
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $query->num_rows();
	}
	
	function filtro_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->db->select($select);
		$this->db->from('usuarios u');
		$this->db->join('evaluaciones e', 'e.id_usuarios = u.id', 'left');
		$this->db->join('evaluaciones_evaluacion ee', 'e.id_evaluacion = ee.id', 'left');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where('et.id',$tipo);
		$this->db->where('u.id_tipo_usuarios',2);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		
		if($rut){
			$this->db->like("u.rut_usuario",$rut);
		}
		
		if($planta){
			$this->db->where("ep.id",$planta);
		}
		
		if($n_tipo){
			$this->db->where("ee.id",$n_tipo);
		}
		
		if($fecha_e1 && $fecha_e2){
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
		}
		
		$this->db->order_by('u.id ASC');
		
		if($por_pagina || $segment){
			$this->db->limit($por_pagina,$segment);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		
	}
	
	function total_filtro_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->db->select($select);
		$this->db->from('usuarios u');
		$this->db->join('evaluaciones e', 'e.id_usuarios = u.id', 'left');
		$this->db->join('evaluaciones_evaluacion ee', 'e.id_evaluacion = ee.id', 'left');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where('et.id',$tipo);
		$this->db->where('u.id_tipo_usuarios',2);
		
		if($nombre){
			$sql.= "AND u.nombres LIKE '%$nombre%' ";
			$sql.= "OR u.paterno LIKE '%$nombre%' ";
			$sql.= "OR u.materno LIKE '%$nombre%' ";
		}
		
		if($rut){
			$sql.= "AND u.rut_usuario LIKE '%$rut%' ";
		}
		
		if($planta){
			$sql.= "AND ep.id = $planta ";
		}
		
		if($n_tipo){
			$sql.= "AND ee.id = $n_tipo ";
		}
		
		if($fecha_e1 && $fecha_e2){
			$sql.= "AND e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2' ";
		}
		
		$this->db->order_by('u.id ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->num_rows();
	}

	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('evaluaciones');
		return $query->row();
	}

	function get_all($id){
		$this->db->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->db->join('(SELECT * FROM evaluaciones_archivo ev1 WHERE id = (SELECT MAX(id) FROM evaluaciones_archivo WHERE id_evaluacion = ev1.id_evaluacion GROUP BY id_evaluacion) ORDER BY id DESC) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_tipo($id_tipo){
		$this->db->select('*');
		$this->db->from('evaluaciones_evaluacion');
		$this->db->where('id_tipo', $id_tipo);
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_masso2($id, $id_planta = FALSE, $estado_examen = FALSE){
		$this->db->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->db->join('(select * from evaluaciones_archivo group by id_evaluacion order by id asc ) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',4);
		
		if($id_planta == "terceros"){
			$this->db->where('evaluaciones.pago', 1);
		}elseif($id_planta == "sin_cc"){
			$this->db->where('evaluaciones.pago', 0);
			$this->db->where('evaluaciones.ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->db->where('evaluaciones.ccosto',$id_planta);
		}
		
		if($estado_examen == "no_cobrados")
			$this->db->where('evaluaciones.estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->db->where('evaluaciones.estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->db->where('evaluaciones.estado_cobro', 2);

		$this->db->where('fecha_e >=', '2014-01-01');
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_masso_todas_plantas($id, $estado_examen = FALSE){
		$this->db->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->db->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',4);

		if($estado_examen == "no_cobrados")
			$this->db->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->db->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->db->where('estado_cobro', 2);

		$query = $this->db->get();
		return $query->result();
	}

	function get_all_preo2($id, $id_planta = FALSE, $estado_examen = FALSE){
		$this->db->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->db->join('(select * from evaluaciones_archivo group by id_evaluacion order by id asc ) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',3);
		
		if($id_planta == "terceros"){
			$this->db->where('evaluaciones.pago', 1);
		}elseif ($id_planta == "sin_cc"){
			$this->db->where('evaluaciones.pago', 0);
			$this->db->where('evaluaciones.ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->db->where('evaluaciones.ccosto',$id_planta);
		}

		if($estado_examen == "no_cobrados")
			$this->db->where('evaluaciones.estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->db->where('evaluaciones.estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->db->where('evaluaciones.estado_cobro', 2);

		$this->db->where('fecha_e >=', '2014-01-01');
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_preo_todas_plantas($id, $estado_examen = FALSE){
		$this->db->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->db->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',3);

		if($estado_examen == "no_cobrados")
			$this->db->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->db->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->db->where('estado_cobro', 2);


		$query = $this->db->get();
		return $query->result();
	}

	function get_desepeno($id){
		$this->db->select('*,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_tipo.nombre',"DESEMPEÑO");
		$this->db->group_by('evaluaciones_evaluacion.id');
		$query = $this->db->get();
		return $query->result();
	}

	function get_eval($id){
		$this->db->where('id_evaluacion',$id);
		$query = $this->db->get('evaluaciones');
		return $query->result();
	}

	function get_eval_id($id){
		$this->db->where('id',$id);
		$query = $this->db->get('evaluaciones');
		return $query->result();
	}

	function get_evaluacion_result($id){
		$this->db->where('id',$id);
		$query = $this->db->get('evaluaciones');
		return $query->result();
	}

	function get_eval_user($id,$user){
		$this->db->where('id_evaluacion',$id);
		$this->db->where('id_usuarios',$user);
		$query = $this->db->get('evaluaciones');
		//echo $this->db->last_query(); 
		return $query->result();
	}
	
	function get_una_masso($id){
		$this->db->select('*');
		$this->db->select('evaluaciones.id as id_masso');
		$this->db->select('DATEDIFF(evaluaciones.fecha_v,now()) as estado_masso');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',4);
		$this->db->order_by("evaluaciones.id", "desc");
		$query = $this->db->get();
		return $query->row();
	}

	function get_una_masso_requerimiento($id, $fecha_inicio_req, $fecha_vigencia_req){
		$this->db->select('*');
		$this->db->select('DATEDIFF(evaluaciones.fecha_v, ("'.$fecha_inicio_req.'")) as estado_inicio_masso');
		$this->db->select('DATEDIFF(evaluaciones.fecha_v, ("'.$fecha_vigencia_req.'")) as estado_fin_masso');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',4);
		$this->db->order_by("evaluaciones.id", "desc"); 
		$query = $this->db->get();
		return $query->row();
	}

	function not_all($id){
		$this->db->select('e.fecha_v, e.resultado, ee.nombre');
		$this->db->from('evaluaciones e');
		$this->db->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion', 'inner');
		$this->db->where('e.id_usuarios',$id);
		$this->db->where("DATE(e.fecha_v) > '0000-00-00'");
		$query = $this->db->get();
		return $query->result();
	}

	function get_una_preocupacional($id){
		$this->db->select('*');
		$this->db->select('evaluaciones.id as preo_id');
		$this->db->select('DATEDIFF(evaluaciones.fecha_v,now()) as estado_preo');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',3);
		$this->db->order_by("evaluaciones.id", "desc"); 
		$query = $this->db->get();
		return $query->row();
	}

	function get_una_preocupacional_requerimiento($id, $fecha_inicio_req, $fecha_vigencia_req){
		$this->db->select('*');
		$this->db->select('DATEDIFF(evaluaciones.fecha_e, ("'.$fecha_inicio_req.'")) as estado_inicio_preo');
		$this->db->select('DATEDIFF(evaluaciones.fecha_e, ("'.$fecha_vigencia_req.'")) as estado_fin_preo');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',3);
		$this->db->order_by("evaluaciones.id", "desc");
		$query = $this->db->get();
		return $query->row();
	}

	function get_all_desepeno($id){
		$this->db->select('*');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',5); //solo preocupacional 1.0 id 5
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_preo($id){
		$this->db->select('*');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',3); //solo preocupacional 1.0 id 5
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_conocimiento($id){
		$this->db->select('*');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_tipo.nombre','CONOCIMIENTO'); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_masso($id){
		$this->db->select('*');
		$this->db->from('evaluaciones');
		$this->db->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->db->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->db->where('evaluaciones.id_usuarios',$id);
		$this->db->where('evaluaciones_evaluacion.id',4); //solo masso id 4
		$this->db->order_by("evaluaciones.id", "desc"); 
		$query = $this->db->get();
		return $query->result();
	}

	function get_ue($usr,$eval){
		$this->db->where("id_usuarios",$usr);
		$this->db->where("id_evaluacion",$eval);
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get('evaluaciones');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('evaluaciones', $data); 
	}

	function ingresar($data){
		$this->db->insert('evaluaciones',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('evaluaciones', array('id' => $id)); 
	}
	function manual($str){
		$query = $this->db->query($str);
		// $data['id'] = $this->db->insert_id();
		// if($data['error'] = $this->db->_error_message());
		// return $data;
	}
	function select_manual($str){
		$query = $this->db->query($str);
		return $query->row();
	}
	
	function total(){
		return $this->db->count_all_results('evaluaciones');
	}

	function primera_evaluacion(){
		$this->db->select_min("fecha_e");
		$query = $this->db->get('evaluaciones');
		return $query->row();
	}
	
	function ultima_evaluacion(){
		$this->db->select_max("fecha_e");
		$query = $this->db->get('evaluaciones');
		return $query->row();	
	}
	
	//-------------------------------------------------------------------------------------------------------------
	
	function filtro_test($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$tipo);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->db->limit($por_pagina,$segment);
		}
		$this->db->where("u.id_tipo_usuarios",2);
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function total_filtro_test($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$tipo);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->db->where("u.id_tipo_usuarios",2);
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function filtro_test_vigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$tipo);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->db->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		
		if($por_pagina || $segment){
			$this->db->limit($por_pagina,$segment);
		}
		$this->db->where("u.id_tipo_usuarios",2);
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function total_filtro_test_vigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$tipo);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->db->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		
		$this->db->where("u.id_tipo_usuarios",2);
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		return $query->num_rows();
	}


	function filtro_test_novigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$tipo);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		//$this->db->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		$this->db->where("e.fecha_v BETWEEN '0000-00-00' AND '". date("Y-m-d")."'");
		
		if($por_pagina || $segment){
			$this->db->limit($por_pagina,$segment);
		}
		$this->db->where("u.id_tipo_usuarios",2);
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function total_filtro_test_novigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$tipo);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->db->where("e.fecha_v BETWEEN '0000-00-00' AND '". date("Y-m-d")."'");
		
		$this->db->where("u.id_tipo_usuarios",2);
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function filtro_test_sinevaluacion($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "u.rut_usuario as rut,u.nombres,u.paterno,u.materno, u.id as id_usr";
		$sql = "SELECT ".$select." FROM usuarios u WHERE u.id NOT IN( SELECT e.id_usuarios FROM evaluaciones e JOIN evaluaciones_evaluacion ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo et ON et.id = ee.id_tipo WHERE et.id = $tipo ) ";
		$sql.= "AND u.id_tipo_usuarios = 2 ";
		if($nombre){
			$sql.= "AND u.nombres LIKE '%$nombre%' ";
			$sql.= "OR u.paterno LIKE '%$nombre%' ";
			$sql.= "OR u.materno LIKE '%$nombre%' ";
		}
		
		if($rut){
			$sql.= "AND u.rut_usuario LIKE '%$rut%' ";
		}
		
		if($planta){
			$sql.= "AND ep.id = $planta ";
		}
		
		if($n_tipo){
			$sql.= "AND ee.id = $n_tipo ";
		}
		
		if($fecha_e1 && $fecha_e2){
			$sql.= "AND e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2' ";
		}
		
		$sql .= 'GROUP BY u.rut_usuario ORDER BY u.id ASC ';
		
		if($por_pagina || $segment){
			$sql.= "LIMIT $segment, $por_pagina ";
		}
	
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		return $query->result();
	}

	function total_filtro_test_sinevaluacion($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "u.rut_usuario as rut,u.nombres,u.paterno,u.materno";
		$sql = "SELECT ".$select." FROM usuarios u WHERE u.id NOT IN( SELECT e.id_usuarios FROM evaluaciones e JOIN evaluaciones_evaluacion ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo et ON et.id = ee.id_tipo WHERE et.id = $tipo ) ";
		$sql.= "AND u.id_tipo_usuarios = 2 ";
		if($nombre){
			$sql.= "AND u.nombres LIKE '%$nombre%' ";
			$sql.= "OR u.paterno LIKE '%$nombre%' ";
			$sql.= "OR u.materno LIKE '%$nombre%' ";
		}
		
		if($rut){
			$sql.= "AND u.rut_usuario LIKE '%$rut%' ";
		}
		
		if($planta){
			$sql.= "AND ep.id = $planta ";
		}
		
		if($n_tipo){
			$sql.= "AND ee.id = $n_tipo ";
		}
		
		if($fecha_e1 && $fecha_e2){
			$sql.= "AND e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2' ";
		}
		
		$sql .= 'GROUP BY u.rut_usuario ORDER BY u.id ASC ';
		
		if( @$por_pagina || @$segment){
			$sql.= "LIMIT $segment, $por_pagina ";
		}

		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function filtro_test_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.id as id_usr,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,et.id as id_tipo,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->db->select($select);
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios','left');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion','left');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		//$this->db->where('et.id',$tipo);
		$this->db->where('u.id_tipo_usuarios',2);
		
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		
		if($rut){
			$this->db->like("u.rut_usuario",$rut);
		}
		
		if($planta){
			$this->db->where("ep.id",$planta);
		}
		
		if($n_tipo){
			$this->db->where("ee.id",$n_tipo);
		}
		
		if($fecha_e1 && $fecha_e2){
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
		}
		
		$this->db->order_by('u.id ASC');
		
		if($por_pagina || $segment){
			$this->db->limit($por_pagina,$segment);
		}
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function total_filtro_test_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.id as id_usr,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,et.id as id_tipo,ee.nombre as n_eval";
		$this->db->from('usuarios AS u');
		$this->db->join('evaluaciones AS e', 'u.id = e.id_usuarios','left');
		$this->db->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion','left');
		$this->db->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		//$this->db->where("et.id",$tipo);
		$this->db->where('u.id_tipo_usuarios',2);
		if($nombre){
			$this->db->like("u.nombres",$nombre);
			$this->db->or_like("u.paterno",$nombre);
			$this->db->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->db->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->db->where("ep.id",$planta);
		
		if($n_tipo)
			$this->db->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->db->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->db->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->db->order_by('u.id ASC');
		$this->db->select($select);
		$this->db->group_by('u.rut_usuario');
		$query = $this->db->get();
		return $query->num_rows();
	}

	function ob_usuario($id_usr,$id_tipo){
		$this->db->select('*, e.id as id_evaluacion, ee.nombre as nombre_examen, ee.id as id_examen, et.nombre as nombre_tipo, et.id as id_tipo');
		$this->db->from('evaluaciones e');
		$this->db->join('usuarios u', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("et.id",$id_tipo);
		$this->db->where("e.id_usuarios",$id_usr);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	
	function get_evaluacion($id){
		$this->db->select('*, e.id as id_evaluacion, ep.nombre as nombre_planta, ee.nombre as nombre_examen');
		$this->db->from('evaluaciones e');
		$this->db->join('usuarios u', 'u.id = e.id_usuarios');
		$this->db->join('empresa_planta ep', 'e.id_planta = ep.id', 'left');
		$this->db->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion');
		$this->db->join('evaluaciones_tipo et', 'et.id = ee.id_tipo','left');
		$this->db->join('evaluaciones_archivo ea', 'e.id = ea.id_evaluacion', 'left');
		$this->db->where("e.id",$id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->row();
	}

	function cancelarNotificacion($id){
		$this->general->set('notificado',1);
		$this->general->where('id',$id);
		$this->general->update('usuarios');
	}
}
