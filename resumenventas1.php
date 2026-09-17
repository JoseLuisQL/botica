<?php
ob_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos


session_start();
include('menu.php');
//include('funciones.php');
//include('conexion.php');

//$db = conectar1();
$a1=recoge1('tipo');
$a2=recoge1('fecha1');
$a3=recoge1('fecha2');
$a4=recoge1('tienda');
$a5="";
$a6="";
$delete=mysqli_query($con,"DELETE FROM consultas");
$insert=mysqli_query($con,"INSERT INTO consultas VALUES (NULL,'6','$a1','$a2','$a3','$a4','$a5','$a6')");
header("location:resumenventas.php");
ob_end_flush(); 
?>