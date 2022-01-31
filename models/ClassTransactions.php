<?php
    
    include_once '../controllers/CrudOperation.php';
    $classtoremove = filter_input(INPUT_POST, 'ClasstoDelete');
    $classname = filter_input(INPUT_POST, 'ClassName');
    
    $classforadd = filter_input(INPUT_POST, 'classforadd');
    $personforadd = filter_input(INPUT_POST, 'personforadd');
    $personidforadd = filter_input(INPUT_POST, 'personidforadd');
    
    $classforupdate = filter_input(INPUT_POST, 'classforupdate');
    $personforupdate = filter_input(INPUT_POST, 'personforupdate');
    $personidforupdate = filter_input(INPUT_POST, 'personidforupdate');
    $recordtoupdate = filter_input(INPUT_POST, 'recordtoupdate');

    $recordtoremove = filter_input(INPUT_POST, 'recordtoremove');
    $class4remove = filter_input(INPUT_POST, 'class4remove');

    $classunshare = filter_input(INPUT_POST, 'classunshare');

    $ToShare = filter_input(INPUT_POST, 'share22');
    $ShareTo = filter_input(INPUT_POST, 'share2');
    
    $CourseName = filter_input(INPUT_POST, 'cname');
    $CourseCode = filter_input(INPUT_POST, 'ccode');
    $LecturerNa = filter_input(INPUT_POST, 'lname');

    $UpdateCourseCode = filter_input(INPUT_POST, 'coursecodeupdate');
    $UpdateCourseName = filter_input(INPUT_POST, 'coursenameupdate');
    $UpdateLectName = filter_input(INPUT_POST, 'lectnameupdate');
    $RecordForUpdate = filter_input(INPUT_POST, 'recordforupdate');

    $Course2Unregister = filter_input(INPUT_POST, 'coursetoremove');

    $AttendName = filter_input(INPUT_POST, 'attend_name');
    $RepName = filter_input(INPUT_POST, 'rep_name');

    $AttendanceToRemove = filter_input(INPUT_POST, 'att2rem');
    $AttendanceToMove = filter_input(INPUT_POST, 'att2move');
    
    $crud = new CrudOperation();

    // removing of a class
    if (isset($classname) && isset($classtoremove)) {
        if ($crud -> RemoveClass($classtoremove, $classname)) {
            echo 'class_removed';
        }
    }
    
    // add member to a class
    else if (isset($classforadd) && isset($personforadd) && isset($personidforadd)) {
        if ($crud -> isMemberExist($personidforadd, $classforadd)) {
            $crud -> AddClassMember($personidforadd, $personforadd, $classforadd);
            echo 'member_added';
        } else { echo 'member_exists'; }
    }
    
    // update member details
    else if (isset($classforupdate) && isset($personforupdate) && isset($personidforupdate) && isset($recordtoupdate)) {
        if ($crud -> UpdateMemberDetails($classforupdate, $personforupdate, $personidforupdate, $recordtoupdate)) {
            echo 'member_updated';
        }
    }

    // update course details
    else if (isset($UpdateCourseCode)) {
        if ($crud -> UpdateCourseDetails($UpdateCourseName, $UpdateCourseCode, $UpdateLectName, $RecordForUpdate)) {
            echo 'class_update_success';
        }
    }

    // remove member from a class
    else if (isset($recordtoremove) && isset($class4remove)) {
        if ($crud -> RemoveMemberDetails($class4remove, $recordtoremove)) {
            echo 'member_removed';
        }
    }

    // unshare a class
    else if (isset($classunshare)) {
        if ($crud -> UnshareClass($classunshare)) {
            echo 'class_unshared';
        }
    }
    
    // unregister a course
    else if (isset($Course2Unregister)) {
        if ($crud -> UnregisterCourse($Course2Unregister)) {
            echo 'course_unregistered';
        }
    }

    // share a class
    else if (isset($ShareTo) && isset($ToShare)) {
        if ($crud -> isShareToExist($ShareTo)) {
            if ($crud -> isClassShared($ShareTo, $ToShare)) { echo 'class_already_shared'; }
            else { 
                if ($crud -> ShareClass($ShareTo, $ToShare)) {
                    echo 'class_shared';
                } else { echo 'class_unsharedd' ; }
            }
        } else { echo 'member_not_exist'; }
    }

    // register courses ... remember to add isCourseRegistered
    else if (isset($CourseCode) && isset($CourseName) && isset($LecturerNa)) {
        $crud -> RegisterCourses($CourseCode, $CourseName, $LecturerNa);
        echo 'courses_registered';
    }

    // save attendance details
    else if (isset($AttendName) && isset($RepName)) {
        $crud -> SaveAttendanceDetails($AttendName, $RepName);
        echo 'attend_saved';
    }

    else if (isset($AttendanceToRemove) && isset($AttendanceToMove)) {
        $crud -> RemoveAttendance($AttendanceToRemove, $AttendanceToMove);
        echo 'attend_removed';
    }
?>