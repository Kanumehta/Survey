<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanku</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/6e67e55af3.js" crossorigin="anonymous"></script>
    <script src="js/userlist.js"></script>
    <script src="js/srvylist.js"></script>


    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'survey_db') or die('connection failed');


    $survey_id = $_GET['survey_id'];

    $query1 = "SELECT * FROM `survey_forms` WHERE `survey_id`='$survey_id'";
    $data = mysqli_query($conn, $query1);
    $arr = mysqli_fetch_row($data);



    // print_r($arr);
    $title = $arr[1];
    $description = $arr[3];
    $pattern = '/#*&$/';
    @$invitation_key = $_GET['invite_key'];

    // extract
    if (isset($_POST['save'])) {
        extract($_POST);

        $answer = $_POST['options'];
        $answer = array_map('array_filter', $answer);
        $answer = array_filter($answer);
        // echo "<pre>";
        // print_r($answer);
        // echo "</pre>";


        $query2 = "SELECT * FROM `survey_invitation` WHERE `invitation_key` = '$invitation_key'";
        $data2 = mysqli_query($conn, $query2);
        $arr = mysqli_fetch_array($data2);
        print_r($arr);
        $name1 = $arr['invitation_name'];
       $email = $arr['invitation_email'];


        if (empty($answer)) {
            echo "<script>alert('Please fill the survey');</script>";
        }

        // INSERT INTO ANSWER************************************** 
        else {
            foreach ($answer as $ques => $arr) {
                foreach ($arr as $val => $ans) {
                    $query5 = "INSERT INTO `answers`(`answer_id`, `answers`, `question_id_2`,`survey_submitted_by`, `survey_submitted_email`) VALUES (NULL, '$ans','$ques','$name1','$email')";
                    $data5 = mysqli_query($conn, $query5);
                    header("location:thanku.php?survey_id=$survey_id");
                }
            }
        }
    }

    // join***************************
    $query1 = "SELECT * FROM survey_forms AS s LEFT JOIN survey_questions AS q ON s.survey_id=q.survey_id LEFT JOIN option_table AS o ON q.question_id=o.question_id_1 WHERE s.survey_id = '$survey_id'  ORDER BY question_id ";
    $data1 = mysqli_query($conn, $query1);

    while ($res = mysqli_fetch_array($data1)) {
        $Survey_name =  $res['survey_title'];
        // $Survey_Category = $res['Survey_Category'];
        // $Survey_description = $res['Survey_description'];

        $arr_ques = $res['question'];
        $opt['ques_type'] = $res['question_options'];
        $opt['arr_opt'] = $res['options'];
        $opt['ques_id'] = $res['question_id'];
        $opt['opt_id'] = $res['option_id'];
        // $mul_arr[$res['survey_id']][$arr_ques][] = $opt;
        $mul_arr[$res['survey_id'] . "::" . $res['question_id']][$arr_ques][] = $opt;
    }

    // echo "<pre>";
    // print_r($mul_arr);
    // echo "<pre>" . "<br>";



    ?>

    <div class="container w-50 mt-3 mb-3 back" style="border: 2px solid gray; border-radius: 2px; background-color:#f2f2f2;">
        <div class="container mt-3">
            <div class="row">
                <div class="col">
                    <h3 style="text-align: center;">Survey Form</h3>
                    <h1 class="mb-3" style=" text-align: center;"><?php echo $Survey_name; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col p-3 mb-3" style="border: 2px solid gray; border-radius: 5px; text-align:justify;">

                    <?php echo $description; ?>

                </div>
            </div>
        </div>

        <div>
            <div class="row">
                <div class="col-lg-12">
                    <form method="post">
                        <?php



                        foreach ($mul_arr as $survey_id => $ques) {
                            foreach ($ques as $q => $opt) {

                                if (!empty($q)) {
                                    foreach ($opt as $k => $v) {
                                        $ques_id =  $v['ques_id'];
                                        $ques_type = $v['ques_type'];
                                        $option = $v['arr_opt'];
                                        // echo $option;

                                    }
                        ?>
                                    <div class="conatiner px-2 mb-3" style="border: 2px solid gray; border-radius:5px;">
                                        <div class="row mt-3 ms-1">
                                            <div class="col-11">
                                                <h5>
                                                    Q. <?php echo $q; ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row mt-1 ms-3">
                                            <?php
                                            $i = 0;
                                            $len = count($opt);
                                            foreach ($opt as $o => $b) {

                                                $question_id_1 = $b['ques_id'];
                                            ?>
                                                <div class="col-lg-10">
                                                    <p style="color: black; font-weight: 400;">

                                                        <?php
                                                        if ($b['arr_opt'] != "") {

                                                            // if(!empty($b['opt'])){
                                                            if ($b['ques_type'] == "radio") { ?>
                                                    <div><input type="radio" name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>">
                                                        <?php print_r($b['arr_opt']); ?></div>

                                                    <?php

                                                                if ($i == count($opt)) {
                                                                    echo $option;

                                                                    // echo " <hr class='style-eight mt-0'>";
                                                                }
                                                                // echo $b['opt'];
                                                                // echo $option;
                                                            } else if ($b['ques_type'] == "radiocmt") {
                                                                $i++;
                                                                if ($i == count($opt) && !preg_match(@$pattern, $b['arr_opt'])) { ?>

                                                        <div><input type='radio' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>">
                                                            <?php print_r($b['arr_opt']); ?></div>
                                                        <textarea style="width: 50%" placeholder="<?php echo @$str; ?>" name='options[<?php echo $b['ques_id'] ?>][]'></textarea>
                                                    <?php
                                                                } elseif (@preg_match(@$pattern, $b['arr_opt'])) {
                                                                    $str = str_replace(str_split('#*&'), '', $b['arr_opt']);
                                                    ?>
                                                        <?php
                                                                } else {
                                                                    if ($i == $len) { ?>
                                                            <textarea placeholder="<?php echo $str; ?>" name='options[<?php echo $b['ques_id'] ?>][]'></textarea>
                                                        <?php
                                                                    } else { ?>
                                                            <div><input type='radio' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>">
                                                                <?php print_r($b['arr_opt']); ?></div>
                                                    <?php
                                                                        // echo $b['opt'];
                                                                        // echo $option;
                                                                    }
                                                                }
                                                            } else if ($b['ques_type'] == "check") { ?>
                                                    <div><input type='checkbox' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>">
                                                        <?php print_r($b['arr_opt']); ?></div>
                                                    <?php
                                                                // echo $b['opt'];
                                                            } else if ($b['ques_type'] == "checkcmt") {
                                                                $i++;
                                                                if ($i == count($opt) && !preg_match(@$pattern, $b['arr_opt'])) { ?>
                                                        <div><input type='checkbox' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>">
                                                            <?php print_r($b['arr_opt']); ?></div>
                                                        <textarea style="width: 50%" placeholder="<?php echo @$str; ?>" name='options[<?php echo $b['ques_id'] ?>][]'></textarea>
                                                    <?php
                                                                } elseif (@preg_match(@$pattern, $b['arr_opt'])) {
                                                                    $str = str_replace(str_split('#*&'), '', $b['arr_opt']);
                                                    ?>
                                                        <?php
                                                                } else {
                                                                    if ($i == $len) { ?>
                                                            <textarea placeholder="<?php echo $str; ?>" name='options[<?php echo $b['ques_id'] ?>][]'></textarea>
                                                        <?php
                                                                    } else { ?>
                                                            <div><input type='checkbox' name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>">
                                                                <?php print_r($b['arr_opt']); ?></div>
                                                    <?php
                                                                        // echo $b['opt'];
                                                                        // echo $option;
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            if ($b['ques_type'] == "shorttext") { ?>
                                                    <input type="text" name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>" class="me-2" style="width:50%;" />
                                                <?php
                                                            } else if ($b['ques_type'] == "text") { ?>
                                                    <textarea name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>" class="me-2" style="width:50%;"></textarea>
                                                <?php
                                                            } else if ($b['ques_type'] == "email") { ?>
                                                    <input type="email" name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>" class="me-2" style="width:50%;" />
                                                <?php
                                                            } else if ($b['ques_type'] == "datetime") { ?>
                                                    <input type="datetime-local" name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>" class="me-2" style="width:50%;" />
                                                <?php
                                                            } else if ($b['ques_type'] == "rating") { ?>
                                                    Rate us (between 0 and 10):<br>
                                                    <input type="range" name='options[<?php echo $b['ques_id'] ?>][]' min='0' max='10' value="0" class="me-2" style="width:50%;" />
                                                <?php
                                                            } else if ($b['ques_type'] == "file") { ?>
                                                    <input type="file" name='options[<?php echo $b['ques_id'] ?>][]' value="<?php echo $b['arr_opt'] ?>" class="me-2" />
                                        <?php
                                                            }
                                                        }
                                                        echo "</p></div>";
                                                    } ?>
                                                </div>
                                        </div>
                            <?php
                                }
                            }
                        }
                            ?>
                            <div class="me-3 mb-3" style="float: right;">
                                <button type="submit" name="save" class="btn btn-primary">Save</button>
                                <!-- <button class="btn btn-secondary">Cancel</button> -->
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>