<?php
session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location:login.php");
		exit;
}
include("config/db.php");
include("config/conexion.php");
$id=$_GET['caja'];
$tienda=$_SESSION['tienda'];
	//exit();
$sql_factura1=mysqli_query($con,"update caja set usuario_cierre='0' where id_caja='".$id."'");
$sql_factura2=mysqli_query($con,"update sucursal set caja='1' where tienda='".$tienda."'");
echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-top: 10px;">';
echo 'Se ha abierto la caja.<br>';

echo '</div>';


?>

