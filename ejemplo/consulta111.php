<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$consulta1 = "SELECT * FROM clientes ";
$result1 = mysqli_query($con, $consulta1);
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$sql2="select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$tienda3=$rs2["tienda"];
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


if(recoge1('comision1')>0 and recoge1('comision2')>0){
   $comision1=recoge1('comision1');
    $comision2=recoge1('comision2'); 
}
$a3=recoge1('tienda');
$a4=recoge1('moneda');
$a5=recoge1('user_id');
$a6="";
$delete=mysqli_query($con,"DELETE FROM consultas");
$insert=mysqli_query($con,"INSERT INTO consultas VALUES (NULL,'41','$a1','$a2','$a3','$a4','$a5','$a6')");     

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
 Reporte Comision Vendedores Diario
  
  </title>

 <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">
  <link href="css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">
 <link href="css/select/select2.min.css" rel="stylesheet">
  <script src="js/jquery.min.js"></script>
  <SCRIPT LANGUAGE="JavaScript" SRC="calendar.js"></SCRIPT>
  
  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>


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
          <!-- /menu prile quick info -->

          <br />

      
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
$dd1="";
$dd2="";
$mon="";
$id_user=0;
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        
     if ($valor1['tipo']==41){
         
         $fecha1=$valor1['a1'];
          //$nom_pro=trim($nom_pro1);
          $fecha2=$valor1['a2'];
          $tienda=$valor1['a3'];
          $id_user=$valor1['a5'];
          
          
        
                   
          
     }
    
}
    
            ?>
              
               <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                       <div class="x_panel" style="background:<?php echo COLOR;?>;">
                        <form  name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="consulta111.php">
                      
                          <div class="panel panel-info">
		<div class="panel-heading">
		   
                    <h2>Reporte Comision Vendedores Diario</h2>
		</div>        
        </div> 
                     
                       <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <label>Buscar Vendedor:</label>
                        <select class="select2_single form-control" name="user_id" required="required" tabindex="-1">
                            <option value="" > Buscar Vendedor
                              
                            <?php
                            $consulta1 = "SELECT * FROM users ORDER BY  `users`.`nombres` ASC  ";
                            $result1 = mysqli_query($con, $consulta1);

                            while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                            if($id_user==$valor1['user_id']){
                            ?>
                                <option  selected value="<?php echo $valor1['user_id'];?>"><?php echo $valor1['nombres'];?>     
                            <?php
                                }else{
                            ?>
                                <option  value="<?php echo $valor1['user_id'];?>"><?php echo $valor1['nombres'];?>     
                            <?php
                            }
    
                            }                            
                            ?>
                                                                                          
                        </select>
                      </div>       
                            
                            
                    
                         <div class="col-md-4 col-sm-4 col-xs-12">
                           
                             <label>Fecha1:</label>
                               <input class="textfield10" class="form-control col-md-10" value="<?php echo $fecha1; ?>" id="fecha1" name="fecha1" type="date" required="required" >
                          </div>
                            
                        
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                            
                           <label>Fecha2:</label>
                               <input class="textfield10" class="form-control col-md-10" value="<?php echo $fecha2; ?>" id="fecha2" name="fecha2" type="date" required="required" >
                          </div>
                     
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Sucursal:</label>
                           <select class="textfield11" class="form-control col-md-10" name="tienda" required="required" tabindex="-1">
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
                             for($i=1 ;$i<=$tienda3;$i++){
                                ?>
                                <option value="<?php echo $i;?>" >Sucursal <?php echo $i;?></option>              
                               <?php
        
                            } 
                                ?>
                                                                                 
                        </select>
                        <br>
                      <br>
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
              if($id_user>0){
                  
              ?>
                <div class="table-responsive">
                  <table id="example"  style="width:100%;color:black;">
                    <thead>
                      <tr style="background-color:#FE9A2E; ">
                        <?php
                       print"<td>Cliente</td><td>Nro Doc</td><td>Tipo Doc</td><td>Fecha Doc</td>";
                       
                        print"<td>Descripcion<br>Producto</td><td>Codigo<br>Producto</td><td>cantidad</td><td>Precio</td><td>Monto</td><td>Comision</td>";
                    
                   ?>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cont=0;
                    $suma1=0;
                     $sql1="SELECT * FROM  facturas,users,clientes where facturas.activo=1 and facturas.ven_com=1 and facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=$id_user and facturas.id_vendedor=users.user_id and facturas.estado_factura<=3  and facturas.tienda=$tienda and DATE_FORMAT(facturas.fecha_factura, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(facturas.fecha_factura, '%Y-%m-%d')<='$fecha2' ORDER BY  `facturas`.`id_factura` ASC ";
                    //print"$sql1";
                    $query1 = mysqli_query($con, $sql1);
                    while ($row1=mysqli_fetch_array($query1)){
                        $folio=$row1['folio'];
                        $numero_factura=$row1['numero_factura'];
                        $numero=$row1['folio']."-".$row1['numero_factura'];
                        $estado_factura=$row1['estado_factura'];
                        $fecha=date("d/m/Y", strtotime($row1['fecha_factura']));
                        $monto_total=$row1['total_venta'];
                        $nombre_cliente=$row1['nombre_cliente'];
                        $id_cliente=$row1['id_cliente'];
                        if($estado_factura==1){
                          $estado1="Factura";  
                        }
                        if($estado_factura==2){
                          $estado1="Boleta";  
                        }
                        if($estado_factura==3){
                          $estado1="Nota de Pedido";  
                        }
                        $condiciones=$row1['estado_factura'];
                        if($condiciones==1){
                            $estado2="Efectivo";
                        }
                        if($condiciones==2){
                            $estado2="Cheque";
                                                    
                        }
                        if($condiciones==3){
                            $estado2="Transf Bancaria";
                        }
                        if($condiciones==4){
                            $estado2="Crédito";
                        }
                        //print"<tr style=background:green;color:white;><td>Cliente</td><td>Nro Doc</td><td>Tipo Doc</td><td>Fecha Doc</td><td>Monto</td><td></td></tr>";
                        $cont=$cont+1;
                        //print"<tr><td>$nombre_cliente</td><td>$numero</td><td>$estado1</td><td>$fecha</td><td>$monto_total</td><td></td></tr>";
                        //$cont=$cont+1; 
                        //print"<tr style=background:orange;color:white;><td>Descripcion<br>Producto</td><td>Codigo<br>Producto</td><td>cantidad</td><td>Precio<br>sin IGV</td><td>Monto</td><td>Comision</td></tr>";
                    $suma=0;
                    
                    $sql="SELECT * FROM  detalle_factura,products,users,und where products.und_pro=und.id_und and detalle_factura.id_vendedor=users.user_id and detalle_factura.id_producto=products.id_producto and detalle_factura.numero_factura=$numero_factura and detalle_factura.folio='$folio' and detalle_factura.activo=1 and detalle_factura.id_cliente=$id_cliente and detalle_factura.tipo_doc=$estado_factura and detalle_factura.tienda=$tienda";
                    
                    $query = mysqli_query($con, $sql);
                    while ($row=mysqli_fetch_array($query)){
                            
                            $numero_factura=$row['numero_factura'];
                            $tipo_doc=$row['tipo_doc'];
                            if($tipo_doc==1){
                                
                                $iva=iva;
                            }
                            if($tipo_doc==2){
                                
                                $iva=iva;
                            }
                            
                            if($tipo_doc==3){
                               
                                $iva=0;
                            }
                            $venta=$row['cantidad']*$row['precio_venta'];
                            $fecha=date("d/m/Y", strtotime($row['fecha']));
                            $codigo_producto=$row['codigo_producto'];
                            $cantidad=$row['cantidad'];
                            $nom=$row['nom_und'];
                            $producto=$row['nombre_producto']."(".$nom.")";
                            $nombres=$row['nombres'];
                            $tipo=$row['status_producto'];
                            $val1=$row['valor2'];
                            $val2=$row['valor3'];
                            if($val2>0){
                                $comision=$cantidad*$val2/$val1;
                            }
                            else{
                                $comision=0;
                            }
                            //if($tipo==1){
                                
                                $venta1=$row['precio_venta']/(1);
                                
                            //}
                            //if($tipo==0){
                                
                            //}
                            $cont=$cont+1;
                            ?>
					
                                <tr>
                                   <?php
                                   print"<td>$nombre_cliente</td><td>$numero</td><td>$estado1</td><td>$fecha</td>";
                        
                                   ?>
                                    
                                        <td><?php echo $producto; ?></td>
                                         <td><?php echo $codigo_producto; ?></td>
                                        <td><?php echo number_format($cantidad, 2, '.', ''); ?></td>
					<td>S/.<?php echo number_format($venta1, 2, '.', ''); ?></td>
                                        <td>S/.<?php echo number_format($cantidad*$venta1, 2, '.', ''); ?></td>
                                        
                                        <td align="right">S/.<?php echo round($comision,2); ?></td>
                                        
                                </tr>
                            <?php
                            $suma=$suma+$comision;
                            $suma1=$suma1+$comision;
                            
			}
                          
                        
                        $cont=$cont+1;
                        }
			?>
                     
                </div>
              
               <tr>
                                              
					<td></td>
					<td></td>
                                        <td></td>
                                        <td></td>
					<td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                        <td>Total</td>
                                        <td align="right"><strong>S/.<?php echo round($suma1,2); ?></strong></td>
                                </tr>      
                                
                    <tbody>  
               </table>
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
            
        "pageLength": 100,
        "order": [],
    } );
} );



</script>



</body>

</html>




