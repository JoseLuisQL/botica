<?php
ob_start();
//ob_end_flush();
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
$tienda1=$rs2["tienda"];
$tienda3=$rs2["tienda"];
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
  Entradas y Salidas
  
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
      
   
        </div>
      </div>

        
        <?php
          menu3();
          
          ?>
      <!-- top navigation -->
     


      <!-- page content -->
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
$dd1="";
$dd2="";
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
    
    
     
     if ($valor1['tipo']==22){
          $d=$valor1['id'];
         $tipo=$valor1['a1'];
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
          
           
               
               <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                       <div class="x_panel" style="background:<?php echo COLOR;?>;">
                      <form name="myForm" style="color:black;" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="GET" action="balance3.php">
                      
                        
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                   
                                <h2>Balance de entradas y salidas:</h2>
                            </div>        
                        </div>  
                     
                           <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha Inicial:</label>
                            <input  name="fecha1"  data-validate-length-range="4" type="date"  class="form-control" style="float: left;" id="fecha1"   value="<?php echo $fecha1;?>" required>
                              
                            
                          </div>
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha Final:</label>
                            <input   name="fecha2"  data-validate-length-range="4" type="date"  class="form-control" style="float: left;" id="fecha2"   value="<?php echo $fecha2;?>" required>
                              
                            
                          </div>
                     
                      
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <label>Sucursal:</label>
                           <select class="form-control" name="tienda" required="required" tabindex="-1">
                            <?php
                            if($tiend>0){
                                
                                if($tiend==4){
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
                        <button id="send" type="submit" name="enviar" class="btn btn-success">Buscar</button>
                      </div>
                   
                      
                    
                    </form>
                  
          
                   </div>
                   </div>
               </div>
        <div class="row">
      
                <?php
                
                ?>
                
              <?php
                       

$total11=0;
$total22=0;
$fech1=strtotime($dd1);
$fech2=strtotime($dd2);  

$f1=$fech1/(24*3600);
$f2=$fech2/(24*3600);
$suma1=0;
$suma2=0;
$suma3=0;
$suma4=0;
$suma5=0;
$suma6=0;
if($d==0){
//$sql="select * from products ORDER BY  `products`.`id_producto` DESC LIMIT 0 , 100";
    $sql="";
}else{           
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$aa="http://".$host.$url;

?>
           
 <div class="table-responsive">
                   
                  <table id="example" class="display nowrap" style="width:100%;color:black">
                    <thead>
                      <tr style="background-color:<?php echo tablas;?>;color:white; ">
                        <th>Fecha </th>
                        <th>Entrada <?php echo moneda;?></th>
                     <!-- <th>Total Ingresos USD</th>-->
                        <th>Salida <?php echo moneda;?></th>
                     <!-- <th>Total Egresos USD</th>-->
                        <th>Diferencia <?php echo moneda;?></th>
                      
                        <th>Entrada Efectivo <?php echo moneda;?></th>
                     <!-- <th>Total Ingresos USD</th>-->
                        <th>Salida Efectivo <?php echo moneda;?></th>
                     <!-- <th>Total Egresos USD</th>-->
                        <th>Dif Efectivo <?php echo moneda;?></th>
                        <th>Detalle <?php echo moneda;?></th>
                      </tr>
                    </thead>

                    <tbody>  
 <?php   
  
$total11=0;
$total22=0;
$total33=0;
$total44=0;
$a1=array();
$a2=array();
$a3=array();
$a4=array();
$fec=array();
$j=0;


for($i=$f1;$i<=$f2;$i++){
 
$sql1="select * from facturas where activo=1 and tienda>=$tienda1 and tienda<=$tienda2 and DATE_FORMAT(fecha_factura, '%Y-%m-%d')>='$fecha1' and DATE_FORMAT(fecha_factura, '%Y-%m-%d')<='$fecha2'"; 
$rs1=mysqli_query($con,$sql1);
$total1=0;
$total2=0;
$total3=0;
$total4=0;
$efectivo1=0;
$efectivo2=0;
$entrada=0;
$salida=0;
$a2[$j]=0;
$a4[$j]=0;


$a=0;
while($row1= mysqli_fetch_array($rs1)){
    $fecha3=$row1['fecha_factura'];
    $tienda=$row1['tienda'];
    $tipo=$row1['ven_com'];
    $condiciones=$row1['condiciones'];
    $estado=$row1['estado_factura'];
    $motivo=$row1['motivo'];
    $d3 = explode("-",$fecha3);
    $dia=date("d",strtotime($fecha3)); 
    $mes=date("m",strtotime($fecha3));  
    $ano=$d3[0];
    $dd=$ano."-".$mes."-".$dia;
    $fecha=strtotime($dd);

    if($fecha==$i*24*3600){    

    if(($tipo==1 || $tipo==3 || $tipo==5) and $estado<>6){
    if($condiciones==1){
        $efectivo1=($row1['total_venta']-$row1['obs'])*$row1['moneda'];
        $total1=$total1+$efectivo1;
    }
    if($condiciones<>4){
        $entrada=($row1['total_venta']-$row1['obs'])*$row1['moneda'];
        $total2=$total2+$entrada;
        $a2[$j]=$total2;
        
        $salida=0;
    }else{
        $salida=0;
        $entrada=0;
    }
}

if($tipo==2 || $tipo==4 || $tipo==6 || ($tipo==1 and ($estado==6 and $motivo<>"01" and $motivo<>'02'))){
    if($condiciones==1){
        $efectivo2=($row1['total_venta']-$row1['obs'])*$row1['moneda'];
        $total3=$total3+$efectivo2;
    }
    if($condiciones<>4){
        $salida=($row1['total_venta']-$row1['obs'])*$row1['moneda'];
        $total4=$total4+$salida;
        $a4[$j]=$total4;
        $entrada=0;
    }else{
        $salida=0;
        $entrada=0;
    }
}
     
  $a=$a+1;  
}
}

$fec[$j]=date('d-m-Y', $i*24*3600);
$j=$j+1;

     if($a>=1) {
        
         ?>
                   
        <tr id="valor1">
              
                    <td class='text-right'><?php echo date('d-m-Y', $i*24*3600);?></td>  
                    <td class='text-right'><?php echo $total2; ?></td>
                    <td class='text-right'><?php echo $total4;?></td>
                    <td class='text-right'><?php $total5=$total2-$total4;print" $total5";?></td>
                    <td class='text-right'><?php echo $total1;?></td>
                    <td class='text-right'><?php echo $total3;?></td>
                    <td class='text-right'><?php $total6=$total1-$total3;print" $total6";?></td>
                    <td class='text-right'><a target="_blank"  onclick="imprimir('<?php echo date('d-m-Y', $i*24*3600);?>',<?php echo $tienda;?>);">Detalle</a></td>
  
       </tr>                
  
        </tbody>

         </form>
              </div>
              
              
            <?php
            $suma2=$suma2+$total2;
            $suma4=$suma4+$total4;
            $suma5=$suma5+$total5;
            $suma1=$suma1+$total1;
            $suma3=$suma3+$total3;
             $suma6=$suma6+$total6;
            
     }


    }
    ?>
     <tr id="valor1">
              
                    <td class='text-right'><strong>Total:</strong></td>  
                    <td class='text-right'><strong><?php echo $suma2; ?></strong></td>
                    <td class='text-right'><strong><?php echo $suma4;?></strong></td>
                    <td class='text-right'><strong><?php print" $suma5";?></strong></td>
                    <td class='text-right'><strong><?php echo $suma1;?></strong></td>
                    <td class='text-right'><strong><?php echo $suma3;?></strong></td>
                    <td class='text-right'><strong><?php print" $suma6";?></strong></td>
                    <td class=" "></td>
  
       </tr>  
       <?php
}
?>
 
            
</table>
      <?php
                  if(isset($fec) && count($fec)>0){
                     ?>
       <div class="row">
            
                  <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  
                    <h2>Grafica de barras Entradas y Salidas </h2>
             
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


<script>
     $(function () {

    /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
    var day_data = [
        
        <?php
                    for($i = 0;$i<count($fec);$i++){
                ?>
                {"period": "<?php print"$fec[$i]";?>", "Entradas": <?php print"$a2[$i]";?>, "Salidas": <?php print"$a4[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group',
        data: day_data,
        xkey: 'period',
        barColors: ['#2E2EFE', '#DF0101', '#ACADAC', '#3498DB'],
        ykeys: ['Entradas', 'Salidas'],
        labels: ['Entradas', 'Salidas'],
        hideHover: 'auto',
        xLabelAngle: 60
    });


});
function imprimir(id_factura,tienda){
    window.open('balance4.php?f='+id_factura+'&tienda='+tienda, "Pagos", "width=900, height=1000")
}
   
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



