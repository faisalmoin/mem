<?php
require_once("Header1.php");

require_once("datab.php");
?>
<head>

  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"> </script>
<script>
$(document).ready(function() {
    $('#Form').bootstrapValidator({
        err: {
            container: function($field, validator) {
               
                return $field.parent().next('.messageContainer');
            }
        },
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            empcode: {
                       
                validators: {
                    notEmpty: {
                        message: 'Employee Code is required'
                    },
                     stringLength: {
                        max: 15,
                        message: 'Code  up to 15 digits'
                    },
                
            }
            },
           contact: {
                       
                validators: {
                    
                     stringLength: {
                        max: 15,
                        message: 'Contact  up to 15 digits'
                    },
                
            }
            },
            empname: {
                validators: {
                    notEmpty: {
                        message: 'Employee Name is required'
                    }
                    
                }
            },
           
             department: {
                validators: {
                    notEmpty: {
                        message: 'Department is required'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                       message: 'Email is required',
                       email:true
                    },
                     stringLength: {
                        max: 40,
                        message: 'email  up to 40 characters'
                    },
                   
                }
            },
           
            
        }
    });


   $("#contact").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
  	$('#category').change(function()
	{
           var textinput = $('#category').val();
              
            var dataString = 'id='+ textinput;	
		 
                $.ajax
                ({
                    type: "POST",
                    url: "get_category.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                       
                        $("#subcategory").html(html);
                    }
                });
            });
       
             




 
    $(function()
    {
        var availableTags = [ <?php
                $dept="SELECT DISTINCT(EmployeeDepartment) FROM employee ";
               $row=mysqli_query($conn, $dept);
               while ($rowdept = mysqli_fetch_array($row)) {

                    echo "'". $rowdept['EmployeeDepartment']."', ";
                }
               
                          
            ?> ];

       
        $( "#department").autocomplete({
            source: availableTags
        });
    });

  });
  
</script>
</head>
<form action="employeeAdd.php" id="Form" method="post" class="form-horizontal">
   <div class="container">	
   
	<div class='col-sm-12 col-md-12'>
            
                    <div class="col-md-9">
                                <div id="messages"></div>
                     </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6"><h1 class="text-primary">Add Employee</h1></div>
                        <?php if(isset($_REQUEST['message'])){
                            $msg=$_REQUEST['message'];
                            if($msg==success)
                            {?>
                                <div class="col-sm-6 col-md-6 text-success" >
                                    <h4> <strong>Success!</strong>New Item  has been added successfully.</h4>
                                </div>
                          <?php }
                        
                          if($msg==fail)
                            {?>
                                <div class="col-sm-6 col-md-6 text-danger" >
                                    <h4> <strong>Fail!  </strong>New Item  Not added.<br/>Fill unique values of Item.</h4>
                                </div>
                          <?php }
                            }?>
                        </div>
                    
                   
                    <div class="form-group">
                        
                            
                            <div class="col-sm-3 col-md-3">Employee Code</div>
                            <div class="col-sm-3 col-md-3"><input type="text" id="empcode" name="empcode" class="form-control" autocomplete="off"/></div>
                            <div class="col-sm-3 col-md-3">&nbsp;</div>
                            <div class="col-sm-3 col-md-3">&nbsp;</div>
                            
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3 col-md-3">Employee Name</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="empname" class="form-control" autocomplete="off"/></div>
                            
                            
                        </div>
                         <div class="form-group">
                            <div class="col-sm-3 col-md-3">Contact No</div>
                            <div class="col-sm-3 col-md-3"><input type="text" id="contact" name="contact" class="form-control" autocomplete="off"/></div>
                            </div>
                           <div class="form-group">
                            <div class="col-sm-3 col-md-3">Department</div>
                            <div class="col-sm-3 col-md-3"><input type="text" name="department" id="department" class="form-control" autocomplete="off"/></div>
                             </div>
                                             
                           <div class="form-group">
                              <div class="col-sm-3 col-md-3">Email</div>
                              <div class="col-sm-3 col-md-3"><input type="text" name="email" class="form-control" autocomplete="off"/></div>
                           </div>
                          
           <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <input type="submit" name="item" id="item" value="Submit" class="btn btn-primary">
        </div>
    </div>
            
                   
                    </div>
        </div>
</form>