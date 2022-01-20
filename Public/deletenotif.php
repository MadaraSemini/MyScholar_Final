<?php
include_once("../Private/config/ConnectSingleton.php");

// $connector = new Connector();
// $connec = $connector->connectDatabase();
$connector = ConnectSingleton::getInstance();
$connec = $connector->getConnection();

if (isset($_GET['id'])) {
    $delete_id = $_GET['id'];
    

    $delete_query = "update notification SET availability=1 WHERE id='$delete_id'";
    $sql_delete = mysqli_query($connec, $delete_query);
    if ($sql_delete) {
        header('location:notifications.php');
    } else {
        echo mysqli_error($connec);
    }
}
?>
