<?php
require_once "vendor/autoload.php";
function store_submitted_data($name,$mail,$user_message)
{
    $fp = fopen(submitted_data,"a+");

    if($fp)
    {
        $user_data = date("F j Y g:i a") . "," . $_SERVER["REMOTE_ADDR"] . "," . $name .",". $mail .",". $user_message.PHP_EOL;
        if(fwrite($fp, $user_data))
        {
            fclose($fp);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
// store_submitted_data("mohamed","mohamed@gmail.com","hiii");

?>