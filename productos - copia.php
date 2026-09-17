<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
include 'ajax/barcode.php';
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$sql2="select * from datosempresa where id_emp=1";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$alerta=$rs2["alerta"];
$precio2=$rs2["precio2"];
$precio3=$rs2["precio3"];

$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[11]==0){
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

  <title>Lista de Productos </title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>



<style type="text/css"> 
    
.Fields {
	background-color: #A9F5E1;
	border: 2px solid #2E9AFE;
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
        text-align:center;
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
        <div class="">
          <div class="page-title">
            <div class="title_left">
              
            </div>

            
          </div>
          <div class="clearfix"></div>

          <div class="row">

           <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
		   <?php 
                                $video=videos;
                    
                                if($video==1){
                                    $v="tHaqiTWQesM";
                                    include("modal/registro_video.php");
                                    ?>
                                    <div class="btn-group pull-right">
                                        <button type='button' class="btn btn-danger" data-toggle="modal" data-target="#nuevoVideo"><span class="glyphicon glyphicon-play" ></span>Video Tutorial</button>
                                    </div>
                                    <?php
                    
                                }
                        ?>
			<h4><i class='glyphicon glyphicon-search'></i>Productos en Sucursal<?php echo $_SESSION['tienda']; ?></h4>
                        <h4>Subir masivamente los productos:    <a href="excel/productos.xlsx" target="_blanck"><font color="blue">Descargar formato de subida</font></a></h4>
                        <form enctype="multipart/form-data" action="productos.php" method="POST">
                               <input   type="file" id="files" name="files" class="form-control"/>
				  
                                <input type="submit" class='btn btn-success btn-xs' value="cargar" name="cargar">
                                 
                            </form>
                
                </div>
            
            
            
            
            
		<div class="panel-body">
                    <?php
                        $cargar=recoge1('cargar');
                        include("modal/registro_productos.php");
			include("modal/editar_productos.php");
			?>
			<?php
                        
			
                          if($cargar=="cargar"){
    
                            
                 //$insert=mysqli_query($con,"delete from planificacion");
	           
   //$namefinal="nuevo.jpg";
    if(is_uploaded_file($_FILES['files']['tmp_name'])) {
        
        $ruta_destino = "archivo/";
        $namefinal="productos.xlsx"; //linea nueva devuelve la cadena sin espacios al principio o al final
        $uploadfile=$ruta_destino.$namefinal;
    if(move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {

  set_time_limit(3000);
	include 'simplexlsx.class.php';
$xlsx = new SimpleXLSX( 'archivo/productos.xlsx' );//Instancio la clase y le paso como parametro el archivo a leer
$fp = fopen( 'archivo/productos.csv', 'w');//Abrire un archivo "datos.csv", sino existe se creara
 foreach( $xlsx->rows() as $fields ) {//Itero la hoja de calculo
        fputcsv( $fp, $fields);//Doy formato CSV a una línea y le escribo los datos
}
fclose($fp);

//$con=@mysqli_connect("localhost", "oferth84_optica", "empresa2018", "oferth84_optica");
 
	
	$productos = fopen ("archivo/productos.csv" , "r" );//leo el archivo que contiene los datos del producto
while (($datos =fgetcsv($productos,2000,",")) !== FALSE )//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) como delimitador
{
 
    //$linea[]=array('codigo'=>$datos[0],'nombre'=>$datos[1],'lote'=>$datos[2],'presentacion'=>$datos[3],'medida'=>$datos[4],'contenido'=>$datos[5],'peso'=>$datos[6],'stock1'=>$datos[7],'stock2'=>$datos[8],'marca'=>$datos[9]);//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
    $linea[]=array('codigo_producto'=>$datos[0],'nombre_producto'=>$datos[1],'c1'=>$datos[2],'c2'=>$datos[3],'c3'=>$datos[4],'a1'=>$datos[5],'a2'=>$datos[6],'a3'=>$datos[7],'marca'=>$datos[8],'modelo'=>$datos[9],'color'=>$datos[10],'proveedor'=>$datos[11],'b1'=>$datos[12],'b2'=>$datos[13],'b3'=>$datos[14],'b4'=>$datos[15],'b5'=>$datos[16],'b6'=>$datos[17],'b7'=>$datos[18],'min'=>$datos[19],'barras'=>$datos[20],'und'=>$datos[21],'blister'=>$datos[22],'caja'=>$datos[23],'bli'=>$datos[24],'fecha'=>$datos[25],'lote'=>$datos[26]);//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo

    
}
fclose ($productos);//Cierra el archivo

	$ingresado=0;//Variable que almacenara los insert exitosos
	$error=0;//Variable que almacenara los errores en almacenamiento
	$duplicado=0;//Variable que almacenara los registros duplicados
        $r=1;
        foreach($linea as $indice=>$value) //Iteracion el array para extraer cada uno de los valores almacenados en cada items
	{
	$codigo_producto=str_replace("'", "''",$value["codigo_producto"]);//Codigo del producto
	$nombre_producto=str_replace("'", "''",$value["nombre_producto"]);//descripcion del producto
        //$und=$value["und"];
        $nombre_producto=trim($nombre_producto);
        $codigo_producto=trim($codigo_producto);
        $und=trim($value["und"]);
        
	//$costo_producto=$value["costo_producto"];//fabricante del producto
	//$precio_producto=$value["precio_producto"];
        //$precio2=$value["precio2"];//precio del producto
        //$precio3=$value["precio3"];//precio del producto
	$marca=$value["marca"];//precio del producto
	$modelo=$value["modelo"];
        $barras=$value["barras"];
        $color=$value["color"];
        $fecha=$value["fecha"];
        $lote=$value["lote"];
        if($lote==""){
            $lote="lote 1";
        }
        //$caja=$value["caja"];
        $blister=$value["blister"];
        $caja=$value["caja"];
        $proveedor=$value["proveedor"];
        $b1=$value["b1"];
        $b2=$value["b2"];
        $b3=$value["b3"];
        $b4=$value["b4"];
        $b5=$value["b5"];
        $b6=$value["b6"];
        $b7=$value["b7"];
        
        $a1=$value["a1"];
        $a2=$value["a2"];
        $a3=$value["a3"];
        $bli=$value["bli"];
        
        $c1=$value["c1"];
        $c2=$value["c2"];
        $c3=$value["c3"];
        
        
        $costo_producto=$value["c1"];//fabricante del producto
	$precio_producto=$value["a1"];
        
        $precio2=0;//precio del producto
        $precio3=0;//precio del producto
        
        
        $min=$value["min"];
        
        $foto="nuevo.jpg";
        $und1="1";
        $sql1=mysqli_query($con,"select * from und where xml_und='$und'");//Consulta a la tabla productos
	$row1= mysqli_fetch_array($sql1);
        $und1=$row1['id_und'];
            
        
        //$und="1";
        date_default_timezone_set('America/Lima');
		$date_added=date("Y-m-d H:i:s");
        
	//if($precio3>)
        $num=0;        
        $sql=mysqli_query($con,"select * from products where codigo_producto='$codigo_producto'");//Consulta a la tabla productos
	$num=mysqli_num_rows($sql);//Cuenta el numero de registros devueltos por la consulta
        if($codigo_producto<>"" and $nombre_producto<>"" and $a1>=0 and $a2>=0 and $a3>=0 and $c1>=0 and $c2>=0  and $c3>=0)
	{
            if ($num==0)//Si es == 0 inserto
	{        
                
	//if ($insert=mysqli_query($con,"insert into products (codigo_producto,nombre_producto, lote,peso_bruto,presentacion,med,contenido,peso,pro_ser) values('$codigo','$nombre','$lote','$peso_bruto','$presentacion','$medida','$contenido','$peso','1')"))
        if ($insert=mysqli_query($con,"insert into products (codigo_producto, nombre_producto, status_producto, date_added, precio_producto,costo_producto,mon_costo,mon_venta,des1,des2,des3,b1,b2,b3,b4,b5,b6,b7,cat_pro,pro_ser,foto1,foto2,foto3,foto4,web,pre_web,descripcion,descripcion1,megusta,nomegusta,valor2,valor3,und_pro,a1,a2,a3,a4,a5,a6,a7,min,barras,mon,c1,c2,c3,c4,c5,c6,c7,proveedor,blister,caja,p1,p2,bli) VALUES ('$codigo_producto','$nombre_producto','1','$date_added','$precio_producto','$costo_producto','1','1','$marca','$modelo','$color','$b1','$b2','$b3','$b4','$b5','$b6','$b7','0','1','nuevo.jpg','nuevo.jpg','nuevo.jpg','nuevo.jpg','1','$precio_producto','','','0','0','$precio2','$precio3','$und1','$a1','$a1','$a1','$a1','$a1','$a1','$a1','$min','$barras','0','$c1','$c1','$c1','$c1','$c1','$c1','$c1','$proveedor','$blister','$caja','$c2','$c3','$bli')"))
	
        {
	//echo $msj='<font color=green>Colegio <b>'.$destino.'</b> Guardado</font><br/>';
	if(strlen($barras)>=10){
            barcode('ajax/codigos/'.$barras.'.png', $barras, 30, 'horizontal', 'code128', true);
            
        }
            //------------------------------
            $id_producto=mysqli_insert_id($con);
            $ingreso=mysqli_query($con,"INSERT INTO precios VALUES (NULL,'$id_producto','$a1','$a2','$a3','$c1','$c2','$c3','$b1','$b2','$b3','$b1','$b2','$b3','1')");
            
            //cambios
            if($fecha<>""){
            $sql="INSERT INTO lote (id_producto,fec_vto,fec_fab,lote,tienda,inicial,final) VALUES ('$id_producto','$fecha','$date_added','$lote','1','$b1','$b1')";
		$query_new_insert = mysqli_query($con,$sql);
                $id_lote=mysqli_insert_id($con);
                $insert_lote1=mysqli_query($con, "INSERT INTO lote1 VALUES (NULL,'$id_lote','$date_added','0','$b1','0','0')");
           }
            //cambios 
            
            
            //--------------------------------------
            $ingresado+=1;
            $r=$r+1;
	}//fin del if que comprueba que se guarden los datos
	else//sino ingresa el producto
	{
	//print"insert into products (codigo_producto, nombre_producto, status_producto, date_added, precio_producto,costo_producto,mon_costo,mon_venta,marca,modelo,color,b1,b2,b3,b4,b5,b6,cat_pro,pro_ser,foto1,foto2,foto3,foto4,web,pre_web,descripcion,descripcion1,megusta,nomegusta,precio2,precio3,und_pro,barras,dcto,min) VALUES ('$codigo_producto','$nombre_producto','1','$date_added','$precio_producto','$costo_producto','1','1','$marca','$modelo','$color','$b1','$b2','$b3','$b4','$b5','$b6','0','1','nuevo.jpg','nuevo.jpg','nuevo.jpg','nuevo.jpg','1','$precio_producto','','','0','0','0','0','$und','','0','$min')";
            echo $msj='<div><font color=red>Producto de código<b>'.$codigo_producto.' </b> NO Guardado '.mysqli_error().'</font><br/></div>';
	$error+=1;
	}
	}//fin de if que comprueba que no haya en registro duplicado
	else
	{
	$duplicado+=1;
        if($num>0){
	echo $duplicate='<div><font color=red>El producto '.$nombre_producto.' de codigo <b>'.$codigo_producto.'</b> Esta duplicado<br></font></div>';
	 }
        if($precio_producto<=$precio2 or $precio2<=$precio3){
             echo $duplicate='<div><font color=red>El producto '.$nombre_producto.' de codigo <b>'.$codigo_producto.'</b> Tiene un error en los precios<br></font></div>';
	
        }
       
        
        }
        
	}
	
        }
        
   }      
  }
  }
      if(isset($ingresado) and isset($ingresado) and isset($error)){
         echo "<div><font color=green>".number_format($ingresado,2)." Productos Almacenados con exito</font><br/>";
	echo "<font color=red>".number_format($duplicado,2)." Productos Con error</font><br/>";
	echo "<font color=red>".number_format($error,2)." Errores de almacenamiento</font><br/></div>";
 
      }  
  	                
  include("modal/registro_productos.php");
			include("modal/editar_productos.php");
  ?>
                        
                        
                        
                        
                        
				<form style="color:black;" class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-1 control-label">Buscar</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" autocomplete="off" class="form-control" id="q" placeholder="Código ,nombre, laboratorio,componente" onkeyup='load(1);'>
							</div>
                                                         <div class="col-md-2 col-sm-2 col-xs-12">
								<select class="form-control" id="q1"  onchange='load(1);'>
                                                                    <option value="">ORDENAR</option>
                                                                    <option value="asc">ASCENDENTE</option>
                                                                    <option value="desc">DESCENDENTE</option>
                                                                    
                                                                </select>
							</div>
                                                       <div class="col-md-3 col-sm-3 col-xs-12">
								<select class="form-control" id="q2"  onchange='load(1);'>
                                                                    <option value="">LABORATORIOS</option>
                                                                   <?php
    
  
                                                                    $sql3="select distinct des1 from products ORDER BY  `products`.`des1` ASC ";
                                                                    $i=0;
                                                                    $rs2=mysqli_query($con,$sql3);
                                                                    while($row4=mysqli_fetch_array($rs2)){
   
                                                                        $marca=$row4["des1"];
                                                                        ?>
                                                                        <option value="<?php echo $marca;?>"><?php echo $marca;?></option>
                                                                        <?php
                                                                        
                                                                    }
                                                                    ?>
                                                                    
                                                                </select>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<button type="button" class="btn btn-warning" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
                                </form>
                    <a href="descargar.php" target="_blanck"><img src="images/descargar-excel.png" width="80" height="25"></a>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
		
                </div>
            </div>
		 
	</div>
    </div>
</div>

        <?php
          footer();
          
          ?>
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

  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
  <script src="js/pace/pace.min.js"></script>
<script>
$( "#guardar_producto" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_productos").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_productos").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_producto" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var codigo_producto = $("#codigo_producto"+id).val();
			var nombre_producto = $("#nombre_producto"+id).val();
			
			var precio_producto = $("#precio_producto"+id).val();
                        var costo_producto = $("#costo_producto"+id).val();
                        var status = $("#status"+id).val();
                         var monventa = $("#mon_venta"+id).val();   
                        var moncosto = $("#mon_costo"+id).val();
                        var cat_pro = $("#cat"+id).val();
                        var inv = $("#inv"+id).val();
                        var des1 = $("#des1"+id).val();
                       var des2 = $("#des2"+id).val(); 
                        var des3 = $("#des3"+id).val();
                        var dolar = $("#dolar"+id).val();
                        var costo = $("#costo"+id).val();
                        var utilidad = $("#utilidad"+id).val();
                        var precio2 = $("#valor2"+id).val();
                        var precio3 = $("#valor3"+id).val();
                        var und_pro = $("#und_pro"+id).val();
                        var barras = $("#barras"+id).val();
                        
                        var c2 = $("#c2"+id).val();
                        var c3 = $("#c3"+id).val();
                        var p2 = $("#p2"+id).val();
                        var p3 = $("#p3"+id).val();
                         var d2 = $("#d2"+id).val();
                        var d3 = $("#d3"+id).val();
                        var min = $("#min"+id).val();
                        var mon = $("#mon"+id).val();
                        var proveedor = $("#proveedor"+id).val();
                        var tipo7 = $("#tipo7"+id).val();
			$("#mod_id").val(id);
			$("#mod_codigo").val(codigo_producto);
                        $("#tipo7").val(tipo7);
			$("#mod_nombre").val(nombre_producto);
			$("#mod_precio").val(precio_producto);
                        $("#mod_costo").val(costo_producto);
                        $("#mod_status").val(status);
                        $("#mod_monventa").val(monventa);
                        $("#mod_moncosto").val(moncosto);
                        $("#mod_cat").val(cat_pro);
                        
                        $("#c2").val(c2);
                        $("#c3").val(c3);
                        $("#p2").val(p2);
                        $("#p3").val(p3);
                        $("#d2").val(d2);
                        $("#d3").val(d3);
                        $("#mod_inv").val(inv);
                        $("#mod_des1").val(des1);
                        $("#mod_des2").val(des2);
                        $("#mod_des3").val(des3);
                        $("#multiplicando1").val(dolar);
                        $("#proveedor").val(proveedor);
                        $("#soles").val(costo);
                        $("#utilidad").val(utilidad);
                        $("#mod_valor2").val(precio2);
                        $("#mod_valor3").val(precio3);
                        $("#mod_und_pro").val(und_pro);
                        $("#mod_barras").val(barras);
                        $("#mod_min").val(min);
                        $("#mod_mon").val(mon);
		}
function imprimir_barra(id_producto){
			VentanaCentrada('./pdf/documentos/ver_producto.php?id_producto='+id_producto,'Factura','','1024','768','true');
		}
function imprimirproducto(id_producto,cantidad,producto){
    VentanaCentrada('lote.php?id_producto='+id_producto+'&cantidad='+cantidad+'&producto='+producto,'Lote','','1024','768','true')
}

</script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/productos.js"></script>
</body>
</html>
<?php
ob_end_flush(); 
?>







