<?php
    /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */
    //error_reporting(E_ERROR | E_PARSE);

    include_once './CrudOperation.php';
    $_SESSION['signup_issue'] = filter_input(INPUT_POST, 'signup_issue');
    echo $_SESSION['signup_issue'];

    if (
            !empty(filter_input(INPUT_POST, 'firstname')) &&
            !empty(filter_input(INPUT_POST, 'lastname')) &&
            !empty(filter_input(INPUT_POST, 'studentemail')) &&
            !empty(filter_input(INPUT_POST, 'studentlevel')) &&
            !empty(filter_input(INPUT_POST, 'programme')) &&
            !empty(filter_input(INPUT_POST, 'class')) &&
            !empty(filter_input(INPUT_POST, 'studentid')) &&
            !empty(filter_input(INPUT_POST, 'password')) &&
            !empty(filter_input(INPUT_POST, 'confirmpassword'))
            
        ) {
        
            $firstname = filter_input(INPUT_POST, 'firstname');
            $middlename = filter_input(INPUT_POST, 'middlename');
            $lastname = filter_input(INPUT_POST, 'lastname');
            $studentemail = filter_input(INPUT_POST, 'studentemail');
            $studentlevel = filter_input(INPUT_POST, 'studentlevel');
            $programme = filter_input(INPUT_POST, 'programme');
            $class = filter_input(INPUT_POST, 'class');
            $studentid = filter_input(INPUT_POST, 'studentid');
            $password = filter_input(INPUT_POST, 'password');

            $person = new Person();
            $person -> setId($studentid);
            $person -> setFirstname($firstname);
            $person -> setMiddlename($middlename);
            $person -> setLastname($lastname);
            $person -> setLevel($studentlevel);
            $person -> setProgram($programme);
            $person -> setClass($class);
            $person -> setStudentemail($studentemail);
            

            $account = new Account();
            $account -> setUsername($studentemail);
            $account -> setStudentId($studentid);
            $account -> setPassword(sha1($password));

            $crud = new CrudOperation();

            if ($crud -> isUserExists($studentemail)) { echo 'account_exists'; }
            else {
                if ($crud -> savePersonDetails($person)) {
                    if ($crud -> createAccount($account)) {
                        //$crud -> createClassesTable();
                        $_SESSION['signup_success'] = 1;
                        $_SESSION['signup_issue'] = '';

                        echo 'account_created';
                    } else { echo 'account_error'; }
                } else { echo 'person_error'; }
            }
    } else { echo 'empty_fields'; }
?>