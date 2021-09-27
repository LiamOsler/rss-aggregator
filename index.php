<?php

$handle = fopen("files/feedlist.csv", "r"); 
$feed_list = fgetcsv($handle, 1000, ",");

foreach($feed_list as $feed_source){
?>
<h1><?php echo($feed_source); ?></h1>

<?php
    $rss_feed = simplexml_load_file($feed_source);
    foreach(($rss_feed->channel->item) as $feed_item) {?>
        <h2><?php echo($feed_item->title); ?></h2>
        <p><?php echo($feed_item->description); ?></p>
<?php
    }
}
?>