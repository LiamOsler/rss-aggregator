# RSS Aggregator Webite
For a live demo of this project, visit:
https://liamosler.ca/demos/rss-aggregator/


![Screenshot](/screenshots/Screen1.bmp)

# Purpose
Saves a list of RSS feeds to a local .XML file (list is stored as feedlist.csv in the "files" folder of the project directory) when retrieve-feeds.php (saved in the "scripts" folder) is called by the client.

index.php shows a Bootstrap based interface that displays the contents of the scraped RSS feeds (also read from the feedlist.csv)

# Scope:
Retrieve and display a list of RSS feeds

## Project File Structure:
```bash
rss-aggregator
├── README.md
├── css
│   └── styles.css
├── files
│   ├── CBC_News_Nova_Scotia.xml
│   ├── CTV_News_Atlantic.xml
│   ├── Global_News_Atlantic.xml
│   ├── The_Coast_Halifax.xml
│   ├── The_Halifax_Examiner.xml
│   ├── The_Star_Halifax.xml
│   └── feedlist.csv
├── includes
│   ├── banner.php
│   ├── foot.php
│   └── head.php
├── index.php
├── screenshots
│   └── Screen1.bmp
└── scripts
    ├── retrieve-feeds.php
    └── scripts.jsp
```

## File samples:

### feedlist.csv:

Feeds are stored in a csv format with the name followed by the URL:
```csv
Name of Agency, https://rss.feed.com/address.xml
```

Examples:
```csv
CBC News Nova Scotia,https://rss.cbc.ca/lineup/canada-novascotia.xml
CTV News Atlantic,https://atlantic.ctvnews.ca/rss/ctv-news-atlantic-public-rss-1.822315
Global News Atlantic,https://globalnews.ca/halifax/feed/
The Coast Halifax,https://www.thecoast.ca/halifax/Rss.xml?section=957802
The Halifax Examiner,https://www.halifaxexaminer.ca/feed/
```

### retrieve-feeds.php:

Script that retrieves the list of RSS feeds and saves them as .XML files in the "files" directory of the project:
```php
<?php
    //Function to read the CSV file to a multidimensional array :
    function readCSV($csv){
        $file = fopen($csv, 'r');
        while (!feof($file) ) {
            $line[] = fgetcsv($file, 1024);
        }
        fclose($file);
        return $line;
    }

    //Read a csv with the list of feeds to save locally:
    $feed_list_csv = '../files/feedlist.csv';
    $feed_list = readCSV($feed_list_csv);

    $i = 0;
    foreach($feed_list as $feed_source){
        //Create a spaceless string for writing the feed to XML file where the name is the same as the title in the CSV:
        $local_copy_string = "../files/" . $feed_list[$i][0] . ".xml";
        $local_copy_string = str_replace(" ", "_", $local_copy_string);

        $rss_feed = simplexml_load_file($feed_list[$i][1]);
        $rss_feed->saveXML($local_copy_string);

        $i++;
    }
?>
```

### index.php:

Dynamically generating the toggle boxes for the feed list:
```php
<?php
    foreach($feed_list as $feed_source){
        $div_label = $feed_source[0];
        $div_id = str_replace(" ", "_", $feed_source[0] . "_toggle");
        $div_id_page = str_replace(" ", "_", $feed_source[0]);
?>
    <div class = "feed-list">
        <input type="checkbox" id="<?php echo $div_id?>" name="<?php echo $div_id?>" value="<?php echo $div_id?>" onclick="toggle(&quot;<?php echo $div_id_page;?>&quot;)" checked>
        <!-- <label for="<?php echo $div_id?>"><?php echo $div_label?></label><br> -->
        <a href ="#<?php echo $div_id_page?>"><?php echo $div_label?></a><br>
    </div>
<?php
    }
?>
```

Toggling news agency display on/off based on the state of the checkboxes:
```javascript
function toggle(target){
    var news_feed = document.getElementById(target);
    if (news_feed.style.display === "none") {
        news_feed.style.display = "block";
    } 
    else {
        news_feed.style.display = "none";
    }
}
```



