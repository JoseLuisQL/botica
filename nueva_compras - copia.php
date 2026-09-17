<?php
ob_start();
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos       
include('menu.php');
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$sql2="select * from datosempresa where id_emp=1";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$dolar=$rs2["dolar"];
$a = explode(".", $modulo); 
$session_id=session_id();
$delete2=mysqli_query($con, "delete from tmp where session_id='".$session_id."'");

$tienda1=$_SESSION['tienda'];
$sql3="select * from sucursal where tienda=$tienda1";
$rw3=mysqli_query($con,$sql3);//recuperando el registro
$rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
$caja=$rs3["caja"];

if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[33]==0){
    header("location:error.php");    
}

if($caja==0){
    header("location:error1.php");    
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

  <title>Nueva compras </title>

  <link rel="stylesheet" type="text/css" href="css/formularios.css"/>
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">


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
      
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              
            </div>

            
          </div>
          <div class="clearfix"></div>

      <div class="btn-group">
                    <button type="button" class="btn btn-danger">Tipo de documento</button>
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="caret"></span>
                     
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="doc.php?accion=1&tipo=2">Factura</a>
                      </li>
                      <li><a href="doc.php?accion=2&tipo=2">Boleta</a>
                      </li>
                     
                      
                    </ul>
                  </div>
              
              
              
 <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
                    <?php
                    if ($_SESSION['doc_ventas']>=3) {
                        $_SESSION['doc_ventas']=1;
                    }
                    if ($_SESSION['doc_ventas']==1) {
                        $doc="Factura";
                    }
                    if ($_SESSION['doc_ventas']==2) {
                        $doc="Boleta";
                    }
                    
                    ?>
                    
                    
                    
			<h4><i class='glyphicon glyphicon-edit'></i> Nueva <?php echo "$doc";?></h4>
		</div>
		<div class="panel-body" style="background:<?php echo COLOR;?>">
		<?php 
			include("modal/buscar_productos.php");
                        include("modal/registro_productos.php");
			include("modal/registro_proveedores.php");
			
		?>
			<form style="color:black;" class="form-horizontal" role="form" id="datos_factura" action="compras.php">
				 <font color="black">LLenar los campos</font> <font style="background-color:<?php echo COLOR1;?>;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
                        
                            <div class="form-group row">
				  
				  <div class="col-md-5 col-sm-5 col-xs-12">
                                      Proveedor
					  <input autocomplete="off" class="textfield10" type="text" style="background-color: <?php echo COLOR1;?>;" class="form-control input-sm" id="nombre_proveedores" placeholder="Selecciona un proveedor" required>
					  <input id="id_proveedores" type='hidden'>	
				  </div>
                                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                                            
								Serie<input class="textfield10" style="background-color:<?php echo COLOR1;?>;" type="text" class="form-control input-sm" id="serie" placeholder="Serie" required>
							</div>
							
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                            
								Nro Doc<input class="textfield10" style="background-color:<?php echo COLOR1;?>;" type="text" class="form-control input-sm" id="factura" placeholder="Número de doc" required>
							</div>
                                  
                                                        <input type="hidden" class="form-control input-sm" id="ot"  value="0" >
					
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                            Teléfono
								<input class="textfield10" type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" readonly>
							</div>
					
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                            Email
								<input class="textfield10" type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly>
							</div>
				
                                                </div>
						<div class="form-group row">
							
							
							<?php date_default_timezone_set('America/Lima');?>
							<div class="col-md-3 col-sm-3 col-xs-12">
                                                            Fecha
								<input class="textfield10" style="background-color: <?php echo COLOR1;?>;" type="date" class="form-control input-sm" id="fecha" value="<?php echo date("Y-m-d");?>" required>
							</div>
							
                                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                                            Hora:
								<input class="textfield10" style="background-color: <?php echo COLOR1;?>;" type="time" class="form-control input-sm" id="hora" value="<?php echo date("H:i:s");?>" required>
							</div>
                                                  
                                                    <input type="hidden" class="form-control input-sm" value="<?php echo 1;?>" name="moneda" id="moneda"  required>
                                                    <input type="hidden" class="form-control input-sm" value="<?php echo $dolar;?>" name="tcp" id="tcp"  required>
							<div class="col-md-3 col-sm-3 col-xs-12">
                                                            Pago
								<select class="textfield11" style="background-color: <?php echo COLOR1;?>;" class='form-control input-sm' id="condiciones">
									<option value="1">Efectivo</option>
									<option value="2">Cheque</option>
									<option value="3">Transferencia bancaria</option>
									<option value="4">Crédito</option>
								</select>
							</div>
                                                        
                                                        
                                                        
							<div class="col-md-3 col-sm-3 col-xs-12">
                                                            Día de Pago al Crédito
								<input class="textfield10" style="background-color: <?php echo COLOR1;?>;" type="text"  class="form-control input-sm" id="dias" name="dias" placeholder="Número de días de crédito">
							</div>
                                                        
						</div>
				
				
                                    <div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#nuevoProveedores">
						 <span class="glyphicon glyphicon-user"></span> Nuevo Proveedor
						</button>
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="submit" class="btn btn-primary">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>
	</div>
         
          </div>
        </div>

        <!-- footer content -->
       
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

  
  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_proveedores").autocomplete({
							source: "./ajax/autocomplete/proveedores.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_proveedores').val(ui.item.id_proveedores);
								$('#nombre_proveedores').val(ui.item.nombre_proveedores);
								$('#tel1').val(ui.item.telefono_proveedores);
								$('#mail').val(ui.item.email_proveedores);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_proveedores" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_proveedores" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_proveedores" ).val("");
							$("#id_proveedores" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
						}
			});	
	
        
        
        
        
        
        $(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
                        var q1= $("#q1").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_compras.php?action=ajax&page='+page+'&q='+q+'&q1='+q1,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	function agregar (id)
		{
			var precio_venta=document.getElementById('precio_venta_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
                        var stock=document.getElementById('stock_'+id).value;
			//Inicia validacion
			if (isNaN(cantidad))
			{
			alert('Esto no es un numero');
			document.getElementById('cantidad_'+id).focus();
			return false;
			}                     
                       
                           
                        
                        
			if (isNaN(precio_venta))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_venta_'+id).focus();
			return false;
			}
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_compras.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});
		}
		
			function eliminar (id)
		{
			
			$.ajax({
        type: "GET",
        url: "./ajax/agregar_compras.php",
        data: "id="+id,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});

		}
		
		$("#datos_factura").submit(function(){
		  var id_proveedores = $("#id_proveedores").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var condiciones = $("#condiciones").val();
                  var factura = $("#factura").val();
		  var moneda = $("#moneda").val();
                  var fecha = $("#fecha").val();
                    var hora = $("#hora").val();
                    var serie = $("#serie").val();
                    var tcp = $("#tcp").val();
                     var dias = $("#dias").val();
                    
		  if (id_proveedores==""){
			  alert("Debes seleccionar un proveedor");
			  $("#nombre_proveedores").focus();
			  return false;
		  }
		 VentanaCentrada('./pdf/documentos/factura1_pdf.php?id_proveedores='+id_proveedores+'&id_vendedor='+id_vendedor+'&factura='+factura+'&moneda='+moneda+'&condiciones='+condiciones+'&fecha='+fecha+'&hora='+hora+'&dias='+dias+'&tcp='+tcp+'&serie='+serie,'Factura','','1024','768','true');
	 	});
		
		$( "#guardar_proveedores" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_proveedores.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})
		
		$( "#guardar_producto" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_producto.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_productos").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_productos").html(datos);
					$('#guardar_datos').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})

        </script>
  
</body>
</html>
<?php
ob_end_flush(); 
?>














