<html>
  <head>
      <?php require_once("header.php"); ?>
      <style type="text/css">
    .content{
        width:900px;
        margin:0 auto;
    }
    #searchid
    {
        width:500px;
        border:solid 1px #000;
        padding:10px;
        font-size:14px;
    }
    #result
    {
        position:absolute;
        width:500px;
        padding:10px;
        display:none;
        margin-top:-1px;
        border-top:0px;
        overflow:hidden;
        border:1px #CCC solid;
        background-color: white;
    }
    .show
    {
        padding:10px; 
        border-bottom:1px #999 dashed;
        font-size:15px; 
        height:50px;
    }
    .show:hover
    {
        background:#4c66a4;
        color:#FFF;
        cursor:pointer;
    }
</style>
    <title>Ajax Search Box using PHP and MySQL</title>
  
    </head>
    <body>
       <div class="content">
       <input type="text" class="search" id="searchid" placeholder="Search for people" />&nbsp; &nbsp; Ex: <b><i>huzoor bux, neelam, ravi or sameer</i></b><br /> 
       <div id="result"></div>
       </div>
    </body>
    </html>   
    <script type="text/javascript" src="jquery-1.8.0.min.js"></script>
            <script type="text/javascript">
            $(function(){
            $(".search").keyup(function() 
            { 
            var searchid = $(this).val();
            var dataString = \'search=\'+ searchid;
            if(searchid!=\'\')
            {
                $.ajax({
                type: "POST",
                url: "result.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                $("#result").html(html).show();
                }
                });
            }return false;    
            });

            jQuery("#result").on("click",function(e){ 
                var $clicked = $(e.target);
                var $name = $clicked.find(\'.name\').html();
                var decoded = $("<div/>").html($name).text();
                $(\'#searchid\').val(decoded);
            });
            jQuery(document).live("click", function(e) { 
                var $clicked = $(e.target);
                if (! $clicked.hasClass("search")){
                jQuery("#result").fadeOut(); 
                }
            });
            $(\'#searchid\').click(function(){
                jQuery("#result").fadeIn();
            });
            });
            </script>

<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script>
$(document).ready(function() {

    $("#name option").filter(function() {
        return $(this).val() == $("#firstname").val();
    }).attr('selected', true);

    $("#name").live("change", function() {

        $("#firstname").val($(this).find("option:selected").attr("value"));
    });
});
</script>
<select id="name" name="name"> 
<option value="">Please select...</option> 
<option value="Elvis">Elvis</option> 
<option value="Frank">Frank</option> 
<option value="Jim">Jim</option> 
</select>

<input type="text" id="firstname" name="firstname" value="Elvis" readonly="readonly"-->


<!--html>

<head>
<script type="text/javascript">

    function do_this(){

        var checkboxes = document.getElementsByName('approve[]');
        var button = document.getElementById('toggle');

        if(button.value == 'select'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'deselect'
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'select';
        }
    }
</script>
</head>

<body>
<input type="checkbox" name="approve[]" value="1" />
<input type="checkbox" name="approve[]" value="2" />
<input type="checkbox" name="approve[]" value="3" />

<input type="button" id="toggle" value="select" onClick="do_this()" />
</body>

</html>
<script>
function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
</scrpt>
<html>
<input type="checkbox" onclick="toggle(this);" />Check all?<br />

<input type="checkbox" />Bar 1<br />
<input type="checkbox" />Bar 2<br />
<input type="checkbox" />Bar 3<br />
<input type="checkbox" />Bar 4<br />
            
</html-->  
  
  
  
  
 
 
 
 
<!--html>

<form method="post" action="">
<input type="checkbox" id="checkAll" /><label>Select/Deselect All</label><br /><br />

<input class="chk" type="checkbox" name="html" value="html" />
HTML<br/>
<input class="chk" type="checkbox" name="javascript" value="javascript" />
JavaScript<br/>
<input class="chk" type="checkbox" name="jquery" value="jquery" />
JQuery<br/><br/>
<input type="submit" name="submit" id="submit" value="Submit" />
</form>
    
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
<script type='text/javascript'>
$("#checkAll").change(function () {
      $("input:checkbox").prop('checked', $(this).prop("checked"));
});
</script>
</html>




<form name="form">
<table>
<tr>
<td>Num 1:</td>
<td><input type="text" name="num1" id="num1" /></td>
</tr>
<tr>
<td>Num 2:</td>
<td><input type="text" name="num2" id="num2" /></td>
</tr>
<tr>
<td>Sum:</td>
<td><input type="text" name="sum" id="sum" readonly /></td>
</tr>
<tr>
<td>Subtract:</td>
<td><input type="text" name="subt" id="subt" readonly /></td>
</tr>
</table>
</form>
<script>
	
$(function() {
    $("#num1, #num2").on("keydown keyup", sum);
	function sum() {
	$("#sum").val(Number($("#num1").val()) + Number($("#num2").val()));
	$("#subt").val(Number($("#num1").val()) - Number($("#num2").val()));
	}
});
    </script-->


<!--html>
<head>
<title>Ajax Image Upload Using PHP and jQuery</title>
<link rel="stylesheet" href="style.css" />
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="script.js"></script>
<style>
    body {
font-family: 'Roboto Condensed', sans-serif;
}
h1
{
text-align: center;
background-color: #FEFFED;
height: 70px;
color: rgb(95, 89, 89);
margin: 0 0 -29px 0;
padding-top: 14px;
border-radius: 10px 10px 0 0;
font-size: 35px;
}
.main {
position: absolute;
top: 50px;
left: 20%;
width: 450px;
height:530px;
border: 2px solid gray;
border-radius: 10px;
}
.main label{
color: rgba(0, 0, 0, 0.71);
margin-left: 60px;
}
#image_preview{
position: absolute;
font-size: 30px;
top: 100px;
left: 100px;
width: 250px;
height: 230px;
text-align: center;
line-height: 180px;
font-weight: bold;
color: #C0C0C0;
background-color: #FFFFFF;
overflow: auto;
}
#selectImage{
padding: 19px 21px 14px 15px;
position: absolute;
bottom: 0px;
width: 414px;
background-color: #FEFFED;
border-radius: 10px;
}
.submit{
font-size: 16px;
background: linear-gradient(#ffbc00 5%, #ffdd7f 100%);
border: 1px solid #e5a900;
color: #4E4D4B;
font-weight: bold;
cursor: pointer;
width: 300px;
border-radius: 5px;
padding: 10px 0;
outline: none;
margin-top: 20px;
margin-left: 15%;
}
.submit:hover{
background: linear-gradient(#ffdd7f 5%, #ffbc00 100%);
}
#file {
color: red;
padding: 5px;
border: 5px solid #8BF1B0;
background-color: #8BF1B0;
margin-top: 10px;
border-radius: 5px;
box-shadow: 0 0 15px #626F7E;
margin-left: 15%;
width: 72%;
}
#message{
position:absolute;
top:120px;
left:815px;
}
#success
{
color:green;
}
#invalid
{
color:red;
}
#line
{
margin-top: 274px;
}
#error
{
color:red;
}
#error_message
{
color:blue;
}
#loading
{
display:none;
position:absolute;
top:50px;
left:850px;
font-size:25px;
}
</style>

</head>
<body>
<div class="main">
<h1>Ajax Image Upload</h1><br/>
<hr>
<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
<div id="image_preview"><img id="previewing" src="noimage.png" /></div>
<hr id="line">
<div id="selectImage">
<label>Select Your Image</label><br/>
<input type="file" name="file" id="file" required />
<input type="submit" value="Upload" class="submit" />
</div>
</form>
</div>
<h4 id='loading' >loading..</h4>
<div id="message"></div>
</body>
</html>

<script>
$(document).ready(function (e) {
$("#uploadimage").on('submit',(function(e) {
e.preventDefault();
$("#message").empty();
$('#loading').show();
$.ajax({
url: "testing.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
$('#loading').hide();
$("#message").html(data);
}
});
}));

// Function to preview image after validation
$(function() {
$("#file").change(function() {
$("#message").empty(); // To remove the previous error message
var file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{
$('#previewing').attr('src','noimage.png');
$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});
function imageIsLoaded(e) {
$("#file").css("color","green");
$('#image_preview').css("display", "block");
$('#previewing').attr('src', e.target.result);
$('#previewing').attr('width', '250px');
$('#previewing').attr('height', '230px');
};
});
</script-->