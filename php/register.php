<?php

require 'custom_functions.php';

if(isset($_POST['submit'])){
    // sanitize user inputs
    $username = strtolower(sanitize_input($_POST['fullname']));
    $email = strtolower(sanitize_input($_POST['email']));

    // hash the password
    $password = hash('md5', $_POST['password']); 

    // register user
    $register_user = registerUser($username, $email, $password);

    if($register_user === TRUE):    // successful registration
        echo 'User successfully registered';
        echo '<p><a href="../forms/login.html">Click here to Login</a></p>';
    else:   // failed registration
        echo $register_user;
    endif;
}

function registerUser($username, $email, $password){
    $fileName = '../storage/users.csv';

    // open file and check if email already exists
    if($handle = fopen($fileName, "r")):
        while($data = fgetcsv($handle, 0, ",")):
            if(($data[1] == $email)):
                return 'Duplication: email already exists';
            endif;
        endwhile;
    endif;
    fclose($handle);

    //save data into the file
    $newUser = [$username, $email, $password];
    $handle = fopen($fileName, "a");
    fputcsv($handle, $newUser);
    fclose($handle);
    
    return TRUE;
}