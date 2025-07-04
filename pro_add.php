<?php 
include 'dbconfig.php';
include 'header.php'; 

session_start();
if($_SESSION["user_role"] == 1){
    header("Location: main.php");
}
?>


<?php
if(isset($_POST['add'])){  
 $name = $_POST['name'];  
 $desc = $_POST['desc'];  
 $price = $_POST['price'];   
 $cat_id = $_POST['id'];    // category id

// Image logic
// Image Upload Handling
$imageName = $_FILES['image']['name'];
$imageTmpName = $_FILES['image']['tmp_name'];
$imageSize = $_FILES['image']['size'];
$imageError = $_FILES['image']['error'];


// Image Validation
$targetDir = "uploads/";
$allowedExts = ['jpg', 'jpeg', 'png', 'jfif']; //wpeb
$imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));


// Validate
if (!in_array($imageExt, $allowedExts)) {
    die("Only JPG, JPEG, PNG, JFIF files are allowed.");
}

if ($imageSize > 2 * 1024 * 1024) {  // 2mb
    die("Image size should not exceed 2MB.");
}

// Rename image
$imageNewName = str_replace(' ', '_', pathinfo($imageName, PATHINFO_FILENAME)); // remove spaces 

// aptech logo.png -> aptech_log.png
$imageNewName = $imageNewName . "_" . date("Ymd_His") . "." . $imageExt;
 //aptech_log_20250623_121703.jpg

$imageDestination = $targetDir . $imageNewName;

// uploads/aptech_log_20250623_121703.jpg


// Upload file
if (move_uploaded_file($imageTmpName, $imageDestination)) {
   

    // $sql = "INSERT INTO products (p_name,p_desc,p_price, image, cat) VALUES ('$name', '$desc', '$price', '$imageNewName', $cat_id)";

    $sql = "INSERT INTO products(p_name,p_desc,p_price,image,cat) VALUES ('".$name."','".$desc."',  '".$price."', '".$imageNewName."' , '".$cat_id."')";
    
    $run = mysqli_query($conn, $sql);
    if($run){
      echo "<script>alert('product added'); window.location.href='pro_view.php'; </script>";
      
    }
    else{
      echo "<script>alert('No product added') </script>";
  
    }
} 
else {
    echo "Failed to upload image.";
}




}


?>
   <!-- Form Start -->
   <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Add Product</h6>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="name">
                                  
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Product Description</label>
                                    <input type="text" class="form-control" name="desc">
                                  
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Product Price</label>
                                    <input type="text" class="form-control" name="price">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Product Image</label>
                                    <input type="file" class="form-control" name="image">
                                  
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Product Category</label>
                                    <select name="id" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                     $sql = "SELECT * FROM category";
                                                     $run = mysqli_query($conn, $sql);
                                                     while($row = mysqli_fetch_array($run)){
                                                    ?>
                                                    <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>

                                                    <?php
                                                     }
                                                    ?>
                                    </select>
                                  
                                </div>
                                <button type="submit" class="btn btn-primary" name="add">Add Product</button>
                            </form>
                        </div>
                    </div>
                
                </div>
            </div>
            <!-- Form End -->

<?php include 'footer.php'; ?>