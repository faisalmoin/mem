

<script type="text/javascript" charset="utf-8">
 
    $(function()
    {
        var availableTags = [ <?php
                $City_Tag1=odbc_exec($conn, "SELECT [ID],[Item category] FROM [VMS Item Category Master] ");
                while(odbc_fetch_array($City_Tag1)){
                    echo "'". odbc_result($City_Tag1, "Item Category")."', ";
                }
               
                          
            ?> ];

       
        $( "#category").autocomplete({
            source: availableTags
        });
    });

 
     $(function()
    {
        var availableTags1 = [ <?php
               
              
               $State_Tag1=odbc_exec($conn, "SELECT [VMS Subcategory Master].[Sub Category] FROM [VMS Subcategory Master]");
                while(odbc_fetch_array($State_Tag1)){
                    echo "'". odbc_result($State_Tag1, "Sub Category")."', ";
                }                

               
            ?> ];

       
        $( "#subcategory").autocomplete({
            source: availableTags1
        });
    });
    
   
</script>
