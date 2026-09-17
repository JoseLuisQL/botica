<?php
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
include('ajax/is_logged.php');
if($_POST)
{
$i=0;
$q=$_POST['palabra'];//se recibe la cadena que queremos buscar
if(strlen ($q)>=1)
{
$sql_res=mysqli_query($con,"select * from products where nombre_producto like '%$q%' or codigo_producto like '%$q%' or des2 like '%$q%' LIMIT 0 , 20");
while($row=mysqli_fetch_array($sql_res))
{
$id=$row['id_producto'];
$nombre=$row['nombre_producto'];
$codigo=$row['codigo_producto'];
$precio_venta=$row['precio_producto'];
$laboratorio=$row['des1'];
$componente=$row['des2'];
$valor2=intval($row['valor2']);
$valor3=$row['valor3'];
if($valor2>0 and $valor3>0){
    $b1="<font color=red><strong>I($valor2/$valor3)</strong></font>";
}else{
    $b1="<font color=red><strong>&nbsp;</strong></font>";
}

$tienda=$_SESSION['tienda'];
$b=$row["b$tienda"];
$i=$i+1;
?>

<div class="display_box" align="left">
    <table style="width:100%;color:black;" >
        <?php
        if($i==1){
         ?>
        <tr style="background:#F5D0A9;color:black;"><td align="center">Inc</td><td align="center">Nombre</td><td align="center">Laboratorio</td><td align="center">Componente</td><td align="center">Codigo</td><td align="center">Stock</td><td>Cantidad</td><td align="center">Precio</td><td></td></tr>
        <?php
        }
        
        //print"select * from products where nombre_producto like '%$q%'";
        ?>
    <tr><td style="width:5%;text-align:center;"><?php echo $b1?></td>
        <td style="width:30%;"><?php echo $nombre; ?></td>
        <td style="width:15%;"><?php echo $laboratorio; ?></td>
        <td style="width:20%;"><?php echo $componente; ?></td>
        <td style="width:5%;text-align:center;"><?php echo $codigo; ?></td>
        <td style="width:10%;">
          <input type="text"  style="text-align:center;width:100%; " disabled id="stoc_<?php echo $id; ?>" value="<?php echo $b;?>">  
            
        </td>
        
        <td style="width:5%;">
            <input type="text"  style="text-align:center;width:100%;" id="cant_<?php echo $id; ?>" value="1" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '1';}">
        </td>
        <td style="width:10%;">
            <input type="text"   style="text-align:center;width:100%;" id="precio_<?php echo $id; ?>"  readonly value="<?php echo $precio_venta;?>" >
        </td>
        <td style="width:5%;">
            <a class='btn btn-info'href="#" onclick="agregar2('<?php echo $id ?>')"><i class="glyphicon glyphicon-plus"></i></a>
        </td>
    </tr></table></div>


<?php
}

}


}


?>
