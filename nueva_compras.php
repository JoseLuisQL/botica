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
if($a[33]==0){
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

  <title>Nueva compras </title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>

 <style type="text/css">
#caja_busqueda /*estilos para la caja principal de busqueda*/
{
width: 100%;
height: 25px;
border: solid 1px #00c2ff;
font-size: 11px;

}
#display /*estilos para la caja principal en donde se puestran los resultados de la busqueda en forma de lista*/
{
width:100%;
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
background: #F5F6CE;
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
texto=encodeURIComponent(texto);
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
url: "search1.php",//la url adonde se va a mandar la cadena a buscar
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


<body class="nav-sm">

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
	
		<?php 
			include("modal/buscar_productos.php");
                        include("modal/registro_productos.php");
			include("modal/registro_proveedores.php");
			
		?>
                <div class="row" style="background:white;color:black;">
                    
                     <div class="col-md-7 col-sm-7 col-xs-12" style=" background: white; ">
                         
					
				
                         
                            <table class="table" style="margin:1px;padding:10px;width:100%;">
                                <tr style="background:#E6E6E6;color:black;">
                                    <td style="width:70%;padding:2px;">    
										<input type="search" style="height:25px;" autocomplete="off" class="busca" id="caja_busqueda" name="clave" placeholder="Buscar nombre o codigo producto">
                                        <div id="display" style="position: absolute;"></div>
                                    </td>
                                    <td style="width:30%;padding:2px;">
										<input type="text" style="width:100%;height:25px;" autocomplete="off" id="q5" placeholder="Codigo barras" onkeyup="Lector(this.value);">
                               
                                </td></tr>
                            </table>    
                         <div id="resultados" style="margin-top:10px"></div> 
			 
                         
                     </div>
                   
                    <div class="col-md-5 col-sm-5 col-xs-12" style="background: <?php echo COLOR;?>;border:2px solid #00BFFF;border-radius:13px;box-shadow: 0 0 13px #00BFFF;" >
               
		
			<form class="form-horizontal" role="form" id="datos_factura" action="compras.php">
				 <div style="background:#01A9DB;padding:5px;margin:5px;border-radius: 7px;">
                                      
                            <font color="white" size="3"><strong>COMPRAS:</strong></font><font color="black">LLenar campos obligatorios</font> <font style="background-color:#D8D8D8;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>                          
                        </div> 



								<div>
									&nbsp;		
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#nuevoProveedores">
									<span class="glyphicon glyphicon-user"></span>+Proveedor
									</button>																									
									<button type="submit" class="btn btn-primary">
													<span class="glyphicon glyphicon-print"></span> Imprimir
									</button>													
								</div>
                               
                               
                            <div class="form-group row">
				  
								<div class="col-md-12 col-sm-12 col-xs-12">
													Proveedor
									<input autocomplete="off"  type="text" style="background-color: <?php echo COLOR1;?>;" class="form-control" id="nombre_proveedores" placeholder="Selecciona un proveedor" required>
									<input id="id_proveedores" type='hidden'>	
								</div>
                                
                            </div>    
                                
                            <div class="form-group row">
					
							<div class="col-md-6 col-sm-6 col-xs-12">
                                                            Teléfono
								<input  type="text" class="form-control" id="tel1" placeholder="Teléfono" readonly>
							</div>
					
							<div class="col-md-6 col-sm-6 col-xs-12">
                                                            Email
								<input  type="text" class="form-control" id="mail" placeholder="Email" readonly>
							</div>
				
                                                </div>
                                 
                                 <div class="form-group row">
				
                                
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                            
                                                Serie<input autocomplete="off" style="background-color:<?php echo COLOR1;?>;" type="text" class="form-control" id="serie" placeholder="Serie" required>
					</div>
							
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                            
						Nro Doc<input autocomplete="off" style="background-color:<?php echo COLOR1;?>;" type="text" pattern="^[1-9]\d*$" class="form-control" id="factura" placeholder="Número de doc" required>
					</div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                         Tipo:
                                                        <select  style="background-color: <?php echo COLOR1;?>;" class='form-control' id="tip" required>
			                                        
                                                                
                                                                <?php
                                                            
                                                                print"<option value=0>IGV</option>";
                                                               
                                                                print"<option value=1>EXONERADA</option>";
                                                                                                                      
                                                            ?>
						                
			                                    </select>
                                                        </div>
                                       <input type="hidden" class="form-control input-sm" id="ot"  value="0" >
				 </div>
						<div class="form-group row">
							
							
							<?php date_default_timezone_set('America/Lima');?>
                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                            Tipo documento
								<select  style="background-color: <?php echo COLOR1;?>;" class='form-control' id="tipo_doc1">
									<option value="1">Factura</option>
									<option value="2">Boleta</option>
									<option value="3"><?php echo doc;?></option>
									
								</select>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
                                                            Fecha
								<input c style="background-color: <?php echo COLOR1;?>;" type="date" class="form-control" id="fecha" value="<?php echo date("Y-m-d");?>" required>
							</div>
							
                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                            Hora:
								<input  style="background-color: <?php echo COLOR1;?>;" type="time" class="form-control" id="hora" value="<?php echo date("H:i:s");?>" required>
							</div>
                                                  
                                                    <input type="hidden"  value="<?php echo 1;?>" name="moneda" id="moneda"  required>
                                                    <input type="hidden"  value="<?php echo $dolar;?>" name="tcp" id="tcp"  required>
							
                                                    </div>
                                 
                                 <div class="form-group row">
				
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            Pago
								<select  style="background-color: <?php echo COLOR1;?>;" class='form-control' id="condiciones">
									<option value="1">Efectivo</option>
									<option value="2">Cheque</option>
									<option value="3">Transferencia bancaria</option>
									<option value="4">Crédito</option>
								</select>
							</div>
                                                        
                                                        
                                                        
							<div class="col-md-6 col-sm-6 col-xs-12">
                                                            Día de Pago al Crédito
                                                            <input autocomplete="off" type="text" style="background-color: <?php echo COLOR1;?>;" pattern="^[0-9]{0,12}([,][0-9]{2,2})?$" class="form-control" id="dias" name="dias" placeholder="Número de días de crédito">
							</div>
															
						</div>
				   
			</form>	
			
		<!-- Carga los datos ajax -->			
                    
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
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>
<script src="js/icheck/icheck.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/pace/pace.min.js"></script> 
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>

  
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
                         $( "#resultados" ).load( "ajax/agregar_compras.php" );
		});

		function load(page){
			var q= $("#q").val();
                        q=encodeURIComponent(q);
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/productos_compras.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
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
        url: "./ajax/agregar_compras.php",
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
                function Lector(n){
			
			$.ajax({
                type: "POST",
                url: "./ajax/productos_factura2.php",
                    data: "barra="+n,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
                    
			});
                        setTimeout(blanco, 1200); 
                        //if(n.length >=12) {
                        //blanco();
                        //}
		}
                
                function blanco() {
                    
                    
                document.getElementById("q5").value = "";
                $( "#resultados" ).load( "ajax/agregar_compras.php" );
        
    
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
                    var tip = $("#tip").val();
                     var dias = $("#dias").val();
                    var tipo_doc1 = $("#tipo_doc1").val();
		  if (id_proveedores==""){
			  alert("Debes seleccionar un proveedor");
			  $("#nombre_proveedores").focus();
			  return false;
		  }
		 VentanaCentrada('./pdf/documentos/factura1_pdf.php?id_proveedores='+id_proveedores+'&id_vendedor='+id_vendedor+'&factura='+factura+'&moneda='+moneda+'&condiciones='+condiciones+'&fecha='+fecha+'&hora='+hora+'&dias='+dias+'&tcp='+tcp+'&serie='+serie+'&tipo_doc1='+tipo_doc1+'&tip='+tip,'Factura','','1024','768','true');
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
function serie (id)
		{
                        
                    var serie2=document.getElementById('serie'+id).value;
                    $.ajax({
                    type: "GET",
                    url: "./ajax/agregar_compras.php",
                    data: "serie2="+serie2,
                    beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
                    },
                    success: function(datos){
                    $("#resultados").html(datos);
                    }
                    });

		}

        </script> 
  <script type="text/javascript" src="jquery.numeric.js"></script>        
        
        
</body>
</html>
<?php
ob_end_flush(); 
?>














