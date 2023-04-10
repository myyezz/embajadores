<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
include_once("./lib/lib-email.php");
// include_once("./funciones.php");

if ($_POST["status"]=='activo') {
   $id           = $_POST["id"];
   $nombre       = trim($_POST["nombre"]);
   $celular      = trim($_POST["telefono"]);
   $email        = trim($_POST["email"]);
   $tallafranela = trim($_POST["tallafranela"]);
   $idtienda     = $_POST["idtienda"];
   $status       = trim($_POST["status"]);

   $query = "select * from tienda where id=$idtienda and status='activo'";
   $result = mysqli_query($link, $query);
   if ($row = mysqli_fetch_array($result)) {
      $nombretienda = $row["nombre"];
      $idgrupo        = $row["idgrupo"];
      $iddistribuidor = $row["iddistribuidor"];
   } else {
      $nombretienda = 0;
      $idgrupo        = 0;
      $iddistribuidor = 0;
   }

   $query  = "update embajador set nombre='$nombre', celular='$celular', email='$email', tallafranela='$tallafranela', idtienda=$idtienda, status='$status', nombretienda='$nombretienda', idgrupo=$idgrupo, iddistribuidor=$iddistribuidor where id=$id";

   correonotificacion($email, $nombre, 'aprobado');
   // correobienvenida($email, $nombre);
} else {
   $id           = $_POST["id"];
   $nombre       = trim($_POST["nombre"]);
   $email        = trim($_POST["email"]);
   $status       = trim($_POST["status"]);

   $query  = "update embajador set status='$status' where id=$id";

   correonotificacion($email, $nombre, 'rechazado');
   // correorechazo($email, $nombre);
}
$result = mysqli_query($link, $query);

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from embajador where id=$id";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   $idgrupo        = $row["idgrupo"];
   $iddistribuidor = $row["iddistribuidor"];

   $quer2 = "select * from grupo where id=$idgrupo and status='activo'";
   $resul2 = mysqli_query($link, $quer2);
   if ($ro2 = mysqli_fetch_array($resul2)) {
      $nombregrupo = $ro2["nombre"];
   } else {
      $nombregrupo = "";
   }

   if ($iddistribuidor>0) {
      $quer2 = "select * from distribuidor where id=$iddistribuidor and status='activo'";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) {
         $nombredistribuidor = $ro2["nombre"];
      } else {
         $nombredistribuidor = "";
      }
   } else {
      $nombredistribuidor = 'Techland LLC';
   }

   $fila = array(
      "id" => $row["id"],
      "nombre" => $row["nombre"],
      "celular" => $row["celular"],
      "email" => $row["email"],
      "tallafranela" => $row["tallafranela"],
      "idtienda" => $row["idtienda"],
      "status" => $row["status"],
      "nombretienda" => $row["nombretienda"],
      "idgrupo" => $row["idgrupo"],
      "nombregrupo" => $nombregrupo,
      "iddistribuidor" => $row["iddistribuidor"],
      "nombredistribuidor" => $nombredistribuidor
   ); 
   $lista[] = json_encode($fila);
   $exito   = 'SI';
   $mensaje = 'Registro exitoso';
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

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
/*
function correobienvenida($email, $nombre) {
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

   $a = fopen('log.html','w+');
   fwrite($a,$asunto);
   fwrite($a,'-');
   fwrite($a,$sTexto);
   
   enviaemail($email, $nombre, $asunto, $sTexto);
}

function correorechazo($email, $nombre) {
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

   $a = fopen('log.html','w+');
   fwrite($a,$asunto);
   fwrite($a,'-');
   fwrite($a,$sTexto);

   enviaemail($email, $nombre, $asunto, $sTexto);
}
*/
?>