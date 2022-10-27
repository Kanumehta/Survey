<?php
require_once 'nav.php';

$email=$_SESSION['email'];

$conn = mysqli_connect('localhost', 'root', '', 'survey_db') or die('connection failed');
$flag = false;
$id = $_GET['survey_id'];
$pattern = "#*&";



$query = "SELECT * FROM `survey_forms` where `survey_id` = '$id'";
$data = mysqli_query($conn, $query);
$arr = mysqli_fetch_row($data);


if (isset($_POST['save'])) {

  $question = $_POST['question'];
  $questiontype = $_POST['questiontype'];
  $questioncreateddate= date("y-m-d");
  $input = $_POST['options'];
  $input = array_filter($input);

  $options = $_POST['options'];
  $options = array_filter($options);


  $options_cmt = $_POST['options_cmt'];
  $options_cmt = array_filter($options_cmt);



    


    if ($questiontype == "checkcmt" || $questiontype == "radiocmt") {
      if (!empty($options_cmt)) {
        foreach ($options_cmt as $k => $v) {
          if (@preg_match($pattern, $v)) {
            $options[] = $v;
          } else {
            $options[] = $v . "#*&";
          }
        }
      }
    }

    echo $questiontype;

    if (!empty($question) && !empty($questiontype)) {
  $query = " INSERT INTO `survey_questions`(`question_id`, `question`, `question_options`,`survey_id`,`question_created_date`,`question_created_by`) VALUES (NULL,'$question','$questiontype', '$id' ,'$questioncreateddate','$email')";
  $data = mysqli_query($conn, $query);

  header("location:viewsurvey.php?survey_id=$id");
  // echo "<script> alert('Successfull');</script>";
  // header("location:srvylist.php"); 
    }
    else{
      echo "<script>alert('Fill both the Fields.');</script>";
    }


  $query1 = "SELECT `question_id` FROM `survey_questions`";
  $data1 = mysqli_query($conn, $query1);
  while ($res1 = mysqli_fetch_array($data1)) {
    $question_id = $res1['question_id'];
  }
  // if($question_options == "mcq"){
  foreach ($options as $options) {
    $query2= "INSERT INTO `option_table`(`option_id`, `options`, `question_id_1`) VALUES (NULL,'$options','$question_id')";
     $data2 = mysqli_query($conn, $query2);
     $flag=true;

  }
}

// if ($flag) {
//   echo "<script> alert('Successfull');</script>";
//   header("location:viewsurvey.php?survey_id=$id"); 
// }

if (isset($_POST['cancel'])) {
header("location:viewsurvey.php?survey_id=$id");
}

?>

<div class="container w-50 p-3 ">
  <h1>
    <center>Questions</center>
  </h1>

  <form method="post" class="row">
    <div class="col-12">

      <div class="row mb-3">
        <label for="" class="control-label">Questions</label>
        <input type="text" name="question" class="form-control form-control-sm">
      </div>

      <div class="row mb-3">
        <label for="" class="control-label">Question Type</label>
        <select class="form-select custom-select custom-select-sm" aria-label=".form-select-sm example" name="questiontype" id="drop">
          <option value="">Select from here </option>
          <option value="shorttext">Short Text</option>
          <option value="rating">Rating Scale</option>
          <option value="radio">Radio Button</option>
          <option value="radiocmt">Radio Button & Comment</option>
          <option value="check">Multiple Choice</option>
          <option value="checkcmt">Multiple Choice & Comment</option>
          <option value="text">Text/Paragraph</option>
          <option value="datetime">Date/Datetime</option>
          <option value="file">File</option>
          <option value="email">Email</option>
        </select>
      </div>


      <!---------------------SHORT TEXT ------------------------------------------------------------------------------------>
      <div class="data container" id="shorttext">
        <div class="row" style=" border:1px solid black; padding:30px;  background-color: #f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Short Text</h5>

            <label for="inputsm">Answer:</label>
            <input class="form-control input-sm" id="inputsm" disabled type="text">

          </div>
        </div>
      </div>

      <!---------------------SHORT TEXT END------------------------------------------------------------------------------------>

      <!---------------------Rating ------------------------------------------------------------------------------------>
      <div class="data container" id="rating">
        <div class="row" style=" border:1px solid black; padding:30px;  background-color: #f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Rating Scale</h5>

            <label for="points">Points (between 0 and 10):</label>
            <input type="range" id="points" name="points" min="0" max="10" disabled style="width: 400px;">

          </div>
        </div>
      </div>

      <!---------------------Rating End------------------------------------------------------------------------------------>

      <!---------------------RADIO -------------------------------------------------------------------------------->
      <div class="data container" id="radio">

        <div class="row " style=" border:1px solid black; padding:30px; background-color: 
                        #f2f2f0;">

          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <h5 class="text-center">Radio Button</h5>

            <div class="form-check row" style="margin-top: 20px;">
              <div>
                <input class=" form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" aria-label="Radio button for following text input" disabled>
                <input type="text" class="form-control mb-3" name="options[]" aria-label="Text input with radio button">
              </div>

            </div>



            <div id="radio_remove1"></div>

            <div>
              <button type="button" class="btn btn-light" id="btn_1" style="float: right; margin-top:5px;">+ Add Option</button>

            </div>
          </div>
        </div>
      </div>
      <!----------------- END RADIO --------------------------------------------------------------------------->

      <!---------------------RADIO & COMMENT -------------------------------------------------------------------------------->
      <div class="data container" id="radiocmt">

        <div class="row " style=" border:1px solid black; padding:30px; background-color: 
                        #f2f2f0;">

          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <h5 class="text-center">Radio Button & Comment</h5>

            <div class="form-check row" style="margin-top: 20px;">



              <div>
                <input class=" form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" aria-label="Radio button for following text input" disabled>
                <input type="text" class="form-control mb-3" name="options[]" aria-label="Text input with radio button">
              </div>

            </div>

            <div id="radio_remove2"></div>
            Comment:-
            <textarea class="form-control" name="options_cmt[]" rows="2" id="comment"></textarea>


            <div>
              <button type="button" class="btn btn-light" id="btn_2" style="float: right; margin-top:5px;">+ Add Option</button>

            </div>
          </div>
        </div>
      </div>
      <!----------------- END RADIO COMMENT --------------------------------------------------------------------------->

      <!---------------------Multiple------------------------------------------------------------------>
      <div class="data container" id="check">

        <div class="row" style="border:1px solid black; padding:30px; background-color: 
#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Multiple Choice</h5>

            <div id="mcq">

              <div class="input-group mb-3">

                <div class="input-group-prepend">

                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" disabled>
                  </div>
                </div>
                <input type="text" class="form-control" name="options[]" aria-label="Text input with checkbox">
              </div>

            </div>

            <div id="check_remove1"></div>

            <div>
              <button type="button" class="btn btn-light" id="btn_3" style="float: right; margin-top:5px;">+ Add Option</button>
            </div>

          </div>
        </div>
      </div>
      <!---------------------Multiple End ---------------------------------------------------------------------------->


      <!---------------------Multiple & Comment ------------------------------------------------------------------->
      <div class="data container" id="checkcmt">

        <div class="row" style="border:1px solid black; padding:30px; background-color: 
#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Multiple Choice & Comment</h5>

            <div id="checkcmnt">

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" disabled>
                  </div>
                </div>
                <input type="text" class="form-control" name="options[]" aria-label="Text input with checkbox">
              </div>

            </div>

            <div id="check_remove2"></div>

            Comment:-
            <textarea class="form-control" name="options_cmt[]" rows="2" id="comment"></textarea>

            <div>
              <button type="button" class="btn btn-light" id="btn_4" style="float: right; margin-top:5px;">+ Add Option</button>
            </div>

          </div>
        </div>
      </div>
      <!---------------------Multiple Comment End ---------------------------------------------------------------------------->

      <!---------------------Text/Para---------------------------------------------------------------------------------------->

      <div class="data container" id="text">

        <div class="row" style="border:1px solid black; padding:10px; background-color: 
#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Text/Paragraph</h5>
            <div class="form-group">
              <label for="comment">Answer:</label>
              <textarea class="form-control" rows="3" cols="50" id="comment" disabled></textarea>
            </div>
          </div>
        </div>
      </div>

      <!---------------------Text/Para End ---------------------------------------------------------------------------------------->

      <!---------------------Date & Time---------------------------------------------------------------------------------------->

      <div class="data container" id="datetime">
        <div class="row" style=" border:1px solid black; padding:30px;  background-color: 
#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Date and Time</h5>

            <label for="date/time">Date and Time:</label>
            <input type="datetime-local" id="datetime" name="datetime" disabled>
          </div>
        </div>
      </div>

      <!---------------------Date & Time End ------------------------------------------------------------------------------------>

      <!---------------------File Upload------------------------------------------------------------------------------------>

      <div class="data container" id="file">
        <div class=" row mt-3" style="border:1px solid black; padding:30px; background-color:#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">File Upload</h5>

            <p>Custom file:</p>
            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" id="customFile" name="filename" disabled>
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>

            <!--  <p>Default file:</p>
    <input type="file" id="myFile" name="filename2"> -->
          </div>
        </div>
      </div>

      <!---------------------File Upload End------------------------------------------------------------------------------------>

      <!---------------------Email ------------------------------------------------------------------------------------>

      <div class="data container" id="email">
        <div class="row" style=" border:1px solid black; padding:30px;  background-color: #f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Email</h5>

            <label for="email">Enter your email:</label>
            <input type="email" id="email" name="email" disabled style="width: 400px;">
          </div>
        </div>
      </div>


      <!---------------------Email End------------------------------------------------------------------------------------>



      <div class="col-lg-12 text-right justify-content-center d-flex mt-3">
        <button type="submit" name="save" class="btn btn-primary" style="margin-right: .5%">Save</button>
        <button type="cancel" name="cancel" class="btn btn-secondary" style="margin-right: .5%">Cancel</button>
      </div>

    </div>

</div>

</form>
</div>
</div>



<script>
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
  
  //////////////////////////////////Hide & Show/////////////////////////////////////////////////

  $(function() {
    $("#drop").on('change', function() {

      $(".data").hide();
      $("#" + $(this).val()).fadeIn(800);
    });
    change();
  });

  ////////////////////////////////////////////////////////////////////////////////////////////////

  //////////////////////////////////////Radio/////////////////////////////////////////////////////

  $(document).ready(function() {
    var input_radio1 = ('<div class="row" id="remove1"><div class="col-11"><input class=" form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" aria-label="Radio button for following text input"disabled><input type="text" class="form-control mb-3"  name="options[]" aria-label="Text input with radio button"></div><div class="col-1"><i class="fa-solid fa-xmark remove_radio1" style="cursor:pointer;"></i></div></div>');

    $('#btn_1').click(function() {
      $('#radio_remove1').append(input_radio1);
    });
    $('#radio_remove1').on('click', '.remove_radio1', function() {
      $(this).parents('#remove1').remove();
    });
  });

  ///////////////////////////////////////////////////////////////////////////////////////////

  //////////////////////////////////////Radio & Comment////////////////////////////////////////////////

  $(document).ready(function() {
    var input_radio2 = ('<div class="row" id="remove2"><div class="col-11"><input class=" form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" aria-label="Radio button for following text input"disabled><input type="text" class="form-control mb-3"  name="options[]" aria-label="Text input with radio button disabled"></div><div class="col-1"><i class="fa-solid fa-xmark remove_radio2" style="cursor:pointer;"></i></div></div>');

    $('#btn_2').click(function() {
      $('#radio_remove2').append(input_radio2);
    });
    $('#radio_remove2').on('click', '.remove_radio2', function() {
      $(this).parents('#remove2').remove();
    });
  });
  ///////////////////////////////////////////////////////////////////////////////////////////

  //////////////////////////////////////Multiple////////////////////////////////////////////////////

  $(document).ready(function() {
    var input_check1 = ('<div id="remove3" class="input-group mb-3"><div class="input-group-prepend"><div class="input-group-text"><input type="checkbox" aria-label="Checkbox for following text input"disabled></div></div><input type="text" class="form-control" name="options[]" aria-label="Text input with checkbox"><i class="fa-solid fa-xmark remove_check1" style="cursor:pointer;"></i></div></div>');

    $('#btn_3').click(function() {
      $('#check_remove1').append(input_check1);
    });
    $('#check_remove1').on('click', '.remove_check1', function() {
      $(this).parents('#remove3').remove();
    });
  });

  ///////////////////////////////////////////////////////////////////////////////////////////

  //////////////////////////////////////Multiple & Comment////////////////////////////////////////////////////

  $(document).ready(function() {
    var input_check2 = ('<div id="remove4" class="input-group mb-3"><div class="input-group-prepend"><div class="input-group-text"><input type="checkbox" aria-label="Checkbox for following text input"disabled></div></div><input type="text" class="form-control" name="options[]" aria-label="Text input with checkbox"><i class="fa-solid fa-xmark remove_check2" style="cursor:pointer;"></i></div></div>');

    $('#btn_4').click(function() {
      $('#check_remove2').append(input_check2);
    });
    $('#check_remove2').on('click', '.remove_check2', function() {
      $(this).parents('#remove4').remove();
    });
  });

  /////////////////////////////////////Remove//////////////////////////////////////////////////////
</script>


<?php
require_once 'sidenav.php';
?>