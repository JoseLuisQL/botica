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
</style>
<?php

	//include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
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
	if (isset($_GET['id'])){
		$id_factura=intval($_GET['id']);
		$del1="UPDATE facturas set activo=0,obs='Eliminado' where id_factura='".$id_factura."'";
                $sql1=mysqli_query($con, "select * from facturas where id_factura='".$id_factura."'");
                $count_query= mysqli_query($con, "SELECT count(*) AS numrows FROM pagos  where id_factura=$id_factura");
		$row2= mysqli_fetch_array($count_query);
		$numrows = $row2['numrows'];
                if($numrows==0){
                while ($row1=mysqli_fetch_array($sql1))
                {
                    $numero_factura=$row1["numero_factura"];
                    $tipo_doc=$row1["estado_factura"];
                    $tienda=$row1["tienda"];
                    $id_cliente=$row1["id_cliente"];
                    $folio=$row1["folio"];
                    $fecha=$row1["fecha_factura"];
                    if($tipo_doc==9){
                        $sig="-";
                        $num=1;
                    }
                    if($tipo_doc==10){
                        $sig="+";
                        $num=2;
                    }
                }
                $sql=mysqli_query($con, "select * from detalle_factura where numero_factura='".$numero_factura."' and ven_com=2 and tienda=$tienda and id_cliente=$id_cliente and tipo_doc=$tipo_doc and folio='$folio' and fecha='$fecha'" );
                while ($row=mysqli_fetch_array($sql))
                {
                    $id_producto=$row["id_producto"];
                    $id_detalle=$row["id_detalle"];    
                    $sql2=mysqli_query($con, "select * from lote1 where id_detalle=$id_detalle " );
                    while ($row2=mysqli_fetch_array($sql2))
                    {
                            $id_lote=$row2["id_lote"];
                            $can_lote=$row2["can_lote"];
                            $lote=mysqli_query($con, "UPDATE lote SET final=final $sig $can_lote WHERE id_lote=$id_lote");
                            
                    }
                    $lote1=mysqli_query($con, "DELETE FROM lote1 where id_detalle=$id_detalle");
                    
                    
                    
                    
                    $tienda=$row["tienda"];
                    $cantidad=$row["cantidad"];
                    $b="b".$tienda;
                    $productos1=mysqli_query($con, "UPDATE products SET $b=$b $sig $cantidad WHERE id_producto=$id_producto");
                    $sql1=mysqli_query($con, "select * from products where id_producto='".$id_producto."'");
                    while ($row1=mysqli_fetch_array($sql1))
                    {
                        $b=$row1["b$tienda"];
                    }
                    if($tipo_doc==9){
                        $c=$b+$cantidad;
                    }else{
                        $c=$b-$cantidad;
                    }
                      
                    $insert=mysqli_query($con,"INSERT INTO detalle_factura VALUES (NULL,'$id_cliente','$usuario','$numero_factura','$num','$id_producto','$cantidad','0','$tienda1','0','1','$fecha1','0','$tipo_doc','$c','1','$folio','0','0','0','0','0')");  
         
                }
                $del2="UPDATE detalle_factura set activo=0 where numero_factura='".$numero_factura."' and ven_com=2 and tienda=$tienda and tipo_doc=$tipo_doc and id_cliente=$id_cliente and folio='$folio' and fecha='$fecha'";
        
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php	
		}
                }else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> .
			</div>
			<?php	
		}
	}
	if($action == 'ajax'){
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
        $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
        
		$sTable = "facturas, users";
		$sWhere = "";
		$sWhere.=" WHERE  facturas.id_vendedor=users.user_id and ven_com=2 and activo=0 and (estado_factura=9 or estado_factura=10) and facturas.tienda=$tienda1";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')>='$q')";	
		}
                if ( $_GET['q1'] != "" )
		{
		$sWhere.= " and  (estado_factura='$q1')";	
		}
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (obs='$q2')";	
		}
		$sWhere.=" order by facturas.id_factura desc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
                //print"$sql";
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;">
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
                                        <th>Nro doc</th>
                                        <th>Tipo</th>
                                	<th>Fecha</th>
					
					<th>Vendedor</th>
					<th>Motivo</th>
					
					<th class='text-right'>Acciones</th>	
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                                $activo=$row['activo'];
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						
                                                $moneda=$row['moneda'];
                                                $mon=moneda;
                                                $estado_factura=$row['estado_factura'];
                                                $motivo=$row['obs'];
                                                
						if($motivo=="Eliminado"){
                                                    $color="#F5D0A9";
                                                }else{
                                                    $color="#A9E2F3";
                                                }
                                                
                                                $deuda=$row['deuda_total']-$row['cuenta1'];
						$nombre_vendedor=$row['nombres'];
						if ($estado_factura==9){$text_estado="Entrada Productos";$label_class='label-success';}
						else{$text_estado="Salida  Productos";$label_class='label-warning';}
						$total_venta=$row['total_venta'];    
					?>
					<tr id="valor1" style="background:<?php echo $color;?>;">
						<td><?php echo $numero_factura; ?></td>
                                                <td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td><?php echo $fecha; ?></td>
						
						<td><?php echo $nombre_vendedor; ?></td>
						<td><?php echo $motivo; ?></td>
						
                                                <td class="text-right">
                                                    
                                                    <a href="#" class='btn btn-primary btn-xs' title='Descargar guia' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                   <?php  
                                                if ($a[8]>0 && $motivo<>"Eliminado"){
                                                    //?>
                                                    <a href="#" class='btn btn-danger btn-xs' title='Borrar documento' onclick="eliminar('<?php echo $id_factura; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
                                                <?php
                                                }   
                                                ?>
                                                   
                                                </td>
						
					</tr>
					<?php
                                        $numrows=$numrows-1;
                                }
				?>
				<tr style="background:white;">
					<td colspan=10><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
        }
	
?>
