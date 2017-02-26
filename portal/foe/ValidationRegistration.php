<script type="text/javascript" charset="utf-8">
    $(function()
    {
        var availableTags = [ <?php
                $City_Tag1=odbc_exec($conn, "SELECT DISTINCT(`City`) FROM `Post Code` ORDER BY `City`");
                while($City_Tag=mysql_fetch_array($City_Tag1)){
                    echo "'". $City_Tag[0]."', ";
                }
                $State_Tag1=mysql_query("SELECT DISTINCT(`State`) FROM `PostCode` ORDER BY `State`");
                while($State_Tag=mysql_fetch_array($State_Tag1)){
                    echo "'". $State_Tag[0]."', ";
                }
                $Country_Tag1=mysql_query("SELECT DISTINCT(`Country`) FROM `PostCode` ORDER BY `Country`");
                while($Country_Tag=mysql_fetch_array($Country_Tag1)){
                    echo "'". $Country_Tag[0]."', ";
                }
            ?> 'ALLAHABAD BANK', 'ANDHRA BANK', 'AXIS BANK', 'BANK OF BAHRAIN AND KUWAIT', 'BANK OF BARODA', 'BANK OF INDIA', 'BANK OF MAHARASHTRA', 'CANARA BANK', 'CENTRAL BANK OF INDIA', 'CITY UNION BANK', 'CORPORATION BANK', 'DEUTSCHE BANK', 'DEVELOPMENT CREDIT BANK', 'DHANLAXMI BANK', 'FEDERAL BANK', 'HDFC BANK', 'ICICI BANK', 'IDBI BANK', 'INDIAN BANK', 'INDIAN OVERSEAS BANK', 'INDUSIND BANK', 'ING VYSYA BANK', 'JAMMU AND KASHMIR BANK', 'KARNATAKA BANK LTD', 'KARUR VYSYA BANK', 'KOTAK BANK', 'LAXMI VILAS BANK', 'ORIENTAL BANK OF COMMERCE', 'PUNJAB NATIONAL BANK', 'PUNJAB & SIND BANK', 'SHAMRAO VITTHAL CO-OPERATIVE BANK', 'SOUTH INDIAN BANK', 'STATE BANK OF BIKANER & JAIPUR', 'STATE BANK OF HYDERABAD', 'STATE BANK OF INDIA', 'STATE BANK OF MYSORE', 'STATE BANK OF PATIALA', 'STATE BANK OF TRAVANCORE', 'SYNDICATE BANK', 'TAMILNAD MERCANTILE BANK LTD.', 'UCO BANK', 'UNION BANK OF INDIA', 'UNITED BANK OF INDIA', 'VIJAYA BANK', 'YES BANK LTD'];

        $("#datepicker1").datepicker({ minDate: -15, maxDate: 0});
        $("#datepicker2").datepicker({changeYear: true, changeMonth: true});
        $("#datepicker3").datepicker({ minDate: 0});
        
        $( "#city,#city1,#city2,#city3, #state, #country, #country1, #country2, #country3, #BankName" ).autocomplete({
            source: availableTags
        });
    });

    $(window).load(function(){
        var $state = $('#CommunicationReference'),
            $province = $('#GuardianRelationship');
        $state.change(function() {
            if ($state.val() == 'Guardian') {
                $province.removeAttr('disabled');
            } else {
                $province.attr('disabled', 'disabled').val('');
            }
        }).trigger('change'); // added trigger to calculate initial state
    });

    // Numeric Validation
    $(document).ready(function() {
        $('.isNumeric').keypress(function (event) {
            return isNumber(event, this)
        });

    });
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode != 8 ) &&      // “.” CHECK BACKSPACE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function formcheck() {
        var fields = $(".ss-item-required")
            .find("select, textarea, input").serializeArray();

        $.each(fields, function(i, field) {
            if (!field.value){
                alert(field.name + ' is required');
                //return false;
            }
        });
        console.log(fields);
    }


    window.onload=function(){
        var checker = document.getElementById('checkme');
        //var sendbtn = document.getElementById('sendNewSms');
        var RegCost = document.getElementById('RegCost');
        var PayMode = document.getElementById('PayMode');
        var BankName = document.getElementById('BankName');
        var DDNo = document.getElementById('DDNo');
        var DDDt = document.getElementById('DDDt');
        // when unchecked or checked, run the function
        checker.onchange = function(){
            if(this.checked){
                //sendbtn.disabled = false;
                RegCost.disabled = true;
                RegCost.value = '0.00';
                PayMode.disabled = true;
                BankName.disabled = true;
                DDNo.disabled = true;
                datepicker3.disabled = true;
            } else {
                //sendbtn.disabled = true;
                RegCost.disabled = false;
                RegCost.value = '<?php
                                //$Rcost=odbc_exec($conn, "SELECT * FROM [Admission Setup] WHERE [Company Name]='$ms'");
                                $Rcost=odbc_exec($conn, "SELECT [Amount] FROM [Class Fee Line] WHERE [Company Name]='$ms' AND [Group Code]='REG'");
                                odbc_fetch_array($Rcost);
				//echo number_format((float)odbc_result($Rcost,"Application Cost"),'0','.','');
                                echo number_format((float)odbc_result($Rcost,"Amount"),'0','.','');
                            ?>';
                PayMode.disabled = false;
                BankName.disabled = false;
                DDNo.disabled = false;
                datepicker3.disabled = false;
            }
        }
        var $PayMode = $('#PayMode'),
            $BankName = $('#BankName'),
            $DDNo = $('#DDNo'),
            $ChequeDDDate = $('#datepicker3');
        $PayMode.change(function() {
            if ($PayMode.val() != 'CASH') {
                $BankName.removeAttr('disabled');
                $DDNo.removeAttr('disabled');
                $ChequeDDDate.removeAttr('disabled');
            } else {
                $BankName.attr('disabled', 'disabled').val('');
                $DDNo.attr('disabled', 'disabled').val('');
                $ChequeDDDate.attr('disabled', 'disabled').val('');
            }
        }).trigger('change'); // added trigger to calculate initial state

    }
//CHECK FOR REGISTRATION FORM NO
    $(document).ready(function() {
        $('#Loading').hide();
    });

    function check_username(){

        var username = $("#username").val();
        if(username.length > 2){
            $('#Loading').show();
            $.post("check_regForm.php?ms=<?php echo $ms?>", {
                //username: $('#username').val(),
                RegistrationFormNo: $('#username').val(),
            }, function(response){
                $('#Info').fadeOut();
                $('#Loading').hide();
                setTimeout("finishAjax('Info', '"+escape(response)+"')", 450);
            });
            return false;
        }
    }

    function finishAjax(id, response){

        $('#'+id).html(unescape(response));
        $('#'+id).fadeIn(1000);
    }
    
    function changetextbox()
    {
        if (document.getElementById("ClassApplied").value == "XI" || document.getElementById("ClassApplied").value == "XII") {
            document.getElementById("Stream").disabled=false;
        } 
        else {
            document.getElementById("Stream").disabled=true;
        }
    }
    
</script>
