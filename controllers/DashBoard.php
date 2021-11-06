<?php
    session_start();
    include_once 'DatabaseConnection.php';
    include_once 'CrudOperation.php';

    $classname = filter_input(INPUT_POST, 'classname');
    if ($classname !== '' || $classname !== null) {
        echo 'class_success';
    } else {
        echo 'empty_class_name';
    }
?>