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
    <title>Registration form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
            //to check whether the form is submitted using isset() $_POST and array key["submit"] name="submit"
            //$_POST["fullname"] fullname is  the attribute of name from  the form group
            if(isset($_POST["submit"])){
                $fullname=$_POST["fullname"];
                $email=$_POST["email"];
                $password=$_POST["password"];
                $confirmpassword=$_POST["confirmpassword"];

                //inscribe the password so that others cannot access it through the database using password_hash() and arguments $password and PASSWORD_DEFAULT
                $passwordHash=password_hash($password,PASSWORD_DEFAULT);

                //validation using errors array
                $errors=array();
                //checking empty fields using empty()
                if(empty($fullname) || empty($email) || empty($password) || empty($confirmpassword)){
                // Pushing error in the array
                    array_push($errors, "All fields are required");
                }
                //valid email or not using !filter_var() (if return false) and arguments $email and FILTER_VALIDATE_EMAIL constant in php
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    array_push($errors,"Email is not valid");
                }
                //Length of password using strlen()
                if(strlen($password)<8){
                    array_push($errors,"Password should be atleast 8 characters long");
                }
                //Confirmation of password
                if($password!==$confirmpassword){
                    array_push($errors,"Password doesnot match");
                }

                //duplicate email user error
                //include the file database.php using require_once()
                require_once "database.php";
                $sql="SELECT * FROM users WHERE email='$email'";
                $result=mysqli_query($conn,$sql);
                //count the number of rows in email field. If count>0 error duplicate email
                $rowCount=mysqli_num_rows($result);
                if($rowCount>0){
                    array_push($errors,"Email already exists");
                }

                //to check the number of errors in the errors array using count()
                if(count($errors)>0){
                    //display
                    foreach($errors as $error){
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }
                else{
                    //We will insert into database
                    $sql="INSERT INTO users (full_name,email,password) VALUES ( ?, ?, ? )";
                    
                    //mysqli_stmt_init() function initializes a statement and returns an object suitable for mysqli_stmt_prepare()
                    //we have to store the $conn variable from database.php in the argument
                    $stmt=mysqli_stmt_init($conn);
                    $stmtPrepare=mysqli_stmt_prepare($stmt,$sql);
                    //if $stmtPrepare returns true then we store values
                    if($stmtPrepare){
                        //bind the values to sql commands using mysqli_stmt_bind_param()
                        mysqli_stmt_bind_param($stmt,"sss",$fullname,$email,$passwordHash); //sss-> 3 string values
                        //execute the commands using mysqli_stmt_execute($stmt)
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>You have registered successfully</div>";
                    }
                    else{
                        //stop executing the program 
                        die("Something went wrong");
                    } 
                }
            }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:" >
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:" >
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:" >
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password:" >
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit" >
            </div>
        </form>
        <div>
        <p>Already registered?<a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>