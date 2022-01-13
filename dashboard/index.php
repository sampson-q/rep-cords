<?php
    session_start();
    $_SESSION['signup_success'] = '';

    require_once '../controllers/DatabaseConnection.php';
    if (empty($_SESSION['login_success']) || $_SESSION['login_success'] == 0) {
        $_SESSION['session_timeout'] = 1;
        echo '<script>window.location.href = "../index.php";</script>';
    }

    $db = new DatabaseConnection('localhost', 'root', '');
    $connection = $db -> ConnectDB();

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
               
                <div id="addclass" class="btn col-xs-3" style="font-size: 25px; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                    Add Class
                </div>

                <div class="col-xs-1" align="center"></div>
                
                <div id="viewclass" name="viewclass" class="btn col-xs-3" style="font-size: 25px; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                    View Class
                </div>

                <div class="col-xs-1" align="center"></div>

                <div id="shared-class" class="btn col-xs-3" style="font-size: 25px; color: white; box-shadow: 0px 0px 1px #ccc;">
                    Exp. Class
                </div>
            </div>
            
            <div class="col-xs-12" style="height: 30px;"></div>
            
            <div class="col-xs-12">
                
                <div id="inheritted-class" class="btn col-xs-3" style="font-size: 25px; color: white; box-shadow: 0px 0px 1px #ccc;" align="">
                    Imp. Class
                </div>

                <div class="col-xs-1" align="center"></div>
                
                <div id="viewclass" name="viewclass" class="btn col-xs-3" style="font-size: 24px; color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                    View Attend.
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
                                                <td><?php echo $result['class_names']; ?></td>
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

        <div style="display: none;" class="container-fluid col-xs-6" id="ViewClassContents">
            <?php
                if (isset($_POST['viewclassmembers'])){
                    echo '<script>document.getElementById("ViewClassContents").style = "display: block;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
            
                    $class2operate = filter_input(INPUT_POST, 'class2operate');

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
                                                <input type="hidden" id="class_shared0" name="class_shared0" value="<?php echo $result['class_names']?>" />
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

        <div style="display: none;" class="container-fluid col-xs-6" id="ViewAttendance">
            <?php
                if (isset($_POST['vattendance'])) {
                    $ClassType = filter_input(INPUT_POST, 'attendance-class');
                    echo '<script>document.getElementById("ViewAttendance").style = "display: block;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';

                    $query = $connection -> prepare('SELECT * FROM all_attendance WHERE class_names = :classname');
                    $query -> execute([
                        'classname' => $ClassType
                    ]);
                    
                    if ($query -> rowCount() > 0) { ?>
                        <div style="color: white;">
                            <div id="table-header-div" class="">
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
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr align="center">
                                            <td><?php echo $counter; ?></td>
                                            <td width="500"><?php echo $result['attend_names']; ?></td>
                                            <td><?php echo $result['taken_by']; ?></td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="sn" id="sn" value="<?php echo $result['id']; ?>" />
                                                <td><input id="updatemember" name="updatemember" type="submit" id="tableButton" class="btn btn-success" value="View" /></td>
                                                <td><input id="removemember" name="removemember" type="submit" id="tableButton"class="btn btn-danger" value="Delete" /></td>
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
                        <?php } else { echo '<h2 style="color: white;">Attendances will show here<h2>
                                            <tr align="right">
                                                <td><div class="col-xs-8"></div></td>
                                                <td><div id="takeattendance" class="btn btn-primary">Take Attendance</div></td>
                                            </tr>';}
                }
            ?>
        </div>

        <script src="../js/index.js"></script>
        <script src="index.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>