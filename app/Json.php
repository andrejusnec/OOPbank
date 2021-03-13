<?php 

class Json {

    private static $jsonObject;
    private $data;
    
    public static function getDB() {
        return self::$jsonObject ?? self::$jsonObject = new self; //grazina objektas, jeigu jo nera , tai sukuriu nauja ir priskiriu
    }
    private function __construct() {
        if(!file_exists(DIR.'/data/users.json')) {
            $dataFile = json_encode([]); //tuscia masyva sudecodinu ir irasau i faila
            file_put_contents(DIR.'/data/users.json', $dataFile);
        }
        $dataFile = file_get_contents(DIR.'/data/users.json');
        $this -> data = json_decode($dataFile); //1 reik nereik??
    }
    public function __destruct() {
        file_put_contents(DIR.'/data/users.json', json_encode($this -> data));
    }
/*************************************************************************************************************************/
    public function readData() //:array 
    { 
        return $this -> data;
    }
    public function writeData(array $data) : void {
        $this -> data = json_encode($data);
    }
    public function getUser(int $id) : ?object {
        foreach($this -> data as $user) {
            if($user -> uniqID == $id) {
                return $user;
            }
        }
        return null;
    }
    private function getCurrentPos() : int {
        if(!file_exists(DIR.'/data/id.json')) {
            $pos = json_encode(['id'=> 1]);
            file_put_contents(DIR.'/data/id.json', $pos);
        }
        $pos = file_get_contents(DIR.'/data/id.json');
        $pos = json_decode($pos, 1   );
        $id = (int) $pos['id'];
        $pos['id'] = $id + 1;
        $pos = json_encode($pos);
        file_put_contents(DIR.'/data/id.json', $pos);
        return $id;
    }
    
    public function addUser(User $user) : void{ //Box $name,Box $surname, Box $accID, Box $personalID
        $id = $this -> getCurrentPos();    // pasiemu esama laisva pozicija per metoda
        $user -> uniqID = (int) $id;
        $this -> data[] = $user;
    }
    public function update(object $useris) : void {
        foreach($this -> data as $key => $user) { //prasibegu pro visus userius
            if($user -> uniqID == $useris -> uniqID) {  //
                $this -> data[$key] = $useris; // CHECK THIS <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                return;
            }
        }
    }
    public function removeFunds(int $id, float $count){
        $user = $this -> getUser($id); //gaunu useri
        if(!$user) {            // patikrinu ar yra toks
            return;
        }
        foreach($this -> data as $key => $user) { //prasibegu pro visus userius
            if($user['uniqID'] == $id) {  //jeigu radau reikiama
                $count = ifFloat($count);  //suroundinu skaiciu
                $user['balance'] -= $count;  // pridedu reiksme prie esamos
                $this -> data[$key] = $user; 
                return;
            }
        }
    }
    public function deleteUser(int $id) : void {
       foreach($this -> data as $key => $user) {
            if ($user -> uniqID  == $id) {
                unset($this -> data[$key]);
                $this->data = array_values($this->data);
                return; 
            }   
        } 
    }
    public function generateAcc() {
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
    function accountExist() {
        $users = $this -> data;
        $accID = $this -> generateAcc();
        if(!empty(DIR.'/data/users.json') && $users !== []) { //jeigu failas yra
            $isNotUniqueID = true;
            do{
                $accID = $this -> generateAcc(); // priskiriu saskaita
                $flag = false;
                foreach($users as $memb) { //pereinu per esamus userius
                    if($accID == $memb -> accId) { //jeigu saskaita sutampa
                        $flag = true;
                        break; 
                    }
                }
                $isNotUniqueID = $flag;
            }while($isNotUniqueID);
            return $accID;
        } else {
            return $accID;
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
}
?>