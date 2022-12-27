<?php
    session_start();
    if(isset($_SESSION['user'])) {
        header("Location: http://localhost/Login_system/index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <!-- Bootstrap CSS file Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <div class="container">

    <!-- PHP CODE START HERE -->

        <?php
        if(isset($_POST['submit'])){
            $fullName = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];

            // encode the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // For validation 
            $errors = array();
            // Check empty value
            if(empty($fullName) OR empty($email) OR empty($password) OR empty($repeat_password)) {
                array_push($errors, "All fields are required");
            }

            // For Email validation
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errors, "Email is not valid");
            }

            // For Password
            if(strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
            
            // Check repeat password same as before password
            if($password!=$repeat_password) {
                array_push($errors, "Password does not Match");
            }

            // Create SQL connection 
            require_once("database.php");

            // For checking duplicate Email address
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($mysql_connection, $sql);

            // Check number of row and values in the result variable
            $rowCount = mysqli_num_rows($result);

            if($rowCount > 0){
                array_push($errors, "Email is already exist.");
            }

            // count function to check how many error in errors array
            if(count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }else {

                // Run SQL Query
                $sql = "INSERT INTO users (full_name, email, password) VALUES( ?, ?, ? )";

                //Initialize a statement and return an object to use with stmt_prepare():
                $stmt = mysqli_stmt_init($mysql_connection);
                $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);

                if($prepare_stmt){
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $password_hash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully. </div>";
                }else {
                    die("something went wrong.");
                }

            }

        }
        ?>

        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="email"  class="form-control" name="email" placeholder="Email" autocomplete="off" >
            </div>
            <div class="form-group">
                <input type="password"  class="form-control" name="password" placeholder="Password" autocomplete="off" >
            </div>
            <div class="form-group">
                <input type="password"  class="form-control" name="repeat_password" placeholder="Repeat Password" autocomplete="off" >
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
            <div class="switch-btn"><p>Already Registered <a href="login.php">Login Here</a></p></div>
        </div>
    </div>

</body>
</html>