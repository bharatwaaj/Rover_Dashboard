<?php
/**
 * Created by PhpStorm.
 * User: Bharatwaaj
 * Date: 07-06-2017
 * Time: 11:42
 */

$roverEmail = $_POST['email-rover-app'];
$roverPassword = $_POST['password-rover-app'];

if ($roverEmail == "admin@roverapp.io" && $roverPassword == "admin") {
    session_start();
    $_SESSION["username"] = "admin";
    header("Location: dashboard.php");
    setcookie("wrong-credentials", null, 24 * 60 * 60);
} else {
    header("Location: index.php");
    setcookie("wrong-credentials", "true", 24 * 60 * 60);
}
?>
