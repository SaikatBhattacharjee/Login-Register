<?php
    session_start();
    if(isset($_SESSION["users"])){
        header("Location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
            if(isset($_POST["login"])){
                $email=$_POST["email"];
                $password=$_POST["password"];
                //to check whether email exists or not using require_once()
                require_once "database.php";
                $sql="SELECT * FROM users WHERE email='$email'";
                $result=mysqli_query($conn,$sql);
                //to access the column of the database using mysqli_fetch_array()  the constraint MYSQLI_ASSOC returns associative array
                //return true/false whether email exists or not
                $users=mysqli_fetch_array($result,MYSQLI_ASSOC);
                if($users){
                    if(password_verify($password,$users["password"])){
                        session_start();
                        $_SESSION["users"]="yes";
                        header("Location:index.php");
                        die();
                    }
                    else{
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                }
                else{
                    echo "<div class='alert alert-danger'>Email does not match</div>";
                }
            }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter your email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter your password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
        <p>Not registered yet?<a href="registration.php">Register here</a></p>
        </div>
    </div>
</body>
</html>