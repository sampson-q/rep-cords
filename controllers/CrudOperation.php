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

        public function UpdateMemberDetails($classforupdate, $studentname, $studentid, $recordforupdate) {
            try {
                $query = $this -> connection -> prepare("UPDATE `repnotes`.`:classname` SET `studentname` = :studentname, `studentid` = :studentid WHERE `:classname`.`sn` = :r");
                $query -> execute([
                    'classname' => $classforupdate,
                    'studentname' => $studentname,
                    'studentid' => $studentid,
                    'r' => $recordforupdate
                ]);

                return true;
            } catch (Exception $e) {
                //die ('Error: ' . $e -> getMessage());
            }
        }

        // update course details
        public function UpdateCourseDetails($coursenameEdit, $coursecodeEdit, $lectnameEdit, $recforup) {
            try {
                $query = $this -> connection -> prepare("UPDATE `registered_courses` SET `courses_code` = :coursecode, `courses_name` = :coursename, `lecturer_name` = :lectname WHERE `registered_courses`.`id` = :idchange;");
                //$query = $this -> connection -> prepare("UPDATE registered_courses SET courses_code = :coursecode, courses_name = :coursename, lecturer_name = :lectname WHERE id = :idchange");
                $query -> execute([
                    'coursecode' => $coursecodeEdit,
                    'coursename' => $coursenameEdit,
                    'lectname' => $lectnameEdit,
                    'idchange' => $recforup
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        public function RemoveMemberDetails($class4remove, $record4remove) {
            try {
                $query = $this -> connection -> prepare('DELETE FROM `repnotes`.`:class4remove` WHERE `:class4remove`.`sn` = :record');
                $query -> execute([
                    'class4remove' => $class4remove,
                    'record' => $record4remove
                ]);
                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // unshare a class by its id
        public function UnshareClass($class4unshare) {
            try {
                $query = $this -> connection -> prepare('DELETE FROM `repnotes`.`shared_classes` WHERE `shared_classes`.`id` = :unshare');
                $query -> execute([
                    'unshare' => $class4unshare
                ]);
                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        public function ShareClass($ShareTo, $ToShare) {
            try {
                $query = $this -> connection -> prepare('INSERT INTO `shared_classes` (`id`, `shared_by`, `shared_to`, `class_names`) VALUES (NULL, :sharedby, :sharedto, :class4share)');
                $query -> execute([
                    'sharedby' => $_SESSION['student_id'],
                    'sharedto' => $ShareTo,
                    'class4share' => $ToShare
                ]);
                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // unsahre class to all users that it has been shared to
        public function UnshareClass0($classname) {
            try {
                $query = $this -> connection -> prepare('DELETE FROM `repnotes`.`shared_classes` WHERE shared_by = :sharedby AND class_names = :classname');
                $query -> execute([
                    'sharedby' => $_SESSION['student_id'],
                    'classname' => $classname
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // has this class been shared to any user?
        public function isClassShared0($classname) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM shared_classes WHERE shared_by = :sharedby AND class_names = :classname");
                $query -> execute([
                    'sharedby' => $_SESSION['student_id'],
                    'classname' => $classname
                ]);

                if ($query -> rowCount() > 0) {
                    return true;
                }
                return false;
            } catch (Exeception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // is class already shared to a specific user?
        public function isClassShared($ShareTo, $ToShare) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM shared_classes WHERE shared_by = :sharedby AND shared_to = :sharedto AND class_names = :toshare");
                $query -> execute([
                    'sharedby' => $_SESSION['student_id'],
                    'sharedto' => $ShareTo,
                    'toshare' => $ToShare

                ]);

                if ($query -> rowCount() > 0) {
                    return true;
                }
                return false;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // does user-to-share-class-to exist?
        public function isShareToExist($userid) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM person WHERE id = :usermail");
                $query -> execute([
                    'usermail' => $userid
                ]);

                if ($query -> rowCount() > 0) {
                    return true;
                }

                return false;
            } catch (Exception $e) {
                //die('Error: ' . $e -> getMessage());
            }
        }

        // register courses
        public function RegisterCourses($courseCode, $courseName, $lecName) {
            try {
                $query = $this -> connection -> prepare("INSERT INTO `registered_courses` (`id`, `courses_code`, `courses_name`, `lecturer_name`, `student_id`) VALUES (NULL, :coursecode, :coursename, :lecname, :studentid)");
                $query -> execute([
                    'studentid' => $_SESSION['student_id'],
                    'coursecode' => $courseCode,
                    'coursename' => $courseName,
                    'lecname' => $lecName
                ]);
            } catch (Exception $e) {
                die('Error: '. $e -> getMessage());
            }
        }

        // remember to remove 'Delete Class' option for users that class has been shared to
    }