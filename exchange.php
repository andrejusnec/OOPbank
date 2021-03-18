<?php
define('API','https://api.exchangeratesapi.io/latest');

//POST scenarijus

//
$eur = 0;
$usd = 0;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, API);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$answer = curl_exec($curl);

curl_close($curl);
$_SESSION['test'] = $answer;
//_d($_SESSION['test']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>currency</title>
</head>
<body>
    <h2> <?php //echo $_SESSION['test'] ?></h2>
</body>
</html>