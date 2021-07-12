<?php
class Evaluaciones_model extends CI_Model {
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}
	function ultimo_id_eval(){
		$this->wood->select('id');
		$this->wood->order_by('id','desc');
		$this->wood->limit(1);
		$query = $this->wood->get('evaluaciones');

     	if( is_null($query->row('id')) ) $folio = 0;
     	else $folio = (int)$query->row('id');

     	return $folio + 1;
	}

	function listar($por_pagina = FALSE,$segment = FALSE){
		if($por_pagina){
			$this->wood->limit($por_pagina,$segment);
		}
		$this->wood->order_by('id ASC');
		$query = $this->wood->get('evaluaciones');
		return $query->result();
	}
	
	function listar_usuario($id_usr){
		$this->wood->where("id_usuarios",$id_usr);
		$this->wood->order_by("id", "desc"); 
		$query = $this->wood->get('evaluaciones');
		return $query->result();
	}

	function listar_trabajadores_cc_planta_segun_eval($id_planta, $id_tipo_eval, $estado_examen = FALSE){
		$this->wood->select('id_usuarios as usuario_id');
		$this->wood->from('evaluaciones');

		if($id_planta == "terceros"){
			$this->wood->where('pago', 1);
		}elseif ($id_planta == "sin_cc"){
			$this->wood->where('pago', 0);
			$this->wood->where('ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->wood->where('ccosto', $id_planta);
		}

		if($estado_examen == "no_cobrados")
			$this->wood->where('estado_cobro', 0);
		elseif($estado_examen == "cobrados")
			$this->wood->where('estado_cobro', 1);
		elseif($estado_examen == "no_informados")
			$this->wood->where('estado_cobro', 2);

		$this->wood->where('id_evaluacion', $id_tipo_eval);
		$this->wood->where('fecha_e >=', '2014-01-01');
		$this->wood->group_by('id_usuarios');
		$query = $this->wood->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta($id_planta){
		$this->wood->select('id_usuarios as usuario_id');
		$this->wood->from('evaluaciones');
		$this->wood->where('ccosto', $id_planta);
		$this->wood->group_by('id_usuarios');
		$query = $this->wood->get();
		return $query->result();
	}

	function listar_trabajadores_cc_planta_todos(){
		$this->wood->select('id_usuarios as usuario_id');
		$this->wood->from('evaluaciones');
		$this->wood->where('id_evaluacion', 3);
		$this->wood->or_where('id_evaluacion', 4);
		$this->wood->group_by('id_usuarios');
		$query = $this->wood->get();
		return $query->result();
	}

	function filtro($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$tipo);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->wood->limit($por_pagina,$segment);
		}
		$this->wood->where("u.id_tipo_usuarios",2);
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
	}

	function filtro_vigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->wood->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->wood->limit($por_pagina,$segment);
		}
		
		$this->wood->where("et.id",$tipo);
		$this->wood->where("u.id_tipo_usuarios",2);
		
		$this->wood->where("e.fecha_v >", date("Y-m-d") );
		$this->wood->or_where("e.fecha_v", '0000-00-00' );
		
		
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
	}

	function filtro_novigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->wood->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->wood->limit($por_pagina,$segment);
		}
		
		$this->wood->where("et.id",$tipo);
		$this->wood->where("u.id_tipo_usuarios",2);
		
		$this->wood->where("e.fecha_v <", date("Y-m-d") );
		$this->wood->where("e.fecha_v >", '0000-00-00' );
		
		
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
	}

	function total_filtro($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$tipo);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->wood->where("u.id_tipo_usuarios",2);
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		return $query->num_rows();
	}

	function total_filtro_vigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->wood->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
			
		$this->wood->where("et.id",$tipo);
		$this->wood->where("u.id_tipo_usuarios",2);
		
		$this->wood->where("e.fecha_v >", date("Y-m-d") );
		
		$this->wood->or_where("e.fecha_v", '0000-00-00' );
		
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->num_rows();
	}

	function total_filtro_novigentes($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e','e.id_usuarios = u.id');
		$this->wood->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->wood->where("et.id",$tipo);
		$this->wood->where("u.id_tipo_usuarios",2);
		
		$this->wood->where("e.fecha_v <", date("Y-m-d") );
		$this->wood->where("e.fecha_v >", '0000-00-00' );
		
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->num_rows();
	}

	function actualizar_estado_ultima_evaluacion($id_usuario, $id_evaluacion, $datos){
		$this->wood->where('id_usuarios', $id_usuario);
		$this->wood->where('id_evaluacion', $id_evaluacion);
		$this->wood->update('evaluaciones', $datos); 
	}

	function actualizar_estado_ultimo_ex_conocimiento($id_usuario){
		$this->wood->set('ev.estado_ultima_evaluacion', 0);
		$this->wood->where('ev.id_usuarios', $id_usuario);
		$this->wood->where('ev_eval.id_tipo', 3);
		$this->wood->where('ev.id_evaluacion = ev_eval.id');
		$this->wood->update('evaluaciones ev, evaluaciones_evaluacion ev_eval');
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
		
		//$this->wood->from('usuarios AS u');
		//$this->wood->where('NOT EXISTS( SELECT * FROM evaluaciones AS e JOIN evaluaciones_evaluacion AS ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo AS et ON ee.id_tipo = et.id )');
		// $this->wood->join('evaluaciones AS e','e.id_usuarios = u.id');
		// $this->wood->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		// $this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		// $this->wood->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		// $this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		
		// if($nombre){
			// $this->wood->like("u.nombres",$nombre);
			// $this->wood->or_like("u.paterno",$nombre);
			// $this->wood->or_like("u.materno",$nombre);
		// }
		// if($rut){
			// $this->wood->like("u.rut_usuario",$rut);
		// }
		
		// if($planta){
			// $this->wood->where("ep.id",$planta);
		// }
		
		// if($n_tipo){
			// $this->wood->where("ee.id",$n_tipo);
		// }
		
		// if($fecha_e1 && $fecha_e2){
			// $this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			// //$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		// }
// 		
		// if($por_pagina || $segment){
			// $this->wood->limit($por_pagina,$segment);
		// }
		
		//$this->wood->where("et.id",$tipo);
		//$this->wood->where("u.id_tipo_usuarios",2);
		
		//$this->wood->order_by('u.id ASC');
		//$this->wood->select($select);
		$query = $this->wood->query($sql);
		//echo $this->wood->last_query();
		return $query->result();
	}

	function total_filtro_sinevaluacion($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		// $select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		// $this->wood->from('usuarios AS u');
		// $this->wood->where(' NOT EXISTS( SELECT * FROM evaluaciones AS e JOIN evaluaciones_evaluacion AS ee ON ee.id = e.id_evaluacion JOIN evaluaciones_tipo AS et ON ee.id_tipo = et.id )');
		// $this->wood->join('evaluaciones AS e','e.id_usuarios = u.id');
		// $this->wood->join('evaluaciones_evaluacion AS ee','ee.id = e.id_evaluacion');
		// $this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		// $this->wood->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		// $this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
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
			// $this->wood->like("u.nombres",$nombre);
			// $this->wood->or_like("u.paterno",$nombre);
			// $this->wood->or_like("u.materno",$nombre);
		// }
		// if($rut){
			// $this->wood->like("u.rut_usuario",$rut);
		// }
// 		
		// if($planta){
			// $this->wood->where("ep.id",$planta);
		// }
// 		
		// if($n_tipo){
			// $this->wood->where("ee.id",$n_tipo);
		// }
// 		
		// if($fecha_e1 && $fecha_e2){
			// $this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			// //$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		// }
		
		// $this->wood->where("et.id",$tipo);
		// $this->wood->where("u.id_tipo_usuarios",2);
// 		
		// $this->wood->order_by('u.id ASC');
		// $this->wood->select($select);
		// $query = $this->wood->get();
		$sql .= 'ORDER BY u.id ASC';
		$query = $this->wood->query($sql);
		//echo $this->wood->last_query();
		return $query->num_rows();
	}
	
	function filtro_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->wood->select($select);
		$this->wood->from('usuarios u');
		$this->wood->join('evaluaciones e', 'e.id_usuarios = u.id', 'left');
		$this->wood->join('evaluaciones_evaluacion ee', 'e.id_evaluacion = ee.id', 'left');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where('et.id',$tipo);
		$this->wood->where('u.id_tipo_usuarios',2);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		
		if($rut){
			$this->wood->like("u.rut_usuario",$rut);
		}
		
		if($planta){
			$this->wood->where("ep.id",$planta);
		}
		
		if($n_tipo){
			$this->wood->where("ee.id",$n_tipo);
		}
		
		if($fecha_e1 && $fecha_e2){
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
		}
		
		$this->wood->order_by('u.id ASC');
		
		if($por_pagina || $segment){
			$this->wood->limit($por_pagina,$segment);
		}
		
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
		
	}
	
	function total_filtro_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->wood->select($select);
		$this->wood->from('usuarios u');
		$this->wood->join('evaluaciones e', 'e.id_usuarios = u.id', 'left');
		$this->wood->join('evaluaciones_evaluacion ee', 'e.id_evaluacion = ee.id', 'left');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_tipo AS et','et.id = ee.id_tipo');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where('et.id',$tipo);
		$this->wood->where('u.id_tipo_usuarios',2);
		
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
		
		$this->wood->order_by('u.id ASC');
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->num_rows();
	}

	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('evaluaciones');
		return $query->row();
	}

	function get_all($id){
		$this->wood->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->wood->join('(SELECT * FROM evaluaciones_archivo ev1 WHERE id = (SELECT MAX(id) FROM evaluaciones_archivo WHERE id_evaluacion = ev1.id_evaluacion GROUP BY id_evaluacion) ORDER BY id DESC) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_all_tipo($id_tipo){
		$this->wood->select('*');
		$this->wood->from('evaluaciones_evaluacion');
		$this->wood->where('id_tipo', $id_tipo);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_all_masso2($id, $id_planta = FALSE, $estado_examen = FALSE){
		$this->wood->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->wood->join('(select * from evaluaciones_archivo group by id_evaluacion order by id asc ) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',4);
		
		if($id_planta == "terceros"){
			$this->wood->where('evaluaciones.pago', 1);
		}elseif($id_planta == "sin_cc"){
			$this->wood->where('evaluaciones.pago', 0);
			$this->wood->where('evaluaciones.ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->wood->where('evaluaciones.ccosto',$id_planta);
		}
		
		if($estado_examen == "no_cobrados")
			$this->wood->where('evaluaciones.estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->wood->where('evaluaciones.estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->wood->where('evaluaciones.estado_cobro', 2);

		$this->wood->where('fecha_e >=', '2014-01-01');
		$query = $this->wood->get();
		return $query->result();
	}

	function get_all_masso_todas_plantas($id, $estado_examen = FALSE){
		$this->wood->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->wood->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',4);

		if($estado_examen == "no_cobrados")
			$this->wood->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->wood->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->wood->where('estado_cobro', 2);

		$query = $this->wood->get();
		return $query->result();
	}

	function get_all_preo2($id, $id_planta = FALSE, $estado_examen = FALSE){
		$this->wood->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->wood->join('(select * from evaluaciones_archivo group by id_evaluacion order by id asc ) evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',3);
		
		if($id_planta == "terceros"){
			$this->wood->where('evaluaciones.pago', 1);
		}elseif ($id_planta == "sin_cc"){
			$this->wood->where('evaluaciones.pago', 0);
			$this->wood->where('evaluaciones.ccosto', NULL);
		}elseif($id_planta != "todos"){
			$this->wood->where('evaluaciones.ccosto',$id_planta);
		}

		if($estado_examen == "no_cobrados")
			$this->wood->where('evaluaciones.estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->wood->where('evaluaciones.estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->wood->where('evaluaciones.estado_cobro', 2);

		$this->wood->where('fecha_e >=', '2014-01-01');
		$query = $this->wood->get();
		return $query->result();
	}

	function get_all_preo_todas_plantas($id, $estado_examen = FALSE){
		$this->wood->select('*,evaluaciones_tipo.id as id_tipo,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval, evaluaciones.id as id');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->wood->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion','left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',3);

		if($estado_examen == "no_cobrados")
			$this->wood->where('estado_cobro', 0);
		if($estado_examen == "cobrados")
			$this->wood->where('estado_cobro', 1);
		if($estado_examen == "no_informados")
			$this->wood->where('estado_cobro', 2);


		$query = $this->wood->get();
		return $query->result();
	}

	function get_desepeno($id){
		$this->wood->select('*,evaluaciones_tipo.nombre as nombre_tipo,evaluaciones_evaluacion.nombre as nombre_eval, evaluaciones_evaluacion.id as id_eval');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_tipo.nombre',"DESEMPEÑO");
		$this->wood->group_by('evaluaciones_evaluacion.id');
		$query = $this->wood->get();
		return $query->result();
	}

	function get_eval($id){
		$this->wood->where('id_evaluacion',$id);
		$query = $this->wood->get('evaluaciones');
		return $query->result();
	}

	function get_eval_id($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('evaluaciones');
		return $query->result();
	}

	function get_evaluacion_result($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('evaluaciones');
		return $query->result();
	}

	function get_eval_user($id,$user){
		$this->wood->where('id_evaluacion',$id);
		$this->wood->where('id_usuarios',$user);
		$query = $this->wood->get('evaluaciones');
		//echo $this->wood->last_query(); 
		return $query->result();
	}
	
	function get_una_masso($id){
		$this->wood->select('*');
		$this->wood->select('evaluaciones.id as id_masso');
		$this->wood->select('DATEDIFF(evaluaciones.fecha_v,now()) as estado_masso');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',4);
		$this->wood->order_by("evaluaciones.id", "desc");
		$query = $this->wood->get();
		return $query->row();
	}

	function get_una_masso_requerimiento($id, $fecha_inicio_req, $fecha_vigencia_req){
		$this->wood->select('*');
		$this->wood->select('DATEDIFF(evaluaciones.fecha_v, ("'.$fecha_inicio_req.'")) as estado_inicio_masso');
		$this->wood->select('DATEDIFF(evaluaciones.fecha_v, ("'.$fecha_vigencia_req.'")) as estado_fin_masso');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',4);
		$this->wood->order_by("evaluaciones.id", "desc"); 
		$query = $this->wood->get();
		return $query->row();
	}

	function not_all($id){
		$this->wood->select('e.fecha_v, e.resultado, ee.nombre');
		$this->wood->from('evaluaciones e');
		$this->wood->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion', 'inner');
		$this->wood->where('e.id_usuarios',$id);
		$this->wood->where("DATE(e.fecha_v) > '0000-00-00'");
		$query = $this->wood->get();
		return $query->result();
	}

	function get_una_preocupacional($id){
		$this->wood->select('*');
		$this->wood->select('evaluaciones.id as preo_id');
		$this->wood->select('DATEDIFF(evaluaciones.fecha_v,now()) as estado_preo');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',3);
		$this->wood->order_by("evaluaciones.id", "desc"); 
		$query = $this->wood->get();
		return $query->row();
	}

	function get_una_preocupacional_requerimiento($id, $fecha_inicio_req, $fecha_vigencia_req){
		$this->wood->select('*');
		$this->wood->select('DATEDIFF(evaluaciones.fecha_e, ("'.$fecha_inicio_req.'")) as estado_inicio_preo');
		$this->wood->select('DATEDIFF(evaluaciones.fecha_e, ("'.$fecha_vigencia_req.'")) as estado_fin_preo');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',3);
		$this->wood->order_by("evaluaciones.id", "desc");
		$query = $this->wood->get();
		return $query->row();
	}

	function get_all_desepeno($id){
		$this->wood->select('*');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',5); //solo preocupacional 1.0 id 5
		$query = $this->wood->get();
		return $query->result();
	}

	function get_all_preo($id){
		$this->wood->select('*');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',3); //solo preocupacional 1.0 id 5
		$query = $this->wood->get();
		return $query->result();
	}

	function get_all_conocimiento($id){
		$this->wood->select('*');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_tipo', 'evaluaciones_tipo.id = evaluaciones_evaluacion.id_tipo');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_tipo.nombre','CONOCIMIENTO'); 
		$query = $this->wood->get();
		return $query->result();
	}

	function get_all_masso($id){
		$this->wood->select('*');
		$this->wood->from('evaluaciones');
		$this->wood->join('evaluaciones_evaluacion', 'evaluaciones_evaluacion.id = evaluaciones.id_evaluacion');
		$this->wood->join('evaluaciones_archivo', 'evaluaciones.id = evaluaciones_archivo.id_evaluacion', 'left');
		$this->wood->where('evaluaciones.id_usuarios',$id);
		$this->wood->where('evaluaciones_evaluacion.id',4); //solo masso id 4
		$this->wood->order_by("evaluaciones.id", "desc"); 
		$query = $this->wood->get();
		return $query->result();
	}

	function get_ue($usr,$eval){
		$this->wood->where("id_usuarios",$usr);
		$this->wood->where("id_evaluacion",$eval);
		$this->wood->order_by("id", "desc"); 
		$query = $this->wood->get('evaluaciones');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('evaluaciones', $data); 
	}

	function ingresar($data){
		$this->wood->insert('evaluaciones',$data); 
		return $this->wood->insert_id();
	}
	
	function eliminar($id){
		$this->wood->delete('evaluaciones', array('id' => $id)); 
	}
	function manual($str){
		$query = $this->wood->query($str);
		// $data['id'] = $this->wood->insert_id();
		// if($data['error'] = $this->wood->_error_message());
		// return $data;
	}
	function select_manual($str){
		$query = $this->wood->query($str);
		return $query->row();
	}
	
	function total(){
		return $this->wood->count_all_results('evaluaciones');
	}

	function primera_evaluacion(){
		$this->wood->select_min("fecha_e");
		$query = $this->wood->get('evaluaciones');
		return $query->row();
	}
	
	function ultima_evaluacion(){
		$this->wood->select_max("fecha_e");
		$query = $this->wood->get('evaluaciones');
		return $query->row();	
	}
	
	//-------------------------------------------------------------------------------------------------------------
	
	function filtro_test($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$tipo);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		if($por_pagina || $segment){
			$this->wood->limit($por_pagina,$segment);
		}
		$this->wood->where("u.id_tipo_usuarios",2);
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
	}

	function total_filtro_test($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$tipo);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->wood->where("u.id_tipo_usuarios",2);
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		return $query->num_rows();
	}

	function filtro_test_vigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$tipo);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->wood->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		
		if($por_pagina || $segment){
			$this->wood->limit($por_pagina,$segment);
		}
		$this->wood->where("u.id_tipo_usuarios",2);
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
	}

	function total_filtro_test_vigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$tipo);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->wood->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		
		$this->wood->where("u.id_tipo_usuarios",2);
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		return $query->num_rows();
	}


	function filtro_test_novigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$tipo);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		//$this->wood->where("(e.fecha_v > ".date('Y-m-d')." OR e.fecha_v = '0000-00-00')" );
		$this->wood->where("e.fecha_v BETWEEN '0000-00-00' AND '". date("Y-m-d")."'");
		
		if($por_pagina || $segment){
			$this->wood->limit($por_pagina,$segment);
		}
		$this->wood->where("u.id_tipo_usuarios",2);
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
	}

	function total_filtro_test_novigente($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado,u.id as id_usr,et.id as id_tipo";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$tipo);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		$this->wood->where("e.fecha_v BETWEEN '0000-00-00' AND '". date("Y-m-d")."'");
		
		$this->wood->where("u.id_tipo_usuarios",2);
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
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
	
		$query = $this->wood->query($sql);
		//echo $this->wood->last_query();
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

		$query = $this->wood->query($sql);
		return $query->num_rows();
	}
	
	function filtro_test_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false,$por_pagina = FALSE,$segment = FALSE){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.id as id_usr,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,et.id as id_tipo,ee.nombre as n_eval,ea.url as archivo, ee.tipo_resultado as tipo_resultado";
		$this->wood->select($select);
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios','left');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion','left');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		//$this->wood->where('et.id',$tipo);
		$this->wood->where('u.id_tipo_usuarios',2);
		
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		
		if($rut){
			$this->wood->like("u.rut_usuario",$rut);
		}
		
		if($planta){
			$this->wood->where("ep.id",$planta);
		}
		
		if($n_tipo){
			$this->wood->where("ee.id",$n_tipo);
		}
		
		if($fecha_e1 && $fecha_e2){
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
		}
		
		$this->wood->order_by('u.id ASC');
		
		if($por_pagina || $segment){
			$this->wood->limit($por_pagina,$segment);
		}
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
	}

	function total_filtro_test_todo($tipo,$nombre=false,$rut=false,$planta=false,$n_tipo=false,$fecha_e1=false,$fecha_e2=false){
		$select = "e.id,e.fecha_e,e.fecha_v,e.resultado,u.id as id_usr,u.rut_usuario as rut,u.nombres,u.paterno,u.materno,ep.nombre as planta,et.nombre as t_eval,et.id as id_tipo,ee.nombre as n_eval";
		$this->wood->from('usuarios AS u');
		$this->wood->join('evaluaciones AS e', 'u.id = e.id_usuarios','left');
		$this->wood->join('empresa_planta AS ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion AS ee', 'ee.id = e.id_evaluacion','left');
		$this->wood->join('evaluaciones_tipo AS et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo AS ea', 'e.id = ea.id_evaluacion', 'left');
		//$this->wood->where("et.id",$tipo);
		$this->wood->where('u.id_tipo_usuarios',2);
		if($nombre){
			$this->wood->like("u.nombres",$nombre);
			$this->wood->or_like("u.paterno",$nombre);
			$this->wood->or_like("u.materno",$nombre);
		}
		if($rut)
			$this->wood->like("u.rut_usuario",$rut);
		
		if($planta)
			$this->wood->where("ep.id",$planta);
		
		if($n_tipo)
			$this->wood->where("ee.id",$n_tipo);
		
		if($fecha_e1 && $fecha_e2)
			$this->wood->where("e.fecha_e BETWEEN '$fecha_e1' AND '$fecha_e2'");
			//$this->wood->where_between("e.fecha_e",$fecha_e1,$fecha_e2);
		
		$this->wood->order_by('u.id ASC');
		$this->wood->select($select);
		$this->wood->group_by('u.rut_usuario');
		$query = $this->wood->get();
		return $query->num_rows();
	}

	function ob_usuario($id_usr,$id_tipo){
		$this->wood->select('*, e.id as id_evaluacion, ee.nombre as nombre_examen, ee.id as id_examen, et.nombre as nombre_tipo, et.id as id_tipo');
		$this->wood->from('evaluaciones e');
		$this->wood->join('usuarios u', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("et.id",$id_tipo);
		$this->wood->where("e.id_usuarios",$id_usr);
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->result();
	}
	
	function get_evaluacion($id){
		$this->wood->select('*, e.id as id_evaluacion, ep.nombre as nombre_planta, ee.nombre as nombre_examen');
		$this->wood->from('evaluaciones e');
		$this->wood->join('usuarios u', 'u.id = e.id_usuarios');
		$this->wood->join('empresa_planta ep', 'e.id_planta = ep.id', 'left');
		$this->wood->join('evaluaciones_evaluacion ee', 'ee.id = e.id_evaluacion');
		$this->wood->join('evaluaciones_tipo et', 'et.id = ee.id_tipo','left');
		$this->wood->join('evaluaciones_archivo ea', 'e.id = ea.id_evaluacion', 'left');
		$this->wood->where("e.id",$id);
		$query = $this->wood->get();
		//echo $this->wood->last_query();
		return $query->row();
	}

	function cancelarNotificacion($id){
		$this->wood->set('notificado',1);
		$this->wood->where('id',$id);
		$this->wood->update('usuarios');
	}


	
}
