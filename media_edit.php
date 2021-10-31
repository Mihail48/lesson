<?php 
session_start();
require 'function.php';

$avatar=$_FILES['avatar'];

$user_id=$_GET['id'];

var_dump($avatar);

upload_avatar($avatar,$user_id);

set_flash_message('success','профиль успешно обновлен');

redirect_to("page_profile.php?id=$user_id");





































?>