<?php
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
	$id_cliente=$rw_factura['id_cliente'];
	$id_vendedor=$rw_factura['id_vendedor'];
	$estado_factura=$rw_factura['estado_factura'];
	$condiciones=$rw_factura['condiciones'];
        $moneda=$rw_factura['condiciones'];
        $folio=$rw_factura['folio'];
        $fecha=$rw_factura['fecha_factura'];
        $estado=$rw_factura['estado_factura'];
        $tienda2=$rw_factura['tienda'];
        $tienda1=$_SESSION['tienda'];
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
   
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">  
    <script type="text/javascript">
 
    
    
function imprSelec(muestra)
{
    var ficha=document.getElementById(muestra);var ventimp=window.open(' ','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();
    window.close();

}
</script>
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

<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}

</style>

<div><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>
<body id="cuerpoPagina">



<div class="zona_impresion">

    <?php

if($tienda1==$tienda2){
    ?>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        
    </page_footer>
    <table cellspacing="0" style="width: 100%;">
        <tr>

            <td style="width: 25%; color: #444444;">
       
            </td>
			<td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
               
                
            </td>
			<td style="width: 25%;text-align:right">
			GUIA Nro <?php echo $numero_factura;?>
			</td>
			
        </tr>
    </table>
    
    

	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        
    </table>
        <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:60%;" class='midnight-blue'>VENDEDOR</td>
            <td style="width:40%;" class='midnight-blue'>FECHA</td>
          
        </tr>
	<tr>
           <td style="width:60%;" >
			<?php 
				$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo $rw_user['nombres'];
			?>
		   </td>
		  <td style="width:40%;"><?php echo date("d/m/Y", strtotime($fecha));?></td>
		   
        </tr>
    </table>
	<br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 60%" class='midnight-blue'>DESCRIPCION</th>
             <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th> 
        </tr>
<?php
$nums=1;
$sumador_total=0;
$sql=mysqli_query($con, "select * from products, detalle_factura where detalle_factura.activo=0 and products.id_producto=detalle_factura.id_producto and detalle_factura.ven_com=2 and detalle_factura.tipo_doc=$estado_factura and detalle_factura.folio='$folio' and detalle_factura.fecha='$fecha' and detalle_factura.numero_factura=$numero_factura and detalle_factura.tienda='".$tienda2."' ORDER BY  `detalle_factura`.`id_detalle` ASC ");
//print"select * from products, detalle_factura, facturas where detalle_factura.activo=0 and products.id_producto=detalle_factura.id_producto and facturas.ven_com=2 and facturas.estado_factura=detalle_factura.tipo_doc and detalle_factura.folio='$folio' and detalle_factura.fecha='$fecha' and detalle_factura.numero_factura=facturas.numero_factura and facturas.id_factura='".$id_factura."' ORDER BY  `detalle_factura`.`id_detalle` ASC ";
//print"select * from products, detalle_factura where detalle_factura.activo=0 and products.id_producto=detalle_factura.id_producto and detalle_factura.ven_com=2 and detalle_factura.tipo_doc=$estado_factura and detalle_factura.folio='$folio' and detalle_factura.fecha='$fecha' and detalle_factura.numero_factura=$numero_factura and detalle_factura.tienda='".$tienda2."' ORDER BY  `detalle_factura`.`id_detalle` ASC ";
while ($row=mysqli_fetch_array($sql))
	{
	$id_producto=$row["id_producto"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad'];
	$nombre_producto=$row['nombre_producto'];
	$precio_venta=$row['precio_venta'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
        $mon=moneda;
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
        
	?>
        <tr>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_venta_f;?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: right"><?php echo $precio_total_f;?></td>
            
        </tr>
	<?php 
	$nums++;
	}
	$subtotal=number_format($sumador_total,2,'.','');
        
        
        
        ?>  
       <tr>
          
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL <?PHP echo $mon;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
        </tr>
    </table>
	
	<br>
</page>

</div>

</body>
<?php 


}
ob_end_flush(); 
?>