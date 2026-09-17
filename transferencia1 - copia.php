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
if($a[14]==0){
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

  <title>Productos Transferidos </title>

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
                    <?php 
                                $video=videos;
                    
                                if($video==1){
                                    $v="krWNC9ULZO0";
                                    include("modal/registro_video.php");
                                    ?>
                                    <div class="btn-group pull-right">
                                        <button type='button' class="btn btn-danger" data-toggle="modal" data-target="#nuevoVideo"><span class="glyphicon glyphicon-play" ></span>Video Tutorial</button>
                                    </div>
                                    <?php
                    
                                }
                    ?>
                    <h4> Productos Transferidos</h4>
		</div>
                    <div class="panel-body">
                      <form style="color:black;" class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-1 control-label">Producto</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" class="form-control" id="q" placeholder="Nombre del producto" onkeyup='load(1);'>
							</div>
                                                        <label for="q1" class="col-md-1 control-label">Fecha1</label>
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
								<input type="date" class="form-control" id="q1" onkeyup='load(1);'>
							</div>
                                                        <label for="q2" class="col-md-1 control-label">Fecha2</label>
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
								<input type="date" class="form-control" id="q1" onkeyup='load(1);'>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<button type="button" class="btn btn-default" onclick='load(1);'>
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

        <?php
          footer();
          
          ?>
     
      </div>
  
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
<script>
        $(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
                        var q1= $("#q1").val();
                        var q2= $("#q2").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_servicios.php?action=ajax&page='+page+'&q='+q+'&q1='+q1+'&q2='+q2,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}
                function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el servicio")){	
		$.ajax({
                type: "GET",
                url: "./ajax/buscar_servicios.php",
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
        $( "#guardar_servicios" ).submit(function( event ) {
        $('#guardar_datos').attr("disabled", true);
        var parametros = $(this).serialize();
	$.ajax({
            type: "POST",
            url: "ajax/nuevo_servicios.php",
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

$( "#editar_servicios" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_servicios.php",
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
    var codigo = $("#codigo"+id).val(); 
    $("#mod_nombre").val(nombre);
    $("#mod_codigo").val(codigo);
    $("#mod_id").val(id);
}      
</script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
 <script>
	$(function() {
		$("#q").autocomplete({
                    source: "./ajax/autocomplete/productos.php",
                    minLength: 1,
                    select: function(event, ui) {
			event.preventDefault();
			$('#id_producto').val(ui.item.id_producto);
			$('#q').val(ui.item.nombre_producto);
			$('#precio_producto').val(ui.item.precio_producto);
			$('#inv_producto').val(ui.item.inv_producto);
                    }
		});
        });
					
	$("#q" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_producto" ).val("");
							$("#inv_producto" ).val("");
							$("#precio_producto" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#q" ).val("");
							$("#id_producto" ).val("");
							$("#inv_producto" ).val("");
							$("#precio_producto" ).val("");
						}
			});	

  </script>
<script src="js/select/select2.full.js"></script>
</body>
</html>
<?php
ob_end_flush(); 
?>






