<?php
include('is_logged.php');
?>
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
textarea {
  

  border  : none;
  padding : 5 5px;
  margin  : 0;
  width   : 80px;
  height: 40px;
  
}
</style>
<script>
 function imprimir(id_producto){
			VentanaCentrada('pdf/documentos/ver_stock.php?id_producto='+id_producto,'Producto','','800','500','true');
		}   
    
</script>
<?php
	//include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
		// $aColumns = array('codigo_producto', 'nombre_producto');
		 $sTable = "products,und";
		$sWhere="";
		 $sWhere.=" WHERE products.und_pro=und.id_und";
		if ( $_GET['q'] != "" and $_GET['q1'] == "")
		{
			$sWhere.= " and  (products.nombre_producto like '%$q%') ORDER BY  `products`.`nombre_producto` ASC";
		}
                if ( $_GET['q1'] != "" and $_GET['q'] == "")
		{
			$sWhere.= " and  (products.des2 like '%$q1%') ORDER BY  `products`.`des2` ASC";
		}
                if ( $_GET['q1'] == "" and $_GET['q'] == ""){
                //$sWhere=$sWhere." ORDER BY  `products`.`nombre_producto` ASC ";
                }
                //print"$sWhere";
		include 'pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 15; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
                
                //print"$sql";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;background:white;">
				<tr  class="warning">
                                    
					<th>Incentivo</th>
					<th>Producto</th>
                                        <th>Laboratorio</th>
                                        <th>Componente</th>
                                        <th>Accion Terapeutica</th>
					<th><span class="pull-right">Cantidad</span></th>
					<th><span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;Precio&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
                                        <th><span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;Stock&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
					<th class='text-center'>Agregar</th>
                                        <th class='text-center'>ver</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_producto=$row['id_producto'];
					$codigo_producto=$row['codigo_producto'];
					$nombre_producto=$row['nombre_producto'];
                                        $des1=$row['des1'];
                                        $des2=$row['des2'];
                                        $des3=$row['des3'];
                                        $foto=$row['foto1'];
                                        $blister=$row['blister'];
                                        $caja=$row['caja'];
                                        $tienda=$_SESSION['tienda'];
                                        $b=$row["b$tienda"];
                                        $dis="";
                                        if($b<=0){
                                            $dis="disabled";
                                        }
                                        $a=$row["a$tienda"];
					$precio_venta=$a;
					$precio_venta=number_format($precio_venta,2);
                                        $valor2="";
                                        $valor3="";
                                        if($row['valor2']>0 and $row['valor3']>0){
                                            
                                        
                                        $valor2="<font color=red>".intval($row['valor2'])." / ";
                                        $valor3="S/.".$row['valor3']."</font>";
                                        }
					?>
					<tr style="background-color:#CEE3F6;color:black;">
                                                
                                                <td><?php echo $valor2; ?><?php echo $valor3; ?></td>
						<td style="width:30%"><?php echo $nombre_producto; ?></td>
                                                <td><?php echo $des1; ?></td>
                                                <td><?php echo $des2; ?></td>
                                                <td><?php echo $des3; ?></td>
						<td>
						<div class="pull-right">
                                                    <input type="text" class="form-control" style="text-align:center;" id="cantidad_<?php echo $id_producto; ?>" autocomplete="off">
						</div></td>
						<td style="width:13%">
                                                    <div>
                                                        <select id="precio_venta_<?php echo $id_producto; ?>" class="form-control">
                    <?php
                    
                    $sql1="SELECT * FROM  precios where id_producto=$id_producto";
                    $query1 = mysqli_query($con, $sql1);
                                               
                    $row1=mysqli_fetch_array($query1);
                    $p1=round($row1['p1'],2);                                
                    $p2=round($row1['p2'],2); 
                    $p3=round($row1['p3'],2);         
                    ?>
                    
                    <option value="<?php print"$p1-1";?>"><?php print"Und: $p1";?></option>
                    <?php
                    if($blister>0){
                        ?>
                        <option value="<?php print"$p2-2";?>">Blister:<?php echo $p2;?></option>
                        <?php
                    }
                    ?>
                    
                    
                    
                    <?php
                    if($caja>0){
                        ?>
                        <option value="<?php print"$p3-3";?>">Caja:<?php echo $p3;?></option>
                        <?php
                    }
                    ?>
                    
                    
                    
                </select>
                                                        
                                                        
                                                        
                                                     </div>
                                                </td>
                                              
                                                <td><div class="pull-right"><input type="text" class="form-control" style="text-align:right" disabled id="stock_<?php echo $id_producto; ?>" value="<?php echo $b;?>"></div></td>
						<td class='text-center'>
                                                    <a <?php echo $dis;?> class='btn btn-info'href="#" onclick="agregar('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a>
                                                </td>
                                                <td class='text-center'>
                                                    <a href="#" class='btn btn-primary' title='ver' onclick="imprimir('<?php echo $id_producto;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                </td>
					</tr>
					<?php
				}
				?>
				<tr>
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