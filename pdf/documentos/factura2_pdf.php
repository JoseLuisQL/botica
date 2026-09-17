<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
        }
	include("../../config/db.php");
	include("../../config/conexion.php");
	$session_id= session_id();
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No hay productos agregados a la guia')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	
        $id_vendedor=$_SESSION['user_id'];
        $fecha=$_GET['fecha'];
        $hora=$_GET['hora'];
        $dolar=$_GET['tcp'];
        
        
        
        $dias=0;
        $moneda=1;
        $folio=$_GET['serie'];
        $motivo=$_GET['motivo'];
        $moneda1=1;
	$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
	$sql=mysqli_query($con, "select LAST_INSERT_ID(numero_factura) as last from facturas order by id_factura desc limit 0,1 ");
	$rw=mysqli_fetch_array($sql);
	
        if($condiciones==1){
            $sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."' and cantidad_tmp>tienda");
            $count=mysqli_num_rows($sql_count);
            if ($count>0)
            {
            echo "<script>alert('Las cantidades no cumple con el stock')</script>";
            echo "<script>window.close();</script>";
            exit;
            }
        }
        
        
        $tienda1=$_SESSION['tienda'];
        $accion7=mysqli_query($con, "select * from facturas where (estado_factura=9 or estado_factura=10) and tienda=$tienda1 and ven_com=2 ORDER BY  `facturas`.`id_factura` DESC  LIMIT 0 , 1");
        $row7=mysqli_fetch_array($accion7);
        $numero_factura=$row7["numero_factura"]+1;

?>
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
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        
    
    <?php
    date_default_timezone_set('America/Lima');
    ?>
    <table cellspacing="0" style="width: 100%;">
        <tr>

            <td style="width: 25%; color: #444444;">
                <br>
            </td>
            <td style="width: 50%; color: #34495e;font-size:12px;text-align:center"> 
            </td>
            <td style="width: 25%;text-align:right">
                    Guia Nro <?php echo $numero_factura;?>
            </td>
			
        </tr>
    </table>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:50%;" class='midnight-blue'>FACTURADO POR:</td>
        </tr>
		
    </table>
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='midnight-blue'>VENDEDOR</td>
		<td style="width:25%;" class='midnight-blue'>FECHA</td>
		
        </tr>
	<tr>
            <td style="width:35%;">
			<?php 
				$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo $rw_user['nombres'];
			?>
            </td>
            <td style="width:25%;"><?php echo date("d/m/Y");?></td>
            
        </tr> 
    </table>
	<br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 90%" class='midnight-blue'>DESCRIPCION</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 15%;text-align: right" class='midnight-blue'>PRECIO TOTAL</th> 
        </tr>

<?php
$nums=1;
$sumador_total=0;
$servicio=0;
$tipo=$_SESSION['doc_ventas'];
$sql=mysqli_query($con, "select * from products, tmp where products.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$id_producto=$row["id_producto"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
        $id_lote=$row['lote'];
	$nombre_producto=$row['nombre_producto'];
	$precio_venta=$row['precio_tmp'];
        $pro_ser=$row['pro_ser'];
        if ($pro_ser==1){
            $servicio=$servicio+1;
        }
	$precio_venta_f=number_format($precio_venta,2);
	$precio_venta_r=str_replace(",","",$precio_venta_f);
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);
	$precio_total_r=str_replace(",","",$precio_total_f);
	$sumador_total+=$precio_total_r;//Sumador
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
        
        $sql3=mysqli_query($con, "select * from products where id_producto='".$id_producto."'");
        $row3=mysqli_fetch_array($sql3);
        $tienda=$_SESSION['tienda'];
        $b="b$tienda";
        $c=$tienda;
        $d=$row3["b$tienda"];
        $fecha1=date("Y-m-d", strtotime($fecha) );
        $date_added=$fecha1." ".$hora;
        $cond1=10;
        if($condiciones==2){
            $cond1=9;
        }
	$insert_detail=mysqli_query($con, "INSERT INTO detalle_factura VALUES (NULL,'0','$id_vendedor','$numero_factura','$condiciones','$id_producto','$cantidad','$precio_venta_r','$c','0','2','$date_added','0','$cond1','$d','$moneda1','$folio','0','0','0','0','0')");
        $id_detalle=mysqli_insert_id($con);
        
        if($condiciones==2){
            $productos1=mysqli_query($con, "UPDATE products SET $b=$b+$cantidad WHERE id_producto=$id_producto and pro_ser=1"); 
            $cond=9;
            // if($id_lote>0){
            //    $insert_detail=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote','$date_added','$id_detalle','$cantidad','$precio_venta_r','2')");
            //    $lote1=mysqli_query($con, "UPDATE lote SET final=final+$cantidad WHERE id_lote=$id_lote");
            //}
            
            
        }
        if($condiciones==1){
            $productos1=mysqli_query($con, "UPDATE products SET $b=$b-$cantidad WHERE id_producto=$id_producto and pro_ser=1"); 
            $cond=10;
            if($id_lote>0){
                $insert_detail=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote','$date_added','$id_detalle','$cantidad','$precio_venta_r','1')");
                $lote1=mysqli_query($con, "UPDATE lote SET final=final-$cantidad WHERE id_lote=$id_lote");
            }
        }
        $nums++;
	}
	$subtotal=number_format($sumador_total,2,'.','');
	$mon=moneda;
	
        
        
         ?>
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;">TOTAL <?php echo $mon;?> </td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,2);?></td>
        </tr>
    </table>
<br>
</page>
<?php

if($condiciones==4){
    $deuda=$sumador_total;
}else{
    $deuda=0;
}
$fecha1=date("Y-m-d", strtotime($fecha) );
$date=$fecha1." ".$hora;

$cuenta="";


$sql3="select * from caja where tienda= $tienda1 and cierre=0 and usuario_inicio=$id_vendedor ORDER BY caja.id_caja DESC LIMIT 0 , 1";
$rw3=mysqli_query($con,$sql3);//recuperando el registro
$rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
$turno=$rs3["turno"];

$insert=mysqli_query($con,"INSERT INTO facturas VALUES (NULL,'$numero_factura','$date','0','','0','0','$id_vendedor','$condiciones','$sumador_total','0','$cond','$c','2','0','0','$moneda1','$cuenta','$motivo','0','2018-11-11','$dias','$folio','2','','0','','0','$turno')");
$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
?>