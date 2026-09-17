<?php
include('is_logged.php');
?>
<!DOCTYPE html>
<html>
<head>
    <style>
    .monto {text-align:center;}
    .monto1 {text-align:center;}
    .monto2 {text-align:center;}
    .totales {font-weight:bold;}
    </style>
</head>
<?php
	
include('is_logged.php');
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}
if (isset($_POST['stock'])){$stock=$_POST['stock'];}
require_once ("../config/db.php");
require_once ("../config/conexion.php");	
if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and ($cantidad>0) and ($precio_venta>0) and ($cantidad<=$stock))
{
$insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda) VALUES ('$id','$cantidad','$precio_venta','$session_id','$stock')");
}
if (isset($_GET['id']))
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_tmp."'");
}
?>
<table class="table" >
<tr class="warning">
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th>DESCRIPCION</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	
</tr>
<?php
	$sumador_total=0;
        $sql1=mysqli_query($con, "select * from facturas where id_factura='".$_SESSION['id_factura']."'");
        $row1=mysqli_fetch_array($sql1);
        $numero_factura=$row1["numero_factura"];
	$folio=$row1["folio"];
	$estado_factura=$row1['estado_factura'];
	$tienda=$row1["tienda"];
        
	$sql=mysqli_query($con, "select * from tmp where tmp.session_id='".$session_id."' ORDER BY  `tmp`.`id_tmp` ASC ");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$id=$row["id_producto"];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row["id_producto"];
        $codigo_producto="";
        if($id>0){
            $sql1=mysqli_query($con, "select * from products where id_producto='".$id."'");
            $row1=mysqli_fetch_array($sql1);
            $nombre_producto=$row1['nombre_producto'];
            if($nombre_producto==""){
                $nombre_producto=$row["id_producto"];
            }
            $codigo_producto=$row1['codigo_producto'];
        }
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
		?>
		<tr style="background:white;">
			<td class='text-center' style="background:white;"><?php echo $codigo_producto;?></td>
			<td class='text-center' style="background:white;"><?php echo $cantidad;?></td>
			<td style="background:white;"><?php echo $nombre_producto;?></td>
			<td class='text-right' style="background:white;"><?php echo $precio_venta_f;?></td>
                        <td class='text-right' style="background:white;"><?php echo $precio_total_f;?></td>
			
		</tr>		
		<?php
	}
	$subtotal=number_format($sumador_total,2,'.','');
	$total_factura=$subtotal/1.18;
        $total_iva=$total_factura*0.18;

        if ($_SESSION['doc_ventas']==5 or $_SESSION['doc_ventas']==6) {   
?>                
<tr style="background:white;">
	<td class='text-right' colspan=4 style="background:white;">SUBTOTAL</td>
	<td class='text-right' style="background:white;"><input type="text" class="monto1" value="<?php echo number_format($total_factura,2);?>"></td>
	
</tr>
<tr style="background:white;">
	<td class='text-right' colspan=4 style="background:white;">IGV (<?php echo 18?>)% </td>
	<td class='text-right' style="background:white;"><input type="text" class="monto2" value="<?php echo number_format($total_iva,2);?>"></td>
	
</tr>
<?php
        }
?>
<tr style="background:white;">
	<td class='text-right' colspan=4 style="background:white;">TOTAL</td>
	<td class='text-right' style="background:white;"><?php echo number_format($subtotal,2);?></td>
	
</tr>
</table>
</body>
</html>
