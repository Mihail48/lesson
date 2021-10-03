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
function add_user($email,$password,$role){
	$role=NULL;
	$pdo=new PDO('mysql:host=localhost;dbname=register', "root" , "");
	$sql ='INSERT INTO users(email,password,role) VALUES(:email,:password,:role)';

	$statement=$pdo->prepare($sql);

	$statement->execute(['email'=>$email,
						'password'=>password_hash($password, PASSWORD_DEFAULT),
						'role'=>$role]);

	 $last_id=$pdo->lastInsertId();
	 return $last_id;


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
												unset($_SESSION['id']);
											exit;
											}


}



function is_not_login($name){ if(empty($_SESSION[$name])){ redirect_to('page_login.php');}}





function pull_id(){
				$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
				$sql='SELECT role FROM users WHERE id=:id';
				$statement=$pdo->prepare($sql);
				$statement->execute(['id'=>$_SESSION['id']]);
				$now_id=$statement->fetch(PDO::FETCH_ASSOC);
				return $now_id;
}


function is_not_login_and_admin($name,$role){if($_SESSION[$name][$role]==null){redirect_to('page_login.php');}}


function edit_information($user_name,$telephone,$location,$work,$last_id){$pdo= new PDO('mysql:host=localhost; dbname=register','root','');
							$sql='INSERT INTO user_information(id,user_name,telephone,location,work) VALUES (:id,:user_name,:telephone,:location,:work)';
							$statement=$pdo->prepare($sql);
							$edit=$statement->execute(['user_name'=>$user_name,
												'telephone'=>$telephone,
												'location'=>$location,
												'work'=>$work,
												'id'=>$last_id]);
							return $edit;

}

function add_social_link($telegram,$instagram,$vk,$last_id){$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
															$sql='INSERT INTO user_social_link(id,telegram,instagram,vk) VALUES (:id,:telegram,:instagram,:vk)';
															$statement=$pdo->prepare($sql);
															$edit_link=$statement->execute(['telegram'=>$telegram,
																							'instagram'=>$instagram,
																							'vk'=>$vk,
																							'id'=>$last_id]);

}


function set_status($select,$last_id){$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
								$sql='UPDATE users SET status=:status WHERE id=:id';
								$statement=$pdo->prepare($sql);
								$statement->execute(['id'=>$last_id,
													'status'=>$select]);

}


function upload_avatar($avatar,$last_id){
										if(is_uploaded_file($avatar['tmp_name'])){ $filename=$avatar['name'];
																							$ext=pathinfo($filename, PATHINFO_EXTENSION);
																							$ext=uniqid();

																		move_uploaded_file($avatar['tmp_name'], 'upload/'.$ext.'.jpg');}

																		$pdo= new PDO('mysql:host=localhost;dbname=register', 'root', '');
																		$sql='UPDATE users SET img=:avatar WHERE id=:id';
																		$statement=$pdo->prepare($sql);
																		$statement->execute(['id'=>$last_id,
																							'avatar'=>$avatar['name']]);




}













?>