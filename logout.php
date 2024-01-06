<?php

// logout.php
session_start();

require_once 'config/Database.php';
require_once 'controllers/User.php';

$db = new Database();
$user = new User($db);

// Call the logout method
$user->logout();

// Redirect to the login page after logout
header('Location:index.php');
exit();