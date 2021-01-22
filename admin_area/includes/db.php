<?php
$con = mysqli_connect("localhost", "root", "", "ecommerce");

if(mysqli_connect_errno()){
    echo "Faild to connect to MySQL:" . mysqli_connect_error();
}


?>