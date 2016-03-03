<?php

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'test_upload';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);


$query_insert="UPDATE upload_result 
				SET answer_value='".$_GET['site']."'
				WHERE user_name='".$_GET['key_name']."'";

						//echo $query_insert;

$result_insert = $mysqli->query($query_insert) or die($mysqli->error.__LINE__);

$result_insert = $mysqli->affected_rows;



?>