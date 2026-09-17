<?php
//https://api.sunat.cloud/ruc/10403322097
//http://localhost:82/Nueva%20carpeta/sistema%20facturacion%20electronica1/busqueda.php?tip_doc=1&doc1=20552103816
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
    echo "$nombre_cliente||$direccion_cliente||$telefono_cliente||$email_cliente";
}else{
    
if($a2==2){
  

	



	
        
        
    
    
    
$a1=recoge1('doc1');
//$cliente = new Sunat();
 	//$ruc="20549500553";
  //  $a5=$cliente->getDataRUC($a1);
    
//$porciones = explode("</font>", $a5);
//$a5=$porciones[1];
    //print"$a5";
   $curl = curl_init();

 
$data = [
    'token' => 'vRkDnseZkJFpOHIWWZbZrXOc0garW8EfoEsKQj4Pa6G12cvrOqMhOnYlm8Ba',
    'ruc' => $a1
];

$post_data = http_build_query($data);

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.migo.pe/api/v1/ruc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $post_data,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
   
$porciones = explode(",", $response);
$leonardovelarde = $porciones[2]; // 
$direcmigo = $porciones[19]; // 

$porcionesdos = explode(":", $leonardovelarde);
$parte = str_replace('"',"",$porcionesdos[1]);
$partedos = str_replace("}","",$parte);

$explodedirecmigo = explode(":", $direcmigo );
$partetres = str_replace('"',"",$explodedirecmigo[1]);
$partedireccion = str_replace("}","",$partetres);


 

echo "$partedos||$partedireccion||||";

}




 
}

if($a2==1){

 $dnileo = $_POST['doc1'];
$curl = curl_init();


$data = [
    'token' => 'vRkDnseZkJFpOHIWWZbZrXOc0garW8EfoEsKQj4Pa6G12cvrOqMhOnYlm8Ba',
    'dni' => $dnileo
];

$post_data = http_build_query($data);

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.migo.pe/api/v1/dni",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $post_data,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {



$porciones = explode(",", $response);
$leonardovelarde = $porciones[2]; // 

$porcionesdos = explode(":", $leonardovelarde);
$parte = str_replace('"',"",$porcionesdos[1]);
$partedos = str_replace("}","",$parte);

echo $partedos; 



 



}



}
}
?>