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
	$id_producto= intval($_GET['id_producto']);
        $largo=0;
        $ancho=0;
        $cant=1;
        $med1=0;
         $med2=0;
         
        if (isset($_GET['largo'])){$largo=$_GET['largo'];}
        if (isset($_GET['ancho'])){$ancho=$_GET['ancho'];}
        if (isset($_GET['med1'])){$med1=$_GET['med1'];}
        if (isset($_GET['med2'])){$med2=$_GET['med2'];}
        if (isset($_GET['cant'])){$cant=$_GET['cant'];}
        
        
	$sql_count=mysqli_query($con,"select * from products where id_producto='".$id_producto."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Producto no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_producto=mysqli_query($con,"select * from products where id_producto='".$id_producto."'");
	$rw_producto=mysqli_fetch_array($sql_producto);
        $barras=$rw_producto['barras'];
        $des1=$rw_producto['des1'];
        $des2=$rw_producto['des2'];
        $des3=$rw_producto['des3'];
	$precio_producto=$rw_producto['precio_producto'];
        
	$cont=0;
  
 
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
    //$pos="position: absolute;top: 0px;z-index: 1;";
    if($largo==0 and $ancho==0 and $cant==1){
        
    ?>
    <form method="GET" action="ver_producto.php" >
        <table>
            <tr><td align="center" colspan="2"><strong><font color="red">Medidas:</font></strong></td></tr>
        <tr><td align="center">Largo:</td><td><input type="text" name="largo" value="50"></td></tr>
        <tr><td align="center">Ancho:</td><td><input type="text" name="ancho" value="26"></td></tr>
        <tr><td align="center">Med1:</td><td><input type="text" name="med1" value="8"></td></tr>
        <tr><td align="center">Med2:</td><td><input type="text" name="med2" value="1"></td></tr>
        <tr><td align="center">Filas:</td><td><input type="number" min="1" max="1000"  name="cant" value="1"></td></tr>
        <input type="hidden" name="id_producto" value="<?php echo $id_producto;?>">
        <tr><td align="center" colspan="2"><button id="send" type="submit" name="enviar" class="btn btn-success" style="background:blue;">Buscar</button></td></tr>
        </table>
    </form> 
    <?php        
     }elseif($largo>0 and $ancho>0 and $cant>=1){
       for($i=1;$i<=$cant;$i++)  {
         //$i1=$i+1;
           //if($cont>0){
             $pos3=$med2."mm";   
             $pos="position:relative;margin-top:$pos3;float: left;";
         //}
           ?> <div style="<?php echo $pos;?>">     
<div class="zona_impresion" style="width:<?php echo $largo;?>mm;height:<?php echo $ancho;?>mm;">
        <!-- codigo imprimir -->

<table border="0" align="center" style="width:<?php echo $largo;?>mm;">
    
    <tr>
        <td align="left" style="width:100%;">
            <font size="1"><span style="padding-left:5px;"><strong><?php echo des1;?>:<?php echo $des2;?></strong></span></font>
       </td>
       
      
    </tr>
    <tr>
        <td align="left" >
            <font size="1"><span style="padding-left:5px;"><strong><?php echo des3;?>:<?php echo $des1;?></strong></span></font>
       </td>
      
    </tr>
    <tr>
        <td align="left">
            <font size="1"><span style="padding-left:5px;"><strong><?php echo des2;?>:<?php echo $des3;?></strong></span></font>
       </td>
    </tr>
    
    <tr>
        <td  align="right" >
        <img src='../../ajax/codigos/<?php echo $barras;?>.png' >
       </td>
    </tr>
   
</table>
        

        
</div>
    
<div class="zona_impresion" style="margin-left: <?php echo $med1;?>mm;width: <?php echo $largo;?>mm;height: <?php echo $ancho;?>mm;">
        <!-- codigo imprimir -->

<table border="0" align="center" style="width:<?php echo $largo;?>mm;">
    
    <tr>
        <td align="left" style="width:100%;">
            <font size="1"><span style="padding-left:5px;"><strong><?php echo des1;?>:<?php echo $des2;?></strong></span></font>
       </td>
      
    </tr>
    <tr>
        <td align="left" style="width:80%;">
            <font size="1"><span style="padding-left:5px;"><strong><?php echo des2;?>:<?php echo $des1;?></strong></span></font>
       </td>
      
    </tr>
    <tr>
        <td align="left">
            <font size="1"><span style="padding-left:5px;"><strong><?php echo des3;?>:<?php echo $des3;?></strong></span></font>
       </td>
    </tr>
    
    <tr>
        <td  align="right">
        <img src='../../ajax/codigos/<?php echo $barras;?>.png' >
       </td>
    </tr>
   
</table>
        

        
</div> 
           </div>
    
    
  <?php
  
}
}
if($largo>0 and $ancho>0 and $cant>=1){
    

?>
    
<div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>
<?php
}
?>
</body>
</html>
<?php
ob_end_flush(); 
?>




