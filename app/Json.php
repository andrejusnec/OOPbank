<?php
namespace Bank;
use Vartotojas\User;

class Json {

    private static $jsonObject;
    private $data;
    
    public static function getDB() {
        return self::$jsonObject ?? self::$jsonObject = new self; //grazina objekta, jeigu jo nera , tai sukuriu nauja ir priskiriu
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
        file_put_contents(DIR.'/data/users.json', json_encode($this -> data)); // kai objektas pabaigia darba , pries mirti iraso 
        //duomenis i faila.
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
        $pos = json_decode($pos, 1);
        $id = (int) $pos['id'];
        $pos['id'] = $id + 1;
        $pos = json_encode($pos);
        file_put_contents(DIR.'/data/id.json', $pos);
        return $id;
    }
    
    public function addUser(User $user) : void{ //Box $name,Box $surname, Box $accID, Box $personalID
        $id = $this -> getCurrentPos();    // pasiemu esama laisva pozicija per metoda
        $user -> uniqID = (int) $id;
        $this -> data[] = $user;   //+
    }
    public function update(object $useris) : void {
        foreach($this -> data as $key => $user) { //prasibegu pro visus userius
            if($user -> uniqID == $useris -> uniqID) {  
                $this -> data[$key] = $useris; 
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
                $count = ifFloat($count);  //suroundinu gauta skaiciu
                $user['balance'] -= $count;  // atimu reiksme nuo esamo balanso
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
    public function accountExist() {
        $users = $this -> data;
        $accID = $this -> generateAcc();
        if(!empty(DIR.'/data/users.json') && $users != []) { //jeigu failas yra ir nera tuscias
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
    public function isIDmatch($id) {
        $goodID = false;
        $pattern = "/^[3-6](\d{2})(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{4}$/";
        if(preg_match($pattern, $id) == 1) {
            $goodID = true;
        }
        return $goodID;
    }
    public function ifFloat($number) {
        if(str_contains($number,'.')) { //jeigu yra taskas(kablelis)
        $num = strval($number); //paverciu i stringa
        $arr = explode('.', $num); //padalinu per kableli
        if(isset($arr[2])) { //jei prideda daugiau negu vienas kablelis
            return null;
        }
        if(strlen($arr[1]) > 2)  {
            $number = round($number, 2);
            return $number;
        }else {
            return $number;
        }
    } else {
        return $number;
    }
    }
    public function chechID($id) :bool {
        $goodID = false;
        $arr  = array_map('intval', str_split($id));
        $summ = ($arr[0] * 1) + ($arr[1] * 2) + ($arr[2] * 3) + ($arr[3] * 4) + ($arr[4] * 5) + ($arr[5] * 6) + ($arr[6] * 7) +
        ($arr[7] * 8) + ($arr[8] * 9) + ($arr[9] * 1);
        if($summ % 11 == 10) {
            $summ = ($arr[0] * 3) + ($arr[1] * 4) + ($arr[2] * 5) + ($arr[3] * 6) + ($arr[4] * 7) + ($arr[5] * 8) + ($arr[6] * 9) +
        ($arr[7] * 1) + ($arr[8] * 2) + ($arr[9] * 3);
            if($summ % 11 != 10) {
                if($summ % 11 == $arr[10]) {
                    $goodID = true;
                }
            }
            if($summ % 11 == 10 && $arr[10] == 0) {
                $goodID = true;
            }
        }else {
            $goodID = true;
        }
        return $goodID;
    }
    public function isIdUniq(int $idNumber) : bool {
        $IdUniq = true;
        foreach($this -> data as $user) {
            if($user -> idNumber == $idNumber) {
                $IdUniq = false;
                return $IdUniq;
            }
        }
        return $IdUniq;
    }
}
?>