<?php include "includes/head.php"?>

<!-- Read the list of feeds -->
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
    $feed_list_csv = 'files/feedlist.csv';
    $feed_list = readCSV($feed_list_csv);

?>

<div class ="container">
    <div class ="row">
        <div class = "col-md-12">
        <?php
            foreach($feed_list as $feed_source){
                $div_label = $feed_source[0];
                $div_id = str_replace(" ", "_", $feed_source[0] . "_toggle");
                $div_id_page = str_replace(" ", "_", $feed_source[0]);
                //echo $div_id;
        ?>
            <div class = "feed-list">
                <input type="checkbox" id="<?php echo $div_id?>" name="<?php echo $div_id?>" value="<?php echo $div_id?>" onclick="toggle(&quot;<?php echo $div_id_page;?>&quot;)" checked>
                <!-- <label for="<?php echo $div_id?>"><?php echo $div_label?></label><br> -->
                <a href ="#<?php echo $div_id_page?>"><?php echo $div_label?></a><br>
            </div>
        <?php
            }
        ?>
        </div>
    </div>
        <!-- Load the RSS contents: -->
        <?php
            //Create a counter keep track of items:
            $i = 0;

            //Loop through each feed list item (each listed rss feed in the csv file):
            foreach($feed_list as $feed_source){
                $j = 0;
                //Generate a string with the file path to the local copy of the RSS feed:
                $local_copy_string = "files/" . $feed_source[0] . ".xml";
                $local_copy_string = str_replace(" ", "_", $local_copy_string);
                $div_id_page = str_replace(" ", "_", $feed_source[0]);
                //Load the RSS feed:
                $rss_feed = simplexml_load_file($local_copy_string);
                ?>

                <div id = "<?php echo str_replace(" ", "_", $feed_list[$i][0]);?>">
                <!-- Echo the title of the feed (from the CSV file) -->
                <div class = "row" id = <?php echo $div_id_page;?>>
                    <div class = "col-md-12">
                        <h2>
                            <br>
                            <?php echo $feed_list[$i][0] ?>
                        </h2>
                    </div>
                </div>


                <div class = "row " data-masonry='{"percentPosition": true }'>
                <?php

                //Go through each item in the feed and log it to the page:
                foreach ($rss_feed->channel->item as $feed_item) {?> 
                    <div class = "rss-item col-lg-3 col-md-4 col-sm-6">
                        <div class="card border-primary">
                            <div class="card-body">
                            <!-- Feed item title formatted as a heading/link -->
                            <h5 class="card-title">
                                <a href="<?php echo $feed_item->link?>"><?php echo$feed_item->title?></a>
                            </h5>

                            <!-- Feed item description -->
                            <p>
                                <?php echo $feed_item->description?>
                            </p>
                        </div>
                    </div>
                    </div>
                <?php
                    $j++;
                    ?>
                <?php
                }
                echo "</div>";
                //Close foreach ($rss_feed->channel->item as $feed_item)
                //Increment the feed counter:
                $i++;
                echo "</div>"; 
            } //Close foreach($feed_list as $feed_source)
        ?>
    </div>


<?php include "includes/foot.php"?>

<script src="scripts/scripts.js"></script>