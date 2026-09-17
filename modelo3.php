<?php
$html = "";
if ($_POST["elegido"]==1) {
	$html = '
	<option value="2">Boleta</option>
	<option value="3">Nota de Venta</option>
	<option value="8">Cotizacion</option>
	
	
	';	
}
if ($_POST["elegido"]==2) {
	$html = '
	<option value="1">Factura</option>
	<option value="3">Nota de Venta</option>
	<option value="8">Cotizacion</option>
	';	
}

echo $html;	
?>