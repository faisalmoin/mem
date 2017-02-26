<?
	require_once("header.php");
	
	$id=$_REQUEST['id'];
	
	$result=mysql_query("SELECT * FROM `admission` WHERE `ApplicationNo`='$id'") or die(mysql_error());
	$row=mysql_fetch_array($result);
	
	
?>
<div class="container">	
	<h1 class="text-primary">Admission Details</h1>
	<input type="hidden" name="id" value="<?=$id?>">
	<ul class="nav nav-tabs" id="StuTab">
		<li class="active"><a href="#StuTab1" data-toggle="tab">General</a></li>
		<li><a href="#StuTab2" data-toggle="tab">Communication</a></li>
		<li><a href="#StuTab3" data-toggle="tab">Personal</a></li>
		<li><a href="#StuTab4" data-toggle="tab">Other Details</a></li>
		<li><a href="#StuTab5" data-toggle="tab">Parent Info</a></li>
		<li><a href="#StuTab6" data-toggle="tab">Gaurdian Info</a></li>
	</ul>
	<div class="tab-content" id="StuTabContent">
		<div class="tab-pane face in active" id="StuTab1">
			<? require_once("AdmissionListGeneral.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab2">
			<? require_once("AdmissionListCommunication.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab3">
			<? require_once("AdmissionListPersonal.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab4">
			<? require_once("AdmissionListOther.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab5">
			<? require_once("AdmissionListParent.php") ?>
		</div>
		<div class="tab-pane face in" id="StuTab6">
			<? require_once("AdmissionListGaurdian.php") ?>
		</div>
	</div>
	<div>
		<button class="btn btn-default" onclick="javascript: history.go(-1)">Back</button>
	</div>
</div>


<? require_once("../footer.php"); ?>