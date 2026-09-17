<?php
ob_start();
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
$alerta=$_POST['alerta'];
$precio2=$_POST['precio2']; 
$precio3=$_POST['precio3']; 
$precio22=$precio2/100;
$precio33=$precio3/100;    

$dml="update datosempresa set alerta=$alerta,precio2=$precio2,precio3=$precio3 where id_emp=1";
if(!mysqli_query($con,$dml)){
    die("No se pudo actualizar..");
}else{
    header("location:productos.php");
}

ob_end_flush();
?>



