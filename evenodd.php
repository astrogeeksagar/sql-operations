<form action="" method="post">  
            <input type="text" name="number">
            <input type="submit" name="submit">
        </form>

<?php

if (isset($_POST['submit'])) {
    $num = $_POST['number'];

    if($num % 2 == 0) {
        echo $num." is even number";
    } else {
        echo $num." is odd number";

    }
}

?>