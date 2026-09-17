<?php
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

 if($a[32]==0){
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
  Detalle Caja
  
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
<body style="background:white;">
  
              <?php
                       
$a=recoge1('f');
$tienda=recoge1('tienda');
$id_vendedor=recoge1('user');
$turno=recoge1('turno');
?>
              <h1 style="color:red;">Caja dia <?php echo $a;?></h1>        
              
              <?php
if($a==0){
//$sql="select * from products ORDER BY  `products`.`id_producto` DESC LIMIT 0 , 100";
    $sql="";
}else{
  ?>
  <div class="table-responsive" >
      <h2><font color="black"> Resumen de Ventas</font> </h2>              
                  <table id="example"  style="width:100%;color:black;" border="1">
                    <thead>
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                        <th class='text-center'>Fecha</th>
                        <th class='text-center'>Producto </th>
                        <th class='text-center'>Razon Social </th>
                        <th class='text-center'>Mon </th>
                        <th class='text-center'>Documento </th>
                        <th class='text-center'>Monedero <br><?php echo moneda;?></th>
                        <th class='text-center'>Cantidad</th>
                        <th class='text-center'>Precio</th>
                        <th class='text-center'>Ventas <br><?php echo moneda;?></th>
                        
                        <th class='text-center'>Sub_total  <br><?php echo moneda;?></th>
                      
                      </tr>
                    </thead>

                    <tbody>  
 <?php  
 
 $monedero1=0;
 $suma1=0;
 
 
 
 
 //$id_vendedor=$_SESSION['user_id'];   
$sql="select * from facturas,clientes where facturas.ven_com=1 and facturas.estado_factura<=3 and facturas.turno='$turno' and facturas.activo=1 and facturas.id_vendedor=$id_vendedor and facturas.tienda=$tienda and clientes.id_cliente=facturas.id_cliente and DATE_FORMAT(fecha_factura, '%d-%m-%Y')='$a'"; 
$rs=mysqli_query($con,$sql);

//print"$sql";
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
    $total=$row['total_venta'];
    $folio=$row['folio'];
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
    if($tipo==6 ){
        $text="Pagos";
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
    $efectivo1=($row['total_venta']-$row['obs'])*$row['moneda'];
if($dd==$a){
    
      
        
        $sql1="select * from detalle_factura,products where products.id_producto=detalle_factura.id_producto and detalle_factura.ven_com=1 and detalle_factura.folio='$folio' and detalle_factura.numero_factura='$numero_factura' and detalle_factura.activo=1 and detalle_factura.id_vendedor=$id_vendedor and detalle_factura.tienda=$tienda "; 
        $rs1=mysqli_query($con,$sql1);

//print"$sql1";
        while($row1= mysqli_fetch_array($rs1)){ 
        $producto=$row1['nombre_producto'];
        $cantidad=$row1['cantidad'];
        $precio=$row1['precio_venta'];
        $efectivo1=$cantidad*$precio;
        $monedero=$row1['mone'];
        if($efectivo1>0){
        $suma1=$suma1+$efectivo1-$monedero;
            ?>
                    
        <tr id="valor1">
            <td class=" "><?php print"$a";?></td>
            <td class=" "><?php print"$producto";?></td>
            <td class=" "><?php print"$nombre_cliente";?></td>
            <td class=" "><?php print"$mon";?></td>
            <td class=" "><?php print"$folio-$numero_factura";?></td>
            <td class='text-center'><?php print"$monedero";?></td>
            <td class='text-center'><?php print"$cantidad";?></td>
            <td class='text-center'><?php print"$precio";?></td>
            <td class='text-center'><?php print"$efectivo1";?></td>    
            
            <td class='text-right'><?php $dif1=$efectivo1-$monedero;echo number_format($dif1,2);?></td>    
                        
        </tr>                
    <?php
     }
    } 
    }   
}
}                       
                        ?>
        <tr style="background:white;">
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td class='text-center' bgcolor="orange">Total</td><td class='text-right'><?php echo number_format($suma1,2);?></td>
				</tr>                
                      
                    </tbody>

                  </table>
                
                     </form>
                </div>
              
              
            <?php

?>
             
            
 
          

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
        "order":[],
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




