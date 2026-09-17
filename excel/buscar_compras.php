<?php
include('../ajax/is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

	header("Content-type: application/vnd.ms-excel" ) ; 
        header("Content-Disposition: attachment; filename=reporte_compras.xls" ) ; 
	$tienda1=$_SESSION['tienda'];
        $usuario=$_SESSION['user_id'];
        $sql1="select * from users where user_id=$_SESSION[user_id]";
        $rw1=mysqli_query($con,$sql1);//recuperando el registro
        $rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
        $modulo=$rs1["accesos"];
        $a = explode(".", $modulo);
        date_default_timezone_set('America/Lima');
        $fecha1  = date("Y-m-d H:i:s");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	//if($action == 'ajax'){
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$sTable = "facturas, clientes, users";
		$sWhere = "";
		$sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id and ven_com=2 and activo=1 and facturas.tienda=$tienda1";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or facturas.numero_factura like '%$q%')";	
		}
		$sWhere.=" order by facturas.id_factura desc";
		//include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		$sql="SELECT * FROM  $sTable $sWhere ";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;">
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
                                        <th>Nro doc</th>
                                        <th>Tipo de Doc</th>
                                	<th>Fecha</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<th>Estado</th>
					<th class='text-right'>Total</th>
                                        <th class='text-right'>Deuda</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                                $activo=$row['activo'];
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
                                                $moneda=$row['moneda'];
                                                $mon=moneda;
                                                $estado_factura=$row['estado_factura'];
                                                if($estado_factura==1){
                                                    $estado1="Factura";   
                                                }
                                                if($estado_factura==2){
                                                    $estado1="Boleta"; 
                                                }
                                                if($estado_factura==3){
                                                    $estado1=doc; 
                                                }
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
                                                $ruc=$row['doc'];
                                                
                                                $deuda=$row['deuda_total']-$row['cuenta1'];
						$nombre_vendedor=$row['nombres'];
						if ($deuda==0){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Credito";$label_class='label-warning';}
						$total_venta=$row['total_venta'];    
					?>
					<tr id="valor1">
						<td><?php echo $numero_factura; ?></td>
                                                <td><?php echo $estado1; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_cliente;?></td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>
                                                <td class='text-right'><?php echo number_format ($deuda,2); ?></td>
                                                
						
					</tr>
					<?php
                                        $numrows=$numrows-1;
                                }
				?>
				
			  </table>
			</div>
			<?php
		}
        //}
	
?>
