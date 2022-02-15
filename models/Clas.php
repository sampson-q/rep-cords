<?php     
    /*
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    /**
     * Description of Clas
     *
     * @author Hash 👽
     */

    class Clas {
        private $RepID;
        private $ClassNameFull;
        private $ClassNameHalf;
        private $MemberName;
        private $RepName;
        private $MemberID;
        private $ClassType;
        private $ClassID;

        public function __construct() {}

        public function getClassNameFull() {
            return $this -> ClassNameFull;
        }

        public function getClassNameHalf() {
            return $this -> ClassNameHalf;
        }

        public function getRepID() {
            return $this -> RepID;
        }

        public function getMemberName() {
            return $this -> MemberName;
        }

        public function getRepName() {
            return $this -> RepName();
        }

        public function getMemberID() {
            return $this -> MemberID;
        }

        public function getClassType() {
            return $this -> ClassType;
        }

        public function getClassID() {
            return $this -> ClassID;
        }

        public function setClassNameFull($ClassNameFull) {
            $this -> ClassNameFull = $ClassNameFull;
        }

        public function setClassNameHalf($ClassNameHalf) {
            $this -> ClassNameHalf = $ClassNameHalf;
        }

        public function setRepID($RepID) {
            $this -> RepID = $RepID;
        }

        public function setMemberName($MemberName) {
            $this -> MemberName = $MemberName;
        }

        public function setRepName($RepName) {
            $this -> RepName = $RepName;
        }

        public function setMemberID($MemberID) {
            $this -> MemberID = $MemberID;
        }

        public function setClassType($ClassType) {
            $this -> ClassType = $ClassType;
        }

        public function setClassID($ClassID) {
            $this -> ClassID = $ClassID;
        }
    }
?>