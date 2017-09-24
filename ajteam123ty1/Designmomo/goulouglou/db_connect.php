<?php
error_reporting(E_ALL ^ E_NOTICE);
$host     = '127.0.0.1';
$username = 'sa';
$pass     = '123456';
$link = @mssql_connect($host, $username, $pass) or Die("Failed to connect to MSSQL server");
?>