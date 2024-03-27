<?php
require_once '../init.php';
Auth::preventUnauthenticated();

$data = unserialize($_POST['data']);
Utils::createTable($data,$_GET['type']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>