function toggle(target){
    var news_feed = document.getElementById(target);
    if (news_feed.style.display === "none") {
        news_feed.style.display = "block";
    } 
    else {
        news_feed.style.display = "none";
    }
}