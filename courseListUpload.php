 <?php
if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['courseList']['tmp_name'])) {
$sourcePath = $_FILES['courseList']['tmp_name'];
$file_ext=strtolower(end(explode('.',$_FILES['courseList']['name'])));
$targetPath = "lists/courseList.".$file_ext;
if(move_uploaded_file($sourcePath,$targetPath)) {
?>
<!--<img class="image-preview" src="<?php //echo $targetPath; ?>" class="upload-preview" />-->
<?php
}
}
}
?>