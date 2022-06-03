<?php

// sanitize user input
function sanitize_input($dirtyValue){
    $cleanValue = htmlentities(trim($dirtyValue));
  
    return $cleanValue;
}