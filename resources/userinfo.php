<?php
session_start();

require "twitteroauth/autoload.php";
require "auth.php";
use Abraham\TwitterOAuth\TwitterOAuth;


//getUserInfo(false);
 

function getUserInfo($ret){
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    
    $user = $connection->get("account/verify_credentials");
//    echo "<pre>";
//    print_r($user);
//    echo "</pre>";
    if($ret){
        return $user;
    } else {
        echo (json_encode( (array)$user ));
    }

}

?>