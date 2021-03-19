<?php
namespace Bank;
use Vartotojas\User;

class UserController
{

    public function index()
    {
        $pageTitle = 'Welcome to TESO!';
        $users = Json::getDB()->readData();
        require DIR . '/viewPage/index.php';
    }
    public function create()
    {
        $pageTitle = 'Create new account';
        require DIR . '/viewPage/create.php';
    }
    public function store()
    {
        //Name and surname
        $user = new User;
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            header('Location: '.URL.'create');
            die;
            }
        if($user -> validation($_POST['name']) && $user -> validation($_POST['surname'])){
            $user->setName($_POST['name']);
            $user->setSurname($_POST['surname']);
        } else {
            $pageTitle = 'ERROR';
            $errorMsg = '<h3 class="errorMsg">You have enter a bad name or surname</h3>';
            require DIR . '/viewPage/create.php';
            die;
        }
        //Account number
        $user->accId = $_SESSION['readonly']; //Json::getDB() -> accountExist();
        if(isset($_SESSION['readonly'])) {
            unset($_SESSION['readonly']);
        }
        //users Identification
        if($user -> isIdUniq($_POST['idNumber'])) {
            if($user -> finalCheckID($_POST['idNumber'])){
                $user->setIdNumber($_POST['idNumber']);
                $_SESSION['success'] = '<div class="MMmsg">Account successfully created <i class="fa fa-check" aria-hidden="true"></i></div>';
            } else {
                $pageTitle = 'ERROR';
                $errorMsg = '<h3 class="errorMsg">You have enter bad ID</h3>';
                require DIR . '/viewPage/create.php';
                die;
            }
        } else {
            $pageTitle = 'ERROR';
            $errorMsg = '<h3 class="errorMsg">This ID already exist</h3>';
            require DIR . '/viewPage/create.php';
            die;
        }
            $user->addUser($user);
            header('Location: ' . URL);
            die;
        }
    public function edit(int $id)
    {   if(!$id == null) {
        $pageTitle = 'Top up balance';
        $user = Json::getDB()->getUser($id);
        require DIR . '/viewPage/addFunds.php';
        } else {
            $pageTitle = perm;
            require DIR . '/viewPage/msg.php';
            die;
        }
    }
    public function edit2(int $id)
    {   if(!$id == null) {
        $pageTitle = 'Withdraw funds';
        $user = Json::getDB()->getUser($id);
        require DIR . '/viewPage/withdraw.php';
        } else {
            $pageTitle = perm;
            require DIR . '/viewPage/msg.php';
            die;
        }
    }
    public function deleteUser(int $id)
    {
        if (!$id == null) {
            $user = Json::getDB()->getUser($id);
            if ($user->balance == 0) {
                $_SESSION['success'] = '<div class="MMmsg">'.$user -> name.' '. $user -> surname. ' ID # '. $user-> uniqID.
                ' has been successfully deleted <i class="fa fa-check" aria-hidden="true"></i></div>';
                Json::getDB()->deleteUser($id);
                header('Location: ' . URL);
                die;
            } else {
                $pageTitle = 'You cannot delete with a positive balance, sorry';
                require DIR . '/viewPage/msg.php';
                die;
            }
        } else {
            $pageTitle = perm;
            require DIR . '/viewPage/msg.php';
            die;
        }
    }
/**************************************************CURRENCY*****************************************************/
/*
public function currency(){
  $currObj = new Currency;
  $currObj -> getCurrExchange(); //parsisiuncia data ir iraso i json faila;
  $currYouWant = 'USD';
  $rez = $currObj -> getCurrency($currYouWant);
  $rezArr[0] = $rez; 
  $rezArr[1] = $currYouWant;
  return $rezArr;
}
*/


public function checkCache($curr) {
    $cache = new Currency;
    $cache -> oneTimeScen();
    $cache -> currencyUpd(); // return $rez = $cache -> currencyUpd();
    $value = $cache -> getCurrency($curr);
    return $value;
}
}
