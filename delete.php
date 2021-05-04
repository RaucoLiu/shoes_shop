<?php

$link = mysqli_connect("localhost","root","","shoes")or die(mysqli_connect_error());
$result = mysqli_query($link,"set names utf8");

$id = $_GET["id"];

$sql = <<<sqlStatement
    delete from `orders`
    where id = $id
sqlStatement;

$result = mysqli_query($link,$sql);

// echo $sql;

header("location: bag.php");
exit();


















?>