<?php 
//print_r($_POST);
$CompName = $_REQUEST['CompName'];
$Name = $_REQUEST['Name'];
if($_REQUEST['Name']==1)
{
	echo '<META http-equiv="refresh" content="0;URL=RoyaltySetup02.php?CompName='.$CompName.'"> ';
//	require_once("RoyaltySetup02.php");
}
else if($_REQUEST['Name']==2)
{
	echo '<META http-equiv="refresh" content="0;URL=Franchisee.php?CompName='.$CompName.'"> ';
	//require_once("Franchisee.php");
}

else if($_REQUEST['Name']==3)
{
	echo '<META http-equiv="refresh" content="0;URL=Royalty.php?CompName='.$_REQUEST['Name'].'"> ';
	//require_once("Royalty.php");
}

else{
	echo '<META http-equiv="refresh" content="0;URL=RoyaltySetup.php"> ';
	//require_once("RoyaltySetup.php");
}

?>