<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$sql2="select * from datosempresa where id_emp=1";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$alerta=$rs2["alerta"];
$precio2=$rs2["precio2"];
$precio3=$rs2["precio3"];

$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[50]==0){
    header("location:error.php");    
 
}

$_SESSION['campo1']="";
$_SESSION['campo2']="";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Valorizacion de Productos </title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>



<style type="text/css"> 
    
.Fields {
	background-color: #A9F5E1;
	border: 2px solid #2E9AFE;
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
        text-align:center;
}


</style>
  
  
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
			
			</div>
			<h4><i class='glyphicon glyphicon-search'></i>Productos en Sucursal<?php echo $_SESSION['tienda']; ?></h4>
                        
                
                </div>
		<div class="panel-body">
                    <?php
                        include("modal/registro_productos.php");
			include("modal/editar_productos.php");
			?>
			
				<form style="color:black;" class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-1 control-label">Buscar</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" autocomplete="off" class="form-control" id="q" placeholder="Código ,nombre, laboratorio,componente" onkeyup='load(1);'>
							</div>
                                                         <div class="col-md-2 col-sm-2 col-xs-12">
								<input type="text" autocomplete="off" class="form-control" id="q1" placeholder="Accion terapeutica" onkeyup='load(1);'>
							</div>
                                                       <div class="col-md-3 col-sm-3 col-xs-12">
								<select class="form-control" id="q2"  onchange='load(1);'>
                                                                    <option value="">LABORATORIOS</option>
                                                                   <?php
    
  
                                                                    $sql3="select distinct des1 from products ORDER BY  `products`.`des1` ASC ";
                                                                    $i=0;
                                                                    $rs2=mysqli_query($con,$sql3);
                                                                    while($row4=mysqli_fetch_array($rs2)){
   
                                                                        $marca=$row4["des1"];
                                                                        ?>
                                                                        <option value="<?php echo $marca;?>"><?php echo $marca;?></option>
                                                                        <?php
                                                                        
                                                                    }
                                                                    ?>
                                                                    
                                                                </select>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<button type="button" class="btn btn-warning" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
                                </form>
                    <a href="descargar1.php" target="_blanck"><img src="images/descargar-excel.png" width="80" height="25"></a>
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
<script>
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

$( "#editar_producto" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_producto.php",
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
			var codigo_producto = $("#codigo_producto"+id).val();
			var nombre_producto = $("#nombre_producto"+id).val();
			
			var precio_producto = $("#precio_producto"+id).val();
                        var costo_producto = $("#costo_producto"+id).val();
                        var status = $("#status"+id).val();
                         var monventa = $("#mon_venta"+id).val();   
                        var moncosto = $("#mon_costo"+id).val();
                        var cat_pro = $("#cat"+id).val();
                        var inv = $("#inv"+id).val();
                        var des1 = $("#des1"+id).val();
                       var des2 = $("#des2"+id).val(); 
                        var des3 = $("#des3"+id).val();
                        var dolar = $("#dolar"+id).val();
                        var costo = $("#costo"+id).val();
                        var utilidad = $("#utilidad"+id).val();
                        var precio2 = $("#valor2"+id).val();
                        var precio3 = $("#valor3"+id).val();
                        var und_pro = $("#und_pro"+id).val();
                        
			$("#mod_id").val(id);
			$("#mod_codigo").val(codigo_producto);
			$("#mod_nombre").val(nombre_producto);
			$("#mod_precio").val(precio_producto);
                        $("#mod_costo").val(costo_producto);
                        $("#mod_status").val(status);
                        $("#mod_monventa").val(monventa);
                        $("#mod_moncosto").val(moncosto);
                        $("#mod_cat").val(cat_pro);
                        $("#mod_inv").val(inv);
                        $("#mod_des1").val(des1);
                        $("#mod_des2").val(des2);
                        $("#mod_des3").val(des3);
                        $("#multiplicando1").val(dolar);
                        $("#soles").val(costo);
                        $("#utilidad").val(utilidad);
                        $("#mod_valor2").val(precio2);
                        $("#mod_valor3").val(precio3);
                        $("#mod_und_pro").val(und_pro);
		}
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/productos1.js"></script>
</body>
</html>
<?php
ob_end_flush(); 
?>






