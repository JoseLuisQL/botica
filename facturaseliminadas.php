<?php
ob_start();
session_start();
include('menu.php');
/* Connect To Database*/
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
	
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Lista de ventas eliminadas.</title>

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

        <?php
        menu2();
        menu1();
        ?>
     
        </div>
      </div>

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
                         
			<h4>Lista de Ventas eliminadas:</h4>
                    </div>
			
				<div class="panel-body">
				<form style="color:black;" class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							
							<div class="col-md-5 col-sm-5 col-xs-12">
                                                                Buscar Cliente
								<input type="text" autocomplete="off" class="form-control" id="q" placeholder="Nombre del cliente " onkeyup='load(1);'>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
                                                                Buscar Doc
								<input type="text" autocomplete="off" class="form-control" id="q1" placeholder="Nro doc " onkeyup='load(1);'>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
                                                                Buscar Fecha
								<input type="date"  class="form-control" id="q2"  onkeyup='load(1);'>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-12">
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

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
<script type="text/javascript" src="js/usuarios.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/facturas1.js"></script>
  
        

  </body>
</html>


















