<?php 
    require __DIR__.'/default.php';

$uri = explode('/', str_replace(INSTALL_DIR, '', $_SERVER['REQUEST_URI']));

// ROUTING'AS
if('' == $uri[0]) {
    (new UserCreate) ->index();
} else if('create' == $uri[0]) {
    (new UserCreate) ->create();
} else if('store' == $uri[0]) {
    (new UserCreate) ->store();
} else if('edit' == $uri[0]) {
    if(isset($uri[1])){
        (new UserCreate) ->edit((int) $uri[1]); 
    } else {
        $uri[1] = null;
        (new UserCreate) ->edit((int) $uri[1]); 
    }
} else if('addFunds' == $uri[0]) {
    (new UserCreate) ->addFunds((int) $uri[1]); //update
}else if('delete' == $uri[0]) { 
    if(isset($uri[1])){
        (new UserCreate) ->deleteUser((int) $uri[1]); 
    } else {
        $uri[1] = null;
        (new UserCreate) ->deleteUser((int) $uri[1]); 
    }
}else if('edit2' == $uri[0]) {
    if(isset($uri[1])){
        (new UserCreate) ->edit2((int) $uri[1]);
        }else {
            $uri[1] = null;
            (new UserCreate) ->edit((int) $uri[1]); 
        }
}else if('withdraw' == $uri[0]) { 
    (new UserCreate) ->withdraw((int) $uri[1]); //update
}
?>