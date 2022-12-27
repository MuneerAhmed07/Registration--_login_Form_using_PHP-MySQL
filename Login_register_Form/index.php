<!-- create session if user cannot login it return to login page -->
<?php
    session_start();
    if(!isset($_SESSION['user'])) {
        header("Location: http://localhost/Login_system/login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <!-- Bootstrap CSS file Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <div class="container">
        <h1>Welcome to Honey Web </h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>

</body>
</html>