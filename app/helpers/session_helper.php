<?php
if(session_status() == PHP_SESSION_NONE){
    //session has not started
    ob_start();
    session_start();
}

// Flash message helper and sessions
// EXAMPLE - flash('register_success', 'You are now registered');
function flash($name = '', $message = '', $class = 'text-center alert alert-success alert-dismissible fade show'){

    if(!empty($name)){
       if(!empty($message) and empty($_SESSION[$name])){
           if(!empty($_SESSION[$name])){
               unset($_SESSION[$name]);
           }

           if(!empty($_SESSION[$name . '_class'])){
               unset($_SESSION[$name . '_class']);
           }

           $_SESSION[$name] = $message;
           $_SESSION[$name . '_class'] = $class;

       } elseif (empty($message) and !empty($_SESSION[$name])){
           $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name . '_class'] : '';

           echo '<div class="'.$class.'" id="msg-flash"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                             <span aria-hidden="true">&times;</span></button>' . $_SESSION[$name] . '</div>';
           unset($_SESSION[$name]);
           unset($_SESSION[$name. '_class']);
       }
    }
}

/// Error messages
function flash_error($name = '', $message = '', $class = 'text-center alert alert-danger alert-dismissible fade show'){

    if(!empty($name)){
        if(!empty($message) and empty($_SESSION[$name])){
            if(!empty($_SESSION[$name])){
                unset($_SESSION[$name]);
            }

            if(!empty($_SESSION[$name . '_class'])){
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;

        } elseif (empty($message) and !empty($_SESSION[$name])){
            $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name . '_class'] : '';

            echo '<div class="'.$class.'" id="msg-flash"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name. '_class']);
        }
    }
}

//// Check if a user is logged in
function isLoggedIn(){
    if(isset($_SESSION['user_id'])){
        return true;
    } else {
        return false;
    }
}

//// Check for admin ownership
function adminAut(){
    if($_SESSION['has_access'] === 'is_admin'){
        return true;
    } else {
        return false;
    }
}

//// Check for teacher ownership
function clientAut(){
    if($_SESSION['has_access'] === 'is_client'){
        return true;
    } else {
        return false;
    }
}
//// Check for user ownership
function userAut(){
    if($_SESSION['userHasPost'] == $_SESSION['user_id']){
        return true;
    } else {
        return false;
    }
}

function userUrls(){
    $slug =  $_SESSION['skSlug'];
    $prettyUser = str_replace(" ", "-", strtolower($_SESSION['user_name']));
    $urlUser = URLROOT . '/stories/show/' . $slug . '/' .  $prettyUser;

        return $urlUser;
}

function nameToUpper(){
    $UserUpper = $_SESSION['user_name'];
    $userToUpper = ucwords($UserUpper);

    return $userToUpper;
}

// Load links based on user status
function checkAccessLinks(){

    switch ($_SESSION['has_access']) {
        case "is_admin":
            include APPROOT . '/views/admins/inc/adminLinks.php';
            break;
        case "is_client":
            include APPROOT . '/views/clients/inc/clientLinks.php';
            break;
    }
}


// Load links based on user status
function checkAccessSideLinks(){

    switch ($_SESSION['has_access']) {
        case "is_admin":
            include APPROOT . '/views/admins/inc/adminSideLinks.php';
            break;
        case "is_client":
            include APPROOT . '/views/clients/inc/clientSideLinks.php';
            break;
    }
}


/// Load avatar based on user status
function userAvatar(){

    switch ($_SESSION['has_access']) {
        case "is_admin":
            $setImg = "admin.png";
            break;
        case "is_client":
            $setImg = "client.png";
            break;
    }
    return $setImg;
}


/// Generate a random token for all our forms
function createToken(){
    $formToken = bin2hex(random_bytes(32));
    $_SESSION['token'] =  $formToken;
    return $formToken;
}

function createTokenSecond()
{
    $formToken = bin2hex(random_bytes(32));
    $_SESSION['secondToken'] = $formToken;
    return $formToken;
}

/// Compare session token with form token to avoid CSRF attacks from outside
function validateToken()
{
//For backward compatibility with the hash_equals function.
//This function was released in PHP 5.6.0.
//It allows us to perform a timing attack safe string comparison.
    if (!function_exists('hash_equals')) {
        function hash_equals($str1, $str2)
        {
            if (strlen($str1) != strlen($str2)) {
                return false;
            } else {
                $res = $str1 ^ $str2;
                $ret = 0;
                for ($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
                return !$ret;
            }
        }
    }

//Make sure that the token POST variable exists.
    if (!isset($_POST['token'])) {
        throw new Exception('No token found!');
    }
//It exists, so compare the token we received against the
//token that we have stored as a session variable.
    if (hash_equals($_POST['token'], $_SESSION['token']) === false) {
        //flash_error('token_error', 'Token mismatch!');
        throw new Exception('Token mismatch!');
    }
//Token is OK - process the form and carry out the action.
}

/// Compare session token with form token to avoid CSRF attacks from outside
function validateTokenSecond()
{

//For backward compatibility with the hash_equals function.
//This function was released in PHP 5.6.0.
//It allows us to perform a timing attack safe string comparison.
    if (!function_exists('hash_equals')) {
        function hash_equals($str1, $str2)
        {
            if (strlen($str1) != strlen($str2)) {
                return false;
            } else {
                $res = $str1 ^ $str2;
                $ret = 0;
                for ($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
                return !$ret;
            }
        }
    }

//Make sure that the token POST variable exists.
    if (!isset($_POST['secondToken'])) {
        throw new Exception('No token found!');
    }
//It exists, so compare the token we received against the
//token that we have stored as a session variable.
    if (hash_equals($_POST['secondToken'], $_SESSION['secondToken']) === false) {
        //flash_error('token_error', 'Token mismatch!');
        throw new Exception('Token mismatch!');
    }
//Token is OK - process the form and carry out the action.
}



