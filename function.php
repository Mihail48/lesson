<?php

//проверяет регистрацию нашего нового пользавателя по email(есть ли такой email в базе)
function get_user_by_email($email){
	$pdo=new PDO('mysql:host=localhost;dbname=register','root','');

	$sql= 'SELECT*FROM users WHERE email=:email';

	$statement=$pdo->prepare($sql);

	$statement->execute(['email'=>$email]);

	$peopls=$statement->fetch(PDO::FETCH_ASSOC);

	return $peopls;
}

//выводит все данные пользователя из таблицы по user_id
function get_user_by_id($edit_user_id){
	$pdo=new PDO('mysql:host=localhost;dbname=register','root','');

	$sql= 'SELECT users.id, users.email, users.password, users.role, users.img, users.status, user_information.user_name,user_information.location,user_information.telephone,user_information.work,user_social_link.telegram,user_social_link.instagram,user_social_link.vk FROM users LEFT JOIN user_information ON users.id=user_information.id LEFT JOIN user_social_link ON user_information.id=user_social_link.id WHERE users.id=:id';

	$statement=$pdo->prepare($sql);

	$statement->execute(['id'=>$edit_user_id]);

	$user=$statement->fetch(PDO::FETCH_ASSOC);

	return $user;

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

	 $user_id=$pdo->lastInsertId();
	 return $user_id;


}
// формирует сообщение
function set_flash_message($name,$message){
	$_SESSION[$name]=$message;
}
//перенаправляет на указанную страницу
function redirect_to($way){

	header("Location: /погружение/$way");
}
// выводит сообщение
function displey_flash_message($name){
	 if(isset($_SESSION[$name])) {
	 	 echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">
                                         {$_SESSION[$name]}
               </div>";
	 	 unset($_SESSION[$name]);
                				}
}

//проверка логина и пароля

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


//проверяет есть ли $_SESSION[id], другими словами есть ли логин
function is_not_login($name){ if(empty($_SESSION[$name])){ redirect_to('page_login.php');}}



// достать значение прав пользователя

function pull_role(){
				$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
				$sql='SELECT role FROM users WHERE id=:id';
				$statement=$pdo->prepare($sql);
				$statement->execute(['id'=>$_SESSION['id']]);
				$now_role=$statement->fetch(PDO::FETCH_ASSOC);
				return $now_role;
}





//внесение информации о пользователе в базу данных

function edit_information($user_name,$telephone,$location,$work,$user_id){$pdo= new PDO('mysql:host=localhost; dbname=register','root','');
							$sql='INSERT INTO user_information(id,user_name,telephone,location,work) VALUES (:id,:user_name,:telephone,:location,:work)';
							$statement=$pdo->prepare($sql);
							$edit=$statement->execute(['user_name'=>$user_name,
												'telephone'=>$telephone,
												'location'=>$location,
												'work'=>$work,
												'id'=>$user_id]);
							return $edit;

}

function edit_info($user_name,$telephone,$location,$work,$user_id){$pdo= new PDO('mysql:host=localhost; dbname=register','root','');
							$sql='UPDATE user_information SET user_name=:user_name, telephone=:telephone, location=:location, work=:work WHERE id=:id';
							$statement=$pdo->prepare($sql);
							$editinfo=$statement->execute(['user_name'=>$user_name,
												'telephone'=>$telephone,
												'location'=>$location,
												'work'=>$work,
												'id'=>$user_id]);
							return $edit_info;
}

//добавление социальных сетей в базу данных

function add_social_link($telegram,$instagram,$vk,$user_id){$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
															$sql='INSERT INTO user_social_link(id,telegram,instagram,vk) VALUES (:id,:telegram,:instagram,:vk)';
															$statement=$pdo->prepare($sql);
															$edit_link=$statement->execute(['telegram'=>$telegram,
																							'instagram'=>$instagram,
																							'vk'=>$vk,
																							'id'=>$user_id]);


}


//установить статус в базу данных

function set_status($select,$user_id){$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
								$sql='UPDATE users SET status=:status WHERE id=:id';
								$statement=$pdo->prepare($sql);
								$statement->execute(['id'=>$user_id,
													'status'=>$select]);

}

//загрузка картинки(аватарки)

function upload_avatar($avatar,$user_id){
										if(is_uploaded_file($avatar['tmp_name'])){
																					$filename=$avatar['name'];
																					$ext=pathinfo($filename, PATHINFO_EXTENSION);//получил png
																					$filename=uniqid().'.'.$ext;

																					move_uploaded_file($avatar['tmp_name'], 'upload/'.$filename);

																					$pdo= new PDO('mysql:host=localhost;dbname=register', 'root', '');
																					$sql='UPDATE users SET img=:avatar WHERE id=:id';
																					$statement=$pdo->prepare($sql);
																					$statement->execute(['id'=>$user_id,
																							'avatar'=>$filename]);};

}



function has_image($user_id,$image){
									if($image==NULL){echo "<img src='img/demo/avatars/avatar-m.png' alt='' class='img-responsive' width='200'>";}

									else{echo "<img src='upload/{$image}' alt='' class='img-responsive' width='200'>";}

}

//проверка свою ли страницу редактирует пользователь

function is_author($logged_user_id,$edit_user_id){if ($logged_user_id==$edit_user_id)
													{return TRUE;}
														else{ return FALSE; exit;};};



function edit_credentials($user_id,$email,$password){ if(empty($password)){	//$password=NULL;
																			$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
																			$sql='UPDATE users SET email=:email WHERE id=:id';
																			$statement=$pdo->prepare($sql);
																			$edit_credentials=$statement->execute(['email'=>$email,
																													'id'=>$user_id]);
																			return $edit_credentials;

																			}
                                                         else {
	                                                         	$pdo= new PDO('mysql:host=localhost;dbname=register','root','');
																$sql='UPDATE users SET email=:email, password=:password WHERE id=:id';
																$statement=$pdo->prepare($sql);
																$edit_credentials=$statement->execute(['email'=>$email,
																				'password'=>password_hash($password,PASSWORD_DEFAULT),
																				'id'=>$user_id]);
																return $edit_credentials;
																exit;
																}


}

function delete($edit_user_id){ $pdo= new PDO('mysql:host=localhost;dbname=register','root','');
								$sql='DELETE FROM users WHERE id=:id';
                                            $statement=$pdo->prepare($sql);
                                            $statement->execute(['id'=>$edit_user_id]);

                                    $pdo= new PDO('mysql:host=localhost;dbname=register','root','');
									$sql='DELETE FROM user_information WHERE id=:id';
                                    $statement=$pdo->prepare($sql);
                                    $statement->execute(['id'=>$edit_user_id]);

                                    $pdo= new PDO('mysql:host=localhost;dbname=register','root','');
									$sql='DELETE FROM user_social_link WHERE id=:id';
                                    $statement=$pdo->prepare($sql);
                                    $statement->execute(['id'=>$edit_user_id]);









}






?>