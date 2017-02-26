 <?php
 require_once("Header1.php"); 
 //print_r($_POST);die;

echo  $poid=$_REQUEST['ID'];
       $id=$_REQUEST['hiddenfinalpoid'];

      $pono= strtoupper(trim($_REQUEST['pono']));
      $postatus=trim($_REQUEST['postatus']);
      $vendor= strtoupper(trim($_REQUEST['supplier']));
      $purchasedate= strtoupper(trim($_REQUEST['purchasedate']));
      $receiveddate= strtoupper(trim($_REQUEST['needdate']));
      $expecteddate= strtoupper(trim($_REQUEST['expecteddate']));
      $vendorcontactname= trim($_REQUEST['vendorcontactname']);
      $vendorquoteno= trim($_REQUEST['vendorquoteno']);
      $mobile= trim($_REQUEST['mobile']);
      $email= trim($_REQUEST['email']);
      $address= trim($_REQUEST['address']);
      $postcode= trim($_REQUEST['postcode']);
      $state= trim($_REQUEST['state']);
      $city=strtoupper(trim($_REQUEST['city']));
      $country=strtoupper(trim($_REQUEST['country']));
      $shippingcontactname=strtoupper(trim($_REQUEST['shippingname']));
      $shippingmobile= trim($_REQUEST['shippingmobile']);
      $shippingemail= trim($_REQUEST['shippingemail']);
      $shippingaddress= trim($_REQUEST['shippingaddress']);
      $shippingpostcode= trim($_REQUEST['shippingpostcode']);
      $shippingstate= trim($_REQUEST['shippingstate']);
      $shippingcity=strtoupper(trim($_REQUEST['shippingcity']));
      $shippingcountry=strtoupper(trim($_REQUEST['shippingcountry']));

       $ItemName=$_REQUEST['itemname'];
       $Specifications=$_REQUEST['specifications'];
      $UOM=$_REQUEST['uom'];
      $Qty=$_REQUEST['qty'];
      $UnitPrice=$_REQUEST['price'];
      $VATCST=$_REQUEST['vatcst'];
      $ServiceTax=$_REQUEST['vatservice'];
      $SubTotal=$_REQUEST['subtotal'];
      $GTotal=$_REQUEST['gtotal'];
      $termncondition=$_REQUEST['termncondition'];
      $site=$_REQUEST['site'];
      $warranty=$_REQUEST['warranty'];
      $postatus=$_REQUEST['postatus'];
      $len=count($_REQUEST['itemname']);
      //print_r($_POST);
      echo $len;
 if(isset($_POST['submit']))

 {

                               $sql_update = "UPDATE [VMS Create PO] SET
                               
                                [PO Status]='".$postatus."',
                                [Vendor]='".$vendor."',
                                [Purchase Date]='".$purchasedate."',
                                [Received Date]='".$receiveddate."',
                                [Expected Date]='".$expecteddate."',
                                [Vendor Contact Name]='".$vendorcontactname."',
                                [Vendor Quote No]='".$vendorquoteno."',
                                [Mobile]='".$mobile."',
                                [Email]='".$email."',
                                [Address]='".$address."',
                                [Postal Code]='".$postcode."',
                                [State]='".$state."',
                                [City]='".$city."',
                                [Country]='".$country."',
                                [Shipping Contact Name]='".$shippingcontactname."',
                                [Shipping Mobile]='".$shippingmobile."',
                                [Shipping Email]='".$shippingemail."',
                                [Shipping Address]='".$shippingaddress."',
                                [Shipping Post Code]='".$shippingpostcode."',
                                [Shipping State]='".$shippingstate."',
                                [Shipping City]='".$shippingcity."',
                                [Shipping Country]='".$shippingcountry."',
                              
                                    
                where [ID]='".$poid."' ";
                 // odbc_exec($conn, $sql_update1) or die(odbc_errormsg($conn));

        for($i=0; $i<$len; $i++)
        {
                                      $qry="select [Item Name] from [VMS Final PO] WHERE [PO ID]='".$_REQUEST['ID']."' and [Item Name]='".$ItemName[$i]."' ";
                                         $result = odbc_exec($conn, $qry) or die(odbc_errormsg($conn));
                                         $res=odbc_fetch_array($result);
                                         echo $item= $res['Item Name'];


        
                                      if($item=="")
            
                                      {
                                               $SQL = "INSERT INTO [VMS Final PO] (
                                                         [Company Name],
                                                         [Vendor Name],
                                                         [PO No],
                                                         [Item type],
                                                         [Item Name],
                                                         [Specifications],
                                                         [UOM],
                                                         [Qty],
                                                         [Unit Price],
                                                         [VAT CST],
                                                         [Service Tax],
                                                         [Sub Total],
                                                         [Gtotal],
                                                          [PO ID],
                                                          [Site],
                                                          [Warranty]

                                           ) VALUES ('".$CompName."',
                                                       '".$vendor."',
                                                       '".$pono."',
                                                       '".$itemtype[$i]."',
                                                       '".$itemname[$i]."',
                                                       '".$specifications[$i]."',
                                                       '".$uom[$i]."',
                                                       '".$qty[$i]."',
                                                       '".$price[$i]."',
                                                       '".$vatcst[$i]."',
                                                       '".$vatservice[$i]."',
                                                       '".$subtotal[$i]."',
                                                       '".$gtotal."',
                                                       '".$resgtid1."','".$site[$i]."','".$warranty[$i]."')";

                                               // $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                                   }

          else
          {
      
               $sql_update1 = "UPDATE [VMS Final PO] SET
                               
                                [Item Name]='".$ItemName[$i]."',
                                [Specifications]='".$Specifications[$i]."',
                                [UOM]='".$UOM[$i]."',
                                [Qty]='".$Qty[$i]."',
                                [Unit Price]='".$UnitPrice[$i]."',
                                [VAT CST]='".$VATCST[$i]."',
                                [Service Tax]='".$ServiceTax[$i]."',
                                [Sub Total]='".$SubTotal[$i]."',
                                [Gtotal]='".$GTotal."',
                                [Site]='".$site[$i]."',
                                [Warranty]='".$warranty[$i]."'
                              
                                    
               WHERE [PO ID]='".$_REQUEST['ID']."' and [Item Name]='".$ItemName[$i]."' ";
                 // odbc_exec($conn, $sql_update1) or die(odbc_errormsg($conn));
              
               
        }
    }
    
        
               $sql_updateterm = "UPDATE [VMS Term Condition] SET
                               
                                [Term Condition]='".$termncondition."'
                                                                    
                                         where [PO ID]='".$_REQUEST['ID']."' ";
                
             //  odbc_exec($conn, $sql_updateterm) or die(odbc_errormsg($conn));
        
             //  echo  '<META http-equiv="refresh" content="0;URL=PurchaseOrderList.php"> ';
 
  }
    
 
                                    
?>

