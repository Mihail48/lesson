<?php

//проверяет регистрацию нашего нового пользавателя по email
function get_user_by_email($email){
	$pdo=new PDO('mysql:host=localhost;dbname=register','root','');

	$sql= 'SELECT*FROM users WHERE email=:email';

	$statement=$pdo->prepare($sql);

	$statement->execute(['email'=>$email]);

	$peopls=$statement->fetchAll(PDO::FETCH_ASSOC);

	return $peopls;
}

//добавляет нового пользователя
function add_user($email,$password){

	$pdo=new PDO('mysql:host=localhost;dbname=register', "root" , "");
	$sql ='INSERT INTO users(email,password) VALUES(:email,:password)';

	$statement=$pdo->prepare($sql);

	$statement->execute(['email'=>$email,
					'password'=>password_hash($password, PASSWORD_DEFAULT)]);

	return $pdo->lastInsertId();
}

function set_flash_message($name,$message){
	$_SESSION[$name]=$message;
}
//перенаправляет на указанную страницу
function redirect_to($way){

	header("Location: /погружение/$way");
}

function displey_flash_message($name){
	 if(isset($_SESSION[$name])) {
	 	 echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">
                                         {$_SESSION[$name]}
               </div>";
	 	 unset($_SESSION[$name]);
                				}
}



function login($email,$password){
	$pdo=new PDO('mysql:host=localhost;dbname=register','root','');

	$sql='SELECT*FROM users WHERE email=:email';

	$statement=$pdo->prepare($sql);
	$statement->execute(['email'=>$email
						]);

	$authorization=$statement->fetch(PDO::FETCH_ASSOC);

	$k=$authorization['password'];

	if(password_verify($password,$k)){
										$_SESSION['login']=$authorization;
										$_SESSION['id']=$authorization['id'];
										redirect_to('users.php');

									}
										else{
												set_flash_message('danger','неправильно набран логин или пароль');
												redirect_to('page_login.php');
												unset($_SESSION['login']);
											exit;
											}


}



function is_not_login($name){ if(empty($_SESSION[$name])){ redirect_to('page_login.php');}}



//if ($_SESSION['role']=='admin'){}

function data(){
				$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
				$sql='SELECT email FROM users WHERE id={$_SESSION["id"]}';
				$statement=$pdo->prepare($sql);
				$statement->execute();
				$st=$statement->fetch(PDO::FETCH_ASSOC);
				return $st;
}













?>