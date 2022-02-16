<?php

    /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    include_once './CrudOperation.php';
    
    $course = new Course();
    $crud = new CrudOperation();

    // getting the values from the input post
    $courseid = filter_input(INPUT_POST, 'courseid');
    $whattodo = filter_input(INPUT_POST, 'WhatToDo');
    $coursename = filter_input(INPUT_POST, 'coursename');
    $courselect = filter_input(INPUT_POST, 'courselect');
    $coursecode = filter_input(INPUT_POST, 'coursecode');
    $coursedate = filter_input(INPUT_POST, 'coursedate');    
    
    if (!empty($coursename) && !empty($coursecode) && !empty($courselect)) {
        $course -> setCourseID($courseid);
        $course -> setCourseName($coursename);
        $course -> setCourseCode($coursecode);
        $course -> setCourseLect($courselect);
        $course -> setCourseDate($coursedate);

        if (isset($whattodo) && $whattodo == 'update_course') {
            if ($crud -> UpdateCourseDetails($course)) {
                echo 'course_updated';
            }
        }

        else if (isset($whattodo) && $whattodo == 'register_course') {
            if ($crud -> RegisterCourse($course)) {
                echo 'course_registered';
            }
        }

    } else {
        $course -> setCourseID($courseid);

        if (isset($whattodo) && $whattodo == 'unregister_course') {
            if ($crud -> UnregisterCourse($course)) {
                echo 'course_removed';
            }
        }
    }
    
?>