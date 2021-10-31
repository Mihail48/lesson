<?php
session_start();

require 'function.php';

	$user_name=$_POST['user_name'];

	$work=$_POST['work'];

	$location=$_POST['location'];

	$telephone=$_POST['telephone'];

    $user_id=$_GET['id'];
	//$user_id=$_SESSION['edit_user_id'];

$edit_info=edit_info($user_name,$telephone,$location,$work,$user_id);

set_flash_message('success','профиль успешно обновлен');

redirect_to("page_profile.php?id=$user_id");



?>