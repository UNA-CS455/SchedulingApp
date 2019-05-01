<?php

session_start();
// need validation for the maximum enrollment against the number of seats for each room.
// question: is there other relevant data from the CSV we want to pull? 
// what should the DB table restructure look like?

$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");


require "db_conf.php"; // set servername,username,password,and dbname
//$filePath = "../../CSV_FILE_HERE";                //set this to the path that an admin specifies in their personal filesystem on seperate page, send to this script
$csvFileName = $argv[1];
$filePath = "$csvFileName";
$csv = file_get_contents($filePath, FILE_USE_INCLUDE_PATH);
$lines = explode("\n", $csv);
// remove the first element from the array
$head = str_getcsv(array_shift($lines));

$data = array();
foreach ($lines as $line) {
    // creates associative array of room data
    $data[] = array_combine($head, str_getcsv($line));
}
for ($i = 0; $i < count($data); $i++) {
    if (strlen($data[$i]['Course Start Time']) == 3) {
        $startTime = '0' . substr_replace($data[$i]['Course Start Time'], ":", 1, 0) . ':00';
    } elseif (strlen($data[$i]['Course Start Time']) == 4) {
        $startTime = substr_replace($data[$i]['Course Start Time'], ":", 2, 0) . ':00';
    }

    if (strlen($data[$i]['Course End Time']) == 3) {
        $endTime = '0' . substr_replace($data[$i]['Course End Time'], ":", 1, 0) . ':00';
    } elseif (strlen($data[$i]['Course End Time']) == 4) {
        $endTime = substr_replace($data[$i]['Course End Time'], ":", 2, 0) . ':00';
    }

    // echo $startTime . '<br>';
    // echo $endTime . '<br>';

    $termStart = DateTime::createFromFormat('j-M-y', $data[$i]['Course Start Date']);
    if($termStart !== FALSE){
        $termStart = $termStart->format('Y-m-d');
        $termEnd = DateTime::createFromFormat('j-M-y', $data[$i]['Course End Date']);
        $termEnd = $termEnd->format('Y-m-d');
        $occur = "weekly";
        $crn = $data[$i]['Course CRN'];
    
        // echo $termStart . '<br>';
        // echo $termEnd . '<br>';
    
        $roomnumber = $data[$i]['Building Name'] . ' ' . $data[$i]['Room Number'];
        // echo $roomnumber . '<br>';
        $owneremail = "N/A";
        // not sharing for lectures
        $allowshare = 0;
        $headcount = $data[$i]['Course Enrollment'];
        $comment = "ARGOS CRN: " . $crn;
        // echo $headcount . '<br>';
    
        // skip the inner loop for now until we understand how the new databse table works.
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $intTermStart = strtotime($termStart);
        $intTermEnd = strtotime($termEnd);
        $dateIterator = $intTermStart;
        
        while ($dateIterator <= $intTermEnd) {
            $weekdayNum = date('w', $dateIterator);
            $day = $days[$weekdayNum % 7];
            $dayIndicator = $day . ' ' . 'Indicator';
            // echo $dayIndicator . "<br>";
            if ($data[$i][$dayIndicator] != NULL) {
    
                // echo 'NON NULL DATE:' . date('Y-m-d', $dateIterator);
                // echo "<br>";
                // print_r($data[$i][$dayIndicator]);
                
                $dateToInsert = date("Y-m-d", $dateIterator);
                $collisionID = md5($roomnumber . $owneremail . $crn . $allowshare . $headcount . $termStart . $termEnd . $dateToInsert . $dateToInsert . $startTime . $endTime . $occur . $comment . $owneremail);
                // echo "<br>$collisionID</br>";
                // echo "\n \n" . $roomnumber . ' ' . $owneremail . ' ' . $allowshare . ' ' . $headcount . ' ' . $termStart . ' ' . $termEnd . ' ' . $dateToInsert . ' ' . $dateToInsert . ' ' . $startTime . ' ' . $endTime . ' ' . $occur . ' ' . $comment . ' ' . $owneremail . "\n\n";
    
                
                $sql = "INSERT INTO reservations (roomnumber, owneremail, allowshare, headcount, termstart, termend, startdate, enddate, starttime, endtime, occur, comment, res_email, unique_identifier)
                        VALUES ('$roomnumber', '$owneremail', '$allowshare', '$headcount', '$termStart', '$termEnd', '$dateToInsert', '$dateToInsert', '$startTime', '$endTime', '$occur', '$comment', '$owneremail', '$collisionID')";
               // $sqlFile = file_put_contents('C:/xampp/htdocs/SchedulingApp/argos/argosInsert.sql', $sql.PHP_EOL, FILE_APPEND | LOCK_EX);
                
                
                if ($conn->query($sql) === TRUE) {
                  echo "New record created successfully \r\n";
                } else {
                  echo "Error: " . $sql . "\r\n" . $conn->error . "\r\n \r\n";
                }
                
            }
    
    
             
            //echo date('Y-m-d', $dateIterator);
            // echo "<br>----------<br>";
            $dateIterator = $dateIterator + 86400;
        }
    }
    else{
        echo "Finished inserting";
        return;
    }
}
$conn->close();
