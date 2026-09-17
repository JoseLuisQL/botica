<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos 
$mensaje=recoge1('mensaje');


$consulta2 = "SELECT * FROM datosempresa ";
$result2 = mysqli_query($con, $consulta2);
$valor2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
$dolar=$valor2['dolar'];

$consulta3 = "SELECT * FROM ultimo ORDER BY ultimo.ultimo DESC LIMIT 0,1";
$result3 = mysqli_query($con, $consulta3);
$valor3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
$ultimo=$valor3['ultimo']+1;

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[10]==0){
    header("location:error.php");    
}

function generar_numero_aleatorio($longitud) {
	$key = '';
	$pattern = '1234567890';
	$max = strlen($pattern)-1;
	for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
	return $key;
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

  <title> 
  
  Ingreso de productos
  </title>

 <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>
<link href="css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">
<link href="css/select/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
 <script>
  function limpiarFormulario() {
    document.getElementById("guardar_producto").reset();
    
  }
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
<style type="text/css"> 
    .fijo {
	background: #333;
	color: white;
	height: 10px;
	
	width: 100%; /* hacemos que la cabecera ocupe el ancho completo de la página */
	left: 0; /* Posicionamos la cabecera al lado izquierdo */
	top: 0; /* Posicionamos la cabecera pegada arriba */
	position: fixed; /* Hacemos que la cabecera tenga una posición fija */
} 




    table tr:nth-child(odd) {background-color: #FBF8EF;}

table tr:nth-child(even) {background-color: #EFFBF5;}
 .valor1 {
              

border-bottom: 2px solid #F5ECCE;

}  

-valor1:hover {
              
background-color: white;
border-bottom: 2px solid #A9E2F3;

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

          <div style="background:<?php echo COLOR;?>;color:black;"> 
          
          <div class="panel panel-info">
		<div class="panel-heading">
		    <?php 
                                $video=videos;
                    
                                if($video==1){
                                    $v="Tctpr8s4OIM";
                                    include("modal/registro_video.php");
                                    ?>
                                    <div class="btn-group pull-right">
                                        <button type='button' class="btn btn-danger" data-toggle="modal" data-target="#nuevoVideo"><span class="glyphicon glyphicon-play" ></span>Video Tutorial</button>
                                    </div>
                                    <?php
                    
                                }
                        ?>
                    <h3>Ingresar datos del producto:</h3>
                    <font color="black">LLenar los campos obligatorios</font> <font style="background-color:<?php echo COLOR1;?>;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
		</div>        
        </div>  
           <?php
          
          if($mensaje<>"")
              {
              ?>
               <div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error! <?php echo $mensaje;?></strong> 
					
			</div>
             <?php 
          }
       
     
                        print"<form class=\"form-horizontal form-label-left\" id=\"guardar_producto\" enctype=\"multipart/form-data\" action=\"ingresoproductos1.php\" method=\"POST\">";

                        ?>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                        <div style="background:#045FB4;padding:2px;color:white;font-weight:bold;">Identificacion:</div>    
                        <div class="form-group">
                            <br><label for="codigo"  class="col-sm-4 control-label">Código del producto <font color="Red"><strong>(Sin repetir):</strong></font></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    
				  <input style="background:<?php echo COLOR1;?>;" type="text"  autocomplete="off" class="form-control" id="codigo" name="codigo" placeholder="El código debe ser corto y numerico" required value="<?php echo $ultimo;?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '<?php echo $ultimo;?>';}">
				</div>
			</div>
          
                        <div class="form-group">
                                <label for="nombre"  class="col-sm-4 control-label">Nombre del producto <font color="Red"><strong>(Sin repetir):</strong></font></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                   <input style="background:<?php echo COLOR1;?>;"  type="search" style="color:black;font-size:10pt; font-family:Verdana;" class="form-control" id="nombre_producto" name="nombre"  placeholder="Nombre del producto" >
                                </div>
                        </div>
                        <div class="form-group">
                                
                            
				<label for="nombre" class="col-sm-4 control-label">Ingresar foto:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input id="valor1" accept="image/jpeg" type="file" id="files" name="files" class="form-control"/>
				  
				</div>
			  </div>   
                        <div class="form-group">
				<label for="cat_pro" class="col-sm-4 control-label">Categoria</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
				 <select  style="background:<?php echo COLOR1;?>;"  class="form-control" id="cat_pro" name="cat_pro" required>
					<option value="">-- Selecciona Categoria --</option>	
                        <?php 
                        $nom = array();
                        $sql2="select * from categorias ";
                        $i=0;
                        $rs1=mysqli_query($con,$sql2);
                        while($row3=mysqli_fetch_array($rs1)){
                            $nom_cat=$row3["nom_cat"];
                            $id_categoria=$row3["id_categoria"];
                            ?>
                            <option value="<?php  echo $id_categoria;?>"><?php  echo $nom_cat;?></option>

                            <?php

                            $i=$i+1;
                        }
                        
                        ?>
                     
                         </select>
				</div>
                                
                                <?php
                                $barras=generar_numero_aleatorio(12);
                                ?>
				<label for="color" class="col-sm-1 control-label">Barras</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				  <input  type="text" autocomplete="off" class="form-control" value="<?php echo $barras;?>" id="barras" name="barras" placeholder="barras" required>
				</div>
                                
			  
                            </div>    
                                
                                
                          
                                
                                
                         <div class="form-group">
                         
				
                            <label for="color" class="col-sm-4 control-label"><?php echo des3;?></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input  type="text" autocomplete="off" class="form-control" id="des3" name="des3" placeholder="<?php echo des3;?>" >
				</div>
                            
                            </div>    
                              
                        <div class="form-group">
                            <label for="marca" class="col-sm-4 control-label"><?php echo des1;?></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
				<input  type="text" autocomplete="off" class="form-control" id="des1" name="des1" placeholder="<?php echo des1;?>" >
                            </div>
                        </div>    
                        <div class="form-group">      
                                
                                <label for="modelo" class="col-sm-4 control-label"><?php echo des2;?></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input  type="text" autocomplete="off" class="form-control" id="des2" name="des2" placeholder="<?php echo des2;?>" >
				</div>
                                
			</div>
                        <div class="form-group">      
                                
                                <label for="modelo" class="col-sm-4 control-label">Proveedor</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select  class="form-control" id="proveedor" name="proveedor">
					<option value="">-- Selecciona Proveedor --</option>	
                        <?php 
                        
                        $sql22="select * from clientes where tipo1=2";
                        
                        $rs12=mysqli_query($con,$sql22);
                        while($row32=mysqli_fetch_array($rs12)){
                            $cliente=$row32["nombre_cliente"];
                            //$id=$row3["id_cliente"];
                            ?>
                            <option value="<?php  echo $cliente;?>"><?php  echo $cliente;?></option>

                            <?php

                            
                        }
                        
                        ?>
                     
                         </select>
				</div>
                                
			</div>
                        <div class="form-group">
				<label for="cat_pro" class="col-sm-4 control-label">Und/Medida</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select style="background:<?php echo COLOR1;?>;"  class="form-control" id="und_pro" name="und_pro" required>
						
                        <?php 
                       
                        $sql3="select * from und ";
                       
                        $rs3=mysqli_query($con,$sql3);
                        while($row3=mysqli_fetch_array($rs3)){
                            $nom_und=$row3["nom_und"];
                            $id_und=$row3["id_und"];
                            ?>
                            <option value="<?php  echo $id_und;?>"><?php  echo $nom_und;?></option>

                            <?php

                            
                        }
                        
                        ?>
                     
                         </select>
				</div>
			  
				
                                
			  </div>
                         </div>
                          <div class="col-md-5 col-sm-5 col-xs-12">   
                             
                           <div style="background:#045FB4;padding:2px;color:white;font-weight:bold;">Comercial Y Stock:</div>   
                           <br>
                         
                      <div style="background:#045FB4;padding:2px;color:white;font-weight:bold;">Unidad:</div>
			  <div class="form-group">
                              <label for="precio" class="col-sm-1 control-label" style="width:10%;"> Costo</label>
				<div class="col-md-3 col-sm-3 col-xs-12" style="width:23%;">
				  <input style="background:<?php echo COLOR1;?>;"   type="number" min="0.01" step="0.01" autocomplete="off" class="form-control" id="costo" name="costo" placeholder="Costo Unidad" required  title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  
                                <input type="hidden" name="multiplicando"   value="1" >
                      
                        
				<label for="precio" class="col-sm-1 control-label" style="width:10%;">Precio</label>
				<div class="col-md-2 col-sm-2 col-xs-12" style="width:24%;">
				  <input style="background:<?php echo COLOR1;?>;"  type="number" min="0.01" step="0.01"  autocomplete="off" class="form-control" name="precio" id="precio" name="Precio por unidad"  placeholder="Precio" required>
				</div>
                                <div class="form-group">
                               <label for="precio" class="col-sm-2 control-label" style="width:10%;">Stock</label>
				<div class="col-md-2 col-sm-2 col-xs-12" style="width:23%;">
                                    <input style="background:<?php echo COLOR1;?>;"  type="number" min="0" step="0.01" autocomplete="off" class="form-control" id="inventario" name="inventario" placeholder="Stock" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
                            </div> 
                         <!--
                         <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">%ISC al valor</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text"  autocomplete="off" class="form-control" id="por_isc" name="por_isc"  value="0" placeholder="Porcentaje ISC">
				</div>
                                <div class="col-md-1 col-sm-1 col-xs-12">%
                                </div>    
			  </div>
                         -->
                         
				  <input type="hidden"  class="form-control" id="precio1" name="precio1"  value="0">
				     
                                
			 
				  <input type="hidden"  class="form-control" id="precio2" name="precio2"  value="0">
				
                      
                         
				
			  </div>
                           <div style="background:#045FB4;padding:2px;color:white;font-weight:bold;">Blister:</div>
                           <div class="form-group">
                               <label for="precio" class="col-sm-3 control-label" style="width:15%;"> Costo </label>
				<div class="col-md-4 col-sm-4 col-xs-12" style="width:35%;">
				  <input   type="number" min="0.01" step="0.01" autocomplete="off" class="form-control"  id="c2" name="c2" placeholder="Costo blister"   title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  
                                <input type="hidden" name="multiplicando"   value="1" >
                      
                        
				<label for="precio" class="col-sm-2 control-label" style="width:15%;">Precio</label>
				<div class="col-md-3 col-sm-3 col-xs-12" style="width:35%;">
				  <input   type="number" min="0.01" step="0.01"  autocomplete="off" class="form-control" name="p2" id="p2"  placeholder="Precio blister" >
				</div>
                                
                                <label for="precio" class="col-sm-2 control-label" style="width:15%;">Stock</label>
				<div class="col-md-2 col-sm-2 col-xs-12" style="width:35%;">
                                    <input   type="number" min="0" step="1" autocomplete="off" class="form-control" id="s2" name="s2" placeholder="Stock blisters"  pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
                                
                                <label for="precio" class="col-sm-2 control-label" style="width:15%;">Contiene</label>
				<div class="col-md-2 col-sm-2 col-xs-12" style="width:35%;">
                                    <input   type="number" min="0" step="1" autocomplete="off" class="form-control" id="a2" name="a2" placeholder="Unidades contiene"  maxlength="8">
				</div>
                       
                      
                         
				
			  </div>
                           <div style="background:#045FB4;padding:2px;color:white;font-weight:bold;" style="width:10%;">Caja:</div>
                           <div class="form-group">
                               <label for="precio" class="col-sm-3 control-label" style="width:15%;"> Costo</label>
				<div class="col-md-4 col-sm-4 col-xs-12" style="width:35%;">
				  <input   type="number" min="0.01" step="0.01" autocomplete="off" class="form-control"  id="c3" name="c3" placeholder="Costo Caja"  title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  
                                <input type="hidden" name="multiplicando"   value="1" >
                      
                        
				<label for="precio" class="col-sm-2 control-label" style="width:15%;">Precio</label>
				<div class="col-md-3 col-sm-3 col-xs-12" style="width:35%;">
				  <input   type="number" min="0.01" step="0.01"  autocomplete="off" class="form-control" name="p3" id="p3"   placeholder="Precio Caja" >
				</div>
                                <label for="precio" class="col-sm-2 control-label" style="width:15%;">Stock</label>
				<div class="col-md-2 col-sm-2 col-xs-12" style="width:35%;">
                                    <input   type="number" min="0" step="1" autocomplete="off" class="form-control" id="s3" name="s3" placeholder="Stock Cajas"  pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
                                <label for="precio" class="col-sm-2 control-label" style="width:15%;">Contiene</label>
                                <div class="col-md-2 col-sm-2 col-xs-12" style="width:35%;">
                                    <input   type="number" min="0" step="1" autocomplete="off" class="form-control" id="a3" name="a3" placeholder="Unidades contiene"  maxlength="8">
				</div>
                      
                         
				
			  </div>
                           
                           
                              <div class="form-group">
                                <label for="color" class="col-sm-2 control-label">Monedero</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				  <input  type="number" min="0.00" step="0.01" autocomplete="off" class="form-control" id="mon" name="mon" placeholder="Monedero" >
				</div>   
                                <label for="modelo" class="col-sm-3 control-label">Stock min</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
				  <input style="background:<?php echo COLOR1;?>;" type="number" min="0" step="0.01"  class="form-control" id="min" name="min" placeholder="Min" required>
				</div>
                              </div>
                            
                            
                            
				
                               
                                
			  
                            
                             <div class="form-group">
				<label for="modelo" class="col-sm-2 control-label">Cantidad Incentivo</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				  <input  type="number" min="0" step="0.01"  class="form-control" id="valor2" name="valor2" placeholder="Incentivo">
				</div>
                               
                                
                            
				<label for="modelo" class="col-sm-3 control-label">Valor Pago Incentivo</label>
				<div class="col-md-3 col-sm-3 col-xs-12">
				  <input  type="number" min="0" step="0.01"  class="form-control" id="valor3" name="valor3" placeholder="Incentivo">
				</div>
                               
                                
                            </div>
                            
                            
              
                          </div>      
                          
       
    <?php
    
  
$sql3="select distinct des1 from products ";
    $i=0;
$rs2=mysqli_query($con,$sql3);
while($row4=mysqli_fetch_array($rs2)){
   
    $marca[$i]=$row4["des1"];

    $i=$i+1;
}

$sql4="select distinct des2 from products ";
    $i=0;
$rs4=mysqli_query($con,$sql4);
while($row5=mysqli_fetch_array($rs4)){
    $modelo[$i]=$row5["des2"];
    $i=$i+1;
}

$sql5="select distinct des3 from products ";
$i=0;
$rs5=mysqli_query($con,$sql5);
while($row6=mysqli_fetch_array($rs5)){
    $color[$i]=$row6["des3"];
    $i=$i+1;
}
    ?>       
    
        
 
 </td></tr>
     
     

    <script>
    var tags1 = [];
                <?php
                    for($i = 0 ;$i<count($marca);$i++){
                ?>
                tags1.push("<?php echo $marca[$i];?>");
                <?php } ?>
                
  

            
    $("#marca" ).autocomplete({
  source: function( request, response ) {
          var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
          response( $.grep( tags1, function( item ){
              return matcher.test( item );
          }) );
      }
});
    
    </script>
    
    
    <script>
    var tags2 = [];
                <?php
                    for($i = 0 ;$i<count($modelo);$i++){
                ?>
                tags2.push("<?php echo $modelo[$i];?>");
                <?php } ?>
                
  

            
    $("#modelo" ).autocomplete({
  source: function( request, response ) {
          var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
          response( $.grep( tags2, function( item ){
              return matcher.test( item );
          }) );
      }
});
    
    </script>
    
   
    
     <script>
    var tags3 = [];
                <?php
                    for($i = 0 ;$i<count($color);$i++){
                ?>
                tags3.push("<?php echo $color[$i];?>");
                <?php } ?>
                
  

            
    $("#color" ).autocomplete({
  source: function( request, response ) {
          var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
          response( $.grep( tags3, function( item ){
              return matcher.test( item );
          }) );
      }
});
    
    </script>
      
           <div class="modal-footer">
                      <button type="button" class="btn btn-success" onclick="limpiarFormulario()">Limpiar</button>
			
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  
                  </div>
		  </form>
          
          
          
           </div>
          </div>
         
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
  <script src="js/pace/pace.min.js"></script>
  <script src="js/select/select2.full.js"></script>
 <link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
  
        <script>
		$(function() {
						$("#nombre_producto").autocomplete({
							source: "./ajax/autocomplete/productos1.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_producto').val(ui.item.id_producto);
								$('#nombre_producto').val(ui.item.nombre_producto);
								
                                                               
                                                                
							 }
						});
						 
						
					});
					
	$("#nombre_producto" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_producto" ).val("");
							
                                                      
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_producto" ).val("");
							$("#id_producto" ).val("");
							
                                                        
                                                                
						}
			});	
	
  </script>
  
</body>

</html>
<?php
ob_end_flush(); 
?>
