<?php
class UserCreate
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
        $user = new User;
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            header('Location: '.URL.'create');
            die;
            }
        if($this -> validation($_POST['name']) && $this -> validation($_POST['surname'])){
            $user->name = $_POST['name'];
            $user->surname = $_POST['surname'];
        } else {
            $pageTitle = 'ERROR';
            $errorMsg = '<h3 class="errorMsg">You have enter a bad name or surname</h3>';
            require DIR . '/viewPage/create.php';
            die;
        }
        $user->accId = $_SESSION['readonly']; //Json::getDB() -> accountExist();
        if(isset($_SESSION['readonly'])) {
            unset($_SESSION['readonly']);
        }
        //$user->idNumber = $_POST['idNumber'];
        if(Json::getDB() -> isIDmatch($_POST['idNumber'])){
            $user->idNumber = $_POST['idNumber'];
        } else {
            $pageTitle = 'ERROR';
            $errorMsg = '<h3 class="errorMsg">You have enter bad ID</h3>';
            require DIR . '/viewPage/create.php';
            die;
        }
        Json::getDB()->addUser($user);
        header('Location: ' . URL);
        die;
    }
    public function edit(int $id)
    {   if(!$id == null) {
        $pageTitle = 'Add funds';
        $user = Json::getDB()->getUser($id);
        require DIR . '/viewPage/addFunds.php';
        } else {
            $pageTitle = 'You cannot add funds using topnav XIXI';
            require DIR . '/viewPage/msg.php';
            die;
        }
    }
    public function addFunds(int $id)
    {
        $user = Json::getDB()->getUser($id);
        $user->balance += (int) $_POST['funds'];

        Json::getDB()->update($user);
        header('Location: ' . URL);
        die;
    }public function edit2(int $id)
    {   if(!$id == null) {
        $pageTitle = 'Withdraw funds';
        $user = Json::getDB()->getUser($id);
        require DIR . '/viewPage/withdraw.php';
        } else {
            $pageTitle = 'You cannot withdraw funds using topnav Xa xa';
            require DIR . '/viewPage/msg.php';
            die;
        }
    }
    public function withdraw(int $id)
    {
        $user = Json::getDB()->getUser($id);
        $user->balance -= (int) $_POST['funds'];

        Json::getDB()->update($user);
        header('Location: ' . URL);
        die;
    }
    public function deleteUser(int $id)
    {
        if (!$id == null) {
            $user = Json::getDB()->getUser($id);
            _d($user);
            if ($user->balance == 0) {
                _d($user)->balance;
                Json::getDB()->deleteUser($id);
                header('Location: ' . URL);
                die;
            } else {
                $pageTitle = 'You cannot delete with a positive balance, sorry';
                require DIR . '/viewPage/msg.php';
                die;
            }
        } else {
            $pageTitle = 'You cannot delete account using navbar, sorry';
            require DIR . '/viewPage/msg.php';
            die;
        }
    }
    public static function validation($name) :bool {
        $rexSafety = "([a-zA-Z]{3,30}\s*)";
        if(preg_match($rexSafety, $name) && strlen($name) <= 30){
            return true;
        } else {
            return false;
    }
}
}
