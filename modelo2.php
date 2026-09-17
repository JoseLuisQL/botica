<?php
$html = "";
if ($_POST["elegido"]==2) {
	$html = '
	<option value="Reponer Stock">Reponer Stock</option>
	';	
}
if ($_POST["elegido"]==1) {
	$html = '
	<option value="Disminuir Stock">Disminuir Stock</option>
        
	<option value="Por Faltante">Por Faltante</option>
	<option value="Mercaderia Vencida o deteriorada">Mercaderia Vencida o deteriorada</option>
	<option value="Devolucion Proveedor">Devolucion Proveedor</option>
	';	
}


echo $html;	
?>