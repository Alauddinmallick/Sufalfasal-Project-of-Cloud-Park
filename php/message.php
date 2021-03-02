<?php
if(isset($_POST['send'])){
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'sufalfasal');
    
    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $name=$_POST['name'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];

    $sql1="INSERT INTO message(id,name,email,subject,message)
            VALUES('','$name','$email','$subject','$message')";
            if(mysqli_query($link,$sql1))
            {
                echo "<script type='text/javascript'>
                    swal({
                        title: 'Thank you..',
                        text: 'Your Message has been sent',
                        icon: 'success',
                    });
                    </script>";
                    echo "Message successs sent";
            }
            else
            {
                echo "<script type='text/javascript'>
                    swal({
                        title: 'Opps...!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'error',
                    });
                    </script>";
            }
    mysqli_close($link);
}
?>
