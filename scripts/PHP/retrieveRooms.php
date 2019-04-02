<?php session_start();
require "ValidateReservation.php";
if(isset($_SESSION['username'])){
  $user= $_SESSION['username'];
}
  /*=========================================================================
    Retrieve Rooms PHP Script
    Purpose: Generates the rooms table that is shown on the primary page.
    constraints are given via GET, and the table generated will provide only
    those rooms who meet those constraints.
    Constraints are:
    1. Start time and end time and date - note that we need both of these to validate
    if a room can be booked or not. The range is checked for each room. If a room
    is taken during that range of time, then the room will note be returned from 
    the query.

    2. Room Type - the type of room as defined in the database. If this constraint
    is specified, then we will query only for those rooms that are defined to be
    that type. For example, if $_GET['roomtype'] == 'Classroom', then only rooms
    with a type of 'classroom' will be shown.

    3. Roomsharing and headcount - if this is roomsharing is true, then we check 
    the headcount field. Computations are performed to ensure that headcount doesn't
    exceed the number of open seats in each room. Only those rooms which have enough
    seats (even with other professors who choose to share and give their headcount)
    will be shown. Note that we will only be posting a headcount. They can only type
    a headcount when allow room sharing is checked, meaning a headcount is what we will
    be waiting for. If we get headcount, we know they selected allow room sharing.

    4. recur - recur is an enumerated type, a check will be performed to ensure 
    the user's preference on recurring reservations doesn't conflict with another
    reservation somewhere down the line in the semester (recall that recurring 
    reservations will be valid for only the length of the semester.

    The variables for these are 'starttime', 'endtime', 'type', 'headcount', 
    'recur'.


    Note that we also check the current group the $_SESSION['username'] is 
    in to ensure they only see rooms they are allowed to book.


  =========================================================================*/

  //////////////////////////////////////////////////////////////////////////
  // GET GET VARIABLES
  $starttime = (isset($_GET['starttime'])) ? $_GET['starttime'] : null; // format as 'H:i' (24-hr format)
  $endtime = (isset($_GET['endtime'])) ? $_GET['endtime'] : null;     // format as 'H:i' (24-hr format)
  $type = (isset($_GET['type'])) ? $_GET['type'] : null;
  $headcount = (isset($_GET['headcount'])) ? $_GET['headcount'] : null;
  $recur_enum = (isset($_GET['recur'])) ? $_GET['recur'] : null;
  $date = (isset($_GET['date'])) ? $_GET['date'] : null; // format as 'Y/d/m'

  
  //VALIDATION
  //////////////////////////////////////////////////////////////////////////

  /*
  //echo "starttime is $starttime and endtime is $endtime";
  if ($starttime != null){
    $starttime = filter_var($starttime, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^'[0-9]{1,2}:[0-9]{1,2}'$/")));
    //var_dump($starttime);
    
  }
  
  if ($endtime != null){
    $endtime = filter_var($endtime, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^'[0-9]{1,2}:[0-9]{1,2}'$/")));
    //var_dump($endtime);
  }

  
  if ($type != null){
    if ($type != "Classroom" and $type != "Conference" and $type != "Computer Lab"){
      $type = null;
    }
    //var_dump($type);
  }

  if ($headcount != null){
    $headcount = filter_var($headcount, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{1,2}$/")));
  }

  if ($date != null){
    $date = filter_var($date, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^'[0-9]{1,4}-[0-9]{1,2}-[0-9]{1,2}'$/")));

  }
  
  if (!$headcount){
    $headcount = 250;
  }
*/
  

  //obtain datbase metadata
    require "db_conf.php";

  //perform conneciton to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
  

  $sql = "";
  $additional = "";

  //TODO: Future work - see if we can refactor these sql statements to prepared statements for security

  if($starttime != null || $endtime != null || $type != null || $headcount != null || $recur_enum != null){

    //if user provides times
    if($starttime != null && $endtime != null && $date != null){
      //ensure user gives valid time first
      if(!checkDateTime(true, substr($starttime,1,-1), substr($endtime,1,-1))){
        
        exit;
      }

      if($headcount == null){
        $additional = $additional . "LEFT JOIN (SELECT DISTINCT roomid, seats, type FROM rooms RIGHT JOIN reservations ON rooms.roomid = reservations.roomnumber 
          WHERE startdate = $date AND (($starttime >= starttime AND $starttime < endtime) OR ($starttime < starttime AND $endtime > starttime)))
          AS subquery ON rooms.roomid = subquery.roomid WHERE subquery.roomid IS NULL AND ";
      } else {
        $additional = $additional . "LEFT JOIN (SELECT DISTINCT roomid, seats, type FROM rooms RIGHT JOIN reservations ON rooms.roomid = reservations.roomnumber 
        WHERE allowshare = '0' AND startdate = $date AND (($starttime >= starttime AND $starttime < endtime) OR ($starttime < starttime AND $endtime > starttime)))
        AS subquery ON rooms.roomid = subquery.roomid WHERE subquery.roomid IS NULL AND ";
      }

    } else {
      
      
      $additional = "WHERE ";
      
      

    }
    
    //user provided type for room
    if($type != null){ 
      $additional = $additional . "rooms.type = '$type' AND ";
    }

    //if user doesn't provide times but wishes to query on headcount:
    if($headcount != null){
      //$additional TODO: add headcount query here
      $additional = $additional . "$headcount <= rooms.seats AND ";
    }


    $additional = $additional . '1'; // we are done appending on clauses. All previous statements before this and with 'AND', so we terminate with '1'.
  }

  
  $sql = $sql . "SELECT DISTINCT rooms.roomid, rooms.seats, rooms.type FROM rooms "; // the final table columns that we want.
  $sql = $sql . $additional ;         // construction of the full query along with ordering
  //echo $sql; // used for testing purposes 
  //echo "<p>$sql</p>";
    $result = $conn->query($sql); // run the query

  //get all rooms first
  // $room_array = array();
  // while ($rowItem = $result->fetch_assoc()) {

  //   $rowResult = array(
  //     "roomid" => $rowItem['roomid'],
  //     "seats" => $rowItem['seats'],
  //     "type" => $rowItem['type']
  //   );
  //   $room_array[] = $rowResult; // append row to result.
  // }

  ///////////////////////////////////////////////////////////////////////////
  // Check allow sharing
  ///////////////////////////////////////////////////////////////////////////
  if($headcount != null && $starttime != null &&  $endtime != null){
    for($i = 0; $i < count($room_array); $i++){

      if(!checkEnoughSeats(false,  substr($starttime,1,strlen($starttime)-2), substr($endtime,1,strlen($endtime)-2),  substr($date,1,strlen($date)-2), $room_array[$i]['roomid'], $headcount)){ 
        array_splice($room_array, $i, 1);
        $i--;
      }
    }
  }


  ///////////////////////////////////////////////////////////////////////////
  // Generate Blacklist
  ///////////////////////////////////////////////////////////////////////////
  
  //$permissions_SQL = "SELECT rooms.roomid, rooms.seats FROM `rooms` LEFT JOIN `users` ON users.permissions = rooms.blacklist WHERE users.email = '$user'";
  $permissions_SQL = "SELECT rooms.roomid, rooms.seats FROM `blacklist` LEFT JOIN `rooms` ON blacklist.numeric_room_id = rooms.numeric_id INNER JOIN `users` ON blacklist.group_id = users.groupID WHERE users.email = '$user'";
  $permissionsRes = $conn->query($permissions_SQL);
  //place in array
  $room_BlacklistArray = array();
  while ($blacklistRowItem = $permissionsRes->fetch_assoc()) {
    $room_BlacklistArray[] = $blacklistRowItem['roomid']; // append row to result.
  }

  ///////////////////////////////////////////////////////////////////////////
  // Generate favorites area
  ///////////////////////////////////////////////////////////////////////////
  
  echo "<span id='favsheader'></span>";
  // echo "<div class='table-responsive' style='height: 150;; overflow: auto;'><table class='table table-sm table-hover'>
  //         <thead>
  //           <tr>
  //             <th scope='col'>
  //               Room
  //             </th>
  //             <th scope='col'>
  //               Seats
  //             </th>
  //             <th scope='col'>
  //               Type
  //             </th>
  //             <th scope='col'>
  //               Favorite
  //             </th>
  //           </tr>
  //         </thead>
  //         <tbody id='favbookArea'>";
    
  // $favoritesSQL = "SELECT DISTINCT rooms.roomid,rooms.seats,rooms.type FROM favorites LEFT JOIN rooms on favorites.roomid = rooms.roomid WHERE email='" . $_SESSION['username'] . "' ORDER BY rooms.roomid";
  // $favoritesResult = $conn->query($favoritesSQL);
    
  // while ($favRow = $favoritesResult->fetch_assoc()) 
  // {

  //   var_dump($favRow);

  //   $imgName = "images/fav-select.png";


  //   $inArray = false;
  //   foreach ($room_array as $row) 
  //   {
  //     if($row['roomid'] == $favRow['roomid'] && !in_array($favRow['roomid'],$room_BlacklistArray)){
  //       $inArray = true;
  //       break;
  //     }
  //   }
  //   if($inArray){
  //     echo "<tr class='roombox' onclick='selectRoom(this.id)' id = 'fav_".$favRow['roomid']."'>
  //               <td>
  //                 <font class='roomboxcontent' id = 'p_".$favRow['roomid']."' >
  //                   " . $favRow['roomid'] ."
  //                 </font>
  //               </td>
  //               <td>
  //                 ". $favRow['seats'] ."
  //               </td>
  //               <td>
  //                 " . $favRow['type'] . "
  //               </td>
  //               <td id = 'fav_".$favRow['roomid']."'>
  //                 <img id='starImg' src='" . $imgName . "' onclick='favoriteClicked(this.parentElement); event.stopPropagation();' class='favoriteIcon' align='middle'>
  //               </td>
  //             </tr>";
  //   } else {
  //     // not found in all rooms, so cut favorites
  //     echo "<tr class='roomboxnotfound' button onclick='' class = 'roomboxnotfound' id = 'fav_".$favRow['roomid']."'>
  //             <td>
  //               <font class='roomboxcontent' id = 'p_".$favRow['roomid']."' >
  //                 " . $favRow['roomid'] ."
  //               </font>
  //             </td>
  //             <td>
  //               ". $favRow['seats'] ."
  //             </td>
  //             <td>
  //               " . $favRow['type'] . "
  //             </td>
  //             <td>
  //               <img id='starImg' src='" . $imgName . "' onclick='favoriteClicked(this.parentElement); event.stopPropagation();' class='favoriteIcon' align='middle'>
  //             </td>
  //           </tr>";
  //   }
  // }
  /*
  if($result->num_rows == 0){
    echo "<h4> No Results </h4>";
  } */
  // echo "</tbody></table></div>";
  
  ///////////////////////////////////////////////////////////////////////////
  // Generate all rooms area
  ///////////////////////////////////////////////////////////////////////////

  // echo "<span id='allroomsheader'>All Rooms</span>";
  echo"<h1 style='font-size: 19; background-color: #337ab7; border-color: #2e6da4; color: white; padding: 5px; border-radius: 5px;'>All Rooms<h1>";
  // echo "<div id='bookArea' class='bookArea'>";
  echo "<div class='table-responsive' style='height: 450px; overflow: auto;'><table class='table table-sm'>
    <thead>
      <tr>
        <th scope='col'>
          Room
        </th>
        <th scope='col'>
          Seats
        </th>
        <th scope='col'>
          Type
        </th>
        <th scope='col'>
          Favorite
        </th>
      </tr>
    </thead>
    <tbody id='bookArea'>";
  
  // foreach ($room_array as $row) 
  // {
  //   if(!in_array($row['roomid'],$room_BlacklistArray)){ // blacklist rooms are excluded
  //     $imgName = "images/fav-unselect.png";
  //     // $sql = "SELECT * FROM favorites WHERE roomid='" . $row['roomid'] . "' AND email='" . $_SESSION['username'] . "'";

  //     // $sql = "select *
  //     //         from favorites
  //     //         right join rooms
  //     //         on favorites.roomid = rooms.roomid
  //     //         WHERE favorites.email = '" . $_SESSION['username'] . "'
  //     //         AND favorites.roomid = '" . $row['roomid'] . "'
  //     //         order by favorites.roomid asc";

  //     // $result2 = $conn->query($sql);
  //     // while ($row2 = $result2->fetch_assoc()) {
  //     //   // var_dump($row2);
  //     //   // there is a favorite.
  //     //   $imgName = "images/fav-select.png"; //color in star if this room is a favorite 
  //     // }


      
  //     echo "<tr class='roombox' onclick='selectRoom(this.id)' id = '".$row['roomid']."'>
  //               <td>
  //                 <font class='roomboxcontent' id = 'p_".$row['roomid']."' >
  //                   " . $row['roomid'] ."
  //                 </font>
  //               </td>
  //               <td>
  //                 ". $row['seats'] ."
  //               </td>
  //               <td>
  //                 " . $row['type'] . "
  //               </td>
  //               <td id = '".$row['roomid']."'>
  //                 <img id='starImg' src='" . $imgName . "' onclick='favoriteClicked(this.parentElement); event.stopPropagation();' class='favoriteIcon' align='middle'>
  //               </td>
  //             </tr>";
  //   }
  // }
  // if($result->num_rows == 0){
  //   echo "<h4> No Results </h4>";
  // }

  // if(isset($_GET['type']))
  // {
  //   echo "got type";
  // }
  // else
  // {
  //   echo "no type";
  // }

  $sql = "select distinct rooms.roomid, rooms.seats, rooms.`type`, favorites.email from rooms
          left join favorites
          on favorites.roomid = rooms.roomid
          and favorites.email = '" . $_SESSION['username'] . "'
          ORDER BY email desc, roomid";

  $result = $conn->query($sql);
  // var_dump($result);
  $room_array = array();
  while($rows = $result->fetch_assoc())
  {
    // var_dump($rows);
    $rowResult = array
    (
      "roomid" => $rows['roomid'],
      "seats" => $rows['seats'],
      "type" => $rows['type'],
      "email" => $rows['email']
    );
    $room_array[] = $rowResult;
  }
  
  json_encode($result);


  // var_dump($room_array);

  foreach ($room_array as $row)
  {
    echo "<tr class='roombox' onclick='selectRoom(this.id)' id = '".$row['roomid']."'>
            <td>
              <font class='roomboxcontent' id = 'p_".$row['roomid']."' >
                " . $row['roomid'] ."
              </font>
            </td>
            <td>
              ". $row['seats'] ."
            </td>
            <td>
              " . $row['type'] . "
            </td>";

            if($row['email'])
            {
              echo'<td>
                    <a href="scripts/PHP/favorite.php?room=' . $row['roomid'] . '">
                      <button class="btn" style="background-color: transparent">
                        <i style="color: #E57B72;" class="fas fa-heart fa-lg" aria-hidden="true" ></i>
                      </button>
                    </a>
                  </td>';
            }
            else
            {
              echo'<td>
                    <a href="scripts/PHP/favorite.php?room=' . $row['roomid'] . '">
                      <button class="btn" style="background-color: transparent">
                        <i  class="far fa-heart fa-lg" aria-hidden="true" ></i>
                      </button>
                    </a>
                  </td>';
            }
            // <td id = '".$row['roomid']."'>
            //   <img id='starImg' src='" . $imgName . "' onclick='favoriteClicked(this.parentElement); event.stopPropagation();' class='favoriteIcon' align='middle'>
            // </td>
          echo "</tr>";
  }

  

    //get all rooms first
  // $room_array = array();
  // while ($rowItem = $result->fetch_assoc()) {

  //   $rowResult = array(
  //     "roomid" => $rowItem['roomid'],
  //     "seats" => $rowItem['seats'],
  //     "type" => $rowItem['type']
  //   );
  //   $r



  echo "</tbody></table></div>";
  // echo "</div>";
  
$conn->close();


?>
