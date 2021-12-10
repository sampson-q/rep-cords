<?php
    /*
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    /**
     * Description of DashBoard
     *
     * @author Hash
     */
    include_once 'DatabaseConnection.php';
    include_once 'CrudOperation.php';
    include_once '../models/AddClass.php';

    $classname = filter_input(INPUT_POST, 'classname');
    if (!empty($classname)) {
        $AddClass = new AddClass();
        $AddClass -> setClassName($classname);

        $crud = new CrudOperation();
        if ($crud -> isClassExists($classname)) {
            if ($crud -> AddClass($AddClass)) {
                $crud -> AddClassDetails($classname);
                echo 'class_added';
            } else { echo 'add_class_error'; }
        } else { echo 'class_exists'; }
    } else { echo 'empty_class_name'; }
?>