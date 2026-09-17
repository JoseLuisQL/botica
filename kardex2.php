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
$tienda3=$rs2["tienda"];   
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[12]==0){
    header("location:error.php");    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html"; charset=utf-8"/> 
  <!-- Meta, title, CSS, favicons, etc. -->
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title> 
  
  Entradas y Salidas de Productos
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
$producto1="";

$fecha1="";
$fecha2="";
$id_producto=0;
$tienda=0;
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
    
     if ($valor1['tipo']==100){
          $d=$valor1['id'];
          
          $id_producto=$valor1['a1'];
          $producto1=$valor1['a6'];
          //$nom_pro=trim($nom_pro1);
          $fecha1=$valor1['a2'];
          
          $fecha2=$valor1['a3'];
          $tiend=$valor1['a4'];
          if($tiend==7){
              $tienda1=1;
              $tienda2=$tienda1;
          }else{
              $tienda1=$tiend;
              $tienda2=$tiend;
          }
          
          if ($fecha1<>""){
            $d1 = explode("-", $fecha1);
            $dia1=$d1[0]; 
            $mes1=$d1[1];
            $ano1=$d1[2];
            }
            $dd1=$ano1."-".$mes1."-".$dia1;
            if ($fecha2<>""){
                $d2 = explode("-", $fecha2);
                $dia2=$d2[0]; 
                $mes2=$d2[1];
                $ano2=$d2[2];
                $dd2=$ano2."-".$mes2."-".$dia2;
            }
    
     }
    
}
    
            ?>
          
           
               
               <div class="row" >
                   <div class="col-md-12 col-sm-12 col-xs-12" >
                       <div class="x_panel" style="background:white;">
                  
                      <div style="background:<?php echo COLOR;?>">       
               
               
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                
                                <h2>Llenar los campos para saber las entradas y salidas de un producto:</h2>
                            </div>        
                    </div>  
                 

                           <form style="color:black"  name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="kardex3.php">
                      
                          
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <label>Nombre del Producto:</label>
                        <input type="search" style="color:black;font-size:10pt; font-family:Verdana;" class="form-control" id="nombre_producto" name="producto" value="<?php echo $producto1;?>" placeholder="Nombre del producto" >
					  <input id="id_producto" name="id_producto" type='hidden' value="<?php echo $id_producto;?>">
                      </div>
                     
                         
                          <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha Inicial:</label>
                            <input    name="fecha1"  data-validate-length-range="4" type="date"  class="form-control" style="float: left;" id="fecha1"   value="<?php echo $fecha1;?>" required>
                              
                            
                          </div>
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha Final:</label>
                            <input    name="fecha2"  data-validate-length-range="4" type="date"  class="form-control" style="float: left;" id="fecha2"   value="<?php echo $fecha2;?>" required>
                              
                            
                          </div>
                     
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Sucursal:</label>
                           <select class="form-control" name="tienda" required="required" tabindex="-1" required>
                            <?php
                            if($tiend>0){
                                
                                if($tiend==7){
                                    $t="Todas";
                                }else{
                                    $t="Sucursal $tiend";
                                }
                                
                                ?>
                               <option value="<?php echo $tiend; ?>" ><?php echo $t; ?></option>
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
                       
                      </div>
             
                      
                      <input type="hidden" name="d" value="1">
                      
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <br><button id="send" type="submit" name="enviar" class="btn btn-success">Buscar</button>
                      
                   </div>
                      
                    
                    </form>
                  
                       </div>
                   </div>
                   </div>
               </div>
          
          <div class="row">

              <?php
                       

$total1=0;
$total2=0;
$saldo=0;
if($d==0){
//$sql="select * from products ORDER BY  `products`.`id_producto` DESC LIMIT 0 , 100";
    $sql="";
}else{
  
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$aa="http://".$host.$url;

?>
       
  <div class="table-responsive">
                   
                  <table id="example" class="display nowrap" style="width:100%;color:black;">
                    <thead>
                  
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                       
                        <th>Fecha  </th>
                        <th>Hora  </th>
                        <th>Producto  </th>
                        
                        <th>Descripcion  </th>
                        <th>Doc  </th>
                        <th>Tipo  </th>
                        
                        <th>Nombre </th>
                        <th>Inicial </th>
                        <th>Entrada </th>
                        <th>Salida  </th>
                        <th>Saldo </th>
                      
                      </tr>
                    </thead>

                    <tbody>  
 <?php   
    //if($id_producto1==$id_producto  && $fecha>=$fech1 && $fecha<=$fech2 && $tienda>=$tienda1 && $tienda<=$tienda2)
//$sql="select * from detalle_factura where ORDER BY `detalle_factura`.`fecha` ASC  "; 
$sql="select * from detalle_factura where id_producto=$id_producto and tipo_doc<>8 and tienda>=$tienda1 and tienda<=$tienda1 and DATE_FORMAT(fecha, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(fecha, '%Y-%m-%d')<='$fecha2' ORDER BY `detalle_factura`.`id_detalle` ASC  ";         
$s=1;

$rs=mysqli_query($con,$sql);
while($row= mysqli_fetch_array($rs)){
$id_vendedor=$row['id_vendedor'];
$numero_factura=$row['numero_factura'];
$cantidad1=$row['cantidad']*$row['t2'];
$precio_compra=$row['precio_venta'];
$tienda3=$row['tienda'];
$tipo=$row['ot'];
$tipo_doc=$row['tipo_doc'];
$inv_ini=$row['inv_ini'];
$id_producto1=$row['id_producto'];
$ven_com=$row['ven_com'];
$activo=$row['activo'];
$descripcion1="Ninguno";
if($row['folio']<>""){
    $folio="$row[folio]-";
}else{
   $folio=""; 
}


if($numero_factura==0){
    $descripcion="Traslado de tienda";
}else{
    if($tipo_doc==1){
        $descripcion1="Factura";
    }
    if($tipo_doc==2){
        $descripcion1="Boleta";
    }
    if($tipo_doc==3){
        $descripcion1="Guias";
    }
    if($tipo_doc==5){
        $descripcion="Nota de Debito";
        $descripcion1="Nota de Debito";
    }
    if($tipo_doc==6){
        $descripcion="Nota de Credito";
        $descripcion1="Nota de Credito";
    }
    if($ven_com==1 and $activo==1 and $precio_compra>0){
        if($tipo_doc<=3)
        {
            $descripcion="Ventas";
        }          
    }
    if($ven_com==2 and $activo==1 and $precio_compra>0){
        $descripcion="Compras";
    }
    if($precio_compra==0 and $activo==1){
        $descripcion="Traslado de tienda";
    }
    if($activo==0 ){
        $descripcion="Documento Eliminado";
        //$precio1=$row['precio_compra'];
        if($tipo_doc==9 && $precio_compra>0){
             $descripcion="Entrada Mercaderia";
        }
        if($tipo_doc==10 && $precio_compra>0){
             $descripcion="Salida Mercaderia";
        }
        
    }
}
if($tipo==0){
    $entrada=0;
    $salida=0;
}
if($tipo==1){
    $entrada=0;
    $salida=$cantidad1;
}
if($tipo==2){
    $salida=0;
    $entrada=$cantidad1;
}
$saldo=$inv_ini+$entrada-$salida; 
$cliente1="";
if($tipo_doc>0){
$consulta1 = "SELECT * FROM facturas ";
$result1 = mysqli_query($con, $consulta1);
while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {   
    if($valor1['numero_factura']==$numero_factura && $valor1['estado_factura']==$tipo_doc && $valor1['tienda']==$tienda3){
        $id=$valor1['id_cliente'];
    }   
}
$consulta2 = "SELECT * FROM clientes ";
$result2 = mysqli_query($con, $consulta2);
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {  
    if($valor1['id_cliente']==$id){
        $cliente1=$valor1['nombre_cliente'];
    }   
}
}
if($tipo_doc==0){
    $consulta2 = "SELECT * FROM users ";
    $result2 = mysqli_query($con, $consulta2);
    while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        if($valor1['user_id']==$id_vendedor){
            $nombre1=$valor1['nombres'];
        }  
    }
$cliente1=$nombre1;
}
$fecha3=$row['fecha'];
$d3 = explode("-",$fecha3);
$dia=date("d",strtotime($fecha3)); 
$mes=date("m",strtotime($fecha3));  
$ano=date("Y",strtotime($fecha3)); 
$dd=$ano."-".$mes."-".$dia;
$dd5=$dia."-".$mes."-".$ano;
$hora=date("H:i",strtotime($fecha3)); 
$fecha=strtotime($dd);
$fech1=strtotime($dd1);
$fech2=strtotime($dd2);
$tienda=$row['tienda'];
$total_venta=$row['precio_venta']*$cantidad1;
//if($id_producto1==$id_producto  && $fecha>=$fech1 && $fecha<=$fech2 && $tienda>=$tienda1 && $tienda<=$tienda2){

        $total1=$total1+$total_venta;
        $mon="S/.";
        ?>
                       
        <tr id="valor1">
               
                        <td class=" "><?php print"$dd5";?></td>
                        <td class=" "><?php print"$hora";?></td>
                        <td class=" "><?php echo $producto1;?></td>
                        <td class=" "><?php print"$descripcion";?></td>
                       <td class=" "><?php print"$folio $numero_factura";?></td>
                        
                        <td class=" "><?php echo $descripcion1;?></td>
                      
                        <td class=" "><?php echo $cliente1;?></td>
                        <td><?php echo $inv_ini;?></td>
                        <td><?php echo $entrada;?></td>
                        <td><?php echo $salida;?></td>
                        <td><?php echo $saldo;?></td>
                        
                        
                      </tr>                
    <?php
    $s=$s+1;

}                       
                        ?>
                    
                    </tbody>

                  </table>
                
                     </form>
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
  
<?php $a=$_SESSION['tabla'];?>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  
  
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  
  
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  
  
  
  <script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script>
    $(function() {
	$("#nombre_producto").autocomplete({
		source: "./ajax/autocomplete/productos1.php",
		minLength: 1,
		select: function(event, ui) {
		event.preventDefault();
								$('#id_producto').val(ui.item.id_producto);
								$('#nombre_producto').val(ui.item.nombre_producto);
								
                                                               
                                                                
							 }
						});
						 
						
					});
					
	$("#nombre_producto" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_producto" ).val("");
							
                                                      
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_producto" ).val("");
							$("#id_producto" ).val("");
							
                                                        
                                                                
						}
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




