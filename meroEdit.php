<!DOCTYPE html>
<html>
<head>
	<title>Редактор мероприятия</title>
	<style type="text/css">
		
	</style>
</head>
<body>
	<?php
		$dbhost = 'localhost'; // адрес сервера 
		$dbdatabase = 'my_db'; // имя базы данных
		$dbuser = 'mysql'; // имя пользователя
		$dbpassword = 'mysql'; // пароль
		$cont =
		'<form name="back" method="post" action="menu.php">
			<input type="hidden" name="pwd" value="'. $_POST['pwd'] .'">
			<input type="hidden" name="mail" value="'. $_POST['mail'] .'">
			<input type="submit" value="Вернуться в меню" style="background-color: blue;  color: white;">
		</form>';
		//		подключение к БД
		$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase) 
	    		or die("Ошибка 0" . mysqli_error($link));
	    		// echo( "</br>".$_POST['meroid']."</br></br>");
    	//		обработка отправленных форм
		$query = 0;
		if ( isset($_POST['del']) ){
			$query = "DELETE FROM `merop` WHERE `merop`.`id` = ". $_POST['meroid'];
			if (mysqli_query($link, $query)) echo "<script>alert(\"мероприятие удалено!\");</script>";
		}else{
			if(isset($_POST['meroname']) && isset($_POST['merodatime']) && isset($_POST['merodescr'])) {
				$query = "UPDATE merop SET descr = '". $_POST['merodescr'];
				$query .= "', dattime = '". $_POST['merodatime'];
				$query .= "', name = '". $_POST['meroname'];
				$query .="'  WHERE org='". $_POST['mail'] ."' and id='". $_POST['meroid'] ."'";
			}
			if( $_POST['meroid'] == 'NEWmer' && isset($_POST['meroname']) && isset($_POST['mail']) ){
				$query ="INSERT INTO merop (`org`, `name`, `descr`, `dattime`) VALUES ('".$_POST['mail']."', '".$_POST['meroname']."', '". $_POST['merodescr'] ."', '". $_POST['merodatime'] ."')";
				echo "<script>alert(\"мероприятие создано!\");</script>";
			}
			if ($query != 0){
				// echo( "</br>".$query."</br></br>");
				$result = mysqli_query($link, $query) or die("Ошибка 1" . mysqli_error($link));	
			}

			//		форма для создания мероприятия
			if ( !isset($_POST['new']) ){
				$cont = '
				<form name="newMeroTitle" method="post">
					<input type="hidden" name="pwd" value="'. $_POST['pwd'] .'">
					<input type="hidden" name="mail" value="'. $_POST['mail'] .'">
					<input type="hidden" name="meroid" value="'. $_POST['meroid'] .'">
					<input type="hidden" name="new" value="newMero">
					<input type="text" name="meroname" required>
					<input type="datetime-local" name="merodatime" required><br>
					<textarea name="merodescr" cols="47" rows="4" required></textarea><br>
					<input type="submit" value="Создать мероприятие">
				</form>
				<form name="back" method="post" action="menu.php">
					<input type="hidden" name="pwd" value="'. $_POST['pwd'] .'">
					<input type="hidden" name="mail" value="'. $_POST['mail'] .'">
					<input type="submit" value="Вернуться в меню" style="background-color: blue; color: white;">
				</form>';
			}
			
			//		форма для редактирования мероприя
			if ( !isset($_POST['new']) && ($_POST['meroid'] != "NEWmer") ){
				if (isset($_POST['meroid'])){
					$meroid = $_POST['meroid'];
				}else{
					$query = "SELECT id FROM merop WHERE org='".$_POST['mail']."' and name='".$_POST['meroname']."'";
					$meroid = $_POST['meroid'];
				}
				$query = "SELECT * FROM merop WHERE org='".$_POST['mail']."' and id='".$meroid."'";
				$result = mysqli_query($link, $query)->fetch_assoc() or die("Ошибка 2" . mysqli_error($link));

				$cont = '
				<form name="editMeroTitle" method="post">
					<input type="hidden" name="pwd" value="'. $_POST['pwd'] .'">
					<input type="hidden" name="mail" value="'. $_POST['mail'] .'">
					<input type="hidden" name="meroid" value="'. $meroid .'">
					<input type="text" name="meroname" value="'. $result['name'] .'">
					<input type="datetime-local" name="merodatime" value="'. substr(str_replace(" ", "T", $result['dattime']), 0, -3) .'"><br>
					<textarea name="merodescr" cols="47" rows="4">'. $result['descr'] .'</textarea><br>
					<input type="submit" value="Сохранить">
				</form>
				<form name="dropmero" method="post">
					<input type="hidden" name="pwd" value="'. $_POST['pwd'] .'">
					<input type="hidden" name="mail" value="'. $_POST['mail'] .'">
					<input type="hidden" name="meroid" value="'. $meroid .'">
					<input type="hidden" name="del" value="deleteMero">
					<input type="submit" value="Удалить!" style="background-color: red;">
				</form>
				<form name="back" method="post" action="menu.php">
					<input type="hidden" name="pwd" value="'. $_POST['pwd'] .'">
					<input type="hidden" name="mail" value="'. $_POST['mail'] .'">
					<input type="submit" value="Вернуться в меню" style="background-color: blue; color: white;">
				</form>';
			}
		}
		
		echo $cont;

		mysqli_close($link);
	?>
</body>
</html>