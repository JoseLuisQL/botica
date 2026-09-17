<?php
include('is_logged.php');
?>
<!DOCTYPE html>
<html>
<head>
    
    
    <script type="text/javascript">
                        $(document).ready(function(){
                        //$('#entero').numeric();
                        $('input[type=number]').numeric("."); 
                        });
                        </script>
    
</head>
<?php
	
//include('is_logged.php');
$session_id= session_id();
$tienda=$_SESSION['tienda'];
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){
    $precio_venta=$_POST['precio_venta'];
    $porciones = explode("-", $precio_venta);
$precio_venta=$porciones[0]; // porción1
$tipo=$porciones[1]; // porción2

    
}
if (isset($_POST['stock'])){$stock=$_POST['stock'];}
require_once ("../config/db.php");
require_once ("../config/conexion.php");	
if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and ($cantidad>0) and ($precio_venta>0))
{
    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM tmp where id_producto='$id' and session_id='$session_id'");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
    //if($numrows==0){
        $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda,fecha1,fecha2,lote) VALUES ('$id','$cantidad','$precio_venta','$session_id','$tipo','0000-00-00','0000-00-00','')");
    //}else{            
      //  print"Producto Repetido";
    //}    
    
}
if (isset($_GET['id']))
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_tmp."'");
}
?>
<div class="display_box" align="left">
<table  style="color:black;width:100%;">
<tr style="background:#0489B1;color:white;">
	
	<th style="width:5%;" class='text-center'>CANT.</th>
        
	<th style="width:50%;">DESCRIPCION</th>
	<th style="width:5%;" class='text-center'>P.U.</th>
	<th style="width:10%;" class='text-center'>TOTAL</th>
        <th style="width:5%;"></th>
</tr>
<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from tmp where tmp.session_id='".$session_id."' ORDER BY  `tmp`.`id_tmp` ASC ");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$id=$row["id_producto"];
	$cantidad=$row['cantidad_tmp'];
        $fecha1=$row['fecha1'];
        $fecha2=$row['fecha2'];
        $tipo=$row['tienda'];
        $lote=$row['lote'];
	$nombre_producto=$row["id_producto"];
        $codigo_producto="";
        
        if($tipo==1){
            $tipo1="unidad";
        }
        if($tipo==2){
            $tipo1="Blister";
        }
        if($tipo==3){
            $tipo1="Caja";
        }
        
        if($id>0 and is_numeric($id)){
            $sql1=mysqli_query($con, "select * from products,und where und.id_und=products.und_pro and id_producto='".$id."'");
            $row1=mysqli_fetch_array($sql1);
            $nombre_producto=$row1['nombre_producto'];
            $codigo_producto=$row1['codigo_producto'];
            $und1=$row1['und1'];
            $min=0.1;
            $step=0.1;
            if($und1==1){
                $min=1;
                $step=1;
            }
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
			
                        <td class='text-center' style="background:white;"><input type="number" min="<?php echo $min;?>" step="<?php echo $step;?>" onchange="sumar(<?php echo $id_tmp;?>);" id="cantidad_tmp-<?php echo $id_tmp;?>" name="cantidad_tmp-<?php echo $id_tmp;?>" class="monto input" style="width:70px;height:40px;background:#E6E6E6;text-align:right;height:40px;border:1px solid black;;line-height: 50px;text-align:center;" value="<?php echo round($cantidad,2);?>"></td>
			
                        <td style="background:white;"><?php echo $nombre_producto;?> <font color=red><?php echo $tipo1;?></font>
                        <a style='cursor: pointer;' onClick="muestra_oculta('contenido-<?php echo $id_tmp;?>')" title="" class="boton_mostrar">Lote</a>
                        
                        
                        </td>
                        <td class='text-right' style="background:white;"><input type="number"  min="0.01" step="0.01" onchange="sumar1(<?php echo $id_tmp;?>,<?php echo round($precio_venta_f,2);?>);" id="precio_tmp-<?php echo $id_tmp;?>" name="precio_tmp-<?php echo $id_tmp;?>" class="monto input" style="width:70px;height:40px;background:#E6E6E6;text-align:right;height:40px;border:1px solid black;line-height: 50px;text-align:center;" value="<?php echo round($precio_venta_f,2);?>"></td>
                        <td class='text-right' style="background:white;"><input class="monto total" type="text" readonly value="<?php echo $precio_total_f;?>" style="width:100%;height:40px;text-align:right;" id="sub-<?php echo $id_tmp;?>"></td>
			<td class='text-center' style="background:white;"><a href="#" class='btn btn-danger btn-xs' onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>
                <tr style="background:white;">
			<td class='text-right' style="background:white;"></td>
                        <td  style="background:white;">
                            <div id="contenido-<?php echo $id_tmp;?>" style="display:none;">
                            <table>
                            <tr><td>Ffab:</td>
                            
                                <td><input id="fecha1-<?php echo $id_tmp;?>" name="fecha1-<?php echo $id_tmp;?>" type="date" style="text-align: left;" value="<?php echo $fecha1;?>"></td>
                            </tr>
                            <tr>
                                <td>Fvco:</td><td><input id="fecha2-<?php echo $id_tmp;?>" name="fecha2-<?php echo $id_tmp;?>"   type="date" value="<?php echo $fecha2;?>"></td>
                            </tr>
                            
                            <tr>
                                <td>Lote: </td><td><textarea  id="lote-<?php echo $id_tmp;?>" name="lote-<?php echo $id_tmp;?>"  style="width:130px;background:#E6E6E6;text-align:left;height:30px;"><?php echo $lote;?></textarea></td>
                            </tr>
                            </table>
                            </div>    
                        </td>
			<td class='text-center' style="background:white;"></td>
                        <td class='text-right' style="background:white;"></td>
                        <td class='text-right' style="background:white;"></td>
                        
			
		</tr>
		<?php
	}
	$subtotal=number_format($sumador_total,2,'.','');
	
	
	$total_factura=$subtotal/1.18;
        $total_iva=$total_factura*0.18;

    if($_SESSION['tipo']==0)
        {
        
?> 
                
                
<tr style="background:white;">
	<td class='text-right' colspan=3 style="background:white;">TOTAL</td>
	<td class='text-right' style="background:white;"><input class="monto totales" id="total" style="width:100%;height:40px;text-align:right;" type="text" value="<?php echo number_format($subtotal,2);?>"></td>
	<td></td>
</tr>                
                



<?php
    } 
    
    
        
?> 
                


</table>
</div>
</body>

<?php
//header("Content-type: application/vnd.ms-excel" ) ; 
//        header("Content-Disposition: attachment; filename=stockmin.xls" ) ;

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
function sumar(id){
    
    var cantidad = $("#cantidad_tmp-"+id).val();
    
    var total=document.getElementById("total").value;
    if(cantidad<=0){
        alert("No puede ser negativo");
        document.getElementById("cantidad_tmp-"+id).value = 1;
        var precio1 = $("#precio_tmp-"+id).val();
        var sub1=document.getElementById("sub-"+id).value;
        document.getElementById("sub-"+id).value = precio1;
        var total1=1*total-1*sub1+1*precio1;
        document.getElementById("total").value=total1.toFixed(2);
    }
 }
 
 function sumar1(id,precio){
    
    var precio1 = $("#precio_tmp-"+id).val();
    var cantidad = $("#cantidad_tmp-"+id).val();
    var total=document.getElementById("total").value;
    
    if(precio1<=0){
        alert("No puede ser negativo");
        document.getElementById("precio_tmp-"+id).value = precio;
        
        var sub1=document.getElementById("sub-"+id).value;
        
        document.getElementById("sub-"+id).value = (precio*cantidad).toFixed(2);
        var total1=1*total-1*sub1+1*precio*cantidad;
        document.getElementById("total").value=total1.toFixed(2);
        
    }
 }

$(document).ready(function(){

    $('input[type=number]').blur(function(){

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


$(document).ready(function(){

    $('input[type="date"]').blur(function(){

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


function muestra_oculta(id){
if (document.getElementById){ //se obtiene el id
var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
}
}
window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
muestra_oculta('contenido');/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
}
</script>

  