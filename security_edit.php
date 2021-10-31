<?php
session_start();
require "function.php";
$email=$_POST['email'];
$password=$_POST['password'];
$user_id=$_GET['id'];
$peopls=get_user_by_email($email);
$user=get_user_by_id($user_id);



if(!empty($peopls AND $email!=$user["email"])){
						set_flash_message('danger','такой email уже зарегистрирован');
						redirect_to("security.php?id=$user_id");
						exit;
};

if(empty($email)){set_flash_message('danger','email не может быть пустым');redirect_to("security.php?id=$user_id");exit;}

$edit_credentials=edit_credentials($user_id,$email,$password);
set_flash_message('success','профиль успешно обновлен');

redirect_to("page_profile.php?id=$user_id");

















?>