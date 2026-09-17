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
if($a[34]==0){
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

  <title>Lista de Guias De Entradas y Salidas</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>


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
      <!-- /top navigation -->

      <!-- page content -->
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
				<a  href="nueva_entsal.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nuevo Doc</a>
			</div>
                        
			<h4>Lista de Guias de Entradas y Salidas.</h4>
		</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Fecha </label>
							<div class="col-md-2">
								<input type="date" class="form-control" id="q"  onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								
                                                                <select   class='form-control' id="q1" onkeyup='load(1);'>
                                                                        <option value="">Escoger Tipo</option>
									<option value="9">Entrada de Mercaderia</option>
									<option value="10">Salida de Mercaderia</option>
									
								</select>
							</div>
							<div class="col-md-3">
								<select   class='form-control' id="q2" onkeyup='load(1);'>
									<option value="">Escoger Motivo</option>
                                                                        <option value="Eliminado">Documento Eliminado</option>
                                                                        <option value="Disminuir Stock">Disminuir Stock</option>
        
                                                                        <option value="Por Faltante">Por Faltante</option>
                                                                        <option value="Mercaderia Vencida o deteriorada">Mercaderia Vencida o deteriorada</option>
                                                                        <option value="Devolucion Proveedor">Devolucion Proveedor</option>
									
								</select>
							</div>
							
							<div class="col-md-2">
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


  </body>
</html>
<script type="text/javascript" src="js/usuarios.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<script type="text/javascript" src="js/compras2.js"></script>
<?php
ob_end_flush();
?>
















