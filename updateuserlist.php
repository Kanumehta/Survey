<?php
require_once 'nav.php';

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');
$id = $_GET['id'];
// $name = $_GET['u_name'];
// $email = $_GET['u_email'];
// $type = $_GET['u_type'];

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $enc_pass = md5($password);
    $options = $_POST['options'];
    if(!empty($password)){
        $query = "UPDATE `users` SET `user_name`='$name',`user_email`='$email',`user_password`='$enc_pass',`user_type`='$options' WHERE `user_id`='$id' ";
        $data = mysqli_query($conn , $query);
        header("location:userlist.php");
    }
    else{
        echo "<script> alert('Password field is empty!'); </script>";
    }
}

if(isset($_POST['cancel'])){

    header("location:userprofile.php?user_id=$id");
}
$query1= "SELECT * FROM `users` WHERE  user_id='$id'";
$data1 = mysqli_query( $conn, $query1);
$res1= mysqli_fetch_array($data1);

$name = $res1['user_name'];
$email = $res1['user_email'];
$type = $res1['user_type'];

?>

<div class="card p-4 mt-5">
    <div class="heading d-flex justify-content-center">
        <h1 class="">Update User List</h1>
    </div>
    <hr class="mb-4">
    <form method="post" class="row g-3" style="max-width: 85%; margin: auto;">
        <div class="col-md-6">
            <label for="inputName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="inputName" name="name" value="<?php echo @$name; ?>">
        </div>
        <div class="col-md-6">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="text" class="form-control" id="inputEmail" name="email" value="<?php echo @$email; ?>">
        </div>

        <div class="col-md-6">
            <label for="inputPassword" class="form-label" style="margin-top: 10px;">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password">
        </div>

        <div class="col-md-6">
            <label for="inputState" class="form-label" style="margin-top: 10px;">User Type</label>
            <select class="form-select custom-select  custom-select-sm" aria-label=".form-select-sm example" name="options">
                <?php
                // if($type == "User"){
                //     echo "<option selected>User</option>
                //     <option>Admin</option>";
                // }else{
                //     echo "<option>User</option>
                //     <option selected>Admin</option>";
                // }
                $a = "<option selected>User</option>
                <option>Admin</option>";
                $b = "<option>User</option>
                <option selected>Admin</option>";
                echo ($type == "User") ? ($a) : ($b) ;
                
                
                ?>
            </select>
        </div>
        <div class="col-md-12 d-flex justify-content-center g-3" style="margin-top: 35px;">
            <button type="submit" class="btn btn-primary" style="margin-right:.5%;" name="update">Update</button>
            <button type="submit" class="btn btn-secondary" name="cancel" style="margin-left:.5%;">Cancel</button>
        </div>

    </form>
</div>
<?php
require_once 'sidenav.php';
?>
