<?php

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');

$id = $_GET['id'];
// $title = $_GET['title']; 
// $description = $_GET['description'];
// $startdate = $_GET['startdate'];
// $enddate = $_GET['enddate'];



if(isset($_POST['save'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $modifieddate= date("Y-m-d");
    // $startdate = ($startdate);
    // $enddate = ($enddate);
    if(!empty($enddate)){


        $query = "UPDATE `survey_forms` SET `survey_title`='$title',`survey_description`='$description', `survey_status`='Active',`survey_created_date`='$startdate',`survey_end_date`='$enddate',`survey_last_modified_date`='$modifieddate' WHERE `survey_id`='$id'";
        $data = mysqli_query($conn , $query);
        header("location:srvylist.php");
    }
    else{
        echo "<script> alert('Date field is empty!'); </script>";
    }
}

if(isset($_POST['reset'])){
    header("location:srvylist.php");
}
$query1= "SELECT * FROM `survey_forms` WHERE  survey_id='$id'";
$data1 = mysqli_query( $conn, $query1);
$res1= mysqli_fetch_array($data1);

$title = $res1['survey_title'];
$description = $res1['survey_description'];


require_once 'nav.php';
?>

<div class= "card p-4 mt-5">
	<div class="heading d-flex justify-content-center mt-2">
		<h1 class="">Update Survey List</h1>
	</div>


<!-- <div class="table-responsive"> -->
<div class="container">
	<form method="post" class="row" style="max-width: 70%; margin: auto;">
		<div class="col-12">
			<div class="row mb-3">
					<label for="" class="control-label">Title</label>
					<input type="text" name="title" class="form-control form-control-sm" value="<?php echo @$title; ?>">
			</div>

			<div class="row mb-3">
					<label class="control-label">Description</label>
					<textarea name="description" id="" cols="30" rows="2" class="form-control"><?php echo @$description; ?></textarea>
			</div>

			<div class="row mb-3">
            <label for="" class="control-label">Survey Category</label>
            <select class="form-select custom-select custom-select-sm" aria-label=".form-select-sm example" name="surveycategory" id="drop">
            <option >Myself</option>
            <option>One Plus</option>
            <option>Samsung</option>
            <option>Footprints</option>
            </select>
			</div>

			<div class="row mb-3">
					<label for="" class="control-label">Start Date</label>
					<input id="startdate" name="startdate" class="form-control form-control-sm" value="<?php echo @$startdate; ?>">
			</div>

			<div class="row mb-3">
					<label for="" class="control-label">End Date</label>
					<input id="enddate" name="enddate" class="form-control form-control-sm" value="<?php echo @$enddate; ?>">
			</div>
			
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button type="submit" class="btn btn-primary mr-2" name="save">Update</button>
					<button type="submit" class="btn" style="background-color: lightgrey" name="reset">Cancel</button>
				</div>
			</form>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 
         <script>
            $(document).ready(function() {
  
                $(function() {
                    $("#startdate").datepicker({dateFormat: 'yy-mm-dd', minDate: new Date()}).val();
                });
                $(function() {
                    $("#enddate").datepicker({dateFormat: 'yy-mm-dd', minDate: new Date()}).val();
                });
  
                $('#startdate').change(function() {
                    startDate = $(this).datepicker('getDate');
                    $("#enddate").datepicker("option", "minDate", startDate);
                })
  
                $('#enddate').change(function() {
                    endDate = $(this).datepicker('getDate');
                    $("#startdate").datepicker("option", "maxDate", endDate);
                })
            })
 
        </script>
<?php
require_once 'sidenav.php';
?>
