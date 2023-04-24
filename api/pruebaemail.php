<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
include_once("./lib/lib-email.php");
// include_once("./funciones.php");

$email = 'soluciones2000@gmail.com';
$nombre = 'Luis';

correonotificacion($email, $nombre);

$exito   = 'SI';
$mensaje = 'Registro exitoso';

$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= '}';

echo $respuesta;

function correonotificacion($email, $nombre) {
   $asunto = "Bienvenido a embajadores YEZZ. Registro Aprobado xyz.";

   $sTexto  = '<div style="width: 388.65px;">
                  <img src="https://embajadores.cash-flag.com/images/LOGO.png" width="220" height="50.23" />
               </div>';

   $sTexto .= '<br/>Prueba<br/><br/>';
   $a = fopen('log.html','w+');
   fwrite($a,$asunto);
   fwrite($a,'-');
   fwrite($a,$sTexto);
   
   enviaemail($email, $nombre, $asunto, $sTexto);
}
?>