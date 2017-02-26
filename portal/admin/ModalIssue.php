<?php

?>
<div id="myModal<?php echo $i?>" class="modal fade" xmlns="http://www.w3.org/1999/html">
    <div class="modal-dialog" style="width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Complaint View for <b class="text-primary"><?php echo $row['ComplaintID']; ?></b></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-stripped">
                        <tr>
                            <td>Call Date</td><td><?php echo date('d/M/Y',strtotime($row['CallDate'])); ?></td>
                            <td>Call Status</td><td style="font-weight: bold"><?php echo $row['CallStatus']; ?></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>Category</td><td><?php echo $row['Category']; ?></td>
                            <td>Module</td><td><?php echo $row['Module']; ?></td>
                            <td>Sub-Module</td><td><?php echo $row['SubModule']; ?></td>
                        </tr>
                        <tr>
                            <td>Description</td><td colspan="5"><?php 
			    echo $row['Description']; 
			    ?></td>
                        </tr>
                        <tr>
                            <td>Snapshot</td>
                            <td colspan="5">
                                <?php
                                    if($row['Picture'] != ""){
                                        $im = $row['Picture'];
                                        echo "<img src='data:image/jpeg;base64,$im' width='500px' />";
                                        //echo $im;
                                    }
                                    else{
                                        echo "Not Available ...";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Responsible Person</td><td><?php echo $row['ResponsiblePerson']; ?></td>
                            <td>Call Type</td><td><?php echo $row['CallType']; ?></td>
                            <td>Attend Date</td><td><?php echo date('d/M/Y',strtotime($row['CloseDate'])); ?></td>
                        </tr>
                        <tr>
                            <td>Action Taken</td><td colspan="5"><?php echo $row['ActionTaken']; ?></td>
                        </tr>
                        <tr>
                            <td>Remarks</td><td colspan="5"><?php echo $row['Remarks']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>