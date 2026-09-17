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
border-bottom: 2px solid #A9E2F3;
}
</style>
<style type="text/css">
   .thumbnail1{
position: relative;
z-index: 0;
}
.thumbnail1:hover{
background-color: transparent;
z-index: 50;
}
.thumbnail1 span{ /*Estilos del borde y texto*/
position: absolute;
background-color: white;
padding: 5px;
left: -100px;

visibility: hidden;
color: #FFFF00;
text-decoration: none;
}
.thumbnail1 span img{ /*CSS for enlarged image*/
border-width: 0;
padding: 2px;
}
.thumbnail1:hover span{ /*CSS for enlarged image on hover*/
visibility: visible;
top: 17px;
left: 40px; /*position where enlarged image should offset horizontally */
} 

img.imagen2{
padding:4px;
border:3px #0489B1 solid;
margin-left: 2px;
margin-right:5px;
margin-top: 5px;
float:left;

}

table tr:nth-child(odd) {background-color: #F5F6CE;}

table tr:nth-child(even) {background-color: #CEF6E3;}
 #valor1:hover {
              
background-color: white;
border-bottom: 2px solid #A9E2F3;

}  
#valor2:hover {
              
background-color: white;
border-bottom: 2px solid #A9E2F3;

} 
#valor1 {            
background-color: #FBF8EF;
border-bottom: 2px solid #F5ECCE;
}  
#valor2 {             
background-color: #EFFBF5;
border-bottom: 2px solid #F5ECCE;
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
tfoot {
    display: table-header-group;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: none;
  color: black!important;
  border-radius: 4px;
  border: 1px solid #828282;
}
 
.dataTables_wrapper .dataTables_paginate .paginate_button:active {
  background: none;
  color: black!important;
}

</style>
<?php
	//include('is_logged.php');
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
		$sTable = "facturas, clientes, users";
		$sWhere = "";
		$sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and facturas.id_vendedor=users.user_id and facturas.ven_com=1 and facturas.estado_factura<8 and facturas.activo=0 and facturas.numero_factura>0";
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
		$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$q2' )";
		}
		$sWhere.=" order by facturas.id_factura desc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
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
                                        <th class='text-right'>Deuda</th>
                                        <th>Vendedor</th>
                                        <th>Ticket</th>
                                        <th class='text-center'>Mensaje</th>
                                        <th class='text-right'>XML</th>
                                        <th class='text-right'>CDR</th>
                                        
                                        <th class='text-right'>PDF</th>	
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                                $activo=$row['activo'];
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
                                                $ruc=$row['doc'];
						$email_cliente=$row['email_cliente'];
                                                $baja=$row['baja'];
                                                $dni=$row['dni'];
                                                $folio=$row['folio'];
						$nombre_vendedor=$row['nombres'];
                                                $estado_factura1=$row['estado_factura'];
						$estado_factura=$row['condiciones'];
                                                $ven_com=$row['ven_com'];
                                                $moneda=$row['moneda'];
                                                $aceptado=$row['aceptado'];
                                                $pos = strpos($aceptado, "aceptada");
                                                if ($pos === false) {
                                                        $aceptado1= "No enviado";
                                                }else{
                                                    $aceptado1= "Aceptada";
   
                                                }
                                                
                                                $mon="S/.";
                                                if($estado_factura1==1){
                                                    $estado1="Factura";
                                                    
                                                }
                                                if($estado_factura1==2){
                                                    $estado1="Boleta";  
                                                }
                                                if($estado_factura1==3){
                                                    $estado1=doc;  
                                                }
                                                
                                                $deuda=$row['deuda_total'];
                                               
                                               
                                                $ticket="";
                                                $sql1="SELECT * FROM  baja_sunat Where id_doc1=$id_factura";
                                                $query1 = mysqli_query($con, $sql1);
                                                while ($row1=mysqli_fetch_array($query1)){
                                                    $ticket=$row1['ticket'];
                                       
                                                }
                                                $xml=$baja.".XML";
						$cdr="R-".$baja.".XML";
						$total_venta=$row['total_venta'];
					?>
					<tr id="valor1">
                                           
						<td><?php print"$folio $numero_factura"; ?></td>
                                                <td><?php echo $estado1; ?></td>
                                                <td><?php echo $fecha; ?></td>
						<td ><?php echo $nombre_cliente;?></td>   
                                                <td class='text-right'><?php print"$mon"; echo number_format ($total_venta,2); ?></td>					
                                                <td class='text-right'><?php print"$mon"; echo number_format ($deuda,2); ?></td>
                                                <td><?php echo $nombre_vendedor; ?></td>
                                                <td><?php echo $ticket; ?></td>
                                                <td class="text-right">
						   
                                                  <?php
                                                  //print"$estado_factura1 $baja $aceptado1";
                                                  if($estado_factura1==1 && $baja=="0" ){
                                                       ?>
                                                   <a href="#" class='btn btn-danger btn-xs' title='Enviar doc de baja' onclick="imprimir_facturas1('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download">Enviar</i></a> 
						  <?php 
                                                  }else{
                                                      if($estado_factura1==1){
                                                          print"<font color=blue><strong>Enviado y aceptado</strong></font>";
                                                      }else{
                                                          print"<font color=black><strong>Enviar en resumen</strong></font>";
                                                      }
                                                      
                                                  }
                                                  
                                                  ?>    
                                                </td>
                                                <td>
                                                    <?php
                                                    if($estado_factura1<=2 && $baja<>"0" ){
                                                       ?>
                                                    <a href="#" class='btn btn-info btn-xs' title='XML' onclick="xml('<?php echo $xml;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                                    
                                                    <?php 
                                                    }
                                                    ?> 
                                                </td>
                                                 <td>
                                                    <?php
                                                    if($estado_factura1<=2 && $baja<>"0" ){
                                                       ?>
                                                   
                                                     <a href="#" class='btn btn-success btn-xs' title='CDR' onclick="cdrxml('<?php echo $cdr;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                                    <?php 
                                                    }
                                                    ?> 
                                                </td>
                                                
						
                                                <td class="text-right">
                                                    <a href="#" class='btn btn-primary btn-xs' title='Descargar doc' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						 
                                                </td>    
					</tr>
					<?php
                                        $numrows=$numrows-1;

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

