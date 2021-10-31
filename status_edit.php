<?php 
session_start();

require "function.php";

$select=$_POST['select'];

$user_id=$_GET['id'];

set_status($select,$user_id);

set_flash_message('success','профиль успешно обновлен');

redirect_to("page_profile.php?id=$user_id");



?>