<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$id              = $_POST["id"];
$nombre          = trim($_POST["nombre"]);
$idejecutivo     = $_POST["idejecutivo"];
$celular         = trim($_POST["celular"]);
$email           = trim($_POST["email"]);
$direccion       = trim($_POST["direccion"]);
$contacto        = trim($_POST["contacto"]);
$celularcontacto = trim($_POST["celularcontacto"]);
$idgrupo         = $_POST["idgrupo"];
$status          = (trim($_POST["status"])=="0") ? "inactivo" : trim($_POST["status"]) ;
$iddistribuidor  = $_POST["iddistribuidor"];

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

if ($id==="New") {
   $query = "select * from tienda where email='$email'";
   $result = mysqli_query($link, $query);
   if ($row = mysqli_fetch_array($result)) {
      $exito   = 'NO';
      $mensaje = 'Registro ya existe';
   } else {
      $query = "select * from ejecutivo where id=$idejecutivo";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $nombreejecutivo = $row["nombre"];
      } else {
         $nombreejecutivo = 'No existe';
      }

      $query = "select * from grupo where id=$idgrupo";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $nombregrupo = $row["nombre"];
      } else {
         $nombregrupo = 'No existe';
      }

      if ($iddistribuidor>0) {
         $quer2 = "select * from distribuidor where id=$iddistribuidor";
         $resul2 = mysqli_query($link, $quer2);
         if ($ro2 = mysqli_fetch_array($resul2)) {
            $nombredistribuidor = $ro2["nombre"];
         } else {
            $nombredistribuidor = "";
         }
      } else {
         $nombredistribuidor = 'Techland LLC';
      }

      $query  = "insert into tienda (nombre, idejecutivo, celular, email, direccion, contacto, celularcontacto, idgrupo, iddistribuidor, status) values ('$nombre', $idejecutivo, '$celular','$email', '$direccion', '$contacto', '$celularcontacto', $idgrupo, $iddistribuidor, '$status')";
      $result = mysqli_query($link, $query);
      $id = mysqli_insert_id($link);

      $fila = array(
         "id" => $id,
         "nombre" => $nombre,
         "idejecutivo" => $idejecutivo,
         "nombreejecutivo" => $nombreejecutivo,
         "celular" => $celular,
         "email" => $email,
         "direccion" => $direccion,
         "contacto" => $contacto,
         "celularcontacto" => $celularcontacto,
         "idgrupo" => $idgrupo,
         "nombregrupo" => $nombregrupo,
         "iddistribuidor" => $iddistribuidor,
         "nombredistribuidor" => $nombredistribuidor,
         "status" => $status
      );
      $lista[] = json_encode($fila);
      $exito   = 'SI';
      $mensaje = 'Registro exitoso';
   }
} else {
   $query = "select * from ejecutivo where id=$idejecutivo";
   $result = mysqli_query($link, $query);
   if ($row = mysqli_fetch_array($result)) {
      $nombreejecutivo = $row["nombre"];
   } else {
      $nombreejecutivo = 'No existe';
   }

   $query = "select * from grupo where id=$idgrupo";
   $result = mysqli_query($link, $query);
   if ($row = mysqli_fetch_array($result)) {
      $nombregrupo = $row["nombre"];
   } else {
      $nombregrupo = 'No existe';
   }

   if ($iddistribuidor>0) {
      $quer2 = "select * from distribuidor where id=$iddistribuidor";
      $resul2 = mysqli_query($link, $quer2);
      if ($ro2 = mysqli_fetch_array($resul2)) {
         $nombredistribuidor = $ro2["nombre"];
      } else {
         $nombredistribuidor = "";
      }
   } else {
      $nombredistribuidor = 'Techland LLC';
   }

   $query  = "update tienda set nombre='$nombre', idejecutivo=$idejecutivo, celular='$celular', email='$email', direccion='$direccion', contacto='$contacto', celularcontacto='$celularcontacto', idgrupo=$idgrupo, iddistribuidor=$iddistribuidor, status='$status' where id=$id";
   $result = mysqli_query($link, $query);

   $fila = array(
      "id" => $id,
      "nombre" => $nombre,
      "idejecutivo" => $idejecutivo,
      "nombreejecutivo" => $nombreejecutivo,
      "celular" => $celular,
      "email" => $email,
      "direccion" => $direccion,
      "contacto" => $contacto,
      "celularcontacto" => $celularcontacto,
      "idgrupo" => $idgrupo,
      "nombregrupo" => $nombregrupo,
      "iddistribuidor" => $iddistribuidor,
      "nombredistribuidor" => $nombredistribuidor,
      "status" => $status
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