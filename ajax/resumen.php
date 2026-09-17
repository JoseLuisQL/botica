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
left: 60px; /*position where enlarged image should offset horizontally */
} 
img.imagen2{
padding:4px;
border:3px #0489B1 solid;
margin-left: 2px;
margin-right:5px;
margin-top: 5px;
float:left;

}
</style>
<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
        $tienda1=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		
		$sTable = "facturas";
                $sWhere = "";
		$sWhere.=" WHERE  facturas.aceptado<>'Aceptada' and (facturas.resumen=0 or (facturas.resumen=1 and activo=0)) and facturas.ven_com=1 and facturas.estado_factura=2 and facturas.numero_factura>0";
		if ( $_GET['q'] != "" )
		{
			$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$q' )";
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
		$reload = './index.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
                $num=1;
                //print"$sql";
		if ($numrows>0){
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="warning">
                                        <th>Nro</th>
					<th>Numero Boleta</th>
					<th>Total S/.</th>
                                        <th>Fecha</th>
					<th>Hora</th>
					<th>Tipo</th>
                                        <th>Sucursal</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$folio=$row['folio'];
					$numero_factura=$row['numero_factura'];
					$activo=$row['activo'];
                                        $tienda=$row['tienda'];
                                        if($activo==0){
                                            $mensaje="<font color=red>Doc Eliminado</font>";
                                        }
                                        if($activo==1){
                                            $mensaje="<font color=blue>Doc Activo</font>";
                                        }
                                        $total=$row['total_venta'];
                                        $fecha=date("d/m/Y", strtotime($row['fecha_factura']));
                                        $hora=date("H:i", strtotime($row['fecha_factura']));
					?>
					<tr style="background-color: #81F7BE;color:black;">
                                                <td><?php print"$num"; ?></td>
                                                <td><?php print"$folio-$numero_factura"; ?></td>
						<td><?php echo $total; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $hora; ?></td>
                                                <td><?php echo $mensaje; ?></td>
                                                <td><?php echo $tienda; ?></td>
					</tr>
					<?php
                                        $num=$num+1;
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>