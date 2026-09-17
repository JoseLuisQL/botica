<?php
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");
$id_factura= intval($_GET['id_factura']);
$sql_factura=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
$rw_factura=mysqli_fetch_array($sql_factura);
$id_cliente=$rw_factura['id_cliente'];
$folio=$rw_factura['folio'];
$estado_factura1=$rw_factura['estado_factura'];
if($estado_factura1==1){
    $tip="01";
}
if($estado_factura1==2){
    $tip="03";
}
if($estado_factura1==6){
    $tip="07";
}
if($estado_factura1==5){
    $tip="08";
}
$numero_factura=$rw_factura['numero_factura'];
$numero_factura1=str_pad($numero_factura, 8, "0", STR_PAD_LEFT);
$doc1="$ruc1-$tip-$folio-$numero_factura1.XML";
$doc2="$ruc1-$tip-$folio-$numero_factura1";
$doc3="R-$ruc1-$tip-$folio-$numero_factura1.XML";
$link1="http://localhost:82/Nueva%20carpeta/sistema%20facturacion%20electronica1/pdf/documentos/factura-firmada/$doc2";




$sql_factura1=mysqli_query($con,"select * from clientes where id_cliente='".$id_cliente."'");
$rw_factura1=mysqli_fetch_array($sql_factura1);
$email=$rw_factura1['email_cliente'];        
$sql_factura2=mysqli_query($con,"select * from datosempresa where id_emp=1");
$rw_factura2=mysqli_fetch_array($sql_factura2);
$nom_emp=$rw_factura2['nom_emp'];                
$link="http://localhost:82/Nueva%20carpeta/sistema%20facturacion%20electronica1/pdf/documentos/ver_factura.php?id_factura=$id_factura";

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Enviar correo.</title>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="" />
<!--Google Fonts-->
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>
<!--Google Fonts-->
</head>
<body>
<!--coact start here-->
<h1>Formulario de envio de Factura Electrónica.</h1>
<div class="contact">
	<div class="contact-main">
	<form method="post">
		<h3>Correo a enviar:</h3>
		<input type="email" value="<?php echo $email;?>" placeholder="Correo donde se enviara la factura." class="hola"  name="customer_email" required />
		<?php
			if (isset($_POST['send'])){
				include("sendemail.php");//Mando a llamar la funcion que se encarga de enviar el correo electronico
				
				/*Configuracion de variables para enviar el correo*/
				$mail_username="";//Correo electronico saliente ejemplo: tucorreo@gmail.com
				$mail_userpassword="";//Tu contraseña de gmail
				$mail_addAddress=$_POST['customer_email'];//correo electronico que recibira el mensaje
				$template="email_template.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
				
				/*Inicio captura de datos enviados por $_POST para enviar el correo */
				$mail_setFromEmail="";//tu correo de gmail
				$mail_setFromName=$nom_emp;//nombre
				$txt_message="<a href='$link'>Descargar PDF</a> <br><a href='$link1'>Descargar XML</a>";//mensaje
				$mail_subject="Factura Electronica";
				
				sendemail($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$template);//Enviar el mensaje
			}
		?>
	</div>
	<div class="enviar">
		<div class="contact-check">
			
		</div>
        <div class="contact-enviar">
		  <input type="submit" value="Enviar Documento" name="send">
		</div>
		<div class="clear"> </div>
		</form>
</div>
</div>

<!--contact end here-->
</body>
</html>