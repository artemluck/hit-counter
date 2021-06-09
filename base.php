<?php
$base_host="localhost"; //указываем параметры для соединения с базой данных
$base_name="php_new";
$user_name='root';
$user_pass='';

$link = mysqli_connect($base_host, $user_name, $user_pass);//подключаемся к серверу базы данных
mysqli_query($link,"SET NAMES 'utf8';");//устанавливаем кодировку
mysqli_query($link,"SET CHARACTER SET 'utf8';");
mysqli_query($link,"SET SESSION collation_connection = 'utf8_general_ci';");

mysqli_select_db($link,$base_name); //выбираем нашу базы данных

?>