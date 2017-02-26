 <?php
 //require_once("Header1.php"); 
 require_once("../db.txt"); 
        $poid=$_REQUEST['ID'];
    //$id=$_REQUEST['hiddenfinalpoid'];

      $pono= strtoupper(trim($_REQUEST['pono']));
     //$postatus=trim($_REQUEST['postatus']);
      $vendorsupplier= strtoupper(trim($_REQUEST['supplier']));
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
      $vinvoicedate=strtoupper(trim($_REQUEST['vinvoicedate']));
      $grndate=strtoupper(trim($_REQUEST['grndate']));
      $vinvoicenogrn=strtoupper(trim($_REQUEST['vinvoicegrn']));
      $vendorcode=strtoupper(trim($_REQUEST['vendorcode']));
      $storecode=strtoupper(trim($_REQUEST['storecode']));
      


      $ItemType=$_REQUEST['itemtype'];
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
      $qtytoreceived=$_REQUEST['qtytoreceived'];
      $qtyreceived=$_REQUEST['qtyreceived'];
      $outstandingqty=$_REQUEST['outstandingqty'];
 if(isset($_POST['submit']))

 {
        $sumq="select SUM([Qty]) as [qty] from [VMS Final PO] WHERE [PO ID]='".$poid."'";
        $resultsum = odbc_exec($conn, $sumq) or die(odbc_errormsg($conn));
        $tsum=odbc_result($resultsum,"qty");
  
                $sum=0; $sumreceive=0; $totalqty=0;
            for($i=0; $i<$len; $i++)
              {
               $totaloutstand[$i] = $outstandingqty[$i]-$qtytoreceived[$i];
                $totalreceive[$i] = $qtytoreceived[$i]+$qtyreceived[$i];
                   $sumos+=$totaloutstand[$i];
                   $sumreceive+=$totalreceive[$i];
                 
             }
             
          
             if($sumreceive==0){
               $postatus='Open';
            }
            if($sumos==0){
               $postatus='Closed';
            }
             if($sumreceive>0 && $sumreceive<$tsum){
               $postatus='Short Closed';
            }
                   $sql_update = "UPDATE [VMS Create PO] SET
                               
                                [PO Status]='".$postatus."',
                                [Vendor]='".$vendorcontactname."',
                                [Purchase Date]= '".strtotime(str_replace("/", " ",$purchasedate.date('H:i:s')))."',
                                [Received Date]='".strtotime(str_replace("/", " ",$receiveddate.date('H:i:s')))."',
                                [Expected Date]='".strtotime(str_replace("/", " ",$expecteddate.date('H:i:s')))."',
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
                                [VendorInvoiceDate]='".strtotime(str_replace("/", " ",$vinvoicedate.date('H:i:s')))."',
                                [PostingGRNDate]='".strtotime(str_replace("/", " ",$grndate.date('H:i:s')))."',
                                [VendorInvoiceNo]='".$vinvoicenogrn."',
                                [StoreCode]='".$storecode."',
                                [VendorCode]='".$vendorcode."'
                                                                  
                where [ID]='".$poid."'";
               odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));


        for($i=0; $i<$len; $i++)
        {
          $totalreceive[$i]= $qtytoreceived[$i]+$qtyreceived[$i];
          $totaloutstand[$i] = $outstandingqty[$i]-$qtytoreceived[$i];
                                    $qry="select [Item Name] from [VMS Final PO] WHERE [PO ID]='".$_REQUEST['ID']."' and [Item Name]='".$ItemName[$i]."' ";
                                         $result = odbc_exec($conn, $qry) or die(odbc_errormsg($conn));
                                         $l=odbc_num_rows($result);
                                       
                                      if($l=='0')
            
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
                                                           [Qtytoreceive],
                                                          [Qtyreceived],
                                                          [Outstandingqty],
                                                          [StoreCode],
                                                          [VendorCode]

                                           ) VALUES ('".$CompName."',
                                                       '".$vendor."',
                                                       '".$pono."',
                                                       '".$ItemType[$i]."',
                                                       '".$ItemName[$i]."',
                                                       '".$Specifications[$i]."',
                                                       '".$UOM[$i]."',
                                                       '".$Qty[$i]."',
                                                       '".$UnitPrice[$i]."',
                                                       '".$VATCST[$i]."',
                                                       '".$ServiceTax[$i]."',
                                                       '".$SubTotal[$i]."',
                                                       '".$GTotal."',
                                                        '".$poid."',
                                                       '".$site[i]."','".$warranty[$i]."','".$qtytoreceived[$i]."','".$totalreceive[$i]."','".$totaloutstand[$i]."','".$storecode."','".$vendorcode."') ";
                                             $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
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
                                [Warranty]='".$warranty[$i]."',
                                [Qtytoreceive]='".$qtytoreceived[$i]."',
                                [Qtyreceived]='".$totalreceive[$i]."',
                                [Outstandingqty]='".$totaloutstand[$i]."',
                                [StoreCode]='".$storecode."',
                                [VendorCode]='".$vendorcode."'
                              
                                    
               WHERE [PO ID]='".$poid."' and [Item Name]='".$ItemName[$i]."' ";
                odbc_exec($conn, $sql_update1) or die(odbc_errormsg($conn));
              if($qtytoreceived[$i]>0)
              {
                      $SQL5 = "INSERT INTO [VMS Item Ledger] (
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
                                                   'GL',
                                                   'Purchase',
                                                   '".$vendorcode."',
                                                     '".strtotime(str_replace("/", " ",$receiveddate.date('H:i:s')))."',
                                                   '".$ItemName[$i]."',
                                                   '".$pono."',
                                                   '".$storecode."',
                                                   '".$totalreceive[$i]."',
                                                  '',
                                                    '".strtotime(str_replace("/", " ",$purchasedate.date('H:i:s')))."',
                                                   '".$UOM[$i]."',
                                                   '".$SubTotal[$i]."',
                                                   '".$vendorcode."','".$GTotal."','".$qtytoreceived[$i]."','".$totaloutstand[$i]."','".$Qty[$i]."','".$poid."')";

                           $result = odbc_exec($conn, $SQL5) or die(odbc_errormsg($conn));
              }
            }
        }
     
    
        
             $sql_updateterm = "UPDATE [VMS Term Condition] SET
                               
                                [Term Condition]='".$termncondition."'
                                                                    
                                         where [PO ID]='".$poid."' ";
                
               odbc_exec($conn, $sql_updateterm);
        
      //echo  '<META http-equiv="refresh" content="0;URL=PO_GRN.php?ID=".$poid"//> ';
         Header( 'Location: PO_GRN.php?ID='.$poid);
 
  }
    
                                    
?>

