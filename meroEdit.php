<!DOCTYPE html>
<html>
<head>
	<title>Редактор мероприятия</title>
</head>
<body>
	<?php
		$dbhost = 'localhost'; // адрес сервера 
		$dbdatabase = 'my_db'; // имя базы данных
		$dbuser = 'mysql'; // имя пользователя
		$dbpassword = 'mysql'; // пароль

		$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbdatabase) 
	    		or die("Ошибка 0" . mysqli_error($link));

		if(isset($_POST['meroname']) && isset($_POST['merodatime']) && isset($_POST['merodescr'])) {
			$query = "UPDATE merop SET descr = '". $_POST['merodescr'];
			$query .= "', dattime = '". $_POST['merodatime'];
			$query .= "', name = '". $_POST['meroname'];
			$query .="'  WHERE org='". $_POST['mail'] ."' and id='". $_POST['meroid'] ."'";
			echo( "</br>".$query."</br></br>");
			$result = mysqli_query($link, $query) or die("Ошибка 1" . mysqli_error($link));
		}

	    $query = "SELECT * FROM merop WHERE org='".$_POST['mail']."' and id='".$_POST['meroid']."'";

		$result = mysqli_query($link, $query)->fetch_assoc() or die("Ошибка 2" . mysqli_error($link));

		$mername = $result['name'];
		$merdatim = $result['dattime'];
		$merdescr = $result['descr'];
		echo "<br>".$result['dattime']."<br>";

		$cont = '
			<form name="newMeroTitle" method="post">
				<input type="hidden" name="pwd" value="'. $_POST['pwd'] .'">
				<input type="hidden" name="mail" value="'. $_POST['mail'] .'">
				<input type="hidden" name="meroid" value="'. $_POST['meroid'] .'">
				<input type="text" name="meroname" value="'. $mername .'">
				<input type="datetime" name="merodatime" value="'. $merdatim .'"><br>
				<textarea name="merodescr" cols="47" rows="4">'. $merdescr .'</textarea><br>
				<input type="submit" value="Сохранить">
			</form><br>
		';
		echo $cont;

		mysqli_close($link);
	?>
	<hr>

	<h3>Гости:</h3>
	<p>vasya@pup.ok - Василий Пупкин[status](from db)</p>
	<p>nastena@some.nu - Настя с соседнего падика[status](from db)</p>
	<form name="newGuest" method="get">
		<input type="text" name="newGuestName" placeholder="ФИО">
		<input type="text" name="newGuestmail" placeholder="E-mail"><br>
		<input type="radio" name="Gueststatus"> status1(from db)<br>
		<input type="radio" name="Gueststatus"> status2(from db)<br>
		<input type="text" name="newGueststatus" placeholder="новый статус">
		<input type="submit" value="Добавить гостя">
	</form>
	<hr>

	<h3>События:</h3>
	<p>Официальная часть - 2022-03-15T13:00; 1ч(from db)</p>
	<p>Фотосессия - 2022-03-15T14:00; 1ч(from db)</p>
	<p>Банкет - 2022-03-15T15:00; 5ч(from db)</p>
	<form name="newEvent" method="get">
		<input type="text" name="newEventName" placeholder="Название">
		<input type="datetime-local" name="newEventdatime"><br><br>
		<input type="text" name="newEventTime" placeholder="длительность">
		<input type="submit" value="Добавить событие">
	</form>
	<hr>

	<h3>Участники:</h3>
	<p>vasya@pup.ok - Василий Пупкин(from db)</p>
	<p>nastena@some.nu - Настя с соседнего падика(from db)</p>
	<form name="newStaff" method="get">
		<input type="text" name="newStaffName" placeholder="ФИО">
		<input type="text" name="newStaffmail" placeholder="E-mail"><br>
		<input type="submit" value="Добавить участника">
	</form>
	<hr>
</body>
</html>