<?php
ob_start();	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
        }
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	$cat= intval($_GET['cat']);
        
	$sql_count=mysqli_query($con,"select * from products where cat_pro='".$cat."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No hay productos en esta categoria')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	
         $largo=0;
        $ancho=0;
        $cant=1;
        $med1=0;
         $med2=0;
         
        if (isset($_GET['largo'])){$largo=$_GET['largo'];}
        if (isset($_GET['ancho'])){$ancho=$_GET['ancho'];}
        if (isset($_GET['med1'])){$med1=$_GET['med1'];}
        if (isset($_GET['med2'])){$med2=$_GET['med2'];}
        
	
  
 
			?>

    
   <html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="barra.css" rel="stylesheet" type="text/css">
<script>
    function printPantalla()
{
   document.getElementById('cuerpoPagina').style.marginRight  = "0";
   document.getElementById('cuerpoPagina').style.marginTop = "1";
   document.getElementById('cuerpoPagina').style.marginLeft = "1";
   document.getElementById('cuerpoPagina').style.marginBottom = "0"; 
   document.getElementById('botonPrint').style.display = "none"; 
   window.print();
}
</script>
<style>
   .verticalText {
writing-mode: vertical-lr;
transform: rotate(180deg);
} 
    
    
</style>
</head>
<body id="cuerpoPagina">
<?php
if($largo==0 and $ancho==0 and $cant==1){
        
    ?>
    <form method="GET" action="ver_producto1.php" >
        <table>
            <tr><td align="center" colspan="2"><strong><font color="red">Medidas:</font></strong></td></tr>
        <tr><td align="center">Largo:</td><td><input type="text" name="largo" value="50"></td></tr>
        <tr><td align="center">Ancho:</td><td><input type="text" name="ancho" value="26"></td></tr>
        <tr><td align="center">Med1:</td><td><input type="text" name="med1" value="8"></td></tr>
        <tr><td align="center">Med2:</td><td><input type="text" name="med2" value="1"></td></tr>
        
        
        <input type="hidden" name="cat" value="<?php echo $cat;?>">
        <tr><td align="center" colspan="2"><button id="send" type="submit" name="enviar" class="btn btn-success" style="background:blue;">Buscar</button></td></tr>
        </table>
    </form>


        <!-- codigo imprimir -->
<?php
 }elseif($largo>0 and $ancho>0 and $cant>=1){
?>
  <div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>
      
<?php
     $sql_producto=mysqli_query($con,"select * from products where cat_pro='".$cat."'");
	
        while ($rw_producto=mysqli_fetch_array($sql_producto)){
            $barras=$rw_producto['barras'];
            $des1=$rw_producto['marca'];
            $des2=$rw_producto['modelo'];
            $des3=$rw_producto['color'];
            $precio_producto=$rw_producto['precio_producto'];
       
       
       
            
    
       
         //$i1=$i+1;
           //if($cont>0){
             $pos3=$med2."mm";   
             $pos="position:relative;margin-top:$pos3;float: left;";
         //}
           ?>  
        <div style="<?php echo $pos;?>"> 
 <div class="zona_impresion" style="width:<?php echo $largo;?>mm;height:<?php echo $ancho;?>mm;">       
        
<table border="0" align="center" style="width:<?php echo $largo;?>mm;">
    
    <tr>
        <td align="left" style="width:100%;">
            <font size="1"><span style="padding-left:5px;"><strong>Modelo:<?php echo $des2;?></strong></span></font>
       </td>
       
    </tr>
    <tr>
        <td align="left" style="width:80%;">
        <font size="1"><span style="padding-left:5px;"><strong>Marca:<?php echo $des1;?></strong></span></font>
       </td>
      
    </tr>
    <tr>
        <td align="left">
        <font size="1"><span style="padding-left:5px;"><strong>Talla:<?php echo $des3;?></strong></span></font>
       </td>
    </tr>
    
    <tr>
        <td  align="right">
        <img src='../../ajax/codigos/<?php echo $barras;?>.png'>
       </td>
    </tr>
   
</table>
</div> 
  <div class="zona_impresion" style="margin-left: <?php echo $med1;?>mm;width: <?php echo $largo;?>mm;height: <?php echo $ancho;?>mm;">       
        
<table border="0" align="center" style="width:<?php echo $largo;?>mm;">
    
    <tr>
        <td align="left" style="width:100%;">
            <font size="1"><span style="padding-left:5px;"><strong>Modelo:<?php echo $des2;?></strong></span></font>
       </td>
       
    </tr>
    <tr>
        <td align="left" style="width:80%;">
        <font size="1"><span style="padding-left:5px;"><strong>Marca:<?php echo $des1;?></strong></span></font>
       </td>
      
    </tr>
    <tr>
        <td align="left">
        <font size="1"><span style="padding-left:5px;"><strong>Talla:<?php echo $des3;?></strong></span></font>
       </td>
    </tr>
    
    <tr>
        <td  align="right" >
        <img src='../../ajax/codigos/<?php echo $barras;?>.png'>
       </td>
    </tr>
   
</table>
</div>       
   </div>       
  <?php
   }
   }
   ?>
   
</body>
</html>

<?php
ob_end_flush(); 
?>


