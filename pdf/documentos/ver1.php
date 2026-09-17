<?php	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	


//if($_POST)
//{
$i=0;
$q=$_GET['q'];//se recibe la cadena que queremos buscar
//$q1=$_GET['q1'];//se recibe la cadena que queremos buscar
if(strlen ($q)>=1)
{
?>   
<style>
tr:hover{background:#81F79F;}
</style>
Busqueda:<font color="red"><strong><?php echo $q;?></strong></font>
 <div class="display_box" align="left">
    <table style="width:100%;color:black;" border="1">  
        <tr style="background:#F5D0A9;color:black;"><td align="center">Nombre</td><td align="center">Laboratorio</td><td align="center">Componente</td><td align="center">Accion Tera.</td><td align="center">Codigo</td><td align="center">Stock</td></tr>
        
<?php  
//$tienda=$_SESSION['tienda'];

$sql_res=mysqli_query($con,"select * from products where des2 like '%$q%' LIMIT 0 , 20");

//print"select * from products where nombre_producto like '%$q%' or codigo_producto like '%$q%' or des2 like '%$q%' LIMIT 0 , 20";

while($row=mysqli_fetch_array($sql_res))
{

$id=$row['id_producto'];
$nombre=$row['nombre_producto'];
$codigo=$row['codigo_producto'];
$blister=$row['blister'];
$caja=$row['caja'];
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


        
      
    <tr>
        <td style="width:25%;"><?php  echo $nombre; ?></td>
        <td style="width:15%;"><?php echo $laboratorio; ?></td>
        <td style="width:10%;"><font color="red"><strong><?php echo $componente; ?></strong></font></td>
        <td style="width:10%;"><?php echo $accion; ?></td>
        <td style="width:5%;text-align:center;"><?php echo $codigo; ?></td>
        <td style="width:10%;">
          <input type="text"  style="text-align:center;width:100%; " disabled id="stoc_<?php echo $id; ?>" value="<?php echo round($b,2);?>">  
            
        </td>
        
        
        
    </tr>


<?php
}
?>
</table></div>
<?php
}


//}

//}
?>