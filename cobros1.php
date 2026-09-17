<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$b = explode(".", $modulo); 

if($b[26]==0){
   header("location:error.php");    
}

$a=recoge1('a');
$fecha1=recoge1('fecha1');
$fecha2=recoge1('fecha2');
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
  
  Pagos
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
  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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

 


      <!-- page content -->
      <div class="right_col" role="main">
<?php 
  
            ?>
       
          <div class="row">
               <div class="x_panel" style="background:#81F79F;">
               <div class="panel panel-info">
		<div class="panel-heading">
		   
                    <h2>Buscar Cobros entre dos fechas:</h2>
		</div>        
                </div> 
                  <form style="color:black;" data-parsley-validate class="form-horizontal form-label-left" method="GET" action="cobros1.php">
                      
                          
                      <div class="col-md-3 col-sm-3 col-xs-12">
                           
                             <label>Fecha1:</label>
                               <input class="form-control col-md-10" value="<?php echo $fecha1; ?>" id="fecha1" name="fecha1" type="date" required="required" >
                          </div>
                      
                      <input type="hidden" value="<?php echo $a;?>" name="a">
                     <div class="col-md-3 col-sm-3 col-xs-12">
                           
                             <label>Fecha2:</label>
                               <input class="form-control col-md-10" value="<?php echo $fecha2; ?>" id="fecha2" name="fecha2" type="date" required="required" >
                          </div>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <button id="send" type="submit" name="enviar" class="btn btn-success">Buscar</button>
                      </div> 
              </form>
              </div>
                
              <?php
                       





if($a==0){
//$sql="select * from products ORDER BY  `products`.`id_producto` DESC LIMIT 0 , 100";
    $sql="";
}else{
  ?>
  <div class="table-responsive">
                   
                  <table id="example" class="display nowrap" style="width:100%;color:black;">
                    <thead>
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                      
                        <th>Fecha  </th>
                        <th>Hora </th>
                        <th>Cliente </th>
                        <th>Pago  </th>
                        <th>Doc  </th>
                        <th>Tipo Doc  </th>
                        <th>Vendedor </th>
                        <th>Tipo<br> de Cobro </th>
                        <th>Operacion<br> y Cobro </th>
                        
                      <th>Eliminar  </th>
                      </tr>
                    </thead>

                    <tbody>  
 <?php   
    
    $sql="select * from facturas,clientes, users where facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id and facturas.ven_com=3 and facturas.activo=1 and facturas.id_cliente=$a and DATE_FORMAT(facturas.fecha_factura, '%Y-%m-%d')>='$fecha1' and  DATE_FORMAT(facturas.fecha_factura, '%Y-%m-%d')<='$fecha2'"; 

$s=1;
$rs=mysqli_query($con,$sql);

while($row= mysqli_fetch_array($rs)){
    

$fecha3=$row['fecha_factura'];
$estado_factura=$row['estado_factura'];
$d3 = explode("-",$fecha3);
$dia=date("d",strtotime($fecha3)); 
$mes=date("m",strtotime($fecha3));  
$ano=$d3[0];
$dd=$dia."-".$mes."-".$ano;
$hora=date("H:i",strtotime($fecha3)); 
$id=$row['id_factura']; 
$nombre_cliente=$row['nombre_cliente']; 

$obs=$row['obs']; 
$numero_factura=$row['numero_factura'];
$condiciones=$row['condiciones'];
if($condiciones==1){
    $condiciones1="Efectivo";
}
if($condiciones==2){
    $condiciones1="Cheque";
}
if($condiciones==3){
    $condiciones1="Transferencia Bancaria";
}
if($condiciones==4){
    $condiciones1="Deposito";
}

$sql1="select * from comprobante_pago where id_comprobante=$estado_factura";
$rs1=mysqli_query($con,$sql1);

$row1= mysqli_fetch_array($rs1);
$tipo=$row1['des_comprobante'];

$nombre_vendedor=$row['nombres'];

$moneda=$row['moneda'];
if($moneda==1){
        
        $mon="S/.";
        }
        if($moneda>1){
        
        $mon="USD";
        }


$total_venta=$row['total_venta'];
    

        
        ?>
  
        <tr id="valor1">
       
                        
                      
                        <td class=" "><?php print"$dd";?></td>
                        <td class=" "><?php print"$hora";?></td>
                        <td class=" "><?php echo $nombre_cliente;?></td>
                        <td class=" "><?php print"$mon ";echo $total_venta;?></td>
                        <td class=" "><?php echo $numero_factura;?></td>
                        <td class=" "><?php echo $tipo;?></td>
                        <td class=" "><?php echo $nombre_vendedor;?></td>
                        <td class=" "><?php echo $condiciones1;?></td>
                        <td class=" "><?php echo $obs;?></td>
                        <td class=" "><a href="eliminarcobros.php?id=<?php echo $id;?>">Eliminar </a></td>
                        
                        
                      </tr>                
    <?php
    
}
}                       
                        ?>
                 </tbody>

                  </table>
                
                     </form>
                </div>
              
              
            <?php

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



