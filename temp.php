<?php
$staff = [
    ['name' => 'Andrejus', 'surname' => 'Nec', 'pass' => password_hash('12345', PASSWORD_DEFAULT)],
    ['name' => 'Kempinsi', 'surname' => 'Nek', 'pass' => password_hash('454541151ffff', PASSWORD_DEFAULT)],
];

file_put_contents(__DIR__.'/data/staff.json', json_encode($staff));
?>