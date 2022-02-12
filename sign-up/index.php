<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Rep-Cords | Sign Up</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <link href="../css/index.css" rel="stylesheet" type="text/css" />
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <link href="material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="node_modules/@material/fab/dist/mdc.fab.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid">
            &nbsp;<h2 style="text-shadow: 0px 0px 2px teal;"><a href="../" style="text-decoration: none;">Rep-Cords.com</a></h2>

            <div style="height: 2px;"></div>
            
            <div class="container-fluid">
                <div class="col-xs-4"></div>
                
                <div class="col-xs-4" style="color: white; width: 520px; font-size: 20px;" align="center">
                    Signup for a free Account!
                </div>
            </div>

            <div style="height: 3px;"></div>

            <div class="container-fluid">
                <div class="col-xs-4"></div>
                
                <div class="container col-xs-4" style="box-shadow: 0px 0px 1px #ccc; height: 470px; width: 520px;">
                    <div style="height: 4px;"></div>
                    
                    <div>
                        <div style="box-shadow: 0px 0px 0px #ccc;">
                            <h5 style="color: white; height: 23px;">
                                <?php
                                    if (!empty($_SESSION['signup_issue'])) {
                                        echo $_SESSION['signup_issue'];
                                    }
                                ?>
                            </h5>
                        </div>
                        
                        <div style="margin-top: 15px;"></div>
                        <form role="form">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name:</label>
                                        <input type="text" class="form-control" id="firstname" placeholder="Enter firstname" name="firstname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="middlename">Middle Name:</label>
                                        <input type="text" class="form-control" id="middlename" placeholder="Enter middlename (optional)" name="middlename">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last Name:</label>
                                        <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="studentemail">Student Email:</label>
                                        <input type="email" class="form-control" id="studentemail" placeholder="student-id@st.atu.edu.gh" name="studentemail" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="studentlevel">Student Level:</label>
                                        <select class="form-control" id="studentlevel" name="studentlevel" required>
                                            <option value="" selected disabled>Choose</option>
                                            <option value="100">Level 100</option>
                                            <option value="200">Level 200</option>
                                            <option value="300">Level 300</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="programme">Programme:</label>
                                        <input type="text" class="form-control" id="programme" name="programme" placeholder="Enter programme" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="class">Class:</label>
                                        <input type="text" class="form-control" name="class" id="class" placeholder="example: CPS 1A" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="studentid">Student ID:</label>
                                        <input type="text" class="form-control" name="studentid" id="studentid" placeholder="01234567D" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="*********" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmpassword">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="*********" required>
                                    </div>
                                </div>
                            </div>
                            <div style="height: 10px;"></div>
                            <div class="row">
                                <div class="col-xs-4"></div>
                                <div class="col-xs-4">
                                <input type="submit" class="form-control btn btn-primary" value="Sign Up" id="signup_button" name="signup_button"/>
                                </div>
                            </div>
                            <div style="height: 30px;"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div style="height: 20px;"></div>
            <div class="container-fluid">
                <div class="col-xs-4"></div>
                
                <div class="col-xs-4" style="color: white; width: 520px;" align="center">
                    <text style="color: white;">Already have an account?</text> <a style="color: #4cae4c; text-decoration: none;" href="../log-in">Login</a>
                </div>
            </div>
        </div>

        <script src="../js/index.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>

    </body>
</html>