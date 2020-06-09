<?php
	include_once('config.php');
	$input = file_get_contents('php://input');
	if ($input) {
		$arr=json_decode($input,true);
		if($arr['secret']==$secretkey){
			if($arr['type']=='confirmation'){
				echo $authkey;
			}
			elseif($arr['type']=='message_new'){
					if(!isset($arr['object']['action'])){
						if(checkMessage($arr['object']['id'])){
							$user_id = $arr['object']['from_id'];
							if($arr['object']['text']=='start' or $arr['object']['text']=='Start' or $arr['object']['text']=='Начать' or $arr['object']['text']=='начать'){
							  send_message($user_id,"Спрашивайте!"); 
							  }
							  else{
								  search_text($arr['object']['text']);
							}
						}
					}
				echo('ok');
			}
		}
	}
	function search_text($text){//Поиск строки в базе данных
		global $user_id;
		$ret=false;
		if($res=my_query('SELECT *, MATCH (body) AGAINST ("'.$text.'") as REL FROM `texts` WHERE MATCH (body) AGAINST ("'.$text.'") > '.floor (0.2*strlen($text)).' ORDER BY REL;')){
			if(mysqli_num_rows($res)>0){
				while($r=mysqli_fetch_assoc($res)){
					send_message($user_id,$r['body']);
				}
			}
			else{
				send_message($user_id,'ничего не найдено');
			}
		}
		return $ret;
	}
	
	function my_query($q){//Функция для SQL запросов, первый аргумент - текст запроса в бд, второй - массив из экранируемых строк
		global $mysql;
		$link = mysqli_connect($mysql['host'], $mysql['user'], $mysql['password'], $mysql['dbname']);
		$res=false;
		if($link){
			$res=mysqli_query($link,$q);
			mysqli_close($link);
		}
		return $res;
	}


	//Функции для работы с лс
	function send_message($uid,$text){
		global $token;
		$request_params = array(
			'message' => $text,
			'user_id' => $uid,
			'access_token' =>$token,
			'v' => '5.50'
		);
		$get_params = http_build_query($request_params);
		$save=file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
	}
	function checkMessage($mid){

		$query='SELECT * FROM `messages` WHERE `message_id`='.$mid.';';
		if($res= my_query('SELECT * FROM `messages` WHERE `message_id`='.$mid.';')){
			if($res=mysqli_fetch_assoc($res)){
			}
			else{
				$ret=true;
				my_query('INSERT INTO `messages` set `message_id`='.$mid.', `date`='.time().';');
			}
		}
		
	return $ret;
	}
?>
