<?php
namespace Bank;
    class Account {

        private function generateAcc() {
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
            $users = Json::getDB() -> readData(); // Json::getDB($path)
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

        public function withdraw(int $id){  
            $user = Json::getDB()->getUser($id);
            if(!isset($_POST['funds'])) {
                require DIR . '/viewPage/withdraw.php';
                die;
            }
            if(is_numeric($_POST['funds'])) {
                $number = $this -> ifFloat($_POST['funds']);
                if($user->balance < $number  || $number <= 0) {
                    $pageTitle = 'ERROR';
                    $errorMsg = '<h3 class="errorMsg">You have entered invalid amount.<br>Try again</h3>';
                    require DIR . '/viewPage/withdraw.php';
                    die;
                }else {
                $user->balance -= $number;
                $user->balance = round($user->balance, 2);
                Json::getDB()->update($user);
                $_SESSION['success'] = '<div class="MMmsg">'.round($_POST['funds'], 2).' EUR were successfully withdrawn from ID # '.$user-> uniqID.' account <i class="fa fa-check" aria-hidden="true"></i></div>';
                header('Location: ' . URL);
                die;
                }
            } else {
                $pageTitle = 'ERROR';
                $errorMsg = '<h3 class="errorMsg">You\'re entry isn\'t a number.<br>Try again</h3>';
                require DIR . '/viewPage/withdraw.php';
                die;
            }
            }
            public function addFunds(int $id){
                $user = Json::getDB()->getUser($id);
                if(!isset($_POST['funds'])) {
                    require DIR . '/viewPage/addFunds.php';
                    die;
                }
                if($_POST['funds'] > 0 && $_POST['funds'] < 100000000){
                $amount = $user -> balance;
                $amount += round((float) $_POST['funds'], 2);
                $user->balance = $amount;
                Json::getDB()->update($user);
                $_SESSION['success'] = '<div class="MMmsg">'.round($_POST['funds'], 2).' EUR were successfully added to ID # '.$user-> uniqID.' account <i class="fa fa-check" aria-hidden="true"></i></div>';
                header('Location: ' . URL);
                die;
                } else {
                    $pageTitle = 'ERROR';
                    $errorMsg = '<h3 class="errorMsg">You have entered invalid amount.<br>Try again</h3>';
                    require DIR . '/viewPage/addFunds.php';
                    die;
                }
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
    
            
    }
?>