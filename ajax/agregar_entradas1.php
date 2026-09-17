<?php
ob_start();
include('is_logged.php');
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        input {
  float: right;
  clear: both;
}
        
    </style>    
</head>
<?php
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}
if (isset($_POST['stock'])){$stock=$_POST['stock'];}
if (isset($_POST['lote'])){$lote=$_POST['lote'];}
require_once ("../config/db.php");
require_once ("../config/conexion.php");	
if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and ($cantidad>0) and ($precio_venta>0) )
{
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM tmp where id_producto='$id' and session_id='$session_id'");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
    if($numrows==0){
        $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda,fecha1,fecha2,lote) VALUES ('$id','$cantidad','$precio_venta','$session_id','$stock','0000-00-00','0000-00-00','$lote')");
    }else{            
        print"Producto Repetido";
    }    
    
}
if (isset($_GET['id']))
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_tmp."'");
}

if (isset($_GET['lote']))
{
$lote=$_GET['lote'];
//print"$precio2 1";
$porciones = explode("-",$lote);
$id1=$porciones[0];
$lote1=$porciones[1];

$cambiar=mysqli_query($con, "UPDATE tmp set lote='$lote1'  WHERE id_tmp='".$id1."'");
}


?>
<div class="display_box" align="left">
<table  style="color:black;width:100%;" border="1">
<tr style="background:#0489B1;color:white;">
	
	<th style="width:5%;" class='text-center'>CANT.</th>
        
	<th style="width:50%;">DESCRIPCION</th>
        <th style="width:50%;">LOTE</th>
	<th style="width:50%;"></th>
        <th style="width:5%;"></th>
</tr>
<?php
	$sumador_total=0;
        $cont=0;
	$sql=mysqli_query($con, "select * from tmp where tmp.session_id='".$session_id."' ORDER BY  `tmp`.`id_tmp` ASC ");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$id=$row["id_producto"];
	$cantidad=$row['cantidad_tmp'];
        $id_lote=$row['lote'];
	$nombre_producto=$row["id_producto"];
        $codigo_producto="";
        if($id>0 and is_numeric($id)){
            $sql1=mysqli_query($con, "select * from products where id_producto='".$id."'");
            $row1=mysqli_fetch_array($sql1);
            $nombre_producto=$row1['nombre_producto'];
            $codigo_producto=$row1['codigo_producto'];
            //print"1";
        }
        $lote="";
        if($id_lote>0){
            $sql11=mysqli_query($con, "select * from lote where id_lote='".$id_lote."'");
            $row11=mysqli_fetch_array($sql11);
            $lote=$row11['lote'];
           
            //print"1";
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
			
                        <td class='text-center' style="background:white;"><textarea id="cantidad_tmp-<?php echo $id_tmp;?>" name="cantidad_tmp-<?php echo $id_tmp;?>" class="monto input" style="width:60px;background:#E6E6E6;text-align:right;height:40px;"><?php echo round($cantidad,2);?></textarea></td>
			
                        <td style="background:white;"><?php echo $nombre_producto;?></td>
                        <td style="background:white;width:20%;"><?php echo $lote;?></td>
                         <td class='text-center'><select class="select2_single form-control" tabindex="-1" onchange="lote(<?php echo $cont;?>)" id="lote<?php echo $cont;?>" >
                                                    <option value="">-- Escoger LOTE --</option>
			
                                                <?php
                                       
                                        //if($id>0){
                                        $sql3="select * from lote where id_producto=$id";
                                        $rs3=mysqli_query($con,$sql3);
                                        while($row4=mysqli_fetch_array($rs3)){
                                            
                                            
                                            $lote=$row4["lote"];
                                            
                                            
                                            
                                            
                                            $id_lote=$row4["id_lote"];
                                            $lote1=$id_tmp."-".$id_lote;
                                            
                                           //if (!in_array($row4["id_serie"], $porciones1)) { 
                                           ?>

                                        <option style="width:200px;" value="<?php echo $lote1;?>"><?php  echo $lote;?></option>
                                        
                                            <?php
                                        $cont=$cont+1;
                                        }
                                        
                                        ?>    
                                                </select> 
                                                </td>
                        
                        <td class='text-center' style="background:white;"><a href="#" class='btn btn-danger btn-xs' onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	}
	$subtotal=number_format($sumador_total,2,'.','');
	
	
	$total_factura=$subtotal/1.18;
        $total_iva=$total_factura*0.18;

    
       
?> 
 
</table>
</div>
</body>

<?php
header("Content-type: application/vnd.ms-excel" ) ; 
        header("Content-Disposition: attachment; filename=stockmin.xls" ) ;

?>
</html>
<script>
// generamos un evento click y keyup para cada elemento input con la clase .input
var input=document.querySelectorAll(".input");
input.forEach(function(e) {
    e.addEventListener("click",multiplica);
    e.addEventListener("keyup",multiplica);
});
 
// funcion que genera la multiplicacion
function multiplica() {
 
    // nos posicionamos en el tr del producto
    var tr=this.closest("tr");
 
    var total=1;
 
    // recorremos todos los elementos del tr que tienen la clase .input
    var inputs=tr.querySelectorAll(".input");
    inputs.forEach(function(e) {
        total*=e.value;
        
    });
 
    // mostramos el total con dos decimales
    tr.querySelector(".total").value=total.toFixed(2);
 
    // indicamos que calcule el total
    calcularTotal(this.closest("table"));
}
 
// funcion que calcula la suma total de los productos
function calcularTotal(e) {
    var total=0;
    var total1=0;
    var total2=0;
    var total3=0;
    var total4=0;
    // obtenemos todos los totales y los sumamos
    var totales=e.querySelectorAll(".total");
    totales.forEach(function(e) {
        total+=parseFloat(e.value);
        total1+=parseFloat(e.value);
    });
    
    total2=total*1.18;
    total3=total*0.18;
    
    
    // mostramos la suma total con dos decimales
    e.getElementsByClassName("totales")[0].value=total.toFixed(2);
    
    <?php
    if($_SESSION['tipo']==1){
    ?>
            
    e.getElementsByClassName("monto4")[0].value=total4.toFixed(2);
    e.getElementsByClassName("monto5")[0].value=total.toFixed(2);    
    <?php
    
        
    }
    
    if($_SESSION['tipo']==0){
        
    
    ?>
    e.getElementsByClassName("monto4")[0].value=total3.toFixed(2);
    e.getElementsByClassName("monto5")[0].value=total2.toFixed(2);  
    <?php
    
        
    }
    
    ?>        
    
}


$(document).ready(function(){

    $('textarea').blur(function(){

        var field = $(this);

        field.css('background-color','#E6E6E6');

        var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name');

        $.ajax({

            type: "POST",

            url: "ajax/edit.php",

            data: dataString,

        });

    });

});
</script>
<?php
ob_end_flush();
?>
  