<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once("../_config/conexion.php");
// include_once("./funciones.php");

$id           = $_POST["id"];
$nombre       = trim($_POST["nombre"]);
$celular      = trim($_POST["telefono"]);
$email        = trim($_POST["email"]);
$tallafranela = trim($_POST["tallafranela"]);
$idtienda     = (isset($_POST["idtienda"]) && $_POST["idtienda"]!="") ? $_POST["idtienda"] : 0;
$status       = trim($_POST["status"]);

$exito   = 'NO';
$mensaje = 'Error inesperado';
$lista = array();
$fila = '{}';

if ($id==="New") {
   $query = "select * from embajador where nombre='$nombre'";
   $result = mysqli_query($link, $query);
   if ($row = mysqli_fetch_array($result)) {
      $exito   = 'NO';
      $mensaje = 'Registro ya existe';
   } else {
      $query = "select * from tienda where id=$idtienda and status='activo'";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $nombretienda   = $row["nombre"];
         $idgrupo        = $row["idgrupo"];
         $iddistribuidor = $row["iddistribuidor"];
      } else {
         $nombretienda   = "";
         $idgrupo        = 0;
         $iddistribuidor = 0;
      }
   
      $query = "select * from grupo where id=$idgrupo and status='activo'";
      $result = mysqli_query($link, $query);
      if ($row = mysqli_fetch_array($result)) {
         $nombregrupo = $row["nombre"];
      } else {
         $nombregrupo = "";
      }
   
      if ($iddistribuidor>0) {
         $query = "select * from distribuidor where id=$iddistribuidor and status='activo'";
         $result = mysqli_query($link, $query);
         if ($row = mysqli_fetch_array($result)) {
            $nombredistribuidor = $row["nombre"];
         } else {
            $nombredistribuidor = "";
         }
      } else {
         $nombredistribuidor = 'Techland LLC';
      }
   
      $query  = "insert into embajador (nombre, celular, email, tallafranela, idtienda, status, nombretienda, idgrupo, iddistribuidor) values ('$nombre', '$celular', '$email', '$tallafranela', $idtienda, '$status', '$nombretienda', $idgrupo, $iddistribuidor)";
      $result = mysqli_query($link, $query);
      $id = mysqli_insert_id($link);
   
      $fila = array(
         "id" => $id,
         "nombre" => $nombre,
         "celular" => $celular,
         "email" => $email,
         "tallafranela" => $tallafranela,
         "idtienda" => $idtienda,
         "status" => $status,
         "nombretienda" => $nombretienda,
         "idgrupo" => $idgrupo,
         "nombregrupo" => $nombregrupo,
         "iddistribuidor" => $iddistribuidor,
         "nombredistribuidor" => $nombredistribuidor
      );
      $lista[] = json_encode($fila);
      $exito   = 'SI';
      $mensaje = 'Registro exitoso';
   }
} else {
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
   $result = mysqli_query($link, $query);

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
}
$respuesta  = '{"exito":"'.$exito.'"';
$respuesta .= ',"mensaje":"'.$mensaje.'"';
$respuesta .= ',"registros": ['. implode(',', $lista)    .']';
$respuesta .= '}';

echo $respuesta;
?>