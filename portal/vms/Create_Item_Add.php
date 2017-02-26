 <?php 
require_once("Header1.php");

   
      $itemno= strtoupper(trim($_REQUEST['itemno']));
      $itemname= strtoupper(trim($_REQUEST['itemname']));
      $skuno= strtoupper(trim($_REQUEST['sku']));
      $condition= trim($_REQUEST['condition']);
      $make= trim($_REQUEST['make']);
      $model= trim($_REQUEST['model']);
      $srno= trim($_REQUEST['srno']);
      $warranty= trim($_REQUEST['warranty']);
      $category=strtoupper(trim($_REQUEST['category']));
      $subcategory=strtoupper(trim($_REQUEST['subcategory']));
      $itemdescription= trim($_REQUEST['itemdescription']);
      $specifications=strtoupper(trim($_REQUEST['specifications']));
      $uom=strtoupper(trim($_REQUEST['uom']));
     
      
      $qrycat="select Count(*) as repeat from [VMS Item Category master] WHERE [Item category]='".$category."'";
      $res = odbc_exec($conn, $qrycat) or die(odbc_errormsg($conn));
      $rcategory=odbc_fetch_array($res);
      
      $qrysubcat="select Count(*) as repeatsubcateg from [VMS Subcategory Master] WHERE [Sub Category]='".$subcategory."'";
      $ressubcat = odbc_exec($conn, $qrysubcat) or die(odbc_errormsg($conn));
      $rsubcategory=odbc_fetch_array($ressubcat);
     
 if(isset($_POST['item']))
 {

    $fid1=1;
   $fid=str_pad($fid1,4,"0",STR_PAD_LEFT);
   $qryitm="select max(ID) AS ID from [VMS Item Master]";
    $resultitm = odbc_exec($conn, $qryitm) or die(odbc_errormsg($conn));
    $ltid=odbc_fetch_array($resultitm);
    $resgtid1=$ltid['ID'];
    $resgtid=$resgtid1+1;
    $itmid=str_pad($resgtid,4,"0",STR_PAD_LEFT);
    if($itmid>=1)
    {
        $newitmid="ITM/".$itmid;
    }
    else 

    {
       $newitmid="ITM/".$fid;
    }
     
      if(!empty($category) && !empty($subcategory) && $rcategory['repeat']==0 && $rsubcategory['repeatsubcateg']==0)
      {
          
          $qrycatinsrt="INSERT INTO [VMS Item Category Master] ([Item category]) VALUES ('".$category."')";
          $resultcatinsrt = odbc_exec($conn, $qrycatinsrt) or die(odbc_errormsg($conn));
          
          $rsid="SELECT ID from [VMS Item Category Master] WHERE [Item category]='".$category."'";
          $resultid = odbc_exec($conn, $rsid) or die(odbc_errormsg($conn));
          $gtid=odbc_fetch_array($resultid);
          $resgtid=$gtid['ID'];
          
          $qrysubcatinsrt="INSERT INTO [VMS Subcategory Master] ([Category ID],[Sub Category]) VALUES ('".$resgtid."','".$subcategory."')";
          $resultsubcatinsrt = odbc_exec($conn, $qrysubcatinsrt) or die(odbc_errormsg($conn));
          
    }
     if(!empty($category) && !empty($subcategory) && $rcategory['repeat']>0 && $rsubcategory['repeatsubcateg']==0)
     {
        
          $qrycatinsrtrpt="SELECT* FROM [VMS Item Category Master] WHERE [Item category]='".$category."'";
          $resultcatinsrtrpt = odbc_exec($conn, $qrycatinsrtrpt) or die(odbc_errormsg($conn));
          $rcategoryrpt=odbc_fetch_array($resultcatinsrtrpt);
          $rcategoryrptid=$rcategoryrpt['ID'];
          $qrysubcatinsrt1="INSERT INTO [VMS Subcategory Master] ([Category ID],[Sub Category]) VALUES ('".$rcategoryrptid."','".$subcategory."')";
          $resultsubcatinsrt1 = odbc_exec($conn, $qrysubcatinsrt1) or die(odbc_errormsg($conn));
          
          
          }
        
     
      $qryspecifications="select [ID],upper([Item Name]) AS [Item Name],upper([Category]) AS [Category],upper([Sub Category]) AS [Sub Category] from [VMS Item Master] WHERE [Item Name]='".$itemname."'";
      $resspecifications = odbc_exec($conn, $qryspecifications) or die(odbc_errormsg($conn));
      $resspecification=odbc_fetch_array($resspecifications);
      $rspecifications=$resspecification['ID'];
      $resitemnames=$resspecification['Item Name'];
      $rspecificationscategory=$resspecification['Category'];
      $rspecificationssubcategory=$resspecification['Sub Category'];
      $rspecificationitem=$resspecification['Item No'];
      
    
      
       
      
          $rsidsku="SELECT COUNT(*) as cnt from [VMS Item Master] WHERE [SKU No]='".$skuno."' OR [Item Name]='".$itemname."'";
          $resultidsku = odbc_exec($conn, $rsidsku) or die(odbc_errormsg($conn));
          $gtidsku=odbc_fetch_array($resultidsku);
          $resgtidsku=$gtidsku['SKU No'];
          $resgtiditemno=$gtidsku['cnt'];
        
        
        
   if($resgtiditemno==0 && $skuno!=$resgtidsku && $itemname!="" && $specifications!="" && $category!="" && $subcategory!="" && $uom!="")
   {
        echo  $SQL = "INSERT INTO [VMS Item Master] (
                                [Company Name],
                                [Item No],
                                [SKU No],
				                        [Item Name],
                                [Condition],
                                [Description],
                                [Make],
				                        [Model],
                                [Sr No],
                                [Warranty],
                                [Category],
                                [Sub Category],
                                [Specifications],
                                [UOM]
                               
                                
				
			) VALUES ('".$CompName."',
                                    '".$newitmid."',
                                    '".strtoupper(trim($_REQUEST['sku']))."',
                                    '".strtoupper(trim($_REQUEST['itemname']))."',
                                    '".trim($_REQUEST['condition'])."',
                                    '".trim($_REQUEST['itemdescription'])."',
                                    '".trim($_REQUEST['make'])."',
                                    '".trim($_REQUEST['model'])."',
                                    '".trim($_REQUEST['srno'])."',
                                    '".trim($_REQUEST['warranty'])."',
                                    '".strtoupper(trim($_REQUEST['category']))."',
                                    '".strtoupper(trim($_REQUEST['subcategory']))."','".$specifications."','".trim($_REQUEST['uom'])."')";
                
        $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
             
                   
                  
                  echo  '<META http-equiv="refresh" content="0;URL=Create_Item.php?message=success"> ';
             
             
   }
        if(!$result){
           
             echo  '<META http-equiv="refresh" content="0;URL=Create_Item.php?message=fail"> ';

        }      
             
       } 
         
		
	
?>

