<?php
namespace Vartotojas;
use Bank\Json;
    class User {
        public $name, $surname, $accId, $idNumber,$uniqID;
        public $balance = 0;

/***************************************************USER ID CHECH*****************************************************/
        public function isIDmatch($id) :bool {
            $goodID = false;
            $pattern = "/^[3-6](\d{2})(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{4}$/";
            if(preg_match($pattern, $id) == 1) {
                $goodID = true;
            }
            return $goodID;
        }
        public function checkID($id) :bool {
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
            $allUsers = Json::getDB() ->readData();
            foreach($allUsers as $user) {
                if($user -> idNumber == $idNumber) {
                    $IdUniq = false;
                    return $IdUniq;
                }
            }
            return $IdUniq;
        }
        public function finalCheckID($idNumber) {
            $idIsGood = false;
            if(($this -> isIDmatch($idNumber)) && ($this -> checkID($idNumber))) {
                $idIsGood = true;
            }
            return $idIsGood;
        }
        public function validation(string $name) :bool {
            $validText = false;
            $rexSafety = "([a-zA-Z]{3,30}\s*)";
            if(preg_match($rexSafety, $name) && strlen($name) <= 30){
                $validText = true;
        }
        return $validText;
    }
    /************************************************SET and GET**********************************************/
    public function getName() {
        return $this->name;
    }
    public function geSurname() {
        return $this->surname;
    }
    public function getAccId() {
        return $this->accId;
    }
    public function getIdNumber() {
        return $this->idNumber;
    }
    public function getBalance() {
        return $this->balance;
    }
    /////////////////////////////////////////////
    public function setName($name) {
        $this -> name = $name;
    }
    public function setSurname($surname) {
        $this -> surname = $surname;
    }
    public function setAccId($accId) {
        $this -> accId = $accId;
    }
    public function setIdNumber($idNumber) {
        $this -> idNumber = $idNumber;
    }
    public function setBalance() {
        $this -> balance = $balance;
    }

/////////////////////////////////////////////////////////////////////
public function addUser(User $user) : void{ //Box $name,Box $surname, Box $accID, Box $personalID
    $id = Json::getDB() -> getCurrentPos();    // pasiemu esama laisva pozicija per metoda
    $user -> uniqID = (int) $id;
    Json::getDB() -> writeData($user);   //+
}

}


?>