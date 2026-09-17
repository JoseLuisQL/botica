<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$disabled1="";
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
$id=recoge1('a');
$sql2="select * from $db_clientes where id_cliente=$id";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$nombre=$rs2["nombre_cliente"];
$deuda1=$rs2["deuda"];
$modulo=$rs1["accesos"];
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[26]==0){
    header("location:error.php");    
}

$caja=0;
$cierre=0;
$tienda1=$_SESSION['tienda'];
$user_id=$_SESSION['user_id'];
$sql3="select * from caja where tienda=$tienda1 and usuario_inicio=$user_id ORDER BY caja.id_caja DESC LIMIT 0 , 1";
$rw3=mysqli_query($con,$sql3);//recuperando el registro
$rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
$caja=$rs3["usuario_inicio"];
$cierre=$rs3["cierre"];

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

  <title> 
  
  Cobros
  </title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>
 
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

.thumb {
            height: 250px;
            width:190px;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
          }
.textfield10:hover {
                    border:3px solid black; 
}
.textfield10:focus {border:3px solid black;
                    -moz-box-shadow:inset 0 0 5px #FAFAFA;
-webkit-box-shadow:inset 0 0 5px #FAFAFA;
box-shadow:inset 0 0 5px #FAFAFA;
                  background-color:#FAFAFA;  
                  color:black;
}
.textfield10{display: block;  float:left;  background-color:white; width:600px;color:#0489B1;
          padding-left: 5px;
          padding-top: 4px; margin:1.5px;	border: 3px solid #BDBDBD;
}

</style>
 
   <script> 
      

</script> 
<script>
function sumar() {

  var total = 0;

  $(".monto").each(function() {

    if (isNaN(parseFloat($(this).val()))) {

      total += 0;

    } else {

      total += parseFloat($(this).val());

    }

  });

  //alert(total);
  document.getElementById('spTotal').value = total;

}

	</script>
 



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
   	  <div class="modal-header" style="background: #58FAAC;">
			
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> <font color="black">Realizar Cobros</font></h4>
		    <font color="black">LLenar los campos Obligatorios</font> <font style="background-color:#F5D0A9;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
           
                  </div>
          
		  <div class="modal-body" style="background: white;">
                      <form style="color:black;" class="form-horizontal" method="post" action="cobro2.php" id="nuevo_pagos" name="nuevo_pagos">
			<div id="resultados_ajax2"></div>
			  
                        <div class="form-group">
				<label for="mod_mon" class="col-sm-3 control-label">Cliente</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_cliente" value="<?php echo $nombre;?>" name="mod_cliente" readonly>
                                  <input type="hidden" id="mod_id" name="mod_id" value="<?php echo $id;?>">	
                                        
				</div>
			  </div>
                        <div class="form-group">
				<label for="mod_deuda" class="col-sm-3 control-label">Deuda Total <?php echo moneda;?></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" value="<?php echo $deuda1;?>" id="mod_deuda" name="mod_deuda" readonly>
					
				</div>
			  </div>
                         <div class="form-group">
                             <font color="red" class="col-sm-3 control-label"><strong>Nro de documento</strong></font>
                          <div class="col-md-3 col-sm-3 col-xs-2">
                             <font color="red"  align="right"><strong>Deuda Documento <?php echo moneda;?></strong></font>
				</div>
                              <div class="col-md-3 col-sm-3 col-xs-2">
                             <font color="red"  align="right"><strong>Fecha Documento.</strong></font>
				</div>
                             <div class="col-md-3 col-sm-3 col-xs-2">
                             <font color="red"  align="right"><strong>Días Crédito.</strong></font>
				</div>
                             
			 </div>	
                        
                        
				
				  <?php
                        
                        
                        
         $total1=0;              
    $sql2="select * from facturas where id_cliente=$id and activo=1 and ven_com=1 and moneda=1";
    $i=0;
$rs1=mysqli_query($con,$sql2);
$suma=0;

while($row3=mysqli_fetch_array($rs1)){
    
 $id_factura=$row3["id_factura"];   
$cuenta1=$row3["cuenta1"];
$deuda=$row3["deuda_total"];
$numero=$row3["numero_factura"];
$folio=$row3["folio"];
$num1=$folio."-".$numero;
$estado=$row3["estado_factura"];
if($estado==1){
    $doc="Factura";
}
if($estado==2){
    $doc="Boleta";
}
if($estado==3){
   $doc=doc; 
}
$total=$row3["total_venta"];
$t=$deuda-$cuenta1;
$dias=$row3["dias"];
$fecha=date("d/m/Y", strtotime($row3['fecha_factura']));

if($t>0){
$i=$i+1;
$suma=$suma+$t;
$total1=$total1+$t;
    ?>
<div class="form-group">
                        <label for="mod_deuda" class="col-sm-3 control-label"><?php echo $doc;?> <?php echo $num1;?></label>
				<div class="col-md-3 col-sm-3 col-xs-12">
 <input type="number"  class="monto"  onkeyup="sumar();" autocomplete="off" style="background-color: white;width:170px;text-align:right;"
        value="<?php echo number_format($t, 2, '.', '');?>"  id="deuda<?php echo $i;?>" name="deuda<?php echo $i;?>" readonly>
 <input type="hidden" id="id<?php echo $i;?>" name="id<?php echo $i;?>" value="<?php echo $id_factura;?>">				
</div>
  <div class="col-md-3 col-sm-3 col-xs-12">
      <strong><?php echo $fecha;?></strong> 
  </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
      <strong><?php echo $dias;?> días</strong> 
  </div>                    
                        
                        </div>
<?php


}
}
                        
                        ?>
                        <input type="hidden" id="cantidad" name="cantidad" value="<?php echo $i+1;?>">
                        <div class="form-group">
                            <label for="mod_deuda" class="col-sm-3 control-label">Deudas Anteriores </label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="number" class="monto" style="background-color: white;width:170px;text-align:right;"  onkeyup="sumar();" value="<?php echo number_format($deuda1-$suma, 2, '.', '');?>" id="deuda<?php echo $i+1;?>" name="deuda<?php echo $i+1;?>" readonly>
                                    <input type="hidden" id="id<?php echo $i+1;?>" name="id<?php echo $i+1;?>" value="0">
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="mod_deuda" class="col-sm-3 control-label"><font color="red">Total a pagar </font></label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="number"   style="background-color: #F5D0A9;width:170px;text-align:right;" step="0.1" min="0" autocomplete="off" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '<?php echo $deuda1;?>';}" max="<?php echo $deuda1;?>" value="<?php echo $deuda1;?>" id="spTotal" name="spTotal" required>
				
                                </div>	
                        </div>			 
                        <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Nro Documento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" autocomplete="off" style="background-color: #F5D0A9;" class="form-control" id="numero_factura" name="numero_factura" placeholder="Nro del documento" required>
				</div>
			</div>
                        
                        <div class="form-group">
				<label for="vendedor" class="col-sm-3 control-label">Tipo de comprobante</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" style="background-color: #F5D0A9;" id="estado_factura" name="estado_factura" required>
					<option value="">-- Selecciona Tipo de Comprobante --</option>
		
                        <?php
                 
    $sql2="select * from comprobante_pago ";
    $i=0;
$rs1=mysqli_query($con,$sql2);
while($row3=mysqli_fetch_array($rs1)){
    
    
$nom_cat=$row3["des_comprobante"];
$id_categoria=$row3["id_comprobante"];
?>

<option value="<?php  echo $id_categoria;?>"><?php  echo $nom_cat;?></option>

<?php

$i=$i+1;
}
                        
                        ?>
                     
                         </select>
				</div>
			  </div>
                        <div class="form-group">
                                                            <label for="mod_deuda" class="col-sm-3 control-label">Pago en</label>
                                                           <div class="col-md-8 col-sm-8 col-xs-12">
                                                            
								<select style="background-color: #F5D0A9;" class='form-control input-sm' id="condiciones" name="condiciones" required>
									<option value="1">Efectivo</option>
									<option value="2">Cheque</option>
									<option value="3">Transferencia bancaria</option>
									<option value="4">Deposito</option>
								</select>
							</div>
                                                            </div>
                        
                        
                        
                        
                        
                        
			    <div class="form-group">
				<label for="mod_obs" class="col-sm-3 control-label">Nro de Operacion</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <textarea  rows="4" class="form-control" id="mod_obs" name="mod_obs"></textarea>
					
				</div>
			  </div> 
			 
			<div class="modal-footer">
			<?php
                        if($deuda1>0){
                            ?>
                            <button type="submit" class="btn btn-primary" id="actualizar_datos">Enviar</button>
                            <?php
                        }
                            ?>
			
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

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>


  <!-- Datatables -->
  <script src="js/datatables/js/jquery.dataTables.js"></script>
  <script src="js/datatables/tools/js/dataTables.tableTools.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script>
    $(document).ready(function() {
      $('input.tableflat').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
      });
    });

    var asInitVals = new Array();
    $(document).ready(function() {
      var oTable = $('#example').dataTable({
        "oLanguage": {
          "sSearch": "Search all columns:"
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
          } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
          "sSwfPath": "js/datatables/tools/swf/copy_csv_xls_pdf.swf"
        }
      });
      $("tfoot input").keyup(function() {
        /* Filter on the column based on the index of this element's parent <th> */
        oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
      });
      $("tfoot input").each(function(i) {
        asInitVals[i] = this.value;
      });
      $("tfoot input").focus(function() {
        if (this.className == "search_init") {
          this.className = "";
          this.value = "";
        }
      });
      $("tfoot input").blur(function(i) {
        if (this.value == "") {
          this.className = "search_init";
          this.value = asInitVals[$("tfoot input").index(this)];
        }
      });
    });
  </script>
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
    $(function() {
      'use strict';
      
      var data =[
      <?php
                    for($i = 0;$i<count($producto);$i++){
                ?>
                '<?php echo $producto[$i];?>',
                <?php } ?>];
     
      
      
      var countriesArray = $.map(data, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  
  <script src="js/select/select2.full.js"></script>
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
  
  
  
</body>

</html>
<?php
ob_end_flush();
?>



