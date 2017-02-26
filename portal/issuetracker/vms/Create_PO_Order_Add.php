<?php
require_once("Header1.php");


      $pono= strtoupper(trim($_REQUEST['pono']));
      $postatus=trim($_REQUEST['postatus']);
      $vendorcode=strtoupper(trim($_REQUEST['vendorcode']));
      $vendor= strtoupper(trim($_REQUEST['vendor']));
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
      $vinvoicedate=strtoupper(trim($_REQUEST['vinvoicedate']));
      $grndate=strtoupper(trim($_REQUEST['grndate']));
      $vinvoicenogrn=strtoupper(trim($_REQUEST['vinvoicegrn']));
      
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
      $qtytoreceived=$_REQUEST['qtytoreceived'];
      $qtyreceived=$_REQUEST['qtyreceived'];
      $outstandingqty=$_REQUEST['outstandingqty'];
if(isset($_POST['submit']))
{
    
      
      if($itemname[0]!="")
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
                                [Release],
                                [VendorInvoiceDate],
                                [PostingGRNDate],
                                [VendorInvoiceNo],
                                [StoreCode],
                                [VendorCode]
                               
                                
				
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
                                    '".$shippingcountry."','".$financialyr."','".$release."','".strtotime(str_replace("/", " ",$vinvoicedate.date('H:i:s')))."','".strtotime(str_replace("/", " ",$grndate.date('H:i:s')))."','".$vinvoicenogrn."','".$storecode."','".$vendorcode."')";
                                   
         $resultpo = odbc_exec($conn, $SQLPO) or die(odbc_errormsg($conn));
      }  
            $qry1="select max(ID) AS ID from [VMS Create PO]";
            $result1 = odbc_exec($conn, $qry1) or die(odbc_errormsg($conn));
            $ltid1=odbc_fetch_array($result1);
            $resgtid1=$ltid1['ID'];
            
            $len=  count($itemname);
               
                for($i=0;$i<$len;$i++)
                {
                    if($itemname[$i]!="" && $vendor!="" && $shippingcontactname!="")
                    {
                     $totalrecive[$i]= $qtytoreceived[$i]+$qtyreceived[$i];
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
                                                [Qtytoreceive],
                                                [Qtyreceived],
                                                [Outstandingqty],
                                                [StoreCode],
                                                [VendorCode]

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
                                                   '".$resgtid1."','".$site[$i]."','".$warranty[$i]."','".$qtytoreceived[$i]."','".$qtyreceived[$i]."','".$outstandingqty[$i]."','".$storecode."','".$vendorcode."')";

                                      $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                              }
                                if($qtytoreceived[$i]>0)
                                {

                                   echo          $SQL5 = "INSERT INTO [VMS Item Ledger] (
                                                      [Company Name],
                                                [EntryNo],
                                               [EntryType],
                                               [VendorCodeSourceNo],
                                               [ReceivedDate],
                                               [ItemCode],
                                               [PODocumentNo],
                                               [StoreCode],
                                               [QtyReceived],
                                               [Positive],
                                               [PoDocumentDate],
                                               [UOM],
                                               [Amount],
                                               [PODocumentType],
                                               [Gtotal],
                                               [QtytoReceive],
                                               [OutstandingQty],
                                               [PO Qty],
                                               [PO ID]


                                       ) VALUES ('".$CompName."',
                                                   '".$vendorcode."',
                                                   'Purchase',
                                                   '".$vendorcode."',
                                                     '".strtotime(str_replace("/", " ",$receiveddate.date('H:i:s')))."',
                                                   '".$itemname[$i]."',
                                                   '".$pono."',
                                                   '".$storecode."',
                                                   '".$totalrecive[$i]."',
                                                  '".$vendorcode."',
                                                    '".strtotime(str_replace("/", " ",$purchasedate.date('H:i:s')))."',
                                                   '".$uom[$i]."',
                                                   '".$subtotal[$i]."',
                                                   '".$vendorcode."','".$gtotal."','".$qtytoreceived[$i]."','".$outstandingqty[$i]."','".$qty[$i]."','".$resgtid1."')";

                             $result = odbc_exec($conn, $SQL5) or die(odbc_errormsg($conn));
                    }
                                         
              } 
         

                
                 if($itemname[0]!="" && $vendor!="" && $shippingcontactname!="")
       {
                     $SQLTERM = "INSERT INTO [VMS Term Condition] (
                                [Company Name],
                                [Term Condition],
                                [PO ID]
                                
				
			) VALUES ('".$CompName."',
                                    '".$term."',
                                    '".$resgtid1."')";
                                   
          $resultterm = odbc_exec($conn, $SQLTERM) or die(odbc_errormsg($conn));
       }
         echo '<META http-equiv="refresh" content="0;URL=PurchaseOrderListBKUP.php"> ';  
         
         if(!$result)
         {
             echo '<META http-equiv="refresh" content="0;URL=Create_PO_Order.php"> ';  
         }
   }

?>




