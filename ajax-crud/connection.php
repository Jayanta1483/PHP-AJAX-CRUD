<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "my_db";

$connect = new mysqli($server, $user, $password, $db);

if($connect->connect_error){
    echo "<h2 style='color:red;text-align:center;'>Connection Error Occured...Please Check Your Connection..!!</h2>";
}

?>