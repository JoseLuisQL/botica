








<?php
require_once ("config/db.php");
$db_db=DB_NAME;
$db_products = $db_db.'.products';  
$db_clientes = $db_db.'.clientes';
$db_users = $db_db.'.users';
$db_facturas = $db_db.'.facturas';
$db_categorias= $db_db.'.categorias';
$db_datosempresa = $db_db.'.datosempresa';
$db_sucursal= $db_db.'.sucursal';
$db_detalle_factura= $db_db.'.detalle_factura';
$db_documento = $db_db.'.documento';
$db_comprobante_pago= $db_db.'.comprobante_pago';
$db_sub_tipo= $db_db.'.sub_tipo';
$db_servicio= $db_db.'.servicio';
$db_consultas= $db_db.'.consultas';
$db_laborales= $db_db.'.laborales';
$db_fotos= $db_db.'.fotos';
$db_documento = $db_db.'.documento';
function conectar2()
{ 
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
    if (!$db) {
        print "<p>Imposible conectarse con la base de datos.</p>";
        exit();
    } else {
        return($db);
    }
}
function recoge1($var)
{
    $tmp = (isset($_REQUEST[$var])) ? trim(strip_tags($_REQUEST[$var])) : '';
    if (get_magic_quotes_gpc()) {
        $tmp = stripslashes($tmp);
    }
    $tmp = str_replace('&', '&amp;',  $tmp);
    $tmp = str_replace('"', '&quot;', $tmp);
    $tmp = str_replace('í', '&iacute;', $tmp);
    return $tmp;
}
function menu1(){
    ?>
    
    
           <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" >

            <div class="menu_section" >
               <h3>General</h3>
              <ul class="nav side-menu" >

                <li><a href="dashboard.php"><i class="fa fa-tachometer"></i> Dashboard </a>
                    
                </li>


                 <li><a><i class="fa fa-home"></i> Empresa <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="empresa.php">Empresa</a>
                    </li>
                    <li><a href="resumen.php">Resumen</a>
                    </li>
                    <li><a href="sucursal.php">Sucursales</a>
                    </li>
                    <li><a href="caja.php">Caja</a>
                    </li>
                    
                    
                  </ul>
                </li>
                
                <li><a><i class="fa fa-lock"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                       <li><a href="usuarios.php">Usuarios</a>
                    </li>
                      <li><a href="acceso.php">Accesos</a>
                    </li>
                 
                  </ul>
                </li>
                
                <li><a><i class="fa fa-barcode"></i><font color="#00c2ff">Productos y Servicios</font><span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="categorias.php">Categorias</a>
                    </li>
                    <li><a href="ingresoproductos.php">Ingresar Productos</a>
                    </li>
                    <li><a href="productos.php">Lista de Productos</a>
                    </li>
                    <li><a href="listalotes.php">Lista de Lotes</a>
                    </li>
                     <li><a href="servicio.php">Lista de Servicios</a>
                    </li>
                    <li><a href="kardex.php">Kardex de Productos</a>
                    </li>
                     <li><a href="kardex2.php">Entradas y Salidas Productos</a>
                    </li>
                    
                    <li><a href="transferencia4.php">Transferencia</a>
                    </li>
                    <li><a href="transferencia1.php">Lista de Transferencias</a>
                    </li>
                    
                    
                    <li><a href="consultaproductos.php">Consultas</a>
                    </li>
                     <li><a href="masvendidos.php">Productos mas vendidos</a>
                    </li>
                    
                    <li><a href="consultaprecios.php">Consulta Precios</a>
                    </li>
                    
                    
                  </ul>
                </li>
                
                <li><a><i class="fa fa-truck"></i> Proveedores <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="proveedores.php">Proveedores</a>
                    </li>
                    
                    
                  </ul>
                </li>
                
                
                
                
                <li><a><i class="fa fa-user"></i> Clientes <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      
                      <li><a href="clientes.php">Clientes</a>
                    </li>
                   
                  </ul>
                </li>
                <li><a><i class="fa fa-list-alt"></i><font color="#00c2ff">Ventas Productos</font> <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="documentos.php">Conf Documentos</a></li>    
                    <li><a href="nueva_factura.php">Ingreso Fact/Bol/Nota</a></li>
                    <li><a href="nueva_nota.php">Ingreso Nota de debito y credito</a></li>
                    <!--<li><a href="nueva_conv.php">Conv a Fac/Bol</a></li>-->
                    <li><a href="facturas.php">Lista de Ventas Fac/Bol/Nota</a></li>
                     <li><a href="cotizacion.php">Lista de Cotizacion</a></li>
                    <li><a href="credito-debito.php">Lista de Notas de credito/debito </a></li>
                   
                   
                     <li><a href="cobros.php">Ventas por Cobrar</a></li>
                     
                     
                    </li>
                  </ul>
                </li>
                
                <li><a><i class="fa fa-list-alt"></i><font color="#00c2ff">Facturación electrónica</font><span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                     <li><a href="conf_electronica.php"><strong>Configuracion</strong> </a></li>
                    <li><a href="facturaelectronica.php">Documentos electrónicos </a></li>
                     <li><a href="contabilidad.php">Calculo del IGV</a></li>
                    <li><a href="resumen_documentos.php">Lista Resumen diario boletas</a></li>
                    <li><a href="facturaseliminadas.php"><strong>Lista Comunicacion de baja</strong></a></li>
                    
                    <li><a href="listaguia.php">Lista de Guias de Remision </a></li>
                   
                       
                     
                    </li>
                  </ul>
                </li>
                
                
                <li><a><i class="fa fa-shopping-cart"></i> Compras <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    
                      <li><a href="nueva_compras.php">Compras Fact/Bol</a></li>
                          
                    
                    <li><a href="compras.php">Lista de Compras</a></li>
                    <li><a href="compras-eliminadas.php">Compras Eliminadas</a></li>
                    <li><a href="pagos.php">Compras por Pagar</a></li>
                     
                   
                    </li>
                  </ul>
                </li>
                 <li><a><i class="fa fa-barcode"></i> Ent/sal mercaderia <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                     <li><a href="nueva_entsal.php">Guia Entradas/Salidas</a>
                    </li>
                    <li><a href="listaguias.php">Lista Guias</a>
                    </li>
                    
                   
                  </ul>
                </li>
                
                <li><a><i class="fa fa-building"></i> Balance y Rentabilidad <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="consulta14.php">Análisis de Rentabilidad</a></li>
                    <li><a href="balance2.php">Balance Entradas/Salidas</a></li>
                    
                      <li><a href="balance.php">Balance Ventas/Compras</a></li>
                      
               
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-money"></i> Tesoreria <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                   
                      <li><a href="otrospagos.php">Tesoreria</a></li>     
                      <li><a href="estadistica8.php">Reporte Tesoreria</a></li> 
                    </li>
                  </ul>
                </li>
                
                <li><a><i class="fa fa-group"></i> Planilla <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                   
                      <li><a href="planilla.php">Planilla</a></li>     
                      <li><a href="estadistica9.php">Reporte Planilla</a></li> 
                    </li>
                  </ul>
                </li>
                
                
                <li><a><i class="fa fa-line-chart"></i> Reportes<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    <li><a href="resumen2.php">Resumen</a>
                          
                    </li>
                    <li><a href="estadistica2.php">Ventas/Compras diario</a>
                          
                    </li>
                   <li><a href="estadistica3.php">Ventas/Compras mensual</a>
                          
                    </li>
                    <li><a href="estadistica4.php">Ventas-Compras-Diferencia diario</a>
                          
                    </li>
                     <li><a href="estadistica5.php">Ventas-Compras-Diferencia Mensual</a>
                          
                    </li>
                     <li><a href="estadistica6.php">Ventas-Costo-Utilidad diario</a>
                          
                    </li>
                     <li><a href="estadistica7.php">Ventas-Costo-Utilidad Mensual</a>
                          
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-line-chart"></i> Reporte de Ventas<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    
                    <li><a href="consulta5.php">Ventas por vendedor mensual/anual</a>
                          
                    </li>
                    <li><a href="consulta11.php">Ventas por vendedor diario</a>
                          
                    </li>
                    <li><a href="consulta111.php">Comision por vendedor</a>
                          
                    </li>
                     <li><a href="consulta1.php">Ventas por cliente mensual/anual</a>
                    </li> 
                    <li><a href="consulta7.php">Ventas por cliente diario</a>
                    </li>
                     <li><a href="consulta2.php">Ventas por producto mensual/anual</a>
                    </li> 
                    <li><a href="consulta8.php">Ventas por producto diario</a>
                    </li>
                    
                  
                  </ul>
                </li>
                
                
                 <li><a><i class="fa fa-bar-chart"></i> Reporte de Compras <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    
                      
                    <li><a href="consulta6.php">Compras por Vendedor mensual/anual</a></li>
                     <li><a href="consulta12.php">Compras por Vendedor diario</a></li>
                    <li><a href="consulta3.php">Compras por Proveedor mensual/anual</a></li>
                    <li><a href="consulta9.php">Compras por Proveedor diario</a></li>
                    
                      <li><a href="consulta4.php">Compras por producto mensual/anual</a>
                    </li> 
                    <li><a href="consulta10.php">Compras por producto diario</a>
                    </li>
                   
                  </ul>
                </li>
                 <li><a><i class="fa fa-calculator"></i> Contabilidad y Otros<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    
                       <li><a href="productos1.php">Valorizacion</a></li>
                     
                      <li><a href="kardex_valorizado.php">Kardex valorizado</a></li>
                    
                  </ul>
                </li>
               
                
              </ul>
            </div>
            

          </div>
            <?php
}



function menu2(){
    ?>

 



    <div class="profile">
            <?php  
            $db_db=DB_NAME;
            $db_users = $db_db.'.users';
            $db = conectar2();
            $consulta1 = "SELECT * FROM $db_users ";
            $result1 = mysqli_query($db, $consulta1);
            while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                if($valor1['user_id']==$_SESSION['user_id']){
                    $name=$valor1['nombres'];  
                    $foto=$valor1['foto'];
                }    
            } 
            ?>
            <div class="profile_pic">
            <img src="images/<?php echo $foto;?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenido</span>
              
              <h2><?php echo $name;   ?></h2>
            </div>
    </div>
    <?php
}




function menu3(){
    ?>











    <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"  data-toggle="collapse"><i class="fa fa-bars"></i></a>
            </div>

            <?php
            $host= $_SERVER["HTTP_HOST"];
            $url= $_SERVER["REQUEST_URI"];
            $a="http://".$host.$url;
            ?>                     
            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/tienda1.jpg" alt=""><!-- Sucursal <?php //echo $_SESSION['tienda']; ?> -->
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">   
                <?php
                $db_db=DB_NAME;
                $db_sucursal = $db_db.'.sucursal';
                $db = conectar2();
                $consulta1 = "SELECT * FROM $db_sucursal ";
                $result1 = mysqli_query($db, $consulta1);
                while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                    $tienda=$valor1['tienda'];    
  
                }
                ?> 
                <?php
                for($i = 1 ;$i<=$tienda;$i++){
                ?> 
                <li><a href="tienda.php?t=<?php echo $i;?>&a=<?php echo $a;?>"> Sucursal  <?php echo $i;?>  </a>
                </li>
                <?php
                }
                ?>
                <li><a href="salir.php">Salir</a></li>
                </ul>
              </li>



              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bell"></i>
                                      
                  <span class="badge bg-red">0</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                  <li>
                        <a href="#">
                      
                        <span class="message">
                        Tienes <font color="red" size="4"><strong>0</strong></font> nuevos clientes registrados
                        </span>
                        </a>
                  </li>
                  <li>
                   <a href="#">
                      
                        <span class="message">
                        Tienes <font color="red" size="4"><strong>0</strong></font> nuevas ventas registrados
                        </span>
                    </a>
                  </li>
                
                 
                </ul>
              </li>


              <script>

                function launchFullScreen(element) {
                  if(element.requestFullScreen) {
                    element.requestFullScreen();
                  } else if(element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                  } else if(element.webkitRequestFullScreen) {
                    element.webkitRequestFullScreen();
                  }
                }

              </script>


<!DOCTYPE html>
<html lang="en">

<head>

<link rel="shortcut icon" type="image/x-icon" href="img/logo_e.png" />

<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

</head>







              <li id="a" role="presentation" class="dropdown">
                <a onclick="launchFullScreen(document.documentElement);">
                  <i class="fa fa-expand"></i>
                </a>
              </li>

                <style>  
                @media all and (max-width: 1250px){
                #a{
        
                display: none;
                } 
      
                }
                </style>




             

              <!-- <li id="a" role="presentation" class="dropdown">
                  <a href="caja.php">

                    <button type="button" class="miboton btn-animado animacion-cuatro color-instagram">
                    <i class="fad fa-hotel"></i>
                              <span class="tex-icono">
                              CAJA
                              </span>
                    </button>
                  </a>
                    
              </li> -->


              <li id="a" role="presentation" class="dropdown">
                  <a href="facturaelectronica.php">

                    <button type="button" class="miboton btn-animado animacion-cuatro color-instagram">
                    <i class="fas fa-caret-circle-right"></i>
                              <span class="tex-icono">
                              SUNAT
                              </span>
                    </button>
                  </a>
                    
              </li>

              


              <li id="a" role="presentation" class="dropdown">
                  <a href="facturas.php">

                    <button type="button" class="miboton miboton btn-animado animacion-cuatro color-instagram">
                    <i class="fas fa-list-alt"></i>
                              <span class="tex-icono">
                              LISTA VENTAS
                              </span>
                    </button>
                  </a>
                    
              </li>

                

              <li id="a" role="presentation" class="dropdown">
                  <a href="nueva_factura.php">

                    <button type="button" class="miboton btn-animado animacion-cuatro color-instagram">
                          <i class="fas fa-file-invoice"></i>
                              <span class="tex-icono">
                              VENTAS
                              </span>
                    </button>
                  </a>
                    
              </li>

              

               
            </ul>
              
              
        </nav>
    </div>

</div>



<?php
}





function footer(){
    ?>
<footer class="main-footer">
          
    
    
          <div class="float-right d-none d-sm-block">
                
              
            <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="">ApiTec</a>.</strong> Todos los derechos
            reservados.
          </div>
          <div class="clearfix"></div>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>

<?php 

}
?>




