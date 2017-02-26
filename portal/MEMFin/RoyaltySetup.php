<?php
	require_once("header.php");
	$pageId=$_REQUEST['pg_id'];
	//require_once("../db.txt");
	
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if($pageId==1)
		{
			echo '<META http-equiv="refresh" content="0;URL=RoyaltySetup02.php?CompName='.$_REQUEST['CompName'].'"> ';
			//	require_once("RoyaltySetup02.php");
		}
		else if($pageId==2)
		{
			echo '<META http-equiv="refresh" content="0;URL=Franchisee.php?CompName='.$_REQUEST['CompName'].'"> ';
			//require_once("Franchisee.php");
		}
		
		else if($pageId==3)
		{
			echo '<META http-equiv="refresh" content="0;URL=Royalty.php?CompName='.$_REQUEST['CompName'].'"> ';
			//require_once("Royalty.php");
		}
		
		else{
			echo '<META http-equiv="refresh" content="0;URL=RoyaltySetup.php"> ';
			//require_once("RoyaltySetup.php");
		}
	  }
  ?>
<div class="container">
    <table  style="width: 40%;margin: 0 auto; margin-top: 4em" class="table table-responsive table-bordered">
        <tr>
            <th style="background-color: #d4d2d2;">
                <?php
                    if($pageId == 1) echo "<h4>School's Royalty Setup</h4>";
                    else if($pageId == 2) echo "<h4>Invoice Generate - Franchisee</h4>";
                    else if($pageId == 3) echo "<h4>Invoice Generate - School</h4>";
                    //else ech
                ?>
            </th>
        </tr>
    <tr>
        <td colspan='2' style='padding: 25px; border: none;' valign="top">
            <form method="post" action="#">
                <?php
                if($pageId==1 || $pageId==3) echo "School ";
                else if($pageId==2) echo "Franchisee ";
                ?> Name: 

                <select name="CompName" class="form-control" style="width: 380px;padding: 8px;" required>
                        <option value=""></option>
                        <?php
                           if($pageId == "1" || $pageId == "3"){ 
                                $cmp = odbc_exec($conn, "SELECT [Name], [ID],[City], [State] FROM [Company Information] ORDER BY [Name]") or die(odbc_errormsg($conn));
                           }
                           else if($pageId == "2") {
                                $cmp = odbc_exec($conn, "SELECT [Name], [ID],[City], [State] FROM [CRM Agreement] ORDER BY [Name]") or die(odbc_errormsg($conn));
                           }

                                while(odbc_fetch_array($cmp)){
                                        echo '<option value="'.odbc_result($cmp, "ID").'">'.odbc_result($cmp, "Name").' // '.odbc_result($cmp, "City").' // '.odbc_result($cmp, "State").'</option>';
                                }									   
                        ?>
                </select>
                <br />
                <button class="btn btn-primary">Next</button>
            </form>
        </td>
    </tr>
    </table>
</div>
<?php require_once("../footer.php"); ?>