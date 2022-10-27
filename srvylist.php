<?php
require_once 'nav.php';

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');

$query = "SELECT * FROM `survey_forms`";
$data = mysqli_query($conn, $query);
?>


<div class="container-lg p-4 mt-5" style="border:4px solid gray;">
    <div class="heading d-flex justify-content-center mt-2">
        <h1 class="">Survey List</h1>
    </div>

        <div class="table-responsive">
            <div class="table-wrapper" >
                <div class="table-title">
                    <div class="row" >
                       <div class="col-lg-12">
                       <button type="button" class="btn btn-primary" style="float:right;">
                            <a href="srvypage.php" style="color:white;">+ Add New Survey</a>
                        </button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-lg-2">Title</th>
                            <th class="col-lg-6">Description</th>
                            <th class="col-lg-2">Start Date</th>
                            <th class="col-lg-2">End Date</th>
                            <th class="col-lg-2">Action</th>
                        </tr>
                    </thead>
                        <tbody>
                    <?php

                    if (mysqli_num_rows($data) > 0) {
                        while ($arr = mysqli_fetch_row($data)) {
                            echo "
                                    <tr>
                                        <td>$arr[1]</td>
                                        <td>$arr[3]</td>
                                        <td>$arr[5]</td>
                                        <td>$arr[6]</td>"; ?>

                            <td>
                                <div class="action-itms d-flex justify-content-evenly">
                                    
                                    <a href="viewsurvey.php?survey_id=<?php echo $arr[0]; ?> "><button class="btn btn-light"><i class="fa-solid fa-eye"></i></button></a>
                                    
                                </div> 
<!-- 
             <div class="custom-control custom-switch mt-3">
				<input type="checkbox" class="custom-control-input toggle-opt" id="customSwitch" name='machine_state'>
				<label class="custom-control-label" for="customSwitch"> </label>
			</div> -->
                                
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
