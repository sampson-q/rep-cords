<?php
    /*
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    /**
    * Description of DatabaseConnection
    *
    * @author Hash 👽
    */

    require_once "./CrudOperation.php";

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Rep Notes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <link href="css/index.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <link href="material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="node_modules/@material/fab/dist/mdc.fab.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/index.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            #closeButton {border: 0px; background: transparent; font-size: 11px;}
            #profile-drop-down{font-size: 14px;}
            body {
                background-color: #f4f6fa;
                background-image: url('../images/background1.jpeg');
                background-size: 100%;
                background-repeat: no-repeat;
                background-clip: content-box;
                overflow-x: hidden;
                overflow-y: hidden;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid" style="background-color: black; opacity: 0.7;">
            <div style="height: 90px;"></div>
            <div class="container" id="signupContainer">
                <div class="row">
                        <div class="col-xs-2"></div>
                        <div class="col-xs-8" id="signupCard" style="box-shadow: 0px 0px 1px #ccc; background: #fff;">
                            <div style="height: 20px;"></div>
                                <div class="row">
                                    <div class="col-xs-4"></div>
                                    <div class="col-xs-4" style="font-weight: bold; font-size: 16px; text-align: center;">Reset Password</div>
                                </div>
                                <div style="height: 15px;"></div>
                                <?php if (!empty($_SESSION['wrong_credent']) && $_SESSION['wrong_credent'] == 1) { ?>
                                    <div class="row" id="forgotStatus">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-10" style="border: 1px solid #ccc; text-align: center;">
                                            <div class="row">
                                                <div class="col-xs-1" style="background: #d63939;">&nbsp;</div>
                                                <div class="col-xs-9">Wrong Security Question or Answer!</div>
                                                <div class="col-xs-1">
                                                    <form method="post" action="">
                                                        <button name="wrong_credent" id="closeButton">x</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if (!empty($_SESSION['password_unmatched']) && $_SESSION['password_unmatched'] == 1) { ?>
                                    <div class="row" id="signupStatus">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-10" style="border: 1px solid #ccc; text-align: center;">
                                            <div class="row">
                                                <div class="col-xs-1" style="background: #d63939;">&nbsp;</div>
                                                <div class="col-xs-9">Passwords do not Match!</div>
                                                <div class="col-xs-1">
                                                    <!--<a style="cursor: pointer;" href="#" onclick="document.getElementById('signupStatus').style.display = 'none';">x</a>-->
                                                    <form method="post" action="">
                                                        <button name="password_unmatched" id="closeButton">x</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if (!empty($_SESSION['password_error']) && $_SESSION['password_error'] == 1) { ?>
                                    <div class="row" id="forgotStatus">
                                        <div class="col-xs-1"></div>
                                        <div class="col-xs-10" style="border: 1px solid #ccc; text-align: center;">
                                            <div class="row">
                                                <div class="col-xs-1" style="background: #d63939;">&nbsp;</div>
                                                <!--<div class="col-xs-9">Password must contain an uppercase and a number. Must be 8 or more!</div>-->
                                                <div class="col-xs-9">Password be must at least 8 characters!</div>
                                                <div class="col-xs-1">
                                                    <!--<a style="cursor: pointer;" href="#" onclick="document.getElementById('signupStatus').style.display = 'none';">x</a>-->
                                                    <form method="post" action="">
                                                        <button name="password_error" id="closeButton">x</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div style="height: 15px;"></div>
                                <form method="POST" action="" role="form">
                                    <div class="row">
                                        <div class="container-fluid">
                                            <div class="form-group">
                                                <label for="securityquestion">Security Question:</label>
                                                <input type="text" class="form-control" id="securityQuestion" placeholder="Enter Security Question" name="securityQuestion" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="securityanswer">Security Answer:</label>
                                                <input type="text" class="form-control" id="securityAnswer" placeholder="Enter Security Answer" name="securityAnswer">
                                            </div>
                                            <div class="form-group">
                                                <label for="newpassword">New Password:</label>
                                                <input type="password" class="form-control" id="newPassword" placeholder="Enter New Password" name="newPassword" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmnewpassword">Confirm New Password:</label>
                                                <input type="password" class="form-control" id="confirmNewPassword" placeholder="Confirm New Password" name="confirmNewPassword" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 10px;"></div>
                                    <div class="row">
                                        <div class="col-xs-4"></div>
                                        <div class="col-xs-4">
                                            <input type="submit" class="btn btn-primary form-control" id="password_reset_button" name="password_reset_button" value="Reset Password">
                                        </div>
                                    </div>
                                    <div style="height: 30px;"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div style="height: 661px;"></div>
                </div>
            </div>
        </div>
    </body>
</html>