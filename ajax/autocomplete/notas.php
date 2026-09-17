<?php
session_start();
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
$tienda1=$_SESSION['tienda'];

/* If connection to database, run sql statement. */
if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM facturas where estado_factura<=2 and ven_com=1 and tienda=$tienda1 and numero_factura like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50"); 
	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_factura=$row['id_factura'];
                $folio=$row['folio'];
		$row_array['value'] = $folio."-".$row['numero_factura'];
		$row_array['id_doc']=$id_factura;
		$row_array['numero_factura']=$row['numero_factura'];
		$row_array['doc2']=$folio."-".$row['numero_factura'];
                
                
    
		
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>