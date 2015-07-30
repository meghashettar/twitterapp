<?php
    require "resources/api.php";
    $user = getUserInfo(true);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>My Twittwr Tweets</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="assets/css/main.css" type="text/css"/>
    </head>
    <body>
        
        <div class="container-fluids">
            <div class="title"><h1>Twitter</h1></div>
            <nav class="topNav">
                <ul class="navList clearfix">
                    <li>
                        <h2><a href="/">Home</a><h2>
                    </li>
                    <li>
                        <h2><a href="/">Notifications</a><h2>
                    </li>
                    <li>
                       <h2> <a href="/">Messages</a><h2>
                    </li>
                    <li id="search">
                        <h2>Search twitter</h2>
                    </li>
                    <li id="settings">

                    </li>
                </ul>
            </nav>
            <div class="content-wrapper row-fluid content">
                <section id="left-dashboard" class="span3 hidden-phone">
                        <div class="contentarea profile-details">
                            <div class="span12 row-fluid" style="background-color: #0084B4;height: 100px"></div>
                            <div style="height: 50px;">
                                <div class="span4 profile-image">
                                    <img alt="<?php print $user->name; ?>" src="<?php print $user->profile_image_url ?>" />
                                </div>
                                <div class="span7 profile-name">
                                    <p style="margin:0;"><strong><?php print $user->name; ?></strong></p>
                                    <p class="smaller-text"><?php print $user->screen_name; ?></p>
                                </div>
                            </div>
                                
                        </div>
                        <div class="contentarea trends">
                            <p style="margin: 20px;"><strong>Trends</strong></p>
                        </div>
                </section>
                <section id="content-main" class="span6">
                    <div class="contentarea">
                        <div class="tweet-box clearfix">
                            <div class="span1" style="float: left; margin: 13px 10px; ">
                                <img alt="<?php print $user->name; ?>" src="<?php print $user->profile_image_url ?>" />
                            </div>
                            <div class="row-fluid span10 tweet-input-box" style="float: left; margin: 10px;"><input  style="padding: 10px; margin: 0; width:100%" type="text" placeholder="What’s happening?" value="" /></div>
                        </div>
                        <div class="tweets">
                            <ul id="tweet-list">
                                <?php 
                                $tweets = getStatuses(5, "",true);
                                
                                if(!isset($tweets['errorcode'])){
                                    foreach($tweets as $tweet){
                                        echo "<li class='clearfix' id='{$tweet['id']}'>";

                                        $retweet = isset($tweet["tweetby_name"]);
                                        if($retweet){
                                            echo "<p class='smaller-text retweet'>{$tweet['tweetby_name']} retweeted</p>";
                                        }

                                        echo "<div class='tweet-user-img'>
                                                <img height='48' width='48' alt='{$tweet['name']}' src='{$tweet['profile_image_url']}' />
                                            </div>";

                                        echo "<div class='span10 profile-name'>
                                                <p style='margin:0;'><strong>{$tweet['name']}</strong>
                                                <span class='smaller-text'> @{$tweet['screen_name']}</span>
                                                </p>
                                                <p>{$tweet['text']}</p>
                                                <img src='{$tweet['media_url']}' />
                                            </div>";

                                        echo "</li>";
                                    }
                                } else {
                                    echo "<li>Error {$tweets['errorcode']} : {$tweets['message']}</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </section>
                <section id="right-dashboard" class="span3">
                    <div class="contentarea follow">
                        
                    </div>
                </section>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="assets/js/main.js" type="text/javascript"></script>
    </body>
</html>
