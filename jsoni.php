<?php

    // open mysql connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bieber";
    $con = mysqli_connect($host, $username, $password, $dbname) or die('Error in Connecting: ' . mysqli_error($con));
echo "Data connection success successfully";
    // use prepare statement for insert query
    $st = mysqli_prepare($con, 'INSERT INTO school(sid,name,phone,class,age,father,city,state) 
    VALUES (?,?,?,?,?,?,?,?)');

    // bind variables to insert query params
    mysqli_stmt_bind_param($st, 'ssssssss', $sid,$name,$phone,$class,$age,$father,$city,$state);

    // read json file
    $filename = 'data.json';
    $json = file_get_contents($filename);   

    //convert json object to php associative array
    $data = json_decode($json, true);

echo "File open and decode success successfully<br />";
//echo "File DATA:<br />".$data;
    // loop through the array
    foreach ($data as $row) {
        // get the employee details
        $sid = $row['sid'];
        $name = $row['name'];
        $phone = $row['phone'];
        $class = $row['class'];
        $age = $row['age'];
        $father = $row['father'];
        $city = $row['city'];
        $state = $row['state'];
        
        // execute insert query
        mysqli_stmt_execute($st);
    }
echo "Insert your JSON record successfully=$filename <br />";
        //close connection
    mysqli_close($con);
echo "Connection close successfully";

?>