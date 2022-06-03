<?php

require 'custom_functions.php';

session_start();

if(isset($_POST['submit'])){
    // fetch and sanitize inputs
    $email = strtolower(sanitize_input($_POST['email']));

    // hash password
    $password = hash('md5', $_POST['password']);

    // login user
    $login_user = loginUser($email, $password);

    if($login_user):    // successful login
        $location = '../dashboard.php';
    else:   // failed login
        $location = '../forms/login.html';
    endif;

    header('Location: '.$location);
    exit();
}

function loginUser($email, $password){
    /*
    Finish this function to check if username and password 
    from file match that which is passed from the form
    */
    
    // read
    $fileName = '../storage/users.csv';

    if($handle = fopen($fileName, "r")):
        while($data = fgetcsv($handle, 0, ",")):
            if(($data[1] == $email) && ($data[2] == $password)):
                // set session variable
                $_SESSION['username'] = ucwords(sanitize_input($data[0]));
                return TRUE;
            endif;
        endwhile;
        return FALSE;
    endif;
    fclose($handle);
}