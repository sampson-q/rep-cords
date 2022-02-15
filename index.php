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
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        
        
        <link href="index.css" rel="stylesheet" type="text/css" />

        <link href="css/index.css" rel="stylesheet" type="text/css" />
        <script src="js/index.js"></script>
        
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