<?php
$html = "";
if ($_POST["elegido"]==1) {
	$html = '
	<option value="0">CON IGV</option>
	<option value="1">EXONERADA</option>
	
	
	
	';	
}
if ($_POST["elegido"]==2) {
	$html = '
	<option value="0">CON IGV</option>
	<option value="1">EXONERADA</option>
	
	';	
}
if ($_POST["elegido"]==3) {
	$html = '
	
	<option value="1">EXONERADA</option>
	
	';	
}
if ($_POST["elegido"]==8) {
	$html = '
	
	<option value="1">EXONERADA</option>
	
	';	
}

echo $html;	
?>