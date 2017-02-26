<?php
        require_once("header.php");
		echo "<br /><br /><br /><br />";

//Step - 4 | Academic Year & Class to be dynamic
$BalAccCode = odbc_exec($conn, "select * from [".$ms."Discount Fee Line] WHERE [Academic year]='".$AcadYear."' AND [Class] = '".$Class."' AND [Fee Type Code] = 'INITIAL' ");
$BalAccCodeRec = odbc_num_rows($BalAccCode);

//MaxLine No to be on loop
for($i = 0; $i <= $BalAccCodeRec; $i++){

    while(odbc_fetch_array($BalAccCode)){
        $FeeCode = odbc_result($BalAccCode, "Fee Code");
        $ADMCode = odbc_exec($conn, "SELECT [G_L Account] FROM [".$ms."Fee Components] WHERE [Code]='".odbc_result($BalAccCode, "Fee Code")."'");
        $BalancingAccountNo = odbc_result($ADMCode, "G_L Account");
        $Amount = odbc_result($BalAccCode, "Amount");
        $DebitAmount = $Amount;
        $Description = odbc_result($BalAccCode, "Description");
    }   
}
        ?>