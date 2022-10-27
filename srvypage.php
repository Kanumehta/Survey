<?php
require_once 'nav.php';

$email=$_SESSION['email'];

$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');

if (isset($_POST['save'])) {
  $title = $_POST['title']; 
  $surveycategory = $_POST['surveycategory'];
  $description = $_POST['description'];
  $startdate = $_POST['startdate'];
  $enddate = $_POST['enddate'];

  
  	$msg_title = "";
    $msg_description = "";
    $msg_startdate ="";
    $msg_enddate ="";

    $flag = true;

    if ($title == "") {
        $msg_title .= "Title field is Empty. <br>";
        $flag = false;
    }
     else{
      $query1="SELECT survey_title FROM survey_forms WHERE survey_title='$title'";
      $data1 = mysqli_query( $conn, $query1);
      $res1= mysqli_fetch_array($data1);
      if(!empty($res1)){
        $flag=false;
      }
      if(!$flag){
        $msg_title .= "This title is already registered.";
     }
     }

    if ($description== "") {
        $msg_description.= "Description field is Empty. <br>";
        $flag = false;
    }
    if ($startdate == "") {
        $msg_startdate .= "Start date field is Empty. <br>";
        $flag = false;
    }
    if ($enddate == "") {
        $msg_enddate .= "End date field is Empty. <br>";
        $flag = false;
    }
    if ($flag) {
        $query= "INSERT INTO `survey_forms`(`survey_id`, `survey_title`, `survey_category`, `survey_description`, `survey_status`, `survey_created_date`, `survey_end_date`,`survey_last_modified_by`) VALUES (NULL, '$title',  '$surveycategory', '$description', 'Active','$startdate', '$enddate','$email')";
  		$data = mysqli_query($conn, $query);

        $query1= "SELECT MAX(survey_id) AS survey FROM survey_forms";
        $data1 = mysqli_query( $conn, $query1);
        $res1 = mysqli_fetch_array($data1);
        header("location:viewsurvey.php?survey_id=$res1[survey]");  
  

    }
}

?>


<div class= "card p-4 mt-5" style="border:4px solid gray;">
	<div class="heading d-flex justify-content-center mt-2">
		<h1 class="">Add New Survey Page</h1>
	</div>


<!-- <div class="table-responsive"> -->
<div class="container" >
	<form method="post" class="row" style="max-width: 70%; margin: auto;">
		<div class="col-12">
			<div class="row mb-3">
					<label for="" class="control-label">Title</label>
					<input type="text" name="title" class="form-control form-control-sm"><?php echo @$msg_title; ?>
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
					<label class="control-label">Description</label>
					<textarea name="description" id="" cols="30" rows="2" class="form-control"></textarea><?php echo @$msg_description; ?>
			</div>

			<div class="row mb-3">
					<label class="control-label">Start Date</label>
					<input  id="startdate" name="startdate" class="form-control form-control-sm">
			</div>

			<div class="row mb-3">
					<label class="control-label">End Date</label>
					<input id="enddate" name="enddate" class="form-control form-control-sm">
			</div>
			
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button type="save" class="btn btn-primary mr-2" name="save" onclick="ques.php">Save</button>
					<button type="reset" class="btn" style="background-color: lightgrey" name="reset">Reset</button>
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
