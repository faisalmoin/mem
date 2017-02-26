<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    require_once("header.php");
?>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#Category").change(function()
            {
                var id=$(this).val();
                var dataString = 'id='+ id;
                
                if(id == 1){
                    $('#span1').text("Upfront");
                }
                else if(id == 2){
                    $('#span1').text("School");
                }
                else{
                    $('#span1').text("");
                }
                
                $.ajax
                ({
                    type: "POST",
                    url: "get_category.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        $("#Module").html(html);
                    }
                });
            });
        });
    </script>


<div class="container">
    <form name="myform">
        <table style="width: 40%;margin: 0 auto; margin-top: 5em" class="table table-responsive table-bordered">
        <tr>
            <th style="border: none;background-color: #d4d2d2;" colspan="2">
                <h4>Payment Receipt</h4>
            </th>
        </tr>
        <tr>
            <td style="border: none;">
                Payment Type 
            </td>
            <td style="border: none;">
                <select name="Category" id="Category" style="padding: 5px; width: 250px;">
                    <option value=""></option>
                    <option value="1">Upfront Fee</option>
                    <option value="2">Royalty Fee </option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="border: none;">
                Select <span id="span1" value="Textt"> </span>
            </td>
            <td style="border: none;">
                <select name="Module" id="Module" style="padding: 5px;  width: 250px;">
                    <option value=""></option>                    
                </select>
            </td>
        </tr>
        <tr>
            <td style="border: none;">
                <input type="button" value="Next" class="btn btn-success" onclick="return redirect()">
            </td>
            <td style="border: none;">
                <script>
                    function redirect(){
                        var a = document.getElementById("Category").value;
                        var b = document.getElementById("Module").value;
                        if(a == 0 ){
                            alert("Please select mode ...");
                            $('#Category').focus();
                            return false;
                        }
                        if(b ==0){
                            alert("Please select source ...");
                            $('#Module').focus();
                            return false;
                        }
                        
                        if(a == 1){
                            window.location.href ="FranchiseeDebit.php?CompName=" + b;
                        }
                        else if(a == 2){
                            window.location.href = "RoyaltyDebit.php?CompName=" + b;
                        }
                    }
                </script>
            </td>
        </tr>
    </table>
    </form>
</div>
<?php require_once("../footer.php"); ?>
