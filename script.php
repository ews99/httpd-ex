<?php
if (isset($_GET['action']) && !empty($_GET['action'])) { $action=htmlspecialchars($_GET['action']); }
if (isset($_GET['state']) && !empty($_GET['state'])) { $state=htmlspecialchars($_GET['state']); }
if (isset($_GET['tag']) && !empty($_GET['tag'])) { $tag=htmlspecialchars($_GET['tag']); }
if (isset($_GET['hostname']) && !empty($_GET['hostname'])) { $hostname=htmlspecialchars($_GET['hostname']); }
if (isset($_GET['ipaddress']) && !empty($_GET['ipaddress'])) { $ipaddress=htmlspecialchars($_GET['ipaddress']); }

switch ($action)
{

case 'heartbeat':
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

case 'update':

    if (!empty($state) && !empty($hostname)) {
        $mysql_query="";
        $mysql_query.="UPDATE pixelflut_nodes";
        $mysql_query.=" SET `deployment_state`='".$state."'";
        $mysql_query.=" WHERE `hostname`='".$hostname."'";

        $mysqli = new mysqli($_ENV['MARIADB_HOSTNAME'], $_ENV['MARIADB_USERNAME'], $_ENV['MARIADB_PASSWORD'], $_ENV['MARIADB_DATABASE']);
        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        $mysqli->query($mysql_query);
        echo "Updated hostname: ".$hostname." to state: ".$state."\n";
    }
    if (!empty($tag) && !empty($hostname)) {
        $mysql_query="";
        $mysql_query.="UPDATE pixelflut_nodes";
        $mysql_query.=" SET `tag`='".$tag."'";
        $mysql_query.=" WHERE `hostname`='".$hostname."'";

        $mysqli = new mysqli($_ENV['MARIADB_HOSTNAME'], $_ENV['MARIADB_USERNAME'], $_ENV['MARIADB_PASSWORD'], $_ENV['MARIADB_DATABASE']);
        if ($mysqli->connect_errno) {
            die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        $mysqli->query($mysql_query);
        echo "Updated tag for hostname: ".$hostname." to tag: ".$tag."\n";
    }
    break;

case 'get':
    if (!empty($state)) {
        $mysql_query="";
        $mysql_query.="SELECT * FROM pixelflut_nodes";
        $mysql_query.=" WHERE `deployment_state`='".$state."'";
        $mysqli = new mysqli($_ENV['MARIADB_HOSTNAME'], $_ENV['MARIADB_USERNAME'], $_ENV['MARIADB_PASSWORD'], $_ENV['MARIADB_DATABASE']);

        $res=$mysqli->query($mysql_query);
        while ($row = $res->fetch_assoc()) {
            echo($row['hostname']." ".$row['ipaddress']);

        }
    }
    break;
}
?>
