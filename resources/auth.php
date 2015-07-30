<?php
session_start();

require "twitteroauth/autoload.php";
require "environment.php";

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', getenv('CONSUMER_KEY'));
define('CONSUMER_SECRET', getenv('CONSUMER_SECRET'));
define('OAUTH_CALLBACK', getenv('OAUTH_CALLBACK'));

/*
$consumerKey = "e2ItzCoAZkGY4miroH6CHxcIQ"; // Consumer Key
$consumerSecret = "mBOx8gmjcpIODnUFdLZFVs0hMmTSf1AxmONxSwHIKx2iqg4LBH"; // Consumer Secret
$accessToken = "172086487-uE8qe5KXAiviFDwWgQnV9TZwSB74eXRtBlPEsVR0"; // Access Token
$accessTokenSecret = "0Ct3bdSL6u16uLmuvK3ws2o2RQ0WIKMh1eLyujN4OTHs4"; // Access Token Secret
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
 */

function auth(){
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    
    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

    $_SESSION['functionName']  = 'statuses';
    if(empty($_GET['statuses'])){
        $_GET['statuses'] = 5;
    }
    $_SESSION['functionValue'] = $_GET['statuses'];
    
    header( "Location: $url");
}

function afterCallback(){
    header("Location:http://localhost:8000/index.php");
}

?>
