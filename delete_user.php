<?php
session_start();

require "function.php";

is_not_login('id');

$logged_user_id=$_SESSION['id'];

$edit_user_id=$_GET['id'];

if($_SESSION['login']['role']==null){if (is_author($logged_user_id,$edit_user_id)==FALSE){redirect_to('users.php');set_flash_message('success','можно редактировать только свой профиль');}};

var_dump($edit_user_id);

$delete=delete($edit_user_id);

var_dump($delete);
set_flash_message('success','пользователь удален');

if($logged_user_id==$edit_user_id){
									unset($_SESSION['login']);
									unset($_SESSION['id']);
									redirect_to('page_register.php');
									}
	else {redirect_to("users.php");};




























?>