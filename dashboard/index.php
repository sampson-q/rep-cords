<?php
    session_start();
    $_SESSION['signup_success'] = '';

    if (empty($_SESSION['login_success']) || $_SESSION['login_success'] == 0) {
        $_SESSION['session_timeout'] = 1;
        echo '<script>window.location.href = "../index.php";</script>';
    }

    include_once "../controllers/DatabaseConnection.php";
?>

<!DOCTYPE html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Rep-Cords | Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <link href="../css/index.css" rel="stylesheet" type="text/css" />
        <link href="index.css" rel="stylesheet" type="text/css" />
        <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link href="material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="node_modules/@material/fab/dist/mdc.fab.min.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <div id="wholebody" class="container-fluid navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="../dashboard">rep-cords.com</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li id="home"><a href="../dashboard" class="active"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $_SESSION['student_id']; ?>
                        <span class="caret"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="../controllers/LogOut.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        <li>
                            <a class="profile-drop-down" href="#" id="profileSet"><span class="glyphicon glyphicon-cog"></span> Profile Settings</a>
                        </li>
                        <li>
                            <a class="profile-drop-down" href="#" id="resetPass"><span class="glyphicon glyphicon-wrench"></span> Set Security Question</a>
                        </li>
                    </ul>
                </li>
                <li><a href="../controllers/LogOut.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
            </ul>
        </div>
        
        <div class="col-xs-3"></div>
        
        <div id="DashHome" class="container-fluid col-xs-6" style="margin-top: 50px;">
            <div id="viewclass" class="btn col-xs-3" style="font-size: 25px; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                My Class
            </div>

            <div class="col-xs-1" align="center"></div>
            
            <div id="addclass" class="btn col-xs-3" style="font-size: 25px; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                Add Class
            </div>

            <div class="col-xs-1" align="center"></div>

            <div id="createclassbutton" class="btn col-xs-3" style="font-size: 25px; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                Create Class
            </div>
        </div>

        <div style="display: none;" class="container-fluid col-xs-6" id="CreateClassForm">
            <form role="form">
                <div class="form-group">
                    <label for="classname">Class Name:</label>
                    <input type="text" class="form-control" id="classname" placeholder="Enter Class Name" name="classname" required>
                </div>
                <input type="submit" class="form-control btn btn-primary" value="Create Class" id="createclass_button" name="createclass_button"/>
            </form>
        </div>

        <script src="../js/index.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    
    </body>
</html>