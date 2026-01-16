<?php
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_POST['upload'])) {

    $img_name = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $folder = "../uploads/gallery/" . $img_name;

    if (move_uploaded_file($tmp, $folder)) {
        mysqli_query($conn, "INSERT INTO gallery (image) VALUES ('$img_name')");
        echo "Image Uploaded Successfully";
    } else {
        echo "Upload Failed";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <h3>Upload Gallery Image</h3>
    <input type="file" name="image" required><br><br>
    <button name="upload">Upload</button>
</form>
