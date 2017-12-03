<?php
require_once("/includes/initialize.php");
session_unset();

session_destroy();
// Logged out, return home.
Header("Location: main.php");
?>