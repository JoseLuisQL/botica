<?php

session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
sleep(1);
$data = intval($_POST['value']);
$field = $_POST['field'];
date_default_timezone_set('America/Lima');
$date_added=date("Y-m-d H:i:s");
if($_SESSION['tienda']==1){
    $field1 ="b1";
}
if($_SESSION['tienda']==2){
    $field1 ="b2";
}
if($_SESSION['tienda']==3){
    $field1 ="b3";
}
if($_SESSION['tienda']==4){
    $field1 ="b4";
}
if($_SESSION['tienda']==5){
    $field1 ="b5";
}
if($_SESSION['tienda']==6){
    $field1 ="b6";
}
$user=$_SESSION['user_id'];
$tienda=$_SESSION['tienda'];
$select=mysqli_query($con,"select * from products where id_producto='".$field."'");
                $row7=mysqli_fetch_array($select);
               
                $inv_ini=$row7["b$tienda"];

if($data>=0){

$conexion = new mysqli('localhost',DB_USER,DB_PASS, DB_NAME);
$update = "UPDATE `products` SET $field1='".$data."' WHERE id_producto=$field";
$conexion->query($update);
if($data<>$inv_ini){
$query_update = mysqli_query($con,"INSERT INTO inventario (id_producto, usuario, fecha,inventario,inv_ini,tienda,motivo) VALUES ('$field','$user','$date_added','$data','$inv_ini','$tienda','rapido')");
}
echo $data;
}
?>