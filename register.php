<?php
session_start();

require 'function.php';

$email=$_POST['email'];

$password=$_POST['password'];

$peopls=get_user_by_email($email);


if(!empty($peopls)){
					set_flash_message('danger','Такой адрес уже зарегистрирован');

					redirect_to("page_register.php");

					exit;
					}





add_user($email, $password);


					set_flash_message('success','Поздравляю,регистрация прошла успешно');

redirect_to("page_login.php");
exit;



















?>
