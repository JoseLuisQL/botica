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
$a = explode(".", $modulo); 
        
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
	exit;
    }

 if($a[40]==0){
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
  Utilidades
  
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
      <div class="right_col" role="main">
          <div class="row">
              <?php
                       
$a=recoge1('f');
$tienda=recoge1('tienda');
?>
              <h1 style="color:red;">Utilidades dia <?php echo $a;?></h1>        
              
              <?php
if($a==0){
//$sql="select * from products ORDER BY  `products`.`id_producto` DESC LIMIT 0 , 100";
    $sql="";
}else{
  ?>
  <div class="table-responsive">
                   
                  <table id="example"  style="width:100%;color:black;">
                    <thead>
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                        <th>Fecha</th>
                        <th>Nombre Operación </th>
                        <th>Razon Social </th>
                        <th>Monedero </th>
                        <th>Mon </th>
                        <th>Total </th>
                        <th>Entrada <?php echo moneda;?></th>
                        <th>Salida <?php echo moneda;?></th>
                        <th>Dif <?php echo moneda;?></th>
                        <th>Entrada Efectivo <?php echo moneda;?></th>
                        <th>Salida Efectivo <?php echo moneda;?></th>
                        <th>Dif Efectivo <?php echo moneda;?></th>
                      
                      </tr>
                    </thead>

                    <tbody>  
 <?php  
 
 $total1=0;
 $total2=0;
 $total3=0;
 $total4=0;
 $entrada=0;
 $salida=0;
    
$sql="select * from facturas,clientes where facturas.tienda=$tienda and facturas.activo=1 and clientes.id_cliente=facturas.id_cliente and DATE_FORMAT(fecha_factura, '%d-%m-%Y')='$a'"; 
$rs=mysqli_query($con,$sql);
while($row= mysqli_fetch_array($rs)){   
    $fecha3=$row['fecha_factura'];
    $d3 = explode("-",$fecha3);
    $dia=date("d",strtotime($fecha3)); 
    $mes=date("m",strtotime($fecha3));  
    $ano=$d3[0];
    $dd=$dia."-".$mes."-".$ano;
    $nombre=$row['nombre'];
    $nombre_cliente=$row['nombre_cliente'];
    $moneda=$row['moneda'];
    $mon=moneda;
    $motivo=$row['motivo'];
    $total=$row['total_venta'];
    $numero_factura=$row['numero_factura'];
    $obs=$row['obs'];
    $tipo=$row['ven_com'];
    $condiciones=$row['condiciones'];
    $estado=$row['estado_factura'];  
    if($tipo==1 and $estado<=3){
        $text="Ventas";
    }
    if($tipo==3){
        $text="Cobro de Ventas";
    }
    if($tipo==1 and $estado==5){
        $text="Nota de Debito";
    }
    
    if($tipo==2 and $estado<=3){
        $text="Compras";
    }
    if($tipo==4){
        $text="Pago de Compras";
    }
    if($tipo==1 and $estado==6){
        $text="Nota de Credito";
    }
    
    if($condiciones==1){
        $text1="en efectivo";
    }
    if($condiciones==2){
        $text1="con cheque";
    }
    if($condiciones==3){
        $text1="por transferencia";
    }
    if($condiciones==4){
        $text1="al credito";
    } 
    if($condiciones==4){
        $text1="tarjeta";
    } 
if($dd==$a){
    if(($tipo==1 and ($estado<=3 or $estado==5)) || $tipo==3 || $tipo==5){
    if($condiciones==1){
        $efectivo1=($row['total_venta']-$row['obs'])*$row['moneda'];
        $total1=$total1+$efectivo1;
        $efectivo2=0;
    }else{
        $efectivo1=0;
        $efectivo2=0;
    }
    if($condiciones<>4){
        $entrada=($row['total_venta']-$row['obs'])*$row['moneda'];
        $total2=$total2+$entrada;
        $salida=0;
    }else{
        $salida=0;
        $entrada=0;
    }
}

if($tipo==2 || $tipo==4 || $tipo==6 || ($tipo==1 and ($estado==6 and $motivo<>'01' and $motivo<>'02'))){
    if($condiciones==1){
        $efectivo2=($row['total_venta']-$row['obs'])*$row['moneda'];
        $total3=$total3+$efectivo2;
        $efectivo1=0;
    }else{
        $efectivo1=0;
        $efectivo2=0;
    }
    if($condiciones<>4){
        $salida=($row['total_venta']-$row['obs'])*$row['moneda'];
        $total4=$total4+$salida;
        $entrada=0;
    }else{
        $salida=0;
        $entrada=0;
    }
}
      if($entrada>0 or $salida>0){
        ?>
                    
        <tr id="valor1">
            <td class=" "><?php print"$a";?></td>
            <td class=" "><?php print"$text $text1";?></td>
            <td class=" "><?php print"$nombre_cliente";?></td>
            <td class=" "><?php print"$obs";?></td>
            <td class=" "><?php print"$mon";?></td>
            <td class=" "><?php print"$total";?></td>
            <td class=" "><?php print"$entrada";?></td>          
            <td class=" "><?php print"$salida";?></td>            
            <td class=" "><?php $dif=$entrada-$salida;print"$dif";?></td> 
            <td class=" "><?php print"$efectivo1";?></td>    
            <td class=" "><?php print"$efectivo2";?></td>    
            <td class=" "><?php $dif1=$efectivo1-$efectivo2;print"$dif1";?></td>    
                        
        </tr>                
    <?php
    }
    }   
}
}                       
                        ?>
                        
                      
                    </tbody>

                  </table>
                
                     </form>
                </div>
              
              
            <?php

?>
             
            <table style="width:100%;color:black;">
                  <tr><td><h3 style="color:blue;">Totales:</h3></td><td></td></tr>
                  <tr><td><h2 style="color:blue;">Entrada:</h2></td>  <td class=" "><?php echo moneda;?><?php print" $total2";?></td></tr>
                  <tr><td> <h2 style="color:red;">Salida:</h2></td>    <td class=" "><?php echo moneda;?><?php print" $total4";?></td></tr>
                      
                   <tr><td> <h2 style="color:orange;">Diferencia:</h2></td>   <td class=" "><?php echo moneda;?><?php $dif2=$total2-$total4;print" $dif2";?></td></tr>
                   <tr><td> <h2 style="color:blue;">Entrada Efectivo:</h2></td><td class=" "><?php echo moneda;?><?php print" $total1";?></td></tr>
                   <tr><td> <h2 style="color:red;">Salida Efectivo:</h2></td> <td class=" "><?php echo moneda;?><?php print" $total3";?></td></tr>
                   <tr><td> <h2 style="color:orange;">Diferencia Efectivo:</h2></td>  <td class=" "><?php echo moneda;?><?php $dif3=$total1-$total3;print" $dif3";?></td></tr>
                  
                  
              </table> 
 
            </div>
   
            <br />
            <br />
            <br />

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
//ob_start();
ob_end_flush();
?>


