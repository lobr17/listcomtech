<?php

require_once("db_connect.php");
//require_once("index.php");

$query = "SELECT * FROM list";
//echo $query;
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;

var_dump($data);
?>


<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Загрузка изображения с изменением размеров</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <img src=<?=$data['0']['foto'];?>>
</body>
</html>
