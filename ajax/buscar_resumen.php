<?php
include('is_logged.php');
?>
<style>
table tr:nth-child(odd) {background-color: #FBF8EF;}
table tr:nth-child(even) {background-color: #EFFBF5;}
#valor1 {             
border-bottom: 2px solid #F5ECCE;
}  
#valor1:hover {             
background-color: white;
border-bottom: 2px solid #A9E2F3;
} 
</style>
<style type="text/css">
   .thumbnail1{
position: relative;
z-index: 0;
}
.thumbnail1:hover{
background-color: transparent;
z-index: 50;
}
.thumbnail1 span{ /*Estilos del borde y texto*/
position: absolute;
background-color: white;
padding: 5px;
left: -100px;

visibility: hidden;
color: #FFFF00;
text-decoration: none;
}
.thumbnail1 span img{ /*CSS for enlarged image*/
border-width: 0;
padding: 2px;
}
.thumbnail1:hover span{ /*CSS for enlarged image on hover*/
visibility: visible;
top: 17px;
left: 40px; /*position where enlarged image should offset horizontally */
} 

img.imagen2{
padding:4px;
border:3px #0489B1 solid;
margin-left: 2px;
margin-right:5px;
margin-top: 5px;
float:left;

}

table tr:nth-child(odd) {background-color: #F5F6CE;}
table tr:nth-child(even) {background-color: #CEF6E3;}
#valor1:hover {              
background-color: white;
border-bottom: 2px solid #A9E2F3;
}  
#valor2:hover {              
background-color: white;
border-bottom: 2px solid #A9E2F3;
} 
#valor1 {             
background-color: #FBF8EF;
border-bottom: 2px solid #F5ECCE;
}  
#valor2 {             
background-color: #EFFBF5;
border-bottom: 2px solid #F5ECCE;
} 
.dt-button.red {
color: black;
background:red;
}
.dt-button.orange {
color: black;
background:orange;
}
.dt-button.green {
color: black;
background:green;
}
.dt-button.green1 {
color: black;
background:#01DFA5;
}
.dt-button.green2 {
color: black;
background:#2E9AFE;
}
tfoot {
    display: table-header-group;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: none;
  color: black!important;
  border-radius: 4px;
  border: 1px solid #828282;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:active {
  background: none;
  color: black!important;
}
</style>
<?php
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$tienda1=$_SESSION['tienda'];
        $usuario=$_SESSION['user_id'];
        date_default_timezone_set('America/Lima');
        $fecha1  = date("Y-m-d H:i:s");
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_factura=intval($_GET['id']);
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$sTable = "resumen_documentos";
		$sWhere = "";
		$sWhere.=" WHERE id_resumen>0";
                if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (numero like '%$q%' or fecha like '%$q%' )";
		}
		$sWhere.=" order by fecha desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table" style="color:black;">
				<tr  style="background-color:#FE9A2E;color:white; ">
                                <th>Numero</th>
                              
                                <th>Fecha</th>
				
				<th class='text-center'>Nombre XML</th>
                                <th class='text-center'>Ticket</th>
                                <th class='text-center'>Mensaje</th>
                                <th class='text-center'>XML</th>
                                <th class='text-center'>CDR</th>
				</tr>
                		<?php
				while ($row=mysqli_fetch_array($query)){
                                    
                                                $id=$row['id_resumen'];
                                                
						$numero_factura=$row['numero'];
						$fecha=$row['fecha'];
                                                $xml=$row['xml'];
                                                $doc=$xml.".".'XML';
                                                $cdrdoc="R-".$xml.".".'XML';
                                                $ticket=$row['ticket'];
					?>
					<tr id="valor1">
                                           
						<td><?php print"$numero_factura" ; ?></td> 
                                                <td><?php echo $fecha; ?></td>
                                                <td class='text-center'><?php echo $xml; ?></td>
                                                <td class='text-center'><?php echo $ticket; ?></td>
                                                <?php
                                                if($ticket<>""){
                                                    ?>
                                                <td class='text-center'><font color="blue"><strong>Enviado y aceptado</strong></font></td>
                                                <?php
                                                }
                                                 ?>
                                            	<td class="text-center">
                                                    <a href="#" class='btn btn-info btn-xs' title='Descargar xml' onclick="resumen('<?php echo $doc;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" class='btn btn-success btn-xs' title='Descargar xml' onclick="cdrresumen('<?php echo $cdrdoc;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                </td>
					</tr>
					<?php
                                        
                   		
                                }
				?>
				<tr style="background:white;">
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
                }
	
?>

