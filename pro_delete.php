<?php
include 'dbconfig.php';

session_start();
if($_SESSION["user_role"] == 1){
    header("Location: main.php");
}


if (isset($_GET['id'])) {
    $del_id = $_GET['id'];

    // Get image name
    $sql_img = "SELECT image FROM products WHERE id = '$del_id'";
    $res_img = mysqli_query($conn, $sql_img);
    $row_img = mysqli_fetch_assoc($res_img);
    
    // Delete image file
    if ($row_img && file_exists('uploads/' . $row_img['image'])) {
        unlink('uploads/' . $row_img['image']);
    }

    // Delete product
    $sql = "DELETE FROM products WHERE id = '$del_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product deleted'); window.location.href='pro_view.php';</script>";
    } else {
        echo "<script>alert('Delete failed'); window.location.href='pro_view.php';</script>";
    }
}
?>
