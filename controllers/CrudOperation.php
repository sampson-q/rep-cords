<?php

    /*
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    /**
     * Description of CrudOperation
     *
     * @author Hash
     */
    session_start();

    require_once '../models/Account.php';
    require_once 'DatabaseConnection.php';
    require_once '../models/Person.php';

    class CrudOperation {
        private $hostname;
        private $username;
        private $password;
        private $connection;

        public function __construct() {
            $this -> hostname = "localhost";
            $this -> username = 'root';
            $this -> password = '';

            $db = new DatabaseConnection($this->hostname, $this->username, $this->password);
            $this -> connection = $db -> ConnectDB();
        }

        public function login(Account $account) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM users WHERE username = :username AND password = :password");
                $query -> execute([
                    'username' => $account -> getUsername(),
                    'password' => $account -> getPassword()
                ]);

                if ($query -> rowCount() > 0) {
                    $qr = $this -> connection -> prepare("SELECT id FROM person WHERE student_email = :student_email");
                    $qr -> execute([
                        'student_email' => $account -> getUsername()
                    ]);

                    while ($result = $qr -> fetch()) {
                        $_SESSION['student_id'] = $result['id'];
                    }

                    return true;
                }
                return false;

            } catch (Exception $e) {
                //die('Error: ' . $e -> getMessage());
            }
        }

        public function confirmPassword($currentPassword) {
            $dbPass = '';
            try {
                $query = $this -> connection -> prepare("SELECT * FROM users WHERE username = :username");
                $query -> execute([
                    'username' => $_SESSION['username']
                ]);

                $result = $query -> fetchAll();
                
                foreach ($result as $res) {
                    $dbPass = $res['password'];
                }

                if ($currentPassword == $dbPass) {
                    return true;
                }

                return false;
            } catch (Exception $e) {
                //die('Error: ' . $e -> getMessage());
            }
        }

        public function createAccount(Account $account) {
            try {
                $query = $this -> connection -> prepare("INSERT INTO users(student_id, username, password) VALUES(:student_id, :username, :password)");
                $query -> execute([
                    'student_id' => $account -> getStudentId(),
                    'username' => $account -> getUsername(),
                    'password' => $account -> getPassword()
                ]);

                return true;
            } catch (Exception $e) {
                die('Error: ' . $e -> getMessage());
            }
        }

        public function savePersonDetails(Person $person) {
            try {
                $query = $this -> connection -> prepare("INSERT INTO person(id, firstname, middlename, lastname, class, program_type, user_level, student_email)
                VALUES(:student_id, :firstname, :middlename, :lastname, :class, :program_type, :user_level, :student_email)");

                $query -> execute([
                    'student_id' => $person -> getId(),
                    'firstname' => $person -> getFirstname(),
                    'middlename' => $person -> getMiddlename(),
                    'lastname' => $person -> getLastname(),
                    'class' => $person -> getClass(),
                    'program_type' => $person -> getProgram(),
                    'user_level' => $person -> getLevel(),
                    'student_email' => $person -> getStudentemail()
                ]);

                return true;
            } catch (Exception $e) {
                $error = $e -> getMessage();
                die($error);
            }
        }

        public function isUserExists($username) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM person WHERE student_email = :student_email");
                $query -> execute([
                    'student_email' => $username
                ]);

                if ($query -> rowCount() > 0) {
                    return true;
                }

                return false;
            } catch (Exception $e) {
                //die('Error: ' . $e -> getMessage());
            }
        }

        public function getPersonId($studentid) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM person WHERE id = :studentid");
                $query -> execute([
                    'studentid' => $studentid
                ]);

                if ($query -> rowCount() > 0) {
                    return true;
                }

                return false;
            } catch (Exception $e) {
                //die('Error: ' . $e -> getMessage());
            }
        }

        public function changePassword(Account $account) {
            try {
                $query = $this -> connection -> prepare("UPDATE users SET password = :password WHERE username = :username");
                $query -> execute([
                    'password' => $account -> getPassword(),
                    'username' => $account -> getUsername()
                ]);
                return true;
            } catch (Exception $e) {
                //die('Error: ' . $e -> getMessage());
            }
        }
    }