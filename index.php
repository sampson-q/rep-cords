<?php
    session_start();
    if (isset($_SESSION['Session_Expired']) && ($_SESSION['Session_Expired'] == 1)) {
        echo '<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Session Expired!
      </div>';

      $_SESSION['Session_Expired'] = '';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Rep-Cords</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <link href="css/index.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <link href="material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="node_modules/@material/fab/dist/mdc.fab.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/index.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            &nbsp;<h2 style="text-shadow: 0px 0px 2px teal;">Rep-Cords.com</h2>

            <div style="height: 30px;"></div>
            
            <div class="container-fluid">
                <div class="col-xs-4"></div>
                
                <div class="col-xs-4" style="color: white; width: 340px; font-size: 20px;" align="center">
                    Welcome to the Paper-Less Gen.
                </div>
            </div>

            <div style="height: 10px;"></div>

            <div class="container-fluid">
                <div class="col-xs-4"></div>
                
                <div class="container col-xs-4" style="box-shadow: 0px 0px 1px #ccc; height: 180px; width: 340px;">
                    <div style="height: 8px;"></div>
                    
                    <div>
                        <h4 style="color: white; text-shadow: 0px 0px 0px teal;">Let's Roll!</h4>
                        <div style="margin-top: 15px;"></div>
                        <div>
                            <a href="log-in" style="text-decoration: none;">
                                <div class="btn btn-block btn-success">Login</div>
                            </a>
                        </div>

                        <div style="height: 30px; box-shadow: 0px 0px 1px #ccc; line-height: 30px; color: white;" align="center">OR</div>
                        
                        <div>
                            <a href="sign-up" style="text-decoration: none;">
                                <div class="btn btn-block btn-primary">Sign Up</div>
                            </a>
                        </div>
                    </div>
                
                </div>
                
            </div>
        </div>
    </body>
</html>