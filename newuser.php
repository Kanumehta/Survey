<?php
require_once 'nav.php';

$mail=$_SESSION['email'];

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');



if (isset($_POST['save'])) {
  $name = $_POST['fullname']; 
  $email = $_POST['email'];
  $password = $_POST['password'];
  $type = $_POST['type'];
  $user_created_date=date('Y-m-d');

  //Variable

            $msg_fullname = "";
            $msg_email = "";
            $msg_password = "";


    //Pattern
            $rel_name1 = '/[0-9]/';
            $rel_name2 = '/[~`!@#$%^&*()\[\]\\.,;:@"\-\\_+={}<>?]/';
            $rel_email = '/^[A-z0-9_.-]+[@][a-z]+[.][a-z]{2,3}$/'; 
            $rel_pass1 = '/[A-Z]/'; 
            $rel_pass2 = '/[a-z]/';
            $rel_pass3 = '/[0-9]/';
            $rel_pass4 ='/[~`!@#$%^&*()\[\]\\.,;:\s@"\-\\_+={}<>?]/';

             $flag = true;

    //Name

     if($name == ""){
          $msg_fullname .= "Name field is Empty. <br>";
          $flag = false;
     } 
     else{
          if(preg_match($rel_name1, $name)){
               $msg_fullname .= "Name should not contain Numbers.<br>";
               $flag = false;
          }
          if(preg_match($rel_name2, $name)){
               $msg_fullname .= "Name should not contain Symbols.<br>";
               $flag = false;
          }
     }

     //Email

     if($email == ""){
          $msg_email .= "Email field is Empty.<br>";
          $flag = false;
     }
     else if(!preg_match($rel_email, $email)){
          $msg_email .= "Email is Invalid.<br>";
          $flag = false;
     }
     else{
      $query1="SELECT user_email FROM users WHERE user_email='$email'";
      $data1 = mysqli_query( $conn, $query1);
      $res1= mysqli_fetch_array($data1);
      if(!empty($res1)){
        $flag=false;
      }
      if(!$flag){
        $msg_email .= "This email is already registered.";
     }
     }

     //Password
     if($password == ""){
          $msg_password .= "Password field is Empty.";
          $flag = false;
     }
     else{
          if(!preg_match($rel_pass1, $password)){
               $msg_password .= "Password must contain at least one Uppercase.<br>";
               $flag = false;
          }
          if(!preg_match($rel_pass2, $password)){
               $msg_password .= "Password must contain at least one Lowercase<br>";
               $flag = false;
          }
          if(!preg_match($rel_pass3, $password)){
               $msg_password .= "Password must contain at least one Numeric Value.<br>";
               $flag = false;
          }
          if(!preg_match($rel_pass4, $password)){
               $msg_password .= "Password must contain at least one Special Character.<br>";
               $flag = false;
          }
          if(strlen($password)<6 || strlen($password)>18){
               $msg_password .= "Password length must be 5 to 20.<br>";
               $flag = false;
          }
     }
  if($flag){
        $password = md5($password);
        $query = "INSERT INTO `users`(`user_id`, `user_name`, `user_email`, `user_password`, `user_type` ,`user_created_by`,`user_created_date`) VALUES (NULL,'$name','$email','$password','$type','$mail','$user_created_date')";
        $data = mysqli_query( $conn, $query);
        // echo"<script> alert('User added Successfully');</script>";

        $query1= "SELECT MAX(user_id) AS user FROM users";
        $data1 = mysqli_query( $conn, $query1);
        $res1 = mysqli_fetch_array($data1);
        // print_r($res1) ;
        header("location:userprofile.php?user_id=$res1[user]");  
          
    }
}



?>


<div class="card p-4 mt-5" style="border:4px solid gray;">
	<div class="heading justify-content-center d-flex">
		<h1 class="">New User</h1>
	</div>
	<hr class="mb-4">
	<form method="post" class="row g-3" style="max-width: 60%; margin: auto;">

		<div class="col-md-6">
			<label for="inputName" class="form-label">Full Name</label>
			<input name="fullname" type="text" class="form-control" id="inputName">
			<span><?php echo @$msg_fullname;?></span>
		</div>

		<div class="col-md-6">
			<label for="inputEmail" class="form-label">Email</label>
			<input name="email" type="text" class="form-control" id="inputEmail">
			<span><?php echo @$msg_email;?></span>
		</div>

		<div class="col-md-6">
			<label for="inputPassword" class="form-label" style="margin-top: 10px;">Password</label>
			<input name="password" type="password" class="form-control" id="inputPassword">
			<span><?php echo @$msg_password;?></span>
		</div>

		<div class="col-md-6">
			<label for="" class="control-label" style="margin-top: 10px;">User Type</label>
			<select name="type" class="form-select custom-select  custom-select-sm" aria-label=".form-select-sm example">
  			<option>Admin</option>
  			<option>User</option>
			</select>
		</div>

		<div class="col-md-12 justify-content-center d-flex g-3" style="margin-top: 35px;">
					<button  name="save" type="submit" class="btn btn-primary" style="margin-right: .5%">Save</button>
					<button  name="cancel" type="submit" class="btn btn-secondary" style="margin-left: .5%">Cancel</button>
		</div>
	</form>
</div>

<?php
require_once 'sidenav.php'; 
?>
