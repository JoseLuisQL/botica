<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$sql2="select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$tienda1=$rs2["tienda"];
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[16]==0){
    header("location:error.php");    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
    
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title> 
  
  Productos mas vendidos.
  </title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
-->
<link rel="stylesheet" type="text/css" href="DataTables/DataTables/css/dataTables.bootstrap.min.css"/>
<script type="text/javascript" src="Buttons/js/jszip.min.js"></script>
<!--<script type="text/javascript" src="Buttons/js/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="Buttons/css/buttons.dataTables.min.css"/>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="Buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.print.min.js"></script>
  
<style>
    table tr:nth-child(odd) {background-color: #FBF8EF;}

table tr:nth-child(even) {background-color: #EFFBF5;}
 

.dt-button.red {
        color: black;
        
        background:red;
    }
 
    .dt-button.orange {
        color: black;
        background:orange;
    }
 
    .dt-button.green {
        color: black;
        background:green;
    }
    
    .dt-button.green1 {
        color: black;
        background:#01DFA5;
    }
    
    .dt-button.green2 {
        color: black;
        background:#2E9AFE;
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

$consulta2 = "SELECT * FROM consultas ";
$result2 = mysqli_query($con, $consulta2);
$d=0;
$cliente="";
$fecha1="";
$fecha2="";
$tienda=0;
$tipo="";
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
    
     if ($valor1['tipo']==21){
          $d=$valor1['id'];
         $tipo=$valor1['a1'];
          //$nom_pro=trim($nom_pro1);
          $fecha1=$valor1['a2'];
          
          $fecha2=$valor1['a3'];
          $tienda=$valor1['a4'];
          
          //mm/dd/yyyy
         
      
     }
    
}
 
            ?>
             <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                       <div class="x_panel" style="background:<?php echo COLOR;?>">
           
                           <form style="color:black;"  name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="GET" action="masvendidos1.php">
                      
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                       
                                        <h4>Productos mas vendidos:</h4>
                                    </div>        
                                </div>
                      
                     
                         <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha Inicial:</label>
                            <input  name="fecha1"  data-validate-length-range="4" type="date"  class="form-control" style="float: left;" id="fecha1"   value="<?php echo $fecha1;?>" required>
                              
                            
                          </div>
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha Final:</label>
                            <input  name="fecha2"  data-validate-length-range="4" type="date"  class="form-control" style="float: left;" id="fecha2"   value="<?php echo $fecha2;?>" required>
                              
                            
                          </div>
                     
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Sucursal:</label>
                           <select class="textfield11" class="form-control" name="tienda" required="required" tabindex="-1" required>
                            <?php
                            if($tienda>0){
                                
                                if($tienda==7){
                                    $t="Todas";
                                }else{
                                    $t="Sucursal $tienda";
                                }
                                
                                ?>
                               <option value="<?php echo $tienda; ?>" ><?php echo $t; ?></option>
                            <?php
                               }else{
                                  ?>
                               <option value="" >Escoger</option>
                                <?php  
                               }
                             for($i=1 ;$i<=$tienda1;$i++){
                                ?>
                                <option value="<?php echo $i;?>" >Sucursal <?php echo $i;?></option>              
                               <?php
        
                              }
                            ?>
                            
                            
                                                                                        
                        </select>
                       
                      </div>
          
                      <input type="hidden" name="d" value="1">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <button id="send" type="submit" name="enviar" class="btn btn-success">Buscar</button>
                      </div>
                    </form>
                  
          
                   </div>
                   </div>
               </div>
      
          <div class="row">

                
              <?php
                       

$cont=0;
$total11=0;
$total22=0;
if($d==0){
//$sql="select * from products ORDER BY  `products`.`id_producto` DESC LIMIT 0 , 100";
    $sql="";
}else{
 
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$aa="http://".$host.$url;

?>
      
  <div class="table-responsive">
                   
                  <table border="1" id="example" class="display nowrap" style="width:100%;color:black;">
                    <thead>
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                        <th>Producto </th>
                        <th>Codigo </th>
                        <th>Cantidad</th>
                        <th>Total <?php echo moneda;?></th>
                      
                      </tr>
                    </thead>

                    <tbody>  
 <?php   
  
  
 
$a1=array();
$a2=array();
$suma1=0;
$j=0;
$text="";
$text=$text." SUM(IF(DATE_FORMAT(fecha, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(fecha, '%Y-%m-%d')<='$fecha2' and tipo_doc<=3 and ven_com=1 and activo=1 and detalle_factura.tienda=$tienda,cantidad*precio_venta,0)) AS 'suma',";  
$text=$text." SUM(IF(DATE_FORMAT(fecha, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(fecha, '%Y-%m-%d')<='$fecha2' and tipo_doc<=3 and ven_com=1 and activo=1 and detalle_factura.tienda=$tienda,cantidad,0)) AS 'cant'";
$sql="SELECT nombre_producto,codigo_producto, $text FROM products, detalle_factura WHERE products.id_producto=detalle_factura.id_producto GROUP BY nombre_producto";
//print"$sql";
$rs=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($rs)){
    $suma=$row['suma'];
    $a1[$j]=$suma;
    $d=$row['nombre_producto'];
    $a2[$j]=utf8_decode($d);
    $codigo=$row['codigo_producto'];
    $cant=$row['cant'];
    $suma1=$suma1+$suma;
    if($suma>0){
   
        ?>
                      
        <tr id="valor1">
            <td class=" "><font color="black"><strong><?php echo $d;?></strong></font></td>
            <td class=" "><font color="black"><strong><?php echo $codigo;?></strong></font></td>
            
            <td align="right"><font color="blue"><strong><?php echo number_format($cant, 2, ".", ""); ?></strong></font></td>
            <td align="right"><font color="blue"><strong><?php echo number_format($suma, 2, ".", "");?></strong></font></td>
        </tr>                
    <?php
    $j=$j+1;
    }
}

for($i = 0;$i<count($a1);$i++){
    for($j = 0;$j<count($a1);$j++){
        If ($a1[$i] >= $a1[$j]) {
            $b1 = $a1[$j];
            $b2 = $a2[$j];
            $a1[$j] = $a1[$i];
            $a2[$j] = $a2[$i];
            $a1[$i] = $b1;
            $a2[$i] = $b2;
        }
    }  
}
?>
                  </tbody>
                    <?php 
                    
                    if($_SESSION['tabla']>0)        {
                        
                    
                    ?>
                    <tr><td colspan="2"></td><td class='text-right'><h2 style="color:blue;">Total Ventas :</h2></td><td class='text-right'><h2 style="color:red;"><?php echo moneda;?><?php echo number_format ($suma1,2);?></h2></td></tr>
                  <?php
                  }
                  ?>
                    </table>
                     </form>
                </div>
             
            <?php

    }
?>
             
            </div>
          
          <div class="row">
            
              <?php
                  if(isset($a1) && count($a1)>0){
                     
                      ?>
                
                  <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  
                    <h2><font color="#FF4000"><strong>Grafica de barras productos mas vendidos.</strong></font> </h2>
                    
                    
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content1">
                  <div id="graph_bar_group" style="width:100%; height:280px;"></div>
                </div>
              </div>
            </div>

                  
<?php
                  }
                    ?>
        
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

  <script src="js/pace/pace.min.js"></script>
  
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
  <script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>


<script>
     $(function () {

    /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
    var day_data = [
        
        <?php
                    for($i = 0;$i<count($a1);$i++){
                ?>
                {"period": "<?php print"$a2[$i]";?>", "Venta": <?php print"$a1[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group',
        data: day_data,
        xkey: 'period',
        barColors: ['#00FF40', '#DF0101', '#ACADAC', '#3498DB'],
        ykeys: ['Venta'],
        labels: ['Venta'],
        hideHover: 'auto',
        xLabelAngle: 20
    });


});

  </script>
  
  <script src="js/moris/raphael-min.js"></script>
  <script src="js/moris/morris.min.js"></script>
  
<script>
 
$(document).ready(function() {
    $('#example').DataTable( {
        language: {
        "url": "/dataTables/i18n/de_de.lang",
                "decimal": "",
        "show": "Mostrar",
        "emptyTable": "No hay informacion",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        buttons: {
                copyTitle: 'Copiar filas al portapapeles',
                
                copySuccess: {
                    _: 'Copiado %d fias ',
                    1: 'Copiado 1 fila'
                },
                
                pageLength: {
                _: "Mostrar %d filas",
                '-1': "Mostrar Todo"
            }
            },
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
        
        
        
        
    },
         bDestroy: true,
            dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: 
        
        
        [
                
                {
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange'
                },
                
                {
                    extend: 'copy',
                    text: 'COPIAR',
                    className: 'red'
                },
                
                
                
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    className: 'green'
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'green1'
                },
                {
                    extend: 'print',
                    text: 'IMPRIMIR',
                    className: 'green2'
                }
            ],
        
        
    } );
} );
</script>
</body>
</html>
<?php
ob_end_flush(); 
?>




