<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">

  
  

  
  
  

  

  <script type="text/javascript" src="//code.jquery.com/jquery-1.10.1.js"></script>

  

  

  

  
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  

  

  <style type="text/css">
    
  </style>

  <title>Upload Image and Display On Screen by KyleMit</title>

  
    




<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
$(function () {
    $(":file").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
});

function imageIsLoaded(e) {
    $('#myImg').attr('src', e.target.result);
};
});//]]> 

</script>

  
</head>

<body>
  <input type='file' />
<img id="myImg" src="#" alt="your image" />












<!-- Post Info -->
<div style='position:fixed;bottom:0;left:0;    
            background:lightgray;width:100%;'>
    About this SO Question <a href='http://stackoverflow.com/q/19866677/1366033'>A button for Open Dialog Box using HTML and JQuery</a><br/>
<div>

  
</body>

</html>

