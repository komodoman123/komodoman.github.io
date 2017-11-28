<?php
    session_start();
    if(isset($_GET['submit'])){
        $cookie_value = $_SESSION['user'];
        
        session_unset();
        session_destroy();
        setcookie('username', $cookie_value,time()+(96400*30), "index.php");
        header ("Location: index.php");
    }
?>

Signed in. Welcome <?php echo $_SESSION['user']?>
<hr>
<form method="GET" >
                <input type="submit" name="submit" value="Back">
</form>