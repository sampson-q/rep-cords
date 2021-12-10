<?php
    
    include_once '../controllers/CrudOperation.php';
    $classtoremove = filter_input(INPUT_POST, 'ClasstoDelete');
    $classname = filter_input(INPUT_POST, 'ClassName');
    $classforadd = filter_input(INPUT_POST, 'classforadd');
    $personforadd = filter_input(INPUT_POST, 'personforadd');
    $personidforadd = filter_input(INPUT_POST, 'personidforadd');

    $crud = new CrudOperation();
    if (isset($classname) && isset($classtoremove)) {
        if ($crud -> RemoveClass($classtoremove, $classname)) {
            echo 'class_removed';
        }
    } else if (isset($classforadd) && isset($personforadd) && isset($personidforadd)) {
        if ($crud -> isMemberExist($personidforadd, $classforadd)) {
            $crud -> AddClassMember($personidforadd, $personforadd, $classforadd);
            echo 'member_added';
        } else { echo 'member_exists'; }
    }
    //echo 'class_removed';
?>