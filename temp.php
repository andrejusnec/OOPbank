<?php
$staff = [
    ['name' => 'Andrejus', 'surname' => 'Nec', 'pass' => password_hash('12345', PASSWORD_DEFAULT)],
    ['name' => 'Ksiu', 'surname' => 'Sabliukova', 'pass' => password_hash('7534286', PASSWORD_DEFAULT)],
];

file_put_contents(__DIR__.'/data/staff.json', json_encode($staff));
?>