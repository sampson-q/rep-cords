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
    require_once '../models/AddClass.php';

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

        public function isClassExists($classname) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM all_class WHERE student_id = :student_id");
                $query -> execute([
                    'student_id' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0) {
                    while ($result = $query -> fetch()) {
                        if ($result['class_names'] == $classname) {
                            return false;
                        }
                    }
                }
                
                return true;
            } catch (Exception $e) {
                die('Error: ' . $e -> getMessage());
            }
        }

        public function AddClass(AddClass $AddClass) {
            try {
                $query = $this -> connection -> prepare('CREATE TABLE `repnotes`.`:classname` ( `sn` INT(10) NOT NULL AUTO_INCREMENT , `studentname` VARCHAR(50) NOT NULL , `studentid` VARCHAR(10) NOT NULL , PRIMARY KEY (`sn`), UNIQUE `studentid` (`studentid`))');
                $query -> execute([
                    'classname' => $AddClass -> getClassName()
                ]);

                return true;
            } catch (Exception $e) {
                //
            }
        }

        public function AddClassDetails($classname) {
            try {
                $query = $this -> connection -> prepare('INSERT INTO `all_class` (`id`, `student_id`, `class_names`) VALUES (NULL, :student_id, :class_name)');
                $query -> execute([
                    'student_id' => $_SESSION['student_id'],
                    'class_name' => $classname
                ]);
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        public function RemoveClass($tablename, $classname) {
            try {
                $removetablequery = $this -> connection -> prepare('DROP TABLE IF EXISTS `repnotes`.`:classremove`');
                $removetablequery -> execute([
                    'classremove' => strtolower($tablename)
                ]);

                $removefromlistquery = $this -> connection -> prepare('DELETE FROM all_class WHERE student_id = :student_id AND class_names = :class_names');
                $removefromlistquery -> execute([
                    'student_id' => strtoupper($_SESSION['student_id']),
                    'class_names' => $classname
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error ' . $e -> getMessage());
            }
        }

        public function isMemberExist($memberid, $classname) {
            try {
                $query = $this -> connection -> prepare('SELECT * FROM '. $classname .' WHERE studentid = ' . $memberid);

                if ($query -> rowCount() > 0) {
                    return false;
                }

                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        public function AddClassMember($studentid, $studentname, $studentclass) {
            try {
                $query = $this -> connection -> prepare('INSERT INTO `:student_class` (`sn`, `studentname`, `studentid`) VALUES (NULL, :student_name, :student_id)');
                $query -> execute([
                    'student_class' => $studentclass,
                    'student_name' => $studentname,
                    'student_id' => $studentid
                ]);
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }
    }