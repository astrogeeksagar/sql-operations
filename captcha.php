<?php
if(isset($_POST['submit']))
{
$secret_key = '6LcpMDYjAAAAAFgR5iC64lJQVGB8yUZ0RcWqHgPv';
$recaptcha = $_POST['g-recaptcha-response'];
$conn =mysqli_connect('localhost','root','','sagar');
$name=$_POST['name'];
$phone=$_POST['mob'];
$url = 'https://www.google.com/recaptcha/api/siteverify?secret='
. $secret_key . '&response=' . $recaptcha;
$response = file_get_contents($url);
$response = json_decode($response);
if ($response->success == true) {
  // echo '<script>alert("Google reCAPTACHA verified")</script>';
$qry= "SELECT * FROM users WHERE phone='$phone'";
$check=mysqli_query($conn,$qry) or die();
$duplicate=mysqli_num_rows($check);
   if($duplicate==0)
    {
      $query1="INSERT INTO users (name,phone) VALUES('$name','$phone')";
      $result=mysqli_query($conn,$query1) or die();
      echo 'Record Submitted';

    }
    else
    {
      echo'The phone '.$phone.' is already present in the user table';
    }
} else {
  echo 'please check google recaptcha';
}
}
?>
<html>
  <head>
  <script src=
        "https://www.google.com/recaptcha/api.js" async defer>
    </script>
  </head>
<body>
<form method='post' action='#'>
name: <input type='text' name='name'></br>
phone: <input type='number' name='mob'></br>
<div class="g-recaptcha" data-sitekey="6LcpMDYjAAAAAFRzRu-fptXY6hOA19Whfab2mUj5"></div></br>
<input type='submit' name='submit' value='Submit'>
</form>
</body>
</html>