<?php
    //we use session so that others cant access user dashboard directly
    //Session in PHP is a way of temporarily storing and making data accessible across all the website pages. It will create a temporary file that stores various session variables and their values. This will be destroyed when you close the website.
    session_start();
    //if the user is not logged in we will send them to login page
    if(!isset($_SESSION["users"])){
        header("Location:login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to dashboard</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
</body>
</html>