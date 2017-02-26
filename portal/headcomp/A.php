<html>
<head>
<title>File Uploader</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 

if (isset($_FILES['ourFiles'])) {
    for ($i = 0; $i < count($_FILES['ourFiles']); $i++) {
        if ($_FILES['ourFiles']['error'][$i] == UPLOAD_ERR_OK) {
            
            $tempName = $_FILES['ourFiles']['tmp_name'][$i];
            $fileName = $_FILES['ourFiles']['name'][$i];
            $saveDirectory = 'uploads/';
            if (@move_uploaded_file($tempName, $saveDirectory . $fileName)) {
                echo 'File Successfully Uploaded!';
            } else {
                echo 'There was an error whilst uploading the file.';
            }
            
        } elseif ($_FILES['ourFiles']['size'][$i] > 100000) {
            echo 'File is greater than maximum allow file size.';
        }
    }
    
} else {
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="upload">
      Please enter up to 5 files to upload:<br> 
      <input name="ourFiles[]" type="file"><br> 
      <input name="ourFiles[]" type="file"><br>
      <input name="ourFiles[]" type="file"><br>
      <input name="ourFiles[]" type="file"><br>
      <input name="ourFiles[]" type="file"><br>
      <input name="submit" type="submit" value="Submit"> 
    </form>
    <?php 
    }
?>
</body>
</html>