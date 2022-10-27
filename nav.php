<?php
session_start();
if(!isset($_SESSION["email"]))
{
    header('location: login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/"> -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/6e67e55af3.js" crossorigin="anonymous"></script>
    <script src="js/userlist.js"></script>
    <script src="js/srvylist.js"></script>
    

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

<link rel="stylesheet" href="css/dash.css">
<link rel="stylesheet" href="css/signup.css">
<link rel="stylesheet" href="css/log.css">
<link rel="stylesheet" href="css/userlist.css">

<style>  
  .data{
    display: none;
  }
</style>

</head>
<body>

	<div>
    <nav class="navbar navbar-light" style="height: 50px; background-color: #404040;">
  <a class="navbar-brand"></a>
  <form class="form-inline">

  <button type="button" class="btn btn-link"><a href ="logout.php" style="color: white;">Logout</a></button>

  </form>
</nav>
</div>
