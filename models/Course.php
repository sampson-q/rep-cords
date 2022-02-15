<?php     
    /*
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    /**
     * Description of Course
     *
     * @author Hash 👽
     */

    class Course {
        private $courseid;
        private $coursename;
        private $courselect;
        private $coursedate;
        private $coursecode;

        public function __construct() {}

        public function getCourseID() {
            return $this -> courseid;
        }

        public function getCourseName() {
            return $this -> coursename;
        }

        public function getCourseLect() {
            return $this -> courselect;
        }

        public function getCourseDate() {
            return $this -> coursedate;
        }

        public function getCourseCode() {
            return $this -> coursecode;
        }

        public function setCourseID($courseid) {
            $this -> courseid = $courseid;
        }

        public function setCourseName($coursename) {
            $this -> coursename = $coursename;
        }

        public function setCourseLect($courselect) {
            $this -> courselect = $courselect;
        }

        public function setCourseDate($coursedate) {
            $this -> coursedate = $coursedate;
        }

        public function setCourseCode($coursecode) {
            $this -> coursecode = $coursecode;
        }
    }

?>