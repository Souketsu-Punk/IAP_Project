<?php
$servername = "localhost";
$username = "root";      
$password = "Admin.21";  
$dbname = "borrow_my_skill";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
