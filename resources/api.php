<?php
session_start();

require "twitteroauth/autoload.php";
require "auth.php";
use Abraham\TwitterOAuth\TwitterOAuth;

if(isset($_GET['action'])){
    if($_GET['action'] == "getUserInfo"){
        getUserInfo(false);
    } else if( $_GET['action'] == "getTweets"){
        if(isset($_GET["statuses"])){
            if(!empty($_GET["statuses"])){
                $_GET["statuses"] = 5;
            }
            getStatuses($_GET["statuses"], $_GET["max_id"], false);
        }
    }
}


function getUserInfo($ret){
    $access_token = $_SESSION['access_token'];
    if($access_token == null || $access_token == ""){
        auth();
    }
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    
    $user = $connection->get("account/verify_credentials");
    if($ret){
        return $user;
    } else {
        echo (json_encode( (array)$user ));
    }

}


function getStatuses($statusesCount, $max_id, $ret){
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    
    if(!empty($max_id)){
        $statuses = $connection->get("statuses/home_timeline", array("count" => $statusesCount, "exclude_replies" => true, "max_id"=>$max_id));
    } else {
        $statuses = $connection->get("statuses/home_timeline", array("count" => $statusesCount, "exclude_replies" => true));
    }
    
    if(isset($statuses->errors)){
        $tweets['errorcode']    = $statuses->errors[0]->code;
        $tweets['message'] = $statuses->errors[0]->message;
    } else {
        $i=0;
        foreach($statuses as $status){
            $tweet['id'] = $status->id;
            $retweet = preg_match("/^RT.*/", $status->text);
            if($retweet > 0){
                $tweetby = $status;
                $status = $status->retweeted_status;
                $tweet['tweetby_name'] = $tweetby->user->name;
                $tweet['tweetby_screen_name'] = $tweetby->user->screen_name;
            }
            $tweet['name'] = $status->user->name;
            $tweet['screen_name'] = $status->user->screen_name;
            $tweet['profile_image_url'] = $status->user->profile_image_url;
            $tweet['text'] = $status->text;
            if(isset($status->entities->media[0]->media_url)){
                $tweet['media_url'] = $status->entities->media[0]->media_url;
            } else {
                $tweet['media_url'] = $status->entities->media['media_url'];
            }

            $tweets[$i] = $tweet;
            $i++;
        }
    }

    if($ret){
        return $tweets;
    } else {
        echo (json_encode( $tweets ));
    }
  
}

?>