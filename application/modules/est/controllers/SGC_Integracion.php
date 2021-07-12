<?php defined('BASEPATH') OR exit('No direct script access allowed');



    class SGC_Integracion extends CI_Controller



    {

        /**

         * function sendDocument(), función para enviar el archivo al WebService

         */

        public function sendDocument()

        {


            //$xml = file_get_contents( base_url().'xmls/xml_generados-xml.bin'); 
             $xml = file_get_contents( base_url().'xmls/document.xml.bin'); 



            /** 

            * @param token es la clave que se envía al WebService

            * Se define el Token para enviar al WebServices para validar que se está accediendo desde la Aplicación de Integra

            */

            $token = 'v6WU6haL&Qzq=*';



            /**

            * @param server es la Ruta del WebService enviándole también el Token, y se definen los datos de cabecera del paquete

            */

            //$server = 'http://54.232.203.239/SGC_Integra/insertContrato';
            $server = 'http://54.232.203.239/wsIntegra/insertDocumento';


            /**

             * @param headers define la cabecera del paquete el cual se envía al Webservice

             * @param Content-Type define el formato de arhivo recibido XML

             * @param Authorization se envía el token de autorización del WebService

             * @param Content-length define el largo de la cadena enviada

            */

            $headers = [
                "Content-type: text/xml",
                'Authorization: Bearer '.$token, 
                /**"id_negocio:2", //1-Arauco 2-Enjoy 3-MDS thno 4-MDS chillán
                "id_documento:1",//id Contrato 
                "tipo_documento:1", //1.-Contrato 2.-Anexo*/
                "Content-length: " . strlen($xml),
                "Referer:prueba",
                "Connection: close"

            ];



            /** 

             * @param ch define las opciones de envío y propiedades del paquete de datos 

            */
             $tipo_documento= 1;
             $id_negocio=1;
             $id_documento=22;
             $rutTrabajador='18.137.423-3';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $server);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_TIMEOUT, 100);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_COOKIE, 'tipo_documento='.$tipo_documento.';id_negocio='.$id_negocio.';id_documento='.$id_documento.'');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



            /**

            * @param data almacena el valor que se retorna desde el WebService al ejecutarse la peticion HTTP

            * Se ejecuta el envío del paquete y se recibe la respuesta en la variable data 

            * Si lo recibido en @param data es un 1, el envío se realizó con exito y se insertó la información en la Base de datos, un registro encriptado y otro sin encriptar para validar las pruebas, si se recibe un 0 algo falló.

            */

            $data = curl_exec($ch);

            if (curl_errno($ch)) {

                print_r( curl_error($ch));

                print_r( "Error");

            } else {

                curl_close($ch);

            }



            /**

            * Imprime el valor de la variable data

            */

            print_r($data);



        }



    }



?>