<?php
//loop through entire rows from database query, stores as array in $row
echo "<table> <tr>
                <th>Name
                </th>
                <th>Price
                </th>
                <th>Location (Lat,Long)
                </th>
                <th>Rating (% Positive)
                </th>
                <th>Distance
                </th>
            </tr>";
//check for distance, then populate table accordingly
// submits averaged rating from reviews table
while ($row = $stmt->fetch()) {
    $dist_check = round(distance($lat, $long, $row['lat'], $row['lng']));
    if ($dist_check <= $dist) {

        //get averaged rating from reviews table
        $avgratingquery = $dbh->query("SELECT ROUND(AVG(value),0) FROM reviews WHERE p_id={$row['id']}");
        $avgrating = $avgratingquery->fetchColumn();

        echo "<tr>";
        echo "<td><a href='parking.php?id={$row['id']}'>{$row['name']}</a>";
        echo "<td>" . $row['price'] . "</td>";
        //. is concatenation, appending lat and lng with a ',' in location row
        echo "<td>" . $row['lat'] . " , " . $row['lng'] . "</td>";
        echo "<td>" . $avgrating * 10 . "</td>";
        echo "<td>" . round(distance($lat, $long, $row['lat'], $row['lng']), 2) . " km " . "</td>";
        echo "</tr>";
        ?>
        <script>
            var parkid = "<?php echo $row['id']; ?>";
            var parkname = "<?php echo $row['name']; ?>";
            var parkprice = "<?php echo $row['price']; ?>";
            var parkrating = "<?php echo $avgrating * 10; ?>";
            var parklat = "<?php echo $row['lat']; ?>";
            var parklong = "<?php echo $row['lng']; ?>";
            //pushing these data vars to a global array stored in JSscripts.js
            pushArray(parkid, parkname, parkprice, parkrating, parklat, parklong);
        </script>
        <?php
    }
}
?>
    <script>
        var tempLat = "<?php echo $lat; ?>";
        var tempLong = "<?php echo $long; ?>";
        getUserLoc(tempLat, tempLong);
    </script>
<?php
echo "<tr><td align=\"center\" colspan=\"5\">End of Results!</td></tr>";
echo "</table>";
?>