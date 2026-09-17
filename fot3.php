<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$asignado=recoge1('asignado');
$a=recoge1('a');
$nombre=recoge1('nombre');;   
function generar_password_complejo($largo){
  $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  $cadena_base .= '0123456789' ;
  
 
  $password = '';
  $limite = strlen($cadena_base) - 1;
 
  for ($i=0; $i < $largo; $i++)
    $password .= $cadena_base[rand(0, $limite)];
 
  return $password;

}

$d=generar_password_complejo(8);
if(is_uploaded_file($_FILES['files']['tmp_name']) && $_FILES['files']['type']<300000) {
        
     $imagen = getimagesize($_FILES['files']['tmp_name']);    //Sacamos la información
    $ancho=$imagen[0];              //Ancho
    $alto=$imagen[1];
  
    $ruta_destino = "galeria/";
    $namefinal="foto"."$d".".jpg";
    if($asignado=="logo"){
        
        $namefinal="logo.jpg";
    }
    
    if($asignado=="fotovision"){
        
        $namefinal="vision.jpg";
    }
    
    if($asignado=="fotomision"){
        
        $namefinal="mision.jpg";
    }
    if($asignado=="quienesomos"){
        
        $namefinal="quienesomos.jpg";
    }
    
    
         //linea nueva devuelve la cadena sin espacios al principio o al final
        $uploadfile=$ruta_destino.$namefinal;
        if(move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
            
        

$sql = "INSERT INTO fotos values (NULL, '$nombre', '$namefinal','$ancho','$alto','$asignado')";
if(!mysqli_query($con,$sql)){
    die("No se pudo actualizar..");
}else{
    if($namefinal<>"quienesomos.jpg"){
        $dml="update datosempresa set $asignado='".$namefinal."' where id_emp=1";
        if(!mysqli_query($con,$dml)){
            header("location:fot1.php?mensaje=no se pudo actualizar");
        }else{
            header("location:fot1.php");
        }
         }else {
            header("location:fot1.php");
        } 
        
        }
 }
 }else{
            if($a<>""){
         
     unlink("galeria/$a");
     
     $dml="DELETE FROM fotos where archivo='".$a."'";
       if(!mysqli_query($con,$dml)){
            header("location:fot1.php");
        }else{
            header("location:fot1.php");
        }
 
 }
        }
ob_end_flush(); 
?>



