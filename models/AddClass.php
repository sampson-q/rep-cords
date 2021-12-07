<?php     
    /*
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    /**
     * Description of AddClass
     *
     * @author Hash 👽
     */

    class AddClass {
        private $classname;

        public function __construct() {}

        public function getClassName() {
            return $this -> classname;
        }

        public function setClassName($classname) {
            $this -> classname = $_SESSION['student_id'] . '_' . $classname;
        }
    }
?>