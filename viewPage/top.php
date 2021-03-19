<?php
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: http://localhost/php_proj/OOPbank/login.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <!--
   <link rel="preload" as="font" type="font/woff2"
    href="../../fonts/nanum-gothic-v17-latin-regular.woff2" crossorigin>
    -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<link rel="stylesheet" href=" <?= URL ?>public/css/app.css">
<link rel="stylesheet" href=" <?= URL ?>public/css/custom.css">
<link rel="stylesheet" href="<?= URL ?>font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body class="bg">
    <div class="allContent">
        <div class="content center">