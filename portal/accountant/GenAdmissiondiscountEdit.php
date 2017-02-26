<?php

	require_once("header.php");?>

<!-- Body -->
<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>School List </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<?php	
	echo "<br/><br/><br/><br/><br/>";
              $Class= $_REQUEST['Class'];
              $AdmissionYear= $_REQUEST['AdmissionYear'];
              $a= $_REQUEST['SlabCode'];
              $b= $_REQUEST['TransFee'];
              $c= $_REQUEST['TransDist'];
	      $Customerno=$_REQUEST['Customerno'];
              if(!empty($a) && ($b) && ($c)) {
              if($a != "" && $b != "" && $c != ""){
              $sql_update = "UPDATE [Temp Student] SET 
					[Slab Code]='".ucwords(strtoupper($a))."',
					[Transport Fee]='$b',
          [Route No_]='".ucwords(strtoupper($a))."',
					[Distance Covered in KM]='$c'
					WHERE [Company Name]='$ms' AND [Registration No_]= '".$Customerno."' ";
       
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn)); 
                  
                 }
                 
                }
	       
                //------------------------------------------------------>
                for($f =1; $f<=$_REQUEST['fee_count']; $f++){
			 $check = odbc_exec($conn, "SELECT [FeeNo] FROM [StudentFee] WHERE [CompanyName]='$ms' AND [FeeNo]='".$_REQUEST['fee_Id'.$f]."' AND [ApplicationNo]='$Customerno' ") or die(odbc_errormsg($conn));
                       
                      if(odbc_num_rows($check) == 0 && $_REQUEST['fee'.$f]==1){
                            odbc_exec($conn, "INSERT INTO [StudentFee] ([ApplicationNo], [CompanyName], [FeeNo], [Description_], [DocumentNo_]) VALUES ('$Customerno','".$ms."','".$_REQUEST["fee_Id".$f]."','".$_REQUEST["Description1".$f]."','".$_REQUEST["DocumentNo1_".$f]."')") or die(odbc_errormsg($conn));
                            echo "INSERT INTO [StudentFee] ([ApplicationNo], [CompanyName], [FeeNo], [Description_], [DocumentNo_]) VALUES ('$Customerno','".$ms."','".$_REQUEST["fee_Id".$f]."','".$_REQUEST["Description1".$f]."','".$_REQUEST["DocumentNo1_".$f]."')";
                            echo "<br/>";

                        }
                        
                }

                //----------------------------------------------------------------------------------------------------------------------->
               

                for($d =0; $d<=$_REQUEST['Dis_count']; $d++){
                        $check1 = odbc_exec($conn, "SELECT [DiscountNo] FROM [StudentDiscountDetails] WHERE [CompanyName]='$ms' AND [DiscountNo]='".$_REQUEST['discount_Id'.$d]."' AND [ApplicationNo]='$Customerno' ") or die(odbc_errormsg($conn));
                      if(odbc_num_rows($check1) == 0 && $_REQUEST['discount'.$d]==1){
                           odbc_exec($conn, "INSERT INTO [StudentDiscountDetails] ([ApplicationNo], [CompanyName], [DiscountNo], [Description_], [DocumentNo_]) VALUES ('$Customerno','".$ms."','".$_REQUEST["discount_Id".$d]."','".$_REQUEST["Description2".$d]."','".$_REQUEST["No_".$d]."')") or die(odbc_errormsg($conn));

                         
                        }
                        else if(odbc_num_rows($check1) == 1 && ( empty($_REQUEST['discount'.$d]) || $_REQUEST['discount'.$d]==0)){
                            odbc_exec($conn, "DELETE FROM [StudentDiscountDetails] WHERE [CompanyName]='$ms' AND [DocumentNo_]='".$_REQUEST["No_".$d]."' AND [DiscountNo]='".$_REQUEST['discount_Id'.$d]."' AND [ApplicationNo]='$Customerno' ") or die(odbc_errormsg($conn));
                           
                        }

                }

                require_once("GeninvoceCalcEdit.php");
		//echo "<META http-equiv='refresh' content='0;URL=RevFeedicountEdit.php?invoice=$Customerno&Class=$Class&AdmissionYear=$AdmissionYear'>";//header("Location: NewEnquiry.php?eid=$EnquiryNo");
               // echo "<META http-equiv='refresh' content='0;URL=Reverse.php?invoice=$Customerno'>";
?>
	<!-- /Content -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Body -->

<!-- Page Classes -->
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>
<?php
 require_once("../footer.php");
?>
