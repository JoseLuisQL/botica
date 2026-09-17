<?php
include('is_logged.php');
?>
<style>
table tr:nth-child(odd) {background-color: #FBF8EF;}
table tr:nth-child(even) {background-color: #EFFBF5;}
 #valor1 {
border-bottom: 2px solid #F5ECCE;
} 
#valor1:hover {             
background-color: white;
border-bottom: 2px solid #A9E2F3
} 
</style>

<?php

	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
        $usuario=$_SESSION['user_id'];
        date_default_timezone_set('America/Lima');
        $fecha1  = date("Y-m-d H:i:s");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
                $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
                $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
                $q3 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q3'], ENT_QUOTES)));
                $q4 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q4'], ENT_QUOTES)));
		$sTable = "facturas, clientes, users";
		$sWhere = "";
		$sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and (facturas.estado_factura<=2 or facturas.estado_factura=5 or facturas.estado_factura=6)and facturas.id_vendedor=users.user_id and facturas.ven_com=1 and facturas.activo=1 and facturas.numero_factura>0";
                 if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' )";
		}
                if ( $_GET['q1'] != "" )
		{
		$sWhere.= " and  (facturas.numero_factura like '%$q1%' )";
		}
                
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')>='$q2' )";
		}
                if ( $_GET['q3'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')<='$q3' )";
		}
                if ( $_GET['q4'] != "" )
		{
		$sWhere.= " and  (estado_factura='$q4')";
		}
		$sWhere.=" order by facturas.id_factura desc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
                //$page = (isset($_SESSION['page']) && !empty($_SESSION['page']))?$_SESSION['page']:$page;
		$per_page = 40; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
                $sql1="SELECT * FROM sucursal where tienda=$tienda1";
		$query1 = mysqli_query($con, $sql1);
                $row1=mysqli_fetch_array($query1);
                $ruc1=$row1['ruc'];
          	$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;">
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
					<th>Nro Doc</th>
                                        <th class='text-right'>Tipo de Doc</th>
                                        <th>Fecha</th>
					<th>Cliente</th>
					<th class='text-right'>Total</th>
                                        <th class='text-right'>Hora envio a Sunat</th>
                                        <th class='text-right'>Desc<br>XML</th>
                                        <th class='text-right'><img src="ajax/sunat.png" width="25" height="25">Enviar</th>
					<th class='text-right'>Respuesta<br>Sunat(CDR)</th>
                                        <th class='text-right'>PDF</th>
                                        <th class='text-right'>Ticket</th>
                                        <th class='text-right'>Enviar <br>correo</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                               $activo=$row['activo'];
						if ($activo==1){
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
                                                $ruc=$row['doc'];
						$email_cliente=$row['email_cliente'];
                                                $folio=$row['folio'];
                                                $dni=$row['dni'];
                                                
						$nombre_vendedor=$row['nombres'];
                                                $resumen=$row['resumen'];
                                               
                                                
                                                $tip=0;
                                                $estado_factura1=$row['estado_factura'];
                                                if($estado_factura1==1){
                                                    $tip="01";
                                                }
                                                if($estado_factura1==2){
                                                    $tip="03";
                                                }
                                                if($estado_factura1==6){
                                                    $tip="07";
                                                }
                                                if($estado_factura1==5){
                                                    $tip="08";
                                                }
                                                $numero_factura1=str_pad($numero_factura, 8, "0", STR_PAD_LEFT);
                                                $doc1="$ruc1-$tip-$folio-$numero_factura1.XML";
                                                
                                                $doc2="$ruc1-$tip-$folio-$numero_factura1";
                                                
                                                $doc3="R-$ruc1-$tip-$folio-$numero_factura1.XML";
                                                $aceptado1="No enviado";
                                                
                                                
                                                $fecha3="";
                                                $fecha4="";
                                                 if($resumen==1){
                                                   $fecha3="<font color=red>Enviado resumen</font>"; 
                                                   $fecha4="Enviado resumen"; 
                                                }
                                                $pos="";
                                                $hora3="";
                                                if (file_exists('../pdf/documentos/cdr/'.$doc3.'')) {
                                                    $xml = file_get_contents('../pdf/documentos/cdr/'.$doc3.'');
                                                    #== Obteniendo datos del archivo .XML 
                                                    $aceptado="";
                                                    $DOM = new DOMDocument('1.0', 'ISO-8859-1');
                                                    $DOM->preserveWhiteSpace = FALSE;
                                                    $DOM->loadXML($xml);
                                                    ### DATOS DE LA FACTURA ####################################################
                                                    // Obteniendo RUC.
                                                    $DocXML = $DOM->getElementsByTagName('Description');
                                                    foreach($DocXML as $Nodo){
                                                        $aceptado = $Nodo->nodeValue; 
                                                    }  
                                                    $DocXML = $DOM->getElementsByTagName('ResponseDate');
                                                    foreach($DocXML as $Nodo){
                                                        $fecha3 = $Nodo->nodeValue; 
                                                    }
                                                    $DocXML = $DOM->getElementsByTagName('ResponseTime');
                                                    foreach($DocXML as $Nodo){
                                                    $hora3 = $Nodo->nodeValue; 
                                                    }
                                                    $fecha3=date("d/m/Y", strtotime($fecha3));
                                                    $fecha4=date("d/m/Y", strtotime($fecha3));
                                                    $pos = strpos($aceptado, "aceptada");
                                                    if ($pos === false) {
                                                        $aceptado1= "No aceptada";
                                                    } else {
                                                    $aceptado1= "Aceptada";
   
                                                    }
						 }
                                                 if($row['aceptado']=="Aceptada"){
                                                    $aceptado1= "Aceptada"; 
                                                 }
                                                 //print"$aceptado1";
                                                 if($fecha3=="" and $aceptado1=="Aceptada"){
                                                     $fecha3=$row['obs'];
                                                 }
                                                $estado_factura=$row['condiciones'];
                                                $ven_com=$row['ven_com'];
                                                $moneda=$row['moneda'];
                                                $mon=moneda;
                                                if($estado_factura1==1){
                                                    $estado1="Factura";
                                                    
                                                }
                                                if($estado_factura1==2){
                                                    $estado1="Boleta";    
                                                }
                                                if($estado_factura1==3){
                                                    $estado1=doc;   
                                                }
                                                if($estado_factura1==5){
                                                    $estado1="Nota de Debito"; 
                                                }
                                                if($estado_factura1==6){
                                                    $estado1="Nota de Credito";    
                                                }
                                                if($estado_factura==1){
                                                    $estado2="Efectivo"; 
                                                }
                                                if($estado_factura==2){
                                                    $estado2="Cheque";
                                                }
                                                if($estado_factura==3){
                                                    $estado2="Transf Bancaria"; 
                                                }
                                                if($estado_factura==4){
                                                    $estado2="Crédito";
                                                }
                                                if($estado_factura==5){
                                                    $estado2="Tarjeta";
                                                }
                                                $deuda=$row['deuda_total'];
                                                $servicio=$row['servicio'];
                                                $sql1="SELECT * FROM  servicio;";
                                                $query1 = mysqli_query($con, $sql1);
                                                while ($row1=mysqli_fetch_array($query1)){
                                                  if($row1['doc_servicio']==$numero_factura && $row1['tip_doc']==$estado_factura1)  {
                                                     $guia=$row1['guia'];
                                                    }
                                                }
                                                if ($servicio==0){$text_estado1="Productos";$label_class1='label-success';}
						else{$text_estado1="Servicios";$label_class1='label-warning';}
                                                
						if ($deuda==0){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
						$total_venta=$row['total_venta'];
					?>
					<tr id="valor1">
                                                <td><?php echo $folio; ?>-<?php echo $numero_factura; ?></td>
                                                <td><?php echo $estado1; ?></td>
                                                <td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_cliente;?></td>   
                        			<td class='text-right'><?php print"$mon"; echo number_format ($total_venta,2); ?></td>					
                                                <td class='text-right'><font color='black'><strong><?php print"$fecha3&nbsp;&nbsp;"; echo $hora3; ?></strong></font></td>
						<td class="text-right">
                                                    <?php
                                                    if($aceptado1=="No enviado"){
                                                    ?>
                                                    <a href="#" class='btn btn-primary btn-xs' title='Descargar xml' onclick="imprimir_factura('<?php echo $doc1;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                    <?php
                                                    }
                                                    if($aceptado1<>"No enviado"){
                                                        ?>
                                                    <a href="#" class='btn btn-primary btn-xs' title='Descargar xml' onclick="imprimir_factura2('<?php echo $doc1;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                            <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    //print"$pos 2";
                                                    if ($pos =="") {
                                                        ?>
                                                    <a href="#" class='btn btn-warning btn-xs' title='Enviar sunat' onclick="enviar('<?php echo $doc2;?>','<?php echo $page;?>');"><i class="glyphicon glyphicon-download">Enviar</i></a> 
						 
                                                            <?php
                                                    }else{
                                                        ?>
                                                    <a class='btn btn-info btn-xs'><i class="glyphicon glyphicon-download">Enviado</i></a> 
						 
                                                            <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    if($folio<>"" and ($estado_factura1<=2 or $estado_factura1==5 or $estado_factura1==6)){
                                                    ?>
                                                    <a href="#" class='btn btn-danger btn-xs' title='Descargar CDR' onclick="imprimir_factura1('<?php echo $doc3;?>');"><?php echo $aceptado1;?></a> 
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                
                                                   <?php 
                                                   if($estado_factura1==1 or $estado_factura1==2){
                                                       ?>
                                                        <a href="#" class='btn btn-primary btn-xs' title='Descargar PDF' onclick="imprimir_facturas2('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                                    <?php
                                                   }else{
                                                       ?>
                                                       <a href="#" class='btn btn-primary btn-xs' title='Descargar PDF' onclick="imprimir_facturas2('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                                     
                                                    <?php
                                                       }
                                                       ?>
                                                <td>
                                                <a href="#" class='btn btn-primary btn-xs' title='Descargar Ticket' onclick="imprimir_facturas3('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                                </td>
                                                <td>
                                                       <a href="#" class='btn btn-success btn-xs' title='Enviar correo' onclick="enviar_correo('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a>   
                                                </td>
					</tr>
					<?php
                                        $numrows=$numrows-1;
                                        
				}
                            }
                            ?>
                            <tr style="background:white;">
					<td colspan=13><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
                            </tr>
			</table>
                    </div>
                    <?php
		}
            }
	
?>

