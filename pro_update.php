<?php 
include 'header.php';
include 'dbconfig.php';

session_start();
if($_SESSION["user_role"] == 1){
    header("Location: main.php");
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch product
    $sql = "SELECT * FROM products WHERE p_id = '$id'";
    $run = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($run);

    if (!$product) {
        echo "<script>alert('Product not found'); window.location.href='pro_view.php';</script>";
        exit;
    }
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $cat_id = $_POST['cat'];

    $sql_update = "UPDATE products SET 
        p_name = '$name', 
        p_desc = '$desc', 
        p_price = '$price', 
        cat = '$cat_id' 
        WHERE p_id = '$id'";
    
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Product updated'); window.location.href='pro_view.php';</script>";
    } else {
        echo "<script>alert('Update failed');</script>";
    }
}
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Update Product</h6>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($product['p_name']); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Description</label>
                        <input type="text" class="form-control" name="desc" value="<?php echo htmlspecialchars($product['p_desc']); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Price</label>
                        <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($product['p_price']); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Category</label>
                        <select name="cat" class="form-control">
                            <option value="">Select Category</option>
                            <?php
                            $sql_cat = "SELECT * FROM category";
                            $run_cat = mysqli_query($conn, $sql_cat);
                            while($row_cat = mysqli_fetch_array($run_cat)) {
                                $selected = ($row_cat['id'] == $product['cat']) ? 'selected' : '';
                                echo "<option value='{$row_cat['id']}' $selected>{$row_cat['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
