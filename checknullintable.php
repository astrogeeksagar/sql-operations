<?php

$conn =mysqli_connect('localhost','root','','sagar');

$qry = "SELECT name FROM users WHERE rights IS NULL OR rights='0'";
// $qry = "SELECT name FROM users WHERE lefts IS NULL OR lefts='0'";

$r = mysqli_query($conn,$qry);
while ($data=$r->fetch_assoc()) {
    
    $names = $data['name']; 
    echo $names;
    echo "</br>";
}

?>