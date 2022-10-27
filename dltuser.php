<?php

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');

$id = $_GET['id'];
$query = "DELETE FROM `users` where `user_id` = '$id'";
$data = mysqli_query($conn, $query);

header("location:userlist.php");

?>