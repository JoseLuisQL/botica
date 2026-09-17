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
if($a[1]==0){
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

  <title>Reporte Dinámico Ventas-Compras Mensual</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>
  
 <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
-->
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
		
                    <?php 
                                $video=videos;
                    
                                if($video==0){
                                    $v="CSrb6nzgnag";
                                    include("modal/registro_video.php");
                                    ?>
                                    <div class="btn-group pull-right">
                                        <button type='button' class="btn btn-danger" data-toggle="modal" data-target="#nuevoVideo"><span class="glyphicon glyphicon-play" ></span>Video Tutorial</button>
                                    </div>
                                    <?php
                    
                                }
                    date_default_timezone_set('America/Lima');
                    //$date_added=date("Y-m-d H:i:s");
                    $anio=date("Y");
                    
                    ?>
                    
			
				<div class="panel-body">
				<form class="form-horizontal" style="color:black;" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                                Filtrar por:
								<select class="form-control input-sm" id="q"  onchange='load(1);'>
                                                                        <option value="1">Vendedores</option>
                                                                        <option value="2">Clientes/Proveedores</option>
                                                                        <option value="3">Productos</option>
                                                                        
                                                                </select>
							</div>
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
                                                                Ventas/Compras
								<select class="form-control input-sm" id="q1"  onchange='load(1);'>
                                                                        <option value="4">Todo</option>
                                                                        <option value="1">Solo Ventas</option>
                                                                        <option value="2">Solo Compras</option>
                                                                        <option value="3">Solo Diferencia</option>
                                                                        
                                                                </select>
							</div>
							
								<input type="hidden"  class="form-control input-sm" id="q2" value="" onchange='load(1);'>
							
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                                 Año
								<input type="text"  class="form-control input-sm" id="q3" value="<?php echo $anio;?>" onchange='load(1);'>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<button type="button" class="btn btn-info" onclick='load(1);'>
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
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script src="js/select/select2.full.js"></script>

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
				url:'./ajax/buscar_estadistica3.php?action=ajax&page='+page+'&q='+q+'&q1='+q1+'&q2='+q2+'&q3='+q3+'&q4='+q4,
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

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la venta")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_facturas1.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		


</script>    

  <!-- form validation -->
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Seleccionar",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "Con Max Selección límite de 4",
        allowClear: true
      });
    });
  </script>
  
  <script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>


<script>
    




function imprimir(id_factura,tienda,moneda){
    window.open('balance4.php?f='+id_factura+'&tienda='+tienda+'&moneda='+moneda, "Detalle", "width=1200, height=1000")
}
   
</script>
<script src="js/moris/raphael-min.js"></script>
<script src="js/moris/morris.min.js"></script>

  </body>
</html>
<?php
ob_end_flush();
?>

















