<?php
session_start();
require 'function.php';

	$email=$_POST['email'];

	$password=$_POST['password'];


	$user_name=$_POST['user_name'];

	$work=$_POST['work'];

	$location=$_POST['location'];

	$telephone=$_POST['telephone'];

	$img=$_POST['img'];

	$telegram=$_POST['telegram'];

	$vk=$_POST['vk'];

	$instagram=$_POST['instagram'];

	$select=$_POST['select'];

	$avatar=$_FILES['avatar'];

	$filename=$_FILES['avatar']['name'];

	$filename=$avatar['name'];

	$peopls=get_user_by_email($email);

	if(!empty($peopls)){

					set_flash_message('danger','Увы,такой email уже зарегистрирован');

						redirect_to('create_user.php');

					exit;
				}


	$user_id=add_user($email,$password,$role);

	$edit=edit_information($user_name,$telephone,$location,$work,$user_id);

	$status=set_status($select,$user_id);

	upload_avatar($avatar,$user_id);

	add_social_link($telegram,$instagram,$vk,$user_id);

	set_flash_message('success','Пользователь добавлен');

	redirect_to('users.php');














































?>