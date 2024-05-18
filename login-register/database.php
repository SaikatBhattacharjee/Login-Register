<!-- for connection into the database -->
<?php
    $hostName="localhost";
    $dbUser="root";
    $dbPassword="";
    $dbName="login_register";
    $conn=mysqli_connect($hostName,$dbUser,$dbPassword,$dbName);
    //if conn return false stop the execution using die()
    if(!$conn){
        die("Something went wrong!");
    }
?>