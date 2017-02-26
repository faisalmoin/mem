<?php
    require_once("header.php");

    if(isset($_GET['q'])){
        if($_GET['q'] == 1){
            echo "<div class='container'><div class='bs-example'>
				<div class='alert alert-success alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Success!</strong> Your complaint has been logged. Your reference no is <strong>$ComplaintID</strong>.
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
        <li class="active"><a href="#StuTab1" data-toggle="tab">List Complaint</a></li>
        <li><a href="#StuTab2" data-toggle="tab">New Complaint</a></li>
    </ul>
    <div class="tab-content" id="StuTabContent">
        <div class="tab-pane face in active" id="StuTab1">
            <?php require_once("IssueTrackerList.php") ?>
        </div>
        <div class="tab-pane face in " id="StuTab2">
            <?php require_once("IssueTracker.php"); ?>
        </div>
    </div>
</div>

<?php require_once("../footer.php"); ?>


