<?php
    session_start();

    if (!empty($_SESSION['login_success']) && $_SESSION['login_success'] == 1) {
        $_SESSION['login_issue'] = '<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Account is active! <a href="../dashboard">Dashboard</a>
      </div>';
    }

    require_once "../controllers/DatabaseConnection.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Rep-Cords | Login</title>
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

            <div style="height: 30px;"></div>
            
            <div class="container-fluid">
                <div class="col-xs-4"></div>
                
                <div class="col-xs-4" style="color: white; width: 340px; font-size: 20px;" align="center">
                    Login to your Account
                </div>
            </div>

            <div style="height: 10px;"></div>

            <div class="container-fluid">
                <div class="col-xs-4"></div>
                
                <div class="container col-xs-4" style="box-shadow: 0px 0px 1px #ccc; height: 326px; width: 340px;">
                    <div style="height: 8px;"></div>
                    
                    <div>
                        <div style="box-shadow: 0px 0px 0px #ccc;">
                            <h5 style="color: white; height: 23px;">
                                <?php 
                                    if (!empty($_SESSION['login_issue'])) {
                                        echo $_SESSION['login_issue']; 
                                    }
                                ?>
                            </h5>
                        </div>
                        
                        <div style="margin-top: 15px;"></div>
                        
                        <form role="form">
                            <div class="form-group">
                                <label for="username" style="color: white;">Username:</label>
                                <input type="email" class="form-control" id="username" placeholder="student-id@st.atu.edu.gh" name="username" required />
                            </div>

                            <div style="height: 12px;"></div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6" style="color: white;"><label for="password">Password:</label></div>
                                    <div class="col-sm-2" style="font-size: 14px; width: 160px; text-align: right;">
                                        <a href="../forgot-password" id="ForgotPasswordButton" name="ForgotPasswordButton">I forgot my password</a>
                                    </div>
                                </div>
                                <input type="password" class="form-control" id="password" placeholder="********" name="password" required />
                            </div>
                            
                            <div class="checkbox" style="color: white;">
                                <label><input type="checkbox" name="remember"> Keep me logged in</label>
                            </div>
                            
                            <div style="height: 20px;"></div>
                            <input type="submit" class="btn form-control btn-success btn-block" name="login_button" id="login_button" value="Login">
                            <div style="height: 40px;"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div style="height: 20px;"></div>
            <div class="container-fluid">
                <div class="col-xs-4"></div>
                
                <div class="col-xs-4" style="color: white; width: 340px;" align="center">
                    <form method="post" action="">
                        <text style="color: white;">Don't have an account yet?</text> <a style="color: #337ab7; text-decoration: none;" href="../sign-up">Sign up</a>
                    </form>
                </div>
            </div>
        </div>

        <script src="../js/index.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        
    </body>
</html>