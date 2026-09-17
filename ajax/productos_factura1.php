<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
        $session_id= session_id();
        $tienda1=$_SESSION['tienda'];
	$action = 0;
	if($action == 0){
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['barra'], ENT_QUOTES)));
         
		// $aColumns = array('codigo_producto', 'nombre_producto');
                        if($q>0){
			//Primera opcion
                        $rr=mysqli_query($con,"SELECT * FROM products where barras='$q'");
                        //Segunda opcion
                        //$rr1=mysqli_query($con,"SELECT * FROM barras where barras='$q'");  
                        //$row2= mysqli_fetch_array($rr1);
                        //$id_producto1 = $row2['id_producto'];
                        //$rr=mysqli_query($con,"SELECT * FROM products where id_producto=$id_producto1");
                        //$rr=mysqli_query($con,"SELECT * FROM products,barras where barras.barras='$q' and barras.id_producto=products.id_producto");
                        $row1= mysqli_fetch_array($rr);
                        $id_producto = $row1['id_producto'];
                        
                        $stock=$row1["b$tienda1"];
                        $precio = $row1["a$tienda1"];
                        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM tmp where id_producto='$id_producto' and session_id='$session_id'");
                        $row= mysqli_fetch_array($count_query);
                        $numrows = $row['numrows'];
                        if($numrows==0 and $id_producto>0){
                         $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda,fecha1,fecha2,lote) VALUES ('$id_producto','1','$precio','$session_id','1','0000-00-00','0000-00-00','')");
                         
                         
                        }
                        $reload = './index.php';
                }
		
	}
?>