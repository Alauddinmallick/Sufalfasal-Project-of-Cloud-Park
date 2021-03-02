<?php
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$userid=$_POST['userid'];
$password=$_POST['password'];
$dateofbirth=$_POST['dateofbirth'];
$gender=$_POST['gender'];
$language=$_POST['language'];
$target_dir = "uploads/";
//PHOTO UPLOED//

    //connection database
$conn=mysqli_connect("localhost","root","","nsti");
if(!$conn)
{
    die("connected failed".mysqli_connect_error());
}
$sql1="INSERT INTO SIGNUP(firstname,lastname,userid,password,dateofbirth,gender,language,photo)
VALUES('$firstname','$lastname','$userid','$password','$dateofbirth','$gender','$language','photo')";
if(mysqli_query($conn,$sql1))
{
echo "Registration Successfully";
}
else
{
    echo "Not Registered".mysqli_error($conn);
}
mysqli_close($conn);
?>