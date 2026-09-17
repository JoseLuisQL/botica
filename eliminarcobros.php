<?php
ob_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
include('menu.php');     
$id=recoge1('id');
$consulta1 = "SELECT * FROM facturas ";
$result1 = mysqli_query($con, $consulta1);

while ($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    if ($row["id_factura"]==$id){
        $numero=$row["id_cliente"];
        $pago=$row["total_venta"];
    }       
}
$consulta2 = "DELETE FROM facturas WHERE id_factura='$id'";
if (mysqli_query($con, $consulta2)) {
    header("location:cobros1.php?a=$numero"); 
}
$consulta3 = "UPDATE clientes set deuda=deuda+$pago WHERE id_cliente='$numero'";
if (mysqli_query($con, $consulta3)) {
    header("location:cobros1.php?a=$numero"); 
}     
   
$sql6="select * from pagos where id_pago='$id'";   
$rs6=mysqli_query($con,$sql6);
while($row6=mysqli_fetch_array($rs6)){
        $id1=$row6["id_factura"];
        $pago1=$row6["pago"];
        if($id1>0){
        $consulta5 = "UPDATE facturas set cuenta1=cuenta1-$pago1 WHERE id_factura='$id1'";
        if (mysqli_query($con, $consulta5)) {
            header("location:cobros1.php?a=$numero"); 
        }     
        }
}
$consulta4 = "DELETE FROM pagos WHERE id_pago='$id'";
if (mysqli_query($con, $consulta4)) {
    header("location:cobros1.php?a=$numero"); 
}      
ob_end_flush();   
//header("location:pagos1.php?a=$numero");       
?>
