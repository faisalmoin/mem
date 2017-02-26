<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<!DOCTYPE html>
<html lang = "en">
   
   <head>
      <meta charset = "utf-8">
      <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
      <meta name = "viewport" content = "width = device-width, initial-scale = 1">
      
      <title>Bootstrap 101 Template</title>
      
      <!-- Bootstrap -->
      <link href = "bs/css/bootstrap.min.css" rel = "stylesheet">
      <script src="bs/js/jquery.min.js"></script>      
      <script src="bs/js/bootstrap.min.js"></script>
      
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      
      <!--[if lt IE 9]>
      <script src = "https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src = "https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      
   </head>
   
   <body>
        <script type="text/javascript">
            $(window).load(function(){
                $('#myModal').modal('show');
            });
    </script>

    
<!-- Modal -->
<div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog" 
   aria-labelledby = "myModalLabel" aria-hidden = "true">
   
   <div class = "modal-dialog">
      <div class = "modal-content">
         
         <div class = "modal-header">
            <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                  &times;
            </button>
            
            <h4 class = "modal-title" id = "myModalLabel">
               We are re-locating ...
            </h4>
         </div>
         
         <div class = "modal-body">
            <p>Dear user,</p>
            <p>This is to inform you that the current URL for Smart Schools application will not be accessible from <b style='color: #800000;'>25<sup>th</sup> July, 2015</b>. 
                The new URL for accessing the application will be like <br />
                    <b style='text-align: center'>http://schoolerp.[School's Domain Name].com</b>. <br /><br />
                <i>
                    For example, if your school is The Millennium School, then the URL for accessing the application will be: 
                    <b>http://schoolerp.themillenniumschools.com</b>
                </i>
                <br />                
            </p>
            <p style='color: #CC0000; font-weight: normal;'>You are requested to know your school's website.</p>
            <p>
                For any query, do contact with the ERP team or write to <b>schoolerp@educompschools.com</b>
            </p>
            <p>
                Regards,<br />
                ERP Team
            </p>
         </div>
         
         <div class = "modal-footer">
            <button type = "button" class = "btn btn-default" data-dismiss = "modal">
               Close
            </button>
            
            <!--button type = "button" class = "btn btn-primary">
               Submit changes
            </button-->
         </div>
         
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
  
</div><!-- /.modal -->

    
    
   </body>
</html>