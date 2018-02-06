<?php session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cs455";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $sql = "SELECT * FROM reservations order by roomnumber";
        $result = $conn->query($sql);

        echo "<table border='1'>
                <tr>
                <th>Room Number</th>
                <th>Email</th>
                <th>Headcount</th>
                <th>Start</th>
                <th>End</th>
                <th>Comment</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['roomnumber'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['headcount'] . "</td>";
            echo "<td>" . $row['start'] . "</td>";
            echo "<td>" . $row['end'] . "</td>";
            echo "<td>" . $row['comment'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        $conn->close();
        ?>
    </body>
</html>
