 <?php 
$id=$_REQUEST['id'];
 require_once("../db.txt");
 if(isset($_POST['submit']))
 {
    
       
     
    echo    $sql_update = "UPDATE [VMS Vendor Master] SET
                               
                                [Vendor]='".trim($_REQUEST['vendor'])."',
                                [Address]='".trim($_REQUEST['address'])."',
				[City]='".trim($_REQUEST['city'])."',
                                [State]='".trim($_REQUEST['state'])."',
                                [Country]='".trim($_REQUEST['country'])."',
                                [Post Code]='".trim($_REQUEST['postcode'])."',
                                [Mobile]='".trim($_REQUEST['mobile'])."',
                                [Email]='".trim($_REQUEST['email'])."',
				[TIN]='".trim($_REQUEST['tin'])."',
                                [CST]='".trim($_REQUEST['cst'])."',
                                [PAN]='".trim($_REQUEST['pan'])."',
                                [TAN]='".trim($_REQUEST['tan'])."',
                                [Service Tax Number]='".trim($_REQUEST['stn'])."',
                                [SME]='".trim($_REQUEST['sme'])."',
				[Vendor Name]='".trim($_REQUEST['vendorname'])."',
                                [Contact Details]='".trim($_REQUEST['contactpersondetails'])."',
                                [Bank Code]='".trim($_REQUEST['bankcode'])."',
                                [Bank Name]='".trim($_REQUEST['bankname'])."',
                                [Bank Account Number]='".trim($_REQUEST['bankaccountnumber'])."',
                                [RTGS Code]='".trim($_REQUEST['rtgscode'])."',
                                [Remittance Address]='".trim($_REQUEST['remittanceaddress'])."',
				[Requested By]='".trim($_REQUEST['requestedby'])."',
                                [Remittance Mobile]='".trim($_REQUEST['remittancemobile'])."',
                                [Office Area]='".trim($_REQUEST['officearea'])."',
                                [Reason New Vendor]='".trim($_REQUEST['newvendor'])."',
                                [Approved By]='".trim($_REQUEST['approvedby'])."',
                                [Date]='".strtotime(str_replace("/", " ",$_REQUEST["date"].date('H:i:s')))."',
                                [CIN]='".trim($_REQUEST['cin'])."'
                                
							
				where [ID]='".$id."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		
		echo '<META http-equiv="refresh" content="0;URL=VendorItemList.php"> ';
       
 } 
                                    
?>

