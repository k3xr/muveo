<?php

include_once 'configuration.php';   // As functions.php is not included
include_once 'forPagination/pagingwithmysqli.cls.php';
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

$db_try = new PagingWithMySQLi(HOST, USER, PASSWORD, DATABASE, 3306);
?>