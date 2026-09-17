<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
        function generar_numero_aleatorio($longitud) {
            $key = '';
            $pattern = '1234567890';
            $max = strlen($pattern)-1;
            for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
            return $key;
        }
        $tienda=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_producto=intval($_GET['id']);
		$query=mysqli_query($con, "select * from detalle_factura where id_producto='".$id_producto."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM products WHERE id_producto='".$id_producto."'")){
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
			  <strong>Error!</strong> No se puede eliminar.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  producto. Existen datos vinculadas a éste producto. 
			</div>
			<?php
		}
        }
	if($action == 'ajax'){
	$query1=mysqli_query($con, "select * from datosempresa where id_emp=1");
        $row1=mysqli_fetch_array($query1);
        $alerta=$row1['alerta'];
        $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
        $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
        $aColumns = array('codigo_producto', 'nombre_producto', 'des1', 'des2');//Columnas de busqueda
        $sTable = "products";
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
                if ( $q2 != "" )
		{
                   $sWhere.=" and des1='$q2'"; 
                 
                }
                
                if ( $q1 != "" )
		{
                   $sWhere.=" and des3 LIKE '%".$q1."%'"; 
                 
                }
                
                $campo1="";
                $campo2="";
                //$r111=$_GET['campo1'];
                if(isset($_GET['campo1']) and isset($_GET['campo2'])){
                    $campo1=$_GET['campo1'];
                    $campo2=$_GET['campo2'];
                }else{
                    $campo1=$_SESSION['campo1'];
                    $campo2=$_SESSION['campo2'];
                }
                
                
                
                //print"$campo1 $campo2 2";
                
                if ( $campo1 != "" and $campo2 != "")
		{
                    $sWhere.=" order by $campo1 $campo2";
                    $_SESSION['campo1']=$campo1;
                    $_SESSION['campo2']=$campo2;
                }else{
                    $sWhere.=" order by id_producto desc";
                }
		
		include 'pagination.php'; 
                //if($_SESSION['pag']==0){
                    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
                //}else{
                //    $page =$_SESSION['pag'];
                    
               // }
                
		$_SESSION['pag']=0;
		$per_page = 40; 
                
                
                
                //print"$action";
                
                //$_SESSION['page']=$page;
                
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
                if($q==""){
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable WHERE pro_ser=1 $sWhere");}
                else
                {
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");    
                }
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './productos.php';
		if($q==""){
                $sql="SELECT * FROM  $sTable WHERE pro_ser=1 $sWhere LIMIT $offset,$per_page";}
                else{  
                $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";}
                
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			?>
			<div class="table-responsive">
                           
			 <table id="example"  style="width:100%;font-size: 8pt;color:black;" border="1">
                            <thead>
				<tr style="background-color:<?php echo tablas;?>;color:white; ">
                                        <th class='text-center's>Foto</th>
					<th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','codigo_producto','<?php echo generar1($campo1,"codigo_producto",$campo2);?>')">
                                                Código
                                            <i class="fa fa-sort<?php echo generar($campo1,"codigo_producto",$campo2);?>"></i></a>    
                                        </th>
					<th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','nombre_producto','<?php echo generar1($campo1,"nombre_producto",$campo2);?>')">
                                            
                                            Producto
                                            <i class="fa fa-sort<?php echo generar($campo1,"nombre_producto",$campo2);?>"></i></a>    
                                        </th>
                                        <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"b$tienda";?>','<?php echo generar1($campo1,"b$tienda",$campo2);?>')">
                                            
                                            Stock
                                            <i class="fa fa-sort<?php echo generar($campo1,"b$tienda",$campo2);?>"></i></a>    
                                        </th>
					
                                        <th style="width:10%;" class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','des1','<?php echo generar1($campo1,"des1",$campo2);?>')">
                                            <?php echo des1;?>
                                            <i class="fa fa-sort<?php echo generar($campo1,"des1",$campo2);?>"></i></a>        
                                        </th>
                                        <th style="width:10%;" class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','des2','<?php echo generar1($campo1,"des2",$campo2);?>')">
                                            <?php echo des2;?>
                                            <i class="fa fa-sort<?php echo generar($campo1,"des2",$campo2);?>"></i></a>            
                                        </th>
                                        <th style="width:10%;" class='text-center' >
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','des3','<?php echo generar1($campo1,"des3",$campo2);?>')">
                                            <?php echo des3;?>
                                            <i class="fa fa-sort<?php echo generar($campo1,"des3",$campo2);?>"></i></a>     
                                        </th>


					<!--  REGISTRO SANITARIO TABLA -->

                                        <th style="width:10%;" class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','registro_sanitario','<?php echo generar1($campo1,"registro_sanitario",$campo2);?>')">
                                            
                                            Registro Sanitario
                                            <i class="fa fa-sort<?php echo generar($campo1,"registro_sanitario",$campo2);?>"></i></a> 
                                        </th>  





                                        <th style="width:10%;" class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','proveedor','<?php echo generar1($campo1,"proveedor",$campo2);?>')">
                                            
                                            Proveedor
                                            <i class="fa fa-sort<?php echo generar($campo1,"proveedor",$campo2);?>"></i></a> 
                                        </th>    
                                        <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"a$tienda";?>','<?php echo generar1($campo1,"a$tienda",$campo2);?>')">
                                            
                                            Precio<br><?php echo moneda;?>
                                            <i class="fa fa-sort<?php echo generar($campo1,"a$tienda",$campo2);?>"></i></a> 
                                        </th>
					<th class='text-center'>Monedero<br><?php echo moneda;?></th>
                                        <th class='text-center'>Acciones</th>
				</tr>
                                </thead>
				<?php
                                $i=0;
				while ($row=mysqli_fetch_array($query)){
					
                                        //if ($pro_ser==1){
                                            
                                            if($i%2==0){
                                                $table="valor1";
                                            }else{
                                                $table="valor2";
                                            }
                                            $i=$i+1;
                                            $id_producto=$row['id_producto'];
                                            $codigo_producto=$row['codigo_producto'];
                                            $nombre_producto=$row['nombre_producto'];


					$registro_sanitario=$row['registro_sanitario'];







                                            $status_producto=$row['status_producto'];
                                            $proveedor=$row['proveedor'];
                                            $des1=$row['des1'];
                                            $des2=$row['des2'];
                                            $des3=$row['des3'];
                                            $mon1=$row['mon'];
                                            $cat_pro=$row['cat_pro'];
                                            $pro_ser=$row['pro_ser'];
                                            $tipo7=$row['bli'];
                                            $blister=round($row['blister'],2);
                                            $caja=round($row['caja'],2);
                                            $foto=$row['foto1'];
                                             
                                            $sql1="SELECT * FROM  precios where id_producto=$id_producto";
                                            $query1 = mysqli_query($con, $sql1);
                                               
                                            $row1=mysqli_fetch_array($query1);
                                            $p2=$row1['p2'];     
                                            $c2=$row1['c2']; 
                                            $p3=$row1['p3'];     
                                            $c3=$row1['c3']; 
                                            
                                            $b=$row["b$tienda"];
                                            $mon_venta=$row['mon_venta'];
                                            $dolar=$row['mon_costo'];
                                            $mon_costo=1;
                                            if($b<=$alerta)
                                            {$label_class='label-danger';}
                                            else
                                            {$label_class='label-success';}
                                            if ($status_producto==1){$estado="Nuevo";}
                                            if ($status_producto==0){$estado="Segunda";}
                                            if ($status_producto==2){$estado="Repuesto";}
                                            $mon=moneda;
                                            $date_added= date('d/m/Y', strtotime($row['date_added']));
                                            $precio_producto=$row["a$tienda"];
                                            $precio2=$row['valor2'];
                                            $precio3=$row['valor3'];
                                            $und_pro=$row['und_pro'];
                                            $costo_producto=$row["c$tienda"];
                                            $costo=$row["c$tienda"];
                                            $utilidad=$row["a$tienda"]-$row["c$tienda"];
                                            $barras=$row['barras'];
                                            $min=$row['min'];
                                            if($barras==""){
                                                $barras=generar_numero_aleatorio(12);
                                            } 
                                            $busqueda=strtoupper($q);
                                            $nombre1=str_ireplace($busqueda,"<span style='color: red;font-weight:bold;'>$busqueda</span>",$nombre_producto);
                                            
					?>
                                        <tr id="<?php echo $table;?>">
                                        <input type="hidden" value="<?php echo $codigo_producto;?>" id="codigo_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $nombre_producto;?>" id="nombre_producto<?php echo $id_producto;?>">

			<!-- REGISTRO SANITARIO TABLA -->
                    <input type="hidden" value="<?php echo $registro_sanitario;?>" id="registro_sanitario<?php echo $id_producto;?>">



					<input type="hidden" value="<?php echo $b;?>" id="inv<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $estado;?>" id="estado<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $des1;?>" id="des1<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $des2;?>" id="des2<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $des3;?>" id="des3<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $proveedor;?>" id="proveedor<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $status_producto;?>" id="status<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $cat_pro;?>" id="cat<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $mon_venta;?>" id="mon_venta<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $mon_costo;?>" id="mon_costo<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $mon_costo;?>" id="mon_costo<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo number_format($dolar,2,'.','');?>" id="dolar<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo number_format($costo,2,'.','');?>" id="costo<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo number_format($precio_producto,2,'.','');?>" id="precio_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo number_format($precio2,2,'.','');?>" id="valor2<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo number_format($precio3,2,'.','');?>" id="valor3<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo number_format($costo_producto,2,'.','');?>" id="costo_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo number_format($utilidad,2,'.','');?>" id="utilidad<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $und_pro;?>" id="und_pro<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $barras;?>" id="barras<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $min;?>" id="min<?php echo $id_producto;?>"> 
                                        <input type="hidden" value="<?php echo $tipo7;?>" id="tipo7<?php echo $id_producto;?>"> 
                                        
                                        <input type="hidden" value="<?php echo $p2;?>" id="p2<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $c2;?>" id="c2<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $p3;?>" id="p3<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $c3;?>" id="c3<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $blister;?>" id="d2<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $caja;?>" id="d3<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $mon1;?>" id="mon<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $page;?>" id="pagi<?php echo $id_producto;?>">
                                        <td>
                                                <a class="thumbnail1">
                                                <img  class="imagen2" src="fotos/<?php echo $foto;?>" width="30" height="30" border="0" />
                                                </a>  
                                            </td>	
                                            <td><?php echo $codigo_producto; ?></td>
                                            <td><?php echo $nombre1; ?></td>
                                            <td class='text-center'><span class="label <?php echo $label_class;?>"><?php echo round($b,2); ?></span></td>
                                            
                                            <td><?php echo $des1;?></td>
                                            <td><?php echo $des2;?></td>
                                            <td><?php echo $des3;?></td>
						<td><?php echo $registro_sanitario;?></td>
                                            <td><?php echo $proveedor;?></td>
                                            <td class='text-center'><font color="blue"><strong><?php echo round($precio_producto,2);?></strong></font></td>
                                             <td class='text-center'><font color="black"><strong><?php echo round($mon1,2);?></strong></font></td>
                                         <td><span class="pull-right">
                                                <a href="fotos1.php?accion=<?php echo $id_producto;?>" class='btn btn-success btn-xs' title='Editar fotos'><i class="fa fa-pencil"></i></a> 
                                                <a href="#" class='btn btn-warning btn-xs' title='Editar producto' onclick="obtener_datos('<?php echo $id_producto;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i></a> 
                                                <a href="#" class="btn btn-danger btn-xs" title='Borrar producto' onclick="eliminar('<?php echo $id_producto; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
                                             <a href="#" class='btn btn-primary btn-xs' title='Descargar Codigo de barras' onclick="imprimir_barra('<?php echo $id_producto;?>');"><i class="fa fa-barcode"></i></a>
                                                <a href="#" class="btn btn-warning btn-xs"  title='Lotes' onclick="imprimirproducto('<?php echo $id_producto; ?>',<?php echo $b;?>,'<?php echo $nombre_producto;?>');">Lote</a></span></td>
					</tr>
					<?php
                                    //}
                                }
				?>
				<tr>
					<td colspan=14><span class="pull-right"><?PHP
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>

			</div>
			<?php
		}
	}
        
 function generar($a1,$a2,$a3) {
	$q12="";
        if($a1==$a2 and $a3=="desc") {
            $q12="-desc";  
        }
        if($a1==$a2 and $a3=="asc") {
            $q12="-asc";  
        }
	return $q12;
}       
        
 function generar1($a1,$a2,$a3) {
	$q12="asc";
        if($a1==$a2 and $a3=="desc") {
            $q12="asc";  
        }
        if($a1==$a2 and $a3=="asc") {
            $q12="desc";  
        }
	return $q12;
}         
?>

