<script type="text/javascript" charset="utf-8">
    $(function()
    {
        var availableTags = [ <?php
                $City_Tag1=odbc_exec($conn, "SELECT DISTINCT([City]) FROM [PostCode] ORDER BY [City]");
                while(odbc_fetch_array($City_Tag1)){
                    //echo "'". odbc_result($City_Tag1, "City")."', ";
                }
                $State_Tag1=odbc_exec($conn, "SELECT DISTINCT([State]) FROM [PostCode] ORDER BY [State]");
                while(odbc_fetch_array($State_Tag1)){
                    echo "'". odbc_result($State_Tag1, "State")."', ";
                }
                $Country_Tag1=odbc_exec($conn, "SELECT DISTINCT([Country]) FROM [PostCode] ORDER BY [Country]");
                while(odbc_fetch_array($Country_Tag1)){
                    echo "'". odbc_result($Country_Tag1, "Country")."', ";
                }
            ?> ];

        $("#datepicker1").datepicker({ minDate: -15, maxDate: 0});
        $("#datepicker2").datepicker({changeYear: true, changeMonth: true, yearRange: "-20:+0",});
        $("#datepicker3").datepicker({ minDate: 0});
        $("#datepicker4").datepicker({changeMonth: true,minDate: '-15'});

        $( "#city,#city1,#city2,#city3, #state, #country, #country1, #country2, #country3" ).autocomplete({
            source: availableTags
        });
    });

    $(window).load(function(){
        var $state = $('#CommunicationReference'),
            $province = $('#GuardianRelationship');
        $state.change(function() {
            if ($state.val() == 'GUARDIAN') {
                $province.removeAttr('disabled');
                $province.focus();
                $province.css('backgroundColor','yellow');
            } else {
                $province.attr('disabled', 'disabled').val('');
                $province.css('backgroundColor','#ffffff');
                $province.css('border','1px solid #d3d3d3');
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
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // â€œ-â€� CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // â€œ.â€� CHECK DOT, AND ONLY ONE.
            (charCode != 8 ) &&      // â€œ.â€� CHECK BACKSPACE.
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
    
    function copy()
    {
        var FatherName = document.getElementById("FatherName");
        var MotherName = document.getElementById("MotherName");
        var GuardianName = document.getElementById("GuardianName");
        var Addressee = document.getElementById("Addressee");
        var CommunicationReference = document.getElementById("CommunicationReference");
        var CommRef = CommunicationReference.options[CommunicationReference.selectedIndex].text;
        
        if(CommRef == "Father" || CommRef == "FATHER"){			
		if(FatherName.value == ""){
			alert("Please enter Father's Name ...");
			document.getElementById("FatherName").focus();
			document.getElementById("CommunicationReference").selectedIndex="0";
		}
		else{
			Addressee.value = FatherName.value;
		}
        }
        if(CommRef == "Mother" || CommRef == "MOTHER"){
		if(MotherName.value == ""){
			alert("Please enter Mother's Name ...");
			document.getElementById("MotherName").focus();
			document.getElementById("CommunicationReference").selectedIndex="0";
		}
		else{
			Addressee.value = MotherName.value;
		}
        }
        if(CommRef == "Guardian" || CommRef == "GUARDIAN"){
		if(GuardianName.value == ""){
			alert("Please enter Guardian's Name ...");
			document.getElementById("GuardianName").focus();
			document.getElementById("CommunicationReference").selectedIndex="0";
		}
		else{
			Addressee.value = GuardianName.value;
		}
        }
        //Addressee.value = CommRef;
    }
    
    function changetextbox()
    {
        if (document.getElementById("ClassApplied").value == "XI" || document.getElementById("ClassApplied").value == "XII") {
            document.getElementById("Stream").disabled=false;
        } 
        else {
            document.getElementById("Stream").disabled=true;
        }
	if (document.getElementById("ClassApplied").selectedIndex >= 2) {
		document.getElementById("PrevSchLastClass").disabled=false;
		document.getElementById("PrevSchLastClass").requireded=true;
		document.getElementById("PrevSchCurricullum").disabled=false;
		document.getElementById("PrevSchCurricullum").requireded=true;
	}
    }
    
    function checkDiff (initialDate) {
        if (initialDate.length == 11){
            
            var mnth;
            var d= new Date();
            var n = d.getFullYear();
            date2 = new Date("04/01/" + (n+1));
            var t = initialDate.split("/");
            
            
            if(t[1] == "Jan" || t[1] == "jan" || t[1] == "JAN") mnth = "01";
            if(t[1] == "Feb" || t[1] == "feb" || t[1] == "FEB") mnth = "02";
            if(t[1] == "Mar" || t[1] == "mar" || t[1] == "MAR") mnth = "03";
            if(t[1] == "Apl" || t[1] == "apl" || t[1] == "APL") mnth = "04";
            if(t[1] == "May" || t[1] == "may" || t[1] == "MAY") mnth = "05";
            if(t[1] == "Jun" || t[1] == "jun" || t[1] == "JUN") mnth = "06";
            if(t[1] == "Jul" || t[1] == "jul" || t[1] == "JUL") mnth = "07";
            if(t[1] == "Aug" || t[1] == "aug" || t[1] == "AUG") mnth = "08";
            if(t[1] == "Sep" || t[1] == "sep" || t[1] == "SEP") mnth = "09";
            if(t[1] == "Oct" || t[1] == "oct" || t[1] == "OCT") mnth = "10";
            if(t[1] == "Nov" || t[1] == "nov" || t[1] == "NOV") mnth = "11";
            if(t[1] == "Dec" || t[1] == "dec" || t[1] == "DEC") mnth = "12";
            
            var custdt = mnth +"/"+t[0]+"/"+t[2];
                            
            var date1 = new Date(custdt); // Date of Birth
            
            var timeDiff = Math.abs(date2.getTime() - date1.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
            //alert();
            
            if(Math.round(diffDays/365, 0, 2) < 2){
                alert("Less than 2 years is not applicable.");
                datepicker2.style.backgroundColor = "#990000";
                datepicker2.style.color = "#ffffff";
                document.getElementById("btnSubmit").disabled=true;	
            }
            else{
                datepicker2.style.backgroundColor = "#FFFF00";
                datepicker2.style.color = "#000000";
                document.getElementById("btnSubmit").disabled=false;
            }
                                    
        }
    }

</script>
