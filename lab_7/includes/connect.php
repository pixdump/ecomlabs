<?php
    $conn=mysqli_connect('localhost','root','root','ecom');
    // if($conn){
    //     echo "Connection successful";
    // }
    // else{
    //     die(mysqli_error($conn));
    // }
    if(!$conn){
        die(mysql_error($conn));
    }


?>