<?php
include('is_logged.php');
?>
<head>
    <link href="css/select2.css" rel = "stylesheet" />  
    <script>
        $(document).ready(function() { $("#valor").select2(); });
    </script>
<style>
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
</head>
<?php
	$tienda=$_SESSION["tienda"];
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
            $numero_factura=intval($_GET['id']);
            $del1="UPDATE facturas set activo=0, deuda_total=0 where numero_factura='".$numero_factura."' and ven_com=1";
            $del2="UPDATE detalle_factura set activo=0 where numero_factura='".$numero_factura."' and ven_com=1";
            $sql=mysqli_query($con, "select * from detalle_factura where numero_factura='".$numero_factura."'");
            while ($row=mysqli_fetch_array($sql))
            {
                $id_producto=$row["id_producto"];
                $tienda=$row["tienda"];
                $cantidad=$row["cantidad"];
                $b="b".$tienda;
                $productos1=mysqli_query($con, "UPDATE products SET $b=$b+$cantidad WHERE id_producto=$id_producto and pro_ser=1");
            }
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
	}
	if($action == 'ajax'){
		$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
                $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
                $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
                $q3 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q3'], ENT_QUOTES)));
                $sTable = "detalle_factura, products,users,transferencia";
		$sWhere = "";
		$sWhere.=" WHERE detalle_factura.id_detalle=transferencia.id_detalle and detalle_factura.id_producto=products.id_producto and users.user_id=detalle_factura.precio_compra";
                if ( $_GET['q'] != "" )
		{
			$sWhere.=" and products.nombre_producto LIKE '%".$q."%'";
			
		}
                if ( $_GET['q1'] != "" )
		{
			$sWhere.=" and DATE_FORMAT(detalle_factura.fecha, '%Y-%m-%d')>='$q1'";
			
		}
                if ( $_GET['q3'] != "" )
		{
			$sWhere.=" and numero_factura='$q3'";
			
		}
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(detalle_factura.fecha, '%Y-%m-%d')<='$q2')";
		}
                $sWhere.=" order by detalle_factura.id_detalle desc";
                
                
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './transferencias1.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
                    echo mysqli_error($con);
                    ?>
                    <div class="table-responsive">
			<table id="example" class="display nowrap" style="width:100%;color:black;">
                            
                            <thead>
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
                                    
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Numero</th>
                                    <th>Producto</th>
                                    <th>Vendedor</th>
                                    <th>Cantidad</th>
                                    <th>Sucursal</th>
                                    <th>Motivo</th>
                                    <th>Tipo</th>
                                </tr>
                                </thead>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                        $producto=$row['nombre_producto'];
                                        $numero_factura=$row['numero_factura'];
                                        $folio=$row['folio'];
                                        $fecha=date("d/m/Y", strtotime($row['fecha']));
                                        $fecha1=date("H:i", strtotime($row['fecha']));
                                        $cantidad=$row['cantidad'];
                                        $tienda=$row['tienda'];
                                        $motivo=$row['motivo'];
                                        $ven_com=$row['ven_com'];
                                        $vendedor=$row['nombres'];
                                        if ($ven_com==1){$text_estado1="Salida";$label_class1='label-success';}
					else{$text_estado1="Entrada";$label_class1='label-warning';}
                                        ?>
					<tr id="valor1">
						
						<td><?php echo $fecha; ?></td>
                                                <td><?php echo $fecha1; ?></td>
                                                <td><?php print"$folio-$numero_factura"; ?></td>
						<td><?php echo $producto; ?></td>
						<td><?php echo $vendedor; ?></td>
                                                <td><?php echo $cantidad; ?></td>
                                                <td><?php echo $tienda; ?></td>
                                                <td><?php echo $motivo; ?></td>
                                                <td><?php echo $text_estado1; ?></td>
                                        </tr>
					<?php
                                        
                                }
				?>
                          <tr>
					<td colspan=9><span class="pull-right"><?PHP
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>              
			  </table>
                    </div>
		<?php
	}
}
	
?>

 
    

    
  