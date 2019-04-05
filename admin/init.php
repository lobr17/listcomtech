<?php
session_start();
ini_set('display_errors', 'on');
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';
$password = '';
$db_name = 'listcomtech';

$link = mysqli_connect($host, $user, $password, $db_name) or die(mysqli_error($link));
mysqli_query($link, "SET NAMES 'utf8'");