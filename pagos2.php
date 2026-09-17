<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");

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
  
  
  </title>

 <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">
  <link href="css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">
 <link href="css/select/select2.min.css" rel="stylesheet">
  <script src="js/jquery.min.js"></script>
 
  
  
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


</style>
<script>
function imprimir(id_factura){
    window.open('pdf/documentos/ver_factura1.php?id_factura='+id_factura, "Pagos", "width=900, height=1000")
}  



</script>
</head>

<body class="nav-md">

  <div class="container body">


    <div class="main_container">

    
      <div class="right_col" role="main">

      <div class="row">
        
                
             <?php
            $a=recoge1('a');
            if($a==0){
                $sql="";
            }else{
            ?>
            <div class="x_content">
                   
                  <table id="example" class="table table-striped responsive-utilities jambo_table">
                    <thead>
                      <tr style="background-color:#FE9A2E;color:white; ">
                      
                        <th>Nro doc</th>
                        <th>Tipo de Doc</th>
                        <th>Nro ot</th>
			<th>Fecha</th>
			<th>Cliente</th>
			<th>Vendedor</th>
			<th>Estado</th>
			<th class='text-right'>Total Compras</th>
                        <th class='text-right'>Deuda</th>
                        <th class='text-right'>Ver pagos</th>
                      </tr>
                    </thead>

                    <tbody>  
 <?php   
$sql="select * from facturas, clientes, users where facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id and facturas.ven_com=2  and facturas.ot=$a"; 
$s=1;
$rs=mysqli_query($con,$sql);
while($row= mysqli_fetch_array($rs)){
$fecha3=$row['fecha_factura'];
$estado_factura=$row['estado_factura'];
$d3 = explode("-",$fecha3);
$dia=date("d",strtotime($fecha3)); 
$mes=date("m",strtotime($fecha3)); 
if($estado_factura==1){
    $estado1="Factura";
                                                    
}
if($estado_factura==2){
    $estado1="Boleta";
                                                    
}
if($estado_factura==3){
    $estado1="Guia";
                                                    
}
$hora=date("H:i",strtotime($fecha3)); 
$ano=$d3[0];
$dd=$dia."-".$mes."-".$ano;
$ot=$row['ot']; 
$numero_factura=$row['numero_factura'];
$nombre_cliente=$row['nombre_cliente']; 
$id=$row['id_factura']; 
$sql1="select * from comprobante_pago where id_comprobante=$estado_factura";
$rs1=mysqli_query($con,$sql1);
$row1= mysqli_fetch_array($rs1);
$tipo=$row1['des_comprobante'];
 $deuda=$row['deuda_total'];
$nombre_vendedor=$row['nombres'];
$moneda=$row['moneda'];
$mon="S/.";  
$total_venta=$row['total_venta'];
if ($deuda==0){$text_estado="Pagada";$label_class='label-success';}   
     
        ?>
                  
        <tr id="valor1">
                    
                        <td class=" "><?php echo $numero_factura;?></td>
            <td class=" "><?php print"$estado1";?></td>
            <td class=" "><?php print"$ot";?></td>
            <td class=" "><?php print"$fecha3";?></td>     
            <td class=" "><?php echo $nombre_cliente;?></td>     
            <td class=" "><?php echo $nombre_vendedor;?></td>
            <td class=" "><?php print"$text_estado";?></td>
                        
            <td class=" "><?php print"$mon ";echo $total_venta;?></td>
                        
            <td class=" "><?php echo $deuda;?></td>
            <td class=" "><a href="#" onclick="imprimir('<?php echo $id;?>');">ver </a></td>
                       
         </tr>                
    <?php
    }
}                       
?>
                 </tbody>

                  </table>
                
                     </form>
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
          "sSearch": "Buscar todas las columnas:"
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



