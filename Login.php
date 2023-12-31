<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container">

    <?php

    if (isset($_POST["login"])) {
      $email=$_POST["email"] ;
      $password=$_POST["password"];
      
      require_once "database.php"; 
      $sql = "SELECT * FROM users WHERE email = '$email'";
      $result = mysqli_query($conn,$sql);
      $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
      if ($user) {
         if (password_verify($password, $user["password"])) {

            session_start();
            $_SESSION["user"] = "yes";

            header("Location: index.php");
            die();
         }else{
            echo "<div class='alert alert-danger'>Password doesn't exist</div>";
         }
      }else{
        echo "<div class='alert alert-danger'>Email doesn't exist</div>";
      }
    }

    ?>
        <form action="Login.php" method="post">
            <div class="form-group">
                
                <input type="email" name="email" class="form-control" placeholder="Enter your email">
            </div>
            <div class="form-group">
                
                <input type="password"  name="password" class="form-control" placeholder="Enter password">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>No registered yet ? <a href="Registration.php">Register here</a></p>
        </div>
    </div>
</body>
</html>