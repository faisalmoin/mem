<?php
require_once("../db.txt");
if(isset($_POST['submit']))

{
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
        
      
      $sql_update = "UPDATE [VMS Item Master] SET 
        
                               [Item No]='".$itemno."',
                                [SKU No]='".$skuno."',
				[Item Name]='".$itemname."',
                                [Condition]='".$condition."',
                                [Description]='".$itemdescription."',
                                [Make]='".$make."',
				[Model]='".$model."',
                                [Sr No]='".$srno."',
                                [Warranty]='".$warranty."',
                                [Category]='".$category."',
                                [Sub Category]='".$subcategory."',
                                [Specifications]='".$specifications."',
                                [UOM]='".$uom."'
					
					where [ID]='".$_REQUEST['id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		
		echo '<META http-equiv="refresh" content="0;URL=Item_List.php"> ';
}
