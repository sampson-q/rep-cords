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
    require_once '../models/Clas.php';
    require_once '../models/Course.php';

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

        public function isClassExists(Clas $class) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM all_class WHERE student_id = :student_id");
                $query -> execute([
                    'student_id' => $_SESSION['student_id']
                ]);

                if ($query -> rowCount() > 0) {
                    while ($result = $query -> fetch()) {
                        if ($result['class_names'] === ($class -> getClassNameHalf())) {
                            return true;
                        }
                    }
                }
                
                return false;
            } catch (Exception $e) {
                die('Error: ' . $e -> getMessage());
            }
        }

        // add a class
        public function AddClass(Clas $class) {
            try {
                $query = $this -> connection -> prepare('CREATE TABLE IF NOT EXISTS `repnotes`.`:classname` ( `sn` INT(10) NOT NULL AUTO_INCREMENT , `studentname` VARCHAR(50) NOT NULL , `studentid` VARCHAR(10) NOT NULL , PRIMARY KEY (`sn`), UNIQUE `studentid` (`studentid`))');
                $query -> execute([
                    'classname' => $class -> getClassNameFull()
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // add a class
        public function AddClassDetails(Clas $class) {
            try {
                $query = $this -> connection -> prepare('INSERT INTO `all_class` (`id`, `student_id`, `class_names`) VALUES (NULL, :student_id, :class_name)');
                $query -> execute([
                    'student_id' => $_SESSION['student_id'],
                    'class_name' => $class -> getClassNameHalf()
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // remove a class
        public function RemoveClass(Clas $class) {
            try {
                $removetablequery = $this -> connection -> prepare('DROP TABLE IF EXISTS `repnotes`.`:classremove`');
                $removetablequery -> execute([
                    'classremove' => strtolower($class -> getClassNameFull())
                ]);

                $removefromlistquery = $this -> connection -> prepare('DELETE FROM all_class WHERE student_id = :student_id AND class_names = :class_names');
                $removefromlistquery -> execute([
                    'student_id' => strtoupper($_SESSION['student_id']),
                    'class_names' => $class -> getClassNameHalf()
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error ' . $e -> getMessage());
            }
        }

        public function isMemberExist(Clas $class) {
            try {
                $query = $this -> connection -> prepare('SELECT * FROM ' . $class -> getClassNameFull() . ' WHERE studentid = ' . $class -> getMemberID());

                if ($query -> rowCount() > 0) {
                    return true;
                }

            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        public function AddClassMember(Clas $class) {
            try {
                $query = $this -> connection -> prepare('INSERT INTO `:student_class` (`sn`, `studentname`, `studentid`) VALUES (NULL, :student_name, :student_id)');
                $query -> execute([
                    'student_class' => $class -> getClassNameFull(),
                    'student_name' => $class -> getMemberName(),
                    'student_id' => $class -> getMemberID()
                ]);

                return true;
            } catch (Exception $e) {
                if (explode(":", $e -> getMessage(), 2)[0] == 'SQLSTATE[23000]') {
                    die ('member_exist');
                }
            }
        }

        public function UpdateMemberDetails(Clas $class, $recordforupdate) {
            try {
                $query = $this -> connection -> prepare("UPDATE `repnotes`.`:classname` SET `studentname` = :studentname, `studentid` = :studentid WHERE `:classname`.`sn` = :r");
                $query -> execute([
                    'classname' => $class -> getClassNameFull(),
                    'studentname' => $class -> getMemberName(),
                    'studentid' => $class -> getMemberID(),
                    'r' => $recordforupdate
                ]);

                return true;
            } catch (Exception $e) {
                if (explode(":", $e -> getMessage(), 2)[0] == 'SQLSTATE[23000]') {
                    die ('member_exist');
                }
            }
        }

        // update course details
        public function UpdateCourseDetails(Course $course) {
            try {
                $query = $this -> connection -> prepare("UPDATE `registered_courses` SET `courses_code` = :coursecode, `courses_name` = :coursename, `lecturer_name` = :courselect WHERE `registered_courses`.`id` = :courseid;");
                $query -> execute([
                    'courseid' => $course -> getCourseID(),
                    'coursecode' => $course -> getCourseCode(),
                    'coursename' => $course -> getCourseName(),
                    'courselect' => $course -> getCourseLect()
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        public function RemoveMemberDetails(Clas $class, $record4remove) {
            try {
                $query = $this -> connection -> prepare('DELETE FROM `repnotes`.`:class4remove` WHERE `:class4remove`.`sn` = :record');
                $query -> execute([
                    'class4remove' => $class -> getClassNameFull(),
                    'record' => $record4remove
                ]);
                
                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // unshare a class by its id
        public function UnshareClass(Clas $class) {
            try {
                $query = $this -> connection -> prepare('DELETE FROM `repnotes`.`shared_classes` WHERE `shared_classes`.`id` = :unshare');
                $query -> execute([
                    'unshare' => $class -> getClassID()
                ]);
                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // unregister a course
        public function UnregisterCourse(Course $course) {
            try {
                $query = $this -> connection -> prepare('DELETE FROM registered_courses WHERE id= :courseid');
                $query -> execute([
                    'courseid' => $course -> getCourseID()
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        public function ShareClass(Person $person, Clas $class) {
            try {
                $query = $this -> connection -> prepare('INSERT INTO `shared_classes` (`id`, `shared_by`, `shared_to`, `class_names`) VALUES (NULL, :sharedby, :sharedto, :class4share)');
                $query -> execute([
                    'sharedby' => $_SESSION['student_id'],
                    'sharedto' => $person -> getID(),
                    'class4share' => $class -> getClassNameHalf()
                ]);

                return true;
            } catch (Exception $e) {
                die ('Error: ' . $e -> getMessage());
            }
        }

        // is this a shared class
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
        public function isClassShared(Person $person, Clas $class) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM shared_classes WHERE shared_by = :sharedby AND shared_to = :sharedto AND class_names = :toshare");
                $query -> execute([
                    'sharedby' => $_SESSION['student_id'],
                    'sharedto' => $person -> getID(),
                    'toshare' => $class -> getClassNameFull()
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
        public function isShareToExist(Person $person) {
            try {
                $query = $this -> connection -> prepare("SELECT * FROM person WHERE id = :userid");
                $query -> execute([
                    'userid' => $person -> getId()
                ]);

                if ($query -> rowCount() > 0) {
                    return true;
                }

                return false;
            } catch (Exception $e) {
                die('Error: ' . $e -> getMessage());
            }
        }

        // register courses
        public function RegisterCourse(Course $course) {
            try {
                $query = $this -> connection -> prepare("INSERT INTO `registered_courses` (`id`, `courses_code`, `courses_name`, `lecturer_name`, `student_id`) VALUES (NULL, :coursecode, :coursename, :courselect, :studentid)");
                $query -> execute([
                    'studentid' => $_SESSION['student_id'],
                    'coursecode' => $course -> getCourseCode(),
                    'coursename' => $course -> getCourseName(),
                    'courselect' => $course -> getCourseLect()
                ]);

                return true;
            } catch (Exception $e) {
                die('Error: '. $e -> getMessage());
            }
        }

        // save attendace details
        public function SaveAttendanceDetails($AttendName, $RepName) {
            
            if ($_SESSION['class2show'][9] == '_') { $class2show = $_SESSION['class2show']; }
            else {$class2show = $_SESSION['student_id'] . '_' . $_SESSION['class2show'];}

            try {
                $query = $this -> connection -> prepare("INSERT INTO `all_attendance` (`id`, `attend_names`, `class_names`, `taken_by`) VALUES (NULL, :attname, :classname, :takenby)");
                $query -> execute([
                    'attname' => $AttendName,
                    'takenby' => $RepName,
                    'classname' => $class2show
                ]);

            } catch (Exception $e) {
                die('Error: ' . $e -> getMessage());
            }
        }

        // remove attendance
        public function RemoveAttendance($AttendanceId, $AttendanceName) {
            try {
                $query = $this -> connection -> prepare("DELETE FROM `all_attendance` WHERE `all_attendance`.`id` = :attid");
                $query -> execute(['attid' => $AttendanceId]);
                
                rename("../attends/$AttendanceName", "../cachedattends/$AttendanceName");
                rename("../cachedattends/$AttendanceName", "../cachedattends/" . explode(".pdf", $AttendanceName, 2)[0] . " -- " . time() . ".pdf");

                return true;
            } catch (Exception $e) {
                die('Error: ' . $e -> getMessage());
            }
        }
        // remember to remove 'Delete Class' option for users that class has been shared to
    }