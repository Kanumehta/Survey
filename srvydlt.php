<?php

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');

$id = $_GET['id'];
$query = "DELETE FROM `survey_forms` where `survey_id` = '$id'";
$data = mysqli_query($conn, $query);

header("location:srvylist.php");

?>