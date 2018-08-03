<html>
<h1>Pixelflut nodes overview</h1>
Version 1.3<br>
<ul>
    <li><a href="/downloads/">Downloads</a></li>
</ul>


<table border="1">
    <tr>
        <th>Hostname</th>
        <th>IP Address</th>
        <th>MAC</th>
        <th>Deployment state</th>
        <th>Device</th>
        <th>Last seen</th>
        <th>Tag</th>
    </tr>
<?php
    
    date_default_timezone_set('Europe/Amsterdam');
    echo date('H:i:s');

    #$mysql_query="SELECT * FROM pixelflut_nodes";
    $mysql_query="select `hostname`,`ipaddress`,`macaddress`,`iface`,`deployment_state`,`tag`,CONVERT_TZ(`last_checkin`, @@session.time_zone, '+02:00') AS `last_checkin` from pixelflut_nodes;";
    
    $mysqli = new mysqli($_ENV['MARIADB_HOSTNAME'], $_ENV['MARIADB_USERNAME'], $_ENV['MARIADB_PASSWORD'], $_ENV['MARIADB_DATABASE']);
    if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }
    $res=$mysqli->query($mysql_query);
    while ($row = $res->fetch_assoc()) {
        echo "    <tr>\n";
        echo "        <td>".$row['hostname']."</td>\n";
        echo "        <td>".$row['ipaddress']."</td>\n";
        echo "        <td>".$row['macaddress']."</td>\n";
        echo "        <td>".$row['iface']."</td>\n";
        echo "        <td>".$row['deployment_state']."</td>\n";
        echo "        <td>".$row['last_checkin']."</td>\n";
        echo "        <td>".$row['tag']."</td>\n";
        echo "    </tr>\n";
    }

?>
</table>
