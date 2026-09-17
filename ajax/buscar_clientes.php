<?php
include('is_logged.php');
?>
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
<?php
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from facturas where id_cliente='".$id_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM clientes WHERE id_cliente='".$id_cliente."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar este  cliente. Existen documentos vinculadas a este cliente. 
			</div>
			<?php
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$aColumns = array('nombre_cliente','doc');//Columnas de busqueda
		$sTable = "clientes";
		$sWhere = "WHERE tipo1=1 and tienda=$tienda1";
                if ( $_GET['q'] != "" )
		{
			$sWhere.= " and (clientes.nombre_cliente LIKE '%".$q."%' or clientes.documento LIKE '%".$q."%' or clientes.telefono_cliente LIKE '%".$q."%')";
			
		}
                $sWhere.=" order by clientes.id_cliente desc";
                include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere ");
                $row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
                $reload = './clientes.php';
                $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
                $query = mysqli_query($con, $sql);
		if ($numrows>0){	
			?>
			<div class="table-responsive">
			  <table id="example"  style="width:100%;color:black;">
                             
                              <thead>
				<tr style="background-color:<?php echo tablas;?>;color:white; ">
                                   
                                    <th>Razon Social</th>
                                    <th>Documento</th>
                                    <th>Tip doc</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Monedero</th>
                                    <th class='text-right'>Acciones</th>
					
				</tr>
                                 </thead>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_cliente=$row['id_cliente'];
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
						$direccion_cliente=$row['direccion_cliente'];
                                                $users=$row['users'];
                                                
                                                $doc=$row['doc'];
                                                $dni=$row['dni'];
                                                if($doc>0){
                                                    $doc1=$doc;
                                                    $tipo="RUC";
                                                    $tipo1="2";
                                                }
                                                if($dni>0){
                                                    $doc1=$dni;
                                                    $tipo="DNI";
                                                    $tipo1="1";
                                                }
                                                
                                                $departamento=$row['departamento'];
                                                $provincia=$row['provincia'];
                                                $distrito=$row['distrito'];
                                                $cuenta=$row['cuenta'];
                                                $vendedor=$row['vendedor'];
						$status_cliente=$row['status_cliente'];
						if ($status_cliente==1){$estado="Activo";}
						else {$estado="Inactivo";}
						$date_added= date('d/m/Y', strtotime($row['date_added']));
                                                
                                                $busqueda=strtoupper($q);
                                                $nombre1=str_ireplace($busqueda,"<span style='color: red;font-weight:bold;'>$busqueda</span>",$nombre_cliente);
                                            
						
					?>
				    <tr id="valor1">
                                        <input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $telefono_cliente;?>" id="telefono_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $email_cliente;?>" id="email_cliente<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $doc1;?>" id="doc<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $vendedor;?>" id="vendedor<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $direccion_cliente;?>" id="direccion_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $status_cliente;?>" id="status_cliente<?php echo $id_cliente;?>">
					
                                        <input type="hidden" value="<?php echo $departamento;?>" id="departamento<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $provincia;?>" id="provincia<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $distrito;?>" id="distrito<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $cuenta;?>" id="cuenta<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $tipo;?>" id="tipo<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $users;?>" id="users<?php echo $id_cliente;?>">
					<td ><?php echo $nombre1; ?></td>
                                        <td><?php echo $doc1; ?></td>
                                        <td><?php echo $tipo; ?></td>
					<td><?php echo $telefono_cliente; ?></td>
					<td><?php echo $email_cliente;?></td>
					<td><?php echo $estado;?></td>
                                        <td><?php echo $users;?></td>
					<td ><span class="pull-right">
					<a href="#" class='btn btn-warning btn-xs' title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-danger btn-xs' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>	
					</tr>
					<?php
                                        
                                        
				}
				?>
				<tr>
					<td colspan=8><span class="pull-right"><?PHP
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>
