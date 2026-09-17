<?php

session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
}
include("../../config/db.php");
include("../../config/conexion.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "validaciondedatos.php";
include "procesarcomprobante.php";
$doc3=$_GET['fac'];
$tienda=$_SESSION['tienda'];

$sql2="select * from sucursal where tienda=$tienda"; 
$rs2=mysqli_query($con,$sql2);
$row2= mysqli_fetch_array($rs2);
$ruc=$row2['ruc'];

$sql_empresa=mysqli_query($con,"select * from datosempresa where id_emp=1");
$rw_empresa=mysqli_fetch_array($sql_empresa);
$fac_ele=$rw_empresa['fac_ele'];
$usuario_sol=$rw_empresa['usuariosol'];
$pass_sol=$rw_empresa['clavesol'];
$clave=$rw_empresa['clave'];

$dato=$doc3;
$porciones = explode("-", $dato);
//$doc2="$ruc1-$tip-$folio-$numero_factura";
$ruc1=$porciones[0]; 
$tip=$porciones[1]; 
if($tip=="01"){

$estado_factura=1;
}
if($tip=="03"){

$estado_factura=2;
}
if($tip=="07"){

$estado_factura=6;
}
if($tip=="08"){

$estado_factura=5;
}
date_default_timezone_set('America/Lima');
$fecha3=date("d/m/Y H:i:s");

$folio=$porciones[2]; 
$numero_factura=$porciones[3]*1; 
//------------------ENVIAR XML SUNAT-------------------
// NOMBRE DE ARCHIVO A PROCESAR.
    $NomArch=$doc3;
    $tipodeproceso = (isset($data['tipo_proceso'])) ? $data['tipo_proceso'] : $fac_ele;

    $content_firmas = 'certificados/';
	
	$nombre_archivo = $doc3;
        $array_cabecera['EMISOR_RUC']=$ruc;
        $array_cabecera['EMISOR_USUARIO_SOL']=$usuario_sol;
        $array_cabecera['EMISOR_PASS_SOL']=$pass_sol;
	if ($fac_ele == '1') {
            $ruta = "factura-firmada/" . $nombre_archivo;
            $ruta_cdr = "cdr/";
            $ruta_firma = '';
            $pass_firma = $clave;
            $ruta_ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
            
	}
	
        if ($fac_ele == '3') {
            $ruta = "factura-firmada/" . $nombre_archivo;
            $ruta_cdr ="cdr/";
            $ruta_firma = $content_firmas.'beta/firmabeta.pfx';
            $pass_firma = '123456';
            $ruta_ws = 'https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService';
	}

	$rutas = array();
        $rutas['nombre_archivo'] = $nombre_archivo;
        $rutas['ruta_xml'] = $ruta;
        $rutas['ruta_cdr'] = $ruta_cdr;
        $rutas['ruta_firma'] = $ruta_firma;
        $rutas['pass_firma'] = $pass_firma;
	$rutas['ruta_ws'] = $ruta_ws;
	
	$procesarcomprobante = new Procesarcomprobante();
	$resp = $procesarcomprobante->procesar_factura1($array_cabecera, $rutas);
	$resp['ruta_xml'] = '';
	$resp['ruta_cdr'] = '';
	$resp['ruta_pdf'] = '';
	$resp['ruta_xml'] = "";
	$resp['url_xml'] = "";
	$resp['ruta_cdr'] = "";
	//echo json_encode($resp);
	//exit();
        
        if($resp['respuesta'] == 'ok') {
           $sql_factura1=mysqli_query($con,"update facturas set aceptado='Aceptada' where numero_factura='".$numero_factura."' and folio='".$folio."' and estado_factura='".$estado_factura."' and tienda='".$tienda."'");
echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-top: 10px;">';
echo 'Su documento electronico ha sido enviado satisfactoriamente.<br>';
echo '<span style="color: #A70202;">Descargar CDR generado:<a href="pdf/documentos/cdr/R-'.$NomArch.'.XML" target="_blank">R-'.$NomArch.'.xml</a>(respuesta de la sunat)</span>';
echo '</div>'; 


        }else{
            echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-top: 10px;">';
echo 'Su documento electronico no ha sido enviado ocurrio o link beta de la Sunat caido.<br>';

echo '</div>';
echo $resp['respuesta'];
echo $resp['mensaje'];
echo $resp['cod_sunat'];

        }



?>

