<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Консоль OS Draenor</title>
		<link href="fav.ico" rel="icon" type="image/x-icon">
		<link href="fav.ico" rel="shortcut icon" type="image/x-icon">
		<link href="css/style.css" rel="stylesheet" type="text/css"/>
		<script src="js/jquery.js" type="text/javascript" language="javascript"></script>	
		<script src="js/JSTry.js" type="text/javascript" language="javascript"></script>
		<script src="js/input_output.js" type="text/javascript" language="javascript"></script>
		<script src="js/actions.js" type="text/javascript" language="javascript"></script>		
		<script src="js/Fil.js" type="text/javascript" language="javascript"></script>		
		<script src="js/Proccess.js" type="text/javascript" language="javascript"></script>		
	</head>
	<body>
		<div id="main">
			<!-- Модули окон -->
			<?php
				// Окно файла
				include_once "blocks/file_window.php";

				// Окно списка команд
				include_once "blocks/list_commands.php";		

				// Окно процессов
				include_once "blocks/process.php";
			 ?>
			<!-- End Модули окон -->
			<header>
				<div id="sitename">
					<h1>Операционная система Draenor</h1>
					<h4>&copy; Alexey Gabrusev</h4>
				</div>
				<div id="user-info">
					<?php
						require_once "classes/User.php";
						$user = new User();
					 ?>
					<div id="user-foto"><img src="img/profile.jpg" width="70"/></div>
					<div id="user-details"><h4><?php echo $user->getUserInfo()['name']; ?></h4><p id="role">
						<?php echo $user->getUserInfo()['role']; ?>
					</p></div>
				</div>				
			</header>			
			<article>
				<div id="help_panel">
					<h3>Консоль ОС</h3>				
					<div id="options">Список команд</div>
					<div id="process">Процессы</div>
				</div>
				<hr>				
				<div id="console">
					<div id="cosnoleDisplay"></div>
					<div class="clr"></div>				
				</div>
				<div id="system-msg"></div>					
				<div id="console-input">
					<input type="text" id="consoleInput" placeholder="Введите команду системы Draenor">
				</div>						
			</article>						
		</div>
	</body>
</html>