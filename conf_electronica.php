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
$tienda=$_SESSION['tienda'];
$sql2="select * from sucursal where tienda=$tienda";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$ruc=$rs2["ruc"];

$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[30]==0){
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

  <title> 
  
  COnfiguración Facturación Electrónica
  </title>

 <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>
 <script>
  function limpiarFormulario() {
    document.getElementById("guardar_producto").reset();
    
  }
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
  
<?php
$sql1="SELECT * FROM datosempresa WHERE id_emp=1";
$rw1=mysqli_query($con,$sql1);
while ($valor1 = mysqli_fetch_array($rw1)) {

    $nom_emp=$valor1['nom_emp'];
    $des_emp=$valor1['des_emp'];
    $mis_emp=$valor1['mis_emp'];
    $vis_emp=$valor1['vis_emp'];
    $dir_emp=$valor1['dir_emp'];
    $tel_emp=$valor1['tel_emp'];
    $email_emp=$valor1['email_emp'];
    $face_emp=$valor1['face_emp'];
    $tiwter_emp=$valor1['tiwter_emp'];
    $youtube_emp=$valor1['youtube_emp'];
    $linkedin_emp=$valor1['linkedin_emp'];
    $comentario1=$valor1['comentario1'];
    $comentario2=$valor1['comentario2'];
    $comentario3=$valor1['comentario3'];
    $comentario4=$valor1['comentario4'];
    $comentario5=$valor1['comentario5'];
    $fac_ele=$valor1['fac_ele'];
    $usuariosol=$valor1['usuariosol'];
    $clavesol=$valor1['clavesol'];
    $clave=$valor1['clave'];
}
?>
          
          <div style="background:<?php echo COLOR;?>;color:black;">
<?php
print"<form class=\"form-horizontal form-label-left\" id=\"guardar_producto\" enctype=\"multipart/form-data\" action=\"conf_electronica1.php\" method=\"POST\">";

?>

                          <div class="panel panel-info">
                            <div class="panel-heading">
		   
                                <h2>Facturación Electrónica:</h2>
                                
                            </div>        
                        </div>
                         <div class="panel panel-info">
                            <div class="panel-heading">
		   
                                <font color=black>Tipo de Fase:</font>
                                
                            </div>        
                        </div>
                        <div class="form-group">
				<label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Facturación Electronica</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
                                    <select   class='form-control' id="fac_ele" name="fac_ele">
                                                                   <?php         
                                                                   if ($fac_ele==3) {
                                                                     ?>
                                                                    
                                                                    <option value="3" selected>Beta</option>
                                                                    <option value="1" >Produccion</option>
                                                                     <?php
                                                                   }         
                                                                   if ($fac_ele==1) {
                                                                     ?>
                                                                    <option value="1" selected>Produccion</option>
                                                                    <option value="3">Beta</option>
                                                                    <?php
                                                                   }         
                                                                            
                                                                    ?>
									
									
								</select> 
				</div>
			  </div>  
                          <div class="panel panel-info">
                            <div class="panel-heading">
		   
                                <font color=black>Datos para producción:</font>
                                
                            </div>        
                        </div>
                           <div class="form-group">
				<label for="youtube_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Usuario Sol</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
                                    <input   type="text"  class="form-control" id="usuariosol" name="usuariosol" placeholder="usuariosol" value="<?php echo $usuariosol;?>">
				</div>
			  </div> 
          
                            <div class="form-group">
				<label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Clave Sol</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
                                    <input  type="text"  class="form-control" id="clavesol" name="clavesol" placeholder="clavesol" value="<?php echo $clavesol;?>">
				</div>
			  </div>
              
                                <input type="hidden" id="ruc" class="form-control"  name="ruc"  value="<?php echo $ruc;?>">
                           <div class="form-group">
                                
                            
				<label for="nombre" class="col-sm-3 control-label">Ingresar certificado digital (.pfx):</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<input   accept="image/jpeg" type="file" id="files" name="files" class="form-control"/>
				  
				</div>
			  </div>  
                          <div class="form-group">
				<label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Password Certificado Digital</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
                                    <input   type="text" id="valor1" class="form-control" id="clave" name="clave" placeholder="Password Certificado Digital" value="<?php echo $clave;?>">
				</div>
			  </div>
              
              
                        
              
                        
                    <div class="modal-footer">
                    
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  
                    </div>
            </div>
    
		  </form>
          
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



