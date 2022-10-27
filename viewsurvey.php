  <?php
  require_once 'nav.php';

  $conn = mysqli_connect('localhost', 'root', '', 'survey_db') or die('connection failed');

  @$id = $_GET['survey_id'];
  @$qq_id = $_GET['qq_id'];
  $pattern = '/#*&/';


  // delete
  if (!empty($qq_id)) {
    $query4 = "DELETE survey_questions , option_table  FROM survey_questions LEFT JOIN option_table ON survey_questions.question_id = option_table.question_id_1 WHERE survey_questions.question_id =$qq_id";
    $data4 = mysqli_query($conn, $query4);
    header("location:viewsurvey.php?survey_id=$id");
  }

  $id = $_GET['survey_id'];
  $query1 = "SELECT * FROM `survey_forms` WHERE `survey_id`='$id'";
  $data = mysqli_query($conn, $query1);
  $arr = mysqli_fetch_row($data);



  // print_r($arr);
  $title = $arr[1];
  $description = $arr[3];
  $startdate = $arr[5];
  $enddate = $arr[6];

  if(isset($_POST['back'])){
    header("location:srvylist.php");
}


  ?>


  <section class="section profile">

    <div class="table-responsive">

      <div class="col-xl-5 p-4 mt-2" style="margin:auto; border:4px solid gray;">

      

        <div class="card  p-4 mt-2">
          <div class="card-body pt-3">
            
          <div style="float:right;">
          <a href="updatesrvylist.php?id=<?php echo $arr[0]; ?>"><button class="btn btn-light"><i class="fa-solid fa-pen-to-square"></i></button></a>

          <a href="ansview.php?survey_id=<?php echo $arr[0]; ?> "><button class="btn btn-light"><i class="fa-solid fa-eye"></i
          ></button></a>

           <a href="invitation.php?survey_id=<?php echo $arr[0]; ?> "><button class="btn btn-light"><i class='bx bx-share-alt'></i></button></a>

           <a href="srvydlt.php?id=<?php echo $arr[0]; ?> "><button onclick="return confirm('Are you sure, You want to delete this?');" class="btn btn-light"><i class="fa-solid fa-trash-can" ></i></button></a>

           </div> 


            <h2>Survey Details </h2>

            

            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" id="nav-profile-overview" data-toggle="tab" href="#profile-overview" role="tab" aria-selected="false"></button>
              </li>


            </ul>

            <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" role="tabpanel" aria-labelledby="nav-profile-overview" id="profile-overview">

                <!-- <h5 class="card-title">Survey Details</h5> -->
                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Title</div>
                  <div class="col-lg-9 col-md-8"><?php echo $title; ?></div>
                </div>


                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Description</div>
                  <div class="col-lg-9 col-md-8"><?php echo $description; ?></div>
                </div>


                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Start Date</div>
                  <div class="col-lg-9 col-md-8"><?php echo $startdate; ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">End Date</div>
                  <div class="col-lg-9 col-md-8"><?php echo $enddate; ?></div>
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

  <div class="card p-4 mt-5">
    <div class="heading d-flex justify-content-center mt-2">
      <h1 class="">Questionnaire</h1>
    </div>

    <button type="button" class="btn btn-block btn-sm btn-default btn-flat border-success new_question" style="width:12%; margin-top:10px; margin-left:55%;" data-toggle="modal" data-target="#myModal">
      <i class="bx bx-plus"></i><a href="ques.php?survey_id=<?php echo $arr[0]; ?>">Add New Question</a></button>



    <div class="container w-50 p-3">

      <div>


        <!-- foreach -->
        <?php

        $query3 = "SELECT * FROM survey_forms AS s LEFT JOIN survey_questions AS q ON s.survey_id=q.survey_id LEFT JOIN option_table AS o ON q.question_id=o.question_id_1 WHERE s.survey_id = '$id' ORDER BY s.survey_id ,o.option_id , q.question";
        $data3 = mysqli_query($conn, $query3);
        while ($res = mysqli_fetch_array($data3)) {
          //$ques_type = $res['Question_option_type'];
          $arr_ques = $res['question'];
          $qq_id = $res['question_id'];
          // if($ques_type == "mcq" || $ques_type == "mcq_c" || $ques_type == "sc" || $ques_type == "sc_c"){
          $opt['ques_type'] = $res['question_options'];
          $opt['arr_opt'] = $res['options'];
          $opt['question_id'] = $res['question_id'];
          // $mul_arr[$res['survey_id']][$arr_ques][] = $opt;
          $mul_arr[$res['survey_id']."::".$res['question_id']][$arr_ques][] = $opt;
          // }
          // else{
          //     $mul_arr[$res['Survey_id']][$arr_ques] ;
          // }x
          // echo "<pre>";
          // print_r($res);
          // echo "</pre>";

        }
        // echo "<pre>";
        //    print_r($mul_arr);
        //    echo "</pre>";

        foreach ($mul_arr as $survey_id => $ques) {
          foreach ($ques as $q => $opt) {
            foreach ($opt as $k => $v) {
              $question_id = $v['question_id'];
            }
            // echo  "<strong>Q.".$q."</strong><br><br>";
        ?>
            <div class="row col-10 rounded mb-2 pt-2 ms-1 r5" style="border-left:10px solid gray;">
              <div class='form-group input-group mb-3' style="border:1px solid gray; box-shadow: -5px -4px 2px 2px gray;">
                <div class='input-group-prepend'>
                  <span class='input-group-text'> <strong>Q</strong></span>
                </div>

                <input name='text' id="" class='form-control' value="<?php echo $q ?>" disabled>

                <div class="action-itms d-flex justify-content-evenly">
                  <button class="btn btn-light"><a href="updateques.php?qq_id=<?php echo $question_id ?>&survey_id=<?php echo $survey_id ?>"><i class="fa-solid fa-pen-to-square"></i></button></a>

                  <button class="btn btn-light"><a onclick="return confirm('Do you want to delete')" href="viewsurvey.php?survey_id=<?php echo $survey_id ?>&qq_id=<?php echo $question_id ?>"><i class="fa-solid fa-trash-can"></i></button></a>


                </div>
              </div>

              <?php
              $len = count($opt);
              $i = 0;

              foreach ($opt as $o => $b) {
                if ($b['arr_opt'] != "") { ?>
                  <?php
                  if ($b['ques_type'] == "radio") { ?>
                    <div class='input-group mb-2'>
                      <input type='radio' name='radio'>
                      &nbsp;
                      <?php
                      // echo "<p>";
                      echo ($b['arr_opt']); ?>
                    </div>
                  <?php
                  } elseif ($b['ques_type'] == "check") { ?>
                    <div class='input-group mb-2'>
                      <input type='checkbox' name='checkbox'>
                      &nbsp;
                      <?php
                      echo $b['arr_opt']; ?>
                    </div>
                    <?php
                  } elseif ($b['ques_type'] == "radiocmt") {
                    ++$i;

                    if ($i == count($opt) && @!preg_match($pattern, $b['arr_opt'])) {
                      echo "<div class='input-group mb-2'>";
                      echo "<input type='radio' name='radio'>";
                      echo "&nbsp;&nbsp;";
                      echo $b['arr_opt'];
                      echo "</div>";
                    ?>
                      <textarea placeholder="Add Comment:"></textarea>
                    <?php
                    } elseif (@preg_match($pattern, $b['arr_opt'])) {
                      $str = str_replace(str_split('#*&'), '', $b['arr_opt']);
                    ?>
                      <div class='input-group mb-2'>
                        <textarea placeholder="<?php echo $str; ?>"></textarea>
                      </div>

                    <?php
                    } else {
                      echo "<div class='input-group mb-2'>";
                      echo "<input type='radio' name='radio'>";
                      echo "&nbsp;&nbsp;";
                      echo $b['arr_opt'];
                      echo "</div>";
                    }
                  } elseif ($b['ques_type'] == "checkcmt") {
                    ++$i;

                    if ($i == count($opt) && @!preg_match($pattern, $b['arr_opt'])) {
                      echo "<div class='input-group mb-2'>";
                      echo "<input type='checkbox' name='checkbox'>";
                      echo "&nbsp;&nbsp;";
                      echo $b['arr_opt'];
                      echo "</div>";
                    ?>

                      <textarea placeholder="Add Comment:"></textarea>

                    <?php
                    } elseif (@preg_match($pattern, $b['arr_opt'])) {
                      $str = str_replace(str_split('#*&'), '', $b['arr_opt']);
                    ?>
                      <div class='input-group mb-2'>
                        <textarea placeholder="<?php echo $str; ?>"></textarea>
                      </div>
              <?php
                    } else {
                      echo "<div class='input-group mb-2'>";
                      echo "<input type='checkbox' name='checkbox'>";
                      echo "&nbsp;&nbsp;";
                      echo $b['arr_opt'];
                      echo "</div>";
                    }
                  }
                } else {
                  if ($b['ques_type'] == "text") {
                    echo "<div class='input-group mb-2'>
                <span class='input-group-text' id='inputGroup-sizing-default'></span>
                <input type='text' placeholder='' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
              </div>";
                  } elseif ($b['ques_type'] == "shorttext") {
                    echo "<div class='input-group mb-2'>
                <span class='input-group-text' id='inputGroup-sizing-default'></span>
                <input type='text' placeholder='' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
              </div>";
                  } elseif ($b['ques_type'] == "datetime") {
                    echo "<div class='input-group mb-2'>
            <span class='input-group-text' id='inputGroup-sizing-default'></span>
            <input type='date' placeholder='' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
          </div>";
                  } elseif ($b['ques_type'] == "rating") {
                    echo "<div class=' row col-11 ms-3  mb-2 mt-2 ' id='rating' style=';background-color:#dcdcdc;'>
              <div class='col-6 ms-5'>
              <label class='mt-2' for='vol'>Rate us (between 0 and 10):</label>
              <input type='range' id='vol' name='vol' min='0' max='10' style='width:100%;height:7vh;'>
              </div>
              </div>";
                  } elseif ($b['ques_type'] == "file") {
                    echo "<div class='input-group mb-2'>
            <span class='input-group-text' id='inputGroup-sizing-default'></span>
            <input type='file'  class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
          </div>";
                  } elseif ($b['ques_type'] == "email") {
                    echo "<div class='input-group mb-2'>
            <span class='input-group-text' id='inputGroup-sizing-default'></span>
            <input type='email' placeholder='' class='form-control' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-default'>
          </div>";
                  }
                }
              }
              ?>
            </div>
        <?php
          }
        }

        ?>


        <?php
        require_once 'sidenav.php';
        ?>