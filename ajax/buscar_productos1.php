<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
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
                
                if ($q2!= "" )
		{
                   $sWhere.=" and des1='$q2'"; 
                 
                }
                
                if ($q1!= "" )
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
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 40; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
                $texto="sum(b1*costo_producto) AS c1,sum(b2*costo_producto) AS c2,sum(b3*costo_producto) AS c3,sum(b4*costo_producto) AS c4,sum(b5*costo_producto) AS c5,sum(b6*costo_producto) AS c6,sum(b7*costo_producto) AS c7,";
                $texto1="sum(b1*precio_producto) AS d1,sum(b2*precio_producto) AS d2,sum(b3*precio_producto) AS d3,sum(b4*precio_producto) AS d4,sum(b5*precio_producto) AS d5,sum(b6*precio_producto) AS d6,sum(b7*precio_producto) AS d7";
                
                if($q==""){
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows,$texto $texto1 FROM $sTable WHERE pro_ser=1 $sWhere");}
                else
                {
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows,$texto $texto1 FROM $sTable  $sWhere");    
                }
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './productos1.php';
		if($q==""){
                $sql="SELECT * FROM  $sTable WHERE pro_ser=1 $sWhere LIMIT $offset,$per_page";}
                else{  
                $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";}
                
                
                //print"$sWhere";
                
		$query = mysqli_query($con, $sql);
                $c1 = round($row['c1'],1);
                $c2 = round($row['c2'],1);
                $c3 = round($row['c3'],1);
                $c4 = round($row['c4'],1);
                $c5 = round($row['c5'],1);
                $c6 = round($row['c6'],1);
                $c7 = round($row['c7'],1);
                
                $d1 = round($row['d1'],1);
                $d2 = round($row['d2'],1);
                $d3 = round($row['d3'],1);
                $d4 = round($row['d4'],1);
                $d5 = round($row['d5'],1);
                $d6 = round($row['d6'],1);
                $d7 = round($row['d7'],1);
		if ($numrows>0){
			?>
			<div class="table-responsive">
                           
			 <table id="example"  style="width:100%;font-size: 8pt;color:black;" border="1">
                            <thead>
				<tr style="background-color:<?php echo tablas;?>;color:white; ">
                                        
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
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"b1";?>','<?php echo generar1($campo1,"b1",$campo2);?>')">
                                            
                                            S1
                                            <i class="fa fa-sort<?php echo generar($campo1,"b1",$campo2);?>"></i></a>    
                                        </th>
					 <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"b2";?>','<?php echo generar1($campo1,"b2",$campo2);?>')">
                                            
                                            S2
                                            <i class="fa fa-sort<?php echo generar($campo1,"b2",$campo2);?>"></i></a>    
                                        </th>
                                         <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"b3";?>','<?php echo generar1($campo1,"b3",$campo2);?>')">
                                            
                                            S3
                                            <i class="fa fa-sort<?php echo generar($campo1,"b3",$campo2);?>"></i></a>    
                                        </th>
                                         <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"b4";?>','<?php echo generar1($campo1,"b4",$campo2);?>')">
                                            
                                            S4
                                            <i class="fa fa-sort<?php echo generar($campo1,"b4",$campo2);?>"></i></a>    
                                        </th>
                                         <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"b5";?>','<?php echo generar1($campo1,"b5",$campo2);?>')">
                                            
                                            S5
                                            <i class="fa fa-sort<?php echo generar($campo1,"b5",$campo2);?>"></i></a>    
                                        </th>
                                         <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"b6";?>','<?php echo generar1($campo1,"b6",$campo2);?>')">
                                            
                                            S6
                                            <i class="fa fa-sort<?php echo generar($campo1,"b6",$campo2);?>"></i></a>    
                                        </th>
                                         <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"b7";?>','<?php echo generar1($campo1,"b7",$campo2);?>')">
                                            
                                            S7
                                            <i class="fa fa-sort<?php echo generar($campo1,"b7",$campo2);?>"></i></a>    
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
                                        <th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"precio_producto";?>','<?php echo generar1($campo1,"precio_producto",$campo2);?>')">
                                            
                                            Precio<br><?php echo moneda;?>
                                            <i class="fa fa-sort<?php echo generar($campo1,"precio_producto",$campo2);?>"></i></a> 
                                        </th>
					<th class='text-center'>
                                            <a href="#" style="color:white;"  onclick="cambiar('<?php echo $page;?>','<?php print"costo_producto";?>','<?php echo generar1($campo1,"costo_producto",$campo2);?>')">
                                            
                                            Costo<br><?php echo moneda;?>
                                            <i class="fa fa-sort<?php echo generar($campo1,"costo_producto",$campo2);?>"></i></a> 
                                        </th>
                                        
				</tr>
                                </thead>
				<?php
                                $i=0;
				while ($row=mysqli_fetch_array($query)){
					$pro_ser=$row['pro_ser'];
                                        if ($pro_ser==1){
                                            
                                            if($i%2==0){
                                                $table="valor1";
                                            }else{
                                                $table="valor2";
                                            }
                                            $i=$i+1;
                                            $id_producto=$row['id_producto'];
                                            $codigo_producto=$row['codigo_producto'];
                                            $nombre_producto=$row['nombre_producto'];
                                            $status_producto=$row['status_producto'];
                                            $des1=$row['des1'];
                                            $des2=$row['des2'];
                                            $des3=$row['des3'];
                                            $cat_pro=$row['cat_pro'];
                                            $pro_ser=$row['pro_ser'];
                                            $foto=$row['foto1'];
                                               
                                            $b1=$row["b1"];
                                            $b2=$row["b2"];
                                            $b3=$row["b3"];
                                            $b4=$row["b4"];
                                            $b5=$row["b5"];
                                            $b6=$row["b6"];
                                            $b7=$row["b7"];
                                            
                                           
                                            $dolar=$row['mon_costo'];
                                            $mon_costo=1;
                                            if($b1<=$alerta)
                                            {$label_class1='label-danger';}
                                            else
                                            {$label_class1='label-success';}
                                            
                                            if($b2<=$alerta)
                                            {$label_class2='label-danger';}
                                            else
                                            {$label_class2='label-success';}
                                            
                                            if($b3<=$alerta)
                                            {$label_class3='label-danger';}
                                            else
                                            {$label_class3='label-success';}
                                            
                                            if($b4<=$alerta)
                                            {$label_class4='label-danger';}
                                            else
                                            {$label_class4='label-success';}
                                            
                                            if($b5<=$alerta)
                                            {$label_class5='label-danger';}
                                            else
                                            {$label_class5='label-success';}
                                            
                                            if($b6<=$alerta)
                                            {$label_class6='label-danger';}
                                            else
                                            {$label_class6='label-success';}
                                            if($b7<=$alerta)
                                            {$label_class7='label-danger';}
                                            else
                                            {$label_class7='label-success';}
                                            $mon="S/";
                                            $date_added= date('d/m/Y', strtotime($row['date_added']));
                                            $precio_producto=$row['precio_producto'];
                                            $costo_producto=$row['costo_producto'];
                                            $precio2=$row['valor2'];
                                            $precio3=$row['valor3'];
                                            $und_pro=$row['und_pro'];
                                            
                                            $costo=$row['costo_producto'];
                                            $utilidad=$row['precio_producto']-$row['costo_producto'];
                                             
					?>
                                        <tr id="<?php echo $table;?>">
                                         	
                                            <td><?php echo $codigo_producto; ?></td>
                                            <td><?php echo $nombre_producto; ?></td>
                                            <td ><span class="label <?php echo $label_class1;?>"><?php echo $b1; ?></span></td>
                                            <td ><span class="label <?php echo $label_class2;?>"><?php echo $b2; ?></span></td>
                                            <td ><span class="label <?php echo $label_class3;?>"><?php echo $b3; ?></span></td>
                                            <td ><span class="label <?php echo $label_class4;?>"><?php echo $b4; ?></span></td>
                                            <td ><span class="label <?php echo $label_class5;?>"><?php echo $b5; ?></span></td>
                                            <td ><span class="label <?php echo $label_class6;?>"><?php echo $b6; ?></span></td>
                                            <td ><span class="label <?php echo $label_class7;?>"><?php echo $b7; ?></span></td>
                                            <td><?php echo $des1;?></td>
                                            <td><?php echo $des2;?></td>
                                            <td><?php echo $des3;?></td>
                                            <td><font color="blue"><strong><span class='pull-right'><?php echo number_format($precio_producto,2);?></strong></font></span></td>
                                         <td><font color="blue"><strong><span class='pull-right'><?php echo number_format($costo_producto,2);?></strong></font></span></td>
					</tr>
					<?php
                                    }
                                }
				?>
				
                                <tr>
                                    <td></td>
                                    <td style="text-align:right;">COSTO:</td>
                                    <td style="text-align:right;"><?php echo $c1;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c2;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c3;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c4;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c5;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c6;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $c7;?>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align:right;">INGRESO:</td>
                                    <td style="text-align:right;"><?php echo $d1;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d2;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d3;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d4;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d5;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d6;?>&nbsp;</td>
                                    <td style="text-align:right;"><?php echo $d7;?>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td style="text-align:right;">DIF:</td>
                                    <td style="text-align:right;"><?php echo $d1-$c1;?></td>
                                    <td style="text-align:right;"><?php echo $d2-$c2;?></td>
                                    <td style="text-align:right;"><?php echo $d3-$c3;?></td>
                                    <td style="text-align:right;"><?php echo $d4-$c4;?></td>
                                    <td style="text-align:right;"><?php echo $d5-$c5;?></td>
                                    <td style="text-align:right;"><?php echo $d6-$c6;?></td>
                                    <td style="text-align:right;"><?php echo $d7-$c7;?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
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

