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
    .monto4 {text-align:center;}
    .monto5 {text-align:center;}
    .totales {font-weight:bold;}
    </style>
    <script type="text/javascript">
                        $(document).ready(function(){
                        //$('#entero').numeric();
                        $('input[type=number]').numeric("."); 
                        });
                        </script>
    
    
</head>
<?php
require_once ("../config/db.php");
require_once ("../config/conexion.php");	
//include('is_logged.php');
$session_id= session_id();
$tienda=$_SESSION['tienda'];
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){
    $precio_venta=$_POST['precio_venta'];
    $porciones = explode("-", $precio_venta);
    $precio_venta=$porciones[0]; // porción1
    if (isset($porciones[1])){
    $tipo=$porciones[1]; // porción2
    }else{
    $tipo=1; // porción2
    }
    $stock7=1000000000;
    $c9=1;
    if($id>0){
        $sql7=mysqli_query($con, "select * from products where id_producto=$id");
	while ($row7=mysqli_fetch_array($sql7)){
            if($tipo==1){
                $c9=1;
            }
            if($tipo==2){
                $c9=$row7['blister'];
            }
            if($tipo==3){
                $c9=$row7['caja'];
            }
            $stock7=$row7["b$tienda"];
        }
    }
}
if (isset($_POST['stock'])){$stock=$_POST['stock'];}

//print"INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda) VALUES ('$id','$cantidad','$precio_venta','$session_id','$stock')";

    
if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and ($cantidad>0) and ($precio_venta>0) and $stock7>=$cantidad*$c9)

{

    $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM tmp where id_producto='$id' and session_id='$session_id'");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
    //if($numrows==0){
        $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda,fecha1,fecha2,lote) VALUES ('$id','$cantidad','$precio_venta','$session_id','$tipo','0000-00-00','0000-00-00','0')");
    //}else{            
        //if($cantidad*1>0){
         //print"Producto Repetido";   
        //}
        
    //}
    
    
}
if (isset($_GET['id']))
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp WHERE id_tmp='".$id_tmp."'");
}


if (isset($_GET['serie2']))
{
$serie2=$_GET['serie2'];
$porciones = explode("-",$serie2);
$pre=$porciones[0];
$tip=$porciones[1];
$id1=$porciones[2];
$id2=$porciones[3];

$sql2=mysqli_query($con, "select * from tmp where id_tmp='".$id2."'");
$row2=mysqli_fetch_array($sql2);
$cant=$row2["cantidad_tmp"];


$sql1=mysqli_query($con, "select * from products where id_producto='".$id1."'");
$row1=mysqli_fetch_array($sql1);
$stock=$row1["b$tienda"];
$bli=$row1["blister"];
$caj=$row1["caja"];
if($tip==1){
    $stock1=$cant;
}
if($tip==2){
    $stock1=$cant*$bli;
}
if($tip==3){
    $stock1=$cant*$caj;
}
//print"$serie2";
if($stock1<=$stock){
    $cambiar=mysqli_query($con, "UPDATE tmp set tienda='$tip',precio_tmp='$pre'  WHERE id_tmp='".$id2."'");
}else{
    print"Ha sobrepasado el stock($stock) se requiere cambiar de cantidad ";
}

}

?>
<div class="display_box" align="left">
<table  style="color:black;width:100%;">
<tr style="background:#0489B1;color:white;">
	<th style="width:10%;" class='text-center' >CODIGO</th>
	<th style="width:5%;" class='text-center'>CANT.</th>
	<th style="width:50%;">DESCRIPCION</th>
	<th style="width:5%;" class='text-center'>PRECIO UNIT.</th>
	<th style="width:10%;" class='text-center'>PRECIO TOTAL</th>
	<th style="width:10%;"></th>
</tr>
<?php
	$sumador_total=0;
	$sql=mysqli_query($con, "select * from tmp where tmp.session_id='".$session_id."' ORDER BY  `tmp`.`id_tmp` ASC ");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$id=$row["id_producto"];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row["id_producto"];
        $codigo_producto="";
        $min=1;
        $step=1;
        $tipo=$row["tienda"];
        if($tipo==1){
            $tipo1="unidad";
        }
        if($tipo==2){
            $tipo1="Blister";
        }
        if($tipo==3){
            $tipo1="Caja";
        }
        
        $b2=100000000000;
         $t7=1;
         $p2=0;
         $p3=0;
         $z1="";
         $z2="";
         $z3="";
        if($id>0){
            $sql1=mysqli_query($con, "select * from products,und,precios where precios.id_producto=products.id_producto and und.id_und=products.und_pro and products.id_producto='".$id."'");
            $row1=mysqli_fetch_array($sql1);
            $nombre_producto=$row1['nombre_producto'];
            $codigo_producto=$row1['codigo_producto'];
            $bli=$row1['bli'];
            $p1=round($row1["p1"],2);                                
            $p2=round($row1['p2'],2); 
            $p3=round($row1['p3'],2);   
            
            
            $t1=$row1['blister'];
            $t2=$row1['caja'];
            if($tipo==1){
                $t7=1;
                $z1="selected";
                
            }
            if($tipo==2){
                $t7=$t1;
                $z2="selected";
            }
            if($tipo==3){
                $t7=$t2;
                $z3="selected";
            }
            
            $b2=round($row1["b$tienda"],0);
            if($_SESSION['val']==2){
                $b2=100000000000;
            }
            $und1=$row1['und1'];
            $min=0.1;
            $step=0.1;
            if($und1==1){
                $min=1;
                $step=1;
            }
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
                        <td class='text-center' style="background:white;"><input type="number" onchange="sumar(<?php echo $id_tmp;?>,<?php echo $b2;?>);" min="<?php echo $min;?>" step="<?php echo $step;?>" max="<?php echo $b2;?>" id="cantidad_tmp-<?php echo $id_tmp;?>" name="cantidad_tmp-<?php echo $id_tmp;?>" class="monto input" style="width:70px;background:#E6E6E6;text-align:right;height:40px;line-height: 50px;text-align:center;" value="<?php echo round($cantidad,2);?>"></td>
                        <input type="hidden" value="<?php echo $t7;?>" id="c7-<?php echo $id_tmp;?>" name="c7-<?php echo $id_tmp;?>">
                        <td style="background:white;"><?php echo $nombre_producto;?> 
                            
                             <select  tabindex="-1" onchange="serie(<?php echo $id_tmp;?>)" id="serie<?php echo $id_tmp;?>" style="background:#F5DA81;text-align:right;height:40px;line-height: 50px;text-align:center;">
                                        
                                        <option value="<?php print"$p1-1-$id-$id_tmp";?>" <?php echo $z1;?>>Unidad: <?php echo $p1;?></option>
                                        <?php
                                        if($p2>0){
                                            ?>
                                        <option value="<?php print"$p2-2-$id-$id_tmp";?>" <?php echo $z2;?>><?php echo $bli;?>: <?php echo $p2;?></option>
                                         <?php
                                        }
                                        if($p3>0){
                                            ?>
                                        
                                        
                                        <option value="<?php print"$p3-3-$id-$id_tmp";?>" <?php echo $z3;?>>Caja: <?php echo $p3;?></option>
                                        <?php
                                        }
                                        ?>
                             </select>            
                            
                        
                        </td>
                        <td class='text-right' style="background:white;"><input type="number" min="0.01" step="0.01" onchange="sumar1(<?php echo $id_tmp;?>,<?php echo round($precio_venta_f,2);?>);" id="precio_tmp-<?php echo $id_tmp;?>" name="precio_tmp-<?php echo $id_tmp;?>" class="monto input" style="width:70px;background:#E6E6E6;text-align:right;height:40px;line-height: 50px;text-align:center;" value="<?php echo str_replace(",","",number_format($precio_venta_f,2));?>" readonly></td>
                       
                        <td class='text-right' style="background:white;"><input class="monto total" type="text" readonly value="<?php echo $precio_total_f;?>" style="width:100%;height:40px;text-align:right;" id="sub-<?php echo $id_tmp;?>"></td>
			<td class='text-center' style="background:white;"><a href="#" class='btn btn-danger btn-xs' onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>	
		<?php
	}
	$subtotal=number_format($sumador_total,2,'.','');
	
	
	$total_factura=$subtotal/1.18;
        $total_iva=$total_factura*0.18;

       
?>
<tr style="background:white;">
	<td class='text-right' colspan=4 style="background:white;">TOTAL</td>
	<td class='text-right' style="background:white;"><input class="monto totales" id="total" style="width:100%;height:40px;text-align:right;" type="text" value="<?php echo number_format($subtotal,2);?>"></td>
	<td></td>
</tr>
</table>
</div>
</body>
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
    
    // obtenemos todos los totales y los sumamos
    var totales=e.querySelectorAll(".total");
    totales.forEach(function(e) {
        total+=parseFloat(e.value);
        total1+=parseFloat(e.value);
    });
    
    
    // mostramos la suma total con dos decimales
    e.getElementsByClassName("totales")[0].value=total.toFixed(2);
    e.getElementsByClassName("monto1")[0].value=total1.toFixed(2);
    
}
</script>


<script type="text/javascript">


function sumar(id,stock){
    
    var cantidad = $("#cantidad_tmp-"+id).val();
    var c7 = $("#c7-"+id).val();
    var total=document.getElementById("total").value;
    <?php
    if($_SESSION['val']==1){
        ?>
        if(stock<cantidad*c7){
        alert("Ha sobrepasado el stock="+stock);
        document.getElementById("cantidad_tmp-"+id).value = 1;
        var precio1 = $("#precio_tmp-"+id).val();
        var sub1=document.getElementById("sub-"+id).value;
        document.getElementById("sub-"+id).value = precio1;
        var total1=1*total-1*sub1+1*precio1;
        document.getElementById("total").value=total1.toFixed(2);
    }
    <?php
    }    
    ?>
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
 
 //function sumar1(id,precio){
    
  //  var precio1 = $("#precio_tmp-"+id).val();
    
 //   if(precio1<0){
 //       alert("No puede ser negativo");
  //      document.getElementById("precio_tmp-"+id).value = precio;
  //  }
 //}
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

        field.css('background-color','#D0F5A9');

        var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name');

        $.ajax({

            type: "POST",

            url: "ajax/edit.php",

            data: dataString,

        });

    });

});

</script>

  