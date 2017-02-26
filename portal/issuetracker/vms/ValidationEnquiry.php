<script type="text/javascript" charset="utf-8">
    $(function()
    {
        var availableTags = [ <?php
                $City_Tag1=odbc_exec($conn, "SELECT DISTINCT([City]) FROM [PostCode] ORDER BY [City]");
                while(odbc_fetch_array($City_Tag1)){
                    //echo "'". odbc_result($City_Tag1, "City")."', ";
                }
                $State_Tag1=odbc_exec($conn, "SELECT DISTINCT([State]) FROM [PostCode] ORDER BY [State]");
                while(odbc_fetch_array($State_Tag1)){
                    echo "'". odbc_result($State_Tag1, "State")."', ";
                }
                $Country_Tag1=odbc_exec($conn, "SELECT DISTINCT([Country]) FROM [PostCode] ORDER BY [Country]");
                while(odbc_fetch_array($Country_Tag1)){
                    echo "'". odbc_result($Country_Tag1, "Country")."', ";
                }
            ?> ];

       
        $( "#city, #state, #country" ).autocomplete({
            source: availableTags
        });
    });

   
   

</script>
