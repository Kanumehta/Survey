<?php
require_once 'php/log.php';

?>

<!DOCTYPE html>
<html>
<head>
     <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
     -->


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/6e67e55af3.js" crossorigin="anonymous"></script> 
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>


 <script src="js/log.js"></script>
<link rel="stylesheet" href="css/log.css">


</head>
<body>

     <div>
    <nav class="navbar navbar-light" style="height: 50px; background-color: #404040;">
        <img src="images/footprint.png" width="150px">
  <a class="navbar-brand"></a></nav>


<div class="login-form">
    <form method="post" onSubmit="return Validation();">
        <h2 class="text-center">Login</h2>        
        

        <div class="form-group">
            <div class="input-group">                
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="fa fa-envelope" style="font-size:11px"></span>
                    </span>                    
                </div>

                <input type="text" class="form-control" name="email" placeholder="Email Id" id="email">
            </div>
            <span id="f_email" class="text-danger" style="font-weight: bold;"></span>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>                    
                </div>
                <input type="password" class="form-control" name="pswrd" placeholder="Password" id="password">
            </div>
            <span id="f_pass" class="text-danger" style="font-weight: bold;"></span>
      </div>  
        
      
        <div class="form-group">
            <button type="submit" name="login" class="btn btn-block login-btn"style="background-color: #888; color: white;">Login</button>
        </div>
        <!-- <div class="form-group">
            <button type="submit" name="signup" class="btn btn-block login-btn" style="background-color: #888; color: white;">
                <img src="images/google.png" class="img_resize">
                Sign in with Google
            </button>
        </div>
         <div class="form-group">
            <button type="submit" name="signup" class="btn btn-block login-btn" style="background-color: #888; color: white;">
                 <img src="images/facebook.png" class="img_resize">
                Sign in with Facebook
            </button>
        </div> -->
        <!-- <div class="clearfix">
            <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
            <a href="#" class="float-right text-success">Forgot Password?</a>
        </div>   -->
        <div class="hint-text">Don't have an account? <a href="signup.php" class="text-success">Sign Up!</a></div>
        <div class="hint-text"><?php echo @$msg;?></div>
    </form>

</div>
</body>
</html>

