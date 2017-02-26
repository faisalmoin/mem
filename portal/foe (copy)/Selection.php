<?php
require_once("header.php");
?>
    <div class="container">
        <ul class="nav nav-tabs" id="StuTab">
            <li class="active"><a href="#StuTab1" data-toggle="tab">New Selection</a></li>
            <li><a href="#StuTab2" data-toggle="tab">List Selected Candidate</a></li>
            <!-- <li><a href="#StuTab3" data-toggle="tab">Admission Documents</a></li> -->
        </ul>
        <div class="tab-content" id="StuTabContent">
            <div class="tab-pane face in active" id="StuTab1">
                <?php require_once("NewSelection.php") ?>
            </div>
            <div class="tab-pane face in" id="StuTab2">
                <?php require_once("ListSelection.php"); ?>
            </div>
            <!--
            <div class="tab-pane face in " id="StuTab3">
                <div class="container">
                    <?php //require_once("AdmissionDocuments.php"); ?>
                </div>
            </div>
            -->
        </div>
    </div>

<?php
    require_once("../footer.php");
?>