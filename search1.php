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
?>
<style>
tr:hover{background:#81F79F;}
</style>
<div class="display_box" align="left">
    <table style="color:black;" border="1">
     <tr style="background:#58FAD0;color:black;"><th style="width:5%;" align="center">Foto</th><th style="width:55%;" align="center">Nombre</th><th style="width:10%;" align="center">Codigo</th><th style="width:10%;" align="center">Stock</th><th style="width:10%;">Cantidad</th><th style="width:10%;" align="center">Precio</th><th style="width:5%;"></th></tr>   


<?php
$sql_res=mysqli_query($con,"select * from products where nombre_producto like '%$q%' LIMIT 0 , 20");
while($row=mysqli_fetch_array($sql_res))
{
$id=$row['id_producto'];
$nombre=$row['nombre_producto'];
$codigo=$row['codigo_producto'];
$blister=$row['blister'];
$caja=$row['caja'];
$foto=$row['foto1'];
$bli=$row['bli'];
$tienda=$_SESSION['tienda'];
$b=$row["b$tienda"];
$c=$row["c$tienda"];
$precio_venta=$c;
$i=$i+1;
?>


        
    <tr><td style="width:5%;"><img src="fotos/<?php echo $foto?>" width="30" height="20" /></td>
        <td style="width:70%;"><?php echo $nombre; ?></td>
        <td style="width:5%;text-align:center;"><?php echo $codigo; ?></td>
        <td style="width:5%;">
          <input type="text"  style="text-align:center;width:100%;" disabled id="stoc_<?php echo $id; ?>" value="<?php echo round($b,2);?>">  
            
        </td>
        
        <td >
            <input type="text"  style="text-align:center;width:100%;" id="cant_<?php echo $id; ?>" value="1" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '1';}">
        </td>
        <td>
            <?php
                    
                    $sql1="SELECT * FROM  precios where id_producto=$id";
                    $query1 = mysqli_query($con, $sql1);
                                               
                    $row1=mysqli_fetch_array($query1);
                    $p1=$row1['c1'];                                
                    $p2=$row1['c2']; 
                    $p3=$row1['c3'];         
                    ?>
            
            
            
           <select id="precio_<?php echo $id; ?>" style="height:20px;">
                
                    <option value="<?php print"$p1-1";?>"><?php print"Und: $p1";?></option>
                    <?php
                    if($blister>0){
                        ?>
                        <option value="<?php print"$p2-2";?>"><?php echo $bli;?>:<?php echo $p2;?></option>
                        <?php
                    }
                    ?>
                    
                    
                    
                    <?php
                    if($caja>0){
                        ?>
                        <option value="<?php print"$p3-3";?>">Caja:<?php echo $p3;?></option>
                        <?php
                    }
                    ?>
                    
                    
                    
                </select>
        </td>
        <td >
            <a class='btn btn-info'href="#" onclick="agregar2('<?php echo $id ?>')"><i class="glyphicon glyphicon-plus"></i></a>
        </td>
    </tr>


<?php
}
?>
    </table></div>
<?php
}


}


?>
