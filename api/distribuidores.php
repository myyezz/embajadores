<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$nombre          = trim($_POST["nombre"]);
$idejecutivo     = $_POST["idejecutivo"];
$celular         = trim($_POST["celular"]);
$email           = trim($_POST["email"]);
$direccion       = trim($_POST["direccion"]);
$contacto        = trim($_POST["contacto"]);
$celularcontacto = trim($_POST["celularcontacto"]);
$status          = (trim($_POST["status"])=="0") ? "inactivo" : trim($_POST["status"]) ;
// $password        = trim($_POST["password"]);
$password        = '123456';

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

$query = "select * from distribuidor where email='$email' and status='activo'";
$result = mysqli_query($link, $query);
if ($row = mysqli_fetch_array($result)) {
   $exito   = 'NO';
   $mensaje = 'Registro ya existe';
} else {
   $query = "select * from ejecutivo where id=$idejecutivo and status='activo'";
   $result = mysqli_query($link, $query);
   if ($row = mysqli_fetch_array($result)) {
      $nombreejecutivo = $row["nombre"];
   } else {
      $nombreejecutivo = 'No existe';
   }
   $hashp = hash('sha256', $email.$password);

   $query  = "insert into distribuidor (nombre, idejecutivo, celular, email, hashp, direccion, contacto, celularcontacto, status) values ('$nombre', $idejecutivo, '$celular','$email', '$hashp', '$direccion', '$contacto', '$celularcontacto', '$status')";
   $result = mysqli_query($link, $query);
   $id = mysqli_insert_id($link);

   $fila = array(
      "id" => $id,
      "nombre" => $nombre,
      "idejecutivo" => $idejecutivo,
      "nombreejecutivo" => $nombreejecutivo,
      "celular" => $celular,
      "email" => $email,
      "hashp" => $hashp,
      "direccion" => $direccion,
      "contacto" => $contacto,
      "celularcontacto" => $celularcontacto,
      "status" => $status,
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
?>