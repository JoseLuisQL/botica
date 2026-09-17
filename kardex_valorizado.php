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
$sql2="select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$tienda1=$rs2["tienda"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[50]==0){
    header("location:error.php");    
}
$a1=recoge1('fecha1');
$a2=recoge1('fecha2');
if($a1==2 && isset($a1)){
    $a2="Anual";
}
$a3=recoge1('tienda');
$a4="";
$a5="";
$a6="";
$delete=mysqli_query($con,"DELETE FROM consultas");
$insert=mysqli_query($con,"INSERT INTO consultas VALUES (NULL,'71','$a1','$a2','$a3','$a4','$a5','$a6')");          
date_default_timezone_set('America/Lima');
$anio1=date("Y");        
        
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title> 
  Kardex valorizado
  
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

<script type="text/javascript">
var mostrarValor = function(x){
      var x;
      var y="Anual";

      
     if(x>1) {
        document.getElementById('anio').value=y;
        document.getElementById("anio").disabled = true;
     }
     
     if(x==1) {
        document.getElementById('anio').value=<?php echo $anio1;?>;
        document.getElementById("anio").disabled = false;
     }
     
};  

</script>

        <![endif]-->
<style>
    table tr:nth-child(odd) {background-color: #FBF8EF;}

table tr:nth-child(even) {background-color: #EFFBF5;}
 #valor1 {
              

border-bottom: 2px solid #F5ECCE;

}  

#valor1:hover {
              
background-color: white;
border-bottom: 2px solid #A9E2F3;

} 

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
$tienda=0;$dd1="";
$dd2="";
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {

     if ($valor1['tipo']==71){
        $fecha1=$valor1['a1'];
        $fecha2=$valor1['a2'];
        $tienda=$valor1['a3'];
    
  
     }
    
}
          
            ?>
          
               <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                       <div class="x_panel" style="background:<?php echo COLOR;?>;color:black;">
                           <form  name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="kardex_valorizado.php">
                      
                          <div class="panel panel-info">
                                <div class="panel-heading">
		   
                            <h2>Kardex valorizado de productos:</h2>
                            </div>        
                        </div> 
                     
                     
                         <div class="col-md-4 col-sm-4 col-xs-12">
                           
                             <label>Fecha1:</label>
                               <input  class="form-control" value="<?php echo $fecha1; ?>" id="fecha1" name="fecha1" type="date" required="required" >
                          </div>
                            
                        
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                            
                           <label>Fecha2:</label>
                               <input  class="form-control" value="<?php echo $fecha2; ?>" id="fecha2" name="fecha2" type="date" required="required" >
                          </div>
                     
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Sucursal:</label>
                           <select  class="form-control" name="tienda" required="required" tabindex="-1">
                            <?php
                            if($tienda>0){
                                
                                if($tiend==7){
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
        
   <div class="table-responsive">
                   
                 
 <?php   
 
 
   
         $text=" SUM(IF(DATE_FORMAT(fecha, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(fecha, '%Y-%m-%d')<='$fecha2' and products.id_producto=detalle_factura.id_producto and ot=1 and activo=1 and numero_factura>0 and detalle_factura.tienda=$tienda,precio_venta,0)) AS 'dato1',";
         $text1=" SUM(IF(DATE_FORMAT(fecha, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(fecha, '%Y-%m-%d')<='$fecha2' and products.id_producto=detalle_factura.id_producto and ot=2 and activo=1 and numero_factura>0 and detalle_factura.tienda=$tienda,precio_venta,0)) AS 'dato2',";
         
          $text2=" SUM(IF(DATE_FORMAT(fecha, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(fecha, '%Y-%m-%d')<='$fecha2' and products.id_producto=detalle_factura.id_producto and ot=1 and activo=1 and detalle_factura.tienda=$tienda,cantidad,0)) AS 'dato3',";
         $text3=" SUM(IF(DATE_FORMAT(fecha, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(fecha, '%Y-%m-%d')<='$fecha2' and products.id_producto=detalle_factura.id_producto and ot=2 and activo=1 and detalle_factura.tienda=$tienda,cantidad,0)) AS 'dato4'";
    
 
 if($tienda>0){
 ?>
        <div class="table-responsive">
			  <table id="example" class="display nowrap" style="width:100%">
                    <thead>
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                       <th>Producto </th>
                      
                       <th style="background-color:#01A9DB;">Cantidad<br>Entrada </th>
                       <th style="background-color:#01A9DB;">Costo <br>Entrada</th>
                       <th style="background-color:#01A9DB;">Total <br>Entrada</th>
                       <th style="background-color:red;">Cantidad<br>Salida </th>
                       <th style="background-color:red;">Costo<br>Salida </th>
                       <th style="background-color:red;">Total<br>Salida </th>
                       <th style="background-color:green;">Cantidad<br>Saldo </th>
                       <th style="background-color:green;">Costo<br>Saldo </th>
                       <th style="background-color:green;">Total<br>Saldo </th>
                    </tr>
                    </thead>

                    <tbody>  
       
       <?php
       
 
    $sql="SELECT nombre_producto,$text $text1 $text2 $text3 FROM products, detalle_factura GROUP BY nombre_producto";

   //echo $sql;
$rs=mysqli_query($con,$sql);

while($row=mysqli_fetch_array($rs)){
    
    $d=$row['nombre_producto'];
    $dato1=$row['dato1'];
    $dato2=$row['dato2'];
   $dato3=$row['dato3'];
   $dato4=$row['dato4'];
    if(-$dato2*$dato4+$dato1*$dato3<>0){
        ?>
                      
        <tr id="valor1">
                        <?php 
                        
                       
                          ?>  
                        
                        <td class=" "><font color="black"><strong><?php echo $d;?></strong></font></td>
                         <td align="right"><font color="black"><strong><?php echo number_format($dato4, 2, '.', '');?></strong></font></td>
                       <td align="right"><font color="black"><strong><?php echo number_format($dato2, 2, '.', '');?></strong></font></td>
                       <td align="right"><font color="black"><strong><?php echo number_format($dato2*$dato4, 2, '.', '');?></strong></font></td>
                        <td align="right"><font color="black"><strong><?php echo number_format($dato3, 2, '.', '');?></strong></font></td>
                       <td align="right"><font color="black"><strong><?php echo number_format($dato1, 2, '.', '');?></strong></font></td>
                       <td align="right"><font color="black"><strong><?php echo number_format($dato1*$dato3, 2, '.', '');?></strong></font></td>
                       
                      
                        <td align="right"><font color="black"><strong><?php echo number_format(-$dato4+$dato3, 2, '.', '');?></strong></font></td>
                       <td align="right"><font color="black"><strong><?php echo number_format(-$dato2+$dato1, 2, '.', '');?></strong></font></td>
                       <td align="right"><font color="black"><strong><?php echo number_format(-$dato2*$dato4+$dato1*$dato3, 2, '.', '');?></strong></font></td>
           
                      </tr>                
    <?php
    }
}
}
                      
                        ?>
         
                     
                    </tbody>

                   
                  </table>
        </div>
                     
                </div>
      
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
 
  
  
<script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>
 
 
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
        
        "pageLength": 50,
    } );
} );



</script>



</body>

</html>
<?php
ob_end_flush(); 
?>



