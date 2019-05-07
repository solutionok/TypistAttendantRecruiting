<?php 
echo __DIR__.'/'.$_FILES['file']['name'];
    if(isset($_FILES['file'])){
        move_uploaded_file($_FILES['file']['tmp_name'],__DIR__.'/'.$_FILES['file']['name']);
    }
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit">
</form>