<?php
error_reporting(0); 
ob_start();	
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	$id_factura= intval($_GET['id_factura']);
        
	$sql_count=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Factura no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_factura=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
	$rw_factura=mysqli_fetch_array($sql_factura);
	$numero_factura=$rw_factura['numero_factura'];
        $total=$rw_factura['total_venta'];
        $ven_com=$rw_factura['ven_com'];
        
	$id_cliente=$rw_factura['id_cliente'];
	$id_vendedor=$rw_factura['id_vendedor'];
	$fecha_factura=$rw_factura['fecha_factura'];
	$condiciones=$rw_factura['condiciones'];
        $moneda=$rw_factura['moneda'];
        $nombre1=$rw_factura['nombre'];
        $estado=$rw_factura['estado_factura'];
        //$doc="Constancia de Pago";
        if($ven_com==5){
            $doc="Constancia de Cobro";
        }
        if($ven_com==6){
            $doc="Constancia de Pago";
        }
        
        
        $deuda=$rw_factura['deuda_total'];
        $acuenta=$total-$deuda;
        
        $tienda2=$rw_factura['tienda'];
        
        if($condiciones==1){
            $condiciones1="Efectivo";
        }
        if($condiciones==2){
            $condiciones1="Cheque";
        }
        if($condiciones==3){
            $condiciones1="Transferencia Bancaria";
        }
        if($condiciones==4){
            $condiciones1="Credito";
        }
        
        $tienda1=$_SESSION['tienda'];
	//require_once(dirname(__FILE__).'/../html2pdf.class.php');
   
        
        $sql_factura1=mysqli_query($con,"select * from guia where id_doc='".$id_factura."'");
        $rw_factura1=mysqli_fetch_array($sql_factura1);
        $guia=$rw_factura1['guia'];
        
        $sql_factura2=mysqli_query($con,"select * from sucursal where tienda='".$tienda1."'");
        $rw_factura2=mysqli_fetch_array($sql_factura2);
        $logo=$rw_factura2['foto'];
        $dir=$rw_factura2['direccion'];
        $nombre=$rw_factura2['nombre'];
        $ruc=$rw_factura2['ruc'];
        $correo=$rw_factura2['correo'];
 
if($tienda1==$tienda2){
    $sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
    $rw_cliente=mysqli_fetch_array($sql_cliente);
    if($rw_cliente['doc']>0){
        $doc1=$rw_cliente['doc'];
        $tipo_doc=RUC;
    }
    if($rw_cliente['dni']>0){
        $doc1=$rw_cliente['dni'];
        $tipo_doc=DNI;
    }
    $sql_cliente1=mysqli_query($con,"select * from facturas where id_factura='$id_factura'");
    $rw_cliente1=mysqli_fetch_array($sql_cliente1);
 
    $sql_vendedor=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
    $rw_vendedor=mysqli_fetch_array($sql_vendedor);
    $vendedor=$rw_vendedor['nombres'];
    
    ?>

    
   <html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="ticket.css" rel="stylesheet" type="text/css">
<script>
    function printPantalla()
{
   document.getElementById('cuerpoPagina').style.marginRight  = "0";
   document.getElementById('cuerpoPagina').style.marginTop = "1";
   document.getElementById('cuerpoPagina').style.marginLeft = "1";
   document.getElementById('cuerpoPagina').style.marginBottom = "0"; 
   document.getElementById('botonPrint').style.display = "none"; 
   window.print();
}
</script>
</head>
<body id="cuerpoPagina">



<div class="zona_impresion">
        <!-- codigo imprimir -->
<br>
<table border="0" align="center" width="315px" style="font-size:15pt;color:black;">
    <tr>
        <td align="center" colspan="2">
            <img src="<?php echo $logo;?>" width="60" height="60">
       </td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            <font size="3"><strong> <?php echo $nombre; ?></strong></font><br>
        RUC: <?php echo $ruc; ?><br>
        <font size="1"><?php echo $dir; ?></font>
       </td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            <strong><font size="3"><?php echo $doc; ?></font></strong><br>
                
            <font size="3"><?php $numero_factura2=str_pad($numero_factura, 8, "0", STR_PAD_LEFT);print"$numero_factura2"; ?></font>   
                
                
       </td>
    </tr>
   <tr>
        <td align="right"><strong>DESPACHADO:</strong> </td><td><?php echo strtoupper($vendedor); ?></td>
    </tr>
   
    
    <tr>
        <td align="right"><?php echo "<strong>FECHA:</strong></td><td>".date("d/m/Y H:i", strtotime($fecha_factura)); ?> </td>
    </tr> 
    <tr>
        <td align="right"><strong>CLIENTE:</strong></td><td> <?php echo $rw_cliente['nombre_cliente']; ?></td>
    </tr>
    
     <tr>
        <td align="right"><strong><?php echo $tipo_doc; ?>:</strong></td><td> <?php echo $doc1; ?></td>
    </tr>
     <?php
    if($nombre<>""){
        
    
     ?>
        <tr>
        <td align="right"><strong>OPERACION:</strong></td><td> <?php echo $nombre1; ?></td>
    </tr>
    <?php
   
        
    }
    
    ?>

    
    <tr>
      <td align="right"><strong>MONTO:</strong></td><td> <?php echo moneda;echo number_format($total,2); ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>      
    <tr>
        <td colspan="2" align="center"><strong><font size="3">¡Gracias por su preferencia, que Dios lo bendiga!</font></strong></td>
    </tr>
    
    
</table>
<br>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<p>
  
<div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>
</body>
</html>

<?php

}

function unidad($numuero){
switch ($numuero)
{
case 9:
{
$numu = "NUEVE";
break;
}
case 8:
{
$numu = "OCHO";
break;
}
case 7:
{
$numu = "SIETE";
break;
} 
case 6:
{
$numu = "SEIS";
break;
} 
case 5:
{
$numu = "CINCO";
break;
} 
case 4:
{
$numu = "CUATRO";
break;
} 
case 3:
{
$numu = "TRES";
break;
} 
case 2:
{
$numu = "DOS";
break;
} 
case 1:
{
$numu = "UN";
break;
} 
case 0:
{
$numu = "";
break;
} 
}
return $numu; 
}

function decena($numdero){

if ($numdero >= 90 && $numdero <= 99)
{
$numd = "NOVENTA ";
if ($numdero > 90)
$numd = $numd."Y ".(unidad($numdero - 90));
}
else if ($numdero >= 80 && $numdero <= 89)
{
$numd = "OCHENTA ";
if ($numdero > 80)
$numd = $numd."Y ".(unidad($numdero - 80));
}
else if ($numdero >= 70 && $numdero <= 79)
{
$numd = "SETENTA ";
if ($numdero > 70)
$numd = $numd."Y ".(unidad($numdero - 70));
}
else if ($numdero >= 60 && $numdero <= 69)
{
$numd = "SESENTA ";
if ($numdero > 60)
$numd = $numd."Y ".(unidad($numdero - 60));
}
else if ($numdero >= 50 && $numdero <= 59)
{
$numd = "CINCUENTA ";
if ($numdero > 50)
$numd = $numd."Y ".(unidad($numdero - 50));
}
else if ($numdero >= 40 && $numdero <= 49)
{
$numd = "CUARENTA ";
if ($numdero > 40)
$numd = $numd."Y ".(unidad($numdero - 40));
}
else if ($numdero >= 30 && $numdero <= 39)
{
$numd = "TREINTA ";
if ($numdero > 30)
$numd = $numd."Y ".(unidad($numdero - 30));
}
else if ($numdero >= 20 && $numdero <= 29)
{
if ($numdero == 20)
$numd = "VEINTE ";
else
$numd = "VEINTI".(unidad($numdero - 20));
}
else if ($numdero >= 10 && $numdero <= 19)
{
switch ($numdero){
case 10:
{
$numd = "DIEZ ";
break;
}
case 11:
{ 
$numd = "ONCE ";
break;
}
case 12:
{
$numd = "DOCE ";
break;
}
case 13:
{
$numd = "TRECE ";
break;
}
case 14:
{
$numd = "CATORCE ";
break;
}
case 15:
{
$numd = "QUINCE ";
break;
}
case 16:
{
$numd = "DIECISEIS ";
break;
}
case 17:
{
$numd = "DIECISIETE ";
break;
}
case 18:
{
$numd = "DIECIOCHO ";
break;
}
case 19:
{
$numd = "DIECINUEVE ";
break;
}
} 
}
else
$numd = unidad($numdero);
return $numd;
}

function centena($numc){
if ($numc >= 100)
{
if ($numc >= 900 && $numc <= 999)
{
$numce = "NOVECIENTOS ";
if ($numc > 900)
$numce = $numce.(decena($numc - 900));
}
else if ($numc >= 800 && $numc <= 899)
{
$numce = "OCHOCIENTOS ";
if ($numc > 800)
$numce = $numce.(decena($numc - 800));
}
else if ($numc >= 700 && $numc <= 799)
{
$numce = "SETECIENTOS ";
if ($numc > 700)
$numce = $numce.(decena($numc - 700));
}
else if ($numc >= 600 && $numc <= 699)
{
$numce = "SEISCIENTOS ";
if ($numc > 600)
$numce = $numce.(decena($numc - 600));
}
else if ($numc >= 500 && $numc <= 599)
{
$numce = "QUINIENTOS ";
if ($numc > 500)
$numce = $numce.(decena($numc - 500));
}
else if ($numc >= 400 && $numc <= 499)
{
$numce = "CUATROCIENTOS ";
if ($numc > 400)
$numce = $numce.(decena($numc - 400));
}
else if ($numc >= 300 && $numc <= 399)
{
$numce = "TRESCIENTOS ";
if ($numc > 300)
$numce = $numce.(decena($numc - 300));
}
else if ($numc >= 200 && $numc <= 299)
{
$numce = "DOSCIENTOS ";
if ($numc > 200)
$numce = $numce.(decena($numc - 200));
}
else if ($numc >= 100 && $numc <= 199)
{
if ($numc == 100)
$numce = "CIEN ";
else
$numce = "CIENTO ".(decena($numc - 100));
}
}
else
$numce = decena($numc);

return $numce; 
}

function miles($nummero){
if ($nummero >= 1000 && $nummero < 2000){
$numm = "MIL ".(centena($nummero%1000));
}
if ($nummero >= 2000 && $nummero <10000){
$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
}
if ($nummero < 1000)
$numm = centena($nummero);

return $numm;
}

function decmiles($numdmero){
if ($numdmero == 10000)
$numde = "DIEZ MIL";
if ($numdmero > 10000 && $numdmero <20000){
$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000)); 
}
if ($numdmero >= 20000 && $numdmero <100000){
$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000)); 
} 
if ($numdmero < 10000)
$numde = miles($numdmero);

return $numde;
} 

function cienmiles($numcmero){
if ($numcmero == 100000)
$num_letracm = "CIEN MIL";
if ($numcmero >= 100000 && $numcmero <1000000){
$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000)); 
}
if ($numcmero < 100000)
$num_letracm = decmiles($numcmero);
return $num_letracm;
} 

function millon($nummiero){
if ($nummiero >= 1000000 && $nummiero <2000000){
$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
}
if ($nummiero >= 2000000 && $nummiero <10000000){
$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
}
if ($nummiero < 1000000)
$num_letramm = cienmiles($nummiero);

return $num_letramm;
} 

function decmillon($numerodm){
if ($numerodm == 10000000)
$num_letradmm = "DIEZ MILLONES";
if ($numerodm > 10000000 && $numerodm <20000000){
$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000)); 
}
if ($numerodm >= 20000000 && $numerodm <100000000){
$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000)); 
}
if ($numerodm < 10000000)
$num_letradmm = millon($numerodm);

return $num_letradmm;
}

function cienmillon($numcmeros){
if ($numcmeros == 100000000)
$num_letracms = "CIEN MILLONES";
if ($numcmeros >= 100000000 && $numcmeros <1000000000){
$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000)); 
}
if ($numcmeros < 100000000)
$num_letracms = decmillon($numcmeros);
return $num_letracms;
} 

function milmillon($nummierod){
if ($nummierod >= 1000000000 && $nummierod <2000000000){
$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod >= 2000000000 && $nummierod <10000000000){
$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod < 1000000000)
$num_letrammd = cienmillon($nummierod);

return $num_letrammd;
} 


function convertir($numero){
$numf = milmillon($numero);
return $numf;
}
ob_end_flush();
?>


