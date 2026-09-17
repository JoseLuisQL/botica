<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
	$fetch1 = mysqli_query($con,"SELECT * FROM datosempresa"); 
	
	
	/* Retrieve and store in array the results of the query.*/
	while ($row1 = mysqli_fetch_array($fetch1)) {
            $conver=$row1['conversion'];
        }
	$fetch = mysqli_query($con,"SELECT * FROM clientes where nombre_cliente like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%'  LIMIT 0 ,50"); 
	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_cliente=$row['id_cliente'];
		$row_array['value'] = $row['nombre_cliente'];
		$row_array['id_cliente']=$id_cliente;
		$row_array['nombre_cliente']=$row['nombre_cliente'];
		$row_array['telefono_cliente']=$row['telefono_cliente'];
		$row_array['email_cliente']=$row['email_cliente'];
                $row_array['direccion_cliente']=$row['direccion_cliente'];
                 $row_array['users']=round($row['users'],2);
                $row_array['users1']=round($row['users']*$conver,2);
                //if($row['doc']>0)
                //{
                    $row_array['doc1']=$row['documento'];
                //}
                //if($row['doc']==0 and $row['dni']>0)
                //{
                   // $row_array['doc1']=$row['dni'];
                //}
                
                
                
                
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>