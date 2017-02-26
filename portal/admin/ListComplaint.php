<?php
require_once("SetupLeft.php");

if(isset($_GET['q'])){
    if($_GET['q'] == 1){
        echo "<div class='container'><div class='bs-example'>
				<div class='alert alert-success alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Success!</strong> Complaint has been updated successfully.
				</div>
			</div></div>";
    }
    if($_GET['q'] == 0){
        echo "<div class='container'><div class='bs-example'>
				<div class='alert alert-danger alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Error!</strong> There is some error, kindly check.
				</div>
			</div></div>";
    }
    if($_GET['q'] == 2){
        echo "<div class='container'><div class='bs-example'>
				<div class='alert alert-danger alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Error!</strong> File size should not be greater than 300 Kb.
				</div>
			</div></div>";
    }
}
?>
<div class="container">
    <ul class="nav nav-tabs" id="StuTab">
        <li class="active"><a href="#StuTab1" data-toggle="tab">Open Complaint</a></li>
        <li><a href="#StuTab2" data-toggle="tab">Closed Complaint</a></li>
    </ul>
    <div class="tab-content" id="StuTabContent">
        <div class="tab-pane face in active" id="StuTab1">
            <?php require_once("IssueTrackerList.php") ?>
        </div>
        <div class="tab-pane face in " id="StuTab2">
            <?php require_once("IssueListClosed.php"); ?>
        </div>
    </div>
</div>

<?php require_once("SetupRight.php"); ?>


