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

$sql22="select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ";
$rw22=mysqli_query($con,$sql22);//recuperando el registro
$rs22=mysqli_fetch_array($rw22);//trasformar el registro en un vector asociativo
$tienda2=$rs22["tienda"];

if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[13]==0){
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

  <title>Nueva Guia Transferencia </title>

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
      
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              
            </div>

            
          </div>
          <div class="clearfix"></div>

      
              
              
              
 <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
                    
                    
                    
                    <h4><i class='glyphicon glyphicon-edit'></i> Nueva Transferencia <font color="red" size="5">Sucursal<?php echo $_SESSION["tienda"];?></font></h4>
		</div>
		<div class="panel-body" style="background:<?php echo COLOR;?>;color:black;">
		<?php 
			include("modal/buscar_productos.php");
                        
			
		?>
                    <form class="form-horizontal" role="form" id="datos_factura" action="transferencia1.php">
				 <font color="black">LLenar los campos</font> <font style="background-color:<?php echo COLOR1;?>;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
                                 
                        
                            <div class="form-group row">
                                                       
                                                         
                                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                                            
                                                            Serie<input  style="background-color:<?php echo COLOR1;?>;" type="text" class="form-control" id="serie" placeholder="Serie" value="T<?php echo $tienda1;?>" required readonly>
							</div>
							<?php
                                                        $accion77=mysqli_query($con, "select * from documento where id_documento=12");
                                                        $row77=mysqli_fetch_array($accion77);
                                                        $numero_factura1=$row77["tienda$tienda1"]+1;
                                                        
                                                        ?>
                                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                                            
								Nro Doc<input  style="background-color:<?php echo COLOR1;?>;" type="text" class="form-control" id="factura" value="<?php echo $numero_factura1;?>" placeholder="Número de doc" required readonly>
							</div>
                                                         <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Sucursal
                                                            <select class="form-control" style="background-color:<?php echo COLOR1;?>;" id="tienda2" name="tienda2" required>
                                                            <option value="">-- Selecciona Sucursal --</option>
                                                            <?php 
                                                                $tienda=$_SESSION['tienda'];
                                                                
                                                                for($i=1 ;$i<=$tienda2;$i++){
                                                                if($i<>$tienda){
          
                                                                ?>
                                                                <option value="<?php echo $i;?>">Sucursal <?php echo $i;?></option>                         
                                                                <?php
                                                                }
        
                                                                }  
                                                            ?>                                   
                                   
                                                            </select>
                                                        </div>
                                                        <input type="hidden" id="ot"  value="0" >
					
							
					
							
							
							<?php date_default_timezone_set('America/Lima');?>
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                            Fecha
								<input style="background-color: <?php echo COLOR1;?>;" type="date" class="form-control" id="fecha" value="<?php echo date("Y-m-d");?>" required>
							</div>
							
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Hora:
								<input  style="background-color: <?php echo COLOR1;?>;" type="time" class="form-control" id="hora" value="<?php echo date("H:i:s");?>" required>
							</div>
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Motivo
								<input  style="background-color: <?php echo COLOR1;?>;" type="text" class="form-control" id="motivo"  required>
							</div>
                                                  
                                                    <input type="hidden" class="form-control input-sm" value="<?php echo 1;?>" name="moneda" id="moneda"  required>
                                                    <input type="hidden" class="form-control input-sm" value="<?php echo $dolar;?>" name="tcp" id="tcp"  required>
                                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                                       
                                                            Codigo de barras
                                                                    <input type="text" class="form-control" autocomplete="off" id="q5" placeholder="Buscar codigo de barras" onkeyup="Lector(this.value);">
                               
                                                                
                                                    </div>
                                                        
                                                        
						</div>
				
				
                                    
				
                                    <div class="col-md-12 col-sm-12 col-xs-12">
					<div class="pull-right">
						
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
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  
  <script src="js/icheck/icheck.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
  <link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
	<script>
		
        
        
        
        $(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
                        
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_entsal.php?action=ajax&page='+page+'&q='+q,
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
                        var lote=document.getElementById('lote_'+id).value;
                        
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
                            url: "./ajax/agregar_entradas1.php",
                            data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock+"&lote="+lote,
                            beforeSend: function(objeto){
                            $("#resultados").html("Mensaje: Cargando...");
                            },
                             success: function(datos){
                             $("#resultados").html(datos);
                            }
                        });
                 }
		 function Lector(n){
			
			$.ajax({
                        type: "POST",
                        url: "./ajax/productos_factura1.php",
                        data: "barra="+n,
                        beforeSend: function(objeto){
                            $("#resultados").html("Mensaje: Cargando...");
                        },
                        success: function(datos){
                        $( "#resultados" ).load( "ajax/agregar_entradas1.php" );
                        }
			});
                        setTimeout(blanco, 1200); 
		}
                
                 function blanco() {
                 
                         document.getElementById("q5").value = "";
        $( "#resultados" ).load( "ajax/agregar_entradas1.php" );
        
                }
                
                function lote (id)
		{
                        
                    var lote=document.getElementById('lote'+id).value;
                    $.ajax({
                    type: "GET",
                    url: "./ajax/agregar_entradas1.php",
                    data: "lote="+lote,
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
        url: "./ajax/agregar_entradas1.php",
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
		  
		  var id_vendedor = $("#id_vendedor").val();
		  
                 
		  var moneda = $("#moneda").val();
                  var fecha = $("#fecha").val();
                    var hora = $("#hora").val();
                    var serie = $("#serie").val();
                    var tienda2 = $("#tienda2").val();
                     var motivo = $("#motivo").val();
                   
		  
		 VentanaCentrada('./pdf/documentos/factura4_pdf.php?id_vendedor='+id_vendedor+'&moneda='+moneda+'&fecha='+fecha+'&hora='+hora+'&serie='+serie+'&tienda2='+tienda2+'&motivo='+motivo,'Factura','','1024','768','true');
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
        <script type="text/javascript">
$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});
</script>
</body>

</html>
<?php
ob_end_flush();
?>














