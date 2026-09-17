<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$tienda1=$_SESSION['tienda'];
$sql2=" select * from caja where tienda=$tienda1 ORDER BY  `caja`.`id_caja` DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$fecha1=$rs2["fecha"];
$usuario_cierre=$rs2["usuario_cierre"];
//$inicio=$rs2["inicio"];
$id_caja=$rs2["id_caja"];
date_default_timezone_set('America/Lima');

$fecha2=date("Y-m-d");
$fecha4=date("d-m-Y");







$entrada1=0;
$salida1=0;
//if($fecha1==$fecha2){
    


$suma1= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total1 FROM facturas  where condiciones=1 and (estado_factura<=3 or estado_factura=5) and activo=1 and ven_com=1 and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
$row1= mysqli_fetch_array($suma1);
$total1 = $row1['total1'];
if($total1==""){
    $total1=0;
}   
//print"SELECT SUM(total_venta) AS total1 FROM facturas  where condiciones=1 and (estado_factura<=3 or estado_factura=5) and activo=1 and ven_com=1 and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )";

$suma4= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total4 FROM facturas  where  condiciones=1 and activo=1 and (ven_com=5 or ven_com=3) and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
$row4= mysqli_fetch_array($suma4);
$total4 = $row4['total4'];
if($total4==""){
    $total4=0;
}                                                    
$suma2= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total2 FROM facturas  where condiciones=1 and estado_factura=6 and activo=1 and ven_com=1 and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
$row2= mysqli_fetch_array($suma2);
$total2 = $row2['total2'];
if($total2==""){
    $total2=0;
}                                                     
$suma3= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total3 FROM facturas  where condiciones=1 and activo=1 and (ven_com=2 or ven_com=4) and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
$row3= mysqli_fetch_array($suma3);
$total3 = $row3['total3'];
if($total3==""){
    $total3=0;
}                                                     
$suma5= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total5 FROM facturas  where condiciones=1 and activo=1 and ven_com=6 and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
$row5= mysqli_fetch_array($suma5);
$total5 = $row5['total5'];
if($total5==""){
    $total5=0;
}                                                     
$entrada1=$total1+$total4;
$salida1=$total2+$total3+$total5;
//}




$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[1]==0){
    header("location:error.php");    
}


$d=date("d");
$m=date("m");
$aa=date("Y");
$dd1=$aa."-".$m."-".$d;
$fech1=strtotime($dd1);
$f1=$fech1/(24*3600);
$a1=array();
$a2=array();
$a3=array();
$a4=array();
$fec=array();
$j=0;
$total1=0;
$total2=0;
$total3=0;
$total4=0;

$fecha50 = date('Y-m-d');
$nuevafecha = strtotime ( '-9 day' , strtotime ( $fecha50 ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

for($i=($f1-9);$i<=$f1;$i++){
$fec[$j]=0;
$sql1="select * from facturas where activo=1 and tienda=$tienda1 and DATE_FORMAT(fecha_factura, '%Y-%m-%d')>='$nuevafecha' and DATE_FORMAT(fecha_factura, '%Y-%m-%d')<='$fecha50'"; 
$rs1=mysqli_query($con,$sql1);
$total1=0;
$total2=0;
$total3=0;
$total4=0;
$efectivo1=0;
$efectivo2=0;
$entrada=0;
$salida=0;
$a1[$j]=0;
$a2[$j]=0;
$a3[$j]=0;
$a4[$j]=0;
$a=0;
while($row1= mysqli_fetch_array($rs1)){
$fecha3=$row1['fecha_factura'];
$tienda=$row1['tienda'];
$tipo=$row1['ven_com'];
$condiciones=$row1['condiciones'];
$estado=$row1['estado_factura'];
$motivo=$row1['motivo'];
$d3 = explode("-",$fecha3);
$dia=date("d",strtotime($fecha3)); 
$mes=date("m",strtotime($fecha3));  
$ano=$d3[0];
$dd=$ano."-".$mes."-".$dia;
$fecha=strtotime($dd);
if($fecha==$i*24*3600){    
    if(($tipo==1 || $tipo==3 || $tipo==5) and $estado<>6){
    if($condiciones>0){
        $entrada=$row1['total_venta']-$row1['obs'];
        if($tipo==1 and $estado<=4){
          $total1=$total1+$entrada;  
        }
        if($condiciones<>4){
        $total2=$total2+$entrada;}
        $salida=0;
    }else{
        $salida=0;
        $entrada=0;
    }
}
if($tipo==2 || $tipo==4 || $tipo==6 || ($tipo==1 and ($estado==6 and $motivo<>'01' and $motivo<>'02'))){
    
    if($condiciones>0){
        $rr=$row1['obs'];
        if($row1['obs']==""){
            $rr=0;
        }
        
        $salida=$row1['total_venta']-$rr*1;
        if($tipo==2){
          $total3=$total3+$salida;  
        }
        if($condiciones<>4){
            $total4=$total4+$salida;
        }
        $entrada=0;
    }else{
        $salida=0;
        $entrada=0;
    }
}

  $a=$a+1;  
}
}

$fec[$j]=date('d-m-Y',$i*24*3600);
$a1[$j]=$total1;
$a2[$j]=$total2;
$a3[$j]=$total3;
$a4[$j]=$total4;
$j=$j+1;
}
$a5=array();
$a6=array();
$a7=array();
$a8=array();
$fec1=array();
$j=1;
$total5=0;
$total6=0;
$total7=0;
$total8=0;    
$m1=date("m");
$ano=date("Y");  





    for($i=1;$i<=$m1;$i++){
 
    $fec1[$j]=0;
    $sql1="select * from facturas where activo=1 and tienda=$tienda1"; 
    $rs1=mysqli_query($con,$sql1);
    $total5=0;
    $total6=0;
    $total7=0;
    $total8=0;
    $efectivo1=0;
    $efectivo2=0;
    $entrada=0;
    $salida=0;
    $a5[$j]=0;
    $a6[$j]=0;
    $a7[$j]=0;
    $a8[$j]=0;
    $a=0;
    while($row1= mysqli_fetch_array($rs1)){
        $fecha3=$row1['fecha_factura'];
        $tienda=$row1['tienda'];
        $tipo=$row1['ven_com'];
        $condiciones=$row1['condiciones'];
        $estado=$row1['estado_factura'];
        $d3 = explode("-",$fecha3);
        $dia=date("d",strtotime($fecha3)); 
        $mes=date("m",strtotime($fecha3));  
        $ano1=date("Y",strtotime($fecha3));  
        if($mes==$i && $ano==$ano1){    
            if(($tipo==1 || $tipo==3 || $tipo==5) and $estado<>6){
                if($condiciones>0){
                    $entrada=$row1['total_venta'];
                    if(is_numeric(['obs'])){
                        $entrada=$row1['total_venta']-$row1['obs'];
                    }
                    
                    if($tipo==1 and $estado<5){
                        $total5=$total5+$entrada;  
                    }
                if($condiciones<>4){
                    $total6=$total6+$entrada;}
                    $salida=0;
                }else{
                    $salida=0;
                    $entrada=0;
                }
            }
            if($tipo==2 || $tipo==4 || $tipo==6 || ($tipo==1 and $estado==6)){
                if($condiciones>0){
                    $entrada=$row1['total_venta'];
                    if(is_numeric(['obs'])){
                        $entrada=$row1['total_venta']-$row1['obs'];
                    }
                    if($tipo==2){
                        $total7=$total7+$salida;  
                    }
                    if($condiciones<>4){
                        $total8=$total8+$salida;
                    }
                    $entrada=0;
                }else{
                    $salida=0;
                    $entrada=0;
                }
            }
            $a=$a+1;  
        }
    }
  if($j==1){
      $mes2="Enero";
  }  
  if($j==2){
      $mes2="Febrero";
  } 
  if($j==3){
      $mes2="Marzo";
  } 
  if($j==4){
      $mes2="Abril";
  } 
  if($j==5){
      $mes2="Mayo";
  } 
  if($j==6){
      $mes2="Junio";
  } 
  if($j==7){
      $mes2="Julio";
  } 
  if($j==8){
      $mes2="Agosto";
  } 
  if($j==9){
      $mes2="Septiembre";
  } 
  if($j==10){
      $mes2="Octubre";
  } 
  if($j==11){
      $mes2="Noviembre";
  } 
  if($j==12){
      $mes2="Diciembre";
  }   
$fec1[$j]=$mes2."-".$ano;
$a5[$j]=$total5;
$a6[$j]=$total6;
$a7[$j]=$total7;
$a8[$j]=$total8;
$j=$j+1;
}   


  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Resumen</title>
 <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>



<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          
          <div class="clearfix"></div>

          <!-- menu prile quick info -->
          <?php
          menu2();
 
          menu1();
          
          ?>
          <!-- /menu prile quick info -->

          <br />

        </div>
      </div>

        
        <?php
          menu3();
          
      
        ?>

      <div class="right_col" role="main">

        <br />
        <div class="">
            
          <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div id="dato" >
                <div class="tile-stats" STYLE=" background-color:#00c2ff">
                <div class="icon"><i class="fa fa-building"></i>
                </div>
                    <div class="count"><font color="white"><?php echo moneda;echo $total1;?></font></div>

                    <h3><font color="white"><strong>VENTAS</strong></font></h3>
                    <p sTYLE="color:black"><strong>Fecha: <?php echo date("d-m-Y");?></strong></p>
              </div>
                  </div>  
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats" STYLE=" background-color:#00c2ff">
                <div class="icon"><i class="fa fa-shopping-cart"></i>
                </div>
                <div class="count"><font color="white"><?php echo moneda; echo $total3;?></font></div>

                <h3><font color="white"><strong>COMPRAS</strong></font></h3>
                <p sTYLE="color:black"><strong>Fecha: <?php echo date("d-m-Y");?></strong></p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats" STYLE=" background-color:#00c2ff">
                <div class="icon"><i class="fa fa-money"></i>
                </div>
                <div class="count"><font color="white"><?php echo moneda; echo $total2;?></font></div>

                <h3><font color="white"><strong>ENTRADAS</strong></font></h3>
                <p sTYLE="color:black"><strong>Fecha: <?php echo date("d-m-Y");?></strong></p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats" STYLE=" background-color:#00c2ff">
                <div class="icon"><i class="fa fa-toggle-up"></i>
                </div>
                <div class="count"><font color="white"><?php echo moneda; echo $total4;?></font></div>

                <h3><font color="white"><strong>SALIDAS</strong></font></h3>
                <p sTYLE="color:black"><strong>Fecha: <?php echo date("d-m-Y");?></strong></p>
              </div>
            </div>
          </div>
             <div class="col-md-12 col-sm-12 col-xs-12">
                 
                       
              
            </div>
          
         
            </div>
        
            <div class="container">
		<div class="panel panel-info">
		
                    
                    <?php
                    
                                
                    date_default_timezone_set('America/Lima');
                    //$date_added=date("Y-m-d H:i:s");
                    $fecha2=date("Y-m-d");
                    $fecha1=date("Y-m-d",strtotime($fecha2."- 6 days"));
                    ?>
                   
			
				<div class="panel-body">
                                   <div style="border:1px solid #00c2ff;">
                                    
                                    <font color="00c2ff" size="4"><strong>          Tendencia Diaria</strong></font>
                                   </DIV>
				<form class="form-horizontal" style="color:black;" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							
							
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                                Sucursal
								<select class="form-control input-sm" id="q4"  onchange='load(1);'>
                                                                    <?php
                                       
                                                                    $sql2="select * from sucursal ";
                                                                    $rs1=mysqli_query($con,$sql2);
                                                                    while($row3=mysqli_fetch_array($rs1)){
                                                                        $nombre=$row3["nombre"];
                                                                        $tienda=$row3["tienda"];
                                                                        ?>

                                                                        <option value="<?php echo $tienda;?>"><?php  print"$tienda: $nombre";?></option>

                                                                        <?php
                                                                        }         
                                                                    ?>   
                                                                        <option value=">=1">Todas las Sucursales</option>
                                                                </select>
							</div>
                                                        
                                                        
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                                Buscar Fecha 1
								<input type="date"  class="form-control input-sm" id="q2" value="<?php echo $fecha1;?>" onchange='load(1);'>
							</div>
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                                Buscar Fecha 2
								<input type="date"  class="form-control input-sm" id="q3" value="<?php echo $fecha2;?>" onchange='load(1);'>
							</div>
							
							
						</div>
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
       			
		</div>	
		
	</div>
        
        
        
     </div>

 
      </div>
         
        <!-- /footer content -->
      </div>
      <!-- /page content -->

    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  
  

  <!-- echart -->
  <script src="js/echart/echarts-all.js"></script>
  <script src="js/echart/green.js"></script>
  
  
  
  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>

  <script>
        
      $(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
                         var q1= $("#q1").val();
                        var q2= $("#q2").val();
                        var q3= $("#q3").val();
                        var q4= $("#q4").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_resumen2.php?action=ajax&page='+page+'&q='+q+'&q1='+q1+'&q2='+q2+'&q3='+q3+'&q4='+q4,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}
          
                
                
                
                
  </script> 
  <script src="js/moris/raphael-min.js"></script>
<script src="js/moris/morris.min.js"></script>
 
</body>

</html>
<?php
ob_end_flush();
?>