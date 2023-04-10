<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
include_once("./lib/lib-email.php");
// include_once("./funciones.php");

$nombre          = trim($_POST["nombre"]);
$celular         = trim($_POST["telefono"]);
$email           = trim($_POST["email"]);
$tallafranela    = $_POST["tallafranela"];
$idtienda        = trim($_POST["tienda"]);
$direcciontienda = trim($_POST["direcciontienda"]);
$password        = trim($_POST["password"]);
$nombretienda    = "";
$idgrupo         = 0;
$iddistribuidor  = $_POST["iddistribuidor"];
$status          = 'activo';

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from embajador where email='$email'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   $exito   = 'NO';
   $mensaje = 'Registro ya existe';
} else {
   $hashp = hash('sha256', $email.$password);

   $quer2 = "select * from tienda where id=$idtienda";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $nombretienda    = $ro2["nombretienda"];
      $direcciontienda = $ro2["direcciontienda"];
      $idgrupo         = $ro2["idgrupo"];
      $iddistribuidor  = $ro2["iddistribuidor"];
   } else {
      $nombretienda    = $nombretienda;
      $direcciontienda = $direcciontienda;
      $idgrupo         = $idgrupo;
      $iddistribuidor  = $iddistribuidor;
   }

   $query  = "insert into embajador (nombre, celular, email, tallafranela, idtienda, hashp, status, nombretienda, direcciontienda, idgrupo, iddistribuidor, nuevo) values ('$nombre', '$celular','$email', '$tallafranela', $idtienda, '$hashp', '$status', '$nombretienda', '$direcciontienda', $idgrupo, $iddistribuidor, 'SI')";
   $result = mysqli_query($link, $query);
   $id = mysqli_insert_id($link);

   $fila  = '{';
   $fila .=  '"id":'.$id;
   $fila .=  ',"nombre":"'.$nombre.'"';
   $fila .=  ',"celular":"'.$celular.'"';;
   $fila .=  ',"email":"'.$email.'"';
   $fila .=  ',"tallafranela":"'.$tallafranela.'"';
   $fila .=  ',"idtienda":'.$idtienda;
   $fila .=  ',"password":"'.$hashp.'"';
   $fila .=  ',"status":"'.$status.'"';
   $fila .=  ',"nombretienda":"'.$nombretienda.'"';
   $fila .=  ',"direcciontienda":"'.$direcciontienda.'"';
   $fila .=  ',"idgrupo":'.$idgrupo;
   $fila .=  ',"iddistribuidor":'.$iddistribuidor;
   $fila .= '}';
   $lista[] = $fila;
   $exito   = 'SI';
   $mensaje = 'Registro exitoso';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

correonotificacion($email, $nombre, 'aprobado');

echo $respuesta;

function correonotificacion($email, $nombre, $accion) {
   if ($accion=='aprobado') {
      $asunto = "Bienvenido a embajadores YEZZ. Registro Aprobado.";

      $sTexto  = '<div style="width: 388.65px;">
                     <img src="https://embajadores.cash-flag.com/images/LOGO.png" width="220" height="50.23" />
                  </div>';
   
      $sTexto .= '<br/>Estimado '.$nombre.'<br/><br/>';
   
      $sTexto .= '¡Bienvenido a Embajadores YEZZ! Tu cuenta ahora está <b>activa</b>.'.'<br/><br/>';
   
      $sTexto .= 'Ya puedes comenzar a registrar tus IMEIS vendidos dentro de la plataforma.'.'<br/><br/>';
   
      $sTexto .= 'Inicia sesión en tu cuenta <a href="https://embajadores.cash-flag.com">AQUÍ</a>'.'<br/><br/>';
   
      $sTexto .= 'Si tienes algún problema con tu cuenta, comunícate con nosotros a <a href="mailto:embajador@myyezz.com">embajador@myyezz.com</a>'.'<br/><br/>';
   
      $sTexto .= '¡Saludos!'.'<br/><br/>';
   
      $sTexto .= 'Embajadores YEZZ'.'<br/>';
   } else {
      $asunto = "Registro de embajadores YEZZ Rechazado.";

      $sTexto  = '<div style="width: 388.65px;">
                     <img src="https://embajadores.cash-flag.com/images/LOGO.png" width="220" height="50.23" />
                  </div>';
   
      $sTexto .= '<br/>Estimado '.$nombre.'<br/><br/>';
   
      $sTexto .= 'Tu solicitud de registro en Embajadores YEZZ ha sido <b>rechazada</b>.'.'<br/><br/>';
   
      $sTexto .= 'Es posible que esto se deba a que no fue posible confirmar tus datos de registro con tu tienda.'.'<br/><br/>';
   
      $sTexto .= 'Si crees que esto es un error, comunícate con nosotros a <a href="mailto:embajador@myyezz.com">embajador@myyezz.com</a> o escríbenos por <a href="https://wa.me/584129771359">Whatsapp</a>'.'<br/><br/>';
   
      $sTexto .= '¡Saludos!'.'<br/><br/>';
   
      $sTexto .= 'Embajadores YEZZ'.'<br/>';
   }
   $a = fopen('log.html','w+');
   fwrite($a,$asunto);
   fwrite($a,'-');
   fwrite($a,$sTexto);
   
   enviaemail($email, $nombre, $asunto, $sTexto);
}
?>