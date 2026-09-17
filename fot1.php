<?php
ob_start();
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$disabled1="";
$consulta1 = "SELECT * FROM users ";
$result1 = mysqli_query($con, $consulta1);
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

         if($a[3]==0){
        header("location:error.php");    
        }


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title> 
  
 Ingreso de fotos
  </title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
<link href="css/custom.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/formularios.css"/>
<script src="js/jquery.min.js"></script>
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
-->
<link rel="stylesheet" type="text/css" href="DataTables/DataTables/css/dataTables.bootstrap.min.css"/>
<script type="text/javascript" src="Buttons/js/jszip.min.js"></script>
<!--<script type="text/javascript" src="Buttons/js/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="Buttons/css/buttons.dataTables.min.css"/>
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="Buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.print.min.js"></script>
  
 
<style type="text/css"> 
    .fijo {
	background: #333;
	color: white;
	height: 10px;
	
	width: 100%; /* hacemos que la cabecera ocupe el ancho completo de la página */
	left: 0; /* Posicionamos la cabecera al lado izquierdo */
	top: 0; /* Posicionamos la cabecera pegada arriba */
	position: fixed; /* Hacemos que la cabecera tenga una posición fija */
} 

.thumb {
            height: 100px;
            width:150px;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
          }
.textfield10:hover {
                    border:3px solid black; 
}
.textfield10:focus {border:3px solid black;
                    -moz-box-shadow:inset 0 0 5px #FAFAFA;
-webkit-box-shadow:inset 0 0 5px #FAFAFA;
box-shadow:inset 0 0 5px #FAFAFA;
                  background-color:#FAFAFA;  
                  color:black;
}
.textfield10{display: block;  float:left;  background-color:white; width:600px;color:#0489B1;
          padding-left: 5px;
          padding-top: 4px; margin:1.5px;	border: 3px solid #BDBDBD;
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

</style>

 
 
</head>

<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

         
          <div class="clearfix"></div>

          <!-- menu prile quick info -->
          <?php
          menu2();
          
        
          menu1();
          
          ?>
     
        </div>
      </div>

        
        <?php
          menu3();
    
        ?>

      <div class="right_col" role="main">
          
          <div style="background:<?php echo COLOR;?>">  
        
            <div class="panel panel-info">
		<div class="panel-heading">
		   
			 Ingreso de fotos a la galeria:
		</div>        
            </div>  
        
         <?php      
print"<form class=\"form-horizontal form-label-left\" action=\"fot3.php\" enctype=\"multipart/form-data\"  method=\"POST\">";

?>
        
                        <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Nombre de la foto:</label>
				<div class="col-sm-8">
                                    
                                    <input type="text"  class="form-control" id="nombre" name="nombre" >
				</div>
			  </div>
          
          
                        <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Ingresar foto:</label>
				<div class="col-sm-8">
                                    <input  accept="image/jpeg" type="file" id="files" name="files" class="form-control"/>
                       <output id="list"></output>
				</div>
			  </div> 
          
                        <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Ingresar foto:</label>
				<div class="col-sm-8">
                                    <select class="form-control" name="asignado" id="asignado">
                                        <option value="fotovision">Vision</option>
                                        <option value="fotomision">Mision</option>
                                        <option value="logo">Logo</option>
                                        
                                        <option value="slider1">Slider1</option>
                                        <option value="slider2">Slider2</option>
                                        <option value="slider3">Slider3</option>
                                        <option value="slider4">Slider4</option>
                                        <option value="slider5">Slider5</option>
                                        <option value="quienesomos">Quienes Somos</option>
                                        
                                        
                                    </select>
				</div>
			  </div> 
          
         <script>
		  function archivo(evt) {
			var files = evt.target.files; // FileList object
		
			// Obtenemos la imagen del campo "file".
			for (var i = 0, f; f = files[i]; i++) {
			  //Solo admitimos imágenes.
			  if (!f.type.match('image.*')) {
				continue;
			  }
		
			  var reader = new FileReader();
		
			  reader.onload = (function(theFile) {
				return function(e) {
				  // Insertamos la imagen
				 document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
				};
			  })(f);
		
			  reader.readAsDataURL(f);
			}
		  }
	
		  document.getElementById('files').addEventListener('change', archivo, false);
                  
	</script>
   
           <div class="modal-footer">
                     
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  
                  </div>
		  </form>
          
          
          </div>
          
              <div class="table-responsive">
                   
                  <table id="example" class="display nowrap" style="width:100%">
                    <thead>
                      <tr style="background-color:#FE9A2E;color:white; ">
                       <th>Foto  </th>
                       <th>Nombre de la foto  </th>
                        <th>Largo  </th>
                        <th>Ancho  </th>
                        <th>Ubicacion Pagina </th>
                        <th>Borrar </th>
                      </tr>
                    </thead>

                    <tbody>
    
            <?php
                            
$consulta3 = "select*from fotos";
$result3 = mysqli_query($con,$consulta3);

while ($row = mysqli_fetch_array($result3)) {
    $archivo=$row["archivo"];
    $foto=$row["nom_foto"];
    $ancho=$row["ancho"];
    $largo=$row["largo"];
    $ubi_pag=$row["ubi_pag"];
  
    ?>
       <tr id="valor1">
                       <td class=" "><img src="galeria/<?php echo $archivo;?>" width="150" height="100"></td>
                       <td class=" "><?php echo $foto;?></td>
                        <td class=" "><?php echo $ancho;?></td>
                        <td class=" "><?php echo $largo;?></td>
                        <td class=" "><?php echo $ubi_pag;?></td>
                        <td class=" "><a href="fot3.php?a=<?php echo $archivo;?>">Borrar Foto</a></td>
       </tr>
<?php
}                            
?>
    
                     
                    </tbody>

                  </table>
     
                   
                     
                </div>
      
          

          </div>
     
      </div>
     
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  
  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>


  
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
       
    
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
    
    initComplete: function () {
            this.api().columns([ 4,5,6,7]).every( function () {
                var column = this;
                
                
                var select = $('<select style="width:70px;"><option value="">Buscar</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    var val = $('<span/>').html(d).text();
                select.append( '<option value="' + val + '">' + val + '</option>' );
                } );
            } );
        },
         bDestroy: true,
            dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        
        columnDefs: [
            {
                targets: 1,
                className: 'noVis'
            }
        ],
        
        buttons: 
        [
                
             {
                    extend: 'colvis',
                    text: 'Mostrar columnas',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }
                
                },   
                          
{
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange',
                    exportOptions: {
                    columns: ':visible'
                }
                
                },
                
                {
                    extend: 'copy',
                    text: 'COPIAR',
                    className: 'red',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                
                
                
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    className: 'green',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'green1',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'print',
                    text: 'IMPRIMIR',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }
                },
            ]
        
        
    } );
} );

  </script>
  
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Seleccionar",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "Con Max Selección límite de 4",
        allowClear: true
      });
    });
  </script>
  
  
  
</body>

</html>
<?php
ob_end_flush();
?>



