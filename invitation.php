	<?php
require_once 'nav.php';
require_once '../survey.com/smtp/PHPMailerAutoload.php';

$email=$_SESSION['email'];

 $id = $_GET['survey_id'];


$conn=mysqli_connect('localhost','root','','survey_db') or die('connection failed');


function email($email, $title, $message){
	$mail = new PHPMailer;

	// $mail->SMTPDebug = 3;                               
  
	$mail->isSMTP();                                      
	$mail->Host = 'smtp.gmail.com';             
	$mail->SMTPAuth = true;                               
	$mail->Username = 'kanumehta452@gmail.com';              
	$mail->Password = 'yxqpfqdqkfjssjzm';                          
	$mail->SMTPSecure = 'tls';                           
	$mail->Port = 587;                                    
  
	$mail->setFrom('kanumehta452@gmail.com');
	$mail->addAddress("$email");     
	// $mail->addReplyTo('kanumehta6663gmail.com', 'Information');
  
	$mail->isHTML(true);                          
  
	$mail->Subject = ("$title");
	$mail->Body    = ("$message");

	// $mail->AltBody = $message;
  
	if (!$mail->send()) {
	  echo '<script>alert("Message could not be sent.")</script>';
	  echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	  echo '<script>alert("Message has been sent.")</script>';
	}
}
 
if (isset($_POST['send'])) {

$name=$_POST['name']; 
$email=$_POST['email'];
$subject=$_POST['subject'];
$message=$_POST['message'];
$invited_date= date("y-m-d");
// $number=$_POST['number'];
$invite_id= md5($email.time());
$url= "192.168.1.72/ansview.php?survey_id=$id&invite_key=$invite_id";
$link= "<a href='$url'>Click Here</a>";


// header("location:viewsurvey.php?survey_id=$id");


$query = "INSERT INTO `survey_invitation`(`invitation_id`, `invitation_key`, `invitation_name`, `invitation_email`, `invitation_subject`, `invitation_message`, `invitation_survey_id`,`invited_date`,`invited_by`) VALUES (NULL, '$invite_id','$name','$email','$subject','$message','$id', '$invited_date','$email')";
 $data = mysqli_query($conn, $query);
 

email($email, $subject, $message.$link);
}

if (isset($_POST['cancel'])) {
	header("location:viewsurvey.php?survey_id=$id");
	}

?>



<div class= "card p-4 mt-5" style="border:4px solid gray;">
	<div class="heading d-flex justify-content-center mt-2">
		<h1 class="">Invitation Form</h1>
	</div>

<!-- <div class="table-responsive"> -->
<div class="container">
	<form method="post" class="row" style="max-width:50%; margin: auto;">
		<div class="col-12">
			<div class="data" id="sms" style="display: none;">
			<div class="row mb-6">
					<!-- <label class="control-label" style="margin-top: 10px;">Name</label>
					<input type="text" name="name" class="form-control form-control-sm"> -->

					<label class="control-label" style="margin-top: 10px;">Mobile Number</label>
					<input type="number" name="number" class="form-control form-control-sm">

				<!-- 	<label class="control-label" style="margin-top: 10px;">Message</label>
   					<textarea class="form-control" rows="2" id="comment" name="message"></textarea>
 -->
   					
			</div>
		</div>


			<div class="data" id="mail" style="display: none;">
			<div class="row mb-6">
					<label class="control-label" style="margin-top: 10px;">Name</label>
					<input type="text" name="name" class="form-control form-control-sm">

					<label class="control-label" style="margin-top: 10px;">Email</label>
					<input type="email" name="email" class="form-control form-control-sm">

					<label for="form_link" style="margin-top: 10px;">Subject</label>
                    <input id="form_link" type="text" name="subject" class="form-control">

					<label class="control-label" style="margin-top: 10px;">Message</label>
   					<textarea class="form-control" rows="2" id="comment" name="message"></textarea>


					
			</div>
		</div>


			<div class="row mb-6">
					<label class="control-label" style="margin-top: 10px;">Invitation Via</label>
					<select name="type" id="drop" class="form-select custom-select  custom-select-sm" aria-label=".form-select-sm example">
					<option value="mail">Select frm here...</option>
		  			<option value="mail">Via Mail</option>
		  			<option value="sms">Via SMS</option>
					</select>
			</div>
			
				<div class="col-md-12 justify-content-center d-flex g-3" style="margin-top: 35px;">
					<button   type="submit" name="send" class="btn btn-primary" style="margin-right: .5%">Send</button>
					<button  name="cancel" type="submit" class="btn btn-secondary" style="margin-left: .5%">Cancel</button>
		    </div>	
		</div>
	</form>
				</div>
				<script>

	$(function () {
    $("#drop").on('change', function(){

    $(".data").hide();
    $("#" + $(this).val()).fadeIn(800);});
    change();
});
</script>

<?php
require_once 'sidenav.php';
?>
