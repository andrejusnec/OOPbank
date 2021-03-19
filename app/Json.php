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
    public function writeData($data) : void {
        $this -> data[] = $data;
    }
    public function getUser(int $id) : ?object {
        foreach($this -> data as $user) {
            if($user -> uniqID == $id) {
                return $user;
            }
        }
        return null;
    }
    public function getCurrentPos() : int { //buvo private
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
    public function update(object $useris) : void {
        foreach($this -> data as $key => $user) { //prasibegu pro visus userius
            if($user -> uniqID == $useris -> uniqID) {  
                $this -> data[$key] = $useris; 
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
    /////////////
    /*
    public function addUser(User $user) : void{ //Box $name,Box $surname, Box $accID, Box $personalID
        $id = $this -> getCurrentPos();    // pasiemu esama laisva pozicija per metoda
        $user -> uniqID = (int) $id;
        $this -> data[] = $user;   //+
    }
    */
    ////////////
}
?>