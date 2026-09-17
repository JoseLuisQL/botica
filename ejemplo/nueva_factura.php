<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
//include('conexion.php');
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$sql2="select * from datosempresa where id_emp=1";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$dolar=$rs2["dolar"];

$tienda1=$_SESSION['tienda'];
$sql3="select * from sucursal where tienda=$tienda1";
$rw3=mysqli_query($con,$sql3);//recuperando el registro
$rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
$caja=$rs3["caja"];

$session_id=session_id();
$delete2=mysqli_query($con, "delete from tmp where session_id='".$session_id."'");
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
   header("location: login.php");
    exit;
}

if($a[20]==0){
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

  <title>Nuevo Documento </title>

  <link rel="stylesheet" type="text/css" href="css/formularios.css"/>
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">


  <script src="js/jquery.min.js"></script>

 <style type="text/css">
#caja_busqueda /*estilos para la caja principal de busqueda*/
{
width:100%;
height:25px;
border:solid 2px #979DAE;
font-size:11px;

}
#display /*estilos para la caja principal en donde se puestran los resultados de la busqueda en forma de lista*/
{
width:1050px;
background: white;
overflow:hidden;
z-index:10;

position:absolute;

}
.display_box /*estilos para cada caja unitaria de cada usuario que se muestra*/
{
padding:2px;
padding-left:6px; 
font-size:11px;

text-decoration:none;
color:#3b5999; 
}

.display_box:hover /*estilos para cada caja unitaria de cada usuario que se muestra. cuando el mause se pocisiona sobre el area*/
{
background: #7f93bc;
color: black;
}
.desc
{
color:#666;
font-size:11;
}
.desc:hover
{
color:#FFF;
}

/* Easy Tooltip */
</style>     
         <script type="text/javascript">
$(document).ready(function(){

$(".busca").keyup(function() //se crea la funcioin keyup
{
var texto = $(this).val();//se recupera el valor de la caja de texto y se guarda en la variable texto
var dataString = 'palabra='+ texto;//se guarda en una variable nueva para posteriormente pasarla a search.php
if(texto=='')//si no tiene ningun valor la caja de texto no realiza ninguna accion
{
    $("#display").hide();
                        return false;
}
else
{
$.ajax({//metodo ajax
type: "POST",//aqui puede  ser get o post
url: "search.php",//la url adonde se va a mandar la cadena a buscar
data: dataString,
cache: false,
success: function(html)//funcion que se activa al recibir un dato
{
$("#display").html(html).show();// funcion jquery que muestra el div con identificador display, como formato html, tambien puede ser .text
	}
});
}return false;    
});
});
jQuery(function($){//funcion jquery que muestra el mensaje "Buscar amigos..." en la caja de texto
   $("#caja_busqueda").Watermark("Buscar producto...");
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
          <?php
                    $read="";  
                    $required="";
                    $color="";
                    $form="facturas.php";
                    if ($_SESSION['doc_ventas']>=5 and $_SESSION['doc_ventas']<8) {
                        $_SESSION['doc_ventas']=1;
                    }
                    if ($_SESSION['doc_ventas']==1) {
                        $doc="Factura";
                        $read="readonly";
                        $required="required";
                        $color="#F5D0A9";
                        $dato="INGRESAR RUC";
                        $dato1="";
                        $dato2="";
                    }
                    if ($_SESSION['doc_ventas']==2) {
                        $doc="Boleta";
                        $read="readonly";
                        $dato="INGRESAR DNI";
                        $dato1="11111111";
                        $dato2="CLIENTES VARIOS";
                    }
                    if ($_SESSION['doc_ventas']==3) {
                        $doc=doc;
                        $read="readonly";
                        $dato="INGRESAR RUC/DNI";
                        $dato1="11111111";
                        $dato2="CLIENTES VARIOS";
                    }
                    if ($_SESSION['doc_ventas']==8) {
                        $doc="Cotizacion";
                        $read="readonly";
                        $dato="INGRESAR RUC/DNI";
                        $dato1="11111111";
                        $dato2="CLIENTES VARIOS";
                    }
                   


                    ?>
      
          
        <div class="container" >
            <div class="panel panel-info" >
		
		<div class="panel-body" style="background:<?php echo COLOR;?>;color:black;">
		<?php 
			include("modal/buscar_productos.php");
                        include("modal/buscar_servicio.php");
			//include("modal/registro_clientes.php");
			
		?><div class="form-group row" >
                    <form class="form-horizontal" role="form" id="datos_factura" action="<?php echo $form;?>" method="get">
			<div class="btn-group">
                    <button type="button" class="btn btn-danger"><?php echo "$doc";?></button>
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <span class="caret"></span>
                     
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="doc.php?accion=1&tipo=1">Factura</a>
                      </li>
                      <li><a href="doc.php?accion=2&tipo=1">Boleta</a>
                      </li>
                     
                     
                      
                     <li><a href="doc.php?accion=3&tipo=1"><?php echo doc;?></a>
                      </li>
                       <li><a href="doc.php?accion=8&tipo=1">Cotizacion</a>
                      </li>
                    </ul>
                  </div> <font color="black">LLenar los campos</font> <font style="background-color:<?php echo COLOR1;?>;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
                        <div class="pull-right">
						
						
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
                                            
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1">
						 <span class="glyphicon glyphicon-search"></span> Agregar servicio o descripcion
						</button>
                                            
						<button type="submit" class="btn btn-primary">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div></div>		
                        <div class="form-group row" >
				  
				 
                            
                                  <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Documento del cliente
                                     							                       
                                                            <input class="textfield10" type="text" autocomplete="off" class="form-control input-sm" style="background-color: #F5D0A9;" name="doc1" id="doc1" placeholder="<?php echo $dato;?>" value="<?php echo $dato1;?>" required>
							</div>
                                                        
                             <div class="col-md-6 col-sm-6 col-xs-12">
                                      Cliente
                                      <input class="textfield10"  type="text" readonly  class="form-control input-sm" style="background-color: #F5D0A9;" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre del cliente" value="<?php echo $dato2;?>" required>
					 
                                      <input id="id_cliente" type='hidden'>	
				  </div>
                                    <div  class="col-md-2 col-sm-2 col-xs-12">
                                                           Tipo Doc
								<select  class="textfield11" class='form-control input-sm' id="tip_doc" name="tip_doc">
                                                                   <?php         
                                                                   if ($_SESSION['doc_ventas']==1 or $_SESSION['doc_ventas']>=3) {
                                                                     ?>
                                                                    
                                                                    <option value="2" selected>RUC</option>
                                                                     <?php
                                                                   }         
                                                                   if ($_SESSION['doc_ventas']==2 or $_SESSION['doc_ventas']==3 or $_SESSION['doc_ventas']==8) {
                                                                     ?>
                                                                    <option value="1" selected>DNI</option>
                                                                    <?php
                                                                   }         
                                                                            
                                                                    ?>
									
									
								</select>
							</div>                     
                            
                                  <div class="col-md-2 col-sm-2 col-xs-12">
                                      <input  type="button" class="btn btn-success" style=" margin-top: 15px;" id="btn-ingresar" value="Buscar Ruc/Dni" />
                            </div>
                                  <?php
                             

$consulta3 = "SELECT * FROM documento ";
$result3 = mysqli_query($con, $consulta3);
while ($valor3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
    if($valor3['id_documento']==$_SESSION['doc_ventas']){
        
       
            $doc=$valor3["tienda$tienda1"]+1;
            $doc11=$valor3["folio$tienda1"];
        
    
    }
}
                                  ?>
                                     </div>
                                     <div class="form-group row" >
                                          <div class="col-md-8 col-sm-8 col-xs-12">
                                                            Dirección del cliente:
								<input class="textfield10" type="text" autocomplete="off" style="background-color: <?php echo $color;?>;" class="form-control input-sm" id="direccion_cliente" placeholder="Dirección del cliente" <?php echo $required;?>>
							</div>
                                         <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Teléfono
								<input class="textfield10" type="text" autocomplete="off" class="form-control input-sm" id="tel1" placeholder="Teléfono" >
							</div>
					
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                            Email
								<input class="textfield10" type="text" autocomplete="off" class="form-control input-sm" id="mail" placeholder="Email" >
							</div>
                                     </div>
                         
                         
						<div class="form-group row">
  						<div class="col-md-1 col-sm-1 col-xs-12">
                                                            
								Folio<input class="textfield10" type="text" value="<?php echo $doc11;?>" class="form-control input-sm" id="folio" placeholder="Folio" readonly required>
							</div>
                                                        
                                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                                            
								Documento<input class="textfield10" type="text" value="<?php echo $doc;?>" class="form-control input-sm" id="factura" placeholder="Número de doc" readonly required>
							</div>
                                  
                                                       <input type="hidden" id="des" value="1"> 
                                                    
                                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                                         Tipo:
                                                        <select class="textfield11" style="background-color: #F5D0A9;" class='form-control input-sm' id="tip" required>
			                                        
                                                                
                                                                <?php
                                                                //print"<option value=1>EXONERADA</option>";
                                                                print"<option value=0>CON IGV</option>";
                                                                
                                                                                                                    
                                                            ?>
						                
			                                        
			                                    </select>
                                                    </div>
                                                    
                                                    
                              
							
							<?php date_default_timezone_set('America/Lima');?>
							
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                            Fecha:
								<input class="textfield10" style="background-color: #F5D0A9;" type="date" class="form-control input-sm" id="fecha" value="<?php echo date("Y-m-d");?>" required>
							</div>
							
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Hora:
								<input class="textfield10" style="background-color: #F5D0A9;" type="time" class="form-control input-sm" id="hora" value="<?php echo date("H:i:s");?>" required>
							</div>
                                                    
                                                   
                                                    <input type="hidden" class="form-control input-sm" value="1" name="moneda" id="moneda"  required>
						
                                                    <input type="hidden" class="form-control input-sm" value="<?php echo $dolar;?>" name="tcp" id="tcp"  required>
							
                                                    <div  class="col-md-2 col-sm-2 col-xs-12">
                                                            Pago
								<select class="textfield11" style="background-color: #F5D0A9;" class='form-control input-sm' id="condiciones">
									<option value="1">Efectivo</option>
									<option value="2">Cheque</option>
									<option value="3">Transferencia bancaria</option>
									 <?php
                                                                        if ($_SESSION['doc_ventas']<5) {
                                                                        ?>
                                                                            <option value="4">Crédito</option>
                                                                        <?php            
                                                                        }
                                                                        ?>
                                                                        
                                                                        
								</select>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
                                                            Nro Dias
								<input class="textfield10" style="background-color: #F5D0A9;" autocomplete="off" type="text" value="0" class="form-control input-sm" id="dias" name="dias" placeholder="Número de días de crédito">
							</div>
                                                        
						</div>
				
				
				<div class="col-md-12">
					
				</div>
			</form>	
		<div style=" width:100%; padding-left:3px; " >
  <input type="search" class="busca" id="caja_busqueda" name="clave" placeholder="Buscar nombre producto o por codigo producto o por componente"/><br />
</div> 
   
    
<div id="display" style="position: absolute;"></div>	
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
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
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
						$("#doc1").autocomplete({
							source: "./ajax/autocomplete/clientes1.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#tel1').val(ui.item.telefono_cliente);
								$('#mail').val(ui.item.email_cliente);
								$('#doc1').val(ui.item.doc1);
                                                                $('#direccion_cliente').val(ui.item.direccion_cliente);
								
							 }
						});
						 
						
					});
					
	$("#doc1" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
                                                        $("#doc1" ).val("");
							$("#direccion_cliente" ).val("");				
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#mail" ).val("");
                                                        $("#doc1" ).val("");
                                                        $("#direccion_cliente" ).val("");
						}
			});	
	   $(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
                        var q1=$("#q1").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_factura.php?action=ajax&page='+page+'&q='+q+'&q1='+q1,
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
			
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});
                        
		}
	
        function agregar2 (id)
		{
			var precio_venta=document.getElementById('precio_'+id).value;
			var cantidad=document.getElementById('cant_'+id).value;
                        var stock=document.getElementById('stoc_'+id).value;
			//Inicia validacion
			
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
			});
                        document.getElementById("caja_busqueda").value = "";
                        $("#caja_busqueda").focus();
                       $("#display").hide();
                        return false;
                        
		}
                
                
               function agregar1 (id1)
		{
			var precio_venta=document.getElementById('precio_ventaa_'+id1).value;
			var cantidad=document.getElementById('cantidada_'+id1).value;
                        var id=document.getElementById('descripcion_'+id1).value;
                        var stock=document.getElementById('stocka_'+id1).value;
			//Inicia validacion
			
			//Fin validacion
			
			$.ajax({
        type: "POST",
        url: "./ajax/agregar_facturacion.php",
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
        url: "./ajax/agregar_facturacion.php",
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
		  var id_cliente = $("#id_cliente").val();
		  var id_vendedor = $("#id_vendedor").val();
		  var condiciones = $("#condiciones").val();
                 
                  var factura = $("#factura").val();
		   var fecha = $("#fecha").val();
                    var hora = $("#hora").val();
                     var moneda = $("#moneda").val();
                     var dias = $("#dias").val();
                      var tcp = $("#tcp").val();
                    var folio = $("#folio").val();
                    var nro_doc = $("#nro_doc").val();
                    var motivo = $("#motivo").val();
                    var nombre_cliente = $("#nombre_cliente").val();
                    var doc1 = $("#doc1").val();
                    var tip_doc = $("#tip_doc").val();
                    var tel1 = $("#tel1").val();
                    var mail = $("#mail").val();
                    var direccion = $("#direccion_cliente").val();
                    var des = $("#des").val();
                    var tip = $("#tip").val();
                         var n = doc1.length;
                    
                        if ((n == 11 && tip_doc==2) |  (n == 8 && tip_doc==1) ) {
                            VentanaCentrada('./pdf/documentos/factura_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor+'&factura='+factura+'&dias='+dias+'&condiciones='+condiciones+'&fecha='+fecha+'&hora='+hora+'&moneda='+moneda+'&tcp='+tcp+'&folio='+folio+'&nro_doc='+nro_doc+'&motivo='+motivo+'&nombre_cliente='+nombre_cliente+'&doc1='+doc1+'&tip_doc='+tip_doc+'&tel1='+tel1+'&mail='+mail+'&direccion='+direccion+'&des='+des+'&tip='+tip,'Factura','','1024','768','true');
                  
                        }else{
                           
                            alert('El dni o ruc es erroneo');
                            event.preventDefault();
                        }
                    
	 	});
		
		$( "#guardar_cliente" ).submit(function( event ) {
		  $('#guardar_datos').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/nuevo_cliente.php",
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

    $(document).on('ready',function(){

      $('#btn-ingresar').click(function(){
        var url = "busqueda.php";                                      
        
        $.ajax({                        
           type: "POST",                 
           url: url,                    
           data: $("#datos_factura").serialize(),
           success: function(data)            
           {
             $('#doc1').html(data);
             
             porciones = data.split('|');


             document.getElementById("nombre_cliente").value = porciones[0];
             document.getElementById("direccion_cliente").value = porciones[1];
             document.getElementById("tel1").value = porciones[2];
             document.getElementById("mail").value = porciones[3];
           }
         });
         
      });
    });
    function rucValido(ruc) {
    //11 dígitos y empieza en 10,15,16,17 o 20
    if (!(ruc >= 1e10 && ruc < 11e9
       || ruc >= 15e9 && ruc < 18e9
       || ruc >= 2e10 && ruc < 21e9))
        return false;
    
    for (var suma = -(ruc%10<2), i = 0; i<11; i++, ruc = ruc/10|0)
        suma += (ruc % 10) * (i % 7 + (i/7|0) + 1);
    return suma % 11 === 0;
    
}
  
        </script>
  
 
</body>

</html>















