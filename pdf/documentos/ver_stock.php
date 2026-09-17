<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	$id_producto= intval($_GET['id_producto']);
	$sql_count=mysqli_query($con,"select * from products where id_producto='".$id_producto."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Producto no encontrado')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql=mysqli_query($con,"select * from products where id_producto='".$id_producto."'");
	$rw=mysqli_fetch_array($sql);
	$b1=$rw['b1'];
	$b2=$rw['b2'];
        $b3=$rw['b3'];
        $b4=$rw['b4'];
        $b5=$rw['b5'];
        $b6=$rw['b6'];
        $b7=$rw['b7'];
        //$b7=$rw['b7'];
        //$b8=$rw['b8'];
        $nombre=$rw['nombre_producto'];
        $codigo=$rw['codigo_producto'];
        $laboratorio=$rw['des1'];
        $componente=$rw['des2'];
        $valor2=$rw['valor2'];
        $valor3=$rw['valor3'];
        
        
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
   
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">  
    <script type="text/javascript">
 
    
    
function imprSelec(muestra)
{
    var ficha=document.getElementById(muestra);var ventimp=window.open(' ','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();
    window.close();

}
</script>
    
</head>

<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:12px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
	
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}

</style>

<a class="btn btn-success"   onclick="javascript:window.close();" href="javascript:imprSelec('muestra')"><i class="fa fa-print"></i>Imprimir</a>
<div id="muestra">

    <?php

//if($tienda1==$tienda2){
    ?>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        
    </page_footer>
    
    

	
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;" border="1">
        
        <tr>
            <td colspan="2"><font color="blue"><strong>NOMBRE</strong></font></td><td colspan="5"><?php echo $nombre;?></td>
        </tr>
        <tr>
           <td colspan="2"><font color="blue"><strong>CODIGO</strong></font></td><td colspan="5"><?php echo $codigo;?></td>
        </tr>
        <tr>   
           <td colspan="2"><font color="blue"><strong>LABORATORIO</strong></font></td><td colspan="5"><?php echo $laboratorio;?></td>
        </tr>
        <tr>
           <td colspan="2"><font color="blue"><strong>COMPONENTES</strong></font></td><td colspan="5"><?php echo $componente;?></td>
        </tr>
        <tr>
           <td colspan="2"><font color="blue"><strong>CANTIDAD INCENTIVO</strong></font></td><td colspan="5"><?php echo $valor2;?></td>
        </tr>
        <tr>
           <td colspan="2"><font color="blue"><strong>INCENTIVO EN S/</strong></font></td><td colspan="5"><?php echo $valor3;?></td>
        </tr>
         <tr>
           <td colspan="7"><font color="blue"><strong>STOCK</strong></font></td>
        </tr>
        <tr style="background:#FE642E;color:white;">
           <td style="width:14%;" align="center" >S1</td>
           <td style="width:14%;" align="center" >S2</td>
           <td style="width:14%;" align="center" >S3</td>
           <td style="width:14%;" align="center" >S4</td>
           <td style="width:14%;" align="center" >S5</td>
           <td style="width:14%;" align="center" >S6</td>
           <td style="width:14%;" align="center" >S7</td>
           
        </tr>
        <tr>
           <td style="width:14%;" align="center"><?php echo $b1;?></td>
           <td style="width:14%;" align="center"><?php echo $b2;?></td>
           <td style="width:14%;" align="center"><?php echo $b3;?></td>
           <td style="width:14%;" align="center"><?php echo $b4;?></td>
           <td style="width:14%;" align="center"><?php echo $b5;?></td>
           <td style="width:14%;" align="center"><?php echo $b6;?></td>
           <td style="width:14%;" align="center"><?php echo $b7;?></td>
           
        </tr>
        <tr>
            <td colspan="7"><br></td>
          
           
        </tr>
	<?php
        $i=0;
        $tienda1="b".$_SESSION['tienda'];
        $sql1=mysqli_query($con,"select * from products where id_producto<>$id_producto and des2='".$componente."' and valor2>0");
	while ($row=mysqli_fetch_array($sql1)){
            if($i==0){
                print"<tr style='background:blue;color:white;'><td colspan=2>Productos Incentivados</td><td>Laboratorio</td><td>Precio</td><td>Stock</td><td>Cantidad</td><td>Incentivo S/.</td></tr>";
            }
            print"<tr><td colspan=2>$row[nombre_producto]</td><td>$row[des1]</td><td>$row[precio_producto]</td><td>$row[$tienda1]</td><td>$row[valor2]</td><td>$row[valor3]</td></tr>";
            $i=1;
            
        }
        ?>
    </table>
     
</page>

</div>

<?php 


//}
?>