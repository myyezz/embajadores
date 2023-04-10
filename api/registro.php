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
$nombretienda    = trim($_POST["tienda"]);
$direcciontienda = trim($_POST["direcciontienda"]);
$password        = trim($_POST["password"]);
$idtienda        = 0;
$idgrupo         = 0;
$iddistribuidor  = $_POST["iddistribuidor"];
$status          = 'pendiente';

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

   $query  = "insert into embajador (nombre, celular, email, tallafranela, idtienda, hashp, status, nombretienda, direcciontienda, idgrupo, iddistribuidor, nuevo) values ('$nombre', '$celular','$email', '$tallafranela', $idtienda, '$hashp', '$status', '$nombretienda', '$direcciontienda', $idgrupo, $iddistribuidor, 'NO')";
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

correonuevacuenta($email, $nombre, $celular, $nombretienda, $direcciontienda, $tallafranela);

echo $respuesta;

function correonuevacuenta($emailx, $nombre, $celular, $nombretienda, $direcciontienda, $tallafranela) {
   $email = 'embajador@myyezz.com';

   $asunto = "Nuevo Embajador registrado.";

   $sTexto  = '<div style="width: 388.65px;">
                  <img src="https://embajadores.cash-flag.com/images/LOGO.png" width="220" height="50.23" />
               </div>';

   $sTexto .= "<br/>Buen día<br/><br/>";

   $sTexto .= "Un Embajador acaba de registrarse en el Programa Embajadores YEZZ:"."<br/><br/>";

   $sTexto .= "Nombre y Apellido: ".$nombre."<br/><br/>";

   $sTexto .= "Celular: ".$celular."<br/><br/>";

   $sTexto .= "Email: ".$emailx."<br/><br/>";

   $sTexto .= "Tienda en donde trabaja: ".$nombretienda."<br/><br/>";

   $sTexto .= "Direccion de la tienda: ".$direcciontienda."<br/><br/>";

   $sTexto .= "Talla de Franela: ".$tallafranela."<br/><br/>";

   $sTexto .= 'Ingresa en <a href="https://embajadores.cash-flag.com/admin">este enlace</a> para mirar sus datos y aprobar su solicitud<br/><br/>';

   $a = fopen('log.html','w+');
   fwrite($a,$asunto);
   fwrite($a,'-');
   fwrite($a,$sTexto);
   
   enviaemail($email, $nombre, $asunto, $sTexto);
}
?>