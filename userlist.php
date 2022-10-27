<?php
require_once 'nav.php';

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');

$query = "SELECT * FROM `users`";
$data = mysqli_query($conn, $query);
?>

<div class="container-lg p-4 mt-5" style="border:4px solid gray;">
    <div class="heading d-flex justify-content-center mt-2">
        <h1 class="">User List</h1>
    </div>
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                       <div class="col-lg-12">
                       <button type="button" class="btn btn-primary" style="float:right;">
                          	<a href="newuser.php" style="color:white;">+ Add New User</a>
                        </button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-lg-4">Name</th>
                            <th class="col-lg-5">Email</th>
                            <th class="col-lg-2">User Type</th>
                            <th class="col-lg-1">Action</th>
                        </tr>
                    </thead>
                        <tbody>
                    <?php

                    if (mysqli_num_rows($data) > 0) {
                        while ($arr = mysqli_fetch_row($data)) {
                            echo "
                                    <tr>
                                        <td>$arr[1]</td>
                                        <td>$arr[2]</td>
                                        <td>$arr[4]</td>"; ?>

                            <td>
                                <div class="action-itms d-flex justify-content-evenly">
                                    <a href="userprofile.php?user_id=<?php echo $arr[0]; ?> "><button class="btn btn-light"><i class="fa-solid fa-eye"></i></button></a>
                                </div>
                            </td>
                            </tr>

                    <?php    }
                    }

                    ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

<?php
require_once 'sidenav.php';
?>
