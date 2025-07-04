<?php include 'header.php';
    include 'dbconfig.php';
session_start();
if($_SESSION["user_role"] == 0){
    header("Location: main.php");
}
?>


<?php
if(isset($_GET['id']))
{
    $del_id= $_GET['id'];
    $sql2 = "DELETE from category where id = '".$del_id."'";
    $run2 = mysqli_query($conn, $sql2);
    if($run2){
        echo "<script>alert('product deleted'); window.location.href='cat_view.php'; </script>";
        
      }
      else{
        echo "<script>alert('No product deleted') </script>";
    
      }
}

?>


<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Basic Table</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Category ID</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                 <?php 
                    $count = 1;
                    $sql = "SELECT * FROM category";
                    $run = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($run)) {
                    ?>
                        <tr>
                            <td ><?php echo $count; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>
                                <a href="cat_view.php?id=<?php echo $row['id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this category?');"
                                    class="btn btn-danger">Delete</a>
                            </td>
                            <td>
                                <a href="cat_update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Update</a>
                            </td>
                        </tr>
                        <?php 
                    $count++;
}
?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
<!-- Table End -->



<?php include 'footer.php' ; ?>