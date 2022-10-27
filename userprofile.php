<?php
require_once 'nav.php';

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');



$id= $_GET['user_id'];
$query1 = "SELECT * FROM `users` WHERE `user_id`='$id'";
$data = mysqli_query($conn ,$query1);
$arr = mysqli_fetch_row($data);

// print_r($arr);

$name= $arr[1];
$email= $arr[2];
$role= $arr[4];

if(isset($_POST['back'])){
    header("location:userlist.php");
}

?>
   

<section class="section profile">
   
        <div class="table-responsive">
        <div class="col-xl-5" style="margin:auto;">

            <div class="card  p-4 mt-5">
                <div class="card-body pt-3">

                     <div style="float:right;">
                    <a href="updateuserlist.php?id=<?php echo $arr[0]; ?>"><button class="btn btn-light"><i class="fa-solid fa-pen-to-square"></i></button></a>

                    <a href="dltuser.php?id=<?php echo $arr[0]; ?> "><button  onclick="return confirm('Are you sure, You want to delete this?');" class="btn btn-light"><i class="fa-solid fa-trash-can"></i></button></a>
                     </div>

                <h2>User Details</h2>



                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                        <button class="nav-link active" id="nav-profile-overview" data-toggle="tab" href="#profile-overview" role="tab"  aria-selected="false" ></button>
                        </li>

                     
                    </ul>

                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" role="tabpanel" aria-labelledby="nav-profile-overview" id="profile-overview">
                            
                        
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                <div class="col-lg-9 col-md-8"><?php echo $name; ?></div>
                            </div>


                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8"><?php echo $email;?></div>
                            </div>


                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">User Type</div>
                                <div class="col-lg-9 col-md-8"><?php echo $role; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="col-md-12 justify-content-center d-flex g-3" style="margin-top:10px; margin-left: 15%; ">
<form method="post">
    <button  name="back" type="submit" class="btn btn-secondary" style="margin-left: .5%">Back</button>
</form>
</div>



<?php
require_once 'sidenav.php';
?>
