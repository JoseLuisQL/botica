<?php
//https://api.sunat.cloud/ruc/10403322097
//https://eldni.com/buscar-por-dni?dni=46419110
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
require_once ("menu.php");
$a2=recoge1('tip_doc');
$doc1=recoge1('doc1');
$nombre_cliente="";
$sql1="select * from clientes where documento=$doc1";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$nombre_cliente=$rs1["nombre_cliente"];
$direccion_cliente=$rs1["direccion_cliente"];
$telefono_cliente=$rs1["telefono_cliente"];
$email_cliente=$rs1["email_cliente"];

if($nombre_cliente<>""){
    echo "$nombre_cliente|$direccion_cliente|$telefono_cliente|$email_cliente";
}else{
    
if($a2==2){
  //https://api.reniec.cloud/dni/41364119
//$a1=20526037651;
  //  $a4=$clientes1->getDataRUC2($a1);
 //   $a4 = str_replace("&",'',$a4); 
    
 $doc1=recoge1('doc1');   
$data = @file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/$doc1?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNnX3ZlbGF6Y29AaG90bWFpbC5jb20ifQ.RugrMlW0IAwCuAcnHWucHbvpwmt9QA0ebm4CIJ11rwc");
$info = json_decode($data, true);
$razon_social = str_replace("&","",$info['razonSocial']);
$razon_social = str_replace('"',"",$info['razonSocial']);
$domicilio=$info['direccion'];//echo $porciones[5]; // porción1
echo "$razon_social|$domicilio||";
//https://api.reniec.cloud/dni/41364119
}

if($a2==1){
    
//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
//while(!feof($fp)) {
$doc1=recoge1('doc1');   
$data = @file_get_contents("https://dniruc.apisperu.com/api/v1/dni/$doc1?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNnX3ZlbGF6Y29AaG90bWFpbC5jb20ifQ.RugrMlW0IAwCuAcnHWucHbvpwmt9QA0ebm4CIJ11rwc");
$info = json_decode($data, true);
$nombre=$info['nombres']." ".$info['apellidoPaterno']." ".$info['apellidoMaterno'];
//$razon_social = str_replace("&","",$info['razonSocial']);
//$domicilio=$info['direccion'];//echo $porciones[5]; // porción1
echo "$nombre|||";
}
}
?>