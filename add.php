<?php
require_once __DIR__ . "/lib/DataSource.php";
$database = new DataSource();
$query = "INSERT INTO toy (name, code, category, price, stock_count) VALUES (?, ?, ?, ?, ?)";
$paramType = 'sssii';
$paramValue = array(
    $_POST["name"],
    $_POST["code"],
    $_POST["category"],
    $_POST["price"],
    $_POST["stock_count"]
);
$insertId = $database->insert($query, $paramType, $paramValue);
?>