<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $con = mysqli_connect("localhost", "root", "root", "project");
	$imgData =addslashes(file_get_contents($_FILES['fileToUpload']['tmp_name']));
	$imageProperties = getimageSize($_FILES['fileToUpload']['tmp_name']);
	$sql = "INSERT INTO product(productName, description, price, category, image, is_deleted) VALUES('".$_POST['ProductName']."', '".$_POST['Description']."', ".$_POST['Price'].", '".$_POST['category']."', '{$imgData}', 0)";
	mysqli_query($con, $sql);
	header("Location: Homepage.php");
}
?>