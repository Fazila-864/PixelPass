<?php include "dbconfig.php"?>
<?php
session_start();
if(isset($_POST["submit"])){
   $name = mysqli_real_escape_string($conn,$_POST["name"]);
   $email = mysqli_real_escape_string($conn,$_POST["email"]);
   $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
   $role = mysqli_real_escape_string($conn,$_POST["role"]);
  if(isset($_FILES["profile_pic"])){
    $errors = array();
    $file_name = $_FILES["profile_pic"]["name"];
    $file_size = $_FILES["profile_pic"]["size"];
    $file_tmp = $_FILES["profile_pic"]["tmp_name"];
    $file_type = $_FILES["profile_pic"]["type"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
   $allowed_ext = array("jpeg", "jpg", "png");

    if (!in_array($file_ext, $allowed_ext)){
      $errors[] = "Please upload image in jpg or png file";
    }
    if($file_size > 2*1048576){
      $errors[] = "File size must be less than 2MB.";
    }
    if(empty($errors) == true){
      $new_file_name = uniqid() . '.' . $file_ext;
      move_uploaded_file($file_tmp , "uploads/".$new_file_name);

       $query = "select email from authorization where Email = '$email'";
    $queryExec = mysqli_query($conn,$query);

    if(mysqli_num_rows($queryExec)>0){
        echo "<script>alert('Email already Exist')</script>";
    }else{
        $query1 = "insert into authorization (Username,Email,Password,Role,Userpic) values ('$name','$email', '$password', '$role', 'uploads/$new_file_name')";
        $queryExec1 = mysqli_query($conn, $query1);
        if($queryExec1){

            session_start();
      $_SESSION["user_name"] = $name;
      $_SESSION["user_email"] = $email;
      $_SESSION["user_id"] = mysqli_insert_id($conn);
      $_SESSION["user_role"] = $role;
      $_SESSION["user_pic"] = "uploads/".$new_file_name;
      if($_SESSION["user_role"] == 1){
    header("Location: dashboard.php");
    exit();
}
       else{header("Location: main.php");} 
       exit();
        }
    }
    }else{
      foreach($errors as $error){
        echo "<div class='alert alert-danger'>$error</div>";
      }
      
    }

  }  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg rounded-4">
          <div class="card-body p-5">
            <h3 class="text-center mb-4">Sign Up</h3>
            <form action= "signup.php" method= "Post" enctype= "multipart/form-data">
              <!-- Name -->
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name= "name" placeholder="Enter your name" required>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password" required>
              </div>

              <!-- Role -->
              <div class="mb-4">
                <label for="role" class="form-label" >Role</label>
                <select class="form-select" id="role" name="role" required>
                  <option value="">Choose your role</option>
                  <option value="0">User</option>
                  <option value="1">Admin</option>
                  
                </select>
              </div>
          <!-- Profile Picture -->
              <div class="mb-4">                
                <label for="profile_pic" class="form-label">Upload Profile Picture</label>                
                <input class="form-control" type="file" id="profile_pic" name="profile_pic" required>              
              </div>

              <!-- Submit -->
              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg" name= "submit">Create Account</button>
              </div>

              <!-- Sign In Link -->
              <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

