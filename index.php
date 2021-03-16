<?php 
    require __DIR__.'/default.php';
    

$uri = explode('/', str_replace(INSTALL_DIR, '', $_SERVER['REQUEST_URI']));

// ROUTING'AS
if('' == $uri[0]) {
    (new Bank\UserController) ->index();
} else if('create' == $uri[0]) {
    (new Bank\UserController) ->create();
} else if('store' == $uri[0]) {
    (new Bank\UserController) ->store();
} else if('edit' == $uri[0]) {
    if(isset($uri[1])){
        (new Bank\UserController) ->edit((int) $uri[1]); 
    } else {
        $uri[1] = null;
        (new Bank\UserController) ->edit((int) $uri[1]); 
    }
} else if('addFunds' == $uri[0]) {
    (new Bank\UserController) ->addFunds((int) $uri[1]); //update
}else if('delete' == $uri[0]) { 
    if(isset($uri[1])){
        (new Bank\UserController) ->deleteUser((int) $uri[1]); 
    } else {
        $uri[1] = null;
        (new Bank\UserController) ->deleteUser((int) $uri[1]); 
    }
}else if('edit2' == $uri[0]) {
    if(isset($uri[1])){
        (new Bank\UserController) ->edit2((int) $uri[1]);
        }else {
            $uri[1] = null;
            (new Bank\UserController) ->edit((int) $uri[1]); 
        }
}else if('withdraw' == $uri[0]) { 
    (new Bank\UserController) ->withdraw((int) $uri[1]); //update
}
?>