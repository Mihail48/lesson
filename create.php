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

	//$filename=$_FILES['avatar']['tmp_name'];

	//$destination='upload/'.rand(000000000,999999999).'.jpg';

	var_dump($avatar);



	$peopls=get_user_by_email($email);

	if(!empty($peopls)){

					set_flash_message('danger','Увы,такой email уже зарегистрирован');

						redirect_to('create_user.php');

					exit;
				}



	$last_id=add_user($email,$password,$role);

	set_flash_message('success','Ура,регистрация нового пользователя произошла успешно');


	$edit=edit_information($user_name,$telephone,$location,$work,$last_id);

	//var_dump($edit);

	add_social_link($telegram,$instagram,$vk,$last_id);

	$status=set_status($select,$last_id);




	upload_avatar($avatar,$last_id);







































?>