<?php
/**
 * Created by PhpStorm.
 * User: Bharatwaaj
 * Date: 09-06-2017
 * Time: 13:07
 */

session_start();
session_destroy();
header("location: index.php");
exit();
?>