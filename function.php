<?php 
function readData() :array { //parasau kad funkcija turi grazinti tik masiva
    if(!file_exists(DIR.'/json/users.json')) {
        $data = json_encode([]); //tuscia masyva sudecodinu ir irasau i faila
        file_put_contents(DIR.'/json/users.json', $data);
    }
    $data = file_get_contents(DIR.'/json/users.json');
    return json_decode($data, 1);
}
function writeData(array $data) : void {
    $data = json_encode($data, 1);
    file_put_contents(DIR.'/json/users.json', $data);
}
function getCurrentPos() : int {
    if(!file_exists(DIR.'/json/id.json')) {
        $pos = json_encode(['id'=> 1]);
        file_put_contents(DIR.'/json/id.json', $pos);
    }
    $pos = file_get_contents(DIR.'/json/id.json');
    $pos = json_decode($pos, 1);
    $id = (int) $pos['id'];
    $pos['id'] = $id + 1;
    $pos = json_encode($pos);
    file_put_contents(DIR.'/json/id.json', $pos);
    return $id;
}
function randomID() : int {
    $memory = [];
    $randomID = rand(1,500);
    $flag = true;
    while($flag) {
        if(in_array($randomID, $memory)) {
            $randomID = rand(1,500); 
        } else {
            $memory[] = $randomID;
            $flag = false;
        }
    }
    return $randomID;
}

function addUser($name, $surname, $accID, $personalID) : void{
    $users = readData();
    $id = getCurrentPos();      //randomID();  //Gali buti bedu
    $user = ['uniqID'=> $id ,'name' => $name,'surname' => $surname,'accId' => $accID, 'idNumber' => $personalID,
'balance' => 0];
    $users[] = $user;
    writeData($users);
}
function getUser(int $id) : ?array {
    foreach(readData() as $user) {
        if($user['uniqID'] == $id) {
            return $user;
        }
    }
    return null;
}

function addFunds(int $id, float $count) : void {
    $users = readData();// all users
    $user = getUser($id);
    if(!$user) {
        return;
    }
    $count = ifFloat($count);
    $user['balance'] += $count;
    deleteUser($id);
    $users = readData(); // users without deleted one
    $users[] = $user; 
    writeData($users);
}
function removeFunds(int $id, float $count){
    $users = readData();// all users
    $user = getUser($id);
    if(!$user) {
        return;
    }
    ifFloat($count);
    $user['balance'] -= $count;
    deleteUser($id);
    $users = readData(); // users without deleted one
    $users[] = $user; 
    writeData($users);
}
function deleteUser(int $id) : void {
    $users = readData();
    foreach($users as $key => $user) {
        if ($user['uniqID'] == $id) {
            unset($users[$key]);
            writeData($users);
            return;
        }
    }
}
function generateAcc() {
    $str = 'LT07 3000 0';
    $space = ' ';
    for($i = 0; $i < 13; $i++) {
         if ($i == 3 || $i == 8) {
            $str .= $space;
        } else {
            $str .= rand(0, 9);
        }
    }
    return $str;
}
function accExist() {
    $users = readData();
    $accID['accId'] = generateAcc();
    if(!empty(DIR.'/json/users.json') && $users !== []) { //jeigu failas yra
        $isNotUniqueID = true;
        do{
            $accID['accId'] = generateAcc(); // priskiriu saskaita
            $flag = false;
            foreach($users as $memb) { //pereinu per esamus userius
                if($accID['accId'] == $memb['accId']) { //jeigu saskaita sutampa
                    $flag = true;
                    break; 
                }
            }
            $isNotUniqueID = $flag;
        }while($isNotUniqueID);
        return $accID['accId'];
    } else {
        return $accID['accId'];
    }
}
function notZero(int $id) : bool {
    $notZero = false;
    $data = readData();
foreach($data as $user){
    if($user['uniqID'] == $id) {
        if($user['balance'] != 0) {
            $notZero = true;
            break;
        }
    }
} return $notZero;
}
function isIDmatch($id) {
    $goodID = false;
    $pattern = "/^[3-6](\d{2})(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{4}$/";
    if(preg_match($pattern, $id) == 1) {
        $goodID = true;
    }
    return $goodID;
}
function ifFloat($number) {
    if(str_contains($number,'.')) {
    $num = strval($number);
    $arr = explode('.', $num);
    _d($arr[1]);
    if(strlen($arr[1]) > 2) {
        $num = round($number, 2);
        return $num;
    }else {
        return $number;
    }
} else {
    return $number;
}
}
?>