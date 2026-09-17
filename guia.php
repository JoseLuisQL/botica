<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$accion=recoge1('accion');
$consulta5 = "SELECT * FROM documento where id_documento=4";
$result5 = mysqli_query($con, $consulta5);
$guia1=0;
$tienda1=$_SESSION['tienda'];
$fecha="";
$id_cliente=0;
while ($valor5 = mysqli_fetch_array($result5, MYSQLI_ASSOC)) {
    $serie=$valor5["folio$tienda1"];
    $guia1=$valor5["tienda$tienda1"]+1;
}
$sql="select * from facturas, clientes where facturas.id_cliente=clientes.id_cliente and facturas.id_factura=$accion"; 
$rs=mysqli_query($con,$sql);
while($row= mysqli_fetch_array($rs)){
    $id_cliente=$row['id_cliente'];
    $razonsocial=$row['nombre_cliente'];
    $ruc=$row['doc'];
    $fecha=$row['fecha_factura'];
    $folio=$row['folio'];
    $numero_factura=$row['numero_factura'];
    $tipo_doc=$row['estado_factura'];
    $tienda=$row['tienda'];
}

$dia1=date("d",strtotime($fecha)); 
$mes1=date("m",strtotime($fecha));  
$ano1=date("Y",strtotime($fecha));
$dir_par="";
$PESO="";
$NUMERO_PAQUETES="";
$CODMOTIVO_TRASLADO="";
$MOTIVO_TRASLADO="";
$UBIGEO_PARTIDA="";
$UBIGEO_DESTINO="";
$NRO_DOCUMENTO_TRANSPORTE="";
$RAZON_SOCIAL_TRANSPORTE="";
$CODTIPO_TRANSPORTISTA="";
$aceptado1="";
$mensaje="";
$dom_lleg="";
$cont_lleg="";
$tel_lleg="";
$hor_lleg="";
$vehiculo="";
$inscripcion="";
$lic="";
$fecha1="";
$guia=0;
$sql6="select * from facturas, guia, clientes where facturas.id_factura=guia.id_doc and facturas.id_cliente=$id_cliente"; 
$rs6=mysqli_query($con,$sql6);
while($valor6= mysqli_fetch_array($rs6)){
    $dir_par=$valor6['dir_par'];
    $dom_lleg=$valor6['dom_lleg'];
    $cont_lleg=$valor6['cont_lleg'];
    $tel_lleg=$valor6['tel_lleg'];  
    $vehiculo=$valor6['vehiculo'];
    $inscripcion=$valor6['inscripcion'];
    $lic=$valor6['lic'];
}
$consulta1 = "SELECT * FROM guia ";
$result1 = mysqli_query($con, $consulta1);
$aa=0;
while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    if($valor1['id_doc']==$accion){
        $guia=$valor1['id'];
        $dir_par=$valor1['dir_par'];
        $PESO=$valor1['PESO'];
        $NUMERO_PAQUETES=$valor1['NUMERO_PAQUETES'];
        $CODMOTIVO_TRASLADO=$valor1['CODMOTIVO_TRASLADO'];
        $MOTIVO_TRASLADO=$valor1['MOTIVO_TRASLADO'];
        $UBIGEO_PARTIDA=$valor1['UBIGEO_PARTIDA'];
        $UBIGEO_DESTINO=$valor1['UBIGEO_DESTINO'];
        $NRO_DOCUMENTO_TRANSPORTE=$valor1['NRO_DOCUMENTO_TRANSPORTE'];
        $RAZON_SOCIAL_TRANSPORTE=$valor1['RAZON_SOCIAL_TRANSPORTE'];
        $CODTIPO_TRANSPORTISTA=$valor1['CODTIPO_TRANSPORTISTA'];
        $aceptado=$valor1['aceptado_guia'];
        $pos = strpos($aceptado, "aceptado");
        $aceptado1="";
        $mensaje="Enviar a Sunat";
        if ($pos==true) {
            $aceptado1="Disabled";
            $mensaje="La guia ha sido enviada a Sunat";
        }
        $dom_lleg=$valor1['dom_lleg'];
        $cont_lleg=$valor1['cont_lleg'];
        $tel_lleg=$valor1['tel_lleg'];
        $hor_lleg=$valor1['fecha_lleg'];
        $vehiculo=$valor1['vehiculo'];
        $inscripcion=$valor1['inscripcion'];
        $lic=$valor1['lic'];
        $fecha1=$valor1['fecha'];
        if($valor1['guia']>0){
            $guia1=$valor1['guia'];
        }
        $aa=1;
    }
}

$consulta4 = "SELECT * FROM datosempresa ";
$result4 = mysqli_query($con, $consulta4);
$dir_par="";
while ($valor4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)) {
      $dir_par=$valor4['dir_emp'];
}
$fecha3=$dia1."/".$mes1."/".$ano1;
if($aa==0 && $accion>0){
    $insert=mysqli_query($con,"INSERT INTO guia VALUES (NULL,'$accion','','$guia1','$dir_par','$dom_lleg','$cont_lleg','$tel_lleg','0000-00-00','$vehiculo','$inscripcion','$lic','0000-00-00','','','0','0','','','0','','','','','','')");
}
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[22]==0){
    header("location:error.php");    
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title> 
  
  Guia de remision:
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
    var mostrarValor = function(x){
        document.getElementById('precio').value=x;
    }
    var mostrarValor2 = function(x){
        document.getElementById('precio').value=x;
    }
  
</script>
<SCRIPT LANGUAGE="JavaScript" SRC="calendar.js"></SCRIPT>
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
#muestra{background:#FFFFFF;}
</style>
  

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
          
          
          <div style="background:<?php echo COLOR;?>;color:black;"> 
        <?php       
print"<form  name=\"myForm\" class=\"form-horizontal form-label-left\"   oninput=\"range_control_value.value = range_control.valueAsNumber\" action=\"guia1.php\" method=\"POST\">";

?>
       <div class="panel panel-info">
		<div class="panel-heading">
		   
                    <h2>Datos de la Guia de Remision:</h2>
               <font color="black">LLenar los campos</font> <font style="background-color:<?php echo COLOR1;?>;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
		</div>        
                        </div> 
                            <font color="red"><strong>RECEPCIONISTA/DOCUMENTO ASOCIADO:</strong></font>
                            <div class="form-group row">
                                
                                
				<div class="col-md-6 col-sm-6 col-xs-12">
                                    <label>Razon Social:</label>
                                    <input type="text" style="float: left;" autocomplete="off" class="form-control"  readonly value="<?php echo $razonsocial;?>">
                                </div>
                            
				
				<div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Ruc:</label>
                                    <input type="text" style="float: left;" class="form-control"  readonly value="<?php echo $ruc;?>">
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Fecha:</label>
                                    <input type="text" class="form-control"  readonly value="<?php echo $fecha3;?>">
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12">
                                    <label>Serie:</label>
                                    <input type="text" class="form-control" readonly id="folio" value="<?php echo $folio;?>">
                                   
                                
                                </div>
                                
				<div class="col-md-1 col-sm-1 col-xs-12">
                                    <label>Documento:</label>
                                    <input type="text" class="form-control" readonly id="doc" value="<?php echo $numero_factura;?>">
                                    <input type="hidden" name="id_guia" id="id_guia" value="<?php echo $accion;?>"> 
                                
                                </div>
                            </div>
                            <font color="red"><strong>DATOS DE LA GUIA:</strong></font>
                            <div class="form-group row">
				
				<div class="col-md-3 col-sm-3 col-xs-12">
                                    <label>Serie de Remision:</label>
                                    <input type="text" class="form-control" name="serie" id="serie" value="<?php echo $serie;?>" readonly>
                                </div>
                           
				
				<div class="col-md-3 col-sm-3 col-xs-12">
                                    <label>Nro de Guia :</label>
                                    <input type="text" class="form-control" name="guia" id="guia" value="<?php echo $guia1;?>" readonly>
                                </div>
                          
                                
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Fecha Inicio de Traslado:</label>
                                    <input placeholder="mm/dd/yyyy"  name="fecha"  style="background-color: #F5D0A9;" data-validate-length-range="4" type="date"  class="form-control" style="float: left;" id="fecha1"  aria-describedby="inputSuccess2Status3" value="<?php echo $fecha1;?>">
                              
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Motivo de Traslado:</label>
                                    
                                     <select class="form-control" id="motivo" name="motivo" required style="background-color: #F5D0A9;">
					<option value="">-- Selecciona Motivo de Traslado --</option>
                                        <?php
                                        if($CODMOTIVO_TRASLADO<>""){
                                         ?>
                                        <option value="<?php print"$CODMOTIVO_TRASLADO-$MOTIVO_TRASLADO";?>" selected><?php echo $MOTIVO_TRASLADO;?></option>
                                         <?php   
                                        }
                                        ?>
                                        
					
                                        <option value="01-VENTA">VENTA</option>
					<option value="14-VENTA SUJETA A CONFIRMACION DEL COMPRADOR">VENTA SUJETA A CONFIRMACION DEL COMPRADOR</option>
                                        <option value="02-COMPRA">COMPRA</option>
                                        <option value="04-TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA">TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA</option>
                                        <option value="18-TRASLADO EMISOR ITINERANTE CP">TRASLADO EMISOR ITINERANTE CP</option>
                                        <option value="08-IMPORTACION">IMPORTACION</option>
                                        <option value="09-EXPORTACION">EXPORTACION</option>
                                        <option value="19-TRASLADO A ZONA PRIMARIA">TRASLADO A ZONA PRIMARIA</option>
                                        <option value="13-OTROS">OTROS</option>
				  </select>
                              
                                </div>
                                
                            </div>
                            <font color="red"><strong>DATOS DE PARTIDA/PESO/PAQUETES:</strong></font>
                            <div class="form-group row">
				
				<div class="col-md-6 col-sm-6 col-xs-12">
                                    <label>Dirección de Partida:</label>
                                    <input type="text"  autocomplete="off" style="background-color: #F5D0A9;" class="form-control"  id="dir_par" name="dir_par" placeholder="Dirección de Partida" value="<?php echo $dir_par;?>">
				</div>
                                 <div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Ubigeo Partida:</label>
                                    <input type="text"  autocomplete="off" style="background-color: #F5D0A9;" class="form-control"  id="UBIGEO_PARTIDA" name="UBIGEO_PARTIDA" placeholder="Ubigeo Partida" value="<?php echo $UBIGEO_PARTIDA;?>">
				</div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Peso:</label>
                                    <input type="text" autocomplete="off" style="background-color: #F5D0A9;" class="form-control"  id="PESO" name="PESO" placeholder="Peso" value="<?php echo $PESO;?>">
				</div>
                                 <div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Nro de Paquetes:</label>
                                    <input type="text"  autocomplete="off" style="background-color: #F5D0A9;" class="form-control"  id="NUMERO_PAQUETES" name="NUMERO_PAQUETES" placeholder="Número de paquetes" value="<?php echo $NUMERO_PAQUETES;?>">
				</div>
                            </div>
                            <div class="form-group row">
				
				<div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Ruc Transporte:</label>
                                    <input type="text"  autocomplete="off" style="background-color: #F5D0A9;" class="form-control"  id="NRO_DOCUMENTO_TRANSPORTE" name="NRO_DOCUMENTO_TRANSPORTE" placeholder="Ruc Transporte" value="<?php echo $NRO_DOCUMENTO_TRANSPORTE;?>">
				</div>
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label>Razon Social de Transporte:</label>
                                    <input type="text"  autocomplete="off" style="background-color: #F5D0A9;" class="form-control"  id="RAZON_SOCIAL_TRANSPORTE" name="RAZON_SOCIAL_TRANSPORTE" placeholder="Razon Social de Transporte:" value="<?php echo $RAZON_SOCIAL_TRANSPORTE;?>">
				</div>
                                 <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Codigo Tipo Transporte:</label>
                                    
                                     <select style="background-color: #F5D0A9;" class="form-control" id="CODTIPO_TRANSPORTISTA" name="CODTIPO_TRANSPORTISTA" required>
					
                                         <option value="">-- Selecciona Codigo Tipo Transporte --</option>
                                        <?php
                                        if($CODTIPO_TRANSPORTISTA=='01'){
                                            print"<option value=01 selected>Transporte público</option>";
                                        }else{
                                            print"<option value=01 selected>Transporte público</option>";
                                        }
                                        if($CODTIPO_TRANSPORTISTA=='02'){
                                            print"<option value=02 selected>Transporte privado</option>";
                                        }else{
                                            print"<option value=02>Transporte privado</option>";
                                        }
					?>
                                        
				  </select>
                              
                                </div>
                                
                            </div>
                            <font color="red"><strong>DIRECCION DE DESTINO:</strong></font>
                            <div class="form-group row">
				
				<div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Punto de Llegada:</label>
                                    <input type="search" autocomplete="off" style="background-color: #F5D0A9;" class="form-control" id="dom_lleg" name="dom_lleg" placeholder="Domicilio de Destino" value="<?php echo $dom_lleg;?>">
                                </div>
				<div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Contacto de Destino:</label>
                                    <input type="search" autocomplete="off" style="background-color: #F5D0A9;" class="form-control" id="cont_lleg" name="cont_lleg" placeholder="Contacto de Destino" value="<?php echo $cont_lleg;?>">
				</div>
				<div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Teléfono de Destino:</label>
                                    <input type="text" autocomplete="off" style="background-color: #F5D0A9;" class="form-control" id="tel_lleg" name="tel_lleg" placeholder="Teléfono de Destino" value="<?php echo $tel_lleg;?>">
				</div> 
				
				<div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Ubigeo de Destino:</label>
                                    <input type="text"  style="background-color: #F5D0A9;" class="form-control" id="hor_lleg" name="UBIGEO_DESTINO" placeholder="Ubigeo destino" value="<?php echo $UBIGEO_DESTINO;?>">
				</div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <label>Horario de Llegada:</label>
                                    <input type="date"  style="background-color: #F5D0A9;" class="form-control" id="hor_lleg" name="hor_lleg" placeholder="Horario de Llegada" value="<?php echo $hor_lleg;?>">
				</div>
                            </div>
                            <font color="red"><strong>UNIDAD DE TRANSPORTE/CONDUCTOR:</strong></font>
                            <div class="form-group row">
				<div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Vehiculo Marca y Placa Nro:</label>
                                    <input type="text" style="background-color: #F5D0A9;" autocomplete="off" class="form-control" id="vehiculo" name="vehiculo" placeholder="Vehiculo Marca y Placa Nro" value="<?php echo $vehiculo;?>">
				</div>                  
				
				<div class="col-md-4 col-sm-4 col-xs-12"> 
                                    <label>Certificado de Inscripcion Nro:</label>
                                    <input type="text" style="background-color: #F5D0A9;" autocomplete="off" class="form-control" id="inscripcion" name="inscripcion" placeholder="Certificado de Inscripcion Nro" value="<?php echo $inscripcion;?>">
				</div>
				
				<div class="col-md-4 col-sm-4 col-xs-12">
                                    <label>Licencia de Conducir:</label>
                                    <input type="text" style="background-color: #F5D0A9;" autocomplete="off" class="form-control" id="lic" name="lic" placeholder="Licencia de Conducir" value="<?php echo $lic;?>">
				</div>
                            </div>
          <?php
          $fecha5="";
          if($fecha1<>""){
                $fecha4 = explode("-", $fecha1);
                $ano2=$fecha4[0]; // porción1
                $mes2=$fecha4[1];  // porción2
                $dia2=$fecha4[2]; 
                $fecha5=$dia2."/".$mes2."/".$ano2; 
          }
          $tienda=$_SESSION['tienda'];
          
          ?>
         
          <button type="submit" class="btn btn-primary" name="aceptar" <?php echo $aceptado1;?>>Editar</button>
           <a href="#" class='btn btn-primary' <?php echo $aceptado1;?> title='Enviar Sunat' onclick="enviar('<?php echo $accion;?>');"><i class="glyphicon glyphicon-download"></i><?php echo $mensaje;?></a>
          </form>
               
           
          </div>
          
          <a href="#" class='btn btn-info'  title='Abrir guia' onclick="imprimirguia('<?php echo $guia;?>');"><i class="glyphicon glyphicon-download"></i>Imprimir Guia</a>
          <a href="#" class='btn btn-warning'  title='Abrir guia' onclick="imprimirfactura('<?php echo $accion;?>');"><i class="glyphicon glyphicon-download"></i>Imprimir Doc</a>
          
 
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

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>


  <!-- Datatables -->
  <script src="js/datatables/js/jquery.dataTables.js"></script>
  <script src="js/datatables/tools/js/dataTables.tableTools.js"></script>
<script type="text/javascript" src="js/facturas.js"></script>
  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
  <!-- pace -->
 <script>



     function enviar(id){
			VentanaCentrada('./pdf/documentos/envio_data_guia_remision.php?accion='+id,'Factura','','1024','768','true');
      location.reload(true);                  
     }
     function imprimirguia(id){
			VentanaCentrada('./pdf/documentos/ver_guia.php?id_guia='+id,'Factura','','1024','768','true');
		}
     function imprimirfactura(id){
			VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id,'Factura','','1024','768','true');
		}           
  </script>
  
	
	
  
</body>

</html>
<?php
ob_end_flush(); 
?>