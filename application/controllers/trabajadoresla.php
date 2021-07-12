<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class trabajadoresla extends CI_Controller {
	function index() {
		$this->load->helper('browsers');
		if(getBrowser()){
			redirect('/home/cambiar_browser', 'refresh');
		}
		//$base['cuerpo'] = '';
		//$this -> load -> view('layout',$base);

		$this -> load -> view('layout2.0/trabajadoresla');
	}

}
?>