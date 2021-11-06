<?php     
    /*
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    /**
     * Description of Account
     *
     * @author Hash 👽
     */
    
    class Person {
        private $id;
        private $firstname;
        private $middlename;
        private $lastname;
        private $studentemail;
        private $studentlevel;
        private $programme;
        private $class;

        public function __construct() {}

        public function getId() {
            return $this -> id;
        }

        public function getFirstname() {
            return $this -> firstname;
        }

        public function getMiddlename() {
            return $this -> middlename;
        }

        public function getLastname() {
            return $this -> lastname;
        }

        public function getStudentemail() {
            return $this -> studentemail;
        }

        public function getLevel() {
            return $this -> studentlevel;
        }

        public function getProgram() {
            return $this -> programme;
        }

        public function getClass() {
            return $this -> class;
        }

        public function getClassesHandle() {
            return $this -> id + "_tables";
        }

        public function setId($id) {
            $this -> id = $id;
        }

        public function setFirstname($firstname) {
            $this -> firstname = $firstname;
        }

        public function setMiddlename($middlename) {
            $this -> middlename = $middlename;
        }

        public function setLastname($lastname) {
            $this -> lastname = $lastname;
        }

        public function setStudentemail($studentemail) {
            $this -> studentemail = $studentemail;
        }

        public function setLevel($studentlevel) {
            $this -> studentlevel = $studentlevel;
        }

        public function setProgram($programme) {
            $this -> programme = $programme;
        }

        public function setClass($class) {
            $this -> class = $class;
        }
    }
?>