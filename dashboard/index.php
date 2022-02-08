<?php
    //session_start();
    $_SESSION['signup_success'] = '';
    error_reporting(E_ERROR | E_PARSE);

    require_once '../controllers/DatabaseConnection.php';
    require_once '../controllers/CrudOperation.php';

    $crud = new CrudOperation();

    if (empty($_SESSION['login_success']) || $_SESSION['login_success'] == 0) {
        $_SESSION['session_timeout'] = 1;
        echo '<script>window.location.href = "../index.php";</script>';
    }

    $db = new DatabaseConnection('localhost', 'root', '');
    $connection = $db -> ConnectDB();

    require('../fpdf183/fpdf.php');
    $pdf = new FPDF();
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
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link href="material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="node_modules/@material/fab/dist/mdc.fab.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="">
        <div id="wholebody" class="container-fluid navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="../dashboard">rep-cords.com</a>
            </div>
            
            <ul class="nav navbar-nav navbar-right">
                <li id="home"><a href="" class="active"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home</a></li>
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
        
        <div id="DashHome" class="container-fluid col-xs-6" style="margin-top: 60px;">
            <div class="col-xs-12">
               
                <div id="addclass" class="btn col-xs-3" style="font-size: ; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                    Add Class
                </div>

                <div class="col-xs-1" align="center"></div>
                
                <div id="viewclass" name="viewclass" class="btn col-xs-3" style="font-size: ; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                    View Classes
                </div>

                <div class="col-xs-1" align="center"></div>

                <div id="shared-class" class="btn col-xs-3" style="font-size: ; color: white; box-shadow: 0px 0px 1px #ccc;">
                    Exported Class
                </div>
            </div>
            
            <div class="col-xs-12" style="height: 30px;"></div>
            
            <div class="col-xs-12">
                
                <div id="inheritted-class" class="btn col-xs-3" style="font-size: ; color: white; box-shadow: 0px 0px 1px #ccc;" align="">
                    Imported Class
                </div>

                <div class="col-xs-1" align="center"></div>
                
                <div id="showatt" name="showatt" class="btn col-xs-3" style="font-size: ; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                    View Attendance
                </div>

                <div class="col-xs-1" align="center"></div>

                <div id="courses" name="courses" class="btn col-xs-3" style="font-size: ; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                    My Courses
                </div>
            </div>
        </div>

        <div style="display: none;" class="container-fluid col-xs-6" id="AddClassForm">
            <form role="form">
                <div class="form-group">
                    <label for="classname">Class Name:</label>
                    <input type="text" class="form-control" id="addclassname" placeholder="Enter Class Name" name="addclassname" required>
                </div>
                <input type="submit" class="form-control btn btn-primary" value="Add Class" id="addclassbutton" name="addclassbutton"/>
            </form>
        </div>

        <div style="display: none;" class="container-fluid col-xs-6" id="ViewClassPage">
            <?php
                $query = $connection -> prepare("SELECT * FROM `all_class` WHERE student_id = :userId");
                $query -> execute([
                    'userId' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0) { ?>
                    <div style="color: white;">
                        <div id="table-header-div" class="col-xs-12">
                            <h2 align="center">My Classes</h2>
                            <hr>
                            <div id="table-heads" style="font-weight: bold; margin-top: -12px;">
                                <div class="col-xs-2">S/N</div>
                                <div align="" class="col-xs-4">Class Name</div>
                                <div class="col-xs-1"></div>
                                <div align="center" class="col-xs-3">Options</div>
                            </div>
                        </div>
                        <div class="col-xs-12 fixTableHead" style="margin-top: 10px;">
                            <table class="table table-responsive" style="color: white;">
                                <tr id="table-body-div">
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr align="center" id="table-bodys">
                                            <form action="" method="POST" role="form">    
                                                <input type="hidden" value="<?php echo $_SESSION['student_id'] . '_' . $result['class_names'] ?>" name="class2operate" id="class2operate">
                                                <input type="hidden" value="<?php echo $result['class_names'] ?>" name="classname" id="classname" />
                                                <td><?php echo $counter; ?></td>
                                                <td width=""><?php echo $result['class_names']; ?></td>
                                                <td><input id="viewclassmembers" name="viewclassmembers" type="submit" class="btn btn-success" value="View" /></td>
                                                <td><input id="deleteclass" name="deleteclass" type="submit" class="btn btn-danger" value="Delete" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-12" style="height: 15px;"></div>
                        <div class="col-xs-12" align="right">
                            <div id="classadd" class="btn btn-primary">Add Class</div>
                        </div>
                    </div>
                    
                <?php } else { echo '<h2 style="color: white;">Your classes will show here if you have any!<h2>
                                    <tr align="right">
                                        <td><div class="col-xs-8"></div></td>
                                        <td><div id="classadd" class="btn btn-primary">Add Class</div></td>
                                    </tr>'; }
            ?>
        </div>

        <div style="display: none;" class="container-fluid col-xs-6" id="ShowAttendance">
            <?php
                $query = $connection -> prepare("SELECT * FROM `all_class` WHERE student_id = :userId");
                $query -> execute([
                    'userId' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0) { ?>
                    <div style="color: white;">
                        <div id="table-header-div" class="col-xs-12">
                            <h2 align="center">View Attendance</h2>
                            <hr>
                            <div id="table-heads" style="font-weight: bold; margin-top: -12px;">
                                <div class="col-xs-2">S/N</div>
                                <div align="" class="col-xs-4">Class Name</div>
                                <div class="col-xs-1"></div>
                                <div align="center" class="col-xs-3">Option</div>
                            </div>
                        </div>
                        <div class="col-xs-12 fixTableHead" style="margin-top: 10px;">
                            <table class="table table-responsive" style="color: white;">
                                <tr id="table-body-div">
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr align="center" id="table-bodys">
                                            <form action="" method="POST" role="form">    
                                                <input type="hidden" value="<?php echo $_SESSION['student_id'] . '_' . $result['class_names'] ?>" name="attendance-class" id="attendance-class">
                                                <td><?php echo $counter; ?></td>
                                                <td width=""><?php echo $result['class_names']; ?></td>
                                                <td><input id="vattendance" name="vattendance" type="submit" class="btn btn-success" value="View Attendance" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-12" style="height: 15px;"></div>
                    </div>
                    
                <?php } else { echo '<h2 style="color: white;">Your classes will show here if you have any!<h2>
                                    <tr align="right">
                                        <td><div class="col-xs-8"></div></td>
                                        <td><div id="classadd" class="btn btn-primary">Add Class</div></td>
                                    </tr>'; }
            ?>
        </div>

        <div style="display: none;" class="container-fluid col-xs-6" id="ViewClassContents">
            <?php
                if (isset($_POST['viewclassmembers'])){
                    echo '<script>document.getElementById("ViewClassContents").style = "display: block;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            
                    $class2operate = filter_input(INPUT_POST, 'class2operate');
                    $_SESSION['class2show'] = $class2operate;

                    $query = $connection -> prepare("SELECT * FROM `repnotes`.`:classtoshow`");
                    $query -> execute([
                        'classtoshow' => strtolower($class2operate)
                    ]);

                    if ($query -> rowCount() > 0) { ?>
                    <div style="color: white;">
                        <div id="table-header-div" class="">
                            <form action="" method="POST">
                                <div class="col-xs-6">
                                        <h2 align="right"><?php echo explode('_', $class2operate)[1] ?></h2>
                                        <input type="hidden" value="<?php echo $class2operate ?>" id="attendance-class" name="attendance-class" />
                                </div>
                                <div class="col-xs-6" align="right">
                                        <h6 style="line-height: 45px;">
                                            <input type="submit" class="btn btn-primary" id="vattendance" name="vattendance" value="View Attendance">
                                        </h6>
                                </div>
                            </form>
                            
                            <div id="table-heads" class="col-xs-12" style="font-weight: bold;">
                                <table class="table">
                                    <tr>
                                        <td>S/N</td>
                                        <td align="center">Student Name</td>
                                        <td align="center">Student ID</td>
                                        <td>Options</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="col-xs-12 fixTableHead" style="margin-top: -18px;">
                                <table class="table table-responsive" style="color: white;">
                                    <tr id="table-body-div">
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr align="center">
                                            <td><?php echo $counter; ?></td>
                                            <td width="500"><?php echo $result['studentname']; ?></td>
                                            <td><?php echo $result['studentid']; ?></td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="sn" id="sn" value="<?php echo $result['sn']; ?>" />
                                                <input type="hidden" name="class2operate" id="class2operate" value="<?php echo $class2operate ?>" />
                                                <input type="hidden" name="id2operate" id="id2operate" value="<?php echo $result['studentid']; ?>" />
                                                <input type="hidden" name="name2operate" id="name2operate" value="<?php echo $result['studentname']; ?>" />
                                                <td><input id="updatemember" name="updatemember" type="submit" id="tableButton" class="btn btn-success" value="Update" /></td>
                                                <td><input id="removemember" name="removemember" type="submit" id="tableButton"class="btn btn-danger" value="Remove" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xs-12" style="height: 15px;"></div>
                            <div class="col-xs-12" align="right">
                                <div id="addmember" class="btn btn-primary">Add Member</div>
                            </div>
                        </div>
                    </div>
                    <?php } else { echo '<h2 style="color: white;">Class members will show here if any!<h2>
                                        <tr align="right">
                                            <td><div class="col-xs-8"></div></td>
                                            <td><div id="addmember" class="btn btn-primary">Add Member</div></td>
                                        </tr>';}
                } else if (isset($_POST['deleteclass'])) { 
                    echo '<script>document.getElementById("ViewClassContents").style = "display: block;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                    $class2operate = filter_input(INPUT_POST, 'class2operate');
                    //$class2delete = filter_input(INPUT_POST, 'classname');
                    $classname = explode('_', $class2operate)[1];
                    
                    ?>
                
                    <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid">
                        <h4>This action cannot be undone! Do you wish to remove <?php echo strtoupper($classname) ?>?</h4>
                        
                        <input type="hidden" value="<?php echo $class2operate ?>" id="class2delete" name="class2delete" />
                        <input type="hidden" value="<?php echo $classname ?>" id="class2rem" />
                        <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                        <div name="proceedclassremov" id="proceedclassremov" class="btn btn-danger">Delete</div>
                    </div>
                <?php } ?>
        </div>

        <?php
            if (isset($_POST['updatemember'])) {
                $sn = filter_input(INPUT_POST, 'sn');
                $id2operate = filter_input(INPUT_POST, 'id2operate');
                $name2operate = filter_input(INPUT_POST, 'name2operate');
                $class2operate = filter_input(INPUT_POST, 'class2operate');
                $backupname = $name2operate; $backupid = $id2operate;
                echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            ?>
            <div class="container-fluid col-xs-6" id="Individuals">
                <form role="form">
                    <input type="hidden" name="memberupdateclass" id="memberupdateclass" value="<?php echo $class2operate ?>" />
                    <input type="hidden" name="backupname" id="backupname" value="<?php echo $backupname?>" />
                    <input type="hidden" name="backupid" id="backupid" value="<?php echo $backupid?>" />
                    <input type="hidden" name="sntoupdate" id="sntoupdate" value="<?php echo $sn ?>" />
                    <div class="form-group">
                        <label for="addstudentid">Student ID :</label>
                        <input type="text" class="form-control" id="updatestudentid" value="<?php echo $id2operate ?>" name="addstudentid" required>
                    </div>

                    <div class="form-group">
                        <label for="addstudentname">Student Name:</label>
                        <input type="text" class="form-control" id="updatestudentname" value="<?php echo $name2operate ?>" name="addstudentname" required>
                    </div>
                    <input type="submit" class="form-control btn btn-primary" value="Update" id="update" name="update"/>
                </form>
            </div>
            <?php } else if (isset($_POST['removemember'])) {
                $sn = filter_input(INPUT_POST, 'sn');
                $name2operate = filter_input(INPUT_POST, 'name2operate');
                $class2operate = filter_input(INPUT_POST, 'class2operate');
                echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                ?>
                <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid col-xs-12">
                    <h4>This action cannot be undone!<p>Do you wish to remove <strong><?php echo $name2operate ?> </strong> from <strong><?php echo explode('_', $class2operate)[1]; ?></strong>?</h4>
                    
                    <input type="hidden" value="<?php echo $class2operate ?>" id="class2delete" name="class2delete" />
                    <input type="hidden" value="<?php echo $sn ?>" id="recordtoremove" />
                    <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                    <div name="proceedmemremov" id="proceedmemremov" class="btn btn-danger">Delete</div>
                </div>
        <?php } ?>

        <div style="display: none;" class="container-fluid col-xs-6" id="SharedClasses">
            <?php
                $query = $connection -> prepare("SELECT * FROM `shared_classes` WHERE shared_by = :userId");
                $query -> execute([
                    'userId' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0) { ?>
                    <div style="color: white;">
                        <div id="table-header-div" class="col-xs-12">
                            <h2 align="center">My Shared Classes</h2>
                            <hr>
                            <div id="table-heads" style="font-weight: bold; margin-top: -12px;">
                                <div class="col-xs-2">S/N</div>
                                <div align="" class="col-xs-3">Class Name</div>
                                <div align="" class="col-xs-3">Shared To</div>
                                <div align="center" class="col-xs-3">Options</div>
                            </div>
                        </div>
                        <div class="col-xs-12 fixTableHead" style="margin-top: 10px;">
                            <table class="table table-responsive" style="color: white;">
                                <tr id="table-body-div">
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr align="center" id="table-bodys">
                                            <form action="" method="POST" role="form">
                                                <input type="hidden" value="<?php echo $result['id'] ?>" name="class2unshare" id="class2unshare"/>
                                                <input type="hidden" value="<?php echo $result['shared_to'] ?>" name="person2unshare" id="person2unshare" />
                                                <input type="hidden" value="<?php echo $result['class_names'] ?>" name="classunsharename" id="classunsharename" />
                                                <td><?php echo $counter; ?></td>
                                                <td><?php echo $result['class_names']; ?></td>
                                                <td><?php echo $result['shared_to']; ?></td>
                                                <td><input id="unshareclass" name="unshareclass" type="submit" class="btn btn-primary" value="Unshare" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-12" style="height: 15px;"></div>
                        <div class="col-xs-12" align="right">
                            <div id="shareaclass" class="btn btn-primary">Share A Class</div>
                        </div>
                    </div>
                    
                <?php } else { echo '<h2 align="center" style="color: white;">Classes you shared will appear here<h2>
                                    <tr align="right">
                                        <td><div class="col-xs-8"></div></td>
                                        <td><div id="shareaclass" class="btn btn-primary">Share A Class</div></td>
                                    </tr>'; }
            ?>
        </div>

        <div style="display: none;" class="container-fluid col-xs-6" id="ShareAClass">
            <?php
                $query = $connection -> prepare("SELECT * FROM `all_class` WHERE student_id = :userId");
                $query -> execute([
                    'userId' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0) { ?>
                    <div style="color: white;">
                        <div id="table-header-div" class="col-xs-12">
                            <h2 align="center">Share A Classes</h2>
                            <hr>
                            <div id="table-heads" style="font-weight: bold; margin-top: -12px;">
                                <div align="" class="col-xs-2">S/N</div>
                                <div align="" class="col-xs-5">&nbsp;&nbsp;&nbsp;&nbsp;Class Name</div>
                                <div align="" class="col-xs-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Options</div>
                            </div>
                        </div>
                        <div class="col-xs-12 fixTableHead" style="margin-top: 10px;">
                            <table class="table table-responsive" style="color: white;">
                                <tr id="table-body-div">
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr align="center" id="table-bodys">
                                            <form action="" method="POST" role="form">    
                                                <input type="hidden" value="<?php echo $result['class_names']; ?>" id="sharethisclass" name="sharethisclass" />
                                                <td><?php echo $counter; ?></td>
                                                <td><?php echo $result['class_names']; ?></td>
                                                
                                                <td><input id="shareclass" name="shareclass" type="submit" class="btn btn-success" value="Share Class" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                <?php } else { echo '<h2 align="center" style="color: white;">Classes you shared will appear here<h2>
                                    <tr align="right">
                                        <td><div class="col-xs-8"></div></td>
                                        <td><div id="shareaclass" class="btn btn-primary">Share A Class</div></td>
                                    </tr>'; }
            ?>
        </div>

        <?php
            if (isset($_POST['unshareclass'])) {
                $class2unshare = filter_input(INPUT_POST, 'class2unshare');
                $person2unshare = filter_input(INPUT_POST, 'person2unshare');
                $classunsharename = filter_input(INPUT_POST, 'classunsharename');
                echo '<script>document.getElementById("SharedClasses").style = "display: none;";</script>';
                echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            ?>

            <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid col-xs-12">
                <h4><strong><?php echo $person2unshare?></strong> will no longer have access to <strong><?php echo $classunsharename ?></strong></h4>
                <p>Do you wish to continue?</p>
                
                <input type="hidden" value="<?php echo $class2unshare ?>" id="classtounshare" name="classtounshare" />
                <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                <div name="proceedunshare" id="proceedunshare" class="btn btn-danger">Unshare</div>
            </div>
        <?php } ?>

        <?php
            if (isset($_POST['shareclass'])) {
                $sharethisclass = filter_input(INPUT_POST, 'sharethisclass');
                echo '<script>document.getElementById("SharedClasses").style = "display: none;";</script>';
                echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
        ?>

        <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid col-xs-6">
            <div class="col-xs-3"></div>
            <div id="sharetowho" class="container-fluid col-xs-6">
                <form role="form" method="POST" action="">
                    <div class="form-group">
                        <label for="shareclassto">Share Class To:</label>
                        <input type="text" class="form-control" id="shareclassto" placeholder="User ID" name="shareclassto" required>
                        <input type="hidden" value="<?php echo $sharethisclass ?>" name="class4share" id="class4share">
                    </div>
                    
                    <input type="submit" class="form-control btn btn-primary" value="Share" id="shareclassbutton" name="shareclassbutton"/>
                </form>
            </div>
        </div>
        <?php } ?>

        <?php 
                if (isset($_POST['shareclassbutton'])) {
                    $shareclassto = filter_input(INPUT_POST, 'shareclassto');
                    $class4share = filter_input(INPUT_POST, 'class4share');
                    echo '<script>document.getElementById("sharetowho").style = "display: none;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                
            ?>
                <div id="proceed2share" align="center" style="color: white; margin-top: 40px;" class="container-fluid col-xs-6">
                    <h4><strong><?php echo $shareclassto ?></strong> will be able to make alterations to <strong><?php echo $class4share ?></strong></h4>
                    <p>Do you wish to continue?</p>
                    
                    <input type="hidden" value="<?php echo $class4share ?>" id="classshare" name="classshare" />
                    <input type="hidden" value="<?php echo $shareclassto?>" id="shareclass1" name="shareclass1" />
                    <input type="hidden" value="<?php echo $_SESSION['student_id'] ?>" id="shareby" name="shareby" />
                    <div id="cancelclassremove" class="btn btn-success">Cancel</div>
                    <div name="proceedshareclass" id="proceedshareclass" class="btn btn-primary">Share Class</div>
                </div>
        <?php } ?>

        <div style="display: none;" class="container-fluid col-xs-6" id="import-classes">
            <?php
                $query = $connection -> prepare("SELECT * FROM `shared_classes` WHERE shared_to = :userId");
                $query -> execute([
                    'userId' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0) { ?>
                    <div style="color: white;">
                        <div id="table-header-div" class="col-xs-12">
                            <h2 align="center">My Received Classes</h2>
                            <hr>
                            <div id="table-heads" style="font-weight: bold; margin-top: -12px;">
                                <div class="col-xs-2">S/N</div>
                                <div align="" class="col-xs-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Class Name</div>
                                <div align="" class="col-xs-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shared By</div>
                                <div align="" class="col-xs-3">Options</div>
                            </div>
                        </div>
                        <div class="col-xs-12 fixTableHead" style="margin-top: 10px;">
                            <table class="table table-responsive" style="color: white;">
                                <tr id="table-body-div">
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr align="center" id="table-bodys">
                                            <form action="" method="POST" role="form">
                                                <td><?php echo $counter; ?></td>
                                                <td width="450"><?php echo $result['class_names']; ?></td>
                                                <td><?php echo $result['shared_by']; ?></td>
                                                <input type="hidden" name="sn0" id="sn0" value="<?php echo $result['id']?>" />
                                                <input type="hidden" id="class2operate" name="class2operate" value="<?php echo $result['shared_by'] . '_' . $result['class_names'];?>" />
                                                <input type="hidden" id="class_shared0" name="class_shared0" value="<?php echo $result['class_names'];?>" />
                                                <td><input id="viewrev" name="viewrev" type="submit" class="btn btn-success" value="View" /></td>
                                                <td><input id="undoshare" name="undoshare" type="submit" class="btn btn-danger" value="Undo Share" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                <?php } else { echo '<h2 align="center" style="color: white;">Classes shared to you will appear here<h2>'; }
            ?>
        </div>

        <div style="display: none;" class="container-fluid col-xs-6" id="ViewSharedClassContents">
            <?php
                if (isset($_POST['viewrev'])){
                    echo '<script>document.getElementById("ViewSharedClassContents").style = "display: block;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            
                    $class2operate = filter_input(INPUT_POST, 'class2operate');
                    $_SESSION['class2show'] = $class2operate;

                    $query = $connection -> prepare("SELECT * FROM `repnotes`.`:classtoshow`");
                    $query -> execute([
                        'classtoshow' => strtolower($class2operate)
                    ]);

                    if ($query -> rowCount() > 0) { ?>
                    <div style="color: white;">
                        <div id="table-header-div" class="">
                        <form action="" method="POST">
                                <div class="col-xs-6">
                                        <h2 align="right"><?php echo $class2operate ?></h2>
                                        <input type="hidden" value="<?php echo $class2operate ?>" id="attendance-class" name="attendance-class" />
                                </div>
                                <div class="col-xs-6" align="right">
                                        <h6 style="line-height: 45px;">
                                            <input type="submit" class="btn btn-primary" id="vattendance" name="vattendance" value="View Attendance">
                                        </h6>
                                </div>
                            </form>

                            <div id="table-heads" class="col-xs-12" style="font-weight: bold;">
                                <table class="table">
                                    <tr>
                                        <td>S/N</td>
                                        <td align="center">Student Name</td>
                                        <td align="center">Student ID</td>
                                        <td>Options</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                        <div class="col-xs-12 fixTableHead" style="margin-top: -18px;">
                            <table class="table table-responsive" style="color: white;">
                                <tr id="table-body-div">
                                <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                    <tr align="center">
                                        <td><?php echo $counter; ?></td>
                                        <td width="500"><?php echo $result['studentname']; ?></td>
                                        <td><?php echo $result['studentid']; ?></td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="sn" id="sn" value="<?php echo $result['sn']; ?>" />
                                            <input type="hidden" name="class2operate" id="class2operate" value="<?php echo $class2operate ?>" />
                                            <input type="hidden" name="id2operate" id="id2operate" value="<?php echo $result['studentid']; ?>" />
                                            <input type="hidden" name="name2operate" id="name2operate" value="<?php echo $result['studentname']; ?>" />
                                            <td><input id="updatemember" name="updatemember" type="submit" id="tableButton" class="btn btn-success" value="Update" /></td>
                                            <td><input id="removemember" name="removemember" type="submit" id="tableButton"class="btn btn-danger" value="Remove" /></td>
                                        </form>
                                    </tr>
                                <?php $counter += 1; } ?>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-12" style="height: 15px;"></div>
                        <div class="col-xs-12" align="right">
                            <div id="addmember" class="btn btn-primary">Add Member</div>
                        </div>
                        </div>
                    </div>
                    <?php } else { echo '<h2 style="color: white;">Class members will show here<h2>
                                        <tr align="right">
                                            <td><div class="col-xs-8"></div></td>
                                            <td><div id="addmember" class="btn btn-primary">Add Member</div></td>
                                        </tr>';}
            }?>
        </div>

        <?php
            if (isset($_POST['undoshare'])) {
                $class2unshare = filter_input(INPUT_POST, 'sn0');
                $classunsharename = filter_input(INPUT_POST, 'class_shared0');
                echo '<script>document.getElementById("ViewSharedClasses").style = "display: none;";</script>';
                echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            ?>

                <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid col-xs-12">
                    <h4>You will no longer have access to <strong><?php echo $classunsharename ?></strong></h4>
                    <p>Do you wish to continue?</p>
                    
                    <input type="hidden" value="<?php echo $class2unshare ?>" id="classtounshare" name="classtounshare" />
                    <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                    <div name="proceedunshare" id="proceedunshare" class="btn btn-danger">Undo Share</div>
                </div>
        <?php } ?>

        <div style="display: none;" class="container-fluid col-xs-6" id="AddClassMembers">
            <form role="form" method="POST">
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

        <?php if ($_POST['addmemberbutton']) {
            echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            echo '<script>document.getElementById("AddClassMembers").style = "display: block;";</script>';
        }?>

        <div style="display: none;" class="container-fluid col-xs-6" id="ViewAttendance">
            <?php
                if (isset($_POST['vattendance'])) {
                    $ClassType = filter_input(INPUT_POST, 'attendance-class');
                    $Container = filter_input(INPUT_POST, 'container');
                    echo '<script>document.getElementById("ViewAttendance").style = "display: block;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';

                    $query = $connection -> prepare('SELECT * FROM all_attendance WHERE class_names = :classname');
                    $query -> execute([
                        'classname' => $ClassType
                    ]);
                    
                    if ($query -> rowCount() > 0) { ?>
                        <div style="color: white;">
                            <div id="table-header-div" class="">
                                <h3 align="center" style="color: white;">Attendances for <?php echo explode("_", $_SESSION['class2show'], 2)[1]; ?></h3>
                                <div id="table-heads" class="col-xs-12" style="font-weight: bold;">
                                    <table class="table">
                                        <tr>
                                            <td>S/N</td>
                                            <td align="center">Attend. Name</td>
                                            <td align="center">Taken By</td>
                                            <td>Options</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div>
                            <div class="col-xs-12 fixTableHead" style="margin-top: -18px;">
                                <table class="table table-responsive" style="color: white;">
                                    <tr id="table-body-div">
                                    <?php
                                        $counter = 1; while ($result = $query -> fetch()) {
                                        $firstcut = explode("-", $result['attend_names'], 3)[1];
                                        $seconcut = explode("-", $result['attend_names'], 3)[2];
                                        $thirdcut = explode(".", $seconcut, 2)[0];
                                        ?>
                                        <tr align="center">
                                            <td><?php echo $counter; ?></td>
                                            <td width="300"><?php echo "[$firstcut] ---> [$thirdcut ]"; ?></td>
                                            <td><?php echo $result['taken_by']; ?></td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="snatt" id="snatt" value="<?php echo $result['id']; ?>" />
                                                <input type="hidden" name="attn" id="attn" value="<?php echo $result['attend_names']; ?>" />
                                                <input type="hidden" name="attname" id="attname" value="<?php echo $firstcut . " @ " . $thirdcut ?>" />
                                                <td><a href="../attends/<?php echo $result['attend_names'];?>" target="_blank" class="btn btn-success">View</a></td>
                                                <td><input id="deleatt" name="deleatt" type="submit" id="tableButton"class="btn btn-danger" value="Delete" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xs-12" style="height: 15px;"></div>
                            <div class="col-xs-12" align="right">
                                <div id="takeattendance" class="btn btn-primary">Take Attendance</div>
                            </div>
                            </div>
                        </div>
                        <?php } else { echo '<h2 style="color: white;">Attendances will show here if any<h2>
                                            <tr align="right">
                                                <td><div class="col-xs-8"></div></td>
                                                <td><div id="takeattendance" class="btn btn-primary">Take Attendance</div></td>
                                            </tr>';}
                }
            ?>
            <input type="hidden" value="<?php echo $ClassType; ?>" id="classtype">
        </div>

        <?php
            if (isset($_POST['deleatt'])) { 
                echo '<script>document.getElementById("ViewClassContents").style = "display: block;";</script>';
                echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                $attname = filter_input(INPUT_POST, 'attname');
                $att2rem = filter_input(INPUT_POST, 'snatt');
                $att2move = filter_input(INPUT_POST, 'attn');
                ?>
            
                <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid">
                    <h4>This action cannot be undone! Do you wish to remove <?php echo strtoupper($attname) ?>?</h4>
                    
                    <input type="hidden" value="<?php echo $att2rem;?>" id="att2rem" />
                    <input type="hidden" value="<?php echo $att2move;?>" id="att2move" />
                    <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                    <div name="proceedattrem" id="proceedattrem" class="btn btn-danger">Delete</div>
                </div>
        <?php } ?>

        <div style="display: none;" class="container-fluid col-xs-6" id="Courses">
            <?php
                $query = $connection -> prepare('SELECT * FROM registered_courses WHERE student_id = :userid');
                $query -> execute([
                    'userid' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0) { ?>
                    <div style="color: white;">
                        <div id="table-header-div" class="">
                            
                            <div class="col-xs-6">
                                    <h2 align="right">My Courses</h2>
                            </div>
                            
                            <div id="table-heads" class="col-xs-12" style="font-weight: bold;">
                            <table class="table">
                                <tr>
                                    <td>S/N</td>
                                    <td align="center">Course Name</td>
                                    <td align="center">Course Code</td>
                                    <td>Lecturer</td>
                                    <td>Options</td>
                                    <td></td>
                                </tr>
                            </table>
                            </div>
                        </div>
                        <div>
                            <div class="col-xs-12 fixTableHead" style="margin-top: -18px;">
                                <table class="table table-responsive" style="color: white;">
                                    <tr id="table-body-div">
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr align="">
                                            <td><?php echo $counter; ?></td>
                                            <td width="250"><?php echo $result['courses_name']; ?></td>
                                            <td><?php echo $result['courses_code']; ?></td>
                                            <td><?php echo $result['lecturer_name']; ?></td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="snid" id="snid" value="<?php echo $result['id']; ?>" />
                                                <input type="hidden" name="coursenameEdit" id="coursenameEdit" value="<?php echo $result['courses_name']; ?>" />
                                                <input type="hidden" name="coursecodeEdit" id="coursecodeEdit" value="<?php echo $result['courses_code']; ?>" />
                                                <input type="hidden" name="lecturnameEdit" id="lecturnameEdit" value="<?php echo $result['lecturer_name']; ?>" />
                                                <td><input id="updatecourses" name="updatecourses" type="submit" id="tableButton" class="btn btn-success" value="Update" /></td>
                                                <td><input id="removecourses" name="removecourses" type="submit" id="tableButton"class="btn btn-danger" value="Remove" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xs-12" style="height: 15px;"></div>
                            <div class="col-xs-12" align="right">
                                <div id="registercourses" class="btn btn-primary">Register Courses</div>
                            </div>
                        </div>
                    </div>
                <?php } else { echo '<h2 style="color: white;">You have not registered any courses yet<h2>
                                        <tr align="right">
                                            <td><div class="col-xs-8"></div></td>
                                            <td><div id="registercourses" class="btn btn-primary">Register Courses</div></td>
                                        </tr>';}?>
        </div>
        
        <div style="display: none;" class="container-fluid col-xs-6" id="RegisterCourses">
            <fom role="">
                <div class="form-group">
                    <label for="coursecode">Course Code:</label>
                    <input type="text" class="form-control" id="coursecode" placeholder="Course Code" required>
                </div>

                <div class="form-group">
                    <label for="coursename">Course Name:</label>
                    <input type="text" class="form-control" id="coursename" placeholder="Course Name" required>
                </div>

                <div class="form-group">
                    <label for="lectname">Lecturer Name:</label>
                    <input type="text" class="form-control" id="lectname" placeholder="Lecturer Name" required>
                </div>

                <input type="submit" class="btn btn-primary form-control" value="Register Course" name="registercoursebutton" id="registercoursebutton"> 
            </form>
        </div>

        <div style="display: none;" class="" id="TakeAttendance">
            <?php
                $qr = $connection -> prepare('SELECT * FROM registered_courses WHERE student_id = :userid');
                
                if (isset($_SESSION['class2show']) && !empty($_SESSION['class2show'])) {
                    $query = $connection -> prepare("SELECT * FROM `repnotes`.`:classtoshow`");
                    $query -> execute([
                        'classtoshow' => strtolower($_SESSION['class2show'])
                    ]);
                }
                $qr -> execute([
                    'userid' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0 ) {
                    if ($qr -> rowCount() > 0) { ?>
                        <div class="container-fluid col-xs-6">
                            <form method="POST">
                                <select style="margin-top: 12px;" id="coursecode" name="coursecode" required>
                                    <option value="" selected disabled>Select Course</option>
                                    <?php while ($res = $qr -> fetch()) { ?>
                                        <option value="<?php echo $res['courses_name'] . '=' . $res['courses_code'] . '=' . $res['lecturer_name']; ?>"><?php echo $res['courses_name'] . ' (' . $res['courses_code'] . ')'; ?></option>
                                    <?php } ?>
                                </select>
                                <input type="date" name="coursedate" id="coursedate" required />
                                                            
                                <div class="container text-center table-responsive">
                                    <table class="table text-center" style="color: white; margin-top: 15px;">
                                        <thead>
                                            <tr style="font-weight: bold;">
                                                <td>S/N</td>
                                                <td>STUDENT NAME</td>
                                                <td>STUDENT ID</td>
                                                <td>ATTENDANCE</td>
                                            </tr>
                                        </thead>
                                        <tbody id="classtable">
                                        <?php
                                            $counter = 1; while($result = $query -> fetch()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $counter ?></td>
                                            <td><?php echo $result['studentname'] ?></td>
                                            <td><?php echo $result['studentid'] ?></td>
                                            <td><input type="checkbox" name="attStatus[]" value="<?php echo $result['studentid']; ?>" /></td>
                                        </tr>
                                        <?php
                                            $counter += 1; }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-xs-12" style="height: 15px;"></div>
                                <div class="col-xs-12" align="right">
                                    <!--<input type="submit" value="Submit Attendance" name="submitattendance" id="submitattendance" class="btn btn-primary" /> -->
                                    <button id="submitattendance" name="submitattendance" class="btn btn-primary">Submit Attendance</button>
                                </div>
                            </form>
                        </div>
                    <?php } else { echo '<h2 style="color: white;">Register a course before you can take attendance<h2>
                                        <tr align="right">
                                            <td><div class="col-xs-8"></div></td>
                                            <td><div id="registercourses" class="btn btn-primary">Register Course</div></td>
                                        </tr>';}
                    
                    } else {echo '<h2 style="color: white;">Class members will show here if any!<h2>
                                            <tr align="right">
                                                <td><div class="col-xs-8"></div></td>
                                                <td><div id="addmember" class="btn btn-primary">Add Member</div></td>
                                            </tr>';}?>
        </div>

        <?php
            $qr = $connection -> prepare('SELECT * FROM person WHERE id = :userid');
            $qr -> execute([
                'userid' => $_SESSION['student_id']
            ]);

            $repName = '';
            $attendanceFile = '';
            
            if ($qr -> rowCount() > 0) {
                while ($res = $qr -> fetch()) {
                    $repName = $res['firstname'] . ' ' . $res['middlename'];
                    $programme = strtoupper($res['program_type']);
                }
            }

            if (isset($_POST['submitattendance'])) {
                if (isset($_SESSION['class2show']) && !empty($_SESSION['class2show'])) {
                    $query = $connection -> prepare("SELECT * FROM `repnotes`.`:classtoshow`");
                    $query -> execute([
                        'classtoshow' => strtolower($_SESSION['class2show'])
                    ]);
                }              

                date_default_timezone_set('Africa/Accra');
                $genDate = date('d/m/Y');
                $genTime = date('H:i:s');

                $raw_date = filter_input(INPUT_POST, 'coursedate');

                $coursedets = filter_input(INPUT_POST, 'coursecode');                  
                $course_name = explode('=', $coursedets, 3)[0];
                $course_code = explode('=', $coursedets, 3)[1];
                $course_date = explode("-", $raw_date, 3)[2] . '/' . explode("-", $raw_date, 3)[1] . '/' . explode("-", $raw_date, 3)[0];
                $lecName = explode("=", $coursedets, 3)[2];

                $filename_date = explode("-", $raw_date, 3)[2] . '_' . explode("-", $raw_date, 3)[1] . '_' . explode("-", $raw_date, 3)[0];
                $attendanceFile = explode("_", $_SESSION['class2show'], 2)[1] . ' Att. - ' . $course_code . ' - ' . $filename_date . '.pdf';
            } ?>
            
            <?php if (isset($attendanceFile) && $attendanceFile != '') {
                if (!empty($_POST['attStatus'])) {
                    if (file_exists("../attends/$attendanceFile")) {
                        // tells the user that attendance file already exists.
                        echo "<script>alert('Attendance Error! Attendance for $course_code on $course_date already exist.');</script>";
                    } else { // else
                        // call on $pdf to create a portrait page of a size of A4
                        $pdf -> AddPage('P', 'A4');
    
                        $pdf -> SetFont('Arial', 'I', 8);
                        $pdf -> Text(8, 292, "$course_code @ $course_date");
                        $pdf -> Text(180, 292, "zeroth-exodus");
                        
                        // set the font face to Arial, underline and bolden the font, and a size to 10
                        $pdf -> SetFont('Arial', 'UB', 10);
                        $pdf -> Cell(0, 10, "$programme", 0, 10, 'C'); // creates the "COMPUTER SCIENCE 1A" heading
                        $pdf -> Cell(0, 0, "ATTENDANCE SHEET", 0, 10, 'C'); // creates the "ATTENDANCE SHEET" sub heading
                        
                        // re-set the font. this time, no underline
                        $pdf -> SetFont('Arial', 'B', 10);
                        $pdf -> Text(17, 28, 'Lecturer: '); // creates the Lecturer label
                        $pdf -> Text(140, 28, 'Lecture Date: '); // Lecture Date label
                        $pdf -> Text(17, 34, 'Date Generated: ');
                        $pdf -> Text(140, 34, 'Taken By: ');
                        $pdf -> Text(17, 40, 'Course Name: ');
                        $pdf -> Text(140, 40, 'Course Code: ');
    
                        // re-sets the font. this time, no bold
                        $pdf -> SetFont('Arial', '', 10);
                        $pdf -> Text(35, 28, $lecName); // add the Name of the Lecturer
                        $pdf -> Text(164, 28, $course_date); // adds the lecture date
                        $pdf -> Text(46, 34, $genDate . ' @ ' . $genTime); // adds the date@time at which the attendance was taken
                        $pdf -> Text(159, 34, $repName); // adds who took the attendance
                        $pdf -> Text(42, 40, $course_name); // adds the course name
                        $pdf -> Text(164, 40, $course_code); // adds the course code
    
                        // creates the head of the table
                        $pdf -> Text(17, 48, '------------------------------------------------------------------------------------------------------------------------------------------------');
                        $pdf -> Text(17, 51, '| S/N |                                      NAME OF STUDENT                                                    |        STUDENT ID       |');
                        $pdf -> Text(17, 54, '------------------------------------------------------------------------------------------------------------------------------------------------');
    
                        $y = 54; // initializing the line number
                        $sn = 1; // initializing the stockiometric number o s3 d3in d3in o
                        $page = 1;
                        $pager = 1;
    
                        $pdf -> Text(103, 292, $page);
    
                        while ($result = $query -> fetch()) {
                            foreach ($_POST['attStatus'] as $presentStudents) {
                                if ($result['studentid'] == $presentStudents) {
                                    if ($page == 1) {
                                        // this is to help create another page if a page gets full.
                                        if ($sn % 39 == 0) {
                                            $y = 10; // value of line number is initialized to 10
                                            // fill the page with the neccessary values; like the name, id and $sn of a selected student
                                            $pdf -> AddPage('P', 'A4');
                                            $page += 1;
                                            $pdf -> Text(17, 11, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            if ($sn <= 9) {
                                                $pdf -> Text(17, $y + 4, '|   ' . $sn . '   |');
                                            } elseif ($sn <= 99) {
                                                $pdf -> Text(17, $y + 4, '|  ' . $sn . '  |');
                                            } elseif ($sn >= 100) {
                                                $pdf -> Text(17, $y + 4, '| ' . $sn . ' |');
                                            }
    
                                            $pdf -> Text(30, $y + 4, '  ' . $result['studentname']);
                                            $pdf -> Text(100, $y + 4, '                                                  |         ' . $presentStudents . '        |');
                                            $pdf -> Text(17, $y + 7, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            $pdf -> SetFont('Arial', 'I', 8);
                                            $pdf -> Text(8, 292, "$course_code @ $course_date");
                                            $pdf -> Text(180, 292, "zeroth-exodus");
                                            $pdf -> SetFont('Arial', '', 10);
                                            $pdf -> Text(103, 292, $page);
    
                                            
                                            $y += 6; // this code is familiar
                                            $sn += 1; // this code is familiar
    
                                        } else {
                                            if ($sn <= 9) {
                                                $pdf -> Text(17, $y + 4, '|   ' . $sn . '   |');
                                            } elseif ($sn <= 99) {
                                                $pdf -> Text(17, $y + 4, '|  ' . $sn . '  |');
                                            } elseif ($sn >= 100) {
                                                $pdf -> Text(17, $y + 4, '| ' . $sn . ' |');
                                            }
    
                                            $pdf -> Text(30, $y + 4, '  ' . $result['studentname']);
                                            $pdf -> Text(100, $y + 4, '                                                  |         ' . $presentStudents . '        |');
                                            $pdf -> Text(17, $y + 7, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            $y += 6; // this code is familiar
                                            $sn += 1; // this code is familiar
                                        }
                                    } else {
                                        // this is to help create another page if a page gets full.
                                        if ($pager % 45 == 0) {
                                            $y = 10; // value of line number is initialized to 10
                                            // fill the page with the neccessary values; like the name, id and $sn of a selected student
                                            $pdf -> AddPage('P', 'A4');
                                            $page += 1;
                                            $pdf -> Text(17, 11, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            if ($sn <= 9) {
                                                $pdf -> Text(17, $y + 4, '|   ' . $sn . '   |');
                                            } elseif ($sn <= 99) {
                                                $pdf -> Text(17, $y + 4, '|  ' . $sn . '  |');
                                            } elseif ($sn >= 100) {
                                                $pdf -> Text(17, $y + 4, '| ' . $sn . ' |');
                                            }
    
                                            $pdf -> Text(30, $y + 4, '  ' . $result['studentname']);
                                            $pdf -> Text(100, $y + 4, '                                                  |         ' . $presentStudents . '        |');
                                            $pdf -> Text(17, $y + 7, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            $pdf -> SetFont('Arial', 'I', 8);
                                            $pdf -> Text(8, 292, "$course_code @ $course_date");
                                            $pdf -> Text(180, 292, "zeroth-exodus");
                                            $pdf -> SetFont('Arial', '', 10);
                                            $pdf -> Text(103, 292, $page);
                                            
                                            $y += 6; // this code is familiar
                                            $sn += 1; // this code is familiar
                                            $pager += 1;
    
                                        } else {
                                            if ($sn <= 9) {
                                                $pdf -> Text(17, $y + 4, '|   ' . $sn . '   |');
                                            } elseif ($sn <= 99) {
                                                $pdf -> Text(17, $y + 4, '|  ' . $sn . '  |');
                                            } elseif ($sn >= 100) {
                                                $pdf -> Text(17, $y + 4, '| ' . $sn . ' |');
                                            }
    
                                            $pdf -> Text(30, $y + 4, '  ' . $result['studentname']);
                                            $pdf -> Text(100, $y + 4, '                                                  |         ' . $presentStudents . '        |');
                                            $pdf -> Text(17, $y + 7, '------------------------------------------------------------------------------------------------------------------------------------------------');
                                            
                                            $y += 6; // this code is familiar
                                            $sn += 1; // this code is familiar
                                            $pager += 1;
                                        }
                                    }
                                }
                            }
                        }
                        
                        $pdf -> Output('F', $attendanceFile);
                        // here, we move the file from this location to the attendance-sheets folder
                        rename("$attendanceFile", "../attends/$attendanceFile");
                        $crud -> SaveAttendanceDetails($attendanceFile, $repName);
                        // alert the user of a successful attendance generation
                        echo '<script>alert("Attendance Taken!");window.location.href = "../dashboard";</script>';
                    }
                } else {echo '<script>alert("Attendance Error! No student selected!");</script>';}
            }
        ?>

        <?php
            if (isset($_POST['updatecourses'])) {
                $sn = (int) filter_input(INPUT_POST, 'snid');
                $updateCourseName = filter_input(INPUT_POST, 'coursenameEdit');
                $updateCourseCode = filter_input(INPUT_POST, 'coursecodeEdit');
                $updateLectName = filter_input(INPUT_POST, 'lecturnameEdit');
                echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            ?>
                <div class="container-fluid col-xs-6" id="UpdateCourses">
                    <form role="form">
                        <input type="hidden" name="recforup" id="recforup" value="<?php echo $sn; ?>" />

                        <div class="form-group">
                            <label for="coursecode">Course Code:</label>
                            <input type="text" class="form-control" id="updatecoursecode" name="updatecoursecode" value="<?php echo $updateCourseCode; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="coursename">Course Name:</label>
                            <input type="text" class="form-control" id="updatecoursename" name="updatecoursename" value="<?php echo $updateCourseName; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="lectname">Lecturer Name:</label>
                            <input type="text" class="form-control" id="updatelectname" name="updatelectname" value="<?php echo $updateLectName; ?>" />
                        </div>

                        <input type="submit" class="btn btn-primary form-control" value="Update Course" name="courseupdate" id="courseupdate">
                    </form>
                </div>
            <?php } else if (isset($_POST['removecourses'])) {
            $sn = (int) filter_input(INPUT_POST, 'snid');
            $updateCourseName = filter_input(INPUT_POST, 'coursenameEdit');
            echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            ?>
            <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid col-xs-12">
                <h4>This action cannot be undone!<p>Do you wish to remove <strong><?php echo $updateCourseName ?> </strong> from your registered courses?</h4>
        
                <input type="hidden" value="<?php echo $sn ?>" id="recordtoremove" />
                <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                <div name="proceedcourserem" id="proceedcourserem" class="btn btn-danger">Delete</div>
            </div>
        <?php } ?>

        <script src="../js/index.js"></script>
        <script src="index.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>