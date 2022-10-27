<?php
require_once 'nav.php';

$conn = mysqli_connect('localhost', 'root', '', 'survey_db') or die('connection failed');

$survey_id = $_GET['survey_id'];
$qq_id = $_GET['qq_id'];
$pattern = '/#*&/';


if (isset($_POST['save'])) {
  extract($_POST);

  $options = $_POST['options'];
  $options = array_filter($options);


  $ques = $_POST['ques'];
  // $question_options = $_POST['question_options'];
  



  $options_cmt = $_POST['opt_cmt'];
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


  // echo "<pre>";
  // print_r($options);
  // echo "</pre>";




  // if (isset($_POST['save'])) {


  // update******************************


  $query2 = "SELECT * FROM  survey_questions AS q LEFT JOIN option_table AS o ON q.question_id=o.question_id_1 WHERE Q.question_id = '$qq_id'";
  $data2 = mysqli_query($conn, $query2);
  while ($result = mysqli_fetch_array($data2)) {
    $option_id[] = $result['option_id'];
  }
  $i = 0;
  // echo "<pre>";
  // print_r($option_id);
  // echo "</pre>";


  if (@$ques != "" && $questiontype != "") {
    if ($questiontype == "check" || $questiontype == "checkcmt" || $questiontype == "radio" || $questiontype == "radiocmt") {
      if ((!@($options[0] == "no_text") && !empty($options))  || (empty($options) && (@$options[0] == "no_text"))) {




        //upsert*****************************
        if (count($option_id) <= count($options)) {
          $header = true;
          $query1 = "UPDATE survey_questions SET question = '$ques' , question_options = '$questiontype' WHERE survey_questions.question_id = '$qq_id'";
          $data1 = mysqli_query($conn, $query1);

          foreach ($options as $key => $value) {
            // echo $value;
            @$optid = $option_id[$i];
            $i++;
            $query3 = "REPLACE INTO option_table(`option_id` ,`question_id_1`, `options`) VALUES ('$optid','$qq_id','$value')";
            $data3 = mysqli_query($conn, $query3);
          }
          header("location:viewsurvey.php?survey_id=$survey_id");
        }


        // delete****************************
        if (count($option_id) > count($options)) {
          $header = true;
          $query1 = "UPDATE survey_questions SET question = '$ques' , question_options = '$questiontype' WHERE survey_questions.question_id = '$qq_id'";
          $data1 = mysqli_query($conn, $query1);

          foreach ($options as $key => $value) {
            @$optid = $option_id[$i];
            $i++;
            $query3 = "REPLACE INTO option_table(`option_id` ,`question_id_1`, `options`) VALUES ('$optid','$qq_id','$value')";
            $data3 = mysqli_query($conn, $query3);
          }
        }
        if ($i == count($options)) {
          for ($i == count($options); $i <= count($option_id); $i++) {
            @$optid = $option_id[$i];
            $query4 = "DELETE FROM `option_table` WHERE option_id = '$optid'";
            $data4 = mysqli_query($conn, $query4);
          }
          header("location:viewsurvey.php?survey_id=$survey_id");
        }
      } else {
        echo "<script>alert('please enter options');</script>";
      }
    } else {
      $query = "UPDATE `survey_questions` SET `question` = '$ques' , question_options = '$questiontype' WHERE `question_id`='$qq_id'"; //question update for text,file,....
      $data = mysqli_query($conn, $query);


      for ($i == 0; $i < count($option_id); $i++) { //options deleted if exists
        $optid = $option_id[$i];
        $query4 = "DELETE FROM `option_table` WHERE option_id = '$optid'";
        $data4 = mysqli_query($conn, $query4);
        echo "<script>alert('deleted');</script>";

        header("location:viewsurvey.php?survey_id=$survey_id");
      }

    }
  } else {
    echo "<script>alert('please enter question & select ques_type');</script>";
  }
  //   }


}
// }


$query1 = "SELECT * FROM survey_forms  AS s LEFT JOIN survey_questions AS q ON s.survey_id=q.survey_id LEFT JOIN option_table AS o ON q.question_id=o.question_id_1 WHERE s.survey_id = '$survey_id' AND q.question_id = '$qq_id' ORDER BY q.question_id";
$data1 = mysqli_query($conn, $query1);

while ($res = mysqli_fetch_array($data1)) {
  $arr_ques = $res['question'];
  $ques_type = $res['question_options'];
  $opt['arr_opt'] = $res['options'];
  $opt['opt_id'] = $res['option_id'];

  $mul_arr[] = $opt;
}

?>
<div class="container w-50 p-3 parent_class ">
  <h1>
    <center>Questions</center>
  </h1>

  <form method="post" class="row">
    <div class="col-12">

      <div class="row mb-3">
        <label for="" class="control-label">Questions</label>
        <input type="text" name="ques" class="form-control form-control-sm" value="<?php echo $arr_ques ?>">
      </div>

      <div class="row mb-3">
        <label for="" class="control-label">Question Type</label>
        <select class="form-select custom-select custom-select-sm" aria-label=".form-select-sm example" name="questiontype" id="drop">
          <option value="shorttext" <?php if ($ques_type == "shorttext") {
                                      echo "selected";
                                    } ?>>Short Text</option>
          <option value="rating" <?php if ($ques_type == "rating") {
                                    echo "selected";
                                  } ?>>Rating Scale</option>
          <option value="radio" <?php if ($ques_type == "radio") {
                                  echo "selected";
                                } ?>>Radio Button</option>
          <option value="radiocmt" <?php if ($ques_type == "radiocmt") {
                                      echo "selected";
                                    } ?>>Radio Button & Comment</option>
          <option value="check" <?php if ($ques_type == "check") {
                                  echo "selected";
                                } ?>>Multiple Choice</option>
          <option value="checkcmt" <?php if ($ques_type == "checkcmt") {
                                      echo "selected";
                                    } ?>>Multiple Choice & Comment</option>
          <option value="text" <?php if ($ques_type == "text") {
                                  echo "selected";
                                } ?>>Text/Paragraph</option>
          <option value="datetime" <?php if ($ques_type == "datetime") {
                                      echo "selected";
                                    } ?>>Date/Datetime</option>
          <option value="file" <?php if ($ques_type == "file") {
                                  echo "selected";
                                } ?>>File</option>
          <option value="email" <?php if ($ques_type == "email") {
                                  echo "selected";
                                } ?>>Email</option>
        </select>
      </div>



      <!---------------------SHORT TEXT ------------------------------------------------------------------------------------>
      <div class="data container common_class" id="shorttext">
        <div class="row" style=" border:1px solid black; padding:30px;  background-color: #f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Short Text</h5>

            <label for="inputsm">Answer:</label>
            <input class="form-control input-sm" id="inputsm" type="text">

          </div>
        </div>
      </div>

      <!---------------------SHORT TEXT END------------------------------------------------------------------------------------>


      <!---------------------Rating ------------------------------------------------------------------------------------>
      <div class="data container common_class" id="rating">
        <div class="row" style=" border:1px solid black; padding:30px;  background-color: #f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Rating Scale</h5>

            <label for="points">Points (between 0 and 5):</label>
            <input type="range" id="points" name="points" min="0" max="5" style="width: 400px;">

          </div>
        </div>
      </div>

      <!---------------------Rating End------------------------------------------------------------------------------------>


      <!---------------------RADIO -------------------------------------------------------------------------------->
      <div class="data container common_class" id="radio">

        <div class="row " style=" border:1px solid black; padding:30px; background-color: 
                        #f2f2f0;">

          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <h5 class="text-center">Radio Button</h5>

            <div class="form-check row comm_class " style="margin-top: 20px;">



              <div>

                <input class=" form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" aria-label="Radio button for following text input">
                <input type="text" class="form-control comm_class mb-3" name="options[]" aria-label="Text input with radio button">
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
      <div class="data container common_class" id="radiocmt">

        <div class="row " style=" border:1px solid black; padding:30px; background-color: 
                        #f2f2f0;">

          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <h5 class="text-center">Radio Button & Comment</h5>

            <div class="form-check row comm_class" style="margin-top: 20px;">



              <div>
                <input class=" form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" aria-label="Radio button for following text input">
                <input type="text" class="form-control comm_class mb-3" name="options[]" aria-label="Text input with radio button">
              </div>

            </div>

            <div id="radio_remove2"></div>
            Comment:-
            <textarea class="form-control" name="opt_cmt[]" rows="2" id="comment"></textarea>


            <div>
              <button type="button" class="btn btn-light" id="btn_2" style="float: right; margin-top:5px;">+ Add Option</button>

            </div>
          </div>
        </div>
      </div>
      <!----------------- END RADIO COMMENT --------------------------------------------------------------------------->


      <!---------------------Multiple------------------------------------------------------------------>
      <div class="data container common_class" id="check">

        <div class="row" style="border:1px solid black; padding:30px; background-color: 
#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Multiple Choice</h5>

            <div id="mcq">

              <div class="input-group mb-3 comm_class">

                <div class="input-group-prepend">

                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input">
                  </div>
                </div>
                <input type="text" class="form-control comm_class" name="options[]" aria-label="Text input with checkbox">
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
      <div class="data container common_class" id="checkcmt">

        <div class="row" style="border:1px solid black; padding:30px; background-color: 
#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <h5 class="text-center">Multiple Choice & Comment</h5>

            <!-- <div id="checkcmnt"> -->
            <div class="form-check row" style="margin-top: 20px;">
              <div class="input-group mb-3 comm_class">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input">
                  </div>
                </div>
                <input type="text" class="form-control comm_class" name="options[]" aria-label="Text input with checkbox">
              </div>
            </div>

            <div id="check_remove2" class=""></div>

            Comment:-
            <textarea class="form-control" name="opt_cmt[]" rows="2" id="comment"></textarea>

            <div>
              <button type="button" class="btn btn-light" id="btn_4" style="float: right; margin-top:5px;">+ Add Option</button>
            </div>
          </div>
        </div>
      </div>
      <!---------------------Multiple Comment End ---------------------------------------------------------------------------->

      <!---------------------Text/Para---------------------------------------------------------------------------------------->

      <div class="data container common_class" id="text">

        <div class="row" style="border:1px solid black; padding:10px; background-color: 
#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Text/Paragraph</h5>
            <div class="form-group">
              <label for="comment">Answer:</label>
              <textarea class="form-control" rows="3" cols="50" id="comment"></textarea>
            </div>
          </div>
        </div>
      </div>

      <!---------------------Text/Para End ---------------------------------------------------------------------------------------->



      <!---------------------Date & Time---------------------------------------------------------------------------------------->

      <div class="data container common_class" id="datetime">
        <div class="row" style=" border:1px solid black; padding:30px;  background-color: 
#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Date and Time</h5>

            <label for="date/time">Date and Time:</label>
            <input type="datetime-local" id="datetime" name="datetime">
          </div>
        </div>
      </div>

      <!---------------------Date & Time End ------------------------------------------------------------------------------------>


      <!---------------------File Upload------------------------------------------------------------------------------------>

      <div class="data container common_class" id="file">
        <div class=" row mt-3" style="border:1px solid black; padding:30px; background-color:#f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">File Upload</h5>

            <p>Custom file:</p>
            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" id="customFile" name="filename">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>

            <!--  <p>Default file:</p>
    <input type="file" id="myFile" name="filename2"> -->
          </div>
        </div>
      </div>

      <!---------------------File Upload End------------------------------------------------------------------------------------>


      <!---------------------Email ------------------------------------------------------------------------------------>

      <div class="data container common_class" id="email">
        <div class="row" style=" border:1px solid black; padding:30px;  background-color: #f2f2f0;">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5 class="text-center">Email</h5>

            <label for="email">Enter your email:</label>
            <input type="email" id="email" name="email" style="width: 400px;">
          </div>
        </div>
      </div>


      <!---------------------Email End------------------------------------------------------------------------------------>


      <?php
      //Radio

      $len = count($mul_arr);
      $i = 0;
      if ($ques_type == "radio") {  ?>

        <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30px;">
          <div class="col-11 flex d-flex justify-content-start " style="padding-left:0px;margin-left:0px">
            <div class="mb-3">
              <button type="button" class="btn btn-light" id="btn_1" style="float: right; margin-top:5px; margin-left:20px;">+ Add Option</button>
            </div>

          </div>
          <div class="row">
            <?php
            foreach ($mul_arr as $k => $v) {

              $i++;
              if (!empty($v['arr_opt'])) {
            ?>
                <div class="col-11 radio_box ">
                  <div class="input-group mb-3 ">

                    <div class="input-group-prepend">

                      <div class="input-group-text">
                        <input type="radio" aria-label="Radio Button for following text input">
                      </div>
                    </div>
                    <input type="text" class="form-control comm_class" name="options[]" value="<?php echo $v['arr_opt'] ?>" aria-label="Text input with radio button">
                    <div class="col-1 "><i class="fa-solid fa-xmark remove_radio1" style="cursor:pointer;"></i></div>
                  </div>


                </div>
                <?php
                if ($i == count($mul_arr)) { ?>
                  <div class="col-11 radio_remove1"></div>
                <?php   }
                ?>
          <?php }
            }
          }  ?>
          </div>


          <?php
          //Radio & Comment

          if ($ques_type == "radiocmt") { ?>
            <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:40px;">
              <div class="col-11 flex d-flex justify-content-start " style="padding-left:0px;margin-left:0px">
                <div class="mb-3">
                  <button type="button" class="btn btn-light" id="btn_2" style="float: right; margin-top:5px; margin-left:20px;">+ Add Option</button>
                </div>
              </div>
              <div class="row">
                <?php foreach ($mul_arr as $k => $v) {
                  ++$i;
                  if ($i == count($mul_arr) && @!preg_match($pattern, $v['arr_opt'])) {  ?>

                    <div class="col-11 check_box1 ">
                      <div class="input-group mb-3 remove4">

                        <div class="input-group-prepend ">

                          <div class="input-group-text ">
                            <input type="radio" aria-label="Checkbox for following text input">
                          </div>
                        </div>
                        <input type="text" class="form-control comm_class" name="options[]" value="<?php echo $v['arr_opt'] ?>" aria-label="Text input with radio button">
                        <div class="col-1 "><i class="fa-solid fa-xmark remove_check2" style="cursor:pointer;"></i></div>
                      </div>

                    </div>

                    <div class="col-11 pe-0 me-0  radiocmt"> </div>
                    <div class="col-12 ms-5">
                      <textarea class="mb-2 ps-2 pt-2 rounded delete_data" name="opt_cmt[]" style="width:50%" placeholder="no_text_here"></textarea>
                    </div>
                    <?php
                  } else {
                    if (preg_match($pattern, $v['arr_opt'])) {
                      $str = str_replace(str_split('#*&'), '', $v['arr_opt']);
                    ?>
                      <div class="row pe-0 me-0 radiocmt"> </div>
                      <div class="row col-10 ms-1">
                        <textarea name="opt_cmt[]" class="mb-2 ps-2 pt-2 rounded delete_data"><?php echo $str; ?></textarea>
                      </div>
                      <?php  } else {
                      if ($i == 1) {  ?>
                        <div class="col-11 radio_box1 ">
                          <div class="input-group mb-3">

                            <div class="input-group-prepend">

                              <div class="input-group-text">
                                <input type="radio" aria-label="Radio Button for following text input">
                              </div>
                            </div>
                            <input type="text" class="form-control comm_class" name="options[]" value="<?php echo $v['arr_opt'] ?>" aria-label="Text input with radio button">
                            <div class="col-1 "><i class="fa-solid fa-xmark remove_radio1" style="cursor:pointer;"></i></div>
                          </div>

                        </div>
                      <?php } else { ?>
                        <div class="col-11 radio_box1 ">
                          <div class="input-group mb-3">

                            <div class="input-group-prepend">

                              <div class="input-group-text">
                                <input type="radio" aria-label="Radio Button for following text input">
                              </div>
                            </div>
                            <input type="text" class="form-control comm_class" name="options[]" value="<?php echo $v['arr_opt'] ?>" aria-label="Text input with radio button">
                            <div class="col-1 "><i class="fa-solid fa-xmark remove_radio1" style="cursor:pointer;"></i></div>
                          </div>
                        </div>

              <?php }
                    }
                  }
                }
              } ?>



              <?php
              //Multiple

              $len = count($mul_arr);
              $i = 0;
              if ($ques_type == "check") {  ?>

                <div class=" row col-11 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30px;">
                  <div class="col-11 flex d-flex justify-content-start " style="padding-left:0px;margin-left:0px">
                    <div class="mb-3">
                      <button type="button" class="btn btn-light" id="btn_3" style="float: right; margin-top:5px; margin-left:20px; ">+ Add Option</button>
                    </div>

                  </div>
                  <div class="row ">
                    <?php
                    foreach ($mul_arr as $k => $v) {

                      $i++;
                      if (!empty($v['arr_opt'])) {
                    ?>
                        <div class="col-11 check_box">
                          <div class="input-group mb-3 ">

                            <div class="input-group-prepend">

                              <div class="input-group-text">
                                <input type="checkbox" aria-label="Checkbox for following text input">
                              </div>
                            </div>
                            <input type="text" class="form-control comm_class" name="options[]" value="<?php echo $v['arr_opt'] ?>" aria-label="Text input with checkbox">
                            <div class="col-1 "><i class="fa-solid fa-xmark remove_check1" style="cursor:pointer;"></i></div>
                          </div>
                        </div>

                        <?php
                        if ($i == count($mul_arr)) { ?>
                          <div class="col-11 check_remove1"></div>
                        <?php   }
                        ?>
                  <?php }
                    }
                  }  ?>
                  </div>


                  <?php
                  //Multiple & Comment
                  if ($ques_type == "checkcmt") { ?>
                    <div class=" row col-5 mt-2 ms-3 pe-5 py-4 new_div parent_class1" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30%;">
                      <div class="col-11 flex d-flex justify-content-start " style="padding-left:0px;margin-left:0px">
                        <div class="mb-3">
                          <button type="button" class="btn btn-light" id="btn_4" style="float: right; margin-top:5px; margin-left:20px; ">+ Add Option</button>
                        </div>
                      </div>
                      <div class="row ">
                        <?php foreach ($mul_arr as $k => $v) {
                          ++$i;
                          if ($i == count($mul_arr) && @!preg_match($pattern, $v['arr_opt'])) {   ?>

                            <div class="col-11 check_box1 ">
                              <div class="input-group mb-3   remove4">

                                <div class="input-group-prepend ">

                                  <div class="input-group-text ">
                                    <input type="checkbox" aria-label="Checkbox for following text input">
                                  </div>
                                </div>
                                <input type="text" class="form-control comm_class" name="options[]" value="<?php echo $v['arr_opt'] ?>" aria-label="Text input with radio button">
                                <div class="col-1 "><i class="fa-solid fa-xmark remove_check2" style="cursor:pointer;"></i></div>
                              </div>

                            </div>

                            <div class="col-11 pe-0 me-0 checkcmt"> </div>
                            <div class="col-12 ms-5">
                              <textarea class="mb-2 ps-2 pt-2 rounded delete_data" name="opt_cmt[]" style="width:50%" placeholder="no_text_here"></textarea>
                            </div>
                          <?php
                          } elseif (preg_match($pattern, $v['arr_opt'])) {
                            $str = str_replace(str_split('#*&'), '', $v['arr_opt']);
                          ?>
                            <div class="row pe-0 me-0 checkcmt"></div>
                            <div class="row col-10 ms-1">
                              <textarea name="opt_cmt[]" class="mb-2 ps-2 pt-2 rounded delete_data"><?php echo $str; ?></textarea>
                            </div>
                            <?php  } else {
                            if ($i == 1) { ?>
                              <div class="col-11 check_box1 ">
                                <div class="input-group mb-3 comm_class ">

                                  <div class="input-group-prepend">

                                    <div class="input-group-text">
                                      <input type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                  </div>
                                  <input type="text" class="form-control comm_class" name="options[]" value="<?php echo $v['arr_opt'] ?>" aria-label="Text input with radio button">
                                  <div class="col-1 "><i class="fa-solid fa-xmark remove_check1" style="cursor:pointer;"></i></div>
                                </div>

                              </div>

                            <?php } else {
                            ?>
                              <div class="col-11 check_box1 ">
                                <div class="input-group mb-3 ">

                                  <div class="input-group-prepend">

                                    <div class="input-group-text">
                                      <input type="checkbox" aria-label="Checkbox for following text input">
                                    </div>
                                  </div>

                                  <input type="text" class="form-control comm_class" name="options[]" value="<?php echo $v['arr_opt'] ?>" aria-label="Text input with radio button">
                                  <div class="col-1 "><i class="fa-solid fa-xmark remove_check1" style="cursor:pointer;"></i></div>
                                </div>
                              </div>

                      <?php }
                          }
                        }
                      } ?>



                      <?php
                      //Short Text

                      $len = count($mul_arr);
                      $i = 0;

                      if ($ques_type == "shorttext") {  ?>

                        <div class=" row col-4 mt-2 ms-3 pe-5 py-4 new_div " style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30%;">

                          <div class="row">
                            <div class="col-12">
                              <div class="input-group mb-4">

                                <div class="input-group-prepend">

                                  <label for="inputsm">Answer:</label>
                                  <input class="form-control input-sm" id="inputsm" type="text" style="width:300px; margin-left:10px;">
                                </div>

                              </div>
                              <?php
                              foreach ($mul_arr as $k => $v) {

                                $i++;
                                if (!empty($v['arr_opt'])) {
                              ?>


                            <?php }
                                if ($i == $len) {
                                }
                              }
                            }  ?>
                            </div>



                            <?php
                            //Rating Scale

                            $len = count($mul_arr);
                            $i = 0;
                            if ($ques_type == "rating") {  ?>

                              <div class=" row col-5 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30%;">

                                <div class="row">
                                  <div class="col-12">
                                    <div class="input-group mb-4">

                                      <div class="input-group-prepend">

                                        <label for="points">Points (between 0 and 5):</label>
                                        <input type="range" id="points" name="points" min="0" max="5" style="width: 300px; margin-left:20px;">
                                      </div>

                                    </div>
                                    <?php
                                    foreach ($mul_arr as $k => $v) {

                                      $i++;
                                      if (!empty($v['arr_opt'])) {
                                    ?>


                                  <?php }
                                      if ($i == $len) {
                                      }
                                    }
                                  }  ?>
                                  </div>

                                  <?php
                                  //Text/Paragraph

                                  $len = count($mul_arr);
                                  $i = 0;
                                  if ($ques_type == "text") {  ?>

                                    <div class=" row col-5 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30%;">

                                      <div class="row">
                                        <div class="col-12">
                                          <div class="input-group mb-4">

                                            <div class="input-group-prepend">

                                              <label for="comment">Answer:</label>
                                              <textarea class="form-control" rows="3" cols="50" id="comment" style="margin-left:20px;"></textarea>
                                            </div>

                                          </div>

                                          <?php
                                          foreach ($mul_arr as $k => $v) {

                                            $i++;
                                            if (!empty($v['arr_opt'])) {
                                          ?>


                                        <?php }
                                            if ($i == $len) {
                                            }
                                          }
                                        }  ?>
                                        </div>

                                        <?php
                                        //Email

                                        $len = count($mul_arr);
                                        $i = 0;
                                        if ($ques_type == "email") {  ?>

                                          <div class=" row col-5 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30%;">

                                            <div class="row">
                                              <div class="col-12">
                                                <div class="input-group mb-4">

                                                  <div class="input-group-prepend">

                                                    <label for="email">Enter your email:</label>
                                                    <input type="email" id="email" name="email" style="margin-left:20px; width:300px;">
                                                  </div>

                                                </div>
                                                <?php
                                                foreach ($mul_arr as $k => $v) {

                                                  $i++;
                                                  if (!empty($v['arr_opt'])) {
                                                ?>


                                              <?php }
                                                  if ($i == $len) {
                                                  }
                                                }
                                              }  ?>
                                              </div>

                                              <?php
                                              //Date/Time

                                              $len = count($mul_arr);
                                              $i = 0;
                                              if ($ques_type == "datetime") {  ?>

                                                <div class=" row col-5 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30%;">

                                                  <div class="row">
                                                    <div class="col-12">
                                                      <div class="input-group mb-4">

                                                        <div class="input-group-prepend">

                                                          <label for="date/time">Date and Time:</label>
                                                          <input type="datetime-local" id="datetime" name="datetime" style="margin-left:20px; width:300px;">
                                                        </div>

                                                      </div>
                                                      <?php
                                                      foreach ($mul_arr as $k => $v) {

                                                        $i++;
                                                        if (!empty($v['arr_opt'])) {
                                                      ?>


                                                    <?php }
                                                        if ($i == $len) {
                                                        }
                                                      }
                                                    }  ?>
                                                    </div>


                                                    <?php
                                                    //File

                                                    $len = count($mul_arr);
                                                    $i = 0;
                                                    if ($ques_type == "file") {  ?>

                                                      <div class=" row col-5 mt-2 ms-3 pe-5 py-4 new_div" style="border-left:10px solid gray;background-color:#dcdcdc; margin-left:30%;">

                                                        <div class="row">
                                                          <div class="col-12">
                                                            <div class="input-group mb-4">

                                                              <div class="input-group-prepend">

                                                                <p>Custom file:</p>
                                                                <div class="custom-file mb-3">
                                                                  <input type="file" class="custom-file-input" id="customFile" name="filename">
                                                                  <label class="custom-file-label" for="customFile">Choose file</label>
                                                                </div>
                                                              </div>

                                                            </div>
                                                            <?php
                                                            foreach ($mul_arr as $k => $v) {

                                                              $i++;
                                                              if (!empty($v['arr_opt'])) {
                                                            ?>


                                                          <?php }
                                                              if ($i == $len) {
                                                              }
                                                            }
                                                          }  ?>
                                                          </div>
                                                          <div class="col-lg-12 text-right justify-content-center d-flex mt-3 ">
                                                            <button type="submit" name="save" class="btn btn-primary" style="margin-right:.5%">Save</button>
                                                            <button type="cancel" name="cancel" class="btn btn-secondary" style="margin-right:.5%">Cancel</button>
                                                          </div>




                                                          <script>
                                                            //////////////////////////////////Hide & Show/////////////////////////////////////////////////

                                                            $(function() {
                                                              $("#drop").on('change', function() {
                                                                $(".data").hide();
                                                                $("#" + $(this).val()).fadeIn(800);
                                                              });
                                                              change();
                                                            });

                                                            //////////////////////////////////////////////////////////////////

                                                            $(function() {
                                                              $("#drop").on('change', function() {
                                                                $(".new_div").hide();
                                                                $("#" + $(this).val()).fadeIn(800);
                                                              });
                                                              $('.common_class').hide();
                                                              change();
                                                            });

                                                            //////////////////////////////////////////////delete value options
                                                            var drop_qtype = $('#drop').val();
                                                            // alert(drop_qtype);
                                                            $(document).ready(function() {
                                                              $('#drop').change(function() {
                                                                var new_drop_qtype1 = $('#drop').val(); // var new_drop_qtype1 = $(this).val();
                                                                // alert(new_drop_qtype1);
                                                                if (drop_qtype != new_drop_qtype1) {
                                                                  $('.comm_class').val('');
                                                                }
                                                              });
                                                            });
                                                            ///////////////////////////////////////////////////////////////////////////////////////////

                                                            //////////////////////////////////////Radio/////////////////////////////////////////////////////

                                                            $(document).ready(function() {
                                                              var input_radio1 = ('<div class="input-group radio_box mb-3" ><div class="input-group-prepend"><div class="input-group-text"><input type="radio" aria-label="Checkbox for following text input" disabled></div></div><input type="text" class="form-control comm_class" name="options[]"aria-label="Text input with checkbox"><div class="col-1 "><i class="fa-solid fa-xmark remove_radio1" style="cursor:pointer;"></i></div></div>');

                                                              $('#btn_1').click(function() {
                                                                $('#radio_remove1').append(input_radio1);
                                                              });
                                                              $('#radio_remove1').on('click', '.remove_radio1', function() {
                                                                $(this).parents('#remove1').remove();
                                                              });


                                                              $('.parent_class').on('click', '#btn_1', function() {
                                                                $('.radio_remove1').append(input_radio1);
                                                              });
                                                              $('.parent_class').on('click', '.remove_radio1', function() {
                                                                $(this).parents('.radio_box').remove();
                                                              });
                                                            });



                                                            /////////////////////////////////////////////////////////////////////////////////////////////////

                                                            //////////////////////////////////////Radio & Comment/////////////////////////////////////////////////////

                                                            $(document).ready(function() {
                                                              var input_radio1 = ('<div class="input-group radio_box1  mb-3" ><div class="input-group-prepend"><div class="input-group-text"><input type="radio" aria-label="Checkbox for following text input" disabled></div></div><input type="text" class="form-control comm_class" name="options[]"aria-label="Text input with checkbox"><div class="col-1"><i class="fa-solid fa-xmark remove_radio1" style="cursor:pointer;"></i></div></div>');

                                                              $('#btn_2').click(function() {
                                                                $('#radio_remove2').append(input_radio1);
                                                              });
                                                              $('#radio_remove2').on('click', '.remove_radio2', function() {
                                                                $(this).parents('#remove2').remove();
                                                              });


                                                              $('.parent_class').on('click', '#btn_2', function() {
                                                                $('.radio_remove1,.radiocmt').append(input_radio1);
                                                              });
                                                              $('.parent_class').on('click', '.remove_radio1', function() {
                                                                $(this).parents('.radio_box1').remove();
                                                              });
                                                            });
                                                            /////////////////////////////////////////////////////////////////////////////////////////////////

                                                            //////////////////////////////////////Multiple/////////////////////////////////////////////////////

                                                            $(document).ready(function() {
                                                              var input_check1 = ('<div class="input-group mb-3 comm_class check_box"><div class="input-group-prepend"><div class="input-group-text"><input type="checkbox" aria-label="Checkbox for following text input" disabled></div></div><input type="text" class="form-control comm_class" name="options[]" aria-label="Text input with checkbox"><div class="col-1 "><i class="fa-solid fa-xmark remove_check1" style="cursor:pointer;"></i></div></div></div>');

                                                              $('#btn_3').click(function() {
                                                                $('#check_remove1').append(input_check1);
                                                              });
                                                              $('#check_remove1').on('click', '.remove_check1', function() {
                                                                $(this).parents('#remove3').remove();
                                                              });


                                                              $('.parent_class').on('click', '#btn_3', function() {
                                                                $('.check_remove1').append(input_check1);
                                                              });
                                                              $('.parent_class').on('click', '.remove_check1', function() {
                                                                $(this).parents('.check_box').remove();
                                                              });
                                                            });
                                                            /////////////////////////////////////////////////////////////////////////////////////////////////

                                                            //////////////////////////////////////Multiple & Comment/////////////////////////////////////////////////////

                                                            $(document).ready(function() {
                                                              var input_check1 = ('<div class="input-group comm_class mb-3"><div class="input-group-prepend"><div class="input-group-text"><input type="checkbox" aria-label="Checkbox for following text input" disabled></div></div><input type="text" class="form-control comm_class" name="options[]" aria-label="Text input with checkbox"><i class="fa-solid fa-xmark remove_check2" style="cursor:pointer;"></i></div></div>');
                                                              // hide div
                                                              $('#btn_4').click(function() {
                                                                $('#check_remove2').append(input_check1);
                                                              });
                                                              $('#check_remove2').on('click', '.remove_check2', function() {
                                                                $(this).parents('#remove4').remove();
                                                              });
                                                              // unhide div
                                                              $('.parent_class1').on('click', '#btn_4', function() {
                                                                $('.check_remove1,.checkcmt').append(input_check1);
                                                              });
                                                              $('.parent_class1').on('click', '.remove_check2', function() {
                                                                $(this).parents('.remove4').remove();
                                                              });
                                                            });
                                                            /////////////////////////////////////////////////////////////////////////////////////////////////
                                                          </script>
                                                          <?php
                                                          // require_once 'sidenav.php';
                                                          ?>