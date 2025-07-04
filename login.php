<?php include "dbconfig.php"?>
<?php
if(isset($_POST["login"])){
  $email = $_POST["email"];
  $password = $_POST["password"];



  $query = "select * from authorization where Email = '$email'";
  $queryEcex = mysqli_query($conn, $query);
  if (mysqli_num_rows($queryEcex)>0){
    $row= mysqli_fetch_assoc($queryEcex);
    if(password_verify($password, $row["Password"])){
      session_start();
      $_SESSION["user_name"] = $row['Username'];
      $_SESSION["user_email"] = $row['Email'];
      $_SESSION["user_id"] = $row["Userid"];
      $_SESSION["user_role"] = $row["Role"];
      $_SESSION["user_pic"] = $row["Userpic"];

if($_SESSION["user_role"] == 1){
    header("Location: dashboard.php");
}
       else{header("Location: main.php");} 
    }else{
    
    echo "<script>alert('Incorrect Email or Password')</script>";
  
    }
  }else{
    echo "<script>alert('Incorrect Email or Password')</script>";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Form</title>
  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-4">
      <div class="card shadow rounded-4 p-4">
        <h3 class="text-center mb-4">Login</h3>
        <form action="login.php" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label" >Email address</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary" name = "login">Login</button>
          </div>
        </form>
        <div class="text-center mt-3">
          <a href="#">Forgot password?</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

