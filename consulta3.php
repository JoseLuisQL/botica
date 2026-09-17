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
if($a[36]==0){
   header("location:error.php");    
} 
$a1=recoge1('tipo');
$a2=recoge1('anio');
if($a1==2 && isset($a1)){
    $a2="Anual";
}
$a3=recoge1('tienda');
$a4="";
$a5="";
$a6="";
$delete=mysqli_query($con,"DELETE FROM consultas");
$insert=mysqli_query($con,"INSERT INTO consultas VALUES (NULL,'33','$a1','$a2','$a3','$a4','$a5','$a6')");         
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
  Tendencia de compras por proveedores mensual/anual
  
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

$tipo=0;
$anio="";
$tienda=0;
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
    
     if ($valor1['tipo']==33){
         
         $tipo=$valor1['a1'];
          //$nom_pro=trim($nom_pro1);
          $anio=$valor1['a2'];
          $tienda=$valor1['a3'];
       
     }
    
}
       ?>
             <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                       <div class="x_panel" style="background:<?php echo COLOR;?>;">
                        <form style="color:black;" name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="consulta3.php">
                      
                          <div class="panel panel-info">
                            <div class="panel-heading">
                                
                                <h2>Tendencia de compras por proveedores mensual/anual:</h2>
                            </div>        
                        </div> 
                     
                     
                         <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Tipo:</label>
                               <select  class="form-control" id="tipo" name="tipo" onchange="mostrarValor(this.value);" required="required" tabindex="-1">
                           <?php
                           
                           
                            if($tipo==1){
                                
                                ?>
                                <option selected value="1" >Mensual</option>
                             <?php
                                }else{
                                   ?>
                                <option value="1" >Mensual</option>
                             <?php  
                                    
                                }
                               ?>    
                                   
                                  
                            <?php
                            if($tipo==2){
                                
                                ?>
                                <option selected value="2" >Anual</option>
                             <?php
                                }else{
                                   ?>
                                <option value="2" >Anual</option>
                             <?php  
                                    
                                }
                               ?>  
                               </select>
                            
                          </div>
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                            <?php
                            $anio1="";
                            if($anio<>""){
                                
                                $anio1=$anio;
                            }
                            ?>
                           <label>A&ntilde;o:</label>
                               <input  class="form-control" value="<?php echo $anio1; ?>" id="anio" name="anio" type="text" required="required" >
                          </div>
                     
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Sucursal:</label>
                           <select class="form-control" name="tienda" required="required" tabindex="-1">
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
<?php 
    if($tipo==1){        
   ?>           
   <div class="table-responsive">
                   
                  <table id="example" class="display nowrap" style="width:100%;color:black;">
                    <thead>
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                       <th>Proveedor </th>
                       <th>Total </th>
                        <th>Enero </th>
                       <th>Febrero </th>
                      <th>Marzo </th>
                      <th>Abril </th>
                      <th>Mayo </th>
                      <th>Junio </th>
                      <th>Julio </th>
                      <th>Agosto </th>
                      <th>Septiembre </th>
                      <th>Octubre </th>
                      <th>Noviembre </th>
                      <th>Diciembre </th>
                      
                      
                      </tr>
                    </thead>

                    <tbody>  
 <?php   

 
$sql="SELECT nombre_cliente,
SUM(IF(MONTH(fecha_factura)=1 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes1,
SUM(IF(MONTH(fecha_factura)=2 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes2,
SUM(IF(MONTH(fecha_factura)=3 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes3,
SUM(IF(MONTH(fecha_factura)=4 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes4,
SUM(IF(MONTH(fecha_factura)=5 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes5,
SUM(IF(MONTH(fecha_factura)=6 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes6,
SUM(IF(MONTH(fecha_factura)=7 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes7,
SUM(IF(MONTH(fecha_factura)=8 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes8,
SUM(IF(MONTH(fecha_factura)=9 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes9,
SUM(IF(MONTH(fecha_factura)=10 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes10,
SUM(IF(MONTH(fecha_factura)=11 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes11,
SUM(IF(MONTH(fecha_factura)=12 and YEAR(fecha_factura)=$anio and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes12
FROM clientes, facturas WHERE clientes.id_cliente=facturas.id_cliente GROUP BY nombre_cliente
";

$rs=mysqli_query($con,$sql);

while($row=mysqli_fetch_array($rs)){
    $d=$row['nombre_cliente'];
  $suma=$row['mes1']+$row['mes2']+$row['mes3']+$row['mes4']+$row['mes5']+$row['mes6']+$row['mes7']+$row['mes8']+$row['mes9']+$row['mes10']+$row['mes11']+$row['mes12'];
        
    if($suma>0)
    {
        ?>
                      
        <tr id="valor1">
                        
                        <td class=" "><font color="black"><strong><?php echo $d;?></strong></font></td>
                       <td align="right"><font color="blue"><strong><?php echo $suma;?></strong></font></td>
               
                       <td align="right"><?php echo $row['mes1'];?></td>
                       <td align="right"><?php echo $row['mes2'];?></td>
                       <td align="right"><?php echo $row['mes3'];?></td>
                       <td align="right"><?php echo $row['mes4'];?></td>
                       <td align="right"><?php echo $row['mes5'];?></td>
                       <td align="right"><?php echo $row['mes6'];?></td>
                       <td align="right"><?php echo $row['mes7'];?></td>
                       <td align="right"><?php echo $row['mes8'];?></td>
                       <td align="right"><?php echo $row['mes9'];?></td>
                       <td align="right"><?php echo $row['mes10'];?></td>
                       <td align="right"><?php echo $row['mes11'];?></td>
                       <td align="right"><?php echo $row['mes12'];?></td>
                       
                        
                      </tr>                
    <?php
 }   
}
                      
                        ?>
                  
                    </tbody>

                   
                  </table>
                
                     
                </div>
              
      <?php 
      }
    elseif($tipo==2){
        
            
   ?> 
       <div class="table-responsive">
                   
                  <table id="example" class="display nowrap" style="width:100%;color:black;">
                    <thead>
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                       <th>Proveedor </th>
                        <th>Total </th>
                       
                      <th>2019 </th>
                      <th>2020 </th>
                      <th>2021 </th>
                      <th>2022 </th>
                      <th>2023 </th>
                      <th>2024 </th>
                      <th>2025 </th>
                      </tr>
                    </thead>

                    <tbody>  
 <?php   
$sql="SELECT nombre_cliente,
SUM(if(YEAR(fecha_factura)=2019 and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes1,
SUM(if(YEAR(fecha_factura)=2020 and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes2,
SUM(if(YEAR(fecha_factura)=2021 and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes3,
SUM(if(YEAR(fecha_factura)=2022 and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes4,
SUM(if(YEAR(fecha_factura)=2023 and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes5,
SUM(if(YEAR(fecha_factura)=2024 and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes6,
SUM(if(YEAR(fecha_factura)=2025 and ven_com=2 and activo=1 and facturas.tienda=$tienda,total_venta,0)) AS mes7
FROM clientes, facturas WHERE clientes.id_cliente=facturas.id_cliente GROUP BY nombre_cliente
";

$rs=mysqli_query($con,$sql);

while($row=mysqli_fetch_array($rs)){
    $d=$row['nombre_cliente'];
  $suma=$row['mes1']+$row['mes2']+$row['mes3']+$row['mes4']+$row['mes5']+$row['mes6']+$row['mes7'];
        
    if($suma>0)
    {
        ?>
                      
        <tr id="valor1">
                        
                        <td class=" "><font color="black"><strong><?php echo $d;?></strong></font></td>
                       <td align="right"><font color="blue"><strong><?php echo $suma;?></strong></font></td>
                       <td align="right"><?php echo $row['mes1'];?></td>
                       <td align="right"><?php echo $row['mes2'];?></td>
                       <td align="right"><?php echo $row['mes3'];?></td>
                       <td align="right"><?php echo $row['mes4'];?></td>
                       <td align="right"><?php echo $row['mes5'];?></td>
                       <td align="right"><?php echo $row['mes6'];?></td>
                       <td align="right"><?php echo $row['mes7'];?></td>
                      
                      </tr>                
    <?php
  }  
}
                      
                        ?>
                  
                    </tbody>

                   
                  </table>
                
                     
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


  <!-- Datatables -->
  

  <!-- pace -->
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
        
        
    } );
} );



</script>



</body>

</html>
<?php
ob_end_flush();
?>



