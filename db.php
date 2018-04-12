<?php
/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = 'compsci';
$db = 'CSIE';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
