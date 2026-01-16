<?php
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>

<h2>Manage Gallery</h2>

<?php while($row = mysqli_fetch_assoc($data)) { ?>
    <div style="display:inline-block; margin:10px;">
        <img src="../uploads/gallery/<?php echo $row['image']; ?>" width="150"><br>
        <a href="gallery_delete.php?id=<?php echo $row['id']; ?>">Delete</a>
    </div>
<?php } ?>
