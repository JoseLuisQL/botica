<!DOCTYPE html>
<?php
//header("Content-Encoding: UTF-8");
//header("Content-Type: application/vnd.ms-excel; charset='UTF-8' ");

?>
<html lang="es">
<head>
    
   <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"> 
  <!-- Meta, title, CSS, favicons, etc. -->
  
  
    
    <style>
 
    </style>
    <script>
 
    </script>
</head>
 
<body>
    <div >
        <table id="tblExport">
            <tr>
                <th>Primera columna</th>
                <th>Segunda columna</th>
                <th>Tercera columna</th>
            </tr>
            <tr>
                <td>row1 Col1</td>
                <td>row1 Col2</td>
                <td>row1 Col3</td>
            </tr>
            <tr>
                <td>row2 Col1</td>
                <td>row2 Col2</td>
                <td>row2 Col3</td>
            </tr>
            <tr>
                
                <td> 
                <?php 
                
                
                ?>
                </td>
                <td>row3 Col2</td>
                <td>row3 Col3</td>
            </tr>
        </table>
    </div>
    <br/>
    <input type="button" onclick="exportData('tblExport')" value="Export to Excel">
    
    <script type="text/javascript"> var tableToExcel = (function() { var uri = 'data:application/vnd.ms-excel;base64,' , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>' , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) } , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) } return function(table, name) { if (!table.nodeType) table = document.getElementById(table) var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML} window.location.href = uri + base64(format(template, ctx)) } })() </script>
 <script>
     
     
     
     
   function exportData(report_id){ 
       var blob = new Blob([document.getElementById(report_id).innerHTML], { type: "text/plain;charset=utf-8;" }); saveAs(blob, "Report.xls");}
  

 </script>  
    
</body>
</html>