<?php
ob_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
include('menu.php');     
$id=recoge1('accion1');
$consulta2 = "DELETE FROM servicio WHERE detalle='$id'";
if (mysqli_query($con, $consulta2)) {
    header("location:ingresoservicios.php"); 
}
$consulta3 = "DELETE FROM detalle_factura WHERE id_detalle='$id'";
if (mysqli_query($con, $consulta3)) {
    header("location:ingresoservicios.php"); 
}      
ob_end_flush();      
?>
