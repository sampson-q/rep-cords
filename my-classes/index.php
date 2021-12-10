<?php
    session_start();
    $_SESSION['signup_success'] = '';

    require_once '../controllers/DatabaseConnection.php';
    if (empty($_SESSION['login_success']) || $_SESSION['login_success'] == 0) {
        $_SESSION['session_timeout'] = 1;
        echo '<script>window.location.href = "../index.php";</script>';
    }
    include_once '../controllers/DatabaseConnection.php';
?>

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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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

        <div style="" class="container-fluid col-xs-6" id="ViewClassMembers">
            <?php
                $class2operate = filter_input(INPUT_POST, 'class2operate');
                $class2delete = filter_input(INPUT_POST, 'classname');
                $db = new DatabaseConnection('localhost', 'root', '');
                $connection = $db -> ConnectDB();
                if (isset($_POST['viewclassmembers'])){
                    $query = $connection -> prepare("SELECT * FROM `repnotes`.`:classtoshow`");
                    $query -> execute([
                        'classtoshow' => strtolower($class2operate)
                    ]);

                    if ($query -> rowCount() > 0) { ?>
                        <table class="table table-responsive" style="color: white;">
                            <caption style="text-align: center; color: white;"><h2><?php echo $class2operate ?></h2></caption>
                            <tr align="center">
                                <td><strong>S/N</strong></td>
                                <td><strong>Student Name</strong></td>
                                <td><strong>Student ID</strong></td>
                                <td colspan="2"><strong>Options</strong></td>
                            </tr>
                            <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                <tr align="center">
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $result['studentname']; ?></td>
                                    <td><?php echo $result['studentid']; ?></td>
                                    <td><input id="updatemember" type="submit" id="tableButton" class="btn btn-success" value="Update" /></td>
                                    <td><input id="removemember" type="submit" id="tableButton"class="btn btn-danger" value="Remove" /></td>
                                </tr>
                            <?php $counter += 1; } ?>
                            <tr style="color: white;" align="right">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><div id="addmember" class="btn btn-primary">Add Member</div></td>
                            </tr>
                        </table>
                    <?php } else { echo '<h2 style="color: white;">Class members will show here if any!<h2>
                                        <tr align="right">
                                            <td><div class="col-xs-8"></div></td>
                                            <td><div id="addmember" class="btn btn-primary">Add Member</div></td>
                                        </tr>';}
                } else if (isset($_POST['deleteclass'])) { ?>
                    <div style="color: white; text-align: center;" id="alert-box" class="container-fluid">
                        <h4>This action cannot be undone! Do you wish to continue?</h4>
                        <form action>
                            <input type="hidden" value="<?php echo $class2operate ?>" id="class2delete" name="class2delete" />
                            <input type="hidden" value="<?php echo $class2delete ?>" id="classname" />
                            <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                            <div name="proceedclassremov" id="proceedclassremov" class="btn btn-danger">Delete</div>
                        </form>
                    </div>
                <?php } ?>
        </div>
        
        <div style="display: none;" class="container-fluid col-xs-6" id="AddClassMembers">
            <form role="form">
                <div class="form-group">
                    <label for="addstudentid">Student ID :</label>
                    <input type="text" class="form-control" id="addstudentid" placeholder="Student ID" name="addstudentid" required>
                </div>

                <div class="form-group">
                    <label for="addstudentname">Student Name:</label>
                    <input type="text" class="form-control" id="addstudentname" placeholder="Student Name" name="addstudentname" required>
                </div>
                <input type="hidden" value="<?php echo strtolower($class2operate) ?>" id="memberaddclass" />
                <input type="submit" class="form-control btn btn-primary" value="Add Member" id="addmemberbutton" name="addmemberbutton"/>
            </form>
        </div>

        <script src="../js/index.js"></script>
        <script src="index.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>