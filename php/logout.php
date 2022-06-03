<?php
session_start();

logout();

header("Location: ../forms/login.html");
exit();

function logout(){
    /*
    Check if the existing user has a session
    if it does
    destroy the session and redirect to login page
    */
    if(isset($_SESSION['username'])):
        echo 'session dey';
        session_destroy();
    endif;
}
