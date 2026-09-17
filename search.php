<?php
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
include('ajax/is_logged.php');
?>
<script>
 function imprimir(id_producto){
			VentanaCentrada('pdf/documentos/ver_stock.php?id_producto='+id_producto,'Producto','','800','500','true');
		}   
    function imprimir1(q){
			VentanaCentrada('pdf/documentos/ver1.php?q='+q,'Producto','','800','500','true');
		} 
                
    function imprimir2(q){
			VentanaCentrada('pdf/documentos/ver2.php?q='+q,'Producto','','800','500','true');
		}            
                
                
</script>
<?php


if($_POST)
{
$i=0;
$q=$_POST['palabra'];//se recibe la cadena que queremos buscar
if(strlen ($q)>=1)
{
?>   
<style>

tr:hover{background:#CEE3F6;}


  #tableB  table th{
    text-align:center;
}
#tableB td,th{
       border:1px solid silver;
       text-align:center;
       padding:1px;
   } 
        
        @media (max-width: 600px){
                #tableB  tr{ 
                    display:flex;
                    flex-direction: column;
                    border:1px solid;
                    padding:3px;
                    margin-bottom: 3px;
                }
                #tableB  thead{ 
                    display:none;
                    
                }
                #tableB  td[data-titulo]{ 
                    display:flex;
                } 
                #tableB  td,
                 #tableB  th{ 
                    border:none;
                    text-align:left;
                }
                #tableB  td[data-titulo]::before{ 
                    content:attr(data-titulo);
                    width:90px;
                    color:black;
                    font-weight:bold;
                }
                
  }
</style>
 <div class="display_box" align="left">
    <table id="tableB" style="color:black;width:100%;">  
        <tr style="background:#F5D0A9;color:black;">
            <td align="center" style="width:5%;">Inc</td>
            <td align="center" style="width:30%;">Nombre</td>
            <td align="center" style="width:15%;">Laboratorio</td>
            <td align="center" style="width:15%;">Componente</td>
            <td align="center" style="width:15%;">Accion Tera.</td>
           
            <td align="center" style="width:5%;">Stock</td>
            <td style="width:5%;">Cantidad</td>
            <td align="center" style="width:5%;">Precio</td>
            <td></td>
            <td></td>
        </tr>
        
<?php  
//$tienda=$_SESSION['tienda'];

$sql_res=mysqli_query($con,"select * from products where nombre_producto like '%$q%' or codigo_producto like '%$q%' or des2 like '%$q%' LIMIT 0 , 20");

//print"select * from products where nombre_producto like '%$q%' or codigo_producto like '%$q%' or des2 like '%$q%' LIMIT 0 , 20";

while($row=mysqli_fetch_array($sql_res))
{

$id=$row['id_producto'];
$nombre=$row['nombre_producto'];
$codigo=$row['codigo_producto'];
$blister=$row['blister'];
$caja=$row['caja'];
$bli=$row['bli'];
$laboratorio=$row['des1'];
$componente=$row['des2'];
$accion=$row['des3'];
$valor2=intval($row['valor2']);
$valor3=$row['valor3'];
if($valor2>0 and $valor3>0){
    $b1="<font color=red><strong>I($valor2/$valor3)</strong></font>";
}else{
    $b1="<font color=red><strong>&nbsp;</strong></font>";
}

$tienda=$_SESSION['tienda'];
$b=$row["b$tienda"];
$dis="";
if($b<=0){
    $dis="disabled";
}

$a=$row["a$tienda"];
$precio_venta=$a;
$i=$i+1;
?>


        
      
    <tr><td style="width:5%;text-align:center;"><?php echo $b1?></td>
        <td style="width:25%;text-align:center;"><a href="#"   onclick="obtener_datos1('','<?php echo $nombre;?>');" data-toggle="modal" data-target="#myModal2"><font color="black"><strong><?php echo substr($nombre,0,25);print" ";echo substr($nombre,25,25);print" ";echo substr($nombre,50,25); ?></strong></font></a> 
             </td>
        <td style="width:15%;text-align:center;"><?php echo $laboratorio; ?></td>
        <td style="width:10%;text-align:center;">
            <a href="#"   onclick="obtener_datos1('<?php echo $componente;?>','');" data-toggle="modal" data-target="#myModal2"><font color="black"><strong><?php echo $componente;?></strong></font></a> 
            
        </td>
        <td style="width:10%;text-align:center;"><?php echo substr($accion,0,25);print"<br>";echo substr($accion,25,25);print"<br>";echo substr($accion,50,25); ?></td>
        
        <td style="width:10%;text-align:center;">
          <input type="text"  style="text-align:center;width:100%; " disabled id="stoc_<?php echo $id; ?>" value="<?php echo round($b,2);?>">  
            
        </td>
        
        <td style="width:5%;text-align:center;">
            <input type="text" autocomplete="off" style="text-align:center;width:100%;" id="cant_<?php echo $id; ?>" value="1" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '1';}">
        </td>
        <td style="width:10%;text-align:center;">
            <select id="precio_<?php echo $id; ?>" style="height:20px;">
                    <?php
                    
                    $sql1="SELECT * FROM  precios where id_producto=$id";
                    $query1 = mysqli_query($con, $sql1);
                                               
                    $row1=mysqli_fetch_array($query1);
                    $p1=round($row1['p1'],2);                                
                    $p2=round($row1['p2'],2); 
                    $p3=round($row1['p3'],2);         
                    ?>
                    
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
        <td style="width:5%;text-align:center;">
            

            <a class="btn btn-info" style="padding:2px;" <?php echo $dis;?> href="#" onclick="agregar2('<?php echo $id ?>')"><i class="glyphicon glyphicon-plus"></i></a>
            
        </td>
        <td style="width:5%;text-align:center;">
            <a href="#" style="padding:2px;" class="btn btn-primary" title="ver" onclick="imprimir('<?php echo $id;?>');"><i class="glyphicon glyphicon-download"></i></a>
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
