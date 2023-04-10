<?php 
header('Access-Control-Allow-Origin: *');

$a = fopen(dirname(__FILE__)."/entorno.cfg","r");
$ambiente = fread($a,filesize(dirname(__FILE__)."/entorno.cfg"));
fclose($a);

$app_id_openexchange = "78131323cdfd4feba26eea67d62f7b4b";

if (isset($ambiente)) {
   session_start();

   switch ($ambiente) {
      case 'local':
         $servidor = "localhost";
         $cuenta   = "root";
         $password = "rootmyapm";
         $database = "embajadores2";
         $urlapp   = "http://localhost";
      break;
      /*
      case 'pruebas':
         // $servidor = "34.237.123.56";
         $servidor = "3.222.39.180";
         $cuenta   = "soft_sayyezz";
         $password = "C4Shp0pk1L";
         $database = "embajadores2";
         $urlapp   = "https://cash.popclik.com/prueba.html";
      break;
      case 'produccion':
         // $servidor = "34.237.123.56";
         $servidor = "3.222.39.180";
         $cuenta   = "soft_sayyezz";
         $password = "C4Shp0pk1L";
         $database = "embajadores2";
         $urlapp   = "https://cash.popclik.com";
      break;
      */

      case 'pruebas':
         $servidor = "localhost:3306";
         $cuenta   = "sgcconsu_embajadores";
         $password = "embajadores12345**";
         $database = "sgcconsu_embajadores";
         $urlapp   = "https://popclik.cash-flag.com";
      break;
      case 'produccion':
         $servidor = "localhost:3306";
         $cuenta   = "sgcconsu_embajadores";
         $password = "embajadores12345**";
         $database = "sgcconsu_embajadores";
         $urlapp   = "https://popclik.cash-flag.com";
      break;

      default:
         // local
         $servidor   = "localhost";
         $cuenta     = "root";
         $password   = "rootmyapm";
         $database   = "embajadores2";
         $urlapp     = "http://localhost";
      break;
   }

   $link = mysqli_connect($servidor, $cuenta, $password) or die ("Error al conectar al servidor.");
   mysqli_select_db($link, $database) or die ("Error al conectar a la base de datos.");

   date_default_timezone_set('America/Caracas');
   set_time_limit(3600);
} else {
   exit('Alerta de programación -> Debe especificar el entorno de trabajo');
}
?>
