<!DOCTYPE html>
<html>
<head>
	<title>Menu</title>
	<style type="text/css">
		*{box-sizing: border-box; font-size: 18pt;}
		html{background-color: #666; width: 100%; height: 100%; padding-top: 60px;}
		body{width: 80%; margin: auto; padding-top: 40px; padding-bottom: 40px;}
		input{display: block; width: 100%;}
		form{width: 80%; margin: auto; border-radius: 8px; background-color: rdba(0,0,0,0); padding: 40px;}
		form.settings {padding: 0px; margin-bottom: 8px;}
		form.settings > input{display: inline-block; width: 49%; background-color: #DDD;}
		form.settings.quit > input {width: 100%; margin-top: 20px;}
		h2{margin-top: 60px; color: white; text-align: center; font-size: 24pt;}
	</style>
</head>
<body>
	<?php
		$dbhost = 'localhost';		// адрес сервера 
		$dbdatabase = 'my_db';		// имя базы данных
		$dbuser = 'mysql';			// имя пользователя
		$dbpassword = 'mysql';		// пароль

		////   содержание страницы по умолчанию как в index.html (на случай попытки входа без ввода почты)  ////
		$cont = '
		<form name="login" method="post" action="menu.php">
			<input name="mail" type="text" placeholder="e-mail">
			<input name="pwd" type="password" placeholder="password">
			New user
			<input name="newUser" type="checkbox">
			<input type="submit" value="Log in!">
		</form>';



		////   обработка изменения почты или пароля   ////

		if (isset($_POST['mail']) || isset($_POST['newMail'])){
			if (isset($_POST['mail'])) $sentmail = $_POST['mail'];
			if (isset($_POST['newMail'])) $sentmail = $_POST['newMail'];

			$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase) 
	    		or die("Ошибка " . mysqli_error($link));

			if (isset($_POST['newPwd']) && ($_POST['newPwd'] != $_POST['lastPwd'])){
				$query ="UPDATE `organizator` SET `pwd` = '".$_POST['newPwd']."' WHERE `organizator`.`mail` = '".$_POST['mail']."'";
				$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
			}
			if (isset($_POST['newMail']) && ($_POST['newMail'] != $_POST['lastMail'])){
				$query ="UPDATE `organizator` SET `mail` = '".$_POST['newMail']."' WHERE `organizator`.`mail` = '".$_POST['lastMail']."'";
				$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
			}
			mysqli_close($link);


			////   содержание страницы по умолчанию как в index.html (с подстановкой введённого раньше логина)  ////

			$cont = '
			<form name="login" method="post" action="menu.php">
				<input name="mail" type="text" placeholder="e-mail" value="'.$sentmail.'">
				<input name="pwd" type="password" placeholder="password">
				New user
				<input name="newUser" type="checkbox">
				<input type="submit" value="Log in!">
			</form>';
		}

		if (isset($_POST['pwd'])) $sentpwd = $_POST['pwd'];
		if (isset($_POST['newPwd']))$sentpwd = $_POST['newPwd'];
		if (isset($_POST['newUser'])) $isnew = $_POST['newUser'];
		

		////   проверка корректности данных для входа   ////

		if(!empty($sentmail) && !empty($sentpwd)){

			$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase) 
	    		or die("Ошибка " . mysqli_error($link));

			$query ="SELECT pwd FROM organizator WHERE mail='".$sentmail."'";
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
			$orgpwd = $result->fetch_assoc()['pwd'];
			if (empty($orgpwd)){
				// если ты случайно обновишь логин или пароль на пустой - всегда будешь получать эту ошибку, но об этом мы никому не скажем
				if (empty($isnew)) echo "Пользователь не существует!<br>";
				else{
					echo "Пользователь '".$sentmail."' успешно зарегистрирован! Для входа введите данные повтороно'<br>";
					$query ="INSERT INTO `organizator` (`name`, `mail`, `phone`, `pwd`) VALUES (NULL, '".$sentmail."', NULL, '".$sentpwd."')";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
				}
			} 
			else if ($orgpwd != $sentpwd) echo "Неверный пароль!<br>";
			else{


				////    УСПЕШНЫЙ ВХОД    ////

				// выгрузка контента страницы из БД

				$query ="SELECT * FROM organizator WHERE mail='".$sentmail."'";
				$result = mysqli_query($link, $query)->fetch_assoc() or die("Ошибка " . mysqli_error($link));
				if ($result['name']) $orgname = $result['name'];
				if ($result['phone']) $orgphone = $result['phone'];

				if (isset($_POST['newName']) ){
					$query ="UPDATE `organizator` SET `name` = '".$_POST['newName']."' WHERE `organizator`.`mail` = '".$sentmail."'";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
					$orgname = $_POST['newName'];
				}
				if (isset($_POST['newPhone'])){
					$query ="UPDATE `organizator` SET `phone` = '".$_POST['newPhone']."' WHERE `organizator`.`mail` = '".$sentmail."'";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
					$orgphone = $_POST['newPhone'];
				}

				$query ="SELECT * FROM merop WHERE org='".$sentmail."'";
				$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
				$merops = '';
				$mer;
				$i = 0;
				while ($mer = $result->fetch_assoc()){
					$merops .= '<label for="mer'. $i .'">'.$mer['name']. '</label><input id="mer'. $i .'" style = "width:13px; display: inline;" name="meroid" type="radio" value="'.$mer['id'].'"><br>';
					$i= $i+1;
				}

				

				$cont = '
					<form class="settings" name="newmail" method="post" action="menu.php">
						<input name="lastMail" type="hidden" placeholder="e-mail" value="'.$sentmail.'">
						<input name="pwd" type="hidden" placeholder="e-mail" value="'.$orgpwd.'">
						mail:<br><input name="newMail" type="text" placeholder="e-mail" value="'.$sentmail.'">
						<input type="submit" value="изменить почту">
					</form>
					<form class="settings" name="newpwd" method="post" action="menu.php">
						<input name="mail" type="hidden" placeholder="e-mail" value="'.$sentmail.'">
						<input name="lastPwd" type="hidden" placeholder="e-mail" value="'.$orgpwd.'">
						password:<br><input name="newPwd" type="password" placeholder="password" value="'.$orgpwd.'">
						<input type="submit" value="изменить пароль">
					</form>
					<form class="settings" name="newname" method="post" action="menu.php">
						<input name="mail" type="hidden" placeholder="e-mail" value="'.$sentmail.'">
						<input name="pwd" type="hidden" placeholder="e-mail" value="'.$orgpwd.'">
						name:<br><input name="newName" type="text" placeholder="ФИО" value="'.$orgname.'">
						<input type="submit" value="Изменить имя">
					</form>
					<form class="settings" name="newphone" method="post" action="menu.php">
						<input name="mail" type="hidden" placeholder="e-mail" value="'.$sentmail.'">
						<input name="pwd" type="hidden" placeholder="e-mail" value="'.$orgpwd.'">
						phone:<br><input name="newPhone" type="text" placeholder="89991112233" value="'.$orgphone.'">
						<input type="submit" value="Изменить телефон">
					</form>
					<form class="settings quit" name="quit" method="post" action="menu.php">
					<input type="submit" value="Выйти">
					</form>

					<h2>Мероприятия</h2>
					
					<form name="meroed" method="post" action="meroEdit.php">
						<input name="mail" type="hidden" placeholder="e-mail" value="'.$sentmail.'">
						<input name="pwd" type="hidden" placeholder="password" value="'.$orgpwd.'">
						'.$merops.'
						<input type="submit" value="Редактировать">
					</form>
				';
			}

			
			mysqli_close($link);
		}else{
			if (empty($sentmail)) echo "email не введён!<br>";
			if (empty($sentpwd)) echo "пароль не введён!<br>";
		}

		echo $cont;
	?>
</body>
</html>