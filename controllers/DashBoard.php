<?php
    include_once 'DatabaseConnection.php';
    include_once 'CrudOperation.php';
    include_once '../models/AddClass.php';

    $classname = filter_input(INPUT_POST, 'classname');
    if (!empty($classname)) {
        $AddClass = new AddClass();
        $AddClass -> setClassName($classname);

        $crud = new CrudOperation();
        if ($crud -> AddClass($AddClass)) {
            $crud -> AddClassDetails($classname);
            echo 'class_added';
        } else {
            echo 'add_class_error';
        }
        
        // echo 'class_added';
    } else {
        echo 'empty_class_name';
    }
?>