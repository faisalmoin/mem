
<script type="text/javascript" charset="utf-8">
 
    $(function(id)
    {
        var availableTags = [ <?php
                $Itemname=odbc_exec($conn, "SELECT DISTINCT([Item Name]) FROM [VMS Item Master] ");
                while(odbc_fetch_array($Itemname)){
                    echo "'". odbc_result($Itemname, "Item Name")."'";
                }
                             

               
            ?> ];

       
        $( "#itemname").autocomplete({
            source: availableTags
        });
    });

 
    
    
   
</script>
