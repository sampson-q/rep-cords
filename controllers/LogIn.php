<?php

    /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    include_once './CrudOperation.php';
    $_SESSION['login_issue'] = filter_input(INPUT_POST, 'login_issue');

    if (!empty(filter_input(INPUT_POST, 'username')) && !empty(filter_input(INPUT_POST, 'password'))){
        $username = filter_input(INPUT_POST, 'username');
        $password = sha1(filter_input(INPUT_POST, 'password'));
    
        $account = new Account();
        $account -> setUsername($username);
        $account -> setPassword($password);

        $person = new Person();
        $studentid = $person -> getId();

        $crud = new CrudOperation();
        if ($crud -> isUserExists($username)) {
            if ($crud -> login($account)) {
                $_SESSION['login_success'] = 1;
                $_SESSION['username'] = $username;
                $_SESSION['student_id'] = strtoupper(strstr($username, "@", true));
                $_SESSION['login_issue'] = '';

                //header("Location: ../dashboard");
                echo 'login_success';
            } else {
                /*$_SESSION['login_issue'] = '<div id="message" class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Wrong username or password!
                </div>';

                //header('Location: ../log-in');
                echo '<script>window.location.href = "../log-in";</script>';*/
                echo 'wrong_credentials';
            }
        } else {
            /*$_SESSION['login_issue'] = '<div id="message" class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Account not found!
            </div>';
            
            echo '<script>window.location.href = "../log-in";</script>';
            //header('Location: ../log-in');*/
            echo '!account';
        }
    }