<?php
session_start();
session_destroy();
header('Location: iniciarsesion.php');
exit();
?>