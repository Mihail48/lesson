<?php
session_start();
require 'function.php';

$email=$_POST['email'];

$password=$_POST['password'];



login($email,$password);




?>