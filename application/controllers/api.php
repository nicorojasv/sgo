<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Api extends CI_Controller{
	public function __construct(){
    	parent::__construct();
		$this->load->model('usuarios_model');
		$this->load->model('requerimiento_usuario_archivo_model');
	}
	
	function prueba_cense(){
	    $data = json_decode(file_get_contents('php://input'), true);
	    var_dump($data);
	}
	
	function validar(){
	



		 	$url = 'https://sistemas.sence.cl/rcetest/Registro/IniciarSesion';
		$ch = curl_init($url);
		$data = array(
				'Token' => '2E497B22-77A0-4464-9313-5B924EF90BAC',
				'RutOtec'=> '78834140-7',
                'CodSence'=> '11',
                'CodigoCurso'=> '11',
                'LineaCapacitacion'=>'11',
                'RunAlumno' => '15210750-3',
                'IdSesionAlumno' => '11',
                'UrlRetoma'=>  'www.google.com'   ,
                'UrlError' =>  'www.google.com'  ,

                );


		$token = '2E497B22-77A0-4464-9313-5B924EF90BAC';
        $headers = [
            "Content-type: application/json;charset=utf-8",
            'Authorization: Bearer '.$token, 
            "Referer:prueba",
            "Connection: close"
        ];

		//var_dump($data);
		$data_json = json_encode($data,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		//var_dump($data_json);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
         echo '<pre>';
		print_r($response);
		echo '</pre>';
		var_dump(json_last_error() == JSON_ERROR_NONE);



/*$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://sistemas.sence.cl/rce/Registro/IniciarSesion");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "token=2E497B22-77A0-4464-9313-5B924EF90BAC&RutOtec=78834140-7&CodSence=111&UrlRetoma=xx&UrlError=hh");

// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);
 echo '<pre>';
		print_r($server_output);
		echo '</pre>';

// Further processing ...
if ($server_output == "OK") { echo'shi';  } else { echo'ño'; }
		
			
	}*/
}

	function updateTrabajador() {
		$data = json_decode(file_get_contents('php://input'), true);
			$id = $data['id'];
			if($data['var']=='nombres'){
			    $arrays = array(
	        	    'nombres' => $data['nombres']
	        	);
			}
			if($data['var']=='paterno'){
			    $arrays = array(
	        	    'paterno' => $data['paterno']
	        	);
			}
			if($data['var']=='materno'){
			    $arrays = array(
	        	    'materno' => $data['materno']
	        	);
			}
			
			if($data['var']=='direccion'){
			    $arrays = array(
	        	    'direccion' => $data['direccion']
	        	);
			}
			if($data['var']=='id_afp'){
			    $arrays = array(
	        	    'id_afp' => $data['id_afp']
	        	);
			}
			if($data['var']=='id_salud'){
			    $arrays = array(
	        	    'id_salud' => $data['id_salud']
	        	);
			}
			if($data['var']=='correo'){
			    $arrays = array(
	        	    'email' => $data['correo']
	        	);
			}
       		$result=$this->usuarios_model->editar($id,$arrays);
       	//var_dump($result);
       		
		//}
	}
	
	function updateTrabajadorObjecion() {
		$data = json_decode(file_get_contents('php://input'), true);
		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

	    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Contrato SGO - ARAUCO');
	    //$this->email->to($email_solicitante);
	    $this->email->to('gramirez@empresasintegra.cl');
	//	$this->email->cc('contratos@empresasintegra.cl');
		$this->email->subject("Objecion por parte del trabajador");
	    $this->email->message("id Objecion:".$data['idObjecion']."<br>id Documento ".$data['idDocumento'].'<br> id Holding:'.$data['idHolding'].'<br> observacion'.$data['observacion'].'<br> idPersonal:'.$data['idPersonal']);
	    $this->email->send();
	    $id_usu_arch = $data['idDocumento'];
	    $guardar = array(
	         'id_objecion'=> 	$data['idObjecion'],
        	 'id_personal'=> 	$data['idPersonal'],
        	 'id_documento'=> 	$id_usu_arch,
        	 //'idHolding'=> 	$data['idHolding'],
        	 'observacion'=> 	$data['observacion'],
        	 'tipo_doc' =>1,
	        );
	        $this->usuarios_model->guardarRegistroObjecion($guardar);//insertando el registro de cada objecion
	        $data = array(
	        	'estado_aprobacion_revision'=>0,
	        );
	        $this->requerimiento_usuario_archivo_model->actualizar_usu_arch($id_usu_arch, $data);//cambiando el estado del contrato 
	        $this->usuarios_model->actualizarPorObjecion($id_usu_arch);//cambiando el estado del contrato 


		/*	$id = $data['id']; /// id Trabajador
			if($data['var']=='nombres'){
			    $arrays = array(
	        	    'nombres' => $data['nombres']
	        	);
	        //	$data['id_documento']
			}
			if($data['var']=='paterno'){
			    $arrays = array(
	        	    'paterno' => $data['paterno']
	        	);
			}
			if($data['var']=='materno'){
			    $arrays = array(
	        	    'materno' => $data['materno']
	        	);
			}
			
			if($data['var']=='direccion'){
			    $arrays = array(
	        	    'direccion' => $data['direccion']
	        	);
			}
			if($data['var']=='id_afp'){
			    $arrays = array(
	        	    'id_afp' => $data['id_afp']
	        	);
			}
			if($data['var']=='id_salud'){
			    $arrays = array(
	        	    'id_salud' => $data['id_salud']
	        	);
			}
			if($data['var']=='correo'){
			    $arrays = array(
	        	    'email' => $data['correo']
	        	);
			}
			if($data['var']=='id_documento'){
			    $arrays = array(
	        	    'email' => $data['correo']
	        	);
			}*/
			/*id_documento
			id_negocio
			tipo_objecion=*/
       	//	$result=$this->usuarios_model->editar2($id,$arrays);
       	//$result = 1;
      // 		var_dump($data);
       		//sobre tipo objecion 10 generar uno nuevo
	}



}
?>