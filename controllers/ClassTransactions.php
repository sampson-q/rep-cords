<?php

    /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    include_once './CrudOperation.php';
    //require_once '../models/Person.php';
    $class = new Clas();
    $person = new Person();
    $crud = new CrudOperation();

    $repid = filter_input(INPUT_POST, 'repid');
    $classid = filter_input(INPUT_POST, 'classid');
    $repname = filter_input(INPUT_POST, 'repname');
    $memberid = filter_input(INPUT_POST, 'memberid');
    $whattodo = filter_input(INPUT_POST, 'WhatToDo');
    $classtype = filter_input(INPUT_POST, 'classtype');
    $membername = filter_input(INPUT_POST, 'membername');
    $classnamehalf = filter_input(INPUT_POST, 'classname');
    $AttendanceToMove = filter_input(INPUT_POST, 'att2move');
    $AttendanceToRemove = filter_input(INPUT_POST, 'att2rem');
    $recordtoupdate = filter_input(INPUT_POST, 'recordtoupdate');
    
    $pos = strpos($classnamehalf, "_");
    $classnamefull = '';

    if ($pos !== FALSE) { $classnamefull .= $classnamehalf; }
    else { $classnamefull .= ($_SESSION['student_id'] . '_' . $classnamehalf); }
    
    if (!empty($classnamehalf)) {
        //$class -> setRepID($_SESSION['student_id']);
        $class -> setClassNameHalf($classnamehalf);
        $class -> setClassNameFull(strtolower($classnamefull));

        if (!empty($whattodo) && $whattodo == 'add_class') {
            if ($crud -> isClassExists($class)) {
                echo 'class_exist';
            } else {
                if ($crud -> AddClass($class)) {
                    if ($crud -> AddClassDetails($class)) {
                        echo 'class_created';
                    } else {echo 'class_details !added';}
                } else {echo 'class !created';}
            }
        }

        else if (!empty($whattodo) && $whattodo == 'remove_class') {
            if ($crud -> RemoveClass($class)) {
                echo 'class_removed';
            } else {
                echo 'class !removed';
            }
        }

        else if (!empty($whattodo) && $whattodo == 'add_member') {
            $class -> setMemberID($memberid);
            $class -> setMemberName($membername);

            if (($crud -> isMemberExist($class))) {
                echo 'member_exist';
            } else {
                if ($crud -> AddClassMember($class)) {
                    echo 'member_added';
                }
            }
        }

        else if (!empty($whattodo) && $whattodo == 'update_member') {
            $class -> setMemberID($memberid);
            $class -> setMemberName($membername);

            if ($crud -> UpdateMemberDetails($class, $recordtoupdate)) {
                echo 'member_updated';
            }
        }

        else if (!empty($whattodo) && $whattodo == 'remove_member') {
            if ($crud -> RemoveMemberDetails($class, $recordtoupdate)) {
                echo 'member_removed';
            }
        }

        else if (!empty($whattodo) && $whattodo == 'share_class') {
            $person -> setID($repid);
            $class -> setRepID($repid);
            
            if ($crud -> isShareToExist($person)) {
                if ($crud -> isClassShared($person, $class)) { echo 'class_already_shared'; }
                else { 
                    if ($crud -> ShareClass($person, $class)) {
                        echo 'class_shared';
                    } else { echo 'class_unsharedd' ; }
                }
            } else { echo 'member_not_exist'; }
        }
    } else {
        if (!empty($whattodo) && $whattodo == 'unshare_class') {
            $class -> setClassID($classid);

            if ($crud -> UnshareClass($class)) {
                echo 'class_unshared';
            }
        }

        else if (isset($AttendanceToRemove) && isset($AttendanceToMove)) {
            if($crud -> RemoveAttendance($AttendanceToRemove, $AttendanceToMove)){
                echo 'attend_removed';
            }
        }
    }
    
?>