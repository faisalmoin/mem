<?php
require_once("../db.txt");
 $category=$_REQUEST['id'];
 $qr="SELECT [ID] FROM [VMS Item Category Master] WHERE [Item category]='".$category."'";
 $Categ=odbc_exec($conn, "$qr");
 
 ?>
        

<script type="text/javascript" charset="utf-8">
 
    $(function()
    {
        var availableTags = [ <?php
                $City_Tag1=odbc_exec($conn, "SELECT DISTINCT[Sub Category] FROM [VMS Subcategory Master] WHERE [Category ID]='".odbc_result($Categ, "ID")."'");
                while(odbc_fetch_array($City_Tag1)){
                    echo "'". odbc_result($City_Tag1, "Sub Category")."', ";
                }
               
                          
            ?> ];

       
        $( "#subcategory").autocomplete({
            source: availableTags
        });
    });

 
   
</script>