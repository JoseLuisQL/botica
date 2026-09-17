<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo

$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[30]==0){
    header("location:error.php");    
}
$doc1=recoge1('nombre_cliente');
if($doc1<>""){
    header("location:nueva_factura.php"); 
}

date_default_timezone_set('America/Lima');
                    //$date_added=date("Y-m-d H:i:s");
                    $fecha2=date("Y-m-d");
                    $fecha1=date("Y-m-d",strtotime($fecha2."- 6 days"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Lista de ventas,compras, notas</title>

 <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="DataTables/DataTables/css/dataTables.bootstrap.min.css"/>
<script type="text/javascript" src="Buttons/js/jszip.min.js"></script>
<!--<script type="text/javascript" src="Buttons/js/pdfmake.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="Buttons/css/buttons.dataTables.min.css"/>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="Buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.print.min.js"></script>
  
    
  

  
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
     
        </div>
      </div>

      <!-- top navigation -->
       <?php
          menu3();
          
          ?>
     
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              
            </div>

            
          </div>
          <div class="clearfix"></div>

          <div class="row">

          <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">
                        
                        <?php 
                                $video=videos;
                    
                                if(2==1){
                                    $v="3_MxjggA4YQ";
                                    include("modal/registro_video.php");
                                    ?>
                                    <div class="btn-group pull-right">
                                        <button type='button' class="btn btn-danger" data-toggle="modal" data-target="#nuevoVideo"><span class="glyphicon glyphicon-play" ></span>Video Tutorial</button>
                                    </div>
                                    <?php
                    
                                }
                        ?>
			<h4>Calculo del <?php echo nom_iva;?></h4>
		</div>
			
				<div class="panel-body">
				<form class="form-horizontal" style="color:black;" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							
							<div class="col-md-4 col-sm-4 col-xs-12">
                                                                Buscar Cliente
								<input type="text" autocomplete="off" class="form-control input-sm" id="q" placeholder="Nombre del cliente " onkeyup='load(1);'>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-12">
                                                                Buscar Doc
								<input type="text" autocomplete="off" class="form-control input-sm" id="q1" placeholder="Nro doc " onkeyup='load(1);'>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                                Buscar Fecha1
								<input type="date"  class="form-control input-sm" id="q2"  onchange='load(1);' value='<?php echo $fecha1;?>'>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                                Buscar Fecha2
								<input type="date"  class="form-control input-sm" id="q3"  onchange='load(1);' value='<?php echo $fecha2;?>'>
							</div>
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                                Ventas/compras
								<select class="form-control input-sm" id="q4"  onchange='load(1);'>
                                                                    <option value="3">Elegir</option>
                                                                    <option value="1">Ventas</option>
                                                                    <option value="2">Compras</option>
                                                                  
                                                                </select>
							</div>
                                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                                                Tipo doc
								<select class="form-control input-sm" id="q5"  onchange='load(1);'>
                                                                    <option value="3">Elegir</option>
                                                                    <option value="1">Factura</option>
                                                                    <option value="2">Boleta</option>
                                                                   <option value="5">Nota de Debito</option>
                                                                   <option value="6">Nota de Credito</option>
                                                                </select>
							</div>
                                                    
                                                    
							<div class="col-md-12 col-sm-12 col-xs-12">
								<button type="button" class="btn btn-primary" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
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

        <!-- footer content -->
         <?php
          footer();
          
          ?>
      
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

<script src="js/bootstrap.min.js"></script>
<script src="js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>

<script src="js/icheck/icheck.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/pace/pace.min.js"></script>
<script type="text/javascript" src="js/usuarios.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
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
                        var q5= $("#q5").val();
                        var q6= $("#q6").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_contabilidad.php?action=ajax&page='+page+'&q='+q+'&q1='+q1+'&q2='+q2+'&q3='+q3+'&q4='+q4+'&q5='+q5+'&q6='+q6,
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
function imprimir_factura(id_factura){
			VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}

function imprimir_factura1(id_factura){
			VentanaCentrada('./pdf/documentos/ver_factura1.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}


</script>

  </body>
</html>
<?php
ob_end_flush();
?>

















