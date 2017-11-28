<?php
        $cookie_value = $_SESSION['username'];   
        setcookie('username', $cookie_value,time()+(96400*30), '/');
?>