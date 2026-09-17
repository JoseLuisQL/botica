<?php
include('is_logged.php');
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}
if (isset($_POST['stock'])){$stock=$_POST['stock'];}
if (isset($_POST['lote'])){$lote=$_POST['lote'];}
require_once ("../config/db.php");
require_once ("../config/conexion.php");	
if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and ($cantidad>0) and ($precio_venta>0))
{
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM tmp where id_producto='$id' and session_id='$session_id'");
    $row= mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $numrows1=0;
    $count_query1   = mysqli_query($con, "SELECT sum(final) AS numrows1 FROM lote where id_producto='$id' and id_lote='$lote'");
    $row1= mysqli_fetch_array($count_query1);
    $numrows1 = $row1['numrows1']*1;
    
    //print"SELECT sum(final) AS numrows1 FROM lote where id_producto='$id' and lote='$lote'";
    if($numrows==0){
        if($lote>0){
            $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda,fecha1,fecha2,lote) VALUES ('$id','$cantidad','$precio_venta','$session_id','$numrows1','0000-00-00','0000-00-00','$lote')");
        }
        if($lote==0){
           $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda,fecha1,fecha2,lote) VALUES ('$id','$cantidad','$precio_venta','$session_id','$stock','0000-00-00','0000-00-00','$lote')"); 
        }
    }else{            
        print"Producto Repetido";
    }     
        
}
if (isset($_GET['id']))
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_tmp."'");
}
?>
<table class="table" style="color:black;">
<tr class="warning">
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th>DESCRIPCION</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from products, tmp where products.id_producto=tmp.id_producto and tmp.session_id='".$session_id."' ORDER BY  `tmp`.`id_tmp` ASC ");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['nombre_producto'];
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,2);
	$precio_venta_r=str_replace(",","",$precio_venta_f);
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);
	$precio_total_r=str_replace(",","",$precio_total_f);
	$sumador_total+=$precio_total_r;
		?>
		<tr style="background:white;">
			<td class='text-center' style="background:white;"><?php echo $codigo_producto;?></td>
			<td class='text-center' style="background:white;"><?php echo $cantidad;?></td>
			<td style="background:white;"><?php echo $nombre_producto;?></td>
			<td class='text-right' style="background:white;"><?php echo $precio_venta_f;?></td>
			<td class='text-right' style="background:white;"><?php echo $precio_total_f;?></td>
			<td class='text-center' style="background:white;"><a href="#" class='btn btn-danger btn-xs' onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$subtotal=number_format($sumador_total,2,'.','');
	
	
	$total_factura=$subtotal/(1+iva);
        $total_iva=$total_factura*iva;

?>
<tr style="background:white;">
	<td class='text-right' colspan=4 style="background:white;">TOTAL</td>
	<td class='text-right' style="background:white;"><?php echo number_format($subtotal,2);?></td>
	<td></td>
</tr>
</table>
