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
        $local_copy_string = "../files/" . $feed_list[$i][0] . ".xml";
        $local_copy_string = str_replace(" ", "_", $local_copy_string);

        $rss_feed = simplexml_load_file($feed_list[$i][1]);
        $rss_feed->saveXML($local_copy_string);

        $i++;
    }

    header('Location: '. "../index.php");
?>