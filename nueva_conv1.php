<?php
ob_start();
session_start();
include("menu.php");
 $accion=recoge1('nota');
 $id_factura=recoge1('doc_mod');


if ($accion==1) {
 $_SESSION['doc_ventas']=1;
 $_SESSION['doc_ventas1']="RUC";
}

if ($accion==2) {
 $_SESSION['doc_ventas']=2;
 $_SESSION['doc_ventas1']="DNI";
}
header("location:nueva_conv.php?id_factura=$id_factura");
ob_end_flush(); 
?>