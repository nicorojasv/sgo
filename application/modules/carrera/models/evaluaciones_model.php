<?php
class Evaluaciones_model extends CI_Model {
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	function ultimo_id_eval(){
		$this->carrera->select('id');
		$this->carrera->order_by('id','desc');
		$this->carrera->limit(1);
		$query = $this->carrera->get('evaluaciones');

     	if( is_null($query->row('id')) ) $folio = 0;
     	else $folio = (int)$query->row('id');

     	return $folio + 1;
	}

	function listar($por_pagina = FALSE,$segment = FALSE){
		if($por_pagina){
			$this->carrera->limit($por_pagina,$segment);
		}
		$this->carrera->order_by('id ASC');
		$query = $this->carrera->get('evaluaciones');
		return $query->result();
	}
	
	function listar_usuario($id_usr){
		$this->carrera->where("id_usuarios",$id_usr);
		$this->carrera->order_by("id", "desc"); 
		$query = $this->carrera->get('evaluaciones');
		return $query->result();
	}

	function listar_trabajadores_cc_planta_segun_eval($id_planta, $id_tipo_eval, $estado_examen = FALSE){
		$this->carrera->select('id_usuarios as usuario_id');
		$this->carrera->from('evaluaciones');

		if($id_planta == "terceros"){
			$this->carrera->where('pago', 1);
		}elseif ($id_planta == "sin_cc"){
			$this->carrera->where('pago', 0);
			$this->carrera->where('ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->carrera->where('ccosto', $id_planta);
		}

		if($estado_examen == "no_cobrados")
			$this->carrera->where('estado_cobro', 0);
		elseif($estado_examen == "cobrados")
			$this->carrera->where('estado_cobro', 1);
		elseif($estado_examen == "no_informados")
			$this->carrera->where('estado_cobro', 2);

		$this->carrera->where('id_evaluacion', $id_tipo_eval);
		$this->carrera->where('fecha_e >=', '2014-01-01');
		$this->carrera->group_by('id_usuarios');
		$query = $this->carrera->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta($id_planta){
		$this->carrera->select('id_usuarios as usuario_id');
		$this->carrera->from('evaluaciones');
		$this->carrera->where('ccosto', $id_planta);
		$this->carrera->group_by('id_usuarios');
		$query = $this->carrera->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta_todos(){
		$this->carrera->select('id_usuarios as usuario_id');
		$this->carrera->from('evaluaciones');
		$this->carrera->where('id_evaluacion', 3);
		$this->carrera->or_where('id_evaluacion', 4);
		$this->carrera->group_by('id_usuarios');
		$query = $this->carrera->get();
		return $query->result();
	}

	function filtro($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$tipo);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->carrera->limit($por_pagina,$segment);
		}
		$this->carrera->where("u.id_tipo_usuarios",2);
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
	}

	function filtro_vigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->carrera->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->carrera->limit($por_pagina,$segment);
		}
		
		$this->carrera->where("et.id",$tipo);
		$this->carrera->where("u.id_tipo_usuarios",2);
		
		$this->carrera->where("e.fecha_v >", date("Y-m-d") );
		$this->carrera->or_where("e.fecha_v", '0000-00-00' );
		
		
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
	}

	function filtro_novigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->carrera->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->carrera->limit($por_pagina,$segment);
		}
		
		$this->carrera->where("et.id",$tipo);
		$this->carrera->where("u.id_tipo_usuarios",2);
		
		$this->carrera->where("e.fecha_v <", date("Y-m-d") );
		$this->carrera->where("e.fecha_v >", '0000-00-00' );
		
		
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
	}

	function total_filtro($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$tipo);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->carrera->where("u.id_tipo_usuarios",2);
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		return $query->num_rows();
	}

	function total_filtro_vigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->carrera->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
			
		$this->carrera->where("et.id",$tipo);
		$this->carrera->where("u.id_tipo_usuarios",2);
		
		$this->carrera->where("e.fecha_v >", date("Y-m-d") );
		
		$this->carrera->or_where("e.fecha_v", '0000-00-00' );
		
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->num_rows();
	}

	function total_filtro_novigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->carrera->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->carrera->where("et.id",$tipo);
		$this->carrera->where("u.id_tipo_usuarios",2);
		
		$this->carrera->where("e.fecha_v <", date("Y-m-d") );
		$this->carrera->where("e.fecha_v >", '0000-00-00' );
		
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->num_rows();
	}

	function actualizar_estado_ultima_evaluacion($id_usuario, $id_evaluacion, $datos){
		$this->carrera->where('id_usuarios', $id_usuario);
		$this->carrera->where('id_evaluacion', $id_evaluacion);
		$this->carrera->update('evaluaciones', $datos); 
	}

	function actualizar_estado_ultimo_ex_conocimiento($id_usuario){
		$this->carrera->set('ev.estado_ultima_evaluacion', 0);
		$this->carrera->where('ev.id_usuarios', $id_usuario);
		$this->carrera->where('ev_eval.id_tipo', 3);
		$this->carrera->where('ev.id_evaluacion = ev_eval.id');
		$this->carrera->update('evaluaciones ev, evaluaciones_evaluacion ev_eval');
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
		
		//$this->carrera->from('usuarios AS u');
		//$this->carrera->where('NOT EXISTS( SELECT * FROM evaluaciones AS e JOIN evaluaciones_evaluacion AS ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo AS et ON ee.id_tipo = et.id )');
		// $this->carrera->join('evaluaciones AS e','e.id_usuarios = u.id');
		// $this->carrera->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		// $this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		// $this->carrera->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		// $this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		// if($nombre){
			// $this->carrera->like("u.nombres",$nombre);
			// $this->carrera->or_like("u.paterno",$nombre);
			// $this->carrera->or_like("u.materno",$nombre);
		// }
		// if($rut){
			// $this->carrera->like("u.rut_usuario",$rut);
		// }
		
		// if($planta){
			// $this->carrera->where("ep.id",$planta);
		// }
		
		// if($n_tipo){
			// $this->carrera->where("ee.id",$n_tipo);
		// }
		
		// if($fecha_e1 && $fecha_e2){
			// $this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			// //$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		// }
// 		
		// if($por_pagina || $segment){
			// $this->carrera->limit($por_pagina,$segment);
		// }
		
		//$this->carrera->where("et.id",$tipo);
		//$this->carrera->where("u.id_tipo_usuarios",2);
		
		//$this->carrera->order_by('u.id ASC');
		//$this->carrera->select($select);
		$query = $this->carrera->query($sql);
		//echo $this->carrera->last_query();
		return $query->result();
	}

	function total_filtro_sinevaluacion($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		// $select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		// $this->carrera->from('usuarios AS u');
		// $this->carrera->where(' NOT EXISTS( SELECT * FROM evaluaciones AS e JOIN evaluaciones_evaluacion AS ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo AS et ON ee.id_tipo = et.id )');
		// $this->carrera->join('evaluaciones AS e','e.id_usuarios = u.id');
		// $this->carrera->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		// $this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		// $this->carrera->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		// $this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
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
			// $this->carrera->like("u.nombres",$nombre);
			// $this->carrera->or_like("u.paterno",$nombre);
			// $this->carrera->or_like("u.materno",$nombre);
		// }
		// if($rut){
			// $this->carrera->like("u.rut_usuario",$rut);
		// }
// 		
		// if($planta){
			// $this->carrera->where("ep.id",$planta);
		// }
// 		
		// if($n_tipo){
			// $this->carrera->where("ee.id",$n_tipo);
		// }
// 		
		// if($fecha_e1 && $fecha_e2){
			// $this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			// //$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		// }
		
		// $this->carrera->where("et.id",$tipo);
		// $this->carrera->where("u.id_tipo_usuarios",2);
// 		
		// $this->carrera->order_by('u.id ASC');
		// $this->carrera->select($select);
		// $query = $this->carrera->get();
		$sql .= 'ORDER BY u.id ASC';
		$query = $this->carrera->query($sql);
		//echo $this->carrera->last_query();
		return $query->num_rows();
	}
	
	function filtro_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->carrera->select($select);
		$this->carrera->from('usuarios u');
		$this->carrera->join('evaluaciones e', 'e.id_usuarios = u.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion ee', 'e.id_evaluacion = ee.id', 'left');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where('et.id',$tipo);
		$this->carrera->where('u.id_tipo_usuarios',2);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		
		if($rut){
			$this->carrera->like("u.rut_usuario",$rut);
		}
		
		if($planta){
			$this->carrera->where("ep.id",$planta);
		}
		
		if($n_tipo){
			$this->carrera->where("ee.id",$n_tipo);
		}
		
		if($fecha_e1 && $fecha_e2){
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
		}
		
		$this->carrera->order_by('u.id ASC');
		
		if($por_pagina || $segment){
			$this->carrera->limit($por_pagina,$segment);
		}
		
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
		
	}
	
	function total_filtro_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->carrera->select($select);
		$this->carrera->from('usuarios u');
		$this->carrera->join('evaluaciones e', 'e.id_usuarios = u.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion ee', 'e.id_evaluacion = ee.id', 'left');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where('et.id',$tipo);
		$this->carrera->where('u.id_tipo_usuarios',2);
		
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
		
		$this->carrera->order_by('u.id ASC');
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->num_rows();
	}

	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('evaluaciones');
		return $query->row();
	}

	function get_all($id){
		$this->carrera->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->carrera->join('(SELECT * FROM evaluaciones_archivo ev1 WHERE id = (SELECT MAX(id) FROM evaluaciones_archivo WHERE id_evaluacion = ev1.id_evaluacion GROUP BY id_evaluacion) ORDER BY id DESC) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_all_tipo($id_tipo){
		$this->carrera->select('*');
		$this->carrera->from('evaluaciones_evaluacion');
		$this->carrera->where('id_tipo', $id_tipo);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_all_masso2($id, $id_planta = FALSE, $estado_examen = FALSE){
		$this->carrera->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->carrera->join('(select * from evaluaciones_archivo group by id_evaluacion order by id asc ) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',4);
		
		if($id_planta == "terceros"){
			$this->carrera->where('evaluaciones.pago', 1);
		}elseif($id_planta == "sin_cc"){
			$this->carrera->where('evaluaciones.pago', 0);
			$this->carrera->where('evaluaciones.ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->carrera->where('evaluaciones.ccosto',$id_planta);
		}
		
		if($estado_examen == "no_cobrados")
			$this->carrera->where('evaluaciones.estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->carrera->where('evaluaciones.estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->carrera->where('evaluaciones.estado_cobro', 2);

		$this->carrera->where('fecha_e >=', '2014-01-01');
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_all_masso_todas_plantas($id, $estado_examen = FALSE){
		$this->carrera->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->carrera->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',4);

		if($estado_examen == "no_cobrados")
			$this->carrera->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->carrera->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->carrera->where('estado_cobro', 2);

		$query = $this->carrera->get();
		return $query->result();
	}

	function get_all_preo2($id, $id_planta = FALSE, $estado_examen = FALSE){
		$this->carrera->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->carrera->join('(select * from evaluaciones_archivo group by id_evaluacion order by id asc ) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',3);
		
		if($id_planta == "terceros"){
			$this->carrera->where('evaluaciones.pago', 1);
		}elseif ($id_planta == "sin_cc"){
			$this->carrera->where('evaluaciones.pago', 0);
			$this->carrera->where('evaluaciones.ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->carrera->where('evaluaciones.ccosto',$id_planta);
		}

		if($estado_examen == "no_cobrados")
			$this->carrera->where('evaluaciones.estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->carrera->where('evaluaciones.estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->carrera->where('evaluaciones.estado_cobro', 2);

		$this->carrera->where('fecha_e >=', '2014-01-01');
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_all_preo_todas_plantas($id, $estado_examen = FALSE){
		$this->carrera->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->carrera->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',3);

		if($estado_examen == "no_cobrados")
			$this->carrera->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->carrera->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->carrera->where('estado_cobro', 2);


		$query = $this->carrera->get();
		return $query->result();
	}

	function get_desepeno($id){
		$this->carrera->select('*,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_tipo.nombre',"DESEMPEÑO");
		$this->carrera->group_by('evaluaciones_evaluacion.id');
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_eval($id){
		$this->carrera->where('id_evaluacion',$id);
		$query = $this->carrera->get('evaluaciones');
		return $query->result();
	}

	function get_eval_id($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('evaluaciones');
		return $query->result();
	}

	function get_evaluacion_result($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('evaluaciones');
		return $query->result();
	}

	function get_eval_user($id,$user){
		$this->carrera->where('id_evaluacion',$id);
		$this->carrera->where('id_usuarios',$user);
		$query = $this->carrera->get('evaluaciones');
		//echo $this->carrera->last_query(); 
		return $query->result();
	}
	
	function get_una_masso($id){
		$this->carrera->select('*');
		$this->carrera->select('evaluaciones.id as id_masso');
		$this->carrera->select('DATEDIFF(evaluaciones.fecha_v,now()) as estado_masso');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',4);
		$this->carrera->order_by("evaluaciones.id", "desc");
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_una_masso_requerimiento($id, $fecha_inicio_req, $fecha_vigencia_req){
		$this->carrera->select('*');
		$this->carrera->select('DATEDIFF(evaluaciones.fecha_v, ("'.$fecha_inicio_req.'")) as estado_inicio_masso');
		$this->carrera->select('DATEDIFF(evaluaciones.fecha_v, ("'.$fecha_vigencia_req.'")) as estado_fin_masso');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',4);
		$this->carrera->order_by("evaluaciones.id", "desc"); 
		$query = $this->carrera->get();
		return $query->row();
	}

	function not_all($id){
		$this->carrera->select('e.fecha_v, e.resultado, ee.nombre');
		$this->carrera->from('evaluaciones e');
		$this->carrera->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion', 'inner');
		$this->carrera->where('e.id_usuarios',$id);
		$this->carrera->where("DATE(e.fecha_v) > '0000-00-00'");
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_una_preocupacional($id){
		$this->carrera->select('*');
		$this->carrera->select('evaluaciones.id as preo_id');
		$this->carrera->select('DATEDIFF(evaluaciones.fecha_v,now()) as estado_preo');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',3);
		$this->carrera->order_by("evaluaciones.id", "desc"); 
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_una_preocupacional_requerimiento($id, $fecha_inicio_req, $fecha_vigencia_req){
		$this->carrera->select('*');
		$this->carrera->select('DATEDIFF(evaluaciones.fecha_e, ("'.$fecha_inicio_req.'")) as estado_inicio_preo');
		$this->carrera->select('DATEDIFF(evaluaciones.fecha_e, ("'.$fecha_vigencia_req.'")) as estado_fin_preo');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',3);
		$this->carrera->order_by("evaluaciones.id", "desc");
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_all_desepeno($id){
		$this->carrera->select('*');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',5); //solo preocupacional 1.0 id 5
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_all_preo($id){
		$this->carrera->select('*');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',3); //solo preocupacional 1.0 id 5
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_all_conocimiento($id){
		$this->carrera->select('*');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_tipo.nombre','CONOCIMIENTO'); 
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_all_masso($id){
		$this->carrera->select('*');
		$this->carrera->from('evaluaciones');
		$this->carrera->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->carrera->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->carrera->where('evaluaciones.id_usuarios',$id);
		$this->carrera->where('evaluaciones_evaluacion.id',4); //solo masso id 4
		$this->carrera->order_by("evaluaciones.id", "desc"); 
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_ue($usr,$eval){
		$this->carrera->where("id_usuarios",$usr);
		$this->carrera->where("id_evaluacion",$eval);
		$this->carrera->order_by("id", "desc"); 
		$query = $this->carrera->get('evaluaciones');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('evaluaciones', $data); 
	}

	function ingresar($data){
		$this->carrera->insert('evaluaciones',$data); 
		return $this->carrera->insert_id();
	}
	
	function eliminar($id){
		$this->carrera->delete('evaluaciones', array('id' => $id)); 
	}
	function manual($str){
		$query = $this->carrera->query($str);
		// $data['id'] = $this->carrera->insert_id();
		// if($data['error'] = $this->carrera->_error_message());
		// return $data;
	}
	function select_manual($str){
		$query = $this->carrera->query($str);
		return $query->row();
	}
	
	function total(){
		return $this->carrera->count_all_results('evaluaciones');
	}

	function primera_evaluacion(){
		$this->carrera->select_min("fecha_e");
		$query = $this->carrera->get('evaluaciones');
		return $query->row();
	}
	
	function ultima_evaluacion(){
		$this->carrera->select_max("fecha_e");
		$query = $this->carrera->get('evaluaciones');
		return $query->row();	
	}
	
	//-------------------------------------------------------------------------------------------------------------
	
	function filtro_test($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$tipo);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->carrera->limit($por_pagina,$segment);
		}
		$this->carrera->where("u.id_tipo_usuarios",2);
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
	}

	function total_filtro_test($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$tipo);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->carrera->where("u.id_tipo_usuarios",2);
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		return $query->num_rows();
	}

	function filtro_test_vigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$tipo);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->carrera->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		
		if($por_pagina || $segment){
			$this->carrera->limit($por_pagina,$segment);
		}
		$this->carrera->where("u.id_tipo_usuarios",2);
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
	}

	function total_filtro_test_vigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$tipo);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->carrera->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		
		$this->carrera->where("u.id_tipo_usuarios",2);
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		return $query->num_rows();
	}


	function filtro_test_novigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$tipo);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		//$this->carrera->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		$this->carrera->where("e.fecha_v BETWEEN '0000-00-00' AND '". date("Y-m-d")."'");
		
		if($por_pagina || $segment){
			$this->carrera->limit($por_pagina,$segment);
		}
		$this->carrera->where("u.id_tipo_usuarios",2);
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
	}

	function total_filtro_test_novigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$tipo);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->carrera->where("e.fecha_v BETWEEN '0000-00-00' AND '". date("Y-m-d")."'");
		
		$this->carrera->where("u.id_tipo_usuarios",2);
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
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
	
		$query = $this->carrera->query($sql);
		//echo $this->carrera->last_query();
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

		$query = $this->carrera->query($sql);
		return $query->num_rows();
	}
	
	function filtro_test_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.id as id_usr,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,et.id as id_tipo,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->carrera->select($select);
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios','left');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion','left');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		//$this->carrera->where('et.id',$tipo);
		$this->carrera->where('u.id_tipo_usuarios',2);
		
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		
		if($rut){
			$this->carrera->like("u.rut_usuario",$rut);
		}
		
		if($planta){
			$this->carrera->where("ep.id",$planta);
		}
		
		if($n_tipo){
			$this->carrera->where("ee.id",$n_tipo);
		}
		
		if($fecha_e1 && $fecha_e2){
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
		}
		
		$this->carrera->order_by('u.id ASC');
		
		if($por_pagina || $segment){
			$this->carrera->limit($por_pagina,$segment);
		}
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
	}

	function total_filtro_test_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.id as id_usr,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,et.id as id_tipo,ee.nombre as n_eval";
		$this->carrera->from('usuarios AS u');
		$this->carrera->join('evaluaciones AS e', 'u.id = e.id_usuarios','left');
		$this->carrera->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion','left');
		$this->carrera->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		//$this->carrera->where("et.id",$tipo);
		$this->carrera->where('u.id_tipo_usuarios',2);
		if($nombre){
			$this->carrera->like("u.nombres",$nombre);
			$this->carrera->or_like("u.paterno",$nombre);
			$this->carrera->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->carrera->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->carrera->where("ep.id",$planta);
		
		if($n_tipo)
			$this->carrera->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->carrera->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->carrera->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->carrera->order_by('u.id ASC');
		$this->carrera->select($select);
		$this->carrera->group_by('u.rut_usuario');
		$query = $this->carrera->get();
		return $query->num_rows();
	}

	function ob_usuario($id_usr,$id_tipo){
		$this->carrera->select('*, e.id as id_evaluacion, ee.nombre as nombre_examen, ee.id as id_examen, et.nombre as nombre_tipo, et.id as id_tipo');
		$this->carrera->from('evaluaciones e');
		$this->carrera->join('usuarios u', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("et.id",$id_tipo);
		$this->carrera->where("e.id_usuarios",$id_usr);
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->result();
	}
	
	function get_evaluacion($id){
		$this->carrera->select('*, e.id as id_evaluacion, ep.nombre as nombre_planta, ee.nombre as nombre_examen');
		$this->carrera->from('evaluaciones e');
		$this->carrera->join('usuarios u', 'u.id = e.id_usuarios');
		$this->carrera->join('empresa_planta ep', 'e.id_planta = ep.id', 'left');
		$this->carrera->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion');
		$this->carrera->join('evaluaciones_tipo et', 'et.id = ee.id_tipo','left');
		$this->carrera->join('evaluaciones_archivo ea', 'e.id = ea.id_evaluacion', 'left');
		$this->carrera->where("e.id",$id);
		$query = $this->carrera->get();
		//echo $this->carrera->last_query();
		return $query->row();
	}

	function cancelarNotificacion($id){
		$this->carrera->set('notificado',1);
		$this->carrera->where('id',$id);
		$this->carrera->update('usuarios');
	}


	
}
