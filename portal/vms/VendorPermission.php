
<script type="text/javascript" charset="utf-8">
 
    $(function(id)
    {
        var availableTags = [ <?php
                $Vendorname=odbc_exec($conn, "SELECT DISTINCT([Vendor Name]) FROM [VMS Vendor Master]");
                while(odbc_fetch_array($Vendorname)){
                    echo "'". odbc_result($Vendorname, "Vendor Name")."'";
                }
                             

               
            ?> ];

       
        $( "#vendorname").autocomplete({
            source: availableTags
        });
    });

 
    
    
   
</script>
