<?php
session_start(); 

session_unset();
session_destroy();

header("Location: /webb/webb/index.php");
exit();
?>
