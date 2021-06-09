<?php session_start();
//счетчик 1
 $base = "session_page1.txt";//указываем название файла
	if(file_exists($base)) //если файл существует, то
		$num = file_get_contents($base); //сохраняем в переменную количество просмотров страницы
	
	if (isset($num)) //если удалось считать количество просмотров, то
	    $num++; //увеличиваем на единицу
	else
    	$num = 0; //иначе обнуляем
	
	file_put_contents($base, $num); //сохраняем в файл количество просмотров
	
	include('base.php'); //подключаем базу данных
	
//счетчик 2
   $ip = ($_SERVER["REMOTE_ADDR"]); // Преобразуем IP в число
   $path_parts = pathinfo($_SERVER['SCRIPT_NAME']);//получаем адрес страницы
   $page = $path_parts['basename'];//и имя файла
   
   $sql="SELECT * FROM `vizits` WHERE `IP`='".$ip."' and page='".$page."'"; //делаем запрос к БД, есть ли пользователь с таким IP и посещал ли он эту страницу

	$result = mysqli_query($link,$sql) or die ("Query failed");//выполняем запрос
		if (mysqli_num_rows($result)) //если есть, то обновляем счетчик посещений
			{
			  $sql2="UPDATE `vizits` SET `count`=`count`+1 WHERE `IP`='".$ip."' and page='".$page."'";
			  $result = mysqli_query ($link,$sql2) or die ("Query failed!-->".$sql2);
			}
		else {	
			  // Добавляем запись
			  $sql2="INSERT INTO `vizits` (`IP`, `count`, `page`) VALUES ('$ip', 1, '$page')";
			  $result = mysqli_query ($link,$sql2) or die ("Query failed!-->".$sql2);
		}	  
?>

<html lang="ru">
<head>
<title>Лабораторная работа 1</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="styles/style.css" rel="stylesheet" type="text/css" />

</head>
  <body>
 
  <div id="wrapper">
    <header> 
	
	<nav>
		
		<ul class="topmenu">
		
		<li><a href="index.php">Главная</a></li>
		
        <li><a href="page1.php">Страница 1</a></li>
		<li><a href="page2.php">Страница 2</a></li>
		</ul>
	  </nav>

	 
    </header>

<!--Основной контент (статья)-->
    <article>
		<? echo "Страница обновлена ".$num." раз(а).";?>
		<table>
			<tr>
			<th>№</th><th>IP</th><th>Страница</th><th>Количество</th>
			</tr>
			<?
				$i=1;
				$sql="SELECT * FROM `vizits` order by IP ASC, page ASC"; //выводим все записи из БД

				$result = mysqli_query($link,$sql) or die ("Query failed");//выполняем запрос
					if (mysqli_num_rows($result)) //если есть, то выводим
						{
							while ($rows=mysqli_fetch_assoc($result)){ //пока есть записи из запроса
								echo "<tr><td>".$i."</td><td>".$rows['IP']."</td><td>".$rows['page']."</td><td>".$rows['count']."</td></tr>"; //выводим запись
								$i++; //счетчик увеличиваем на 1
							}	
						}
			?>
		</table>
    </article>
	
	
	
  <div class="clear"></div>
    <footer>
    

    </footer>
  </div> 
  <?php mysqli_close($link)//закрываем соединение с базой данных  ?> 
</body>
</html>

    

	

	 
