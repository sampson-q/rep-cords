<?php
    /* 
    * To change this license header, choose License Headers in Project Properties.
    * To change this template file, choose Tools | Templates
    * and open the template in the editor.
    */

    require_once './CrudOperation.php';
    
    session_destroy();
    session_start();
    
    $_SESSION['freshPage'] = '';
    
    echo '<script>sessionStorage.removeItem("PageID");window.location.href="../index.php";</script>';
?>