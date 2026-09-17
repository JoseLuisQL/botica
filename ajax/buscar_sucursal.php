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
<?php

	
        //print"ee$_SESSION[user_login_status]ee";
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_categoria=intval($_GET['id']);
		$query=mysqli_query($con, "select * from products where cat_pro='".$id_categoria."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM categorias WHERE id_categoria='".$id_categoria."'")){
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
			  <strong>Error!</strong> No se pudo eliminar ésta categoria.Existen productos asignados a esta categoría. 
			</div>
			<?php
		}	
	}
	if($action == 'ajax'){
            $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre');//Columnas de busqueda
		 $sTable = "sucursal";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by tienda asc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './sucursal.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
                
                //print"$sql";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			?>
                        
			<div class="table-responsive">
			  <table class="table" style="color:black;">
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">	
                                    <th>Logo</th>
                                    <th>Nombre</th>
                                    <th>Ruc</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_sucursal=$row['id_sucursal'];
					$nombre=$row['nombre'];
					$ruc=$row['ruc'];
                                        $direccion=$row['direccion'];
                                        $correo=$row['correo'];
					$telefono=$row['telefono'];
                                        $ubigeo=$row['ubigeo'];
                                        $departamento=$row['dep_suc'];
                                        $provincia=$row['pro_suc'];
                                        $distrito=$row['dis_suc'];
                                        $foto=$row['foto'];
                                        if($foto==""){
                                            $foto1="logo.jpg";
                                        }else{
                                            $foto1=$foto; 
                                        }
                                        $tien=$row['tienda'];
                                        ?>
                                        <input type="hidden" value="<?php echo $nombre;?>" id="nombre<?php echo $id_sucursal;?>">
					<input type="hidden" value="<?php echo $ruc;?>" id="ruc<?php echo $id_sucursal;?>">
					<input type="hidden" value="<?php echo $direccion;?>" id="direccion<?php echo $id_sucursal;?>">
					<input type="hidden" value="<?php echo $correo;?>" id="correo<?php echo $id_sucursal;?>">
                                        <input type="hidden" value="<?php echo $telefono;?>" id="telefono<?php echo $id_sucursal;?>">
                                        <input type="hidden" value="<?php echo $ubigeo;?>" id="ubigeo<?php echo $id_sucursal;?>">
                                        
                                        <input type="hidden" value="<?php echo $departamento;?>" id="departamento<?php echo $id_sucursal;?>">
                                        <input type="hidden" value="<?php echo $provincia;?>" id="provincia<?php echo $id_sucursal;?>">
                                        <input type="hidden" value="<?php echo $distrito;?>" id="distrito<?php echo $id_sucursal;?>">
                                   <tr id="valor1">
					<td><img width="100" height="60" src="pdf/documentos/<?php echo $foto1; ?>"</td>
					<td><?php echo $nombre; ?></td>
					<td><?php echo $ruc; ?></td>
                                        <td><?php echo $telefono; ?></td>
                                        <td><?php echo $correo; ?></td>
                                        <td><span class="pull-right">
                                            <a href="sucursal2.php?accion=<?php echo $tien;?>" class='btn btn-success btn-xs' title='Editar logo'><i class="fa fa-pencil"></i>Logo</a>                                   
                                            <a href="#" class='btn btn-warning btn-xs' title='Editar sucursal' onclick="obtener_datos('<?php echo $id_sucursal;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i>Editar</a> 
					</td>	
					</tr>
					<?php
				}
				?>
				<tr style="background:white;">
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