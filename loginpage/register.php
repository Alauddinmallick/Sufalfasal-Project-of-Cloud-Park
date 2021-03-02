<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $name_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "<script type='text/javascript'>
                    swal({
                        title: 'Opps...!',
                        text: 'This email is already taken.',
                        icon: 'error',
                      });
                      </script>";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "<script type='text/javascript'>
                swal({
                    title: 'Opps...!',
                    text: 'Something went wrong. Please try again later.',
                    icon: 'error',
                  });
                  </script>";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your Name.";
    }
    elseif(strlen(trim($_POST["name"])) < 3){
        $name_err = "Name must have atleast 3 characters.";
    } else{
        $name = trim($_POST["name"]);
    }
     // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($name_err)  && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (name,email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss",$param_name, $param_email, $param_password);
            
            // Set parameters
            $param_name=$name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            echo "<script type='text/javascript'>
                    swal({
                        title: 'Opps...!',
                        text: 'Alauddin',
                        icon: 'error',
                    });
                    </script>";
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "<script type='text/javascript'>
                swal({
                    title: 'Opps...!',
                    text: 'Something went wrong. Please try again later.',
                    icon: 'error',
                  });
                  </script>";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!---it is use only for popUp--->
    <style type="text/css">
        body{
            font: 14px sans-serif;
            background-image:url(img/image2.jpg);
            background-size:cover;
        }
        .wrapper{ width: 350px; padding: 20px; }

        .container{
            background-color:rgba(3, 252, 233, 0.757);
            width:400px;
            height:600px;
            margin-top:85px;
            border-radius:40px;

        }
        h2{
            text-align:center;
            color:blue;
        }
        p{
            color:yellow;
        }
        .go-home{
            margin-top:50px;
        }
        .go-home a{
            margin-left:100px;
            color:blue;
            font-size:20px;
            background-color:lightblue;
        }
    </style>
</head>
<body>
    <div class="wrapper container">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email Id</label>
                <input type="text" name="email" class="form-control" value="">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" onclick="popup()">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p> Already have an account? <a href="login.php">Login here</a>.</p>
            <div class="go-home">
                <a href="../index.php">Go back to Home</a>
            </div>
        </form>
    </div>  
    <script>
        function popup(){
            swal({
                    title: 'Thank you',
                    text: 'Your Registraion has been Successfully.',
                    icon: 'success',
                    
                  });
        }
    </script>   
</body>
</html>