<?php

require 'custom_functions.php';

if(isset($_POST['submit'])){
    // fetch and sanitize inputs
    $email = strtolower(sanitize_input($_POST['email']));

    // hash password
    $new_password = hash('md5', $_POST['password']);

    // reset password
    $reset_password = resetPassword($email, $new_password);

    if($reset_password === TRUE):   // reset is successful
        echo 'Password reset successful';
        echo '<p><a href="../forms/login.html">Click here to Login</a></p>';
    else:   // reset is unsuccessful
        echo 'User not found';
    endif;
}

function resetPassword($email, $new_password){
    $fileName = '../storage/users.csv';
    
    //open file and check if the username exist inside
    // first fetch file and save as associative array
    $users = [];
    $i = 0;
    $user_index_to_update = null;

    if($handle = fopen($fileName, "r")):
        while($data = fgetcsv($handle, 0, ",")):
            $users[$i] = $data;
            if($data[1] == $email):
                $user_index_to_update = $i;
            endif;
            $i++;
        endwhile;
    endif;
    fclose($handle);
    
    // if user index to be updated is not null
    if(!is_null($user_index_to_update)):
        // update new password for selected user
        $users[$user_index_to_update][2] = $new_password;

        // save users associative array back into the file
        $handle = fopen($fileName, "w");
        for($index=0; $index<count($users); $index++):
            $username = $users[$index][0];
            $email = $users[$index][1];
            $password = $users[$index][2];

            $old_user = [$username, $email, $password];
            fputcsv($handle, $old_user);
        endfor;
        fclose($handle);

        return TRUE;
    else:
        return FALSE;
    endif;
}