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
tfoot{
    display: table-header-group;
}
</style>
<?php
        //include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else{
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
                $sTable = "clientes";
		$sWhere = "WHERE clientes.id_cliente>0";
                if ( $_GET['q'] != "" )
		{
			$sWhere.= " and (clientes.nombre_cliente LIKE '%".$q."%' or clientes.documento LIKE '%".$q."%' or clientes.telefono_cliente LIKE '%".$q."%')";
			
		}
		$sWhere.=" order by clientes.debe desc";
		
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './pagos.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table id="example" class="display nowrap" style="width:100%;color:black;">
                            
                            <thead>
                                <tr  style="background-color:<?php echo tablas;?>;color:white; ">
                                    <th>Proveedor</th>
                                    <th>Tipo Doc</th>
					<th>Documento</th>
                                    <th>Telefono</th>
                                    <th>Deuda</th>
                                    <th class='text-right'>Acciones</th>
				</tr>
                                </thead>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                    $id_cliente=$row['id_cliente'];
                                    $nombre_cliente=$row['nombre_cliente'];
                                    $telefono_cliente=$row['telefono_cliente'];
                                    $email_cliente=$row['email_cliente'];
                                    $telefono=$row['telefono_cliente'];
                                    if($row['doc']>0){
                                            $tipo="RUC";
                                        }else{
                                            $tipo="DNI";
                                        }
                                        $documento=$row['documento'];
                                    $mon="S/.";
                                    $deuda=$row['debe'];
                                    ?>
				<tr id="valor1">
                                    <td><?php echo $nombre_cliente;?></td>
                                    <td><?php echo $tipo;?></td>
                                            <td><?php echo $documento;?></td>
                                    <td><?php echo $telefono;?></td>
                                    <td class='text-right'><?php print"$mon"; echo number_format ($deuda,2); ?></td>	
                                    <td class="text-right">
					<a href="#" class='btn btn-primary btn-xs' title='Descargar Pagos' onclick="imprimir_cobros('<?php echo $id_cliente;?>');"><i class="glyphicon glyphicon-download"></i></a> 
					<a href="pago1.php?a=<?php echo $id_cliente;?>" class='btn btn-warning btn-xs' title='Realizar Pagos' ><i class="glyphicon glyphicon-edit"></i></a> 
                                    </td>
                                    <input type="hidden" value="<?php echo $nombre_cliente;?>" id="cliente<?php echo $id_cliente;?>">
                                    <input type="hidden" value="<?php echo $deuda;?>" id="deuda<?php echo $id_cliente;?>">    
                                </tr>
				<?php
				}
				?>
                                <tr>
					<td colspan=7><span class="pull-right"><?PHP
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			</table>
                    </div>
		<?php
		}
        }
	
?>
