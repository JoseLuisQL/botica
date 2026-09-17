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

$tienda1=$_SESSION['tienda'];
$user_id=$_SESSION['user_id'];

$caja=0;
$cierre=0;
$sql3="select * from caja where tienda=$tienda1 and usuario_inicio=$user_id ORDER BY caja.id_caja DESC LIMIT 0 , 1";
$rw3=mysqli_query($con,$sql3);//recuperando el registro
$rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
$caja=$rs3["usuario_inicio"];
$cierre=$rs3["cierre"];
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[25]==0){
    header("location:error.php");    
}
if($cierre>0 or $cierre==""){
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

  <title>PLanilla </title>

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

          <div class="row">

           <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
                        <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nuevo Pago</button>
			</div>
                            
			<h4><i class='glyphicon glyphicon-search'></i> Pago de Personal</h4>
		</div>
		<div class="panel-body">
		
			<?php
                      
			include("modal/registro_planilla.php");
			include("modal/editar_planilla.php");
                        
                        $con;
			?>
			<form style="color:black;" class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							
							<div class="col-md-6 col-sm-6 col-xs-12" >
                                                            Nro de Documento
								<input type="text" autocomplete="off" class="form-control" id="q" placeholder=Nro de Documento" onkeyup='load(1);'>
							</div>
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                                Trabajador
								<select class="form-control" id="q4"  onchange='load(1);'>
                                                                    <option value="">Elegir</option>
                                                                   <?php
    
  
                                                                    $sql3="select*from clientes where tipo1=0 ORDER BY  nombre_cliente ASC ";
                                                                    $i=0;
                                                                    $rs2=mysqli_query($con,$sql3);
                                                                    while($row4=mysqli_fetch_array($rs2)){
                                                                        $id_cliente=$row4["id_cliente"];
                                                                        $nombre=$row4["nombre_cliente"];
                                                                        ?>
                                                                        <option value="<?php echo $id_cliente;?>"><?php echo $nombre;?></option>
                                                                        <?php
                                                                        
                                                                    }
                                                                    ?>
                                                                    
                                                                </select>
							</div>
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                                Buscar Fecha1
								<input type="date"  class="form-control" id="q2"  onchange='load(1);'>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                                Buscar Fecha2
								<input type="date"  class="form-control" id="q3"  onchange='load(1);'>
							</div>
							
							<div class="col-md-12 col-sm-12 col-xs-12">
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
  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
  <script src="js/custom.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
<script>
$( "#guardar_otrospagos" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_planilla.php",
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

$(document).ready(function(){
			load(1);
			
		});


function load(page){
			var q= $("#q").val();
                        var q2= $("#q2").val();
                        var q3= $("#q3").val();
                        var q4= $("#q4").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_planilla.php?action=ajax&page='+page+'&q='+q+'&q2='+q2+'&q3='+q3+'&q4='+q4,
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
		if (confirm("Realmente deseas eliminar la operación")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_planilla.php",
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
	
       $( "#editar_otrospagos" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_planilla.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
}) 
        
        
    function obtener_datos(id){
			var nombre = $("#nombre"+id).val();
                        var ven_com = $("#ven_com"+id).val();
                        var cliente = $("#cliente"+id).val();
                        var vendedor = $("#vendedor"+id).val();
			var condiciones = $("#condiciones"+id).val();
			var total = $("#total"+id).val();
			var estado_factura = $("#estado_factura"+id).val();
			var numero_factura = $("#numero_factura"+id).val();
                        
                        var obs = $("#obs"+id).val();
                        
                        
                        
                        $("#mod_nombre").val(nombre);
                        $("#mod_ven_com").val(ven_com);
                        $("#mod_cliente").val(cliente);
                        $("#mod_vendedor").val(vendedor);
                        $("#mod_condiciones").val(condiciones);
                        
			$("#mod_pago").val(total);
			$("#mod_estado_factura").val(estado_factura);
			$("#mod_numero_factura").val(numero_factura);
			$("#mod_obs").val(obs);                      
                        
        $("#mod_id").val(id);
                        
                         
		
		}    
  function imprimir_factura2(id_factura){
			VentanaCentrada('./pdf/documentos/ver_ticket2.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}       
</script>
</body>
</html>
<?php
ob_end_flush(); 
?>






