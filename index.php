<?php include "includes/head.php"?>
<div class ="container ">
        <!-- Load the RSS contents: -->
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

            //Create a counter keep track of items:
            $i = 0;

            //Loop through each feed list item (each listed rss feed in the csv file):
            foreach($feed_list as $feed_source){
                $j = 0;
                //Generate a string with the file path to the local copy of the RSS feed:
                $local_copy_string = "files/" . $feed_list[$i][0] . ".xml";
                $local_copy_string = str_replace(" ", "_", $local_copy_string);

                //Load the RSS feed:
                $rss_feed = simplexml_load_file($local_copy_string);
                ?>
                <!-- Echo the title of the feed (from the CSV file) -->
                <div class = "row">
                    <h1>
                        <?php echo $feed_list[$i][0] ?>
                    </h1>
                </div>


                <div class = "row " data-masonry='{"percentPosition": true }'>
                <?php
                //Go through each item in the feed and log it to the page:
                foreach ($rss_feed->channel->item as $feed_item) {?> 
                    <div class = "rss-item col-lg-4 col-4 col-md-6 col-sm-6">
                        <div class="card border-primary">
                            <div class="card-body">
                            <!-- Feed item title formatted as a heading/link -->
                            <p>
                                <a href="<?php echo $feed_item->link?>"><?php echo$feed_item->title?></a>
                            <p>

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
            } //Close foreach($feed_list as $feed_source)
        ?>
    </div>



<?php include "includes/foot.php"?>