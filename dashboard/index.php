<?php
    //session_start();
    $_SESSION['signup_success'] = '';

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

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        
        <link href="../css/index.css" rel="stylesheet" type="text/css" />
        <link href="index.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="../dashboard">rep_cords <i class="far fa-clipboard"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse justify-content-end">
                    <span class="navbar-text" id="navar"></span>
                </div>
                
                <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../dashboard"><i class="fas fa-home"></i> Home</a>
                        </li>
                                                                
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?php echo $_SESSION['student_id']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../controllers/LogOut.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Profile Settings</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-secret"></i> Set Security Question</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="../controllers/LogOut.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="col-sm-3"></div>
        
        <div class="col-sm-5 container" style="margin-top: 80px;">
            
            <div id="DashHome" class="align-self-center" style="">
                
                <div class="row">
                    <div id="addclass" class="btn col align-self-start" style="color: white; box-shadow: 0px 0px 1px #ccc;">
                        <p class="h6">Create Classes</p>
                    </div>

                    <div class="col"></div>
                    
                    <div id="inheritted-class" class="btn col align-self-start" style="color: white; box-shadow: 0px 0px 1px #ccc;">
                        <p class="h6">Imported Class</p>
                    </div>

                    <div class="col"></div>

                    <div id="shared-class" class="btn col align-self-end" style="color: white; box-shadow: 0px 0px 1px #ccc;">
                    <p class="h6">Exported Class</p>
                    </div>
                </div>

                <div class="col-xs-12" style="height: 30px;"></div>

                <div class="row">
                    <div id="viewclass" class="btn col align-self-center" style="color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                        <p class="h6">View Classes</p>
                    </div>

                    <div class="col"></div>
                    
                    <div id="showatt" name="viewclass" class="btn col align-self-center" style="color: white; box-shadow: 0px 0px 1px #ccc;" align="center">
                    <p class="h6">View Attendance</p>
                    </div>

                    <div class="col"></div>

                    <div id="courses" class="btn col align-self-end" style="color: white; box-shadow: 0px 0px 1px #ccc;">
                    <p class="h6">View Courses</p>
                    </div>
                </div>

            </div>

            <div style="display: none;" class="container" id="AddClassForm">
                <form role="form">
                    <div class="mb-2">
                        <label for="classname">Class Name:</label>
                        <input type="text" class="form-control mt-2" id="addclassname" placeholder="Enter Class Name" name="addclassname" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Add Class" id="addclassbutton" name="addclassbutton"/>
                </form>
            </div>

            <div style="display: none;" class="container-fluid col-xs-6" id="ViewClassPage">
                <?php
                    $query = $connection -> prepare("SELECT * FROM `all_class` WHERE student_id = :userId");
                    $query -> execute([
                        'userId' => $_SESSION['student_id']
                    ]);

                    if ($query -> rowCount() > 0) { ?>
                        <div class="cont">
                            <table class="table table-responsive-sm" style="color: white;">
                                <thead class="table-dark">
                                    <tr align="">
                                        <th class="header" scope="col">S/N</th>
                                        <th class="header" scope="col">CLASS</th>
                                        <th class="header" scope="col">OPTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr>
                                            <form action="" method="POST" role="form">
                                                <input type="hidden" value="<?php echo $result['class_names'] ?>" name="classname" id="classname" />
                                                <td><?php echo $counter; ?></td>
                                                <td width=""><?php echo $result['class_names']; ?></td>
                                                <td>
                                                    <button id="viewclassmembers" name="viewclassmembers" class="btn btn-success"><span class="far fa-eye"></span></button>
                                                    <button id="deleteclass" name="deleteclass" class="btn btn-danger"><span class="fas fa-minus-circle"></span></button>
                                                </td>
                                                
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                <tbody>
                            </table>
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
                        
                        $classname = filter_input(INPUT_POST, 'classname');
                        $_SESSION['class2show'] = $classname;
                        $pos = strpos($_SESSION['class2show'], "_");
                        $class2show = '';

                        if ($pos !== FALSE) { $class2show .= $_SESSION['class2show']; }
                        else {$class2show .= ($_SESSION['student_id'] . '_' . $_SESSION['class2show']);}
                        
                        $query = $connection -> prepare("SELECT * FROM `repnotes`.`:classtoshow`");
                        $query -> execute([
                            'classtoshow' => strtolower($class2show)
                        ]);

                        if ($query -> rowCount() > 0) { ?>
                        <div style="color: white;">
                            <div id="table-header-div" class="">
                                <form action="" method="POST">
                                    
                                    <script>document.getElementById('navar').innerHTML = "<span class='h6'><?php echo $classname ?></span>";</script>
                                    <input type="hidden" value="<?php echo $_SESSION['student_id'] . '_' . $_SESSION['class2show'] ?>" id="attendance-class" name="attendance-class" />
                                    
                                    
                                        <input class="form-control me-2" type="text" placeholder="Search">
                                        <button class="btn btn-primary" type="button">Search</button>
                                    
                                   
                                        <button class="btn btn-secondary" id="vattendance" name="vattendance"><span class="fas fa-book-reader"></span></button>
                                            
                                        
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
                                    <!--<div id="addmember" class="btn btn-primary">Add Member</div>-->
                                    <form method="POST">
                                        <input type="submit" name="addmember" id="addmember" class="btn btn-primary" value="Add Member" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } else { echo '<h2 style="color: white;">Class members will show here if any!<h2>
                                            <tr align="right">
                                                <td><div class="col-xs-8"></div></td>
                                                <td>
                                                    <form method="POST">
                                                        <input type="submit" name="addmember" id="addmember" class="btn btn-primary" value="Add Member" />
                                                    </form>
                                                </td>
                                            </tr>';}
                    } else if (isset($_POST['deleteclass'])) { 
                        echo '<script>document.getElementById("ViewClassContents").style = "display: block;";</script>';
                        echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                        
                        $classname = filter_input(INPUT_POST, 'classname');
                        ?>
                    
                        <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid">
                        <script>document.getElementById('navar').innerHTML = "<span class='h6'>Confirm Delete \"<?php echo strtoupper($classname); ?>\"</span>";</script>
                            <h4>This action cannot be undone! Do you wish to remove <?php echo strtoupper($classname) ?>?</h4>
                            <input type="hidden" value="<?php echo $classname ?>" id="class2rem" />
                            <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                            <div name="proceedclassremov" id="proceedclassremov" class="btn btn-danger">Delete</div>
                        </div>
                    <?php } ?>
            </div>

            <div style="display: none;" class="container-fluid col-xs-6" id="AddClassMembers">
                <?php if (isset($_POST['addmember'])) {
                    echo '<script>document.getElementById("AddClassMembers").style = "display: block;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                    ?>
                    <form role="form" method="POST">
                        <script>document.getElementById('navar').innerHTML = "<span class='h6'>Add Class Member</span>";</script>
                        <div class="form-group mb-3">
                            <label for="addstudentid">Student ID :</label>
                            <input type="text" class="form-control" id="addstudentid" placeholder="Student ID" name="addstudentid" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="addstudentname">Student Name:</label>
                            <input type="text" class="form-control" id="addstudentname" placeholder="Student Name" name="addstudentname" required>
                        </div>
                        <input type="hidden" value="<?php echo strtolower($_SESSION['class2show']) ?>" id="memberaddclass" />
                        <div class="btn btn-primary" id="addmemberbutton" name="addmemberbutton">Add Member</div>
                    </form>
                <?php } ?>
            </div>

            <div style="display: none;" class="container-fluid col-xs-6" id="ViewAttendance">
                <?php
                    if (isset($_POST['vattendance'])) {
                        $ClassType = filter_input(INPUT_POST, 'attendance-class');
                        $Container = filter_input(INPUT_POST, 'container');
                        echo '<script>document.getElementById("ViewAttendance").style = "display: ;";</script>';
                        echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';

                        $query = $connection -> prepare('SELECT * FROM all_attendance WHERE class_names = :classname');
                        $query -> execute([
                            'classname' => $ClassType
                        ]);
                        
                        if ($query -> rowCount() > 0) { ?>
                            <div style="color: white;">
                                <div id="table-header-div" class="">
                                    <h3 align="center" style="color: white;">Attendances for <?php echo $_SESSION['class2show']; ?></h3>
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
            </div>

            <div style="display: none;" class="" id="TakeAttendance">
                <?php
                    $qr = $connection -> prepare('SELECT * FROM registered_courses WHERE student_id = :userid');
                    
                    if (isset($_SESSION['class2show']) && !empty($_SESSION['class2show'])) {
                        
                        $pos = strpos($_SESSION['class2show'], "_");
                        $class2show = '';

                        if ($pos !== FALSE) { $class2show .= $_SESSION['class2show']; }
                        else {$class2show .= ($_SESSION['student_id'] . '_' . $_SESSION['class2show']);}

                        $query = $connection -> prepare("SELECT * FROM `repnotes`.`:classtoshow`");
                        $query -> execute([
                            'classtoshow' => strtolower($class2show)
                        ]);
                    }
                    $qr -> execute([
                        'userid' => $_SESSION['student_id']
                    ]);

                    if ($query -> rowCount() > 0 ) {
                        if ($qr -> rowCount() > 0) { ?>
                            <div class="container-fluid col-xs-6">
                                <form method="POST">
                                    <select style="margin-top: 12px;" class="" id="coursecode" name="coursecode" required>
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
                        <?php } else { echo '<h2 style="color: white;">Register a course to take attendance<h2>
                                            <tr align="right">
                                                <td><div class="col-xs-8"></div></td>
                                                <td><form method="POST"><input type="submit" id="registercourses" name="registercourses" value="Register Courses" class="btn btn-primary"></form></td>
                                            </tr>';}
                        
                        } else {echo '<h2 style="color: white;">Class members will show here if any!<h2>
                                                <tr align="right">
                                                    <td><div class="col-xs-8"></div></td>
                                                    <td><div id="addmember" class="btn btn-primary">Add Member</div></td>
                                                </tr>';}?>
            </div>

            <div style="display: none;" class="" id="SharedClasses">
                <?php
                    $query = $connection -> prepare("SELECT * FROM `shared_classes` WHERE shared_by = :userId");
                    $query -> execute([
                        'userId' => $_SESSION['student_id']
                    ]);

                    if ($query -> rowCount() > 0) { ?>
                        <div class="cont">
                            <table class="table table-responsive-sm" style="color: white;">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="header" scope="col">S/N</th>
                                        <th class="header" scope="col">CLASS</th>
                                        <th class="header" scope="col">TARGET</th>
                                        <th class="header" scope="col">OPTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr>
                                            <form action="" method="POST" role="form">
                                                <input type="hidden" value="<?php echo $result['id'] ?>" name="class2unshare" id="class2unshare"/>
                                                <input type="hidden" value="<?php echo $result['shared_to'] ?>" name="person2unshare" id="person2unshare" />
                                                <input type="hidden" value="<?php echo $result['class_names'] ?>" name="classunsharename" id="classunsharename" />
                                                <td align="center"><?php echo $counter; ?></td>
                                                <td width="500"><?php echo $result['class_names']; ?></td>
                                                <td><?php echo $result['shared_to']; ?></td>
                                                <td align="center"><span id="unshareclass" name="unshareclass" class="fas btn fa-minus-circle"></span></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                <tbody>
                            </table>
                        </div>
                        <div class="col-xs-12 mt-2" align="right">
                            <div id="shareaclass" class="btn btn-primary">Share A Class</div>
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
                        <div class="cont">
                            <table class="table table-responsive-sm" style="color: white;">
                                <thead class="table-dark">
                                    <tr align="">
                                        <th class="header" scope="col">S/N</th>
                                        <th class="header" scope="col">CLASS</th>
                                        <th class="header" scope="col">OPTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr>
                                            <form action="" method="POST" role="form">    
                                                <input type="hidden" value="<?php echo $result['class_names']; ?>" id="sharethisclass" name="sharethisclass" />
                                                <td><?php echo $counter; ?></td>
                                                <td><?php echo $result['class_names']; ?></td>
                                                
                                                <td><input id="shareclass" name="shareclass" type="submit" class="btn btn-success" value="Share" /></td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                <tbody>
                            </table>
                        </div>
                    <?php } else { echo '<h2 style="color: white;">Your classes will show here if you have any!<h2>
                                        <tr align="right">
                                            <td><div class="col-xs-8"></div></td>
                                            <td><div id="classadd" class="btn btn-primary">Add Class</div></td>
                                        </tr>'; }
                ?>
            </div>

            <div style="display: none;" class="" id="import-classes">
                <?php
                    $query = $connection -> prepare("SELECT * FROM `shared_classes` WHERE shared_to = :userId");
                    $query -> execute([
                        'userId' => $_SESSION['student_id']
                    ]);

                    if ($query -> rowCount() > 0) { ?>
                        <div class="container">
                            <table class="table table-responsive-sm" style="color: white;">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="header" scope="col">S/N</th>
                                        <th class="header" scope="col">CLASS</th>
                                        <th class="header" scope="col">OWNER</th>
                                        <th class="header" scope="col">OPTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; while ($result = $query -> fetch()) { ?>
                                        <tr>
                                            <form action="" method="POST" role="form">
                                                <td align="center"><?php echo $counter; ?></td>
                                                <td width="500"><?php echo $result['class_names']; ?></td>
                                                <td><?php echo $result['shared_by']; ?></td>
                                                <input type="hidden" name="sn0" id="sn0" value="<?php echo $result['id']?>" />
                                                <input type="hidden" id="classname" name="classname" value="<?php echo $result['shared_by'] . '_' . $result['class_names'];?>" />
                                                <input type="hidden" id="class_shared0" name="class_shared0" value="<?php echo $result['class_names'];?>" />
                                                <td align="center">
                                                    <button id="viewclassmember" name="viewclassmembers" class="btn btn-success"><span class="far fa-eye"></span></button>
                                                    <button id="undoshare" name="undoshare" class="btn btn-danger"><span class="fas fa-minus-circle"></span></button>
                                                </td>
                                            </form>
                                        </tr>
                                    <?php $counter += 1; } ?>
                                <tbody>
                            </table>
                        </div>
                    <?php } else { echo '<h2 align="center" style="color: white;">Classes shared to you will appear here<h2>'; }
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
                                <form method="POST"><input type="submit" id="registercourses" name="registercourses" value="Register Courses" class="btn btn-primary"></form>
                                </div>
                            </div>
                        </div>
                    <?php } else { echo '<h2 style="color: white;">You have not registered any courses yet<h2>
                                            <tr align="right">
                                                <td><div class="col-xs-8"></div></td>
                                                <td><form method="POST"><input type="submit" id="registercourses" name="registercourses" value="Register Courses" class="btn btn-primary"></form></td>
                                            </tr>';}?>
            </div>

            <div style="display: none;" class="container-fluid col-xs-6" id="RegisterCourses">
                <fom role="">
                    <div class="form-group">
                        <label for="courseCode">Course Code:</label>
                        <input type="text" class="form-control" id="courseCode" placeholder="Course Code" required>
                    </div>

                    <div class="form-group">
                        <label for="coursename">Course Name:</label>
                        <input type="text" class="form-control" id="coursename" placeholder="Course Name" required>
                    </div>

                    <div class="form-group">
                        <label for="lEctName">Lecturer Name:</label>
                        <input type="text" class="form-control" id="lEctName" placeholder="Lecturer Name" required>
                    </div>

                    <input type="submit" class="btn btn-primary form-control" value="Register Course" name="registercoursebutton" id="registercoursebutton"> 
                </form>
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

            <?php
                if (isset($_POST['updatemember'])) {
                    $sn = filter_input(INPUT_POST, 'sn');
                    $id2operate = filter_input(INPUT_POST, 'id2operate');
                    $name2operate = filter_input(INPUT_POST, 'name2operate');
                    $backupname = $name2operate; $backupid = $id2operate;
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                ?>
                <div class="container-fluid col-xs-6" id="Individuals">
                    <script>document.getElementById('navar').innerHTML = '<span class="h6">Update Member Details</span>';</script>
                    <form role="form">
                        <input type="hidden" name="memberupdateclass" id="memberupdateclass" value="<?php echo $_SESSION['class2show'];?>" />
                        <input type="hidden" name="backupname" id="backupname" value="<?php echo $backupname?>" />
                        <input type="hidden" name="backupid" id="backupid" value="<?php echo $backupid?>" />
                        <input type="hidden" name="sntoupdate" id="sntoupdate" value="<?php echo $sn ?>" />
                        <div class="form-group mb-3">
                            <label for="addstudentid">Student ID :</label>
                            <input type="text" class="form-control" id="updatestudentid" value="<?php echo $id2operate ?>" name="addstudentid" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="addstudentname">Student Name:</label>
                            <input type="text" class="form-control" id="updatestudentname" value="<?php echo $name2operate ?>" name="addstudentname" required>
                        </div>
                        <input type="submit" class=" btn btn-primary" value="Update" id="update" name="update"/>
                    </form>
                </div>
                <?php } else if (isset($_POST['removemember'])) {
                    $sn = filter_input(INPUT_POST, 'sn');
                    $name2operate = filter_input(INPUT_POST, 'name2operate');
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                    ?>
                    <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid col-xs-12">
                        <h4>This action cannot be undone!<p>Do you wish to remove <strong><?php echo $name2operate ?> </strong> from <strong><?php echo $_SESSION['class2show']; ?></strong>?</h4>
                        <input type="hidden" value="<?php echo $_SESSION['class2show'];?>" id="class2delete" name="class2delete" />
                        <input type="hidden" value="<?php echo $sn ?>" id="recordtoremove" />
                        <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                        <div name="proceedmemremov" id="proceedmemremov" class="btn btn-danger">Delete</div>
                    </div>
            <?php } ?>

            <?php
                if (isset($_POST['unshareclass'])) {
                    $class2unshare = filter_input(INPUT_POST, 'class2unshare');
                    $person2unshare = filter_input(INPUT_POST, 'person2unshare');
                    $classunsharename = filter_input(INPUT_POST, 'classunsharename');
                    echo '<script>document.getElementById("SharedClasses").style = "display: none;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                ?>

                <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid col-xs-12">
                    <script>document.getElementById('navar').innerHTML = "<span class='h6'>Confirm Detach \"<?php echo $person2unshare; ?>\" from \"<?php echo $classunsharename; ?>\"</span>";</script>
                    <h4><strong><?php echo $person2unshare; ?></strong> will no longer have access to <strong><?php echo $classunsharename; ?></strong></h4>
                    <p>Do you wish to continue?</p>
                    
                    <input type="hidden" value="<?php echo $class2unshare; ?>" id="classtounshare" name="classtounshare" />
                    <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                    <div name="proceedunshare" id="proceedunshare" class="btn btn-danger">Detach</div>
                </div>
            <?php } ?>

            <?php
                $qr = $connection -> prepare('SELECT * FROM person WHERE id = :userid');
                $qr -> execute([
                    'userid' => $_SESSION['student_id']
                ]);

                $repName = '';
                $attendanceFile = '';
                
                if ($qr -> rowCount() > 0) {
                    while ($res = $qr -> fetch()) {
                        if ($res['middlename'] == '') { $repName = $res['firstname'] . ' ' . $res['lastname']; }
                        else { $repName = $res['firstname'] . ' ' . $res['middlename']; }
                        
                        $programme = strtoupper($res['program_type']);
                    }
                }

                if (isset($_POST['submitattendance'])) {
                    if (isset($_SESSION['class2show']) && !empty($_SESSION['class2show'])) {
                        $query = $connection -> prepare("SELECT * FROM `repnotes`.`:classtoshow`");
                        
                        $pos = strpos($_SESSION['class2show'], "_");
                        $class2show = '';

                        if ($pos !== FALSE) { $class2show .= $_SESSION['class2show']; }
                        else {$class2show .= ($_SESSION['student_id'] . '_' . $_SESSION['class2show']);}

                        $query -> execute([
                            'classtoshow' => strtolower($class2show)
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
                    $attendanceFile = $_SESSION['class2show'] . ' Att. - ' . $course_code . ' - ' . $filename_date . '.pdf';
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
                if (isset($_POST['shareclass'])) {
                    $sharethisclass = filter_input(INPUT_POST, 'sharethisclass');
                    echo '<script>document.getElementById("SharedClasses").style = "display: none;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                ?>

                <div style="color: white; text-align: center; display: block;" id="alert-box" class="">
                <script>document.getElementById('navar').innerHTML = "<span class='h6'>Share Class</span>";</script>
                    <div id="sharetowho" class="container-fluid col-xs-6">
                        <form role="form" method="POST" action="">
                            <div class="form-group mb-3">
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

            <?php
                if (isset($_POST['undoshare'])) {
                    $class2unshare = filter_input(INPUT_POST, 'sn0');
                    $classunsharename = filter_input(INPUT_POST, 'class_shared0');
                    echo '<script>document.getElementById("ViewSharedClasses").style = "display: none;";</script>';
                    echo '<script>document.getElementById("DashHome").style = "display: none;";</script>';
                ?>

                    <div style="color: white; text-align: center; display: block;" id="alert-box" class="container-fluid col-xs-12">
                        <script>document.getElementById('navar').innerHTML = "<span class='h6'>Confirm Detach from \"<?php echo $classunsharename; ?>\" </span>";</script>
                        <h4>You will no longer have access to <strong><?php echo $classunsharename ?></strong></h4>
                        <p>Do you wish to continue?</p>
                        
                        <input type="hidden" value="<?php echo $class2unshare ?>" id="classtounshare" name="classtounshare" />
                        <div id="cancelclassremove" class="btn btn-primary">Cancel</div>
                        <div name="proceedunshare" id="proceedunshare" class="btn btn-danger">Detach Me</div>
                    </div>
            <?php } ?>

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

            <?php
                if (isset($_POST['registercourses'])) {
                    echo "<script>document.getElementById('RegisterCourses').style.display = 'block';</script>";
                    echo "<script>document.getElementById('Courses').style.display = 'none';</script>";
                    echo "<script>document.getElementById('DashHome').style.display = 'none';</script>";
                }
            ?>
        </div>

        <script src="../js/index.js"></script>
        <script src="index.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>