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
        //Name and surname
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
        //Account number
        $user->accId = $_SESSION['readonly']; //Json::getDB() -> accountExist();
        if(isset($_SESSION['readonly'])) {
            unset($_SESSION['readonly']);
        }
        //users Identification
        if(Json::getDB() -> isIdUniq($_POST['idNumber'])) {
            if(Json::getDB() -> isIDmatch($_POST['idNumber']) && Json::getDB() -> chechID($_POST['idNumber'])){
                $user->idNumber = $_POST['idNumber'];
                $_SESSION['success'] = '<div class="MMmsg">Account successfully created</div>';
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
            $pageTitle = perm;
            require DIR . '/viewPage/msg.php';
            die;
        }
    }
    public function addFunds(int $id)
    {
        $user = Json::getDB()->getUser($id);
        if($_POST['funds'] > 0 && $_POST['funds'] < 100000000){
        $user->balance += round((float) $_POST['funds'], 2);
        Json::getDB()->update($user);
        $_SESSION['success'] = '<div class="MMmsg">'.$_POST['funds'].' EUR were successfully added to ID # '.$user-> uniqID.' account</div>';
        header('Location: ' . URL);
        die;
        } else {
            $pageTitle = 'ERROR';
            $errorMsg = '<h3 class="errorMsg">You have entered invalid amount.<br>Try again</h3>';
            require DIR . '/viewPage/addFunds.php';
            die;
        }
    }public function edit2(int $id)
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
    public function withdraw(int $id)
    {  
    $user = Json::getDB()->getUser($id);
    if(is_numeric($_POST['funds'])) {
        $number = Json::getDB() -> ifFloat($_POST['funds']);
        if($user->balance < $number  || $number <= 0) {
            $pageTitle = 'ERROR';
            $errorMsg = '<h3 class="errorMsg">You have entered invalid amount.<br>Try again</h3>';
            require DIR . '/viewPage/withdraw.php';
            die;
        }else {
        $user->balance -= $number;
        $user->balance = round($user->balance, 2);
        Json::getDB()->update($user);
        $_SESSION['success'] = '<div class="MMmsg">'.$_POST['funds'].' EUR were successfully withdrawn from ID # '.$user-> uniqID.' account</div>';
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
    public function deleteUser(int $id)
    {
        if (!$id == null) {
            $user = Json::getDB()->getUser($id);
            if ($user->balance == 0) {
                $_SESSION['success'] = '<div class="MMmsg">'.$user -> name.' '. $user -> surname. ' ID # '. $user-> uniqID.
                ' has been successfully deleted</div>';
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
    public static function validation($name) :bool {
        $rexSafety = "([a-zA-Z]{3,30}\s*)";
        if(preg_match($rexSafety, $name) && strlen($name) <= 30){
            return true;
        } else {
            return false;
    }
}
}
