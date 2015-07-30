var scrollLoads = 0;
var numItemsToLoad = 3;

$(document).ready(function(){
    $(window).scroll(function() {   
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
        getdata(numItemsToLoad);
    }
});
    
});

function getdata(noOfstatus){
    var lastTweetId = $("#tweet-list li").last().attr('id');
    var url = "http://localhost:8000/resources/api.php?action=getTweets" + "&statuses=" + noOfstatus + "&max_id=" + lastTweetId;
    
    $.get(url, function(data){
        if(typeof data.errorcode == 'undefined'){
            scrollLoads++;
            var tweetsMarkup = "";
            var data = JSON.parse(data);
            var tweet = "";
            $.each(data,  function(i, item) {
                if(item.id == lastTweetId){
                    return true;
                }
                tweet = "<li class='clearfix' id='" + item.id + "'>";

                if(item.tweetby_name != null){
                    tweet += "<p class='smaller-text retweet'>" + item.tweetby_name + "retweeted</p>";
                }

                tweet += "<div class='tweet-user-img'> "
                            + "<img height='48' width='48' alt='" + item.name + "' src='" + item.profile_image_url + "' /></div>"
                            + "<div class='span10 profile-name'>"
                                + "<p style='margin:0;'><strong>" + item.name + "</strong>"
                                + "<span class='smaller-text'> @" + item.screen_name + "</span></p><p>" 
                                    + item.text + "'</p><img src='" + item.media_url+ "'/></div></li>";

                tweetsMarkup += tweet;

            });

            $("#tweet-list").append(tweetsMarkup);
            
            if(scrollLoads > 2){
                $("#tweet-list li:lt("+numItemsToLoad+")").remove();
            }
        } else {
            alert(data.message);
        }
    });
}

