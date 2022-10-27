<?php
session_start();
if(isset($SESSION["email"]))
{
    header('location: index.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">
    
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

</head>
<body>

	<div>
    <nav class="navbar navbar-light" style="height: 50px; background-color: #404040;">
  <a class="navbar-brand">Nav</a>
  <form class="form-inline">
  <button type="button" class="btn btn-link"><a href ="logout.php" style="color: white;">Logout</a></button>
  </form>
</nav>
</div>


<div class="wlcm">
  <h1><center>Welcome to the Footprints!</center></h1>
  <h3><center>Best PreSchool & Day Care</center></h3>
  <h5><center>Run by IIT-IIM Alumni.</center></h5>
  <center><img src="images/nic.webp" width=200px; height= 200px;></center>
</div>

<!-- <div class="dshbrd">
      <div class="content">
        <div class="logo"> -->
<div class="sidebar">
      <div class="logo_content">
        <div class="logo">
        <img src="images/footprint.png" width="150px">
      </div>
      <i class='bx bx-menu' id="btn"></i>
      <!-- <img src="images/fp.jpg" width="50px; height= 50px;"> -->
    </div>
    <div>
    <ul class="nav_list">
      <li>
        <a href="main.php">
        <i class='bx bx-grid-alt'></i>
        <span class="link_names">Dashboard</span>
        </a>
        <span class="srch">Dashboard</span>
      </li>

      <li>
        <a href="newuser.php">
        <i class='bx bx-user-plus'></i>
        <span class="link_names">New User</span>
        </a>
        <span class="srch">Users</span>
      </li>
      <li>
        <a href="userlist.php">
        <i class='bx bxs-user-detail'></i>
        <span class="link_names">User List</span>
        </a>
        <span class="srch">User List</span>
      </li>

    <li>
        <a href="srvypage.php">
        <i class='bx bx-plus'></i>
        <span class="link_names">New Survey</span>
        </a>
        <span class="srch">New Survey</span>
     </li>
       <li>
        <a href="srvylist.php">
        <i class='bx bx-list-ul' ></i>
        <span class="link_names">Survey List</span>
        </a> -->
        <span class="srch">Survey List</span>
              </li>
      <!-- <li>
        <a href="invitation.php">
        <i class='bx bx-mail-send'></i>
        <span class="link_names">Invitation</span>
        </a>
        <span class="srch">Invitation</span>
      </li> -->
      <li>
        <a href="report.php">
        <i class='bx bxs-report'></i>
        <span class="link_names">Report</span>
        </a>
        <span class="srch">Report</span>
      </li>
    </ul>
</div>
<script>
      let btn = document.querySelector("#btn");
      let sidebar = document.querySelector(".sidebar");
      let searchBtn = document.querySelector(".bx-search");

      btn.onclick = function(){
        sidebar.classList.toggle("active");
      }

      searchBtn.onclick = function(){
        sidebar.classList.toggle("active");
      }
    </script>



</body>
</html>