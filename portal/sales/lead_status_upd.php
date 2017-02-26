<?php
	require_once("../db.txt");
	
	$date = time();
	
	$Status = $_REQUEST['Status'];
	//$ID = $_REQUEST['id'];
        $ID = odbc_result($get_id, "ID");
	$land = $_REQUEST['land'];
	$invest = $_REQUEST['invest'];
	
	//UPDATE Lead Status	
	echo "A";
	odbc_exec($conn, "UPDATE [CRM Lead] SET [Status]='$Status' WHERE [ID]=$ID ") or die(odbc_errormsg());
	
	//Convert to Opurtunity
	//if($Status == "Qualified"){
                echo "B";
		$Lead = odbc_exec($conn, "SELECT * FROM [CRM Lead] WHERE [ID]='$ID' ") or die(odbc_errormsg($conn));
		echo "C";
		$No = odbc_exec($conn, "SELECT COUNT([ID])+1 FROM [CRM Oppurtunity]") or die(odbc_errormsg($conn));
                echo "D";
		$Opp = "
			INSERT INTO [CRM Oppurtunity]
				   ([Opp Date]
				   ,[Name]
				   ,[Status]
				   ,[Job Title]
				   ,[Company Name]
				   ,[Office Phone]
				   ,[Source]
				   ,[Mobile]
				   ,[Office Fax]
				   ,[Email]
				   ,[Address 1]
				   ,[Address 2]
				   ,[City]
				   ,[State]
				   ,[Post Code]
				   ,[Country]
				   ,[Industry]
				   ,[Website]
				   ,[Description]
				   ,[Likely Brand]
				   ,[Location of School]
				   ,[User ID]
				   ,[Lead No]
				   ,[Assign To]
				   ,[Lead Date]
				   ,[land]
				   ,[investment],
				   [Opp No],
				   [Stage],
				   [Level])
			     VALUES
				   ('$date'
				   ,'".odbc_result($Lead, "Name")."'
				   ,'".odbc_result($Lead, "Status")."'
				   ,'".odbc_result($Lead, "Job Title")."'
				   ,'".odbc_result($Lead, "Company Name")."'
				   ,'".odbc_result($Lead, "Office Phone")."'
				   ,'".odbc_result($Lead, "Source")."'
				   ,'".odbc_result($Lead, "Mobile")."'
				   ,'".odbc_result($Lead, "Office Fax")."'
				   ,'".odbc_result($Lead, "Email")."'
				   ,'".odbc_result($Lead, "Address 1")."'
				   ,'".odbc_result($Lead, "Address 2")."'
				   ,'".odbc_result($Lead, "City")."'
				   ,'".odbc_result($Lead, "State")."'
				   ,'".odbc_result($Lead, "Post Code")."'
				   ,'".odbc_result($Lead, "Country")."'
				   ,'".odbc_result($Lead, "Industry")."'
				   ,'".odbc_result($Lead, "Website")."'
				   ,'".odbc_result($Lead, "Description")."'
				   ,'".odbc_result($Lead, "Likely Brand")."'
				   ,'".odbc_result($Lead, "Location of School")."'
				   ,'".odbc_result($Lead, "User ID")."'
				   ,'".odbc_result($Lead, "Lead No")."'
				   ,'".odbc_result($Lead, "Assign To")."'
				   ,'".odbc_result($Lead, "Lead Date")."'
				   ,'".$land."'
				   ,'".$invest."'
				   ,'OPP".str_pad(odbc_result($No, "") , 6, 0, STR_PAD_LEFT)."'
				   , 'Conversion'
				   ,'Lead ID: ".odbc_result($Lead, "Lead No")." qualified to Oppurtunity') ";

		odbc_exec($conn, $Opp) or die(odbc_errormsg($conn));
		echo "E";
		//Insert Opp Activity
                $OppSQL = "INSERT INTO [CRM Opp Activity]([Opp ID], [Date], [Stage], [Level], 
                        [Contact Person], [Contact No], [Remarks], [Activity Status], 
                        [Post Date], [Assign To], [Activities], [Outcome]) VALUES 
                        ('OPP".str_pad(odbc_result($No, "") , 6, 0, STR_PAD_LEFT)."','$date', 'Qualified', 'Conversion',
                        '".odbc_result($Lead, "Name")."', '".odbc_result($Lead, "Mobile")."', 'Lead ID: ".odbc_result($Lead, "Lead No")." qualified to Opportunity', 'Qualified', 
                        '$date', '".odbc_result($Lead, "Assign To")."','Lead ID: ".odbc_result($Lead, "Lead No")." qualified to Opportunity', 'Converted' )";
                echo "<br />$OppSQL <br />";
		odbc_exec($conn, $OppSQL) or die(odbc_errormsg($conn));
	//}

?>