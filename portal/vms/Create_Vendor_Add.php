 <?php 
 //require_once("Header1.php");
 require_once("../db.txt");
 if(isset($_POST['submit']))
 {
    $err=0;
     $fid='00001';
     $qry="select max(ID) AS ID from [VMS Vendor Master]";
     $result = odbc_exec($conn, $qry) or die(odbc_errormsg($conn));
     $ltid=odbc_fetch_array($result);
     $resgtid1=$ltid['ID'];
     $resgtid=$resgtid1+1;
     $lpoid=str_pad($resgtid,4,"0",STR_PAD_LEFT);
     if($resgtid>=1)
     {
          $newvendorid=$lpoid."(".trim(strtoupper($_POST["vendor"])).")";
     }
     else 
         
     {
        $newvendorid=$fid."(".trim(strtoupper($_POST["vendor"])).")";
     }
     
       
      
     if (empty($_POST["vendor"])) {
        $err++;
    }
    else {
        $vendor = trim($_POST["vendor"]);
    }
     if (empty($_POST["vendorname"])) {
        $err++;
    }
    else {
        $vendorname = $_POST["vendorname"];
    }
   
     if (empty($_POST["city"])) {
        $err++;
    }
    else {
        $city = $_POST["city"];
    }
      if (empty($_POST["state"])) {
       $err++;
    }
    else {
        $state = $_POST["state"];
    }
     if (empty($_POST["country"])) {
        $err++;
    }
    else {
        $country = $_POST["country"];
    }
     if (empty($_POST["postcode"])) {
        $err++;
    }
    else {
        $postcode = $_POST["postcode"];
    }
     if (empty($_POST["bankcode"])) {
        $err++;
    }
    else {
        $bankcode = $_POST["bankcode"];
    }
      if (empty($_POST["bankname"])) {
        $err++;
    }
    else {
        $bankname = $_POST["bankname"];
    }
     if (empty($_POST["accountnumber"])) {
        $err++;
    }
    else {
        $accountnumber = $_POST["accountnumber"];
    }
   if (empty($_POST["mobile"])) {
       $err++;
    }
    else {
        $mobile = $_POST["mobile"];
    }
     if (empty($_POST["email"])) {
       $err++;
    }
    else {
        $email = $_POST["email"];
    }
    if (empty($_POST["pan"])) {
        $err++;
    }
    else {
        $pan = $_POST["pan"];
    }
    
  if($err==0)
       {
       
     
        $SQL1 = "INSERT INTO [VMS Vendor Master] (
                                [Company Name],
                                [Vendor],
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
				                [Vendor Name],
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
                                    '".trim($vendor)."',
                                    '".trim($_REQUEST['address'])."',
                                    '".trim($city)."',
                                    '".trim($state)."',
                                    '".trim($country)."',
                                    '".trim($postcode)."',
                                    '".trim($mobile)."',
                                    '".trim($email)."',
                                    '".trim($_REQUEST['tin'])."',
                                    '".trim($_REQUEST['cstnumber'])."',
                                    '".trim($pan)."',
                                    '".trim($_REQUEST['tan'])."',
                                    '".trim($_REQUEST['strn'])."',
                                    '".trim($_REQUEST['sme'])."',
                                    '".trim($vendorname)."',
                                    '".trim($_REQUEST['contactpersonmobile'])."',
                                    '".trim($bankcode)."',
                                    '".trim($bankname)."',
                                    '".trim($accountnumber)."',
                                    '".trim($_REQUEST['rtgscode'])."',
                                    '".trim($_REQUEST['remittanceaddress'])."',
                                    '".trim($_REQUEST['requestedby'])."',
                                    '".trim($_REQUEST['contactmobile'])."',
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

