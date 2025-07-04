<?php 
include 'header.php';
include 'dbconfig.php';
session_start();
if($_SESSION["user_role"] == 0){
    header("Location: main.php");
}

?>

<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Product List</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count = 1;
                        $sql = "SELECT p.*, c.name AS cat_name FROM products p LEFT JOIN category c ON p.cat = c.id";
                        $run = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($run)) {
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><img src="uploads/<?php echo $row['image']; ?>" width="80" height="80" style="object-fit:cover;"></td>
                            <td><?php echo htmlspecialchars($row['p_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['p_desc']); ?></td>
                            <td><?php echo htmlspecialchars($row['p_price']); ?></td>
                            <td><?php echo htmlspecialchars($row['cat_name']); ?></td>
                            <td>
                            <a href="pro_delete.php?id=<?php echo $row['p_id']; ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm">Delete</a>
                            <a href="pro_update.php?id=<?php echo $row['p_id']; ?>" class="btn btn-warning btn-sm">Update</a>
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

<?php include 'footer.php'; ?>