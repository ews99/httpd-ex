<?php
echo "Version 1.0\n";

if (isset($_GET['action']) && !empty($_GET['action'])) { $action=htmlspecialchars($_GET['action']); }
if (isset($_GET['hostname']) && !empty($_GET['hostname'])) { $hostname=htmlspecialchars($_GET['hostname']); }
if (isset($_GET['ipaddress']) && !empty($_GET['ipaddress'])) { $ipaddress=htmlspecialchars($_GET['ipaddress']); }

switch ($action)
{
case 'update':

    $mysql_query="";
    $mysql_query.="INSERT INTO pixelflut_nodes (`hostname`,`ipaddress`,`last_checkin`)";
    $mysql_query.=" VALUES ('".$hostname."','".$ipaddress."',NOW())";
    $mysql_query.=" ON DUPLICATE KEY UPDATE `last_checkin` = NOW()";

    $mysqli = new mysqli($_ENV['MARIADB_HOSTNAME'], $_ENV['MARIADB_USERNAME'], $_ENV['MARIADB_PASSWORD'], $_ENV['MARIADB_DATABASE']);
    if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }

    $mysqli->query($mysql_query);
    break;
}

?>
