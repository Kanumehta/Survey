<?php
require_once 'php/sign.php';
?>

<!DOCTYPE html>
<html>
<head>
     <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
  
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/6e67e55af3.js" crossorigin="anonymous"></script> 
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>


<link rel="stylesheet" href="css/signup.css">
<script src="js/sign.js"></script>



</head>
<body>

    <div>
    <nav class="navbar navbar-light" style="height: 50px; background-color: #404040;">
        <img src="images/footprint.png" width="150px">
  <a class="navbar-brand"></a></nav>

<div class="login-form">
    <form method="post" onSubmit="return Validation();">
        <h2 class="text-center">Sign up</h2>        
        
        <!-- Name -->
        <div class="form-group">
            <div class="input-group">                
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="fa fa-user"></span>
                    </span>                    
                </div>
                <input type="text" class="form-control" name="name" placeholder="Full Name" id="name">
            </div>
            <span id="f_name" class="text-danger" style="font-weight: bold;"><?php echo @$msg_name;?></span>
        </div>
        
        <!-- Email -->
        <div class="form-group">
            <div class="input-group">                
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="fa fa-envelope" style="font-size:11px"></span>
                    </span>                    
                </div>
                <input type="text" class="form-control" name="email" placeholder="Email Id" id="email">
            </div>
            <span id="f_email" class="text-danger" style="font-weight: bold;"><?php echo @$msg_email;?></span>
        </div>

        <!-- Password -->
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>                    
                </div>
                <input type="password" class="form-control" name="pswrd" placeholder="Password" id="password">
            </div>
            <span id="f_pass" class="text-danger" style="font-weight: bold;"><?php echo @$msg_password;?></span>
        </div>  

        <!-- Confirm Password -->
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>                    
                </div>
                <input type="password" class="form-control" name="cnfrmpswrd" placeholder="Confirm Password" id="cnfrm">
            </div>
            <span id="f_cnfrm" class="text-danger" style="font-weight: bold;"><?php echo @$msg_cnfrm;?></span>
      </div>  
      
        <!-- Button       -->
        <div class="form-group">
            <button type="submit" name="signup" class="btn btn-block login-btn" style="background-color: #888; color: white;">Create New Account</button>
        </div>
        <div class="hint-text">If you have an account <a href="" class="text-success">Sign In!</a></div>
        <div class="hint-text"><?php echo @$msg;?></div>
    </form>
    
</div>
</body>
</html>