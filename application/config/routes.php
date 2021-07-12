<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['qr/(:any)/(:any)'] = "est/requerimiento/qr_carga/$1/$2";
$route['correo/(:any)/(:any)/(:any)'] = "est/requerimiento/contratos_req_trabajador/$1/$2/$3";
$route['carta/(:any)/(:any)/(:any)'] = "est/requerimiento/descargar_carta_termino/$1/$2/$3";

$route['default_controller'] = "home";
$route['404_override'] = 'error/error_404';