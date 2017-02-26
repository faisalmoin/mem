 <?php 
 require_once("../db.txt");
 if(isset($_POST['submit']))
 {
    $fid='00001';
    $qry="select max(ID) AS ID from [VMS Vendor Master]";
 $result = odbc_exec($conn, $qry) or die(odbc_errormsg($conn));
 $ltid=odbc_fetch_array($result);
 $resgtid1=$ltid['ID'];
 $resgtid=$resgtid1+1;
 $lpoid=str_pad($resgtid,4,"0",STR_PAD_LEFT);
 if($resgtid>=1)
 {
    echo  $newvendorid=trim($lpoid."(".$_REQUEST['vendorname'].")");
 }
 else 
     
 {
    $newvendorid=trim($fid."(".$_REQUEST['vendorname'].")");
 }
   
    
      if($_REQUEST['vendorname']!="" && $_REQUEST['tin']!="" && $_REQUEST['pan']!="" && $_REQUEST['tan']!=""
        && $_REQUEST['bankcode']!="" && $_REQUEST['bankname']!="" && $_REQUEST['accountnumber']!="")
       {
     
          $SQL1 = "INSERT INTO [VMS Vendor Master] (
                                [Company Name],
                                [Vendor Name],
                                [Address],
				                [City],
                                [State],
                                [Country],
                                [Post Code],
                                [Mobile],
                                [Email],
				                [TIN],
                                [CST],
                                [PAN],
                                [TAN],
                                [Service Tax Number],
                                [SME],
				                [Contact Person Details],
                                [Contact Details],
                                [Bank Code],
                                [Bank Name],
                                [Bank Account Number],
                                [RTGS Code],
                                [Remittance Address],
				                [Requested By],
                                [Remittance Mobile],
                                [Office Area],
                                [Reason New Vendor],
                                [Approved By],
                                [Date],
                                [CIN],
                                [vendorcode]
                                
				
		                  	) VALUES ('".$CompName."',
                                    '".trim($_REQUEST['vendorname'])."',
                                    '".trim($_REQUEST['address'])."',
                                    '".trim($_REQUEST['city'])."',
                                    '".trim($_REQUEST['state'])."',
                                    '".trim($_REQUEST['country'])."',
                                    '".trim($_REQUEST['postcode'])."',
                                    '".trim($_REQUEST['mobile'])."',
                                    '".trim($_REQUEST['email'])."',
                                    '".trim($_REQUEST['tin'])."',
                                    '".trim($_REQUEST['cstnumber'])."',
                                    '".trim($_REQUEST['pan'])."',
                                    '".trim($_REQUEST['tan'])."',
                                    '".trim($_REQUEST['strn'])."',
                                    '".trim($_REQUEST['sme'])."',
                                    '".trim($_REQUEST['contactperson'])."',
                                    '".trim($_REQUEST['contactpersondetails'])."',
                                    '".trim($_REQUEST['bankcode'])."',
                                    '".trim($_REQUEST['bankname'])."',
                                    '".trim($_REQUEST['accountnumber'])."',
                                    '".trim($_REQUEST['rtgscode'])."',
                                    '".trim($_REQUEST['remittanceaddress'])."',
                                    '".trim($_REQUEST['requestedby'])."',
                                    '".trim($_REQUEST['mobile'])."',
                                    '".trim($_REQUEST['officearea'])."',
                                    '".trim($_REQUEST['newvendorcreation'])."',
                                    '".trim($_REQUEST['approvedby'])."',
                                    '".strtotime(str_replace("/", " ",$_REQUEST["date"].date('H:i:s')))."',
                                     '".trim($_REQUEST['cin'])."', '".$newvendorid."'
                                   )";
              
                                       $result1 = odbc_exec($conn, $SQL1) or die(odbc_errormsg($conn));
                
       }        if($result1)
       {
                                   header('Location: Create_Vendor.php?message=success');
       }
                                          
                                   
       
 } 
                                    
?>

