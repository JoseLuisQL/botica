<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
        }
	include("../../config/db.php");
	include("../../config/conexion.php");
	$session_id= session_id();
	$sql_count=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No hay productos agregados a la transferencia')</script>";
	//echo "<script>window.close();</script>";
	exit;
	}
	$tienda3=$_SESSION['tienda'];
        $resp=0;
        $sql3=mysqli_query($con,"select * from tmp where session_id='".$session_id."'");
	while ($row3=mysqli_fetch_array($sql3)){
           $id_producto3=$row3["id_producto"]; 
           $cant=$row3["cantidad_tmp"]; 
           $lote=$row3["lote"]*1; 
           $numrows=200000;
           if($lote>0){
                $count_query=mysqli_query($con, "SELECT sum(final) AS numrows FROM lote where id_producto=$id_producto3 and id_lote=$lote and tienda=$tienda3");
                $row5=mysqli_fetch_array($count_query);
                $numrows = $row5['numrows']; 
           }
           
                    
           //print"$cant $numrows"; 
           if($cant>$numrows*1){
               $resp=$resp+1;
           }
        }
        
        //print"$resp";
        if ($resp>0)
	{
	echo "<script>alert('Error en la cantidad de lotes ha transferir </script>";
	echo "<script>window.close();</script>";
	exit;
	}
        
        $id_vendedor=$_SESSION['user_id'];
        $fecha=$_GET['fecha'];
        $hora=$_GET['hora'];
        $tienda2=$_GET['tienda2'];
        $motivo=$_GET['motivo'];
        
        //print"asd";
        $dias=0;
        $moneda=1;
        //$folio=$_GET['serie'];
        $tienda1=$_SESSION['tienda'];
        

?>
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
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        
    
    <?php
    date_default_timezone_set('America/Lima');
    ?>
    <table cellspacing="0" style="width: 100%;">
        <tr>

            <td style="width: 25%; color: #444444;">
                <br>
            </td>
            <td style="width: 50%; color: #34495e;font-size:12px;text-align:center"> 
            </td>
            <td style="width: 25%;text-align:right">
                    
            </td>
			
        </tr>
    </table>
    <br>
    
       <br>
		<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
           <td style="width:35%;" class='midnight-blue'>VENDEDOR</td>
		<td style="width:25%;" class='midnight-blue'>FECHA</td>
		
        </tr>
	<tr>
            <td style="width:35%;">
			<?php 
				$sql_user=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
				$rw_user=mysqli_fetch_array($sql_user);
				echo $rw_user['nombres'];
			?>
            </td>
            <td style="width:25%;"><?php echo date("d/m/Y");?></td>
            
        </tr> 
    </table>
	<br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
        <tr>
            <th style="width: 10%;text-align:center" class='midnight-blue'>CANT.</th>
            <th style="width: 90%" class='midnight-blue'>DESCRIPCION</th>
            
        </tr>

<?php

$accion77=mysqli_query($con, "select * from documento where id_documento=12");
$row77=mysqli_fetch_array($accion77);
$numero_factura=$row77["tienda$tienda1"]+1;
$folio=$row77["folio$tienda1"];


$nums=1;
$sumador_total=0;
$servicio=0;
$tipo=$_SESSION['doc_ventas'];

//print"select * from products, tmp where products.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'";
$sql2=mysqli_query($con, "select * from tmp,products where products.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
//$sql=mysqli_query($con, "select * from products, tmp where products.id_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
while ($row=mysqli_fetch_array($sql2))
	{
	$id_tmp=$row["id_tmp"];
	$id_producto=$row["id_producto"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
        $id_lote=$row['lote'];
	$nombre_producto=$row['nombre_producto'];
	$precio_venta=$row['precio_tmp'];
        $pro_ser=$row['pro_ser'];
        
	$precio_venta_f=number_format($precio_venta,2);
	$precio_venta_r=str_replace(",","",$precio_venta_f);
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);
	$precio_total_r=str_replace(",","",$precio_total_f);
	$sumador_total+=$precio_total_r;//Sumador
	if ($nums%2==0){
		$clase="clouds";
	} else {
		$clase="silver";
	}
	?>
        <tr>
            <td class='<?php echo $clase;?>' style="width: 10%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 60%; text-align: left"><?php echo $nombre_producto;?></td>
             
            
        </tr>

	<?php 
        
        $sql3=mysqli_query($con, "select * from products where id_producto='".$id_producto."'");
        $row3=mysqli_fetch_array($sql3);
        $tienda=$_SESSION['tienda'];
        $b="b$tienda";
        $r="b$tienda2";
        
        
        $c=$tienda;
        $d=$row3["b$tienda"];
        
        $d2=$row3["b$tienda2"];
        
        $fecha1=date("Y-m-d", strtotime($fecha) );
        $date_added=$fecha1." ".$hora;
        
	$insert_detail=mysqli_query($con, "INSERT INTO detalle_factura VALUES (NULL,'0','$id_vendedor','$numero_factura','1','$id_producto','$cantidad','$precio_venta_r','$c','1','1','$date_added','$id_vendedor','0','$d','0','$folio','0','0','0')");
        $id_detalle=mysqli_insert_id($con);
        
        $insert_detail11=mysqli_query($con, "INSERT INTO transferencia VALUES ('$id_detalle','$motivo')");
       
        
        //if($condiciones==1){
            $productos1=mysqli_query($con, "UPDATE products SET $b=$b-$cantidad,$r=$r+$cantidad WHERE id_producto=$id_producto "); 
            //$cond=10;
            
            
            $id_lote1="";
            if($id_lote>0){
                $insert_detail=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote','$date_added','$id_detalle','$cantidad','$precio_venta_r','1')");
                $lote1=mysqli_query($con, "UPDATE lote SET final=final-$cantidad WHERE id_lote=$id_lote");
            
                $query=mysqli_query($con, "select * from lote where id_lote=$id_lote");    
                $row11=mysqli_fetch_array($query);
                $lote11=$row11["lote"];
                $fec_vto=$row11["fec_vto"];
                $fec_fab=$row11["fec_fab"];
	
                $id_lote1=0;
        
                $query1=mysqli_query($con, "select * from lote where lote='$lote11' and tienda=$tienda2 and id_producto=$id_producto");    
                $row12=mysqli_fetch_array($query1);
                $id_lote1=$row12["id_lote"];
                
            }
        
            
        
        
         if($id_lote1>0 and $id_lote>0){
                $insert_detail=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote1','$date_added','$id_detalle','$cantidad','$precio_venta_r','2')");
                $lote1=mysqli_query($con, "UPDATE lote SET final=final+$cantidad WHERE id_lote=$id_lote1");
        }
        //print"$id_lote1 - 11";
        if(($id_lote1==0 or $id_lote1=="") and $id_lote>0){
                $sql="INSERT INTO lote VALUES (NULL,'$id_producto','$fec_vto','$fec_fab','$lote11','$tienda2','$cantidad','$cantidad')";
                $query_new_insert = mysqli_query($con,$sql);
                //rint"$sql";
                $id_lote1=mysqli_insert_id($con);
                $insert_detail=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote1','$date_added','$id_detalle','$cantidad','$precio_venta_r','2')");
                //$lote1=mysqli_query($con, "UPDATE lote SET final=final+$cantidad WHERE id_lote=$id_lote1");
        }
        
        $insert_detail1=mysqli_query($con, "INSERT INTO detalle_factura VALUES (NULL,'0','$id_vendedor','$numero_factura','2','$id_producto','$cantidad','$precio_venta_r','$tienda2','1','2','$date_added','$id_vendedor','0','$d2','0','$folio','0','0','0')");
        $id_detalle1=mysqli_insert_id($con);
        
        $insert_detail111=mysqli_query($con, "INSERT INTO transferencia VALUES ('$id_detalle1','$motivo')");
        //if($condiciones==1){
            //$productos2=mysqli_query($con, "UPDATE products SET  WHERE id_producto=$id_producto "); 
            //$cond=10;
            //if($id_lote>0){
            //    $insert_detail=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote','$date_added','$id_detalle1','$cantidad','$precio_venta_r','1')");
           //     $lote1=mysqli_query($con, "UPDATE lote SET final=final-$cantidad WHERE id_lote=$id_lote");
            //}    
            
            
        $nums++;
	}
	
	
        
        
         ?>
        
    </table>
<br>
</page>
<?php



$documento=mysqli_query($con, "UPDATE documento SET tienda$tienda3=tienda$tienda3+1 WHERE id_documento=12");
//$insert=mysqli_query($con,"INSERT INTO facturas VALUES (NULL,'$numero_factura','$date','0','','0','0','$id_vendedor','$condiciones','$sumador_total','0','$cond','$c','2','0','0','$moneda1','$cuenta','$motivo','0','2018-11-11','$dias','$folio','2','','0','','0')");
//$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");
?>