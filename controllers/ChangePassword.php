<?php
    
    /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    include_once './CrudOperation.php';

    if(!empty(filter_input(INPUT_POST, 'currentpassword')) && !empty(filter_input(INPUT_POST, 'newpassword')) && !empty(filter_input(INPUT_POST, 'confirmnewpassword'))) {
        $currentPassword = filter_input(INPUT_POST, 'currentpassword');
        $newpassword = filter_input(INPUT_POST, 'newpassword');
        $confirmnewpassword = filter_input(INPUT_POST, 'confirmnewpassword');

        $account = new Account();
        $crud = new CrudOperation();

        if ($newpassword == $confirmnewpassword) {
            if ($crud -> passwordCheck($newpassword)) {
                if ($crud -> confirmPassword(sha1($currentPassword))) {
                    
                    $account -> setPassword(sha1($newpassword));
                    $account -> setUsername($_SESSION['username']);
                    
                    if ($crud -> changePassword($account)) {
                        $_SESSION['password_unmatched'] = 0;
                        $_SESSION['password_error'] = 0;
                        $_SESSION['password_len<8'] = 0;
                        $_SESSION['setToHome'] = 1;
                        $_SESSION['confPass'] = 'I am watching you!';
                        header ('Location: ../index.php');
                    } else {
                        echo "Password change errored!";
                    }
                } else {
                    $_SESSION['password_error'] = 1;
                    $_SESSION['password_unmatched'] = 0;
                    $_SESSION['password_len<8'] = 0;
                    header ('Location: ../index.php');
                }
            } else {
                $_SESSION['password_len<8'] = 1;
                $_SESSION['password_error'] = 0;
                $_SESSION['password_unmatched'] = 0;
                header ('Location: ../index.php');
            }
        } else {
            $_SESSION['password_error'] = 0;
            $_SESSION['password_unmatched'] = 1;
            $_SESSION['password_len<8'] = 0;
            header ('Location: ../index.php');
        }
    }
?>