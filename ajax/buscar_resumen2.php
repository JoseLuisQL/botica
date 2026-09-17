<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
        function generar_numero_aleatorio($longitud) {
            $key = '';
            $pattern = '1234567890';
            $max = strlen($pattern)-1;
            for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
            return $key;
        }
        $mon=moneda;
        
        $tienda=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	if($action == 'ajax'){
	$query1=mysqli_query($con, "select * from datosempresa where id_emp=1");
        $row1=mysqli_fetch_array($query1);
        $alerta=$row1['alerta'];
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
        $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
        $q3 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q3'], ENT_QUOTES)));
        $q4 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q4'], ENT_QUOTES)));
        //$dd1=date("Y/m/d", strtotime($q2));
        
        
        
        //$dd2=date("Y/m/d", strtotime($q3));
        //echo strtotime($dd1);
        //print"<br>";
        //echo strtotime($dd2);
        
        $fech1=strtotime($q2);
        
        
        $fech2=strtotime($q3); 
        
        
        $f1=$fech1/(24*3600);
        
        
        $f2=$fech2/(24*3600);
        
       // echo date('Y-m-d', $f1*24*3600);
       // echo date('Y-m-d', $f2*24*3600);
        
        //print"<br>$f1 <br>$f2<br><br>";
        if($q4==">=1"){
            $tienda=$q4; 
        }else{
            $tienda="=$q4"; 
        }
        
        
        
        $dato=array();
$dato1=array();
$dato2=array();
$dato3=array();
$dato4=array();
$dato7=array();
$dato8=array();
$a=array();
$a1=array();
$a2=array();
$a3=array();


$j=0;
$text="";
$text1="";
$text2="";
if($q4==">=1"){
   $tienda=$q4; 
}else{
   $tienda="=$q4"; 
}
$j=0;

 for($i=$f1;$i<=$f2;$i++){
     $fec[$j]=date('Y-m-d', $i*24*3600);
     
    // print"<br>";   
    // echo $i*24*3600;
    // print" $fec[$j]";
    // echo $fec[$j];
     
    $suma= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total FROM facturas  where estado_factura<=3 and activo=1 and ven_com=1 and tienda$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fec[$j]' )");
    $row= mysqli_fetch_array($suma);
    $dato[$j] = $row['total'];
    //print"<br>";
    if($dato[$j]==""){
        $dato[$j]=0;
    }
    
    
    //echo $row['total'];
     
    $suma1= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total1 FROM facturas  where estado_factura<=3 and activo=1 and ven_com=2 and tienda$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fec[$j]' )");
    $row1= mysqli_fetch_array($suma1);
    $dato1[$j] = $row1['total1']; 
    if($dato1[$j]==""){
        $dato1[$j]=0;
    }
   //  print"<br>";
   // echo $row1['total1'];
    
    $suma2= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total2 FROM facturas  where estado_factura<=3 and activo=1 and ((ven_com=1 and estado_factura<=3 and condiciones<>4) or (ven_com=5) or (ven_com=3) or (ven_com=1 and estado_factura=5)) and tienda$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fec[$j]' )");
    $row2= mysqli_fetch_array($suma2);
    $dato2[$j] = $row2['total2']; 
    if($dato2[$j]==""){
        $dato2[$j]=0;
    }
  // print"<br>";
    //echo $row2['total2'];  //}
    $suma3= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total3 FROM facturas  where estado_factura<=3 and activo=1 and ((ven_com=2 and estado_factura<=3 and condiciones<>4) or (ven_com=6) or (ven_com=4) or (ven_com=1 and estado_factura=6)) and tienda$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fec[$j]' )");
    $row3= mysqli_fetch_array($suma3);
    $dato3[$j] = $row3['total3']; 
    if($dato3[$j]==""){
        $dato3[$j]=0;
    }
    
     $j=$j+1;
}
$j1=1;  
 $fec1=array();

 date_default_timezone_set('America/Lima');

$anio=date("Y");
 
 
for($i=1;$i<=12;$i++)
{
        
    $suma= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total FROM facturas  where estado_factura<=3 and activo=1 and ven_com=1 and tienda$tienda and MONTH(fecha_factura)=$i and YEAR(fecha_factura)=$anio");
    
    //print"SELECT SUM(total_venta) AS total FROM facturas  where estado_factura<=3 and activo=1 and ven_com=1 and tienda$tienda and MONTH(fecha_factura)=$i and YEAR(fecha_factura)=$anio )";
    $row= mysqli_fetch_array($suma);
    $a[$j1] = $row['total'];
    if($a[$j1]==""){
        $a[$j1]=0;
    }
    
     
    $suma1= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total1 FROM facturas  where estado_factura<=3 and activo=1 and ven_com=2 and tienda$tienda and MONTH(fecha_factura)=$i and YEAR(fecha_factura)=$anio");
    $row1= mysqli_fetch_array($suma1);
    $a1[$j1] = $row1['total1']; 
    
    if($a1[$j1]==""){
        $a1[$j1]=0;
    }
    
     
    $suma2= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total2 FROM facturas  where estado_factura<=3 and activo=1 and ((ven_com=1 and estado_factura<=3 and condiciones<>4) or (ven_com=5) or (ven_com=3) or (ven_com=1 and estado_factura=5)) and tienda$tienda and MONTH(fecha_factura)=$i and YEAR(fecha_factura)=$anio");
    $row2= mysqli_fetch_array($suma2);
    $a2[$j1] = $row2['total2']; 
    if($a2[$j1]==""){
        $a2[$j1]=0;
    }
    
     //}
    $suma3= mysqli_query($con, "SELECT SUM(total_venta-obs) AS total3 FROM facturas  where estado_factura<=3 and activo=1 and ((ven_com=2 and estado_factura<=3 and condiciones<>4) or (ven_com=6) or (ven_com=4) or (ven_com=1 and estado_factura=6)) and tienda$tienda and MONTH(fecha_factura)=$i and YEAR(fecha_factura)=$anio");
    $row3= mysqli_fetch_array($suma3);
    $a3[$j1] = $row3['total3']; 
    if($a3[$j1]==""){
        $a3[$j1]=0;
    }
    
    if($i==1){
      $mes2="Enero";
  }  
  if($i==2){
      $mes2="Febrero";
  } 
  if($i==3){
      $mes2="Marzo";
  } 
  if($i==4){
      $mes2="Abril";
  } 
  if($i==5){
      $mes2="Mayo";
  } 
  if($i==6){
      $mes2="Junio";
  } 
  if($i==7){
      $mes2="Julio";
  } 
  if($i==8){
      $mes2="Agosto";
  } 
  if($i==9){
      $mes2="Septiembre";
  } 
  if($i==10){
      $mes2="Octubre";
  } 
  if($i==11){
      $mes2="Noviembre";
  } 
  if($i==12){
      $mes2="Diciembre";
  }   
$fec1[$j1]=$mes2."-".$anio;
    
    
    $j1=$j1+1;
}
?>
     <div class="row">
              <?php
                  if(isset($fec) && count($fec)>0){
                     
                      ?>
                
                  <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                    
                    <p style="color:#045FB4;"> <strong>Grafica de barras Ventas y Compras diario</strong></p>
                  
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content1">
                  <div id="graph_bar_group1" style="width:100%; height:280px;"></div>
                  
                  
                </div>
              </div>
            </div>
                      
               <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                    
                    <p style="color:#045FB4;"> <strong>Grafica de barras Entradas y Salidas diario</strong></p>
                  
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content1">
                  
                  
                  <div id="graph_bar_group" style="width:100%; height:280px;"></div>
                </div>
              </div>
            </div>
                <div class="col-md-12 col-sm-12 col-xs-12">     
                  <font color="blue" size="2"><strong>        Productos mas vendidos</strong></font>
                  
                </div>              
             <div class="col-md-7 col-sm-7 col-xs-12">
              <div class="x_panel">
                
                <div class="x_content">

                  <div id="echart_pie" style="height:350px;"></div>

                </div>
              </div>
            </div>          
                      
              <div class="col-md-5 col-sm-5 col-xs-12">        
                       
                     <div class="x_panel">  
                  
                  
                   
                    <table id="example" class="display" style="width:100%;color:black;" border="1">
                    <thead>
                      <tr style="background-color: #43F2F5<?php echo tablas;?>;color:black; ">
                       <th>Producto </th>
                       <th>Total Ventas</th>
                      
                      
                      </tr>
                    </thead>

                    <tbody> 
                       <?php 
                        $h=0;
$text2=" SUM(IF(DATE_FORMAT(fecha, '%Y-%m-%d')>='$q2' and DATE_FORMAT(fecha, '%Y-%m-%d')<='$q3' and ven_com=1 and tipo_doc<=3 and activo=1 and detalle_factura.tienda$tienda,cantidad*precio_venta-mone,0)) AS 'ventas'"; 
$sql2="SELECT nombre_producto,
$text2
FROM products, detalle_factura WHERE products.id_producto=detalle_factura.id_producto GROUP BY nombre_producto ORDER BY `ventas` DESC LIMIT 0,7";
//print"$sql2";
$rs2=mysqli_query($con,$sql2); 
while($row7=mysqli_fetch_array($rs2)){
    $dato7[$h]=round($row7['ventas'],2);
    if($dato7[$h]==""){
        $dato7[$h]=0;
    }
    $dato55=$row7['nombre_producto'];
    $dato8[$h]=$dato55;
    $dato44=$dato7[$h];
    $mon=moneda;
    print"<tr><td align=center>$dato55</td><td align=center>$mon $dato44</td></tr>";
    $h=$h+1;
}
                        ?>
                    </tbody>

                    </table>  
                  </div>
              </div>
                 <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel-body">
                   <div style="border:1px solid red;width:100%;" >
                  <font color="red" size="4"><strong>        Tendencia Mensual</strong></font>
                  </div>    
                   </div> 
                 </div>     
                     
              <div class="col-md-6 col-sm-6 col-xs-12">
                   
                 
              <div class="x_panel">
                <div class="x_title">
                    
                    <p style="color:#DF3A01;"> <strong>Grafica de barras Ventas y Compras Mensual</strong></p>
                  
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content1">
                  
                  
                  <div id="graph_bar_group2" style="width:100%; height:280px;"></div>
                </div>
              </div>
            </div>
              
              
              
               <div class="col-md-6 col-sm-6 col-xs-12">
                   
              <div class="x_panel">
                <div class="x_title">
                    
                    <p style="color:#DF3A01;"> <strong>Grafica de barras Entradas y Salidas (Últimos Meses)</strong></p>
                  
                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content1">
                  
                  
                  <div id="graph_bar_group3" style="width:100%; height:280px;"></div>
                </div>
              </div>
            </div>
      </div>    

                  
<?php
                  }
                    ?>
        
          </div>        
           
   
       
            <?php
            }
                   
?>
</tbody>

                  
  <?php
  $r6="dato"
 //}

?>   
     
<script>

$(function () {

    var day_data = [
        
        <?php
                    for($i = 0;$i<=$j-1;$i++){
                ?>
                {"period": "<?php print"$fec[$i]";?>", "Entradas": <?php print"$dato2[$i]";?>, "Salidas": <?php print"$dato3[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group',
        data: day_data,
        xkey: 'period',
        barColors: ['#04B431', 'orange', '#ACADAC', 'orange'],
        ykeys: ['Entradas', 'Salidas'],
        labels: ['Entradas', 'Salidas'],
        hideHover: 'auto',
        xLabelAngle: 60
    });

 

});
    $(function () {

   
    var day_data1 = [
        
        <?php
                    for($i = 0;$i<=$j-1;$i++){
                ?>
                {"period": "<?php print"$fec[$i]";?>", "Ventas": <?php print"$dato[$i]";?>, "Compras": <?php print"$dato1[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group1',
        data: day_data1,
        xkey: 'period',
        barColors: ['#0000FF', '#FF0000', '#ACADAC', '#3498DB'],
        ykeys: ['Ventas', 'Compras'],
        labels: ['Ventas', 'Compras'],
        hideHover: 'auto',
        xLabelAngle: 60
    });



var day_data2 = [
        
        <?php
                    for($i = 1;$i<=12;$i++){
                ?>
                {"period": "<?php print"$fec1[$i]";?>", "Entradas": <?php print"$a2[$i]";?>, "Salidas": <?php print"$a3[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group3',
        data: day_data2,
        xkey: 'period',
        barColors: ['#04B431', 'orange', '#ACADAC', 'orange'],
        ykeys: ['Entradas', 'Salidas'],
        labels: ['Entradas', 'Salidas'],
        hideHover: 'auto',
        xLabelAngle: 60
    });
    
    
    var day_data3 = [
        
        <?php
                    for($i = 1;$i<=12;$i++){
                ?>
                {"period": "<?php print"$fec1[$i]";?>", "Ventas": <?php print"$a[$i]";?>, "Compras": <?php print"$a1[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group2',
        data: day_data3,
        xkey: 'period',
        barColors: ['#0000FF', '#FF0000', '#ACADAC', '#3498DB'],
        ykeys: ['Ventas', 'Compras'],
        labels: ['Ventas', 'Compras'],
        hideHover: 'auto',
        xLabelAngle: 60
    });
 

});


var myChart = echarts.init(document.getElementById('echart_pie'), theme);
    myChart.setOption({
      tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
      },
      legend: {
        //orient: 'vertical',
        //x: 'left',
        x: 'center',
        y: 'bottom',
        data: [
        
        <?php
                    for($i = 0;$i<=$h-1;$i++){
                ?>
                '<?php echo  substr($dato8[$i], 0, 18);?>.',
                <?php } ?>
    
    ]
     
      },
      
      calculable: true,
      series: [{
        name: 'Venta Total',
        type: 'pie',
        radius: '55%',
        Colors: ['#0000FF', '#FF0000'],
        center: ['50%', '48%'], //left,top
        data: [
            
        <?php
                    for($i = 0;$i<=$h-1;$i++){
                ?>
                {value:"<?php print"$dato7[$i]";?>", name: '<?php echo  substr($dato8[$i], 0, 18);?>.'},
                <?php } ?>
        
        ]
      }]
    });


    var placeHolderStyle = {
      normal: {
        color: 'rgba(0,0,0,0)',
        label: {
          show: false
        },
        labelLine: {
          show: false
        }
      },
      emphasis: {
        color: 'rgba(0,0,0,0)'
      }
    };






</script>
     
