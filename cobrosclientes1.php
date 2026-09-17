<?php
ob_start();
//ob_end_flush();
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
include('menu.php');
$_SESSION['tabla']=2;
$a1=$_POST['cliente'];
$a2=recoge1('fecha1');
$a3=recoge1('fecha2');
$a4=recoge1('tienda');
$a5="";
$a6="";
$delete=mysqli_query($con,"DELETE FROM consultas");
$insert=mysqli_query($con,"INSERT INTO consultas VALUES (NULL,'10','$a1','$a2','$a3','$a4','$a5','$a6')");
header("location:cobrosclientes.php");
//ob_start();
ob_end_flush();
?>