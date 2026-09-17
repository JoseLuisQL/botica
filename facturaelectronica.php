<?php	
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Lista de ventas </title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>


<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />



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
		    <div class="btn-group pull-right">
				<a  href="nueva_factura.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nuevo Doc</a>
                    </div>
                    
                    <h4><img src="ajax/sunat.png" width="40" height="40">Lista de Documentos Electrónicos:</h4>
		</div>
			
				<div class="panel-body">
				<form class="form-horizontal" style="color:black;" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							
							<div class="col-md-4 col-sm-4 col-xs-12">
                                                                Buscar Cliente
								<input type="text" autocomplete="off" class="form-control" id="q" placeholder="Nombre del cliente " onkeyup='load(1);'>
							</div>
                                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                                                Tipo doc
								<select class="form-control" id="q4"  onkeyup='load(1);'>
                                                                    <option value="">Elegir</option>
                                                                    <option value="1">Factura</option>
                                                                    <option value="2">Boleta</option>
                                                                   <option value="5">Nota de Debito</option>
                                                                   <option value="6">Nota de Credito</option>
                                                                </select>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                                Buscar Doc
								<input type="text" autocomplete="off" class="form-control" id="q1" placeholder="Nro doc " onkeyup='load(1);'>
							</div>
							<div class="col-md-2 col-sm-1 col-xs-12">
                                                                Fecha Inicial
								<input type="date"  class="form-control" id="q2"  onkeyup='load(1);'>
							</div>
                                                        <div class="col-md-2 col-sm-1 col-xs-12">
                                                                Fecha Final
								<input type="date"  class="form-control" id="q3"  onkeyup='load(1);'>
							</div>
							<div class="col-md-1">
								<button type="button" class="btn btn-warning" onclick='load(1);'>
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
  <script src="js/bootstrap.min.js"></script>
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="js/icheck/icheck.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/pace/pace.min.js"></script>
<script type="text/javascript" src="js/usuarios.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/facturas2.js"></script>
  
      <script>
       function enviar (id,page)
		{
			var q= $("#q").val();
			
		$.ajax({
        type: "GET",
        url: "./pdf/documentos/enviar_sunat.php",
        data: "fac="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(page);
		}
			});
		
		}   
          
      </script>    

  </body>
</html>
<?php
ob_end_flush();
?>

















