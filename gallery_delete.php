<?php
include "../config/db.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM gallery WHERE id=$id"));

unlink("../uploads/gallery/".$data['image']);

mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");

header("Location: gallery_manage.php");
?>
