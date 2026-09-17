<?php
session_start();
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM products where nombre_producto like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50"); 
	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_producto=$row['id_producto'];
		$row_array['value'] = $row['nombre_producto'];
		$row_array['id_producto']=$id_producto;
		$row_array['nombre_producto']=$row['nombre_producto'];
		$row_array['precio_producto']=$row['precio_producto'];
                $row_array['precio_producto2']=$row['valor2'];
                $row_array['precio_producto3']=$row['valor3'];
                $row_array['des1']=$row['des1'];
                $row_array['des2']=$row['des2'];
                $row_array['des3']=$row['des3'];
                $row_array['foto1']="fotos/".$row['foto1'];
                
                //$_SESSION['foto']="fotos/".$row['foto'];
                
                $tipo=$row['status_producto'];
                
                if($tipo==0){
                    $c="De segunda";
                }
                if($tipo==1){
                    $c="Nuevo";
                }
                
                if($tipo==2){
                    $c="Repuesto";
                }
                $row_array['tipo']=$c;
                
                $tienda=$_SESSION['tienda'];
                $inv=$row["b$tienda"];
		$row_array['inv_producto']=$inv;
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>