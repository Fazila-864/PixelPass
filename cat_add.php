<?php include 'header.php' ;
    include 'dbconfig.php';
?>



<?php
if(isset($_POST['add'])){
 $name = $_POST['name'];  
 
 $insert = "INSERT INTO category (name) VALUES ('".$name."')";
  $run = mysqli_query($conn, $insert);
  if($run){
    echo "<script>alert('Category added'); window.location.href='cat_view.php'; </script>";
    
  }
  else{
    echo "<script>alert('No Category added') </script>";

  }
}


?>


<div class="container my-5">
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Create New Category</h6>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Add Category</label>
                <input type="text" class="form-control" name="name">
               
            </div>
            
            <button type="submit" class="btn btn-primary" name="add">Insert</button>
        </form>
    </div>

</div>  



<?php include 'footer.php' ; ?>