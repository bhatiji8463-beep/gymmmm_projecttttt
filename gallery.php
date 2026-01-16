<?php
include "config/db.php";
$data = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Gallery</title>
<style>
.gallery{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
    gap:15px;
    padding:20px;
}
.gallery img{
    width:100%;
    border-radius:8px;
}
</style>
</head>

<body>

<h2 style="text-align:center;">Gym Gallery</h2>

<div class="gallery">
<?php while($row = mysqli_fetch_assoc($data)) { ?>
    <img src="uploads/gallery/<?php echo $row['image']; ?>">
<?php } ?>
</div>

</body>
</html>
