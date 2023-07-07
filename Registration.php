<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container">

    <?php

     if (isset($_POST["submit"])) {
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $repeat_password = $_POST["repeat_password"];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);


        $errors = array();

        if (empty($fullname) OR empty($email) OR empty($password) OR empty($repeat_password) ) {
           array_push($errors,"All fields are required");
        }
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
           array_push($errors,"Email is not valid"); # code...
        }
        if (strlen($password)<8) {
           array_push($errors,"Password must be at least 8 characters long"); # code...
        }
        if ($password!==$repeat_password) {
            array_push($errors,"Password doesn't match");
        }


        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowcount = mysqli_num_rows($result);
        if ($rowcount>0) {
           array_push($errors,"Email already exists"); # code...
        }

        if (count($errors)>0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>" ; # code...
            }# code...
        }else{
           
           $sql ="INSERT INTO users (fullname,email,password) VALUES ( ?, ?, ? )";//we will insert the data into database
           $stmt = mysqli_stmt_init($conn);
           $prepareStmt = mysqli_stmt_prepare($stmt,$sql); 
           if ($prepareStmt) {
               mysqli_stmt_bind_param( $stmt,"sss", $fullname, $email, $password_hash);
               mysqli_stmt_execute( $stmt );
            echo "<div class='alert alert-success'>REGISTERED SUCCESSFULLY</div>";# code...
           }else {
            die("Something went wrong");
           }
        }

     }
    ?>
        <form action="Registration.php" method="post">
            <h1 align="center">REGISTRATION FORM</h1><br>
            <div class="form-group">
                <label for="">Name:</label>
                <Input type="text" name="fullname"  class="form-control"  placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <label for="">Email:</label>
                <Input type="email" name="email"  class="form-control" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="">Password:</label>
                <Input type="password" name="password"  class="form-control" placeholder="enter password">
            </div>
            <div class="form-group">
                <label for="">Re-enter password:</label>
                <Input type="password" name="repeat_password"  class="form-control" placeholder="Re enter password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> -->
</body>
</html>