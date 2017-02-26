<?php
require_once("Header1.php");
//require_once("../db.txt");

     
     
if(isset($_POST['submit']))
{
 
      $pono= strtoupper(trim($_REQUEST['pono']));
      $postatus=trim($_REQUEST['postatus']);
      $vendorcode=strtoupper(trim(strtoupper($_REQUEST['vendorcode'])));
      $vendor= strtoupper(trim($_REQUEST['vendorsname']));
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
      $financialyr=strtoupper(trim($_REQUEST['financialyr']));
      $release=strtoupper(trim($_REQUEST['release']));
     
      
      $storecode=strtoupper(trim($_REQUEST['storecode']));
      
      $itemtype=$_REQUEST['itemtype'];
      $itemname=$_REQUEST['itemname'];
      $specifications=$_REQUEST['specifications'];
      $uom=$_REQUEST['uom'];
      $qty=$_REQUEST['qty'];
      $price=$_REQUEST['price'];
      $vatcst=$_REQUEST['vatcst'];
      $vatservice=$_REQUEST['vatservice'];
      $subtotal=$_REQUEST['subtotal'];
      $gtotal=$_REQUEST['gtotal'];
      $term=$_REQUEST['termncondition'];
      $site=$_REQUEST['site'];
      $warranty=$_REQUEST['warranty'];
      $chktk=$_REQUEST['chktk'];
  
    $err=0;
     if(isset($_POST['release']))
     {
      $release ='1';
     }
     else{
      $release ='0';
     }
       
  
             for($i=0; $i<count($itemname); $i++)
                {
                   if (empty($itemname[$i]) || empty($specifications[$i]) || empty($uom[$i]) ||($qty[$i]==0)) {
                         $err++;
                        
                        } 
                } 
     
      if($vendorcode!="" && $purchasedate!="" && $mobile!="" && $address!="" && $shippingmobile!="" && $shippingaddress!="" && $receiveddate!="" && $expecteddate!="" && $vendorquoteno!="" && $storecode!="" && $err==0 )
    {
      
          $SQLPO = "INSERT INTO [VMS Create PO] (
                                [Company Name],
                                [PO No],
                                [PO Status],
                                [Vendor],
                                [Purchase Date],
                                [Received Date],
                                [Expected Date],
                                [Vendor Contact Name],
                                [Vendor Quote No],
                                [Mobile],
                                [Email],
                                [Address],
                                [Postal Code],
                                [State],
                                [City],
                                [Country],
                                [Shipping Contact Name],
                                [Shipping Mobile],
                                [Shipping Email],
                                [Shipping Address],
                                [Shipping Post Code],
                                [Shipping State],
                                [Shipping City],
                                [Shipping Country],
                                [Financial Year],
                                [StoreCode],
                                [VendorCode],
                                [Release]
                               
                                
        
                         ) VALUES ('".$CompName."',
                                    '".$pono."',
                                    '".$postatus."',
                                    '".$vendor."',
                                    '".strtotime(str_replace("/", " ",$purchasedate.date('H:i:s')))."',
                                    '".strtotime(str_replace("/", " ",$receiveddate.date('H:i:s')))."',
                                    '".strtotime(str_replace("/", " ",$expecteddate.date('H:i:s')))."',
                                    '".$vendorcontactname."',
                                    '".$vendorquoteno."',
                                    '".$mobile."',
                                    '".$email."',
                                    '".$address."',
                                    '".$postcode."',
                                    '".$state."',
                                    '".$city."',
                                    '".$country."',
                                    '".$shippingcontactname."',
                                    '".$shippingmobile."',
                                    '".$shippingemail."',
                                    '".$shippingaddress."',
                                    '".$shippingpostcode."',
                                    '".$shippingstate."',
                                    '".$shippingcity."',
                                    '".$shippingcountry."','".$financialyr."','".$storecode."','".$vendorcode."','".$release."')";
                                   
         $resultpo = odbc_exec($conn, $SQLPO) or die(odbc_errormsg($conn));
       }
            $qry1="select max(ID) AS ID from [VMS Create PO]";
            $result1 = odbc_exec($conn, $qry1) or die(odbc_errormsg($conn));
            $ltid1=odbc_fetch_array($result1);
            $resgtid1=$ltid1['ID'];
            
            $len=  count($itemname);
               
                for($i=0; $i<$len; $i++)
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
                                                [Warranty],
                                                [StoreCode],
                                                [VendorCode],
                                                [Qtytoreceive],
                                                [Qtyreceived],
                                                [Outstandingqty]

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
                                                   '".$resgtid1."','".$site[$i]."','".$warranty[$i]."','".$storecode."','".$vendorcode."','0','0','".$qty[$i]."')";

                                     $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                              }
                                
            
         

                
                     $SQLTERM = "INSERT INTO [VMS Term Condition] (
                                [Company Name],
                                [Term Condition],
                                [PO ID]
                                
        
                          ) VALUES ('".$CompName."',
                                    '".trim($term)."',
                                    '".$resgtid1."')";
                                   
          $resultterm = odbc_exec($conn, $SQLTERM) or die(odbc_errormsg($conn));
            }
        if($resultpo){

           echo  '<META http-equiv="refresh" content="0;URL=PurchaseOrderListBKUP.php?success=0"> ';
        
      
         }
         if(!$resultpo)
         {
            echo  '<META http-equiv="refresh" content="0;URL=Create_PO_Order.php?success=1"> ';
         //Header( 'Location: Create_PO_Order.php?success=1');
         }


?>




