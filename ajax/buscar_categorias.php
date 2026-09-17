<?php
include('is_logged.php');
?>
<style>
    
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

</style>

<?php

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_categoria=intval($_GET['id']);
		$query=mysqli_query($con, "select * from products where cat_pro='".$id_categoria."'");
		$count=mysqli_num_rows($query);
                
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM categorias WHERE id_categoria='".$id_categoria."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar ésta categoria.Existen productos asignados a esta categoría. 
			</div>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nom_cat');//Columnas de busqueda
		 $sTable = "categorias";
		 $sWhere = "";
		
		$sWhere.=" order by id_categoria desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './categorias.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere ";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table id="example" class="display nowrap" style="width:100%;color:black;">
                                <thead>
				<tr  style="background-color:<?php echo tablas;?>;color:white; ">
					<th>Nombre</th>
					<th>Descripcion</th>
                                        <th>Acciones</th>
					
				</tr>
                                </thead>
                                <tbody>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_categoria=$row['id_categoria'];
						$nom_cat=$row['nom_cat'];
						$des_cat=$row['des_cat'];
				        
					?>
					
                                        <tr>
                                                <input type="hidden" value="<?php echo $nom_cat;?>" id="nom_cat<?php echo $id_categoria;?>">
                                                <input type="hidden" value="<?php echo $des_cat;?>" id="des_cat<?php echo $id_categoria;?>">
						
					<td><?php echo $nom_cat; ?></td>
					<td><?php echo $des_cat; ?></td>
                                        <td ><span class="pull-right">
					<a href="#" class='btn btn-warning btn-xs' title='Editar categoria' onclick="obtener_datos('<?php echo $id_categoria;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i>Editar</a> 
					<a href="#" class='btn btn-danger btn-xs' title='Borrar categoria' onclick="eliminar('<?php echo $id_categoria; ?>')"><i class="glyphicon glyphicon-trash"></i>Borrar </a></span></td>
						
					</tr>
					<?php
				}
				?>
				
                                
                                </tbody>
			  </table>
			</div>
			<?php
		}
	}
?>

  <script>
 
$(document).ready(function() {
    $('#example').DataTable( {
        language: {
        "url": "/dataTables/i18n/de_de.lang",
                "decimal": "",
        "show": "Mostrar",
        "emptyTable": "No hay informacion",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        buttons: {
                copyTitle: 'Copiar filas al portapapeles',
                
                copySuccess: {
                    _: 'Copiado %d fias ',
                    1: 'Copiado 1 fila'
                },
                
                pageLength: {
                _: "Mostrar %d filas",
                '-1': "Mostrar Todo"
            }
            },
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
        
        
        
        
    },
         bDestroy: true,
            dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: 
        
        
        [
                
                {
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange'
                },
                
                {
                    extend: 'copy',
                    text: 'COPIAR',
                    className: 'red'
                },
                
                
                
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    className: 'green'
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'green1'
                },
                {
                    extend: 'print',
                    text: 'IMPRIMIR',
                    className: 'green2'
                }
            ],
        
        
    } );
} );



</script>


  
 